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
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_teach_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $user_school = htmlspecialchars($i['rev_teach_school'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['rev_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>

<?php 
	$question_id = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
	$question_name = htmlspecialchars($_POST['time'], ENT_QUOTES, 'UTF-8');
	$question_uniq_id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
?>

<?php 
	$check_id_uniq_id_belongs_to_same_teacher = mysqli_query($connection, "SELECT * FROM ai_teachers_hw_question_data WHERE hw_uniq_id = '$question_uniq_id' AND question_id = '$question_id' AND question_sts = '1'");

	if (mysqli_num_rows($check_id_uniq_id_belongs_to_same_teacher) > 0) {
		$update = mysqli_query($connection, "UPDATE ai_teachers_hw_question_data SET question_data = '$question_name' WHERE question_id = '$question_id' AND hw_uniq_id = '$question_uniq_id' AND question_sts = '1'");
		if (isset($update)) {
			$fetch_updated_data = mysqli_query($connection, "SELECT * FROM ai_teachers_hw_question_data WHERE hw_uniq_id = '$question_uniq_id' AND question_sts = '1' AND question_id = '$question_id'");

			if (mysqli_num_rows($fetch_updated_data) > 0) {
				while($fdr = mysqli_fetch_assoc($fetch_updated_data)) { ?>
					<!-- <div class="card shadow-lg p-1 mb-1 bg-body-tertiary rounded "> -->
						<div class="card-body text-dark det_<?php echo $question_id; ?>" style="font-family: 'Nunito Sans', sans-serif;">
							<button id="<?php echo $question_id; ?>" class="float-end" style="border: 0px; background-color: #fff;"><i class="far fa-trash-alt" style="font-size: 20px; color:red; cursor: pointer;"></i></button>
							<button id="edit_<?php echo $question_id; ?>" class="float-end" data-bs-toggle="modal" data-bs-target="#edit_questions" data-bs-whatever="<?php echo $question_id; ?>" data-bs-whatever_question="<?php echo $fdr['question_data']; ?>" data-bs-whatever_question_uniq_id = "<?php echo $question_uniq_id; ?>" style="border: 0px; background-color: #fff;"><i class="fas fa-edit" style="font-size: 20px; color:#74C0FC; cursor: pointer;"></i></button><br>
							<?php echo $fdr['question_data']; ?>
						</div>
					<!-- </div> -->
				<?php }
			}
		}
	}
?>