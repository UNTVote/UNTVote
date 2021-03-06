<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<div id="loginForm">
<?php echo form_open("user/register");?>
      <p>     
            <?php echo lang('create_user_college_lavel', 'colleges');?>      
-           <select name = "colleges[]">     
-              <!-- for every college that we have -->      
-              <?php foreach($options as $college):?>       
-                  <option value = "<?php echo $college['id'];?>">      
-                      <?php echo htmlspecialchars($college['description'], ENT_QUOTES, 'UTF-8');?>     
-                  </option>        
-              <?php endforeach?>           
-           </select>        
-     </p>
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
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>


      <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

<?php echo form_close();?>
</div>

