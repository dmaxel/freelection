<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voter extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	   $this->auth = new stdClass;
		$this->load->model('general_model');
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
		$timestamp = (new DateTime)->format("Y-m-d H:i:s");
		
		$userID = $this->general_model->getUserID();
		// Check if user already voted
		$userTempVoted = $this->general_model->checkUserVoted($userID);
		$userVoted = FALSE;
		if($userTempVoted != NULL)
		{
			$userVoted = TRUE;
		}
		$data['positions'] = $this->general_model->getPositions($userID);
		$data['candidates'] = array();
		foreach($data['positions'] as $positions)
		{
			$data['candidates'][$positions['position']] = $this->general_model->getCandidatesForPosition($positions['position']);
		}
		$data['chosen_candidates'] = array();
		// Submit the vote for each separate position on the ballot
		foreach($data['positions'] as $positions)
		{
			$data['chosen_candidates'][$positions['position']]['position_name'] = $positions['title'];
			// Submit a new vote for a normal position
			if($positions['type'] == 0 && $userVoted == FALSE)
			{
				$position = $positions['position'];
				$candidate_id = $this->input->post('choices'.$positions['position']);
				$data['chosen_candidates'][$positions['position']] = $candidate_id;
				// Write-in vote
				if($candidate_id == -1)
				{
					$firstname = $this->input->post($positions['position'].'_first_name');
					$lastname = $this->input->post($positions['position'].'_last_name');
					$data['chosen_candidates'][$positions['position']]['candidate_name'] = $firstname.' '.$lastname;
					$this->general_model->addWriteinVote($userID, $position, $firstname, $lastname, $confirmation_number);
				}
				// Normal candidate selection
				else
				{
					$data['chosen_candidates'][$positions['position']]['candidate_name'] = $data['candidates'][$positions['position']]['first_name']." ".$data['candidates'][$positions['position']]['last_name'];
					$this->general_model->addCandidateVote($userID, $position, $candidate_id, $confirmation_number);
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
				$position = $positions['position'];
				$proposition_id = $this->input->post('choices'.$positions['position']);
				// Write-in propositional vote
				if($proposition_id == -1)
				{
					$description = $this->input->post($positions['position'].'_description');
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
				$position = $positions['position'];
				$candidate_id = $this->input->post('choices'.$positions['position']);
				// Write-in vote
				if($candidate_id == -1)
				{
					$firstname = $this->input->post($positions['position'].'_first_name');
					$lastname = $this->input->post($positions['position'].'_last_name');
					$data['chosen_candidates'][$positions['position']]['candidate_name'] = $firstname.' '.$lastname;
					$this->general_model->updateWriteinVote($userID, $position, $firstname, $lastname, $confirmation_number);
				}
				// Normal candidate selection
				else
				{
					$data['chosen_candidates'][$positions['position']]['candidate_name'] = $data['candidates'][$positions['position']['first_name']." ".$data['candidates'][$positions['position']['last_name'];
					$this->general_model->updateCandidateVote($userID, $position, $candidate_id, $confirmation_number);
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
				$position = $positions['position'];
				$proposition_id = $this->input->post('choices'.$positions['position']);
				// Propositional write-in vote
				if($proposition_id == -1)
				{
					$description = $this->input->post($positions['position'].'_description');
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
