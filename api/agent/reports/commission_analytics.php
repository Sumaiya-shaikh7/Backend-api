<?php
require("../../db.php");

$agent_id = $_GET['agent_id'];

$sql = "
SELECT 
    DATE_FORMAT(created_at,'%b') AS month,
    SUM(commission) AS commission
FROM commissions
WHERE agent_id='$agent_id'
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
";

$res = $conn->query($sql);

$data = [];
while($row = $res->fetch_assoc()){
    $data[] = $row;
}

echo json_encode(["status"=>1, "data"=>$data]);
?>
