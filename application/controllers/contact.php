<?php

// Controller Controller is for all the logic in contactng UNTVote
class Contact extends CI_Controller
{
	// constructor - load the model that we will use
	// - load the URL helper for redirect
	public function __construct()
	{
		parent::__construct();

		$this->load->library('ion_auth');
		$this->load->model('ion_auth_model');
	}

	// index - default candidates page that displays all the candidates that we have
	public function index()
	{
		$this->load->library('form_validation');

		$title = "Contact UNTVote";

		$data['title'] = $title;
		$data['scripts'] = array('vendor/parsley.min.js');

		if(!$this->form_validation->run())
		{
			if($this->ion_auth->logged_in())
			{
				$data['user'] = $this->ion_auth->user()->row();
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
			}
			else
			{
				$this->load->view('templates/header_login', $data);
        		$this->load->view('templates/navigation_forgot', $data);
			}
       		$this->load->view('pages/contact-us', $data);
	    	$this->load->view('templates/scripts_main');
        	$this->load->view('templates/scripts_custom');
			$this->load->view('templates/footer'); 
		}
	}

	public function SendMail()
	{
			$this->load->library('form_validation');
			$firstName = $this->input->post('firstName');
			$lastName = $this->input->post('lastName');
			$email = $this->input->post('email');
			$message = $this->input->post('message');
			$this->load->library('email');

			$this->email->from($email, $firstName . ' ' . $lastName);
			$this->email->to('UNTVote@gmail.com'); 

			$this->email->subject($firstName . ' has contacted UNTVote');
			$this->email->message('Name: ' . $firstName . ' ' . $lastName
								  '<br>Email: ' . $email
								  '<br>: Message: ' .$message);	

			$this->email->send();

			$this->ion_auth_model->set_message('email_sent');
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			redirect('/', 'refresh');	
	}
}