<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    $this->auth = new stdClass;
		$this->load->model('general_model');
        
        // check if logged in as admin
		$loggedIn = $this->general_model->checkIfLoggedIn();
		$groupID = $this->general_model->getGroupID();
        
        // redirect to homepage if not logged in or incorrect id
        if($loggedIn === FALSE || $groupID !== 1)
        {
            redirect('');
        }
	}
        public function getPositionVotes($position) {
        $query = $this->db->query("select first_name, last_name, sum(uacc_vote_weight) from candidates natural join (select candidate_id, uacc_vote_weight from votes natural join user_accounts where position = $position and vote_type = 0) as alpha group by candidate_id");
        return $query->result_array();
    }
    
    public function getWriteInVotes($position) {
        $query = $this->db->query("select sum(uacc_vote_weight) from votes natural join user_accounts where vote_type = 1 and position = $position");
        $result = $query->row_array();
        return $result["sum(uacc_vote_weight)"];
    }
    public function getElectionTitle($electionID){
		$query = $this->db->query("SELECT election_title FROM elections WHERE election_id = $electionID");
		$result = $query->row_array();
        return $result['election_title'];
	}
	public function index(){
    ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
        $data['username'] = $this->general_model->getUsername();
        // get all the elections
        $data['elections'] = $this->general_model->getElectionInfoList();
        
        $data['election_options'] = array();
        $data['election_options'][-1] = "Select an Election";
        
        foreach ($data['elections'] as $election)
        {
            $data['election_options'][$election['election_id']] = $election['election_title'];
        }
        
        // check for form input for election selection
        if($this->input->post('election_dropdown'))
        {   
            $data['selected_election_id'] = $this->input->post('election_dropdown');
            
            foreach ($data['elections'] as $election)
                if ($election['election_id'] == $data['selected_election_id'])
                {
                    $data['selected_ele_desc'] = $election['description'];
                    $data['election_description'] = $this->general_model->getElectionDescription($election['election_id']);
                    $data['election_window'] = $this->general_model->getElectionWindow($election['election_id']);
                    $data['election_title'] = $this->getElectionTitle($election['election_id']);
                }
        }
        else
        {
            $data['selected_election_id'] = -1;
        }
        
        if ($data['selected_election_id'] != -1)
        {
            $data['election_positions'] = $this->general_model->getPositionsForElection($data['selected_election_id']);

            // get list of candidates for each position;
            $numPositions = count($data['election_positions']);
            for ($i = 0; $i < $numPositions; $i++)
            {   
                $position_id = $data['election_positions'][$i]['position'];
                $this_pos_candidates = $this->general_model->getCandidatesForPosition($position_id);
                $data['election_positions'][$i]['candidates_list'] = $this_pos_candidates;
            }

            // get the vote counts for each position
            $i = 0;
            foreach ($data['election_positions'] as $position)
            {
                $vote_dist = $this->getPositionVotes($position['position']);
                $data['election_positions'][$i]['votes'] = $vote_dist;
                
                // get write in vote count for this position
                $write_in_votes = $this->getWriteInVotes($position['position']);
                if ($write_in_votes != NULL)
                    $data['election_positions'][$i]['writein_votes'] = $write_in_votes;
                else
                    $data['election_positions'][$i]['writein_votes'] = NULL;
                $i++;
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('admin', $data);
        $this->load->view('templates/footer');

	}
	
    public function view_users() {
		$data['username'] = $this->general_model->getUsername();
        $this->load->view('templates/header', $data);
		
		$data['users'] = $this->general_model->getActiveUsers();
        $this->load->view('view_users', $data);
        $this->load->view('templates/footer');
    }
    
    public function view_pending() {
        
		$data['username'] = $this->general_model->getUsername();
        $this->load->view('templates/header', $data);
		
		$pending_users = $this->general_model->getPendingUsers();
		$data['p_user'] = array();
		foreach($pending_users as $pendingUser)
		{
			$userID = $pendingUser['uacc_id'];
			if($pendingUser['uacc_group_fk'] == 3)
			{
				$temp = $this->general_model->getPendingCandidate($userID);
				$data['p_user'][] = array_merge($pendingUser, $temp);
			}
			else if($pendingUser['uacc_group_fk'] == 4)
			{
				$temp = $this->general_model->getPendingVoter($userID);
				$data['p_user'][] = array_merge($pendingUser, $temp);
			}
		}
        $this->load->view('view_pending', $data);
		
        $this->load->view('templates/footer');
    }
    
    public function view_elections(){
        redirect('/view_elections');
        $data['username'] = $this->general_model->getUsername();
        
        // get all the elections
        $data['elections'] = $this->general_model->getElectionInfoList();
        
        $data['election_options'] = array();
        $data['election_options'][-1] = "Select an Election";

        foreach ($data['elections'] as $election)
        {
            $data['election_options'][$election['election_id']] = $election['election_title'];
        }
        
        if ($this->input->post('election_dropdown'))
        {
            $data['selected_election_id'] = $this->input->post('election_dropdown');
            foreach ($data['elections'] as $election)
            {
                if ($election['election_id'] == $data['selected_election_id'])
                {
                    $data['selected_elec_desc'] = $election['description'];
                }
                $data['election_options'][$election['election_id']] = $election['election_title'];
            }
        }
        else
        {
            $data['selected_election_id'] = -1;
        }
        
        
        
        
        if ($data['selected_election_id'] != -1)
        {
            $data['candidates'] = $this->general_model->getAllCandidates($data['selected_election_id']);
        }
        else
            $data['selected_elec_desc'] = "Select an Election";
            
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        // exit;
            
        $this->load->view('templates/header', $data);
        $this->load->view('view_elections', $data);
        $this->load->view('templates/footer');        
    }

    public function new_user(){
        $data['username'] = $this->general_model->getUsername();
        $this->load->view('templates/header', $data);
        $this->load->view('new_user');
        $this->load->view('templates/footer');
    }
    
	public function edit_user($userID){
		$data['username'] = $this->general_model->getUsername();
        $this->load->view('templates/header', $data);
		
		$data['user'] = $this->general_model->getUserInfo($userID);
		$data['candidate'] = NULL;
		$data['positions'] = NULL;
		if($data['user']['uacc_group_fk'] == 1)
		{
			$data['user']['election_title'] = " ";
		}
		else
		{
			$data['user']['election_title'] = $this->general_model->getElectionTitle($data['user']['uacc_id'], $data['user']['uacc_group_fk']);
		}
		if($data['user']['uacc_group_fk'] == 3)
		{
			$data['candidate'] = $this->general_model->getCandidate($userID);
			$data['positions'] = $this->general_model->getPositionsForCandidate($userID);
		}
        $this->load->view('update_user', $data);
        $this->load->view('templates/footer');
	}
	
	public function update_user($userID){
		$firstname = $this->input->post('firstname_field');
		$lastname = $this->input->post('lastname_field');
		$major = $this->input->post('major_field');
		$email = $this->input->post('email_field');
		$user = $this->general_model->getUserInfo($userID);
		$position = NULL;
		$description = NULL;
		if($user['uacc_group_fk'] == 3)
		{
			$position = $this->input->post('available_positions');
			$description = $this->input->post('description_field');
		}
		$this->general_model->updateUser($user['uacc_id'], $user['uacc_group_fk'], $firstname, $lastname, $major, $email, $position, $description);
		
		redirect('/admin/view_users');
	}

    public function new_election(){
        $data['username'] = $this->general_model->getUsername();
        $this->load->view('templates/header', $data);
        $this->load->view('new_election');
    }
	
	public function approve($userID, $candidate){
		$this->general_model->approveUser($userID);
		if($candidate = 1)
		{
			$this->general_model->approveCandidate($userID);
		}
		redirect('/admin/view_pending');
	}
	
	public function deny($userID){
		$this->general_model->deleteUser($userID);
		redirect('/admin/view_pending');
	}
}
?>
