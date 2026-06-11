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
        public function create_table($table, array $column){
            $tabledat = [];
            foreach($column as $name => $data_type){
                $tabledat[] = "`$name` $data_type";
            }
                $create_table = "CREATE TABLE IF NOT EXISTS `$table` (" . implode(', ', $tabledat) . ")";
                $this->pdo->exec($create_table);
                // Attempt to add any missing columns individually to avoid invalid SQL syntax
                foreach ($tabledat as $colDef) {
                    // Extract the column name from the definition like `name` TYPE
                    if (preg_match('/`([^`]+)`/', $colDef, $m)) {
                        $colName = $m[1];
                        // Use ADD COLUMN IF NOT EXISTS per-column (MySQL 8+). If the server
                        // doesn't support IF NOT EXISTS for ADD COLUMN, the exec will throw
                        // and caller code should handle it accordingly.
                        $alter = "ALTER TABLE `$table` ADD COLUMN IF NOT EXISTS " . $colDef;
                        try {
                            $this->pdo->exec($alter);
                        } catch (\PDOException $e) {
                            // Ignore alter errors to avoid breaking on older MySQL versions
                            // (table already has columns or server doesn't support IF NOT EXISTS)
                        }
                    }
                }
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
                die("Insert Error: " . $e->getMessage());
                if ($e->errorInfo[1] == 1062) {
                echo "Duplicate entry detected!";
                }

        }
    }
}
    

        

        



?>