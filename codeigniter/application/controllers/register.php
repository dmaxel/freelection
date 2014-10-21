<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function index()
	{
		$this->load->helper('form');
		$this->load->view('register');
	}
	
	public function input(){
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->model('register');
		
		if($this->input->post('mysubmit')){
			$this->register->entry_insert();
		}
	}
}
?>
