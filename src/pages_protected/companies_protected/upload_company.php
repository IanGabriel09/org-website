<?php
header('Content-Type: application/json');

require '../../../conn.php';

// Function to generate event ID
function generate_company_id() {
    $random_number = mt_rand(10000000, 99999999);
    return 'ENV-' . $random_number;
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
define('MAX_FILE_SIZE', 1048576); // 1MB = 1048576 bytes

$company_id = generate_company_id();

$company_name = $_POST['companyName'];
$date_established = $_POST['dateEstablished'];
$company_address = $_POST['companyAddress'];
$company_mail = $_POST['companyEmail'];
$company_contact = $_POST['companyContact'];
$web_link = $_POST['webLink'];
$company_desc = $_POST['companyDesc'];

// Convert Unix timestamp to MySQL DATETIME format
$date_uploaded = date('Y-m-d H:i:s', time()); // Get current datetime in MySQL format

if ($_FILES['companyImg']['size'] > MAX_FILE_SIZE) {
    echo json_encode([
        "status" => "error", 
        "message" => "Your news image is too large, file limitations are 1MB",
    ]);
    exit();
}

$companyImg = $_FILES['companyImg'];
$image_filename = generateImgName() . '.' . pathinfo($companyImg['name'], PATHINFO_EXTENSION); // Using extension from original file
$directory = '../../../assets/img/companyImg/';

// Check if the company name or email already exists in the database
$query = "SELECT * FROM `affiliate_table` WHERE `company_name` = ? OR `email` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $company_name, $company_mail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "status" => "error", 
        "message" => "A company with this name or email already exists.",
    ]);
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->close();

// Move the uploaded image to the directory
if (move_uploaded_file($companyImg['tmp_name'], $directory . $image_filename)) {
    $stmt = $conn->prepare("INSERT INTO `affiliate_table` 
        (`company_id`, `company_name`, `company_address`, `company_description`, `contact`, `email`, `date_established`, `web_link`, `company_img`, `date_uploaded`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('ssssssssss', $company_id, $company_name, $company_address, $company_desc, $company_contact, $company_mail, $date_established, $web_link, $image_filename, $date_uploaded);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Company successfully added!",
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
