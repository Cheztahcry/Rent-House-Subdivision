<?php
    require_once 'Database.php';
    class HouseInfo extends Database {
        private $query_config;
        public function __construct() {
        parent::__construct();
        $this->query_config = require __DIR__ . '/query_config.php';
    }
       public function check_duplicates($block, $lot) {
        $sql = "SELECT blocknumber, lotnumber 
                FROM `{$this->query_config['tables']['central']}` 
                WHERE blocknumber = :blocknumber AND lotnumber = :lotnumber
                LIMIT 1";        
        $stmt = $this->pdo->prepare($sql); 
        $stmt->execute(['blocknumber' => $block,
                        'lotnumber' => $lot]); 
        return (bool) $stmt->fetch();
}
       

    }


?>