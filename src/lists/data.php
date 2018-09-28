<?php

  require_once('../../config/config.php');
  require_once(ROOT . PATH .'src/class/lists.php');

  $list = new Lists();

  // create the user
  echo $list->showData();

?>
