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

$addedBy =
    trim($data["added_by"] ?? "");

$speaking =
    trim($data["speaking"] ?? "");

$writing =
    trim($data["writing"] ?? "");

$listening =
    trim($data["listening"] ?? "");

$recordDate =
    trim($data["record_date"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($recordDate === "") {
    $recordDate = null;
}


/* UPDATE */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_communication_skills
        SET
            added_by = ?,
            speaking = ?,
            writing = ?,
            listening = ?,
            record_date = ?
        WHERE id = ?
        AND employee_id = ?
    ");

    $stmt->bind_param(
        "sssssii",
        $addedBy,
        $speaking,
        $writing,
        $listening,
        $recordDate,
        $id,
        $employeeId
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Communication skill updated successfully.",
            "id" => $id
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

    exit;
}


/* INSERT */

$stmt = $conn->prepare("
    INSERT INTO employee_communication_skills
    (
        employee_id,
        added_by,
        speaking,
        writing,
        listening,
        record_date
    )
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "isssss",
    $employeeId,
    $addedBy,
    $speaking,
    $writing,
    $listening,
    $recordDate
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Communication skill added successfully.",
        "id" => $conn->insert_id
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