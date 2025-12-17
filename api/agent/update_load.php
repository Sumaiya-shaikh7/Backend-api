<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$status = $data['status']; // pending/active/completed/cancelled

$sql = "UPDATE My_Loads SET status='$status' WHERE id=$id";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Load Updated"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
