<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../../config/db.php";

$result = $conn->query("
    SELECT
        id,
        name,
        employee_type,
        work_status,
        gender,
        email,
        personal_email,
        cnic,
        date_of_birth,
        residential_address,
        job_title,
        business_area,
        linkedin_url,
        office_no,
        mobile_no,
        emergency_no,
        home_no,
        location,
        office_location,
        department,
        employee_group,
        practice,
        hire_source,
        company,
        educational_level,

        guardian_name,
        guardian_contact,
        guardian_address,
        sps_corporate,

        supervisor_name,
        supervisor_email,
        status,

        created_at,
        updated_at

    FROM employees
    ORDER BY name ASC
");

if (!$result) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);

    exit;
}

$employees = [];

while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $employees
]);

$conn->close();

?>