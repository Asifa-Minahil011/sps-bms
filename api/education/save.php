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

$employeeId =
    intval($data["employee_id"] ?? 0);

$university =
    trim($data["university"] ?? "");

$fieldOfStudy =
    trim($data["field_of_study"] ?? "");

$passingYear =
    trim($data["passing_year"] ?? "");

$course =
    trim($data["course"] ?? "");

$gradeGpa =
    trim($data["grade_gpa"] ?? "");

if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}

$stmt = $conn->prepare("
    INSERT INTO employee_education (
        employee_id,
        university,
        field_of_study,
        passing_year,
        course,
        grade_gpa
    )
    VALUES (?, ?, ?, ?, ?, ?)

    ON DUPLICATE KEY UPDATE

        university = VALUES(university),
        field_of_study = VALUES(field_of_study),
        passing_year = VALUES(passing_year),
        course = VALUES(course),
        grade_gpa = VALUES(grade_gpa)
");

$stmt->bind_param(
    "isssss",
    $employeeId,
    $university,
    $fieldOfStudy,
    $passingYear,
    $course,
    $gradeGpa
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Education saved successfully."
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