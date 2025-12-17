<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$agent_id = $data["agent_id"];
$load_code = $data["load_code"];
$category = $data["category"];
$pickup_city = $data["pickup_city"];
$pickup_state = $data["pickup_state"];
$drop_city = $data["drop_city"];
$drop_state = $data["drop_state"];
$distance_km = $data["distance_km"];
$freight_amount = $data["freight_amount"];
$pickup_date = $data["pickup_date"];
$status = $data["status"];

$sql = "INSERT INTO My_Loads (
        agent_id, load_code, category, pickup_city, pickup_state,
        drop_city, drop_state, distance_km, freight_amount,
        pickup_date, status
    ) VALUES (
        '$agent_id', '$load_code', '$category', '$pickup_city', '$pickup_state',
        '$drop_city', '$drop_state', '$distance_km', '$freight_amount',
        '$pickup_date', '$status'
    )";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Load Added"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>
