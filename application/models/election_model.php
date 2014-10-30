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
		
		if($this->IsActive($startDate))
		{
			$status = "active";
		}
		else
		{
			$status = "inactive";
		}

		// data array to insert into the table
		$data = array('election_name' => $electionName,
					  'election_description' => $electionDescription,
					  'slug' => $slug,
					  'start_time' => $startDate,
					  'end_time' => $endDate,
					  'college_id' => $college,
					  'total_votes' => 0,
					  'status' => $status);
		// insert into the table
		return $this->db->insert('election', $data);
	}

	// IsActive - IsActive is a helper function that determines whether an election should be active
	// startDate - the date to check whether or not it is active
	// Returns - returns true if start date is today or earlier, false otherwise
	private function IsActive($startDate)
	{
		// set the timezone to central
		date_default_timezone_set('America/Chicago');
		if(strtotime($startDate) > time())
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
		// if the start date is < the current date we update its status to active
		//$query = $this->db->query('UPDATE election SET status="active" WHERE "start_date" < DATEADD(day, DATEDIFF(day,0');

		// if the end date is < the current date we update its status to inactive
		//$query = $this->db->query('UPDATE election SET status="inactive" WHERE "end_date" < CURDATE()');
		$elections = $this->GetElections();

		foreach($elections as $election)
		{
			if($this->IsActive($election['start_time']))
			{
				$this->db->where('id', $election['id']);
				$this->db->update('election', array('status' => 'active'));
			}
			else
			{
				$this->db->where('id', $election['id']);
				$this->db->update('election', array('status' => 'inactive'));
			}
		}
	}

}
