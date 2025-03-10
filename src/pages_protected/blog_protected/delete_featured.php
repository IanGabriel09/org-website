<?php
require '../../../conn.php';

header('Content-Type: application/json');

// Get the blog ID to delete
$blog_id = $_POST['deleteID'];

// Prepare the SQL statement to delete the blog record
$stmt = $conn->prepare('DELETE FROM blog_featured WHERE blog_num = ?');
$stmt->bind_param('s', $blog_id);

// Execute the statement
if ($stmt->execute()) {
    // Return success response
    echo json_encode([
        'status' => 'success',
        'message' => 'Successfully deleted from featured Posts.'
    ]);
} else {
    // Return failure response
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to delete featured posts.'
    ]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
