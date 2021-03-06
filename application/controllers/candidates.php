<?php

// Candidates Controller is for all the logic in viewing candidates
class Candidates extends CI_Controller
{
	// constructor - load the model that we will use
	// - load the URL helper for redirect
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('ion_auth');
		$this->load->model('candidate_model');
		$this->load->model('user_model');
		// the user must be logged in the view the candidates
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('user/login', 'refresh');
		}
	}

	// index - default candidates page that displays all the candidates that we have
	public function index()
	{
		$user = $this->ion_auth->user()->row();
		$title = "Candidates | UNTVote";

		// All the users that are candidates
		$candidates = $this->ion_auth->users(3)->result();

		$data['title'] = $title;
		$data['user'] = $user;
		$data['candidates'] = $candidates;

		$this->load->view('templates/header_user', $data);
        $this->load->view('templates/navigation_user', $data);
		$this->load->view('templates/sidebar_user', $data);
        $this->load->view('candidate/user-candidate-browse', $data);
	    $this->load->view('templates/scripts_main');
        $this->load->view('templates/scripts_custom');
		$this->load->view('templates/footer');
	}

	// View - Views the candidates personal profile
	// Displays their name, what college they are apart of
	// candidateID - The candidate they are viewing
	public function View($candidateID)
	{
		// get the candidate they want to view
		$candidate = $this->ion_auth->user($candidateID)->row();
		$title = $candidate->first_name . "'s Candidate Profile | UNTVote";
		$college = $this->user_model->GetUsersCollege($candidateID);
		$user = $this->ion_auth->user()->row();
		$elections = $this->candidate_model->GetCandidateElections($candidateID);

		$data['title'] = $title;
		$data['candidate'] = $candidate;
		$data['college'] = $college;
		$data['user'] = $user;
		$data['elections'] = $elections;

		$this->load->view('templates/header_user', $data);
		$this->load->view('templates/navigation_user', $data);
		$this->load->view('templates/sidebar_user');
		$this->load->view('candidate/user-candidate-info', $data);
		$this->load->view('templates/scripts_main');
		$this->load->view('templates/footer');
	}

	// Edit - edits the candidate information
	public function Edit()
	{
		// load the form helper and form validation library
		$this->load->helper('form');
		$this->load->library('form_validation');

		// get the candidates information
		$candidate = $this->ion_auth->user()->row();

		// update the users candidate information
		$this->candidate_model->UpdateCandidate($candidate->id);
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		// redirect the user back to their dashboard
		redirect('user', 'refresh');
	}
}