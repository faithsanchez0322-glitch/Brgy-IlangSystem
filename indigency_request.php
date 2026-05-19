<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");

$message = "";
$image_path = "";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["full_name"]);
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $address = trim($_POST["address"]);
    $purpose = trim($_POST["purpose"]);

    $target_dir = "uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    /* IMAGE UPLOAD */
    if (!empty($_FILES["user_image"]["name"])) {

        $image_name = basename($_FILES["user_image"]["name"]);

        $target_file = $target_dir . time() . "_" . $image_name;

        $imageFileType = strtolower(
            pathinfo($target_file, PATHINFO_EXTENSION)
        );

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {

            if (
                move_uploaded_file(
                    $_FILES["user_image"]["tmp_name"],
                    $target_file
                )
            ) {

                $image_path = $target_file;

            } else {

                $message = "
                <span class='error'>
                    Error uploading image.
                </span>";
            }

        } else {

            $message = "
            <span class='error'>
                Only JPG, JPEG, PNG & GIF allowed.
            </span>";
        }
    }

    /* INSERT */
    if (empty($message)) {

        $stmt = $conn->prepare("
            INSERT INTO indigency_requests
            (full_name, age, gender, address, purpose, image_path)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sissss",
            $name,
            $age,
            $gender,
            $address,
            $purpose,
            $image_path
        );

        if ($stmt->execute()) {

            $message = "
            <span class='success'>
                Request submitted successfully!
            </span>";

        } else {

            $message = "
            <span class='error'>
                Error: {$stmt->error}
            </span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Indigency Certificate</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* BACKGROUND */
body{
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:url('BIISMS.png') no-repeat center center fixed;
    background-size:cover;

    position:relative;
}

/* DARK OVERLAY */
body::before{
    content:"";
    position:fixed;
    inset:0;

    background:rgba(0,40,0,0.60);

    z-index:0;
}

/* FORM CARD */
form{
    position:relative;
    z-index:1;

    width:100%;
    max-width:550px;

    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(15px);

    padding:35px;
    border-radius:20px;

    box-shadow:0 10px 35px rgba(0,0,0,0.45);

    animation:fadeIn 0.7s ease;
}

/* ANIMATION */
@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* TITLE */
h2{
    text-align:center;
    color:white;

    margin-bottom:20px;

    font-size:30px;
}

/* LABEL */
label{
    color:#eaffea;
    font-weight:bold;
    display:block;
    margin-top:12px;
}

/* INPUTS */
input,
textarea,
select{
    width:100%;

    padding:13px;
    margin-top:8px;
    margin-bottom:15px;

    border:none;
    border-radius:12px;

    background:rgba(255,255,255,0.90);
    color:black;

    outline:none;

    font-size:15px;
}

/* PLACEHOLDER */
input::placeholder,
textarea::placeholder{
    color:#555;
}

/* SELECT */
select{
    cursor:pointer;
    font-weight:bold;
}

/* TEXTAREA */
textarea{
    resize:none;
    height:100px;
}

/* MESSAGE */
.message{
    text-align:center;
    margin-bottom:15px;

    font-weight:bold;
    font-size:15px;
}

.success{
    color:#00ff99;
}

.error{
    color:#ff6b6b;
}

/* BUTTON */
button{
    width:100%;

    padding:13px;
    margin-top:10px;

    border:none;
    border-radius:30px;

    font-size:16px;
    font-weight:bold;

    cursor:pointer;
    transition:0.3s;
}

/* SUBMIT */
.submit-button{
    background:linear-gradient(45deg,#00c853,#009624);
    color:white;
}

.submit-button:hover{
    transform:scale(1.03);
    box-shadow:0 5px 20px rgba(0,200,83,0.45);
}

/* BACK */
.back-button{
    background:white;
    color:#064420;
}

.back-button:hover{
    background:#dfffe0;
    transform:scale(1.03);
}

/* MOBILE */
@media(max-width:600px){

    form{
        margin:20px;
        padding:25px;
    }

    h2{
        font-size:24px;
    }
}

</style>
</head>

<body>

<form method="POST" enctype="multipart/form-data">

    <h2>📄 Indigency Certificate</h2>

    <?php if (!empty($message)): ?>

        <div class="message">
            <?= $message ?>
        </div>

    <?php endif; ?>

    <!-- FULL NAME -->
    <label>Full Name</label>

    <input
        type="text"
        name="full_name"
        placeholder="Enter full name"
        required
    >

    <!-- AGE -->
    <label>Age</label>

    <input
        type="number"
        name="age"
        placeholder="Enter age"
        min="1"
        required
    >

    <!-- GENDER -->
    <label>Gender</label>

    <select name="gender" required>

        <option value="" disabled selected>
            Select Gender
        </option>

        <option value="Male">
            Male
        </option>

        <option value="Female">
            Female
        </option>

    </select>

    <!-- ADDRESS -->
    <label>Address</label>

    <textarea
        name="address"
        placeholder="Enter complete address"
        required
    ></textarea>

    <!-- PURPOSE -->
    <label>Purpose</label>

    <textarea
        name="purpose"
        placeholder="Purpose of request"
        required
    ></textarea>

    <!-- IMAGE -->
    <label>Upload Valid ID</label>

    <input
        type="file"
        name="user_image"
        accept="image/*"
    >

    <!-- BUTTON -->
    <button type="submit" class="submit-button">
        Submit Request
    </button>

    <button
        type="button"
        class="back-button"
        onclick="history.back()"
    >
        ← Go Back
    </button>

</form>

</body>
</html>