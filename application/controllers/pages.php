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
		// redirect the user to their user page if they're logged in and if they tried to view the home page
		if($this->ion_auth->logged_in() && $page == 'home')
		{
			// redirect user to the user page
			redirect('user/');
		}
        // create the title from the view passed in, capitalize the first letter, add UNTVote
        $data['title'] = ucfirst($page . ' | UNTVote');
        
		// get all the colleges from the database
        $data['options'] = $this->ion_auth->colleges()->result_array();
		// validation errors for the registration form
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		// load the views based on whether it's the home page or terms of service page
		if($page == 'terms-of-service')
		{
			$this->load->view('templates/header_user', $data);
        	$this->load->view('templates/navigation_login', $data);
		}
		else
		{
			$this->load->view('templates/header', $data);
        	$this->load->view('templates/navigation', $data);
		}
        
        $this->load->view('pages/'.$page, $data);
		$this->load->view('templates/scripts_main');
		$this->load->view('templates/scripts_custom');
        $this->load->view('templates/footer', $data);
    }
}


