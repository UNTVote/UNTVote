<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Account Successfully Created';
$lang['account_creation_unsuccessful'] 	 	 = 'Unable to Create Account';
$lang['account_creation_duplicate_email'] 	 = 'Email Already Used or Invalid';
$lang['account_creation_duplicate_username'] = 'Username Already Used or Invalid';

// Password
$lang['password_change_successful'] 	 	 = 'Password Successfully Changed';
$lang['password_change_unsuccessful'] 	  	 = 'Unable to Change Password';
$lang['forgot_password_successful'] 	 	 = 'Password Reset Email Sent';
$lang['forgot_password_unsuccessful'] 	 	 = 'Unable to Reset Password';

// Activation
$lang['activate_successful'] 		  	     = 'Account Activated';
$lang['activate_unsuccessful'] 		 	     = 'Unable to Activate Account';
$lang['deactivate_successful'] 		  	     = 'Account De-Activated';
$lang['deactivate_unsuccessful'] 	  	     = 'Unable to De-Activate Account';
$lang['activation_email_successful'] 	  	 = 'Activation Email Sent';
$lang['activation_email_unsuccessful']   	 = 'Unable to Send Activation Email';

// Login / Logout
$lang['login_successful'] 		  	         = 'Logged In Successfully';
$lang['login_unsuccessful'] 		  	     = 'Incorrect Login';
$lang['login_unsuccessful_not_active'] 		 = 'Account is inactive';
$lang['login_timeout']                       = 'Temporarily Locked Out.  Try again later.';
$lang['logout_successful'] 		 	         = 'Logged Out Successfully';

// Account Changes
$lang['update_successful'] 		 	         = 'Account Information Successfully Updated';
$lang['update_unsuccessful'] 		 	     = 'Unable to Update Account Information';
$lang['delete_successful']               = 'User Deleted';
$lang['delete_unsuccessful']           = 'Unable to Delete User';

// Groups
$lang['group_creation_successful']  = 'Group created Successfully';
$lang['group_already_exists']       = 'Group name already taken';
$lang['group_update_successful']    = 'Group details updated';
$lang['group_delete_successful']    = 'Group deleted';
$lang['group_delete_unsuccessful'] 	= 'Unable to delete group';
$lang['group_name_required'] 		= 'Group name is a required field';

// Colleges
$lang['college_creation_successful']  = 'College created Successfully';
$lang['college_already_exists']       = 'College name already taken';
$lang['college_update_successful']    = 'College details updated';
$lang['college_delete_successful']    = 'College deleted';
$lang['college_delete_unsuccessful']  = 'Unable to delete college';
$lang['college_name_required']        = 'College name is a required field';


// Activation Email
$lang['email_activation_subject']            = 'Account Activation';
$lang['email_activate_heading']    = 'Activate account for %s';
$lang['email_activate_subheading'] = 'Please click this link to %s.';
$lang['email_activate_link']       = 'Activate Your Account';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Forgotten Password Verification';
$lang['email_forgot_password_heading']    = 'Reset Password for %s';
$lang['email_forgot_password_subheading'] = 'Please click this link to %s.';
$lang['email_forgot_password_link']       = 'Reset Your Password';

// New Password Email
$lang['email_new_password_subject']          = 'New Password';
$lang['email_new_password_heading']    = 'New Password for %s';
$lang['email_new_password_subheading'] = 'Your password has been reset to: %s';

// Voting 
$lang['vote_successful'] = 'Thank you, your vote has been successfully submitted';
$lang['vote_already_voted'] = 'Your vote was not submitted, as you have already voted for this candidate';
$lang['vote_changed'] = 'Your vote has been successfully changed';

// Elections
$lang['create_election_successful'] = 'The election has been successfully created';
$lang['edit_election_successful'] = 'The election has been successfully updated';
$lang['delete_election_successful'] = 'The election has been successfully deleted';

// Notification and Approvals
$lang['notification_approval_sent'] = 'Your request has been sent to the voting administrators, and you will receive an email soon';
$lang['notification_approval_notsent'] = 'We already have your request; You will receive an email soon';

// Candidate profile
$lang['candidate_profile_updated'] = 'Your candidate information has been updated';

// contact us 
$lang['email_sent'] = 'Thank you for contacting us!  We wil get back to you as soon as we can';
