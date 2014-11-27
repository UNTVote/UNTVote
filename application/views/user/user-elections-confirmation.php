      <!-- Main body content -->
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">Elections</h1>
        <br>
        <div class="fade-on-load" hidden>
          <div class="row">
            <div class="col-xs-12 text-center">
              <span class="icon-vote-success glyphicon glyphicon-ok-circle"></span>
              <br>
              <h1>You have successfully voted.</h1>
              <h3 class="text-muted">Confirmation#: <?=$confirmationNumber?></h3>
            </div>
          </div>
          <br>
          <br>

          <div class="row">
            <div class="col-xs-6 text-right">
              <button class="btn btn-success">Download receipt</button>
            </div>
            <div class="col-xs-6 text-left">
              <a class="btn btn-default" href="https://twitter.com/share?url=<?=base_url()?>&text=I voted at UNTVote! You should too!" target="_blank">Share on Twitter</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>