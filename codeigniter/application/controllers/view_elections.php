<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class View_Elections extends CI_Controller {
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
	
	public function updateElection($election_id, $new_description, $new_registration_start, $new_registration_end, $new_voting_start, $new_voting_end)
	{
		$this->db->query("update elections set description = '$new_description', registration_window_start = '$new_registration_start', registration_window_end = '$new_registration_end', voting_window_start = '$new_voting_start', voting_window_end = '$new_voting_end' where election_id = '$election_id'");
	}
    
    public function index(){
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
            }
        }
        else
        {
            $data['selected_election_id'] = -1;
        };
		if ($this->input->post('current_election'))
			$data['selected_election_id'] = $this->input->post('current_election');
			
		//$data['selected_election_id'] = 1;
		//if an election is selected
        if ($data['selected_election_id'] != -1)
        {
            $data['election_positions'] = $this->general_model->getPositionsForElection($data['selected_election_id']);
            $numPositions = count($data['election_positions']);
            for ($i = 0; $i < $numPositions; $i++)
            {   
                $position_id = $data['election_positions'][$i]['position'];
                $this_pos_candidates = $this->general_model->getCandidatesForPosition($position_id);
                $data['election_positions'][$i]['candidates_list'] = $this_pos_candidates;
            }
			$reg_window = $this->general_model->getRegistrationWindow($data['selected_election_id']);
			$start_time = strtotime($reg_window['registration_window_start']);
			$data['reg_start_day_selected'] = date("Y-m-d", $start_time);
			$data['reg_start_hour_selected'] = date("G", $start_time);
			
			$end_time = strtotime($reg_window['registration_window_end']);
			$data['reg_end_day_selected'] = date("Y-m-d", $end_time);
			$data['reg_end_hour_selected'] = date("G", $end_time);
			
			$election_window = $this->general_model->getElectionWindow($data['selected_election_id']);
			$start_time = strtotime($election_window['voting_window_start']);
			$data['vote_start_day_selected'] = date("Y-m-d", $start_time);
			$data['vote_start_hour_selected'] = date("G", $start_time);
			
			$end_time = strtotime($election_window['voting_window_end']);
			$data['vote_end_day_selected'] = date("Y-m-d", $end_time);
			$data['vote_end_hour_selected'] = date("G", $end_time);
			
			// get election positions + candidates
			$data['election_positions'] = $this->general_model->getPositionsForElection($data['selected_election_id']);
			
			for ($i = 0; $i < count($data['election_positions']); $i++)
			{
				$data['election_positions'][$i]['candidates_list'] = $this->general_model->getCandidatesForPosition($data['election_positions'][$i]['position']);
			}
        }
        else
		{
            $data['selected_elec_desc'] = "Select an Election";
			
			$data['reg_start_day_selected'] = "";
			$data['reg_start_hour_selected'] = 0;
			
			$data['reg_end_day_selected'] = "";
			$data['reg_end_hour_selected'] = 0;
			

			$data['vote_start_day_selected'] = "";
			$data['vote_start_hour_selected'] = 0;
			

			$data['vote_end_day_selected'] = "";
			$data['vote_end_hour_selected'] = 0;
			
		}   
        // check for form input
        if ($this->input->post('election_description'))
        {
			$electionID = $this->input->post('current_election');
		
            $new_description = $this->input->post('election_description');
			
			$new_reg_start_day = $this->input->post('registration_start');
			$new_reg_start_hour = $this->input->post('reg_hour_start_dropdown');
			$new_reg_end_day = $this->input->post('registration_end');
			$new_reg_end_hour = $this->input->post('reg_hour_end_dropdown');
			
			
			$new_vote_start_day = $this->input->post('election_start');
			$new_vote_start_hour = $this->input->post('vote_hour_start_dropdown');
			$new_vote_end_day = $this->input->post('election_end');
			$new_vote_end_hour = $this->input->post('vote_hour_end_dropdown');
			
			$new_reg_start = $new_reg_start_day . ' ' . sprintf("%02d:00:00", $new_reg_start_hour);
			$new_reg_end = $new_reg_end_day . ' ' . sprintf("%02d:00:00", $new_reg_end_hour);
			$new_vote_start = $new_vote_start_day . ' ' . sprintf("%02d:00:00", $new_vote_start_hour);
			$new_vote_end = $new_vote_end_day . ' ' . sprintf("%02d:00:00", $new_vote_end_hour);
			
			$this->updateElection($electionID, trim($new_description), $new_reg_start, $new_reg_end, $new_vote_start, $new_vote_end);
			redirect(current_url(), ‘refresh’);
        }
		// create time form options
		for ($i = 0; $i <=23; $i++)
		{
			if ($i < 10)
			$data['hour_options'][$i] = "0". $i . ":00";
			else
			$data['hour_options'][$i] = $i . ":00";
		}
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        // exit;
            
        $this->load->view('templates/header', $data);
        $this->load->view('view_elections', $data);     
    }
	
	public function delete_election($electionID)
	{
		if ($electionID != -1)
		{
			$this->db->query("delete from elections where election_id = '$electionID'");
		}
		redirect('/view_elections');
	}
}