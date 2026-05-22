<?php
$opts = [
    'http' => [
        'method' => 'GET',
        'header' => 'Cookie: ' . @$_SERVER['HTTP_COOKIE'] . "\r\n",
        'follow_location' => 1,
    ],
];
$context = stream_context_create($opts);
$html = @file_get_contents('http://127.0.0.1:8000/admin/ocr-tasks/9', false, $context);
$httpCode = $http_response_header[0] ?? 'unknown';

echo "HTTP Code: $httpCode\n";
echo "Length: " . strlen($html) . "\n";

// Check for duplicate "Extracted Text"
$count = substr_count($html, 'Extracted Text');
echo "'Extracted Text' occurrences: $count\n";

// Check for bordered box class
$hasBox = strpos($html, 'rounded-lg border border-gray-300') !== false;
echo "Has bordered box: " . ($hasBox ? 'yes' : 'no') . "\n";

// Check for footer buttons
$hasEditBtn = strpos($html, 'Edit') !== false;
$hasDeleteBtn = strpos($html, 'Delete') !== false;
echo "Has Edit button: " . ($hasEditBtn ? 'yes' : 'no') . "\n";
echo "Has Delete button: " . ($hasDeleteBtn ? 'yes' : 'no') . "\n";

// Check for icon next to Extracted Text
$hasIcon = strpos($html, 'heroicon-o-document-text') !== false;
echo "Has document-text icon: " . ($hasIcon ? 'yes' : 'no') . "\n";
