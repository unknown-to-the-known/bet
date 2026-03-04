<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

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

<?php $domain_name = $_SERVER['SERVER_NAME']; ?>

<?php 
    if (isset($_GET['id'])) {
        if ($_GET['id'] != "") {
            $category = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');    
        } else {
            header("Location: " . BASE_URL . 'pages/dash');
        }
    } else {
            header("Location: " . BASE_URL . 'pages/dash');
        }
?>

<?php 
    if (isset($_GET['param'])) {
        if ($_GET['param'] != "") {
            $class_id = htmlspecialchars($_GET['param'], ENT_QUOTES, 'UTF-8');
            $fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE tree_id = '$class_id' AND rev_teach_sts = '1'");
            if (mysqli_num_rows($fetch_teacher_subject) > 0) {
                while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
                    $subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
                    $subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
                    $subject_teacher_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
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
                $subject_teacher_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');        
        }
        }
    }       
?>

<!-- School Name details -->
    <?php 
        $fetch_school_details = mysqli_query($connection,"SELECT * FROM rev_school_details WHERE rev_school_name = '$user_school' AND  rev_school_sts = '1'");

        if (mysqli_num_rows($fetch_school_details) > 0) {
            while($sch_details = mysqli_fetch_assoc($fetch_school_details)) {
                $school_number = htmlspecialchars($sch_details['rev_school_number'], ENT_QUOTES, 'UTF-8');
                $school_admin = htmlspecialchars(ucfirst($sch_details['rev_school_admin_name']), ENT_QUOTES, 'UTF-8');
            }   
        }
    ?>

<!-- School Name details ended -->

<!-- For Image Code -->
<?php     
    if ($category == "image") {
        if (isset($_POST['submit'])) {
            if(!empty($_POST['student_id'])) {    
                foreach($_POST['student_id'] as $value){
                    $user_id = $value;
                    $fetch_numbers = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_id = '$user_id'");

                    if (mysqli_num_rows($fetch_numbers) > 0) {
                        while($k = mysqli_fetch_assoc($fetch_numbers)) {
                           $user_number .= "+91" . $k['rev_student_phone'] . ',';
                        }
                    }
                }
            } else {
                $error_message = "Please select students";
            }

            $caption = mysqli_escape_string($connection, trim($_POST['textarea']));
            if ($caption != "") {
                // $caption = $caption . '\n Please do not reply to this number, For any queries contact ' . $school_admin . '\n Phone Number: ' . $school_number;
            } else {
                // $caption = 'Please do not reply to this number, For any queries contact ' . $school_admin . '\n Phone Number: ' . $school_number;
            }

            if (isset($_FILES['fileToUpload'])) {
                $file = $_FILES['fileToUpload'];
                $file_name = $file['name'];
                $file_tmp = $file['tmp_name'];
                $file_size = $file['size']; 

                if ($file == "") {
                    $error_message = "Please select file";
                } 

                if (!isset($error_message)) {
                   $file_ext = explode('.', $file_name);
                    $file_ext = strtolower(end($file_ext));

                    $allowed = array('jpg', 'png', 'jpeg');

                    if ($file_size > 15000000) {
                         if (in_array($file_ext, $allowed)) {
                        $file_new_name = md5(date('Y-m-d H:i:s.u')) . '.' .  $file_ext;
                        $file_destination = '../uploads/' . $file_new_name;
                        $full_url = "https://" . $domain_name . "/uploads/" . $file_new_name;
                        if (move_uploaded_file($file_tmp, $file_destination)) { ?>
                            <script type="text/javascript">
                                var settings = {
                                      "async": true,
                                      "crossDomain": true,
                                      "url": "https://api.ultramsg.com/instance26587/messages/image",
                                      "method": "POST",
                                      "headers": {},
                                      "data": {
                                        "token": "wq6wqj6ky4or8oy7",
                                        "to": "<?php echo $user_number; ?>",
                                        "image": "<?php echo $full_url; ?>",
                                        "caption": "<?php echo $caption; ?>"
                                      }
                                    }
                                    $.ajax(settings).done(function (response) {
                                      // console.log(response);
                                    });
                            </script>
                        <?php 
                            $error_message = "Success Notification sent successfully";
                        }
                    } else {
                        $error_message = "Only JPG, PNG & JPEG format are allowed";
                    }
                    } else { 
                        if (in_array($file_ext, $allowed)) {
                        $file_new_name = md5(date('Y-m-d H:i:s.u')) . '.' .  $file_ext;
                        $file_destination = '../uploads/' . $file_new_name;
                        $full_url = "https://" . $domain_name . "/uploads/" . $file_new_name;
                        if (move_uploaded_file($file_tmp, $file_destination)) { ?>
                            <script type="text/javascript">
                                var settings = {
                                      "async": true,
                                      "crossDomain": true,
                                      "url": "https://api.ultramsg.com/instance26587/messages/image",
                                      "method": "POST",
                                      "headers": {},
                                      "data": {
                                        "token": "wq6wqj6ky4or8oy7",
                                        "to": "<?php echo $user_number; ?>",
                                        "image": "<?php echo $full_url; ?>",
                                        "caption": "<?php echo $caption; ?>"
                                      }
                                    }
                                    $.ajax(settings).done(function (response) {
                                      // console.log(response);
                                    });
                            </script>
                        <?php 
                            $error_message = "Success Notification sent successfully";
                        }
                    }

                     }

                    
                 }             
            }
        }   
    }    
?>
<!-- For Image Code ended-->

<!-- For audio Code -->
<?php     
    if ($category == "audio") {
        if (isset($_POST['audiosubmit'])) {
            if(!empty($_POST['student_id'])) {    
                foreach($_POST['student_id'] as $value){
                    $user_id = $value;
                    $fetch_numbers = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_id = '$user_id'");

                    if (mysqli_num_rows($fetch_numbers) > 0) {
                        while($k = mysqli_fetch_assoc($fetch_numbers)) {
                           $user_number .= "+91" . $k['rev_student_phone'] . ',';
                        }
                    }
                }
            } else {
                $error_message = "Please select students";
            }

        $caption = mysqli_escape_string($connection, trim($_POST['textarea']));
        if ($caption != "") {
            // $caption = $caption . '\n Please do not reply to this number, For any quries contact ' . $school_admin . '\n Phone Number: ' . $school_number;
        } else {
            // $caption = 'Please do not reply to this number, For any quries contact ' . $school_admin . '\n Phone Number: ' . $school_number;
        }


        if (isset($_FILES['audioToUpload'])) {
            $file = $_FILES['audioToUpload'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_size = $file['size']; 

            if ($file == "") {
                $error_message = "Please select file";
            } 

            if (!isset($error_message)) {
                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));

                $allowed = array('mp3', 'wav');

                if (in_array($file_ext, $allowed)) {
                    $file_new_name = md5(date('Y-m-d H:i:s.u')) . '.' .  $file_ext;
                    $file_destination = '../uploads/' . $file_new_name;
                    $full_url = "https://" . $domain_name . "/uploads/" . $file_new_name;

                    if (move_uploaded_file($file_tmp, $file_destination)) { ?>
                        <script type="text/javascript">
                            var settings = {
                              "async": true,
                              "crossDomain": true,
                              "url": "https://api.ultramsg.com/instance26587/messages/audio",
                              "method": "POST",
                              "headers": {},
                              "data": {
                                "token": "wq6wqj6ky4or8oy7",
                                "to": "<?php echo $user_number; ?>",
                                "audio": "<?Php echo $full_url; ?>",
                                "caption": "<?php echo $caption; ?>"
                              }
                            }

                            $.ajax(settings).done(function (response) {
                              // console.log(response);
                            });
                        </script>
                    <?php 
                    $error_message = "Success Notification sent successfully";
                    }
                } else {
                    $error_message = "Only MP3 & WAV format are allowed";
                } 
             }             
        }
    }
    }   
        
?>
<!-- For audio Code ended-->

<!-- For video Code -->
<?php     
    if ($category == "video") {
        if (isset($_POST['videosubmit'])) {

            if(!empty($_POST['student_id'])) {    
                foreach($_POST['student_id'] as $value){
                    echo $user_id = $value;
                    $fetch_numbers = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_id = '$user_id'");

                    if (mysqli_num_rows($fetch_numbers) > 0) {
                        while($k = mysqli_fetch_assoc($fetch_numbers)) {
                           $user_number .= "+91" . $k['rev_student_phone'] . ',';
                        }
                    }
                }
            } else {
                $error_message = "Please select students";
            }

            $caption = mysqli_escape_string($connection, trim($_POST['textarea']));
            if ($caption != "") {
                // $caption = $caption . '\n Please do not reply to this number, For any quries contact ' . $school_admin . '\n Phone Number: ' . $school_number;
            } else {
                // $caption = 'Please do not reply to this number, For any quries contact ' . $school_admin . '\n Phone Number: ' . $school_number;
            }
            
        if (isset($_FILES['videoToUpload'])) {
            $file = $_FILES['videoToUpload'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_size = $file['size']; 

            if ($file == "") {
                $error_message = "Please select file";
            } 

            if (!isset($error_message)) {
                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));

                $allowed = array('mp4', 'webm', 'mov','wmv','avi','flv','mkv','mts');
                if (in_array($file_ext, $allowed)) {
                    $file_new_name = md5(date('Y-m-d H:i:s.u')) . '.' .  $file_ext;
                    try {                
                        $file = $file_new_name;
                        $result = $s3->putObject(
                            array(
                                'Bucket'=>$bucketName,
                                'Key' =>  $file_new_name,
                                'SourceFile' => $file_tmp,
                                'StorageClass' => 'REDUCED_REDUNDANCY'
                            )
                        );
                    } catch (S3Exception $e) {
                        echo 'sorry audio not uploaded, please try again';
                    } catch (Exception $e) {
                        echo 'sorry audio not uploaded, please try again';
                    } ?>
                    
                        <script type="text/javascript">
                            var settings = {
                                  "async": true,
                                  "crossDomain": true,
                                  "url": "https://api.ultramsg.com/instance26587/messages/chat",
                                  "method": "POST",
                                  "headers": {},
                                  "data": {
                                    "token": "wq6wqj6ky4or8oy7",
                                    "to": "<?php echo $user_number; ?>",
                                    "body": "Please click the link to watch the shared video\n<?php echo "https://d349p3fjrxa3i.cloudfront.net/" . $file_new_name; ?>"
                                    }
                                }
                                
                                $.ajax(settings).done(function (response) {
                                  console.log(response);
                                });
                        </script>
                    <?php                       
                     }
                } else {
                    $error_message = "Only mp4,webm,mov,wmv,avi,flv,mkv,mts are allowed";
                } 
             }             
        }
    }   
       
?>
<!-- For video Code ended-->


<!-- For video Code -->
<?php     
    if ($category == "text") {
      if (isset($_POST['textarea'])) {
           if(!empty($_POST['student_id'])) {    
                foreach($_POST['student_id'] as $value){
                    $user_id = $value;
                    $fetch_numbers = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_id = '$user_id'");

                    if (mysqli_num_rows($fetch_numbers) > 0) {
                        while($k = mysqli_fetch_assoc($fetch_numbers)) {
                           $user_number .= "+91" . $k['rev_student_phone'] . ',';
                        }
                    }
                }
            } else {
                $error_message = "Please select students";
            }

            $caption = mysqli_escape_string($connection, trim($_POST['textarea']));
            if ($caption != "") {
                // $caption = $caption . '\n Please do not reply to this number, For any quries contact ' . $school_admin . '\n Phone Number: ' . $school_number;
            } else {
                // $caption = 'Please do not reply to this number, For any quries contact ' . $school_admin . '\n Phone Number: ' . $school_number;
            } ?>
            <script type="text/javascript">
               var settings = {
                  "async": true,
                  "crossDomain": true,
                  "url": "https://api.ultramsg.com/instance26587/messages/chat",
                  "method": "POST",
                  "headers": {},
                  "data": {
                    "token": "wq6wqj6ky4or8oy7",
                    "to": "<?php echo $user_number; ?>",
                    "body": "<?php echo $caption; ?>"
                }
                }

                $.ajax(settings).done(function (response) {
                  // console.log(response);
                });
            </script>
        <?Php 
        $error_message = "Success Notification sent successfully";
      }
    }    
?>
<!-- For video Code ended-->

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<style type="text/css">
    html{
        scroll-behavior: smooth;
    }
    .text_highlight:target {
     color: #ED213A;
     font-weight: bold;
     background-color: #FFA;
    -webkit-transition: all 1s linear;
  } 
</style>

     <div class="container">
          <div class="row">
                <div class="d-flex justify-content-center mt-2">
                    <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center text-purple fw-bold" role="alert" style="font-size: 18px; text-align: center;">
                        <img src="<?php echo BASE_URL; ?>assets/images/submitted.webp" width="30px" height="30px" alt="submitted">&nbsp;Select students to send <?php echo $category; ?> via WhatsApp
                    </div>  
                </div>
                
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <form class="bg-body shadow rounded p-2 form">
                            <div class="input-group">
                                <input class="form-control border-0 me-1 searchquery" type="search" placeholder="Search student name or grade">
                                <button type="button" class="btn btn-primary btn-xs mb-0 rounded z-index-1"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="search_result"></div>
                        </form>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-md-2">
                        <div class="mb-3 bg-body rounded text-success fw-bold text-center" onclick='selects()' style="cursor: pointer;">
                                ✅ Select all
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3 bg-body rounded text-danger fw-bold text-center" onclick='deSelect()' style="cursor: pointer;">
                                ❌ Deselect all
                        </div>
                    </div>
                </div>

               <div class="col-md-12">
                    <!-- <h5 class="text-center">Select Students to Send Image through WhatsApp</h5> -->
                    <?php 
                        if (isset($error_message)) { ?>                               
                            <div class="alert alert-danger text-center" role="alert">
                                <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        <?php }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div id="table-scroll1" class="table-scroll1">
                          <div class="table-wrap" style="max-height: 1000px; overflow:auto;">
                            <table class="main-table">
                               <thead>
                                 <tr class="table_header text-center">
                                  <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">#</span></th>
                                  <!-- <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Select</span></th> -->
                                  <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Name</span></th>
                                  <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Grade</span></th>
                                  <th scope="col" class="border-0"><span class="badge bg-success bg-opacity-10 text-success" style="font-size: 16px; font-weight: bold">Sec</span></th>  
                                 </tr>
                               </thead>
                           <tbody>
                              <?php
                                   $fetch_data_query = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_sch = '$user_school' AND rev_student_sts = '1' AND rev_student_id != '0' AND rev_student_class = '$subject_class_yt' AND rev_student_sec = '$subject_teacher_sec'");
                                   if (mysqli_num_rows($fetch_data_query) > 0) {
                                        $i = 1;
                                        while($k = mysqli_fetch_assoc($fetch_data_query)) { ?>
                                             <tr id="<?php echo htmlspecialchars($k['tree_id'], ENT_QUOTES, 'UTF-8'); ?>" class="text-left text_highlight" style="font-size: 16px">
                                                   <th class="fixed-side" style="font-weight: bold;"><?php echo $i++; ?></th>
                                                   <td><input class="form-check-input" type="checkbox" id="disabledFieldsetCheck_<?php echo htmlspecialchars($k['tree_id'], ENT_QUOTES, 'UTF-8'); ?>" name="student_id[]" value="<?php echo htmlspecialchars($k['rev_student_id'], ENT_QUOTES, 'UTF-8'); ?>" style="background-color: #0cbc87; border: 0px solid #0cbc87;"><span style="font-weight: bold;">&nbsp;&nbsp;<?php echo htmlspecialchars(ucfirst($k['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></span></td>
                                                   <!-- <td class="fixed-side" style="text-align: left; max-width: 5px; font-weight: bold; color: #0cbc87"><?php echo htmlspecialchars(ucfirst($k['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></td>       -->
                                                   <td style="font-weight: bold;">Grade <?php echo htmlspecialchars($k['rev_student_class'], ENT_QUOTES, 'UTF-8'); ?></td> 
                                                   <td style="font-weight: bold;">'<span style="color: red"><?php echo htmlspecialchars(ucfirst($k['rev_student_sec']), ENT_QUOTES, 'UTF-8'); ?></span>' Sec</td>                                              
                                             </tr>                                            
                                        <?php }
                                   }
                              ?>
                           </tbody>
                         </table>
                         </div>
                     </div>
                     <div class="d-flex justify-content-left mt-4">
                        <div class="p-2 mb-3 bg-body rounded d-flex align-items-center text-purple fw-bold" role="alert" style="font-size: 16px; text-align: center;">
                            <?php 
                                if ($category == "text" || $category == 'audio') { ?>
                                    <div class="icon-md bg-primary bg-opacity-10 rounded-circle text-primary"><i class="fas fa-image" style="font-size: 18px; margin-top: 11px;"></i></div>&nbsp;Add <?php echo $category;?>
                                <?php } else { ?>
                                    <div class="icon-md bg-primary bg-opacity-10 rounded-circle text-primary"><i class="fas fa-image" style="font-size: 18px; margin-top: 11px;"></i></div>&nbsp;Choose <?php echo $category; ?> and add text
                                <?php } ?>                            
                        </div>  
                     </div>
                          <!-- for image -->
                            <?php 
                             if ($category == "image") { ?>
                                <div class="form-floating">
                                   <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="textarea"></textarea>
                                   <label for="floatingTextarea">Comments</label>
                                </div><br>
                                <div class="mb-3">                                  
                                  <input class="form-control" type="file" name="fileToUpload">
                                </div>                                       
                                <input type="submit" name="submit" class="btn btn-primary">
                            <?php } ?>
                          <!-- for image ended -->

                          <!-- for audio -->
                            <?php 
                             if ($category == "audio") { ?>
                                <div class="mb-3">                                  
                                  <input class="form-control" type="file" name="audioToUpload">
                                </div>                                      
                                <input type="submit" name="audiosubmit" class="btn btn-primary">
                            <?php } ?>
                          <!-- for audio ended -->

                          <!-- for video -->
                            <?php 
                             if ($category == "video") { ?>
                                <div class="form-floating">
                                   <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="textarea"></textarea>
                                   <label for="floatingTextarea">Comments</label>
                                </div><br>
                                <div class="mb-3">                                  
                                  <input class="form-control" type="file" name="videoToUpload">
                                </div>                                     
                                <input type="submit" name="videosubmit" class="btn btn-primary">
                            <?php } ?>
                          <!-- for video ended -->

                          <!-- for text -->
                            <?php 
                             if ($category == "text") { ?>
                                 <div class="form-floating">
                                       <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="textarea"></textarea>
                                       <label for="floatingTextarea">Comments</label>
                                  </div><br>                                      
                                <input type="submit" name="textsubmit" class="btn btn-primary">
                            <?php } ?>
                          <!-- for text ended -->
                    </form>
               </div>
          </div>
     </div>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<script type="text/javascript">
    $('.searchquery').keyup(function() {        
        var search_q = $('.searchquery').val();
        $.post("search.php", { search: search_q, teacher_class: "<?php echo $subject_class_yt; ?>", teacher_sec: "<?php echo $subject_teacher_sec; ?>", teacher_school: "<?php echo $user_school; ?>" }).done(function( data ) {           
            $('.search_result').show();
            $('.search_result').html(data);
        });
    })
    $(".form").submit(function(e){
        e.preventDefault();
    });
</script>
<script type="text/javascript">  
    function selects(){  
        var ele=document.getElementsByName('student_id[]');  
        for(var i=0; i<ele.length; i++){  
            if(ele[i].type=='checkbox')  
                ele[i].checked=true;  
        }  
    }  
    function deSelect(){  
        var ele=document.getElementsByName('student_id[]');  
        for(var i=0; i<ele.length; i++){  
            if(ele[i].type=='checkbox')  
                ele[i].checked=false;
        }  
    }             
</script> 