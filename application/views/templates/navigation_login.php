 <body>
    <!-- Navigation -->
    <div class="navbar nav-bar-unt navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-5">
            <a href="<?=base_url('/')?>"><img class="navbar-brand" src="<?=img_url()?>UNTVote-logo.png" alt="UNTVote"></a>
          </div>
          <div class="col-xs-7 text-right">
            <!-- <a href="#" class="btn btn-primary">Register</a> -->
            <?=anchor('/', 'Register', array('class' => 'btn btn-primary'));?>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        