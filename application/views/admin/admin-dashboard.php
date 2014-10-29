        
        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
          
          <div class="row">
            <div class="col-xs-12">
              
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Overview</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                      <h4><span class="info-circle info-circle-red">12</span> Approval requests</h4>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                      <h4><span class="info-circle info-circle-blue"><?=$numberActiveElections?></span> Active elections</h4>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                      <h4><span class="info-circle info-circle-green">83</span> Registered students</h4>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                      <h4><span class="info-circle info-circle-yellow"><?=$numberUpcomingElections?></span> Upcoming elections</h4>
                    </div>
                  </div>
                </div>
              </div>

              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Active elections</h3>
                </div>
                <div class="panel-body">
                  <br>
                  <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Election</th>
                          <th>Ends on</th>
                          <th>Total votes</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($activeElections as $activeElection) : ?>
                          <tr>
                          <td><?=$activeElection['election_name'] ?></td>
                          <td><?=date("m-d-Y", strtotime($activeElection['end_time'])) ?></td>
                          <td>
                            <div class="progress" style="margin-bottom: 0px;">
                              <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 10%;"><?=$activeElection['total_votes']?> / 54</div>
                            </div>
                          </td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Upcoming elections</h3>
                </div>
                <div class="panel-body">
                  <br>
                  <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Election</th>
                          <th>Starts on</th>
                          <th>Candidates</th>
                          <th>Voters</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($upcomingElections as $upcomingElection) : ?>
                          <tr>
                          <td><?=$upcomingElection['election_name'] ?></td>
                          <td><?=date("m-d-Y", strtotime($upcomingElection['start_time'])); ?></td>
                          <td>0</td>
                          <td>0</td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
                  
        </div>
      </div>
    </div>