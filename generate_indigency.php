<?php
require_once __DIR__ . '/vendor/autoload.php';

$conn = new mysqli("localhost", "root", "", "barangay_db");

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM indigency_requests WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$mpdf = new \Mpdf\Mpdf();

$html = '
<h2 style="text-align: center;">Republic of the Philippines</h2>
<h3 style="text-align: center;">Barangay Ilang, Davao City</h3>
<h4 style="text-align: center; text-decoration: underline;">Certificate of Indigency</h4>
<p>This is to certify that <strong>' . htmlspecialchars($data['full_name']) . '</strong>, age ' . $data['age'] . ', gender ' . $data['gender'] . ', residing at ' . htmlspecialchars($data['address']) . ', is known to this office to be an indigent resident of Barangay Ilang.</p>
<p>This certificate is issued upon the request of the above-named person for the purpose of <strong>' . htmlspecialchars($data['purpose']) . '</strong>.</p>
<p style="margin-top: 40px;">Issued this ' . date("jS \of F Y") . ' at Barangay Ilang, Davao City.</p>
<br><br><br>
<p>_________________________<br>Barangay Captain</p>
';

$mpdf->WriteHTML($html);
$mpdf->Output('Indigency_Certificate.pdf', 'I');
