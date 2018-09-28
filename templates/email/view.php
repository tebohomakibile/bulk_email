<?php

  require_once(ROOT . PATH .'/src/class/lists.php');

  // Instantiate the objects
  $lists = new Lists();

?>
<!-- Compose Email -->
<div class="container" id="new_container">
  <span id="response"></span>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
      Compose Email
    </div>
  </div>
  <form id="create_email">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-bg">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <!-- Subscriber List -->
          <?php echo $lists->htmlSelect(); ?>
        </div>
      </row>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <textarea name="body" id="body" class="form-control mceEditor" required></textarea>
        </div>
      </div>
      <div class="row">
        <div class="hidden-xs col-sm-12 col-md-4 col-lg-3 col-xl-3 pull-right">
          <button type="submit" id="submit" name="add-subscriber" id="add-subscriber" class="btn btn-primary btn-create">
            <i class="glyphicon glyphicon-envelope"></i> SEND EMAIL
          </button>
        </div>
        <div class="col-xs hidden-sm hidden-md hidden-lg hidden-xl">
          <button type="submit" id="submit" name="add-subscriber" id="add-subscriber" class="btn btn-primary btn-create">
            <i class="glyphicon glyphicon-envelope"></i> SEND
          </button>
        </div>
      </div>
    </div>
  </form>
  </div>
</div>
<!-- End Compose Email -->

<!-- Edit Email -->
<div id="edit_container">
</div>
<!-- End Edit Email -->

<!-- Sent Email List -->
<div id="saved_emails">
</div>
<!-- End Sent Email List -->

<!-- TinyMCE -->
<script type="text/javascript">
  tinymce.init({
    mode : "specific_textareas",
    editor_selector : "mceEditor",
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    },
    theme: "modern",
    menubar:false,
    statusbar: false,
    relative_urls:false,
    autoresize_bottom_margin : 0,
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
    plugins: [
      "textcolor lists link image responsivefilemanager autoresize",
    ],
  autoresize_on_init: true,
  toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | forecolor fontsizeselect | | link image"
});


</script>
  <!-- End TinyMCE -->

<!-- jQuery -->
<script type="text/javascript">

function getEmailList() {

  $.ajax({
    type: "GET",
    url: "<?php echo HOST . PATH; ?>templates/email/email_list.php",
    dataType: "html",
    success: function(response){
        $("#saved_emails").html(response);
    }
  });
}

// Get the sent email list on page load
$(window).on("load", getEmailList());

// Create new email
$(function() {

  // Variable to hold request
  var request;

  // Bind to the submit event on the form
  $("#create_email").submit(function(event){

    // Prevent form method
    event.preventDefault();

    // Abort any pending request
    if (request){
      request.abort();
    }

    // Set local variables
    var $form = $(this);

    // Select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the form data
    var serializedData = $form.serialize();

    // Disable form elements
    $inputs.prop("disabled", true);

    request = $.ajax({
      url: "<?php echo HOST . PATH; ?>src/email/create.php",
      type: "post",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // Message to the browser
      $("#response").html(response);

      // Clear the form fields
      $("#mail_list").children().removeAttr("selected");
      $("#subject").val('');
      $("#body").val('');
      tinyMCE.activeEditor.setContent('');

      // Reload the mailing lists with the new data
      getEmailList();
    });

    // Generic callback handler
    request.always(function () {

      // Enable the inputs
      $inputs.prop("disabled", false);
    });
  });


  // Edit email
  var i;

  for(i = 0; i <= 100; i++){

    // Bind to the submit event to the form
    $(document).on('submit', '#edit_email'+i, function() {

      // Prevent form method
      event.preventDefault();

      // Abort any pending request
      if (request){
        request.abort();
      }

      // Set up local variables
      var $form = $(this);

      // Select and cache all the fields
      var $inputs = $form.find("input, select, button, textarea");

      // Serialize the form data
      var serializedData = $form.serialize();

      // Disable form elements
      $inputs.prop("disabled", true);

      request = $.ajax({
        url: "<?php echo HOST . PATH; ?>templates/email/edit.php",
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

  // Delete email
  var i;

  for(i = 0; i <= 100; i++){

    // Bind to the submit event to the form
    $(document).on('submit', '#delete'+i, function() {

      // Prevent form method
      event.preventDefault();

      // Abort any pending request
      if (request){
        request.abort();
      }

      // Set up local variables
      var $form = $(this);

      // Select and cache all the fields
      var $inputs = $form.find("input, select, button, textarea");

      // Serialize the form data
      var serializedData = $form.serialize();

      // Disable form elements for the duration of the Ajax request.
      $inputs.prop("disabled", true);

      request = $.ajax({
        url: "<?php echo HOST . PATH; ?>src/email/delete.php",
        type: "POST",
        data: serializedData
      });

      // Callback handler on success
      request.done(function (response, textStatus, jqXHR){

        // Message to the browser
        $( "#response" ).html(response);
      });

      // Reload the mailing lists with the new data
      getEmailList();

      // Generic callback handler
      request.always(function () {

        // Eenable the inputs
        $inputs.prop("disabled", false);
      });
    });
  }

});
</script>
