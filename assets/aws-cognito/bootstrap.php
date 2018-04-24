<?php

require_once '../assets/vendors/aws/aws-autoloader.php';

$config = require('../assets/aws-cognito/config.php');

$aws = new \Aws\Sdk($config);
$cognitoClient = $aws->createCognitoIdentityProvider();

$client = new \pmill\AwsCognito\CognitoClient($cognitoClient);
$client->setAppClientId($config['app_client_id']);
$client->setAppClientSecret($config['app_client_secret']);
$client->setRegion($config['region']);
$client->setUserPoolId($config['user_pool_id']);

return $client;
