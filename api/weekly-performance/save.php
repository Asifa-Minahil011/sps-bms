<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../../config/db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Only POST requests are allowed."
    ]);

    exit;
}


$data = json_decode(
    file_get_contents("php://input"),
    true
);


if (!$data) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Invalid request data."
    ]);

    exit;
}


$employeeId =
    intval($data["employee_id"] ?? 0);

$year =
    intval($data["performance_year"] ?? 2026);

$weekNumber =
    intval($data["week_number"] ?? 0);

$score =
    floatval($data["score"] ?? 0);


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($weekNumber <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Week number must be greater than 0."
    ]);

    exit;
}


if ($score < 0 || $score > 100) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Score must be between 0 and 100."
    ]);

    exit;
}


$stmt = $conn->prepare("
    INSERT INTO employee_weekly_performance
    (
        employee_id,
        performance_year,
        week_number,
        score
    )
    VALUES (?, ?, ?, ?)

    ON DUPLICATE KEY UPDATE
        score = VALUES(score)
");


$stmt->bind_param(
    "iiid",
    $employeeId,
    $year,
    $weekNumber,
    $score
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Weekly performance saved successfully."
    ]);

} else {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $stmt->error
    ]);
}


$stmt->close();
$conn->close();

?>