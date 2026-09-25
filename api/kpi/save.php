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


$id =
    intval($data["id"] ?? 0);

$employeeId =
    intval($data["employee_id"] ?? 0);

$kpiPeriod =
    trim($data["kpi_period"] ?? "2026 · Q1");

$sectionType =
    trim($data["section_type"] ?? "");

$department =
    trim($data["department"] ?? "");

$groupName =
    trim($data["group_name"] ?? "");

$practice =
    trim($data["practice"] ?? "");

$vendor =
    trim($data["vendor"] ?? "");

$name =
    trim($data["name"] ?? "");

$practiceMultiplier =
    trim($data["practice_multiplier"] ?? "");

$percentMultiplier =
    trim($data["percent_multiplier"] ?? "");

$kpiTarget =
    trim($data["kpi_target"] ?? "");

$kpiActual =
    trim($data["kpi_actual"] ?? "");

$bonusTarget =
    trim($data["bonus_target"] ?? "");

$bonusActual =
    trim($data["bonus_actual"] ?? "");

$plan =
    trim($data["plan"] ?? "");

$sortOrder =
    intval($data["sort_order"] ?? 0);


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


$allowedSections = [
    "personalLeadership",
    "vendors",
    "matrixProducts",
    "services",
    "practices",
    "customers",
    "partners"
];


if (!in_array(
    $sectionType,
    $allowedSections,
    true
)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid KPI section."
    ]);

    exit;
}


/* UPDATE */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_kpi_records
        SET
            kpi_period = ?,
            section_type = ?,
            department = ?,
            group_name = ?,
            practice = ?,
            vendor = ?,
            name = ?,
            practice_multiplier = ?,
            percent_multiplier = ?,
            kpi_target = ?,
            kpi_actual = ?,
            bonus_target = ?,
            bonus_actual = ?,
            plan = ?,
            sort_order = ?
        WHERE id = ?
        AND employee_id = ?
    ");


    $stmt->bind_param(
        "ssssssssssssssiii",
        $kpiPeriod,
        $sectionType,
        $department,
        $groupName,
        $practice,
        $vendor,
        $name,
        $practiceMultiplier,
        $percentMultiplier,
        $kpiTarget,
        $kpiActual,
        $bonusTarget,
        $bonusActual,
        $plan,
        $sortOrder,
        $id,
        $employeeId
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "KPI record updated successfully.",
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
    INSERT INTO employee_kpi_records
    (
        employee_id,
        kpi_period,
        section_type,
        department,
        group_name,
        practice,
        vendor,
        name,
        practice_multiplier,
        percent_multiplier,
        kpi_target,
        kpi_actual,
        bonus_target,
        bonus_actual,
        plan,
        sort_order
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");


$stmt->bind_param(
    "issssssssssssssi",
    $employeeId,
    $kpiPeriod,
    $sectionType,
    $department,
    $groupName,
    $practice,
    $vendor,
    $name,
    $practiceMultiplier,
    $percentMultiplier,
    $kpiTarget,
    $kpiActual,
    $bonusTarget,
    $bonusActual,
    $plan,
    $sortOrder
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "KPI record added successfully.",
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