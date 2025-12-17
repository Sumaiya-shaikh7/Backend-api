<?php
header("Content-Type: application/json");
require("../db.php");
$driver_id = $_GET['driver_id'];

$response = [];

// Total Loads
$t = mysqli_query($conn, "SELECT COUNT(*) AS total FROM driver_loads WHERE driver_id='$driver_id'");
$total = mysqli_fetch_assoc(t)['total'];

// Accepted Loads
$a = mysqli_query($conn, "SELECT COUNT(*) AS total FROM driver_loads WHERE driver_id='$driver_id' AND status='accepted'");
$accepted = mysqli_fetch_assoc($a)['total'];

// Completed Loads
$c = mysqli_query($conn, "SELECT COUNT(*) AS total FROM driver_loads WHERE driver_id='$driver_id' AND status='completed'");
$completed = mysqli_fetch_assoc($c)['total'];

// Pending Loads
$p = mysqli_query($conn, "SELECT COUNT(*) AS total FROM driver_loads WHERE driver_id='$driver_id' AND status='pending'");
$pending = mysqli_fetch_assoc($p)['total'];

echo json_encode([
    "status" => true,
    "message" => "Dashboard Loaded",
    "data" => [
        "total_loads" => $total,
        "accepted" => $accepted,
        "completed" => $completed,
        "pending" => $pending
    ]
]);
?>
