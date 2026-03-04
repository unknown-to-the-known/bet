<?php
$upi_id = "9164454002@ybl";  // Replace with your actual UPI ID
$amount = "100";          // Prefilled amount in INR

// Generate UPI deep link
$upi_link = "upi://pay?pa=$upi_id&am=$amount&cu=INR";

// Generate QR Code using QuickChart API
$qr_code_url = "https://quickchart.io/qr?text=" . urlencode($upi_link) . "&size=300";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI QR Code</title>
</head>
<body>
    <img src="<?= $qr_code_url ?>" alt="UPI QR Code">
</body>
</html>
