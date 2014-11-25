<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class New_Election extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->auth = new stdClass;
		$this->load->model('general_model');
		// check if logged in as admin
		$loggedIn = $this->general_model->checkIfLoggedIn();
		$groupID = $this->general_model->getGroupID();
		// redirect to homepage if not logged in or incorrect id
		if($loggedIn === FALSE || $groupID !== 1)
		{
			redirect('');
		}
		ini_set('display_startup_errors',1);
		ini_set('display_errors',1);
		error_reporting(-1);
	}
	// insert new election and return new id
	public function insertNewElection($new_title, $new_description, $new_registration_start, $new_registration_end, $new_voting_start, $new_voting_end)
	{
		$this->db->query("insert into elections (election_title, description, registration_window_start, registration_window_end, voting_window_start, voting_window_end) values ('$new_title', '$new_description', '$new_registration_start', '$new_registration_end', '$new_voting_start', '$new_voting_end')");
		$new_election_id = $this->db->query("select election_id from elections where election_title = '$new_title' and description = '$new_description'");
		$new_election_id = $new_election_id->row_array();
		return $new_election_id['election_id'];
	}
	public function insertPositionIntoElection($election_id)
	{
	}
	public function index(){
		$data['username'] = $this->general_model->getUsername();
		if ($this->input->post('election_title'))
		{
			$new_title = $this->input->post('election_title');
			$new_description = $this->input->post('election_description');
			$new_reg_start_day = $this->input->post('registration_start');
			$new_reg_start_hour = $this->input->post('reg_hour_start_dropdown');
			$new_reg_end_day = $this->input->post('registration_end');
			$new_reg_end_hour = $this->input->post('reg_hour_end_dropdown');
			$new_vote_start_hour = $this->input->post('vote_hour_start_dropdown');
			$new_vote_start_day = $this->input->post('election_start');
			$new_vote_end_hour = $this->input->post('vote_hour_end_dropdown');
			$new_vote_end_day = $this->input->post('election_end');
			$election_to_update = $this->input->post('current_election');
			// apply these changes to the election
			$new_reg_start = $new_reg_start_day . ' ' . sprintf("%02d:00:00", $new_reg_start_hour);
			$new_reg_end = $new_reg_end_day . ' ' . sprintf("%02d:00:00", $new_reg_end_hour);
			$new_vote_start = $new_vote_start_day . ' ' . sprintf("%02d:00:00", $new_vote_start_hour);
			$new_vote_end = $new_vote_end_day . ' ' . sprintf("%02d:00:00", $new_vote_end_hour);
			//$this->insertNewElection($new_title, trim($new_description), $new_reg_start, $new_reg_end, $new_vote_start, $new_vote_end);
			
			$new_positions = $this->input->post('pos');
			$write_ins = $this->input->post('writein');
			
			echo '<pre>';
			var_dump($new_positions);
			var_dump($write_ins);
			echo '</pre>';
			exit;
			//redirect(current_url(), 'refresh');
		}
		// create time form options
		for ($i = 0; $i <=23; $i++)
		{
			if ($i < 10)
			$data['hour_options'][$i] = "0". $i . ":00";
			else
			$data['hour_options'][$i] = $i . ":00";
		}
		$this->load->view('templates/header', $data);
		$this->load->view('new_election', $data);
	}
}