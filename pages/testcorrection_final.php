<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php 
    if (isset($_SESSION['teach_details'])) {
       $session_email = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
    }
?>
<?php
    $fetch_teah_detai = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$session_email' AND rev_teach_sts = '1'");
        if (mysqli_num_rows($fetch_teah_detai) > 0) {
                while($lolks = mysqli_fetch_assoc($fetch_teah_detai)) {
                $teacher_name = htmlspecialchars($lolks['rev_teach_name'], ENT_QUOTES, 'UTF-8');
                // $teacher_class = htmlspecialchars($lolks['rev_tea_class'], ENT_QUOTES, 'UTF-8');
                // $teacher_subject_name = htmlspecialchars($lolks['rev_tec_sub'], ENT_QUOTES, 'UTF-8');
                // $teacher_unique_id = htmlspecialchars($lolks['tree_id'], ENT_QUOTES, 'UTF-8');
                
                // $teacher_school = htmlspecialchars($lolks['rev_tec_school'], ENT_QUOTES, 'UTF-8');
            }
        } else {
            header("Location: " . BASE_URL . 'index');
        }
?>
<?php 
 
    if (isset($_POST['name']) && isset($_POST['tim']) && isset($_POST['test_id']) && isset($_POST['mon']) && isset($_POST['paper_id']) && isset($_POST['stud_id'])) {
      $student_id = htmlspecialchars($_POST['stud_id'], ENT_QUOTES, 'UTF-8');
      $img_id = htmlspecialchars($_POST['tim'], ENT_QUOTES, 'UTF-8');
      $test_id = htmlspecialchars($_POST['test_id'], ENT_QUOTES, 'UTF-8');
      $user_mobile = htmlspecialchars($_POST['mon'], ENT_QUOTES, 'UTF-8');
      $paper_id = htmlspecialchars($_POST['paper_id'], ENT_QUOTES, 'UTF-8');
      $student_name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

      if ($student_id == "" || $img_id == "" || $test_id == "" || $user_mobile == "" || $paper_id == "" || $student_name == "") {
            $error_message = "data is missing";
        }  

     if (!isset($error_message)) {
        $fetch_all_student_details = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_id = '$student_id'");

        if (mysqli_num_rows($fetch_all_student_details) > 0) {
            while($hytg = mysqli_fetch_assoc($fetch_all_student_details)) {
                $student_name = htmlspecialchars($hytg['rev_student_name'], ENT_QUOTES, 'UTF-8');
                $school_short_name = htmlspecialchars($hytg['rev_student_sch'], ENT_QUOTES, 'UTF-8');
            }
        }

        $fetch_test_details = mysqli_query($connection, "SELECT * FROM rev_list_of_student_test_submitted WHERE tree_id = '$test_id'");

        if (mysqli_num_rows($fetch_test_details) > 0) {
            while($kjytg = mysqli_fetch_assoc($fetch_test_details)) {
                $original_test_id = $kjytg['rev_test_id'];
            }
        }

        $fetch_test_details_full = mysqli_query($connection, "SELECT * FROM rev_test WHERE tree_id = '$original_test_id'");

        if (mysqli_num_rows($fetch_test_details_full) > 0) {
            while($gyg = mysqli_fetch_assoc($fetch_test_details_full)) {
                $test_name = $gyg['rev_test_name'];
                $test_date = $gyg['rev_test_date'];
            }
        }

        $check_already_insert = mysqli_query($connection, "SELECT * FROM rev_correction_img WHERE rev_stud_id = '$student_id' AND rev_test_id = '$test_id' AND rev_paper_number = '$paper_id' AND rev_sts = '1'");

        if (mysqli_num_rows($check_already_insert) > 0) {
            $update_into = mysqli_query($connection, "UPDATE rev_correction_img SET rev_img_code = '$img_id' WHERE rev_stud_id = '$student_id' AND rev_test_id = '$test_id' AND rev_sts = '1' AND rev_paper_number = '$paper_id'");
            echo 'ok';
        } else {
            $insert_into = mysqli_query($connection,"INSERT INTO rev_correction_img(rev_stud_id,rev_test_id,rev_img_code,rev_sts,rev_paper_number) VALUES ('$student_id', '$test_id', '$img_id', '1', '$paper_id')");
            echo 'ok';
        }
     }
    } 
?>