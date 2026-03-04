<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php $today_date = date('Y-m-d'); ?>
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
            $school_id = htmlspecialchars($i['rev_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }

    $date_of_uplading = date('Y-m-d H:i:s a');
    $uniq_url_of_uploading = $date_of_uplading . '_' . $teacher_email_id;
    $uniq_identifier = md5($uniq_url_of_uploading);

    if (isset($_GET['param'])) {
        if ($_GET['param'] != "") {
            $_SESSION['class_id'] = $class_id = htmlspecialchars($_GET['param'], ENT_QUOTES, 'UTF-8');
            $fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE tree_id = '$class_id' AND rev_teach_sts = '1'");

            if (mysqli_num_rows($fetch_teacher_subject) > 0) {
                while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
                    $_SESSION['subject_name'] = $subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
                    $_SESSION['subject_class'] = $subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
                    $_SESSION['class_sec'] = $class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
                }
            }
        }
    } else {
        $fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE  rev_teach_sts = '1' ORDER BY tree_id DESC");
        if (mysqli_num_rows($fetch_teacher_subject) > 0) {
            while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
                $_SESSION['subject_name'] = $subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
                $_SESSION['subject_class'] = $subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
                $_SESSION['class_id'] = $class_id = htmlspecialchars($l['tree_id'], ENT_QUOTES, 'UTF-8');  
                $_SESSION['class_sec'] = $class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');      
        }
        }
    }      
?>

<?php 
    if (isset($_GET['uni'])) {
        if ($_GET['uni'] != "") {
            $uniq_data = htmlspecialchars($_GET['uni'], ENT_QUOTES, 'UTF-8');
        } else {
            header("Location: " . BASE_URL . 'pages/action');
        }
    } else {
        header("Location: " . BASE_URL . 'pages/action');
    }

?>
<?php
    if (isset($_GET['id'])) {
    if ($_GET['id'] != "") {
    $_SESSION['lsrw_id'] = $lsrw_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    } else {
        $fecth_uniq_id = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE rev_uniq_link = '$uniq_data' AND rev_sts = '1' AND rev_school_id = '$school_id' AND rev_teacher_id = '$teacher_email_id'");

        if (mysqli_num_rows($fecth_uniq_id) > 0) {
            while ($fd = mysqli_fetch_assoc($fecth_uniq_id)) {
                $_SESSION['lsrw_id'] = $lsrw_id = htmlspecialchars($fd['tree_id'], ENT_QUOTES, 'UTF-8');
            }
        }
    }
    }else {
        $fecth_uniq_id = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE rev_uniq_link = '$uniq_data' AND rev_sts = '1' AND rev_school_id = '$school_id' AND rev_teacher_id = '$teacher_email_id'");

        if (mysqli_num_rows($fecth_uniq_id) > 0) {
            while ($fd = mysqli_fetch_assoc($fecth_uniq_id)) {
                $_SESSION['lsrw_id'] = $lsrw_id = htmlspecialchars($fd['tree_id'], ENT_QUOTES, 'UTF-8');
            }
        }
    }
?>



<?php
    $check_if_lsrw_belong_to = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE tree_id = '$lsrw_id' AND rev_teacher_id = '$teacher_email_id' AND rev_sts = '1'");

    if (mysqli_num_rows($check_if_lsrw_belong_to) > 0)  {
        while($roj = mysqli_fetch_assoc($check_if_lsrw_belong_to)) {
            $lsrw_name = htmlspecialchars($roj['rev_name'], ENT_QUOTES, 'UTF-8');
            $lsrw_link = htmlspecialchars($roj['rev_audio_video_link'], ENT_QUOTES, 'UTF-8');
            $lsrw_start_time = htmlspecialchars($roj['rev_start_time'], ENT_QUOTES, 'UTF-8');
            $lsrw_end_time = htmlspecialchars($roj['rev_end_time'], ENT_QUOTES, 'UTF-8');
            $lsrw_date = htmlspecialchars($roj['rev_date'], ENT_QUOTES, 'UTF-8');
            $lsrw_mode = htmlspecialchars($roj['rev_question_text'], ENT_QUOTES, 'UTF-8');
        }
    } else {
        header("Location: " . BASE_URL . "pages/action");
    }
?>

<?php 
    // $lsrw_link = 'https://youtu.be/RA_dNLtE6ZQ?si=hte8PwEMMvrTbH5R';
     $host = (parse_url($lsrw_link, PHP_URL_HOST));
    // echo $youtube_id = (parse_url($lsrw_link, PHP_URL_QUERY));
    
?>

<?php 
    if (isset($_POST['submit'])) {
        $fetch_details_with_uniq_id =  mysqli_query($connection,"SELECT * FROM rev_lsrw_mcq WHERE rev_uniq_id = '$lsrw_id' AND rev_mcq_sts = '2'");

        if (mysqli_num_rows($fetch_details_with_uniq_id) > 0) {
            $update = mysqli_query($connection, "UPDATE rev_lsrw_mcq SET rev_mcq_sts = '1' WHERE rev_uniq_id = '$lsrw_id'");

            if (isset($update)) {
                $error_message = "Success";
                // header("Location: " . BASE_URL . 'pages/listen');
            }
        }
    }
?>

<?php 
    if (isset($_POST['delete'])) {
        $delete_id = mysqli_escape_string($connection, trim($_POST['del_id']));

        if ($delete_id == "") {
            $error_message = "Something went wrong, please try again";
        }

        if (!isset($error_message)) {
            $check_ownership = mysqli_query($connection, "SELECT * FROM rev_lsrw_mcq WHERE tree_id = '$delete_id' AND rev_mcq_sts != '0'");

            if (mysqli_num_rows($check_ownership) > 0) {
                $delete_id = mysqli_query($connection, "UPDATE rev_lsrw_mcq SET rev_mcq_sts = '0' WHERE tree_id = '$delete_id'");           
            }       
        }
    }
?>
<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />
<script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/time_picker.css">
<link href="https://releases.transloadit.com/uppy/v3.23.0/uppy.min.css" rel="stylesheet">

<script src="html2pdf.bundle.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
      cache: false
    });
</script>
<!-- =======================
Main Banner START -->
<div class="container zindex-100 desk" style="margin-top: 10px">
    <div style="float: left;">
        <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
    </div>

    <div style="float: right;">
        <!-- <a href="#scroll_up">
            <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center text-info fw-bold btn-transition" role="alert" style="font-size: 16px">
            📝&nbsp;Create MCQs for this activity
            </div>
        </a> -->
    </div>
</div>

<div class="container">
    <div class="w-100 mt-auto d-inline-flex justify-content-center">
        <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
            <div class="avatar avatar-sm me-2 rounded-4">
                <img class="avatar-img rounded-1" src="../assets/images/listen.webp" alt="avatar">
            </div>
            <div>
            <p class="mb-0 text-dark fw-bold">LSRW Name -
            <span class="text-primary"><?php echo ucfirst($lsrw_name); ?></span><br>
            <span class="text-primary"><img src="<?php echo BASE_URL; ?>assets/images/calendar.webp" width="20px" height="20px" alt="Calendar">&nbsp;<?php echo date('d-M-Y', strtotime($lsrw_date)); ?></span><br>
            <img src="<?php echo BASE_URL; ?>assets/images/clock.webp" width="20px" height="20px" alt="clock"><span class="text-primary">&nbsp;<?php echo date('h:i a', strtotime($lsrw_start_time)); ?> - <?php echo date('h:i a', strtotime($lsrw_end_time)); ?> </span>
            </p>
            </div>
        </div>
      </div>
</div>

<div class="container">
    <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        
            <?php
                function extractYouTubeVideoId($url) {
                    $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

                    preg_match($pattern, $url, $matches);

                    // Check if a match is found
                    if (isset($matches[1])) {
                        return $matches[1];
                    }

                    // If no match is found, return false or handle accordingly
                    return false;
                }

                // Example usage
                $youtubeUrl = $lsrw_link;
                $videoId = extractYouTubeVideoId($youtubeUrl);

            ?>


    <?php 
            if ($host == "rev-users.s3.ap-south-1.amazonaws.com") { ?>
                <audio id="player" controls>
                  <source src="<?php echo $lsrw_link; ?>" type="audio/mp3" />
                  <!-- <source src="/path/to/audio.ogg" type="audio/ogg" /> -->
                </audio>
            <?php } else { ?>
                <iframe width="100%" height="350px" src="https://www.youtube.com/embed/<?php echo $videoId; ?>?si=FLV6YElRFB7htaEN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            <?php }  ?>
    </div>
    <div class="col-md-2"></div>
    </div>
</div>

<?php 
    if ($lsrw_date > $today_date) { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div style="text-align:center; margin-top:10px;">
                        <!-- <button class="btn btn-primary data">Students Data</button> -->
                        <button class="btn btn-warning mcq upp">Create MCQs for this activity</button>
                    </div>
                </div>
            </div>
        </div>
<?php } else { ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary data">View all MCQ's</button>
                <!-- <button class="btn btn-primary data float-end">Download Report</button> -->
                <div class="d-flex justify-content-around" style="margin-top:10px;">

                    <button class="btn btn-outline-success student_submitted_data_box_button">Submitted List</button>
                    <button class="btn btn-outline-danger student_non_submitted_data_box_button">Non Submitted List</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container student_submitted_data_box">
    <div class="row mt-4 mb-4 ">        
    <div class="col-md-12 mt-4">        
    <div class="d-flex justify-content-center">
        <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center text-success fw-bold" role="alert" style="font-size: 16px">
            <img src="<?php echo BASE_URL; ?>assets/images/submitted.webp" width="25px" height="25px" alt="submitted">&nbsp;List of students submitted
        </div>
    </div>
    <div id="table-scroll1" class="table-scroll1">
     <div class="table-wrap">
      <div class="table-responsive" style="height: 400px">
       <table class="main-table">
         <thead>
           <tr class="table_header text-center">
             <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">#</span></th>
             <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Name</span></th>
             <th scope="col" class="border-0"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Submitted on</span></th>
           </tr>
         </thead>
         <tbody>
            <?php 
                $fetch_submitted_list = mysqli_query($connection, "SELECT * FROM rev_student_lsrw_submitted_list WHERE rev_mcq_id = '$lsrw_id' AND mcq_student_sts = '1'");

                if (mysqli_num_rows($fetch_submitted_list) > 0) {
                    $i = 1;
                    while($rl = mysqli_fetch_assoc($fetch_submitted_list)) { ?>
                         <tr class="text-center" style="font-size: 15px">
                             <th class="fixed-side" style="color: #0cbc87;"><?php echo $i++; ?></th>
                             <th class="fixed-side" style="max-width: 5px;"><a href="<?php echo BASE_URL; ?>pages/check_indi_lsrw_listen?id=<?Php echo $lsrw_id; ?>&st_id=<?Php echo $rl['rev_student_id']; ?>" style="text-decoration: underline; color: #0cbc87"><?Php echo htmlspecialchars($rl['rev_student_name'], ENT_QUOTES, 'UTF-8'); ?></a></th>
                             <td style="color: #0cbc87;">&nbsp;<?Php echo htmlspecialchars(date('d-M-Y h:i a', strtotime($rl['rev_submitted_on'])), ENT_QUOTES, 'UTF-8'); ?></td>
                           </tr> 
                    <?php }
                }
            ?>            
         </tbody>
       </table>
        </div>
     </div>
    </div>
    </div>    
    </div>
</div>

<div class="container student_non_submitted_data_box">
    <div class="row">
        <div class="col-md-12 mt-4">
    <div class="d-flex justify-content-center">
    <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center text-danger fw-bold" role="alert" style="font-size: 16px">
     <img src="<?php echo BASE_URL; ?>assets/images/not_submitted.webp" width="25px" height="25px" alt="not_submitted">&nbsp;List of students not submitted
    </div>
    </div>
    <div id="table-scroll2" class="table-scroll2">
     <div class="table-wrap">
      <div class="table-responsive" style="height: 400px">
       <table class="main-table">
         <thead>
           <tr class="table_header text-center">
             <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 16px; font-weight: bold">#</span></th>
             <th scope="col" class="border-0"><span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 16px; font-weight: bold">Name</span></th>
             <th scope="col" class="border-0"><span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 16px; font-weight: bold">ID</span></th>             
           </tr>
         </thead>
         <tbody>
            <?php 
                $fetch_not_subitted = mysqli_query($connection, "SELECT * FROM rev_student_lsrw_submitted_list WHERE rev_mcq_id = '$lsrw_id' AND mcq_student_sts = '2'");

                if (mysqli_num_rows($fetch_not_subitted) > 0) {
                    $i = 1;
                    while($jh = mysqli_fetch_assoc($fetch_not_subitted)) { ?>
                        <tr class="text-center" style="font-size: 15px">
                         <th class="fixed-side" style="color: #D6293E;"><?php echo $i++; ?></th>
                         <th style="color: #D6293E;"><?php echo htmlspecialchars($jh['rev_student_name'], ENT_QUOTES, 'UTF-8'); ?></th>
                         <td style="color: #D6293E;"><?php echo htmlspecialchars($jh['rev_student_id'], ENT_QUOTES, 'UTF-8'); ?></td>                         
                       </tr> 
                    <?php }
                }
            ?>                     
         </tbody>
       </table>
        </div>
     </div>
    </div>
    </div>
    </div>
</div>

<?php 
    $block_once_start_time_is_cross = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE tree_id = '$lsrw_id' AND rev_sts = '1'");

    if (mysqli_num_rows($block_once_start_time_is_cross) > 0) {
        while($hytk = mysqli_fetch_assoc($block_once_start_time_is_cross)) {
            $start_date_of_lsrw = $hytk['rev_date'];
            $start_time_of_lsrw = $hytk['rev_start_time'];
        }
    }
    $total_lsrw_time = $start_date_of_lsrw . $start_time_of_lsrw; 
?>

<section class="mcq_box">
    <!-- Content START -->
    <div class="container zindex-100 desk" id="scroll_up">
        <div class="row d-lg-flex justify-content-md-center g-md-5">
            <!-- Left content START -->
                <h4 class="fs-1 fw-bold d-flex justify-content-center">
                    <span class="position-relative z-index-9 text-center" style="font-size: 33px;">&nbsp;Create MCQs for Listen activity&nbsp;</span>
                </h4>           
        </div> 
    </div>  
</section>



<section style="background: #F5F7F9" class="mcq_box">
    <div id="uppyModalOpener_question"></div>
    <script type="text/javascript">
        function generateUniqueId() {
            // Get the current timestamp
            var timestamp = new Date().getTime();

            // Generate a random number
            var randomNum = Math.floor(Math.random() * 1000000);

            // Combine timestamp and random number to create a unique ID
            var uniqueId = 'id_' + timestamp + '_' + randomNum;

            return uniqueId;
          }
          // Example of generating a unique ID
          var myUniqueId = generateUniqueId();
          

    </script>
    <script type="module">
      import {
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_question'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://teacher.revisewell.com/pages/lsrw_mcq_question.php?u_id=' + myUniqueId, })
        .use(Compressor);     
       uppy.on('upload-success', (file) => {
         var opt4_img = file.name;
            if (opt4_img.length > 5) {
                $.post( "fetch_uploaded_image.php", { uniq_question_id: myUniqueId, opt: "0" }).done(function( text ) {
                     $('.question_img_preview').html('<div class="card" style="height:55px; margin-top:10px; background-color:#F0ECF9;"><div class="card-body"><img id="theImg" src="https://rev-users.s3.ap-south-1.amazonaws.com/'+text+'" width="25px" height="25px" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-image="'+text+'"/><i class="bi bi-trash del float-end" id="question" style="color:red; font-size:24px;"></i></div></div>'); 
                     $('.uppyModalOpener_question').hide();  
                    // console.log(data);   
                });
                
            }
        });
       $('.container').on('click', 'i.del', function() {
          var clickedIconId = $(this).attr('id');
          if (clickedIconId == "question") {
            $.post( "remove_lsrw_mcq_image.php", { name: clickedIconId, time:  myUniqueId})
              .done(function( data ) {
                var out = data.trim();
                if (out === 'ok') {
                    $('.question_img_preview').html("");
                    $('.uppyModalOpener_question').show();  
                }
              })
          }
        });
    </script>
<!-- Option 1 Uppy -->
    <div id="uppyopt1"></div>
    <script type="module">
      import {
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyopt1'})
        .use(Webcam, { target: Dashboard, modes:['picture'] })   
        .use(XHRUpload, { endpoint: 'https://teacher.revisewell.com/pages/lsrw_mcq_opt1.php?u_id=' + myUniqueId, })
        .use(Compressor);    
       uppy.on('upload-success', (file) => {
         var opt4_img = file.name;
            if (opt4_img.length > 5) {
                $.post( "fetch_uploaded_image.php", { uniq_question_id: myUniqueId, opt: "1" }).done(function( text ) {
                     $('.opt1_img_preview').html('<div class="card" style="height:55px; margin-top:10px; background-color:#F0ECF9;"><div class="card-body"><img id="theImg" src="https://rev-users.s3.ap-south-1.amazonaws.com/'+text+'" width="25px" height="25px" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-image="'+text+'"/><i class="bi bi-trash del float-end" id="1" style="color:red; font-size:24px;"></i></div></div>'); 
                     $('.uppyopt1').hide(); 
                    // console.log(data);   
                });
                
            }
        });
       $('.container').on('click', 'i.del', function() {
          var clickedIconId = $(this).attr('id');
          if (clickedIconId == "1") {
            $.post( "remove_lsrw_mcq_image.php", { name: clickedIconId, time:  myUniqueId})
              .done(function( data ) {
                var out = data.trim();
                if (out === 'ok') {
                    $('.opt1_img_preview').html("");
                     $('.uppyopt1').show(); 
                }
              })            
          }
        });
    </script>

<!-- Option 2 Uppy -->
    <div id="uppyopt2"></div>
    <script type="module">
      import {
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyopt2'})
        .use(Webcam, { target: Dashboard, modes:['picture'] })  
        .use(XHRUpload, { endpoint: 'https://teacher.revisewell.com/pages/lsrw_mcq_opt2.php?u_id=' + myUniqueId, })
        .use(Compressor);      
       uppy.on('upload-success', (file) => {
         var opt4_img = file.name;
            if (opt4_img.length > 5) {
                $.post( "fetch_uploaded_image.php", { uniq_question_id: myUniqueId, opt: "2" }).done(function( text ) {
                    $('.opt2_img_preview').html('<div class="card" style="height:55px; margin-top:10px; background-color:#F0ECF9;"><div class="card-body"><img id="theImg" src="https://rev-users.s3.ap-south-1.amazonaws.com/'+text+'" width="25px" height="25px" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-image="'+text+'"/><i class="bi bi-trash del float-end" id="2" style="color:red; font-size:24px;"></i></div></div>');
                    $('.uppyopt2').hide();   
                    // console.log(data);   
                });
                
            }
        });
       $('.container').on('click', 'i.del', function() {
          var clickedIconId = $(this).attr('id');
          if (clickedIconId == "2") {
           $.post( "remove_lsrw_mcq_image.php", { name: clickedIconId, time:  myUniqueId})
              .done(function( data ) {
                var out = data.trim();
                if (out === 'ok') {
                    $('.opt2_img_preview').html("");
                    $('.uppyopt2').show(); 
                }
              })
          }
        });
    </script>

   

    <!-- Option 3 Uppy -->
    <div id="uppyopt3"></div>
    <script type="module">
      import {
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyopt3'})
        .use(Webcam, { target: Dashboard, modes:['picture'] })  
        .use(XHRUpload, { endpoint: 'https://teacher.revisewell.com/pages/lsrw_mcq_opt3.php?u_id=' + myUniqueId, })
        .use(Compressor);       
       uppy.on('upload-success', (file) => {
         var opt4_img = file.name;
            if (opt4_img.length > 5) {
                $.post( "fetch_uploaded_image.php", { uniq_question_id: myUniqueId, opt: "3" }).done(function( text ) {
                     $('.opt3_img_preview').html('<div class="card" style="height:55px; margin-top:10px; background-color:#F0ECF9;"><div class="card-body"><img id="theImg" src="https://rev-users.s3.ap-south-1.amazonaws.com/'+text+'" width="25px" height="25px" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-image="'+text+'"/><i class="bi bi-trash del float-end" id="3" style="color:red; font-size:24px;"></i></div></div>');  
                     $('.uppyopt3').hide(); 
                    // console.log(data);   
                });
                
            }
        });
      $('.container').on('click', 'i.del', function() {
          var clickedIconId = $(this).attr('id');
          if (clickedIconId == "3") {
            $.post( "remove_lsrw_mcq_image.php", { name: clickedIconId, time:  myUniqueId})
              .done(function( data ) {
                var out = data.trim();
                if (out === 'ok') {
                    $('.opt3_img_preview').html("");
                    $('.uppyopt3').show(); 
                }
              })
          }
        });
    </script>  

    <!-- Option 4 Uppy -->
    <div id="uppyopt4"></div>
    <script type="module">
      import {
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Core,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyopt4'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://teacher.revisewell.com/pages/lsrw_mcq_opt4.php?u_id=' + myUniqueId},)
        .use(Compressor);                
        uppy.on('upload-success', (file) => {
         var opt4_img = file.name;
            if (opt4_img.length > 5) {
                $.post( "fetch_uploaded_image.php", { uniq_question_id: myUniqueId, opt: "4" }).done(function(text) {
                     $('.opt4_img_preview').html('<div class="card" style="height:55px; margin-top:10px; background-color:#F0ECF9;"><div class="card-body"><img id="theImg" src="https://rev-users.s3.ap-south-1.amazonaws.com/'+text+'" width="25px" height="25px" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-image="'+text+'"/><i class="bi bi-trash del float-end" id="4" style="color:red; font-size:24px;"></i></div></div>');
                     $('.uppyopt4').hide();                         
                });                
            }
        });

        $('.container').on('click', 'i.del', function() {
          var clickedIconId = $(this).attr('id');
          if (clickedIconId == "4") {
            $.post( "remove_lsrw_mcq_image.php", { name: clickedIconId, time:  myUniqueId})
              .done(function( data ) {
                var out = data.trim();
                if (out === 'ok') {
                    $('.opt4_img_preview').html("");
                    $('.uppyopt4').hide(); 
                }
              })
          }
    });
    </script>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <img id="modalImage" class="img-fluid" alt="Image">
       <input type="text" name="" class="uniq_id_to_remove">
       <!-- <input type="text" name="" class="uniq_id_temp"> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary remove_image">Remove Image</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
   var modal = document.getElementById('exampleModal');
   var imageElement = document.getElementById('modalImage');

  // Attach event listener when the modal is shown
  modal.addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    var button = event.relatedTarget;

    // Get the image path from the data-bs-image attribute
    var imagePath = button.getAttribute('data-bs-image');
    //var class_img = 'opt1_img_preview';

    // Set the image source dynamically
    imageElement.src = 'https://rev-users.s3.ap-south-1.amazonaws.com/'+imagePath;

    $('.uniq_id_to_remove').val(imagePath);
    $('.uniq_id_temp').val(imagePath);   
  });
</script>
    <div class="container position-relative" style="margin-top: -100px">
        <div class="row justify-content-between align-items-center my-5">
            <div class="col-md-12 position-relative">                
                <?php $now_date_time = date('Y-m-d H:i'); ?>
                            <!-- Form START -->
                    <div class="row g-3 position-relative myform">
                        <!-- Name -->
                        <div class="col-12">
                            <div class="bg-body shadow p-4" style="border-radius: 20px;">
                                <textarea class="form-control border-0 question" rows="4" placeholder="Question*" name="Name" id="Name" required autocomplete="off"></textarea>
                                <div style="display:inline-flex; margin-top: 10px;">
                                    <small id="uppyModalOpener_question" class="uppyModalOpener_question" style="color:blue; text-align: right;">Add image to question</small>
                                    <div class="question_img_preview" id="question"></div>
                                </div>
                            </div>
                        </div>
                        

                        <!-- Option 1 -->
                        <div class="col-md-6 col-lg-12 col-xl-6 col-sm-1">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 opt1" type="text" placeholder="Option 1*" name="opt1" id="opt1" required autocomplete="off"><img src="/assets/images/letter-a.webp" alt="A" width="35px">

                                </div>                                
                            </div>
                            <div class="opt1_img_preview" id="1"></div>
                            <small class="float-end uppyopt1" id="uppyopt1" style="color:blue;">Add image to option 1</small>
                        </div>

                        <!-- <input type="text" name="" class="uni_id" value="<?php //echo md5(date('YmdHisa')); ?>"> -->

                        <!-- Option 2 -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 opt2" type="text" placeholder="Option 2*" name="opt2" id="opt2"  required autocomplete="off"><img src="/assets/images/letter-b.webp" alt="B" width="35px">
                                </div>
                            </div>
                            <div class="opt2_img_preview" id="2"></div>
                            <small class="float-end uppyopt2" id="uppyopt2" style="color:blue;">Add image to option 2</small>
                        </div>

                        <!-- Option 3 -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 opt3" type="text" placeholder="Option 3*" name="opt3" id="opt3" required autocomplete="off"><img src="/assets/images/letter-c.webp" alt="C" width="35px">
                                </div>
                            </div>
                            <div class="opt3_img_preview" id="3"></div>
                            <small class="float-end uppyopt3" id="uppyopt3" style="color:blue;">Add image to option 3</small>
                        </div>

                        <!-- Option 4 -->
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 opt4" type="text" placeholder="Option 4*" name="opt4" id="opt4" required autocomplete="off"><img src="/assets/images/letter-d.webp" alt="D" width="35px">
                                </div>
                            </div>
                            <div class="opt4_img_preview" id="4"></div>
                            <small class="float-end uppyopt4" id="uppyopt4" style="color:blue;">Add image to option 4</small>
                        </div>                        

                        <div class="d-flex justify-content-center mt-4">
                            <label class="control-label" for="textinput">
                            <h5 class="text-primary fw-bold me-3">Key:</h5></label>
                            <div class="radio-group">
                                <!-- <span style="border:1px solid grey; padding: 10px;" class="rad"> -->
                                    <input type="radio" id="radio1" name="options" class="custom-radio" value="1">
                                    <label for="radio1" class="radio-label" style="font-size:20px; color: #000;">Option 1</label>
                                <!-- </span> -->

                                <!-- <span style="border:1px solid grey; padding: 10px;" class="rad"> -->
                                    <input type="radio" id="radio2" name="options" class="custom-radio" value="2">
                                    <label for="radio2" class="radio-label" style="font-size:20px; color: #000;">Option 2</label>
                                <!-- </span> -->

                                <!-- <span style="border:1px solid grey; padding: 10px;" class="rad"> -->
                                    <input type="radio" id="radio3" name="options" class="custom-radio" value="3">
                                    <label for="radio3" class="radio-label" style="font-size:20px; color: #000;">Option 3</label>
                                <!-- </span> -->

                                <!-- <span style="border:1px solid grey; padding: 10px;" class="rad"> -->
                                    <input type="radio" id="radio4" name="options" class="custom-radio" value="4">
                                    <label for="radio4" class="radio-label" style="font-size:20px; color: #000;">Option 4</label>  
                                <!-- </span>                               -->
                            </div>
                        </div>
                        
                        <!-- Button -->
                        <div class="form-group d-flex justify-content-center mb-4">
                            <label class="col-md-4 control-label" for="button1id"></label>
                            <div class="col-md-8">
                                 <button class="btn btn-primary-soft add_question" id="liveToastBtn" type="button" name="btnSubmit"><i class="bi bi-plus-circle-dotted"></i> Add Question</button>

                                 <!-- <button class="btn btn-danger-soft" id="btnReset" type="reset" name="btnReset" value="Reset">Reset</button> -->

                                                  
                            </div>
                        </div>
                        <!-- <div class="col-md-12 d-flex justify-content-center">
                            <a href="#scroll_up"><button type="button" class="btn btn-primary mb-0 submit" name="submit">Submit</button></a>
                        </div> -->
                       </div>
                        <!-- Form END -->
        
            </div>

            <div class="result">
                
            </div>

            <div class="container">
                <div class="row">        
                    <div class="col-md-12 d-flex justify-content-center mcq_latest_data"></div>        
                </div>
            </div>
        </div>

        <!-- <button type="button" class="btn btn-primary" >Show live toast</button> -->

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
          <div id="liveToast" class="toast text-bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" class="rounded me-2" alt="..." width="45px" height="45px">
              <strong class="me-auto">Revisewell Alert</strong>
              <!-- <small>11 mins ago</small> -->
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body t_body">
              <!-- Hello, world! This is a toast message. -->
            </div>
          </div>
        </div>



    </div>
</section>

<section>
    <div class="container">
        <div class="row">
        <?php 
    $fetch_question_data = mysqli_query($connection, "SELECT * FROM rev_lsrw_mcq WHERE rev_uniq_id = '$lsrw_id' AND rev_mcq_sts = '1'");

    if (mysqli_num_rows($fetch_question_data) > 0) {
        while($r = mysqli_fetch_assoc($fetch_question_data)) { ?>                   
            <div class="bg-purple bg-opacity-10 shadow rounded-3 p-4 position-relative btn-transition" style="height: 100%; text-align: justify">
                <span class="badge text-white bg-danger mt-2" style="font-size: 15px">Question :</span>&nbsp;&nbsp;<span class="fw-bold text-purple" style="font-size: 18px"><?php echo htmlspecialchars($r['mcq_question'], ENT_QUOTES, 'UTF-8'); ?></span><br>
                <span class="badge text-white bg-secondary mt-2" style="font-size: 15px">Option A :</span>&nbsp;&nbsp;<span class="fw-bold text-purple" style="font-size: 18px"><?php echo htmlspecialchars($r['mcq_opt1'], ENT_QUOTES, 'UTF-8'); ?></span><br>
                <span class="badge text-white bg-secondary mt-2" style="font-size: 15px">Option B :</span>&nbsp;&nbsp;<span class="fw-bold text-purple" style="font-size: 18px"><?php echo htmlspecialchars($r['mcq_opt2'], ENT_QUOTES, 'UTF-8'); ?></span><br><span class="badge text-white bg-secondary mt-2" style="font-size: 15px">Option C :</span>&nbsp;&nbsp;<span class="fw-bold text-purple" style="font-size: 18px"><?php echo htmlspecialchars($r['mcq_opt3'], ENT_QUOTES, 'UTF-8'); ?></span><br>
                <span class="badge text-white bg-secondary mt-2" style="font-size: 15px">Option D :</span>&nbsp;&nbsp;<span class="fw-bold text-purple" style="font-size: 18px"><?php echo htmlspecialchars($r['mcq_opt4'], ENT_QUOTES, 'UTF-8'); ?></span><br>
                <span class="badge text-white bg-success mt-2" style="font-size: 15px">Answer :</span>&nbsp;&nbsp;<span class="fw-bold text-purple" style="font-size: 18px"><?php echo htmlspecialchars($r['mcq_ans'], ENT_QUOTES, 'UTF-8'); ?></span><br>
            </div>
        <?php }
    }
?>
        </div>
    </div>
</section>


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
   <form class="row align-items-center justify-content-center" autocomplete="off" action="" method="post">
          <div class="w-100 mt-auto">
            <label class="control-label" for="textinput">
                <h6 class="text-primary fw-bold me-3 del_question">Question:</h6>
                <input type="hidden" role="uploadcare-uploader" data-public-key="681fb82548eb6042619b"
    data-tabs="file camera" data-effects="crop, rotate, mirror, sharp, invert, grayscale, blur, flip, enhance" name="new_img" /><span style="color:red;"></span>
            </label>
               <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">                    
                    <div class="input-group">
                         <!-- Avatar info -->
                         <textarea class="col-md-12 form-control border-0 me-1 mcq_ques text-purple fw-bold" style="text-align: justify;" rows="3" placeholder="MCQ Question" name="mcq_name"></textarea>
                    </div>
               </div>
          </div>

          <div class="col-md-6 mt-3">
            <label class="control-label" for="textinput">
                <h6 class="text-secondary fw-bold me-3">Option A:</h6>
            </label>
               <div class="bg-body shadow rounded-pill p-2">
                    <div class="input-group">
                         <input class="form-control border-0 me-1 option1 text-purple fw-bold" type="text" placeholder="Option A" name="mcq_opt_1">
                    </div>
               </div>
          </div>
          <div class="col-md-6 mt-3">
            <label class="control-label" for="textinput">
                <h6 class="text-secondary fw-bold me-3">Option B:</h6>
            </label>
               <div class="bg-body shadow rounded-pill p-2">
                    <div class="input-group">
                         <input class="form-control border-0 me-1 option2 text-purple fw-bold" type="text" placeholder="Option B" name="mcq_opt_2">
                    </div>
               </div>
          </div>
          <div class="col-md-6 mt-3">
            <label class="control-label" for="textinput">
                <h6 class="text-secondary fw-bold me-3">Option C:</h6>
            </label>
               <div class="bg-body shadow rounded-pill p-2">
                    <div class="input-group"><input class="form-control border-0 me-1 option3 text-purple fw-bold" type="text" placeholder="Option C" name="mcq_opt_3">
                    </div>
               </div>
          </div>
          <div class="col-md-6 mt-3">
            <label class="control-label" for="textinput">
                <h6 class="text-secondary fw-bold me-3">Option D:</h6>
            </label>
               <div class="bg-body shadow rounded-pill p-2">
                    <div class="input-group"><input class="form-control border-0 me-1 option4 text-purple fw-bold" type="text" placeholder="Option D" name="mcq_opt_4">
                    </div>
               </div>
          </div>

          <div class="w-100 d-inline-flex justify-content-center mt-3">
               <div class="shadow-lg p-2 mb-3 bg-body rounded">
                    <!-- Avatar -->
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
               </div>
          </div>

          <div class="col-md-12 d-flex justify-content-center mb-2 mt-2">
               <input type="hidden" class="mcq_edit_id" name="mcq_edit_id">
               <button class="btn btn-primary-soft mb-0 submit_field" name="edit_submit" type="submit">Submit</button>
          </div>
     </form>
</div>

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
                 <div class="col-md-2 col-sm-2">
                 <div class="avatar avatar-sm me-2 rounded-4">
                      <img class="avatar-img rounded-1" src="../assets/images/MCQ.webp" alt="avatar">
                 </div>
                 </div>
                <!-- Avatar info -->
                <div class="col-md-10 col-sm-10">
                    <div>
                    <h6 class="mb-0 text-dark" style="text-align: justify;">Question - <span class="text-danger mcq_ques_del"></span></h6>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
          <form action="" method="post">
          <input type="hidden" name="del_id" class="mcq_del_id" value="">
          <button type="submit" class="btn btn-danger-soft" name="delete">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    

     $('.add_question').click(function() {

    // Display the random value
    // console.log("Random Value: " + randomValue);
               const FName = document.getElementById("Name").value;
               const copt1 = document.getElementById("opt1").value;
               const copt2 = document.getElementById("opt2").value;
               const copt3 = document.getElementById("opt3").value;
               const copt4 = document.getElementById("opt4").value;

                if ($('input[name="options"]:checked').length > 0) {
        // Get the selected radio button value
        var selectedValue = $('input[name="options"]:checked').val();
        
        // Do something with the selected value (e.g., send it to the server)
        // console.log("Selected Value: " + selectedValue);
      } else {
        // Display an error message or take appropriate action
        $('.t_body').html("Please select an option");
      }

                $.post( "listen_mcq_data.php" ,{ name: FName, option1: copt1, option2: copt2, option3: copt3, option4: copt4, radio: selectedValue, teacher_id: "<?php echo $teacher_email_id; ?>", teacher_sec: "<?php echo $class_sec; ?>", teacher_class:"<?php echo $subject_class_yt; ?>", uniq_id: "<?php echo $lsrw_id; ?>", ref_key:myUniqueId,}).done(function( text ) {
                    var out = $.trim(text);

                    if (out == 's') {
                        $('.t_body').html('Success');

                        $.post( "fetch_temp_mcq.php", { name: "<?php echo $lsrw_id; ?>"})
                          .done(function( data ) {
                            $('.result').html(data);
                            $('.opt1').val('');
                            $('.opt2').val('');
                            $('.opt3').val('');
                            $('.opt4').val('');
                            $('.question').val('');
                            $('.custom-radio').prop('checked', false);
                            $('.opt4_img_preview').hide();
                            $('.opt3_img_preview').hide();
                            $('.opt2_img_preview').hide();
                            $('.opt1_img_preview').hide();
                            $('.question_img_preview').hide();

                            $('.uppyopt1').show();
                            $('.uppyopt2').show();
                            $('.uppyopt3').show();
                            $('.uppyopt4').show(); 
                            $('.uppyModalOpener_question').show();



                          });
                    } else {
                        $('.t_body').html('Please fill all fields');
                    }
             })
             
     }); 

     
</script>


<script type="text/javascript">
    const picker = MCDatepicker.create({
        el: '#datepickers',                    
        minDate: new Date()
    });
    // $('#timepicker').mdtimepicker(); //Initializes the time picker
</script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="../includes/time_picker.js"></script>
<script type="text/javascript">
    $('#timepicker').mdtimepicker(); //Initializes the time picker
    $('#timepicker_2').mdtimepicker(); //Initializes the time picker
    $('#timepicker3').mdtimepicker(); //Initializes the time picker
$('#timepicker4').mdtimepicker(); //Initializes the time picker
</script>

<script>
    document.querySelectorAll('.feedback li').forEach(entry => entry.addEventListener('click', e => {
    if(!entry.classList.contains('active')) {
        document.querySelector('.feedback li.active').classList.remove('active');
        entry.classList.add('active');
    }
    e.preventDefault();
    }));

    function angry() {
      document.getElementById("demo").innerHTML = "Angry";
    }

    function sad() {
      document.getElementById("demo").innerHTML = "Sad";
    }

    function ok() {
      document.getElementById("demo").innerHTML = "Ok";
    }

    function good() {
      document.getElementById("demo").innerHTML = "Good";
    }

    function happy() {
      document.getElementById("demo").innerHTML = "Happy";
    }

    const player = new Plyr('audio', {});

// Expose player so it can be used from the console
window.player = player;

$('.submitted').hide();

$(".check").click(function(){
  $('.submitted').toggle();
});
</script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $('.final_submit').hide();
        });
    </script>

    <script>
        document.getElementById('downloadButton').addEventListener('click', function () {
            var element = document.getElementById('prin');
            html2pdf(element);
        });
    </script>

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>

 <script type="text/javascript">
        const toastTrigger = document.getElementById('liveToastBtn')
        const toastLiveExample = document.getElementById('liveToast')

        if (toastTrigger) {
          const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
          toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
          })
        }
</script>

<script type="text/javascript">
     const exampleModal = document.getElementById('staticBackdrop1')
     exampleModal.addEventListener('show.bs.modal', event => {
       // Button that triggered the modal
       const button = event.relatedTarget
       // Extract info from data-bs-* attributes
       const recipient = button.getAttribute('data-bs-whatever-question')
       const mcq_ques = button.getAttribute('data-bs-whatever-question');
       const option1 = button.getAttribute('data-bs-whatever-opt1');
       const option2 = button.getAttribute('data-bs-whatever-opt2');
       const option3 = button.getAttribute('data-bs-whatever-opt3');
       const option4 = button.getAttribute('data-bs-whatever-opt4');
       const mcq_edit_id = button.getAttribute('data-bs-whatever-edit');
       // const ans = button.getAttribute('data-bs-whatever-ans');


       // If necessary, you could initiate an AJAX request here
       // and then do the updating in a callback.
       //
       // Update the modal's content.
       const modalTitle = exampleModal.querySelector('.mcq_ques')
       const modalBodyInput_ques = exampleModal.querySelector('.modal-body .mcq_ques')
       const modalBodyInput_opt1 = exampleModal.querySelector('.modal-body .option1')
       const modalBodyInput_opt2 = exampleModal.querySelector('.modal-body .option2')
       const modalBodyInput_opt3 = exampleModal.querySelector('.modal-body .option3')
       const modalBodyInput_opt4 = exampleModal.querySelector('.modal-body .option4')
       // const modalBodyInput_ans = exampleModal.querySelector('.modal-body .ans')
       const modalBodyInput_edit_id = exampleModal.querySelector('.modal-body .mcq_edit_id')

        modalTitle.textContent = `${recipient}`
        modalBodyInput_ques.value = mcq_ques
        modalBodyInput_opt1.value = option1
        modalBodyInput_opt2.value = option2
        modalBodyInput_opt3.value = option3
        modalBodyInput_opt4.value = option4
        // modalBodyInput_ans.value = ans
        modalBodyInput_edit_id.value = mcq_edit_id
     })


     const removeModal = document.getElementById('staticBackdrop2')
        if (removeModal) {
          removeModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const recipient = button.getAttribute('data-bs-whatever')
            const rec_name = button.getAttribute('data-bs-whatever_mcq_name')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = removeModal.querySelector('.mcq_del_id')
            const modalBodyInput = removeModal.querySelector('.modal-body .mcq_ques_del')

             modalTitle.value = recipient
            modalBodyInput.textContent = rec_name
          })
        }


     $( document ).ready(function() {
        $('.student_non_submitted_data_box').hide();
        $('.student_submitted_data_box').hide();
         $('.t_op').hide();
         $('.mcq_box').hide();

         $(".add_new_question").click(function(){
            $(".t_op").toggle();
          });

         $('.student_submitted_data_box_button').click(function() {
            $('.student_submitted_data_box').toggle();
            $('.student_non_submitted_data_box').hide();
            $('.mcq_box').hide();
         })

         $('.student_non_submitted_data_box_button').click(function() {
            $('.student_non_submitted_data_box').toggle();
            $('.student_submitted_data_box').hide();
            $('.mcq_box').hide();
         })

         $('.mcq').click(function() {
            $('.mcq_box').toggle();
            $('.student_data_box').hide();
            var y = $(window).scrollTop();  //your current y position on the page
            $(window).scrollTop(y+350);
         })
     });
</script>



