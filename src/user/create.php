<?php

  require_once('../../config/config.php');
  require_once('../class/user.php');

  $user = new User();

  // Set the user properties
  $user->first_name = $user->sanitise($_POST['first_name']);
  $user->last_name = $user->sanitise($_POST['last_name']);
  $user->email = $user->sanitise($_POST['email']);
  $user->username = $user->sanitise($_POST['username']);
  $user->created = date('Y-m-d H:i:s');

  // create the user
  echo $user->create();

?>
