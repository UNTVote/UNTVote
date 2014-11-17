        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Candidates</h1>
            <div class="fade-on-load" hidden>
                <div class="text-right">
                <?php
                  $candidateLink = (!$this->ion_auth->in_group('candidates')) ? '<a href="' . site_url('notifications/SendCandidateNotification/') . '" class="btn btn-info" role="button">Become a Candidate</a>' : ' ';
                ?>
                <?=$candidateLink?>
                <!--<a href="#" class="btn btn-info btn-lg active" role="button">Become a Candidate</a>-->
                </div>
                <br>

                <div class="well well-sm">
                    <div class="row">
                    <?php foreach($candidates as $candidate):?>
                      <div class="col-sm-3 col-md-2">
                        <div class="thumbnail">
                          <br>
                          <img class="img-circle img-thumbnail" width="100" src="<?=base_url() . $candidate->avatar?>" alt="<?=$candidate->first_name?> <?=$candidate->last_name?>">
                          <div class="caption text-center">
                            <h5><?=$candidate->first_name?> <?=$candidate->last_name?></h5>
                            <h5><?=$this->user_model->GetUsersCollege($candidate->id)?></h5><br />
                            <p><a href="<?=site_url('candidates/view/' . $candidate->id)?>" class="btn btn-info" role="button">Profile</a></p>
                          </div>
                        </div>
                      </div>
                    <?php endforeach?>
                    </div>
                </div>

            </div>
        </div>
      </div>
    </div>