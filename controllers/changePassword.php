<?php session_start();
include '../initialize.php';

$action = $_POST['action'];

if ($action == 'changePassword') {

		include '../assets/aws-cognito/changePassword.php';

		if ($needChangePassword == 3) {
			echo json_encode(array("success" => 3));
		} else if ($needChangePassword == 1) {
			include 'changePassword-handler.php';
			//Users table
			$tableName = 'zones_Users';
			
			$key = $marshaler->marshalJson('
			    {
			        "id": "' . $userId . '"
			    }
			');

			$eav = $marshaler->marshalJson('
			    {
			        ":n": "' . $user_name . '"
			    }
			');

			$params = [
			    'TableName' => $tableName,
			    'Key' => $key,
			    'UpdateExpression' =>
			        'set #nam = :n',
			    'ExpressionAttributeValues'=> $eav,
					'ExpressionAttributeNames'=> [ '#nam' => 'name' ],
			    'ReturnValues' => 'UPDATED_NEW'
			];

			try {
			    $result = $dynamodb->updateItem($params);
								//Get User Info
								$tableName = 'zones_Users';
								$key = $marshaler->marshalJson('{"id": "' . $userId . '"}');
								$params = ['TableName' => $tableName, 'Key' => $key];
								try {
										$result = $dynamodb->getItem($params);
										if ($accessToken) {
											session_start();
											$_SESSION['role'] = $result["Item"]["role"]["S"];
											$_SESSION['email'] = $result["Item"]["email"]["S"];
											$_SESSION['name'] = $result["Item"]["name"]["S"];
											$_SESSION['userId'] = $result["Item"]["id"]["S"];
											$_SESSION['allowedZones'] = $result["Item"]["allowedZones"]["S"];
											$_SESSION['AccessToken'] = $accessToken;
											$_SESSION['RefreshToken'] = $refreshToken;
											$_SESSION['IdToken'] = $idToken;
											$_SESSION['pss'] = $new_password;
											echo json_encode(array("success" => 1));
										} else {
											echo "Wrong username or password.";
										}
								} catch (DynamoDbException $e) {
										echo $e->getMessage() . "\n";
								}

			} catch (DynamoDbException $e) {
			    echo "Unable to update item:\n";
			    echo $e->getMessage() . "\n";
			}
			
		} else {
			echo "There was an error in the change of password.";
		}

}

?>
