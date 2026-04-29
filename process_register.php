<?php
header('Content-Type: application/json';

// Include database configuration
$config = require 'config.php';

// Include Database class
require 'database.php';

// Initialize response array
$response = [
    'status' => 'error',
    'message' => '',
    'redirect' => false
];

try {
    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Invalid request method';
        echo json_encode($response);
        exit;
    }

    // Sanitize and validate inputs
    $lname = trim($_POST['lname'] ?? '');
    $fname = trim($_POST['fname'] ?? '');
    $mname = trim($_POST['mname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $gender = trim($_POST['gender'] ?? '');
    $block = intval($_POST['block'] ?? 0);
    $lot = intval($_POST['lot'] ?? 0);
    $rent_price = floatval($_POST['rent_price'] ?? 0);
    $down_payment = floatval($_POST['down_payment'] ?? 0);
    $move_in_date = trim($_POST['move_in_date'] ?? '');
    $lease_terms = intval($_POST['lease_terms'] ?? 0);
    $agree_terms = isset($_POST['agree_terms']) ? 1 : 0;

    // Validation
    $errors = [];

    if (empty($lname)) $errors['lname'] = 'Last name is required';
    if (empty($fname)) $errors['fname'] = 'First name is required';
    if (empty($email)) $errors['email'] = 'Email is required';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format';
    
    if (empty($contact_number)) $errors['contact_number'] = 'Contact number is required';
    elseif (!preg_match('/^[0-9]{11}$/', $contact_number)) $errors['contact_number'] = 'Contact number must be 11 digits';
    
    if ($age < 18 || $age > 120) $errors['age'] = 'Age must be between 18 and 120';
    if (empty($gender)) $errors['gender'] = 'Gender is required';
    if ($block < 1) $errors['block'] = 'Valid block number is required';
    if ($lot < 1) $errors['lot'] = 'Valid lot number is required';
    if ($rent_price < 0) $errors['rent_price'] = 'Rent price must be valid';
    if ($down_payment < 0) $errors['down_payment'] = 'Down payment must be valid';
    if (empty($move_in_date)) $errors['move_in_date'] = 'Move-in date is required';
    if ($lease_terms < 1 || $lease_terms > 60) $errors['lease_terms'] = 'Lease term must be between 1-60 months';
    if ($agree_terms != 1) $errors['agree_terms'] = 'You must agree to terms and conditions';

    // If there are validation errors, return them
    if (!empty($errors)) {
        $response['message'] = 'Please fix the errors below';
        $response['errors'] = $errors;
        echo json_encode($response);
        exit;
    }

    // Initialize Database connection
    $db = new Database(
        $config['host'],
        $config['db'],
        $config['user'],
        $config['password']
    );

    // Create table if not exists
    $table_schema = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'lname' => 'VARCHAR(50) NOT NULL',
        'fname' => 'VARCHAR(50) NOT NULL',
        'mname' => 'VARCHAR(50)',
        'email' => 'VARCHAR(100) NOT NULL UNIQUE',
        'contact_number' => 'VARCHAR(11) NOT NULL UNIQUE',
        'age' => 'INT NOT NULL',
        'gender' => 'VARCHAR(10) NOT NULL',
        'block' => 'INT NOT NULL',
        'lot' => 'INT NOT NULL',
        'rent_price' => 'DECIMAL(10, 2) NOT NULL',
        'down_payment' => 'DECIMAL(10, 2) NOT NULL',
        'move_in_date' => 'DATE NOT NULL',
        'lease_terms' => 'INT NOT NULL',
        'agree_terms' => 'TINYINT(1) NOT NULL',
        'registered_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    $db->create_table('owners', $table_schema);

    // Check for duplicate email
    if ($db->checkDuplicate('owners', 'email', $email)) {
        $response['message'] = 'Email already registered';
        $response['errors'] = ['email' => 'This email is already in use'];
        echo json_encode($response);
        exit;
    }

    // Check for duplicate contact number
    if ($db->checkDuplicate('owners', 'contact_number', $contact_number)) {
        $response['message'] = 'Contact number already registered';
        $response['errors'] = ['contact_number' => 'This contact number is already in use'];
        echo json_encode($response);
        exit;
    }

    // Prepare data for insertion
    $owner_data = [
        'lname' => $lname,
        'fname' => $fname,
        'mname' => $mname,
        'email' => $email,
        'contact_number' => $contact_number,
        'age' => $age,
        'gender' => $gender,
        'block' => $block,
        'lot' => $lot,
        'rent_price' => $rent_price,
        'down_payment' => $down_payment,
        'move_in_date' => $move_in_date,
        'lease_terms' => $lease_terms,
        'agree_terms' => $agree_terms
    ];

    // Insert data into database
    if ($db->insert_table('owners', $owner_data)) {
        $response['status'] = 'success';
        $response['message'] = 'Registration successful! Redirecting...';
        $response['redirect'] = true;
        echo json_encode($response);
    } else {
        $response['message'] = 'Failed to register. Please try again.';
        echo json_encode($response);
    }

} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
    echo json_encode($response);
} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
    echo json_encode($response);
}
?>
