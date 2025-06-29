<?php

// Load the secret from the file
$secret = trim(file_get_contents("/var/www/clarknav-api/github_secret"));

if (!$secret) {
    http_response_code(500);
    die("Secret not found.");
}

// Get GitHub signature
$signature = $_SERVER["HTTP_X_HUB_SIGNATURE_256"] ?? '';

// Compute expected hash
$payload = file_get_contents("php://input");
$expected_signature = "sha256=" . hash_hmac("sha256", $payload, $secret);

// Debugging: Log values to check if they match
file_put_contents("/var/www/clarknav-api/deploy_debug.log", "Expected: $expected_signature\nReceived: $signature\n", FILE_APPEND);

if (!hash_equals($expected_signature, $signature)) {
    http_response_code(403);
    die("Invalid signature");
}

// Run deployment script
exec("sh /var/www/clarknav-api/deploy.sh > /var/www/clarknav-api/deploy.log 2>&1 &");

http_response_code(200);
echo "Deployment triggered!";
