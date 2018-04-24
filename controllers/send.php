<?php session_start();
include '../initialize.php';

if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'superadmin') {
	header('Location:../pages/login.php');
} else {
	//Run page

$action = $_POST['action'];

if ($action == 'submitKey') {

  if(!empty($_POST['keyid']) && !empty($_POST['name']) && !empty($_POST['receiver'])){
    //Capture variables
		$approvedBy 	= $_SESSION['userId'];
    $get_name     = $_POST['name'];
		$get_receiver = $_POST['receiver'];
		$get_keyid 		= $_POST['keyid'];
		$get_keytype 	= $_POST['keytype'];
		$get_createdtimestamp = $_POST['createdTimestamp'];
		$get_starttimestamp 	= $_POST['startTimestamp'];
		$get_endtimestamp 		= $_POST['endTimestamp'];

		$tableName = 'zones_Keys';

		$item = $marshaler->marshalJson('
		    {
		        "id": "' 								. $get_keyid . '",
		        "approvedBy": "' 				. $approvedBy . '",
						"createdTimestamp": "' 	. $get_createdtimestamp . '",
						"isActive": true,
						"keyBucketURL": "keyBucket",
						"keyEndTimestamp": "' 	. $get_endtimestamp . '",
						"keyStartTimestamp": "' . $get_starttimestamp . '",
						"keyType": "' 					. $get_keytype . '",
						"recipientName": "'			. $get_name . '",
						"recipientPhone": "'		. $get_receiver . '",
						"zoneId": "'						. $_SESSION['allowedZones'] . '"
		    }
		');

		$params = [
		    'TableName' => $tableName,
		    'Item' => $item
		];


		try {
		    $result = $dynamodb->putItem($params);

		} catch (DynamoDbException $e) {
		    echo "Unable to add item:\n";
		    echo $e->getMessage() . "\n";
		}

  } else {
    echo "No post data";
  }

} else if ($action == 'getTimestamp') {
	
	include '../assets/aws-cognito/refreshAuthentication.php';
	
	include '../controllers/puertoRicoTimestamp.php';
	
} else if ($action == 'getKey') {
	
	include '../assets/aws-cognito/refreshAuthentication.php';
	
	include '../controllers/parknetKey.php';
	
} else if ($action == 'sendKey') {
	
	include '../assets/aws-cognito/refreshAuthentication.php';

	$visitorName 				= $_POST['visitorName'];
	$visitorReceiver 		= $_POST['visitorReceiver'];
	$keyId 							= $_POST['keyId'];
	$keyType      			= $_POST['keytype'];
	$keyStartTimestamp 	= $_POST['startTimestamp'];
	$keyEndTimestamp 		= $_POST['endTimestamp'];
	$sendTo							= $_POST['sendTo'];
	$zoneId							= $_SESSION['allowedZones'];

	if ($sendTo == 'email') {
		include '../controllers/sendKey-email.php';
	} else if ($sendTo == 'text') {
		include '../controllers/sendKey-text.php';
	}
}

}


?>
