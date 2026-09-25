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


$employeeId =
    intval($_POST["employee_id"] ?? 0);

$title =
    trim($_POST["title"] ?? "");


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
        "message" => "Attachment title is required."
    ]);

    exit;
}


if (
    !isset($_FILES["file"]) ||
    $_FILES["file"]["error"] !== UPLOAD_ERR_OK
) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "Please select a valid file."
    ]);

    exit;
}


$file =
    $_FILES["file"];


$maxSize =
    10 * 1024 * 1024;


/* Maximum 10 MB */

if ($file["size"] > $maxSize) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "File must be 10 MB or smaller."
    ]);

    exit;
}


$originalFileName =
    basename($file["name"]);

$extension =
    strtolower(
        pathinfo(
            $originalFileName,
            PATHINFO_EXTENSION
        )
    );


$allowedExtensions = [
    "pdf",
    "doc",
    "docx",
    "jpg",
    "jpeg",
    "png",
    "txt"
];


if (!in_array(
    $extension,
    $allowedExtensions,
    true
)) {

    http_response_code(422);

    echo json_encode([
        "success" => false,
        "message" => "File type not allowed."
    ]);

    exit;
}


/*
Create a safe random stored filename.
We do NOT use the user's original filename
for physical storage.
*/

$storedFileName =
    bin2hex(random_bytes(16))
    . "."
    . $extension;


/*
Physical upload folder
*/

$uploadDirectory =
    "../../uploads/employee-attachments/";


if (!is_dir($uploadDirectory)) {

    mkdir(
        $uploadDirectory,
        0775,
        true
    );
}


$physicalPath =
    $uploadDirectory
    . $storedFileName;


/*
Path saved in database.
This path can later be used by the frontend.
*/

$databasePath =
    "uploads/employee-attachments/"
    . $storedFileName;


if (!move_uploaded_file(
    $file["tmp_name"],
    $physicalPath
)) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not save uploaded file."
    ]);

    exit;
}


$fileType =
    $file["type"] ?? "";

$fileSize =
    intval($file["size"]);


$stmt = $conn->prepare("
    INSERT INTO employee_attachments
    (
        employee_id,
        title,
        original_file_name,
        stored_file_name,
        file_path,
        file_type,
        file_size
    )
    VALUES (?, ?, ?, ?, ?, ?, ?)
");


$stmt->bind_param(
    "isssssi",
    $employeeId,
    $title,
    $originalFileName,
    $storedFileName,
    $databasePath,
    $fileType,
    $fileSize
);


if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Attachment uploaded successfully.",
        "id" => $conn->insert_id,
        "file_path" => $databasePath
    ]);

} else {

    /*
    If database insert fails,
    remove the uploaded physical file.
    */

    if (file_exists($physicalPath)) {
        unlink($physicalPath);
    }

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $stmt->error
    ]);
}


$stmt->close();
$conn->close();

?>