<?php

// ============================================================
//  Front controller - all requests go through this file
// ============================================================

require_once __DIR__ . '/../config/config.php';
require_once APP_PATH . '/core/helpers.php';

// Simple PSR-4 style autoloader for the App\ namespace
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) === 0) {
        $file = APP_PATH . '/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});

use App\Core\App;

new App();
