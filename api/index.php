<?php

/**
 * Vercel Entry Point - Enhanced for Laravel 12
 */

// 1. Hard Error Reporting (Disable in production)
if (getenv('APP_DEBUG') === 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

try {
    // 2. Map Key
    $appKey = getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? null);
    if ($appKey) {
        putenv("APP_KEY=$appKey");
        $_ENV['APP_KEY'] = $appKey;
    }

    // 3. Environment Fixes for Vercel
    if (getenv('VERCEL')) {
        // Ensure /tmp/views exists
        $tmpViews = '/tmp/views';
        if (!is_dir($tmpViews)) {
            @mkdir($tmpViews, 0755, true);
        }
        putenv("VIEW_COMPILED_PATH=$tmpViews");

        // Ensure storage directories exist in /tmp
        $storageDirs = [
            '/tmp/framework/sessions',
            '/tmp/framework/views',
            '/tmp/framework/cache',
        ];

        foreach ($storageDirs as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
        }
    }

    // 4. Load Autoloader & Bootstrap
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        // In Vercel, composer install should have run during build
        // If it's missing, we might be in a local environment or a failed build
        if (file_exists(__DIR__ . '/vendor/autoload.php')) {
             require __DIR__ . '/vendor/autoload.php';
        } else {
             throw new \Exception("Vercel Error: Vendor directory not found. Please check deployment logs.");
        }
    } else {
        require __DIR__ . '/../vendor/autoload.php';
    }

    // 5. Hand over to public/index.php (The standard Laravel entry)
    require __DIR__ . '/../public/index.php';

} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Vercel Deployment Error</h1>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    if (getenv('APP_DEBUG') === 'true') {
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
}

