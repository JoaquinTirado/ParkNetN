<?php
use pmill\AwsCognito\CognitoClient;
use pmill\AwsCognito\Exception\ChallengeException;

/** @var CognitoClient $client */
$client = require('../assets/aws-cognito/bootstrap.php');
$username = $_POST['email'];

try {
    $authenticationResponse = $client->sendForgottenPasswordRequest($username);
} catch (ChallengeException $e) {
    $challenge = $e->getChallengeName();
}
