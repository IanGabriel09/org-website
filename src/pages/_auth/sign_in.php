<?php
header('Content-Type: application/json');
require_once '../../../conn.php';

$email = $_POST['email'];
$pass = $_POST['pass'];

$stmt = $conn->prepare('SELECT * FROM user_table WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Check if the provided password matches the hashed password in the database
    if (password_verify($pass, $user['password'])) {
        // Check if tk_id is not NULL or empty (i.e., the user has a token)
        if (!empty($user['tk_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'User cannot be authenticated because they have an active token. Please verify your email first.'
            ]);
        } else {
            // If no token is present, authenticate the user
            echo json_encode([
                'status' => 'success',
                'message' => 'User authenticated successfully',
                'user' => $user
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid email or password'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found. Please register first.'
    ]);
}

$stmt->close();
$conn->close();
?>
