<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php   
      
 if (isset($_POST['name']) && isset($_POST['option1']) && isset($_POST['option2']) && isset($_POST['option3']) && isset($_POST['option4']) && isset($_POST['radio']) && isset($_POST['teacher_id']) && isset($_POST['teacher_sec']) && isset($_POST['teacher_class']) && isset($_POST['uniq_id']) && isset($_POST['up_img'])) {
		$mcq_q = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
		$opt_1 = htmlspecialchars($_POST['option1'], ENT_QUOTES, 'UTF-8');
		$opt_2 = htmlspecialchars($_POST['option2'], ENT_QUOTES, 'UTF-8');
		$opt_3 = htmlspecialchars($_POST['option3'], ENT_QUOTES, 'UTF-8');
		$opt_4 = htmlspecialchars($_POST['option4'], ENT_QUOTES, 'UTF-8');
		$radio = htmlspecialchars($_POST['radio'], ENT_QUOTES, 'UTF-8');
		$teacher_id = htmlspecialchars($_POST['teacher_id'], ENT_QUOTES, 'UTF-8');
		$teacher_sec = htmlspecialchars($_POST['teacher_sec'], ENT_QUOTES, 'UTF-8');
		$teacher_class = htmlspecialchars($_POST['teacher_class'], ENT_QUOTES, 'UTF-8');
		$uniq_id = htmlspecialchars($_POST['uniq_id'], ENT_QUOTES, 'UTF-8');
		$up_img = htmlspecialchars($_POST['up_img'], ENT_QUOTES, 'UTF-8');
		$insert_query = "INSERT INTO rev_mcq(mcq_question, mcq_opt1, mcq_opt2, mcq_opt3, mcq_opt4, mcq_ans,tree_teacher_id,tree_teacher_class,tree_teacher_sec,rev_uniq_id,	mcq_img) values ('$mcq_q', '$opt_1', '$opt_2', '$opt_3', '$opt_4', '$radio', '$teacher_id', '$teacher_class', '$teacher_sec', '$uniq_id', '$up_img')";
		if (mysqli_query($connection, $insert_query)) {
		  $last_id = mysqli_insert_id($connection);
		  echo "OK";
		} else {
		  echo "Error: " . $insert_query . "<br>" . mysqli_error($connection);
		}		
	}
?>
