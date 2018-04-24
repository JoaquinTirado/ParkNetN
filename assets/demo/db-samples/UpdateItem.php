<?php
require '../../../assets/vendors/aws/aws-autoloader.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'region'   => 'us-east-1',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'zones_Users';

$key = $marshaler->marshalJson('
    {
        "id": ""
    }
');


$eav = $marshaler->marshalJson('
    {
        ":n": ""
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
    echo $result['Attributes'];

} catch (DynamoDbException $e) {
    echo "Unable to update item:\n";
    echo $e->getMessage() . "\n";
}

?>
