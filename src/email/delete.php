<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/email.php');

  $list = new Email();

  // Set the user properties
  $list->setId($_POST['email_id']);

  // create the user
  echo $list->delete();

?>
