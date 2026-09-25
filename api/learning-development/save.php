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

$courseName =
    trim($data["course_name"] ?? "");

$trainingTaken =
    trim($data["training_taken"] ?? "");

$testTaken =
    trim($data["test_taken"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($courseName === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Course name is required."
    ]);

    exit;
}


/* UPDATE */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_learning_development
        SET
            course_name = ?,
            training_taken = ?,
            test_taken = ?
        WHERE id = ?
        AND employee_id = ?
    ");

    $stmt->bind_param(
        "sssii",
        $courseName,
        $trainingTaken,
        $testTaken,
        $id,
        $employeeId
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Learning record updated successfully.",
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
    INSERT INTO employee_learning_development
    (
        employee_id,
        course_name,
        training_taken,
        test_taken
    )
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param(
    "isss",
    $employeeId,
    $courseName,
    $trainingTaken,
    $testTaken
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Learning record added successfully.",
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