<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Singleton PDO wrapper for MySQL.
 * Use Database::instance()->run(...) or the Model class.
 */
class Database
{
    private static $instance = null;

    private $pdo;

    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_TIMEOUT            => 5,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            die('Database connection failed: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
        }
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** Prepare + execute a statement. Always uses prepared statements. */
    public function run($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /** Fetch all rows. */
    public function fetchAll($sql, $params = [])
    {
        return $this->run($sql, $params)->fetchAll();
    }

    /** Fetch a single row or false. */
    public function fetch($sql, $params = [])
    {
        return $this->run($sql, $params)->fetch();
    }

    /** Fetch a single column value. */
    public function value($sql, $params = [])
    {
        return $this->run($sql, $params)->fetchColumn();
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
