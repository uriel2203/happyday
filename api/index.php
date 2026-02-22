<?php

/**
 * Vercel Entry Point - Diagnostic Version
 */

// 1. Hard Error Reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // 2. Map Key
    $appKey = getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? null);
    if ($appKey) {
        putenv("APP_KEY=$appKey");
        $_ENV['APP_KEY'] = $appKey;
    }

    // 3. Environment Fixes
    if (getenv('VERCEL')) {
        putenv('VIEW_COMPILED_PATH=/tmp/views');
        if (!is_dir('/tmp/views')) {
            @mkdir('/tmp/views', 0755, true);
        }
    }

    // 4. Load Autoloader & Bootstrap
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        throw new \Exception("Vercel Error: Vendor directory not found. Please check deployment logs.");
    }

    // 5. Hand over to public/index.php (The standard Laravel entry)
    require __DIR__ . '/../public/index.php';

} catch (\Throwable $e) {
    http_response_code(500);
    echo "<div style='font-family: sans-serif; padding: 20px; background: #fff; border: 5px solid red;'>";
    echo "<h1>Vercel Deployment Diagnostic</h1>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}
