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
                $data['election_options'][$election['election_id']] = $election['election_title'];
            }
        }
        else
        {
            $data['selected_election_id'] = -1;
        }
//$data['selected_election_id'] = 1;
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
        }
        else
            $data['selected_elec_desc'] = "Select an Election";
            
        // check for form input
        if ($this->input->post('election_description'))
        {
            $new_description = $this->input->post('election_description');
            echo $new_description;
            exit;
        }
            
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        // exit;
            
        $this->load->view('templates/header', $data);
        $this->load->view('view_elections', $data);
        $this->load->view('templates/footer');        
    }
}