<?php

  $url = trim($_SERVER['REQUEST_URI'], '/');

  // Drop path from url
  $url = substr($url, strlen(PATH));

  $home_active = '';
  $email_active = '';
  $lists_active = '';
  $subscribers_active = '';

  $explode_url = explode('/', $url);

  // Make sure the class exists
  if(file_exists('src/class/' . strtolower($explode_url[0]) . '.php')){

    // Set the class variable
    $class = strtolower($explode_url[0]);

    // Set the active menu item
    if($class == 'email'){

      $email_active ='class="active"';
    }

    if($class == 'lists'){

      $lists_active ='class="active"';
    }

    if($class == 'subscriber'){

      $subscribers_active = 'class="active"';
    }

    if(!empty($explode_url[1])){

      // Set the action / method variable;
      $method = strtolower($explode_url[1]);
    }

    if(!empty($explode_url[2])){

      // Set the parameter variable
      $parameter = strtolower($explode_url[2]);
    }

  } else {

    if(isset($_SESSION['user_id'])){

      $class = 'Dashboard';
      $method = 'view';
      $home_active = 'class="active"';

    } else {

      $class = 'User';
      $method = 'login';
      $home_active = 'class="active"';
    }
  }

 ?>
