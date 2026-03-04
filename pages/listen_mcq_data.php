<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php 
 if (isset($_POST['name']) && isset($_POST['option1']) && isset($_POST['option2']) && isset($_POST['option3']) && isset($_POST['option4']) && isset($_POST['radio']) && isset($_POST['teacher_id']) && isset($_POST['teacher_sec']) && isset($_POST['teacher_class']) && isset($_POST['uniq_id'])) {
		$mcq_q = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
		$opt_1 = htmlspecialchars(trim($_POST['option1']), ENT_QUOTES, 'UTF-8');
		$opt_2 = htmlspecialchars(trim($_POST['option2']), ENT_QUOTES, 'UTF-8');
		$opt_3 = htmlspecialchars(trim($_POST['option3']), ENT_QUOTES, 'UTF-8');
		$opt_4 = htmlspecialchars(trim($_POST['option4']), ENT_QUOTES, 'UTF-8');
		$radio = htmlspecialchars(trim($_POST['radio']), ENT_QUOTES, 'UTF-8');
		$teacher_id = htmlspecialchars($_POST['teacher_id'], ENT_QUOTES, 'UTF-8');
		$teacher_sec = htmlspecialchars($_POST['teacher_sec'], ENT_QUOTES, 'UTF-8');
		$teacher_class = htmlspecialchars($_POST['teacher_class'], ENT_QUOTES, 'UTF-8');
		$uniq_id = htmlspecialchars($_POST['uniq_id'], ENT_QUOTES, 'UTF-8');
		$ref_key = htmlspecialchars($_POST['ref_key'], ENT_QUOTES, 'UTF-8');

		
		$check_if_question_is_present_with_ref_key = mysqli_query($connection, "SELECT * FROM rev_lsrw_mcq WHERE rev_reference_id = '$ref_key'");

		if (mysqli_num_rows($check_if_question_is_present_with_ref_key) > 0) {
			while($rol = mysqli_fetch_assoc($check_if_question_is_present_with_ref_key)) {
				$img_text = $rol['mcq_question'];
				$img_img = $rol['mcq_question_image'];
				$mcq_1_text = $rol['mcq_opt1'];
				$mcq_2_text = $rol['mcq_opt2'];
				$mcq_3_text = $rol['mcq_opt3'];
				$mcq_4_text = $rol['mcq_opt4'];
				$mcq_1_img = $rol['mcq_opt1_image'];
				$mcq_2_img = $rol['mcq_opt2_image'];
				$mcq_3_img = $rol['mcq_opt3_image'];
				$mcq_4_img = $rol['mcq_opt4_image'];
			}
		} else {
			$insert = mysqli_query($connection, "INSERT INTO rev_lsrw_mcq(mcq_question,mcq_question_image,mcq_opt1,mcq_opt1_image,mcq_opt2,mcq_opt2_image,mcq_opt3,mcq_opt3_image,mcq_opt4,mcq_opt4_image,mcq_ans,	rev_mcq_sts,tree_teacher_id,tree_teacher_class,tree_teacher_sec,rev_uniq_id,rev_reference_id) VALUES ('0','0','0','0','0','0','0','0','0','0','0','2','0','0','0','$uniq_id','$ref_key')");
		}



		if ($img_img == "0" && $mcq_q == "") {
			$error_message = 'Please fill all fields';
		}

		if (!isset($error_message)) {
			if ($mcq_1_img == "0" && $opt_1 == "") {
				$error_message = 'Please fill all fields';
			}
		}

		if (!isset($error_message)) {
			if ($mcq_2_img == "0" && $opt_2 == "") {
				$error_message = 'Please fill all fields';
			}
		}

		if (!isset($error_message)) {
			if ($mcq_3_img == "0" && $opt_3 == "") {
				$error_message = 'Please fill all fields';
			}
		}

		if (!isset($error_message)) {
			if ($mcq_4_img == "0" && $opt_4 == "") {
				$error_message = 'Please fill all fields';
			}
		}	

		if (!isset($error_message)) {
			if ($opt_1 != "") {
				$mcq1 = $opt_1;
			}

			if ($opt_2 != "") {
				$mcq2 = $opt_2;
			}

			if ($opt_3 != "") {
				$mcq3 = $opt_3;
			}

			if ($opt_4 != "") {
				$mcq4 = $opt_4;
			}

			if ($mcq_q != "") {
				$mcq_text = $mcq_q;
			}

			$update = mysqli_query($connection, "UPDATE rev_lsrw_mcq SET mcq_question = '$mcq_text', mcq_opt1 = '$mcq1', mcq_opt2 = '$mcq2', mcq_opt3 = '$mcq3', mcq_opt4 = '$mcq4', mcq_ans = '$radio' WHERE rev_reference_id = '$ref_key' AND rev_uniq_id = '$uniq_id' AND rev_mcq_sts = '2'");

			if (isset($update)) {
				$error_message = "s";
			}
		}							
	}	
?>

<?php 
	if (isset($error_message)) {
		echo $error_message;
	}
?>

