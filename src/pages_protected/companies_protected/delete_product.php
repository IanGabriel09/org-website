<?php
require '../../../conn.php';

header('Content-Type: application/json');

$product_img = $_POST['productIMG'];
$directory = '../../../assets/img/companyProducts/';

// Construct the full path to the image
$image_path = $directory . $product_img;

// Check if the image exists in the directory
if (file_exists($image_path)) {
    // Delete the image file from the server
    unlink($image_path);

    // Prepare and execute the query to delete the company data
    $stmt = $conn->prepare('DELETE FROM affiliate_products WHERE product_image = ?');
    $stmt->bind_param('s', $product_img);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Company data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Company data not found or already deleted']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete company data']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Image not found']);
}

$conn->close();
?>
