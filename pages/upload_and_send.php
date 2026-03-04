<?php
require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

date_default_timezone_set('Asia/Kolkata');

$whatsapp = $_POST['phone'];
$school_name = $_POST['school_name'];
$filename = 'receipt_' . $whatsapp . '_' . time() . '.pdf';

// === DO Spaces Config ===
$space_name = 'rev-users';
$region = 'blr1'; // or nyc3, sgp1 etc.
$access_key = 'DO00H47WCGZNWF2D3JWV';
$secret_key = '2cpLmblWbg2pTxMc3wVR6l3cy9qp0m28rcgITySFJBQ';
$endpoint = "https://{$region}.digitaloceanspaces.com";

// === Initialize Client ===
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => $region,
    'endpoint' => $endpoint,
    'credentials' => [
        'key'    => $access_key,
        'secret' => $secret_key,
    ],
    'bucket_endpoint' => false,
    'use_path_style_endpoint' => false,
]);

try {
    // Upload file to Spaces
    $result = $s3->putObject([
        'Bucket' => $space_name,
        'Key'    => "receipts/{$filename}",
        'Body'   => fopen($_FILES['file']['tmp_name'], 'rb'),
        'ACL'    => 'public-read', // or use signed URLs if private
        'ContentType' => 'application/pdf',
    ]);

    // File URL
    $file_url = $result['ObjectURL'];

    // === Green API WhatsApp ===
    $green_instance = '7105206644';
    $green_token = 'aca8587084c6411f8ce0ab8bcf994f587b52bcf7b73e4f5eb8';
    $chatId = '91' . $whatsapp . '@c.us';

    $payload = json_encode([
        'chatId' => $chatId,
        'urlFile' => $file_url,
        'fileName' => 'Fee Receipt.pdf',
        'caption' => 'Fee Receipt from ' . $school_name
    ]);

    $green_api_url = "https://api.green-api.com/waInstance{$green_instance}/sendFileByUrl/{$green_token}";

    $ch = curl_init($green_api_url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo json_encode(['status' => 'success', 'message' => 'Uploaded & sent via WhatsApp.', 'url' => $file_url]);
} catch (S3Exception $e) {
    echo json_encode(['status' => 'fail', 'message' => 'Upload failed: ' . $e->getMessage()]);
}
?>
