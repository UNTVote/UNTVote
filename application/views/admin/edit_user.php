<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

      <p>
            <?php echo lang('edit_user_euid_label', 'euid');?> <br />
            <?php echo form_input($euid);?>
      </p>
      
      <p>
            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </p>

      <p>
            <?php echo lang('edit_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
            <?php echo form_input($password_confirm);?>
      </p>
      
      <!-- the college dropdown list -->
      <?php if($this->ion_auth->is_admin()): ?>
          <!-- output the heading -->
          <h3><?php echo lang('user_user_college_heading');?></h3>
          <!-- create the dropdown list -->
          <select name = "colleges[]">
              <!-- for each college that we have -->
              <?php foreach($options as $college):?>
                  <!-- create an option for that college -->
                  <?php
                    $cID = $college['id'];
                    $default = null;
                    $item = null;
                    // default college
                    foreach($collegeDefault as $clg)
                    {
                        if($cID == $clg->id)
                        {
                            $default = ' selected = "selected"';
                        }
                        break;
                    }
                  ?>
                  <option value = "<?php echo $college['id'];?>"<?php echo $default;?>>
                  <?php echo htmlspecialchars($college['description'], ENT_QUOTES, 'UTF-8');?>
              <?php endforeach?>   
          </select>
      <?php endif?>

      <?php if ($this->ion_auth->is_admin()): ?>

          <h3><?php echo lang('edit_user_groups_heading');?></h3>
          <?php foreach ($groups as $group):?>
              <label class="checkbox">
              <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) 
                  {
                      if ($gID == $grp->id) 
                      {
                          $checked= ' checked="checked"';
                      break;
                      }
                  }
              ?>
              <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
              </label>
          <?php endforeach?>

      <?php endif ?>
      
      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p>

<?php echo form_close();?>
