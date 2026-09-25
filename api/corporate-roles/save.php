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

$id = intval($data["id"] ?? 0);

$employeeId =
    intval($data["employee_id"] ?? 0);

$role =
    trim($data["role"] ?? "");

$level =
    trim($data["level"] ?? "");

$levelTitle =
    trim($data["level_title"] ?? "");

$rankValue =
    trim($data["rank_value"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($role === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Role is required."
    ]);

    exit;
}


/* UPDATE existing role */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_corporate_roles
        SET
            role = ?,
            level = ?,
            level_title = ?,
            rank_value = ?
        WHERE id = ?
        AND employee_id = ?
    ");

    $stmt->bind_param(
        "ssssii",
        $role,
        $level,
        $levelTitle,
        $rankValue,
        $id,
        $employeeId
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Corporate role updated successfully.",
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


/* INSERT new role */

$stmt = $conn->prepare("
    INSERT INTO employee_corporate_roles
    (
        employee_id,
        role,
        level,
        level_title,
        rank_value
    )
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issss",
    $employeeId,
    $role,
    $level,
    $levelTitle,
    $rankValue
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Corporate role added successfully.",
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