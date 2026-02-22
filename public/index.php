<?php

use Illuminate\Http\Request;

// --- Vercel Compatibility Shim ---
if (getenv('APP_KEY')) {
    putenv('APP_KEY=' . getenv('APP_KEY'));
}

if (getenv('VERCEL')) {
    putenv('VIEW_COMPILED_PATH=/tmp/views');
    if (!is_dir('/tmp/views')) {
        @mkdir('/tmp/views', 0755, true);
    }
}
// ---------------------------------

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
