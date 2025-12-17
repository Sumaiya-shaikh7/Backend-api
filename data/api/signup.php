<?php
require_once "../core/env.php";
loadEnv(__DIR__ . "/../.env");

function generateApiKey($email) {
    $secret = $_ENV["SECRET_KEY"];
    $random = bin2hex(random_bytes(16));
    return hash_hmac("sha256", $email . $random, $secret);
}

$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? "";
$pass = $data["password"] ?? "";
$role = $data["role"] ?? "user";

$users = json_decode(file_get_contents("../data/users.json"), true);
foreach ($users as $u) {
    if ($u["email"] === $email) {
        echo json_encode(["status"=>"error","message"=>"Email already exists"]);
        exit;
    }
}

$newUser = [
    "email"=>$email,
    "password"=>$pass,
    "role"=>$role,
    "api_key"=>generateApiKey($email)
];
$users[] = $newUser;

file_put_contents("../data/users.json", json_encode($users, JSON_PRETTY_PRINT));
echo json_encode(["status"=>"success","api_key"=>$newUser["api_key"]]);
?>