<?php
/**
 * Database — PDO Connection Singleton
 *
 * Usage anywhere in the app:
 *   $db = Database::getInstance()->getPdo();
 *
 * PDO is PHP's secure, modern way to talk to databases.
 * It uses prepared statements which protect against SQL injection.
 */
class Database {

    private static $instance = null;
    private $pdo;

    /**
     * Private constructor — prevents anyone from doing "new Database()"
     * directly. Forces use of getInstance() instead.
     */
    private function __construct() {
        $dsn = 'mysql:host=' . DB_HOST
             . ';dbname='    . DB_NAME
             . ';charset=utf8mb4';

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // Throw exceptions on error
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,           // Return rows as objects
                PDO::ATTR_EMULATE_PREPARES   => false,                    // Use real prepared statements
            ]);
        } catch (PDOException $e) {
            // In production, never show the real error — log it instead
            if (ENVIRONMENT === 'development') {
                die('Database connection failed: ' . $e->getMessage());
            } else {
                die('A database error occurred. Please try again later.');
            }
        }
    }

    /**
     * Get the single shared instance of this class.
     * Creates it on first call, returns the same one every time after.
     */
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Return the PDO connection object.
     * Models call this to run queries.
     */
    public function getPdo(): PDO {
        return $this->pdo;
    }
}