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
        "message" => "Invalid hours data."
    ]);

    exit;
}


/*
Start transaction
*/

$conn->begin_transaction();

try {

    /*
    Clear current distribution for this employee.
    Then insert the latest values from the UI.
    */

    $deleteStmt = $conn->prepare("
        DELETE FROM employee_hours_distribution
        WHERE employee_id = ?
    ");

    $deleteStmt->bind_param(
        "i",
        $employeeId
    );

    $deleteStmt->execute();

    $deleteStmt->close();


    $insertStmt = $conn->prepare("
        INSERT INTO employee_hours_distribution
        (
            employee_id,
            department,
            group_name,
            practice,
            hours
        )
        VALUES (?, ?, ?, ?, ?)
    ");


    foreach ($records as $record) {

        $department =
            trim($record["department"] ?? "");

        $groupName =
            trim($record["group_name"] ?? "");

        $practice =
            trim($record["practice"] ?? "");

        $hours =
            floatval($record["hours"] ?? 0);


        if (
            $department === "" ||
            $groupName === "" ||
            $practice === ""
        ) {
            continue;
        }


        /*
        Don't store empty / zero rows.
        */

        if ($hours <= 0) {
            continue;
        }


        $insertStmt->bind_param(
            "isssd",
            $employeeId,
            $department,
            $groupName,
            $practice,
            $hours
        );

        $insertStmt->execute();
    }


    $insertStmt->close();

    $conn->commit();


    echo json_encode([
        "success" => true,
        "message" => "Hours distribution saved successfully."
    ]);


} catch (Throwable $e) {

    $conn->rollback();

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not save hours distribution."
    ]);
}


$conn->close();

?>