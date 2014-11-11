        <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Approvals</h1>
          <?php if($numberNotifications == 0):?>
            <h3 class='text-muted text-center'>Their are currently zero approval requests.</h3>
          <?php endif ?> 
            <div class="row">
              <div class="col-xs-12 fade-on-load" hidden>
              <?php if($numberElectionNotifications > 0):?>
                <h3>Voting approvals</h3>
                <table class="table table-striped" id="tableVotingApprovals">
                  <thead>
                    <tr>
                      <th><a href="#">First name</a></th>
                      <th><a href="#">Last name</a></th>
                      <th><a href="#">Election</a></th>
                      <td><a href="#">Category</a></td>
                      <td data-sorter="false">Action</td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($electionNotifications as $notification):?>
                    <tr>
                      <td><?=$notification['first_name']?></td>
                      <td><?=$notification['last_name']?></td>
                      <td><?=$notification['election_name']?></td>
                      <td><?=$notification['description']?></td>
                      <td><a class='btn btn-xs btn-success' href="<?=site_url('notifications/AcceptElectionNotification/' . $notification['id'])?>">Approve</a>
                          &nbsp; <a class='btn btn-xs btn-danger' href="<?=site_url('notifications/RejectRequest/' . $notification['id'])?>">Deny</a>
                    </tr>
                  <?php endforeach?>
                  </tbody>
                </table>
              <?php endif ?>
                <br>
              <?php if($numberCandidateNotifications > 0): ?>
                <h3>Candidacy approvals</h3>
                <table class="table table-striped" id="tableCandidacyApprovals">
                  <thead>
                    <tr>
                      <th><a href="#">First name</a></th>
                      <th><a href="#">Last name</a></th>
                      <td><a href="#">Category</a></td>
                      <td data-sorter="false">Action</td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($candidateNotifications as $notification):?>
                    <tr>
                      <td><?=$notification['first_name']?></td>
                      <td><?=$notification['last_name']?></td>
                      <td><?=$notification['description']?></td>
                      <td><a class='btn btn-xs btn-success' href="<?=site_url('notifications/AcceptCandidateNotification/' . $notification['id'])?>">Approve</a>
                          &nbsp; <a class='btn btn-xs btn-danger' href="<?=site_url('notifications/RejectRequest/' . $notification['id'])?>">Deny</a>
                    </tr>
                  <?php endforeach?>
                  </tbody>
                </table>
              <?php endif ?>
              </div>
            </div>
        </div>
      </div>
    </div>