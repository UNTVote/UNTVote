<?php

// Notification Controller is for all the logic in an notifications
class Notifications extends CI_Controller
{
	// constructor - load the model that we will use
	// - load the URL helper for redirect
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('notification_model');

		// the user must be an admin to view notifications
		if (!$this->ion_auth->is_admin())
		{
			// redirect them to the login page
			redirect('user/', 'refresh');
		}
	}

	// index - default notification page, shows all the notification to the admin
	public function index()
	{
		// grab all the notifications for the admin
		$notifications = $this->notification_model->GetNotificationsByType('Vote');
		$numberNotifications = count($notifications);
		$title = "Notifications | UNTVote";

		$data['title'] = $title;
		$data['notifications'] = $notifications;
		$data['numberNotifications'] = $numberNotifications;

		//$this->load->view('templates/header', $data);
		$this->load->view('notifications/index', $data);
		//$this->load->view('templates/footer');
	}

	// send - sends the notification to the admins, then redirects them back to the elections page
	public function SendElectionNotification($electionID)
	{
		$this->notification_model->SendElectionNotification($electionID);
		redirect('elections/', 'refresh');
	}

	// send candidate notification to the admins, then redirects them back to the elections page
	public function SendCandidateNotification()
	{
		$this->notification_model->SendCandidateNotification();
		redirect('elections/', 'refresh');
	}
}