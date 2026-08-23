<?php
/**
 * Base Model
 *
 * Gives every model automatic access to the database
 * through $this->db — a PDO connection object.
 *
 * Usage in any model:
 *   $stmt = $this->db->prepare('SELECT * FROM posts');
 *   $stmt->execute();
 *   return $stmt->fetchAll();
 */
class Model {

    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getPdo();
    }
}