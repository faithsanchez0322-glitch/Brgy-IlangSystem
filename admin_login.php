<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND role='admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $admin = $result->fetch_assoc();

        if (md5($password) == $admin['password']) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['role'] = "admin";

            header("Location: admin_dashboard.php");
            exit();

        } else {
            $error = "Invalid Password!";
        }

    } else {
        $error = "Admin Account Not Found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;

    /* BACKGROUND IMAGE */
    background:url('Logo.png') no-repeat center center fixed;

    background-size:cover;

    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* DARK OVERLAY */
body::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    z-index:0;
}

.login-box{
    position:relative;
    z-index:1;

    background:rgba(255,255,255,0.95);

    width:350px;
    padding:35px;
    border-radius:15px;

    box-shadow:0 5px 20px rgba(0,0,0,0.4);
}

.login-box h2{
    text-align:center;
    margin-bottom:25px;
    color:#064420;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:5px;
    font-size:15px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#064420;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#0b5d2a;
}

.error{
    color:red;
    text-align:center;
    margin-bottom:10px;
    font-size:14px;
}

</style>

</head>
<body>

<div class="login-box">

<h2>ADMIN LOGIN</h2>

<?php
if($error != ""){
    echo "<p class='error'>$error</p>";
}
?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Enter Username"
required>

<input
type="password"
name="password"
placeholder="Enter Password"
required>

<button type="submit">LOGIN</button>

</form>

</div>

</body>
</html>