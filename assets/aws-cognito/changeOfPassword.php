<?php
/** @var \pmill\AwsCognito\CognitoClient $client */
$client = require('../assets/aws-cognito/bootstrap.php');

$username = $_POST['email'];
$password = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];

$authenticationResponse = $client->authenticate($username, $password);
$accessToken = $authenticationResponse['AccessToken'];
$refreshToken = $authenticationResponse['RefreshToken'];
$idToken = $authenticationResponse['IdToken'];

$_SESSION['AccessToken'] = $accessToken;
$_SESSION['RefreshToken'] = $refreshToken;
$_SESSION['IdToken'] = $idToken;

$passwordChangeResponse = $client->changePassword($accessToken, $password, $newPassword);
var_dump($passwordChangeResponse);
$changePasswordStatus = 1;
