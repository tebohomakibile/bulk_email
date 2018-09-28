<?php

  require_once('../../config/config.php');
  require_once('../class/subscriber.php');

  $subscriber = new Subscriber();

  // Set the user properties
  $subscriber->setId($_POST['subscriber_id']);
  $subscriber->setFirstName($_POST['first_name']);
  $subscriber->setLastName($_POST['last_name']);
  $subscriber->setEmail($_POST['email']);

  // create the user
  echo $subscriber->edit();

?>
