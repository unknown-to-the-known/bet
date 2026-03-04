<?php
// Load AWS SDK from shared vendor folder hosted in your subdomain
require '/var/www/vhosts/revisewell.com/aws.revisewell.com/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// DigitalOcean Spaces config (S3-compatible)
$spaceName = 'rev-users'; // your space name
$region = 'blr1';                // your space region
$endpoint = "https://$region.digitaloceanspaces.com";
$accessKey = 'DO00M98C2YG6Y8YWQUVD';
$secretKey = 'jkIslV8WX8IFowuGllOK8VRj2OiTpihqLf9wbgZS0jU';

$s3 = new S3Client([
    'version'     => 'latest',
    'region'      => $region,
    'endpoint'    => $endpoint,
    'credentials' => [
        'key'    => $accessKey,
        'secret' => $secretKey,
    ],
    'bucket_endpoint' => false,
    'use_path_style_endpoint' => false,
]);

if (isset($_POST['submit']) && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $fileName = basename($file['name']);
    $fileTmpPath = $file['tmp_name'];
    $fileType = mime_content_type($fileTmpPath);

    try {
        $result = $s3->putObject([
            'Bucket' => $spaceName,
            'Key'    => "uploads/" . $fileName,
            'SourceFile' => $fileTmpPath,
            'ACL'    => 'public-read',
            'ContentType' => $fileType,
        ]);

        echo "✅ Upload successful!<br>🔗 File URL: <a href='" . $result['ObjectURL'] . "'>" . $result['ObjectURL'] . "</a>";
    } catch (AwsException $e) {
        echo "❌ Upload failed: " . $e->getMessage();
    }
}
?>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <button type="submit" name="submit">Upload Image</button>
</form>
