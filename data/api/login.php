<?php
require_once "../core/env.php";
loadEnv(__DIR__ . "/../.env");

function generateApiKey($email) {
    $secret = $_ENV["SECRET_KEY"];
    $random = bin2hex(random_bytes(16));
    return hash_hmac("sha256", $email . $random, $secret);
}

$users = json_decode(file_get_contents("../data/users.json"), true);
$data = json_decode(file_get_contents("php://input"), true);

$email = $data["email"] ?? "";
$pass = $data["password"] ?? "";

foreach ($users as &$user) {
    if ($user["email"] === $email && $user["password"] === $pass) {
        if (empty($user["api_key"])) {
            $user["api_key"] = generateApiKey($email);
            file_put_contents("../data/users.json", json_encode($users, JSON_PRETTY_PRINT));
        }
        echo json_encode([
            "status" => "success",
            "role" => $user["role"],
            "api_key" => $user["api_key"]
        ]);
        exit;
    }
}
echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
?>