<?php
require_once 'database.php';

class Bookmark extends Database {
    private $query_config;
    public function __construct() {
       parent::__construct();
       $this->query_config = require __DIR__ . '/query_config.php';
    }

    public function toggle_bookmark($userId, $registryId) {
        // 1. Check if the user already bookmarked this property
        $checkStmt = $this->pdo->prepare("SELECT id FROM tbl_bookmark WHERE user_id = ? AND registry_id = ?");
        $checkStmt->execute([$userId, $registryId]);
        
        if ($checkStmt->fetch()) {
            // It exists! So we delete it (Unsave)
            $deleteStmt = $this->pdo->prepare("DELETE FROM tbl_bookmark WHERE user_id = ? AND registry_id = ?");
            $deleteStmt->execute([$userId, $registryId]);
            return ['status' => 'removed'];
        } else {
            // It does not exist! So we insert it (Save)
            $insertStmt = $this->pdo->prepare("INSERT INTO tbl_bookmark (user_id, registry_id) VALUES (?, ?)");
            $insertStmt->execute([$userId, $registryId]);
            return ['status' => 'added'];
        }
    }
    public function show_bookmark($user_id){
    // Use INNER JOIN to grab the actual property details attached to the bookmark!
    $sql = "SELECT 
                b.registry_id, 
                c.blocknumber, 
                c.lotnumber, 
                c.house_status 
            FROM `{$this->query_config['tables']['bookmark']}` b
            INNER JOIN tbl_centralinfo c ON b.registry_id = c.id 
            WHERE b.user_id = :user";
            
    $stmt = $this->pdo->prepare($sql); 
    $stmt->execute(['user' => $user_id]); 

    $acc_tran = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $acc_tran;
    }
    public function save_bookmark($user_id){
    $bm_query = "SELECT registry_id FROM tbl_bookmark WHERE user_id = :user";
    $bm_stmt = $this->pdo->prepare($bm_query);
    
    // Use the $user_id variable that was passed into the function!
    $bm_stmt->execute(['user' => $user_id]);
    
    // Return the clean array
    return $bm_stmt->fetchAll(PDO::FETCH_COLUMN);
}

     
}
?>