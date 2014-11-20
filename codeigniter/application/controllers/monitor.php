<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends CI_Controller {
    public function getElectionTitle($electionID){
		$query = $this->db->query("SELECT election_title FROM elections WHERE election_id = $electionID");
		$result = $query->row_array();
        return $result['election_title'];
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
    
    public function index(){
        // check if logged in as monitor
        $this->auth = new stdClass;
        $this->load->model('general_model');
        $loggedIn = $this->general_model->checkIfLoggedIn();
        $groupID = $this->general_model->getGroupID();

        // redirect to homepage if not logged in or incorrect id
        if($loggedIn === FALSE || $groupID !== 2)
        {
            redirect('');
        }
		
		$userID = $this->general_model->getUserID();

		$realName = $this->general_model->getRealName($userID);
		$data['username'] = $realName['uacc_firstname']." ".$realName['uacc_lastname'];
		$this->load->view('templates/header', $data);
        
        $data['username'] = $this->general_model->getUsername();  

        // get the election this monitor can view
        $userID = $this->general_model->getUserID();
        $data['election_id'] = $this->general_model->getElectionID($userID);  
        $data['election_description'] = $this->general_model->getElectionDescription($data['election_id']);
        $data['election_window'] = $this->general_model->getElectionWindow($data['election_id']);  
        $data['election_title'] = $this->getElectionTitle($data['election_id']);

        // get all candidates for this election
        $data['candidates'] = $this->general_model->getAllCandidates($data['election_id']);
        
        // get options for candidate drop-down form
        $data['candidate_options'] = array();
        $data['candidate_options'][-1] = "Select a candidate";
        
        foreach ($data['candidates'] as $candidate)
        {
            $data['candidate_options'][$candidate['candidate_id']] = $candidate['first_name'] . " " . $candidate['last_name'];
        }
        
        // check for form input for candidate selection
        if ($this->input->post('candidate_dropdown'))
        {
            $data['selected_candidate_id'] = $this->input->post('candidate_dropdown');
            foreach ($data['candidates'] as $candidate)
                if ($candidate['candidate_id'] == $data['selected_candidate_id'])
                {
                    $data['selected_cand_desc'] = $candidate['description'];
                }
        }
        else
            $data['selected_candidate_id'] = -1;
            
        $data['election_positions'] = $this->general_model->getPositionsForElection($data['election_id']);

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
        
        // echo '<pre>';
        // var_dump($data['election_positions']);
        // echo '</pre>';
        // exit;
        $this->load->view('monitor', $data);
        $this->load->view('templates/footer');
    }
    

    

}
?>
