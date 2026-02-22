<?php

/**
 * Vercel Modern Entry Point
 * This file maps WEB_KEY to APP_KEY and ensures Laravel can run on Vercel.
 */

// 1. Force mapping of custom WEB_KEY to required APP_KEY
$webKey = getenv('WEB_KEY') ?: ($_ENV['WEB_KEY'] ?? ($_SERVER['WEB_KEY'] ?? ($_SERVER['REDIRECT_WEB_KEY'] ?? null)));

if ($webKey) {
    putenv("APP_KEY=$webKey");
    $_ENV['APP_KEY'] = $webKey;
    $_SERVER['APP_KEY'] = $webKey;
    error_log("HappyDay Debug: WEB_KEY found and mapped to APP_KEY.");
} else {
    error_log("HappyDay CRITICAL: WEB_KEY/APP_KEY not found in environment!");
}

// 2. Vercel Storage Fix (Redirect writeable paths to /tmp)
if (getenv('VERCEL')) {
    putenv('VIEW_COMPILED_PATH=/tmp/views');
    if (!is_dir('/tmp/views')) {
        mkdir('/tmp/views', 0755, true);
    }
}

// 3. Dependency Check
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    error_log("HappyDay CRITICAL: vendor/autoload.php not found! The build may have failed to run composer install.");
}

// 4. Forward to Laravel
require __DIR__ . '/../public/index.php';
