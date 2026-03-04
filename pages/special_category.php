<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
    if (isset($_SESSION['teach_details'])) {
        $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
    } else {
        header("Location: " . BASE_URL . 'index');
    }        
?>
<?php 
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_user_name'], ENT_QUOTES, 'UTF-8');
            $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['rev_user_school_id'], ENT_QUOTES, 'UTF-8');
                       
         }  
    }
?>

<?php 
    $student_uniq_id = $_SESSION['student_id'];
        require '../vendor/autoload.php';        
        use Aws\S3\S3Client;
        use Aws\S3\Exception\S3Exception;

        $bucketName = 'rev-users';
        $IAM_KEY = 'AKIAU6GDZJBY2GZG5MOO';
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

        

     

     



    if (isset($_FILES['file'])) {
            $record_file_upload = $_FILES['file'];            
            $record_audio_name_upload = $_FILES['file']['name'];
            $record_temp_name_upload = $_FILES['file']['tmp_name'];
            $record_size_upload = $_FILES['file']['size'];

            $video_ext_upload = pathinfo($record_audio_name_upload,PATHINFO_EXTENSION);

            if (!isset($error_message_upload)) {
                $uniq_name_upload = hash('murmur3f', date('YmdHis'));
                $generate_new_name_upload = $uniq_name_upload . '.' . $video_ext_upload;

                try {                
                    $file = $uniq_name_upload;
                    $result = $s3->putObject(
                        array(
                            'Bucket'=> $bucketName,
                            'Key' =>  $generate_new_name_upload,
                            'SourceFile' => $record_temp_name_upload,
                            'StorageClass' => 'REDUCED_REDUNDANCY',
                            'ContentType' => ';image/*'
                        )
                );


                } catch (S3Exception $e) {
                        echo 'sorry video not uploaded, please try again';
                } catch (Exception $e) {
                        echo 'sorry video not uploaded, please try again';
                }               

                if (!isset($error_message_upload)) {
                   $update = mysqli_query($connection, "UPDATE  rev_erp_student_details SET rev_special_category_doc = '$generate_new_name_upload' WHERE tree_id = '$student_uniq_id'");
                }
            }            
        } else {
            $error_message = "File format not supported";
        }

        if (isset($error_message)) {
            echo $error_message;
        }

        echo json_encode($generate_new_name_upload);
?>