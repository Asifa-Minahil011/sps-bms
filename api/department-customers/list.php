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
        customer_code,
        customer_name
    FROM employee_department_customers
    WHERE employee_id = ?
    ORDER BY id ASC
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$customers = [];

while ($row = $result->fetch_assoc()) {
    $customers[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $customers
]);

$stmt->close();
$conn->close();

?>