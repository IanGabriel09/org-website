<?php
header('Content-Type: application/json');

require '../../../conn.php'; // Assuming your database connection is here

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

$upload_directory = '../../../assets/img/companyProducts/'; // Upload directory for images

// Check if form is submitted and there are files uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selectName']) && !empty($_POST['selectName'])) {
        // Fetch fk_company_id from form
        $fk_company_id = $_POST['selectName'];

        // Prepare the insert query
        $query = "INSERT INTO affiliate_products (fk_company_id, product_name, product_description, product_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die(json_encode(['status' => 'error', 'message' => 'Failed to prepare query']));
        }

        // Process each product card
        for ($i = 0; isset($_POST["productName$i"]); $i++) {
            $productName = $_POST["productName$i"];
            $productDesc = $_POST["productDesc$i"];
            
            // Handle image upload
            if (isset($_FILES["productImg$i"]) && $_FILES["productImg$i"]['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES["productImg$i"]['tmp_name'];
                $fileName = generateImgName() . '.' . pathinfo($_FILES["productImg$i"]['name'], PATHINFO_EXTENSION);
                $destPath = $upload_directory . $fileName;

                // Move the uploaded file to the destination folder
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $productImage = $fileName;
                } else {
                    $productImage = ''; // If the file upload fails, set an empty string
                }
            } else {
                $productImage = ''; // If no file was uploaded, set an empty string
            }

            // Execute insert query for each product
            $stmt->bind_param("ssss", $fk_company_id, $productName, $productDesc, $productImage);
            $stmt->execute();
        }

        // Check if the query was successful
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Products added successfully. Please check client side to see the products uploaded.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No products were added']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Company ID is required']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
