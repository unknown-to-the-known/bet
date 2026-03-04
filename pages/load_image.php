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
    $uniq_identifier = htmlspecialchars($_SESSION['uniq_identifier'], ENT_QUOTES, 'UTF-8');
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
     $fetch_uplaaded_details = mysqli_query($connection, "SELECT * FROM rev_base64 WHERE rev_uniq_session = '$uniq_identifier'");
     if (mysqli_num_rows($fetch_uplaaded_details) > 0) {
          while($ro = mysqli_fetch_assoc($fetch_uplaaded_details)) { ?>
               <div class='col-md-4' style='margin-left:10px; margin-top:5px'>
                    <div class='shadow-lg bg-body rounded' style='width:100%'>
                         <div class='card-body'>
                              <a href=edit?id=<?php echo $ro['uniq_url']; ?>&uni=<?php echo $uniq_identifier; ?>&t_id=<?php echo $teacher_tree_id; ?> target='_blank'>
                                   <button class='btn btn-danger' type='button' style='float:right'>Delete</button>
                              </a>
                              <a href='https://d349p3fjrxa3i.cloudfront.net/<?php echo $ro['uniq_url']; ?>' target='_blank'><img src='https://d349p3fjrxa3i.cloudfront.net/<?php echo $ro['uniq_url']; ?>'></a>
                         </div>
                    </div>
               </div>
         <?php }
     } else {
          echo 'not ok';
     }
?>