<?php
/** @var \pmill\AwsCognito\CognitoClient $client */
$client = require('../assets/aws-cognito/bootstrap.php');

$username = $_SESSION['email'];
$refreshToken = $_SESSION['RefreshToken'];
$password = $_SESSION['pss'];

$refreshResponse = $client->refreshAuthentication($username, $refreshToken, $password);

$_SESSION['AccessToken'] = $refreshResponse['AccessToken'];
$_SESSION['RefreshToken'] = $refreshResponse['RefreshToken'];
$_SESSION['IdToken'] = $refreshResponse['IdToken'];
