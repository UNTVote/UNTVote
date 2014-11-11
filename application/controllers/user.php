<?php defined('BASEPATH') OR exit('No direct script access allowed');

// User Controller class
// What all the general users can do
class User extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('language');
        $this->load->helper('url');

        // language file loads
        $this->lang->load('auth');

        // model loads
        $this->load->model('election_model');

        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->election_model->UpdateElections();
    }
    
    public function index()
    {
        // if the user is not logged in take them to the log in page
        if(!$this->ion_auth->logged_in())
        {
            redirect('user/login', 'refresh');
        }
        else
        {
            $user = $this->ion_auth->user()->row();
            $title = $user->first_name . " | UNTVote";
            $activeElections = $this->election_model->GetElectionsByUser($user->id, 'Active');
            $upcomingElections = $this->election_model->GetElectionsByUser($user->id, 'Upcoming');
            $this->data['user'] = $user;
            $this->data['title'] = $title;
            $this->data['activeElections'] = $activeElections;
            $this->data['upcomingElections'] = $upcomingElections;
            $this->data['numberActiveElections'] = count($activeElections);
            $this->data['numberInactiveElections'] = count($upcomingElections);
            // number of users in the group 'voters'
            $this->data['numberVoters'] = count($this->ion_auth->users(array(4))->result_array());

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->_render_page('templates/header_user', $this->data);
        	$this->_render_page('templates/navigation_user', $this->data);
			$this->_render_page('templates/sidebar_user', $this->data);
            $this->_render_page('user/user-dashboard', $this->data);
			$this->_render_page('templates/scripts_main');
            $this->_render_page('templates/scripts_custom');
			$this->_render_page('templates/footer');            
        }
    }
    
    public function login()
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
                redirect('user/', 'refresh');
            }
            else
            {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('user/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            
            $this->_render_page('templates/header_login', $this->data);
            $this->_render_page('templates/navigation_login', $this->data);
            $this->_render_page('user/login', $this->data);  
			$this->_render_page('templates/scripts_main');   
			$this->_render_page('templates/footer', $this->data);     
        }
        
    }

    public function logout()
    {
        $this->data['title'] = "Logout | UNTVote";
        
        // logout the user
        $logout = $this->ion_auth->logout();
        
        // redirect to homep age
		$this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('user/login', 'refresh');
    }
    
    public function register()
    {
        $this->data['title'] = "Register | UNTVote";
        // do we have a logged in user
        $this->data['loggedIn'] = $this->ion_auth->logged_in();
        $this->data['isAdmin'] = $this->ion_auth->is_admin();
        
        // get all the colleges from the database
        $colleges = $this->ion_auth->colleges()->result_array();

        $tables = $this->config->item('tables','ion_auth');

        // validate form input
        $this->form_validation->set_rules('euid', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('colleges', $this->lang->line('create_user_validation_college_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|is_unique['.$tables['users'].'.email]');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth'));

        
        if ($this->form_validation->run() == true)
        {
            // make both the username and email lowercase
            // username is the euid
            $username = strtolower($this->input->post('euid'));
            $email    = strtolower($this->input->post('email'));
            // append @my.unt.edu to the email
            $email   .= '@my.unt.edu'; 
            $password = $this->input->post('password');
 				
			// all the colleges the user has picked.     
            $collegeData = $this->input->post('colleges');
            
			// additional data to be send to the users table
			$additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
            );
        }
		
		// check to see if we are creating the user
        if ($this->form_validation->run() == true && $this->ion_auth->registerUser($username, $password, $email, $collegeData, $additional_data))
        {
            // redirect them back to the login page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("user/login", 'refresh');
        }
        else
        {
            //display the create user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['inforMessage'] = $this->session->flashdata('message');

            $this->data['options'] = $colleges;
            
            $this->_render_page('templates/header', $this->data);
            $this->_render_page('templates/navigation', $this->data);
            $this->_render_page('pages/home', $this->data);
			$this->_render_page('templates/scripts_main');  
			$this->_render_page('templates/scripts_custom');
			$this->_render_page('templates/footer', $this->data);
        }
    }

    //edit a user
    function edit_user($id)
    {
        $this->data['title'] = "Edit User";
        $user = $this->ion_auth->user()->row();
        $title = $user->first_name . " | UNTVote";
        // create a substring from the email, don't include the "@my.unt.edu"
        $userEmail = substr($user->email, 0, -11);
        // get all the colleges from the database
        $colleges = $this->ion_auth->colleges()->result_array();
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
            redirect('user', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();
        $colleges = $this->ion_auth->colleges()->result_array();
        $currentCollege = $this->ion_auth->get_users_colleges($id)->result();

        //validate form input
        $this->form_validation->set_rules('firstName', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('lastName', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('college', $this->lang->line('edit_user_validation_college_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }

            $data = array(
                'first_name' => $this->input->post('firstName'),
                'last_name'  => $this->input->post('lastName'),
            );

            $collegeData = $this->input->post('colleges');

            if (isset($collegeData) && !empty($collegeData)) 
            {
                $this->ion_auth->remove_from_college('', $id);

                foreach ($collegeData as $clg) 
                {
                    $this->ion_auth->add_to_college($clg, $id);
                }
            }

            //update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE)
            {
                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', "User Saved");
                if ($this->ion_auth->is_admin())
                {
                    redirect('user', 'refresh');
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
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;
        $this->data['isCandidate'] = $isCandidate;
        // sets the options for the dropdown box
        $this->data['options'] = $colleges;
        $this->data['collegeDefault'] = $currentCollege;
        $this->data['userEmail'] = $userEmail;
        
        $this->_render_page('templates/header_user', $this->data);
        $this->_render_page('templates/navigation_user');
        $this->_render_page('templates/sidebar_user');
        $this->_render_page('pages/edit-profile', $this->data);
        $this->_render_page('templates/scripts_main');  
        $this->_render_page('templates/scripts_custom');
        $this->_render_page('templates/footer');
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
			$this->_render_page('user/forgot-password', $this->data);
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

			$this->form_validation->set_rules('newPassword', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[confirmPassword]');
			$this->form_validation->set_rules('confirmPassword', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$this->_render_page('templates/header_login', $this->data);
				$this->_render_page('templates/navigation_forgot', $this->data);
				$this->_render_page('user/reset-password', $this->data);
				$this->_render_page('templates/scripts_main'); 
				$this->_render_page('templates/footer', $this->data);
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

					$change = $this->ion_auth->reset_password($identity, $this->input->post('newPassword'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('user/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("user/forgot_password", 'refresh');
		}
	}

    // private function to render a certain page
    function _render_page($view, $data=null, $render=false)
    {
        $this->viewData = (empty($data)) ? $this->data : $data;
        
        $viewHTML = $this->load->view($view, $this->viewData, $render);
        if(!$render)
        {
            return $viewHTML;
        }
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
}

