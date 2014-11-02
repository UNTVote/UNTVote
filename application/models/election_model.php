<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Election_Model extends CI_Model
{
	// constructor - sets up the model, load the database, and libraries
    public function __construct()
    {
        $this->load->database();
        $this->load->library('ion_auth');
    }

    // GetElections - Returns all the elections, or a certain elections by its slug
	public function GetElections($slug = FALSE)
	{
		// slug was false, we need all the elections
		if($slug === FALSE)
		{
			// return all elections
			$query = $this->db->get('election');
			// returns the resulting array of the the elections is found
			return $query->result_array();
		}

		// we had a slug so only get the information about the election
		$query = $this->db->get_where('election', array('slug' => $slug));
		return $query->row_array();
	}

	// GetElectionByStatus - returns all the election of a certain status (active, inactive, closed)
	// Active - All elections currently running
	// Inactive - All elections not yet opened
	// Closed - All elections that are finish
	public function GetElectionsByStatus($status)
	{
		// update all the elections before getting them
		$this->UpdateElections();
		// query the database and get all elections based on a status
		$query = $this->db->get_where('election', array('status' => $status));
		return $query->result_array();
	}

	// GetElectionCandidates - returns all candidates in a certain election
	// Takes in the election id
	public function GetElectionCandidates($electionID)
	{
		// query the database and get all candidates that are in the given election
		$query = $this->db->query('SELECT election_candidates.candidate_id,first_name,last_name FROM users,election_candidates WHERE election_id='. $electionID . ' AND users.id=election_candidates.candidate_id');
		return $query->result_array();
	}

	// GetElectionIDBySlug - returns the elections id when all you have is its slug
	public function GetelectionIDBySlug($slug)
	{
		$this->db->select('id');
		$this->db->where('slug', $slug);
		$query = $this->db->get('election');
		$row = $query->row();
		return $row->id;
	}

	// GetElectionsByUser - returns all the elections the specific user can see
	// user - The user to use
	// status - what status of elections are we looking for
	public function GetElectionsByUser($user, $status)
	{
		// get all the colleges that the user currently passed in is apart of
		$colleges = $this->ion_auth->get_users_colleges($user)->result_array();
		
		$userCollege = array();
		// build an array with all the college id's
		foreach($colleges as $college)
		{
			$userColleges[] = $college['id'];
		}

		$this->db->where('status', $status);
		$this->db->where_in('college_id', $userColleges);
		$query = $this->db->get('election');
		return $query->result_array();
	}

	// CreateElection - Gets the input from the form and setup a new election in the database
	public function CreateElection()
	{
		$this->load->helper('url');

		// create the slug based on the name of the election
		$slug = url_title($this->input->post('electionName'), 'dash', TRUE);

		// get the input from the form
		$electionName = $this->input->post('electionName');
		$electionDescription = $this->input->post('electionDescription');
		$startDate = $this->input->post('electionStart');
		$endDate = $this->input->post('electionEnd');
		$college = $this->input->post('electionCollege');
		$candidates = $this->input->post('electionCandidates');
		
		if($this->IsActive($startDate))
		{
			$status = "Active";
		}
		else
		{
			$status = "Upcoming";
		}

		// data array to insert into the election table
		$data = array('election_name' => $electionName,
					  'election_description' => $electionDescription,
					  'slug' => $slug,
					  'start_time' => $startDate,
					  'end_time' => $endDate,
					  'college_id' => $college,
					  'total_votes' => 0,
					  'status' => $status);
		// insert into the election table
		$this->db->insert('election', $data);
		// get the election id of the last insert into the table
		$electionID = $this->db->insert_id();

		// forevery candidate we have add them to the election
		foreach($candidates as $candidate)
		{
			$this->AddCandidateToElection($candidate, $electionID);
		}
		
	}

	// AddCandidateToElection - Adds a candidate to a given election
	// takes in a candidates ID and a election ID.
	private function AddCandidateToElection($candidateID, $electionID)
	{
		// set the data array to insert into the table
		$data = array('candidate_id' => $candidateID,
					  'election_id' => $electionID,
					  'votes' => 0);

		// insert the candidate into the election_candidates table
		$this->db->insert('election_candidates', $data);		
	}

	// IsActive - IsActive is a helper function that determines whether an election should be active
	// startDate - the date to check whether or not it is active
	// Returns - returns true if start date is today or earlier, false otherwise
	private function IsActive($startDate)
	{
		// set the timezone to central
		date_default_timezone_set('America/Chicago');
		if(strtotime($startDate) >= time())
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	// UpdateElections - This checks whether each election needs to have their status updated, and if so update it
	public function UpdateElections()
	{
		$elections = $this->GetElections();

		foreach($elections as $election)
		{
			if($this->IsActive($election['start_time']))
			{
				$this->db->where('id', $election['id']);
				$this->db->update('election', array('status' => 'Active'));
			}
			else
			{
				$this->db->where('id', $election['id']);
				$this->db->update('election', array('status' => 'Upcoming'));
			}
			if($this->IsActive($election['end_time']))
			{
				$this->db->where('id', $election['id']);
				$this->db->update('election', array('status' => 'Closed'));
			}
		}
	}

}
