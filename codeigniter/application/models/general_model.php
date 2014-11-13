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
	
	public function entry_insert($username, $password, $candidate, $election, $position, $firstname, $lastname, $email, $major){
		$this->load->library('flexi_auth');
		$user_data = array(
			'uacc_firstname' => $firstname,
			'uacc_lastname' => $lastname,
			'uacc_major' => $major
		);
		if($candidate == 1)
		{
			$new_userID = $this->flexi_auth->insert_user($email, $username, $password, $user_data, 3, FALSE);
			
			$this->db->query("INSERT INTO candidates (position, approved, first_name, last_name, uacc_id, description) VALUES ($position, 0, '$firstname', '$lastname', $new_userID, 'No description yet')");
			
			$this->db->query("INSERT INTO voting_eligibility (position, uacc_id) VALUES ($position, $new_userID)");
		}
		else
		{
			$new_userID = $this->flexi_auth->insert_user($email, $username, $password, $user_data, 4, FALSE);
			
			$positions = $this->getPositionsForElection($election);
			foreach($positions as $each)
			{
				$_position = $each['position'];
				$this->db->query("INSERT INTO voting_eligibility (position, uacc_id) VALUES ($_position, $new_userID)");
			}
		}
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
	
	public function getRealName($userID){
		$query = $this->db->query("SELECT uacc_firstname, uacc_lastname FROM user_accounts WHERE uacc_id = $userID");
		return $query->row_array();
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
	
	/* this function is should work for Admin and monitor*/
	public function getElectionInfoList(){
		$query = $this->db->query("SELECT election_id, election_title, description, voting_window_start, voting_window_end FROM elections");
		return $query->result_array();
	}
	
	public function getPositions($userID){
		$query = $this->db->query("SELECT position, type, title, write_ins FROM ballots NATURAL JOIN voting_eligibility WHERE uacc_id = $userID");
		return $query->result_array();
	}
	
	public function getPositionsForElection($election_id){
		$query = $this->db->query("SELECT position, type, title FROM ballots WHERE election_id = $election_id");
		return $query->result_array();
	}
	
	public function getCandidatesForPosition($position){
		$query = $this->db->query("SELECT candidate_id, first_name, last_name FROM candidates WHERE position =  $position");
		return $query->result_array();
	}
	
	public function getPropsForPosition($position){
		$query = $this->db->query("SELECT proposition_id, proposition_description FROM propositions WHERE position = $position");
		return $query->result_array();
	}
	
	public function getAllCandidates($electionID){
		$query = $this->db->query("SELECT candidate_id, first_name, last_name, description FROM ballots NATURAL JOIN candidates WHERE election_id = $electionID");
		return $query->result_array();
	}
		
	public function getCandidate($userID){
		$query = $this->db->query("SELECT candidate_id, description, position, first_name, last_name FROM candidates WHERE uacc_id = $userID");
		return $query->row_array();
	}
	
	public function updateCandidateDescription($userID){
		$description = $this->input->post('description_field');
		$this->db->query("UPDATE candidates SET description = \"$description\" WHERE uacc_id = $userID");
	}
	
	public function getPendingUsers(){
		$query = $this->db->query("SELECT DISTINCT uacc_id, uacc_group_fk, uacc_firstname, uacc_lastname, uacc_major FROM user_accounts WHERE uacc_active = 0");
		return $query->result_array();
	}
	
	public function getPendingVoter($userID){
		$query = $this->db->query("SELECT DISTINCT election_title FROM voting_eligibility NATURAL JOIN elections WHERE uacc_id = $userID");
		return $query->row_array();
	}
	
	public function getPendingCandidate($userID){
		$query = $this->db->query("SELECT DISTINCT election_title, title FROM elections NATURAL JOIN (SELECT election_id, title FROM ballots NATURAL JOIN candidates WHERE uacc_id = $userID) AS alpha");
		return $query->row_array();
	}
	
	public function checkUserVoted($userID){
		$query = $this->db->query("SELECT position, vote_type, candidate_id, proposition_id, first_name, last_name FROM votes WHERE uacc_id = $userID");
		//user voted if info is returned; user did not vote if empty
		return $query->results_array();
	}
	
	public function getElectionDescription($electionID){
		$query = $this->db->query("SELECT description FROM elections WHERE election_id = $electionID");
		$result = $query->row_array();
		return $result['description'];
	}
	
	public function getElectionWindow($electionID){
		$query = $this->db->query("SELECT voting_window_start, voting_window_end FROM elections WHERE election_id = $electionID");
		return $query->row_array();
	}
	
	public function addWriteinVote($userID, $position, $first_name, $last_name){
		$this->db->query("INSERT INTO votes (uacc_id, position, vote_type, first_name, last_name) VALUES ($userID, $position, 1, ‘$first_name', ‘$last_name')");
	}
	
	public function addCandidateVote($userID, $position, $candidate_id){
		$this->db->query("INSERT INTO votes (uacc_id, position, vote_type, candidate_id) VALUES ($userID, $position, 0, $candidate_id)");
	}
	
	public function addPropositionVote($userID, $position, $proposition_id){
		$this->db->query("INSERT INTO votes (uacc_id, position, vote_type, proposition_id) VALUES ($uacc_id, $position, 0, $proposition_id)");
	}
	
	public function updateWriteinVote($userID, $position, $first_name, $last_name){
		$this->db->query("UPDATE votes SET vote_type=1, first_name='$first_name', last_name='$last_name' WHERE uacc_id = $userID and position = $position");
	}
	
	public function updateCandidateVote($userID, $position, $candidate_id){
		$this->db->query("UPDATE votes SET vote_type=0, candidate_id=$candidate_id WHERE uacc_id = $userID AND position = $position");
	}
	
	public function updatePropositionVote($userID, $position, $proposition_id){
		$this->db->query("UPDATE votes SET vote_type=0, proposition_id=$proposition_id WHERE uacc_id = $uacc_id AND position = $position");
	}
	
	public function deleteUser($userID){
		$this->load->library('flexi_auth');
		$this->flexi_auth->delete_user($userID);
	}
	
	public function approveUser($userID){
		$this->load->library('flexi_auth');
		$this->flexi_auth->activate_user($userID);
	}
	
	public function approveCandidate($userID){
		$this->db->query("UPDATE candidates SET approved = 1 WHERE uacc_id = $userID");
	}
}
?>