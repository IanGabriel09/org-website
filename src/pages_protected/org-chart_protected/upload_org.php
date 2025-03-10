<?php
header('Content-Type: application/json');
require_once '../../../conn.php';

// Set the default timezone to Manila
date_default_timezone_set('Asia/Manila');

// Define the max file size (1MB)
define('MAX_FILE_SIZE', 1048576); // 1MB = 1048576 bytes

// Function to generate the custom UUID
function generateUUID() {
    $randomNumber = mt_rand(100000, 999999); // Ensure it's a 6-digit number
    return "UUID" . $randomNumber;
}

$id = generateUUID();
$cName = $_POST['companyName'];
$presName = $_POST['presidentName'];
$startTerm = $_POST['startPeriod'];
$endTerm = $_POST['endPeriod'];
$cDesc = $_POST['companyDesc'];

// Get the president's picture file and path
$presPicTmpName = $_FILES['presPic']['tmp_name'];
$presPicName = $_FILES['presPic']['name']; // The original name of the image file
$imageDir = '../../../assets/img/presidentImg/'; // Directory to store the images
$presPicPath = $imageDir . $presPicName; // Full path to the image

// Get the Excel file details
$fileName = $_FILES['excel_file']['name']; // Get the original Excel file name
$filePath = '../../../assets/excel/' . $fileName; // Directory path for the Excel file

// Check file extension to ensure it is an Excel file
$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
$allowedExtensions = ['xls', 'xlsx'];

// Validate president's picture size
if ($_FILES['presPic']['size'] > MAX_FILE_SIZE) {
    echo json_encode([
        "status" => "error", 
        "message" => "Image file is too large. Please upload a file smaller than 1MB."
    ]);
    exit();
}

// Validate the Excel file extension
if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid file type. Only Excel files (.xls, .xlsx) are allowed.",
        "fileName" => $fileName
    ]);
    exit();
}

// Check if the Excel file already exists in the directory
if (file_exists($filePath)) {
    echo json_encode([
        "status" => "exists", 
        "message" => "Excel file already exists. Please rename the file and try again.", 
        "fileName" => $fileName
    ]);
    exit();
}

// Ensure the image directory exists
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0777, true); // Create the directory if it doesn't exist
}

// Move the president's picture to the images directory
if (!move_uploaded_file($presPicTmpName, $presPicPath)) {
    echo json_encode([
        "status" => "error", 
        "message" => "Failed to upload the image file."
    ]);
    exit();
}

// Ensure the Excel directory exists
$uploadDir = '../../../assets/excel/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
}

// Move the Excel file to the Excel directory
if (!move_uploaded_file($_FILES['excel_file']['tmp_name'], $filePath)) {
    echo json_encode([
        "status" => "error", 
        "message" => "Failed to upload the Excel file."
    ]);
    exit();
}

// Set the current date in the required format
$date_created = date('Y-m-d H:i:s');

// Prepare and execute the SQL query
$stmt = $conn->prepare("INSERT INTO excel_table (id, period_start, period_end, president_name, company_name, company_description, excel_file, president_picture, date_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssssss', $id, $startTerm, $endTerm, $presName, $cName, $cDesc, $filePath, $presPicPath, $date_created);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Data inserted successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to insert data!"]);
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
