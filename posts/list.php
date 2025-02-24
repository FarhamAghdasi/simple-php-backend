<?php

require_once '../db.php';
require_once '../helper.php';

CheckMethod('POST');
CheckID();
CheckToken();

$token = $_GET['token'];
$id = $_GET['id'];
$user = getUserByToken($conn , $token);

if (!$user) {
    SendMessage(401,'error','invalid token');
    exit;
}

$sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii' , $id , $user['id']);

if ($stmt->execute()) {
    SendMessage(200 ,'data' , $stmt->get_result()->fetch_assoc());
} else {
    SendMessage(500,'error','cannot get data from db');
}