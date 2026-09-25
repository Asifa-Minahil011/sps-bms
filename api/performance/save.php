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

$year =
    intval($data["performance_year"] ?? 0);


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($year <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid performance year."
    ]);

    exit;
}


/*
Chart arrays
*/

$revenueMargin =
    json_encode(
        is_array($data["revenue_margin"] ?? null)
            ? $data["revenue_margin"]
            : []
    );

$utilization =
    json_encode(
        is_array($data["utilization"] ?? null)
            ? $data["utilization"]
            : []
    );

$certifications =
    json_encode(
        is_array($data["certifications"] ?? null)
            ? $data["certifications"]
            : []
    );

$communicationScore =
    json_encode(
        is_array($data["communication_score"] ?? null)
            ? $data["communication_score"]
            : []
    );


$performanceChoice =
    trim(
        $data["performance_choice"] ?? ""
    );

$performanceDimension =
    trim(
        $data["performance_dimension"] ?? ""
    );


$stmt = $conn->prepare("
    INSERT INTO employee_performance
    (
        employee_id,
        performance_year,
        revenue_margin,
        utilization,
        certifications,
        communication_score,
        performance_choice,
        performance_dimension
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)

    ON DUPLICATE KEY UPDATE
        revenue_margin = VALUES(revenue_margin),
        utilization = VALUES(utilization),
        certifications = VALUES(certifications),
        communication_score = VALUES(communication_score),
        performance_choice = VALUES(performance_choice),
        performance_dimension = VALUES(performance_dimension)
");


$stmt->bind_param(
    "iissssss",
    $employeeId,
    $year,
    $revenueMargin,
    $utilization,
    $certifications,
    $communicationScore,
    $performanceChoice,
    $performanceDimension
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Performance saved successfully."
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