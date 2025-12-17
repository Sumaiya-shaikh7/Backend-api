<?php
header("Content-Type: application/json");
include "db.php";

$agent_id = $_GET['agent_id'];

$sql = "SELECT * FROM My_Loads WHERE agent_id = $agent_id ORDER BY id DESC";
$result = $conn->query($sql);

$loads = [];

while ($row = $result->fetch_assoc()) {
    $loads[] = $row;
}

echo json_encode([
    "status" => "success",
    "total" => count($loads),
    "data" => $loads
]);
?>
