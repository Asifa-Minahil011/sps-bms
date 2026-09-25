<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../../config/db.php";

$employeeId = intval($_GET["employee_id"] ?? 0);
$planType = trim($_GET["plan_type"] ?? "");

$allowedTypes = [
    "onboarding",
    "offboarding"
];

if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

if (!in_array($planType, $allowedTypes, true)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid plan type."
    ]);

    exit;
}

$stmt = $conn->prepare("
    SELECT
        id,
        employee_id,
        plan_type,
        item_key,
        task_name,
        assignee
    FROM employee_plan_assignments
    WHERE employee_id = ?
      AND plan_type = ?
    ORDER BY id ASC
");

$stmt->bind_param(
    "is",
    $employeeId,
    $planType
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