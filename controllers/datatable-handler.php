<?php session_start();
include '../initialize.php';

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
			'ProjectionExpression' => '#id, #act, recipientName, recipientPhone, keyType, createdTimestamp, approvedBy, keyStartTimestamp, keyEndTimestamp, zoneId',
			'FilterExpression' => '#act IN (:active, :isactive) and zoneId = :allowedZones',
			'ExpressionAttributeNames'=> [ '#id' => 'id', '#act' => 'isActive' ],
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
			'ProjectionExpression' => '#id, #act, recipientName, recipientPhone, keyType, createdTimestamp, approvedBy, keyStartTimestamp, keyEndTimestamp, zoneId',
			'FilterExpression' => '#act IN (:active, :isactive) and zoneId = :allowedZones and approvedBy = :approvedBy',
			'ExpressionAttributeNames'=> [ '#id' => 'id', '#act' => 'isActive' ],
			'ExpressionAttributeValues'=> $eav
	];
}

try {
		while (true) {
				$result = $dynamodb->scan($params);
				$keys = array();
				foreach ($result['Items'] as $i) {
					$key = $marshaler->unmarshalItem($i);
						//Get User Name
						$tableName = 'zones_Users';
						$userId = $key['approvedBy'];
						$key2 = $marshaler->marshalJson('{"id": "' . $userId . '"}');
						$params = ['TableName' => $tableName, 'Key' => $key2];
						try {
								$results = $dynamodb->getItem($params);
								$userName = $results["Item"]["name"]["S"];
						} catch (DynamoDbException $e) {
								echo "Unable to get item:\n";
								echo $e->getMessage() . "\n";
						}
					$createdDate = date("Y-m-d", substr($key['createdTimestamp'], 0, 10));
					$startDate = date("Y-m-d", substr($key['keyStartTimestamp'], 0, 10));
					//corregir despues //
					$endDate = date("Y-m-d", 9000000);

					$actions = '<a onclick="deactivateAction(this.id, this.name);" id="'.$key['id'].'" name="'.$key['recipientName'].'" class="deactivate m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
												<i class="la la-trash"></i>
											</a>';
					$newKey = array('recipientName' => $key['recipientName'],
													'recipientPhone' => $key['recipientPhone'],
													'keyType' => $key['keyType'],
													'createdDate' => $createdDate,
													'startDate' => $startDate,
													'endDate' => $endDate,
													'approvedBy' => $userName,
													'actions' => $actions,
													'id' => $key['id']);
					array_push($keys, $newKey);
				}
				echo (json_encode(array('data' => $keys)));

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


?>
