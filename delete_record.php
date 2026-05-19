<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "barangay_db";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = intval($_POST['id']);
  $table = $_POST['table'];

  $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

$conn->close();
header("Location: admin_dashboard.php");
exit;
?>
