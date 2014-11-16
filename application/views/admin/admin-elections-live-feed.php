        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Live feed</h1>
          <br>
          
          <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 block-center fade-on-load" hidden>
            
              <div class="row">
                <div class="col-xs-12">
                  <label>Choose election</label>
                  <select class="form-control">
                    <option>Election XYZ</option>
                    <option>Election HRE</option>
                    <option>Election SOS</option>
                  </select>
                </div>
              </div>
              
              <br>
              
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title hide-text-overflow">Election name</h3>
                </div>
                
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-11 block-center">
                      <h4 class="text-center">Steve Jobs is leading</h4>
                      
                      <canvas id="liveFeedChart" class="bar-chart"></canvas>
                      
                      <br><br>
                      
                      <h4 class="text-center">Statistics</h4>
                      <br>
                      
                      <div class="row">
                        <div class="col-xs-12 col-sm-6">
                          <ul class="list-inline">
                            <li><strong>Total votes:</strong></li>
                            <li><p>35</p></li>
                          </ul>
                          <ul class="list-inline">
                            <li><strong>Registered voters:</strong></li>
                            <li><p>56</p></li>
                          </ul>
                        </div>
                        <div class="col-xs-12 col-sm-6 text-right-sm">
                          <ul class="list-inline">
                            <li><strong>Start date:</strong></li>
                            <li><p>08/25/14</p></li>
                          </ul>
                          <ul class="list-inline">
                            <li><strong>End date:</strong></li>
                            <li><p>10/21/14</p></li>
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

    <!-- Footer area -->
    <div class="footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-6">
            <p class="footer-text">&copy; 2014 UNT Vote</p>
          </div>
          <div class="col-xs-6 text-right">
            <a href="#" class="footer-text">Contact</a>
            &nbsp;
            <a href="#" class="footer-text">Help</a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- All scripts go below this area -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../../../assets/js/app.js"></script>
    <script src="../../../assets/js/vendor/chart.min.js"></script>
    <script src="../../../assets/js/admin-elections-live-feed.js"></script>
  </body>
</html>
