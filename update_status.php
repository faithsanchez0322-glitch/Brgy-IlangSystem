<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "barangay_db";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$status = $_POST['status'];
$table = $_POST['table'];

if ($table === "complaints" || $table === "indigency_requests") {
  $sql = "UPDATE $table SET status='$status' WHERE id=$id";
  $conn->query($sql);
}

$conn->close();
header("Location: admin_dashboard.php");
exit();
