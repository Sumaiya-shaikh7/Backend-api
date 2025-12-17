<?php
header("Content-Type: application/json");
require("../db.php");

$driver_id = $_GET['driver_id'];

$query = mysqli_query($conn, "SELECT * FROM driver_notifications 
                              WHERE driver_id='$driver_id'
                              ORDER BY id DESC");

$data = [];

while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode([
    "status" => true,
    "data" => $data
]);
?>
