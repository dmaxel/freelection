<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	    $this->auth = new stdClass;
		$this->load->model('general_model');
	}

	public function index()
	{
		$this->load->view('register');
	}
	
	public function input(){
		if($this->input->post('mysubmit')){
			$this->general_model->entry_insert();
			redirect('/voter');
		}
	}
}
?>
