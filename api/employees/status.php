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

$id = intval($data["id"] ?? 0);
$status = trim($data["status"] ?? "");

if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

if (!in_array($status, ["Active", "Inactive"])) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee status."
    ]);

    exit;
}

$stmt = $conn->prepare("
    UPDATE employees
    SET status = ?
    WHERE id = ?
");

$stmt->bind_param(
    "si",
    $status,
    $id
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Employee status updated."
    ]);

} else {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not update employee status."
    ]);
}

$stmt->close();
$conn->close();

?>