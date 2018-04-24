<?php
/** @var \pmill\AwsCognito\CognitoClient $client */
$client = require(__DIR__ . '/bootstrap.php');

$username = 'luis@borilabs.com';
$password = 'Test123!';

$authenticationResponse = $client->authenticate($username, $password);
$accessToken = $authenticationResponse['AccessToken'];

$client->deleteUser($accessToken);
