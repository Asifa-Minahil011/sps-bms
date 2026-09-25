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

$name = trim($data["name"] ?? "");
$employeeType = trim($data["employee_type"] ?? "Employee");
$workStatus = trim($data["work_status"] ?? "Full Time");
$email = trim($data["email"] ?? "");
$mobileNo = trim($data["mobile_no"] ?? "");
$location = trim($data["location"] ?? "");
$department = trim($data["department"] ?? "");
$employeeGroup = trim($data["employee_group"] ?? "");
$practice = trim($data["practice"] ?? "");
$supervisorName = trim($data["supervisor_name"] ?? "");
$status = trim($data["status"] ?? "Active");


/* Required fields */

if ($name === "" || $email === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Name and email are required."
    ]);

    exit;
}


/* Validate email */

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Please enter a valid email address."
    ]);

    exit;
}


/* Check duplicate email */

$check = $conn->prepare("
    SELECT id
    FROM employees
    WHERE email = ?
    LIMIT 1
");

$check->bind_param(
    "s",
    $email
);

$check->execute();

$existing = $check->get_result();

if ($existing->num_rows > 0) {

    http_response_code(409);

    echo json_encode([
        "success" => false,
        "message" => "An employee with this email already exists."
    ]);

    $check->close();
    $conn->close();

    exit;
}

$check->close();


/* Insert employee */

$stmt = $conn->prepare("
    INSERT INTO employees (
        name,
        employee_type,
        work_status,
        email,
        mobile_no,
        location,
        department,
        employee_group,
        practice,
        supervisor_name,
        status
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssssssss",
    $name,
    $employeeType,
    $workStatus,
    $email,
    $mobileNo,
    $location,
    $department,
    $employeeGroup,
    $practice,
    $supervisorName,
    $status
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Employee added successfully.",
        "id" => $conn->insert_id
    ]);

} else {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Failed to add employee."
    ]);
}

$stmt->close();

$conn->close();

?>