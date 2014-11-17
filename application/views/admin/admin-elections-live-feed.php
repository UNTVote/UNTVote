        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Live feed</h1>
          <br>

          <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 block-center fade-on-load" hidden>

              <div class="row">
                <div class="col-xs-12">
                  <?php if($numberElections <= 0): ?>
                    <h3 class='text-muted text-center'>Oops, there are no elections.  Please check back later</h3>
                  <?php else:?>
                    <label>Election</label>
                  <select name="elections" class="form-control" id="liveElectionsList">
                    <option value="" disabled selected>Choose election</option>
                  <?php foreach($elections as $election) : ?>
                    <option value="<?=$election['id']?>"><?=$election['election_name']?></option>
                  <?php endforeach?>
                  </select>
                <?php endif?>
                </div>
              </div>

              <br>

              <div class="alert alert-danger" role="alert" id="liveDataError" hidden>Oops, can't load live data right now.</div>

              <div class="panel panel-default" id="liveFeedPanel" hidden>
                <div class="panel-heading">
                  <h3 class="panel-title hide-text-overflow" id="electionName">Election name</h3>
                </div>

                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-11 block-center">

                      <h4 class="text-center" id="leadingCandidate">No votes yet</h4>

                      <canvas id="liveFeedChart" class="bar-chart" hidden></canvas>

                      <br><br>

                      <h4 class="text-center">Statistics</h4>
                      <br>

                      <div class="row">
                        <div class="col-xs-12 col-sm-6">
                          <ul class="list-inline">
                            <li><strong>Total votes:</strong></li>
                            <li><p id="totalVotes">0</p></li>
                          </ul>
                          <ul class="list-inline">
                            <li><strong>Registered voters:</strong></li>
                            <li><p id="registeredVoters">0</p></li>
                          </ul>
                          <ul class="list-inline">
                            <li><strong>Total candidates:</strong></li>
                            <li><p id="totalCandidates">0</p></li>
                          </ul>
                        </div>
                        <div class="col-xs-12 col-sm-6 text-right-sm">
                          <ul class="list-inline">
                            <li><strong>Start date:</strong></li>
                            <li><p id="startDate">00/00/00</p></li>
                          </ul>
                          <ul class="list-inline">
                            <li><strong>End date:</strong></li>
                            <li><p id="endDate">00/00/00</p></li>
                          </ul>
                          <ul class="list-inline">
                            <li><strong>Category:</strong></li>
                            <li><p id="electionCategory">Empty</p></li>
                          </ul>
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
