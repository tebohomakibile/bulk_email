<?php
$file = 'config.php';

if(!empty($_POST['root-path'])){

  $path = "define('PATH', '". $_POST['root-path'] ."/');";

} else {

  $path = "define('PATH', '');";
}

$data = "<?php
session_start();

define('DB_HOST', '". $_POST['db-host'] ."');
define('DB_USER', '". $_POST['db-user'] ."');
define('DB_PWD', '". $_POST['db-password'] ."');
define('DB_DATABASE', '". $_POST['db-name'] ."');

// Define API Key
define('API_KEY', '". $_POST['mg-api-key'] ."');

// Define the domain
define('DOMAIN', '". $_POST['mg-domain'] ."');

// Define the email address to send emails
define('EMAIL', '". $_POST['email'] ."');

// Define the system name
define('SYSTEM', '". $_POST['sys-name'] ."');

// Define the directory sepearator
define('DS', DIRECTORY_SEPARATOR);

// Define Absolute URL's
define('HOST', 'http://" . $_SERVER['HTTP_HOST'] . "/');
". $path ."
define('ROOT', '". $_SERVER['DOCUMENT_ROOT'] ."/');

define('CSS', HOST . PATH . 'css/');
define('JS', HOST . PATH . 'js/');
define('IMG', HOST . PATH . 'images/');
define('CLASSES', ROOT .  PATH . 'src/class/');
define('TEMPLATES', ROOT . PATH . 'templates/');

 ?>

";
// Write the contents back to the file
file_put_contents($file, $data);

$host = $_POST['db-host'];
$username = $_POST['db-username'];
$password = $_POST['db-password'];
$db_name = $_POST['db-name'];

$conn = new mysqli($host, $username, $password, $db_name);

$sql[] .= "
  SET FOREIGN_KEY_CHECKS = 0;
";

$sql[] .= "
  DROP TABLE IF EXISTS `subscriber_mailing_list`;
";

$sql[] .= "
  DROP TABLE IF EXISTS `email_status`;
";

$sql[] .= "
  DROP TABLE IF EXISTS `user`;
";

$sql[] .= "
  DROP TABLE IF EXISTS `mailing_list`;
";

$sql[] .= "
  DROP TABLE IF EXISTS `subscriber`;
";

$sql[] .= "
  DROP TABLE IF EXISTS `email`;
";

$sql[] .= "
  DROP TABLE IF EXISTS `email_log`;
";

$sql[] .= "
  SET GLOBAL FOREIGN_KEY_CHECKS = 1;
";

$sql[] .= "
  CREATE TABLE IF NOT EXISTS `user` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `username` VARCHAR(355) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created` DATE NOT NULL,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  );
  ";

$sql[] .= "
  CREATE TABLE IF NOT EXISTS `mailing_list` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `list_name` VARCHAR(255) NOT NULL,
    `created` DATE NOT NULL,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  );
  ";

$sql[] .= "
  CREATE TABLE IF NOT EXISTS `subscriber` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(355) NOT NULL,
    `created` DATE NOT NULL,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  );
  ";

$sql[] .= "
  CREATE TABLE IF NOT EXISTS `subscriber_mailing_list` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `subscriber_id` INT(11) UNSIGNED NOT NULL,
    `mail_list_id` INT(11) UNSIGNED NOT NULL,
    `created` DATE NOT NULL,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT FK_subscriber_mailing_list_subscriberid FOREIGN KEY (subscriber_id) REFERENCES `subscriber`(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FK_subscriber_mailing_list_maillistid FOREIGN KEY (mail_list_id) REFERENCES `mailing_list`(id) ON UPDATE CASCADE ON DELETE CASCADE
  );
  ";

$sql[] .= "
  CREATE TABLE IF NOT EXISTS  `email` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `mail_list_id` INT(11) UNSIGNED NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `created` DATE NOT NULL,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  );
  ";

$sql[] .= "
  CREATE TABLE IF NOT EXISTS `email_log` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `mailgun_id` VARCHAR(255),
    `email_id` INT(11) UNSIGNED NOT NULL,
    `subscriber_id` INT(11) UNSIGNED NOT NULL,
    `status` VARCHAR(255),
    `created` DATE NOT NULL,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT FK_email_log_emailid FOREIGN KEY (email_id) REFERENCES `email`(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FK_email_log_subscriberid FOREIGN KEY (subscriber_id) REFERENCES `subscriber`(id) ON UPDATE CASCADE ON DELETE CASCADE
  );
  ";

$sql[] .= "
  CREATE TABLE IF NOT EXISTS  `email_status` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `status` VARCHAR(255) NOT NULL,
    `created` DATE NOT NULL,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  );
  ";

$sql[] .= "
  INSERT INTO `email_status` (`status`, `created`) VALUES ('Sent', NOW()), ('Delivered', NOW()), ('Read', NOW()), ('Failed', NOW());

";

// Loop through sql array and execute the queries
foreach($sql as $query){

  $conn->query($query);
}

?>
