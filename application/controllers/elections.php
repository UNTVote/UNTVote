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
	}

	// index - default election page, shows all the elections
	public function index()
	{
		// grab all the elections in the system
		$elections = $this->election_model->GetElections();
		// grab all active elections in the system
		$activeElections = $this->election_model->GetElectionsByStatus("active");

		$title = "Elections Archive";

		$data['title'] = $title;
		$data['elections'] = $elections;
		$data['activeElections'] = $activeElections;

		//$this->load->view('templates/header', $data);
		$this->load->view('elections/index', $data);
		//$this->load->view('templates/footer');
	}

	// view - takes in a slug which is the elections we need to view
	public function view($slug)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		// grab the election data for this one election
		$election = $this->election_model->GetElections($slug);
		// grab the candidates from the election
		// first get the elections ID from the elections slug
		$electionID = $this->election_model->GetElectionIDBySlug($slug);
		$candidates = $this->election_model->GetElectionCandidates($electionID);

		foreach($candidates as $candidate)
		{
			if($this->input->post($candidate['candidate_id']))
			{
				redirect('user/', 'refresh');
			}
		}

		if(empty($election))
		{
			show_404();
		}
		$title = $election['election_name'];
		$data['election'] = $election;
		$data['title'] = $title;
		$data['candidates'] = $candidates;

		//$this->load->view('templates/header', $data);
		$this->load->view('elections/view_election', $data);
		//$this->load->view('templates/footer');

	}

	// create - check whether the form was submitted and if it passed the validation rules.  Then create the election
	public function create()
	{
		// load the form helper and form validation library
		$this->load->helper('form');
		$this->load->library('form_validation');

		$title = "New Election";

		// get all the colleges for the admin to select from
		$colleges = $this->ion_auth->colleges()->result_array();

		// the rules of the form
		// the title, description, start and end date, college are required
		$this->form_validation->set_rules('electionName', 'Election Name', 'required');
		$this->form_validation->set_rules('electionDescription', 'Election Description', 'required');
		$this->form_validation->set_rules('electionStart', 'Start Date', 'required');
		$this->form_validation->set_rules('electionEnd', 'End Date', 'required');
		$this->form_validation->set_rules('electionCollege', 'College', 'required');

		$data['title'] = $title;
		$data['colleges'] = $colleges;

		// form was not submitted, show the form
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('elections/create_election', $data);
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