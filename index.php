<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>BISMS - Barangay Portal</title>

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
    flex-direction: column;

    background: url('BIISMS.png') no-repeat center center fixed;
    background-size: cover;
    position: relative;
}

/* 🌫️ LIGHT GOVERNMENT OVERLAY */
body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: rgba(0, 30, 0, 0.45);
    z-index: 0;
}

/* 🇵🇭 TOP GOV BAR */
.topbar {
    position: relative;
    z-index: 1;
    background: #0b3d0b;
    color: #fff;
    padding: 8px 20px;
    font-size: 12px;
    display: flex;
    justify-content: space-between;
}

/* HEADER */
header {
    position: relative;
    z-index: 1;
    background: rgba(0, 70, 0, 0.95);
    color: white;
    text-align: center;
    padding: 18px;
    font-size: 18px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* MAIN WRAPPER */
.wrapper {
    position: relative;
    z-index: 1;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px;
}

/* CARD */
.container {
    width: 100%;
    max-width: 600px;
    padding: 45px;

    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(14px);
    border-radius: 16px;

    box-shadow: 0 12px 35px rgba(0,0,0,0.5);

    text-align: center;
    animation: fadeIn 0.8s ease;
}

/* ANIMATION */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
}

/* TITLE */
.container h1 {
    font-size: 32px;
    color: #fff;
    margin-bottom: 10px;
}

/* DESCRIPTION */
.container p {
    color: #e8ffe8;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 25px;
}

/* INFO BOX (like LGU notice) */
.info-box {
    background: rgba(255,255,255,0.15);
    padding: 12px;
    border-radius: 10px;
    color: #fff;
    font-size: 13px;
    margin-bottom: 20px;
}

/* BUTTONS */
.btn {
    display: block;
    width: 100%;
    padding: 13px;
    margin: 10px 0;

    border-radius: 30px;
    text-decoration: none;
    font-weight: bold;
    font-size: 15px;

    transition: 0.3s;
}

/* LOGIN */
.btn-login {
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    color: white;
}

.btn-login:hover {
    transform: scale(1.04);
    box-shadow: 0 6px 20px rgba(0,114,255,0.5);
}

/* REGISTER */
.btn-register {
    background: linear-gradient(45deg, #ff512f, #dd2476);
    color: white;
}

.btn-register:hover {
    transform: scale(1.04);
    box-shadow: 0 6px 20px rgba(255,81,47,0.5);
}

/* FOOTER */
footer {
    position: relative;
    z-index: 1;
    background: #0b3d0b;
    color: white;
    text-align: center;
    padding: 14px;
    font-size: 13px;
}

/* MOBILE */
@media (max-width: 600px) {
    .container {
        padding: 25px;
    }

    .container h1 {
        font-size: 24px;
    }
}
</style>
</head>

<body>

<div class="topbar">
    <span>Republic of the Philippines</span>
    <span>Barangay Ilang, Davao City</span>
</div>

<header>
    Barangay Ilang Integrated Services Management System
</header>

<div class="wrapper">
    <div class="container">

        <h1>Welcome to BISMS</h1>

        <div class="info-box">
            A secure and centralized system for barangay services such as certificates,
            complaints, appointments, and announcements.
        </div>

        <p>
            Access government services anytime, anywhere. Fast, transparent, and reliable
            barangay transactions for residents.
        </p>

        <a href="login.php" class="btn btn-login">Login to Portal</a>
        <a href="register.php" class="btn btn-register">Create Account</a>

    </div>
</div>

<footer>
    &copy; 2026 Barangay Ilang Integrated Services Management System
</footer>

</body>
</html>
