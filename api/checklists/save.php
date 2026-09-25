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

$employeeId = intval(
    $data["employee_id"] ?? 0
);

$checklistType = trim(
    $data["checklist_type"] ?? ""
);

$records =
    $data["records"] ?? [];


$allowedTypes = [
    "onboarding_checklist",
    "onboarding_steps",
    "offboarding_checklist"
];


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if (!in_array($checklistType, $allowedTypes, true)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid checklist type."
    ]);

    exit;
}


if (!is_array($records)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid checklist data."
    ]);

    exit;
}


$conn->begin_transaction();

try {

    /*
    Remove the current saved checklist
    for this employee + checklist type.
    */

    $deleteStmt = $conn->prepare("
        DELETE FROM employee_checklists
        WHERE employee_id = ?
          AND checklist_type = ?
    ");

    $deleteStmt->bind_param(
        "is",
        $employeeId,
        $checklistType
    );

    $deleteStmt->execute();
    $deleteStmt->close();


    /*
    Insert the latest checklist values.
    */

    $insertStmt = $conn->prepare("
        INSERT INTO employee_checklists
        (
            employee_id,
            checklist_type,
            item_key,
            item_label,
            choice_value,
            note
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ");


    foreach ($records as $record) {

        $itemKey = trim(
            $record["item_key"] ?? ""
        );

        $itemLabel = trim(
            $record["item_label"] ?? ""
        );

        $choiceValue = trim(
            $record["choice_value"] ?? ""
        );

        $note = trim(
            $record["note"] ?? ""
        );


        if ($itemKey === "") {
            continue;
        }


        $insertStmt->bind_param(
            "isssss",
            $employeeId,
            $checklistType,
            $itemKey,
            $itemLabel,
            $choiceValue,
            $note
        );

        $insertStmt->execute();
    }


    $insertStmt->close();

    $conn->commit();


    echo json_encode([
        "success" => true,
        "message" => "Checklist saved successfully."
    ]);


} catch (Throwable $e) {

    $conn->rollback();

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not save checklist."
    ]);
}


$conn->close();

?>