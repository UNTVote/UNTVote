<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		// library loads
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->helper('language');

		// languague file loads
		$this->lang->load('auth');

		// model loads
		$this->load->model('election_model');
		$this->load->model('notification_model');
		$this->load->model('user_model');
		$this->load->model('college_model');

		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->election_model->UpdateElections();
	}

	// redirect if needed, otherwise display the user list
	function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('admin/login', 'refresh');
		}
		// a regular user tried to hack this, get him out of here
		elseif (!$this->ion_auth->is_admin())
		{
			// show an error message, they can't be here
			show_error("You must be an admin to view this page.");
		}
		else
		{
			$firstName = $this->ion_auth->user()->row()->first_name;

        	// grab the election data
        	$activeElections = $this->election_model->GetElectionsByStatus("Active");
        	$upcomingElections = $this->election_model->GetElectionsByStatus("Upcoming");
        	$numberActiveElections = count($activeElections);
        	$numberUpcomingElections = count($upcomingElections);
        	$numberNotifications = count($this->notification_model->GetNotifications());

        	// grab how many users we have
        	$users = $this->ion_auth->users()->result_array();
        	$numberUsers = count($users);

        	// send everything to the data array
        	$this->data['user'] = $this->ion_auth->user()->row();
        	$this->data['title'] = $firstName . " | UNTVote";
        	$this->data['activeElections'] = $activeElections;
        	$this->data['upcomingElections'] = $upcomingElections;
        	$this->data['numberActiveElections'] = $numberActiveElections;
        	$this->data['numberUpcomingElections'] = $numberUpcomingElections;
        	$this->data['numberUsers'] = $numberUsers;
        	$this->data['numberNotifications'] = $numberNotifications;
			// set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->_render_page('templates/header_user', $this->data);
            $this->_render_page('templates/navigation_admin', $this->data);
			$this->_render_page('templates/sidebar_admin', $this->data);
			$this->_render_page('admin/admin-dashboard', $this->data);
			$this->_render_page('templates/scripts_main');
			$this->_render_page('templates/footer');
		}
	}

	// UserData
	// used for ajax to return all the users in a json formatted string
	function UserData()
	{
		header('Content-Type: application/json');

		// do we have an ajax request
		if($this->input->is_ajax_request())
		{
			// grab all the users
			$users = $this->user_model->GetsUsersAjax();
			$viewURL = null;

			$userData = array();
			foreach($users as $user)
			{
				$viewURL = site_url('admin/view_user/' . $user['user_id']);
				$actionButtons = "<a href='" . $viewURL . "' class='btn btn-xs btn-primary'>Edit</a>";
				$userData[] = array(
									'first_name' => $user['first_name'],
									'last_name'  => $user['last_name'],
									'college'    => $user['college'],
									'role'       => $user['role'],
									'username'   => $user['username'],
									'last_login' => date('m-d-Y', $user['last_login']),
									'created_on' => date('m-d-Y', $user['created_on']),
									'action_buttons' => $actionButtons
								);
			}

			// encode this array into json
			$return = json_encode($userData);
			echo $return;
		}
	}

	// VoteLog
	// used for ajax to return the vote log in a json formatted string
	function VoteLog()
	{
		header('Content-Type: application/json');

		// do we have an ajax request
		if($this->input->is_ajax_request())
		{
			$voteLog = $this->election_model->GetVoteLog();

			$voteLogData = array();
			foreach($voteLog as $vote)
			{
				$election = $this->election_model->GetElection($vote['election_id']);
				$userFirstName = $this->ion_auth->user($vote['voter_id'])->row()->first_name;
				$userLastName = $this->ion_auth->user($vote['voter_id'])->row()->last_name;
				$userName = $userFirstName . ' ' . $userLastName;
				$candidateFirstName = $this->ion_auth->user($vote['candidate_id'])->row()->first_name;
				$candidateLastName = $this->ion_auth->user($vote['candidate_id'])->row()->last_name;
				$candidateName = $candidateFirstName . ' ' . $candidateLastName;
				$electionName = $election['election_name'];
				$timeStampSQL = strtotime($vote['vote_time']);
				$timeStamp = date('m-d-Y g:i A', $timeStampSQL);
				$confirmationNumber = $vote['confirmation_number'];

				$voteLogData[] = array(
										'confirmation_number' => $confirmationNumber,
										'voter_name' => $userName,
										'candidate' => $candidateName,
										'election_name' => $electionName,
										'vote_time' => $timeStamp
										);
			}
			$return = json_encode($voteLogData);
			echo $return;
		}
	}

	// VoteData
	// Used for ajax to return the number of votes in an hour in a json formatted string
	function VoteData()
	{
		header('Content-Type: application/json');

		if($this->input->is_ajax_request())
		{
			$election = $this->input->post('elections');
			$voteData = array();
			$votes = 0;
			// loop through all 24 hours to get the data
			for($currentHour = 0; $currentHour < 24; $currentHour++)
			{
				// get the number of votes for that hour
				$votes = $this->election_model->GetVotesByHour($election, $currentHour);
				$voteData['hour'.$currentHour] = $votes;
			}

			$return = json_encode($voteData);
			echo $return;
		}
	}

	// ElectionData
	// used for ajax to return the election data in a json formatted string
	function ElectionData()
	{
		header('Content-Type: application/json');
		// do we have an ajax request
		if($this->input->is_ajax_request())
		{
			// grab all the elections from the database
			$elections = $this->election_model->GetElectionsAjax();
			$editURL = null;
			$deleteURL = null;

			$electionData = array();
			foreach($elections as $election)
			{
				$editURL = site_url('elections/edit/' . $election['id']);
				$actionButtons = "<a href='" . $editURL . "' class='btn btn-xs btn-primary'>Edit</a>";
				$electionData[] = array(
										  'election_name' => $election['election_name'],
							 			  'college' => $election['description'],
							  			  'start_date' => date("m-d-Y", strtotime($election['start_time'])),
							  			  'end_date' => date("m-d-Y", strtotime($election['end_time'])),
							  			  'status' => $election['status'],
							  			  'actionButtons' => $actionButtons
										);
			}

			//encode it into json format
			$return = json_encode($electionData);
			echo $return;
		}
	}

	// ElectionResults
	// Used for ajax to return the election details for the election selected
	function ElectionResults()
	{
		header('Content-Type: application/json');
		// do we have an ajax request
		if($this->input->is_ajax_request())
		{
			// grab the elelection they request
			$election = $this->input->post('elections');
			$electionCollege = $this->election_model->GetElectionCollege($election);
			$college = $electionCollege['description'];
			$candidates = $this->election_model->GetElectionCandidates($election);
			$totalCandidates = count($candidates);
			$totalVoters = $this->election_model->GetElectionVoters($election);
			$electionData = $this->election_model->GetElection($election);
			$electionName = $electionData['election_name'];
			$startDate = date("m-d-Y", strtotime($electionData['start_time']));
			$endDate = date("m-d-Y", strtotime($electionData['end_time']));
			$electionVotes = $electionData['total_votes'];

			$electionResults = array('election_name' => $electionName,
									 'start_date' => $startDate,
									 'end_date' => $endDate,
									 'total_votes' => $electionData['total_votes'],
									 'total_voters' => $totalVoters,
									 'total_candidates' => $totalCandidates,
									 'category' => $college);
			$candidateIndex = 0;
			foreach($candidates as $candidate)
			{
				// generate a URL for the candidates avatar
				$avatar = base_url() . $candidate['avatar'];
				$electionResults['candidate'][$candidateIndex] = array(
										  'candidate_first_name' => $candidate['first_name'],
										  'candidate_last_name' => $candidate['last_name'],
							 			  'votes' => $candidate['votes'],
							 			  'avatar' => $avatar
										);
				$candidateIndex++;
			}

			//encode it into json format
			$return = json_encode($electionResults);
			echo $return;
		}
	}

	//log the user in
	function login()
	{
        $this->data['title'] = "Login | UNTVote";
        // do we have a logged in user
        $this->data['loggedIn'] = $this->ion_auth->logged_in();
        $this->data['isAdmin'] = $this->ion_auth->is_admin();

        // validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true)
        {
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                //if the login is successful
                //redirect them to the users page
                redirect('admin/', 'refresh');
            }
            else
            {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('admin/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->_render_page('templates/header_login', $this->data);
            $this->_render_page('templates/navigation_login', $this->data);
            $this->_render_page('admin/login', $this->data);
			$this->_render_page('templates/scripts_main');
			$this->_render_page('templates/footer', $this->data);
        }

    }

	//log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('admin/login', 'refresh');
	}

	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('admin/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$this->_render_page('admin/change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('admin/change_password', 'refresh');
			}
		}
	}

	//forgot password
	public function forgot_password()
	{
		$this->data['title'] = 'Forgot Password | UNTVote';

		// set the validation rules
		$this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		if ($this->form_validation->run() == false)
		{
			$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');

			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('templates/header_login', $this->data);
			$this->_render_page('templates/navigation_forgot', $this->data);
			$this->_render_page('admin/forgot-password', $this->data);
			$this->_render_page('templates/scripts_main');
			$this->_render_page('templates/footer', $this->data);
		}
		else
		{
			// email validation
			$identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
	            if(empty($identity))
				{
		        	$this->ion_auth->set_message('forgot_password_email_not_found');
		            $this->session->set_flashdata('message', $this->ion_auth->messages());
                	redirect("user/forgot_password", 'refresh');
            	}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			// if their were not errors redirect user to the login page
			if ($forgotten)
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("user/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("user/forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$this->_render_page('admin/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('admin/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("admin/forgot_password", 'refresh');
		}
	}

	//activate the user
	function activate($id, $code=false)
	{
	    $data['title'] = "Activate User";
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("admin", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("admin/forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
	    $data['title'] = "Deactivate User";
		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('admin/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}
			//redirect them back to the auth page
			redirect('admin', 'refresh');
		}
	}

	//create a new user
	function create_user()
	{
		$data['title'] = "Create User";

        $tables = $this->config->item('tables','ion_auth');

        //validate form input
        $this->form_validation->set_rules('euid', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            // make both the username and email lowercase
            // username is the euid
            $username = strtolower($this->input->post('euid'));
            $email    = strtolower($this->input->post('email'));
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
        {
            //check to see if we are creating the user
            //redirect them back to the register page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("user/login", 'refresh');
        }
        else
        {
            //display the create user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

             $this->data['euid'] = array(
                'name'  => 'euid',
                'id'    => 'euid',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('euid'),
            );
            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_navigation', $data);
			$this->_render_page('admin/create_user', $this->data);
		}
	}

	// manage all the users
	function manage_users()
	{
		if (!$this->ion_auth->is_admin())
		{
			// show them an error message, they can't be here
			show_error("You must be an admin to view this page.");
		}

		// scripts
		$cdnScripts = array('//www.fuelcdn.com/fuelux/3.1.0/js/fuelux.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js');
		$scripts = array('admin-users-manage.js');

		$firstName = $this->ion_auth->user()->row()->first_name;
        $this->data['user'] = $this->ion_auth->user()->row();
        $this->data['title'] = $firstName . " | UNTVote";
        $this->data['cdnScripts'] = $cdnScripts;
        $this->data['scripts'] = $scripts;

		$this->_render_page('templates/header_manage_elections', $this->data);
		$this->_render_page('templates/navigation_admin', $this->data);
		$this->_render_page('templates/sidebar_admin');
		$this->_render_page('admin/admin-users-manage', $this->data);
		$this->_render_page('templates/scripts_main');
		$this->_render_page('templates/scripts_custom', $this->data);
		$this->_render_page('templates/footer');
	}

	// edit/view a user from the manage users table
	function view_user($id)
	{

		$data['user'] = $this->ion_auth->user()->row();
		$profile = $this->ion_auth->user($id)->row();
		$data['title'] = $profile->first_name . "'s Profile | UNTVote";
		$scripts = array('vendor/parsley.min.js', 'admin-users-edit.js');
		$data['scripts'] = $scripts;

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}
		$user = $this->ion_auth->user($id)->row();
		// create a substring from the email, don't include the "@my.unt.edu"
        $userEmail = substr($user->email, 0, -11);
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		$colleges = $this->college_model->GetCollegesNotLike('All');
		$currentColleges = $this->ion_auth->get_users_colleges($id)->result();
		$voteCost = $user->vote_cost;
		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');
		$this->form_validation->set_rules('colleges', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}
			$email    = strtolower($this->input->post('email'));
            // append @my.unt.edu to the email
            $email   .= '@my.unt.edu';
			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'email'      => $email,
				'vote_cost'  => $this->input->post('voteWeight')
			);
			// Only allow updating groups if user is admin
			if ($this->ion_auth->is_admin())
			{
				//Update the groups user belongs to
				$groupData = $this->input->post('groups');
				if (isset($groupData) && !empty($groupData)) {
					$this->ion_auth->remove_from_group('', $id);
					foreach ($groupData as $grp) {
						$this->ion_auth->add_to_group($grp, $id);
					}
				}
			}

			if ($this->ion_auth->is_admin())
			{
				//Update the colleges user belongs to
				$collegeData = $this->input->post('colleges');
				if (isset($collegeData) && !empty($collegeData)) {
					$this->ion_auth->remove_from_college('', $id);
					foreach ($collegeData as $clg) {
						$this->ion_auth->add_to_college($clg, $id);
					}
				}
				// add them back to the all college
				$this->ion_auth->add_to_college(15, $id);
			}
			if ($this->form_validation->run() === TRUE)
			{
				$this->ion_auth->update($user->id, $data);
				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('message', "User Saved");
				if ($this->ion_auth->is_admin())
				{
					redirect('admin/manage_users', 'refresh');
				}
				else
				{
					redirect('/', 'refresh');
				}
			}
		}
		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		//pass the user to the view
		$this->data['user'] = $user;
		$this->data['userEmail'] = $userEmail;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;
		$this->data['colleges'] = $colleges;
		$this->data['currentColleges'] = $currentColleges;
		$this->data['voteCost'] = $voteCost;

        $this->load->view('templates/header_user', $data);
        $this->load->view('templates/navigation_admin', $data);
        $this->load->view('templates/sidebar_admin');
		$this->_render_page('admin/admin-users-edit', $this->data);
		$this->load->view('templates/scripts_main');
		$this->load->view('templates/scripts_custom', $data);
		$this->load->view('templates/footer');
	}

	// deletes a user
	// userID - the suer to delete
	function delete_user($userID)
	{
		$this->ion_auth->delete_user($userID);
		$this->user_model->DeleteUser($userID);
		redirect('admin/manage_users', 'refresh');
	}

	//edit a user
	function edit_user($id)
    {
        // setup all the scripts needed for this page
        // the cdn scripts
        $cdnScripts = array('//www.fuelcdn.com/fuelux/3.1.0/js/fuelux.min.js');
        $scripts = array('vendor/parsley.min.js', 'edit-profile.js');
        $errors = null;


        $this->data['title'] = "Edit profile | UNTVote";
        $user = $this->ion_auth->user()->row();
        $title = $user->first_name . " | UNTVote";
        // create a substring from the email, don't include the "@my.unt.edu"
        $userEmail = substr($user->email, 0, -11);
        // get all the colleges from the database
        $colleges = $this->college_model->GetCollegesNotLike('All');
        $currentCollege = $this->ion_auth->get_users_colleges($user->id)->result();
        $isCanddate = true;

        // check to see if the current user is a candidate to know to dispay that form or not
        if($this->ion_auth->in_group('candidates'))
        {
            $isCandidate = true;
        }
        else
        {
            $isCandidate = false;
        }

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('admin', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();
        $colleges = $this->college_model->GetCollegesNotLike('All');
        $currentCollege = $this->ion_auth->get_users_colleges($id)->result();

        //validate form input
        $this->form_validation->set_rules('firstName', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('lastName', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required|xss_clean');
        $this->form_validation->set_rules('college', $this->lang->line('edit_user_validation_college_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            // do we have a valid request?
            //if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            //{
               // show_error($this->lang->line('error_csrf'));
            //}

            $email    = strtolower($this->input->post('email'));
            // append @my.unt.edu to the email
            $email   .= '@my.unt.edu';

            $data = array(
                'first_name' => $this->input->post('firstName'),
                'last_name'  => $this->input->post('lastName'),
                'email'      => $email
            );

            $collegeData = $this->input->post('colleges');

            if (isset($collegeData) && !empty($collegeData))
            {
                $this->ion_auth->remove_from_college('', $id);

                foreach ($collegeData as $clg)
                {
                    $this->ion_auth->add_to_college($clg, $id);
                }
                // add them back to the default group
                $this->ion_auth->add_to_college(15, $id);
            }

            //update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

                $data['password'] = $this->input->post('password');
            }

            if(isset($_FILES['avatar']))
            {
                if(!empty($_FILES['avatar']['name']))
                {
                    if(!$this->upload->do_upload('avatar'))
                    {
                        $avatarUploaded = false;
                    }
                    else
                    {
                        $avatarUploaded = true;
                    }
                }
            }

            if ($this->form_validation->run() === TRUE)
            {
                if($avatarUploaded)
                {
                    // get the user avatar file path
                    $uploadData = $this->upload->data();
                    $relative_url = 'assets/upload/' . $uploadData['file_name'];
                    $data['avatar'] = $relative_url;
                }
                else
                {
                    $errors = $this->upload->display_errors(
                        '<div id="message" class="alert alert-danger">', '</div>');
                }

                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
                if ($this->ion_auth->is_admin())
                {
                    redirect('admin', 'refresh');
                }
                else
                {
                    redirect('admin', 'refresh');
                }
            }
        }

        //display the edit user form
        //$this->data['csrf'] = $this->_get_csrf_nonce();

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;
        $this->data['isCandidate'] = $isCandidate;
        // sets the options for the dropdown box
        $this->data['options'] = $colleges;
        $this->data['collegeDefault'] = $currentCollege;
        $this->data['userEmail'] = $userEmail;
        $this->data['errors'] = $errors;
        $this->data['cdnScripts'] = $cdnScripts;
        $this->data['scripts'] = $scripts;

        $this->_render_page('templates/header_user', $this->data);
        $this->_render_page('templates/navigation_admin', $this->data);
        $this->_render_page('templates/sidebar_admin');
        $this->_render_page('pages/edit-profile', $this->data);
        $this->_render_page('templates/scripts_main');
        $this->_render_page('templates/scripts_custom', $this->data);
        $this->_render_page('templates/footer');
    }

	// create a new group
	function create_group()
	{
		$data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin', 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('description', $this->lang->line('create_group_validation_desc_label'), 'xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("admin", 'refresh');
			}
		}
		else
		{
			//display the create group form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);
            $this->_render_page('templates/header', $data);
            $this->_render_page('templates/admin_navigation', $data);
			$this->_render_page('admin/create_group', $this->data);
		}
	}

	//edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('admin', 'refresh');
		}

		$data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('admin', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label'), 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("admin", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

        $this->_render_page('templates/header', $data);
        $this->_render_page('templates/admin_navigation', $data);
		$this->_render_page('admin/edit_group', $this->data);
	}

	// admin managing elections
	function manage_elections()
	{
		if (!$this->ion_auth->is_admin())
		{
			// show them an error message, they can't be here
			show_error("You must be an admin to view this page.");
		}

		// scripts we need
		$cdnScripts = array('https://www.fuelcdn.com/fuelux/3.1.0/js/fuelux.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js');
		$scripts = array('admin-elections-manage.js');

		$firstName = $this->ion_auth->user()->row()->first_name;
        $this->data['user'] = $this->ion_auth->user()->row();
        $this->data['title'] = $firstName . " | UNTVote";
        $this->data['cdnScripts'] = $cdnScripts;
        $this->data['scripts'] = $scripts;

		$this->_render_page('templates/header_manage_elections', $this->data);
		$this->_render_page('templates/navigation_admin', $this->data);
		$this->_render_page('templates/sidebar_admin');
		$this->_render_page('admin/admin-elections-manage', $this->data);
		$this->_render_page('templates/scripts_main');
		$this->_render_page('templates/scripts_custom', $this->data);
		$this->_render_page('templates/footer');
	}

	// view the vote log
	function vote_log()
	{
		if (!$this->ion_auth->is_admin())
		{
			// show them an error message, they can't be here
			show_error("You must be an admin to view this page.");
		}

		// scripts
		$cdnScripts = array('//www.fuelcdn.com/fuelux/3.1.0/js/fuelux.min.js','https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js');
		$scripts = array('admin-users-vote-log.js');

		$firstName = $this->ion_auth->user()->row()->first_name;
        $this->data['user'] = $this->ion_auth->user()->row();
        $this->data['title'] = $firstName . " | UNTVote";
        $this->data['cdnScripts'] = $cdnScripts;
        $this->data['scripts'] = $scripts;

		$this->_render_page('templates/header_manage_elections', $this->data);
		$this->_render_page('templates/navigation_admin', $this->data);
		$this->_render_page('templates/sidebar_admin');
		$this->_render_page('admin/admin-users-vote-log', $this->data);
		$this->_render_page('templates/scripts_main');
		$this->_render_page('templates/scripts_custom', $this->data);
		$this->_render_page('templates/footer');
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

}
