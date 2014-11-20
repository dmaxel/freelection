<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    private $data = array();
    
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
        
        // get the username
        $this->data['username'] = $this->general_model->getUsername();
	}
    
	public function index(){
        // get all the elections
        $this->data['elections'] = $this->general_model->getElectionInfoList();
        
        // check for form input
        if(!$this->input->post('elections'))
        {
            $this->data['selected_election'] = -1;
        }
        else
        {
            $selected_election = $this->input->post('elections');
          
            $this->data['selected_election'] = $selected_election;
            $this->data['election_description'] = $this->general_model->getElectionDescription($selected_election);
            $this->data['election_window'] = $this->general_model->getElectionWindow($selected_election);
            echo '<pre>';
            var_dump($this->data);
            echo '</pre>';
            exit;
        }



        $this->load->view('templates/header', $this->data);
        $this->load->view('admin', $this->data);
        $this->load->view('templates/footer');

	}
	
    public function view_users() {
		$data['username'] = $this->general_model->getUsername();
        $this->load->view('templates/header', $data);
		
		$data['users'] = $this->general_model->getActiveUsers();
        $this->load->view('view_users', $data);
        $this->load->view('templates/footer');
    }
    
    public function view_pending() {
        
		$data['username'] = $this->general_model->getUsername();
        $this->load->view('templates/header', $data);
		
		$pending_users = $this->general_model->getPendingUsers();
		$data['p_user'] = array();
		foreach($pending_users as $pendingUser)
		{
			$userID = $pendingUser['uacc_id'];
			if($pendingUser['uacc_group_fk'] == 3)
			{
				$temp = $this->general_model->getPendingCandidate($userID);
				$data['p_user'][] = array_merge($pendingUser, $temp);
			}
			else if($pendingUser['uacc_group_fk'] == 4)
			{
				$temp = $this->general_model->getPendingVoter($userID);
				$data['p_user'][] = array_merge($pendingUser, $temp);
			}
		}
        $this->load->view('view_pending', $data);
		
        $this->load->view('templates/footer');
    }
    
    public function view_elections(){
    
        // get all the elections
        $result = $this->general_model->getElectionInfoList();
        $this->data['elections'] = $result;
        
    
        $this->load->view('templates/header', $this->data);
        $this->load->view('view_elections', $this->data);
        $this->load->view('templates/footer');        
    }

    public function new_user(){
        $this->load->view('templates/header', $this->data);
        $this->load->view('new_user');
        $this->load->view('templates/footer');
    }
    
    public function edit_user(){
        $this->load->view('templates/header', $this->data);
        $this->load->view('update_user');
        $this->load->view('templates/footer');
    }

    public function new_election(){
        $this->load->view('templates/header', $this->data);
        $this->load->view('new_election');
    }
	
	public function approve($userID, $candidate){
		$this->general_model->approveUser($userID);
		if($candidate = 1)
		{
			$this->general_model->approveCandidate($userID);
		}
		redirect('/admin/view_pending');
	}
	
	public function deny($userID){
		$this->general_model->deleteUser($userID);
		redirect('/admin/view_pending');
	}
}
?>
