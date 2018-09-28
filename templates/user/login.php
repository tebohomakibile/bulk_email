<!-- User login Form -->
<div class="outer-wrapper">
  <div class="inner-wrapper">
    <span id="response"></span>
    <div class="container login-bg">
      <div class="row">
        <div class="col-xs-12">
          <h4>Bulk Mailer Login</h4>
        </div>
      </div>
      <form id="login">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <a href="<?php echo HOST . PATH . 'user/create'; ?>">Register an accoutnt</a>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <input type="submit" name="login" id="login" class="btn btn-primary pull-right" value="LOGIN">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End User login Form -->

<script type="text/javascript">

$(function() {

  // Variable to hold request
  var request;

  // Bind to the submit event of our form
  $("#login").submit(function(event){

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
      url: "<?php echo HOST . '/' . PATH; ?>/src/user/login.php",
      type: "post",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // Message to the browser
      $( "span#response" ).html(response)
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
