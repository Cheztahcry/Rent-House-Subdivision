<?php
// ajax_handler.php

// 1. START THE SESSION
session_start();

require_once 'bookmark.php';

// SECURE: Turn OFF visual error reporting so we don't leak server info or break JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

// 2. Check if registry_id was sent
if (isset($input['registry_id'])) {
    
    // 3. SECURE CHECK: Is the user actually logged into the dashboard?
    if (!isset($_SESSION["user_id"])) {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'You must be logged in to bookmark properties.']);
        exit; 
    }

    try {
        $bookmarkObj = new Bookmark();
        
        $secure_user_id = $_SESSION["user_id"];
        $property_id = $input['registry_id'];

        $result = $bookmarkObj->toggle_bookmark($secure_user_id, $property_id);
        
        echo json_encode($result);
        
    } catch (Throwable $e) { 
        http_response_code(500);
        // SECURE: Keep the error generic for the client
        echo json_encode(['error' => 'Database error occurred.']); 
        
        // OPTIONAL: This is where you could log $e->getMessage() to a local file
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing registry_id.']);
}
?>