<?php
header("Content-Type: application/json");
date_default_timezone_set('Asia/Kolkata');

// DB CREDENTIALS
$host = "localhost";
$user = "root";
$pass = "";
$db   = "";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    echo json_encode(["status"=>0, "message"=>"Database connection failed"]);
    die();
}
?>
