<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php $today_date = date('Y-m-d'); ?>
<?php 
	$subject_name_yt = htmlspecialchars($_SESSION['subject_name'], ENT_QUOTES, 'UTF-8');
	$subject_class_yt = htmlspecialchars($_SESSION['subject_class'], ENT_QUOTES, 'UTF-8');
	$class_id = htmlspecialchars($_SESSION['class_id'], ENT_QUOTES, 'UTF-8');
	$class_sec = htmlspecialchars($_SESSION['class_sec'], ENT_QUOTES, 'UTF-8');
	$school_id = htmlspecialchars($_SESSION['school_id'], ENT_QUOTES, 'UTF-8');
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

?>

<?php 
    	

        $uniq_id = htmlspecialchars($_POST['uniq_id'], ENT_QUOTES, 'UTF-8');
        $audio_name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $audio_date = htmlspecialchars($_POST['time'], ENT_QUOTES, 'UTF-8');

        if ($audio_name == "" || $audio_date == "") {
        	$error_message = "Please try again";
        }

        if (!isset($error_message)) {
        	$check_id_uniq_id = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE rev_uniq_link = '$uniq_id'");

	        if (mysqli_num_rows($check_id_uniq_id) > 0) {
	        	$error_message = "Please refresh the page and try again";	
	        } 

	        if (!isset($error_message)) {
                $audio_date = date('Y-m-d', strtotime($audio_date));
	        	$insert = mysqli_query($connection,"INSERT INTO rev_lsrw(rev_name,rev_date,rev_start_time,rev_end_time,rev_teacher_id,	rev_category,rev_link,rev_sch,rev_class,rev_lsrw_sub,rev_sec,rev_uniq_link,rev_sts,rev_question_text,rev_school_id) VALUES('$audio_name', '$audio_date', '00:00', '23:59', '$teacher_email_id', 'listen', '00', '$user_school', '$subject_class_yt', '$subject_name_yt', '$class_sec', '$uniq_id', '2', '00', '$school_id')");
	        }

	        if (isset($error_message)) {
	        	echo trim($error_message);
	        }
        }
?>