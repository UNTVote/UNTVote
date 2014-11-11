        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Elections</h1>
          <br>

          <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 block-center fade-on-load" hidden>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><?=$election['election_name']?></h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <p><?=$election['election_description']?></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-12">
                      <span class="label label-success"><?=date("m-d-Y", strtotime($election['start_time'])) ?> - <?=date("m-d-Y", strtotime($election['end_time'])) ?></span>
                      <span class="label label-primary">College of engineering</span>
                    </div>
                  </div>
                  <br>

                  <div class="row">
                    <div class="col-xs-12">
                      <h4>Candidates:</h4>
                      <?php foreach($candidates as $candidate): ?>
                        <img src="<?=asset_url()?>img/user-default.png" class="img-circle img-thumbnail" width="70" data-toggle="popover" data-trigger="hover" data-placement="top" title="<?=$candidate['first_name']?> <?=$candidate['last_name']?>" data-content="<?=$candidate['about_me']?>">
                      <?php endforeach?>
                    </div>
                  </div>
                  <br><br>

                  <div class="row">
                    <div class="col-xs-12" hidden>
                      <a href="#" class="btn btn-primary btn-block">Request to vote</a>
                    </div>
                    <div class="col-xs-12" hidden>
                      <a href="#" class="btn btn-default btn-block" disabled>Pending request to vote..</a>
                    </div>
                    <div class="col-xs-12">
                      <h4>Cast your vote:</h4>
                      <form name="vote" action="<?=site_url('elections/' . $election['slug'])?>" method="post" role="form">
                        <ul class="list-inline">
                        <?php foreach($candidates as $candidate): ?>
                          <li>
                            <div class="radio">
                              <label>
                                <input type="radio" name="candidate" value="<?=$candidate['candidate_id'];?>">
                                <?=$candidate['first_name']?> <?=$candidate['last_name']?>
                              </label>
                            </div>
                          </li>
                        <?php endforeach?>
                        </ul>
                        <input type="submit" class="btn btn-success btn-block" value="Submit Vote">
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