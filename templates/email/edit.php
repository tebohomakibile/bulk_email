<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/email.php');
  require_once(ROOT . PATH .'src/class/lists.php');

  // Instantiate the objects
  $email = new Email();
  $lists = new Lists();

  // Set the object properties
  $email->setId($_POST['email_id']);

  // Get the record
  $res = $email->read();
  $row = $res->fetch_assoc();

  // Set the mail list id so the correct mailing list is selected
  $mail_list_id = $lists->setListId($row['mail_list_id']);

?>

<!-- Edit Email -->
<div class="container">
  <span id="response"></span>
  <div class="row row-header">
    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
      Edit Email
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 pull-right">
      <a href="#" class="pull-right" id="close_edit">
        <span class="glyphicon glyphicon-remove"></span>
      </a>
    </div>
  </div>
  <form id="edit_email">
    <input type="hidden" name="email_id" value="<?php echo $_POST['email_id']; ?>">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-bg">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <?php echo $lists->htmlSelect(); ?>
        </div>
      </row>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <input type="text" name="subject" class="form-control" placeholder="Subject" value="<?php echo $row['subject']; ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <textarea name="body" id="body" class="form-control mceEditor" required><?php echo $row['body']; ?></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 pull-right">
          <button type="submit" id="submit" name="add-subscriber" id="add-subscriber" class="btn btn-primary btn-create btn-lrg-2 pull-right">
            <i class="glyphicon glyphicon-floppy-disk"></i> SAVE
          </button>
        </div>
      </div>
    </div>
  </form>
  </div>
</div>
<!-- End Edit Email -->

<script type="text/javascript">

function tiny_rte(){

  tinyMCE.remove();
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
}

// Close the edit panel and get the default compose panel
$("#close_edit").click(function(){
  $.ajax({
    type: "GET",
    url: "<?php echo HOST . PATH; ?>templates/email/create.php",
    dataType: "html",
    success: function(response){
        $("#new_container").html(response);

        // Initialise the tinyMCE editor
        tiny_rte();
    }
  });
  $("#edit_container").html('');
});

// Initialise the tinyMCE editor
tiny_rte();

// Call the edit email panel
$(function() {

  // Set the request variable
  var request;

  // Bind to the submit event of the form
  $("#edit_email").submit(function(event){

    // Prevent form submitting
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
      url: "<?php echo HOST . PATH; ?>src/email/edit.php",
      type: "POST",
      data: serializedData
    });

    // Callback handler on success
    request.done(function (response, textStatus, jqXHR){

      // Message to the browser
      $( "span#response" ).html(response);

    });

    // Reload the mailing lists with the new data
    getEmailList();

    // Generic callback handler
    request.always(function () {

      // Eenable the inputs
      $inputs.prop("disabled", false);
    });
  });
});

</script>
