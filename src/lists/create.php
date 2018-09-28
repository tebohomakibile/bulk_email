<?php

  require_once('../../config/config.php');
  require_once('../class/lists.php');

  $list = new Lists();

  // Set the user properties
  $list->list_name = $list->setName($_POST['list_name']);

  // create the user
  echo $list->create();

?>
