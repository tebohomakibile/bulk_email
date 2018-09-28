<?php

  require_once('../../config/config.php');
  require_once('../class/subscriber.php');

  $list = new Subscriber();

  // Set the user properties
  $list->setFirstName($_POST['first_name']);
  $list->setLastName($_POST['last_name']);
  $list->setEmail($_POST['email']);

  // create the user
  echo $list->create();

?>
