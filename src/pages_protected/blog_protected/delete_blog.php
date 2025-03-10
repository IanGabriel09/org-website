<?php
require '../../../conn.php';

header('Content-Type: application/json');

$blog_id = $_POST['deleteID'];
$directory = '../../../assets/img/blogImg/';

$stmt = $conn->prepare('SELECT blog_img FROM blog_table WHERE blog_num = ?');
$stmt->bind_param('s', $blog_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($blog_img);
$stmt->fetch();

// Check if the event exists and if it has an associated image
if ($stmt->num_rows > 0) {
    // Construct the full path to the image
    $image_path = $directory . $blog_img;

    // If the event has an image and the file exists, delete the image
    if ($blog_img && file_exists($image_path)) {
        unlink($image_path); // Delete the image file from the server
    }

    // Now delete the event record from the database
    $stmt->close();
    $stmt = $conn->prepare('DELETE FROM blog_table WHERE blog_num = ?');
    $stmt->bind_param('s', $blog_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Post data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Post data not found or already deleted']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete Post data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Post data not found']);
}

$stmt->close();
$conn->close();
?>
