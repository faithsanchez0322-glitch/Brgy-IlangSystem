<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $purpose = htmlspecialchars(trim($_POST['purpose']));
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $contact = htmlspecialchars(trim($_POST['contact']));

    $valid_id = "";

    /* IMAGE UPLOAD */
    if(isset($_FILES['valid_id']) && $_FILES['valid_id']['error'] == 0){

        $uploadDir = "uploads/";

        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        $extension = strtolower(pathinfo($_FILES['valid_id']['name'], PATHINFO_EXTENSION));

        $newFileName = uniqid() . "." . $extension;

        $targetFile = $uploadDir . $newFileName;

        if(move_uploaded_file($_FILES['valid_id']['tmp_name'], $targetFile)){
            $valid_id = $targetFile;
        }
    }

    $appointment_number = "APT-" . rand(1000,9999);

    $stmt = $conn->prepare("INSERT INTO appointment_requests
    (appointment_number, full_name, purpose, appointment_date, appointment_time, contact, valid_id_path, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')");

    $stmt->bind_param(
        "sssssss",
        $appointment_number,
        $fullname,
        $purpose,
        $appointment_date,
        $appointment_time,
        $contact,
        $valid_id
    );

    if($stmt->execute()){
        $success = "Appointment submitted successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modern Appointment Form</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;

    background:url('LOGO.png') no-repeat center center fixed;
    background-size:cover;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:20px;
    position:relative;
}

/* DARK OVERLAY */
body::before{
    content:"";
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,40,0,0.70);
    z-index:0;
}

/* FORM CARD */
.form-container{
    position:relative;
    z-index:2;

    width:100%;
    max-width:500px;

    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(14px);

    border-radius:25px;
    padding:35px;

    box-shadow:0 10px 30px rgba(0,0,0,0.4);

    margin:auto;
}

/* TITLE */
h1{
    text-align:center;
    color:white;
    margin-bottom:25px;
    font-size:32px;
}

/* SUCCESS */
.success{
    background:#d4edda;
    color:#155724;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    text-align:center;
    font-weight:bold;
}

/* LABEL */
label{
    color:white;
    display:block;
    margin-bottom:8px;
    margin-top:15px;
    font-size:14px;
}

/* INPUTS */
input,
textarea{
    width:100%;
    padding:13px;

    border:none;
    border-radius:12px;

    background:rgba(255,255,255,0.20);
    color:white;

    outline:none;
    font-size:15px;
}

textarea{
    resize:none;
    height:110px;
}

input::placeholder,
textarea::placeholder{
    color:#eee;
}

/* FILE INPUT */
input[type="file"]{
    background:rgba(255,255,255,0.12);
    padding:10px;
}

/* DATE & TIME ICON COLOR */
input[type="date"],
input[type="time"]{
    color:white;
}

/* BUTTON */
button{
    width:100%;
    margin-top:25px;
    padding:14px;

    border:none;
    border-radius:30px;

    background:linear-gradient(45deg, #00c853, #009624);

    color:white;
    font-size:16px;
    font-weight:bold;

    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:scale(1.03);
}

/* MOBILE */
@media(max-width:600px){

    .form-container{
        padding:25px;
    }

    h1{
        font-size:26px;
    }
}

</style>
</head>

<body>

<div class="form-container">

    <h1>📅 Appointment Form</h1>

    <?php if($success): ?>
        <div class="success">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Full Name</label>
        <input type="text" name="fullname" placeholder="Enter full name" required>

        <label>Purpose</label>
        <textarea name="purpose" placeholder="Enter purpose" required></textarea>

        <label>Appointment Date</label>
        <input type="date" name="appointment_date" required>

        <label>Appointment Time</label>
        <input type="time" name="appointment_time" required>

        <label>Contact Number</label>
        <input type="text" name="contact" placeholder="09XXXXXXXXX" required>

        <label>Upload Valid ID</label>
        <input type="file" name="valid_id" accept="image/*">

        <button type="submit">
            Submit Appointment
        </button>

    </form>

</div>

</body>
</html>