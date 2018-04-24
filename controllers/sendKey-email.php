<?php
require_once '../assets/vendors/aws/aws-autoloader.php';

use Aws\Credentials\Credentials;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Aws\Signature\SignatureV4;

$url = 'https://zvz4q8pp3m.execute-api.us-east-1.amazonaws.com/prod/sendKey_email?visitorName='.$visitorName.'&keyId='.$keyId.'&visitorEmail='.$visitorReceiver.'&keyType='.$keyType.'&keyStartTimestamp='.$keyStartTimestamp.'&keyEndTimestamp='.$keyEndTimestamp.'&zoneId='.$zoneId;

$region = 'us-east-1';

$headers = array('Authorization' => $_SESSION['IdToken']);

$client = new Client();
$request = new Request('POST', $url, $headers);

$response = $client->send($request);

$data = $response->getBody();
$decoded = json_decode($data, true);

print($data);

?>
