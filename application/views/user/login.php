

 
        <!-- Main body content -->
        <div class="col-xs-12">
          <div class="panel panel-default panel-user-auth block-center">
            <div class="panel-heading">
              <h3 class="panel-title">Sign in</h3>
            </div>
            <div class="panel-body">
            <div id="infoMessage"><?php echo $message;?></div>
              <form method="post" accept-charset="utf-8" action="<?=site_url('user/login')?>" id="login" role="form">
                <div class="form-group">
                  <label>EUID</label>
                  <input name="identity" id="identity" type="text" class="form-control" placeholder="UNT EUID">
                </div>
                <div class="form-group">
                  <label>Password <?=anchor('user/forgot_password', '(Forgot?)', array('tabindex' => '-1'))?></label> 
                  <input name="password" id="password" type="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Sign in</button>
              </form>
            </div>
          </div>
        </div>
        
        <br>
      </div>
    </div>

    <!-- Footer area -->
    <div class="footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-6">
            <p class="footer-text">&copy; 2014 UNT Vote</p>
          </div>
          <div class="col-xs-6 text-right">
            <a href="#" class="footer-text">Contact</a>
            &nbsp;
            <a href="#" class="footer-text">Help</a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- All scripts go below this area -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>
