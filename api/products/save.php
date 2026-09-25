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

$productCode =
    trim($data["product_code"] ?? "");

$productName =
    trim($data["product_name"] ?? "");


if ($employeeId <= 0) {
    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

if ($productName === "") {
    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Product name is required."
    ]);

    exit;
}


/* UPDATE */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_products
        SET
            product_code = ?,
            product_name = ?
        WHERE id = ?
        AND employee_id = ?
    ");

    $stmt->bind_param(
        "ssii",
        $productCode,
        $productName,
        $id,
        $employeeId
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Product updated successfully.",
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
    INSERT INTO employee_products
    (
        employee_id,
        product_code,
        product_name
    )
    VALUES (?, ?, ?)
");

$stmt->bind_param(
    "iss",
    $employeeId,
    $productCode,
    $productName
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Product added successfully.",
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