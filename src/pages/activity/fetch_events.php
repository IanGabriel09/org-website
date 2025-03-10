<?php
require '../../../conn.php'; // Include your database connection

// Set the header to indicate JSON response
header('Content-Type: application/json');

$event_name = $_POST['eventName'];

if($event_name === 'All') {
    // Query to fetch event data (event_name and event_pic) for all events
    $query = "SELECT event_name, event_pic FROM events ORDER BY event_name ASC";
    $result = $conn->query($query);

    // Array to hold the event data
    $events = [];

    while ($row = $result->fetch_assoc()) {
        $row['event_pic'] = $row['event_pic']; // File path in DB
        $events[] = $row;
    }

    // Return the events data as JSON
    echo json_encode($events);
} else {
    // Query to fetch event data where event_name matches the provided event_name
    $query = "SELECT event_name, event_pic FROM events WHERE event_name = ? ORDER BY event_name ASC";
    
    // Prepare statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $event_name); // Bind the event_name parameter to the query

    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Array to hold the event data
    $events = [];

    while ($row = $result->fetch_assoc()) {
        $row['event_pic'] = $row['event_pic']; // File path in DB
        $events[] = $row;
    }

    // Return the events data as JSON
    echo json_encode($events);

    // Close the prepared statement
    $stmt->close();
}

$conn->close();
?>
