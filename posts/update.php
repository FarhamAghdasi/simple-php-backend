<?php
header('Content-Type: application/json');

require_once '../db.php';
require_once '../helper.php';

CheckMethod('PATCH');
CheckToken();
CheckID();

$input = json_decode(file_get_contents("php://input") , true);

$token = $_GET['token'];
$id = $_GET['id'];
$user = getUserByToken($conn , $token);

if (!$user) {
    SendMessage(401,'error','invalid token');
    exit;
}

if (!isset($input['title']) || !isset($input['description'])) {
    SendMessage(401 , 'error' , 'please fill values');
    exit;
}

$title = $input['title'];
$description = $input['description'];

$sql = "UPDATE posts SET title = ? , description = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii",$title , $description ,$id , $user['id']);
if ($stmt->execute()) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i' , $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result()->fetch_assoc();
        SendMessage(201,'data',$result);
        exit;
    } else {
        SendMessage(500,'error','cannot send updated details');
    }
} else {
    SendMessage(500,'error','faild update post');
}