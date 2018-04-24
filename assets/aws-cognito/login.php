<?php
use pmill\AwsCognito\CognitoClient;
use pmill\AwsCognito\Exception\ChallengeException;
use pmill\AwsCognito\Exception\PasswordResetRequiredException;

/** @var CognitoClient $client */
$client = require('../assets/aws-cognito/bootstrap.php');

$username = $_POST['email'];
$password = $_POST['password'];

try {
    $authenticationResponse = $client->authenticate($username, $password);
    $needChangePassword = 1;
} catch (ChallengeException $e) {
    if ($e->getChallengeName() === CognitoClient::CHALLENGE_NEW_PASSWORD_REQUIRED) {
        // $authenticationResponse = $client->respondToNewPasswordRequiredChallenge($username, $password, $e->getSession());
        $needChangePassword = 2;
    }
} catch (PasswordResetRequiredException $e) {
    $needChangePassword = 3;
}

  $accessToken = $authenticationResponse['AccessToken'];
  $refreshToken = $authenticationResponse['RefreshToken'];
  $idToken = $authenticationResponse['IdToken'];
