<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Voter extends CI_Controller {
	
	public function index(){
    
        // check if logged in as voter
        $this->auth = new stdClass;
		$this->load->model('general_model');
		$loggedIn = $this->general_model->checkIfLoggedIn();
		$groupID = $this->general_model->getGroupID();
        
        // redirect to homepage if not logged in or incorrect id
        if($loggedIn === FALSE || $groupID !== 1) // should be 4 for actual voter
        {
            $this->load->helper('url');
            redirect('');
        }
        
        $data['username'] = $this->general_model->getUsername();
        
        // load the view
        $this->load->view('templates/header', $data);
		
		$userID = $this->general_model->getUserID();
		$electionID = $this->general_model->getElectionID($userID);
		$data['candidates'] = $this->general_model->getAllCandidates($electionID);
		$data['election_description'] = $this->general_model->getElectionDescription($electionID);
		$data['election_window'] = $this->general_model->getElectionWindow($electionID);

		$this->load->view('voter', $data);
		
        $this->load->view('templates/footer');
	}
}
?>
