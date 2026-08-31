<?php

// ============================================================
//  TechnoMeits Store Management System (TSMS) - Configuration
// ============================================================

// Application metadata
define('APP_NAME', 'TechnoMeits Store');
define('APP_TAGLINE', 'Computers, Smartphones & Repair Services');
define('APP_VERSION', '1.0');
define('APP_EMAIL', 'contact@technomeits.ma');

// ------------------------------------------------------------------
// Base URL: point this to the "public" folder of the application.
// Examples:
//   http://localhost/Tech-Store/public/
//   http://localhost:8080/tsms/public/
// ------------------------------------------------------------------
define('BASE_URL', 'http://localhost/Tech-Store/public/');

// Paths (computed automatically, do not change)
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');
define('UPLOAD_URL', BASE_URL . 'uploads/');

// ------------------------------------------------------------------
// Database connection (XAMPP / WAMP defaults)
// ------------------------------------------------------------------
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'technomeits');
define('DB_USER', 'root');
define('DB_PASS', '');

// Session key used to store the shopping cart
define('CART_SESSION', 'tsms_cart');

// Currency symbol used across the shop
define('CURRENCY', 'MAD');

date_default_timezone_set('Africa/Casablanca');

// Start the session once (safe on every request)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
