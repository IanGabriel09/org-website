<?php
require '../../../conn.php';

header('Content-Type: application/json');

$id = $_POST['deleteID'];

$stmt = $conn->prepare('SELECT news_img FROM news_table WHERE news_id = ?');
$stmt->bind_param('s', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($news_img);
$stmt->fetch();

if($stmt->num_rows > 0) {
    // If the event has an image, delete the image from the directory
    if ($news_img && file_exists($news_img)) {
        unlink($news_img); // Delete the image file from the server
    }
    
    $stmt->close();

    $stmt = $conn->prepare('DELETE FROM news_table WHERE news_id = ?');
    $stmt->bind_param('s', $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Event data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Event data not found or already deleted']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete even data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'News not found']);
}

$stmt->close();
$conn->close();
?>
