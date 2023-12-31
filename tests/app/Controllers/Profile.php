<?php
/**
 * SharIF Judge online judge
 * @file Profile.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Assignment_model;
use App\Models\Settings_model;
use App\Models\User;
use App\Models\User_model;

class Profile extends BaseController
{

	private $form_status;
	private $edit_username;
	protected $session;
	protected $user_model;
	protected $user;
	protected $form_validation;
	protected $assignment_model;
	protected $settings_model;


	// ------------------------------------------------------------------------


	public function __construct()
	{
		$this->session = session();
		$this->user_model = new User_model();
		$this->user = new User();
		$this->form_validation = \Config\Services::validation();
		$this->assignment_model = new Assignment_model();
		$this->settings_model = new Settings_model();
		$session = \Config\Services::session();
		if ( ! $session->get('logged_in')) // if not logged in
			redirect('login');
		$this->form_status = '';
	}


	// ------------------------------------------------------------------------


	public function index($user_id = FALSE)
	{
		if ($user_id === FALSE)
			$user_id = $this->user_model->username_to_user_id($this->user->username);

		if ( ! is_numeric($user_id))
			throw new \Exception('SharIF Judge is already installed.');


		$user = $this->user_model->get_user($user_id);
		if ($user === FALSE)
			throw new \Exception('SharIF Judge is already installed.');

		$this->edit_username = $user->username;

		//Non-admins are not able to update others' profile
		if ($this->user->level <= 2 && $this->user->username != $this->edit_username) // permission denied
			throw new \Exception('SharIF Judge is already installed.');

		$this->form_validation->setRule('display_name', 'name', 'max_length[40]');
		$this->form_validation->setRule('email', 'email address', 'required|max_length[40]|valid_email|callback__email_check', array('_email_check' => 'This %s already exists.'));
		$this->form_validation->setRule('password', 'password', 'callback__password_check', array('_password_check' => 'The %s field must be between 6 and 200 characters in length.'));
		$this->form_validation->setRule('password_again', 'password confirmation', 'callback__password_again_check', array('_password_again_check' => 'The %s field does not match the password field.'));
		$this->form_validation->setRule('role', 'role', 'callback__role_check');
		if ($this->form_validation->run()){
			$this->user_model->update_profile($user_id);
			$user = $this->user_model->get_user($user_id);
			$this->form_status = 'ok';
		}
		$data = array(
			'all_assignments' => $this->assignment_model->all_assignments(),
			'id' => $user_id,
			'edit_username' => $this->edit_username,
			'email' => $user->email,
			'display_name' => $user->display_name,
			'role' => $user->role,
			'form_status' => $this->form_status,
			'lock_student_display_name' => $this->settings_model->get_setting(lock_student_display_name),
		);

		$this->twig->display('pages/profile.twig', $data);
	}


	// ------------------------------------------------------------------------


	public function _password_check($str)
	{
		if (strlen($str) == 0 OR (strlen($str) >= 6 && strlen($str) <= 200))
			return TRUE;
		return FALSE;
	}

	public function _password_again_check($str)
	{
		if ($this->input->post('password') !== $this->input->post('password_again'))
			return FALSE;
		return TRUE;
	}

	/**
	 * Checks whether a user with this email exists
	 */
	public function _email_check($email)
	{
		if ($this->user_model->have_email($email, $this->edit_username))
			return FALSE;
		return TRUE;
	}

	/**
	 * For validating user role
	 */
	public function _role_check($role)
	{
		// Non-admin users should not be able to change user role:
		if ($this->user->level <= 2)
			return ($role == '');

		// Admins can change everybody's user role:
		$roles = array('admin', 'head_instructor', 'instructor', 'student');
		return in_array($role, $roles);
	}


}
