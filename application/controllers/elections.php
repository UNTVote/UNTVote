<?php

// Election Controller is for all the logic in an election
class Elections extends CI_Controller
{
	// constructor - load the model that we will use
	// - load the URL helper for redirect
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('election_model');

		$this->election_model->UpdateElections();

		// the user must be logged in the view the elections
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('user/login', 'refresh');
		}
	}

	// index - default election page, shows all the elections
	public function index()
	{
		// grab all the elections in the system
		//$elections = $this->election_model->GetElections();
		// grab all active elections in the system
		$activeElections = $this->election_model->GetElectionsByStatus("Active");
		$title = "Elections Archive";

		$data['title'] = $title;
		//$data['elections'] = $elections;
		$data['activeElections'] = $activeElections;

		//$this->load->view('templates/header', $data);
		$this->load->view('elections/index', $data);
		//$this->load->view('templates/footer');
	}

	// view - takes in a slug which is the elections we need to view
	public function view($slug)
	{
		// grab the election data for this one election
		$election = $this->election_model->GetElections($slug);
		// we don't know what the election is, or it is not an election they can vote on
		if(empty($election) || ($election['status'] != 'Active'))
		{
			show_404();
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		// validation that they picked a candidate
		$this->form_validation->set_rules('candidate', 'Candidate Selection', 'required');
		// grab the candidates from the election
		$electionID = $election['id'];
		$candidates = $this->election_model->GetElectionCandidates($electionID);
		// the current user
		$user = $this->ion_auth->user()->row();

		$title = $election['election_name'];
		$data['election'] = $election;
		$data['title'] = $title;
		$data['candidates'] = $candidates;

		// if the form failed to run
		if($this->form_validation->run() === FALSE)
		{
			//$this->load->view('templates/header', $data);
			$this->load->view('elections/view_election', $data);
			//$this->load->view('templates/footer');
		}
		else
		{
			// we now know the user tried to vote
			// send the user who voted, and the election
			$this->election_model->Vote($user->id, $electionID);
			redirect('elections/');

		}

	}

	// create - check whether the form was submitted and if it passed the validation rules.  Then create the election
	public function create()
	{
		// must be an admin to create an election
		if(!$this->ion_auth->is_admin())
		{
			// redirect them to their dashboard
			redirect('/', 'refresh');
		}
		// load the form helper and form validation library
		$this->load->helper('form');
		$this->load->library('form_validation');

		$user = $this->ion_auth->user()->row();

		$title = "New Election";

		// get all the colleges for the admin to select from
		$colleges = $this->ion_auth->colleges()->result_array();
		// get the users that can be candidates
		$candidates = $this->ion_auth->users(3)->result_array();

		// the rules of the form
		// the title, description, start and end date, college are required
		$this->form_validation->set_rules('electionName', 'Election Name', 'required');
		$this->form_validation->set_rules('electionDescription', 'Election Description', 'required');
		$this->form_validation->set_rules('electionStart', 'Start Date', 'required');
		$this->form_validation->set_rules('electionEnd', 'End Date', 'required');
		$this->form_validation->set_rules('electionCollege', 'College', 'required');
		$this->form_validation->set_rules('electionCandidates', 'Candidates', 'required');

		$data['user'] = $user;
		$data['title'] = $title;
		$data['colleges'] = $colleges;
		$data['candidates'] = $candidates;

		// form was not submitted, show the form
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header_create_election', $data);
        	$this->load->view('templates/navigation_admin', $data);
			$this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/admin-create-election', $data);
			$this->load->view('templates/scripts_main');
            $this->load->view('templates/scripts_custom');
			$this->load->view('templates/footer');
		}
		// form was submitted - create the election, redirect to the admins page
		else
		{
			$this->election_model->CreateElection();
			redirect('admin/');
		}
	}
}