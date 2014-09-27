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
        $this->load->helper('url');

        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
    }
    
    public function index()
    {
        // if the user is not logged in take them to the log in page
        if(!$this->ion_auth->logged_in())
        {
            redirect('user/login', 'refresh');
        }
        // get the current logged in user to use on the page
        else
        {
            $this->data['user'] = $this->ion_auth->user()->row();
            $this->data['title'] = $this->ion_auth->user()->row()->first_name;
            $this->load->view('user/index', $this->data);           
        }
    }
    
    public function login()
    {
        $this->data['title'] = "Login";
        // do we have a logged in user
        $this->data['loggedIn'] = $this->ion_auth->logged_in();
        $this->data['isAdmin'] = $this->ion_auth->is_admin();
        
        //validate form input
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
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('/', 'refresh');
            }
            else
            {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('user/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            // user is not logging in, display the form to the user
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
            );
            
            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/navigation', $this->data);
            $this->load->view('user/login', $this->data);        
        }
        
    }

    public function logout()
    {
        $this->data['title'] = "Logout";
        
        // logout the user
        $logout = $this->ion_auth->logout();
        
        // redirect to homep age
        redirect('/', 'refresh');
    }
    
    public function register()
    {
        $this->data['title'] = "Create User";
        // do we have a logged in user
        $this->data['loggedIn'] = $this->ion_auth->logged_in();
        $this->data['isAdmin'] = $this->ion_auth->is_admin();
        
        // sets the options for the dropdown box
        $this->data['options'] = array(
        'arts_and_sciences' => "College of Arts and Sciences",
        'business' => "College of Business",
        'education' => "College of Education",
        'engineering' => "College of Engineering",
        'information' => "College of Information",
        'merchandishing_hospitality_tourism' => "College of Merchandishing, Hospitality and Tourism",
        'music' => "College of Music",
        'public_affairs_community_service' => "College of Public Affairs and Community Service",
        'visual_arts_design' => "College of Visual Arts and Design",
        'journalism' => "Frank W. and Sue Mayborn School of Journalism",
        'honors' => "Honors College",
        'tams' => "TAMS",
        'toulouse' => "Toulouse Graduate School",
        );

        $tables = $this->config->item('tables','ion_auth');

        //validate form input
        $this->form_validation->set_rules('euid', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
        $this->form_validation->set_rules('college', $this->lang->line('create_user_validation_college_label'), 'required|xss_clean');
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
                'college'    => $this->input->post('college'),
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
            $this->data['college'] = array(
                'name'  => 'college',
                'id'    => 'college',
                'value' => $this->form_validation->set_value('college'), 
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
            
            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/navigation', $this->data);
            $this->_render_page('user/register', $this->data);
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
}

