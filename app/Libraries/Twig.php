<?php
namespace App\Libraries;


class Twig
{

	/**
	 * Required
	 *
	 * @param	string
	 * @return	bool
	 */
	public function extra_time_formatter($extra_time)
	{
		// convert to minutes
		$extra_time = floor($extra_time/60);
		// convert to H*60
		if ($extra_time % 60 == 0 )
			$extra_time = ($extra_time/60) . '*60';
		return $extra_time;
	}
}
