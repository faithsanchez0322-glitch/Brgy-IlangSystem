<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "barangay_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // ❌ Prevent admin registration
    if ($role === 'admin') {
        $role = 'resident';
    }

    // Check duplicate
    $check = $conn->prepare("SELECT id FROM users WHERE email=? OR username=?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "<div class='error'>❌ Username or Email already exists!</div>";
    } else {

        $stmt = $conn->prepare("INSERT INTO users (full_name, email, username, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $email, $username, $password, $role);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $message = "<div class='error'>❌ Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - BISMS</title>

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

    background: url('BIISMS.png') no-repeat center center fixed;
    background-size: cover;
    position: relative;
}

/* OVERLAY */
body::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0, 50, 0, 0.4);
    z-index: 0;
}

/* CONTAINER */
.container {
    position: relative;
    z-index: 1;

    width: 100%;
    max-width: 400px;
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
    from {opacity: 0; transform: translateY(30px);}
    to {opacity: 1; transform: translateY(0);}
}

/* TITLE */
h2 {
    color: #fff;
    margin-bottom: 5px;
}

h3 {
    color: #ccffcc;
    margin-bottom: 20px;
}

/* INPUT */
input, select {
    width: 100%;
    padding: 12px;
    margin: 10px 0;

    border: none;
    border-radius: 10px;
    outline: none;

    background: rgba(255,255,255,0.9); /* ✅ FIX VISIBILITY */
    color: #002147; /* ✅ DARK TEXT FOR READABILITY */
    font-size: 14px;
}

/* placeholder text */
input::placeholder {
    color: #666;
}

/* SELECT OPTION */
select option[value=""] {
    color: #666;
}

/* BUTTON */
button {
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

button:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 20px rgba(0,200,83,0.6);
}

/* ERROR */
.error {
    background: rgba(255,0,0,0.25);
    color: #fff;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 10px;
}

/* FOOTER */
.footer-note {
    margin-top: 15px;
    font-size: 13px;
    color: #ccffcc;
}

.footer-note a {
    color: white;
    font-weight: bold;
    text-decoration: none;
}

.footer-note a:hover {
    text-decoration: underline;
}
</style>
</head>

<body>

<div class="container">
    <h2>Barangay Services</h2>
    <h3>Create Account</h3>

    <?php if ($message) echo $message; ?>

    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <!-- FIXED SELECT -->
        <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="resident">Resident</option>
            <option value="official">Barangay Official</option>
        </select>

        <button type="submit">Register</button>
    </form>

    <div class="footer-note">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>

</body>
</html>