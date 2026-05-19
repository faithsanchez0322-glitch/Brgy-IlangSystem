<?php
session_start();

date_default_timezone_set('Asia/Manila');

$conn = new mysqli("localhost", "root", "", "barangay_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* =========================
   CHECK ID
========================= */

if(!isset($_GET['id'])){
    die("No ID Found");
}

$id = intval($_GET['id']);

/* =========================
   FETCH DATA
========================= */

$stmt = $conn->prepare("
    SELECT *
    FROM clearance_requests
    WHERE id=?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Certificate not found");
}

$row = $result->fetch_assoc();

/* =========================
   VALUES
========================= */

$fullname = strtoupper($row['fullname']);
$purpose = strtoupper($row['purpose']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Barangay Clearance Certificate</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Times New Roman', serif;
}

/* BODY */
body{
    background:#d9d9d9;
    padding:30px;
}

/* BUTTONS */
.top-buttons{
    text-align:center;
    margin-bottom:20px;
}

.print-btn,
.back-btn{
    display:inline-block;
    padding:12px 28px;
    margin:5px;

    border:none;
    border-radius:8px;

    text-decoration:none;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;

    transition:0.3s;
}

.print-btn{
    background:#0b5d2a;
    color:white;
}

.print-btn:hover{
    background:#08441e;
}

.back-btn{
    background:#ffffff;
    color:#064420;
}

.back-btn:hover{
    background:#e9ffe9;
}

/* CERTIFICATE PAPER */
.certificate{
    width:850px;
    min-height:1100px;

    background:white;
    margin:auto;

    padding:70px 80px;
    position:relative;

    box-shadow:0 0 20px rgba(0,0,0,0.25);
}

/* WATERMARK */
.watermark{
    position:absolute;
    top:270px;
    left:50%;
    transform:translateX(-50%);
    width:520px;
    opacity:0.05;
}

/* LOGO */
.logo{
    position:absolute;
    top:65px;
    left:75px;
    width:95px;
}

/* HEADER */
.header{
    text-align:center;
    line-height:1.5;
}

.header h2{
    font-size:24px;
    margin-top:8px;
}

.header h3{
    margin-top:8px;
    font-size:18px;
}

.header hr{
    margin-top:20px;
}

/* TITLE */
.title{
    text-align:center;
    margin:40px 0;

    font-size:48px;
    font-weight:bold;

    letter-spacing:2px;
    text-decoration:underline;
}

/* CONTENT */
.content{
    font-size:25px;
    line-height:2;
    text-align:justify;
}

.content p{
    margin-bottom:30px;
    text-indent:70px;
}

/* HIGHLIGHT */
.highlight{
    font-weight:bold;
    text-decoration:underline;
}

/* SIGNATURES */
.signatures{
    margin-top:120px;

    display:flex;
    justify-content:space-between;
}

.signature-box{
    width:280px;
    text-align:center;
    font-size:20px;
}

.signature-line{
    margin-top:70px;
    border-top:2px solid black;
    padding-top:10px;
    font-weight:bold;
}

/* THUMBMARK */
.thumbmark{
    margin-top:90px;
    font-size:20px;
}

/* FOOTER */
.footer{
    margin-top:120px;

    border-top:2px solid black;
    padding-top:20px;

    text-align:center;
    font-size:17px;
}

/* PRINT */
@media print{

    body{
        background:white;
        padding:0;
    }

    .top-buttons{
        display:none;
    }

    .certificate{
        box-shadow:none;
        width:100%;
        min-height:auto;
    }
}

/* MOBILE */
@media(max-width:900px){

    .certificate{
        width:100%;
        padding:50px 30px;
    }

    .title{
        font-size:36px;
    }

    .content{
        font-size:20px;
    }

    .logo{
        width:70px;
        left:30px;
    }

    .signatures{
        flex-direction:column;
        gap:50px;
        align-items:center;
    }
}

</style>
</head>

<body>

<div class="top-buttons">

    <button onclick="window.print()" class="print-btn">
        🖨 Print Certificate
    </button>

    <a href="clearance_admin.php" class="back-btn">
        ← Back
    </a>

</div>

<div class="certificate">

    <!-- WATERMARK -->
    <img src="LOGO.png" class="watermark">

    <!-- LOGO -->
    <img src="LOGO.png" class="logo">

    <!-- HEADER -->
    <div class="header">

        <div>Republic of the Philippines</div>
        <div>City of Davao</div>
        <div>District of Bunawan</div>

        <h2>BARANGAY ILANG</h2>

        <h3>OFFICE OF THE PUNONG BARANGAY</h3>

        <hr>

    </div>

    <!-- TITLE -->
    <div class="title">
        CERTIFICATE OF CLEARANCE
    </div>

    <!-- CONTENT -->
    <div class="content">

        <p>
            To whom it may concern;
        </p>

        <p>
            This is to certify that
            <span class="highlight"><?= $fullname ?></span>
            is a bonafide resident of Barangay Ilang,
            Bunawan District, Davao City.
        </p>

        <p>
            This is to certify further that based on the
            records of this office, the bearer has no pending
            civil or criminal case filed in this Barangay.
        </p>

        <p>
            This certification is issued upon the request
            of the bearer for
            <span class="highlight"><?= $purpose ?></span>
            and for whatever legal purpose it may serve best.
        </p>

        <p>
            Issued this
            <span class="highlight"><?= date("jS") ?></span>
            day of
            <span class="highlight"><?= strtoupper(date("F Y")) ?></span>
            at Barangay Ilang, Bunawan District,
            Davao City.
        </p>

    </div>

    <!-- SIGNATURES -->
    <div class="signatures">

        <div class="signature-box">

            <div class="signature-line">
                <?= $fullname ?>
            </div>

            Applicant Signature

        </div>

        <div class="signature-box">

            <div class="signature-line">
                HON. BARANGAY CAPTAIN
            </div>

            Punong Barangay

        </div>

    </div>

    <!-- THUMBMARK -->
    <div class="thumbmark">

        ____________________ <br>
        RIGHT THUMBMARK

    </div>

    <!-- FOOTER -->
    <div class="footer">

        Km. 17 Daang Maharlika Highway,
        Ilang, Bunawan District, Davao City

    </div>

</div>

</body>
</html>