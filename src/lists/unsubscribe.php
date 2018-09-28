<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'/src/class/lists.php');

  $list = new Lists();

  // Set the user properties
  $list->setListId($_POST['list_id']);
  $list->setSubscriberId($_POST['subscriber_id']);

  // create the user
  echo $list->unsubscribe();

?>
