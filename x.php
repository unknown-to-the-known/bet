<?php require 'includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
    if (isset($_SESSION['teach_details'])) {
        $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
    } else {
        // header("Location: " . BASE_URL . 'index');
    }        
?>

<?php 
	$fetch = mysqli_query($connection, "SELECT * FROM mcq_temp_question");

	if (mysqli_num_rows($fetch) > 0) {
		while($ro = mysqli_fetch_assoc($fetch)) {
			$chapter_name = $ro['mcq_chapter_name'];
			$chapter_id = $ro['tree_id'];
			$chapter_syllabus = $ro['mcq_chapter_syllabus'];
			$chapter_class = $ro['mcq_chapter_class'];
			$chapter_subject = $ro['mcq_chapter_suject'];

			$fetch_chapter_uniq_id = mysqli_query($connection, "SELECT * FROM  mcq_academy_chapter_name WHERE mcq_chapter_name = '$chapter_name' AND mcq_chapter_class = '$chapter_class' AND mcq_chapter_sylabus = '$chapter_syllabus' AND mcq_subject_name = '$chapter_subject'");

			if (mysqli_num_rows($fetch_chapter_uniq_id) > 0) {
				while($c_id = mysqli_fetch_assoc($fetch_chapter_uniq_id)) {
					$chapter_id = $c_id['tree_id'];

					$update = mysqli_query($connection, "UPDATE mcq_temp_question SET mcq_uniq_id = '$chapter_id' WHERE mcq_chapter_name = '$chapter_name' AND mcq_chapter_syllabus = '$chapter_syllabus' AND mcq_chapter_class = '$chapter_class' AND mcq_chapter_suject = '$chapter_subject'");

				}
			}
		}
	}
?>