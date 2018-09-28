<?php

require_once('../../config/config.php');
require_once(ROOT . PATH .'src/class/lists.php');

$lists = new Lists();

$class = 'even';
$i = 0;

?>

<div class="container">

<?php if($lists->countRows('mailing_list') >= 1){ ?>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        List Name
      </div>
      <div class="hidden-xs hidden-sm col-md-4 col-lg-4 col-xl-4">
        Subscribers
      </div>
    </div>
  </div>

  <div class="list-bdr">

  <?php

  $res = $lists->read();
  while($row = $res->fetch_assoc()){

    $i++;

    if($i % 2 == 0){

      $class = 'even';

    } else {

      $class = 'odd';
    }

    ?>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 <?php echo $class; ?>">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <?php echo $row['list_name']; ?>
      </div>
      <div class="hidden-xs hidden-sm col-md-2 col-lg-2 col-xl-2">
        <?php echo $lists->countRows('subscriber_mailing_list', 'mail_list_id = '. $row['id']);?>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <form id="edit_list<?php echo $i; ?>">
          <input type="hidden" name="list_id" id="list_id" value="<?php echo $row['id']; ?>">
          <button type="submit" id="edit" class="btn btn-primary btn-xs pull-right btn-3">
            <span class="glyphicon glyphicon-user"></span> Edit
          </button>
        </form>
        <form id="delete<?php echo $i; ?>">
          <input type="hidden" name="list_id" id="list_id" value="<?php echo $row['id']; ?>">
          <button type="submit" id="delete" class="btn btn-danger btn-xs pull-right btn-delete btn-3">
            <span class="glyphicon glyphicon-remove"></span> Delete
          </button>
        </form>
        <form id="manage_subscribers<?php echo $i; ?>">
          <input type="hidden" name="list_id" id="list_id" value="<?php echo $row['id']; ?>">
          <input type="hidden" name="list_name" id="list_name" value="<?php echo $row['list_name']; ?>">
          <button type="submit" class="btn btn-success btn-xs pull-right btn-3">
            <span class="glyphicon glyphicon-user"></span> Subscribers
          </button>
        </form>
      </div>
    </div>

    <?php } ?>
  <?php } ?>

</div>
