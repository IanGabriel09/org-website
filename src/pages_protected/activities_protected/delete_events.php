<?php
require '../../../conn.php';

header('Content-Type: application/json');

$event_id = $_POST['eventID'];

// Fetch the event's image file path from the database before deleting the event
$stmt = $conn->prepare('SELECT event_pic FROM events WHERE event_id = ?');
$stmt->bind_param('s', $event_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($event_pic);
$stmt->fetch();

// Check if the event exists and if it has an associated image
if ($stmt->num_rows > 0) {
    // If the event has an image, delete the image from the directory
    if ($event_pic && file_exists($event_pic)) {
        unlink($event_pic); // Delete the image file from the server
    }

    // Now delete the event record from the database
    $stmt->close();
    $stmt = $conn->prepare('DELETE FROM events WHERE event_id = ?');
    $stmt->bind_param('s', $event_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Event data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Event data not found or already deleted']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete event data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Event not found']);
}

$stmt->close();
$conn->close();
?>
