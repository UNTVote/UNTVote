<!-- Sidebar -->
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar panel-group" id="menuAccordion">
            <li class="panel"><a href="<?=site_url("admin/")?>"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Dashboard</a></li>
            <li class="panel">
              <a data-toggle="collapse" data-parent="#menuAccordion" href="#collapseElections"><span class="glyphicon glyphicon-send"></span>&nbsp;&nbsp;Elections</a>
              <div id="collapseElections" class="panel-collapse collapse">
                <ul class="nav-sidebar-sub-menu">
                  <li><?=anchor('admin/manage_elections', 'Manage')?></li>
                  <li><?=anchor('elections/results', 'Results')?></li>
                  <li><?=anchor('elections/livefeed', 'Live Feed')?></li>
                </ul>
              </div>
            </li>
            <li class="panel">
              <a data-toggle="collapse" data-parent="#menuAccordion" href="#collapseUsers"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Users</a>
              <div id="collapseUsers" class="panel-collapse collapse">
                <ul class="nav-sidebar-sub-menu">
                  <li><?=anchor('admin/manage_users', 'Manage')?></li>
                  <li><?=anchor('notifications/', 'Approvals')?></li>
                  <li><?=anchor('notifications/', 'Vote log')?></li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
