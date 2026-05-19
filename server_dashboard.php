<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, full_name, gender, birthdate, address, phone, email, profile_photo FROM residents ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resident Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f3;
      margin: 0;
      padding: 20px;
      color: #064420;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #064420;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background-color: #064420;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
    }

    .back-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #064420;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }

    .back-btn:hover {
      background-color: darkgreen;
    }
  </style>
</head>
<body>

<h2>Resident Records Dashboard</h2>

<?php if ($result->num_rows > 0): ?>
  <table>
    <tr>
      <th>#</th>
      <th>Photo</th>
      <th>Full Name</th>
      <th>Gender</th>
      <th>Birthdate</th>
      <th>Address</th>
      <th>Phone</th>
      <th>Email</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td>
          <?php if ($row["profile_photo"]): ?>
            <img src="<?= htmlspecialchars($row["profile_photo"]) ?>" alt="Profile">
          <?php else: ?>
            N/A
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row["full_name"]) ?></td>
        <td><?= htmlspecialchars($row["gender"]) ?></td>
        <td><?= htmlspecialchars($row["birthdate"]) ?></td>
        <td><?= htmlspecialchars($row["address"]) ?></td>
        <td><?= htmlspecialchars($row["phone"]) ?></td>
        <td><?= htmlspecialchars($row["email"]) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
<?php else: ?>
  <p style="text-align:center;">No residents found.</p>
<?php endif; ?>

<a class="back-btn" href="add_resident.php">← Back to Add Resident</a>

</body>
</html>

<?php $conn->close(); ?>
