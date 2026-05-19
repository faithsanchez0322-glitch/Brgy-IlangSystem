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

  $name = $conn->real_escape_string($_POST['name']);
  $address = $conn->real_escape_string($_POST['address']);
  $years = $conn->real_escape_string($_POST['years']);
  $purpose = $conn->real_escape_string($_POST['purpose']);

  $date = date("Y-m-d H:i:s");

  $sql = "INSERT INTO residency_requests 
          (full_name, address, years_of_stay, purpose, status) 
          VALUES ('$name', '$address', '$years', '$purpose', 'Pending')";

  if ($conn->query($sql) === TRUE) {
    $success_message = "Residency request submitted successfully!";
    $transaction_time = date("F j, Y, g:i A", strtotime($date));
  } else {
    $error_message = "Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Residency Request</title>

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

/* 🌫️ OVERLAY */
body::before {
  content: "";
  position: fixed;
  width: 100%;
  height: 100%;
  background: rgba(0, 40, 0, 0.55);
  z-index: 0;
}

/* CARD */
.form-container {
  position: relative;
  z-index: 1;

  width: 100%;
  max-width: 520px;

  padding: 30px;

  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(14px);

  border-radius: 18px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.5);

  animation: fadeIn 0.8s ease;
}

/* ANIMATION */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* TITLE */
h2 {
  text-align: center;
  margin-bottom: 15px;
  color: #eaffea;
}

/* LABEL */
label {
  display: block;
  margin-top: 12px;
  color: #dfffe0;
  font-weight: bold;
}

/* INPUTS */
input, textarea {
  width: 100%;
  padding: 12px;
  margin-top: 8px;

  border: none;
  border-radius: 10px;

  background: rgba(255,255,255,0.25);
  color: white;
  outline: none;
}

/* placeholder */
input::placeholder,
textarea::placeholder {
  color: #eaffea;
}

/* TEXTAREA */
textarea {
  resize: none;
}

/* MESSAGE */
.message {
  text-align: center;
  margin-bottom: 10px;
  font-weight: bold;
}

.success { color: #00ff99; }
.error { color: #ff6b6b; }

/* BUTTON */
input[type="submit"] {
  width: 100%;
  padding: 12px;
  margin-top: 15px;

  border: none;
  border-radius: 30px;

  font-weight: bold;
  font-size: 16px;

  cursor: pointer;

  background: linear-gradient(45deg, #00c853, #009624);
  color: white;

  transition: 0.3s;
}

input[type="submit"]:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 20px rgba(0,200,83,0.4);
}

/* BACK BUTTON */
.back-button {
  display: block;
  text-align: center;

  margin-top: 12px;
  padding: 12px;

  border-radius: 30px;

  text-decoration: none;
  font-weight: bold;

  background: rgba(255,255,255,0.85);
  color: #064420;

  transition: 0.3s;
}

.back-button:hover {
  background: #e6e6e6;
}

/* MOBILE */
@media (max-width: 600px) {
  .form-container {
    margin: 20px;
    padding: 25px;
  }
}
</style>

<script>
function validateForm() {
  const name = document.getElementById("name").value.trim();
  const address = document.getElementById("address").value.trim();
  const years = document.getElementById("years").value.trim();
  const purpose = document.getElementById("purpose").value.trim();

  if (!name || !address || !years || !purpose) {
    alert("Please fill in all fields.");
    return false;
  }

  if (name.length < 3) {
    alert("Full Name must be at least 3 characters.");
    return false;
  }

  return true;
}
</script>

</head>

<body>

<div class="form-container">

  <h2>🏠 Residency Certificate Request</h2>

  <?php if ($success_message): ?>
    <div class="message success"><?= $success_message ?></div>
    <div class="message success">
      Transaction Time: <?= $transaction_time ?>
    </div>
  <?php elseif ($error_message): ?>
    <div class="message error"><?= $error_message ?></div>
  <?php endif; ?>

  <form method="POST" onsubmit="return validateForm()">

    <label>Full Name</label>
    <input type="text" id="name" name="name" placeholder="Enter full name">

    <label>Address</label>
    <input type="text" id="address" name="address" placeholder="Enter address">

    <label>Years of Stay</label>
    <input type="number" id="years" name="years" placeholder="e.g. 5">

    <label>Purpose</label>
    <textarea id="purpose" name="purpose" rows="3" placeholder="State your purpose"></textarea>

    <input type="submit" value="Submit Request">

  </form>

  <a class="back-button" href="services.php">← Back to Services</a>

</div>

</body>
</html>