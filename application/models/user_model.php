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
    	$query = $this->db->query("SELECT users.first_name, users_colleges.user_id, users.last_name,users.last_login,users.created_on,colleges.description AS college,groups.name as role 
    							  FROM users,colleges,users_colleges,groups,users_groups 
    							  WHERE colleges.description NOT LIKE '%All%' 
    							  AND users_colleges.user_id=users.id 
    							  AND users_colleges.college_id=colleges.id 
    							  AND users_groups.group_id=groups.id 
    							  AND users_groups.user_id=users.id");

    	return $query->result_array();
    }

    // GetUsersCollege - Returns the college of the user, but not all
    // usedID - the usersID to get the college for
    public function GetUsersCollege($userID)
    {
        $query = $this->db->query("SELECT users.first_name, users_colleges.user_id, users.last_name, colleges.description
                                    FROM users, colleges, users_colleges WHERE colleges.description NOT LIKE '%All%' 
                                    AND users_colleges.user_id=users.id AND users_colleges.college_id=colleges.id AND users.id = " . $userID);
        return $query->row_array()['description'];
    }

    // DeleteUser - deletes the user from all the election tables
    // userID - the user to delete
    public function DeleteUser($userID)
    {
        $this->db->where('user_id', $userID);
        $this->db->delete('voters');

        $this->db->where('candidate_id', $userID);
        $this->db->delete('election_candidates');

        $this->db->where('sender_id', $userID);
        $this->db->delete('admin_notifications');
    }
}