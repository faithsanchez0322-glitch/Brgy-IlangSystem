<?php
$conn = new mysqli("localhost", "root", "", "barangay_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$success = false;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid resident ID.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $photo_path = $_POST['existing_photo'] ?? '';

    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = basename($_FILES["profile_photo"]["name"]);
        $photo_path = $targetDir . uniqid() . "_" . $fileName;
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $photo_path);
    }

    $stmt = $conn->prepare("UPDATE residents SET
        full_name=?, gender=?, birthdate=?, birthplace=?, civil_status=?, citizenship=?,
        address=?, phone=?, email=?, father_name=?, father_birthplace=?, mother_name=?,
        mother_birthplace=?, educational_attainment=?, religion=?, height=?, weight=?,
        complexion=?, identifying_marks=?, profile_photo=?
        WHERE id=?");

    $stmt->bind_param("sssssssssssssssssssssi",
        $_POST['full_name'], $_POST['gender'], $_POST['birthdate'], $_POST['birthplace'],
        $_POST['civil_status'], $_POST['citizenship'], $_POST['address'], $_POST['phone'], $_POST['email'],
        $_POST['father_name'], $_POST['father_birthplace'], $_POST['mother_name'], $_POST['mother_birthplace'],
        $_POST['educational_attainment'], $_POST['religion'], $_POST['height'], $_POST['weight'], $_POST['complexion'], $_POST['identifying_marks'],
        $photo_path,
        $id
    );

    if ($stmt->execute()) {
        $message = "✅ Resident updated successfully!";
        $success = true;
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM residents WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Resident not found.");
}
$resident = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Resident</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('LOGO.png') no-repeat center center fixed;
            background-size: cover;
            padding: 40px;
        }

        form {
            background: rgba(255, 255, 255, 0.95);
            max-width: 850px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: white;
            color: darkgreen;
            border: 2px solid darkgreen;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            transition: background 0.3s, color 0.3s;
        }

        button:hover {
            background-color: darkgreen;
            color: white;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: <?= $success ? "'green'" : "'red'" ?>;
        }

        img.profile-photo {
            max-width: 150px;
            display: block;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<form action="edit_resident.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
    <h2>Edit Resident Profile</h2>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <div class="form-group"><label>Full Name</label><input type="text" name="full_name" value="<?= htmlspecialchars($resident['full_name']) ?>" required></div>
    <div class="form-group"><label>Gender</label>
        <select name="gender">
            <option value="Female" <?= $resident['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            <option value="Male" <?= $resident['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
        </select>
    </div>
    <div class="form-group"><label>Birthdate</label><input type="date" name="birthdate" value="<?= htmlspecialchars($resident['birthdate']) ?>"></div>
    <div class="form-group"><label>Birthplace</label><input type="text" name="birthplace" value="<?= htmlspecialchars($resident['birthplace']) ?>"></div>
    <div class="form-group"><label>Civil Status</label>
        <select name="civil_status">
            <option value="Single" <?= $resident['civil_status'] == 'Single' ? 'selected' : '' ?>>Single</option>
            <option value="Married" <?= $resident['civil_status'] == 'Married' ? 'selected' : '' ?>>Married</option>
        </select>
    </div>
    <div class="form-group"><label>Citizenship</label><input type="text" name="citizenship" value="<?= htmlspecialchars($resident['citizenship']) ?>"></div>

    <div class="form-group"><label>Address</label><input type="text" name="address" value="<?= htmlspecialchars($resident['address']) ?>"></div>
    <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?= htmlspecialchars($resident['phone']) ?>"></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($resident['email']) ?>"></div>

    <div class="form-group"><label>Father Name</label><input type="text" name="father_name" value="<?= htmlspecialchars($resident['father_name']) ?>"></div>
    <div class="form-group"><label>Father Birthplace</label><input type="text" name="father_birthplace" value="<?= htmlspecialchars($resident['father_birthplace']) ?>"></div>
    <div class="form-group"><label>Mother Name</label><input type="text" name="mother_name" value="<?= htmlspecialchars($resident['mother_name']) ?>"></div>
    <div class="form-group"><label>Mother Birthplace</label><input type="text" name="mother_birthplace" value="<?= htmlspecialchars($resident['mother_birthplace']) ?>"></div>

    <div class="form-group"><label>Educational Attainment</label><input type="text" name="educational_attainment" value="<?= htmlspecialchars($resident['educational_attainment']) ?>"></div>
    <div class="form-group"><label>Religion</label><input type="text" name="religion" value="<?= htmlspecialchars($resident['religion']) ?>"></div>
    <div class="form-group"><label>Height</label><input type="text" name="height" value="<?= htmlspecialchars($resident['height']) ?>"></div>
    <div class="form-group"><label>Weight</label><input type="text" name="weight" value="<?= htmlspecialchars($resident['weight']) ?>"></div>
    <div class="form-group"><label>Complexion</label><input type="text" name="complexion" value="<?= htmlspecialchars($resident['complexion']) ?>"></div>
    <div class="form-group"><label>Identifying Marks</label><input type="text" name="identifying_marks" value="<?= htmlspecialchars($resident['identifying_marks']) ?>"></div>

    <div class="form-group">
        <label>Profile Photo</label><br>
        <?php if (!empty($resident['profile_photo']) && file_exists($resident['profile_photo'])): ?>
            <img src="<?= htmlspecialchars($resident['profile_photo']) ?>" alt="Profile Photo" class="profile-photo" />
        <?php else: ?>
            <p>No photo uploaded.</p>
        <?php endif; ?>
        <input type="file" name="profile_photo">
        <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($resident['profile_photo']) ?>">
    </div>

    <button type="submit">Update Resident</button>
</form>

</body>
</html>

<?php $conn->close(); ?>
