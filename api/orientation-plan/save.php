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

$records =
    $data["records"] ?? [];


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

if (!is_array($records)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid orientation plan data."
    ]);

    exit;
}

$conn->begin_transaction();

try {

    $deleteStmt = $conn->prepare("
        DELETE FROM employee_orientation_plan
        WHERE employee_id = ?
    ");

    $deleteStmt->bind_param(
        "i",
        $employeeId
    );

    $deleteStmt->execute();
    $deleteStmt->close();


    $insertStmt = $conn->prepare("
        INSERT INTO employee_orientation_plan
        (
            employee_id,
            module_key,
            module_name,
            orientation_day,
            orientation_date,
            duration,
            feedback
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");


    foreach ($records as $record) {

        $moduleKey =
            trim($record["module_key"] ?? "");

        $moduleName =
            trim($record["module_name"] ?? "");

        $orientationDay =
            trim($record["orientation_day"] ?? "");

        $orientationDate =
            trim($record["orientation_date"] ?? "");

        $duration =
            trim($record["duration"] ?? "");

        $feedback =
            trim($record["feedback"] ?? "");


        if ($moduleKey === "" || $moduleName === "") {
            continue;
        }


        if ($orientationDate === "") {
            $orientationDate = null;
        }


        $insertStmt->bind_param(
            "issssss",
            $employeeId,
            $moduleKey,
            $moduleName,
            $orientationDay,
            $orientationDate,
            $duration,
            $feedback
        );

        $insertStmt->execute();
    }


    $insertStmt->close();

    $conn->commit();


    echo json_encode([
        "success" => true,
        "message" => "Orientation plan saved successfully."
    ]);


} catch (Throwable $e) {

    $conn->rollback();

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not save orientation plan."
    ]);
}


$conn->close();

?>