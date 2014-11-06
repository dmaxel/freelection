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
		$type = $this->input->post('user_types');
		$type_num = 0;

		if($type == 'voter')
		{
			$type_num = 4;
		}
		else if($type == 'candidate')
		{
			$type_num = 3;
		}
		else if($type == 'admin')
		{
			$type_num = 1;
		}
		else if($type == 'monitor')
		{
			$type_num = 2;
		}
		
		$this->flexi_auth->insert_user($email, $username, $password, FALSE, $type_num, TRUE);
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
		$query = $this->db->query("SELECT DISTINCT b.election_id FROM ballots b, voting_eligibility v WHERE v.position = b.position AND v.uacc_id = $userID");
		$result = $query->row_array();
		return $result['election_id'];
	}
	
	/*public function getPositionTitles($userID){
		$sql = "SELECT b.title FROM ballots b, voting_eligibility v WHERE v.position = b.position AND v.uacc_id = ?";
		$query = $this->db->query($sql, $userID);
		return $query;
	}*/
	
	public function getAllCandidates($electionID){
		$query = $this->db->query("SELECT candidate_id, first_name, last_name, description FROM ballots NATURAL JOIN candidates WHERE election_id = $electionID");
		return $query->result_array();
	}
	
	/*public function getCandidates($position){
		$sql = "SELECT first_name, last_name FROM candidates c, voting_eligibility v WHERE c.position = v.position AND v.position = ?";
		$query = $this->db->query($sql, $position);
		return $query;
	}*/
	
	public function getElectionDescription($electionID){
		$query = $this->db->query("SELECT description FROM elections WHERE election_id = $electionID");
		$result = $query->row_array();
		return $result['description'];
	}
	
	public function getElectionWindow($electionID){
		$query = $this->db->query("SELECT voting_window_start, voting_window_end FROM elections WHERE election_id = $electionID");
		return $query->row_array();
	}
}
?>