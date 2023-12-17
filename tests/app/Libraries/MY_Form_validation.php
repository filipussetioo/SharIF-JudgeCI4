<?php
/**
 * SharIF Judge online judge
 * @file MY_Form_validation.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
namespace App\Libraries;

use CodeIgniter\Validation\Validation;

class MY_Form_validation extends Validation
{

	/**
	 * Required
	 *
	 * @param	string
	 * @return	bool
	 */
	public function required($str)
	{
		return is_array($str) ? (bool) count($str) : ($str !== '');
	}


	// -------------------------------------------------------------------------


	/**
	 * Is Lowercase
	 *
	 * @param $str
	 * @return bool
	 */
	public function lowercase($str)
	{
		return (strtolower($str) === $str);
	}


}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */