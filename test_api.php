<?php
$baseUrl = 'http://127.0.0.1:8000';

echo "=== TESTING API MIDDLEWARE ===\n\n";

// Test 1: Without API Key
echo "1. Testing WITHOUT API Key:\n";
echo "   URL: $baseUrl/api/products\n";
$response = file_get_contents("$baseUrl/api/products");
echo "   Response: $response\n\n";

// Test 2: With Invalid API Key
echo "2. Testing with INVALID API Key:\n";
$opts = ['http' => ['header' => 'API-KEY: invalid_key_here']];
$context = stream_context_create($opts);
$response = @file_get_contents("$baseUrl/api/products", false, $context);
echo "   Response: $response\n\n";

echo "=== To test with valid key, run: ===\n";
echo "curl -H \"API-KEY: YOUR_ACTUAL_API_KEY\" $baseUrl/api/products\n";
