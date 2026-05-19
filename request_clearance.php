<?php
session_start();

date_default_timezone_set('Asia/Manila');

$host = "localhost";
$user = "root";
$pass = "";
$db = "barangay_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";
$transaction_time = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $fullname = $conn->real_escape_string($_POST['fullname']);
  $purpose = $conn->real_escape_string($_POST['purpose']);
  $date = date("Y-m-d H:i:s");

  $target_dir = "uploads/";
  if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

  $image_path = '';

  if (!empty($_FILES["user_image"]["name"])) {
    $image_name = basename($_FILES["user_image"]["name"]);
    $target_file = $target_dir . time() . "_" . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = ['jpg','jpeg','png','gif'];

    if (in_array($imageFileType, $allowed_types)) {
      if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file)) {
        $image_path = $conn->real_escape_string($target_file);
      } else {
        $error_message = "Image upload failed.";
      }
    } else {
      $error_message = "Invalid file type.";
    }
  }

  if (empty($error_message)) {
    $sql = "INSERT INTO clearance_requests (fullname, purpose, request_date, status, image_path)
            VALUES ('$fullname', '$purpose', '$date', 'Pending', '$image_path')";

    if ($conn->query($sql)) {
      $success_message = "Clearance request submitted successfully!";
      $transaction_time = date("F j, Y - g:i A", strtotime($date));
    } else {
      $error_message = "Database error: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Barangay Clearance</title>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

/* 🌄 BACKGROUND */
body {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;

  background: url('BIISMS.png') no-repeat center center fixed;
  background-size: cover;
  position: relative;
}

/* 🌫️ LIGHT OVERLAY (VISIBLE BACKGROUND) */
body::before {
  content: "";
  position: fixed;
  inset: 0;
  background: rgba(0, 40, 0, 0.35);
}

/* 🧾 MAIN CARD */
.form-container {
  position: relative;
  z-index: 1;

  width: 100%;
  max-width: 520px;

  background: rgba(255,255,255,0.18);
  backdrop-filter: blur(15px);

  padding: 35px;
  border-radius: 16px;

  box-shadow: 0 12px 30px rgba(0,0,0,0.5);

  animation: fadeIn 0.8s ease;
}

/* ANIMATION */
@keyframes fadeIn {
  from {opacity: 0; transform: translateY(20px);}
  to {opacity: 1; transform: translateY(0);}
}

/* TITLE */
h2 {
  text-align: center;
  color: white;
  margin-bottom: 20px;
  letter-spacing: 1px;
}

/* LABEL */
label {
  color: #eaffea;
  font-weight: 600;
  font-size: 14px;
}

/* INPUTS */
input, textarea {
  width: 100%;
  padding: 12px;
  margin: 8px 0 16px;

  border: none;
  border-radius: 10px;

  background: rgba(255,255,255,0.25);
  color: white;
  outline: none;
}

input::placeholder, textarea::placeholder {
  color: #dfffe0;
}

/* BUTTON */
input[type="submit"] {
  width: 100%;
  padding: 13px;

  border: none;
  border-radius: 30px;

  background: linear-gradient(45deg, #00c853, #009624);
  color: white;

  font-size: 16px;
  font-weight: bold;
  cursor: pointer;

  transition: 0.3s;
}

input[type="submit"]:hover {
  transform: scale(1.03);
}

/* MESSAGE BOX */
.message {
  text-align: center;
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 8px;
}

.success {
  background: rgba(0,255,0,0.15);
  color: #b6ffb6;
}

.error {
  background: rgba(255,0,0,0.15);
  color: #ffb6b6;
}

/* TRANSACTION TIME */
.transaction-time {
  text-align: center;
  margin: 10px 0;
  padding: 8px;
  background: rgba(255,255,255,0.15);
  color: white;
  border-radius: 8px;
  font-size: 13px;
}

/* BACK BUTTON */
.back-button {
  display: block;
  text-align: center;
  margin-top: 15px;

  padding: 12px;
  border-radius: 30px;

  background: rgba(255,255,255,0.25);
  color: white;
  text-decoration: none;
  font-weight: bold;

  transition: 0.3s;
}

.back-button:hover {
  background: rgba(255,255,255,0.4);
}
</style>
</head>

<body>

<div class="form-container">

  <h2>BARANGAY CLEARANCE</h2>

  <?php if ($success_message): ?>
    <div class="message success"><?= $success_message ?></div>
    <div class="transaction-time">
      Transaction Time: <?= $transaction_time ?>
    </div>
  <?php elseif ($error_message): ?>
    <div class="message error"><?= $error_message ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">

    <label>Full Name</label>
    <input type="text" name="fullname" required>

    <label>Purpose</label>
    <textarea name="purpose" rows="3" required></textarea>

    <label>Upload Valid ID</label>
    <input type="file" name="user_image" accept="image/*">

    <input type="submit" value="Submit Request">

  </form>

  <a class="back-button" href="services.php">← Back to Services</a>

</div>

</body>
</html>