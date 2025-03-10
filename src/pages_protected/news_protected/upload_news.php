<?php
// Set header for JSON response
header('Content-Type: application/json');

require '../../../conn.php';

// Function to generate unique ID
function generateID() {
    $random_number = mt_rand(10000000, 99999999);
    return 'ENV-' . $random_number;
}

// Function to generate a unique image filename using UUID
function generateImgName() {
    // Generate a version 4 UUID (random-based)
    if (function_exists('com_create_guid') === true) {
        return com_create_guid(); // Windows-specific
    } else {
        // Generate UUID for other platforms
        $data = random_bytes(16);
        // Set version (4) and variant (2) as per UUID v4 specs
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set version to 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set variant to 10xx
        // Convert to hexadecimal representation and return
        return sprintf('%08x-%04x-%04x-%04x-%12x',
            unpack('N', substr($data, 0, 4))[1],
            unpack('n', substr($data, 4, 2))[1],
            unpack('n', substr($data, 6, 2))[1],
            unpack('n', substr($data, 8, 2))[1],
            unpack('N', substr($data, 10, 4))[1]
        );
    }
}

// Define the max file size (1MB)
define('MAX_FILE_SIZE', 1048576); // 1MB = 1048576 bytes

$news_id = generateID();
$news_name = $_POST['news_name'];
$dateExpected = $_POST['dateExpected'];
$newsDesc = $_POST['newsDesc'];

// Check if the news image file is uploaded and validate the size
if ($_FILES['newsPic']['size'] > MAX_FILE_SIZE) {
    echo json_encode([
        "status" => "error", 
        "message" => "Your news image is too large, file limitations are 1mb",
    ]);
    exit();
}

// File input
$newsPic = $_FILES['newsPic'];

// Check if the image was uploaded without errors
if ($newsPic && $newsPic['error'] === 0) {
    // Generate a unique filename for the image using UUID
    $image_extension = pathinfo($newsPic['name'], PATHINFO_EXTENSION);
    $image_name = generateImgName() . '.' . $image_extension;  // Ensure unique name

    // Define the directory where images will be stored
    $target_directory = '../../../assets/img/newsImg/';
    
    // Check if the directory exists, if not, create it
    if (!file_exists($target_directory)) {
        mkdir($target_directory, 0777, true);
    }

    // Define the full path where the image will be saved
    $target_file = $target_directory . $image_name;

    // Move the uploaded image to the target directory
    if (!move_uploaded_file($newsPic['tmp_name'], $target_file)) {
        echo json_encode([
            "status" => "error", 
            "message" => "Failed to move uploaded file to directory.",
        ]);
        exit();
    }
} else {
    // Default to null if no file is uploaded or there was an error
    $target_file = null;
}

try {
    // Prepare the SQL statement to insert the news data along with the image file path
    $stmt = $conn->prepare("INSERT INTO news_table (news_id, news_name, expected_date, news_description, news_img, created_at) 
                            VALUES (?, ?, ?, ?, ?, NOW())");
    
    // Bind parameters to the prepared statement
    $stmt->bind_param('sssss', $news_id, $news_name, $dateExpected, $newsDesc, $target_file);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'News item added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert news item.']);
    }

    // Close the prepared statement
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}

// Close the database connection
$conn->close();
?>