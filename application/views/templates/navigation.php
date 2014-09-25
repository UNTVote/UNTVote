
<?php
// home
echo anchor('/', 'Home|');   
echo anchor('/about', 'About|');
// select to display login or logout depending on if a user is logged in or not
if($loggedIn == FALSE)
{
    echo anchor('user/login', 'Log In|');
    echo anchor('user/register', "Register");
}
// user is logged in, let them know they can log out
else
{
    echo anchor('user/logout', 'Log Out');
    // if the user that is logged in is an admin show them a link to the admin panel
    if($isAdmin == true)
    {
        echo anchor('auth', '|Admin Panel');
    }       
}
?>