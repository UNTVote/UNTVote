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
	}

	// index - default notification page, shows all the notification to the admin
	public function index()
	{
		// the user must be an admin to view notifications
		if (!$this->ion_auth->is_admin())
		{
			// redirect them to the login page
			redirect('user/', 'refresh');
		}
		$scripts = array('vendor/tablesorter.min.js', 'admin-users-approvals.js');
		$user = $this->ion_auth->user()->row();
		// grab all the notifications for the admin
		$candidateNotifications = $this->notification_model->GetCandidateNotifications();
		$electionNotifications = $this->notification_model->GetElectionNotifications();
		$numberNotifications = count($candidateNotifications) + count($electionNotifications);
		$numberElectionNotifications = count($electionNotifications);
		$numberCandidateNotifications = count($candidateNotifications);
		$title = "Notifications | UNTVote";

		$data['user'] = $user;
		$data['title'] = $title;
		$data['candidateNotifications'] = $candidateNotifications;
		$data['electionNotifications'] = $electionNotifications;
		$data['numberNotifications'] = $numberNotifications;
		$data['numberElectionNotifications'] = $numberElectionNotifications;
		$data['numberCandidateNotifications'] = $numberCandidateNotifications;
		$data['scripts'] = $scripts;

		$this->load->view('templates/header_user', $data);
		$this->load->view('templates/navigation_admin', $data);
		$this->load->view('templates/sidebar_admin');
		$this->load->view('admin/admin-users-approvals', $data);
		$this->load->view('templates/scripts_main');
		$this->load->view('templates/scripts_custom', $data);
		$this->load->view('templates/footer');
	}

	// SendElectionNotification - sends the notification to the admins, then redirects them back to the elections page
	public function SendElectionNotification($electionID)
	{
		$this->notification_model->SendElectionNotification($electionID);
		// get the election the user was viewing
		$slug = $this->input->post('slug');

		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('elections/' . $slug . '/', 'refresh');
	}

	// send candidate notification to the admins, then redirects them back to the elections page
	public function SendCandidateNotification()
	{
		$this->notification_model->SendCandidateNotification();
		redirect('user/', 'refresh');
	}

	// AcceptElectionNotification - Accepts a users request to vote in an election
	// notificationID - the notification that we are accepting
	public function AcceptElectionNotification($notificationID)
	{
		$this->notification_model->AcceptElectionRequest($notificationID);
		redirect('notifications/', 'refresh');
	}

	// AcceptCandidateNotification - Accepts a users request to be a candidate
	// notificationID - the notification that we are accepting
	public function AcceptCandidateNotification($notificationID)
	{
		$this->notification_model->AcceptCandidateRequest($notificationID);
		redirect('notifications/', 'refresh');
	}

	// RejectRequest - Denies a user from voting or being a candidate
	// notificationID - the approval we are rejecting
	public function RejectRequest($notificationID)
	{
		$this->notification_model->RejectRequest($notificationID);
		redirect('notifications', 'refresh');
	}
}