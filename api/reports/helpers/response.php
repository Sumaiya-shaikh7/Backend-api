<?php
header("Content-Type: application/json");

function sendJSON($status, $message, $data = []) {
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ], JSON_PRETTY_PRINT);
    exit;
}
