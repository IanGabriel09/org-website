<?php
require '../conn.php'; // Include your database connection

// Set the header to indicate JSON response
header('Content-Type: application/json');

// Query to fetch the last 3 rows from the 'blog_table' ordered by 'upload_date' in descending order
$sql = "SELECT * FROM `blog_table` ORDER BY `blog_num` DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $blogs = array();
    
    // Fetch all rows and store them in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row; // Store the event row in the blogs array
    }

    // Output the result as JSON including the data
    echo json_encode([
        "status" => "success",
        "message" => "Data successfully fetched",
        "recentBlogs" => $blogs // Include the fetched data in the response
    ]);
} else {
    // If the query fails, return an error message
    echo json_encode([
        'status' => 'error',
        "message" => 'Failed to fetch blog data'
    ]);
}
?>
