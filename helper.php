<?php

function SendMessage($http_code , $status , $message) {
    http_response_code($http_code);
    echo json_encode([$status => $message]);
}

function CheckMethod($methodname) {
    if ($_SERVER['REQUEST_METHOD'] !== $methodname) {
        SendMessage(405,"error","invalid method");
        exit;
    }
}

function CheckToken() {
    if (!isset($_GET['token'])) {
        SendMessage(401,'error','Unauthorized, token required');
        exit;
    }
}

function CheckID() {
    if (!isset($_GET['id'])) {
        SendMessage(401,'error','Unauthorized, id required');
        exit;
    }
}

function getUserByToken($conn , $token) {
    $sql = "SELECT * FROM users WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s" , $token);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}