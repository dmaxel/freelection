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
	
	public function getVotesByHour($election_id, $begin_date_time, $end_date_time) {
		$query = $this->db->query("select count(distinct uacc_id) from votes where date_time between '$begin_date_time' and '$end_date_time' and position in (select position from ballots where election_id = '$election_id')");
		$result = $query->row_array();
		return $result["count(distinct uacc_id)"];
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

			$data['votes_by_hour'][$i] = (int) $this->getVotesByHour($data['election_id'], $interval_start, $interval_end);
			$data['vote_count_labels'][$i] = $label;
	
		}
		
        // echo '<pre>';
		// var_dump($data);
        // echo '</pre>';
        // exit;
        $this->load->view('monitor', $data);
        $this->load->view('templates/footer');
    }
    

    

}
?>
