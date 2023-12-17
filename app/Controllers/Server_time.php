<?php
/**
 * SharIF Judge online judge
 * @file Server_time.php
 * @author: Filipus Setio Nugroho <filipussetio@gmail.com>
 */
namespace App\Controllers;

use App\Controllers\BaseController;

class Server_time extends BaseController
{
	/**
	 * Prints server time, used for server time synchronization
	 */
	public function index()
	{
		echo shj_now_str();
	}
}