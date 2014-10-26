        <!-- Main body content -->
        <div class="col-xs-12">
          <div class="panel panel-default panel-user-auth block-center">
            <div class="panel-heading">
              <h3 class="panel-title">Forgot password</h3>
            </div>
            <div class="panel-body">
              <form method="post" accept-charset="utf-8" action="<?=site_url('admin/forgot_password')?>" id="forgot_password" role="form">
                <div class="form-group">
                  <label>Email</label>
                  <input name="email" id="email" type="email" class="form-control" placeholder="UNT Email">
                  <small class="help-block">Instructions will be sent to this email address.</small>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
              </form>
            </div>
          </div>
        </div>
        
        <br>
      </div>
    </div>