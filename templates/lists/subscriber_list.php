<?php

require_once('../../config/config.php');
require_once(ROOT . PATH .'src/class/lists.php');

$lists = new Lists();

if(isset($_POST['list_id'])){

  $list_id = $_POST['list_id'];

} else {

  $list_id = $_SESSION['list_id'];
}

if(isset($_POST['list_name'])){

  $list_name = $_POST['list_name'];

} else {

  $list_name = $_SESSION['list_name'];
}

$sql = "
  SELECT
    subscriber_id
  FROM
    subscriber_mailing_list
  WHERE
    mail_list_id = ". $list_id ."
";

$lists->setSQL($sql);

$in_array = array(0);

$res = $lists->read();
while($row = $res->fetch_assoc()){

  $in_array[] .= $row['subscriber_id'];
}

$sql = "
  SELECT
    s.id,
    s.first_name,
    s.last_name
  FROM
    subscriber s
  WHERE
    s.id NOT IN (". implode(',', $in_array) .")
  ORDER BY
    s.first_name
  ASC
";

$lists->setSQL($sql);

$res = $lists->read();

$select = '<select name="subscriber_id" id="subscriber_id" class="form-control">';
$select .= '<option value="">Select Subscribers</option>';

while($row = $res->fetch_assoc()){
  $select .= '<option value="'. $row['id'] .'">'. $row['first_name'] .' '. $row['last_name'] .'</option>';
}

$select .= '</select>';

$data = '<!-- New Mailing List Form -->
<div class="container">

  <div class="row row-header">
    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
      '. $list_name .'
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 pull-right">
      <a href="#" class="pull-right" id="close_subscriber">
        <span class="glyphicon glyphicon-remove"></span>
      </a>
    </div>
  </div>

    <form id="add_to_list">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-bg">
          <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
            '. $select .'
          </div>
          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <input type="hidden" name="list_id" id="list_id" value="'. $list_id .'">
            <input type="hidden" name="list_name" id="list_name" value="'. $list_name .'">
            <button type="submit" name="add_subscriber" id="add_subscriber" class="btn btn-primary pull-right btn-create">
              <i class="glyphicon glyphicon-plus"></i> ADD TO LIST
            </button>
          </div>
        </div>
      </div>
    </form>

</div>
<!-- End New Mailing List Form -->';

if($lists->countRows('subscriber_mailing_list', 'mail_list_id = '. $list_id) >= 1){

  $class = 'even';
  $i = 0;
  $data .= '<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
      Subscriber Name
    </div>
  </div>
  <div class="list-bdr">';

  $sql = "
      SELECT
        m.id AS list_id,
        m.list_name,
        s.id AS subscriber_id,
        s.first_name,
        s.last_name
      FROM
        mailing_list m
        join subscriber_mailing_list sm on m.id = sm.mail_list_id
        join subscriber s on sm.subscriber_id = s.id
      WHERE
        m.id = ". $list_id ."
  ";

  $lists->setSQL($sql);

  $res = $lists->read();
  while($row = $res->fetch_assoc()){

    $i++;

    if($i % 2 == 0){

      $class = 'even';

    } else {

      $class = 'odd';
    }

    $data .= '
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 '. $class .'">
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
        '. $row['first_name'] .' '. $row['last_name'] .'
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <form id="unsubscribe'. $i .'">
          <input type="hidden" name="list_id" id="list_id" value="'. $row['list_id'] .'">
          <input type="hidden" name="subscriber_id" id="subscriber_id" value="'. $row['subscriber_id'] .'">
          <button type="submit" id="delete" class="btn btn-danger btn-xs pull-right btn-delete btn-1">
            <span class="glyphicon glyphicon-remove"></span> Delete
          </button>
        </form>
      </div>
    </div>';
  }

  $data .= '</div></div>';
}

echo $data;

?>

<script>
$("#close_subscriber").click(function(){
  $("#subscribers").html('');
});
</script>
