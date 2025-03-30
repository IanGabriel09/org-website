<?php
require '../../../conn.php'; // Include your database connection

// Set the header to indicate JSON response
header('Content-Type: application/json');

// SQL query to fetch all rows from 'affiliate_table' and their related rows from 'affiliate_products'
$sql = "SELECT at.*, ap.id AS product_id, ap.product_name, ap.product_description, ap.product_image
        FROM `affiliate_table` at
        LEFT JOIN `affiliate_products` ap ON at.company_id = ap.fk_company_id
        ORDER BY at.date_uploaded ASC";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $affilliates = array();
    
    // Fetch all rows and store them in an array
    while ($row = mysqli_fetch_assoc($result)) {
        // Here we add the product data under each affiliate
        // If a product exists, we include it; otherwise, we leave it as null
        $affiliate_id = $row['company_id'];

        // Check if this affiliate already exists in the array, if not, create a new entry
        if (!isset($affilliates[$affiliate_id])) {
            $affilliates[$affiliate_id] = [
                'company_id' => $row['company_id'],
                'company_name' => $row['company_name'],
                'business_type' => $row['business_type'],
                'company_description' => $row['company_description'],
                'contact' => $row['contact'],
                'email' => $row['email'],
                'web_link' => $row['web_link'],
                'company_img' => $row['company_img'],
                'date_uploaded' => $row['date_uploaded'],
                'products' => [] // Initialize products array for each affiliate
            ];
        }

        // Add product information to the 'products' array if a product exists
        if ($row['product_id']) {
            $affilliates[$affiliate_id]['products'][] = [
                'product_id' => $row['product_id'],
                'product_name' => $row['product_name'],
                'product_description' => $row['product_description'],
                'product_image' => $row['product_image']
            ];
        }
    }

    // Output the result as JSON including the data
    echo json_encode([
        "status" => "success",
        "message" => "Data successfully fetched",
        "data" => array_values($affilliates) // Convert associative array to indexed array
    ]);
} else {
    // If the query fails, return an error message
    echo json_encode([
        'status' => 'error',
        "message" => 'Failed to fetch data'
    ]);
}
?>
