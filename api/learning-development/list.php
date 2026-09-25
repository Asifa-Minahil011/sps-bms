<?php

header("Content-Type: application/json");

require_once "../../config/db.php";

$employeeId = intval($_GET["employee_id"] ?? 0);

if ($employeeId <= 0) {
    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

$stmt = $conn->prepare("
    SELECT
        id,
        employee_id,
        course_name,
        training_taken,
        test_taken
    FROM employee_learning_development
    WHERE employee_id = ?
    ORDER BY id ASC
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$records = [];

while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $records
]);

$stmt->close();
$conn->close();

?>