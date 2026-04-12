<?php
// Test API Middleware

$apiKey = 'PASTE_YOUR_API_KEY_HERE'; // Replace with actual API key
$baseUrl = 'http://127.0.0.1:8000';

echo "=== API MIDDLEWARE TEST ===\n\n";

// Test 1: No API Key
echo "1. Test WITHOUT API Key:\n";
$ch = curl_init("$baseUrl/api/products");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "   Status: $httpCode\n";
echo "   Response: $response\n\n";

// Test 2: Wrong API Key
echo "2. Test with WRONG API Key:\n";
$ch = curl_init("$baseUrl/api/products");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['API-KEY: wrong_key_123']);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "   Status: $httpCode\n";
echo "   Response: $response\n\n";

// Test 3: Valid API Key (if provided)
if ($apiKey !== 'PASTE_YOUR_API_KEY_HERE') {
    echo "3. Test with VALID API Key:\n";
    $ch = curl_init("$baseUrl/api/products");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["API-KEY: $apiKey"]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "   Status: $httpCode\n";
    echo "   Response: " . substr($response, 0, 200) . "...\n\n";
} else {
    echo "3. To test with VALID key, edit this file and set \$apiKey variable\n\n";
}

echo "=== END ===\n";
