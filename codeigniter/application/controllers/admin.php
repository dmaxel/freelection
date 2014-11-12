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
        
        // echo '<pre>';
        // var_dump($elections);
        // echo '</pre>';
        // exit;

        $this->load->view('templates/header', $this->data);
        $this->load->view('admin', $this->data);
        $this->load->view('templates/footer');
	
	$email_config = Array(
	'protocol' => 'smtp',
	'smtp_host' => 'ssl://smtp.googlemail.com',
	'smtp_port' => 465,
	'smtp_user' => 'freelection.voting.system@gmail.com',
	'smtp_pass' => 'teamfreelection',
	'mailtype' => 'html',
	'charset' => 'iso-8859-1'
	);

	$this->load->library('email', $email_config);
	$this->email->set_newline("\r\n");
	$this->email->from('freelection.voting.system@gmail.com', 'Admin');
	$this->email->to('adamhair@rocketmail.com');
	$this->email->subject('Test subject');
	$data = array('message' => "Test message");
	$email = $this->load->view('templates/email', $data, TRUE);
	$this->email->message($email);
	//$this->email->send();

	}
	
    public function view_users() {
        $this->load->view('templates/header', $this->data);
        $this->load->view('view_users');
        $this->load->view('templates/footer');
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
    
        // get all the elections
        $result = $this->general_model->getAllElections();
        $this->data['elections'] = $result;
        
    
        $this->load->view('templates/header', $this->data);
        $this->load->view('view_elections', $this->data);
        $this->load->view('templates/footer');        
    }
    
    public function new_election(){
        $this->load->view('templates/header', $this->data);
        $this->load->view('new_election');
        $this->load->view('templates/footer');     
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
