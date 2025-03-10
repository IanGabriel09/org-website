<?php
header('Content-Type: application/json');

require '../../../conn.php';

// Function to generate event ID
function generate_blog_id() {
    $random_number = mt_rand(10000000, 99999999);
    return 'BLG-' . $random_number;
}

// Function to generate a unique image filename using UUID
function generateImgName() {
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

$timezone = new DateTimeZone('Asia/Manila');

// Define the max file size (1MB)
define('MAX_FILE_SIZE', 2097152); // 2MB = 2097152 bytes

$blog_id = generate_blog_id();
$blog_title = $_POST['blogTitle'];
$blog_content = $_POST['blogContent'];
$date_uploaded = date('Y-m-d H:i:s', time()); // Get current datetime in MySQL format

if ($_FILES['blogImg']['size'] > MAX_FILE_SIZE) {
    echo json_encode([
        "status" => "error", 
        "message" => "Your news image is too large, file limitations are 1MB",
    ]);
    exit();
}

$blogImg = $_FILES['blogImg'];
$image_filename = generateImgName() . '.' . pathinfo($blogImg['name'], PATHINFO_EXTENSION); // Using extension from original file
$directory = '../../../assets/img/blogImg/';

// Move the uploaded image to the directory
if (move_uploaded_file($blogImg['tmp_name'], $directory . $image_filename)) {
    $stmt = $conn->prepare("INSERT INTO `blog_table` 
        (`blog_id`, `blog_title`, `blog_content`, `blog_img`, `upload_date`) 
        VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param('sssss', $blog_id, $blog_title, $blog_content, $image_filename, $date_uploaded);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Blog post successfully added!",
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Failed to insert company data into the database.",
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "Failed to upload the image.",
    ]);
}

$conn->close();
?>
