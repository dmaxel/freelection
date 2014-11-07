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

        $data['username'] = "admin";
        
        // load the view
        $this->load->view('templates/header', $data);
        //$this->load->view('admin');
        $this->load->view('templates/footer');
	}
    
    public function view_users() {
        $result = $this->db->query("select uacc_username from user_accounts where uacc_date_last_login != uacc_date_added;");
        echo '<pre>';
        var_dump($result);
        echo '</pre>';
        exit;
        
        $this->load->view('templates/header', $data);
        $this->load->view('view_users');
        $this->load->view('templates/footer');
    }
    
    public function view_pending() {
        $result = $this->db->query("select uacc_username from user_accounts where uacc_password_plain is not NULL and uacc_date_last_login = uacc_date_added;");
        echo '<pre>';
        var_dump($result->row());
        echo '</pre>';
        exit;
        
        $this->load->view('templates/header', $data);
        $this->load->view('view_pending');
        $this->load->view('templates/footer');
    }
    
    public function view_elections(){
        
    
    }
}
?>
