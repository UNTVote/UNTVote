<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_Model extends CI_Model
{
	// constructor - sets up the model, load the database, and libraries
    public function __construct()
    {
        $this->load->database();
        $this->load->model('ion_auth_model');
        $this->load->library('ion_auth');
    }

    // GetNotifications - Returns all the notifications
	public function GetNotifications()
	{
		// return all elections
		$query = $this->db->get('admin_notifications');
		// returns the resulting array of the the elections is found
		return $query->result_array();
	}

	// GetNotificationsByType - Returns all the notifications for that type
	public function GetNotificationsByType($type)
	{
		$query = $this->db->query('SELECT first_name, last_name, type, election_name  FROM users, admin_notifications, election WHERE type="'. $type . '" AND users.id=admin_notifications.sender_id 
									AND admin_notifications.election_id=election.id');
		return $query->result_array();
	}

	// IsElectionNotificationSent - checks to see if the logged in user has sent a notification for that election
	// Returns - True if it has been sent, false if it has not been sent
	public function IsElectionNotificationSent($electionID)
	{
		$userID = $this->ion_auth->user()->row()->id;
		$query = $this->db->select('id')->from('admin_notifications')->where('election_id', $electionID)->where('sender_id', $userID)->get();
		$result = $query->num_rows();

		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// SendElectionNotification - Adds an election notification to the admins for the current user
	// electionID - the ID for the election they are wanting to vote on
	public function SendElectionNotification($electionID)
	{
		$userID = $this->ion_auth->user()->row()->id;

		$data = array('sender_id' => $userID,
					  'type' => 'Vote',
					  'election_id' => $electionID);
		$this->db->insert('admin_notifications', $data);
	}

	// SendCandidateNotification - Adds an candidate request notification to the admins for the current user
	public function SendCandidateNotification()
	{
		$userID = $this->ion_auth->user()->row()->id;
		$data = array('sender_id' => $userID,
					  'type' => 'Candidate');
		$this->db->insert('admin_notifications', $data);
	}
}