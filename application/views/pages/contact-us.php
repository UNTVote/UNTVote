<!-- Main body content -->

      <div class="col-xs-11 col-sm-10 col-md-8 col-lg-6 panel panel-default block-center fade-on-load" hidden>
          <h1>Contact us</h1>
          <hr>
          <br>

          <div class="col-xs-12block-center">
            <form method="post" accept-charset="utf-8" action="<?=site_url('contact/SendMail')?>" class="form-horizontal col-md-10 col-lg-8 block-center" id="register" role="form" data-parsley-validate>
              <div class="form-group">
                <label>Name</label>
                <div class="row">
                  <div class="col-sm-5">
                    <input name="firstName" type="text" class="form-control" value="" placeholder="First name" data-parsley-trigger="keyup" required autofocus>
                  </div>
                  <div class="col-sm-7">
                    <input name="lastName" type="text" class="form-control" value="" placeholder="Last name" data-parsley-trigger="keyup" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Email</label>
                  <input name ="email" type="email" class="form-control" value="" placeholder="Your Email address" data-parsley-trigger="keyup" required>
              </div>
              <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="5" placeholder="Your message or question" data-parsley-trigger="keyup" data-parsley-minlength="50"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Send</button>
              </div>
            </form>
            <br>
          </div>
        </div>

  </div>
</div>