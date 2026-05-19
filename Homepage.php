<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "barangay_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Barangay Ilang Integrated Services</title>

<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', sans-serif;
}

/* BACKGROUND */
body {
  display: flex;
  min-height: 100vh;
  background: url('BIISMS.png') no-repeat center center fixed;
  background-size: cover;
  position: relative;
}

/* OVERLAY */
body::before {
  content: "";
  position: fixed;
  width: 100%;
  height: 100%;
  background: rgba(0, 30, 0, 0.45);
  z-index: 0;
}

/* SIDEBAR */
nav.sidebar {
  width: 240px;
  background: #064420;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding-top: 20px;
  position: fixed;
  height: 100%;
  z-index: 1;
  box-shadow: 4px 0 10px rgba(0,0,0,0.3);
}

/* LINKS */
nav.sidebar .top-links {
  display: flex;
  flex-direction: column;
}

nav.sidebar a {
  color: white;
  text-decoration: none;
  padding: 15px;
  font-weight: bold;
  border-left: 4px solid transparent;
  transition: 0.3s;
}

nav.sidebar a:hover {
  background: #0a5a2a;
  border-left: 4px solid #00c853;
  padding-left: 20px;
}

/* LOGOUT */
nav.sidebar a.logout {
  background: crimson;
  text-align: center;
}

nav.sidebar a.logout:hover {
  background: darkred;
}

/* 📌 BARANGAY INFO BOX */
.barangay-info {
  background: rgba(255,255,255,0.12);
  margin: 15px;
  padding: 15px;
  border-radius: 10px;
  color: #e8ffe8;
  font-size: 13px;
  line-height: 1.5;
  border: 1px solid rgba(255,255,255,0.2);
}

.barangay-info h4 {
  margin-bottom: 8px;
  color: #00ff99;
}

/* CONTENT */
.content {
  margin-left: 240px;
  width: calc(100% - 240px);
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  position: relative;
  z-index: 1;
}

/* HEADER */
header {
  background: rgba(6, 68, 32, 0.95);
  color: white;
  padding: 20px;
  text-align: center;
  font-size: 18px;
  font-weight: bold;
}

/* MAIN */
main {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 30px;
}

/* CARD */
.welcome {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(12px);
  border-radius: 15px;
  padding: 40px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.4);
  max-width: 750px;
  width: 100%;
  color: white;
  text-align: center;
}

.welcome h2 {
  font-size: 26px;
  margin-bottom: 10px;
}

.welcome p {
  font-size: 14px;
  margin-bottom: 15px;
  color: #e8ffe8;
}

/* GREETING */
.greeting a {
  color: #00ff99;
  font-weight: bold;
}

/* FOOTER */
footer {
  background: rgba(6, 68, 32, 0.95);
  color: white;
  text-align: center;
  padding: 15px;
  font-size: 13px;
}
</style>
</head>

<body>

<nav class="sidebar">

  <div class="top-links">
    <a href="index.php">🏠 Home</a>
    <a href="services.php">📄 Services</a>
    <a href="appointment_form.php">📅 Appointment</a>
  </div>

  <!-- 📌 BARANGAY INFO -->
  <div class="barangay-info">
    <h4>📍 Barangay Info</h4>
    <p><b>Name:</b> Barangay Ilang</p>
    <p><b>City:</b> Davao City</p>
    <p><b>Province:</b> Davao del Sur</p>
    <p><b>Hotline:</b>  (082) 238 0133</p>
  </div>

  <a href="logout.php" class="logout">🚪 Logout</a>
</nav>

<div class="content">

<header>
  Barangay Ilang Integrated Services Management System
</header>

<main>
  <section class="welcome">
    <h2>Welcome to Barangay Services Portal</h2>
    <p>Fast, transparent, and accessible barangay services.</p>

    <?php if (isset($_SESSION['username'])): ?>
      <p class="greeting">
        Hello, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> 👋
      </p>
    <?php else: ?>
      <p class="greeting">
        Please <a href="login.php">login</a> or <a href="register.php">register</a>
      </p>
    <?php endif; ?>
  </section>
</main>

<footer>
  &copy; <?= date("Y") ?> Barangay Ilang Integrated Services
</footer>

</div>

</body>
</html>