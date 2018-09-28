<?php

  require_once('database.php');

  class Subscriber extends Database{

    private $id;
    private $first_name;
    private $last_name;
    private $email;

    public function setId($id){

      $this->id = $id;
    }

    public function setFirstName($first_name){

      $this->first_name = $this->sanitise($first_name);
    }

    public function setLastName($last_name){

      $this->last_name = $this->sanitise($last_name);
    }

    public function setEmail($email){

      $this->email = $this->sanitise($email);
    }

    // Create subscriber
    public function create(){

      $sql = "
        INSERT
        INTO
          subscriber
          (
            first_name,
            last_name,
            email,
            created
          )
          VALUES
          (
            '". $this->first_name ."',
            '". $this->last_name ."',
            '". $this->email ."',
            '". date('Y-m-d H:i:s') ."'
          )
      ";

      // Execute the SQL statement
      $res = $this->dbQuery($sql);

      // Set the success & fail messages
      $success = 'Subscriber Successfully Added.';
      $fail = 'Failed To Add Subscriber.';

      // Output message to browser
      $return = $this->htmlOutput($success, $fail);

      return $return;
    }

    // Get subscribers
    public function read(){

      $where = '';

      // Get specific subscriber
      if(isset($this->id)){

        $where = "
          WHERE
            s.id = $this->id
        ";
      }

      $sql = "
        SELECT
          s.id,
          s.first_name,
          s.last_name,
          s.email
        FROM
          subscriber s
        $where
        ORDER BY
          s.created DESC";

      $res = $this->dbQuery($sql);

      return $res;
    }

    // Edit subscriber
    public function edit(){

      $sql = "
        UPDATE
          subscriber
        SET
          first_name = '". $this->first_name ."',
          last_name = '". $this->last_name ."',
          email = '". $this->email ."'
        WHERE
          id = $this->id
      ";

      // Execute the SQL statement
      $res = $this->dbQuery($sql);

      // Set the success & fail messages
      $success = 'Subscriber Successfully Updated.';
      $fail = 'Failed To Update Subscriber.';

      // Output message to browser
      $return = $this->htmlOutput($success, $fail);

      return $return;
    }

    // Delete subscriber
    public function delete(){

      $sql = "
        DELETE
        FROM
          subscriber
        WHERE
          id = $this->id
      ";

      // Execute the SQL statement
      $res = $this->dbQuery($sql);

      // Set the success & fail messages
      $success = 'Subscriber Successfully Deleted.';
      $fail = 'Failed To Delete Subscriber.';

      // Output message to browser
      $return = $this->htmlOutput($success, $fail);

      return $return;
  }
}

?>
