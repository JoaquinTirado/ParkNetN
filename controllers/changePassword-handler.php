<?php
require_once '../assets/vendors/aws/aws-autoloader.php';

use Aws\Credentials\Credentials;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Aws\Signature\SignatureV4;

$url = 'https://zvz4q8pp3m.execute-api.us-east-1.amazonaws.com/prod/protectedHelloCognito';
$region = 'us-east-1';
$headers = array('Authorization' => $idToken);
$client = new Client();
$request = new Request('GET', $url, $headers);
$response = $client->send($request);
$data = $response->getBody();
$decoded = json_decode($data, true);
$userId = $decoded['input']['requestContext']['authorizer']['claims']['sub'];
$userEmail = $decoded['input']['requestContext']['authorizer']['claims']['email'];
$userPhone = $decoded['input']['requestContext']['authorizer']['claims']['phone_number'];

?>
