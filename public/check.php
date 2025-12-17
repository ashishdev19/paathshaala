<?php
// Simple Server Check - No Laravel Dependencies
// Upload to: /home/healthboat/medniks.com/public/check.php
// Visit: http://medniks.com/check.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Server Check</title>";
echo "<style>body{font-family:Arial;margin:20px;background:#f5f5f5;} .box{background:white;padding:20px;margin:10px 0;border-radius:5px;border-left:4px solid #4CAF50;} .ok{color:green;font-weight:bold;} .error{color:red;font-weight:bold;} .warning{color:orange;font-weight:bold;} pre{background:#f9f9f9;padding:10px;overflow:auto;} h2{margin-top:0;}</style>";
echo "</head><body>";

echo "<h1>🔍 Server Health Check</h1>";

// 1. PHP Info
echo "<div class='box'><h2>1. PHP Version</h2>";
echo "PHP Version: <span class='ok'>" . phpversion() . "</span><br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</div>";

// 2. Extensions
echo "<div class='box'><h2>2. PHP Extensions</h2>";
$extensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'curl', 'xml', 'zip', 'gd'];
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? "<span class='ok'>✓</span>" : "<span class='error'>✗</span>";
    echo "$status $ext<br>";
}
echo "</div>";

// 3. Directories
echo "<div class='box'><h2>3. Directory Structure</h2>";
$baseDir = dirname(__DIR__);
echo "Base Directory: <code>$baseDir</code><br><br>";

$checkDirs = [
    '.env file' => $baseDir . '/.env',
    'vendor/' => $baseDir . '/vendor',
    'storage/' => $baseDir . '/storage',
    'bootstrap/cache/' => $baseDir . '/bootstrap/cache',
    'public/index.php' => $baseDir . '/public/index.php'
];

foreach ($checkDirs as $name => $path) {
    $exists = (strpos($name, 'file') !== false) ? file_exists($path) : is_dir($path);
    $status = $exists ? "<span class='ok'>✓ EXISTS</span>" : "<span class='error'>✗ MISSING</span>";
    echo "$status $name<br>";
    
    if ($exists && is_dir($path)) {
        $writable = is_writable($path);
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        echo "&nbsp;&nbsp;&nbsp;&nbsp;Permissions: <code>$perms</code> - " . ($writable ? "<span class='ok'>Writable</span>" : "<span class='error'>Not Writable</span>") . "<br>";
    }
}
echo "</div>";

// 4. .env File Content
echo "<div class='box'><h2>4. Environment File (.env)</h2>";
$envFile = $baseDir . '/.env';
if (file_exists($envFile)) {
    echo "<pre>";
    $lines = file($envFile);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || $line[0] === '#') continue;
        
        // Hide sensitive values
        if (strpos($line, 'PASSWORD') !== false || strpos($line, 'KEY=') !== false) {
            $parts = explode('=', $line, 2);
            echo htmlspecialchars($parts[0]) . "=***HIDDEN***\n";
        } else {
            echo htmlspecialchars($line) . "\n";
        }
    }
    echo "</pre>";
} else {
    echo "<span class='error'>✗ .env file NOT FOUND!</span>";
}
echo "</div>";

// 5. Database Test
echo "<div class='box'><h2>5. Database Connection</h2>";

function readEnv($key, $file) {
    if (!file_exists($file)) return '';
    $lines = file($file);
    foreach ($lines as $line) {
        if (strpos(trim($line), $key . '=') === 0) {
            $value = trim(substr($line, strlen($key) + 1));
            return trim($value, '"\'');
        }
    }
    return '';
}

if (file_exists($envFile)) {
    $host = readEnv('DB_HOST', $envFile);
    $port = readEnv('DB_PORT', $envFile) ?: '3306';
    $database = readEnv('DB_DATABASE', $envFile);
    $username = readEnv('DB_USERNAME', $envFile);
    $password = readEnv('DB_PASSWORD', $envFile);
    
    echo "DB_HOST: <code>$host</code><br>";
    echo "DB_PORT: <code>$port</code><br>";
    echo "DB_DATABASE: <code>$database</code><br>";
    echo "DB_USERNAME: <code>$username</code><br>";
    echo "DB_PASSWORD: " . (!empty($password) ? "<span class='ok'>***SET***</span>" : "<span class='error'>EMPTY</span>") . "<br><br>";
    
    if (!empty($host) && !empty($database) && !empty($username)) {
        try {
            $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "<span class='ok'>✓ DATABASE CONNECTED!</span><br>";
            
            $stmt = $pdo->query("SELECT DATABASE(), VERSION()");
            $row = $stmt->fetch();
            echo "Database Name: <code>{$row[0]}</code><br>";
            echo "MySQL Version: <code>{$row[1]}</code><br>";
            
        } catch (PDOException $e) {
            echo "<span class='error'>✗ CONNECTION FAILED!</span><br>";
            echo "<strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "<br><br>";
            
            echo "<strong>Fix:</strong><br>";
            if (strpos($e->getMessage(), 'Access denied') !== false) {
                echo "→ Check username/password in .env<br>";
                echo "→ Verify user is assigned to database in cPanel<br>";
            }
            if (strpos($e->getMessage(), 'Unknown database') !== false) {
                echo "→ Create database '$database' in cPanel<br>";
            }
            if ($host === '127.0.0.1') {
                echo "<span class='warning'>→ Try changing DB_HOST to 'localhost'</span><br>";
            }
        }
    } else {
        echo "<span class='error'>✗ Incomplete database configuration</span>";
    }
} else {
    echo "<span class='error'>✗ Cannot read .env file</span>";
}
echo "</div>";

// 6. Composer Check
echo "<div class='box'><h2>6. Composer Dependencies</h2>";
$vendorDir = $baseDir . '/vendor';
$autoloadFile = $vendorDir . '/autoload.php';

if (is_dir($vendorDir)) {
    echo "<span class='ok'>✓ vendor/ directory exists</span><br>";
    
    if (file_exists($autoloadFile)) {
        echo "<span class='ok'>✓ autoload.php exists</span><br>";
        
        // Count packages
        $installedFile = $vendorDir . '/composer/installed.json';
        if (file_exists($installedFile)) {
            $installed = json_decode(file_get_contents($installedFile), true);
            $count = isset($installed['packages']) ? count($installed['packages']) : 0;
            echo "Installed packages: <code>$count</code><br>";
        }
    } else {
        echo "<span class='error'>✗ autoload.php NOT FOUND</span><br>";
        echo "<strong>Fix:</strong> Run <code>composer install</code><br>";
    }
} else {
    echo "<span class='error'>✗ vendor/ directory NOT FOUND!</span><br>";
    echo "<strong>Fix:</strong> Run <code>composer install --no-dev --optimize-autoloader</code><br>";
}
echo "</div>";

// 7. Storage Check
echo "<div class='box'><h2>7. Storage Directories</h2>";
$storageDirs = [
    'storage/framework/cache',
    'storage/framework/sessions', 
    'storage/framework/views',
    'storage/logs',
    'storage/app/public'
];

$allGood = true;
foreach ($storageDirs as $dir) {
    $fullPath = $baseDir . '/' . $dir;
    $exists = is_dir($fullPath);
    $writable = $exists && is_writable($fullPath);
    
    if (!$exists) {
        echo "<span class='error'>✗ $dir - NOT EXISTS</span><br>";
        $allGood = false;
    } elseif (!$writable) {
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        echo "<span class='warning'>⚠ $dir - NOT WRITABLE (Perms: $perms)</span><br>";
        $allGood = false;
    } else {
        echo "<span class='ok'>✓ $dir - OK</span><br>";
    }
}

if (!$allGood) {
    echo "<br><strong>Fix:</strong><br>";
    echo "<code>chmod -R 755 storage bootstrap/cache</code><br>";
}
echo "</div>";

// 8. Laravel Log
echo "<div class='box'><h2>8. Recent Errors</h2>";
$logFile = $baseDir . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    $lines = explode("\n", $content);
    $last = array_slice($lines, -30);
    
    echo "<pre style='max-height:200px;overflow:auto;'>";
    echo htmlspecialchars(implode("\n", $last));
    echo "</pre>";
} else {
    echo "No log file found (this might be okay)";
}
echo "</div>";

// Summary
echo "<div class='box' style='border-left-color:#2196F3;'><h2>📋 Action Items</h2>";
echo "<ol>";
echo "<li>Fix any <span class='error'>RED (✗)</span> items above</li>";
echo "<li>Fix any <span class='warning'>ORANGE (⚠)</span> warnings</li>";
echo "<li>If vendor/ missing: SSH → <code>composer install --no-dev</code></li>";
echo "<li>If DB connection fails: Update .env with correct credentials</li>";
echo "<li>If permissions wrong: <code>chmod -R 755 storage bootstrap/cache</code></li>";
echo "<li>After fixes: <code>php artisan config:clear</code></li>";
echo "<li>Test: <a href='/'>http://medniks.com/</a></li>";
echo "<li>Delete this check.php file after fixing</li>";
echo "</ol></div>";

echo "</body></html>";
