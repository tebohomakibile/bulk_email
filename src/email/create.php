<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/email.php');

  $email = new Email();

  // Set the user properties
  $email->setMailListId($_POST['mailing_list']);
  $email->setSubject($_POST['subject']);
  $email->setBody($_POST['body']);

  // create the user
  echo $email->create();

?>
