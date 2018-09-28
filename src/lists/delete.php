<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/lists.php');

  $list = new Lists();

  // Set the object properties
  $list->setId($_POST['list_id']);

  // Delete the mailing list
  echo $list->delete();

?>
