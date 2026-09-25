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

$goal =
    trim($data["goal"] ?? "");

$targetDate =
    trim($data["target_date"] ?? "");

$progress =
    trim($data["progress"] ?? "");

$notes =
    trim($data["notes"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


/*
Allow empty date.
MySQL DATE should receive NULL instead of "".
*/

if ($targetDate === "") {
    $targetDate = null;
}


$stmt = $conn->prepare("
    INSERT INTO employee_development_plans
    (
        employee_id,
        goal,
        target_date,
        progress,
        notes
    )
    VALUES (?, ?, ?, ?, ?)

    ON DUPLICATE KEY UPDATE
        goal = VALUES(goal),
        target_date = VALUES(target_date),
        progress = VALUES(progress),
        notes = VALUES(notes)
");

$stmt->bind_param(
    "issss",
    $employeeId,
    $goal,
    $targetDate,
    $progress,
    $notes
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Development plan saved successfully."
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