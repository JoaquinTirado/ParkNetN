<?php session_start();
include '../initialize.php';

$action = $_POST['action'];

if ($action == 'deactivate') {

  if(!empty($_POST['userid'])){
    //Zones Keys Table
    $tableName = 'zones_Users';

    $user_id = $_POST['userid'];

    $key = $marshaler->marshalJson('
        {
            "id": "' . $user_id . '"
        }
    ');

    $eav = $marshaler->marshalJson('
        {
            ":d": "false"
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

    } catch (DynamoDbException $e) {
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
    }

  } else {
    echo "No post data";
  }

} else if ($action == 'activate') {

  if(!empty($_POST['userid'])){
    //Zones Keys Table
    $tableName = 'zones_Users';

    $user_id = $_POST['userid'];

    $key = $marshaler->marshalJson('
        {
            "id": "' . $user_id . '"
        }
    ');

    $eav = $marshaler->marshalJson('
        {
            ":d": "true"
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

    } catch (DynamoDbException $e) {
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
    }

  } else {
    echo "No post data";
  }

} else if ($action == 'makeSuperadmin') {

  if(!empty($_POST['userid'])){
    //Zones Keys Table
    $tableName = 'zones_Users';

    $user_id = $_POST['userid'];
    
    $key = $marshaler->marshalJson('
        {
            "id": "' . $user_id . '"
        }
    ');

    $eav = $marshaler->marshalJson('
        {
            ":d": "superadmin"
        }
    ');

    $params = [
        'TableName' => $tableName,
        'Key' => $key,
        'UpdateExpression' =>
            'set #rol = :d',
        'ExpressionAttributeNames' => [ '#rol' => 'role' ],
        'ExpressionAttributeValues'=> $eav,
        'ReturnValues' => 'UPDATED_NEW'
    ];

    try {
        $result = $dynamodb->updateItem($params);

    } catch (DynamoDbException $e) {
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
    }

  } else {
    echo "No post data";
  }

} else if ($action == 'makeAdmin') {

  if(!empty($_POST['userid'])){
    //Zones Keys Table
    $tableName = 'zones_Users';

    $user_id = $_POST['userid'];

    $key = $marshaler->marshalJson('
        {
            "id": "' . $user_id . '"
        }
    ');

    $eav = $marshaler->marshalJson('
        {
            ":d": "admin"
        }
    ');

    $params = [
        'TableName' => $tableName,
        'Key' => $key,
        'UpdateExpression' =>
            'set #rol = :d',
        'ExpressionAttributeNames' => [ '#rol' => 'role' ],
        'ExpressionAttributeValues'=> $eav,
        'ReturnValues' => 'UPDATED_NEW'
    ];

    try {
        $result = $dynamodb->updateItem($params);

    } catch (DynamoDbException $e) {
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
    }

  } else {
    echo "No post data";
  }

}


?>
