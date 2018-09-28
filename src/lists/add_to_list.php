<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/lists.php');

  $list = new Lists();

  $list->setListId($_POST['list_id']);
  $list->setSubscriberId($_POST['subscriber_id']);
  $list->setName($_POST['list_name']);

  if(!empty($_POST['list_id']) && !empty($_POST['subscriber_id'])){

    echo $list->addToList();
  }

?>
