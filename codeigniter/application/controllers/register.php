<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	    $this->auth = new stdClass;
	}

	public function index()
	{
		$this->load->helper('form');
		$this->load->view('register');
	}
	
	public function input(){
		$this->auth = new stdClass;
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->model('general_model');
		
		if($this->input->post('mysubmit')){
			$this->general_model->entry_insert();
		}
	}
}
?>
