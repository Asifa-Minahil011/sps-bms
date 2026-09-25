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
        start_date,
        end_date,
        job_title,
        corporate_role,
        department_role,
        functional_role,
        duration
    FROM employee_employment_history
    WHERE employee_id = ?
    ORDER BY start_date DESC, id DESC
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$history = [];

while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $history
]);

$stmt->close();
$conn->close();

?>