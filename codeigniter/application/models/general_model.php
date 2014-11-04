<?php
class General_Model extends CI_Model {
	
	public function __construct(){
	        parent::__construct();
	    }
	
	public function index(){
		//
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
	
	public function entry_insert(){
		$this->load->library('flexi_auth');
		
		$username = $this->input->post('name_field');
		$email = $this->input->post('email_field');
		$password = $this->input->post('password_field');
		
		$this->flexi_auth->insert_user($email, $username, $password, FALSE, FALSE, TRUE);
	}
	
	public function checkIfLoggedIn(){
		$this->load->library('flexi_auth');
		$result = $this->flexi_auth->get_user_id();
		return $result;
	}
	
	public function getUserID(){
		$this->load->library('flexi_auth');
		$query = $this->flexi_auth->get_user_by_identity();
		$result = $query->row();
		$userID = $result->uacc_id;
		return $userID;
	}
	
	public function getUsername(){
		$this->load->library('flexi_auth');
		$query = $this->flexi_auth->get_user_by_identity();
		$result = $query->row();
		$username = $result->uacc_username;
		return $username;
	}
	
	public function getGroupID(){
		$this->load->library('flexi_auth');
		$result = $this->flexi_auth->get_user_group_id();
		return $result;
	}
	
	public function getElectionID($userID){
		$query = $this->db->query('SELECT unique b.election_id FROM ballots b, voting_eligibility v WHERE v.position = b.position AND v.uacc_id = $userID');
		$result = $query->row();
		return $result;
	}
	
	public function getPositionTitles($userID){
		$query = $this->db->query('SELECT b.title FROM ballots b, voting_eligibility v WHERE v.position = b.position AND v.uacc_id = $userID');
		$result = $query->result();
		return $result;
	}
	
	public function getAllCandidates($electionID){
		$query = $this->db->query('SELECT firstname, lastname FROM ballots NATURAL JOIN candidates WHERE b.election_id = $electionID');
		$result = $query->result();
		return $result;
	}
	
	public function getCandidates($position){
		$query = $this->db->query('SELECT first_name, last_name FROM candidates c, voting_eligibility v WHERE c.position = v.position AND v.position = $position');
		$result = $query->result();
		return $result;
	}
}
?>