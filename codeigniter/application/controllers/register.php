<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	    $this->auth = new stdClass;
		$this->load->model('general_model');
	}

	public function index()
	{
		$data['checkbox_value'] = FALSE;
		$data['election_value'] = 0;
		$data['firstname_value'] = "";
		$data['lastname_value'] = "";
		$data['email_value'] = "";
		$data['major_value'] = "";
		
		$data['elections'] = $this->general_model->getElectionInfoList();
		$this->load->view('register', $data);
	}
	
	public function input(){
		$checkbox = $this->input->post('candidate');
		$election = $this->input->post('available_elections');
		$position = NULL;
		if(isset($checkbox) == TRUE)
		{
			$position = $this->input->post('available_positions');
		}
		$firstname = $this->input->post('firstname_field');
		$lastname = $this->input->post('lastname_field');
		$username = $firstname[0].$lastname.$this->getRandomNum();
		$password = $this->randomPassword();
		$email = $this->input->post('email_field');
		$major = $this->input->post('major_field');
		
		$this->general_model->entry_insert($username, $password, $checkbox, $election, $position, $firstname, $lastname, $email, $major);
		
		$email_config = Array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'freelection.voting.system@gmail.com',
		'smtp_pass' => 'teamfreelection',
		'mailtype' => 'html',
		'charset' => 'iso-8859-1'
		);

		$this->load->library('email', $email_config);
		$this->email->set_newline("\r\n");
		$this->email->from('freelection.voting.system@gmail.com', 'Freelection Admin');
		$this->email->to($email);
		$this->email->subject('Freelection - Your Username and Password');
		$this->email->message("Hello there!\r\n\r\nYour username is: $username\r\nYour password is: $password\r\n\r\nThank you for registering!\r\n\r\nFreelection");
		//$this->email->send();
		
		redirect('');
	}
	
	public function reload(){
		$checkbox = $this->input->post('candidate');
		$election = $this->input->post('available_elections');
		$position = NULL;
		if(isset($checkbox) == TRUE)
		{
			if($this->input->post('available_positions'))
			{
				//if this field already exists, get the value from it, otherwise leave it as null because the field didn't exist yet
				$position = $this->input->post('available_positions');
			}
		}
		else
		{
			//give it some random value so it'll pass the check later
			$position = -1;
		}
		$firstname = $this->input->post('firstname_field');
		$lastname = $this->input->post('lastname_field');
		$email = $this->input->post('email_field');
		$major = $this->input->post('major_field');
		if($election == NULL || $position == NULL || $firstname == NULL || $lastname == NULL || $email == NULL || $major == NULL)
		{
			//reload the page
			$data['checkbox_value'] = $checkbox;
			$data['election_value'] = $election;
			if($election == -1)
			{
				$data['select_positions'] = array(
					'title' => "Please select an election first.",
					'position' => -1
				);
			}
			else
			{
				$data['select_positions'] = $this->general_model->getPositionsForElection($election);
			}
			$data['firstname_value'] = $firstname;
			$data['lastname_value'] = $lastname;
			$data['email_value'] = $email;
			$data['major_value'] = $major;
			
			$data['elections'] = $this->general_model->getElectionInfoList();
			$this->load->view('register', $data);
		}
		else
		{
			$this->input();
		}
	}
	
	public function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 10; $i++) {
	        $n = mt_rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
	
	public function getRandomNum() {
	    $alphabet = "0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 4; $i++) {
	        $n = mt_rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
}
?>
