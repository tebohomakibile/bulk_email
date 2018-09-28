<?php

  require_once('../../config/config.php');
  require_once('../class/user.php');

  $user = new User();

  // Set the user properties
  $user->username = $user->sanitise($_POST['username']);
  $user->password = $user->sanitise(md5($_POST['password']));

  // create the user
  echo $user->login();

?>
