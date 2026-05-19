<?php
include "auth_admin.php";
include "db.php";

/* APPROVE */
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE residency_requests SET status='Approved' WHERE id=$id");
    header("Location: residency_admin.php");
    exit();
}

/* REJECT */
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $conn->query("UPDATE residency_requests SET status='Rejected' WHERE id=$id");
    header("Location: residency_admin.php");
    exit();
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM residency_requests WHERE id=$id");
    header("Location: residency_admin.php");
    exit();
}

/* FETCH DATA */
$result = $conn->query("SELECT * FROM residency_requests ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Residency Requests</title>

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
    background:url('BIISMS.png') no-repeat center center fixed;
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
    background:rgba(0,40,0,0.65);
    z-index:0;
}

/* 📦 CONTAINER */
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

/* 🏷️ TITLE */
h2{
    text-align:center;
    color:white;
    font-size:32px;
    margin-bottom:25px;
    text-shadow:0 3px 8px rgba(0,0,0,0.5);
}

/* 📋 TABLE */
table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:15px;
}

/* 🔖 HEADERS */
th{
    background:#0b3d0b;
    color:white;
    padding:15px;
    font-size:15px;
}

/* 📄 DATA */
td{
    background:rgba(255,255,255,0.92);
    padding:14px;
    text-align:center;
    border-bottom:1px solid #ddd;
    color:#222;
}

/* ✨ HOVER */
tr:hover td{
    background:#e9ffe9;
}

/* 🟢 STATUS */
.status{
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:bold;
}

.approved{
    background:#d4edda;
    color:#155724;
}

.rejected{
    background:#f8d7da;
    color:#721c24;
}

.pending{
    background:#fff3cd;
    color:#856404;
}

/* 🔘 BUTTONS */
.btn{
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-size:13px;
    font-weight:bold;
    display:inline-block;
    margin:2px;
    transition:0.3s;
}

/* ✅ APPROVE */
.approve-btn{
    background:#28a745;
}

.approve-btn:hover{
    background:#1f8c39;
    transform:scale(1.05);
}

/* ❌ REJECT */
.reject-btn{
    background:#dc3545;
}

.reject-btn:hover{
    background:#bb2d3b;
    transform:scale(1.05);
}

/* 🗑 DELETE */
.delete-btn{
    background:#6c757d;
}

.delete-btn:hover{
    background:#5a6268;
    transform:scale(1.05);
}

/* 📄 CERTIFICATE */
.certificate-btn{
    background:#007bff;
}

.certificate-btn:hover{
    background:#0056b3;
    transform:scale(1.05);
}

/* 📱 RESPONSIVE */
@media(max-width:768px){

    .container{
        overflow-x:auto;
    }

    table{
        min-width:700px;
    }

    th, td{
        font-size:13px;
    }
}

</style>
</head>

<body>

<div class="container">

    <h2>🏠 Residency Requests</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>

        <tr>

            <td><?= $row['id'] ?></td>

            <td><?= htmlspecialchars($row['fullname']) ?></td>

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

                <a class="btn certificate-btn"
                   href="residency_certificate.php?id=<?= $row['id'] ?>">
                   📄 Certificate
                </a>

                <a class="btn delete-btn"
                   href="?delete=<?= $row['id'] ?>"
                   onclick="return confirm('Delete this request?');">
                   🗑 Delete
                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>