<?php
include "auth_admin.php";
include "db.php";

/* APPROVE */
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE indigency_requests SET status='Approved' WHERE id=$id");
    header("Location: indigency_admin.php");
    exit();
}

/* REJECT */
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $conn->query("UPDATE indigency_requests SET status='Rejected' WHERE id=$id");
    header("Location: indigency_admin.php");
    exit();
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM indigency_requests WHERE id=$id");
    header("Location: indigency_admin.php");
    exit();
}

/* FETCH DATA */
$result = $conn->query("SELECT * FROM indigency_requests ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Indigency Requests</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* BACKGROUND */
body{
    min-height:100vh;
    background:url('BIISMS.png') no-repeat center center fixed;
    background-size:cover;
    position:relative;
    padding:40px;
}

/* DARK OVERLAY */
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

/* CONTAINER */
.container{
    position:relative;
    z-index:2;
    max-width:1300px;
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
    font-size:32px;
    text-shadow:0 3px 8px rgba(0,0,0,0.5);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:15px;
}

/* TABLE HEADER */
th{
    background:#0b3d0b;
    color:white;
    padding:15px;
    font-size:15px;
}

/* TABLE DATA */
td{
    background:rgba(255,255,255,0.92);
    padding:14px;
    text-align:center;
    border-bottom:1px solid #ddd;
    color:#222;
}

/* HOVER */
tr:hover td{
    background:#e9ffe9;
}

/* IMAGE */
.user-img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:10px;
    border:2px solid #0b3d0b;
}

/* STATUS */
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

/* BUTTONS */
.btn{
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-size:13px;
    font-weight:bold;
    transition:0.3s;
    display:inline-block;
    margin:3px;
}

/* APPROVE */
.approve-btn{
    background:#28a745;
}
.approve-btn:hover{
    background:#1f8c39;
    transform:scale(1.05);
}

/* REJECT */
.reject-btn{
    background:#dc3545;
}
.reject-btn:hover{
    background:#bb2d3b;
    transform:scale(1.05);
}

/* PRINT */
.print-btn{
    background:#007bff;
}
.print-btn:hover{
    background:#0056b3;
    transform:scale(1.05);
}

/* DELETE */
.delete-btn{
    background:#6c757d;
}
.delete-btn:hover{
    background:#5a6268;
    transform:scale(1.05);
}

/* RESPONSIVE */
@media(max-width:900px){
    .container{ overflow-x:auto; }
    table{ min-width:1000px; }
    th, td{ font-size:13px; }
}

</style>
</head>

<body>

<div class="container">

    <h2>📄 Indigency Requests</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Purpose</th>
            <th>Valid ID</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>

        <tr>

            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['age']) ?></td>
            <td><?= htmlspecialchars($row['gender']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><?= htmlspecialchars($row['purpose']) ?></td>

            <td>
                <?php if(!empty($row['image_path'])): ?>
                    <img src="<?= $row['image_path'] ?>" class="user-img">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>

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

                <button class="btn print-btn"
                        onclick="printRow(this)">
                    🖨 Print
                </button>

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

<script>
function printRow(button){

    let row = button.closest("tr").innerHTML;

    let printWindow = window.open('', '', 'width=900,height=700');

    printWindow.document.write(`
        <html>
        <head>
            <title>Print Request</title>

            <style>
                body{ font-family:Arial; padding:30px; }
                table{ width:100%; border-collapse:collapse; }
                th, td{ border:1px solid #000; padding:10px; text-align:center; }
                th{ background:#0b3d0b; color:white; }
                img{ width:80px; height:80px; object-fit:cover; }
            </style>
        </head>

        <body>

        <h2>Indigency Request Details</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Purpose</th>
                <th>Valid ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <tr>${row}</tr>

        </table>

        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.print();
}
</script>

</body>
</html>