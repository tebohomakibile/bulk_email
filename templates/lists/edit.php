<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/lists.php');

  $list = new Lists();

  $list->setId($_POST['list_id']);

  $res = $list->read();
  $row = $res->fetch_assoc();

?>
<!-- New Mailing List Form -->
<span id="response"></span>
<div class="row row-header">
  <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
    Update Mailing List
  </div>
  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 pull-right">
    <a href="#" class="pull-right" id="close_edit">
      <span class="glyphicon glyphicon-remove"></span>
    </a>
  </div>
</div>
<div class="row">
  <form id="update_list">
    <input type="hidden" name="list_id" value="<?php echo $_POST['list_id']; ?>">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-bg">
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
          <input type="text" name="list_name" id="list_name" class="form-control" value="<?php echo $row['list_name']; ?>" placeholder="List name." required>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
          <button type="submit" id="submit" name="update-list" id="update-list" class="btn btn-primary pull-right btn-create">
            <i class="glyphicon glyphicon-pencil"></i> UPDATE LIST
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
<!-- End New Mailing List Form -->

<script type="text/javascript">

$("#close_edit").click(function(){
  $.ajax({
    type: "GET",
    url: "<?php echo HOST . PATH; ?>templates/lists/create.php",
    dataType: "html",
    success: function(response){
        $("#new_container").html(response);
    }
  });
  $("#edit_container").html('');
});

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
      url: "<?php echo HOST . PATH; ?>src/lists/edit.php",
      type: "post",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // Message to the browser
      $( "span#response" ).html(response);
    });

    // Callback handler on failure
    request.fail(function (jqXHR, textStatus, errorThrown){

      // Log the error to the console
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
    });

    // Reload the mailing lists
    getMailingLists();

    // Generic callback handler
    request.always(function () {

      // Eenable the inputs
      $inputs.prop("disabled", false);
    });
  });
});
</script>
