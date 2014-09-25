<! login view !>
<! displays the login form !>

<! output the heading and subheading that is is in the auth_lang.php file !>
<h1><?php echo lang('login_heading');?></h1>
<p><?php echo lang('login_subheading');?></p>

<! display all messages (like error messages) !>
<div id="infoMessage"><?php echo $message;?></div>

<! using CodeIgniter form helper functions !>
<?php echo form_open("auth/login");?>

  <p>
      <! textbox for the users ID !>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </p>

  <p>
      <! textbox for the password !>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </p>

  <p>
      <! remember the users password checkbox !>
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>

  <! submit button to login !>
  <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>

<?php echo form_close();?>

<! forgot password link !>
<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>