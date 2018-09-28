<?php

  require_once('database.php');

  class Lists extends Database{

    // Set the class properties
    private $id;
    private $name;
    private $sql;
    private $list_id;
    private $subscriber_id;
    private $add_subscriber;

    public $res;

    // Setter methods
    public function setId($id) {

      if(isset($id) && !empty($id)){

        $this->id = $id;

      }

      return $this->id;
    }

    public function setName($name) {

      $name = $this->sanitise($name);

      if(!empty($name)){

        $this->name = $name;
        $_SESSION['list_name'] = $name;
      }

      return $this->name;
    }

    public function setSQL($sql){

      $this->sql = $sql;
    }

    public function setListId($list_id){

      if(!empty($list_id)){

        $this->list_id = $list_id;
        $_SESSION['list_id'] = $list_id;
      }
    }

    public function setSubscriberId($subscriber_id){

      if(!empty($subscriber_id)){

        $this->subscriber_id = $subscriber_id;
        $_SESSION['subscriber_id'] = $subscriber_id;
      }
    }

    public function setListName($list_name){

      $this->list_name = $list_name;
      $_SESSION['list_name'] = $list_name;
    }

    // Create mailling list
    public function create(){

      $sql = "
        INSERT INTO
          mailing_list
          (
            list_name,
            created
          )
          VALUES
          (
            '". $this->name ."',
            '". date('Y-m-d H:i:s') ."'
          )
      ";

      // Execute the query
      $res = $this->dbQuery($sql);

      // Set the success & fail messages
      $success = 'Mailing List Successfully Added.';
      $fail = 'Failed To Add List.';

      // Output message to browser
      $return = $this->htmlOutput($success, $fail);

      return $return;
    }

    // Get mailing lists
    public function read(){

      // Use default query if sql not set
      if(!isset($this->sql)){

        $where = '';

        if(isset($this->id)){

          $where = "
            WHERE
              ml.id = $this->id
          ";
        }

        $this->sql = "
          SELECT
            ml.id,
            ml.list_name
          FROM
            mailing_list ml
          $where
          ORDER BY
            ml.created DESC";
      }

      // Execute the query
      $this->res = $this->dbQuery($this->sql);

      return $this->res;
    }

    // Edit mailing lists
    public function edit(){

      $sql = "
        UPDATE
          mailing_list
        SET
          list_name = '". $this->name ."'
        WHERE
          id = $this->id
      ";

      // Execute the query
      $res = $this->dbQuery($sql);

      // Set the success & fail messages
      $success = 'Mailing List Successfully Updated.';
      $fail = 'Failed To Update Mailing List.';

      // Output message to browser
      $return = $this->htmlOutput($success, $fail);

      return $return;
    }

    // Delete mailing list
    public function delete(){

      $sql = "
        DELETE
        FROM
          mailing_list
        WHERE
          id = $this->id
      ";

      // Execute the query
      $res = $this->dbQuery($sql);

      // Set the success & fail messages
      $success = 'Mailing List Successfully Deleted.';
      $fail = 'Failed To Delete Mailing List.';

      // Output message to browser
      $return = $this->htmlOutput($success, $fail);

      return $return;
  }

  // Mailing list drop down
  public function htmlSelect(){

    $select = '<select name="mailing_list" class="form-control" required>';
    $select .= '<option value="">Select a mailing list</option>';

    // Find lists that have subscribers
    $sql = "
      SELECT
        mail_list_id
      FROM
        subscriber_mailing_list
      GROUP BY
        mail_list_id
    ";

    // Array to store id's
    $in_array = array(0);

    // Execute the query
    $res = $this->dbQuery($sql);
    while($row = $res->fetch_assoc()){

      // Add the lists to the array
      $in_array[] .= $row['mail_list_id'];
    }

    // Get the mailing lists
    $this->sql = "
      SELECT
        ml.id,
        ml.list_name
      FROM
        mailing_list ml
      WHERE
        ml.id IN (". implode(',', $in_array) .")
      ORDER BY
        ml.list_name
      ASC
    ";

    // Execute the query
    $res = $this->read($this->sql);
    while($row = $res->fetch_assoc()){

      $selected = '';

      if($row['id'] == $this->list_id){

        $selected = 'selected';
      }

      $select .= '<option value="'. $row['id'] .'" '. $selected .'>'. $row['list_name'] .'</option>';
    }

    $select .= '</select>';

    // Return the drop down list
    return $select;
  }

  // Unsubscribe from mailing list
  public function unsubscribe(){

    $sql = "
      DELETE
      FROM
        subscriber_mailing_list
      WHERE
        subscriber_id = $this->subscriber_id
      AND
        mail_list_id = $this->list_id
    ";

    // Execute the query
    $res = $this->dbQuery($sql);

    // Set the success & fail messages
    $success = 'Subscriber Successfully Deleted From Mailing List.';
    $fail = 'Failed To Delete Subscriber From Mailing List.';

    // Output message to browser
    $return = $this->htmlOutput($success, $fail);

    return $return;
  }

  // Add subscriber to mailing list
  public function addToList(){

    if(!empty($this->subscriber_id)){

      $sql = "
        INSERT
        INTO
          subscriber_mailing_list
          (
            subscriber_id,
            mail_list_id,
            created
            )
        VALUES
          (
            $this->subscriber_id,
            $this->list_id,
            '". date('Y-m-d') ."'
            )
      ";

      // Execute the query
      $res = $this->dbQuery($sql);
    }

    // Set the success & fail messages
    $success = 'Subscriber Successfully Added.';
    $fail = 'Failed To Add Subscriber.';

    // Output message to browser
    $return = $this->htmlOutput($success, $fail);

    return $return;
  }

}

?>
