<?php
// Quick Diagnostic Tool for medniks.com
// Upload this file to: /home/healthboat/medniks.com/public/diagnose.php
// Then visit: http://medniks.com/diagnose.php

echo "<h1>Server Diagnostic Report</h1>";
echo "<style>body{font-family:sans-serif;margin:20px;} .ok{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border-radius:5px;}</style>";

// 1. PHP Version
echo "<h2>1. PHP Version</h2>";
$phpVersion = phpversion();
echo "<p class='" . (version_compare($phpVersion, '8.1', '>=') ? 'ok' : 'error') . "'>PHP Version: $phpVersion</p>";

// 2. Required Extensions
echo "<h2>2. Required PHP Extensions</h2>";
$required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo'];
foreach ($required as $ext) {
    $loaded = extension_loaded($ext);
    echo "<p class='" . ($loaded ? 'ok' : 'error') . "'>$ext: " . ($loaded ? '✓ Loaded' : '✗ Missing') . "</p>";
}

// 3. File Paths
echo "<h2>3. File System</h2>";
$basePath = dirname(__DIR__);
echo "<p>Base Path: <code>$basePath</code></p>";
echo "<p>.env exists: " . (file_exists($basePath . '/.env') ? '<span class="ok">✓ Yes</span>' : '<span class="error">✗ No</span>') . "</p>";
echo "<p>vendor exists: " . (is_dir($basePath . '/vendor') ? '<span class="ok">✓ Yes</span>' : '<span class="error">✗ No</span>') . "</p>";

// 4. Directory Permissions
echo "<h2>4. Directory Permissions</h2>";
$dirs = [
    'storage' => $basePath . '/storage',
    'storage/logs' => $basePath . '/storage/logs',
    'storage/framework' => $basePath . '/storage/framework',
    'bootstrap/cache' => $basePath . '/bootstrap/cache'
];

foreach ($dirs as $name => $dir) {
    $exists = is_dir($dir);
    $writable = $exists && is_writable($dir);
    $perms = $exists ? substr(sprintf('%o', fileperms($dir)), -4) : 'N/A';
    echo "<p>$name: ";
    if (!$exists) {
        echo "<span class='error'>✗ Does not exist</span>";
    } elseif (!$writable) {
        echo "<span class='warning'>⚠ Not writable (Perms: $perms)</span>";
    } else {
        echo "<span class='ok'>✓ Writable (Perms: $perms)</span>";
    }
    echo "</p>";
}

// 5. Read .env file
echo "<h2>5. Environment Configuration</h2>";
$envPath = $basePath . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $envLines = explode("\n", $envContent);
    
    echo "<pre>";
    foreach ($envLines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        
        // Mask sensitive data
        if (strpos($line, 'PASSWORD') !== false || strpos($line, 'KEY') !== false) {
            list($key, $value) = array_pad(explode('=', $line, 2), 2, '');
            echo htmlspecialchars($key) . "=***HIDDEN***\n";
        } else {
            echo htmlspecialchars($line) . "\n";
        }
    }
    echo "</pre>";
} else {
    echo "<p class='error'>✗ .env file not found!</p>";
}

// 6. Database Connection Test
echo "<h2>6. Database Connection Test</h2>";

// Parse .env manually
function getEnvValue($key, $envPath) {
    if (!file_exists($envPath)) return null;
    $content = file_get_contents($envPath);
    if (preg_match("/^$key=(.*)$/m", $content, $matches)) {
        return trim(trim($matches[1]), '"\'');
    }
    return null;
}

$dbHost = getEnvValue('DB_HOST', $envPath);
$dbPort = getEnvValue('DB_PORT', $envPath);
$dbDatabase = getEnvValue('DB_DATABASE', $envPath);
$dbUsername = getEnvValue('DB_USERNAME', $envPath);
$dbPassword = getEnvValue('DB_PASSWORD', $envPath);

echo "<p>DB_HOST: <code>" . htmlspecialchars($dbHost) . "</code></p>";
echo "<p>DB_PORT: <code>" . htmlspecialchars($dbPort) . "</code></p>";
echo "<p>DB_DATABASE: <code>" . htmlspecialchars($dbDatabase) . "</code></p>";
echo "<p>DB_USERNAME: <code>" . htmlspecialchars($dbUsername) . "</code></p>";
echo "<p>DB_PASSWORD: <code>" . (empty($dbPassword) ? '<span class="error">EMPTY!</span>' : '***SET***') . "</code></p>";

echo "<h3>Connection Test:</h3>";
try {
    $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbDatabase";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "<p class='ok'>✓ Database connection successful!</p>";
    
    // Test query
    $stmt = $pdo->query("SELECT DATABASE() as db, VERSION() as version");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Connected to database: <code>{$result['db']}</code></p>";
    echo "<p>MySQL version: <code>{$result['version']}</code></p>";
    
    // Check if migrations table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
    if ($stmt->rowCount() > 0) {
        echo "<p class='ok'>✓ Migrations table exists</p>";
    } else {
        echo "<p class='warning'>⚠ Migrations table not found - run migrations</p>";
    }
    
} catch (PDOException $e) {
    echo "<p class='error'>✗ Database connection failed!</p>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    
    // Common issues
    echo "<h3>Common Fixes:</h3>";
    echo "<ul>";
    echo "<li>If error contains 'Access denied': Check username/password</li>";
    echo "<li>If error contains 'Unknown database': Create the database in cPanel</li>";
    echo "<li>If using '127.0.0.1': Change to 'localhost' in .env</li>";
    echo "<li>If password has special chars: Wrap in quotes in .env</li>";
    echo "</ul>";
}

// 7. Laravel Bootstrap Test
echo "<h2>7. Laravel Bootstrap Test</h2>";
try {
    require $basePath . '/vendor/autoload.php';
    echo "<p class='ok'>✓ Composer autoload works</p>";
    
    $app = require_once $basePath . '/bootstrap/app.php';
    echo "<p class='ok'>✓ Laravel application bootstrapped</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Laravel bootstrap failed!</p>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// 8. Recent Laravel Log
echo "<h2>8. Recent Laravel Errors (Last 20 lines)</h2>";
$logPath = $basePath . '/storage/logs/laravel.log';
if (file_exists($logPath)) {
    $logContent = file($logPath);
    $lastLines = array_slice($logContent, -20);
    echo "<pre style='max-height:300px;overflow:auto;'>";
    echo htmlspecialchars(implode('', $lastLines));
    echo "</pre>";
} else {
    echo "<p class='warning'>No log file found</p>";
}

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Fix any RED (✗) items above</li>";
echo "<li>Fix any ORANGE (⚠) warnings</li>";
echo "<li>Clear config cache: <code>php artisan config:clear</code></li>";
echo "<li>Visit <a href='/'>http://medniks.com/</a> again</li>";
echo "<li>Delete this file after diagnosis</li>";
echo "</ol>";
?>
