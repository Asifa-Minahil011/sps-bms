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

$projectCode =
    trim($data["project_code"] ?? "");

$projectName =
    trim($data["project_name"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($projectName === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Project name is required."
    ]);

    exit;
}


/* UPDATE */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_projects
        SET
            project_code = ?,
            project_name = ?
        WHERE id = ?
        AND employee_id = ?
    ");

    $stmt->bind_param(
        "ssii",
        $projectCode,
        $projectName,
        $id,
        $employeeId
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Project updated successfully.",
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
    INSERT INTO employee_projects
    (
        employee_id,
        project_code,
        project_name
    )
    VALUES (?, ?, ?)
");

$stmt->bind_param(
    "iss",
    $employeeId,
    $projectCode,
    $projectName
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Project added successfully.",
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