<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
	$today = date('Y-m-d h:i a');


?>
<?php 
	if (isset($_COOKIE['aut'])) {
		$auto_login_code = htmlspecialchars($_COOKIE['aut'], ENT_QUOTES, 'UTF-8');
		$fetch_user_auto_login_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_auto_login = '$auto_login_code' AND rev_teach_sts = '1'");

		if (mysqli_num_rows($fetch_user_auto_login_details) > 0) {
			while($j = mysqli_fetch_assoc($fetch_user_auto_login_details)) {
				$user_email = htmlspecialchars($j['rev_teach_email'], ENT_QUOTES, 'UTF-8');
				 $_SESSION['teach_details'] = $user_email;
				 // header("Location: " . BASE_URL . 'pages/action');	
			}
		}
	}


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
	if (isset($_POST['search']) && isset($_POST['teacher_class']) && isset($_POST['teacher_sec']) && isset($_POST['teacher_sub']) && isset($_POST['teacher_id'])) {
		$searchquery = mysqli_escape_string($connection, trim($_POST['search']));
		$searchclass = mysqli_escape_string($connection, trim($_POST['teacher_class']));
		$searchsec = mysqli_escape_string($connection, trim($_POST['teacher_sec']));
		$searchsubject = mysqli_escape_string($connection, trim($_POST['teacher_sub']));
		$searchteacherid = mysqli_escape_string($connection, trim($_POST['teacher_id']));

		if ($searchquery == "" || $searchclass == "" || $searchsec == "" || $searchsubject == "" || $searchteacherid == "") {
			$error_message = "something went wrong";	
		}		

		if (!isset($error_message)) {
			 $fetch_data = mysqli_query($connection, "SELECT * FROM rev_homework WHERE rev_hw_name LIKE  '%$searchquery%' AND rev_hw_class = '$searchclass' AND rev_hw_sec = '$searchsec' AND rev_hw_sts = '1' AND rev_hw_school = '$user_school' AND rev_teacher_id = '$searchteacherid' LIMIT 4");

			 if (mysqli_num_rows($fetch_data) > 0) { ?>
			 	<?php while($fr = mysqli_fetch_assoc($fetch_data)) { ?>
			 		<li style="list-style-type: none;" class="fw-bold"><a href="https://revisewellteachers.com/pages/check_hw.php?id=<?php echo $fr['tree_id']; ?>"><?php echo htmlspecialchars($fr['rev_hw_name'], ENT_QUOTES, 'UTF-8'); ?><span class="float-end"></span></a></li>
			 	<?php }
			 } else {
			 	echo "<p class='fw-bold'>No data found</p>";
			 }
		}
	}
?>