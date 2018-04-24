<?php
require_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;

$key = "eyJraWQiOiJPNzdDdHZuSVBBbnkwVkJkcHJFWHozSTlaSWp4RVNQalZKMXFxVDdCMU5JPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiI0Y2UwYzAwNS1iMmFjLTQ4N2YtYmVlMS1kNzY5NzBmMGVhM2MiLCJldmVudF9pZCI6IjE3ZDAwZTZkLTE4NjMtMTFlOC1iMDQwLTIzYTA2YjI0YTQ5YiIsInRva2VuX3VzZSI6ImFjY2VzcyIsInNjb3BlIjoiYXdzLmNvZ25pdG8uc2lnbmluLnVzZXIuYWRtaW4iLCJpc3MiOiJodHRwczpcL1wvY29nbml0by1pZHAudXMtZWFzdC0xLmFtYXpvbmF3cy5jb21cL3VzLWVhc3QtMV9VaFpLb25HQkMiLCJleHAiOjE1MTkzNzEwNTEsImlhdCI6MTUxOTM2NzQ1MSwianRpIjoiNjk5YTg4MTgtOWEyNS00MDY5LTgzYjgtNTFlMTc2N2UxZDYxIiwiY2xpZW50X2lkIjoiMTFrMm0zYnJjNzVyaDluOTVoN2toYWRiMzEiLCJ1c2VybmFtZSI6Ikx1aXNSYW1vcyJ9.VWkMVZR6B-ndJCCDZqmSdv5P573GCdm65nrtydAwouTIu3xSUhVdYYxzrH7p2pVd_Qi17cR_25QI2q90L2dMSKM1kngP-27iRv8HWhm0POrQsCwoZQeDEu-Kp4uEuo7REF1Ft0fYZ5Deo68em4M8jSAtFpIIK9o8UFe9UJ29TMDXuQImDrfsd0W4CLyJof0wuMGdzzOHeO_TAni0yLnvDvrmBVhuxb3x4TbtQT4MyExJYtu6SCDG7jWIUl_rQWvoUE6FkpVo_QJ6703oJqE4qxYqFnMwpXcVBE7QfhLFcAc5NBrADW7C5kt8J_3j8-t25cr1Sg_NUqr8qRmhhbIJVA";
$token = array(
  "typ" => "JWT",
  "alg" => "RS256",
  "kid" => "O77CtvnIPAny0VBdprEXz3I9ZIjxESPjVJ1qqT7B1NI="
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
 $jwt = JWT::encode($token, $key);
 $decoded = JWT::decode($jwt, $key, array('RS256'));

print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, $key, array('HS256'));

?>
