<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/subscriber.php');

  $subscriber = new Subscriber();

  // Only show header if there are subscribers
  if($subscriber->countRows('subscriber') >= 1){

  ?>

  <!-- Header -->
  <div class="container">
    <div id="responsecontainer">
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
        <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3">
          First Name
        </div>
        <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3">
          Last Name
        </div>
        <div class="hidden-xs hidden-sm col-md-3 col-lg-3 col-xl-3">
          Email
        </div>
        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg hidden-xl">
          Subsctibers
        </div>
      </div>
    </div>
    <!-- End Header -->

  <div class="list-bdr">

  <?php

  }

  $class = 'even';
  $i = 0;

  $res = $subscriber->read();
  while($row = $res->fetch_assoc()){

    $i++;

    if($i % 2 == 0){

      $class = 'even';

    } else {

      $class = 'odd';
    }

    ?>
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 <?php echo $class; ?>">
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
        <?php echo $row['first_name']; ?>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
        <?php echo $row['last_name']; ?>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-1">
        <?php echo $row['email']; ?>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-5">
        <form id="delete<?php echo $i; ?>">
          <input type="hidden" name="subscriber_id" id="subscriber_id" value="<?php echo $row['id']; ?>">
          <button type="submit" id="delete" class="btn btn-danger btn-xs pull-right btn-delete btn-2">
            <span class="glyphicon glyphicon-remove"></span> Delete
          </button>
        </form>
        <form id="edit<?php echo $i; ?>">
          <input type="hidden" name="subscriber_id" id="subscriber_id" value="<?php echo $row['id']; ?>">
          <button type="submit" id="edit" class="btn btn-primary btn-xs pull-right btn-2">
            <span class="glyphicon glyphicon-remove"></span> Edit
          </button>
        </form>
      </div>
    </div>
  </div>

<?php } ?>

</div>
