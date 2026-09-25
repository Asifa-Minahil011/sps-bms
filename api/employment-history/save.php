<?php

header("Content-Type: application/json");

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

$startDate =
    trim($data["start_date"] ?? "");

$endDate =
    trim($data["end_date"] ?? "");

$jobTitle =
    trim($data["job_title"] ?? "");

$corporateRole =
    trim($data["corporate_role"] ?? "");

$departmentRole =
    trim($data["department_role"] ?? "");

$functionalRole =
    trim($data["functional_role"] ?? "");

$duration =
    trim($data["duration"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($jobTitle === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Job title is required."
    ]);

    exit;
}


/*
Convert blank dates to NULL
*/

$startDate =
    $startDate !== ""
        ? $startDate
        : null;

$endDate =
    $endDate !== ""
        ? $endDate
        : null;


/* UPDATE */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_employment_history
        SET
            start_date = ?,
            end_date = ?,
            job_title = ?,
            corporate_role = ?,
            department_role = ?,
            functional_role = ?,
            duration = ?
        WHERE id = ?
        AND employee_id = ?
    ");

    $stmt->bind_param(
        "sssssssii",
        $startDate,
        $endDate,
        $jobTitle,
        $corporateRole,
        $departmentRole,
        $functionalRole,
        $duration,
        $id,
        $employeeId
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Employment history updated successfully.",
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
    INSERT INTO employee_employment_history
    (
        employee_id,
        start_date,
        end_date,
        job_title,
        corporate_role,
        department_role,
        functional_role,
        duration
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "isssssss",
    $employeeId,
    $startDate,
    $endDate,
    $jobTitle,
    $corporateRole,
    $departmentRole,
    $functionalRole,
    $duration
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Employment history added successfully.",
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