<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voter extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	   $this->auth = new stdClass;
		$this->load->model('general_model');
	}
	public function getVotesByHour($election_id, $begin_date_time, $end_date_time) {
		$query = $this->db->query("select count(distinct uacc_id) from votes where date_time between '$begin_date_time' and '$end_date_time' and position in (select position from ballots where election_id = '$election_id')");
		$result = $query->row_array();
		return $result["count(distinct uacc_id)"];
	}
	
	// Redirect to voter page if the user is actually a voter
	public function index(){
    
      // check if logged in as voter
		$loggedIn = $this->general_model->checkIfLoggedIn();
		$groupID = $this->general_model->getGroupID();
        
      // redirect to homepage if not logged in or incorrect id
		if($loggedIn === FALSE || $groupID !== 4)
      {
      	redirect('');
		}
		else
		{
			$userID = $this->general_model->getUserID();
			$electionID = $this->general_model->getElectionID($userID);
			$data['registration_window'] = $this->general_model->getRegistrationWindow($electionID);
			$data['election_window'] = $this->general_model->getElectionWindow($electionID);
			// If the election is in the voting or registration window, go to the normal page
			if(strtotime($data['registration_window']['registration_window_start']) < time() && strtotime($data['election_window']['voting_window_end']) > time()){
				$this->showPage();
			}
			// Otherwise go to the election results page
			else{
				redirect('/election_results/showForVoter');
			}
		}
	}

	// Load the contents of the voter page
	public function showPage(){
		$userID = $this->general_model->getUserID();

		$realName = $this->general_model->getRealName($userID);
		$data['username'] = $realName['uacc_firstname']." ".$realName['uacc_lastname'];
		
        
      // load the view
      $this->load->view('templates/header', $data);
		
		$userID = $this->general_model->getUserID();
		// Get the election the user is allowed to vote for
		$electionID = $this->general_model->getElectionID($userID);
		// Show the candidates that are in that election (if any)
		if($this->input->post('available_candidates'))
		{
			$data['selected_candidate'] = $this->input->post('available_candidates');
		}
		else
		{
			$data['selected_candidate'] = -1;
		}
		$data['candidates'] = $this->general_model->getAllCandidates($electionID);
		// Get the election description and the election window
		$data['election_description'] = $this->general_model->getElectionDescription($electionID);
		$data['election_window'] = $this->general_model->getElectionWindow($electionID);
		
		// get previous 24 hours time-windows from current time
		$date = new DateTime;

		// subtract a day and add an hour to get start time for graph
		$date->sub(new DateInterval('P1D'));
		$date->add(new DateInterval('PT1H'));
		$graph_time = $date->format("Y-m-d H:00:00");
		$graph_time = new DateTime($graph_time);
		
		$data['votes_by_hour'] = array();
		$data['vote_count_labels'] = array();
		
		for ($i = 0; $i < 24; $i++)
		{
			$interval_start = $graph_time->format("Y-m-d H:i:s");
			$label = date("gA", strtotime($interval_start)) . "-";
			
			// increment by 1 hour
			$graph_time->add(new DateInterval('PT1H'));
			
			$interval_end = $graph_time->format("Y-m-d H:i:s");
			$label = $label . date("gA", strtotime($interval_end));

			$data['votes_by_hour'][$i] = (int) $this->getVotesByHour($electionID, $interval_start, $interval_end);
			$data['vote_count_labels'][$i] = $label;
	
		}
		$this->load->view('voter', $data);
		
	}

	// Load the voting window with the ballot information for that election
	public function voteNow(){
		$userID = $this->general_model->getUserID();
		$electionID = $this->general_model->getElectionID($userID);
		$data['election_window'] = $this->general_model->getElectionWindow($electionID);
		// If the election is in the voting window, allow the voter to vote
		if(strtotime($data['election_window']['voting_window_start']) < time() && strtotime($data['election_window']['voting_window_end']) > time()){
			$userID = $this->general_model->getUserID();

			$realName = $this->general_model->getRealName($userID);
			$data['username'] = $realName['uacc_firstname']." ".$realName['uacc_lastname'];
			
			$this->load->view('templates/header', $data);
			
			$userID = $this->general_model->getUserID();
			// Get the list of positions for the election
			$data['positions'] = $this->general_model->getPositions($userID);
			$data['list'] = array();
			// For each position, get the list of candidates (or propositions) for that position
			foreach($data['positions'] as $positions)
			{
				$position_id = $positions['position'];
				if($positions['type'] == 0)
				{
					$data['list'][$position_id] = $this->general_model->getCandidatesForPosition($position_id);
				}
				else if($positions['type'] == 1)
				{
					$data['list'][$position_id] = array("Yes", "No");
				}
				else if($positions['type'] == 2)
				{
					$data['list'][$position_id] = $this->general_model->getPropsForPosition($position_id);
				}
			}
			$data['userID'] = $userID;
			$this->load->view('vote_now', $data);
			
			$this->load->view('templates/footer');
		}
		else{
			redirect('/voter');
		}
	}

	// Submit the user's vote information
	public function processBallot(){
		$confirmation_number = $this->generateConfirmationNumber();
		$timestamp = date('Y-m-d H:i:s', time());
		
		$userID = $this->general_model->getUserID();
		// Check if user already voted
		$userTempVoted = $this->general_model->checkUserVoted($userID);
		$userVoted = FALSE;
		if($userTempVoted != NULL)
		{
			$userVoted = TRUE;
		}
		$data['positions'] = $this->general_model->getPositions($userID);
		$data['chosen_candidates'] = array();
		// Submit the vote for each separate position on the ballot
		foreach($data['positions'] as $positions)
		{
			$position = $positions['position'];
			$data['chosen_candidates'][$position]['position_name'] = $positions['title'];
			// Submit a new vote for a normal position
			if($positions['type'] == 0 && $userVoted == FALSE)
			{
				$candidate_id = $this->input->post('choices'.$position);
				// Write-in vote
				if($candidate_id == -1)
				{
					$firstname = $this->input->post($position.'_first_name');
					$lastname = $this->input->post($position.'_last_name');
					$data['chosen_candidates'][$position]['candidate_name'] = $firstname.' '.$lastname;
					$this->general_model->addWriteinVote($userID, $position, $firstname, $lastname, $confirmation_number, $timestamp);
				}
				// Normal candidate selection
				else
				{
					$candidate = $this->general_model->getCandidateByCanID($candidate_id);
					$data['chosen_candidates'][$position]['candidate_name'] = $candidate['first_name']." ".$candidate['last_name'];
					$this->general_model->addCandidateVote($userID, $position, $candidate_id, $confirmation_number, $timestamp);
				}
			}
			// Submit a new vote for a y/n position
			else if($positions['type'] == 1 && $userVoted == FALSE)
			{
				// Add later if needed
			}
			// Submit a new vote for a propositional position
			else if($positions['type'] == 2 && $userVoted == FALSE)
			{
				$proposition_id = $this->input->post('choices'.$position);
				// Write-in propositional vote
				if($proposition_id == -1)
				{
					$description = $this->input->post($position.'_description');
					$this->general_model->addWriteinVote($userID, $position, $description, NULL);
				}
				// Normal propositional selection
				else
				{
					$this->general_model->addPropositionVote($userID, $position, $proposition_id);
				}
			}
			// Submit an overwrite for a normal position
			else if($positions['type'] == 0 && $userVoted == TRUE)
			{
				$candidate_id = $this->input->post('choices'.$position);
				// Write-in vote
				if($candidate_id == -1)
				{
					$firstname = $this->input->post($position.'_first_name');
					$lastname = $this->input->post($position.'_last_name');
					$data['chosen_candidates'][$position]['candidate_name'] = $firstname.' '.$lastname;
					$this->general_model->updateWriteinVote($userID, $position, $firstname, $lastname, $confirmation_number, $timestamp);
				}
				// Normal candidate selection
				else
				{
					$candidate = $this->general_model->getCandidateByCanID($candidate_id);
					$data['chosen_candidates'][$position]['candidate_name'] = $candidate['first_name']." ".$candidate['last_name'];
					$this->general_model->updateCandidateVote($userID, $position, $candidate_id, $confirmation_number, $timestamp);
				}
			}
			// Submit an overwrite for a y/n position
			else if($positions['type'] == 1 && $userVoted == TRUE)
			{
				// Add later if needed
			}
			// Submit an overwrite for a propositional position
			else if($positions['type'] == 2 && $userVoted == TRUE)
			{
				$proposition_id = $this->input->post('choices'.$position);
				// Propositional write-in vote
				if($proposition_id == -1)
				{
					$description = $this->input->post($position.'_description');
					$this->general_model->updateWriteinVote($userID, $position, $description, NULL);
				}
				// Normal proposition selected
				else
				{
					$this->general_model->updatePropositionVote($userID, $position, $proposition_id);
				}
			}
		}
		// Take the voter to the vote confirmation page
		$userID = $this->general_model->getUserID();

		$realName = $this->general_model->getRealName($userID);
		$data['username'] = $realName['uacc_firstname']." ".$realName['uacc_lastname'];
		$this->load->view('templates/header', $data);
		
		$data['confirmation'] = $confirmation_number;
		$this->load->view('votingConfirmation', $data);
		
		$this->load->view('templates/footer');
		//goes back to voter homepage w/ back button
	}
	
	public function generateConfirmationNumber(){
		$alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 6; $i++) {
	        $n = mt_rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
}
?>
