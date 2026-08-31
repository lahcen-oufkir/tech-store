<?php

namespace App\Core;

/**
 * Base controller used by every page controller.
 * Provides view rendering, JSON responses and redirects.
 */
abstract class Controller
{
    /** Render a public-facing page with the main layout. */
    protected function view($path, $data = [])
    {
        $this->render($path, $data, 'layouts/header', 'layouts/footer');
    }

    /** Render an admin page with the admin layout. */
    protected function adminView($path, $data = [])
    {
        requireAdmin();
        $this->render($path, $data, 'layouts/admin_header', 'layouts/admin_footer');
    }

    /** Render a standalone page with no layout (e.g. auth pages can use it). */
    protected function viewPlain($path, $data = [])
    {
        $this->render($path, $data, null, null);
    }

    private function render($path, $data, $header, $footer)
    {
        extract($data);

        $viewFile = VIEW_PATH . '/' . $path . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(404);
            die('View not found: ' . htmlspecialchars($path, ENT_QUOTES, 'UTF-8'));
        }

        if ($header) {
            require VIEW_PATH . '/' . $header . '.php';
        }

        require $viewFile;

        if ($footer) {
            require VIEW_PATH . '/' . $footer . '.php';
        }
    }

    /** Send a JSON response with a proper status code. */
    protected function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    /** Redirect to a relative path. */
    protected function redirectTo($path)
    {
        redirect($path);
    }
}
