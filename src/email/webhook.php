<?php

require_once('../../config/config.php');
require_once(ROOT . PATH .'src/class/email.php');

$email = new Email();

$from = "karsten@kwd.co.za";
$to = "karsten@kwd.co.za";

$key = API_KEY;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(
		isset($_POST['timestamp']) && isset($_POST['token']) && isset($_POST['signature']) &&
		hash_hmac('sha256', $_POST['timestamp'] . $_POST['token'], $key) === $_POST['signature']
		){

		if($_POST['event'] == 'delivered'){

			$subject = "[Mailgun] Delivered";
			$body = "Recipient: " . $_POST['recipient'] . "\nDomain: " . $_POST['domain'] . "\n\nMessage-headers: " . $_POST['message-headers'] . "\n";
			mail($to, $subject, $body, "From: " . $from,"-f". $from);

		} elseif($_POST['event'] == 'accepted'){

			$subject = "[Mailgun] Accepted";
			$body = "Recipient: " . $_POST['recipient'] . "\nDomain: " . $_POST['domain'] . "\n\nMessage-headers: " . $_POST['message-headers'] . "\n";
			mail($to, $subject, $body, "From: " . $from,"-f". $from);

		} elseif($_POST['event'] == 'opened'){

			$subject = "[Mailgun] Opened";
			$body = "Recipient: " . $_POST['recipient'] . "\nDomain: " . $_POST['domain'] . "\nCode: " . $_POST['code'] . "\nError: " . $_POST['error'] . "\nNotification: " . $_POST['notification'] . "\n\nMessage-headers: " . $_POST['message-headers'] . "\n";
			mail($to, $subject, $body, "From: " . $from,"-f". $from);

		} elseif($_POST['event'] == 'failed'){

			$subject = "[Mailgun] Failed";
			$body = "Recipient: " . $_POST['recipient'] . "\nDomain: " . $_POST['domain'] . "\nCode: " . $_POST['code'] . "\nError: " . $_POST['error'] . "\nNotification: " . $_POST['notification'] . "\n\nMessage-headers: " . $_POST['message-headers'] . "\n";
			mail($to, $subject, $body, "From: " . $from,"-f". $from);
		}
	}

	//var_dump($_POST['Message-Id']);
	var_dump($_POST['event']);

  $sql = "
    UPDATE
      email_log
    SET
      status = '". ucfirst($_POST['event']) ."'
		WHERE
		 	mailgun_id = '". $_POST['Message-Id'] ."'
  ";

  $sql = $email->setSQL($sql);

  $email->edit($sql);
}
