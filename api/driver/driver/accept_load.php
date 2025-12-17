<?php
header('Content-Type: application/json');
require __DIR__ . '/../../../helpers/response.php';
require __DIR__ . '/../../../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$driver_id = isset($data['driver_id']) ? (int)$data['driver_id'] : null;
$load_id = isset($data['load_id']) ? (int)$data['load_id'] : null;
if (!$driver_id || !$load_id) jsonResponse(false, 'driver_id and load_id required');

$db = new Database();
$conn = $db->connect();

// Ensure load is available
$stmt = $conn->prepare('SELECT status FROM loads WHERE id = ? LIMIT 1');
$stmt->execute([$load_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) jsonResponse(false, 'Load not found', []);
if ($row['status'] !== 'available') jsonResponse(false, 'Load not available for acceptance', []);

// Assign driver and change status
$upd = $conn->prepare('UPDATE loads SET driver_id = ?, status = ? WHERE id = ?');
$ok = $upd->execute([$driver_id, 'in_progress', $load_id]);
if ($ok) {
    jsonResponse(true, 'Load Accepted Successfully', ['load_id'=>$load_id,'driver_id'=>$driver_id]);
} else {
    jsonResponse(false, 'Failed to accept load');
}
?>