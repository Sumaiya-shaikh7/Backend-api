<?php
include 'includes/config.php';

$assignment_id = intval($_GET['id']);
$res = $conn->query("SELECT title, price FROM assignments WHERE id=$assignment_id");
if(!$res || $res->num_rows == 0){
    die("Assignment not found");
}
$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Demo Payment</title>
</head>
<body>
<h2>Demo Payment</h2>
<p><strong>Assignment:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
<p><strong>Amount:</strong> ₹<?php echo number_format($row['price'],2); ?></p>

<form action="confirm_payment.php" method="post">
   <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
   <label>Enter Fake Card Number (for demo only):</label><br>
   <input type="text" name="card" required><br><br>
   <button type="submit">Confirm Demo Payment</button>
</form>
</body>
</html>
