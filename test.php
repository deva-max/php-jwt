<?php

require 'vendor/autoload.php'; // Assuming you have installed the google/auth-library library via Composer

use Google\Auth\AccessTokenVerifier;

$jwtToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6ImtpZCJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJpYXQiOjE2ODU1MTI2MjUsIm5iZiI6MTY4NTUxMjYzNSwiZXhwIjoxNjg1NTEyNjU1LCJhdWQiOiJteXVzZXJzIiwiZGF0YSI6eyJuYW1lIjoidGUiLCJlbWFpbCI6InRlQGdtYWlsLmNvbSJ9fQ.04yULxZg-NlsA9Ab5AHA1lj3XKwm3CEEdTAU-4y2LfajWQB3t64Y0tpH5exVfOxn4RsPqxR3-f44wsy6DhK1_Q";
$clientID = "owt123";

$verifier = new AccessTokenVerifier();
$ticket = $verifier->verify($jwtToken, ['client_id' => $clientID]);

if ($ticket) {
    // Token is valid
    $payload = $ticket->getAttributes();
    print_r($payload);
} else {
    // Token is invalid
    echo 'Invalid token';
}
