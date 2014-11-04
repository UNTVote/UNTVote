<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Election_Model extends CI_Model
{
	// constructor - sets up the model, load the database, and libraries
    public function __construct()
    {
        $this->load->database();
        $this->load->model('ion_auth_model');
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
		
		$userColleges = array();
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

		// format the dates to SQL date format
		$newStartDate = date('Y-m-d', strtotime($startDate));
		$newEndDate = date('Y-m-d', strtotime($endDate));
		
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
					  'start_time' => $newStartDate,
					  'end_time' => $newEndDate,
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
		
		$this->ion_auth_model->set_message('create_election_successful');
	}

	// Vote - Takes in who the user voted for and deals with the total votes
	// userID - the ID of the user who voted
	// electionID - the ID of the election they voted on
	public function Vote($userID, $electionID)
	{
		// grab the candidate the user voted for
		$candidate = $this->input->post('candidate');

		// first check if the user has already voted
		if($this->HasUserVoted($userID, $electionID))
		{
			// find out who they voted for
			$this->db->where('voter_id', $userID);
			$this->db->where('election_id', $electionID);
			$this->db->select('candidate_id');
			$query = $this->db->get('vote_log');
			$result = $query->row_array();
			// voting for same candidate, if so, do nothing
			if($candidate == $result['candidate_id'])
			{
				$this->ion_auth_model->set_error('vote_already_voted');
				return false;
			}
			// otherwise, take a vote away from the other candidate
			else
			{
				$this->db->where('election_id', $electionID);
				$this->db->where('candidate_id', $result['candidate_id']);
				// do not protect the query with backticks (') to generate the correct query.
				$this->db->set('votes', 'votes-1', FALSE);
				$this->db->update('election_candidates');

				// clear their previous vote from the vote log
				$this->db->where('voter_id', $userID);
				$this->db->where('election_id', $electionID);
				$this->db->delete('vote_log');
				$this->ion_auth_model->set_message('vote_changed');
				// next query run will add one to the candidate they voted for
			}
		}

		// add one to the candidate they voted for, for this election
		$this->db->where('election_id', $electionID);
		$this->db->where('candidate_id', $candidate);
		// do not protect the query with backticks (') to generate the correct query.
		$this->db->set('votes', 'votes+1', FALSE);
		$this->db->update('election_candidates');

		// update the total votes for the election table
		$this->UpdateElectionVotes($electionID);

		// add to the vote log
		$this->db->insert('vote_log', array('election_id' => $electionID, 'candidate_id' => $candidate, 'voter_id' => $userID));
		$this->ion_auth_model->set_message('vote_successful');
		return true;
	}

	// UpdateElectionVotes - updates the election tables total number of votes
	// election - the election to update the total number of votes
	private function UpdateElectionVotes($election)
	{
		// get how many votes this election now has and udpate the election table
		$this->db->where('election_id', $election);
		$this->db->select_sum('votes', 'total_votes');
		$query = $this->db->get('election_candidates');
		$result = $query->row_array();
		$totalVotes = $result['total_votes'];

		// now update the election table
		$this->db->where('id', $election);
		$this->db->set('total_votes', $totalVotes);
		$this->db->update('election');
	}

	// HasUserVoted - Checks to see if a user has voted
	// userID - The user we are checking
	// electionID - the election we are seeing they have voted on
	// Returns - true if the user has voted already, false if they have not
	private function HasUserVoted($userID, $electionID)
	{
		$query = $this->db->select('voter_id')->from('vote_log')->where('election_id', $electionID)->where('voter_id', $userID)->get();
		$result = $query->num_rows();
		
		// one or more rows were found, the user has voted
		if($result >= 1)
		{
			return true;
		}
		else
		{
			return false;
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
			// update all the election votes
			$this->UpdateElectionVotes($election['id']);
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
