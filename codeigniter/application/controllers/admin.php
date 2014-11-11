<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->auth = new stdClass;
		$this->load->model('general_model');
		$loggedIn = $this->general_model->checkIfLoggedIn();
		$groupID = $this->general_model->getGroupID();
        
        // redirect to homepage if not logged in or incorrect id
        if($loggedIn === FALSE || $groupID !== 1)
        {
            $this->load->helper('url');
            redirect('');
        }
    }
    
	public function index(){

        $data['username'] = $this->general_model->getUsername();
        
        // load the view
        $this->load->view('templates/header', $data);
        //$this->load->view('admin');
        $this->load->view('templates/footer');
	}
    
    public function view_users() {
        /*$result = $this->db->query("select uacc_username from user_accounts where uacc_date_last_login != uacc_date_added;");
        echo '<pre>';
        var_dump($result);
        echo '</pre>';
        exit;
        
        $this->load->view('templates/header', $data);
        $this->load->view('view_users');
        $this->load->view('templates/footer');*/
    }
    
    public function view_pending() {
        
		$data['username'] = $this->general_model->getUsername();
        $this->load->view('templates/header', $data);
		
		$userID = $this->general_model->getUserID();
		$data['p_user'] = $this->general_model->getPendingUsers();
		foreach($data['p_user'] as $pendingUser)
		{
			if($pendingUser['uacc_group_fk'] = 3)
			{
				$pendingUser[] = $this->general_model->getPendingCandidate($userID);
			}
			else if($pendingUser['uacc_group_fk'] = 4)
			{
				$pendingUser[] = $this->general_model->getPendingVoter($userID);
				$pendingUser['position'] = '';
			}
		}
        $this->load->view('view_pending', $data);
		
        $this->load->view('templates/footer');
    }
    
    public function view_elections(){
        
    
    }
	
	public function approve($userID, $candidate){
		$this->general_model->approveUser($userID);
		if($candidate = 1)
		{
			$this->general_model->approveCandidate($userID);
		}
	}
	
	public function deny($userID){
		$this->general_model->deleteUser($userID);
	}
}
?>
