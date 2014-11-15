        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Results</h1>
          <br>
          
          <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 block-center fade-on-load" hidden>
            
              <div class="row">
                <div class="col-xs-12">
                  <label>Choose election</label>
                  <select name="elections" class="form-control">
                  <?php foreach($elections as $election) : ?>
                    <option value="<?=$election['id']?>"><?=$election['election_name']?></option>
                  <?php endforeach?>
                  </select>
                </div>
              </div>
              
              <br>
              
              
              <div class="panel panel-default">
                <div class="panel-heading">              
                  <h3 class="panel-title">Election XYZ <span class="text-muted">- (08/21/14 - 09/12/14)</span></h3>
                  
                  
                </div>
                
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-11 block-center">
                      <br>
                      
                      <div class="row">
                        <div class="col-xs-12">
                          <canvas id="resultsChart" class="bar-chart"></canvas>
                        </div>
                      </div>

                      <br><br>
                      
                      <div class="row">
                        <div class="col-xs-12">
                          <ul class="list-inline election-winners">
                            <li><h1>1.</h1></li>
                            <li><img src="../../../assets/img/user-default.png" class="img-circle img-thumbnail" width="70"></li>
                            <li>
                              <ul class="list-unstyled">
                                <li><H4>Steve Jobs</H4></li>
                                <li class="text-muted">94 votes</li>
                              </ul>
                            </li>
                          </ul>
                        </div>
                        <div class="col-xs-12">
                          <ul class="list-inline election-winners">
                            <li class="lol"><h1>2.</h1></li>
                            <li><img src="../../../assets/img/user-default.png" class="img-circle img-thumbnail" width="70"></li>
                            <li>
                              <ul class="list-unstyled">
                                <li><H4>Jony Ive</H4></li>
                                <li class="text-muted">86 votes</li>
                              </ul>
                            </li>
                          </ul>
                        </div>
                      </div>
                      
                      <h4 class="text-center">Statistics</h4>
                      <br>
                      
                      <div class="row">
                        <div class="col-xs-12 col-sm-6">
                          <ul class="list-inline">
                            <li><strong>Total votes</strong></li>
                            <li><p>35</p></li>
                          </ul>
                          <ul class="list-inline">
                            <li><strong>Registered voters</strong></li>
                            <li><p>56</p></li>
                          </ul>
                        </div>
                        <div class="col-xs-12 col-sm-6 text-right-sm">
                          <ul class="list-inline">
                            <li><strong>Total candidates:</strong></li>
                            <li><p>3</p></li>
                          </ul>
                          <ul class="list-inline">
                            <li><strong>Category:</strong></li>
                            <li>College of engineering</li>
                          </ul>
                        </div>
                      </div>
                      
                      <br>

                      <h4 class="text-center">Actions</h4>
                      <br>
                      
                      <div class="row">
                        <div class="col-xs-12 col-sm-4">
                          <button class="btn btn-block btn-primary">
                            <span class="glyphicon glyphicon-print"></span> Print
                          </button>
                        </div>
                        <div class="col-xs-12 visible-xs">&nbsp;</div>
                        <div class="col-xs-12 col-sm-4">
                          <button class="btn btn-block btn-success">
                            <span class="glyphicon glyphicon-envelope"></span> Email
                          </button>
                        </div>
                        <div class="col-xs-12 visible-xs">&nbsp;</div>
                        <div class="col-xs-12 col-sm-4">
                          <button class="btn btn-block btn-warning">
                            <span class="glyphicon glyphicon-download"></span> Download
                          </button>
                        </div>
                      </div>
                      <br>
                      
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>