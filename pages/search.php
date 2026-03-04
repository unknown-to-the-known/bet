<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php $today = date('Y-m-d h:i a'); ?>
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
            $school_id = htmlspecialchars($i['rev_user_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>

<?php 
	 if (isset($_SESSION['academic_setter'])) {
        $academic_setter = $_SESSION['academic_setter'];
    } else {
        $academic_setter = '2025_26';
    }

    $academic_setter = str_replace('-', '_', $academic_setter);


?>
<?php 
	if (isset($_POST['search']) && isset($_POST['seal_class'])) {
		$searchquery = mysqli_escape_string($connection, trim($_POST['search']));
		$seach_class = mysqli_escape_string($connection, trim($_POST['seal_class']));

		if ($searchquery == "" || $seach_class == "") {
			$error_message = "something went wrong";	
		}

		if (!isset($error_message)) {

			if ($seach_class == 'all') {
				$fetch_data = mysqli_query($connection,"SELECT * FROM rev_erp_student_details WHERE (rev_student_fname LIKE '%$searchquery%' OR rev_student_mobile LIKE '%$searchquery%') AND rev_sts = '1' AND rev_academic_year = '$academic_setter' AND rev_admission_class = '1'  LIMIT 4");	
			} else {
				$fetch_data = mysqli_query($connection,"SELECT * FROM rev_erp_student_details WHERE (rev_student_fname LIKE '%$searchquery%' OR rev_student_mobile LIKE '%$searchquery%') AND rev_sts = '1' AND rev_admission_class = '$seach_class' AND rev_academic_year = '$academic_setter' LIMIT 4");
			}			

			if (mysqli_num_rows($fetch_data) > 0) { ?>
				<?php while($fr = mysqli_fetch_assoc($fetch_data)) { 
					$student_fname = $fr['rev_student_fname'];
					$student_mname = $fr['rev_student_mname'];
					$student_lname = $fr['rev_student_lname'];

					if ($student_lname == '0' || $student_mname == '0') {
						$student_name = $student_fname;
					} else {
						$student_name = $student_fname . ' ' . $student_mname . ' ' . $student_lname;
					}
					?>
					<a href="#<?php echo $fr['tree_id']; ?>">
						<div style="font-size: 14px; font-weight: bold;" class="d-flex justify-content-between">
							<span><?php echo htmlspecialchars(ucfirst($student_name), ENT_QUOTES, 'UTF-8'); ?> </span>

							<span class="float-end">Grade:<?php echo htmlspecialchars(ucfirst($fr['rev_admission_class']), ENT_QUOTES, 'UTF-8'); ?></span>					
						</div>
					</a>
				<?php }
			} else {
				echo "<p class='fw-bold'>No data found</p>";
			}
		}
	}
?>