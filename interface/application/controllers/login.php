<?php
class Login extends CI_Controller {
	
	public function index(){
		$this->load->library('flexi_auth_lite');
		
		if(get_user_id() == FALSE)
		{
			$this->showlogin();
		}
		else
		{
			//redirect('/main/showmain');
		}
	}
	
	public function showlogin(){
		$this->load->view('login', $data);
	}
}
?>
