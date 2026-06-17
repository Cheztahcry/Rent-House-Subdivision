<?php
    $tb_name = "tbl_rentinfo";
    $conn = "";
    $config = require 'config.php';

    class DataBase{
        protected $pdo;
        
        public function __construct(
        ){
            $config = require 'config.php';

            $dsn = "mysql:host=" . $config['host'];
            $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                $this->pdo = new PDO($dsn, $config['user'], $config['password']);
                $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `{$config['dbname']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $this->pdo->exec("USE `{$config['dbname']}` ");
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());

            }
        }
        public function create_table($table, array $column) {
            $fields = [];
            $constraints = [];

            // 1. Separate standard columns from SQL constraints
            foreach ($column as $key => $value) {
                if (strtoupper($key) === 'FOREIGN KEY' || strtoupper($key) === 'PRIMARY KEY' || strtoupper($key) === 'UNIQUE KEY') {
                    $constraints[] = "$key $value";
                } else {
                    $fields[] = "`$key` $value";
                }
            }

            // 2. Build a clean list of EVERYTHING that goes inside the table definition
            $all_parts = array_merge($fields, $constraints);

            // 3. Assemble the CREATE TABLE query safely in ONE single go
            $create_table = "CREATE TABLE IF NOT EXISTS `$table` (" . implode(', ', $all_parts) . ") ENGINE=InnoDB;";
            
            // Execute the main creation query
            $this->pdo->exec($create_table);

            // 4. Run your migration safety net loop (Alters columns individually if table already exists)
            foreach ($fields as $colDef) {
                if (preg_match('/`([^`]+)`/', $colDef, $m)) {
                    $alter = "ALTER TABLE `$table` ADD COLUMN IF NOT EXISTS " . $colDef;
                    try {
                        $this->pdo->exec($alter);
                    } catch (\PDOException $e) {
                        // Ignore errors for older MySQL versions that don't support IF NOT EXISTS on ALTER
                    }
                }
            }

            return true;
        }


        public function show_table($table){
            $show = "SELECT * FROM `$table`";
            try {
                $show_query = $this->pdo->query($show);
                return $show_query->fetchAll(PDO::FETCH_OBJ);
            } catch (\PDOException $e) {
                // Return empty array on error (missing table, etc.) to allow
                // the caller to handle 'no data' gracefully instead of dying.
                return [];
            }
        }

        public function insert_table($table, array $column){
            unset($column['id']);
            $attributes = array_keys($column);
            $imp_att = implode(", ", $attributes);
            $place_att = ":". implode(", :", $attributes);
            $insert_info = "INSERT INTO `$table` ($imp_att) VALUES($place_att)";
            try {
                $insert = $this->pdo->prepare($insert_info);
                return $insert->execute($column);
                } 
            catch (PDOException $e) {
                throw $e;

        }
        
        }
        public function duplicate_entries_real_time($lot, $block, $tbl){
            $sql = "SELECT * FROM `{$tbl}` WHERE  lotnumber = :lot AND blocknumber = :blocknumber" ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'lot' => $lot,
                'blocknumber' => $block]);
            $results = $stmt->fetchColumn();
            if ($results > 0){
                echo "House is already registered";
            }
       }
       public function filterData(array $input, array $allowedKeys) {
        // 1. Whitelist the keys
        $whitelisted = array_intersect_key($input, array_flip($allowedKeys));
        
        // 2. NEW: Drop any keys where the user left the input blank
        return array_filter($whitelisted, function($value) {
            return $value !== ''; 
        });
        }
}
    

        

        



?>
