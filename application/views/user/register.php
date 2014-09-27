<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<div id="loginForm">
<?php echo form_open("user/register");?>

      <p>
            <?php echo lang('create_user_euid_label', 'euid');?> <br />
            <?php echo form_input($euid);?>
      </p>
      <p>
            <?php echo lang('create_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <?php echo lang('create_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </p>

      <p>
            <?php echo lang('create_user_email_label', 'email');?> <br />
            <?php echo form_input($email);?>
      </p>
      
      <p>
          <?php echo lang('create_user_validation_college_label'); ?><br />
          <?php echo form_dropdown('college', $options, 'engineering'); ?>
      </p>

      <p>
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

<?php echo form_close();?>
</div>

