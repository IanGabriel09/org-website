<?php
require '../../../conn.php';
header('Content-Type: application/json');

// Capture POST data
$username = $_POST['uName'];
$password = $_POST['pass'];

// Prepare a response array
$response = array('status' => 'error', 'message' => 'Invalid username or password', 'username' => $username);

if (!empty($username) && !empty($password)) {
    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM admin_table WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        
        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            $response = array('status' => 'success', 'message' => 'Authentication successful');
        } else {
            $response['message'] = 'Incorrect password';
        }
    } else {
        $response['message'] = 'Username not found';
    }
    
    $stmt->close();
} else {
    $response['message'] = 'Username and password cannot be empty';
}

// Return the response as JSON
echo json_encode($response);

$conn->close();
?>
