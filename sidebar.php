<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
.sidebar{
    width:220px;
    background:#064420;
    height:100vh;
    position:fixed;
    color:white;
    padding-top:10px;
    box-shadow:2px 0 10px rgba(0,0,0,0.3);
}

.sidebar h2{
    text-align:center;
    padding:20px;
    border-bottom:1px solid rgba(255,255,255,0.2);
    font-size:18px;
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

/* ACTIVE LINK */
.sidebar a.active{
    background:#0b5d2a;
    padding-left:25px;
    font-weight:bold;
    border-left:4px solid #fff;
}
</style>

<div class="sidebar">

<h2>ADMIN PANEL</h2>

<a href="admin_dashboard.php"
class="<?= $currentPage == 'admin_dashboard.php' ? 'active' : '' ?>">
Dashboard</a>

<a href="announcement_manager.php"
class="<?= $currentPage == 'announcement_manager.php' ? 'active' : '' ?>">
Announcements</a>

<a href="clearance_admin.php"
class="<?= $currentPage == 'clearance_admin.php' ? 'active' : '' ?>">
Clearance Requests</a>

<a href="appointment_list.php"
class="<?= $currentPage == 'appointment_list.php' ? 'active' : '' ?>">
Appointments</a>

<a href="indigency_admin.php"
class="<?= $currentPage == 'indigency_admin.php' ? 'active' : '' ?>">
Indigency Requests</a>

<a href="residency_admin.php"
class="<?= $currentPage == 'residency_admin.php' ? 'active' : '' ?>">
Residency Requests</a>

<a href="logout.php">Logout</a>

</div>