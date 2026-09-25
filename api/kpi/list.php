<?php

header("Content-Type: application/json; charset=utf-8");

require_once "../../config/db.php";

$employeeId = intval($_GET["employee_id"] ?? 0);

$period = trim($_GET["period"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


/*
If a period is supplied,
return only that period.
Otherwise return all KPI records.
*/

if ($period !== "") {

    $stmt = $conn->prepare("
        SELECT
            id,
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
        FROM employee_kpi_records
        WHERE employee_id = ?
        AND kpi_period = ?
        ORDER BY section_type ASC, sort_order ASC, id ASC
    ");

    $stmt->bind_param(
        "is",
        $employeeId,
        $period
    );

} else {

    $stmt = $conn->prepare("
        SELECT
            id,
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
        FROM employee_kpi_records
        WHERE employee_id = ?
        ORDER BY kpi_period DESC,
                 section_type ASC,
                 sort_order ASC,
                 id ASC
    ");

    $stmt->bind_param(
        "i",
        $employeeId
    );
}


$stmt->execute();

$result =
    $stmt->get_result();

$records = [];

while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}


echo json_encode([
    "success" => true,
    "data" => $records
]);


$stmt->close();
$conn->close();

?>