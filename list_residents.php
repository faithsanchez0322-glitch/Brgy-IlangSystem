<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, full_name, gender, birthdate FROM residents ORDER BY full_name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Residents List</title>
    <style>
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th, td {
            padding: 10px 15px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        a.edit-btn {
            background-color: #28a745;
            color: white;
            padding: 5px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        a.edit-btn:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Residents List</h2>

<table>
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Birthdate</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['gender']) ?></td>
            <td><?= htmlspecialchars($row['birthdate']) ?></td>
            <td><a class="edit-btn" href="edit_resident.php?id=<?= $row['id'] ?>">Edit</a></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4" style="text-align:center;">No residents found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php $conn->close(); ?>
