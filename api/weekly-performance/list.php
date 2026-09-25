<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../../config/db.php";

$employeeId =
    intval($_GET["employee_id"] ?? 0);

$year =
    intval($_GET["year"] ?? 2026);


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
        performance_year,
        week_number,
        score,
        created_at,
        updated_at
    FROM employee_weekly_performance
    WHERE employee_id = ?
      AND performance_year = ?
    ORDER BY week_number ASC
");

$stmt->bind_param(
    "ii",
    $employeeId,
    $year
);

$stmt->execute();

$result = $stmt->get_result();

$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}


echo json_encode([
    "success" => true,
    "data" => $rows
]);


$stmt->close();
$conn->close();

?>