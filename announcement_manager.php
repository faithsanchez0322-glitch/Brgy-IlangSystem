<?php
include "auth_admin.php";
include "db.php";

/* ADD ANNOUNCEMENT */
if (isset($_POST['add'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $conn->query("INSERT INTO announcements (title, message)
    VALUES ('$title', '$message')");
}

/* DELETE */
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $conn->query("DELETE FROM announcements WHERE id=$id");

    header("Location: announcement_manager.php");
    exit();
}

/* FETCH ANNOUNCEMENTS */
$result = $conn->query("SELECT * FROM announcements ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Announcement Manager</title>

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

/* 🌫️ OVERLAY */
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

    max-width:1200px;
    margin:auto;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);

    border-radius:20px;
    padding:30px;

    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

/* 🏷 TITLE */
h2{
    text-align:center;
    color:white;
    margin-bottom:25px;
    font-size:32px;
    text-shadow:0 3px 8px rgba(0,0,0,0.5);
}

/* 📝 FORM */
.form-box{
    background:rgba(255,255,255,0.15);
    padding:25px;
    border-radius:15px;
    margin-bottom:30px;
}

/* INPUTS */
input, textarea{
    width:100%;
    padding:14px;
    margin-top:10px;
    margin-bottom:20px;

    border:none;
    border-radius:10px;

    font-size:15px;
    outline:none;
}

/* TEXTAREA */
textarea{
    resize:none;
    height:120px;
}

/* ➕ BUTTON */
.add-btn{
    background:#28a745;
    color:white;
    border:none;

    padding:12px 20px;
    border-radius:10px;

    font-size:15px;
    font-weight:bold;

    cursor:pointer;
    transition:0.3s;
}

.add-btn:hover{
    background:#1f8c39;
    transform:scale(1.05);
}

/* 📋 TABLE */
table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:15px;
}

/* HEADERS */
th{
    background:#0b3d0b;
    color:white;
    padding:15px;
}

/* DATA */
td{
    background:rgba(255,255,255,0.92);
    padding:14px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

/* HOVER */
tr:hover td{
    background:#e9ffe9;
}

/* 🗑 DELETE BUTTON */
.delete-btn{
    background:#dc3545;
    color:white;

    padding:8px 14px;
    border-radius:8px;

    text-decoration:none;
    font-size:13px;
    font-weight:bold;

    transition:0.3s;
}

.delete-btn:hover{
    background:#bb2d3b;
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
}

</style>
</head>

<body>

<div class="container">

    <h2>📢 Announcement Manager</h2>

    <!-- 📝 FORM -->
    <div class="form-box">

        <form method="POST">

            <input type="text"
                   name="title"
                   placeholder="Enter announcement title..."
                   required>

            <textarea name="message"
                      placeholder="Write announcement message..."
                      required></textarea>

            <button class="add-btn" name="add">
                ➕ Add Announcement
            </button>

        </form>

    </div>

    <!-- 📋 TABLE -->
    <table>

        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Message</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>

        <tr>

            <td><?= $row['id'] ?></td>

            <td>
                <?= htmlspecialchars($row['title']) ?>
            </td>

            <td>
                <?= htmlspecialchars($row['message']) ?>
            </td>

            <td>

                <a class="delete-btn"
                   href="?delete=<?= $row['id'] ?>"
                   onclick="return confirm('Delete this announcement?');">
                   🗑 Delete
                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>