<?php
include "auth_admin.php";
include "db.php";

/* GET REQUEST ID */
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

/* FETCH APPROVED RECORD */
$stmt = $conn->prepare("SELECT * FROM residency_requests WHERE id = ? AND status='Approved'");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

/* CHECK IF RECORD EXISTS */
if (!$data) {
    die("❌ Residency certificate not found or request is not approved.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Residency Certificate</title>

<style>

body{
    font-family:'Times New Roman', serif;
    background:#f2f2f2;
    padding:30px;
}

/* PRINT BUTTON */
.print-btn{
    display:block;
    margin:0 auto 20px;
    padding:12px 25px;
    border:none;
    background:#0b3d0b;
    color:white;
    font-size:16px;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.print-btn:hover{
    background:#145c14;
}

/* CERTIFICATE */
.certificate{
    width:850px;
    margin:auto;
    background:white;
    padding:60px;
    border:12px solid #0b3d0b;
    position:relative;

    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

/* WATERMARK */
.watermark{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    opacity:0.05;
    width:350px;
}

/* HEADER */
.header{
    text-align:center;
    margin-bottom:40px;
}

.header img{
    width:90px;
    margin-bottom:10px;
}

.header h1{
    font-size:30px;
    color:#0b3d0b;
}

.header h2{
    font-size:22px;
    margin-top:10px;
}

.header p{
    font-size:15px;
}

/* BODY */
.content{
    font-size:20px;
    line-height:2;
    text-align:justify;
    margin-top:30px;
}

.name{
    font-weight:bold;
    text-decoration:underline;
}

.purpose{
    font-weight:bold;
}

/* SIGNATURES */
.footer{
    margin-top:90px;
    display:flex;
    justify-content:space-between;
    text-align:center;
}

.sign{
    width:250px;
}

.sign-line{
    border-top:1px solid black;
    margin-bottom:8px;
}

/* PRINT STYLE */
@media print{

    .print-btn{
        display:none;
    }

    body{
        background:white;
        padding:0;
    }

    .certificate{
        box-shadow:none;
        border:10px solid #000;
    }
}

</style>
</head>

<body>

<button class="print-btn" onclick="window.print()">
🖨 Print Residency Certificate
</button>

<div class="certificate">

    <!-- WATERMARK -->
    <img src="LOGO.png" class="watermark">

    <!-- HEADER -->
    <div class="header">

        <img src="BIISMS.png">

        <h1>REPUBLIC OF THE PHILIPPINES</h1>

        <p>Province of Davao del Sur</p>
        <p>Municipality / City</p>
        <p><strong>BARANGAY OFFICE</strong></p>

        <h2>CERTIFICATE OF RESIDENCY</h2>

    </div>

    <!-- CONTENT -->
    <div class="content">

        To whom it may concern:

        <br><br>

        This is to certify that 
        <span class="name">
            <?= htmlspecialchars($data['fullname']) ?>
        </span>
        is a bonafide resident of this barangay.

        <br><br>

        This certification is issued upon the request of the above-named person
        for <span class="purpose">whatever legal purpose it may serve.</span>

        <br><br>

        Issued this 
        <strong><?= date("F d, Y") ?></strong>
        at Barangay Office.

    </div>

    <!-- FOOTER -->
    <div class="footer">

        <div class="sign">
            <div class="sign-line"></div>
            Barangay Secretary
        </div>

        <div class="sign">
            <div class="sign-line"></div>
            Barangay Captain
        </div>

    </div>

</div>

</body>
</html>