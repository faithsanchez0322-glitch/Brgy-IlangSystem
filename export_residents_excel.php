<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=residents.xls");

echo "ID\tFull Name\tAge\tGender\tAddress\tOccupation\n";

$result = $conn->query("SELECT * FROM residents");

while ($row = $result->fetch_assoc()) {
    echo "{$row['id']}\t{$row['full_name']}\t{$row['age']}\t{$row['gender']}\t{$row['address']}\t{$row['occupation']}\n";
}
?>
<a href="export_residents_excel.php" class="btn">Export to Excel</a>
