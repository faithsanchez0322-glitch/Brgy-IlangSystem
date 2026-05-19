<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* =========================
   UPDATE STATUS
========================= */

if(isset($_GET['status']) && isset($_GET['id'])){

    $id = intval($_GET['id']);
    $status = $_GET['status'];

    if(
        $status == "Pending" ||
        $status == "Approved" ||
        $status == "Rejected"
    ){

        $stmt = $conn->prepare("
            UPDATE appointment_requests
            SET status=?
            WHERE id=?
        ");

        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
    }

    header("Location: appointment_list.php");
    exit();
}

/* =========================
   DELETE APPOINTMENT
========================= */

if(isset($_GET['delete'])){

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("
        DELETE FROM appointment_requests
        WHERE id=?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: appointment_list.php");
    exit();
}

/* =========================
   FETCH DATA
========================= */

$result = $conn->query("
    SELECT *
    FROM appointment_requests
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Appointment List CRUD</title>

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
    padding:40px;
    position:relative;
}

/* 🌫️ DARK OVERLAY */
body::before{
    content:"";
    position:fixed;
    inset:0;
    background:rgba(0,40,0,0.65);
    z-index:0;
}

/* 📦 MAIN CONTAINER */
.container{
    position:relative;
    z-index:2;

    max-width:1450px;
    margin:auto;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(14px);

    border-radius:25px;
    padding:30px;

    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

/* 🏷 TITLE */
h1{
    text-align:center;
    color:white;
    margin-bottom:30px;
    font-size:36px;
    text-shadow:0 3px 10px rgba(0,0,0,0.5);
}

/* 📋 TABLE */
table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:18px;
}

/* 🔖 TABLE HEADERS */
th{
    background:#0b3d0b;
    color:white;
    padding:16px;
    font-size:15px;
    text-transform:uppercase;
}

/* 📄 TABLE DATA */
td{
    background:rgba(255,255,255,0.92);
    padding:15px;
    text-align:center;
    border-bottom:1px solid #ddd;
    color:#222;
}

/* ✨ ROW HOVER */
tr:hover td{
    background:#e9ffe9;
    transition:0.3s;
}

/* 🖼 VALID ID IMAGE */
.user-img{
    width:75px;
    height:75px;
    object-fit:cover;
    border-radius:12px;
    border:2px solid #0b3d0b;
}

/* 📌 MODERN STATUS */
.status{
    padding:10px 18px;
    border-radius:30px;

    font-size:13px;
    font-weight:700;

    border:none;
    outline:none;

    cursor:pointer;

    min-width:135px;

    transition:0.3s ease;

    appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;

    text-align:center;

    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}

/* 🟡 PENDING */
.pending{
    background:linear-gradient(45deg,#fff3cd,#ffe082);
    color:#856404;
}

/* 🟢 APPROVED */
.approved{
    background:linear-gradient(45deg,#d4edda,#81c784);
    color:#155724;
}

/* 🔴 REJECTED */
.rejected{
    background:linear-gradient(45deg,#f8d7da,#ef5350);
    color:#721c24;
}

/* ✨ STATUS HOVER */
.status:hover{
    transform:translateY(-2px) scale(1.03);
    box-shadow:0 8px 18px rgba(0,0,0,0.25);
}

/* OPTION STYLE */
.status option{
    background:white;
    color:black;
    font-weight:bold;
}

/* 🗑 DELETE BUTTON */
.delete-btn{
    background:linear-gradient(45deg,#dc3545,#b71c1c);
    color:white;

    padding:10px 16px;
    border-radius:10px;

    text-decoration:none;
    font-size:13px;
    font-weight:bold;

    display:inline-block;

    transition:0.3s;
}

.delete-btn:hover{
    transform:scale(1.05);
    background:linear-gradient(45deg,#c82333,#8e0000);
}

/* 🔘 BACK BUTTON */
.back-btn{
    display:inline-block;
    margin-top:30px;
    padding:13px 28px;

    background:white;
    color:#064420;

    border-radius:35px;
    text-decoration:none;
    font-weight:bold;

    transition:0.3s;
}

.back-btn:hover{
    transform:scale(1.05);
    background:#dfffe0;
}

/* 📱 RESPONSIVE */
@media(max-width:1100px){

    .container{
        overflow-x:auto;
    }

    table{
        min-width:1350px;
    }

    th, td{
        font-size:13px;
    }
}

</style>
</head>

<body>

<div class="container">

<h1>📅 Appointment List</h1>

<table>

<tr>
    <th>ID</th>
    <th>Appointment No.</th>
    <th>Full Name</th>
    <th>Purpose</th>
    <th>Date</th>
    <th>Time</th>
    <th>Contact</th>
    <th>Valid ID</th>
    <th>Status</th>
    <th>Delete</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>

<tr>

    <td>
        <?= $row['id'] ?>
    </td>

    <td>
        <?= htmlspecialchars($row['appointment_number']) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['full_name']) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['purpose']) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['appointment_date']) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['appointment_time']) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['contact']) ?>
    </td>

    <td>

        <?php if(!empty($row['valid_id_path'])): ?>

            <img
                src="<?= $row['valid_id_path'] ?>"
                class="user-img"
            >

        <?php else: ?>

            No Image

        <?php endif; ?>

    </td>

    <td>

        <select
            class="status <?= strtolower($row['status'] ?? 'Pending') ?>"
            onchange="window.location.href=this.value"
        >

            <option
                value="?id=<?= $row['id'] ?>&status=Pending"
                <?= (($row['status'] ?? '') == 'Pending') ? 'selected' : '' ?>>
                Pending
            </option>

            <option
                value="?id=<?= $row['id'] ?>&status=Approved"
                <?= (($row['status'] ?? '') == 'Approved') ? 'selected' : '' ?>>
                Approved
            </option>

            <option
                value="?id=<?= $row['id'] ?>&status=Rejected"
                <?= (($row['status'] ?? '') == 'Rejected') ? 'selected' : '' ?>>
                Rejected
            </option>

        </select>

    </td>

    <td>

        <a
            class="delete-btn"
            href="?delete=<?= $row['id'] ?>"
            onclick="return confirm('Are you sure you want to delete this appointment?');"
        >
            🗑 Delete
        </a>

    </td>

</tr>

<?php endwhile; ?>

</table>

<a href="admin_dashboard.php" class="back-btn">
    ← Back to Dashboard
</a>

</div>

</body>
</html>