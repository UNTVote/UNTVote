  <body>
    <!-- Navigation -->
    <div class="navbar nav-bar-unt navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-5">
            <a href="#"><img class="navbar-brand" src="<?=img_url()?>UNTVote-logo.png" alt="UNTVote"></a>
          </div>
          <div class="col-xs-7 text-right">
          	<?=anchor('user/login', 'Sign In', array('class' => 'btn btn-default'))?>
            <?=anchor('user/register', 'Register', array('class' => 'btn btn-primary'))?> 
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <br>
        