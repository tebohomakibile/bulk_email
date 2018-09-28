<?php

  require_once('src/class/subscriber.php');

  $subscriber = new Subscriber();

  $res = $subscriber->read();

?>
<!-- New Subscriber Form -->
<div class="container" id="new_container">
  <span id="response"></span>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
      Add Subscriber
    </div>
  </div>
  <form id="create_subscriber">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-bg">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name." required>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name." required>
        </div>
      </row>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <input type="email" name="email" id="email" class="form-control" placeholder="Email Address." required>
        </div>

        <div class="hidden-xs col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <button type="submit" id="submit" name="add-subscriber" id="add-subscriber" class="btn btn-primary pull-right btn-create">
            <i class="glyphicon glyphicon-plus"></i> INSERT SUBSCRIBER
          </button>
        </div>
        <div class="col-xs hidden-sm hidden-md hidden-lg hidden-xl">
          <button type="submit" id="submit" name="add-subscriber" id="add-subscriber" class="btn btn-primary pull-right btn-create">
            <i class="glyphicon glyphicon-plus"></i> INSERT
          </button>
        </div>

      </div>
    </div>
  </form>
  </div>
</div>
<!-- End New Subscriber Form -->

<div id="edit_container">
</div>

<!-- Subscriber Lists -->
<div class="container">
  <div id="list_container">
  </div>
</div>
<!-- End Subscriber Lists -->

<script type="text/javascript">

// Create new list
$(function() {

  // Load the subscriber list on page load
  $(window).on("load", getSubscribers());

  function getSubscribers(){

    $.ajax({
      type: "GET",
      url: "<?php echo HOST . PATH; ?>templates/subscriber/subscriber_list.php",
      dataType: "html",
      success: function(response){
          $("#list_container").html(response);
      }
    });
  }

  // Variable to hold request
  var request;

  // Bind to the submit event to the form
  $("#create_subscriber").submit(function(event){

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
      url: "<?php echo HOST . PATH; ?>src/subscriber/create.php",
      type: "post",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // Message to the browser
      $("span#response").html(response);

      // Reload the subscriber list
      getSubscribers();

      // Clear the form fields
      $("#first_name").val('');
      $("#last_name").val('');
      $("#email").val('');
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


  // Edit Subscriber
  var i;

  for(i = 0; i <= 100; i++){

    // Bind to the submit event to the form
    $(document).on('submit', '#edit'+i, function() {

      // Prevent form method
      event.preventDefault();

      // Abort any pending request
      if (request){
        request.abort();
      }

      // Set up local variables
      var $form = $(this);

      // Select and cache all the fields
      var $inputs = $form.find(subscriber_id);

      // Serialize the form data
      var serializedData = $form.serialize();

      // Disable form elements
      $inputs.prop("disabled", true);

      request = $.ajax({
        url: "<?php echo HOST . PATH; ?>templates/subscriber/edit.php",
        type: "POST",
        data: serializedData
      });

      // Callback handler on success
      request.done(function (response, textStatus, jqXHR){

        // Message to the browser
        $( "#edit_container" ).html(response);
        $( "#new_container" ).html('');

      });

      // Generic callback handler
      request.always(function () {

        // Enable the inputs
        $inputs.prop("disabled", false);
      });
    });
  }


  var i;

  // Loop through the mailing list
  for(i = 1; i <= 100; i++){

    // Delete a record
    $(document).on('submit', '#delete'+i, function(){

      // Prevent default form method
      event.preventDefault();

      // Abort any pending request
      if (request){
        request.abort();
      }

      // setup some local variables
      var $form = $(this);

      // Select and cache all the fields
      var $inputs = $form.find("form, input, select, button, textarea");

      // Serialize the form data
      var serializedData = $form.serialize();

      // Disable form elements for the duration of the Ajax request.
      $inputs.prop("disabled", true);

      // Delete the record
      request = $.ajax({
        type: "post",
        url: "<?php echo HOST . PATH; ?>src/subscriber/delete.php",
        data: serializedData
      });

      // Callback handler on success
      request.done(function (response, textStatus, jqXHR){

        // Reload the subscriber list
        getSubscribers();

        // Message to the browser
        $("#response").html(response);

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
  }
});
</script>
