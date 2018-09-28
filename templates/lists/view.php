<?php

  require_once(ROOT . PATH .'src/class/lists.php');

  $list = new Lists();

  $res = $list->read();

?>
<!-- New Mailing List Form -->
<div class="container" id="new_container">
  <span id="response"></span>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
      Create New List
    </div>
    <form id="create_list">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-bg">
          <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
            <input type="text" name="list_name" id="list_name" class="form-control" placeholder="List name." required>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <button type="submit" name="create-list" id="create-list" class="btn btn-primary pull-right btn-create">
              <i class="glyphicon glyphicon-plus"></i> CREATE LIST
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="container" id="edit_container">
</div>
<!-- End New Mailing List Form -->

<!-- Mailing Lists -->
<div id="list_container">
</div>
<!-- End Mailing Lists -->

<!-- Subscribers -->
<div id="subscriber_response">
</div>
<div id="subscribers">
</div>
<!-- End Subscribers -->

<script type="text/javascript">

function getMailingLists(){

  $.ajax({
    type: "GET",
    url: "<?php echo HOST . PATH; ?>templates/lists/mailing_list.php",
    dataType: "html",
    success: function(response){
        $("#list_container").html(response);
    }
  });
}

function getSubscriberList(){

  $.ajax({
    type: "GET",
    url: "<?php echo HOST . PATH; ?>templates/lists/subscriber_list.php",
    dataType: "html",
    success: function(response){
        $("#subscribers").html(response);
    }
  });
}

// Load the mailing lists on page load
$(window).on("load", getMailingLists());

$(function() {

  // Variable to hold request
  var request;

  // Create mailing list
  $("#create_list").submit(function(event){

    // Prevent form method
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

    request = $.ajax({
      url: "<?php echo HOST . PATH; ?>src/lists/create.php",
      type: "post",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // Message to the browser
      $( "span#response" ).html(response);

      // Clear the mail list from form field
      $("#list_name").val('');

      // Reload the mailing lists with the new data
      getMailingLists();
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

      // Enable the inputs
      $inputs.prop("disabled", false);
    });
  });



  // Edit list
  var i;

  for(i = 0; i <= 100; i++){

    // Bind to the submit event to the form
    $(document).on('submit', '#edit_list'+i, function() {

      // Prevent form method
      event.preventDefault();

      // Abort any pending request
      if (request){
        request.abort();
      }

      // Set up local variables
      var $form = $(this);

      // Select and cache all the fields
      var $inputs = $form.find(list_id, list_name);

      // Serialize the form data
      var serializedData = $form.serialize();

      // Disable form elements
      $inputs.prop("disabled", true);

      request = $.ajax({
        url: "<?php echo HOST . PATH; ?>templates/lists/edit.php",
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



  // Delete lists
  var i;

  // Loop through the mailing list
  for(i = 1; i <= 100; i++){

    $(document).on('submit', '#delete'+i, function() {

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
        type: "POST",
        url: "<?php echo HOST . PATH; ?>src/lists/delete.php",
        data: serializedData
      });

      // Callback handler on success
      request.done(function (response, textStatus, jqXHR){

        // Reload the mailing lists with the new data
        getMailingLists();

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



  // Manage Subscribers
  // Loop through the subscriber list
  var i;

  for(i = 1; i <= <?php echo $list->countRows('mailing_list'); ?>; i++){

    // Delete a record
    $(document).on('submit', '#manage_subscribers'+i, function(){

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

      // Reload the mailing lists
      request = $.ajax({
        type: "POST",
        url: "<?php echo HOST . PATH; ?>templates/lists/subscriber_list.php",
        data: serializedData
      });

      // Callback handler on success
      request.done(function (response, textStatus, jqXHR){

        // Message to the browser
        $("#subscribers").html(response);
        getMailingLists();
      });

      $inputs.prop("disabled", false);
    });
  }

  // Add subscriber to mailing list
  $(document).on('submit', '#add_to_list', function(){

    // Prevent form method
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

    request = $.ajax({
      url: "<?php echo HOST . PATH; ?>src/lists/add_to_list.php",
      type: "POST",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // Message to the browser
      $("span#response").html(response);

      // Reload the mailing lists
      getSubscriberList();

      getMailingLists();
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

      // Enable the inputs
      $inputs.prop("disabled", false);
    });
  });


  // Unsubscribe from lists
  var i;

  // Loop through the mailing list
  for(i = 1; i <= 100; i++){

    $(document).on('submit', '#unsubscribe'+i, function() {

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
        url: "<?php echo HOST . PATH; ?>src/lists/unsubscribe.php",
        data: serializedData
      });

      // Callback handler on success
      request.done(function (response, textStatus, jqXHR){

        // Message to the browser
        $("span#response").html(response);

        // Reload the mailing lists
        getSubscriberList();

        getMailingLists();
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
