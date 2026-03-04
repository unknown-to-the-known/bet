<?php 

        require 'vendor/autoload.php';        
        use Aws\S3\S3Client;
        use Aws\S3\Exception\S3Exception;
        $bucketName = 'rev-user';
        $IAM_KEY = 'AKIAYN4LIQUHNSJVSAOV';
        $IAM_SECRET = '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';

        // Connect to AWS
        try {
                // You may need to change the region. It will say in the URL when the bucket is open
                // and on creation.
                $s3 = S3Client::factory(
                    array(
                        'credentials' => array(
                        'key' => $IAM_KEY,
                        'secret' => $IAM_SECRET
                        ),
                        'version' => 'latest',
                        'region'  => 'ap-south-1',
                        'ACL' => 'public-read',
                        'signature_version' => 'v4'
                    )
                );
        } catch (Exception $e) {
                // We use a die, so if this fails. It stops here. Typically this is a REST call so this would
                // return a json object.
                die("Error: " . $e->getMessage());
        }
?>