<?php
require '../../../assets/vendors/aws/aws-autoloader.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'region'   => 'us-east-1',
    'version'  => 'latest',
    'credentials' => [
        'key'    => '',
        'secret' => '',
    ]
]);

$dynamodb = $sdk->createDynamoDb();

$marshaler = new Marshaler();

//Expression attribute values
$eav = $marshaler->marshalJson('
    {
        ":userid": "1"
    }
');

$params = [
    'TableName' => 'users_mvps',
    'ProjectionExpression' => '#id, email',
    'FilterExpression' => '#id = :userid',
    'ExpressionAttributeNames'=> [ '#id' => 'userId' ],
    'ExpressionAttributeValues'=> $eav
];

echo "Scanning Users table.\n";

try {
    while (true) {
        $result = $dynamodb->scan($params);

        foreach ($result['Items'] as $i) {
            $user = $marshaler->unmarshalItem($i);
            echo $user['userId'] . ' : ' . $user['email']
                . "\n";
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

?>
