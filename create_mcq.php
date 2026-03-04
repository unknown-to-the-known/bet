<?php require 'includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php $today = date('Y-m-d H:i'); ?>
<?php 
    if (isset($_SESSION['user_login'])) {
        $user_id = htmlspecialchars($_SESSION['user_login'], ENT_QUOTES, 'UTF-8');  
    } else {
        header("Location: " . BASE_URL . 'register');
    }
?>
<?php 
    $fetch_teacher_all_details = mysqli_query($connection, "SELECT * FROM mcq_academy_user_data WHERE mcq_whats = '$user_id' AND mcq_sts = '1'");

    if (mysqli_num_rows($fetch_teacher_all_details) > 0) {
        while($ro = mysqli_fetch_assoc($fetch_teacher_all_details)) {
            $teacher_name = htmlspecialchars($ro['mcq_name'], ENT_QUOTES, 'UTF-8');
            $teacher_agreement_sts = htmlspecialchars($ro['mcq_agreement'], ENT_QUOTES, 'UTF-8');
        }   
    }
?>
<?php 
    if ($teacher_agreement_sts == '0') {
        header("Location: " . BASE_URL . 'agreement');
    }
?>
    <?php
        $time_date_sec = date('Y-m-d H:i:s');

        $_SESSION['temp_session'] = $uniq_zen = md5($time_date_sec);

    ?>

<?php 
    

    if (isset($_GET['id'])) {
        if ($_GET['id'] != "") {
            $chapter_ids = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');    
        } else {
            header("Location: " . BASE_URL . 'dash');
        }   
    } else {
            header("Location: " . BASE_URL . 'dash');
        }
?>
<?php 
    $fetch_chapter_name = mysqli_query($connection, "SELECT * FROM mcq_academy_chapter_name WHERE tree_id = '$chapter_ids' AND mcq_sts = '1'");

    if (mysqli_num_rows($fetch_chapter_name) > 0) {
        while($htg = mysqli_fetch_assoc($fetch_chapter_name)){
            $chapter_name = $htg['mcq_chapter_name'];
            $chapter_syllabus = $htg['mcq_chapter_sylabus'];
            $chapter_class = $htg['mcq_chapter_class'];
            $chapter_sujbect = $htg['mcq_subject_name']; 
        }
    }



?>

<?php 
    if (isset($_POST['btnSubmit'])) {

        $question_mcq = mysqli_escape_string($connection, trim($_POST['name']));
        $question_mcq_opt_1 = mysqli_escape_string($connection, trim($_POST['opt1']));
        $question_mcq_opt_2 = mysqli_escape_string($connection, trim($_POST['opt2']));
        $question_mcq_opt_3 = mysqli_escape_string($connection, trim($_POST['opt3']));
        $question_mcq_opt_4 = mysqli_escape_string($connection, trim($_POST['opt4']));
        $question_answer = mysqli_escape_string($connection, trim($_POST['flexRadioDefault']));
        $question_desc = mysqli_escape_string($connection, trim($_POST['quest_desc']));

        $question_image = mysqli_escape_string($connection, trim($_POST['mcq_question']));
        $question_mcq_opt_1_image = mysqli_escape_string($connection, trim($_POST['mcq_opt1']));
        $question_mcq_opt_2_image = mysqli_escape_string($connection, trim($_POST['mcq_opt2']));
        $question_mcq_opt_3_image = mysqli_escape_string($connection, trim($_POST['mcq_opt3']));
        $question_mcq_opt_4_image = mysqli_escape_string($connection, trim($_POST['mcq_opt4']));
        $question_desc_image = mysqli_escape_string($connection, trim($_POST['mcq_just']));


        $insert = mysqli_query($connection, "INSERT INTO mcq_academy_question(mcq_question,mcq_uniq_id,mcq_opt1,mcq_opt2,mcq_opt3,mcq_opt4,mcq_correct_option,mcq_desc,mcq_image_question,mcq_image_opt1,mcq_image_opt2,mcq_image_opt3,mcq_image_opt4,mcq_image_just,mcq_sts,mcq_time,mcq_owner,mcq_chapter_name,   mcq_chapter_syllabus,mcq_chapter_class,mcq_chapter_suject,mcq_diffuculty_level,mcq_diffuculty_level_approved_on,mcq_rejection_reason,mcq_approved_teacher,mcq_temp_session) VALUES ('$question_mcq','$chapter_ids', '$question_mcq_opt_1', '$question_mcq_opt_2', '$question_mcq_opt_3', '$question_mcq_opt_4', '$question_answer', '$question_desc', '$question_image', '$question_mcq_opt_1_image','$question_mcq_opt_2_image', '$question_mcq_opt_3_image', '$question_mcq_opt_4_image', '$question_desc_image','3', '$today', '$user_id', '$chapter_name','$chapter_syllabus','$chapter_class','$chapter_sujbect','0', '0', '', '','')");

        if (isset($insert)) {
            $error_message = "Success, Question added";
        }



        // if ($question_mcq == "" || $question_mcq_opt_1 == "" || $question_mcq_opt_2 == "" || $question_mcq_opt_3 == "" || $question_mcq_opt_4 == "") {
        //     $error_message = "Please fill all the fields";
        // }

        // if (!isset($error_message)) {
        //     $fetch_all_old_questions = mysqli_query($connection, "SELECT * FROM mcq_academy_question WHERE mcq_uniq_id = '$chapter_ids'");

        //     if (mysqli_num_rows($fetch_all_old_questions) > 0) {
        //         while($jh = mysqli_fetch_assoc($fetch_all_old_questions)) {
        //             $old_questions = $jh['mcq_question'];
        //             $sim .= similar_text($old_questions, $question_mcq, $perc);
        //         }
        //     }
        // }



        // if (!isset($error_message)) {
        //     if ($sim > 80) {
        //         $error_message = "Seems like we already have a similar question!! Please try entering a new one";
        //     }
        // }

        // if (!isset($error_message)) {
        //     $check_if_image_is_uploaded = mysqli_query($connection, "SELECT * FROM mcq_academy_question WHERE mcq_temp_session = '$uniq_zen'");

        //     if (mysqli_num_rows($check_if_image_is_uploaded) > 0) {
        //         $insert_into_single = mysqli_query($connection, "UPDATE mcq_academy_question SET mcq_question = '$question_mcq',mcq_uniq_id = '$chapter_ids', mcq_opt1 = '$question_mcq_opt_1', mcq_opt2 = '$question_mcq_opt_2', mcq_opt3 = '$question_mcq_opt_3', mcq_opt4 = '$question_mcq_opt_4', mcq_correct_option = '$question_answer', mcq_desc = '$question_desc', mcq_sts = '1', mcq_time = '$today', mcq_owner = '$user_id', mcq_chapter_name = '$chapter_name', mcq_chapter_syllabus = '$chapter_syllabus', mcq_chapter_class = '$chapter_class', mcq_chapter_suject = '$chapter_sujbect', mcq_diffuculty_level = '0', mcq_rejection_reason = '', mcq_approved_teacher = '' WHERE mcq_temp_session = '$uniq_zen'");
        //     if (isset($insert_into_single)) {
        //         $error_message = "Success, Question uploaded successfully";
        //     }
        //     } else {
        //         echo 'nsert';
        //     }            
        // }
    }
?>
<?php 
    // $fetch_chapter_details = mysqli_query($connection, "SELECT * FROM ");

    if (isset($_POST['submit'])) {        
        $file = $_FILES['upload_file'];
        $name = strtolower($file['name']);
        $size = $file['size'];
         $extract_ext = pathinfo($name, PATHINFO_EXTENSION);
         // echo $allowed_ext = $extract_ext['extension'];
        $explode_ext = explode('.', $name);
        $allowed_ext = $explode_ext[1];
        $array = array('csv');

        if (!in_array($allowed_ext, $array)) {
            $error_message = "Sorry only .csv file is allowed";
        }

        if (!isset($error_message)) {
            if ($size > 100000) {
                $error_message = "File size must be less than 100 KB";      
            }   
        }

        if (!isset($error_message)) {
            $handle = fopen($_FILES['upload_file']['tmp_name'], "r");

            while($data = fgetcsv($handle)) {
                $item_question_name = mysqli_escape_string($connection, trim($data[0]));
                $item_opt_1 = mysqli_escape_string($connection, trim($data[1]));               
                $item_opt_2 = mysqli_escape_string($connection, trim($data[2]));
                $std_opt_3 = mysqli_escape_string($connection, strtolower(trim($data[3])));
                $std_opt_4 = mysqli_escape_string($connection, strtolower(trim($data[4])));  
                $std_opt_correct = mysqli_escape_string($connection, strtolower(trim($data[5]))); 
                $std_desc = mysqli_escape_string($connection, strtolower(trim($data[6])));

                $query = mysqli_query($connection,"INSERT INTO mcq_academy_question(mcq_question, mcq_opt1, mcq_opt2, mcq_opt3, mcq_opt4,mcq_correct_option, mcq_desc, mcq_sts, mcq_time, mcq_owner, mcq_uniq_id,mcq_image_question,mcq_image_opt1,mcq_image_opt2,mcq_image_opt3,mcq_image_opt4,mcq_image_just,mcq_chapter_name, mcq_chapter_syllabus,mcq_chapter_class,mcq_chapter_suject,mcq_diffuculty_level,mcq_diffuculty_level_approved_on,mcq_rejection_reason,   mcq_approved_teacher,mcq_temp_session) VALUES ('$item_question_name', '$item_opt_1', '$item_opt_2', '$std_opt_3', '$std_opt_4', '$std_opt_correct', '$std_desc', '3', '$today', '$user_id', '$chapter_ids','','','','','','','$chapter_name','$chapter_syllabus','$chapter_class','$chapter_sujbect','0', '0', '', '','')");
                 // $query_run = mysqli_query($connection, $query);
            }                      
            }                 
        }
?>

<?php 
    if (isset($_POST['remove'])) {
        $uniq_id = mysqli_escape_string($connection, trim($_POST['uniq_id']));

        if ($uniq_id == "") {
            $error_message = "Something went wrong";
        }

        if (!isset($error_message)) {
            $delete =  mysqli_query($connection,"DELETE  FROM mcq_academy_question WHERE tree_id = '$uniq_id' AND  mcq_owner = '$user_id'");
        }
    }
?>

<?php 
    if (isset($_POST['final_submit'])) {
        $update = mysqli_query($connection, "UPDATE mcq_academy_question SET mcq_sts = '1' WHERE mcq_sts = '3' AND mcq_owner = '$user_id'");
    }
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<script>
  UPLOADCARE_PUBLIC_KEY = 'b86d765006e12cf9532d';
  UPLOADCARE_TABS = 'camera file';
</script>
<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>
<link href="https://releases.transloadit.com/uppy/v3.8.0/uppy.min.css" rel="stylesheet" />
    <style type="text/css">
      .uppy-Dashboard-poweredByUppy, .uppy-Dashboard-poweredByIcon, .uppy-Dashboard-poweredBy {
        visibility: hidden;
      }
    </style>

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
<!-- =======================
Main Banner START -->
    <div class="container zindex-100 desk" style="margin-top: 10px">
        <div class="row">
            <h6 class=" font-base bg-light bg-opacity-10 text-danger py-2 px-4 rounded-2 btn-transition" style="font-size: 20px;"><img src="assets/images/hello.svg" width="45px">&nbsp;&nbsp;<?php echo $teacher_name; ?></h6>
        </div>
    </div>

    <!-- Content START -->
    <div class="container zindex-100 desk mt-4" id="scroll_up">
        <div class="row d-lg-flex justify-content-md-center g-md-5">
            <span class="d-flex justify-content-end mb-2">
                <a href="<?php echo BASE_URL; ?>chapter_full_question?id=<?php echo $chapter_ids; ?>"><button class="btn btn-primary-soft btn-sm">View All Questions</button></a>
            </span>
            
                <h4 class="fs-1 fw-bold d-flex justify-content-center">
                    <img src="<?php echo BASE_URL; ?>assets/images/MCQ.webp" width="50px" height="50px" alt="MCQ">
                    <span class="position-relative z-index-9" style="font-size: 33px;">&nbsp;Create&nbsp;</span>
                    <span class="position-relative z-index-1" style="font-size: 33px;">MCQ                     
                        <span class="position-absolute top-50 start-50 translate-middle z-index-n1">
                            <svg width="163.9px" height="48.6px">
                                <path class="fill-warning" d="M162.5,19.9c-0.1-0.4-0.2-0.8-0.3-1.3c-0.1-0.3-0.2-0.5-0.4-0.7c-0.3-0.4-0.7-0.7-1.2-0.9l0.1,0l-0.1,0 c0.1-0.4-0.2-0.5-0.5-0.6c0,0-0.1,0-0.1,0c-0.1-0.1-0.2-0.2-0.3-0.3c0-0.3,0-0.6-0.2-0.7c-0.1-0.1-0.3-0.2-0.6-0.2 c0-0.3-0.1-0.5-0.3-0.6c-0.1-0.1-0.3-0.2-0.5-0.2c-0.1,0-0.1,0-0.2,0c-0.5-0.4-1-0.8-1.4-1.1c0,0,0-0.1,0-0.1c0-0.1-0.1-0.1-0.3-0.2 c-0.9-0.5-1.8-1-2.6-1.5c-6-3.6-13.2-4.3-19.8-6.2c-4.1-1.2-8.4-1.4-12.6-2c-5.6-0.8-11.3-0.6-16.9-1.1c-2.3-0.2-4.6-0.3-6.8-0.3 c-1.2,0-2.4-0.2-3.5-0.1c-2.4,0.4-4.9,0.6-7.4,0.7c-0.8,0-1.7,0.1-2.5,0.1c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0-0.2,0 c-0.9,0-1.8,0.1-2.7,0.1c-0.9,0-1.8,0-2.7,0c-5.5-0.3-10.7,0.7-16,1.5c-2.5,0.4-5.1,1-7.6,1.5c-2.8,0.6-5.6,0.7-8.4,1.4 c-4.1,1-8.2,1.9-12.3,2.6c-4,0.7-8,1.6-11.9,2.7c-3.6,1-6.9,2.5-10.1,4.1c-1.9,0.9-3.8,1.7-5.2,3.2c-1.7,1.8-2.8,4-4.2,6 c-1,1.3-0.7,2.5,0.2,3.9c2,3.1,5.5,4.4,9,5.7c1.8,0.7,3.6,1,5.3,1.8c2.3,1.1,4.6,2.3,7.1,3.2c5.2,2,10.6,3.4,16.2,4.4 c3,0.6,6.2,0.9,9.2,1.1c4.8,0.3,9.5,1.1,14.3,0.8c0.3,0.3,0.6,0.3,0.9-0.1c0.7-0.3,1.4,0.1,2.1-0.1c3.7-0.6,7.6-0.3,11.3-0.3 c2.1,0,4.3,0.3,6.4,0.2c4-0.2,8-0.4,11.9-0.8c5.4-0.5,10.9-1,16.2-2.2c0.1,0.2,0.2,0.1,0.2,0c0.5-0.1,1-0.2,1.4-0.3 c0.1,0.1,0.2,0.1,0.3,0c0.5-0.1,1-0.3,1.6-0.3c3.3-0.3,6.7-0.6,10-1c2.1-0.3,4.1-0.8,6.2-1.2c0.2,0.1,0.3,0.1,0.4,0.1 c0.1,0,0.1,0,0.2-0.1c0,0,0.1,0,0.1-0.1c0,0,0-0.1,0.1-0.1c0.2-0.1,0.4-0.1,0.6-0.2c0,0,0.1,0,0.1,0c0.1,0,0.2-0.1,0.3-0.2 c0,0,0,0,0,0l0,0c0,0,0,0,0,0c0.2,0,0.4-0.1,0.5-0.1c0,0,0,0,0,0c0.1,0,0.1,0,0.2,0c0.2,0,0.3-0.1,0.3-0.3c0.5-0.2,0.9-0.4,1.4-0.5 c0.1,0,0.2,0,0.2,0c0,0,0.1,0,0.1,0c0,0,0.1-0.1,0.1-0.1c0,0,0,0,0.1,0c0,0,0.1,0,0.1,0c0.2,0.1,0.4,0.1,0.6,0 c0.1,0,0.1-0.1,0.2-0.2c0.1-0.1,0.1-0.2,0.1-0.3c0.5-0.2,1-0.4,1.6-0.7c1.5-0.7,3.1-1.4,4.7-1.9c4.8-1.5,9.1-3.4,12.8-6.3 c0.8-0.2,1.2-0.5,1.6-1c0.2-0.3,0.4-0.6,0.5-0.9c0.5-0.1,0.7-0.2,0.9-0.5c0.2-0.2,0.2-0.5,0.3-0.9c0-0.1,0-0.1,0.1-0.1 c0.5,0,0.6-0.3,0.8-0.5C162.3,24,163,22,162.5,19.9z M4.4,28.7c-0.2-0.4-0.3-0.9-0.1-1.2c1.8-2.9,3.4-6,6.8-8 c2.8-1.7,5.9-2.9,8.9-4.2c4.3-1.8,9-2.5,13.6-3.4c0,0.1,0,0.2,0,0.2l0,0c-1.1,0.4-2.2,0.7-3.2,1.1c-3.3,1.1-6.5,2.1-9.7,3.4 c-4.2,1.6-7.6,4.2-10.1,7.5c-0.5,0.7-1,1.3-1.6,2c-2.2,2.7-1,4.7,1.2,6.9c0.1,0.1,0.3,0.3,0.4,0.5C7.8,32.5,5.5,31.2,4.4,28.7z  M158.2,23.8c-1.7,2.8-4.1,5.1-7,6.8c-2,1.2-4.5,2.1-6.9,2.9c-3.3,1-6.4,2.4-9.5,3.7c-3.9,1.6-8.1,2.5-12.4,2.9 c-6,0.5-11.8,1.5-17.6,2.5c-4.8,0.8-9.8,1-14.7,1.5c-5.6,0.6-11.2,0.2-16.8,0.1c-3.1-0.1-6.3,0.3-9.4,0.5c-2.6,0.2-5.2,0.1-7.8-0.1 c-3.9-0.3-7.8-0.5-11.7-0.9c-2.8-0.3-5.5-0.7-8.2-1.4c-3.2-0.8-6.3-1.7-9.5-2.5c-0.5-0.1-1-0.3-1.4-0.5c-0.2-0.1-0.4-0.1-0.6-0.2 c0,0,0.1,0,0.1,0c0.3-0.1,0.5,0,0.7,0.1c0,0,0,0,0,0c3.4,0.5,6.9,1.2,10.3,1.4c0.5,0,1,0,1.5,0c0.5,0,1.3,0.2,1.3-0.3 c0-0.6-0.7-0.9-1.4-0.9c-2.1,0-4.2-0.2-6.3-0.5c-4.6-0.7-9.1-1.5-13.4-3c-2.9-1.1-5.4-2.7-6.9-5.2c-0.5-0.8-0.5-1.6-0.1-2.4 c3.2-6.2,9-9.8,16.3-12.2c6.7-2.2,13.2-4.5,20.2-6c5-1.1,10-1.8,15-2.9c8.5-1.9,17.2-2.4,26-2.7c3.6-0.1,7.1-0.8,10.8-0.6 c8.4,0.7,16.7,1.2,25,2.3c4.5,0.6,9,1.2,13.6,1.7c3.6,0.4,7.1,1.4,10.5,2.8c3.1,1.3,6,2.9,8.5,5C159.1,17.7,159.8,21.1,158.2,23.8z"/>
                            </svg>
                        </span>                     
                    </span>
                </h4>           
          </div> 
    </div> 

<section style="background: #F5F7F9">
    <!-- SVG decoration -->
   <!--  <figure class="position-absolute bottom-0 start-0 d-none d-lg-block">
        <svg width="822.2px" height="301.9px" viewBox="0 0 822.2 301.9">
            <path class="fill-warning" d="M752.5,51.9c-4.5,3.9-8.9,7.8-13.4,11.8c-51.5,45.3-104.8,92.2-171.7,101.4c-39.9,5.5-80.2-3.4-119.2-12.1 c-32.3-7.2-65.6-14.6-98.9-13.9c-66.5,1.3-128.9,35.2-175.7,64.6c-11.9,7.5-23.9,15.3-35.5,22.8c-40.5,26.4-82.5,53.8-128.4,70.7 c-2.1,0.8-4.2,1.5-6.2,2.2L0,301.9c3.3-1.1,6.7-2.3,10.2-3.5c46.1-17,88.1-44.4,128.7-70.9c11.6-7.6,23.6-15.4,35.4-22.8 c46.7-29.3,108.9-63.1,175.1-64.4c33.1-0.6,66.4,6.8,98.6,13.9c39.1,8.7,79.6,17.7,119.7,12.1C634.8,157,688.3,110,740,64.6 c4.5-3.9,9-7.9,13.4-11.8C773.8,35,797,16.4,822.2,1l-0.7-1C796.2,15.4,773,34,752.5,51.9z"/>
        </svg>
    </figure> -->
    
    <!-- SVG decoration -->
    <figure class="position-absolute bottom-0 start-50 translate-middle-x ms-n9 mb-5">
        <svg width="23px" height="23px">
            <path class="fill-primary" d="M23.003,11.501 C23.003,17.854 17.853,23.003 11.501,23.003 C5.149,23.003 -0.001,17.854 -0.001,11.501 C-0.001,5.149 5.149,-0.000 11.501,-0.000 C17.853,-0.000 23.003,5.149 23.003,11.501 Z"></path>
        </svg>
    </figure>

    <!-- SVG decoration -->
    <figure class="position-absolute bottom-0 end-0 me-5 mb-5">
        <svg width="22px" height="22px">
            <path class="fill-warning" d="M22.003,11.001 C22.003,17.078 17.077,22.003 11.001,22.003 C4.925,22.003 -0.001,17.078 -0.001,11.001 C-0.001,4.925 4.925,-0.000 11.001,-0.000 C17.077,-0.000 22.003,4.925 22.003,11.001 Z"></path>
        </svg>
    </figure>

    <?php 
        if (isset($error_message)) { ?>
            <div class="container mb-4">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="alert alert-success alert-dismissible fade show mt-2 mb-0 rounded-3" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        <?php }  ?>

    <div class="container">
        <div class="row g-lg-5 mb-4">
            <!-- Item -->
                <div class="col-md-6 col-lg-4 text-center position-relative card shadow-hover overflow-hidden bg-transparent btn-transition">
                    <div class="px-4 mt-2">
                        <span id="bulk_upl">
                            <!-- Image -->
                            <div class="icon-xxl bg-transparent shadow mx-auto rounded-circle mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/upload.svg" width="70px" height="70px" alt="Student List">
                            </div>
                            <!-- Title -->
                            <h5>Upload bulk questions</h5>
                            <p class="pb-0 fw-bold text-primary" style="text-align: center;">Download a demo sheet and Create MCQs in same format for bulk upload</p>
                        </span>
                            <a href="assets/images/Demo_MCQs.csv" download><button class="btn btn-danger btn-sm">Download Demo Sheet</button></a>
                    </div>
                </div>

            <!-- Item -->
            <div class="col-md-6 col-lg-4 text-center position-relative card shadow-hover overflow-hidden bg-transparent btn-transition" id="MCQ_ques">
                <div class="px-4 mt-2">
                    <!-- Image -->
                    <div class="icon-xxl bg-body shadow mx-auto rounded-circle mb-3">
                        <img src="<?php echo BASE_URL; ?>assets/images/MCQ.svg" width="65px" height="65px" alt="Generate report">
                    </div>
                    <!-- Title -->
                    <h5>Enter MCQs</h5>
                    <p class="pb-0 fw-bold text-primary" style="text-align: center;">Create MCQs by entering question with 4 options and giving the Key along with justification</p>
                </div>
            </div>

            <!-- Item -->
                <div class="col-md-6 col-lg-4 text-center position-relative card shadow-hover overflow-hidden bg-transparent btn-transition">
                    <div class="px-4 mt-2">
                        <a href="<?php echo BASE_URL; ?>teacher_question?id=<?php echo htmlspecialchars($chapter_ids, ENT_QUOTES, 'UTF-8'); ?>" style="text-decoration: none;">
                        <!-- Image -->
                        <div class="icon-xxl bg-body shadow mx-auto rounded-circle mb-3">
                            <img src="<?php echo BASE_URL; ?>assets/images/view.svg" width="65px" height="65px" alt="Homework">
                        </div>
                        <!-- Title -->
                        <h5>View entered MCQs</h5>
                        <p class="pb-0 fw-bold" style="text-align: center;">View all the MCQs (along with their status), that you have entered so far</p>
                        </a>
                    </div>  
                </div>
        

            <!-- Communication Center ended -->
            <!-- </div> -->
        </div>
        <style type="text/css">
             ::file-selector-button {
                 --color: #e75480;
                 --hover: #e79654;
            }
             ::file-selector-button {
                 font-size: 1.5rem;
                 border: none;
                 background: white;
                 border: 1px solid var(--color);
                 color: var(--color);
                 transition: 1.3s;
                 padding: 1rem 2rem;
                 font-size: 1.5rem;
                 width: 13.5rem;
                 height: 5rem;
                 border-radius: 2rem;
            }
             ::file-selector-button:hover, ::file-selector-button:focus {
                 border-color: var(--hover);
                 color: white;
            }
             ::file-selector-button:hover, ::file-selector-button:focus {
                 box-shadow: inset 15rem 0 0 0 var(--hover);
            }
             
        </style>
        <div class="row justify-content-center align-items-center my-5" id="upl_btn">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="upload_file"><br>
                <button class="btn btn-primary mt-2" name="submit">Submit</button>
            </form>        
        </div>

    </div>

    <div class="container" id="display_ques">
        <form class="row g-3 position-relative" id="myForm" action="" method="post">
            <div class="col-12 mt-4">
                <label class="control-label" for="textinput">
                    <h6 class="text-primary fw-bold me-3">Question*</h6>
                </label>
                <div class="bg-body shadow p-2 d-flex justify-content-between" style="border-radius: 20px;">
                    
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" height="5em" viewBox="0 0 512 512" id="uppyModalOpener">
                        
                        <path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg> -->
                    <textarea class="form-control border-0" rows="3" placeholder="Question*" name="name" id="Name" required autocomplete="off"></textarea>
                    <input type="hidden" role="uploadcare-uploader" name="mcq_question" />
                    <!-- <img src="/assets/images/gallery.svg" width="50px" id="uppyModalOpener_question" alt="Gallery" style="float: right"> -->
                </div>
            </div>
            

            <!-- Option 1 -->
            <div class="col-md-6 col-lg-12 col-xl-6 col-sm-1">
                <label class="control-label" for="textinput">
                    <h6 class="text-primary fw-bold me-3">Option A*</h6>
                </label>
                <div class="bg-body shadow rounded-pill p-2">
                    <div class="input-group d-flex justify-content-between">
                        <input class="form-control border-0 me-1 dates" type="text" placeholder="Option A*" name="opt1" id="opt1" required autocomplete="off">
                        <input type="hidden" role="uploadcare-uploader" name="mcq_opt1" />
                        <!-- <img src="/assets/images/gallery.svg" width="30px" id="uppyModalOpener_opta" alt="Gallery"> -->
                    </div>
                </div>
            </div>
            <!-- Option 2 -->
            <div class="col-md-6 col-lg-12 col-xl-6">
                <label class="control-label" for="textinput">
                    <h6 class="text-primary fw-bold me-3">Option B*</h6>
                </label>
                <div class="bg-body shadow rounded-pill p-2">
                    <div class="input-group d-flex justify-content-between">
                        <input class="form-control border-0 me-1 dates" type="text" placeholder="Option B*" name="opt2" id="opt2"  required autocomplete="off">
                        <input type="hidden" role="uploadcare-uploader" name="mcq_opt2" />
                        <!-- <img src="/assets/images/gallery.svg" width="30px" id="uppyModalOpener_optb" alt="Gallery"> -->
                    </div>
                </div>
            </div>
            <!-- Option 3 -->
            <div class="col-md-6 col-lg-12 col-xl-6">
                <label class="control-label" for="textinput">
                    <h6 class="text-primary fw-bold me-3">Option C*</h6>
                </label>
                <div class="bg-body shadow rounded-pill p-2">
                    <div class="input-group d-flex justify-content-between">
                        <input class="form-control border-0 me-1 dates" type="text" placeholder="Option C*" name="opt3" id="opt3" required autocomplete="off">
                        <input type="hidden" role="uploadcare-uploader" name="mcq_opt3" />
                        <!-- <img src="/assets/images/gallery.svg" width="30px" id="uppyModalOpener_optc" alt="Gallery"> -->
                    </div>
                </div>
            </div>
            <!-- Option 4 -->
             <div class="col-md-6 col-lg-12 col-xl-6">
                <label class="control-label" for="textinput">
                    <h6 class="text-primary fw-bold me-3">Option D*</h6>
                </label>
                <div class="bg-body shadow rounded-pill p-2">
                    <div class="input-group d-flex justify-content-between">
                        <input class="form-control border-0 me-1 dates" type="text" placeholder="Option D*" name="opt4" id="opt4" required autocomplete="off">
                        <input type="hidden" role="uploadcare-uploader" name="mcq_opt4" />
                        <!-- <img src="/assets/images/gallery.svg" width="30px" id="uppyModalOpener_optd" alt="Gallery"> -->
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <label class="control-label" for="textinput">
                <h5 class="text-primary fw-bold me-3">Key:</h5></label>
                <div>
                    <div class="form-check form-check-inline text mb-3">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" required="required" value="A">
                      <label class="form-check-label" for="flexRadioDefault1"><img src="/assets/images/letter-a.webp" alt="A" style="width: 35px"></label>
                    </div>
                    <div class="form-check form-check-inline img mb-3">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" required="required" value="B">
                      <label class="form-check-label" for="flexRadioDefault2"><img src="/assets/images/letter-b.webp" alt="B" style="width: 35px"></label>
                    </div>
                    <div class="form-check form-check-inline pdf mb-3">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" required="required" value="C">
                      <label class="form-check-label" for="flexRadioDefault3"><img src="/assets/images/letter-c.webp" alt="C" style="width: 35px"></label>
                    </div>
                    <div class="form-check form-check-inline pdf mb-3">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" required="required" value="D">
                      <label class="form-check-label" for="flexRadioDefault4"><img src="/assets/images/letter-d.webp" alt="D" style="width: 35px"></label>
                    </div>
                </div>
            </div>
            
            <!-- Button -->
            <label class="control-label" for="textinput">
                <h6 class="text-primary fw-bold me-3">Justification/Description*</h6>
            </label>
            <div class="bg-body shadow p-2 d-flex justify-content-between" style="border-radius: 20px;">
                <textarea class="form-control border-0" rows="3" placeholder="Justification/Description*" name="quest_desc" id="Name" required autocomplete="off"></textarea>
                <input type="hidden" role="uploadcare-uploader" name="mcq_just" />
                <!-- <img src="/assets/images/gallery.svg" width="50px" id="uppyModalOpener_justification" alt="Gallery"> -->
            </div>
            
            <div class="form-group d-flex justify-content-center mb-4">
                <label class="col-md-4 control-label" for="button1id"></label>
                <div class="col-md-8">
                     <button class="btn btn-primary-soft submi" id="btnSubmit" name="btnSubmit"><i class="bi bi-plus-circle-dotted"></i> Add Question</button>
                     <button class="btn btn-danger-soft" id="btnReset" type="reset" name="btnReset" value="Reset">Reset</button>
                </div>
            </div>
                
            <div class="result"></div>                        
        </form> 
    </div>

    <?php 
            $fetch_uploaded_question = mysqli_query($connection, "SELECT * FROM mcq_academy_question WHERE mcq_owner = '$user_id' AND mcq_uniq_id = '$chapter_ids' AND mcq_sts = '2'");

            if (mysqli_num_rows($fetch_uploaded_question) > 0) {
                  ?>
                  <div class="container">
    <!-- <h3>Your Uploads</h3> -->

    <div class="row">
        <div class="col-12">
            <div class="card border bg-transparent rounded-3 mt-5">
                <!-- Card header START -->
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-sm-flex justify-content-sm-center align-items-center">
                        <h3 class="mb-2 mb-sm-0 text-dark">Your uploads</h3>
                    </div>
                </div>
                <!-- Card header END -->

                <!-- Card body START -->
                <div class="card-body">
                    <div class="table-responsive border-0 rounded-3">
                        <!-- Table START -->
                        <table class="table table-dark-gray align-middle p-4 mb-0">
                            <!-- Table head -->
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0 rounded-start">#</th>
                                    <th scope="col" class="border-0">Question</th>
                                    <th scope="col" class="border-0">Option A</th>
                                    <th scope="col" class="border-0">Option B</th>
                                    <th scope="col" class="border-0">Option C</th>
                                    <th scope="col" class="border-0">Option D</th>
                                    <th scope="col" class="border-0">Correct option</th>
                                    <th scope="col" class="border-0">Justification</th>
                                    <th scope="col" class="border-0 rounded-end">Action</th>
                                </tr>
                            </thead>
                            <!-- Table body START -->
                            <tbody>
                            <?php 
                                $fetch_uploaded_question = mysqli_query($connection, "SELECT * FROM mcq_academy_question WHERE mcq_owner = '$user_id' AND mcq_sts = '2'");

                                if (mysqli_num_rows($fetch_uploaded_question) > 0) {
                                    $i = 1;
                                    while($tr = mysqli_fetch_assoc($fetch_uploaded_question)) { ?>
                                        <tr>
                                          <th scope="row"><?php echo $i++; ?>)</th>
                                          <?php 
                                            $user_question = $tr['mcq_question'];
                                            $check_question_already_present = mysqli_query($connection, "SELECT * FROM mcq_academy_question WHERE mcq_question = '$user_question' AND mcq_sts = '1'");

                                            if (mysqli_num_rows($check_question_already_present) > 0) { ?>
                                                <td style="color: red;"><?php echo htmlspecialchars($tr['mcq_question'], ENT_QUOTES, 'UTF-8'); ?><br><small>(Question already Present in our database)</small></td>
                                            <?php } else { ?>
                                                <td><?php echo htmlspecialchars($tr['mcq_question'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <?php } ?>

                                          
                                          <td><?php echo htmlspecialchars($tr['mcq_opt1'], ENT_QUOTES, 'UTF-8'); ?></td>
                                          <td><?php echo htmlspecialchars($tr['mcq_opt2'], ENT_QUOTES, 'UTF-8'); ?></td>
                                          <td><?php echo htmlspecialchars($tr['mcq_opt3'], ENT_QUOTES, 'UTF-8'); ?></td>
                                          <td><?php echo htmlspecialchars($tr['mcq_opt4'], ENT_QUOTES, 'UTF-8'); ?></td>
                                          <td><?php echo htmlspecialchars(ucfirst($tr['mcq_correct_option']), ENT_QUOTES, 'UTF-8'); ?></td>
                                          <td><?php echo htmlspecialchars($tr['mcq_desc'], ENT_QUOTES, 'UTF-8'); ?></td>
                                          <?php 
                                            if (mysqli_num_rows($check_question_already_present) > 0) { ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="uniq_id" value="<?php echo htmlspecialchars($tr['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                                    <td><button class="btn btn-danger" type="submit" name="remove">Delete</button></td>
                                                </form>
                                                
                                            <?php } ?>
                                        </tr>
                                    <?php }   
                                }
                            ?>
                          </tbody>
                            <!-- Table body END -->
                        </table>
                        <!-- Table END -->
                    </div>
                </div>
                <!-- Card body START -->
            </div>
        </div>
    </div>
    <?php 
    if (mysqli_num_rows($check_question_already_present) > 0) { ?>
    
    <?php } else { ?>
        <div class="d-flex justify-content-center mt-4">
            <form action="" method="post">
                <button class="btn btn-success" name="final_submit" type="submit">Submit</button>
            </form>
        </div>
    <?php } ?>
<?php } ?>
</div>
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type="text/javascript">
    $( document ).ready(function() {
        $('#display_ques').hide();
        $('#MCQ_ques').click(function(e) {
            $('#display_ques').toggle();
            $('html, body').animate({
                scrollTop: $("#display_ques").offset().top
            }, 500);
            return false;
        });

        $('#upl_btn').hide();
        $('#bulk_upl').click(function(e) {
            $('#upl_btn').toggle();
            $('html, body').animate({
                scrollTop: $("#upl_btn").offset().top
            }, 500);
            return false;
        });
    });
   
        document.getElementById('formula').addEventListener('input',(ev) => {
            // `ev.target` is an instance of `MathfieldElement`
        console.log(ev.target.value);
        });
    
    
</script>

<script type="module">
      import {
        Uppy,Dashboard,Webcam,Compressor,XHRUpload,ImageEditor,        
      } from "https://releases.transloadit.com/uppy/v3.8.0/uppy.min.mjs";

        const uppy_jus = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, minNumberOfFiles: 1,allowedFileTypes: ['image/*']}, })
        .use(Dashboard, { trigger: "#uppyModalOpener_justification" })
        .use(Webcam, { target: Dashboard, facingMode:'environment'})                
        .use(Compressor)     
        .use(ImageEditor, { target: Dashboard })
        .use(XHRUpload, { endpoint: 'https://revisewellteachers.com/upload_just.php' });
        
        uppy_jus.on("success", (fileCount) => {
            console.log(`${fileCount} files uploaded`);
        });

        const uppy_optd = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, minNumberOfFiles: 1,allowedFileTypes: ['image/*']}, })
        .use(Dashboard, { trigger: "#uppyModalOpener_optd" })
        .use(Webcam, { target: Dashboard, facingMode:'environment'})                
        .use(Compressor)     
        .use(ImageEditor, { target: Dashboard })
        .use(XHRUpload, { endpoint: 'https://revisewellteachers.com/mcq_optd.php' });
        
        uppy_optd.on("success", (fileCount) => {
            console.log(`${fileCount} files uploaded`);
        });


        const uppy_optc = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, minNumberOfFiles: 1,allowedFileTypes: ['image/*']}, })
        .use(Dashboard, { trigger: "#uppyModalOpener_optc" })
        .use(Webcam, { target: Dashboard, facingMode:'environment'})                
        .use(Compressor)     
        .use(ImageEditor, { target: Dashboard })
        .use(XHRUpload, { endpoint: 'https://revisewellteachers.com/mcq_optc.php' });
        
        uppy_optc.on("success", (fileCount) => {
            console.log(`${fileCount} files uploaded`);
        });

        const uppy_optb = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, minNumberOfFiles: 1,allowedFileTypes: ['image/*']}, })
        .use(Dashboard, { trigger: "#uppyModalOpener_optb" })
        .use(Webcam, { target: Dashboard, facingMode:'environment'})                
        .use(Compressor)     
        .use(ImageEditor, { target: Dashboard })
        .use(XHRUpload, { endpoint: 'https://revisewellteachers.com/mcq_optb.php' });
        
        uppy_optb.on("success", (fileCount) => {
            console.log(`${fileCount} files uploaded`);
        });

        const uppy_opta = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, minNumberOfFiles: 1,allowedFileTypes: ['image/*']}, })
        .use(Dashboard, { trigger: "#uppyModalOpener_opta" })
        .use(Webcam, { target: Dashboard, facingMode:'environment'})                
        .use(Compressor)     
        .use(ImageEditor, { target: Dashboard })
        .use(XHRUpload, { endpoint: 'https://revisewellteachers.com/mcq_opta.php' });
        
        uppy_opta.on("success", (fileCount) => {
            console.log(`${fileCount} files uploaded`);
        });

        const uppy_ques = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, minNumberOfFiles: 1,allowedFileTypes: ['image/*']}, })
        .use(Dashboard, { trigger: "#uppyModalOpener_question" })
        .use(Webcam, { target: Dashboard, facingMode:'environment'})                
        .use(Compressor)     
        .use(ImageEditor, { target: Dashboard })
        .use(XHRUpload, { endpoint: 'https://revisewellteachers.com/mcq_ques.php' });
        
        uppy_ques.on("success", (fileCount) => {
            console.log(`${fileCount} files uploaded`);
        });

    </script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="../includes/time_picker.js"></script>