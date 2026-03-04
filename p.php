<?php 
    error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'includes/config.php'; ?>
<?php require 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo 'ok';
//         $rev_email_id = mysqli_real_escape_string($connection, trim($_POST['emailsw']));
//         $rev_pass = mysqli_real_escape_string($connection, trim($_POST['passwordsw']));

//         var_dump($rev_email_id);
// var_dump($rev_pass);

//         if ($rev_email_id == "" || $rev_pass == "") {
//             $error_message = "Please fill all the fields";
//         }

//         if (!isset($error_message)) {
//                 $fetch_from_table = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$rev_email_id' AND user_sts = '1'");
//                 if (mysqli_num_rows($fetch_from_table) > 0) {
//                     while($tr = mysqli_fetch_assoc($fetch_from_table)) {
//                         $teacher_pass = htmlspecialchars($tr['rev_user_pass'], ENT_QUOTES, 'UTF-8');
//                     }
//                     if (password_verify($rev_pass, $teacher_pass) == $teacher_pass) {                       
//                         $cookiename = 'aut';
//             $cookievalue = md5(date('Y-m-d H:i:s'));
//             setcookie($cookiename, $cookievalue, time() + (86400 * 30), "/"); 
//             $_SESSION['teach_details'] = $rev_email_id;
//                 header("Location: " . BASE_URL . 'pages/action');
//                     } else {
//                         $error_message = "Sorry! The entered Email ID or Password are not matching";
//                     }
//                 } else {
//                     $error_message = "Entered Email ID is not registered in Revisewell...! Please contact your school admin to register";
//                 }
//         }
    }

    // if (isset($_POST['submit'])) {
    //     echo 'ok';
        
    // }
?>
<form action="" method="post" autocomplete="off">
            <div class="form-group">
                <label for="email">Email ID</label>
                <input type="email" id="email" name="emialsw" placeholder="Enter your email"   required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="passwordsw" placeholder="Enter your password"  required>
                    <!-- <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility()"></i> -->
                </div>
            </div>

            <button type="submit" name="submit" class="btn-login">Login</button>
            <div class="loading_msg"></div>
        </form>