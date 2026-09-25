<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../../config/db.php";

$employeeId = intval($_GET["employee_id"] ?? 0);
$formType = strtoupper(trim($_GET["form_type"] ?? ""));

if ($employeeId <= 0) {
    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

if (!in_array($formType, ["A", "B"], true)) {
    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid form type."
    ]);

    exit;
}

$stmt = $conn->prepare("
    SELECT
        id,
        employee_id,
        form_type,
        responsibilities,
        notes,
        review_year,
        review_quarter,
        rating,
        achievements,
        development,
        created_at,
        updated_at
    FROM employee_forms
    WHERE employee_id = ?
      AND form_type = ?
    LIMIT 1
");

$stmt->bind_param(
    "is",
    $employeeId,
    $formType
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