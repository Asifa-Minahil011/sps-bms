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
        vendor,
        certification_group,
        practice,
        product,
        title,
        certification_code,
        certification_url,
        certification_type,
        completed_on
    FROM employee_certifications
    WHERE employee_id = ?
    ORDER BY completed_on DESC, id DESC
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$certifications = [];

while ($row = $result->fetch_assoc()) {
    $certifications[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $certifications
]);

$stmt->close();
$conn->close();

?>