<?php

  use Mailgun\Mailgun;

  require_once(ROOT . '/' . PATH . '/vendor/autoload.php');
  require_once('database.php');

  // Mailgun domain
  $domain = DOMAIN;

  class Email extends Database{

    // Set the class properties
    private $sql;
    private $res;
    private $id;
    private $mail_list_id;
    private $subject;
    private $body;
    private $from;
    private $to;
    private $first_name;
    private $last_name;
    private $mailgun_id;

    // Setter functions
    public function setSQL($sql){

      $this->sql = $sql;
    }

    public function setId($id){

      $this->id = $this->sanitise($id);
    }

    public function setMailListId($mail_list_id){

      $this->mail_list_id = $this->sanitise($mail_list_id);

      return $this->mail_list_id;
    }

    public function setSubject($subject){

      $this->subject = $this->sanitise($subject);

      return $this->subject;
    }

    public function setBody($body){

      $this->body = $this->sanitise($body);

      return $this->body;
    }

    public function setTo($to){

      $this->to = $this->sanitise($to);
    }

    public function setFrom($from){

      $this->from = $this->sanitise($from);
    }

    // Create email
    public function create(){

      // Insert email
      $this->createEmail();

      // Send email
      return $this->sendEmail();
    }

    public function read(){

      $where = '';

      if(!isset($this->sql)){

        if(isset($this->id)){

          $where = "
            WHERE
              e.id = $this->id
          ";
        }

        $this->sql = "
          SELECT
            e.id,
            e.mail_list_id,
            e.subject,
            e.body,
            e.created
          FROM
            email e
          $where
          ORDER BY
            e.created DESC";
      }

      $res = $this->dbQuery($this->sql);

      return $res;
    }

    // Read emails
    public function edit(){

      // Overide default SQL query if sql property is set
      if(!isset($this->sql)){

        $this->sql = "
          UPDATE
            email
          SET
            mail_list_id = ". $this->mail_list_id .",
            subject = '". $this->subject ."',
            body = '". $this->body ."'
          WHERE
            id = $this->id
        ";
      }

      // Query resultset
      $res = $this->dbQuery($this->sql);

      // Set the success & fail messages
      $success = 'Email Successfully Updated.';
      $fail = 'Failed To Update Email.';

      // Output message to browser
      $return = $this->htmlOutput($success, $fail);

      return $return;
    }

    // Delete email
    public function delete(){

      $sql = "
        DELETE
        FROM
          email
        WHERE
          id = $this->id
      ";

      // Query resultset
      $res = $this->dbQuery($sql);

      // Set the success & fail messages
      $success = 'Email Successfully Deleted.';
      $fail = 'Failed To Delete Email.';

      // Output message to browser
      $return = $this->htmlOutput($success, $fail);

      return $return;

    }

  // Insert email into database
  private function createEmail(){

    $sql = "
      INSERT
      INTO
        email
        (
          mail_list_id,
          subject,
          body,
          created
        )
        VALUES
        (
          ". $this->mail_list_id .",
          '". $this->subject ."',
          '". $this->body ."',
          '". date('Y-m-d H:i:s') ."'
        )
    ";

    $res = $this->dbQuery($sql);
  }

  // Get the subscribers
  private function getSubscribers(){

    $sql = "
      SELECT
        sml.subscriber_id,
        sml.mail_list_id,
        s.first_name,
        s.last_name,
        s.email
      FROM
        subscriber_mailing_list sml
      JOIN
        subscriber s ON sml.subscriber_id = s.id
      WHERE
        sml.mail_list_id = ". $this->mail_list_id ."
    ";

    $this->res = $this->dbQuery($sql);
  }

  // Send bulk mail
  private function sendEmail(){

    // Get the subscribers from the mailing list
    $this->getSubscribers();
    while($row = $this->res->fetch_assoc()){

      $this->first_name = $row['first_name'];
      $this->last_name = $row['last_name'];
      $this->email = $row['email'];

      // Save to email log
      $sql = "
        INSERT
        INTO
          email_log
            (
              email_id,
              subscriber_id,
              status,
              created
            )
            VALUES
            (
              ". $this->getLastId('email') .",
              ". $row['subscriber_id'] .",
              'Sent',
              '". date('Y-m-d') ."'
              )
      ";

      // Execute the query
      $this->dbQuery($sql);

      // Send emails
      $this->send();

      // Save Mailgun id for tracking
      $id = $this->getLastId('email_log');

      $sql = "
        UPDATE
          email_log
        SET
          mailgun_id = '". $this->mailgun_id ."',
          status = 'Sent'
        WHERE
          id = ". $id ."
      ";

      $this->dbQuery($sql);
    }

    // Set the success & fail messages
    $success = 'Email Successfully Sent.';
    $fail = 'Failed To Send Email.';

    // Output message to browser
    $return = $this->htmlOutput($success, $fail);

    return $return;
  }

  // Send emails with Mailgun
  private function send(){

    $client = new \Http\Adapter\Guzzle6\Client();
    $mailgun = new \Mailgun\Mailgun(API_KEY, $client);

    // Array to send to Mailgun
    $arr = [
      'from'    => SYSTEM . '<' . EMAIL . '>',
      'to'      => $this->first_name .' '. $this->last_name .' <'. $this->email .'>',
      'subject' => $this->subject,
      'html'    => $this->body
    ];

    # Make the call to the client.
    $result = $mailgun->sendMessage(DOMAIN, $arr);

    // Det the unique id
    $this->mailgun_id = $result->http_response_body->id;
  }

  public function getEvents(){

    # Instantiate the client.
    $mgClient = new Mailgun(API_KEY);
    $domain = DOMAIN;
    $queryString = array('event' => 'rejected OR failed');

    # Make the call to the client.
    $result = $mgClient->get("$domain/events");

    echo '<pre>' . var_dump($result->http_response_body->items) . '</pre>';
  }
}

?>
