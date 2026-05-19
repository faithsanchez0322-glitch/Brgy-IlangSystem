<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");

$result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Announcements</title>

<style>
body {
    font-family: Arial;
    margin: 0;
    display: flex;

    /* 🌄 BACKGROUND */
    background: url('Logo (1).png') no-repeat center center fixed;
    background-size: cover;
    position: relative;
}

/* 🌫️ OVERLAY */
body::before {
    content: "";
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(0, 40, 0, 0.55);
    z-index: 0;
}

/* SIDEBAR */
.sidebar {
    width: 200px;
    height: 100vh;
    background: rgba(11, 61, 11, 0.95);
    position: fixed;
    left: 0;
    top: 0;
    display: flex;
    flex-direction: column;
    padding-top: 20px;
    z-index: 2;
}

.sidebar h3 {
    color: #c8ffc8;
    text-align: center;
    margin-bottom: 20px;
}

/* LINKS */
.sidebar a {
    padding: 15px;
    color: white;
    text-decoration: none;
    border-left: 4px solid transparent;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #145214;
    border-left: 4px solid #00c853;
}

/* 🔙 BACK BUTTON IN SIDEBAR */
.back-btn {
    margin-top: auto;
    background: #0b3d0b;
    text-align: center;
    font-weight: bold;
}

.back-btn:hover {
    background: #145214;
}

/* CONTENT AREA */
.content {
    margin-left: 200px;
    padding: 20px;
    width: calc(100% - 200px);
    position: relative;
    z-index: 1;
}

/* TITLE */
h2 {
    color: white;
    text-align: center;
    margin-bottom: 20px;
    text-shadow: 0 2px 5px rgba(0,0,0,0.5);
}

/* CARD */
.card {
    background: rgba(255,255,255,0.92);
    padding: 15px;
    margin-bottom: 12px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-3px);
}

.card h3 {
    color: #0b3d0b;
}

.card p {
    color: #333;
}

.card small {
    color: #666;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>MENU</h3>

    <a href="Homepage.php">🏠 Home</a>
    <a href="services.php">📄 Services</a>
    <a href="announcement.php">📢 Announcements</a>

    <!-- 🔙 BACK BUTTON -->
    <a href="javascript:history.back()" class="back-btn">⬅ Back</a>
</div>

<!-- CONTENT -->
<div class="content">

<h2>📢 Barangay Announcements</h2>

<?php while($row = $result->fetch_assoc()): ?>
<div class="card">
    <h3><?= $row['title'] ?></h3>
    <p><?= $row['message'] ?></p>
    <small><?= $row['created_at'] ?></small>
</div>
<?php endwhile; ?>

</div>

</body>
</html>