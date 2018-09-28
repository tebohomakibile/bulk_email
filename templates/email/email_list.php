<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/email.php');
  require_once(ROOT . PATH .'src/class/lists.php');

  // Instantiate the objects
  $email = new Email();
  $lists = new Lists();

  $class = 'even';
  $i = 0;
  $data = '';

  // Only display if there are sent emails
  if($email->countRows('email') >= 1){

    // Header
    $data .= '<div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
        <div class="hidden-xs hidden-sm col-md-6 col-lg-6 col-xl-6">
          Subject
        </div>
        <div class="hidden-xs hidden-sm col-md-2 col-lg-2 col-xl-2">
          Creted
        </div>
      </div>
    </div>';

    $data .= '<div class="list-bdr">
    ';

    // Loop through sent emails
    $res = $email->read();
    while($row = $res->fetch_assoc()){

      $i++;

      if($i % 2 == 0){

        $class = 'even';

      } else {

        $class = 'odd';
      }

      // jQuery to toggle subscribers
      $data .= '<script>
      $(document).ready(function(){
        $("#subscribers'. $i .'").hide();
        $("#show_subscribers'. $i .'").click(function(){
          $("#subscribers'. $i .'").toggle();
        });
      });
      </script>';

      // Sent emails list
      $data .= '<div class="row '. $class .' ">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          '. $row['subject'] .'
        </div>
        <div class="hidden-xs hidden-sm col-md-2 col-lg-2 col-xl-2">
          '. $row['created'] .'
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
          <form id="edit_email'. $i .'">
            <input type="hidden" name="email_id" id="email_id" value="'. $row['id'] .'">
            <button type="submit" id="edit" class="btn btn-primary btn-xs pull-right btn-3">
              <span class="glyphicon glyphicon-user"></span> Edit
            </button>
          </form>
          <form id="delete'. $i .'">
            <input type="hidden" name="email_id" id="email_id" value="'. $row['id'] .'">
            <button type="submit" id="delete" class="btn btn-danger btn-xs pull-right btn-delete btn-3">
              <span class="glyphicon glyphicon-remove"></span> Delete
            </button>
          </form>
          <button type="submit" id="show_subscribers'. $i .'" class="btn btn-success btn-xs pull-right btn-3">
            <span class="glyphicon glyphicon-user"></span> Subscribers
          </button>
        </div>
      </div>

      <div id="subscribers'. $i .'" class="expand">
        <!-- Subscribers Header -->
        <div class="row '. $class .' blue">
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <b>Subscriber</b>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <b>Email</b>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <b>Status</b>
          </div>
        </div>
        <!-- End Subscribers Header -->';

      // Get the subscribers
      $sql = "
      SELECT
        email_log.`status`,
        subscriber.first_name,
        subscriber.last_name,
        subscriber.email,
        subscriber.id
      FROM
        email_log
      JOIN
        subscriber ON email_log.subscriber_id = subscriber.id
      WHERE
        email_log.email_id = ". $row['id'] ."
      ";

      $email->setSQL($sql);

      // Loop through subscribers
      $res_list = $email->read();
      while($row_list = $res_list->fetch_assoc()){

        $data .= '<div class="row '. $class .'">';
        $data .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">';
        $data .= $row_list['first_name'] .' '. $row_list['last_name'];
        $data .= '</div>';
        $data .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">';
        $data .= $row_list['email'];
        $data .= '</div>';
        $data .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">';
        $data .= $row_list['status'];
        $data .= '</div>';
        $data .= '</div>';
      }

      $data .= '</div>';
  }

    // Close list-bdr div
    $data .= '</div>';
}

echo $data;

?>
