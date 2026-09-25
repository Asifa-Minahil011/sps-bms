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

$planType =
    trim($data["plan_type"] ?? "");

$itemKey =
    trim($data["item_key"] ?? "");

$taskName =
    trim($data["task_name"] ?? "");

$assignee =
    trim($data["assignee"] ?? "");


$allowedTypes = [
    "onboarding",
    "offboarding"
];


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if (!in_array($planType, $allowedTypes, true)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid plan type."
    ]);

    exit;
}


if ($itemKey === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Plan item key is required."
    ]);

    exit;
}


$stmt = $conn->prepare("
    INSERT INTO employee_plan_assignments
    (
        employee_id,
        plan_type,
        item_key,
        task_name,
        assignee
    )
    VALUES (?, ?, ?, ?, ?)

    ON DUPLICATE KEY UPDATE
        task_name = VALUES(task_name),
        assignee = VALUES(assignee)
");

$stmt->bind_param(
    "issss",
    $employeeId,
    $planType,
    $itemKey,
    $taskName,
    $assignee
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Plan assignment saved successfully."
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