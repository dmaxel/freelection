<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voter extends CI_Controller {
	
	public function __construct(){
	    parent::__construct();
	    $this->auth = new stdClass;
	}
	
	public function index(){
    
        // check if logged in as voter
		$this->load->model('general_model');
		$loggedIn = $this->general_model->checkIfLoggedIn();
		$groupID = $this->general_model->getGroupID();
        
        // redirect to homepage if not logged in or incorrect id
        if($loggedIn === FALSE || $groupID !== 1) // should be 4 for actual voter
        {
            redirect('');
        }
		else
		{
			$this->showPage();
		}
	}
        
		public function showPage(){
		$this->load->model('general_model');
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
}
?>