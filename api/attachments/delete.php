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


$data =
    json_decode(
        file_get_contents("php://input"),
        true
    );


$id =
    intval($data["id"] ?? 0);


if ($id <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid attachment ID."
    ]);

    exit;
}


/*
Find the file first
*/

$stmt = $conn->prepare("
    SELECT
        stored_file_name
    FROM employee_attachments
    WHERE id = ?
    LIMIT 1
");

$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();

$result =
    $stmt->get_result();

$attachment =
    $result->fetch_assoc();

$stmt->close();


if (!$attachment) {

    http_response_code(404);

    echo json_encode([
        "success" => false,
        "message" => "Attachment not found."
    ]);

    $conn->close();

    exit;
}


/*
Delete database row
*/

$stmt = $conn->prepare("
    DELETE FROM employee_attachments
    WHERE id = ?
");

$stmt->bind_param(
    "i",
    $id
);


if ($stmt->execute()) {

    $physicalPath =
        "../../uploads/employee-attachments/"
        . basename(
            $attachment["stored_file_name"]
        );


    if (file_exists($physicalPath)) {
        unlink($physicalPath);
    }


    echo json_encode([
        "success" => true,
        "message" => "Attachment deleted successfully."
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