<?php
header('Content-Type: application/json');
require_once '../../../conn.php';

$sessionUserName = $_POST['userEmail'];

$stmt = $conn->prepare('SELECT * FROM user_table WHERE email = ?');
$stmt->bind_param('s', $sessionUserName);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode([
        'status' => 'success',
        'message' => 'User found.',
        'user' => $user
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found. You will be redirected to login page.'
    ]);
}

$stmt->close();
$conn->close();


?>