<?php

// Check if cinfig file exists
if(!file_exists(__DIR__ . '/config/config.php')){

  $uri = '';

  if(strlen(trim($_SERVER['REQUEST_URI'], '/')) >= 1){

    $uri = trim($_SERVER['REQUEST_URI'], '/') . '/';
  }

  header('Location: http://'. $_SERVER['HTTP_HOST'] . '/' . $uri . 'config/config-form.php');

  die();
}

// Get the router and configuration settings
require_once('config/config.php');
require_once('router.php');
require_once('src/class/' . strtolower($class) . '.php');

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>BULK EMAIL</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Inlude jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <!-- Include Bootstrap Files -->
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

  <!-- TinyMCE -->
  <script type="text/javascript" src="<?php echo HOST . PATH .'js/tinymce/tinymce.min.js'; ?>"></script>
  <!-- End TinyMCE -->


  <!-- Include CSS Files -->
  <link href="https://fonts.googleapis.com/css?family=Dosis:300" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo CSS . 'layout.css'; ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo CSS . 'navbar.css'; ?>" rel="stylesheet">

</head>

<body>

  <!-- Navbar -->
  <?php if(isset($_SESSION['user_id'])){ ?>
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo HOST . PATH; ?>">BULK EMAIL</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li <?php echo $home_active; ?>><a href="<?php echo HOST . PATH; ?>">HOME</a></li>
            <li <?php echo $email_active; ?>><a href="<?php echo HOST . PATH . 'Email/View'; ?>">EMAILS</a></li>
            <li <?php echo $lists_active; ?>><a href="<?php echo HOST . PATH . 'Lists/View'; ?>">LISTS</a></li>
            <li <?php echo $subscribers_active; ?>><a href="<?php echo HOST . PATH . 'Subscriber/View'; ?>">SUBSCRIBERS</a></li>
            <li><a href="<?php echo HOST . PATH . 'User/Logout'; ?>">LOGOUT</a></li>
          </ul>
        </div>
      </div>
    </nav>
  <?php } ?>
  <!-- End Navbar -->

  <!-- Main Body -->
  <?php include(TEMPLATES . strtolower($class) . '/' . $method . '.php'); ?>
  <!-- End Main Body -->

  <!-- Footer -->
  <?php if(isset($_SESSION['user_id'])){ ?>
    <footer>
      <div class="container">
        <div class="row">
          <div class="footer">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <p class="navbar-text text-center">2018 - Bulk Emailer By Karsten Kaminski</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  <?php } ?>
  <!-- End Footer -->

</body>

</html>
