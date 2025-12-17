<?php
header("Content-Type: application/json");
require("../db.php");

$driver_id = $_GET['driver_id'];

$sql = "SELECT loads.*, driver_loads.status 
        FROM driver_loads 
        JOIN loads ON loads.id = driver_loads.load_id
        WHERE driver_loads.driver_id='$driver_id' 
        AND driver_loads.status='accepted'
        ORDER BY driver_loads.id DESC";

$result = mysqli_query($conn, $sql);

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode([
    "status" => true,
    "data" => $data
]);
?>
