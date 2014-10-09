<?php
class Login extends CI_Model {
	
	public function index(){
		
		$this->load->library(flexi_auth);
		
		//these values need to be picked up by the form
		$identity = $_POST["username_field"];
		$password = $_POST["password_field"];
		if (isset($_POST['remember_me'])) {
			$remember_user = TRUE;
		}
		else
		{
			$remember_user = FALSE;
		}
		//login returns true or false if successful
		$result = $ci->flexi_auth->login($identity, $password, $remember_user);
		if($result)
		{
			//do stuff after successful login
			//getGroup()
			//load appropriate page for respective group
		}
		else
		{
			//this should hopefully replace the login form with this message
			echo "Your username or password was incorrect. Please try again. If you need help, contact an administrator.";
		}
	}
}
?>
