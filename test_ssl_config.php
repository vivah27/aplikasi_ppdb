<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

// Set certificate path
$certPath = 'C:/laragon/etc/ssl/cacert.pem';

echo "Testing SSL Certificate Configuration\n";
echo "====================================\n\n";

echo "1. Certificate File Exists: ";
echo file_exists($certPath) ? "✅ YES\n" : "❌ NO\n";

echo "2. Certificate Path: $certPath\n\n";

// Test Google OAuth endpoint
echo "3. Testing connection to Google OAuth endpoint...\n";
try {
    $client = new Client([
        'verify' => $certPath,
        'timeout' => 10,
    ]);
    
    $response = $client->get('https://www.googleapis.com/oauth2/v4/token', [
        'query' => ['client_id' => '1'],
        RequestOptions::VERIFY => $certPath,
    ]);
    
    echo "✅ Connection successful (Status: " . $response->getStatusCode() . ")\n\n";
} catch (\Exception $e) {
    echo "⚠️ Connection result: " . $e->getMessage() . "\n\n";
}

// Check Laravel environment
echo "4. Laravel Configuration:\n";
echo "   APP_URL: " . config('app.url') . "\n";
echo "   GOOGLE_CLIENT_ID: " . (env('GOOGLE_CLIENT_ID') ? '✅ Set' : '❌ Not set') . "\n";
echo "   GOOGLE_REDIRECT_URI: " . config('services.google.redirect') . "\n";
echo "   CURL_CA_BUNDLE: " . env('CURL_CA_BUNDLE', 'Not set') . "\n\n";

echo "5. PHP Extensions:\n";
echo "   cURL: " . (extension_loaded('curl') ? "✅ Loaded\n" : "❌ Not loaded\n");
echo "   OpenSSL: " . (extension_loaded('openssl') ? "✅ Loaded\n" : "❌ Not loaded\n");

echo "\n✅ All tests completed!\n";
