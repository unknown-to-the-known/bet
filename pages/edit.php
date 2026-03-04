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
     if (isset($_GET['uni'])) {
          if ($_GET['uni'] != "") {
              $uni_id = htmlspecialchars($_GET['uni'], ENT_QUOTES, 'UTF-8');          
          }    
     }

     if (isset($_GET['id'])) {
          if ($_GET['id'] != "") {
               $photo_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
          } else {
               header("Location: " . BASE_URL . 'pages/action');
          }
     } else {
               header("Location: " . BASE_URL . 'pages/action');
          }


          
?>




<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.loader {
  background: linear-gradient(#F7971E, #FFD200); /* Green background */
  border-radius: 10px;
  border: none; /* Remove borders */
  color: white; /* White text */
  padding: 12px 24px; /* Some padding */
  font-size: 16px; /* Set a font-size */
}
/* Add a right margin to each icon */
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
</style>

<style type="text/css">
     html {
  scroll-behavior: smooth;
}
.text_highlight:target {
    background-color: #ffa;
    -webkit-transition: all 1s linear;
 }
</style>

<div class="container">
     <div class="row">
          <h3>Delete Photo</h3>
          <?php 
               $fetch_image_from_database = mysqli_query($connection,"SELECT * FROM rev_base64 WHERE rev_uniq_session = '$uni_id'");

               if (mysqli_num_rows($fetch_image_from_database) > 0) {
                    while($kj = mysqli_fetch_assoc($fetch_image_from_database)) {  ?>
                         <div class="col-md-4">
                              <a href="#" class="pop">
                              <img src="https://d349p3fjrxa3i.cloudfront.net/<?php echo htmlspecialchars($kj['uniq_url'], ENT_QUOTES, 'UTF-8'); ?>" class="imageresource">
                                  <input type="hidden" name="" class="k" value="<?php echo htmlspecialchars($kj['uniq_url'], ENT_QUOTES, 'UTF-8'); ?>">
                              </a>
                         </div>
                    <?php }
               } else {
                    header("Location: " . BASE_URL . 'pages/action');
               }
          ?>
          
     </div>
</div>

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>

<?php 
     if ($photo_id != "") { 
          $fetch_photo_value = mysqli_query($connection, "SELECT * FROM rev_base64 WHERE uniq_url = '$photo_id'");
          if (mysqli_num_rows($fetch_photo_value) > 0) {
               while($juyh = mysqli_fetch_assoc($fetch_photo_value)) {
                    $u_d = $juyh['tree_id'];
                    $img_id = $juyh['uniq_url'];
               } ?>
               <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                 <div class="modal-dialog">
                   <div class="modal-content">
                     <div class="modal-header">
                       <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete selected photo</h1>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <img src="https://d349p3fjrxa3i.cloudfront.net/<?php echo $img_id; ?>">
                       
                     </div>
                     <div class="modal-footer">
                         <form action="" method="post">
                              <input type="hidden" name="del_va" value="<?php echo $img_id; ?>">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" name="submit">Delete</button>
                         </form>
                       
                     </div>
                   </div>
                 </div>
               </div>

               <script type="text/javascript">
                    $(document).ready(function(){
                         $("#staticBackdrop").modal('show');
                    });
               </script>
          <?php }          
     }
?>

<div class="modal fade imagemodal" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Image preview</h4>
      </div>
      <div class="modal-body">
        <img src="" class="imagepreview" style="width: 100%; height: 264px;" >
        <input type="text" name="" value="" class="y">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(function() {
          $('.pop').on('click', function() {
               $('.y').attr('value', $(this).find('.k').attr('value'));
               $('.imagepreview').attr('src', $(this).find('img').attr('src'));
               $('#imagemodal').modal('show');   
          });       
     });
</script>




