    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar panel-group" id="menuAccordion">
            <li class="panel"><a href="<?=site_url('user/')?>"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Dashboard</a></li>
            <li class="panel">
              <a data-toggle="collapse" data-parent="#menuAccordion" href="#collapseElections"><span class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;Elections</a>
              <div id="collapseElections" class="panel-collapse collapse">
                <ul class="nav-sidebar-sub-menu">
                  <li><a href="<?=site_url('elections/')?>">Browse</a></li>
                  <li><a href="#">Results</a></li>
                </ul>
              </div>
            
            </li>
            <li class="panel">
              <a href="#"><span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;Candidates</a></li>
              
                </div>
            </li>
          </ul>