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
              <a class="btn btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?=base_url()?>" target="_blank">Share on Facebook</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>