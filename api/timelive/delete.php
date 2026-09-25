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

$id =
    intval($data["id"] ?? 0);

$employeeId =
    intval($data["employee_id"] ?? 0);


if ($id <= 0 || $employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid TimeLive entry."
    ]);

    exit;
}


$stmt = $conn->prepare("
    DELETE FROM employee_timelive
    WHERE id = ?
      AND employee_id = ?
");

$stmt->bind_param(
    "ii",
    $id,
    $employeeId
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "TimeLive entry deleted successfully."
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