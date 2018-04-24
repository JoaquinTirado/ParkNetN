<?php
require 'vendors/aws/aws-autoloader.php';
date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'region'   => 'us-east-1',
    'version'  => 'latest',
    'credentials' => [
        'key'    => 'AKIAJ55KEJCD57SCUC6A',
        'secret' => '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',
    ]
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

?>
