<?php

/**
 * Vercel Entry Point
 */

// 1. Map custom WEB_KEY to required APP_KEY
$webKey = getenv('WEB_KEY') ?: ($_ENV['WEB_KEY'] ?? ($_SERVER['WEB_KEY'] ?? null));

if ($webKey) {
    putenv("APP_KEY=$webKey");
    $_ENV['APP_KEY'] = $webKey;
    $_SERVER['APP_KEY'] = $webKey;
}

// 2. Vercel Storage Fix
if (getenv('VERCEL')) {
    putenv('VIEW_COMPILED_PATH=/tmp/views');
    if (!is_dir('/tmp/views')) {
        @mkdir('/tmp/views', 0755, true);
    }
}

// 3. Forward to Laravel
require __DIR__ . '/../public/index.php';
