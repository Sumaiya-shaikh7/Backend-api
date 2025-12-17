<?php
require("../../db.php");

$agent_id = $_GET['agent_id'];

$statuses = ['completed','in_progress','pending','cancelled'];
$output = [];

foreach($statuses as $st){
    $sql = "SELECT COUNT(*) AS total FROM loads WHERE agent_id='$agent_id' AND status='$st'";
    $res = $conn->query($sql);
    $output[$st] = $res->fetch_assoc()['total'] ?? 0;
}

echo json_encode(["status"=>1, "data"=>$output]);
?>
