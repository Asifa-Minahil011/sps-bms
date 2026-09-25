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

$content =
    trim($data["content"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($content === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Blog content is required."
    ]);

    exit;
}


$stmt = $conn->prepare("
    INSERT INTO employee_blog_entries
    (
        employee_id,
        content
    )
    VALUES (?, ?)
");

$stmt->bind_param(
    "is",
    $employeeId,
    $content
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Blog entry saved successfully.",
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