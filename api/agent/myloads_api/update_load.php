<?php
require 'db.php';

$id = $_POST['id'];
$from_city = $_POST['from_city'];
$to_city = $_POST['to_city'];

$sql = "UPDATE My_Loads SET from_city='$from_city', to_city='$to_city'
        WHERE id='$id'";

if($conn->query($sql)){
    echo json_encode(["status"=>true, "message"=>"Updated"]);
}else{
    echo json_encode(["status"=>false, "message"=>$conn->error]);
}
?>