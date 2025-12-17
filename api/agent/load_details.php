<?php
header("Content-Type: application/json");
include "db.php";

$id = $_GET["id"];

$sql = "SELECT * FROM My_Loads WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(["status" => "success", "data" => $result->fetch_assoc()]);
} else {
    echo json_encode(["status" => "error", "message" => "Load not found"]);
}
?>
