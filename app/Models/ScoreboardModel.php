<?php
/**
 * SharIF Judge online judge
 * @file Scoreboard_model.php
 * @author: Filipus Setio Nugroho <filipussetio@gmail.com>
 */
namespace App\Models;
use CodeIgniter\Model;

class ScoreboardModel extends Model
{
	protected $assignment_model;
	protected $settings_model;
	protected $user_model;

	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Generate Scoreboard
	 *
	 * Generates scoreboard for given assignment, from Final Submissions.
	 * This function is called by update_scoreboard
	 *
	 * @param int $assignment_id
	 * @return array
	 */
	private function _generate_scoreboard($assignment_id)
	{
		$this->assignment_model = new AssignmentModel();
		$this->settings_model = new SettingsModel();
		$assignment = $this->assignment_model->assignment_info($assignment_id);
		$submissions = $this->db->table('submissions')->getWhere(array('is_final' => 1 , 'assignment' => $assignment_id))->getResultArray();
		$total_score = array();
		$penalty = array();
		$users = array();
		$start = strtotime($assignment['start_time']);
		$submit_penalty = $this->settings_model->get_setting('submit_penalty');
		$scores = array();
		foreach ($submissions as $submission){

			$pi = $this->assignment_model->problem_info($assignment_id, $submission['problem']);

			$pre_score = ceil($submission['pre_score']*$pi['score']/10000);
			if ($submission['coefficient'] === 'error')
				$final_score = 0;
			else
				$final_score = ceil($pre_score*$submission['coefficient']/100);
			$delay = strtotime($submission['time'])-$start;
			$scores[$submission['username']][$submission['problem']]['score'] = $final_score;
			$scores[$submission['username']][$submission['problem']]['time'] = $delay;

			if ( ! isset($total_score[$submission['username']]))
				$total_score[$submission['username']] = 0;
			if ( ! isset($penalty[$submission['username']]))
				$penalty[$submission['username']] = 0;

			$total_score[$submission['username']] += $final_score;

			$number_of_submissions = $this->db->table('submissions')->where(array(
				'assignment' => $submission['assignment'],
				'problem' => $submission['problem'],
				'username' => $submission['username'],
			))->countAllResults();

			$penalty[$submission['username']] += $delay + $number_of_submissions*$submit_penalty;
			$users[] = $submission['username'];
		}
		$scoreboard = array(
			'username' => array(),
			'score' => array(),
			'submit_penalty' => array()
		);
		$users = array_unique($users);
		foreach($users as $username){
			array_push($scoreboard['username'], $username);
			array_push($scoreboard['score'], $total_score[$username]);
			array_push($scoreboard['submit_penalty'], $penalty[$username]);
		}
		array_multisort(
			$scoreboard['score'], SORT_NUMERIC, SORT_DESC,
			$scoreboard['submit_penalty'], SORT_NUMERIC, SORT_ASC,
			$scoreboard['username']
		);
		return array($scores, $scoreboard);
	}


	// ------------------------------------------------------------------------


	/**
	 * Update All Scoreboards
	 *
	 * Updates the cached scoreboard of all assignments.
	 * This function is called each time a user is deleted, or all submissions
	 * of a user is deleted.
	 */
	public function update_scoreboards()
	{
		$assignments = $this->db->table('assignments')->select('id')->get()->getResultArray();
		foreach ($assignments as $assignment){
			$this->update_scoreboard($assignment['id']);
		}
	}


	// ------------------------------------------------------------------------


	/**
	 * Update Scoreboard
	 *
	 * Updates the cached scoreboard of given assignment. Saves the html code of
	 * scoreboard table in database.
	 *
	 * This function is called after judging/rejudging a submission, and when one
	 * of these settings is changed for an assignment:
	 *
	 * TODO: Better Implementation (faster and with less db queries)
	 *
	 *   - Extra Time
	 *   - Start Time
	 *   - Finish Time
	 *   - Coefficient's Rule
	 *   - Enable/Disable Scoreboard
	 *
	 * @param int $assignment_id
	 */
	public function update_scoreboard($assignment_id)
	{
		$this->assignment_model = new AssignmentModel();
		$this->user_model = new UserModel();
		// If scoreboard in not enabled, do nothing
		$scoreboard_enabled = $this->db->table('assignments')->select('scoreboard')->getWhere(array('id'=>$assignment_id))->getRow()->scoreboard;

		if ($assignment_id == 0 OR  ! $scoreboard_enabled )
			return;

		// Generate the scoreboard
		list ($scores, $scoreboard) = $this->_generate_scoreboard($assignment_id);

		// Generate the scoreboard's html code
		// todo: Save Scoreboard as json (generate html at client side)
		$all_problems = $this->assignment_model->all_problems($assignment_id);
		$total_score = 0;
		foreach($all_problems as $i)
			$total_score += $i['score'];
		$data = array(
			'assignment_id' => $assignment_id,
			'problems' => $all_problems,
			'total_score' => $total_score,
			'scores' => $scores,
			'scoreboard' => $scoreboard,
			'names' => $this->user_model->get_names(),
		);
		
		$scoreboard_table =  view('pages/scoreboard_table', $data);

		// Minify the scoreboard's html code
		// $scoreboard_table = $this->output->minify($scoreboard_table, 'text/html');

		// Save the scoreboard's html code in Database
		$query = $this->db->table('scoreboard')->select('assignment')->getWhere(array('assignment'=>$assignment_id));
		if ($query->getNumRows()==0)
			$this->db->table('scoreboard')->insert(array('assignment'=>$assignment_id, 'scoreboard'=>$scoreboard_table));
		else
			$this->db->table('scoreboard')->where('assignment', $assignment_id)->update(array('scoreboard'=>$scoreboard_table));
	}


	// ------------------------------------------------------------------------


	/**
	 * Get Cached Scoreboard
	 *
	 * Returns the cached scoreboard of given assignment as a html text
	 *
	 * @param int $assignment_id
	 * @return string
	 */
	public function get_scoreboard($assignment_id)
	{
		$query =  $this->db->table('scoreboard')->select('scoreboard')->getWhere(array('assignment'=>$assignment_id));

		if ($query->getNumRows() != 1)
			return 'Scoreboard not found';
		else
			return $query->getRow()->scoreboard;
	}

}