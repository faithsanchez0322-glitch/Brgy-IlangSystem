<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM residents WHERE id = $id");
}

header("Location: view_residents.php");
exit();
?>
