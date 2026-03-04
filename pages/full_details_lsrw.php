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
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_teach_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $user_school = htmlspecialchars($i['rev_teach_school'], ENT_QUOTES, 'UTF-8');
            
         }  
    }
?>
<?php 
     $fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE rev_teach_email_id = '$teacher_email_id' AND rev_teach_sts = '1'");

            if (mysqli_num_rows($fetch_teacher_subject) > 0) {
                while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
                    $subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
                    $subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
                    $class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
                }
            }
?>

<?php 
     if (isset($_GET['id'])) {
      if ($_GET['id'] != "") {
            $lsrw_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
          } else {
                header("Location: " . BASE_URL . 'pages/action');
          }    
     } else {
           header("Location: " . BASE_URL . 'pages/action');
     }
?>

<?php 
     $check_if_id_belongs_to_same_teacher = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE tree_id = '$lsrw_id' AND rev_sch = '$user_school' AND rev_class = '$subject_class_yt' AND rev_sts = '1' AND rev_sec = '$class_sec'");

     if (mysqli_num_rows($check_if_id_belongs_to_same_teacher) > 0) {
          while($k = mysqli_fetch_assoc($check_if_id_belongs_to_same_teacher)) {
               $lsrw_name = htmlspecialchars($k['rev_name'], ENT_QUOTES, 'UTF-8');
               $lsrw_date = htmlspecialchars($k['rev_date'], ENT_QUOTES, 'UTF-8');
               $lsrw_start = htmlspecialchars($k['rev_start_time'], ENT_QUOTES, 'UTF-8');
               $lsrw_end = htmlspecialchars($k['rev_end_time'], ENT_QUOTES, 'UTF-8');
               $lsrw_category = htmlspecialchars($k['rev_category'], ENT_QUOTES, 'UTF-8');
               $lsrw_question_text = htmlspecialchars($k['rev_question_text'], ENT_QUOTES, 'UTF-8');
               $lsrw_uniq_link = htmlspecialchars($k['rev_uniq_link'], ENT_QUOTES, 'UTF-8');
          }    
     } else {
           header("Location: " . BASE_URL . 'pages/action');               
     }
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<!-- <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
<!-- <link rel="stylesheet" href="<?php echo BASE_URL; ?>manage-audio.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>

<style type="text/css">
    html {
  scroll-behavior: smooth;
}
.text_highlight:target {
    background-color: #ffa;
    -webkit-transition: all 1s linear;
 }
   .table-scroll th, .table-scroll td {
       border:1px solid #066AC9;
   }
   .paper-content textarea {
        color: #000;
        font-family: 'Nunito', sans-serif;
    }
</style>

<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito&display=swap');
</style>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>includes/time_picker.css">

<div class="container zindex-100 desk" style="margin-top: 10px">
    <div class="row">
        <div style="float: left;">
            <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
        </div>        
    </div>
</div>


<div class="container zindex-100 desk">
     <?php 
          if ($lsrw_category == "text_read") { ?>
               <div class="row">
                <h6 class="text-center text-purple"><img src="../assets/images/read.webp" class="rounded-3" alt="read" width="40px" height="40px">&nbsp;&nbsp;*Assigned Read Activity*</h6>
                    <div class="col-md-2"></div>
                    <div class="col-md-8" style="font-size:20px; font-weight: bold; color: #000;">
                        <div class="alert alert-primary shadow-lg btn-transition" role="alert">
                            <h5 class="alert-heading"><?php echo ucfirst($lsrw_question_text); ?></h5>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
     <?php } ?> 

     <!-- <div class="row">
        <h6 class="text-center text-purple"><img src="../assets/images/read.webp" class="rounded-3" alt="read" width="40px" height="40px">&nbsp;&nbsp;*Assigned Read Activity*</h6>
            <div class="col-md-2"></div>
            <div class="col-md-8" style="font-size:20px; font-weight: bold; color: #000;">
                <div class="alert alert-primary shadow-lg btn-transition" role="alert">
                    <h5 class="alert-heading"><?php echo ucfirst($lsrw_question_text); ?></h5>
                </div>
            </div>
            <div class="col-md-2"></div>
    </div> -->

     <?php 
          if ($lsrw_category == "text_read_image") { ?>
               <div class="row d-flex justify-content-center">
                <h6 class="text-center text-purple"><img src="../assets/images/read.webp" class="rounded-3" alt="read" width="40px" height="40px">&nbsp;&nbsp;*Assigned Read Activity*</h6>
                    <?php 
                         $fetch_img = mysqli_query($connection, "SELECT * FROM rev_base64 WHERE rev_uniq_session = '$lsrw_uniq_link'");

                         if (mysqli_num_rows($fetch_img) > 0) {
                              while($jh = mysqli_fetch_assoc($fetch_img)) { ?>
                                   <div class="col-md-4"><img src="https://d349p3fjrxa3i.cloudfront.net/<?Php echo htmlspecialchars($jh['uniq_url'], ENT_QUOTES, 'UTF-8'); ?>" width="100%" style="border-radius: 10px;"></div>
                              <?php }
                         }
                    ?>
               </div>
     <?php } ?> 

     <?php 
          if ($lsrw_category == "text_read_pdf") { ?>
               <div class="row">
                    <div id="adobe-dc-view" style="width: 100%; height:550px"></div>
                         <script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
                         <script type="text/javascript">
                              document.addEventListener("adobe_dc_view_sdk.ready", function(){ 
                                   var adobeDCView = new AdobeDC.View({clientId: "dce2b5631d0744c29dbf2d1d78d686dd", divId: "adobe-dc-view"});
                                   adobeDCView.previewFile({
                                        content:{location: {url: "<?php echo $lsrw_uniq_link; ?>"}},
                                        metaData:{fileName: "<?php echo $lsrw_name; ?>"}
                                   }, {embedMode: "SIZED_CONTAINER"});
                              });
                         </script>
               </div>
     <?php } ?> 
</div>

<div class="container">
    <div class="row mt-4 mb-4">
    <div class="col-md-6 mt-4">
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
             <th scope="col" class="border-0"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">User ID</span></th>
             <th scope="col" class="border-0"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Submitted on</span></th>
           </tr>
         </thead>
         <tbody>
            <?php 
                    $fetch_submitted_list = mysqli_query($connection, "SELECT * FROM rev_student_lsrw_submitted_list WHERE rev_mcq_id = '$lsrw_id' AND mcq_student_sts = '1'");
                    if (mysqli_num_rows($fetch_submitted_list) > 0) {
                         $i = 1;
                         while($jhg = mysqli_fetch_assoc($fetch_submitted_list)) { ?>
                              <tr class="text-center" style="font-size: 15px">
                         <th class="fixed-side" style="color: #0cbc87;"><?php echo $i++; ?></th>
               
                         <th class="fixed-side text-center" style="text-align: left; max-width: 5px;">
                              <a href="<?php echo BASE_URL; ?>pages/read_lsrw_indi?st_id=<?php echo $jhg['rev_student_id']; ?>&id=<?php echo $lsrw_id; ?>" style="text-decoration: underline; color: #0cbc87"><?php echo htmlspecialchars(ucfirst($jhg['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></a>                                        
                         </th>
                         <td style="color: #0cbc87;"><?php echo htmlspecialchars($jhg['rev_student_id'], ENT_QUOTES, 'UTF-8'); ?> </td>
                         <td style="color: #0cbc87;"><?php echo htmlspecialchars(date('d-M-Y h:i a', strtotime($jhg['rev_submitted_on'])), ENT_QUOTES, 'UTF-8'); ?></td>                           
                       </tr>
                         <?php }
                    }
               ?>                             
         </tbody>
       </table>
     </div>
    </div>
    </div>

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
            <?php 
              $fetch_submitted_list = mysqli_query($connection, "SELECT * FROM rev_student_lsrw_submitted_list WHERE rev_mcq_id = '$lsrw_id' AND mcq_student_sts = '2'");
              if (mysqli_num_rows($fetch_submitted_list) > 0) {
                   $i = 1;
                   while($jhg = mysqli_fetch_assoc($fetch_submitted_list)) { ?>
                        <tr class="text-center" style="font-size: 15px">
                   <th class="fixed-side" style="color: #D6293E;"><?php echo $i++; ?></th>
         
                   <th class="fixed-side text-center" style="text-align: left; color: #D6293E;">
                        <?php echo htmlspecialchars(ucfirst($jhg['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?>                                        
                   </th>
                   <td style="color: #D6293E;"><?php echo htmlspecialchars($jhg['rev_student_id'], ENT_QUOTES, 'UTF-8'); ?> </td>                                   
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
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>

