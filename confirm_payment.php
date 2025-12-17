<?php
include 'includes/config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $assign_id = intval($_POST['assignment_id']);
    $fake_txn  = "DEMO-" . strtoupper(bin2hex(random_bytes(4)));

    $stmt = $conn->prepare("INSERT INTO payments (assignment_id, amount, payment_status, txn_id)
                            SELECT id, price, 'completed', ? FROM assignments WHERE id=?");
    $stmt->bind_param("si", $fake_txn, $assign_id);
    $stmt->execute();

    $conn->query("UPDATE assignments SET status='paid' WHERE id=$assign_id");

    echo "<h3>Demo Payment Successful!</h3>";
    echo "<p>Transaction ID: ".htmlspecialchars($fake_txn)."</p>";
    echo "<a href='dashboard_student.php'>Back to Dashboard</a>";
} else {
    echo "Invalid request.";
}
?>
