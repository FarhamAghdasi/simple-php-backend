<?php

require_once '../db.php';
require_once '../helper.php';

CheckMethod('POST');
CheckToken();

$token = $_GET['token'];
$user = getUserByToken($conn, $token);

if (!$user) {
    SendMessage(500, 'error', 'invalid token');
}

$sql = "SELECT address,size FROM images";
$result = $conn->query($sql);
$images = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
    SendMessage(201,'data',$images);
} else {
    SendMessage(500,'error','image not found');
}
