<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'barangay_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Check if the email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update password
        $stmt->close();
        $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $new_password, $email);
        if ($update->execute()) {
            $message = "<p class='success'>✅ Password successfully updated.</p>";
        } else {
            $message = "<p class='error'>❌ Failed to update password.</p>";
        }
        $update->close();
    } else {
        $message = "<p class='error'>❌ Email not found in our records.</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('LOGO.png') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      background: rgba(255,255,255,0.95);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      max-width: 400px;
      width: 100%;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      font-weight: bold;
      margin-top: 15px;
      display: block;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      width: 100%;
      background-color: #007bff;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    button:hover {
      background-color: #0056b3;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      text-align: center;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      text-align: center;
    }

    .footer-note {
      text-align: center;
      font-size: 14px;
      margin-top: 10px;
    }

    .footer-note a {
      color: #007bff;
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
  <h2>Reset Your Password</h2>
  <?php if ($message) echo $message; ?>

  <form method="POST">
    <label for="email">Registered Email:</label>
    <input type="email" name="email" required>

    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required>

    <button type="submit">Reset Password</button>
  </form>

  <div class="footer-note">
    <a href="login.php">Back to Login</a>
  </div>
</div>

</body>
</html>
