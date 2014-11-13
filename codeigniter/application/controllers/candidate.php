<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	    $this->auth = new stdClass;
		$this->load->model('general_model');
	}

	public function index()
	{
		$this->showProfile();
	}
	
	public function showProfile(){
		$userID = $this->general_model->getUserID();
		$realName = $this->general_model->getRealName($userID);
		$data['username'] = $realName['uacc_firstname']." ".$realName['uacc_lastname'];
        $this->load->view('templates/header', $data);
		
		
		//$userID = $this->general_model->getUserID();
		$electionID = $this->general_model->getElectionID($userID);
		$data['candidate_info'] = $this->general_model->getCandidate($userID);
		$data['election_description'] = $this->general_model->getElectionDescription($electionID);
		$data['election_window'] = $this->general_model->getElectionWindow($electionID);
		$this->load->view('candidate', $data);
		
        $this->load->view('templates/footer');
		}
	
	public function updateDescription(){
		if($this->input->post('description_submit')){
			$userID = $this->general_model->getUserID();
			$this->general_model->updateCandidateDescription($userID);
			$this->showProfile();
		}
	}
}
?>