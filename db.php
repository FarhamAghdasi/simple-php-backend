<?php

include './helper.php';

$servername = "localhost";
$username = "root";
$password = "";
$db_name = 'backend';

$conn = new mysqli($servername , $username , $password, $db_name);

if ($conn->connect_error) {
    SendMessage(500,'error',"error with connecting to db");
    exit;
}

$conn->set_charset("utf8mb4");