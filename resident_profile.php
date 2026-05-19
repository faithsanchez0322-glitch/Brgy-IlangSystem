<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "barangay_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use a static resident ID for demo; replace with session or GET param as needed
$resident_id = 1;

// Messages
$message = "";

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $del_stmt = $conn->prepare("DELETE FROM residents WHERE id = ?");
    $del_stmt->bind_param("i", $delete_id);
    if ($del_stmt->execute()) {
        echo "<script>alert('Resident deleted successfully.'); window.location.href='resident_profile.php';</script>";
        exit();
    } else {
        $message = "Failed to delete resident.";
    }
}

// Handle update
if (isset($_GET['action']) && $_GET['action'] === 'edit' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];

    // Get current photo path
    $sql_photo = "SELECT profile_photo FROM residents WHERE id = ?";
    $stmt_photo = $conn->prepare($sql_photo);
    $stmt_photo->bind_param("i", $resident_id);
    $stmt_photo->execute();
    $result_photo = $stmt_photo->get_result();
    $row_photo = $result_photo->fetch_assoc();
    $current_photo = $row_photo['profile_photo'] ?? "uploads/default.jpg";

    $profile_photo = $current_photo;

    // Handle image upload
    if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["error"] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = time() . "_" . basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $profile_photo = $target_file;
            // Delete old photo if not default
            if ($current_photo != "uploads/default.jpg" && file_exists($current_photo)) {
                unlink($current_photo);
            }
        }
    }

    // Update resident data
    $sql_update = "UPDATE residents SET full_name=?, email=?, phone=?, address=?, birthdate=?, gender=?, profile_photo=? WHERE id=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssssi", $full_name, $email, $phone, $address, $birthdate, $gender, $profile_photo, $resident_id);

    if ($stmt_update->execute()) {
        $message = "Resident updated successfully!";
    } else {
        $message = "Update failed: " . $stmt_update->error;
    }
}

// Fetch resident data
$sql = "SELECT * FROM residents WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $resident_id);
$stmt->execute();
$result = $stmt->get_result();
$resident = $result->fetch_assoc();

if (!$resident) {
    die("Resident not found.");
}

// Determine mode (view or edit)
$mode = (isset($_GET['action']) && $_GET['action'] === 'edit') ? 'edit' : 'view';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Resident Profile | Barangay Ilang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('BIISMS.png') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            background: rgba(255, 255, 255, 0.95);
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }
        .profile-photo, .profile-photo-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007BFF;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        h2 {
            margin-top: 0;
            color: #007BFF;
            text-align: center;
        }
        .profile-info {
            margin: 15px 0;
        }
        .label {
            font-weight: bold;
            color: #444;
        }
        .value {
            margin-left: 10px;
            color: #222;
        }
        .btn-group {
            margin-top: 25px;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin: 0 5px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit {
            background-color: #28a745;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        form {
            display: inline;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-top: 10px;
        }
        button.submit-btn {
            width: 100%;
            background-color: #004d00;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button.submit-btn:hover {
            background-color: #004d00;
        }
        .message {
            text-align: center;
            font-weight: bold;
            color: green;
            margin-top: 15px;
        }
        a.back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #004d00;
            text-decoration: none;
        }
        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
<?php if ($mode === 'view'): ?>

    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <img class="profile-photo" src="<?php echo htmlspecialchars($resident['profile_photo']); ?>" alt="Profile Photo">
    <h2><?php echo htmlspecialchars($resident['full_name']); ?></h2>

    <div class="profile-info"><span class="label">Email:</span><span class="value"><?php echo htmlspecialchars($resident['email']); ?></span></div>
    <div class="profile-info"><span class="label">Phone:</span><span class="value"><?php echo htmlspecialchars($resident['phone']); ?></span></div>
    <div class="profile-info"><span class="label">Address:</span><span class="value"><?php echo htmlspecialchars($resident['address']); ?></span></div>
    <div class="profile-info"><span class="label">Birthdate:</span><span class="value"><?php echo date("F j, Y", strtotime($resident['birthdate'])); ?></span></div>
    <div class="profile-info"><span class="label">Gender:</span><span class="value"><?php echo htmlspecialchars($resident['gender']); ?></span></div>
    <div class="profile-info"><span class="label">Registered Since:</span><span class="value"><?php echo date("F j, Y", strtotime($resident['created_at'])); ?></span></div>

    <div class="btn-group">
        <a href="?action=edit" class="btn btn-edit">Edit</a>
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this resident?');">
            <input type="hidden" name="delete_id" value="<?php echo $resident['id']; ?>">
            <button type="submit" class="btn btn-delete">Delete</button>
        </form>
    </div>

<?php elseif ($mode === 'edit'): ?>

    <a href="resident_profile.php" class="back-link">← Back to Profile</a>
    <h2>Edit Resident</h2>

    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="?action=edit">
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($resident['full_name']); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($resident['email']); ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($resident['phone']); ?>" required>

        <label>Address</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($resident['address']); ?>" required>

        <label>Birthdate</label>
        <input type="date" name="birthdate" value="<?php echo htmlspecialchars($resident['birthdate']); ?>" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="Male" <?php echo ($resident['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($resident['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>

        <label>Profile Photo</label>
        <img src="<?php echo htmlspecialchars($resident['profile_photo']); ?>" alt="Profile Photo" class="profile-photo-preview">
        <input type="file" name="profile_photo" accept="image/*">

        <button type="submit" class="submit-btn">Update Resident</button>
    </form>

<?php endif; ?>
</div>

</body>
</html>
