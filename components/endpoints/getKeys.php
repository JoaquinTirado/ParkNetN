<?php include '../../initialize.php';

		//Users table
		$tableName = 'zones_Keys';

		// //Capture variables
		$keyId = $_GET['keyId'];

		$key = $marshaler->marshalJson('
		    {
		        "id": "' . $keyId . '"
		    }
		');

		$params = [
		    'TableName' => $tableName,
		    'Key' => $key
		];

		try {

        $result = $dynamodb->getItem($params);

		    if ($result["Item"]) {
          $key = $marshaler->unmarshalItem($result["Item"]);
          print_r(json_encode($key));
        } else {
          print_r('{"isValid": false}');
        }

		} catch (DynamoDbException $e) {
		    echo "Unable to get item:\n";
		    echo $e->getMessage() . "\n";
		}

?>
