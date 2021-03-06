<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	
	public function __construct(){
	    parent::__construct();
	    $this->auth = new stdClass;
	}

	public function index(){
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
		$this->load->model('general_model');
		
		if($this->input->post('mysubmit')){
			$result = $this->general_model->login();
			if($result == TRUE)
			{
				$this->loadPage();
			}
			else
			{
				$this->loadLoginPage();
			}
		}
	}
	
	public function doLogout(){
		$this->load->model('general_model');
		$this->general_model->logout(FALSE);
        redirect('');
		//$this->loadLoginPage();
	}
	
	public function loadLoginPage(){

		$this->load->view('login');
	}
	
	public function loadPage(){
		$groupID = $this->general_model->getGroupID();
		if($groupID == 1)
		{
            redirect('/admin');
		}
		else if($groupID == 2)
		{
			redirect('/monitor');
		}
		else if($groupID == 3)
		{
			redirect('/candidate');
		}
		else if($groupID == 4)
		{
			redirect('/voter');
		}
	}
}
?>