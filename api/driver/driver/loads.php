<?php
header('Content-Type: application/json');
require __DIR__ . '/../../../helpers/response.php';
require __DIR__ . '/../../../config/db.php';

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT * FROM loads WHERE status = 'available' ORDER BY id DESC");
$stmt->execute();
$loads = $stmt->fetchAll(PDO::FETCH_ASSOC);
jsonResponse(true, 'Available Loads', $loads);
?>