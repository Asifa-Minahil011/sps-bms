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
        product_code,
        product_name
    FROM employee_products
    WHERE employee_id = ?
    ORDER BY id ASC
");

$stmt->bind_param(
    "i",
    $employeeId
);

$stmt->execute();

$result = $stmt->get_result();

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $products
]);

$stmt->close();
$conn->close();

?>