    <!-- Main body content -->
    <div class="container-fluid">
      <div class="row fade-on-load" hidden>
        <br>
        <div class="col-xs-12">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-7">
              <div class="col-lg-10 block-center">
                <h1>Let your voice be heard! </h1>
                <br>
                <h4>Welcome to the online voting platform of University of North Texas. We conduct elections year round for many of our college organizations. </h4>
                <br>
                <div class="media">
                  <a class="pull-left" href="#">
                    <!-- <img class="media-object site-features" src="../assets/img/elections.png" alt="Elections"> -->
                    <img class="media-object site-features" src="<?=img_url()?>elections.png" alt="Elections">
                  </a>
                  <div class="media-body">
                    <h4 class="media-heading">Elections</h4>
                    <p>Browse elections, candidates and vote. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquet odio ante, eu molestie urna commodo et. Donec consectetur aliquam nisi.</p>
                  </div>
                </div>
                <div class="media">
                  <a class="pull-left" href="#">
                    <!-- <img class="media-object site-features" src="../assets/img/results.png" alt="Results"> -->
                    <img class="media-object site-features" src="<?=img_url()?>results.png" alt="Results">
                  </a>
                  <div class="media-body">
                    <h4 class="media-heading">View results</h4>
                    <p>Browse elections, candidates and vote. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquet odio ante, eu molestie urna commodo et. Donec consectetur aliquam nisi.</p>
                  </div>
                </div>
                <div class="media">
                <a class="pull-left" href="#">
                  <!-- <img class="media-object site-features" src="../assets/img/candidate.png" alt="Become a candidate"> -->
                  <img class="media-object site-features" src="<?=img_url()?>candidate.png" alt="Become a candidate">
                </a>
                <div class="media-body">
                  <h4 class="media-heading">Become a candidate</h4>
                  <p>Browse elections, candidates and vote. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquet odio ante, eu molestie urna commodo et. Donec consectetur aliquam nisi.</p>
                </div>
              </div>
              <br>
              <h4>Register today and join the revolution.</h4>
              <br>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-5">
              
              <form method="post" accept-charset="utf-8" action="<?=site_url('user/register')?>" class="form-horizontal col-md-10 col-lg-8 block-center" id="register" role="form" data-parsley-validate>
                <?php if($message != NULL):?>
                <div class="row">
                  <?php echo $message;?>
                </div>
                <?php endif;?>
                <div class="row">
                  <h1>Register</h1>
                </div>
                <div class="form-group">
                  <label>Name</label>
                  <div class="row">
                    <div class="col-sm-5">
                      <input name="first_name" id="first_name" type="text" class="form-control" placeholder="First" required data-parsley-pattern="^[a-zA-Z]+$" data-parsley-pattern-message="Invalid name" data-parsley-required-message="Required field" data-parsley-trigger="change keyup" autofocus>
                    </div>
                    <div class="visible-xs col-xs-1">&nbsp;</div> <!-- This adds a space after textbox on small screens -->
                    <div class="col-sm-7">
                      <input name="last_name" id="last_name" type="text" class="form-control" placeholder="Last" required data-parsley-pattern="^[a-zA-Z]+$" data-parsley-pattern-message="Invalid name" data-parsley-required-message="Required field" data-parsley-trigger="change keyup">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>College</label>
                  <select name="colleges[]" class="form-control">
                    <!-- create an option for every college that we have -->      
-                   <?php foreach($options as $college):?>       
-                       <option value = "<?php echo $college['id'];?>">      
-                           <?php echo htmlspecialchars($college['description'], ENT_QUOTES, 'UTF-8');?>     
-                       </option>        
-                   <?php endforeach?>
                  </select>
                </div>
                <div class="form-group">
                  <label>EUID</label>
                  <input name ="euid" id="euid" type="text" class="form-control" placeholder="UNT EUID" required data-parsley-pattern="/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/" data-parsley-pattern-message="This EUID seems to be invalid." data-parsley-required-message="Required field" data-parsley-trigger="change keyup">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group">
                    <input name="email" id ="email" type="text" class="form-control" placeholder="UNT email" required data-parsley-type="alphanum" data-parsley-type-message="This email seems to be invalid." data-parsley-required-message="Required field" data-parsley-errors-container="#error-container-email" data-parsley-trigger="change keyup">
                    <span class="input-group-addon">@my.unt.edu</span>
                  </div>
                  <div id="error-container-email"></div>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input name="password" id="password" type="password" class="form-control" placeholder="Password" required data-parsley-minlength="8" data-parsley-minlength-message="Password should have 8 character or more." data-parsley-required-message="Required field" data-parsley-trigger="keyup">
                </div>
                <div class="form-group">
                  <br>
                  <button name="submit" id="submit" type="submit" class="btn btn-primary btn-block">Register for UNTVote</button>
                  <span class="help-block">By registering, you agree to our <?=anchor('/terms-of-service', 'Terms of Service');?></span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>