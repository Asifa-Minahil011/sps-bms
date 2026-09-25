<?php

header("Content-Type: application/json; charset=utf-8");

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
        reason,
        created_at
    FROM employee_offboarding_reasons
    WHERE employee_id = ?
    ORDER BY id ASC
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$reasons = [];

while ($row = $result->fetch_assoc()) {
    $reasons[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $reasons
]);

$stmt->close();
$conn->close();

?>