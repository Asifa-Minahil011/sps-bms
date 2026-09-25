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

$id =
    intval($data["id"] ?? 0);

$employeeId =
    intval($data["employee_id"] ?? 0);

$workDate =
    trim($data["work_date"] ?? "");

$client =
    trim($data["client"] ?? "");

$project =
    trim($data["project"] ?? "");

$task =
    trim($data["task"] ?? "");

$description =
    trim($data["description"] ?? "");

$hours =
    floatval($data["hours"] ?? 0);


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($workDate === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Work date is required."
    ]);

    exit;
}


if ($hours < 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Hours cannot be negative."
    ]);

    exit;
}


/*
Update existing row
*/

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_timelive
        SET
            work_date = ?,
            client = ?,
            project = ?,
            task = ?,
            description = ?,
            hours = ?
        WHERE id = ?
          AND employee_id = ?
    ");

    $stmt->bind_param(
        "sssssdi i",
        $workDate,
        $client,
        $project,
        $task,
        $description,
        $hours,
        $id,
        $employeeId
    );

} else {

    /*
    Add new row
    */

    $stmt = $conn->prepare("
        INSERT INTO employee_timelive
        (
            employee_id,
            work_date,
            client,
            project,
            task,
            description,
            hours
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isssssd",
        $employeeId,
        $workDate,
        $client,
        $project,
        $task,
        $description,
        $hours
    );
}


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "TimeLive entry saved successfully.",
        "id" => $id > 0
            ? $id
            : $conn->insert_id
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