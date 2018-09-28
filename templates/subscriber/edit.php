<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/subscriber.php');

  $subscriber = new Subscriber();

  $subscriber->setId($_POST['subscriber_id']);

  $res = $subscriber->read();
  $row = $res->fetch_assoc();

?>
<!-- New Mailing List Form -->
<div class="container">
  <span id="response"></span>
  <div class="row row-header">
    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
      Update Subscriber
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 pull-right">
      <a href="#" class="pull-right" id="close_edit">
        <span class="glyphicon glyphicon-remove"></span>
      </a>
    </div>
  </div>
  <div class="row">
    <form id="update_list">
      <input type="hidden" name="subscriber_id" value="<?php echo $_POST['subscriber_id']; ?>">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-bg">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $row['first_name']; ?>" placeholder="First name." required>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $row['last_name']; ?>" placeholder="Last name." required>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <input type="text" name="email" id="email" class="form-control" value="<?php echo $row['email']; ?>" placeholder="Email Address." required>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <button type="submit" id="submit" name="update-list" id="update-list" class="btn btn-primary pull-right btn-create">
              <i class="glyphicon glyphicon-pencil"></i> UPDATE SUBSCRIBER
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- End New Mailing List Form -->

<script type="text/javascript">

// Close the edit panel and get the default compose panel
$("#close_edit").click(function(){
  $.ajax({
    type: "GET",
    url: "<?php echo HOST . PATH; ?>templates/subscriber/create.php",
    dataType: "html",
    success: function(response){
        $("#new_container").html(response);

        // Initialise the tinyMCE editor
        tiny_rte();
    }
  });
  $("#edit_container").html('');
});

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

// Create new list
$(function() {

  // Variable to hold request
  var request;

  // Bind to the submit event to the form
  $("#update_list").submit(function(event){

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
      url: "<?php echo HOST . PATH; ?>src/subscriber/edit.php",
      type: "post",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // Message to the browser
      $( "span#response" ).html(response);
      getSubscribers();
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
