<?php

  require_once(ROOT . PATH .'src/class/database.php');

  class Dashboard extends Database {

    // Setter functions
    private $sql_where;

    public function setSqlWhere($sql_where){

      $this->sql_where = $sql_where;
    }

    // Get the overal number of sent emails
    public function sentMail(){

      // Set the parameters for delivered & failed emails
      $where = '';

      if(isset($this->sql_where)){

        $where = "
          WHERE
            status = '". $this->sql_where ."'
        ";
      }

      $sql = "
        SELECT
          COUNT(*) AS count
        FROM
          email_log
        $where
      ";

      $res = $this->dbQuery($sql);
      $row = $res->fetch_assoc();

      return $row['count'];
    }

    // Get the number of subscribers
    public function getSubscribers(){

      $sql = "
        SELECT
          COUNT(*) AS count
        FROM
          subscriber
      ";

      $res = $this->dbQuery($sql);
      $row = $res->fetch_assoc();

      return $row['count'];
    }

    // Get the number of mailing lists
    public function getMailingLists(){

      $sql = "
        SELECT
          COUNT(*) AS count
        FROM
          mailing_list
      ";

      $res = $this->dbQuery($sql);
      $row = $res->fetch_assoc();

      return $row['count'];
    }
  }

?>
