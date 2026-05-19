<?php
session_start();
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "barangay_db");
$result = $conn->query("SELECT message, created_at FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC");

echo "<h2>Notifications</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<p><strong>{$row['created_at']}:</strong> {$row['message']}</p>";
}
?>
