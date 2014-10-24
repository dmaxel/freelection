<?php
class Login_Model extends CI_Model {
	
	public function __construct(){
	        parent::__construct();
	    }
	
	public function index(){
		// nothing here
	}
	
	public function checkIfLoggedIn(){
		$this->load->library('flexi_auth');
		$result = $this->flexi_auth->get_user_id();
		return $result;
	}
	
	public function getGroupID(){
		$this->load->library('flexi_auth');
		$result = $this->flexi_auth->get_user_group_id();
		return $result;
	}
	
	public function login(){
		$this->load->library('flexi_auth');
		$username = $this->input->post('username_field');
		$password = $this->input->post('password_field');
		$result = $this->flexi_auth->login($username, $password);
		return $result;
	}
	
	public function logout($input){
		$this->load->library('flexi_auth');
		$this->flexi_auth->logout($input);
	}
}
?>
