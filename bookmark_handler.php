<?php
// ajax_handler.php

// 1. START THE SESSION (Crucial for the dashboard!)
session_start();

require_once 'bookmark.php';

// Turn OFF visual error reporting so we don't break JSON with HTML errors
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

// 2. ONLY check if registry_id was sent. We don't care if JS sends a user_id.
if (isset($input['registry_id'])) {
    
    // 3. SECURE CHECK: Is the user actually logged into the dashboard?
    if (!isset($_SESSION["user_id"])) {
        http_response_code(401); // 401 means "Unauthorized"
        echo json_encode(['error' => 'You must be logged in to bookmark properties.']);
        exit; // Stop the script entirely
    }

    try {
        $bookmarkObj = new Bookmark();
        
        // 4. Use the secure Session ID, NOT the Javascript ID!
        $secure_user_id = $_SESSION["user_id"];
        $property_id = $input['registry_id'];

        $result = $bookmarkObj->toggle_bookmark($secure_user_id, $property_id);
        
        echo json_encode($result);
        
    } catch (Throwable $e) { 
        http_response_code(500);
        // Keep the error message generic for the user, but you can log $e->getMessage() to a secret file later
        echo json_encode(['error' => 'Database error occurred.']); 
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing registry_id.']);
}
?>