<?php
require("../../db.php");

$agent_id = $_GET['agent_id'];

$response = [];

// TOTAL REVENUE
$sql = "SELECT SUM(amount) AS revenue FROM payments WHERE agent_id='$agent_id'";
$res = $conn->query($sql);
$response['revenue'] = $res->fetch_assoc()['revenue'] ?? 0;

// COMPLETED JOBS
$sql = "SELECT COUNT(*) AS jobs FROM loads WHERE agent_id='$agent_id' AND status='completed'";
$res = $conn->query($sql);
$response['completed_jobs'] = $res->fetch_assoc()['jobs'] ?? 0;

// ACTIVE DRIVERS
$sql = "SELECT COUNT(*) AS drivers FROM drivers WHERE agent_id='$agent_id' AND status='active'";
$res = $conn->query($sql);
$response['active_drivers'] = $res->fetch_assoc()['drivers'] ?? 0;

// AVG COMMISSION
$sql = "SELECT AVG(commission) AS avg_comm FROM commissions WHERE agent_id='$agent_id'";
$res = $conn->query($sql);
$response['avg_commission'] = $res->fetch_assoc()['avg_comm'] ?? 0;

echo json_encode(["status"=>1, "data"=>$response]);
?>
