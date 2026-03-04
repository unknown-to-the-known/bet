<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
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
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_user_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
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
	if (isset($_POST['name'])) {
		if ($_POST['name'] != "") {
			$student_name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
		}
	}

	if (isset($_POST['st_date'])) {
		if ($_POST['st_date'] != "") {
			$st_date = htmlspecialchars($_POST['st_date'], ENT_QUOTES, 'UTF-8');
		}
	}

	if (isset($_POST['et_date'])) {
		if ($_POST['et_date'] != "") {
			$et_date = htmlspecialchars($_POST['et_date'], ENT_QUOTES, 'UTF-8');
		}
	}


	// Erp
	// echo "SELECT * FROM erp_bill WHERE rev_student_name LIKE '%$student_name%' AND rev_academic_year = '$academic_setter' AND rev_sts = '1'";
	 // echo "SELECT * FROM erp_bill WHERE rev_student_name LIKE '%$student_name%'  AND rev_academic_year = '$academic_setter' AND rev_sts = '1' AND rev_paid_on BETWEEN '$st_date' AND '$et_date' LIMIT 4";
	$sqls = mysqli_query($connection,"SELECT * FROM erp_bill WHERE rev_student_name LIKE '%$student_name%'  AND rev_academic_year = '$academic_setter' AND rev_sts = '1' LIMIT 4");
	if (mysqli_num_rows($sqls) > 0) {
		while($k = mysqli_fetch_assoc($sqls)) {
			echo '<a href="#' . $k['rev_student_id'] . '"><li style="list-style-type: none;">' . $k['rev_student_name'] . '</li></a>';
		}
	} else {
		echo 'No Data found';
	}
?>