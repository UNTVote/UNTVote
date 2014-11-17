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
		$this->load->model('notification_model');
		$this->load->model('college_model');

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
		$this->load->library('form_validation');


		$firstName = $this->ion_auth->user()->row()->first_name;
        $this->data['user'] = $this->ion_auth->user()->row();
        $this->data['title'] = $firstName . " | UNTVote";

        // cdn scripts
        $cdnScripts = array('https://www.fuelcdn.com/fuelux/3.1.0/js/fuelux.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js');
        $scripts = array('user-elections-browse.js');

        $this->data['cdnScripts'] = $cdnScripts;
        $this->data['scripts'] = $scripts;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		$this->load->view('templates/header_manage_elections', $this->data);
		$this->load->view('templates/navigation_user', $this->data);
		$this->load->view('templates/sidebar_user', $this->data);
		$this->load->view('user/user-elections-browse', $this->data);
		$this->load->view('templates/scripts_main');
		$this->load->view('templates/scripts_custom', $this->data);
		$this->load->view('templates/footer', $this->data);
	}

	// results - shows the elections results page
	public function results()
	{
		$firstName = $this->ion_auth->user()->row()->first_name;
		$user = $this->ion_auth->user()->row();
        $this->data['user'] = $user;
        $this->data['title'] = $firstName . " | UNTVote";

        // if the user is an admin show all the elections that are closed
        if($this->ion_auth->is_admin())
        {
        	$elections = $this->election_model->GetElectionsByStatus('Closed');
        }
        else
        {
        	// only get them by the current logged in user
        	$elections = $this->election_model->GetElectionsByUser($user->id, 'Closed');
        }

        $scripts = array('vendor/chart.min.js', 'vendor/pdfmake.min.js', 'vendor/vfs_fonts.js', 'admin-elections-results.js');

        $this->data['scripts'] = $scripts;
        $this->data['elections'] = $elections;

        $this->load->view('templates/header_user', $this->data);
        $this->load->view('templates/navigation_admin', $this->data);
        if($this->ion_auth->is_admin())
        {
        	$this->load->view('templates/sidebar_admin');
        }
        else
        {
        	$this->load->view('templates/sidebar_user');
        }
        $this->load->view('admin/admin-elections-results', $this->data);
        $this->load->view('templates/scripts_main');
        $this->load->view('templates/scripts_custom', $this->data);
        $this->load->view('templates/footer');
	}

	// livefeed- shows a livefeed of all the elections currently running
	public function livefeed()
	{
		if(!$this->ion_auth->is_admin())
		{
			show_error("I'm sorry, you must be an administrator to view the live feed");
		}

		$user = $this->ion_auth->user()->row();
        $this->data['user'] = $user;
        $this->data['title'] = "Live Feed | UNTVote";

        $elections = $this->election_model->GetElectionsByStatus('Active');

        $scripts = array('vendor/chart.min.js', 'admin-elections-live-feed.js');

        $this->data['scripts'] = $scripts;
        $this->data['elections'] = $elections;

        $this->load->view('templates/header_user', $this->data);
        $this->load->view('templates/navigation_admin', $this->data);
        $this->load->view('templates/sidebar_admin');
        $this->load->view('admin/admin-elections-live-feed', $this->data);
        $this->load->view('templates/scripts_main');
        $this->load->view('templates/scripts_custom', $this->data);
        $this->load->view('templates/footer');
	}

	// Delete - deletes an election
	// deletes any references of it from the database tables
	// electionID - the election we are going to delete
	public function delete($electionID)
	{
		if(!$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
		}

		$this->election_model->DeleteElection($electionID);
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('admin/', 'refresh');
	}

	// Edit - Edits/updates a certain election
	// electionID - the Election we are editing/updating
	public function edit($electionID)
	{
		// must be an admin to update an election
		if(!$this->ion_auth->is_admin())
		{
			// redirect them to their dashboard
			redirect('/', 'refresh');
		}
		$this->load->helper('form');
		$this->load->library('form_validation');

		// scripts to load
		$cdnScripts = array('http://www.fuelcdn.com/fuelux/3.2.0/js/fuelux.min.js');
		$scripts = array('vendor/parsley.min.js', 'vendor/bootstrap-multiselect.js', 'admin-elections-edit.js');

		$user = $this->ion_auth->user()->row();
		$title = 'Edit Election | UNTVote';
		// the election data
		$election = $this->election_model->GetElection($electionID);
		$colleges = $this->college_model->GetColleges();
		$selectedCollege = $this->election_model->GetElectionCollege($electionID);
		// get the users that can be candidates
		$candidates = $this->ion_auth->users(3)->result_array();
		$selectedCandidates = $this->election_model->GetElectionCandidates($electionID);

		// convert the MySQL date to a date better for the user
		$startDate = date("m-d-Y", strtotime($election['start_time']));
		$endDate = date("m-d-Y", strtotime($election['end_time']));

		$data['user'] = $user;
		$data['title'] = $title;
		$data['election'] = $election;
		$data['colleges'] = $colleges;
		$data['selectedCollege'] = $selectedCollege;
		$data['candidates'] = $candidates;
		$data['selectedCandidates'] = $selectedCandidates;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['cdnScripts'] = $cdnScripts;
		$data['scripts'] = $scripts;

		$this->load->view('templates/header_create_election', $data);
		$this->load->view('templates/navigation_admin', $data);
		$this->load->view('templates/sidebar_admin');
		$this->load->view('admin/admin-edit-election', $data);
		$this->load->view('templates/scripts_main');
        $this->load->view('templates/scripts_custom', $data);
		$this->load->view('templates/footer');
	}

	// the script that runs when an election gets edited
	public function ElectionEdit()
	{
		// the election we are going to edid
		$electionID = $this->input->post('electionID');

		$this->election_model->UpdateElection($electionID);
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('admin/', 'refresh');
	}

	// view - takes in a slug which is the elections we need to view
	public function view($slug)
	{
		// grab the election data for this one election
		$election = $this->election_model->GetElections($slug);
		// we don't know what the election is, or it is not an election they can vote on
		if(empty($election))
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
		$college = $this->election_model->GetElectionCollege($electionID);
		// the current user
		$user = $this->ion_auth->user()->row();

		$title = $election['election_name'] . ' | UNTVote';

		$viewElection = '';
		$requestSent = '';
		$requestVote = '';
		$electionClosed = 'hidden';
		$electionDone = 'hidden';

		if($this->election_model->IsUserRegistered($electionID))
		{
			$requestSent = 'hidden';
			$requestVote = 'hidden';
		}
		else if($this->notification_model->IsElectionNotificationSent($electionID))
		{
			$viewElection = 'hidden';
			$requestVote = 'hidden';
		}
		else
		{
			$viewElection = 'hidden';
			$requestSent = 'hidden';
		}
		if($election['status'] == 'Upcoming')
		{
			$viewElection = 'hidden';
			$electionClosed = '';
		}
		elseif($election['status'] == 'Closed')
		{
			$viewElection = 'hidden';
			$electionDone = '';
		}

		$data['election'] = $election;
		$data['title'] = $title;
		$data['candidates'] = $candidates;
		$data['user'] = $user;
		$data['requestSent'] = $requestSent;
		$data['requestVote'] = $requestVote;
		$data['viewElection'] = $viewElection;
		$data['electionClosed'] = $electionClosed;
		$data['electionDone'] = $electionDone;
		$data['college'] = $college;
		$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		// if the form failed to run
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header_user', $data);
			$this->load->view('templates/navigation_user', $data);
			if($this->ion_auth->is_admin())
			{
				$this->load->view('templates/sidebar_admin');
			}
			else
			{
				$this->load->view('templates/sidebar_user');
			}
			$this->load->view('user/user-elections-details', $data);
			$this->load->view('templates/scripts_main');
			$this->load->view('templates/footer');
		}
		else
		{
			// we now know the user tried to vote
			// send the user who voted, and the election
			if(!$this->election_model->Vote($user->id, $electionID))
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('user/');
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('user/');
			}
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

		// scripts to load
		$cdnScripts = array("https://www.fuelcdn.com/fuelux/3.1.0/js/fuelux.min.js");
		$scripts = array('vendor/parsley.min.js', 'vendor/bootstrap-multiselect.js', 'admin-elections-create.js');

		$user = $this->ion_auth->user()->row();

		$title = "New Election";

		// get all the colleges for the admin to select from
		$colleges = $this->college_model->GetColleges();
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
		$data['cdnScripts'] = $cdnScripts;
		$data['scripts'] = $scripts;

		// form was not submitted, show the form
		if($this->form_validation->run() === FALSE)
		{
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->load->view('templates/header_create_election', $data);
        	$this->load->view('templates/navigation_admin', $data);
			$this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/admin-create-election', $data);
			$this->load->view('templates/scripts_main');
            $this->load->view('templates/scripts_custom', $data);
			$this->load->view('templates/footer');
		}
		// form was submitted - create the election, redirect to the admins page
		else
		{
			$this->election_model->CreateElection();
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('admin/');
		}
	}
}