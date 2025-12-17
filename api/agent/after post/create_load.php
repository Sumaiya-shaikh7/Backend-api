<?php
header("Content-Type: application/json");

// JSON file path
$jsonFile = __DIR__ . "/../data/loads.json";

// Read current data
$data = json_decode(file_get_contents($jsonFile), true);

// Get POST data
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit;
}

// Create load ID
$loadId = "TC" . rand(10000, 99999);

// New Load Data
$newLoad = [
    "id" => $loadId,
    "agent_id" => $input["agent_id"],
    "pickup" => $input["pickup"],
    "delivery" => $input["delivery"],
    "distance" => $input["distance"],
    "expected_freight" => $input["expected_freight"],
    "driver_matches" => rand(5, 20),
    "avg_response" => "<15 min",
    "created_at" => date("Y-m-d H:i:s")
];

// Add to JSON
$data["loads"][] = $newLoad;

// Save File
file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode([
    "status" => "success",
    "message" => "Load Posted Successfully",
    "load" => $newLoad
]);
?>
