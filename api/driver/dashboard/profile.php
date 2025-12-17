<?php
header("Content-Type: application/json");
require("../db.php");

$driver_id = $_GET['driver_id'];

$q = mysqli_query($conn, "SELECT * FROM drivers WHERE id='$driver_id'");
$data = mysqli_fetch_assoc($q);

echo json_encode([
    "status" => true,
    "data" => $data
]);
?>
