<?php
require '../../../conn.php'; // Include your database connection

// Set the header to indicate JSON response
header('Content-Type: application/json');

// Query to fetch all rows from the 'events' table
$sql = "SELECT * FROM `events` ORDER BY `event_name` ASC";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $events = array();
    
    // Fetch all rows and store them in an array
    while ($row = mysqli_fetch_assoc($result)) {
        // If there's an event picture, store the path in the array
        if ($row['event_pic']) {
            $row['event_pic'] = $row['event_pic']; // File path in DB
        }
        
        $events[] = $row;
    }

    // Output the result as JSON
    echo json_encode($events, JSON_PRETTY_PRINT);
} else {
    // If the query fails, return an error message
    echo json_encode(['error' => 'Failed to retrieve data']);
}
?>
