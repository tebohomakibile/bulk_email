<?php

require_once('../../config/config.php');
require_once(ROOT . PATH .'src/class/email.php');

$email = new Email();

$from = "karsten@kwd.co.za";
$to = "karsten@kwd.co.za";

//$key = API_KEY; var_dump($key);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if(isset($_POST['timestamp']) && isset($_POST['token']) && isset($_POST['signature']) && hash_hmac('sha256', $_POST['timestamp'] . $_POST['token'], $key) === $_POST['signature'])
	{
		if($_POST['event'] == 'complained') {
			$subject = "[Mailgun] Spam Complaint";
			$body = "Recipient: " . $_POST['recipient'] . "\nDomain: " . $_POST['domain'] . "\n\nMessage-headers: " . $_POST['message-headers'] . "\n";
			mail($to, $subject, $body, "From: " . $from,"-f". $from);

		}elseif($_POST['event'] == 'bounced'){

			$subject = "[Mailgun] Bounced Email";
			$body = "Recipient: " . $_POST['recipient'] . "\nDomain: " . $_POST['domain'] . "\nCode: " . $_POST['code'] . "\nError: " . $_POST['error'] . "\nNotification: " . $_POST['notification'] . "\n\nMessage-headers: " . $_POST['message-headers'] . "\n";
			mail($to, $subject, $body, "From: " . $from,"-f". $from);

		}elseif($_POST['event'] == 'dropped'){

			$subject = "[Mailgun] Failed Email";
			$body = "Recipient: " . $_POST['recipient'] . "\nDomain: " . $_POST['domain'] . "\nCode: " . $_POST['code'] . "\nReason: " . $_POST['reason'] . "\nDescription: " . $_POST['description'] . "\n\nMessage-headers: " . $_POST['message-headers'] . "\n";
			mail($to, $subject, $body, "From: " . $from,"-f". $from);
		}
	}

  $sql = "
    UPDATE
      email_log
    SET
      status = '". $_POST['event'] ."'
  ";

  $sql = $email->setSQL($sql);

  $email->edit($sql);
}
