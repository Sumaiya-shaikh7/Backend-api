<?php
require 'db.php';

$sql = "SELECT * FROM My_Loads";
$result = $conn->query($sql);

$data = [];
while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>