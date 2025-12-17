<?php
require("../../db.php");

$agent_id = $_GET['agent_id'];

$sql = "
SELECT type, title, amount, city_from, city_to, created_at
FROM activities
WHERE agent_id='$agent_id'
ORDER BY created_at DESC
LIMIT 20
";

$res = $conn->query($sql);

$data = [];
while($row = $res->fetch_assoc()){
    $data[] = $row;
}

echo json_encode(["status"=>1, "data"=>$data]);
?>
