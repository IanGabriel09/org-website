<?php
require '../../../conn.php'; // Include your database connection

// Set the header to indicate JSON response
header('Content-Type: application/json');

// SQL query to join blog_featured and blog_table, and fetch the upload_date from blog_table
$sql = "
    SELECT bt.blog_num, bt.blog_title, bt.blog_content, bt.blog_img, bf.featured_order, DATE_FORMAT(bt.upload_date, '%Y-%m-%d') AS upload_date
    FROM blog_featured bf
    JOIN blog_table bt ON bf.blog_num = bt.blog_num
    ORDER BY bf.featured_order;
";

// Prepare the statement
if ($stmt = $conn->prepare($sql)) {
    // Execute the statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($blog_num, $blog_title, $blog_content, $blog_img, $featured_order, $upload_date);

    // Fetch the results and store them in an array
    $featuredBlogs = [];
    while ($stmt->fetch()) {
        $featuredBlogs[] = [
            'blog_num' => $blog_num,
            'blog_title' => $blog_title,
            'blog_content' => $blog_content,
            'blog_img' => $blog_img,
            'featured_order' => $featured_order,
            'upload_date' => $upload_date
        ];
    }

    // Get the number of rows returned
    $rowCount = count($featuredBlogs);

    // Return the results as a JSON response along with the row count
    echo json_encode([
        'rowCount' => $rowCount,
        'featuredBlogs' => $featuredBlogs
    ]);

    // Close the prepared statement
    $stmt->close();
} else {
    echo json_encode(['error' => 'Failed to prepare the query']);
}

// Close the database connection
$conn->close();
?>
