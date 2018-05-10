<?php
use pmill\AwsCognito\CognitoClient;
use pmill\AwsCognito\Exception\ChallengeException;
/** @var \pmill\AwsCognito\CognitoClient $client */
$client = require('../assets/aws-cognito/bootstrap.php');

$password = 'Temp1234!';
$email    = $_POST['email'];
$username = $_POST['username'];
$phone    = $_POST['phone'];

    $result = $client->registerUser($username, $password, [
      'email' => $email,
      'email_verified' => 'true',
      'phone_number' => $phone,
      'phone_number_verified' => 'true'
    ]);

$new_user_username = $result['User']['Username'];
$new_user_sub      = $result['User']['Attributes'][0]['Value'];
$new_user_phone    = $result['User']['Attributes'][3]['Value'];
$new_user_email    = $result['User']['Attributes'][4]['Value'];


