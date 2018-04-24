<?php
require '../../../assets/vendors/aws/aws-autoloader.php';
date_default_timezone_set('UTC');

use Aws\CognitoIdentity\CognitoIdentityClient;

$client = CognitoIdentityClient::factory(array(
    'region'  => 'us-east-1',
    'version' => 'latest'
));

$result = $client->describeIdentityPool(array(
    // IdentityPoolId is required
    'IdentityPoolId' => '',
));

print_r($result);

?>
