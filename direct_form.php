<?php
// Start session (optional)
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "barangay_db";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Message
$message = "";

// Handle form submission DIRECTLY
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $address = $_POST['address'];

    // Simple insert query
    $sql = "INSERT INTO residents (name, address) VALUES ('$name', '$address')";

    if ($conn->query($sql) === TRUE) {
        $message = "✅ Data saved successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Direct Form</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }
        .container {
            width: 400px;
            margin: 80px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            padding: 10px;
            width: 100%;
            background: green;
            color: white;
            border: none;
        }
        .msg {
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Resident Form</h2>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Enter Name" required>
        <textarea name="address" placeholder="Enter Address" required></textarea>
        <button type="submit">Submit</button>
    </form>

    <div class="msg">
        <?php echo $message; ?>
    </div>
</div>

</body>
</html>