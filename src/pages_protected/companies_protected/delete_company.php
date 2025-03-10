<?php
require '../../../conn.php';

header('Content-Type: application/json');

$company_id = $_POST['companyID'];
$directory = '../../../assets/img/companyImg/';

// Fetch the event's image file path from the database before deleting the event
$stmt = $conn->prepare('SELECT company_img FROM affiliate_table WHERE company_id = ?');
$stmt->bind_param('s', $company_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($company_img);
$stmt->fetch();

// Check if the event exists and if it has an associated image
if ($stmt->num_rows > 0) {
    // Construct the full path to the image
    $image_path = $directory . $company_img;

    // If the event has an image and the file exists, delete the image
    if ($company_img && file_exists($image_path)) {
        unlink($image_path); // Delete the image file from the server
    }

    // Now delete the event record from the database
    $stmt->close();
    $stmt = $conn->prepare('DELETE FROM affiliate_table WHERE company_id = ?');
    $stmt->bind_param('s', $company_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Company data deted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Company data not found or already deleted']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete company data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Copmany not found']);
}

$stmt->close();
$conn->close();
?>
