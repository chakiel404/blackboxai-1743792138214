<?php
require_once __DIR__ . '/../config/config.php';

class DB {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            // Create SQLite database if it doesn't exist
            if (!file_exists(DB_FILE)) {
                $this->createDatabase();
            }

            // Connect to SQLite database
            $this->pdo = new PDO("sqlite:" . DB_FILE);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Enable foreign keys
            $this->pdo->exec('PRAGMA foreign_keys = ON;');
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    private function createDatabase() {
        try {
            // Create database directory if it doesn't exist
            $dbDir = dirname(DB_FILE);
            if (!file_exists($dbDir)) {
                mkdir($dbDir, 0777, true);
            }

            // Create empty database file
            touch(DB_FILE);
            chmod(DB_FILE, 0777);

            // Connect to the new database
            $pdo = new PDO("sqlite:" . DB_FILE);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Read and execute schema.sql
            $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
            $pdo->exec($schema);

        } catch (PDOException $e) {
            throw new Exception("Database creation failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function prepare($sql) {
        try {
            return $this->pdo->prepare($sql);
        } catch (PDOException $e) {
            throw new Exception("Database prepare failed: " . $e->getMessage());
        }
    }

    public function insert($table, $data) {
        try {
            $fields = array_keys($data);
            $values = array_values($data);
            $placeholders = array_fill(0, count($fields), '?');

            $sql = sprintf(
                "INSERT INTO %s (%s) VALUES (%s)",
                $table,
                implode(', ', $fields),
                implode(', ', $placeholders)
            );

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($values);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Database insert failed: " . $e->getMessage());
        }
    }

    public function update($table, $data, $where) {
        try {
            $fields = array_keys($data);
            $values = array_values($data);
            $whereFields = array_keys($where);
            $whereValues = array_values($where);

            $setClause = implode(' = ?, ', $fields) . ' = ?';
            $whereClause = implode(' = ? AND ', $whereFields) . ' = ?';

            $sql = sprintf(
                "UPDATE %s SET %s WHERE %s",
                $table,
                $setClause,
                $whereClause
            );

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_merge($values, $whereValues));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Database update failed: " . $e->getMessage());
        }
    }

    public function delete($table, $where) {
        try {
            $whereFields = array_keys($where);
            $whereValues = array_values($where);
            $whereClause = implode(' = ? AND ', $whereFields) . ' = ?';

            $sql = sprintf(
                "DELETE FROM %s WHERE %s",
                $table,
                $whereClause
            );

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($whereValues);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Database delete failed: " . $e->getMessage());
        }
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }
}