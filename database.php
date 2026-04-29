<?php
/** COMMENTS R IMPORTANT*/
/**
 * Database Class for Rent House Subdivision
 * 
 * Handles all database operations including:
 * - Create, Read, Update, Delete (CRUD)
 * - Duplicate checking
 * - Search functionality
 * - Pagination support
 */

class Database {
    private $pdo;
    private $table = 'owners';

    /**
     * Constructor - Initialize database connection
     */
    public function __construct(
        private string $host,
        private string $dbname,
        private string $user,
        private string $password
    ) {
        $this->connect();
    }

    /**
     * Connect to database and create if not exists
     */
    private function connect() {
        $dsn = "mysql:host={$this->host}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password, $options);
            
            // Create database if it doesn't exist
            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `{$this->dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->pdo->exec("USE `{$this->dbname}`");
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Create table with specified columns
     * 
     * @param string $table Table name
     * @param array $columns Column definitions
     */
    public function create_table($table, array $columns) {
        $columnDefs = [];
        foreach ($columns as $name => $dataType) {
            $columnDefs[] = "`{$name}` {$dataType}";
        }
        
        $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (" . implode(', ', $columnDefs) . ")";
        
        try {
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            throw new PDOException("Create table error: " . $e->getMessage());
        }
    }

    /**
     * Insert data into table
     * 
     * @param string $table Table name
     * @param array $data Column => Value pairs
     * @return bool True on success
     */
    public function insert_table($table, array $data) {
        unset($data['id']);
        
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":{$col}", $columns);
        
        $sql = "INSERT INTO `{$table}` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new PDOException("Insert error: " . $e->getMessage());
        }
    }

    /**
     * Get all records from table
     * 
     * @param string $table Table name
     * @return array Array of records
     */
    public function get_all($table) {
        $sql = "SELECT * FROM `{$table}` ORDER BY id DESC";
        
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException("Get all error: " . $e->getMessage());
        }
    }

    /**
     * Get single record by ID
     * 
     * @param string $table Table name
     * @param int $id Record ID
     * @return array|null Record data or null if not found
     */
    public function get_by_id($table, $id) {
        $sql = "SELECT * FROM `{$table}` WHERE id = :id LIMIT 1";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new PDOException("Get by ID error: " . $e->getMessage());
        }
    }

    /**
     * Update record in table
     * 
     * @param string $table Table name
     * @param array $data Updated column => value pairs
     * @param int $id Record ID
     * @return bool True on success
     */
    public function update_table($table, array $data, $id) {
        unset($data['id']);
        
        $setClause = [];
        foreach ($data as $column => $value) {
            $setClause[] = "`{$column}` = :{$column}";
        }
        
        $data['id'] = $id;
        
        $sql = "UPDATE `{$table}` SET " . implode(', ', $setClause) . " WHERE id = :id";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new PDOException("Update error: " . $e->getMessage());
        }
    }

    /**
     * Delete record from table
     * 
     * @param string $table Table name
     * @param int $id Record ID
     * @return bool True on success
     */
    public function delete_table($table, $id) {
        $sql = "DELETE FROM `{$table}` WHERE id = :id";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            throw new PDOException("Delete error: " . $e->getMessage());
        }
    }

    /**
     * Check if record exists (duplicate check)
     * 
     * @param string $table Table name
     * @param string $column Column to check
     * @param string $value Value to search for
     * @return bool True if duplicate exists
     */
    public function checkDuplicate($table, $column, $value) {
        $sql = "SELECT COUNT(*) FROM `{$table}` WHERE `{$column}` = :value LIMIT 1";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':value' => $value]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new PDOException("Duplicate check error: " . $e->getMessage());
        }
    }

    /**
     * Search records in table
     * 
     * @param string $table Table name
     * @param string $column Column to search in
     * @param string $search Search term
     * @return array Array of matching records
     */
    public function search($table, $column, $search) {
        $sql = "SELECT * FROM `{$table}` WHERE `{$column}` LIKE :search ORDER BY id DESC";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':search' => "%{$search}%"]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException("Search error: " . $e->getMessage());
        }
    }

    /**
     * Get paginated records
     * 
     * @param string $table Table name
     * @param int $page Page number
     * @param int $limit Records per page
     * @return array Array with 'data' and 'total' keys
     */
    public function get_paginated($table, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM `{$table}`";
        $countStmt = $this->pdo->query($countSql);
        $total = $countStmt->fetch()['total'];
        
        // Get paginated data
        $sql = "SELECT * FROM `{$table}` ORDER BY id DESC LIMIT :limit OFFSET :offset";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return [
                'data' => $stmt->fetchAll(),
                'total' => $total,
                'pages' => ceil($total / $limit),
                'current_page' => $page
            ];
        } catch (PDOException $e) {
            throw new PDOException("Pagination error: " . $e->getMessage());
        }
    }

    /**
     * Count total records in table
     * 
     * @param string $table Table name
     * @return int Total record count
     */
    public function count($table) {
        $sql = "SELECT COUNT(*) as total FROM `{$table}`";
        
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch()['total'];
        } catch (PDOException $e) {
            throw new PDOException("Count error: " . $e->getMessage());
        }
    }

    /**
     * Get database statistics
     * 
     * @param string $table Table name
     * @return array Statistics data
     */
    public function getStatistics($table) {
        $sql = "SELECT 
                    COUNT(*) as total_records,
                    MIN(registered_at) as first_registration,
                    MAX(registered_at) as last_registration
                FROM `{$table}`";
        
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new PDOException("Statistics error: " . $e->getMessage());
        }
    }

    /**
     * Get records with filter
     * 
     * @param string $table Table name
     * @param array $filters Filter conditions
     * @return array Filtered records
     */
    public function getFiltered($table, array $filters) {
        $conditions = [];
        $params = [];
        
        foreach ($filters as $column => $value) {
            $conditions[] = "`{$column}` = :{$column}";
            $params[":{$column}"] = $value;
        }
        
        $sql = "SELECT * FROM `{$table}`";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $sql .= " ORDER BY id DESC";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException("Filter error: " . $e->getMessage());
        }
    }

    /**
     * Get PDO connection
     * 
     * @return PDO PDO instance
     */
    public function getConnection() {
        return $this->pdo;
    }
}
?>
