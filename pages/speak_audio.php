<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
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
    if (isset($_GET['id'])) {
    if ($_GET['id'] != "") {
    $lsrw_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    }else {
        header("Location: " . BASE_URL . 'pages/action');
    }
    }else {
        header("Location: " . BASE_URL . 'pages/action');
    }
?>

<?php 
    if (isset($_GET['uni'])) {
        if ($_GET['uni'] != "") {
            $uniq_id = htmlspecialchars($_GET['uni'], ENT_QUOTES, 'UTF-8');
        } else {
             header("Location: " . BASE_URL . 'pages/action');
        }
    } else {
             header("Location: " . BASE_URL . 'pages/action');
    }
?>

<?php
    $check_if_lsrw_belong_to = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE tree_id = '$lsrw_id' AND rev_teacher_id = '$teacher_email_id' AND rev_sts = '1'");

    if (mysqli_num_rows($check_if_lsrw_belong_to) > 0)  {
        while($roj = mysqli_fetch_assoc($check_if_lsrw_belong_to)) {
            $lsrw_name = htmlspecialchars($roj['rev_name'], ENT_QUOTES, 'UTF-8');
            $lsrw_link = htmlspecialchars($roj['rev_link'], ENT_QUOTES, 'UTF-8');
            $lsrw_start_time = htmlspecialchars($roj['rev_start_time'], ENT_QUOTES, 'UTF-8');
            $lsrw_end_time = htmlspecialchars($roj['rev_end_time'], ENT_QUOTES, 'UTF-8');
            $lsrw_date = htmlspecialchars($roj['rev_date'], ENT_QUOTES, 'UTF-8');
        }
    } else {
         header("Location: " . BASE_URL . "pages/action");
    }
?>

<?php 
    if (isset($_POST['submit'])) {
        $fetch_details_with_uniq_id = mysqli_query($connection, "SELECT * FROM rev_lsrw_mcq WHERE rev_uniq_id = '$uniq_id' AND rev_mcq_sts = '2'");

        if (mysqli_num_rows($fetch_details_with_uniq_id) > 0) {
            $update = mysqli_query($connection, "UPDATE rev_lsrw_mcq SET rev_mcq_sts = '1' WHERE rev_uniq_id = '$uniq_id'");

            if (isset($update)) {
                $error_message = "Success";
                 header("Location: " . BASE_URL . 'pages/listen');
            }
        }
    }
?>

<link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />
<script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>

<link rel="stylesheet" type="text/css" href="../includes/time_picker.css">

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<!-- =======================
Main Banner START -->
<div class="container zindex-100 desk" style="margin-top: 10px">
    <div style="float: left;">
        <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
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
        if (strlen($lsrw_link) > 20) { ?>
        <div class="audio-player bg-light p-3">
            <audio id="player" controls>
            <source src="https://d349p3fjrxa3i.cloudfront.net/<?php echo $lsrw_link; ?>" type="audio/mp3" />
            </audio>
        </div>
        <?php } else { ?>
        <div class="row">
        	<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $lsrw_link; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-2"></div>

    </div>
</div>

<div class="container">
    <div class="row mt-4 mb-4">
    <div class="col-md-6 mt-4">
        <?php 
    $fetch_submitted_list = mysqli_query($connection, "SELECT * FROM rev_student_lsrw_submitted_list WHERE rev_mcq_id = '$lsrw_id' AND mcq_student_sts = '1'");

    if (mysqli_num_rows($fetch_submitted_list) > 0) { ?>
    <div class="d-flex justify-content-center">
        <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center text-success fw-bold" role="alert" style="font-size: 16px">
        <img src="<?php echo BASE_URL; ?>assets/images/submitted.webp" width="25px" height="25px" alt="submitted">&nbsp;List of students submitted
        </div>
    </div>

    <div id="table-scroll1" class="table-scroll1">
     <div class="table-wrap">
       <table class="main-table">
         <thead>
           <tr class="table_header text-center">
             <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">#</span></th>
             <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Name</span></th>
             <th scope="col" class="border-0"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Submitted on</span></th>
           </tr>
         </thead>
         <tbody>
            
                 <?php   $i = 1;
                    while($rl = mysqli_fetch_assoc($fetch_submitted_list)) { ?>
                         <tr class="text-center" style="font-size: 15px">
                             <th class="fixed-side" style="color: #0cbc87;"><?php echo $i++; ?></th>
                             <th class="fixed-side" style="max-width: 5px;"><a href="<?php echo BASE_URL; ?>pages/check_indi_lsrw?id=<?php echo $lsrw_id; ?>&st_id=<?Php echo $rl['rev_student_id']; ?>" style="text-decoration: underline; color: #0cbc87"><?php echo htmlspecialchars(ucfirst($rl['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></a></th>
                             <td style="color: #0cbc87;">&nbsp;<?php echo htmlspecialchars(date('d-M-Y h:i a', strtotime($rl['rev_submitted_on'])), ENT_QUOTES, 'UTF-8'); ?></td>
                           </tr> 
                    <?php }
                }
            ?>                             
         </tbody>
       </table>
     </div>
    </div>
    </div>

<?php 
    $fetch_not_submitted_list = mysqli_query($connection, "SELECT * FROM rev_student_lsrw_submitted_list WHERE mcq_student_sts = '2' AND rev_mcq_id = '$lsrw_id'");

    if (mysqli_num_rows($fetch_not_submitted_list) > 0) { ?>
    <div class="col-md-6 mt-4">
    <div class="d-flex justify-content-center">
    <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center text-danger fw-bold" role="alert" style="font-size: 16px">
    <img src="<?php echo BASE_URL; ?>assets/images/not_submitted.webp" width="25px" height="25px" alt="not_submitted">&nbsp;List of students not submitted</div>
    </div>
    <div id="table-scroll2" class="table-scroll2">
     <div class="table-wrap">
       <table class="main-table">
         <thead>
           <tr class="table_header text-center">
             <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 16px; font-weight: bold">#</span></th>
             <th scope="col" class="border-0"><span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 16px; font-weight: bold">Name</span></th>
             <th scope="col" class="border-0"><span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 16px; font-weight: bold">ID</span></th>
             
           </tr>
         </thead>
         <tbody>
            
            <?php  $i = 1;
                while($jhg = mysqli_fetch_assoc($fetch_not_submitted_list)) { ?>
                        <tr class="text-center" style="font-size: 15px">
                         <th class="fixed-side" style="color: #D6293E;"><?php echo $i++; ?></th>
                         <th style="color: #D6293E;"><?php echo htmlspecialchars(ucfirst($jhg['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></th>
                         <td style="color: #D6293E;"><?php echo htmlspecialchars($jhg['rev_student_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                         
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
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



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

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>