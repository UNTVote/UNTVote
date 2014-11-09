  <body>
    <!-- Navigation -->
    <div class="navbar nav-bar-unt navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-5">
            <a href="<?=base_url('/')?>"><img class="navbar-brand" src="<?=asset_url()?>img/UNTVote-logo.png" alt="UNTVote"></a>
          </div>
          <div class="col-xs-7 text-right">
            <label class="profile-name"><?=$user->first_name ?></label>
            <div class="btn-group">
              <img src="<?=asset_url()?>img/user-default.png" class="img-circle dropdown-toggle profile-pic" type="button" data-toggle="dropdown">
              <ul class="dropdown-menu dropdown-menu-open-left " role="menu">
                <li><?=anchor("user/edit_user/".$user->id, 'Profile') ;?></li>
                <li class="divider"></li>
                <li><?=anchor('user/logout', 'Logout')?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        