<!-- For Images Only -->
<?php require 'includes/db.php'; ?>
<?php require 'includes/aws_cred.php'; ?>
<?php $time_and_date = date('Y-m-d H:i'); ?>
<?php 	
        $subject_class_yt = htmlspecialchars($_SESSION['subject_class'], ENT_QUOTES, 'UTF-8');
        $user_school = htmlspecialchars($_SESSION['user_school'], ENT_QUOTES, 'UTF-8');
        $subject_name_yt = htmlspecialchars($_SESSION['subject_name'], ENT_QUOTES, 'UTF-8');
        $subject_sec = htmlspecialchars($_SESSION['class_sec'], ENT_QUOTES, 'UTF-8');
        $user_name = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');

        $user_school = str_replace(' ', '_', $user_school);

	    $filename = $_FILES['file']['name'];
	    $tmp_name = $_FILES['file']['tmp_name'];
	    $uniq_name = hash('murmur3f', date('YmdHis'));
        $lastDot = strrpos($filename, ".");
        $string = str_replace(".", "", substr($filename, 0, $lastDot)) . substr($filename, $lastDot); 

        $ext = explode('.', $string);
        $video_ext = $ext[1]; 

        $video_ext = strtolower($video_ext);

        $allowed_ext = array("jpg", "png", "jpeg", "webp", "heif");

        $uniq_session = htmlspecialchars($_SESSION['uniq_identifie'], ENT_QUOTES, 'UTF-8');

        if (!in_array($video_ext, $allowed_ext)) {
            $error_message =  "Only JPG, PNG, JPEG, WEBP, HEIF are allowed";
        }

        if (!isset($error_message)) {
            $generate_new_name = $user_name . '_' . $subject_class_yt . '_' . $user_school . '_' . $subject_name_yt . '_' . $uniq_name . $video_ext . '.' . $video_ext;
            // $generate_new_name = md5(uniqid('', true)) . '.' . $video_ext;
            $pathInS3 = 'rev-user.s3-accelerate.amazonaws.com/' . $bucketName . '/';
            $pathInS3 . '/' . $generate_new_name; 

            try {                
                $file = $uniq_name;
                $result = $s3->putObject(
                    array(
                        'Bucket'=>$bucketName,
                        'Key' =>  $generate_new_name,
                        'SourceFile' => $tmp_name,
                        'StorageClass' => 'REDUCED_REDUNDANCY',                        
                        'ContentType' => 'image/' . $video_ext
                    )
                );
            } catch (S3Exception $e) {
                $error_message = 'sorry video not uploaded, please try again';
            } catch (Exception $e) {
                $error_message = 'sorry video not uploaded, please try again';
            }           
        }

        if (!isset($error_message)) {
            $insert = mysqli_query($connection, "INSERT INTO rev_base64(base64_img_text,uniq_url,rev_uniq_session,rev_uploaded_on,rev_user_id) VALUES ('0', '$generate_new_name', '$uniq_session', '$time_and_date', '$user_name')");        
            }  	

    
          
    
?>