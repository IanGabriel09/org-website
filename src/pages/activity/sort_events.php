<?php
require '../../../conn.php'; // Include your database connection

// Set the header to indicate JSON response
header('Content-Type: application/json');

// Query to fetch distinct event_name values
$query = 'SELECT DISTINCT event_name FROM events ORDER BY event_name ASC';
$result = $conn->query($query);

// Initialize an array to store event names
$events = array();

// Fetch the results and store event names in the array
while ($row = $result->fetch_assoc()) {
    $events[] = $row['event_name'];
}

// Close the database connection
$conn->close();

// Output the result as JSON
echo json_encode($events);
?>
