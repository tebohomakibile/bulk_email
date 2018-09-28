<?php

  require_once('../../config/config.php');
  require_once('../class/subscriber.php');

  $list = new Subscriber();

  // create the user
  echo $list->showData();

?>
