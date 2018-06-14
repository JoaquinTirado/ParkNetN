<?php session_start();
include '../initialize.php';

$action = $_POST['action'];

if ($action == 'deactivate') {

  if(!empty($_POST['keyid'])){
    //Zones Keys Table
    $tableName = 'zones_Keys';

    $keyid = $_POST['keyid'];

    $key = $marshaler->marshalJson('
        {
            "id": "' . $keyid . '"
        }
    ');

    $eav = $marshaler->marshalJson('
        {
            ":d": false
        }
    ');

    $params = [
        'TableName' => $tableName,
        'Key' => $key,
        'UpdateExpression' =>
            'set isActive = :d',
        'ExpressionAttributeValues'=> $eav,
        'ReturnValues' => 'UPDATED_NEW'
    ];

    try {
        $result = $dynamodb->updateItem($params);

        if ($_SESSION['allowedZones'] == 'cocohaus_1') {
      		include '../controllers/deleteKey-coco.php';
      	} else if ($_SESSION['allowedZones'] == 'parallel18_1') {
      		include '../controllers/deleteKey-parallel.php';
      	} else if ($_SESSION['allowedZones'] == 'test_1') {
      		include '../controllers/deleteKey-test.php';
      	} else if ($_SESSION['allowedZones'] == 'vitech_1') {
      		include '../controllers/deleteKey-vitech.php';
      	} else if ($_SESSION['allowedZones'] == 'inteldot_1') {
      		include '../controllers/deleteKey-inteldot.php';
      	}

    } catch (DynamoDbException $e) {
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
    }

  } else {
    echo "No post data";
  }

}


?>
