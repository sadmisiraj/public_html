<?php

require_once '../vendor/autoload.php';
require_once '../app/Helpers/helpers.php';

// Test image path
$imagePath = 'offerImage/test-offer.png';
$imageDriver = 'local';

// Test if the file exists
$localPath = '../assets/upload/' . $imagePath;
$exists = file_exists($localPath);

// Get the image URL
$imageUrl = getFile($imageDriver, $imagePath, true);

echo "<h1>Image Test</h1>";
echo "<p>Image Path: {$imagePath}</p>";
echo "<p>Image Driver: {$imageDriver}</p>";
echo "<p>Local Path: {$localPath}</p>";
echo "<p>Exists: " . ($exists ? 'Yes' : 'No') . "</p>";
echo "<p>Image URL: {$imageUrl}</p>";
echo "<p>Image Preview:</p>";
echo "<img src='{$imageUrl}' alt='Test Image' style='max-width: 300px;'>"; 