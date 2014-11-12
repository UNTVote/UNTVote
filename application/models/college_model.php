<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class College_Model extends CI_Model
{
	// constructor - sets up the model, load the database, and libraries
    public function __construct()
    {
        $this->load->database();
    }

    // GetColleges - Selects all the colleges from the database
    public function GetColleges()
    {
    	$query = $this->db->get('colleges');
    	return $query->result_array();
    }
}