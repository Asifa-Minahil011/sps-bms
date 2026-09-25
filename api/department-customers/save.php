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

$customerCode =
    trim($data["customer_code"] ?? "");

$customerName =
    trim($data["customer_name"] ?? "");


if ($employeeId <= 0) {
    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

if ($customerName === "") {
    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Customer name is required."
    ]);

    exit;
}


/* UPDATE */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_department_customers
        SET
            customer_code = ?,
            customer_name = ?
        WHERE id = ?
        AND employee_id = ?
    ");

    $stmt->bind_param(
        "ssii",
        $customerCode,
        $customerName,
        $id,
        $employeeId
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Department customer updated successfully.",
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
    INSERT INTO employee_department_customers
    (
        employee_id,
        customer_code,
        customer_name
    )
    VALUES (?, ?, ?)
");

$stmt->bind_param(
    "iss",
    $employeeId,
    $customerCode,
    $customerName
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Department customer added successfully.",
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