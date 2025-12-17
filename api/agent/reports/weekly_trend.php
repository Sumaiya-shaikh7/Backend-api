 <?php
require("../../db.php");

$agent_id = $_GET['agent_id'];

$sql = "
SELECT 
    DAYNAME(created_at) AS day,
    COUNT(*) AS jobs,
    SUM(amount) AS revenue
FROM loads
WHERE agent_id='$agent_id'
GROUP BY DAYNAME(created_at)
ORDER BY FIELD(DAYNAME(created_at),'Mon','Tue','Wed','Thu','Fri','Sat','Sun')
";

$res = $conn->query($sql);

$data = [];
while($row = $res->fetch_assoc()){
    $data[] = $row;
}

echo json_encode(["status"=>1, "data"=>$data]);
?>
