<?php
class Register extends CI_Model {
	
	public function index(){
		
		$this->load->library(flexi_auth);
		
		//these values need to be picked up by the form
		$username = $_POST["name_field"];
		$password = $_POST["password_field"];
		$email = $_POST["email_field"];
		//login returns true or false if successful
		$result = $this->flexi_auth->create_user($email, $username, $password, FALSE, FALSE, TRUE);
		if($result != FALSE)
		{
			//do stuff after successful register
		}
		else
		{
			//this should hopefully replace the login form with this message
			echo "There was an error.";
		}
	}
}
?>
