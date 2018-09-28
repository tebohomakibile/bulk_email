<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/lists.php');

  $list = new Lists();

  // Set the user properties
  $list->setId($_POST['list_id']);
  $list->setName($_POST['list_name']);

  // create the user
  echo $list->edit();

?>
