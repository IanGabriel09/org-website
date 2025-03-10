<?php
header('Content-Type: application/json');

require '../../../conn.php';

// Function to generate event ID
function generate_event_id() {
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

$timezone = new DateTimeZone('Asia/Manila');
define('MAX_FILE_SIZE', 2 * 1024 * 1024);  // 2MB max file size
$upload_dir = '../../../assets/img/eventAlbums/';  // Directory where images will be saved

$response = isset($_POST['event_name']) && isset($_FILES['event_pic']) ? (function() use ($conn, $timezone, $upload_dir) {
    $event_name = $_POST['event_name'];
    $date_uploaded = new DateTime('now', $timezone);
    $formatted_date = $date_uploaded->format('Y-m-d H:i:s'); // Format as MySQL datetime format

    // Initialize results array
    $results = [];

    // Check file sizes before proceeding
    foreach ($_FILES['event_pic']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['event_pic']['size'][$key] > MAX_FILE_SIZE) {
            return ['status' => 'error', 'message' => 'One or more files exceed the 2MB size limit.'];
        }
    }

    // Ensure the upload directory exists, create it if it doesn't
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Process each file
    foreach ($_FILES['event_pic']['tmp_name'] as $key => $tmp_name) {
        $event_id = generate_event_id();  // Generate a new event ID for each image
        $unique_filename = generateImgName();  // Generate a unique image filename using UUID
        $file_extension = pathinfo($_FILES['event_pic']['name'][$key], PATHINFO_EXTENSION);
        $target_filename = $unique_filename . '.' . $file_extension;  // Add the file extension
        $target_path = $upload_dir . $target_filename;  // Full path to the target image file

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmp_name, $target_path)) {
            // Insert record into the database with the file path
            $stmt = $conn->prepare("INSERT INTO events (event_id, date_uploaded, event_name, event_pic) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $event_id, $formatted_date, $event_name, $target_path);

            if ($stmt->execute()) {
                $stmt->close();
                $results[] = ['status' => 'success', 'message' => 'Event image uploaded successfully!'];
            } else {
                $stmt->close();
                $results[] = ['status' => 'error', 'message' => 'Error uploading event image.'];
            }
        } else {
            $results[] = ['status' => 'error', 'message' => 'Failed to move the uploaded file.'];
        }
    }

    return ['status' => 'success', 'message' => 'All images processed', 'results' => $results];
})() : ['status' => 'error', 'message' => 'Please fill out all fields.'];

$conn->close();

// Return response as JSON in one line
echo json_encode($response);
?>
