<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	   $this->auth = new stdClass;
		$this->load->model('general_model');
	}
	public function getVotesByHour($election_id, $begin_date_time, $end_date_time) {
		$query = $this->db->query("select count(distinct uacc_id)) from votes where date_time between '$begin_date_time' and '$end_date_time' and position in (select position from ballots where election_id = '$election_id')");
		$result = $query->row_array();
		return $result["count(distinct uacc_id)"];
	}
	// Initiate the loading of the candidate page
	public function index(){
    
      // check if logged in as candidate
		$loggedIn = $this->general_model->checkIfLoggedIn();
		$groupID = $this->general_model->getGroupID();
        
      // redirect to homepage if not logged in or incorrect id
		if($loggedIn === FALSE || $groupID !== 3)
      {
      	redirect('');
		}
		else
		{
			$userID = $this->general_model->getUserID();
			$electionID = $this->general_model->getElectionIDFromCandidate($userID);
			$data['registration_window'] = $this->general_model->getRegistrationWindow($electionID);
			$data['election_window'] = $this->general_model->getElectionWindow($electionID);
			// If the election is in the voting or registration window, go to the normal page
			if(strtotime($data['registration_window']['registration_window_start']) < time() && strtotime($data['election_window']['voting_window_end']) > time()){
				$this->showProfile();
			}
			// Otherwise go to the election results page
			else{
				redirect('/election_results/showForCandidate');
			}
		}
	}
	// Load the page with all the current information on the candidate and their election
	public function showProfile(){
		$userID = $this->general_model->getUserID();
		$realName = $this->general_model->getRealName($userID);
		$data['username'] = $realName['uacc_firstname']." ".$realName['uacc_lastname'];
      $this->load->view('templates/header', $data);
		
		$electionID = $this->general_model->getElectionIDFromCandidate($userID);
		$data['candidate_info'] = $this->general_model->getCandidate($userID);
		$data['election_description'] = $this->general_model->getElectionDescription($electionID);
		$data['election_window'] = $this->general_model->getElectionWindow($electionID);
		
		// get previous 24 hours time-windows from current time
		$date = new DateTime;

		// subtract a day and add an hour to get start time for graph
		$date->sub(new DateInterval('P1D'));
		$date->add(new DateInterval('PT1H'));
		$graph_time = $date->format("Y-m-d H:00:00");
		$graph_time = new DateTime($graph_time);
		
		$data['votes_by_hour'] = array();
		$data['vote_count_labels'] = array();
		
		for ($i = 0; $i < 24; $i++)
		{
			$interval_start = $graph_time->format("Y-m-d H:i:s");
			$label = date("gA", strtotime($interval_start)) . "-";
			
			// increment by 1 hour
			$graph_time->add(new DateInterval('PT1H'));
			
			$interval_end = $graph_time->format("Y-m-d H:i:s");
			$label = $label . date("gA", strtotime($interval_end));

			$data['votes_by_hour'][$i] = (int) $this->getVotesByHour($electionID, $interval_start, $interval_end);
			$data['vote_count_labels'][$i] = $label;
	
		}
		$this->load->view('candidate', $data);
		
      $this->load->view('templates/footer');
		}
	
	// Update the candidate's description to reflect their changes
	public function updateDescription(){
		if($this->input->post('description_submit')){
			$userID = $this->general_model->getUserID();
			$this->general_model->updateCandidateDescription($userID);
			$this->showProfile();
		}
	}
}
?>