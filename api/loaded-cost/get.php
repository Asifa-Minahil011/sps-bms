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
        base_cost,
        individual_cost,
        practice_cost,
        last_year_cost,
        loaded_rate
    FROM employee_loaded_cost
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