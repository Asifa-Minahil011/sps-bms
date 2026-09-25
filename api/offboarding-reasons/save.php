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

$reasons =
    $data["reasons"] ?? [];


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if (!is_array($reasons)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid reasons data."
    ]);

    exit;
}


$conn->begin_transaction();

try {

    /*
    Delete previous selected reasons.
    */

    $deleteStmt = $conn->prepare("
        DELETE FROM employee_offboarding_reasons
        WHERE employee_id = ?
    ");

    $deleteStmt->bind_param(
        "i",
        $employeeId
    );

    $deleteStmt->execute();
    $deleteStmt->close();


    /*
    Insert currently selected reasons.
    */

    $insertStmt = $conn->prepare("
        INSERT INTO employee_offboarding_reasons
        (
            employee_id,
            reason
        )
        VALUES (?, ?)
    ");


    foreach ($reasons as $reason) {

        $reason = trim($reason);

        if ($reason === "") {
            continue;
        }

        $insertStmt->bind_param(
            "is",
            $employeeId,
            $reason
        );

        $insertStmt->execute();
    }


    $insertStmt->close();

    $conn->commit();


    echo json_encode([
        "success" => true,
        "message" => "Offboarding reasons saved successfully."
    ]);


} catch (Throwable $e) {

    $conn->rollback();

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not save offboarding reasons."
    ]);
}


$conn->close();

?>