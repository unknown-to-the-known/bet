<?php //header('Content-Type: application/json'); ?>
<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php     
    if (isset($_COOKIE['aut'])) {
        $auto_login_code = htmlspecialchars($_COOKIE['aut'], ENT_QUOTES, 'UTF-8');
        $fetch_user_auto_login_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_auto_login = '$auto_login_code' AND rev_teach_sts = '1'");

        if (mysqli_num_rows($fetch_user_auto_login_details) > 0) {
            while($j = mysqli_fetch_assoc($fetch_user_auto_login_details)) {
                $user_email = htmlspecialchars($j['rev_teach_email'], ENT_QUOTES, 'UTF-8');
                $redirect = htmlspecialchars($j['rev_erp_domain'], ENT_QUOTES, 'UTF-8');
                 $_SESSION['teach_details'] = $user_email;
                  // header("Location: " . BASE_URL . 'pages/action');   
            }
        }
    }
     if (isset($_SESSION['teach_details'])) {
            $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
        } else {
             header("Location: " . BASE_URL . 'index');
        }        
    ?>
<?php 
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_teach_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['rev_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>
<?php 
    $uniq_id = htmlspecialchars($_SESSION['uniq_id'], ENT_QUOTES, 'UTF-8'); 
    $class_id = htmlspecialchars($_SESSION['class_id'], ENT_QUOTES, 'UTF-8');
    $subject_name = htmlspecialchars($_SESSION['subject_name'], ENT_QUOTES, 'UTF-8');
    $subject_class = htmlspecialchars($_SESSION['subject_class'], ENT_QUOTES, 'UTF-8');
    $subject_sec = htmlspecialchars($_SESSION['class_sec'], ENT_QUOTES, 'UTF-8');
    $lsrw_id = htmlspecialchars($_SESSION['lsrw_id'], ENT_QUOTES, 'UTF-8');
?>

<?php 
    if (isset($_POST['uniq_question_id'])) {
        $question_id = htmlspecialchars($_POST['uniq_question_id'], ENT_QUOTES, 'UTF-8');        
    }

    if (isset($_POST['opt'])) {
        $opt_id = htmlspecialchars($_POST['opt'], ENT_QUOTES, 'UTF-8');
    }
?>

<?php 
    

?>

<?php 
    $fetch_image_url = mysqli_query($connection, "SELECT * FROM rev_lsrw_mcq WHERE  rev_reference_id = '$question_id' AND rev_mcq_sts = '2' ORDER BY tree_id DESC LIMIT 1");

    if (mysqli_num_rows($fetch_image_url) > 0) {
        while($ro = mysqli_fetch_assoc($fetch_image_url)) {
            $question_image = $ro['mcq_question_image'];
            $opt1_image = $ro['mcq_opt1_image'];
            $opt2_image = $ro['mcq_opt2_image'];
            $opt3_image = $ro['mcq_opt3_image'];
            $opt4_image = $ro['mcq_opt4_image'];

            if ($opt_id == '0') {
                echo $question_image;
            }

            if ($opt_id == '1') {
                echo $opt1_image;
            }

            if ($opt_id == '2') {
                echo $opt2_image;
            }

            if ($opt_id == '3') {
                echo $opt3_image;
            }

            if ($opt_id == "4") {
                echo $opt4_image;
            }
        }
    }
?>