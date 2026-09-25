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

$vendor =
    trim($data["vendor"] ?? "");

$badgeGroup =
    trim($data["badge_group"] ?? "");

$practice =
    trim($data["practice"] ?? "");

$product =
    trim($data["product"] ?? "");

$title =
    trim($data["title"] ?? "");

$badgeUrl =
    trim($data["badge_url"] ?? "");

$completedOn =
    trim($data["completed_on"] ?? "");


if ($employeeId <= 0) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Invalid employee ID."
    ]);

    exit;
}


if ($title === "") {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Badge title is required."
    ]);

    exit;
}


if ($completedOn === "") {
    $completedOn = null;
}


/* UPDATE */

if ($id > 0) {

    $stmt = $conn->prepare("
        UPDATE employee_badges
        SET
            vendor = ?,
            badge_group = ?,
            practice = ?,
            product = ?,
            title = ?,
            badge_url = ?,
            completed_on = ?
        WHERE id = ?
        AND employee_id = ?
    ");

    $stmt->bind_param(
        "sssssssii",
        $vendor,
        $badgeGroup,
        $practice,
        $product,
        $title,
        $badgeUrl,
        $completedOn,
        $id,
        $employeeId
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Badge updated successfully.",
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
    INSERT INTO employee_badges
    (
        employee_id,
        vendor,
        badge_group,
        practice,
        product,
        title,
        badge_url,
        completed_on
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "isssssss",
    $employeeId,
    $vendor,
    $badgeGroup,
    $practice,
    $product,
    $title,
    $badgeUrl,
    $completedOn
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Badge added successfully.",
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