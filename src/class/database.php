<?php

  class Database {

    private $host;
    private $username;
    private $password;
    private $database;

    public $conn;

    function __construct(){

      $this->redirect();

      $this->host = DB_HOST;
      $this->user = DB_USER;
      $this->password = DB_PWD;
      $this->database = DB_DATABASE;

      $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
    }

    // Expose query()
    protected function dbQuery($sql){

      $query = $this->conn->query($sql);

      // Check for SQL errors
      if(mysqli_error($this->conn)){

        die('Error: ' . $this->conn->error);

      } else {

        return $query;
      }
    }

    // Expose num_rows
    public function dbNumRows($res){

      $numrows = $res->num_rows;

      return $numrows;
    }

    // Count the number of records in a table
    public function countRows($table, $where = NULL){

      if($where != NULL){

        $where = "
          WHERE
            $where
        ";
      }

      $sql = "
        SELECT
          *
        FROM
          $table
        $where
      ";

      $res = $this->dbQuery($sql);
      $num_rows = $this->dbNumRows($res);

      return $num_rows;
    }

    public function getLastId($table){

      $sql = "
        SELECT
          id
        FROM
          $table
        ORDER BY
          id DESC
        LIMIT 1
      ";

      $res = $this->dbQuery($sql);
      $row = $res->fetch_assoc();

      return $row['id'];
    }

    // Sanitise user input
    public function sanitise($string){

      if(is_array($string)){

        return array_map(array($this->conn, 'real_escape_string'), $string);

      } else {

        return $this->conn->real_escape_string($string);
      }
    }

    // Output message to browser
    protected function htmlOutput($success, $fail){

      if(!mysqli_error($this->conn)){

        // Success message
        $return = '<div class="alert alert-success" role="alert">';
        $return .= $success;
        $return .= '</div>';

      } else {

        // Failed message
        $return = '<div class="alert alert-warning" role="alert">';
        $return .= $failed;
        $return .= '</div>';
      }

      // Return the message
      return $return;
    }

    // Redirect user to login
    protected function redirect(){

      if(!isset($_SESSION['user_id'])){

        header('Location: ' . HOST . PATH);
      }
    }

  }


?>
