<?php

  require_once('../../config/config.php');
  require_once('../class/lists.php');

  $list = new Lists();

  if(isset($_POST['list_id'])){

    $list_id = $_POST['list_id'];

  } else {

    $list_id = $_SESSION['list_id'];
  }

  if(isset($_POST['list_name'])){

    $list_name = $_POST['list_name'];

  } else {

    $list_name = $_SESSION['list_name'];
  }

  $list->setListId($list_id);
  $list->setListName($list_name);

  // create the user
  //echo $list->showSubscriber();

?>
