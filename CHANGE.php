<?php 
include 'initialize.php';
require_once 'assets/vendors/aws/aws-autoloader.php';


$email = 'random@gmail.com';

$tableName = 'zones_Users';

$params = [
		'TableName' => $tableName,
		'email' => $email
];

$response = $dynamodb->scan($params);


$name = $_POST['postData'];

if (isset($_POST['postData'])){
	if (strpos($response, $name) !== false) {
		echo "taken";
	}else {
		echo 'unique';

	}
}






