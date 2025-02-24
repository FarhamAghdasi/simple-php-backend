<?php

header('Content-Type: application/json');

require_once '../db.php';
require_once '../helper.php';

$token = $_GET['token'];
$user = getUserByToken($conn , $token);

if (!$user) {
    SendMessage(401,'error','invalid token');
    exit;
}

if (!isset($_FILES['file'])) {
    SendMessage(401,'error','Not Image Uploaded');
    exit;
}

$file = $_FILES['file'];
$allowed = ['png','jpg','jpeg'];
$ext = strtolower(pathinfo($file['name'] , PATHINFO_EXTENSION));

if (!in_array($ext , $allowed)) {
    SendMessage(500, 'error' , 'not allowed image EXTENSION');
    exit;
}

$uploadDir = './uploads/';


if(!is_dir($uploadDir)) {
    mkdir($uploadDir , 0777 , true);
}

$unicname =  uniqid() ."." .  $ext;
$finnaly_folder = $uploadDir . $unicname;

$maxSize = 1 * 1024 * 1024; 

if ($file['size'] > $maxSize) {
    SendMessage(400, 'error', 'File size exceeds the maximum allowed limit of 1 MB');
    exit;
}

if (move_uploaded_file($file['tmp_name'] , $finnaly_folder)) {
    $file_size = filesize($finnaly_folder);
    $sql = "INSERT INTO images (address,size) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si" , $finnaly_folder , $file_size);
    if ($stmt->execute())  {
        http_response_code(201);
        echo json_encode([
            'message' => 'image uploded',
            'data' => ['address' => $finnaly_folder , 'size' => $file_size]
        ]);
        exit;
    } else {
        SendMessage(500 , 'error' , 'database error');
        exit;
    }

} else {
    SendMessage(500,'error','error with uploading file');
    exit;
}