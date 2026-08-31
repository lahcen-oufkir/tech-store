<?php

// ============================================================
//  Simple REST API for learning purposes
//  Base URL:  http://localhost/Tech-Store/public/api/
//  Endpoints:
//    GET  /api/products            list active products
//    GET  /api/products/{id}       single product
//    GET  /api/categories          list categories with product counts
//    GET  /api/services            list active services
//    GET  /api/orders              list orders        (admin only)
//    GET  /api/orders/{id}         single order       (admin only)
//    GET  /api/repairs             list repairs       (admin only)
//    GET  /api/repairs/{id}        single repair      (admin only)
// ============================================================

require_once dirname(__DIR__) . '/../config/config.php';
require_once APP_PATH . '/core/helpers.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) === 0) {
        $file = APP_PATH . '/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});

// Allow simple cross-origin requests while learning with Postman / the browser
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

function jsonResponse($data, $status = 200)
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed. Use GET.'], 405);
}

// Parse the URL: /products/12 -> ['products', '12']
$url   = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$parts = $url !== '' ? explode('/', $url) : [];

if (empty($parts[0])) {
    jsonResponse([
        'name'    => APP_NAME . ' API',
        'version' => APP_VERSION,
        'endpoints' => [
            'products'      => 'GET /api/products',
            'products/{id}' => 'GET /api/products/{id}',
            'categories'    => 'GET /api/categories',
            'services'      => 'GET /api/services',
            'orders'        => 'GET /api/orders (admin)',
            'repairs'       => 'GET /api/repairs (admin)',
        ],
    ]);
}

$resource = strtolower($parts[0]);
$id       = isset($parts[1]) ? (int) $parts[1] : null;

switch ($resource) {
    case 'products':
        if ($id) {
            $product = (new App\Models\Product())->withCategoryName($id);
            if (!$product || !$product['is_active']) {
                jsonResponse(['error' => 'Product not found.'], 404);
            }
            jsonResponse($product);
        }
        jsonResponse(['products' => (new App\Models\Product())->active()]);
        break;

    case 'categories':
        jsonResponse(['categories' => (new App\Models\Category())->withProductCount()]);
        break;

    case 'services':
        jsonResponse(['services' => (new App\Models\Service())->active()]);
        break;

    case 'orders':
        if (!isAdmin()) {
            jsonResponse(['error' => 'Unauthorized. Log in as an administrator first.'], 401);
        }
        if ($id) {
            $order = (new App\Models\Order())->withItems($id);
            if (!$order) {
                jsonResponse(['error' => 'Order not found.'], 404);
            }
            jsonResponse($order);
        }
        jsonResponse(['orders' => (new App\Models\Order())->recent(50)]);
        break;

    case 'repairs':
        if (!isAdmin()) {
            jsonResponse(['error' => 'Unauthorized. Log in as an administrator first.'], 401);
        }
        if ($id) {
            $request = (new App\Models\RepairRequest())->find($id);
            if (!$request) {
                jsonResponse(['error' => 'Repair request not found.'], 404);
            }
            jsonResponse($request);
        }
        jsonResponse(['repairs' => (new App\Models\RepairRequest())->all()]);
        break;

    default:
        jsonResponse(['error' => 'Unknown endpoint.'], 404);
}
