        <!-- Main body content -->
        <div class="col-xs-12">
          <div class="panel panel-default panel-user-auth block-center">
            <div class="panel-heading">
              <h3 class="panel-title">Sign in</h3>
            </div>
            <div class="panel-body">
            <?php if($message != NULL):?>
            	<?php echo $message;?>
            <?php endif; ?>
              <form method="post" accept-charset="utf-8" action="<?=site_url('auth/login')?>" id="login" role="form">
                <div class="form-group">
                  <label>EUID</label>
                  <input name="identity" id="identity" type="text" class="form-control" placeholder="UNT EUID" tabindex="1" autofocus>
                </div>
                <div class="form-group">
                  <label>Password <?=anchor('auth/forgot_password', '(Forgot?)', array('tabindex' => '-1'))?></label> 
                  <input name="password" id="password" type="password" class="form-control" placeholder="Password" tabindex="2">
                </div>
                <button type="submit" class="btn btn-default" tabindex="3">Sign in</button>
              </form>
            </div>
          </div>
        </div>
        
        <br>
      </div>
    </div>