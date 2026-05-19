<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "barangay_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // ✅ Include role for redirect
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $user, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {

            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $user;
            $_SESSION['role'] = $role;

            // 🔀 Redirect based on role
            if ($role === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: homepage.php");
            }
            exit();

        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - BISMS</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;

    /* 🖼️ BACKGROUND IMAGE */
    background: url('BIISMS.png') no-repeat center center fixed;
    background-size: cover;
    position: relative;
}

/* 🌿 LIGHT OVERLAY */
body::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0, 50, 0, 0.4);
    z-index: 0;
}

/* LOGIN BOX */
.login-box {
    position: relative;
    z-index: 1;

    width: 100%;
    max-width: 380px;
    padding: 40px;

    background: rgba(255,255,255,0.15);
    border-radius: 20px;
    backdrop-filter: blur(10px);

    box-shadow: 0 8px 30px rgba(0,0,0,0.5);
    text-align: center;

    animation: fadeIn 1s ease;
}

/* ANIMATION */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* LOGO */
.logo-area img {
    width: 90px;
    margin-bottom: 10px;
}

.logo-title {
    color: #fff;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* TITLE */
h2 {
    color: #fff;
    margin-bottom: 25px;
}

/* INPUT */
.login-box input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;

    border: none;
    border-radius: 10px;
    outline: none;

    background: rgba(255,255,255,0.25);
    color: white;
    font-size: 15px;
}

.login-box input::placeholder {
    color: #e0ffe0;
}

/* BUTTON */
.login-box button {
    width: 100%;
    padding: 12px;
    margin-top: 15px;

    border: none;
    border-radius: 30px;
    font-size: 16px;
    font-weight: bold;

    background: linear-gradient(45deg, #00c853, #009624);
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

.login-box button:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 20px rgba(0,200,83,0.6);
}

/* FOOTER */
.footer-note {
    margin-top: 15px;
    font-size: 13px;
    color: #ccffcc;
}

.footer-note a {
    color: #ffffff;
    font-weight: bold;
    text-decoration: none;
}

.footer-note a:hover {
    text-decoration: underline;
}
</style>
</head>

<body>

<div class="login-box">

    <div class="logo-area">
        <img src="logo.png.png" alt="Logo">
        <div class="logo-title">Barangay Services</div>
    </div>

    <h2>Login to your account</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <button type="submit">Login</button>
    </form>

    <div class="footer-note">
        Don’t have an account? <a href="register.php">Register</a>
    </div>

</div>

</body>
</html>