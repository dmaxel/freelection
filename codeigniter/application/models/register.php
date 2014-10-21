<?php
class Register extends CI_Model {
	
	public function index(){
		//
	}
	
	public function entry_insert(){
		$this->load->library(flexi_auth);
		
		$username = $this->input->post('name_field');
		$email = $this->input->post('email_field');
		$password = $this->input->post('password_field');
		
		$this->flexi_auth->insert_user($email, $username, $password, FALSE, FALSE, TRUE);
	}
}
?>
