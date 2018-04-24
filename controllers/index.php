<?php session_start();
include 'initialize.php';

if($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'superadmin') {
	header('Location:../pages/login.php');
} else {
	
// Which sections each role can see
if($_SESSION['role'] == 'superadmin') {
	$superadmin = '';
} else {
	$superadmin = 'hidden';
}
	//Run page

	//Zones Keys table
	$tableName = 'zones_Keys';
	
if ($_SESSION['role'] == 'superadmin') {

	//Expression attribute values
	$eav = $marshaler->marshalJson('
	    {
	        ":active": true,
					":isactive": "true",
					":allowedZones": "'.$_SESSION['allowedZones'].'"
	    }
	');

	$params = [
	    'TableName' => $tableName,
	    'ProjectionExpression' => '#act, zoneId',
	    'FilterExpression' => '#act IN (:active, :isactive) and zoneId = :allowedZones',
	    'ExpressionAttributeNames'=> [ '#act' => 'isActive' ],
	    'ExpressionAttributeValues'=> $eav
	];
	
} else {
	
	//Expression attribute values
	$eav = $marshaler->marshalJson('
	    {
	        ":active": true,
					":isactive": "true",
					":allowedZones": "'.$_SESSION['allowedZones'].'",
					":approvedBy": "'.$_SESSION['userId'].'"
	    }
	');

	$params = [
	    'TableName' => $tableName,
	    'ProjectionExpression' => '#act, zoneId',
	    'FilterExpression' => '#act IN (:active, :isactive) and zoneId = :allowedZones and approvedBy = :approvedBy',
	    'ExpressionAttributeNames'=> [ '#act' => 'isActive' ],
	    'ExpressionAttributeValues'=> $eav
	];
	
}

	try {
	    while (true) {
	        $result = $dynamodb->scan($params);
					$active_keys_count = 0;
	        foreach ($result['Items'] as $i) {
	            $active_keys_count ++;
	        }

	        if (isset($result['LastEvaluatedKey'])) {
	            $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
	        } else {
	            break;
	        }
	    }

	} catch (DynamoDbException $e) {
	    echo "Unable to scan:\n";
	    echo $e->getMessage() . "\n";
	}

}


?>
