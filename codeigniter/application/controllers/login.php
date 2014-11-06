<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	
	public function index(){
		
		$this->auth = new stdClass;
		$this->load->model('general_model');
		$loggedIn = $this->general_model->checkIfLoggedIn();
		
		if($loggedIn == FALSE)
		{
			$this->loadLoginPage();
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
		$this->load->model('general_model');
		
		if($this->input->post('mysubmit')){
			$result = $this->general_model->login();
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
	
	public function doLogout(){
		$this->auth = new stdClass;
		$this->load->model('general_model');
		$this->general_model->logout(TRUE);
		$this->loadLoginPage();
	}
	
	public function loadLoginPage(){
		$this->load->helper('form');
		$this->load->view('login');
	}
	
	public function loadPage(){
		$groupID = $this->general_model->getGroupID();
		if($groupID == 1)
		{
			//this should be $this->load->view('administrator'); but we're using voter for testing
			//$this->load->view('templates/header');
			//$this->load->view('voter');
			//$this->load->view('templates/footer');
			$this->load->helper('url');
            redirect('/voter');
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