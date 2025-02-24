<?php

header('Content-Type: application/json');

require_once './db.php';
require_once './helper.php';

CheckMethod("POST");

$input = json_decode(file_get_contents("php://input") , true);

if (!isset($input['username']) || !isset($input['password'])) {
    SendMessage(400,'error','please fill out values');
    exit;
}

$username = $input['username']; 
$password = $input['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s',$username);
$stmt->execute();
$users = $stmt->get_result()->fetch_assoc();

if (!$users) {
    /** Sign Up */
    $sql = "INSERT INTO users (username,password) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss" , $username , password_hash($password , PASSWORD_DEFAULT));
    
    if ($stmt->execute()) {
        SendMessage(201,'message','user registered');
        exit;
    } else {
        SendMessage(500,'error','error with sending data to database');
        exit;
    }
} else {
    /** Login */
    if (password_verify($password , $users['password'])) {
        $token = bin2hex(random_bytes(15));
        $sql = "UPDATE users SET token = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si',$token , $users['id']);
        if ($stmt->execute()) {
            SendMessage(201,'token',$token);
            exit;
        } else {
            SendMessage(500,'error','cannot login');
            exit;
        }
    }
}
