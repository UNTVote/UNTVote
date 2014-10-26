<body>
    <!-- Navigation -->
    <div class="navbar nav-bar-unt navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-5">
            <!-- <a href="#"><img class="navbar-brand" src="../assets/img/UNTVote-logo.png" alt="UNT Vote"></a> -->
            <a href="<?=base_url('/')?>"><img class="navbar-brand" src="<?=img_url()?>UNTVote-logo.png" alt="UNT Vote"></a>
          </div>
          <div class="col-xs-7 text-right">
            <?=anchor('user/login', 'Sign In', array('class' => 'btn btn-default'))?>
          </div>
        </div>
      </div>
    </div>
    