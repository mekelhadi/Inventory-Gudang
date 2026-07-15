<?php
// DIAGNOSTIC: This file tests if the deployment is updating
// If you see phpinfo output, the deployment works
// If you still see the old error, the build is failing

echo "<h1>Deployment Test</h1>";
echo "<p>If you see this page, the deployment updated successfully!</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>__DIR__: " . __DIR__ . "</p>";

// Check if vendor exists
$vendorPath = __DIR__ . '/../vendor/autoload.php';
echo "<p>Vendor path: " . $vendorPath . "</p>";
echo "<p>Vendor exists: " . (file_exists($vendorPath) ? 'YES' : 'NO') . "</p>";

// List files in parent directory
echo "<h2>Files in parent directory:</h2>";
$parentDir = dirname(__DIR__);
if (is_dir($parentDir)) {
    $files = scandir($parentDir);
    echo "<ul>";
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $type = is_dir($parentDir . '/' . $file) ? 'DIR' : 'FILE';
            echo "<li>[$type] $file</li>";
        }
    }
    echo "</ul>";
}

// Check if vendor directory exists in parent
$vendorDir = dirname(__DIR__) . '/vendor';
echo "<h2>Vendor directory check:</h2>";
echo "<p>vendor dir exists: " . (is_dir($vendorDir) ? 'YES' : 'NO') . "</p>";
if (is_dir($vendorDir)) {
    echo "<p>vendor/autoload.php exists: " . (file_exists($vendorDir . '/autoload.php') ? 'YES' : 'NO') . "</p>";
}
