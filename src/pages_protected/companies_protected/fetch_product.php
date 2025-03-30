<?php
require '../../../conn.php'; // Include your database connection

header('Content-Type: application/json');

$company_id = $_POST['cName']; // Retrieve the company name from the POST request

// Check if the company name is provided
if (empty($company_id)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Company name is required'
    ]);
    exit; 
}

$sql = "SELECT * FROM `affiliate_products` WHERE `fk_company_id` = ? ORDER BY `id` ASC";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param('s', $company_id); // Bind company name

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $companies = [];
        while ($row = $result->fetch_assoc()) {
            $companies[] = $row;
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Data successfully fetched',
            'data' => $companies
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No products found for the specified company'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to prepare SQL query'
    ]);
}

$conn->close();
?>
