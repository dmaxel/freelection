<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Election_Results extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	    $this->auth = new stdClass;
		$this->load->model('general_model');
	}
	
	public function index(){
		$userID = $this->general_model->getUserID();
		
		$realName = $this->general_model->getRealName($userID);
		$data['username'] = $realName['uacc_firstname']." ".$realName['uacc_lastname'];
        $this->load->view('templates/header', $data);
		
		$electionID = $this->general_model->getElectionID($userID);
		$data['positions'] = $this->general_model->getPositionsForElection($electionID);
		$data['list'] = array();
		foreach($data['positions'] as $position)
		{
			$data['list'][$position['position']] = $this->general_model->getWinner($position['position']);
		}
		$this->load->view('election_results', $data);
		$this->load->view('templates/footer');
	}
}