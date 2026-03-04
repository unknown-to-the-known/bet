<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php $today = date('Y-m-d h:i a'); ?>

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
    $student_first_name = mysqli_escape_string($connection, trim($_POST['student_first_name']));
    $father_first_name = mysqli_escape_string($connection, trim($_POST['father_first_name']));
    $mother_first_name = mysqli_escape_string($connection, trim($_POST['mother_first_name']));
    $uniq_id = mysqli_escape_string($connection, trim($_POST['uniq_id']));

    $student_middle_name = mysqli_escape_string($connection, trim($_POST['student_middle_name']));
    $father_middle_name = mysqli_escape_string($connection, trim($_POST['father_middle_name']));
    $mother_middle_name = mysqli_escape_string($connection, trim($_POST['mother_middle_name']));

    $student_last_name = mysqli_escape_string($connection, trim($_POST['student_last_name']));
    $father_last_name = mysqli_escape_string($connection, trim($_POST['father_last_name']));
    $mother_last_name = mysqli_escape_string($connection, trim($_POST['mother_last_name']));

    if ($student_first_name == "" || $father_first_name == "" || $mother_first_name == "" || $uniq_id == "") {
        $error_message = "please fill all the fields";
    }

    if (!isset($error_message)) {
        $new_data_insert = "INSERT INTO rev_erp_student_details(rev_student_fname,rev_father_fname,rev_mother_fname,rev_uniq_id,rev_student_mname,rev_student_lname,rev_father_mname,rev_father_lname,rev_mother_mname,rev_mother_lname,rev_school_id,rev_school_name) VALUES ('$student_first_name','$father_first_name', '$mother_first_name', '$uniq_id', '$student_middle_name', '$student_last_name','$father_middle_name','$father_last_name', '$mother_middle_name', '$mother_last_name', '$school_id', '$school_name')";

        if (mysqli_query($connection, $new_data_insert)) {
          $last_id = mysqli_insert_id($connection);
          $error_message = $last_id;
        } else {
          $error_message = "Error, something went wrong";
        }
    }

    if (isset($error_message)) {
        echo $error_message;
    }
?>