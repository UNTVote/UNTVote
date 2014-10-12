<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    
    <title>Login | UNTVote</title>
    
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <!-- Custom styles -->
    <?=css('style-main.css')?>
    <?=css('user-auth.css')?>
    <!-- <link href="../assets/css/style-main.css" rel="stylesheet">
    <link href="../assets/css/user-auth.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- Navigation -->
    <div class="navbar nav-bar-unt navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-5">
            <a href="#"><img class="navbar-brand" src="<?=img_url()?>UNTVote-logo.png" alt="UNTVote"></a>
          </div>
          <div class="col-xs-7 text-right">
            <a href="#" class="btn btn-primary">Register</a>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <br>
        
        <!-- Main body content -->
        <div class="col-xs-12">
          <div class="panel panel-default panel-user-auth block-center">
            <div class="panel-heading">
              <h3 class="panel-title">Sign in</h3>
            </div>
            <div class="panel-body">
              <form role="form">
                <div class="form-group">
                  <label>EUID</label>
                  <input type="text" class="form-control" placeholder="UNT EUID">
                </div>
                <div class="form-group">
                  <label>Password <a href="#" tabindex="-1">(Forgot?)</a></label>
                  <input type="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Sign in</button>
              </form>
            </div>
          </div>
        </div>
        
        <br>
      </div>
    </div>

    <!-- Footer area -->
    <div class="footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-6">
            <p class="footer-text">&copy; 2014 UNT Vote</p>
          </div>
          <div class="col-xs-6 text-right">
            <a href="#" class="footer-text">Contact</a>
            &nbsp;
            <a href="#" class="footer-text">Help</a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- All scripts go below this area -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>
