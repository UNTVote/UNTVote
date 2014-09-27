<! navigation area!>
<?=anchor('/', 'Home | ')?>
<?=anchor('/about', 'About | ')?>

<! display Login or Logout depending on whether or not they are logged in !>
<?php if($loggedIn == FALSE): ?>
    <! display Login and Register for the user !>
    <?=anchor('user/login', 'Log In|')?>
    <?=anchor('user/register', "Register")?>
    
<?php else: ?>
    <?=anchor('user/logout', 'Log Out')?>
    <?php if($isAdmin): ?>
        <?=anchor('auth', '|Admin Panel')?>
    <?php endif; ?>
<?php endif; ?>
<hr>