<?php
header("Content-Type: application/json");

$jsonFile = __DIR__ . "/../data/loads.json";

$data = json_decode(file_get_contents($jsonFile), true);

echo json_encode([
    "status" => "success",
    "total" => count($data["loads"]),
    "loads" => $data["loads"]
]);
?>
