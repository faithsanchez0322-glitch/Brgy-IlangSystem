<?php
include "auth_admin.php";
include "db.php";

/* APPROVE */
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE clearance_requests SET status='Approved' WHERE id=$id");
    header("Location: clearance_admin.php");
    exit();
}

/* REJECT */
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $conn->query("UPDATE clearance_requests SET status='Rejected' WHERE id=$id");
    header("Location: clearance_admin.php");
    exit();
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM clearance_requests WHERE id=$id");
    header("Location: clearance_admin.php");
    exit();
}

$result = $conn->query("SELECT * FROM clearance_requests ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Clearance Requests</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* 🌄 BACKGROUND */
body{
    min-height:100vh;
    background:url('LOGO.png') no-repeat center center fixed;
    background-size:cover;
    position:relative;
    padding:40px;
}

/* 🌫️ DARK OVERLAY */
body::before{
    content:"";
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,40,0,0.60);
    z-index:0;
}

/* MAIN CONTAINER */
.container{
    position:relative;
    z-index:2;
    max-width:1100px;
    margin:auto;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);

    border-radius:20px;
    padding:30px;

    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

/* TITLE */
h2{
    text-align:center;
    color:white;
    margin-bottom:25px;
    font-size:30px;
    text-shadow:0 3px 8px rgba(0,0,0,0.5);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    border-radius:15px;
    overflow:hidden;
}

/* HEADERS */
th{
    background:#0b3d0b;
    color:white;
    padding:15px;
}

/* TABLE DATA */
td{
    background:rgba(255,255,255,0.92);
    padding:14px;
    text-align:center;
}

/* STATUS */
.status{
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:bold;
}

.approved{ background:#d4edda; color:#155724; }
.rejected{ background:#f8d7da; color:#721c24; }
.pending{ background:#fff3cd; color:#856404; }

/* BUTTONS */
.btn{
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-size:13px;
    font-weight:bold;
    display:inline-block;
    margin:2px;
}

.approve-btn{ background:#28a745; }
.reject-btn{ background:#dc3545; }
.delete-btn{ background:#6c757d; }
.certificate-btn{ background:#007bff; }

.approve-btn:hover{ background:#1f8c39; }
.reject-btn:hover{ background:#bb2d3b; }
.delete-btn:hover{ background:#5a6268; }
.certificate-btn:hover{ background:#0056b3; }

</style>
</head>

<body>

<div class="container">

    <h2>📄 Clearance Requests</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Purpose</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>

        <tr>

            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['fullname']) ?></td>
            <td><?= htmlspecialchars($row['purpose']) ?></td>

            <td>
                <?php $status = strtolower($row['status']); ?>
                <span class="status <?= $status ?>">
                    <?= $row['status'] ?>
                </span>
            </td>

            <td>

                <a class="btn approve-btn"
                   href="?approve=<?= $row['id'] ?>">
                   ✔ Approve
                </a>

                <a class="btn reject-btn"
                   href="?reject=<?= $row['id'] ?>">
                   ✖ Reject
                </a>

                <!-- ✅ CERTIFICATE BUTTON ADDED -->
                <a class="btn certificate-btn"
                   href="clearance_certificate.php?id=<?= $row['id'] ?>">
                   📄 Certificate
                </a>

                <a class="btn delete-btn"
                   href="?delete=<?= $row['id'] ?>"
                   onclick="return confirm('Are you sure you want to delete this request?');">
                   🗑 Delete
                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>