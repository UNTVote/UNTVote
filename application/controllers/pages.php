<?php

// pages class handles static pages
class Pages extends CI_Controller
{
    // constructor to load libraries
    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }
    // which page to view
    // defaults to the home page
    public function view($page = 'home')
    {
        // create the title from the view passed in, capitalize the first letter
        $data['title'] = ucfirst('Home | UNTVote');
        
        // do we have a logged in user
        $data['loggedIn'] = $this->ion_auth->logged_in();
        $data['isAdmin'] = $this->ion_auth->is_admin();
		
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		
		// before we go any further, check to see if anyone is logged in
		if($this->ion_auth->logged_in())
		{
			// redirect user to the user page
			redirect('user/');
		}
        
        // get all the colleges from the database
        $data['options'] = $this->ion_auth->colleges()->result_array();
		
        
        // load the view needed, load the templates with the view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navigation', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }
}


