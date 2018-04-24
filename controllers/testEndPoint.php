<?php
require_once '../assets/vendors/aws/aws-autoloader.php';

use Aws\Credentials\Credentials;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Aws\Signature\SignatureV4;

$url = 'https://zvz4q8pp3m.execute-api.us-east-1.amazonaws.com/prod/puertoRicoTimestamp';
$region = 'us-east-1';

$headers = array('Authorization' => 'eyJraWQiOiJIOEFScnhya0htZnplTGVcL3JkbFhLeXhPUjNlQ3FjbGNMMHRtTmtuQlpzbz0iLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJhODc5YWE2YS1hNTVmLTRkZGMtYjY3MS1iMDQ1Y2YzYWExMDgiLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiaXNzIjoiaHR0cHM6XC9cL2NvZ25pdG8taWRwLnVzLWVhc3QtMS5hbWF6b25hd3MuY29tXC91cy1lYXN0LTFfVWhaS29uR0JDIiwicGhvbmVfbnVtYmVyX3ZlcmlmaWVkIjp0cnVlLCJjb2duaXRvOnVzZXJuYW1lIjoiTHVpc1JhbW9zIiwiYXVkIjoiMTFrMm0zYnJjNzVyaDluOTVoN2toYWRiMzEiLCJldmVudF9pZCI6Ijk2YzRjZGYyLTIyNzgtMTFlOC1hZTE2LWM1MDM2OGZjZmQzMyIsInRva2VuX3VzZSI6ImlkIiwiYXV0aF90aW1lIjoxNTIwNDc2MTk1LCJwaG9uZV9udW1iZXIiOiIrMTc4NzI0NzEzODciLCJleHAiOjE1MjA0Nzk3OTUsImlhdCI6MTUyMDQ3NjE5NSwiZW1haWwiOiJsdWlzQGJvcmlsYWJzLmNvbSJ9.AWpYe_D1U5rfPNVYeNSG1G03p6v-CYZVsd08-3nv_XqkswjFqkYotnZAK6D-HYiL-KiYCjoByJoTi6tboLc6UK8W55LIywYGGRxsk2K9dDma8c6F0U78mb0GRdBgE4QczN32P1ISGCxPJQhpQieEvvdq5FrmT8zeItgkv91FNXE7F9PgX82nnV1PtB7j_GKHhWmFj0-nPb9afQ3VZioLGOhhyo4ra13i-zTU2bPQWZ6dq9ESZWKp3pX-kxZ-fni-Fd-3cDIWXH-vHzRBPLUwIiXSGbO7ANeVWFKToea3X9Im7nk7BnoBWvJGRc1h_yXqhKS89nKE1tnd1Vc3f3BDcw');

$client = new Client();
$request = new Request('GET', $url, $headers);


$response = $client->send($request);

$data = $response->getBody();
$decoded = json_decode($data, true);

echo $data;


?>
