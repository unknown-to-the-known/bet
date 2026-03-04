<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php require 'ultramsg.class.php'; ?>
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
     if(isset($_POST['name']) && isset($_POST['class']) && isset($_POST['sec']) && isset($_POST['subject']) && isset($_POST['school']) && isset($_POST['date']) && isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['format']) && isset($_POST['text']) && isset($_POST['uniq_identifier']) && isset($_POST['test_mark'])) {
          $name = htmlspecialchars($_POST['name'],ENT_QUOTES, 'UTF-8');
          $class = htmlspecialchars($_POST['class'],ENT_QUOTES, 'UTF-8');
          $sec = htmlspecialchars($_POST['sec'],ENT_QUOTES, 'UTF-8');
          $subject = htmlspecialchars($_POST['subject'],ENT_QUOTES, 'UTF-8');
          $school = htmlspecialchars($_POST['school'],ENT_QUOTES, 'UTF-8');
          $date = htmlspecialchars(date('Y-m-d',strtotime($_POST['date'])),ENT_QUOTES, 'UTF-8');
          $start_time = htmlspecialchars(date("H:i", strtotime($_POST['start_time'])),ENT_QUOTES, 'UTF-8');
          $end_time = htmlspecialchars(date("H:i", strtotime($_POST['end_time'])),ENT_QUOTES, 'UTF-8');
          $format = htmlspecialchars($_POST['format'],ENT_QUOTES, 'UTF-8');
          $text = htmlspecialchars($_POST['text'],ENT_QUOTES, 'UTF-8');
          $uniq_identifier = htmlspecialchars($_POST['uniq_identifier'], ENT_QUOTES, 'UTF-8');
          $marks = htmlspecialchars($_POST['test_mark'], ENT_QUOTES, 'UTF-8');

          $check_if_homework_class = mysqli_query($connection, "SELECT * FROM rev_test WHERE rev_hw_school = '$school' AND rev_hw_date = '$date' AND  rev_hw_class = '$class' AND rev_hw_sec = '$sec' AND rev_hw_sts = '1'");

          if (mysqli_num_rows($check_if_homework_class) > 0) {
               $error_message = "Home work already present for selected date";
          } else {
               $insert = "INSERT INTO rev_test(rev_hw_name, rev_hw_class,rev_hw_sec, rev_hw_subject,rev_hw_school,rev_hw_date, rev_hw_start_time,rev_hw_end_time, rev_hw_sts, rev_hw_format, rev_hw_link,    rev_question_text,rev_teacher_id, rev_uniq_identifier, rev_marks) VALUES ('$name', '$class', '$sec', '$subject', '$school', '$date', '$start_time',  '$end_time', '1','$format','0','$text', '$teacher_email_id', '0', '$marks')";
              if (mysqli_query($connection, $insert)) {
                 $last_id = mysqli_insert_id($connection); 
                 function generateRandomString($length = 25) {
                     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                     $charactersLength = strlen($characters);
                     $randomString = '';
                     for ($i = 0; $i < $length; $i++) {
                         $randomString .= $characters[rand(0, $charactersLength - 1)];
                     }
                     return $randomString;
                 }
                 $myRandomString = generateRandomString(5);
                 $insert_into_noti = mysqli_query($connection, "INSERT INTO rev_notification(rev_noti_name,rev_noti_cate,rev_noti_date,rev_noti_start_time,rev_noti_end,rev_uniq_id,rev_sts,rev_noti_sch,rev_noti_class,rev_noti_sec, rev_lsrw_sub_cate) VALUES ('$name', 'TEST', '$date', '$start_time', '$end_time', '$last_id', '1', '$user_school','$class', '$sec', '0')");

                 $original_url = "revisewell.com/pages/test?id=" . $uniq_identify;
                 $insert_into_short_url = mysqli_query($connection, "INSERT INTO rev_redirect(rev_short_url,rev_full_url,rev_sts) VALUES ('$myRandomString', '$original_url', '1')");

                  $cate = 'TEST';

                  // $sub_cate = "text_write";

                  $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$user_school' AND rev_student_sts = '1' AND rev_student_id != '0'");
                        if (mysqli_num_rows($fetch_all_student_list) > 0) {
                             while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                                   $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                                   // $student_name = $k['rev_student_name'];
                             }         
                        } 

                         $body = 'Hi,\n' .'Greetings from '. $user_school . ' 🙏\n'
                            .' *❗' . ucfirst($subject) . ' ' . $cate . '* ' .'notification alert for *class ' . $class .'* ' . ', from *Revisewell Learner App* ' . '❗\n\n'
                            . ucfirst($cate) . ' name - ' . ' *' . $name . '* ' . '\n'
                            . 'Scheduled on 🗓️ - ' . ' *' . date('d-M-Y', strtotime($date)) . '* ' . '\n'
                            . 'Start time ⏳ - ' . ' *' . date('h:i a', strtotime($start_time)) . '* ' . '\n' . 'End time ⌛ - ' . ' *' . date('h:i a', strtotime($end_time)) . '* '. '\n\n'
                            . 'Please click on the link below to check the scheduled LSRW\n' . ' *revisewell.com/k?r=' . $myRandomString . '* ' . '\n\n'.                             
                            'Thank you for using' .' *Revisewell Learner App* ' . '👍' . '\n' . 'Have a great day😊!';
                              $ultramsg_token = $ultra_msg_token; // Ultramsg.com token
                              $instance_id = $instance_id; // Ultramsg.com instance id
                              $client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);
                              $to = $student_phone; 
                              $body = $body; 
                              $api = $client->sendChatMessage($to,$body);
                              $success_message = "Success, Listen activity scheduled";                
               } 

               if (isset($insert)) {
                    $error_message = $last_id;
               } else {
                    $error_message = $error_message;
               }               
          }
     } 

     echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8');

?>