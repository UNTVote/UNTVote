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

	// GetElectionNotifications - Returns all the notifications for elections
	public function GetElectionNotifications()
	{
		$query = $this->db->query('SELECT admin_notifications.id, colleges.description, first_name, last_name, election_name 
								FROM users, colleges, users_colleges, admin_notifications, election WHERE type="Vote" 
								AND users.id=admin_notifications.sender_id 
								AND admin_notifications.election_id=election.id 
								AND users_colleges.college_id=colleges.id 
								AND users_colleges.user_id=admin_notifications.sender_id');
		return $query->result_array();
	}

	// GetElectionNotifications - Returns all the notifications for elections
	public function GetCandidateNotifications()
	{
		$query = $this->db->query('SELECT admin_notifications.id, colleges.description, first_name, last_name
								FROM users, colleges, users_colleges, admin_notifications WHERE type="Candidate" 
								AND users.id=admin_notifications.sender_id 
								AND users_colleges.college_id=colleges.id 
								AND users_colleges.user_id=admin_notifications.sender_id');
		return $query->result_array();
	}

	// IsElectionNotificationSent - checks to see if the logged in user has sent a notification for that election
	// Returns - True if it has been sent, false if it has not been sent
	public function IsElectionNotificationSent($electionID)
	{
		$userID = $this->ion_auth->user()->row()->id;
		$query = $this->db->select('id')->from('admin_notifications')->where('election_id', $electionID)->where('sender_id', $userID)->get();
		$result = $query->num_rows();

		if($result >= 1)
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

		$this->ion_auth_model->set_message('notification_approval_sent');
	}

	// SendCandidateNotification - Adds an candidate request notification to the admins for the current user
	public function SendCandidateNotification()
	{
		// the current logged on user is the user sending the request
		$userID = $this->ion_auth->user()->row()->id;

		// checks to see if we have this users approval request, if so, we do nothing.
		$query = $this->db->get_where('admin_notifications', array('sender_id' => $userID,
																   'type' => 'Candidate'));
		$result = $query->num_rows();
		if($result > 0)
		{
			// we have the request already, just return and do nothing
			$this->ion_auth_model->set_message('notification_approval_notsent');
			return;
		}

		$data = array('sender_id' => $userID,
					  'type' => 'Candidate');
		$this->db->insert('admin_notifications', $data);
		$this->ion_auth_model->set_message('notification_approval_sent');
	}

	// AcceptElectionRequest - allows a user to vote on an election and deletes their notification from the table
	// notificationID - the notification that we are accepting and deleting from the table.
	public function AcceptElectionRequest($notificationID)
	{
		$this->load->library('email');

		$query = $this->db->get_where('admin_notifications', array('id' => $notificationID));
		$result = $query->row_array();

		// store who sender and the election they will vote on
		$sender = $result['sender_id'];
		$election = $result['election_id'];

		// adds the user to the voters table
		$data = array('user_id' => $sender,
					  'election_id' => $election);
		$this->db->insert('voters', $data);

		$userEmail = $this->ion_auth->user($sender)->row()->email;

		$this->email->from('UNTVote@gmail.com', 'UNTVote');
		$this->email->to($userEmail);
		$this->email->subject('UNTVote: Election Approval Request');
		$this->email->message('We are sending you this email to let you know that you have been 
								approved to vote in an election you requested.');
		$this->email->send();

		// deletes the notification from the table
		$this->db->delete('admin_notifications', array('id' => $notificationID));

		// TODO: SEND EMAIL TO THE USER HERE
	}

	public function AcceptCandidateRequest($notificationID)
	{
		$this->load->helper('url');

		$query = $this->db->get_where('admin_notifications', array('id' => $notificationID));
		$result = $query->row_array();

		// store the sender and add the user to the candidates group
		$sender = $result['sender_id'];
		$this->ion_auth->add_to_group('3', $sender);

		$userName = $this->ion_auth->user($sender)->row()->first_name;
		$userEmail = $this->ion_auth->user($sender)->row()->email;
		$profileURL = anchor('user/edit_user/' . $sender . '#candidate', "HERE");
		$emailMessage = 'Congratulations <strong>' . $userName . '</strong>, you have been approved to be a candidate!<br>
						You may click '. $profileURL . ' to edit your profile.  You can click the Candidate Tab to edit your candidate information!';

		$this->email->from('UNTVote@gmail.com', 'UNTVote');
		$this->email->to($userEmail);
		$this->email->subject('UNTVote: Candidate Approval Request');
		$this->email->message($emailMessage);
		$this->email->send();

		// deletes the notification from the table
		$this->db->delete('admin_notifications', array('id' => $notificationID));

		// TODO: SEND EMAIL TO THE USER HERE
	}

	// RejectRequest - The admin rejects the users reques to be a candidate or vote on an election
	// notificationID - the notification we need to remove
	public function RejectRequest($notificationID)
	{
		$this->db->delete('admin_notifications', array('id' => $notificationID));
	}
}