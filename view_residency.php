<?php
session_start();

$conn = new mysqli("localhost", "root", "", "barangay_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$result = $conn->query("SELECT * FROM residency_requests ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Residency Requests</title>

    <style>
        body {
            font-family: Arial;
            margin: 0;
            display: flex;
        }

        /* SIDEBAR */
        nav {
            width: 200px;
            background: darkgreen;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav a {
            color: white;
            padding: 15px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        nav a:hover {
            background: #004d00;
        }

        .logout {
            margin-top: auto;
            background: maroon;
            text-align: center;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 20px;
            background: #f4f4f4;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background: #004d00;
            color: white;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 12px;
        }

        .approve {
            background: green;
        }

        .reject {
            background: red;
        }

        .pending {
            color: orange;
            font-weight: bold;
        }

        .approved {
            color: green;
            font-weight: bold;
        }

        .rejected {
            color: red;
            font-weight: bold;
        }

    </style>
</head>

<body>

<nav>
    <a href="services.php">Services</a>
    <a href="view_residency.php">Residency Requests</a>
    <a href="logout.php" class="logout">Logout</a>
</nav>

<div class="content">

<h2>Residency Requests</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Address</th>
        <th>Years</th>
        <th>Purpose</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while($row = $result->fetch_assoc()): ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['address']; ?></td>
    <td><?php echo $row['years_of_stay']; ?></td>
    <td><?php echo $row['purpose']; ?></td>

    <td class="<?php echo strtolower($row['status']); ?>">
        <?php echo $row['status']; ?>
    </td>

    <td>
        <?php if ($row['status'] == "Pending"): ?>
            <a class="btn approve" href="approve_residency.php?id=<?php echo $row['id']; ?>&action=approve">Approve</a>
            <a class="btn reject" href="approve_residency.php?id=<?php echo $row['id']; ?>&action=reject">Reject</a>
        <?php else: ?>
            ✔ Done
        <?php endif; ?>
    </td>
</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>