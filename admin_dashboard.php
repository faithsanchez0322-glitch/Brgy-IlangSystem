<?php
include "auth_admin.php";
include "db.php";

$clearance = $conn->query("SELECT * FROM clearance_requests")->num_rows;
$appointments = $conn->query("SELECT * FROM appointment_requests")->num_rows;
$indigency = $conn->query("SELECT * FROM indigency_requests")->num_rows;
$residency = $conn->query("SELECT * FROM residency_requests")->num_rows;
$announcements = $conn->query("SELECT * FROM announcements")->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>

body{
    margin:0;
    font-family:Arial;

    background: url('BIISMS.png') no-repeat center center fixed;
    background-size: cover;
    position: relative;
}

/* DARK OVERLAY */
body::before{
    content:"";
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: -1;
}

/* SIDEBAR */
.sidebar{
    width:220px;
    background: rgba(6,68,32,0.95);
    height:100vh;
    position:fixed;
    color:white;
}

.sidebar h2{
    text-align:center;
    padding:20px;
    border-bottom:1px solid rgba(255,255,255,0.2);
}

.sidebar a{
    display:block;
    color:white;
    padding:15px;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a:hover{
    background:#0b5d2a;
    padding-left:20px;
}

/* CONTENT */
.content{
    margin-left:220px;
    padding:30px;
    color:white;
}

.content h1{
    margin-bottom:25px;
}

/* CARDS GRID */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

/* CLICKABLE CARD */
.card-link{
    text-decoration:none;
}

.card{
    background: rgba(255,255,255,0.92);
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.3);
    transition:0.3s;
    cursor:pointer;
    color:black;
}

.card:hover{
    transform:translateY(-5px);
    background:white;
}

.card h3{
    color:#333;
    margin-bottom:10px;
}

.card h1{
    color:darkgreen;
    font-size:40px;
}

</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

<h2>ADMIN PANEL</h2>

<a href="admin_dashboard.php">Dashboard</a>
<a href="announcement_manager.php">Announcements</a>
<a href="clearance_admin.php">Clearance Requests</a>
<a href="appointment_list.php">Appointments</a>
<a href="indigency_admin.php">Indigency Requests</a>
<a href="residency_admin.php">Residency Requests</a>
<a href="logout.php">Logout</a>

</div>

<!-- CONTENT -->
<div class="content">

<h1>Welcome Admin</h1>

<div class="cards">

<!-- CLEARANCE -->
<a class="card-link" href="clearance_admin.php">
<div class="card">
<h3>Clearance Requests</h3>
<h1><?= $clearance ?></h1>
</div>
</a>

<!-- APPOINTMENTS -->
<a class="card-link" href="appointment_list.php">
<div class="card">
<h3>Appointments</h3>
<h1><?= $appointments ?></h1>
</div>
</a>

<!-- INDIGENCY -->
<a class="card-link" href="indigency_admin.php">
<div class="card">
<h3>Indigency Requests</h3>
<h1><?= $indigency ?></h1>
</div>
</a>

<!-- RESIDENCY -->
<a class="card-link" href="residency_admin.php">
<div class="card">
<h3>Residency Requests</h3>
<h1><?= $residency ?></h1>
</div>
</a>

<!-- ANNOUNCEMENTS -->
<a class="card-link" href="announcement_manager.php">
<div class="card">
<h3>Announcements</h3>
<h1><?= $announcements ?></h1>
</div>
</a>

</div>

</div>

</body>
</html>