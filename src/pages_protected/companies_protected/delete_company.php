<?php
require '../../../conn.php';

header('Content-Type: application/json');

$company_id = $_POST['companyID'];
$directory = '../../../assets/img/companyImg/';
$product_img_directory = '../../../assets/img/companyProducts/'; // Directory for product images

// Fetch the company's image file path from the database before deleting the company
$stmt = $conn->prepare('SELECT company_img FROM affiliate_table WHERE company_id = ?');
$stmt->bind_param('s', $company_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($company_img);
$stmt->fetch();

// Check if the company exists and if it has an associated image
if ($stmt->num_rows > 0) {
    // Construct the full path to the company's image
    $image_path = $directory . $company_img;

    // If the company has an image and the file exists, unlink the image
    if ($company_img && file_exists($image_path)) {
        unlink($image_path); // Unlink the company's image file from the server
    }

    // Fetch all product images related to the company before deleting the products
    $stmt->close();
    $stmt = $conn->prepare('SELECT product_image FROM affiliate_products WHERE fk_company_id = ?');
    $stmt->bind_param('s', $company_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($product_img);

    // Loop through all product images and unlink them
    while ($stmt->fetch()) {
        if ($product_img && file_exists($product_img_directory . $product_img)) {
            unlink($product_img_directory . $product_img); // Unlink the product's image file from the server
        }
    }

    // Now delete the company and its related products from the database
    $stmt->close();
    $stmt = $conn->prepare('DELETE FROM affiliate_table WHERE company_id = ?');
    $stmt->bind_param('s', $company_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Company and related product data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Company data not found or already deleted']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete company data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Company not found']);
}

$stmt->close();
$conn->close();
?>
