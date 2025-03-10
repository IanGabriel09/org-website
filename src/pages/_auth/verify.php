<?php
// Include database connection file (make sure to configure your DB connection correctly)
require_once '../../../conn.php';

// Check if the tokenID, uuid, and email are provided
if(isset($_GET['tokenID'], $_GET['uuid'], $_GET['email'])) {
    // Get the token, uuid, and email from the URL
    $tokenID = $_GET['tokenID'];
    $uuid = $_GET['uuid'];
    $email = $_GET['email'];

    // Prepare and execute the query to find the user based on tk_id, uuid, and email
    $query = "SELECT * FROM user_table WHERE tk_id = ? AND user_id = ? AND email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $tokenID, $uuid, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and the token matches
    if($result->num_rows > 0) {
        // If valid, delete the token by setting tk_id to NULL
        $deleteQuery = "UPDATE user_table SET tk_id = NULL WHERE tk_id = ? AND user_id = ? AND email = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("sss", $tokenID, $uuid, $email);
        if ($deleteStmt->execute()) {
            // Redirect to success page if token is deleted
            header("Location: ../_response/success.html");
            exit();
        } else {
            // Redirect to failed page if unable to delete the token
            header("Location: ../_response/failed.html");
            exit();
        }
    } else {
        // Redirect to failed page if no match is found
        header("Location: ../_response/failed.html");
        exit();
    }
} else {
    // Redirect to failed page if required parameters are missing
    header("Location: ../_response/failed.html");
    exit();
}
?>
