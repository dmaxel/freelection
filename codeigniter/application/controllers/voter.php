<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voter extends CI_Controller {
	
	public function __construct(){
	    parent::__construct();
	    $this->auth = new stdClass;
		$this->load->model('general_model');
	}
	
	public function index(){
    
        // check if logged in as voter
		$loggedIn = $this->general_model->checkIfLoggedIn();
		$groupID = $this->general_model->getGroupID();
        
        // redirect to homepage if not logged in or incorrect id
        if($loggedIn === FALSE || $groupID !== 4)
        {
            redirect('');
        }
		else
		{
			$this->showPage();
		}
	}
        
		public function showPage(){
        $data['username'] = $this->general_model->getUsername();
        
        // load the view
        $this->load->view('templates/header', $data);
		
		$userID = $this->general_model->getUserID();
		$electionID = $this->general_model->getElectionID($userID);
		if($this->input->post('available_candidates'))
		{
			$data['selected_candidate'] = $this->input->post('available_candidates');
		}
		else
		{
			$data['selected_candidate'] = -1;
		}
		$data['candidates'] = $this->general_model->getAllCandidates($electionID);
		$data['election_description'] = $this->general_model->getElectionDescription($electionID);
		$data['election_window'] = $this->general_model->getElectionWindow($electionID);
		$this->load->view('voter', $data);
		
        $this->load->view('templates/footer');
		}
		
		public function voteNow(){
	        $data['username'] = $this->general_model->getUsername();
			$this->load->view('templates/header', $data);
			$this->load->view('vote_now');
			$this->load->view('templates/footer');
		}
}
?>