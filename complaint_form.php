<?php
// complaint_form.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>File a Complaint</title>

<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', sans-serif;
}

/* 🌄 BACKGROUND */
body {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;

  background: url('Logo.png') no-repeat center center fixed;
  background-size: cover;
  position: relative;
}

/* 🌫️ DARK OVERLAY */
body::before {
  content: "";
  position: fixed;
  width: 100%;
  height: 100%;
  background: rgba(0, 30, 0, 0.55);
  z-index: 0;
}

/* FORM CARD */
.form-container {
  position: relative;
  z-index: 1;

  width: 100%;
  max-width: 520px;

  padding: 35px;

  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(14px);

  border-radius: 18px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.5);

  animation: fadeIn 0.8s ease;
  color: white;
}

/* ANIMATION */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* TITLE */
h2 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 24px;
  color: #eaffea;
}

/* LABELS */
label {
  display: block;
  margin-top: 15px;
  font-weight: bold;
  color: #dfffe0;
}

/* INPUTS */
input[type="text"],
textarea,
input[type="file"] {
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

/* BUTTON */
button {
  margin-top: 20px;
  width: 100%;
  padding: 12px;

  border: none;
  border-radius: 30px;

  font-size: 16px;
  font-weight: bold;

  cursor: pointer;
  transition: 0.3s;
}

/* SUBMIT BUTTON */
button[type="submit"] {
  background: linear-gradient(45deg, #00c853, #009624);
  color: white;
}

button[type="submit"]:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 20px rgba(0,200,83,0.4);
}

/* BACK BUTTON */
.back-button {
  background: rgba(255,255,255,0.85);
  color: #064420;
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
</head>

<body>

<div class="form-container">

  <h2>📢 File a Complaint</h2>

  <form action="complaint_submit.php" method="post" enctype="multipart/form-data">

    <label>Your Name</label>
    <input type="text" name="complainant" placeholder="Enter your full name" required />

    <label>Complaint Details</label>
    <textarea name="complaint" rows="6" placeholder="Describe your complaint..." required></textarea>

    <label>Upload Evidence (Image/Video)</label>
    <input type="file" name="evidence" accept="image/*,video/*" />

    <button type="submit">Submit Complaint</button>

    <button type="button" class="back-button" onclick="history.back()">← Go Back</button>

  </form>

</div>

</body>
</html>