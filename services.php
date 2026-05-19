<?php
session_start();

$conn = new mysqli("localhost", "root", "", "barangay_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Barangay Services</title>

<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', sans-serif;
}

/* 🌄 BACKGROUND FIX */
body {
  display: flex;
  min-height: 100vh;

  background: url('BIISMS.png') no-repeat center center fixed;
  background-size: cover;
  position: relative;
}

/* 🌫️ DARK OVERLAY */
body::before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 20, 0, 0.45);
  z-index: 0;
}

/* SIDEBAR */
.sidebar {
  width: 220px;
  background: #0b3d0b;
  color: white;
  position: fixed;
  height: 100%;
  display: flex;
  flex-direction: column;
  padding-top: 20px;
  z-index: 1;
}

.sidebar h3 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 16px;
  color: #c8ffc8;
}

/* LINKS */
.sidebar a {
  padding: 15px 20px;
  color: white;
  text-decoration: none;
  border-left: 4px solid transparent;
  transition: 0.3s;
}

.sidebar a:hover {
  background: #145214;
  border-left: 4px solid #00c853;
}

/* ANNOUNCEMENT BOX (NEW SECTION STYLE) */
.sidebar .section-title {
  padding: 10px 20px;
  font-size: 12px;
  color: #a6f3a6;
  margin-top: 10px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* LOGOUT */
.sidebar .logout {
  margin-top: auto;
  background: #8b0000;
  text-align: center;
}

.sidebar .logout:hover {
  background: #a30000;
}

/* WRAPPER */
.wrapper {
  margin-left: 220px;
  width: calc(100% - 220px);
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  z-index: 1;
  position: relative;
}

/* HEADER */
header {
  background: rgba(11, 61, 11, 0.9);
  color: white;
  padding: 20px;
  text-align: center;
  font-size: 20px;
  font-weight: bold;
}

/* MAIN */
main {
  padding: 30px;
}

/* TITLE */
main h2 {
  margin-bottom: 20px;
  color: white;
}

/* SERVICES GRID */
.services-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

/* CARD */
.service-button {
  background: rgba(255, 255, 255, 0.92);
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.25);
  transition: 0.3s;
  border-top: 4px solid #0b3d0b;
}

.service-button:hover {
  transform: translateY(-6px);
}

/* TITLE */
.service-title {
  font-weight: bold;
  font-size: 16px;
  margin-bottom: 10px;
  color: #0b3d0b;
}

/* TEXT */
.service-button p {
  font-size: 13px;
  color: #444;
  margin-bottom: 10px;
}

/* STATUS */
.status {
  display: inline-block;
  padding: 5px 10px;
  border-radius: 20px;
  font-size: 12px;
  margin-bottom: 10px;
}

.available {
  background: #d4f5d4;
  color: #0b3d0b;
}

/* BUTTON */
.form-link {
  display: block;
  text-align: center;
  padding: 10px;
  margin-top: 10px;
  background: #0b3d0b;
  color: white;
  text-decoration: none;
  border-radius: 6px;
  font-weight: bold;
}

.form-link:hover {
  background: #145214;
}

/* FOOTER */
footer {
  background: rgba(11, 61, 11, 0.95);
  color: white;
  text-align: center;
  padding: 12px;
  margin-top: auto;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<nav class="sidebar">
  <h3>BISMS MENU</h3>

  <a href="Homepage.php">🏠 Home</a>
  <a href="services.php">📄 Services</a>

  <!-- ✅ ADDED ANNOUNCEMENT -->
  <div class="section-title">Information</div>
  <a href="announcement.php">📢 Announcements</a>

  <a href="logout.php" class="logout">🚪 Logout</a>
</nav>

<div class="wrapper">

<header>
  Barangay Ilang Integrated Services
</header>

<main>
  <h2>Available Services</h2>

  <div class="services-container">

    <div class="service-button">
      <div class="service-title">Barangay Clearance</div>
      <p>Request official barangay clearance document.</p>
      <div class="status available">Available</div>
      <?php if (file_exists("request_clearance.php")): ?>
        <a class="form-link" href="request_clearance.php">Open Form</a>
      <?php endif; ?>
    </div>

    <div class="service-button">
      <div class="service-title">Complaint Filing</div>
      <p>Submit community complaints or reports.</p>
      <div class="status available">Available</div>
      <?php if (file_exists("complaint_form.php")): ?>
        <a class="form-link" href="complaint_form.php">Open Form</a>
      <?php endif; ?>
    </div>

    <div class="service-button">
      <div class="service-title">Indigency Certificate</div>
      <p>Request indigency certificate.</p>
      <div class="status available">Available</div>
      <?php if (file_exists("indigency_request.php")): ?>
        <a class="form-link" href="indigency_request.php">Open Form</a>
      <?php endif; ?>
    </div>

    <div class="service-button">
      <div class="service-title">Residency Certificate</div>
      <p>Request proof of residency.</p>
      <div class="status available">Available</div>
      <?php if (file_exists("residency_request.php")): ?>
        <a class="form-link" href="residency_request.php">Open Form</a>
      <?php endif; ?>
    </div>

  </div>
</main>

<footer>
  &copy; <?= date("Y") ?> Barangay Integrated Services Management System
</footer>

</div>

</body>
</html>