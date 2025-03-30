<?php
require '../../../conn.php';

header('Content-Type: application/json');

$org_id = $_POST['id'];

// Retrieve the file paths for both the excel file and the president picture from the database before deleting the record
$stmt = $conn->prepare('SELECT excel_file FROM excel_table WHERE id = ?');
$stmt->bind_param('s', $org_id);
$stmt->execute();
$stmt->bind_result($excel_file);
$stmt->fetch();
$stmt->close();

// If the excel file exists, delete it
if (!empty($excel_file) && file_exists($excel_file)) {
    unlink($excel_file); // Delete the excel file from the server
}

// Now, delete the record from the database
$stmt = $conn->prepare('DELETE FROM excel_table WHERE id = ?');
$stmt->bind_param('s', $org_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Event data, associated file, and president picture deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Event data not found or already deleted']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete event data']);
}

$stmt->close();
$conn->close();
?>
