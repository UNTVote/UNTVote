        <!-- Main body content -->
        <div class="col-xs-12">
          <div class="panel panel-default panel-user-auth block-center">
            <div class="panel-heading">
              <h3 class="panel-title">Reset password</h3>
            </div>
            <div class="panel-body">
            <?php if($message != NULL):?>
                  <div id="message" class="alert alert-danger"><?php echo $message;?></div>
                </div>
            <?php endif;?>
              <form method="post" accept-charset="utf-8" action="<?=site_url('admin/reset_password/' . $code)?>" role="form" id="reset" data-parsley-validate>
                <div class="form-group">
                  <label>New password</label>
                  <input type="password" class="form-control" name ="newPassword" id="newPassword" placeholder="Minimum 8 characters" data-parsley-minlength="8" data-parsley-trigger="change" required>
                </div>
                <div class="form-group">
                  <label>Confirm password</label>
                  <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Re-type new password"  data-parsley-trigger="change" required data-parsley-equalto="#newPassword">
                </div>
                <div class="form-group">
                	<?php echo form_input($user_id);?>
					<?php echo form_hidden($csrf); ?>
                </div>
                <button name="submit" id="submit" type="submit" class="btn btn-default">Save</button>
              </form>
            </div>
          </div>
        </div>
        
        <br>
      </div>
    </div>