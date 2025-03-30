<?php
require '../../../conn.php'; // Include your database connection

header('Content-Type: application/json');

// Fetch all records
$sql = "SELECT * FROM `excel_table` ORDER BY `date_created` DESC";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $row['period_start'] = date('Y', strtotime($row['period_start']));
        $row['period_end'] = date('Y', strtotime($row['period_end']));
        $data[] = $row;
    }

    echo json_encode($data);
    $stmt->close();
} else {
    echo json_encode(['error' => 'Failed to prepare the statement']);
}
?>
