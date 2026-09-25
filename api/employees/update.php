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

$id = intval($data["id"] ?? 0);

$name = trim($data["name"] ?? "");
$employeeType = trim($data["employee_type"] ?? "Employee");
$workStatus = trim($data["work_status"] ?? "");
$gender = trim($data["gender"] ?? "");

$email = trim($data["email"] ?? "");
$personalEmail = trim($data["personal_email"] ?? "");
$cnic = trim($data["cnic"] ?? "");

$dateOfBirth = trim($data["date_of_birth"] ?? "");

if ($dateOfBirth === "") {
    $dateOfBirth = null;
}

$residentialAddress =
    trim($data["residential_address"] ?? "");

$jobTitle =
    trim($data["job_title"] ?? "");

$businessArea =
    trim($data["business_area"] ?? "");

$linkedinUrl =
    trim($data["linkedin_url"] ?? "");

$officeNo =
    trim($data["office_no"] ?? "");

$mobileNo =
    trim($data["mobile_no"] ?? "");

$emergencyNo =
    trim($data["emergency_no"] ?? "");

$homeNo =
    trim($data["home_no"] ?? "");

$location =
    trim($data["location"] ?? "");

$officeLocation =
    trim($data["office_location"] ?? "");

$department =
    trim($data["department"] ?? "");

$employeeGroup =
    trim($data["employee_group"] ?? "");

$practice =
    trim($data["practice"] ?? "");

$hireSource =
    trim($data["hire_source"] ?? "");

$company =
    trim($data["company"] ?? "");

$educationalLevel =
    trim($data["educational_level"] ?? "");


/*
New Employee Detail fields
*/

$guardianName =
    trim($data["guardian_name"] ?? "");

$guardianContact =
    trim($data["guardian_contact"] ?? "");

$guardianAddress =
    trim($data["guardian_address"] ?? "");

$spsCorporate =
    !empty($data["sps_corporate"])
        ? 1
        : 0;


$supervisorName =
    trim($data["supervisor_name"] ?? "");

$supervisorEmail =
    trim($data["supervisor_email"] ?? "");

$status =
    trim($data["status"] ?? "Active");


if ($id <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($name === "" || $email === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Name and email are required."
    ]);

    exit;
}


/*
Check whether another employee
already has this email.
*/

$checkStmt = $conn->prepare("
    SELECT id
    FROM employees
    WHERE email = ?
      AND id <> ?
    LIMIT 1
");

$checkStmt->bind_param(
    "si",
    $email,
    $id
);

$checkStmt->execute();

$duplicate =
    $checkStmt
        ->get_result()
        ->fetch_assoc();

$checkStmt->close();


if ($duplicate) {

    http_response_code(409);

    echo json_encode([
        "success" => false,
        "message" => "Another employee already uses this email."
    ]);

    exit;
}


$stmt = $conn->prepare("
    UPDATE employees
    SET
        name = ?,
        employee_type = ?,
        work_status = ?,
        gender = ?,
        email = ?,
        personal_email = ?,
        cnic = ?,
        date_of_birth = ?,
        residential_address = ?,
        job_title = ?,
        business_area = ?,
        linkedin_url = ?,
        office_no = ?,
        mobile_no = ?,
        emergency_no = ?,
        home_no = ?,
        location = ?,
        office_location = ?,
        department = ?,
        employee_group = ?,
        practice = ?,
        hire_source = ?,
        company = ?,
        educational_level = ?,

        guardian_name = ?,
        guardian_contact = ?,
        guardian_address = ?,
        sps_corporate = ?,

        supervisor_name = ?,
        supervisor_email = ?,
        status = ?

    WHERE id = ?
");

$stmt->bind_param(
    "sssssssssssssssssssssssssssisssi",

    $name,
    $employeeType,
    $workStatus,
    $gender,
    $email,
    $personalEmail,
    $cnic,
    $dateOfBirth,
    $residentialAddress,
    $jobTitle,
    $businessArea,
    $linkedinUrl,
    $officeNo,
    $mobileNo,
    $emergencyNo,
    $homeNo,
    $location,
    $officeLocation,
    $department,
    $employeeGroup,
    $practice,
    $hireSource,
    $company,
    $educationalLevel,

    $guardianName,
    $guardianContact,
    $guardianAddress,
    $spsCorporate,

    $supervisorName,
    $supervisorEmail,
    $status,

    $id
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Employee updated successfully."
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