<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/email.php');

  $email = new Email();

  $email->setId($_POST['email_id']);
  $email->setMailListId($_POST['mailing_list']);
  $email->setSubject($_POST['subject']);
  $email->setBody($_POST['body']);

  echo $email->edit();

?>
