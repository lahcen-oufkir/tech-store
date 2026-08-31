<?php

// ============================================================
//  Global helper functions
// ============================================================

use App\Core\Session;

/**
 * Escape a value for safe HTML output (prevents XSS).
 */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Build an application URL from a controller path.
 * Example: url('products') => http://localhost/Tech-Store/public/products
 */
function url($path = '')
{
    return BASE_URL . ltrim($path, '/');
}

/**
 * Redirect to a relative path and stop execution.
 */
function redirect($path)
{
    header('Location: ' . url($path));
    exit;
}

/**
 * Return the previous form value for a field (repopulate on error).
 */
function old($key, $default = '')
{
    return $_POST[$key] ?? $default;
}

/**
 * Format a number as a price.
 */
function money($amount)
{
    return number_format((float) $amount, 2, '.', '') . ' ' . CURRENCY;
}

// ------------------------------------------------------------
// Authentication helpers
// ------------------------------------------------------------

function currentUser()
{
    return Session::get('user');
}

function isLoggedIn()
{
    return Session::get('user') !== null;
}

function isAdmin()
{
    $user = currentUser();
    return isLoggedIn() && ($user['role'] ?? '') === 'admin';
}

/**
 * Ensure the visitor is authenticated, otherwise redirect to login.
 */
function requireLogin()
{
    if (!isLoggedIn()) {
        flash('warning', 'Please log in to continue.');
        redirect('auth/showLogin');
    }
}

/**
 * Ensure the visitor is an administrator.
 */
function requireAdmin()
{
    requireLogin();
    if (!isAdmin()) {
        http_response_code(403);
        flash('danger', 'You do not have permission to access that page.');
        redirect('');
    }
}

// ------------------------------------------------------------
// Flash messages (one-time session notifications)
// ------------------------------------------------------------

function flash($key, $message = null)
{
    if ($message !== null) {
        Session::set('flash_' . $key, $message);
        return;
    }

    $value = Session::get('flash_' . $key);
    Session::remove('flash_' . $key);
    return $value;
}

function getFlashAlerts()
{
    $alerts = [];
    foreach (['success', 'danger', 'warning', 'info'] as $type) {
        $message = flash($type);
        if ($message) {
            $alerts[] = ['type' => $type, 'message' => $message];
        }
    }
    return $alerts;
}

// ------------------------------------------------------------
// CSRF protection
// ------------------------------------------------------------

function csrf_token()
{
    if (!Session::has('csrf_token')) {
        Session::set('csrf_token', bin2hex(random_bytes(32)));
    }
    return Session::get('csrf_token');
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verifyCsrf()
{
    $sent = $_POST['csrf_token'] ?? '';
    $valid = hash_equals(csrf_token(), (string) $sent);
    if (!$valid) {
        http_response_code(419);
        die('Invalid or missing CSRF token. Please go back and try again.');
    }
}

// ------------------------------------------------------------
// Slug and image upload helpers (used by the admin panel)
// ------------------------------------------------------------

function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    return $text !== '' ? $text : 'item-' . time();
}

/**
 * Handle a product image upload.
 * Returns the new filename, the old filename (when no new file), or false on error.
 */
function uploadImage($file, $oldFile = null)
{
    if (!is_array($file) || empty($file['name'])) {
        return $oldFile;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        flash('danger', 'The image could not be uploaded. Please try again.');
        return false;
    }

    if (class_exists('finfo')) {
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    } else {
        $mime = $file['type'];
    }

    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

    if (!in_array($mime, $allowed, true)) {
        flash('danger', 'Please upload a valid image (JPG, PNG, WEBP or GIF).');
        return false;
    }

    $extension = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'][$mime];
    $name      = 'prod_' . uniqid() . '.' . $extension;

    if (!move_uploaded_file($file['tmp_name'], UPLOAD_PATH . '/' . $name)) {
        flash('danger', 'Failed to save the uploaded image.');
        return false;
    }

    if ($oldFile && $oldFile !== $name && file_exists(UPLOAD_PATH . '/' . $oldFile)) {
        unlink(UPLOAD_PATH . '/' . $oldFile);
    }

    return $name;
}

function deleteImage($filename)
{
    if ($filename && file_exists(UPLOAD_PATH . '/' . $filename)) {
        unlink(UPLOAD_PATH . '/' . $filename);
    }
}

// ------------------------------------------------------------
// Status badge helper
// ------------------------------------------------------------
function statusBadge($status)
{
    $map = [
        'pending'     => 'warning',
        'confirmed'   => 'primary',
        'in_progress' => 'info',
        'shipped'     => 'info',
        'repaired'    => 'success',
        'delivered'   => 'success',
        'collected'   => 'secondary',
        'cancelled'   => 'danger',
    ];

    $class = $map[$status] ?? 'secondary';
    $label = ucwords(str_replace('_', ' ', $status));

    return '<span class="badge status-badge text-bg-' . $class . '">' . e($label) . '</span>';
}

// ------------------------------------------------------------
// Shopping cart helpers
// ------------------------------------------------------------

function cartItems()
{
    return Session::get(CART_SESSION, []);
}

function cartCount()
{
    return array_sum(array_column(cartItems(), 'quantity'));
}

function cartTotal()
{
    $total = 0;
    foreach (cartItems() as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
