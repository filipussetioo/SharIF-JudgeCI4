<?php
/**
 * SharIF Judge online judge
 * @file Dashboard.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Assignment_model;
use App\Models\Notifications_model;
use App\Models\Settings_model;
use App\Models\User;
use Exception;

class Dashboard extends BaseController
{
	protected $db;
	protected $assignment_model;
	protected $notifications_model;
	protected $settings_model;
	protected $user;
	protected $session;
	
	public function __construct()
	{
		$this->db = db_connect();
		$this->session = session();
		$this->assignment_model = new Assignment_model();
		$this->settings_model = new Settings_model();
		$this->user = new User();
		helper(['text','url','shj_helper']);
		$this->notifications_model = new Notifications_model();
	}


	// ------------------------------------------------------------------------


	public function index()
	{
		helper(['shj_helper']);
		$data = array(
			'all_assignments'=>$this->assignment_model->all_assignments(),
			'week_start'=>$this->settings_model->get_setting('week_start'),
			'wp'=>$this->user->get_widget_positions(),
			'notifications' => $this->notifications_model->get_latest_notifications()
		);

		// detecting errors:
		$data['errors'] = array();
		if($this->user->level === 3){
			$path = $this->settings_model->get_setting('assignments_root');
			if ( ! file_exists($path))
				array_push($data['errors'], 'The path to folder "assignments" is not set correctly. Move this folder somewhere not publicly accessible, and set its full path in Settings.');
			elseif ( ! is_writable($path))
				array_push($data['errors'], 'The folder <code>"'.$path.'"</code> is not writable by PHP. Make it writable. But make sure that this folder is only accessible by you. Codes will be saved in this folder!');

			$path = $this->settings_model->get_setting('tester_path');
			if ( ! file_exists($path))
				array_push($data['errors'], 'The path to folder "tester" is not set correctly. Move this folder somewhere not publicly accessible, and set its full path in Settings.');
			elseif ( ! is_writable($path))
				array_push($data['errors'], 'The folder <code>"'.$path.'"</code> is not writable by PHP. Make it writable. But make sure that this folder is only accessible by you.');
		}
		$colors = ['#812C8C','#FF750D','#2C578C','#013440','#A6222C','#42758C','#02A300','#BA6900'];
		return view('pages/dashboard', [
			'data' => $data,
			'title' => 'Dashboard',
			'user' => $this->user,
			'colors' => $colors,
			
		]);
	}


	// ------------------------------------------------------------------------

	/**
	 * Used by ajax request, for saving the user's Dashboard widget positions
	 */
	public function widget_positions()
	{
		if ( ! $this->request->isAJAX() )
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		if ($this->request->getPost('positions') !== NULL)
			$this->user->save_widget_positions($this->request->getPost('positions'));
			$this->db->table('users');
	}

}