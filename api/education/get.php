<?php

header("Content-Type: application/json");

require_once "../../config/db.php";

$employeeId = intval($_GET["employee_id"] ?? 0);

if ($employeeId <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM employee_education
    WHERE employee_id = ?
    LIMIT 1
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$data = $result->fetch_assoc();

echo json_encode([
    "success" => true,
    "data" => $data
]);

$stmt->close();
$conn->close();

?>