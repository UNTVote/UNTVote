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

    // GetCollegesNotLike - selects all colleges from the database that are not like a string
    // $string - the college that we do not want to include
    public function GetCollegesNotLike($string)
    {
        $query = $this->db->select('*')->from('colleges')->not_like('description', $string)->get();
        return $query->result_array();
    }
}