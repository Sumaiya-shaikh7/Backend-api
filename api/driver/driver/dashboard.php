<?php
header('Content-Type: application/json');
require __DIR__ . '/../../../helpers/response.php';
require __DIR__ . '/../../../config/db.php';
$db = new Database();
$conn = $db->connect();

$driver_id = isset($_GET['driver_id']) ? (int)$_GET['driver_id'] : null;
if (!$driver_id) jsonResponse(false, 'driver_id is required');

$stmt = $conn->prepare("
    SELECT d.id,d.name, d.image, d.status,
           IFNULL(w.total_balance,0) AS total_balance,
           IFNULL(w.available,0) AS available,
           IFNULL(w.pending,0) AS pending,
           IFNULL(p.rating,0) AS rating,
           IFNULL(p.completed_jobs,0) AS completed_jobs,
           IFNULL(p.ontime_rate,0) AS ontime_rate,
           IFNULL(p.weekly_miles,0) AS weekly_miles
    FROM drivers d
    LEFT JOIN wallet w ON d.id = w.driver_id
    LEFT JOIN performance p ON d.id = p.driver_id
    WHERE d.id = ?
");
$stmt->execute([$driver_id]);
$driver = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$driver) jsonResponse(false, 'Driver not found', []);
jsonResponse(true, 'Driver Dashboard Data', $driver);
?>