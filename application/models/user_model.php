<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model
{
	// constructor - sets up the model, load the database, and libraries
    public function __construct()
    {
        $this->load->database();
        $this->load->model('ion_auth_model');
        $this->load->library('ion_auth');
    }

    // GetsUsersAjax - Ajax method of geting the users
    // Returns first_name, last_name, college, role
    public function GetsUsersAjax()
    {
    	$query = $this->db->query("SELECT users.first_name,users.last_name,users.last_login,users.created_on,colleges.description AS college,groups.name as role 
    							  FROM users,colleges,users_colleges,groups,users_groups 
    							  WHERE colleges.description NOT LIKE '%All%' 
    							  AND users_colleges.user_id=users.id 
    							  AND users_colleges.college_id=colleges.id 
    							  AND users_groups.group_id=groups.id 
    							  AND users_groups.user_id=users.id");

    	return $query->result_array();
    }
}