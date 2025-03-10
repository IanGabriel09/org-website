<?php
require '../../../conn.php'; // Include your database connection

// Set the header to indicate JSON response
header('Content-Type: application/json');

$blog_num = $_POST['selectBlog'];
$featured_order = $_POST['featuredOrder'];

// Check if the featured_order already exists
$checkOrderStmt = $conn->prepare('SELECT * FROM blog_featured WHERE featured_order = ?');
$checkOrderStmt->bind_param('s', $featured_order);
$checkOrderStmt->execute();
$orderResult = $checkOrderStmt->get_result();

if ($orderResult->num_rows > 0) {  // If featured_order already exists
    echo json_encode([
        "status" => "error", 
        "message" => "The selected featured order already exists. Please choose a different order 1-3.",
    ]);
    $checkOrderStmt->close();
    exit();
}

$checkOrderStmt->close();

// Check if there are already 3 featured posts
$checkStmt = $conn->prepare('SELECT * FROM blog_featured ORDER BY featured_order ASC');
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows >= 3) {  // Corrected the comparison to check row count
    echo json_encode([
        "status" => "error", 
        "message" => "There are already 3 featured posts. Please delete one first before creating/setting a new one.",
    ]);
    $checkStmt->close();
    exit();  
}

$checkStmt->close();

// Insert new featured post
$stmt = $conn->prepare("INSERT INTO blog_featured (`blog_num`, `featured_order`) VALUES (?, ?)");
$stmt->bind_param('ss', $blog_num, $featured_order);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success", 
        "message" => "Featured post updated added!",
    ]);
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "Failed to insert featured post data into the database.",
    ]);
}

$stmt->close();
$conn->close();
?>
