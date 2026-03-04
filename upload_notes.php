<?php //require 'includes/config.php'; ?>
<?php require 'includes/db.php'; ?>
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
<?php 	
	$filename = $_FILES['file']['name'];
	$tmp_name = $_FILES['file']['tmp_name'];
	$uniq_name = hash('murmur3f', date('YmdHis'));
    // $video_ext_upload = pathinfo($filename,PATHINFO_EXTENSION);
    // $video_ext = $video_ext_upload['extension'];
	// $ext = explode('.', $filename);
    // $video_ext = $ext[1];
        // echo $generate_new_name = $user_name . '_' . $subject_class_yt . '_' . $user_school . '_' . $subject_name_yt . '_' . $uniq_name . $video_ext;
        // $generate_new_name = md5(uniqid('', true)) . '.' . $video_ext;
    $generate_new_name = $filename;
    $pathInS3 = 'rev-user.s3-accelerate.amazonaws.com/' . $bucketName . '/';
    $pathInS3 . '/' . $generate_new_name; 
	try {                
        	$file = $uniq_name;
        	$result = $s3->putObject(
                    array(
                        'Bucket'=>$bucketName,
                        'Key' =>  $generate_new_name,
                        'SourceFile' => $tmp_name,
                        'StorageClass' => 'REDUCED_REDUNDANCY'
                    )
	        );
	    } catch (S3Exception $e) {
	            echo 'sorry video not uploaded, please try again';
	    } catch (Exception $e) {
	            echo 'sorry video not uploaded, please try again';
	    } 

	 //$insert = mysqli_query($connection, "UPDATE rev_chapter_list SET rev_chapter_notes = '$uniq_name' WHERE tree_id = '115'");
	// move_uploaded_file($tmp_name, $filename);
?>