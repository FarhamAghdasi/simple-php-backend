<?php
header('Content-Type: application/json');

require_once '../db.php';
require_once '../helper.php';

CheckMethod("POST");
CheckToken();

$input = json_decode(file_get_contents("php://input") , true);
$token = $_GET['token'];
$user = getUserByToken($conn , $token);

if (!$user) {
    SendMessage(401,'error','invalid token');
    exit;
}

if (!isset($input['title']) || !isset($input['description'])) {
    SendMessage(500,'error','please fill out form');
    exit;
}

$title = $input['title'];
$description = $input['description'];

$stmt = $conn->prepare("INSERT INTO posts (user_id,title,description) VALUES (?,?,?)");
$stmt->bind_param('iss' , $user['id'] ,$title , $description);

if ($stmt->execute()) {
    $postid = $conn->insert_id;
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt->bind_param('i' , $postid);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_assoc();
        SendMessage(201,'data',$result);
        exit;
    }
} else {
    SendMessage(500,'error','error with sending data');
    exit;
}