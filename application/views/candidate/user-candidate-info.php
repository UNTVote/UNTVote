        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Candidate Information</h1>
             <div class="fade-on-load" hidden>
            <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 block-center">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><?=$candidate->first_name?> <?=$candidate->last_name?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 block-center">
                            <img src="<?=base_url() . $candidate->avatar?>" alt="..." class="img-circle center-block" width="200" height="200">
                            <br>
                            <h3>About Me: </h3>
                             <p><?=$candidate->about_me?></p>
                             <h3>Goals: </h3>
                             <p><?=$candidate->goals?></p>
                            <h3>Participating Election(s):</h3>
                            <div class="list-group">
                            <?php foreach($elections as $election):?>
                              <a href="<?=site_url('elections/' . $election['slug'])?>" class="list-group-item"><?=$election['election_name']?></a>
                            <?php endforeach?>
                            </div>
                            <h3>College:</h3>
                            <span class="label label-info"><?=$college?></span>
                            <h3>My Contact Info:</h3>
                            <p>Email : <?=$candidate->email?></p>
                    </div>
                </div>
                    
              </div>
            </div>
            </div>
        
      </div>
        </div>
    </div>
      </div>