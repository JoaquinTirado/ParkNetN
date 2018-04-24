<?php session_start();
include '../initialize.php';

$action = $_POST['action'];

if ($action == 'login') {

	if(!empty($_POST['email']) && !empty($_POST['password'])){

		include '../assets/aws-cognito/login.php';

		if ($needChangePassword == 2) {
			echo json_encode(array("success" => 2, "email" => $username, "password" => $password));
		} else if ($needChangePassword == 3) {
			echo json_encode(array("success" => 3));
		} else if ($needChangePassword == 1) {
			include 'login-handler.php';
			//Users table
			$tableName = 'zones_Users';

			$key = $marshaler->marshalJson('
			    {
			        "id": "' . $userId . '"
			    }
			');

			$params = [
			    'TableName' => $tableName,
			    'Key' => $key
			];

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
						$_SESSION['pss'] = $password;
						echo json_encode(array("success" => 1));
					} else {
						echo "Wrong username or password.";
					}

			} catch (DynamoDbException $e) {
			    echo "Unable to get item:\n";
			    echo $e->getMessage() . "\n";
			}
		} else {
			echo "There was an error in the login.";
		}


	} else {
		echo "No post data";
		exit;
	}

} else if ($action == 'forgotPassword') {

  if(!empty($_POST['email'])) {

		include '../assets/aws-cognito/forgotPasswordRequest.php';
		echo json_encode(array("success" => 1));

  } else {
    echo "No email posted";
  }

} else if ($action == 'registerUser') {
	
		include '../assets/aws-cognito/registerUser.php';
		
		//Users table
		$tableName = 'zones_Users';

		//Capture variables
		$userRole = "admin";
		$userAllowedZones = $_SESSION['allowedZones'];

		$item = $marshaler->marshalJson('
				{
						"id": "' . $new_user_sub . '",
						"allowedZones": "' . $userAllowedZones . '",
						"name": "Needs Change",
						"email": "' . $new_user_email . '",
						"phoneNumber": "' . $new_user_phone . '",
						"role": "' . $userRole . '",
						"isActive": "true"
				}
		');

		$params = [
				'TableName' => $tableName,
				'Item' => $item
		];


		try {
				$result = $dynamodb->putItem($params);
				echo json_encode(array("success" => 1));

		} catch (DynamoDbException $e) {
				echo "Unable to add item:\n";
				echo $e->getMessage() . "\n";
		}

}

?>
