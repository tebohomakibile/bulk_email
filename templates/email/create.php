<?php

require_once('../../config/config.php');
require_once(ROOT . PATH .'src/class/lists.php');

// Instantiate the object
$lists = new Lists();

?>
<!-- Compose Email -->
<div id="new_container">
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
          <?php echo $lists->htmlSelect(); ?>
        </div>
      </row>
      <div class="row">
        <div class="hidden-xs col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required>
        </div>
      </div>
      <div class="row">
        <div class="hidden-xs col-sm-12 col-md-12 col-lg-12 col-xl-12">
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
