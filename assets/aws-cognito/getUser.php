<?php
/** @var \pmill\AwsCognito\CognitoClient $client */
$client = require(__DIR__ . '/bootstrap.php');

$accessToken = 'eyJraWQiOiJPNzdDdHZuSVBBbnkwVkJkcHJFWHozSTlaSWp4RVNQalZKMXFxVDdCMU5JPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiI1MTdiMzM5Yi1iZTA0LTQyNzEtODdkYS03ODZiNTNhYzk2N2IiLCJldmVudF9pZCI6ImI4ZDNjYjU3LTE4MjMtMTFlOC1iNDIxLWYzZDQ5MmVhMDQwZCIsInRva2VuX3VzZSI6ImFjY2VzcyIsInNjb3BlIjoiYXdzLmNvZ25pdG8uc2lnbmluLnVzZXIuYWRtaW4iLCJpc3MiOiJodHRwczpcL1wvY29nbml0by1pZHAudXMtZWFzdC0xLmFtYXpvbmF3cy5jb21cL3VzLWVhc3QtMV9VaFpLb25HQkMiLCJleHAiOjE1MTkzNDM4MzQsImlhdCI6MTUxOTM0MDIzNCwianRpIjoiODQ0OTk5ZDMtN2YyOC00NWRhLWJjY2YtZjNkMWZhNjk2Y2JhIiwiY2xpZW50X2lkIjoiMTFrMm0zYnJjNzVyaDluOTVoN2toYWRiMzEiLCJ1c2VybmFtZSI6Ikx1aXNSYW1vcyJ9.Dj69voxu7m26CVUQoHDLpGLT430_hPURmGoE-R296u4iSSPvIlr5iQDTG8doiLsuoYZPh1IWQx8CqpRdETNIWeU_DtdQc9t-zckpf-YULrDh9LiyEWyNhVMW6RcoswQ18iilG2pDWryzmgqoe3395UcigH_K5BZWoMqIwbXQTcdTMpuveT_BrZ-ZNQsTqUo4VLyy8nPAKmrkLuQUvGreWtf7P3esB6s1C0SSDg0lv89UD8ZVbcIces-gbIVe-48AifRmWWyORzc8TmLaBkaXNkmpvX7uJ1wvYJy7-uCvT4jrFxE37H5LXwaSkEtWtiHHC-kFG0ZQGkp2PMg39t6QUA';

$username = $client->verifyAccessToken($accessToken);
var_dump($username);
