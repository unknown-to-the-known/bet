<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php require 'ultramsg.class.php'; ?>
<?php 
    require '../vendor/autoload.php';        
        use Aws\S3\S3Client;
        use Aws\S3\Exception\S3Exception;

        // AWS Info
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
     if (isset($_SESSION['teach_details'])) {
            $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
        } else {
             header("Location: " . BASE_URL . 'index');
        }        

    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_teach_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $user_school = htmlspecialchars($i['rev_teach_school'], ENT_QUOTES, 'UTF-8');            
         }  
    }

    $date_of_uplading = date('Y-m-d H:i:s a');
    $uniq_url_of_uploading = $date_of_uplading . '_' . $teacher_email_id;
    $uniq_identifier = md5($uniq_url_of_uploading); 

    if (isset($_GET['param'])) {
        if ($_GET['param'] != "") {
            $class_id = htmlspecialchars($_GET['param'], ENT_QUOTES, 'UTF-8');
            $fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE tree_id = '$class_id' AND rev_teach_sts = '1'");

            if (mysqli_num_rows($fetch_teacher_subject) > 0) {
                while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
                    $subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
                    $subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
                    $class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
                }
            }
        } 
    } else {
        $fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE  rev_teach_sts = '1'  ORDER BY tree_id DESC");
        if (mysqli_num_rows($fetch_teacher_subject) > 0) {
            while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
                $subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
                $subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
                $class_id = htmlspecialchars($l['tree_id'], ENT_QUOTES, 'UTF-8');   
                $class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');      
        }
        }
    }       
?>
<?php 
    if (isset($_GET['uni'])) {
        if ($_GET['uni'] != '') {
            $uniq_id = htmlspecialchars($_GET['uni'], ENT_QUOTES, 'UTF-8');
        } else {
            header("Location: " . BASE_URL . 'pages/action');
        }
    } else {
            header("Location: " . BASE_URL . 'pages/action');
        }
?>

<?php 
     if (isset($_POST['submit'])) {
        $audio_name = mysqli_escape_string($connection, trim($_POST['audio_name']));
        $audio_date = mysqli_escape_string($connection, trim($_POST['date']));
        $audio_start = mysqli_escape_string($connection, trim($_POST['start']));
        $audio_end = mysqli_escape_string($connection, trim($_POST['end']));

        if ($audio_name == "" || $audio_date == "" || $audio_start == "" || $audio_end == "") {
            $error_message = "Please fill all the fields";
        }

        if (!isset($error_message)) {
            $convert_start_date = date('Y-m-d', strtotime($audio_date));
            $convert_start_time = date('H:i', strtotime($audio_start));
            $convert_end_time = date('H:i', strtotime($audio_end));     


        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $size = $_FILES['file']['size'];

            if ($size > 15000000) {
                $error_message = "Audio size must be less than 15 MB";
            }

            if (!isset($error_message)) {
                $ext = explode('.', $name);

                $file_ext = $ext[1];

                $allowed_input = array('mp3', 'wav');
            }

            if (!in_array($file_ext, $allowed_input)) {
                $error_message = "Only MP3 and WAV files are allowed";
            }

            if (!isset($error_message)) {
                $uniq_name = hash('murmur3f', date('YmdHis'));
                $generate_new_name = $user_name . '_' . $subject_class_yt . '_' . $user_school . '_' . $subject_name_yt . '_' . $uniq_name . '.mp3';

                try {                
                    $file = $uniq_name;
                    $result = $s3->putObject(
                        array(
                            'Bucket'=>$bucketName,
                            'Key' =>  $generate_new_name,
                            'SourceFile' => $temp_name,
                            'StorageClass' => 'REDUCED_REDUNDANCY',
                            'ContentType' => ';audio/*'
                        )
                );
                } catch (S3Exception $e) {
                        $error_message = 'sorry audio not uploaded, please try again';
                } catch (Exception $e) {
                        $error_message = 'sorry audio not uploaded, please try again';
                }                                

                $check_if_already = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE rev_date = '$convert_start_date' AND rev_teacher_id = '$teacher_email_id' AND rev_sts = '1' AND rev_category = 'speak'");

                    if (mysqli_num_rows($check_if_already) > 0) {
                        $error_message = "Already there is a task for selected date";
                    }

                    if (!isset($error_message)) {
                        $insert_into = "INSERT INTO rev_lsrw(rev_name,rev_date,rev_start_time,rev_end_time,rev_teacher_id,rev_category,rev_link,rev_uniq_link,rev_sts,rev_sch,rev_class,rev_lsrw_sub,rev_sec) VALUES ('$audio_name', '$convert_start_date', '$convert_start_time', '$convert_end_time', '$teacher_email_id', 'speak', '$generate_new_name', '$uniq_id', '1', '$user_school', '$subject_class_yt', '$subject_name_yt', '$class_sec')";

                            if (mysqli_query($connection, $insert_into)) {
                                $last_id = mysqli_insert_id($connection);
                                function generateRandomString($length = 25) {
                                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                    $charactersLength = strlen($characters);
                                    $randomString = '';
                                    for ($i = 0; $i < $length; $i++) {
                                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                                    }
                                    return $randomString;
                                }

                            
                                $myRandomString = generateRandomString(5);
                                $insert_into_noti = mysqli_query($connection, "INSERT INTO rev_notification(rev_noti_name,rev_noti_cate,rev_noti_date,rev_noti_start_time,rev_noti_end,rev_uniq_id,rev_sts,rev_noti_sch,rev_noti_class,rev_noti_sec, rev_lsrw_sub_cate) VALUES ('$audio_name', 'LSRW', '$convert_start_date', '$convert_start_time', '$convert_end_time', '$last_id', '1', '$user_school','$subject_class_yt', '$class_sec', 'speak')");

                                 $original_url = "revisewell.com/pages/lsrw_listen?id=" . $uniq_identify;
                                 $insert_into_short_url = mysqli_query($connection, "INSERT INTO rev_redirect(rev_short_url,rev_full_url,rev_sts) VALUES ('$myRandomString', '$original_url', '1')");

                            $cate = 'LSRW';

                            $sub_cate = "speak";

                             $fetch_all_student_list = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_class = '$subject_class_yt' AND rev_student_sec = '$class_sec' AND rev_student_sch = '$user_school' AND rev_student_sts = '1'");

                                  if (mysqli_num_rows($fetch_all_student_list) > 0) {
                                       while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                                             $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                                             // $student_name = $k['rev_student_name'];
                                       }         
                                  }

                             $body = 'Hi,\n' .'Greetings from '. $user_school . ' 🙏\n'
                            .' *❗' . ucfirst($subject) . ' ' . $cate . '* ' .'notification alert for *class ' . $subject_class_yt .'* ' . ', from *Revisewell Learner App* ' . '❗\n\n'
                            . ucfirst($cate) . ' name - ' . ' *' . $audio_name . '* ' . '\n'
                            . 'Scheduled on 🗓️ - ' . ' *' . date('d-M-Y', strtotime($convert_start_date)) . '* ' . '\n'
                            . 'Start time ⏳ - ' . ' *' . date('h:i a', strtotime($convert_start_time)) . '* ' . '\n' . 'End time ⌛ - ' . ' *' . date('h:i a', strtotime($convert_end_time)) . '* '. '\n\n'
                            . 'Please click on the link below to check the scheduled homework👇\n' . ' *revisewell.com/k?r=' . $myRandomString . '* ' . '\n\n'.                             
                            'Thank you for using' .' *Revisewell Learner App* ' . '👍' . '\n' . 'Have a great day😊!';
                              $ultramsg_token = $ultra_msg_token; // Ultramsg.com token
                              $instance_id = $instance_id; // Ultramsg.com instance id
                              $client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);
                              $to = $student_phone; 
                              $body = $body; 
                              $api = $client->sendChatMessage($to,$body); 

                        if (isset($insert_into)) {
                            $success_message = "Success, Speak activity scheduled";
                        }
                    } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($connection);
                    }
            }            
        }
        }                     
      } 
    } 
?>

<?php
    if (isset($_POST['youtube'])) {
       $youtube_name = mysqli_escape_string($connection, trim($_POST['yt_text']));
       $youtube_date = mysqli_escape_string($connection, trim($_POST['yt_date']));
       $youtube_url = mysqli_escape_string($connection, trim($_POST['yt_url']));
       $youtube_start = mysqli_escape_string($connection, trim($_POST['yt_start']));
       $youtube_end = mysqli_escape_string($connection, trim($_POST['yt_end']));

       if ($youtube_name == "" || $youtube_date == "" || $youtube_url == "" || $youtube_start == "" || $youtube_end == "") {
           $error_message = "Please fill all fields";
       }

       if (!isset($error_message)) {
            $main_url = (parse_url($youtube_url, PHP_URL_HOST));
            if ($main_url == "www.youtube.com") {
                $error_message = "Please paste the URL using share button in youtube";
            }
        }

        if (!isset($error_message)) {            
            $parent_hosting = parse_url($youtube_url, PHP_URL_HOST);
            if ($parent_hosting != 'youtu.be') {
               $error_message = "Please upload video from youTube";
            }
        }

        if (!isset($error_message)) {
            $values = parse_url($youtube_url, PHP_URL_PATH);
            $str_explode = explode('/', $values);
            foreach ($str_explode as $key) {
            $short_url =  $key;
            }
        }

       if (!isset($error_message)) {
        $convert_youtube_date = date('Y-m-d', strtotime($youtube_date));
        $convert_youtube_start = date("H:i", strtotime($youtube_start));
        $convert_youtube_end = date("H:i", strtotime($youtube_end));

        $fetch_already_present = mysqli_query($connection,"SELECT * FROM rev_lsrw WHERE rev_date = '$convert_youtube_date' AND  rev_teacher_id = '$teacher_email_id' AND rev_sts = '1' AND rev_category = 'speak'");

        if (mysqli_num_rows($fetch_already_present) > 0) {
            while($ju = mysqli_fetch_assoc($fetch_already_present)) {
                $youtube_ure = htmlspecialchars($ju['rev_link'], ENT_QUOTES, 'UTF-8');
            }           
        } 

        if ($youtube_ure == $short_url) {
            $error_message = "URL already present";
        }

        if (!isset($error_message)) {
            $insert_youtube = "INSERT INTO rev_lsrw(rev_name,rev_date,rev_start_time,rev_end_time,rev_teacher_id,rev_category,rev_link,rev_uniq_link,rev_sts,rev_sch,rev_class,rev_lsrw_sub,rev_sec) VALUES ('$youtube_name', '$convert_youtube_date', '$convert_youtube_start', '$convert_youtube_end', '$teacher_email_id', 'speak', '$short_url', '$uniq_id', '1', '$user_school', '$subject_class_yt', '$subject_name_yt', '$class_sec')";

           if (mysqli_query($connection, $insert_youtube)) {
                $last_id = mysqli_insert_id($connection);

            function generateRandomString($length = 25) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }

        
            $myRandomString = generateRandomString(5);

            $insert_into_noti = mysqli_query($connection, "INSERT INTO rev_notification(rev_noti_name,rev_noti_cate,rev_noti_date,rev_noti_start_time,rev_noti_end,rev_uniq_id,rev_sts,rev_noti_sch,rev_noti_class,rev_noti_sec, rev_lsrw_sub_cate) VALUES ('$youtube_name', 'LSRW', '$convert_youtube_date', '$convert_youtube_start', '$convert_youtube_end', '$last_id', '1', '$user_school','$subject_class_yt', '$class_sec', 'speak')");

                                 $original_url = "revisewell.com/pages/lsrw_listen?id=" . $uniq_identify;
                                 $insert_into_short_url = mysqli_query($connection, "INSERT INTO rev_redirect(rev_short_url,rev_full_url,rev_sts) VALUES ('$myRandomString', '$original_url', '1')");

                            $cate = 'LSRW';

                            $sub_cate = "speak";

                             $fetch_all_student_list = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_class = '$subject_class_yt' AND rev_student_sec = '$class_sec' AND rev_student_sch = '$user_school' AND rev_student_sts = '1'");

                                  if (mysqli_num_rows($fetch_all_student_list) > 0) {
                                       while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                                             $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                                             // $student_name = $k['rev_student_name'];
                                       }         
                                  }

                             $body = 'Hi,\n' .'Greetings from '. $user_school . ' 🙏\n'
                            .' *❗' . ucfirst($subject) . ' ' . $cate . '* ' .'notification alert for *class ' . $subject_class_yt .'* ' . ', from *Revisewell Learner App* ' . '❗\n\n'
                            . ucfirst($cate) . ' name - ' . ' *' . $youtube_name . '* ' . '\n'
                            . 'Scheduled on 🗓️ - ' . ' *' . date('d-M-Y', strtotime($convert_youtube_date)) . '* ' . '\n'
                            . 'Start time ⏳ - ' . ' *' . date('h:i a', strtotime($convert_youtube_start)) . '* ' . '\n' . 'End time ⌛ - ' . ' *' . date('h:i a', strtotime($convert_youtube_end)) . '* '. '\n\n'
                            . 'Please click on the link below to check the scheduled homework👇\n' . ' *revisewell.com/k?r=' . $myRandomString . '* ' . '\n\n'.                             
                            'Thank you for using' .' *Revisewell Learner App* ' . '👍' . '\n' . 'Have a great day😊!';
                              $ultramsg_token = $ultra_msg_token; // Ultramsg.com token
                              $instance_id = $instance_id; // Ultramsg.com instance id
                              $client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);
                              $to = $student_phone; 
                              $body = $body; 
                              $api = $client->sendChatMessage($to,$body); 

            if (isset($q)) {
                $success_message = "Success, Data Uploaded";
            }
        }
                    
        }
       }
    }
?>

<?php 
    if (isset($_POST['record'])) {
        $record_name = mysqli_escape_string($connection, trim($_POST['record_name']));
        $record_date = mysqli_escape_string($connection, trim($_POST['record_date']));
        $record_start = mysqli_escape_string($connection, trim($_POST['record_start']));
        $record_end = mysqli_escape_string($connection, trim($_POST['record_end']));

        if ($record_name == "" || $record_date == "" || $record_start == "" || $record_end == "") {
            $error_message = "Please fill all the fields";
        }

        if (!isset($error_message)) {
            $convert_start_date = date('Y-m-d', strtotime($record_date));
            $convert_start_time = date('H:i', strtotime($record_start));
            $convert_end_time = date('H:i', strtotime($record_end));     


        if (isset($_FILES['record_audio'])) {
            $record_file = $_FILES['record_audio'];
            $record_audio_name = $_FILES['record_audio']['name'];
            $record_temp_name = $_FILES['record_audio']['tmp_name'];
            $record_size = $_FILES['record_audio']['size'];

            if ($size > 15000000) {
                $error_message = "Audio size must be less than 15 MB";
            }

            if (!isset($error_message)) {
                $uniq_name = hash('murmur3f', date('YmdHis'));
                $generate_new_name = $user_name . '_' . $subject_class_yt . '_' . $user_school . '_' . $subject_name_yt . '_' . $uniq_name . '.mp3';

                try {                
                    $file = $uniq_name;
                    $result = $s3->putObject(
                        array(
                            'Bucket'=>$bucketName,
                            'Key' =>  $generate_new_name,
                            'SourceFile' => $record_temp_name,
                            'StorageClass' => 'REDUCED_REDUNDANCY'
                        )
                );
                } catch (S3Exception $e) {
                        $error_message = 'sorry audio not uploaded, please try again';
                } catch (Exception $e) {
                        $error_message = 'sorry audio not uploaded, please try again';
                }

                $check_if_already = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE rev_date = '$convert_start_date' AND rev_teacher_id = '$teacher_email_id' AND rev_sts = '1' AND rev_category = 'speak'");

                    if (mysqli_num_rows($check_if_already) > 0) {
                        $error_message = "Already there is a task for selected date";
                    }

                    if (!isset($error_message)) {
                        $insert_into = "INSERT INTO rev_lsrw(rev_name,rev_date,rev_start_time,rev_end_time,rev_teacher_id,rev_category,rev_link,rev_uniq_link,rev_sts,rev_sch,rev_class,rev_lsrw_sub,rev_sec) VALUES ('$record_name', '$convert_start_date', '$convert_start_time', '$convert_end_time', '$teacher_email_id', 'speak', '$generate_new_name', '$uniq_id', '1', '$user_school', '$subject_class_yt', '$subject_name_yt', '$class_sec')";

                        if (mysqli_query($connection, $insert_into)) {
                $last_id = mysqli_insert_id($connection);

            function generateRandomString($length = 25) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }

        
            $myRandomString = generateRandomString(5);

            $insert_into_noti = mysqli_query($connection, "INSERT INTO rev_notification(rev_noti_name,rev_noti_cate,rev_noti_date,rev_noti_start_time,rev_noti_end,rev_uniq_id,rev_sts,rev_noti_sch,rev_noti_class,rev_noti_sec, rev_lsrw_sub_cate) VALUES ('$record_name', 'LSRW', '$convert_start_date', '$convert_start_time', '$convert_end_time', '$last_id', '1', '$user_school','$subject_class_yt', '$class_sec', 'speak')");

                                 $original_url = "revisewell.com/pages/lsrw_listen?id=" . $uniq_identify;
                                 $insert_into_short_url = mysqli_query($connection, "INSERT INTO rev_redirect(rev_short_url,rev_full_url,rev_sts) VALUES ('$myRandomString', '$original_url', '1')");

                            $cate = 'LSRW';

                            $sub_cate = "speak";

                             $fetch_all_student_list = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_class = '$subject_class_yt' AND rev_student_sec = '$class_sec' AND rev_student_sch = '$user_school' AND rev_student_sts = '1'");

                                  if (mysqli_num_rows($fetch_all_student_list) > 0) {
                                       while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                                             $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                                             // $student_name = $k['rev_student_name'];
                                       }         
                                  }

                             $body = 'Hi,\n' .'Greetings from '. $user_school . ' 🙏\n'
                            .' *❗' . ucfirst($subject) . ' ' . $cate . '* ' .'notification alert for *class ' . $subject_class_yt .'* ' . ', from *Revisewell Learner App* ' . '❗\n\n'
                            . ucfirst($cate) . ' name - ' . ' *' . $record_name . '* ' . '\n'
                            . 'Scheduled on 🗓️ - ' . ' *' . date('d-M-Y', strtotime($convert_start_date)) . '* ' . '\n'
                            . 'Start time ⏳ - ' . ' *' . date('h:i a', strtotime($convert_start_time)) . '* ' . '\n' . 'End time ⌛ - ' . ' *' . date('h:i a', strtotime($convert_end_time)) . '* '. '\n\n'
                            . 'Please click on the link below to check the scheduled homework👇\n' . ' *revisewell.com/k?r=' . $myRandomString . '* ' . '\n\n'.                             
                            'Thank you for using' .' *Revisewell Learner App* ' . '👍' . '\n' . 'Have a great day😊!';
                              $ultramsg_token = $ultra_msg_token; // Ultramsg.com token
                              $instance_id = $instance_id; // Ultramsg.com instance id
                              $client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);
                              $to = $student_phone; 
                              $body = $body; 
                              $api = $client->sendChatMessage($to,$body); 

            if (isset($q)) {
                $success_message = "Success, Data Uploaded";
            }
        }

                        if (isset($insert_into)) {
                            $success_message = "Success, Speak activity scheduled";
                        }
                    }
            }            
        }
        } 
    }
?>

<?php      
    if (isset($_POST['delete'])) {
      $delete_id = mysqli_escape_string($connection, trim($_POST['delete_id']));

      if ($delete_id == "") {
            $error_message = "Something went wrong, please try again";       
        }     

        if (!isset($error_message)) {
            $check_if_id_belong_to_the_same_teacher = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE tree_id = '$delete_id' AND rev_teacher_id = '$teacher_email_id' AND rev_sts = '1'");

            if (mysqli_num_rows($check_if_id_belong_to_the_same_teacher) > 0) {
                $delete_lsrw_data = mysqli_query($connection, "UPDATE rev_lsrw SET rev_sts = '0' WHERE tree_id = '$delete_id' AND rev_teacher_id = '$teacher_email_id' AND rev_sts = '1'");
                $delete_noti = mysqli_query($connection, "UPDATE rev_notification SET rev_sts = '0' WHERE rev_uniq_id = '$delete_id' AND rev_sts = '1'");

                if (isset($delete_lsrw_data)) {
                    $success_message = "Success, Speak activity deleted";
                }
            }
        }
    }
?>

<?php 
    if (isset($_POST['edit'])) {
        $audio_edit_name = mysqli_escape_string($connection, trim($_POST['audio_edit_name']));  
        $audio_edit_date = mysqli_escape_string($connection, trim($_POST['audio_edit_date']));
        $audio_edit_start = mysqli_escape_string($connection, trim($_POST['audio_edit_start']));
        $audio_edit_end = mysqli_escape_string($connection, trim($_POST['audio_edit_end']));
        $audi_edit_id = mysqli_escape_string($connection, trim($_POST['edit_id']));

        if ($audio_edit_name == "" || $audio_edit_date == "" || $audio_edit_start == "" || $audio_edit_end == "" || $audi_edit_id == "") {
            $error_message = "Something went wrong, please try again";
        }

        if (!isset($error_message)) {
            $convert_edit_date = date('Y-m-d', strtotime($audio_edit_date));
            $convert_start_time = date('H:i', strtotime($audio_edit_start));
            $convert_end_time = date('H:i', strtotime($audio_edit_end));
            $fetch_id_belong_to_same_teacher = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE tree_id = '$audi_edit_id' AND rev_teacher_id = '$teacher_email_id' AND rev_sts = '1'");            

            if (mysqli_num_rows($fetch_id_belong_to_same_teacher) > 0) {
                $check_if_there_is_a_clash = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE rev_date = '$convert_edit_date' AND rev_teacher_id = '$teacher_email_id' AND rev_sts = '1' AND tree_id != '$audi_edit_id'");

                    if(mysqli_num_rows($check_if_there_is_a_clash) > 0) {
                        $error_message = "LSRW already present for the selected date";
                    }
                    if (!isset($error_message)) {
                        $update_edit =  mysqli_query($connection,"UPDATE rev_lsrw SET rev_name = '$audio_edit_name', rev_date = '$convert_edit_date', rev_start_time = '$convert_start_time', rev_end_time = '$convert_end_time' WHERE tree_id = '$audi_edit_id'");

                        $update_noti = mysqli_query($connection, "UPDATE rev_notification SET rev_noti_name = '$audio_edit_name', rev_noti_date = '$convert_edit_date', rev_noti_start_time = '$convert_start_time', rev_noti_end = '$convert_end_time' WHERE rev_uniq_id = '$audi_edit_id'");

                        if (isset($update_edit)) {
                            $success_message = "Success, Speak activity updated";
                        }
                    }                
            }
        }
    }
?>


<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
    html {
      scroll-behavior: smooth;
    }
    .text_highlight:target {
        background-color: #ffa;
        -webkit-transition: all 1s linear;
     }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>includes/time_picker.css">
<div class="container zindex-100 desk" style="margin-top: 10px">
    <div class="row">
        <div style="float: left;">
            <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
        </div>
    </div>
    <div class="d-flex justify-content-end" style="margin-top: -20px">
            <select class="btn btn-sm dropdown-toggle select mb-3 font-base bg-primary bg-opacity-10 text-primary rounded-2 btn-transition d-flex justify-content-end" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false" style="font-size: 15px; font-weight: bold;" onchange="javascript:handleSelect(this)">          
                    <?php 
                        $fetch_teacher_class = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE rev_teach_email_id = '$teacher_email_id' AND rev_teach_sts = '1'");
                        if (mysqli_num_rows($fetch_teacher_class) > 0) {
                            while($lo = mysqli_fetch_assoc($fetch_teacher_class)) { ?>                          
                                <option style="background:#fff; color: #000;" value="<?php echo htmlspecialchars($lo['tree_id'], ENT_QUOTES, 'UTF-8'); ?>" <?php if ($lo['tree_id'] == $class_id) {
                                    echo 'selected';
                                }?>>Grade <?php echo htmlspecialchars($lo['rev_teacher_class'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars(ucfirst($lo['rev_teach_subject']), ENT_QUOTES, 'UTF-8'); ?></option>                         
                            <?php } 
                        }
                    ?>   
            </select>       
        </div>
</div>

<style type="text/css">
        .table-scroll th, .table-scroll td {
            border:1px solid #066AC9;
        }
</style>

<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito&display=swap');
</style>

<style type="text/css">
    .paper-content textarea {
        color: #000;
        font-family: 'Nunito', sans-serif;
    }
</style>

<!-- =======================
Main Banner START -->

    <!-- Svg decoration -->
    <figure class="position-absolute  top-100 end-0 translate-middle-y me-n8 d-none d-sm-block">
        <svg class="fill-success opacity-1" width="634.1px" height="776px">
            <path d="M161.4,200.8c-9,40.1-7.5,82.5-20.8,121.6c-17.5,52.8-58.5,93.8-92,138.1c-33,44.8-59.9,101.8-42.5,154.6
                c23.1,70.2,109,94.8,181.6,108.4c77.4,14.6,154.7,29.2,232.5,43.8c41,8,85.8,15.1,123.1-4.7c47.2-25,63.7-83,72.2-135.3
                C650.5,419.6,675-127.8,306.2,27.3C234,57.5,178.4,124.5,161.4,200.8z"/>
            </svg>
    </figure>

    <!-- Svg decoration -->
    <figure class="position-absolute top-50 end-0 translate-middle-y me-n4 mt-n8 d-none d-lg-block">
        <svg class="fill-dark" width="349px" height="188.4px">
                <path d="M64.5,85.4c-0.2-0.3,0.2-0.8,0.6-0.6c3.2,1.6,5.7,4.4,4.6,8c-1,3.2-4.1,5.2-7.3,4.1c-2.9-0.8-5.3-3.9-4.5-7.1 C58.6,87.2,61.6,84.6,64.5,85.4z M63.5,95.3c2.3,0.4,4.3-1.5,4.6-3.7c0.4-2.3-1.2-3.9-2.7-5.3c-0.1,0.3-0.3,0.5-0.6,0.6 c-2.2,0.2-4.4,1.2-5,3.5C59.1,92.6,61.2,94.9,63.5,95.3z"/>
                <path d="M79.1,99.4c1.9-1.6,5.2-1.9,6.8,0.4c0.1,0.2,0,0.4-0.2,0.7c0.8,1.2,0.9,3,0.2,4.4c-1.1,2.6-4.2,2.8-6.4,1.3 C77.6,104.3,77,101.2,79.1,99.4z M80.6,104.8c1.4,1.1,3.3,0.9,4.1-0.7c0.7-1.4,0.4-3-0.8-4.1c-1.2-0.5-2.6-0.4-3.7,0.4 C78.7,101.6,79.2,103.7,80.6,104.8z"/>
                <path d="M94.9,116.6c0.9-2.2,3.8-3.4,5.8-2c0.1,0,0.2,0.2,0.2,0.3c1.3,0.9,2,2.7,1.5,4.4c-0.6,2.3-2.9,3.2-5,2.5 C95.2,121,93.8,118.7,94.9,116.6z M98,120.3c2.9,0.8,4.1-2.7,2.4-4.6c-0.2,0.1-0.3,0.1-0.4,0c-1.4-0.5-3.3,0.1-3.9,1.5 C95.7,118.7,96.8,120,98,120.3z"/>
                <path d="M15.6,62.5c7.8-3.3,16.6-3.9,24.8-2.6C56.3,62.1,69.5,71.3,81.2,82c0.1-0.4,0.5-0.7,0.9-0.7 c8-1,15.9,0.1,23.7,2.1c3.7,1,13,2.1,14.9,6.5c3.5,8-13.9,12.1-19.7,12.3c4.6,4.8,9.1,9.6,13.9,14.1c4.8,4.5,9.8,8.7,15.8,10.8 c1.9-2.2,3.3-6.7,7-6.1c2.9,0.5,4.9,4.6,5.8,7.6c2.6,0,5.2,0.3,7.9,1c0.7,0.2,0.9,0.8,0.8,1.4c-1.5,9.2-5.5,29.6-18.4,27.3 c-7.7-1.4-15.8-6.2-22.5-10c-7-3.9-13.7-8.6-19.7-14.1c0.2,5.9,0.9,11.8,2.1,17.6c0.6,3.5,3.2,8.6,0,11.4 c-7.9,6.8-21.5-14.6-24.5-19.6c-4-6.5-7.1-13.5-9.9-20.4c-1.5-3.5-3.4-7.9-3.7-12.2c-0.4,0.3-0.8,0.3-1.3,0.2 c-11.1-5.5-21.7-11.9-31.8-19.1c-5.3-3.7-18-10.7-19.1-17.5C2.7,68.2,11,64.6,15.6,62.5z M37.3,62.3c-0.1,0-0.2-0.2-0.2-0.3 c-2.9-0.2-6-0.2-8.9,0.1c-3,0.3-6.4,0.8-9.7,1.9c4.1,7,10.2,11.4,17.2,15.3c2.8,1.5,4.2,2,7.5,2.6c5.3,2.3,7.6-0.4,6.9-7.8 c-1-1.1-2.1-2.4-3-3.6C43.8,67.4,40.4,65.1,37.3,62.3z M112.7,97c2.5-1.4,7.2-4.3,4.2-7.9c-1.2-1.5-6-2.2-7.7-2.7 c-8.7-2.7-17.4-4.1-26.5-3.3c3,2.8,5.9,5.8,8.7,8.5c3,3.1,5.9,6.3,8.9,9.4c0,0,0-0.1,0.2-0.1C104.6,100.2,108.7,99.1,112.7,97z  M141.5,126.8c-0.6-1-1.6-3-2.7-3.6c-1.2,0.1-2.2,0.1-3.4,0.2c-0.2,0.4-0.4,0.6-0.8,0.9c-0.3,0.5-0.6,1-0.8,1.5 c-0.3,0.6-0.8,1.2-1.2,1.8c0.9,0.3,2,0.5,3.1,0.7c2.3,0.4,4.5,0.4,6.8,0.4C142.2,128,141.8,127.3,141.5,126.8z M21.6,88.1 c10.8,8.1,22.3,15,34.2,21.2l0.1,0c0-1.1,0.4-2.3,0.8-3.4c2.1-5.1,5.5-4.4,9.9-2.3c8.6,3.8,16.4,8.6,23.5,14.6 c0.6,0.4-0.2,1.4-0.9,1.1c-4.8-3-9.5-6-14.4-8.8c-1.9-1.1-4.6-3.3-6.8-3.6c-0.9-0.8-1.8-1.2-2.7-1.3c-0.9-0.5-2-0.7-3-0.5 c-1.8,0.2-3.6,1.6-4.1,3.5c-0.4,1.5-0.3,2.8,0,4.3c0.1,0.3,0.3,0.6,0.3,0.9c0.1,0.2,0.2,0.5,0.1,0.6c0,0,0,0.1,0.1,0.2 c0.1,0.7,0.3,1.4,0.8,1.9c0.6,4.6,4,10,5.9,14.1c2.1,4.4,4.2,8.6,6.8,12.7c2.4,3.7,5,7.2,8,10.5c0.2,0.3,0.4,0.7,0.6,0.9 c0.2,0.2,0.3,0.4,0.6,0.6c1.2,1.9,2.7,3.6,5,4.9c2.1,1.3,4.2,0.7,5.6-0.6c-0.2-1.3-0.3-2.5-0.4-3.8c-0.5-1.3-0.5-3.4-0.4-4.3 c-0.2-0.9-0.4-1.7-0.5-1.9c-1.6-9.7-2-19.4-1.6-29.3c0.1-1.5,2.4-1.6,2.4,0c-0.2,3.9-0.1,7.8-0.1,11.7c9.8,7,19.5,13.8,30.4,18.8 c2.8,1.3,8.1,4.8,11.5,4.6c0.1,0,0.1,0,0.2-0.1c-5.1-0.7-3.7-7.6-5.5-10.8c-0.4-0.7,0.2-1.4,0.9-1.2c0.1-0.3,0.4-0.6,0.8-0.5 c2.9,0.4,5.9,1,8.9,1.7c0.3,0.1,0.3,0.6,0,0.6c-2.9-0.2-5.9-0.5-8.8-0.8c1.1,2.7,0.3,7.1,2.9,8.9c4.3,3.2,5.5-5.9,6.4-8.1 c0.3-0.5,1-0.1,0.9,0.4c-0.9,2.6-0.9,7.6-3.6,9.4c4-1.3,7-4.8,8.8-8.5c1.4-3,3.4-7.1,3.7-10.4c0.4-4.6,0.7-5.2-5.4-5.3 c-10.1-0.3-16.4-1.5-24.7-7.9c-9.7-7.5-17.8-17-26.3-25.9C78.6,81.8,61.3,65.7,40.4,62.5c5,3.7,12,8.1,12.7,14.3 c0.4,4.1-2.2,7.1-6.2,7.9c-6.2,1.3-12.9-3.8-17.7-7c-5.1-3.4-9.6-7.5-11.6-13.3c-2.7,1-5.2,2.2-7,4C1.7,76.5,16.7,84.3,21.6,88.1z "/>
                <path d="M148.9,144.4c0.2-0.4,0.7-0.1,0.5,0.3c-4.3,9.4,10.7,17.5,17.1,20.8c8.2,4.2,18.1,6.8,27.3,4.5 c2.9-0.8,6-2.4,8.5-4.4c-2.6-1.9-5.1-3.8-7.3-6c-7.3-7.3-13.9-24.1-0.1-28.5c12.3-3.9,21.1,9.9,18.7,20.7 c-1.2,5.4-4.1,9.7-7.9,13.1c1.2,0.8,2.5,1.4,3.6,2c12.9,6.4,27.7,11,41.9,12.6c31.3,3.4,61.4-14.2,67.6-46.4 c3-15.8-0.4-31.6-8.2-45.4c-5.8-10.3-13.2-19.9-16.2-31.5C287,25.6,318,7.6,343.8,3.5c0.7-0.1,1,1,0.3,1.1 c-20.7,3.3-43.8,13.4-48.7,36.3c-4.2,19.9,12.3,35.8,20.2,52.3c14.6,30.3,3.8,68.9-27.6,83.5c-14.9,6.9-32,6.8-47.9,3.3 c-11.8-2.5-25.6-6.6-36.4-13.6c-6.4,4.5-14.8,6.4-22.8,5.2C171.5,170.2,142.1,158.3,148.9,144.4z M205.2,133.2 c-6-3.4-14.3-1.1-16.4,5.8c-1.4,4.8,0.9,10.3,3.5,14.3c3.1,4.6,7.3,7.9,12,10.7C213.5,155.5,218.3,140.8,205.2,133.2z"/>
        </svg>
    </figure>

    <div class="container">
        <div class="row">
            <!-- Title -->
            <div class="col-md-8 mb-2 mb-lg-4 position-relative">

                <!-- Svg decoration -->
                <figure class="position-absolute top-0 start-0 translate-middle ms-n5 d-none d-md-block">
                    <svg class="fill-danger" width="114px" height="140px" viewBox="0 0 114 140">
                        <path d="M67.6,6.2c0.8-0.5,7.2,7.6,14.2,18c7.1,10.2,14.7,22.7,18.9,30c8.3,14.7,13.2,27.5,11.4,28.5 c-1.9,1-9.6-10.2-17.9-24.9c-4.2-7.3-11.1-20.1-16.9-31C71.4,15.9,66.7,6.7,67.6,6.2z"/>
                        <path d="M85,89c-0.8,0.7-4.6-2.2-9.2-5.5c-4.6-3.2-10.1-6.8-13.1-8.8c-6.1-4.2-10.9-8.2-10-10.2 c0.8-1.8,7.5-0.6,14.2,3.8c3.4,2.1,8.7,6.7,12.6,11.2C83.3,84,85.7,88.3,85,89z"/>
                        <path d="M73.1,114.7c0,1.1-8.5,1.8-18.8,2.1c-10.2,0.3-22.2-0.2-29.1-0.8c-13.8-1.2-24.7-4.4-24.4-6.4 c0.3-2.1,11.5-2.3,25.1-1.1c6.8,0.6,18.5,1.9,28.6,3C64.7,112.7,73.1,113.8,73.1,114.7z"/>
                    </svg>
                </figure>
                <!-- Title -->
                <h1 class="display-4 mb-3 mb-lg-0 text-dark" style="font-size: 40px;">Speak</h1>
            </div>

            <!-- Info and buttons -->
            <div class="col-md-8 mb-4 mb-lg-0">
                <!-- <p class="mb-4">Contrasted by oh estimating instrument. Size like body someone had. Are conduct viewing boy minutes</p> -->
                <!-- Buttons -->
                <!-- <a href="#" class="btn btn-sm btn-primary-soft mb-4">Get Inquiry</a> -->

                <div class="d-flex justify-content-around">
                    <!-- Counter item -->
                    <ul class="nav nav-pills nav-pill-soft mb-3 d-flex justify-content-around" id="course-pills-tab" role="tablist">
                        <!-- Tab item -->
                            <li class="nav-item me-2" role="presentation">
                                <button class="nav-link active" id="course-pills-tab-1" data-bs-toggle="tab" data-bs-target="#course-pills-tab1" type="button" role="tab" aria-controls="course-pills-tab1" aria-selected="true">Upload<div class="icon-md fs-4 text-info bg-white rounded flex-shrink-0" style="cursor: pointer;"> <i class="fas fa-upload"></i> </div></button>

                            </li>
                        <!-- Tab item -->
                            <li class="nav-item me-2" role="presentation">
                                <button class="nav-link" id="course-pills-tab-2" data-bs-toggle="tab" data-bs-target="#course-pills-tab2" type="button" role="tab" aria-controls="course-pills-tab2" aria-selected="false">Share<div class="icon-md fs-4 text-purple bg-white rounded flex-shrink-0" style="cursor: pointer;"> <i class="fab fa-youtube"></i> </div></button>
                            </li>
                        <!-- Tab item -->
                            <li class="nav-item me-2" role="presentation">
                                <button class="nav-link" id="course-pills-tab-3" data-bs-toggle="tab" data-bs-target="#course-pills-tab3" type="button" role="tab" aria-controls="course-pills-tab3" aria-selected="false">Record<div class="icon-md fs-4 text-orange bg-white rounded flex-shrink-0
                                flex-shrink-0" style="cursor: pointer;"> <i class="fas fa-microphone"></i> </div></button>
                            </li>
                    </ul> 
                </div>

                <?php 
                        if (isset($success_message)) { ?>
                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="col-md-8 d-flex justify-content-center alert alert-success" role="alert">
                                    <ul class="feedback">
                                        <li class="active happy">
                                            <div>
                                                <svg class="eye left">
                                                    <use xlink:href="#eye">
                                                </svg>
                                                <svg class="eye right">
                                                    <use xlink:href="#eye">
                                                </svg>
                                            </div>
                                        </li>
                                    </ul>
                                     &nbsp;&nbsp;<span class="mt-2 fw-bold"> <?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?> </span>
                                </div>  
                            </div>      
                        <?php }
                    ?>
                    <?php 
                        if (isset($error_message)) { ?>
                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="col-md-8 d-flex justify-content-center alert alert-danger" role="alert">
                                    <ul class="feedback d-flex justify-content-center">
                                        <li class="ok active">
                                            <div></div>
                                        </li>
                                    </ul>
                                     &nbsp;&nbsp;<span class="mt-2 fw-bold"> <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?> </span>
                                </div>  
                            </div>              
                        <?php }
                    ?>

            <div class="tab-content" id="course-pills-tabContent">

                <div class="tab-pane fade show active mt-4" id="course-pills-tab1" role="tabpanel" aria-labelledby="course-pills-tab-1">

                <div class="card card-body shadow p-4 p-sm-5 position-relative">

                    <h4 class="text-center text-info fw-bold mb-4">Upload an audio clip</h4>
                    
                    <!-- Form START -->
                    <form class="row g-3 position-relative" action="" method="post" enctype="multipart/form-data" autocomplete="off">
                        <!-- Name -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Enter audio name*" name="audio_name" required value="<?php
                                        if (isset($error_message)) {
                                            echo htmlspecialchars($audio_name, ENT_QUOTES, 'UTF-8');
                                        }
                                     ?>">
                                    <p style="font-size: 20px;"><img>🔊</p>
                                </div>
                            </div>
                        </div>
                        <!-- Date -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Date*" name="date"  id="datepicker_up" required value="<?php
                                        if (isset($error_message)) {
                                            echo htmlspecialchars($audio_date, ENT_QUOTES, 'UTF-8');
                                        }
                                     ?>">
                                    <p style="font-size: 20px;">🗓️</p>
                                </div>
                            </div>
                        </div>
                        <!-- Start time -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Start time*" name="start" id="timepicker_up1" required value="<?php
                                        if (isset($error_message)) {
                                            echo htmlspecialchars($audio_start, ENT_QUOTES, 'UTF-8');
                                        }
                                     ?>">

                                    <p style="font-size: 20px;">⏳</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" name="end" id="timepicker_up2" placeholder="End time*" required value="<?php
                                        if (isset($error_message)) {
                                            echo htmlspecialchars($audio_end, ENT_QUOTES, 'UTF-8');
                                        }
                                     ?>">

                                    <p style="font-size: 20px;">⌛</p>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="col-md-12 mt-4 d-flex justify-content-center">

                            <div class="shadow-lg p-2 mb-3 bg-body rounded col-md-4">
                                <div class="d-flex justify-content-center" style="display: inline-flex;">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-sm me-2 rounded-4">
                                        <img class="avatar-img rounded-1" src="../assets/images/speaking.svg" alt="Question paper">
                                    </div>
                                    <!-- Avatar info -->
                                    <div>
                                        <h6 class="mb-0 text-dark mt-2">Upload audio*</h6>
                                    </div>
                                </div>
                            
                            </div>
                        </div>  
                        <!-- Choose file -->
                        <div class="uploader2">
                            <div class="col-md-12">
                              <label for="formFileLg" class="form-label"></label>
                              <input class="form-control form-control-lg" id="file" type="file"  name="file" accept="audio/*">
                            </div>
                        </div>                        
                        
                        </div>

                        

                        <!-- Button -->
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-info mb-0" name="submit">Upload</button>
                        </div>
                    </form>
                    <!-- Form END -->
                </div>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
                        <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
                    </symbol>
                    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
                        <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
                    </symbol>
                </svg>

                <div class="tab-pane fade mt-4" id="course-pills-tab2" role="tabpanel" aria-labelledby="course-pills-tab-2">

                <div class="card card-body shadow p-4 p-sm-5 position-relative">

                    <h4 class="text-center text-purple fw-bold mb-4">Share a Youtube Video</h4>

                    <!-- Form START -->
                    <form class="row g-3 position-relative" action="" method="post" autocomplete="off">
                        <!-- Name -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Enter video name*" name="yt_text" autocomplete="off" required value="<?php if (isset($error_message)) {
                                            echo htmlspecialchars($youtube_name, ENT_QUOTES, 'UTF-8');
                                    } ?>">
                                    <p style="font-size: 20px;"><img>📽️</p>
                                </div>
                            </div>
                        </div>
                        <!-- Date -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Date*"   id="datepicker_yt" name="yt_date" autocomplete="off" required value="<?php if (isset($error_message)) {
                                            echo htmlspecialchars($youtube_date, ENT_QUOTES, 'UTF-8');
                                    } ?>">
                                    <p style="font-size: 20px;">🗓️</p>
                                </div>
                            </div>
                        </div>
                        <!-- Youtube URL -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Paste Youtube URL*" name="yt_url" autocomplete="off" required value="<?php if (isset($error_message)) {
                                            echo htmlspecialchars($youtube_url, ENT_QUOTES, 'UTF-8');
                                    } ?>">
                                    <p style="font-size: 20px;"><img>🔊</p>
                                </div>
                            </div>
                        </div>
                        <!-- Start time -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Start time*" name="yt_start" autocomplete="off" id="timepicker_yt1" required value="<?php if (isset($error_message)) {
                                            echo htmlspecialchars($youtube_start, ENT_QUOTES, 'UTF-8');
                                    } ?>">

                                    <p style="font-size: 20px;">⏳</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" name="yt_end" id="timepicker_yt2" placeholder="End time*" autocomplete="off" required value="<?php if (isset($error_message)) {
                                            echo htmlspecialchars($youtube_end, ENT_QUOTES, 'UTF-8');
                                    } ?>">

                                    <p style="font-size: 20px;">⌛</p>
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-purple mb-0" name="youtube">Upload</button>
                        </div>
                    </form>
                    <!-- Form END -->
                </div>
                </div>

                <div class="tab-pane fade mt-4" id="course-pills-tab3" role="tabpanel" aria-labelledby="course-pills-tab-3">

                <div class="card card-body shadow p-4 p-sm-5 position-relative">

                    <h4 class="text-center text-orange fw-bold mb-4">Record an audio</h4>
                    
                    <!-- Form START -->
                    <form class="row g-3 position-relative" action="" method="post" enctype="multipart/form-data" autocomplete="off">
                        <!-- Name -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Enter audio name*" name="record_name" autocomplete="off" required value="<?php if (isset($error_message)) {
                                        echo htmlspecialchars($record_name, ENT_QUOTES, 'UTF-8');
                                    } ?>">
                                    <p style="font-size: 20px;"><img>📽️</p>
                                </div>
                            </div>
                        </div>
                        <!-- Date -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Date*" name="record_date"  id="datepicker_rec" autocomplete="off" required value="<?php if (isset($error_message)) {
                                        echo htmlspecialchars($record_date, ENT_QUOTES, 'UTF-8');
                                    } ?>">
                                    <p style="font-size: 20px;">🗓️</p>
                                </div>
                            </div>
                        </div>
                        <!-- Start time -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Start time*" name="record_start" id="timepicker_rec1" autocomplete="off" required value="<?php if (isset($error_message)) {
                                        echo htmlspecialchars($record_start, ENT_QUOTES, 'UTF-8');
                                    } ?>">

                                    <p style="font-size: 20px;">⏳</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" name="record_end" id="timepicker_rec2" placeholder="End time*" autocomplete="off" required value="<?php if (isset($error_message)) {
                                        echo htmlspecialchars($record_end, ENT_QUOTES, 'UTF-8');
                                    } ?>">

                                    <p style="font-size: 20px;">⌛</p>
                                </div>
                            </div>
                        </div>
                        <input class="form-control form-control-lg" id="file" type="file" name="record_audio" accept="audio/*" capture />
                        <!-- Button -->
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-orange mb-0" name="record">Upload</button>
                        </div>
                    </form>
                    <!-- Form END -->
                </div>
                </div>
            </div>
            </div>

            <!-- Image -->
            <div class="col-md-4">
                <div class="position-relative">
                    <!-- Svg decoration -->
                    <figure class="position-absolute bottom-0 start-0 z-index-9 mb-n5 ms-n6 d-none d-xl-block">
                            <svg class="fill-purple">
                                <path d="m168.1 45.6c-0.6 2.4-1.8 3.4-3.7 3.8-0.4-0.5-0.8-1.1-1.1-1.5-1.9-1.2-3.7-2.3-5.4-3.3 0-0.9 0.2-1.5 0-2-0.4-0.9-1-1.8-0.6-2.8 0.5-1.5 1.1-3.1 1.9-4.4 1.3-1.9 2.9-3.7 4.3-5.4h1.8c1.6 1.4 3 2.3 4.1 3.6s1.8 2.9 2.7 4.5c-2.3 2.4-4.3 4.8-4 7.5"/>
                                <path d="m101.5 2.3c0.3 1.5 2 2.2 2.1 4 0 0.8 0.5 1.5-0.1 2.4-0.6 1-0.9 2.2-1.3 3.2-0.1-0.1-0.3-0.3-0.5-0.4-1.1 0.9-1.3 1.1-2.1 3.1-1.8 0.5-3.7 1-6 1.5-1.3-0.9-3.1-1.1-4.6-2.1-0.4-2.6-3.3-4.3-2.2-7.3 0.5-0.5 1-1.1 1.7-1.8 0.3 0.2 0.7 0.5 1.1 0.6 1.7 0.7 3-0.1 4.2-1.1s2.3-2.2 3.5-3.5h2.4c-0.5 0.8-1 1.5-1.5 2.3 1.6 1.2 1.8-1.1 3.3-0.9"/>
                                <path d="m178.3 78.4h1.1c0.8 1 1.6 2.1 2.6 3.2 0.2 1.8 0.3 3.8-1.3 5.4 0.1 1.5-1 2.6-0.8 4.2 0.1 1.1-0.2 2.4-0.7 3.5-0.2 0.6-1.1 0.9-1.8 1.3-2.3-1.6-4.4-3-5.8-3.9-2.1-3.6-0.9-6.3 0-9.1 1.1-3.5 2-4.7 5.4-6.7 0.4 0.6 0.8 1.3 1.3 2.1"/>
                                <path d="m27.9 53.1c0.5 2.4-1.4 4.9-4.7 6.5l-0.6-0.6c-0.3 0.2-0.5 0.5-0.8 0.7-1.4-0.6-2.8-1.1-4.5-1.8-0.4-0.6-0.9-1.6-1.5-2.6 0.5-0.4 0.8-0.9 1.3-1.1 0.4-0.2 0.9 0 1.4 0 0.2-1.1 0.4-2.1 0.6-3.1-0.8-1.4-1.7-3-2.7-4.7 0.7-0.7 1.4-1.3 2-1.9h1.7c3 2 6.3 3.5 7.8 8.6"/>
                                <path d="m73.7 131.2c0.6-0.8 1-1.4 1.6-2.3 0.6-0.2 1.6-0.6 2.7-1 0.2 0.9 0.3 1.5 0.4 2.4 0.5-0.1 1-0.3 1.4-0.4 1.5-0.4 0.6 1.7 2 1.9 0.6 0.1 1.1 1.5 1.8 2.5 0.4 1.5-0.1 3.1-1.3 4.6 0.2 0.2 0.4 0.4 0.6 0.7-0.3 0.3-0.7 0.6-1 0.9-0.2-0.2-0.6-0.6-0.6-0.5-1.8 1.5-3.2-0.1-4.7-0.6-1.3-0.4-2.5-1.1-3.7-1.7-0.7-1.4-1.4-2.9-2.2-4.5-0.1-3 0.1-3.5 2.4-5.2 0.2 1 0.4 1.9 0.6 3.2"/>
                                <path d="m126.5 124.3c-1.3-0.5-2.3-0.9-3.3-1.2v-0.8c-1.5-0.5-3.1-1-4.7-1.5-0.4-2-0.7-3.8-1-5.3 1.2-1.4 2.8-1.5 3.3-3.2 0.2-0.7 1.5-1.1 2.7-1.8 0.2 0.6 0.5 1.1 0.7 1.8 0 0.1-0.2 0.6-0.4 1.1 0.2 0.1 0.3 0.2 0.5 0.3 0.3-0.6 0.7-1.1 1.2-1.9 1.2 1.7 2.7 2.9 3.1 4.3 0.3 1.3 1.2 2.6 0.7 4.4-0.6 1.8-2.9 1.6-2.8 3.8"/>
                                <path d="m49.6 86.6h-3.6c-0.8 1.1 0.6 2.8-2.3 3.5-2.5-0.1-5.2-1.4-7-4.5v-2.8l2.3-2.3c0.1 0.1 0.5 0.4 0.8 0.6 1-1.2 2.3-0.5 3.2-0.6 2.9 1.4 5.5 2.6 6.6 6.1"/>
                                <path d="m29.5 144.1h1.5c0.1 0.4 0.3 0.8 0.5 1.4 1.4-0.2 3.2-0.1 3.8 1 0.7 1.4 2.6 1.3 2.9 3.4v5.6c-2.3 1.5-3.7-1.5-5.8-1-1.4-0.9-2-2.5-3.4-3.4-0.8-0.5-1.3-1.7-1.2-2.9 0.1-0.8 0-1.6 0-2.4l1.7-1.7z"/>
                                <path d="m1.5 106.7c0.6-2.1-2.3-2.9-1.3-5l2.8-2.8c1.7 0.9 3.7 1.7 5.5 2.8 1.8 1.2 2.5 3.3 3.5 5.1-0.3 0.9-0.6 1.7-1 2.6-3.4 0.7-6.2-1-9.5-2.7"/>
                                <path d="m110.6 165c-1.3-1.7-3.2-1.8-4.9-2.4-0.5-0.7-1-1.4-1.7-2.5v-5.5c0.4-0.3 1.1-0.8 2.2-1.6 0.8 0.2 2.1 0.4 3.3 0.7 2.9 1.5 3 4.5 4.3 7.2-1.1 1.3-2.2 2.7-3.2 4.1"/>
                                <path d="m50 120.4c0.4 0.1 0.7 0.2 1.1 0.3v3.3c-0.6 0.8-1.2 1.6-1.5 2.1-2.1-0.6-3.8-1-5.8-1.6-0.1-0.4-0.2-1.1-0.3-1.7-0.3-0.1-0.6-0.1-1-0.2-1-2.7 1.5-4.3 1.9-6.6 1.5 0.1 1.9-2.4 3.9-1.5 0 0.1 0.1 0.5 0.3 1 0.4 0.1 1.1 0.2 1.7 0.2l1.6 1.6c-0.6 1.1-1.2 2.1-1.9 3.1"/>
                                <path d="m143.5 81.3c0.6-0.3 1.1-0.5 1.6-0.7 1.4 2.4 4.2 4.3 3.7 8-1.2 0.6-2.5 1.4-3.7 2.1-1-0.5-1.9-1-2.7-1.4-0.9-1.1-1.7-2.2-2.6-3.3-0.3-1.6-0.6-3.3-0.9-5.1 0.7-0.6 1.4-1.1 2.3-1.8h1.9c0.2 0.7 0.3 1.3 0.4 2.2"/>
                                <path d="m152.2 137.4c-0.2 0.4-0.5 0.9-0.8 1.4 1.1 0.6 1.9 0.7 2.8-0.5 0.1 0.7 0.3 1 0.2 1.3-0.2 0.7-0.5 1.4-0.8 2.2 1.2-0.7 1.3-0.8 2-2.2 0.6 1.5 1.3 2.8 1.4 4.1 0.1 1.2-0.4 2.5-0.7 3.8-0.4-0.2-0.9-0.5-1-0.4-1 0.9-2 0.8-3.1 0.1-1-0.7-1.9-0.4-2.6 0.7-0.5-0.4-0.9-0.7-1.3-1 0.2-0.7 0.4-1.5 0.6-2.3-0.5-0.3-1-0.5-1.6-0.7 0.3-1.4 0.6-2.7 1-4.4 1-0.7 2.2-1.5 3.5-2.3l0.4 0.2z"/>
                                <path d="m108.7 47.2c-1-0.6-1.8-1.1-2.6-1.6-2.1-1.2-2.1-1.2-2.9-3.5-0.2-0.6-0.4-1.2-0.7-1.8-0.4-0.8-1-1.4-1.3-2.2-0.3-0.7-0.5-1.4-0.7-2.2 0.7-0.8 1.3-1.7 2.2-2.1 4.6 2.8 4.6 2 7.5 9.8-0.6 1.3-1 2.5-1.5 3.6"/>
                                <path d="m137.5 11.2c0.3 0 0.9 0.1 1.4 0.2 2 2.6 3.5 5.3 2.8 8.5-1.1 0.1-2 0.3-3 0.4-0.8-0.9-1.7-1.8-2.2-2.4-1.2-0.5-2.2-0.6-2.5-1.1-1.2-1.8-1.4-3.9-1.1-6.2 0.8-0.5 1.8-1 2.9-1.7 0.7 0.8 1.2 1.5 1.7 2.3"/>
                                <path d="m135.7 43.8v1.9c0.8 0.1 1.7 0.2 2.7 0.3v1.6c3.3 1.2 2.9 3.8 2.9 6.5-4 0.7-6.4-1.7-8.7-4.1-0.3-1.4-0.6-2.6-1-4.1 0.7-1.6 2-2.2 4.1-2.1"/>
                                <path d="m60.3 48.8c0.9-0.5 1.6-1 2.4-1.4 2.1 1.8 5.1 2.6 6.3 4.8 0.4 1.1 0.6 1.8 0.9 2.8-0.2 0.5-0.6 1.2-0.9 1.7-0.6 0.3-1 0.5-1.5 0.7-1-0.4-2.1-0.9-3.2-1.4-2.5-1.6-4.2-3.8-4-7.2"/>
                                <path d="m55.5 174.3c-0.7-1.1-1.5-2.1-2.1-3.1 0.2-0.6 0.3-1.1 0.5-1.6-0.1-0.1-0.3-0.1-0.4-0.2 1-1.3 2-2.7 3-3.9 3.8 0.8 4.6 3.9 5.7 6.6l-1.5 3c-1.6-0.3-3.2-0.5-5.2-0.8"/>
                                <path d="m44.1 22.9c0.8-0.8 1.4-1.3 2-2 1.7 0.1 3.2-0.1 4.7 1.7 1.7 2.2 2.5 2.3 2.9 3.8 0 0.1 0.2 0.2 0.2 0.2-0.9 0.8-0.6 2.8-2.9 2.4-0.8-0.8-2-1.3-3.5-1.5-1.2-0.2-2.2-1.5-3.5-2.5 0.4-0.5 0.6-0.9 0.9-1.2-0.1-0.1-0.4-0.4-0.8-0.9"/>
                            </svg>
                    </figure>

                    <!-- Image -->
                    <img src="../assets/images/teacher.webp" class="rounded-3" alt="image" width="100%" height="100%">
                </div>
            </div>
        </div>
    </div>


<div class="container">

    <h3 class="mt-5 mb-4 text-center">Audio List</h3>
    <div id="table-scroll" class="table-scroll">
      <div class="table-wrap">
        <table class="main-table">
          <thead>
            <tr class="table_header text-center">
              <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">#</span></th>
              <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Media name</span></th>
              <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Date</span></th>
              <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Media mode</span></th>
              <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Action</span></th>
            </tr>
          </thead>
          <tbody>
            <?php 
                $fetch_audio_file = mysqli_query($connection,"SELECT * FROM rev_lsrw WHERE rev_teacher_id = '$teacher_email_id' AND rev_sts = '1' AND rev_category = 'speak' AND rev_sch = '$user_school' AND rev_class = '$subject_class_yt' AND rev_sec = '$class_sec'");
                if (mysqli_num_rows($fetch_audio_file) > 0) {
                    $i = 1;
                    while($rol = mysqli_fetch_assoc($fetch_audio_file)) { ?>
                        <tr class="text-center" style="font-size: 18px">
                          <th class="fixed-side"><?php echo $i++; ?></th>
                          <th class="fixed-side" style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/speak_audio?id=<?php echo htmlspecialchars($rol['tree_id'], ENT_QUOTES, 'UTF-8'); ?>&uni=<?php echo htmlspecialchars($rol['rev_uniq_link'], ENT_QUOTES, 'UTF-8'); ?>" style="text-decoration: none;">💬 <?php echo htmlspecialchars(ucfirst($rol['rev_name']), ENT_QUOTES, 'UTF-8'); ?></a></th>
                          <td><img src="<?php echo BASE_URL; ?>assets/images/calendar.webp" width="20px" height="20px" alt="Calendar">&nbsp;<?php echo htmlspecialchars(date('d-M-Y',strtotime($rol['rev_date'])), ENT_QUOTES, 'UTF-8'); ?>&nbsp;<br><?php echo htmlspecialchars(date('h:i a',strtotime($rol['rev_start_time'])), ENT_QUOTES, 'UTF-8'); ?> to <?php echo htmlspecialchars(date('h:i a',strtotime($rol['rev_end_time'])), ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php 
                                if (strlen($rol['rev_link']) > 20) {
                                    echo 'Upload';
                                } else {
                                    echo 'YouTube';
                                }
                            ?></td>
                          <td>
                            <button href="#" class="btn btn-sm btn-success-soft btn-round me-1 mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop1" data-bs-whatever-edit-name="<?php echo htmlspecialchars($rol['rev_name'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever-edit-date="<?php echo htmlspecialchars($rol['rev_date'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever-edit-start-time="<?php echo htmlspecialchars($rol['rev_start_time'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever-edit-end-time="<?php echo htmlspecialchars($rol['rev_end_time'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever-edit-id="<?php echo htmlspecialchars($rol['tree_id'], ENT_QUOTES, 'UTF-8'); ?>"><i class="far fa-fw fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger-soft btn-round mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-bs-whatever-delete-name="<?php echo htmlspecialchars($rol['rev_name'], ENT_QUOTES, 'UTF-8'); ?>"  data-bs-whatever-delete-id="<?php echo htmlspecialchars($rol['tree_id'], ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-fw fa-times"></i></button>
                          </td>              
                        </tr>
                    <?php }                    
                }
                else{ ?>
                    <style>
                        .main-table{
                            display: none;
                        }
                    </style>

                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="col-md-4 alert alert-warning text-center" role="alert">
                             &nbsp;&nbsp;<img src="../assets/images/warning.svg" width="30px" height="30px" class="rounded" alt="warning"><span class="mt-2 fw-bold" style="font-size: 18px"> <?php echo "No activity scheduled yet!" ?> </span>
                        </div>
                    </div>

               <?php }
            ?>             
          </tbody>
        </table>
      </div>
    </div>
</div>
<br><br>
<!-- =======================
Main Banner END -->


<!--Edit Modal -->
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="w-100 mt-auto d-inline-flex justify-content-center">
                <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
                    <!-- Avatar -->
                    <div class="avatar avatar-sm me-2 rounded-4">
                        <img class="avatar-img rounded-1" src="../assets/images/speaking.svg" alt="avatar">
                    </div>
                    <!-- Avatar info -->
                    <div>
                        <h6 class="mb-0 text-dark">Update audio details of <span class="text-primary hwname">Audio name</span></h6>
                    </div>
                </div>
            </div>
        
                    <form class="row g-3 position-relative" action="" method="post">
                        <!-- Name -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 st_name" type="text" placeholder="Audio name*" name="audio_edit_name" required>
                                </div>
                            </div>
                        </div>
                        <!-- Date -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                      <input type="date" class="form-control border-0 me-1 hm_da da st_date" placeholder="Audio Date"  name="audio_edit_date" min="<?php echo date('Y-m-d'); ?>"/>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Start time -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 time_picker st_start_time" type="text" placeholder="Homework Start time*" name="audio_edit_start" id="timepicker3" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 time_picker st_end_time" type="text" name="audio_edit_end" id="timepicker4" placeholder="Homework End time*" required>
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="col-md-12 mb-4 d-flex justify-content-center">
                            <input type="hidden" name="edit_id" class="st_id" value="">
                            <button type="submit" class="btn btn-primary mb-0" name="edit">Submit</button>
                        </div>
                    </form>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
</div>

<!--Remove Modal -->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-center">
        <img src="../assets/images/exclamation.webp" alt="exclamation" height="30px" width="30px"><span class="text-danger fw-bold mb-2" style="font-size: 16px;">Are you sure you want to delete</span><img src="../assets/images/exclamation.webp" alt="exclamation" height="30px" width="30px">
        </div>
        <div class="w-100 mt-auto d-inline-flex justify-content-center">
            <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
                <!-- Avatar -->
                <div class="avatar avatar-sm me-2 rounded-4">
                    <img class="avatar-img rounded-1" src="../assets/images/speaking.svg" alt="speak">
                </div>
                <!-- Avatar info -->
                <div>
                    <h6 class="mb-0 text-dark">Audio - <span class="text-danger st_name_delete">audio name</span></h6>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <form action="" method="post">
            <input type="hidden" name="delete_id" class="st_id_delete" value="">
            <button type="submit" class="btn btn-danger-soft" name="delete">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="../includes/time_picker.js"></script>
<script type="text/javascript">
    $('#timepicker_up1').mdtimepicker(); //Initializes the time picker
    $('#timepicker_up2').mdtimepicker(); //Initializes the time picker
    $('#timepicker_yt1').mdtimepicker(); //Initializes the time picker
    $('#timepicker_yt2').mdtimepicker(); //Initializes the time picker
    $('#timepicker_rec1').mdtimepicker(); //Initializes the time picker
    $('#timepicker_rec2').mdtimepicker(); //Initializes the time picker
    $('#timepicker3').mdtimepicker(); //Initializes the time picker
    $('#timepicker4').mdtimepicker(); //Initializes the time picker 
</script>

<script type="text/javascript">
    const picker_up = MCDatepicker.create({
        el: '#datepicker_up',                     
        minDate: new Date()
    });
    const picker_yt = MCDatepicker.create({
        el: '#datepicker_yt',                     
        minDate: new Date()
    });
    const picker_rec = MCDatepicker.create({
        el: '#datepicker_rec',                     
        minDate: new Date()
    });
</script>

<!-- <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.yt_box').hide();
        $('.rec_box').hide();
    });

    $('.up_click').click(function(event) {
       $('.up_box').fadeIn(); 
       $('.yt_box').hide(); 
       $('.rec_box').hide();    
    });

    $('.yt_click').click(function(event) {
       $('.yt_box').fadeIn(); 
       $('.up_box').hide(); 
       $('.rec_box').hide();    
    });

    $('.rec_click').click(function(event) {
       $('.rec_box').fadeIn(); 
       $('.yt_box').hide(); 
       $('.up_box').hide();
    });
</script> -->

<script type="text/javascript">
    const exampleModal = document.getElementById('staticBackdrop1')
    exampleModal.addEventListener('show.bs.modal', event => {
      // Button that triggered the modal
      const button = event.relatedTarget
      // Extract info from data-bs-* attributes
      const recipient = button.getAttribute('data-bs-whatever-edit-name');
      const st_name = button.getAttribute('data-bs-whatever-edit-name');
      const st_date = button.getAttribute('data-bs-whatever-edit-date');
      const st_start_time = button.getAttribute('data-bs-whatever-edit-start-time');
      const st_end_time = button.getAttribute('data-bs-whatever-edit-end-time');
      const st_id = button.getAttribute('data-bs-whatever-edit-id');

      // If necessary, you could initiate an AJAX request here
      // and then do the updating in a callback.
      //
      // Update the modal's content.
      const modalTitle = exampleModal.querySelector('.hwname')
      const modalBodyInput = exampleModal.querySelector('.modal-body .st_name')
      const modalBodyInputs = exampleModal.querySelector('.modal-body .st_date')
      const modalBodyInput_st = exampleModal.querySelector('.modal-body .st_start_time')
      const modalBodyInput_et = exampleModal.querySelector('.modal-body .st_end_time')
      const modalBodyInput_id = exampleModal.querySelector('.modal-body .st_id')


       modalTitle.textContent = `${recipient}`
       modalBodyInput.value = st_name
       modalBodyInputs.value = st_date
       modalBodyInput_st.value = st_start_time
       // modalBodyInput_id.value = recipient
       modalBodyInput_et.value = st_end_time
       modalBodyInput_id.value = st_id
    });

    const exampleModal2 = document.getElementById('staticBackdrop2')
    exampleModal2.addEventListener('show.bs.modal', event => {
      // Button that triggered the modal
      const button = event.relatedTarget
      // Extract info from data-bs-* attributes
      const recipient = button.getAttribute('data-bs-whatever-delete-name');
      const st_name_delete = button.getAttribute('data-bs-whatever-delete-name');
      const st_id_delete = button.getAttribute('data-bs-whatever-delete-id');

      // If necessary, you could initiate an AJAX request here
      // and then do the updating in a callback.
      //
      // Update the modal's content.
      const modalTitle = exampleModal2.querySelector('.st_name_delete')
      const modalBodyInput = exampleModal2.querySelector('.modal-body .st_name_delete')
      const modalBodyInputs = exampleModal2.querySelector('.modal-footer .st_id_delete')

       modalTitle.textContent = `${recipient}`
       modalBodyInput.value = st_name_delete
       modalBodyInputs.value = st_id_delete
    });

</script>

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>

<script>
$(document).ready(function(){
    $('button[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('id'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#course-pills-tab button[id="' + activeTab + '"]').tab('show');
    }
    // window.localStorage.removeItem('activeTab');
    localStorage.removeItem("activeTab");
    // localStorage.setItem('activeTab', false);
});

</script>