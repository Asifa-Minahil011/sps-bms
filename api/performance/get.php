<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../../config/db.php";

$employeeId =
    intval($_GET["employee_id"] ?? 0);

$year =
    intval($_GET["year"] ?? 0);


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($year <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid performance year."
    ]);

    exit;
}


$stmt = $conn->prepare("
    SELECT
        id,
        employee_id,
        performance_year,
        revenue_margin,
        utilization,
        certifications,
        communication_score,
        performance_choice,
        performance_dimension,
        created_at,
        updated_at
    FROM employee_performance
    WHERE employee_id = ?
      AND performance_year = ?
    LIMIT 1
");

$stmt->bind_param(
    "ii",
    $employeeId,
    $year
);

$stmt->execute();

$result = $stmt->get_result();

$data = $result->fetch_assoc();


if ($data) {

    $data["revenue_margin"] =
        json_decode(
            $data["revenue_margin"] ?? "[]",
            true
        ) ?: [];

    $data["utilization"] =
        json_decode(
            $data["utilization"] ?? "[]",
            true
        ) ?: [];

    $data["certifications"] =
        json_decode(
            $data["certifications"] ?? "[]",
            true
        ) ?: [];

    $data["communication_score"] =
        json_decode(
            $data["communication_score"] ?? "[]",
            true
        ) ?: [];
}


echo json_encode([
    "success" => true,
    "data" => $data
]);


$stmt->close();
$conn->close();

?>