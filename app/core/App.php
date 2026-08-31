<?php

namespace App\Core;

use App\Controllers\HomeController;
use App\Controllers\ErrorController;

/**
 * Simple front controller / router.
 *
 * URL format:  /controller/action/params
 * Example:     /products/show/12  => ProductsController::show(12)
 * Admin:       /admin/<controller>/<action>
 * Example:     /admin/products/edit/4 => Admin\ProductsController::edit(4)
 */
class App
{
    protected $controller;
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (!empty($url) && strtolower($url[0]) === 'admin') {
            array_shift($url);
            $this->resolveAdmin($url);
        } else {
            $this->resolvePublic($url);
        }

        $this->params = array_values($url);

        if (!method_exists($this->controller, $this->method)) {
            $this->controller = new ErrorController();
            $this->method     = 'notFound';
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function resolvePublic(&$url)
    {
        $controllerName = !empty($url[0]) ? ucfirst(strtolower($url[0])) . 'Controller' : 'HomeController';
        $class          = 'App\\Controllers\\' . $controllerName;
        array_shift($url);

        $this->controller = class_exists($class) ? new $class() : new ErrorController();
        $this->method     = !empty($url[0]) ? strtolower(array_shift($url)) : 'index';
    }

    private function resolveAdmin(&$url)
    {
        $controllerName = !empty($url[0]) ? ucfirst(strtolower($url[0])) . 'Controller' : 'DashboardController';
        $class          = 'App\\Controllers\\Admin\\' . $controllerName;
        array_shift($url);

        $this->controller = class_exists($class) ? new $class() : new ErrorController();
        $this->method     = !empty($url[0]) ? strtolower(array_shift($url)) : 'index';
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
