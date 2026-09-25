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

$baseCost =
    floatval($data["base_cost"] ?? 0);

$individualCost =
    floatval($data["individual_cost"] ?? 0);

$practiceCost =
    floatval($data["practice_cost"] ?? 0);

$lastYearCost =
    floatval($data["last_year_cost"] ?? 0);


/*
Loaded rate is calculated by backend
*/

$loadedRate =
    $baseCost
    + $individualCost
    + $practiceCost;


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


$stmt = $conn->prepare("
    INSERT INTO employee_loaded_cost
    (
        employee_id,
        base_cost,
        individual_cost,
        practice_cost,
        last_year_cost,
        loaded_rate
    )
    VALUES (?, ?, ?, ?, ?, ?)

    ON DUPLICATE KEY UPDATE

        base_cost = VALUES(base_cost),
        individual_cost = VALUES(individual_cost),
        practice_cost = VALUES(practice_cost),
        last_year_cost = VALUES(last_year_cost),
        loaded_rate = VALUES(loaded_rate)
");


$stmt->bind_param(
    "iddddd",
    $employeeId,
    $baseCost,
    $individualCost,
    $practiceCost,
    $lastYearCost,
    $loadedRate
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Loaded cost saved successfully.",
        "loaded_rate" => $loadedRate
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