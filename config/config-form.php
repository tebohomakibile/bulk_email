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


  <!-- Include CSS Files -->
  <link href="https://fonts.googleapis.com/css?family=Dosis:300" rel="stylesheet">
  <link rel="stylesheet" href="../css/layout.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css" rel="stylesheet">

</head>

<body>

<form id="config">

  <div class="container">

    <!-- Database Settings -->
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
        Database Settings
      </div>
    </div>
    <div class="container-bg">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="db-host" class="form-control" placeholder="Host">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="db-name" class="form-control" placeholder="Database Name">
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="db-username" class="form-control" placeholder="Username">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <input type="password" name="db-password" class="form-control" placeholder="Password">
        </div>
      </div>
    </div>
    <!-- End Database Settings -->

    <!-- Mailgun Settings -->
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
        Mailgun Settings
      </div>
    </div>
    <div class="container-bg">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="mg-api-key" class="form-control" placeholder="API Key">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="mg-domain" class="form-control" placeholder="Domain Name">
        </div>
      </div>
    </div>
    <!-- End Mailgun Settings -->

    <!-- System Settings -->
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
        System Settings
      </div>
    </div>
    <div class="container-bg">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="root-path" class="form-control" placeholder="Root Directory.">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="email" class="form-control" placeholder="Email Address.">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="sys-name" class="form-control" placeholder="System Name.">
        </div>
      </div>
    </div>
    <!-- End System Settings -->

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 btn-spacer">
        <input type="submit" class="btn btn-primary" value="UPDATE SETTINGS">
      </div>
    </div>

  </div>

</form>

<script type="text/javascript">

// Create new list
$(function() {

  // Variable to hold request
  var request;

  // Bind to the submit event to the form
  $("#config").submit(function(event){

    // Prevent form method
    event.preventDefault();

    // Abort any pending request
    if (request){
      request.abort();
    }

    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Disable form elements for the duration of the Ajax request.
    $inputs.prop("disabled", true);

    request = $.ajax({
      url: "config.init.php",
      type: "post",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // jQuery URL redirection
      $(document).ready( function() {
        url = "../User/Create";
        $( location ).attr("href", url);
      });

    });

    // Callback handler on failure
    request.fail(function (jqXHR, textStatus, errorThrown){

      // Log the error to the console
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
    });

    // Generic callback handler
    request.always(function () {

      // Eenable the inputs
      $inputs.prop("disabled", false);
    });
  });
});
</script>

</body>
</html>
