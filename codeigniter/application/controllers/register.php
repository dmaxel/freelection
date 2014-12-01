<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	   $this->auth = new stdClass;
		$this->load->model('general_model');
	}
	// Initialize the values for the registration page and load the view
	public function index()
	{
		$data['checkbox_value'] = FALSE;
		$data['election_value'] = -1;
		$data['position_value'] = -1;
		$data['firstname_value'] = "";
		$data['lastname_value'] = "";
		$data['email_value'] = "";
		$data['major_value'] = "";
		
		$data['elections'] = $this->general_model->getElectionInfoList();
		$this->load->view('register', $data);
	}
	
	// Enters the new user into the appropriate database tables (as a pending user)
	public function input(){
		// Get all the entered information
		$checkbox = $this->input->post('candidate');
		$election = $this->input->post('available_elections');
		$position = -1;
		if($checkbox == TRUE)
		{
			$position = $this->input->post('available_positions');
		}
		$firstname = $this->input->post('firstname_field');
		$lastname = $this->input->post('lastname_field');
		// Generate a username based on the first initial of the first name followed by last name plus a number
		$username = strtolower($firstname[0]).strtolower($lastname).$this->getRandomNum();
		// Generate a random password
		$password = $this->randomPassword();
		$email = $this->input->post('email_field');
		$major = $this->input->post('major_field');
		$activate = FALSE;
		$type = NULL;
		if($checkbox == TRUE)
		{
			$type = 3;
		}
		else
		{
			$type = 4;
		}
		
		// Enter the user into the user accounts table (unactivated)
		$userID = $this->general_model->entry_insert($username, $password, $type, $election, $position, $firstname, $lastname, $email, $major, $activate);
		
		// Send a confirmation email with the username and password
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
		$this->email->message("Hello there! Here are your credentials, but you won't be able to log in until you receive another email mentioning that an admin has approved you.\r\n\r\nYour username is: $username\r\nYour password is: $password\r\n\r\nThank you for registering!\r\n\r\nFreelection");
		$this->email->send();
		
		// Redirect to the log-in page
		redirect('');
	}
	
	// Reload with the new needed information (positions based on election selected, etc.)
	public function reload(){
		$submitted = $this->input->post('mysubmit');
		$checkbox = $this->input->post('candidate');
		$election = $this->input->post('available_elections');
		$position = NULL;
		if(isset($checkbox) == TRUE)
		{
			$position = $this->input->post('available_positions');
		}
		else
		{
			$position = -1;
		}
		$firstname = $this->input->post('firstname_field');
		$lastname = $this->input->post('lastname_field');
		$email = $this->input->post('email_field');
		$major = $this->input->post('major_field');
		if(!($submitted) || $election == -1 || $position == -1 || $firstname == NULL || $lastname == NULL || $email == NULL || $major == NULL)
		{
			//reload the page
			$data['checkbox_value'] = $checkbox;
			$data['election_value'] = $election;
			$data['select_positions'] = $this->general_model->getPositionsForElection($election);
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
	
	// Create a randomly generated password for the new user
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
	
	// Create a randomly generated number to add on the end of the username
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
