<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index(){
		
		$this->auth = new stdClass;
		$this->load->model('login_model');
		$loggedIn = $this->login_model->checkIfLoggedIn();
		
		if($loggedIn == FALSE)
		{
			$this->load->helper('form');
			$this->load->view('login');
		}
		else
		{
			$this->loadPage();
		}
	}
	
	public function doLogin(){
		$this->auth = new stdClass;
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->model('login_model');
		
		if($this->input->post('mysubmit')){
			$result = $this->login_model->login();
			if($result == TRUE)
			{
				$this->loadPage();
			}
			else
			{
				//show an error page, with a button to go back to the login page
			}
		}
	}
	
	public function loadPage(){
		$groupID = $this->login_model->getGroupID();
		if($groupID == 1)
		{
			//this should be $this->load->view('administrator'); but we're using voter for testing
			$this->load->view('templates/header');
			$this->load->view('voter');
			$this->load->view('templates/footer');
		}
		else if($groupID == 2)
		{
			$this->load->view('monitor');
		}
		else if($groupID == 3)
		{
			$this->load->view('candidate');
		}
		else if($groupID == 4)
		{
			$this->load->view('voter');
		}
	}
}
?>
