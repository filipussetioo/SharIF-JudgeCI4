<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User_model;
use App\Models\Logs_model;
use App\Models\Settings_model;

/**
 * SharIF Judge online judge
 * @file Login.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */


class Login extends BaseController
{
	protected $settings_model;
	protected $validation;
	protected $session;
	protected $user_model;
	protected $logs_model;

	public function __construct()
	{
		$this->settings_model = new Settings_model();
		$this->user_model = new User_model();
		$this->logs_model = new Logs_model();
		$this->validation =  \Config\Services::validation();
		$this->session = session();
		helper(['form']);
	}


	// ------------------------------------------------------------------------


	/**
	 * checks whether the entered registration code is correct or not
	 *
	 */
	public function _registration_code($code){
		$rc = $this->settings_model->get_setting('registration_code');
		if ($rc == '0')
			return TRUE;
		if ($rc == $code)
			return TRUE;
		return FALSE;
	}


	// ------------------------------------------------------------------------


	/**
	 * Login
	 */
	public function index()
	{
		$errors = [];
		if ($this->session->get('logged_in')) // if logged in
			redirect('/');
		$this->validation->setRule('username', 'Username', 'required|min_length[3]|max_length[20]|alpha_numeric', ['Incorrect Username or Password']);
		$this->validation->setRule('password', 'Password', 'required|min_length[6]|max_length[200]',['Incorrect Username or Password']);
		$data = [
			'error' => FALSE,
			'registration_enabled' => $this->settings_model->get_setting('enable_registration'),
		];

		if($this->validation->withRequest($this->request)->run()){
			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');
			if($this->user_model->validate_user($username, $password)){
				$ip_adrress = $this->request->getIpaddress();
			
				// setting the session and redirecting to dashboard:
				$login_data = array(
					'username'  => $username,
					'logged_in' => TRUE
				);
				$this->session->set($login_data);
				$this->user_model->update_login_time($username);
				$this->logs_model->insert_to_logs($username,$ip_adrress);
				return redirect()->to('/');
			}
			else
				// for displaying error message in 'pages/authentication/login' view
				$errors = $this->validation->getErrors();
				$data['error'] = TRUE;
		}

		return view('pages/authentication/login', [
			'data' => $data,
			'title' => 'Login',
			'errors' => $errors
		]);;
	}


	// ------------------------------------------------------------------------


	public function register()
	{
		if ($this->session->userdata('logged_in')) // if logged in
			redirect('dashboard');
		if ( ! $this->settings_model->get_setting('enable_registration'))
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Registration is Closed');
		$this->validation->setRule('registration_code', 'registration code', 'callback__registration_code', array('_registration_code' => 'Invalid %s'));
		$this->validation->setRule('username', 'username', 'required|min_length[3]|max_length[20]|alpha_numeric|lowercase|is_unique[users.username]', array('is_unique' => 'This %s already exists.','alpha_numeric'));
		$this->validation->setRule('email', 'email address', 'required|max_length[40]|valid_email|lowercase|is_unique[users.email]', array('is_unique' => 'This %s already exists.'));
		$this->validation->setRule('password', 'password', 'required|min_length[6]|max_length[200]');
		$this->validation->setRule('password_again', 'password confirmation', 'required|matches[password]');
		$data = array(
			'registration_code_required' => $this->settings_model->get_setting('registration_code')=='0'?FALSE:TRUE
		);
		if ($this->validation->run()){
			$this->user_model->add_user(
				$this->request->getPost('username'),
				$this->request->getPost('email'),
				$this->request->getPost('displayname'),
				$this->request->getPost('password'),
				'student'
			);
			return $this->twig->display('pages/authentication/register_success.twig');
		}
		else
			return $this->twig->display('pages/authentication/register.twig', $data);

	}


	// ------------------------------------------------------------------------


	/**
	 * Logs out and redirects to login page
	 */
	public function logout()
	{
		$this->session->destroy();
		redirect('login');
	}


	// ------------------------------------------------------------------------


	public function lost()
	{
		if ($this->session->userdata('logged_in')) // if logged in
			redirect('dashboard');
		$this->validation->setRule('email', 'email', 'required|max_length[40]|lowercase|valid_email');
		$data = array(
			'sent' => FALSE
		);
		if ($this->validation->run())
		{
			$this->user_model->send_password_reset_mail($this->request->getPost('email'));
			$data['sent'] = TRUE;
		}

		$this->twig->display('pages/authentication/lost.twig', $data);
	}


	// ------------------------------------------------------------------------


	public function reset($passchange_key = FALSE)
	{
		if ($passchange_key === FALSE)
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		$result = $this->user_model->passchange_is_valid($passchange_key);
		if ($result !== TRUE)
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($result);
		$this->validation->setRule('password', 'password', 'required|min_length[6]|max_length[200]');
		$this->validation->setRule('password_again', 'password confirmation', 'required|matches[password]');
		$data = array(
			'key' => $passchange_key,
			'result' => $result,
			'reset' => FALSE
		);
		if ($this->validation->run()){
			$this->user_model->reset_password($passchange_key, $this->request->getPost('password'));
			$data['reset'] = TRUE;
		}

		$this->twig->display('pages/authentication/reset_password.twig', $data);
	}



}
