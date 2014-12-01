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
	
	public function entry_insert($username, $password, $type, $election, $position, $firstname, $lastname, $email, $major, $activate){
		$this->load->library('flexi_auth');
		$user_data = array(
			'uacc_firstname' => $firstname,
			'uacc_lastname' => $lastname,
			'uacc_major' => $major
		);
		if($type == 3)
		{
			$new_userID = $this->flexi_auth->insert_user($email, $username, $password, $user_data, $type, $activate);
			
			$t_activate = NULL;
			if($activate == TRUE)
			{
				$t_activate = 1;
			}
			else
			{
				$t_activate = 0;
			}
			
			$this->db->query("INSERT INTO candidates (position, approved, first_name, last_name, uacc_id, description) VALUES ($position, $t_activate, '$firstname', '$lastname', $new_userID, 'No description yet')");
		}
		else
		{
			$new_userID = $this->flexi_auth->insert_user($email, $username, $password, $user_data, $type, $activate);
			
			if($type == 2 || $type == 4)
			{
				$positions = $this->getPositionsForElection($election);
				foreach($positions as $each)
				{
					$_position = $each['position'];
					$this->db->query("INSERT INTO voting_eligibility (position, uacc_id) VALUES ($_position, $new_userID)");
				}
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
	
	public function getUserInfo($userID){
		$query = $this->db->query("SELECT uacc_id, uacc_username, uacc_firstname, uacc_lastname, uacc_major, uacc_email, uacc_group_fk FROM user_accounts WHERE uacc_id = $userID");
		return $query->row_array();
	}
	
	public function getElectionID($userID){
		$query = $this->db->query("SELECT DISTINCT b.election_id FROM ballots b, voting_eligibility v WHERE v.position = b.position AND v.uacc_id = $userID");
		$result = $query->row_array();
		return $result['election_id'];
	}
	
	public function getElectionTitle($userID, $userType){
		$query = NULL;
		if($userType == 2 || $userType == 4)
		{
			$query = $this->db->query("SELECT DISTINCT election_title FROM elections NATUAL JOIN ballots NATURAL JOIN voting_eligibility WHERE uacc_id = $userID");
		}
		else if($userType == 3)
		{
			$query = $this->db->query("SELECT election_title FROM elections NATURAL JOIN (SELECT election_id FROM ballots NATURAL JOIN candidates WHERE uacc_id = $userID) alpha");
		}
		$result = $query->row_array();
		return $result['election_title'];
	}

	public function getElectionIDFromCandidate($userID){
		$query = $this->db->query("SELECT DISTINCT b.election_id FROM ballots b, candidates c WHERE c.position = b.position AND c.uacc_id = $userID");
		$result = $query->row_array();
		return $result['election_id'];
	}
	
	public function getActiveUsers(){
		$query = $this->db->query("SELECT * FROM (SELECT uacc_firstname, uacc_lastname, election_title, uacc_group_fk, uacc_id FROM user_accounts NATURAL JOIN (SELECT DISTINCT uacc_id, election_title FROM voting_eligibility NATURAL JOIN (SELECT a.position, election_title FROM ballots AS a NATURAL JOIN elections) AS alpha) AS bravo WHERE uacc_active = 1) AS epsilon UNION (SELECT uacc_firstname, uacc_lastname, election_title, uacc_group_fk, uacc_id FROM user_accounts NATURAL JOIN (SELECT uacc_id, election_title FROM candidates NATURAL JOIN (SELECT a.position, election_title FROM ballots AS a NATURAL JOIN elections) AS charlie) AS delta WHERE uacc_active = 1)");
		return $query->result_array();
	}
	
    public function getAdmins(){
        $query = $this->db->query("SELECT uacc_firstname, uacc_lastname, uacc_group_fk, uacc_id FROM user_accounts WHERE uacc_group_fk = 1");
        return $query->result_array();
    }
	
	/* this function is should work for Admin and monitor*/
	public function getElectionInfoList(){
		$query = $this->db->query("SELECT election_id, election_title, description, voting_window_start, voting_window_end, registration_window_start, registration_window_end FROM elections");
		return $query->result_array();
	}
	
	public function getPositions($userID){
		$query = $this->db->query("SELECT position, type, title, write_ins FROM ballots NATURAL JOIN voting_eligibility WHERE uacc_id = $userID");
		return $query->result_array();
	}
	
	public function getPosition($positionID){
		$query = $this->db->query("SELECT title FROM ballots WHERE position = $positionID");
		return $query->row_array();
	}
	
	public function getPositionsForElection($election_id){
		$query = $this->db->query("SELECT position, type, title FROM ballots WHERE election_id = $election_id");
		return $query->result_array();
	}
	
	public function getCandidatesForPosition($position){
		$query = $this->db->query("SELECT candidate_id, first_name, last_name FROM candidates WHERE position = $position AND approved = 1");
		return $query->result_array();
	}
	
	public function getPositionsForCandidate($userID){
		$query = $this->db->query("SELECT position, type, title FROM ballots NATURAL JOIN (SELECT election_id FROM ballots NATURAL JOIN candidates WHERE uacc_id = $userID) as alpha");
		return $query->result_array();
	}
	
	public function getPropsForPosition($position){
		$query = $this->db->query("SELECT proposition_id, proposition_description FROM propositions WHERE position = $position");
		return $query->result_array();
	}
	
	public function getAllCandidates($electionID){
		$query = $this->db->query("SELECT candidate_id, first_name, last_name, description FROM ballots NATURAL JOIN candidates WHERE approved = 1 AND election_id = $electionID");
		return $query->result_array();
	}
		
	public function getCandidate($userID){
		$query = $this->db->query("SELECT candidate_id, description, position, first_name, last_name FROM candidates WHERE uacc_id = $userID");
		return $query->row_array();
	}
	
	public function getCandidateByCanID($candidate_id){
		$query = $this->db->query("SELECT candidate_id, description, position, first_name, last_name FROM candidates WHERE candidate_id = $candidate_id");
		return $query->row_array();
	}
	
	public function updateCandidateDescription($userID){
		$description = $this->input->post('description_field');
		$this->db->query("UPDATE candidates SET description = '$description' WHERE uacc_id = $userID");
	}
	
	public function updateUser($userID, $userGroup, $firstname, $lastname, $major, $email, $position, $description){
		$this->db->query("UPDATE user_accounts SET uacc_email='$email', uacc_major='$major', uacc_firstname='$firstname', uacc_lastname='$lastname' WHERE uacc_id=$userID");
		if($userGroup == 3)
		{
			$this->db->query("UPDATE candidates SET position=$position, description=\"$description\" where uacc_id=$userID");
		}
	}
	
	public function getPendingUsers(){
		$query = $this->db->query("SELECT DISTINCT uacc_id, uacc_group_fk, uacc_firstname, uacc_lastname, uacc_major FROM user_accounts WHERE uacc_active = 0");
		return $query->result_array();
	}
	
	public function getPendingVoter($userID){
		$query = $this->db->query("SELECT DISTINCT election_title FROM voting_eligibility NATURAL JOIN ballots NATURAL JOIN elections WHERE uacc_id = $userID");
		return $query->row_array();
	}
	
	public function getPendingCandidate($userID){
		$query = $this->db->query("SELECT DISTINCT election_title, title FROM elections NATURAL JOIN (SELECT election_id, title FROM ballots NATURAL JOIN candidates WHERE uacc_id = $userID) AS alpha");
		return $query->row_array();
	}
	
	public function checkUserVoted($userID){
		$query = $this->db->query("SELECT position, vote_type, candidate_id, proposition_id, first_name, last_name FROM votes WHERE uacc_id = $userID");
		//user voted if info is returned; user did not vote if empty
		return $query->result_array();
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
    
    public function getRegistrationWindow($electionID){
		$query = $this->db->query("SELECT registration_window_start, registration_window_end FROM elections WHERE election_id = $electionID");
		return $query->row_array();
	}
	
	public function addWriteinVote($userID, $position, $first_name, $last_name, $confirmation, $timestamp){
		$this->db->query("INSERT INTO votes (uacc_id, position, vote_type, first_name, last_name, confirmation_number, date_time) VALUES ($userID, $position, 1, ‘$first_name', ‘$last_name', '$confirmation', '$timestamp')");
	}
	
	public function addCandidateVote($userID, $position, $candidate_id, $confirmation, $timestamp){
		$this->db->query("INSERT INTO votes (uacc_id, position, vote_type, candidate_id, confirmation_number, date_time) VALUES ($userID, $position, 0, $candidate_id, '$confirmation', '$timestamp')");
	}
	
	public function addPropositionVote($userID, $position, $proposition_id, $confirmation, $timestamp){
		$this->db->query("INSERT INTO votes (uacc_id, position, vote_type, proposition_id, confirmation_number, date_time) VALUES ($uacc_id, $position, 0, $proposition_id, '$confirmation', '$timestamp')");
	}
	
	public function updateWriteinVote($userID, $position, $first_name, $last_name, $confirmation, $timestamp){
		$this->db->query("UPDATE votes SET vote_type=1, first_name='$first_name', last_name='$last_name', confirmation_number='$confirmation', date_time='$timestamp' WHERE uacc_id = $userID and position = $position");
	}
	
	public function updateCandidateVote($userID, $position, $candidate_id, $confirmation, $timestamp){
		$this->db->query("UPDATE votes SET vote_type=0, candidate_id=$candidate_id, confirmation_number='$confirmation', date_time='$timestamp' WHERE uacc_id = $userID AND position = $position");
	}
	
	public function updatePropositionVote($userID, $position, $proposition_id, $confirmation, $timestamp){
		$this->db->query("UPDATE votes SET vote_type=0, proposition_id=$proposition_id, confirmation_number='$confirmation', date_time='$timestamp' WHERE uacc_id = $uacc_id AND position = $position");
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
	
	public function getWinner($positionID){
		$query = $this->db->query("SELECT first_name, last_name, max(votes) FROM (SELECT first_name, last_name, sum(uacc_vote_weight) AS votes FROM candidates NATURAL JOIN (SELECT candidate_id, uacc_vote_weight FROM votes NATURAL JOIN user_accounts WHERE position = $positionID AND vote_type = 0) AS alpha GROUP BY candidate_id) AS bravo");
		return $query->row_array();
	}
	
	public function getVotesByConfirm($confirmation){
		$query = $this->db->query("SELECT * FROM votes WHERE confirmation_number = '$confirmation'");
		return $query->result_array();
	}
	
	public function getUsersNoVote($election_id){
		$query = $this->db->query("select distinct uacc_email from voting_eligibility natural join user_accounts natural join ballots where uacc_group_fk=4 and election_id=$election_id and uacc_id not in (select distinct uacc_id from votes natural join ballots where election_id=$election_id)");
		return $query->result_array();
	}
	
	public function getLastEmailed($electionID){
		$query = $this->db->query("SELECT last_emailed FROM elections WHERE election_id = $electionID");
		return $query->row_array();
	}
}
?>
