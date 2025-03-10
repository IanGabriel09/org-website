<?php
require '../../../conn.php'; // Include your database connection

header('Content-Type: application/json');

$president_name = isset($_POST['president_name']) ? $_POST['president_name'] : '';

if (!empty($president_name)) {
    $sql = "SELECT * FROM `excel_table` WHERE `president_name` LIKE ? ORDER BY `date_created` ASC";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $president_name . '%';
    $stmt->bind_param('s', $searchTerm);
} else {
    $sql = "SELECT * FROM `excel_table` ORDER BY `date_created` ASC";
    $stmt = $conn->prepare($sql);
}

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $row['period_start'] = date('Y', strtotime($row['period_start']));
        $row['period_end'] = date('Y', strtotime($row['period_end']));
        if ($row['president_picture']) {
            $row['president_picture'] = $row['president_picture'];
        }
        $data[] = $row;
    }

    echo json_encode($data);
    $stmt->close();
} else {
    echo json_encode(['error' => 'Failed to prepare the statement']);
}
?>
