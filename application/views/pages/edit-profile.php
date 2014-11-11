        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Edit profile</h1>
          <br>
          
          <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 block-center fade-on-load" hidden>
              <div class="panel panel-default">
                <div class="panel-body">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
                    <!-- only display the candidate tab if they are a candidate -->
                    <?php if($isCandidate):?>
                      <li role="presentation"><a href="#candidate" role="tab" data-toggle="tab">Candidate</a></li>
                    <?php endif?>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="general">
                      <br>
                      <div class="col-xs-12 col-md-3 text-center">
                        <img class="img-circle img-thumbnail" width="100" src="<?=asset_url()?>img/user-default.png" alt="My picture">
                      </div>
                      <div class="col-xs-12 visible-xs visible-sm">&nbsp;</div>
                      <div class="col-xs-12 col-md-9">
                        <form method="post" accept-charset="utf-8" action="<?=site_url('user/edit_user/' . $user->id)?>" role="form" data-parsley-validate>
                          <div class="form-group">
                            <label>Name</label>
                            <div class="row">
                              <div class="col-sm-5">
                                <input name="firstName" type="text" class="form-control" value="<?=$user->first_name?>" placeholder="First name" data-parsley-trigger="keyup" required autofocus>
                                <div class="col-xs-12 visible-xs">&nbsp;</div>
                              </div>
                              <div class="col-sm-7">
                                <input name="lastName" type="text" class="form-control" value="<?=$user->last_name?>" placeholder="Last name" data-parsley-trigger="keyup" required>
                              </div>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label>College</label>
                            <select name="colleges[]" class="form-control">
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
                          </div>
                          <div class="form-group">
                            <label>Email</label>
                            <div class="input-group">
                              <input name ="email" type="text" class="form-control" value="<?=$userEmail?>" placeholder="Your UNT Email address" data-parsley-trigger="keyup" data-parsley-errors-container="#error-container-email" data-parsley-type="alphanum" required>
                              <span class="input-group-addon">@my.unt.edu</span>
                            </div>
							<div id="error-container-email"></div>
                          </div>
                          <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="Atleast 8 characters" data-parsley-trigger="change keyup" data-parsley-minlength="8">
                          </div>
                          <div class="form-group" id="confirmPassGroup" hidden>
                            <label>Confirm password</label>
                            <input name="password_confirm" type="password" class="form-control" id="confirmPass" placeholder="Re-type your new password" data-parsley-trigger="keyup" data-parsley-equalto="#password">
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-xs-12">
                              <?php echo form_hidden('id', $user->id);?>
                              <?php echo form_hidden($csrf); ?>
                              <button name="submit" id="submit" type="submit" class="btn btn-primary btn-block">Save changes</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="candidate">
                      <br>
                      <div class="form-group">
                        <label>About me</label>
                        <textarea class="form-control" rows="3" placeholder="Explain a little bit about your self"></textarea>
                      </div>
                      <div class="form-group">
                        <label>What to expect</label>
                        <textarea class="form-control" rows="3" placeholder="Describe your goals, contributing and services you can offer"></textarea>
                      <br>
                      <div class="row">
                        <div class="col-xs-12">
                          <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
   
      </div>
    </div>
