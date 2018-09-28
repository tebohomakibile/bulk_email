<?php

require_once('database.php');

class User extends Database {

  // Set the object properties
  public $first_name;
  public $last_name;
  public $email;
  public $password;
  public $response;

  // Generate eandom passwords
  public function password(){

    // Possible characters for password
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";

    // Create a random password
    $this->password = substr(str_shuffle($chars), 0, 12);
  }

  // Create user account.
  public function create(){

    $this->password();

    // Insert query statement
    $sql = "
      INSERT INTO
        user
        (
          first_name,
          last_name,
          email,
          username,
          password,
          created
        )
      VALUES
        (
          '". $this->first_name ."',
          '". $this->last_name ."',
          '". $this->email ."',
          '". $this->username ."',
          '". md5($this->password) ."',
          '". date('Y-m-d H:i:s') ."'
        )";

    // Execute the query
    $query = $this->dbQuery($sql);

    // Output the username and password to the browser
    $this->response = '<div class="alert alert-success" role="alert">';
    $this->response .= "<b>Username:</b> " . $this->username . "<br>";
    $this->response .= "<b>Password:</b> " . $this->password;
    $this->response .= '</div>';

    // Return the output to the client
    return $this->response;
  }

  // User Login
  public function login(){

    // Ensure both username and password fields have been entered.
    if(!empty($this->username) && !empty($this->password)){

      // Query the database on the usernme and password
      $sql = "
        SELECT
          u.id,
          u.username,
          u.password,
          u.email,
          u.first_name,
          u.last_name
        FROM
          user u
        WHERE
          u.username = '". $this->username ."'
        AND
          u.password = '". $this->password ."'
      ";
    }

    $res = $this->dbQuery($sql);
    $row = $res->fetch_assoc();

    // If the user exists log them in
    if($this->dbNumRows($res) >= 1){

      // Set the user sessions.
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['first_name'] = $row['first_name'];
      $_SESSION['last_name'] = $row['last_name'];

      $return = '<div class="alert alert-success" role="alert">';
      $return .= 'Welcome ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
      $return .= '. <b>Redirecting in <span id="countdowntimer">5 </span> seconds.</b>';
      $return .= '</div>';

      $return .= '<script>';
      $return .= "setTimeout(function (){
                    window.location.href = '". HOST . PATH ."Dashboard/View'
                  }, 5000);";
      $return .= '</script>';

      $return .= '<script>';
      $return .= 'var timeleft = 5;
                  var downloadTimer = setInterval(function(){
                    timeleft--;
                    document.getElementById("countdowntimer").textContent = timeleft;
                    if(timeleft <= 0)
                      clearInterval(downloadTimer);
                  },1000);';
      $return .= '</script>';

    } else {

      $return = '<div class="warning alert-warning" role="alert">';
      $return .= 'Login failed, please try again.';
      $return .= '</div>';
    }
    return $return;
  }

  // Logout and sestroy the user session
  public function logout(){

    session_destroy();

    header('Location: ' . HOST . PATH);
  }
}
?>
