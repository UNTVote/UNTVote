        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Edit user</h1>
          <br>

          <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 block-center fade-on-load" hidden>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><?=$user->first_name?> <?=$user->last_name?></h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12 text-center">
                      <img src="<?=base_url() . $user->avatar?>" class="img-circle img-thumbnail" width="100">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-12 col-md-9 block-center">
                      <form method="post" accept-charset="utf-8" action="<?=site_url('admin/view_user/' . $user->id)?>" role="form" data-parsley-validate>
                        <div class="form-group">
                          <label>Name</label>
                            <div class="row">
                              <div class="col-sm-5">
                                <input name="first_name" value="<?=$user->first_name?>" type="text" class="form-control" placeholder="First name" data-parsley-trigger="keyup" required autofocus>
                              </div>
                              <div class="col-sm-7">
                                <input name="last_name" value="<?=$user->last_name?>" type="text" class="form-control" placeholder="Last name" data-parsley-trigger="keyup" required>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-xs-12">
                                <div class="form-group">
                                  <label>Email</label>
                                  <div class="input-group">
                                    <input name ="email" value="<?=$userEmail?>" type="text" class="form-control" placeholder="UNT Email address" data-parsley-trigger="keyup" data-parsley-errors-container="#error-container-email" data-parsley-type="alphanum" required>
                                    <span class="input-group-addon">@my.unt.edu</span>
                                  </div>
                                  <div id="error-container-email"></div>
                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-xs-12">
                                <div class="form-group">
                                  <label>College</label>
                                  <select name="colleges[]" class="form-control">
                                  <?php foreach($colleges as $college):?>
                                  <?php
                                    $cID = $college['id'];
                                    $selected = null;
                                    $item = null;
                                    foreach($currentColleges as $clg)
                                    {
                                      if($cID == $clg->id)
                                      {
                                        $selected = ' selected="selected"';
                                        break;
                                      }
                                    }
                                    ?>
                                    <option value="<?=$college['id']?>" <?=$selected?>><?=$college['description']?></option>
                                  <?php endforeach?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-xs-12">
                                <div class="form-group">
                                  <label>Role</label>
                                  <select name="groups[]" class="form-control">
                                  <?php foreach ($groups as $group):?>
                                  <?php
                                    $gID=$group['id'];
                                      $checked = null;
                                      $item = null;
                                      foreach($currentGroups as $grp)
                                      {
                                        if ($gID == $grp->id)
                                        {
                                          $checked= ' selected="selected"';
                                          break;
                                        }
                                      }
                                  ?>
                                    <option value="<?=$group['id']?>" <?=$checked?>><?=$group['name']?></option>
                                  <?php endforeach?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-xs-12">
                                <div class="form-group">
                                  <label>Vote cost</label>
                                  <div class="row">
                                    <div class="col-xs-10">
                                      <input id="voteCostSlider" type="range" min="1" max="5" value="1">
                                    </div>
                                    <div class="col-xs-2 text-right">
                                      <strong id="voteCostText">1X</strong>
                                    </div>
                                  </div>
                                  <small class="help-block">Increasing this value will add more weight to this users votes</small>
                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <?php echo form_hidden('id', $user->id);?>
                              <?php echo form_hidden($csrf); ?>
                              <div class="col-xs-12 col-sm-6 col-sm-push-6">
                                <button class="btn btn-primary btn-block">Save changes</button>
                              </div>
                              <div class="col-xs-12 visible-xs">&nbsp;</div>
                              <div class="col-xs-12 col-sm-6 col-sm-pull-6">
                                <a href="<?=site_url('admin/delete_user/' . $user->id)?>" class="btn btn-danger btn-block">Delete</a>
                              </div>
                            </div>
                          </div>
                      </form>
                    </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>