<?php
require 'db.php';

$agent_id = $_POST['agent_id'];
$load_code = $_POST['load_code'];
$from_city = $_POST['from_city'];
$to_city = $_POST['to_city'];

$sql = "INSERT INTO My_Loads(agent_id, load_code, from_city, to_city)
        VALUES('$agent_id', '$load_code', '$from_city', '$to_city')";

if($conn->query($sql)){
    echo json_encode(["status"=>true, "message"=>"Load created"]);
}else{
    echo json_encode(["status"=>false, "message"=>$conn->error]);
}
?>