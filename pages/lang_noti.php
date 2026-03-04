 <?php require ROOT_PATH . 'includes/db.php'; ?>
 <?php
          if ($subject == 'english_first') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_first = 'english'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }

          if ($subject == 'english_second') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_second = 'english'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }

          if ($subject == 'english_third') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_third = 'english'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }

          if ($subject == 'kannada_first') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_first = 'kannada'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }


          if ($subject == 'kannada_second') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_second = 'kannada'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }

          if ($subject == 'kannada_third') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_third = 'kannada'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }


          if ($subject == 'hindi_first') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_first = 'hindi'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }

          if ($subject == 'hindi_second') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_second = 'hindi'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }


          if ($subject == 'hindi_third') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_third = 'hindi'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }

          if ($subject == 'sanskrit_first') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_first = 'sanskrit'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }

          if ($subject == 'sanskrit_second') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_second = 'sanskrit'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }


          if ($subject == 'sanskrit_third') {
               $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1' AND rev_student_third = 'sanskrit'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }
          }

          if ($subject == 'math' || $subject == 'social' || $subject == 'science') {
                 $fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_class = '$class' AND rev_student_sec = '$sec' AND rev_student_sch = '$school' AND rev_student_sts = '1'");

               if (mysqli_num_rows($fetch_all_student_list) > 0) {
                    while($k = mysqli_fetch_assoc($fetch_all_student_list)) {
                          $student_phone .= '+91' . $k['rev_student_phone'] . ',';
                          // $student_name = $k['rev_student_name'];
                    }         
               }  
          } 
?>