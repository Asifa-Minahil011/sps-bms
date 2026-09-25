<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../../config/db.php";

$employeeId = intval($_GET["employee_id"] ?? 0);
$checklistType = trim($_GET["checklist_type"] ?? "");

$allowedTypes = [
    "onboarding_checklist",
    "onboarding_steps",
    "offboarding_checklist"
];

if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

if (!in_array($checklistType, $allowedTypes, true)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid checklist type."
    ]);

    exit;
}

$stmt = $conn->prepare("
    SELECT
        id,
        employee_id,
        checklist_type,
        item_key,
        item_label,
        choice_value,
        note
    FROM employee_checklists
    WHERE employee_id = ?
      AND checklist_type = ?
    ORDER BY id ASC
");

$stmt->bind_param(
    "is",
    $employeeId,
    $checklistType
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