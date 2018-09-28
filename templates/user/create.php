<!-- User Registration Form -->
<div class="outer-wrapper">
  <div class="inner-wrapper">
    <span id="response"></span>
    <div class="container login-bg">
      <div class="row">
        <div class="col-xs-12">
          <h4>Register Your Account.</h4>
        </div>
      </div>
      <form id="create_user">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Your first name.">
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Your last name.">
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <input type="text" name="username" class="form-control" placeholder="Username">
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <input type="text" name="email" id="email" class="form-control" placeholder="Email address">
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <a href="<?php echo HOST . PATH . 'user/login'; ?>">Sign In</a>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <input type="submit" id="submit" name="register" id="register" class="btn btn-primary pull-right" value="REGISTER">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End User Registration Form -->

<script type="text/javascript">

$(function() {

  // Variable to hold request
  var request;

  // Bind to the submit event of our form
  $("#create_user").submit(function(event){

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
      url: "<?php echo HOST . '/' . PATH; ?>/src/user/create.php",
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
