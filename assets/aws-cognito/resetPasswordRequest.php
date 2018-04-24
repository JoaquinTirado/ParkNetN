<?php
use pmill\AwsCognito\CognitoClient;
use pmill\AwsCognito\Exception\ChallengeException;

/** @var CognitoClient $client */
$client = require('../assets/aws-cognito/bootstrap.php');
$reset_username = $_POST['reset_username'];
$confirmationCode = $_POST['confirmationCode'];
$proposedPassword = $_POST['new_password'];

try {
    $authenticationResponse = $client->resetPassword($confirmationCode, $reset_username, $proposedPassword);
} catch (ChallengeException $e) {
    $challenge = $e->getChallengeName();
}
