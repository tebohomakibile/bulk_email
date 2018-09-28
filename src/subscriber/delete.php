<?php

  require_once('../../config/config.php');
  require_once('../class/subscriber.php');

  $list = new Subscriber();

  // Set the user properties
  $list->setId($_POST['subscriber_id']);

  // create the user
  echo $list->delete();

?>
