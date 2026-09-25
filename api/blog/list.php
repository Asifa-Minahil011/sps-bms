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
        content,
        created_at,
        updated_at
    FROM employee_blog_entries
    WHERE employee_id = ?
    ORDER BY created_at DESC, id DESC
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$entries = [];

while ($row = $result->fetch_assoc()) {
    $entries[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $entries
]);

$stmt->close();
$conn->close();

?>