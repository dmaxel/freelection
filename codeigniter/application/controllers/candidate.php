<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	   $this->auth = new stdClass;
		$this->load->model('general_model');
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
				redirect('/election_results');
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