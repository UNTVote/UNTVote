<?php

// CronJobs Controller is for all the scripts that need to be ran as cron jobs
class Cronjobs extends CI_Controller
{
	// constructor - load the model that we will use
	// - load the URL helper for redirect
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('election_model');
	}

	// Update all the elections
	public function UpdateElections()
	{
		$this->election_model->UpdateElections();
	}

	public function TestCron()
	{
		echo 'Testing!!!';
	}
}