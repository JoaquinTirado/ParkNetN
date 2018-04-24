<?php
use pmill\AwsCognito\CognitoClient;
use pmill\AwsCognito\Exception\ChallengeException;
use pmill\AwsCognito\Exception\PasswordResetRequiredException;

/** @var CognitoClient $client */
$client = require('../assets/aws-cognito/bootstrap.php');
$username = $_POST['email'];
$password = $_POST['password'];
$new_password = $_POST['new_password'];

$user_name = $_POST['user_name'];

try {
    $authenticationResponse = $client->authenticate($username, $password);
} catch (ChallengeException $e) {
    if ($e->getChallengeName() === CognitoClient::CHALLENGE_NEW_PASSWORD_REQUIRED) {
        $authenticationResponse = $client->respondToNewPasswordRequiredChallenge($username, $new_password, $e->getSession());
        $needChangePassword = 1;
    }
} catch (PasswordResetRequiredException $e) {
    $needChangePassword = 3;
}

$accessToken = $authenticationResponse['AccessToken'];
$refreshToken = $authenticationResponse['RefreshToken'];
$idToken = $authenticationResponse['IdToken'];
