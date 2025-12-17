<?php
header("Content-Type: application/json");

$jsonFile = __DIR__ . "/../data/loads.json";
$data = json_decode(file_get_contents($jsonFile), true);

// Get ?id=TC12345
$loadId = $_GET["id"] ?? "";

if ($loadId == "") {
    echo json_encode(["status" => "error", "message" => "Load ID missing"]);
    exit;
}

foreach ($data["loads"] as $load) {
    if ($load["id"] === $loadId) {
        echo json_encode(["status" => "success", "load" => $load]);
        exit;
    }
}

echo json_encode(["status" => "error", "message" => "Load not found"]);
?>
