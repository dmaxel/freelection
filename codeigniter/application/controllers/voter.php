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
    
    
        // get data associated with this user/election and pass to view
        //this->load->model('voter_model');
        
        $query = $this->flexi_auth->get_user_by_identity();
        $result = $query->row();
        // echo '<pre>';
        // var_dump($result);
        // echo '</pre>';
        // exit;
        
        $data['username'] = $result->uacc_username;
        
        // load the view
        $this->load->view('templates/header', $data);
        $this->load->view('voter');
        $this->load->view('templates/footer');
	}
}
?>
