<?php
header('Content-Type: application/json');
require __DIR__ . '/../../../helpers/response.php';
require __DIR__ . '/../../../config/db.php';

$db = new Database();
$conn = $db->connect();

$driver_id = isset($_GET['driver_id']) ? (int)$_GET['driver_id'] : null;
if (!$driver_id) jsonResponse(false, 'driver_id is required');

$stmt = $conn->prepare("SELECT * FROM performance WHERE driver_id = ? LIMIT 1");
$stmt->execute([$driver_id]);
$perf = $stmt->fetch(PDO::FETCH_ASSOC);
jsonResponse(true, 'Performance Data', $perf ?: []);
?>