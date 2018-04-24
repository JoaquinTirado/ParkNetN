<?php session_start();
include '../initialize.php';

//Zones Keys table
$tableName = 'zones_Users';
	
	//Expression attribute values
	$eav = $marshaler->marshalJson('
			{
					":allowedZones": "'.$_SESSION['allowedZones'].'",
					":currentUser": "'.$_SESSION['userId'].'"
			}
	');
	
	$params = [
			'TableName' => $tableName,
			'ProjectionExpression' => '#id, #act, #nam, #em, phoneNumber, #rol',
			'FilterExpression' => 'allowedZones = :allowedZones and not #id = :currentUser',
			'ExpressionAttributeNames'=> [ '#id' => 'id', '#act' => 'isActive', '#nam' => 'name', '#em' => 'email', '#rol' => 'role' ],
			'ExpressionAttributeValues'=> $eav
	];

try {
		while (true) {
				$result = $dynamodb->scan($params);
				$keys = array();
				foreach ($result['Items'] as $i) {
					$key = $marshaler->unmarshalItem($i);
					//Determine which action to show depending on isActive status
					$isActive = $key['isActive'];
					if ($isActive == 'true') {
						$activeAction = '<button onclick="deactivateUser(this.id);" id="'.$key['id'].'" class="btn btn-danger" title="Deactivate">Deactivate</button>';
						$isActive_text = 'Active';
					} else {
						$activeAction = '<button onclick="activateUser(this.id);" id="'.$key['id'].'" class="btn btn-success" title="Activate">Activate</button>';
						$isActive_text = 'Inactive';
					}
					
					//Determine which action to show depending on role
					$role = $key['role'];
					if ($role == 'admin') {
						$roleAction = '<button onclick="makeSuperadmin(this.id);" id="'.$key['id'].'" class="btn btn-success" title="Super Admin">Promote</button>';
						$role_text = 'Admin';
					} else {
						$roleAction = '<button onclick="makeAdmin(this.id);" id="'.$key['id'].'" class="btn btn-primary" title="Admin">Demote</button>';
						$role_text = 'Super Admin';
					}
					
					$newKey = array('id' => $key['id'],
													'userName' => $key['name'],
													'userEmail' => $key['email'],
													'userPhone' => $key['phoneNumber'],
													'userRole' => $role_text,
													'roleAction' => $roleAction,
													'isActive' => $isActive_text,
													'activeAction' => $activeAction);
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
