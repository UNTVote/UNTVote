<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate_Model extends CI_Model
{
	// constructor - sets up the model, load the database, and libraries
    public function __construct()
    {
        $this->load->database();
        $this->load->library('ion_auth');
        $this->load->model('ion_auth_model');
    }

    // UpdateCandidate - Updates the current users candidate information
    // candidateID - the candidate that we are updating
    public function UpdateCandidate($candidateID)
    {
    	// get the fields
    	$aboutMe = $this->input->post('aboutMe');
    	$goals = $this->input->post('candidateGoals');

    	$data = array('about_me' => $aboutMe,
    				  'goals'    => $goals);

    	// update the candidate
    	$this->db->where('id', $candidateID);
    	$this->db->update('users', $data);
    	$this->ion_auth_model->set_message('candidate_profile_updated');
    }
}