  <body>
    <!-- Navigation -->
    <div class="navbar nav-bar-unt navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-5">
            <a href="<?=base_url('/')?>"><img class="navbar-brand" src="<?=img_url()?>UNTVote-logo.png" alt="UNTVote"></a>
          </div>
          <div class="col-xs-7 text-right">
            <label class="profile-name"><?=$user->first_name?></label>
            <div class="btn-group">
              <img src="<?=img_url()?>user-default.png" class="img-circle dropdown-toggle profile-pic" type="button" data-toggle="dropdown">
              <ul class="dropdown-menu dropdown-menu-open-left " role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><?=anchor('admin/logout', 'Logout')?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <br>