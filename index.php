<?php

/**
 * Vercel Entry Point
 * This file forwards requests to the Laravel public directory.
 */

// 1. Map custom Vercel WEB_KEY to Laravel's required APP_KEY
if (empty(getenv('APP_KEY')) && !empty(getenv('WEB_KEY'))) {
    putenv('APP_KEY=' . getenv('WEB_KEY'));
}

// 2. Fallback to .env for local/other environments if still empty
if (empty(getenv('APP_KEY')) && file_exists(__DIR__ . '/.env')) {
    $env = file_get_contents(__DIR__ . '/.env');
    if (preg_match('/APP_KEY=(.*)/', $env, $matches)) {
        putenv('APP_KEY=' . trim($matches[1]));
    }
}

// Vercel only: Ensure storage and view cache use /tmp/
if (getenv('VERCEL')) {
    putenv('VIEW_COMPILED_PATH=/tmp/views');
    if (!is_dir('/tmp/views')) {
        mkdir('/tmp/views', 0755, true);
    }
}

require __DIR__ . '/public/index.php';
