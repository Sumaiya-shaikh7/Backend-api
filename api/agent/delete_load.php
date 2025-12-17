<?php
header("Content-Type: application/json");
include "db.php";

$id = $_GET["id"];

$sql = "DELETE FROM My_Loads WHERE id=$id";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Load deleted"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
