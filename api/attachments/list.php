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
        title,
        original_file_name,
        stored_file_name,
        file_path,
        file_type,
        file_size,
        created_at
    FROM employee_attachments
    WHERE employee_id = ?
    ORDER BY id DESC
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$attachments = [];

while ($row = $result->fetch_assoc()) {
    $attachments[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $attachments
]);

$stmt->close();
$conn->close();

?>