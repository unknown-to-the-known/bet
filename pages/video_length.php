<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<?php 
	$date = date('Y-m-d H:i');
?>

<?php 
	if (isset($_POST['name']) && isset($_POST['time'])) {
		$video_id = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
		$video_length = htmlspecialchars($_POST['time'], ENT_QUOTES, 'UTF-8');
		$update = mysqli_query($connection,"UPDATE rev_video_list SET rev_video_length = '$video_length', rev_video_uploaded_on = '$date' WHERE rev_video_url = '$video_id' AND rev_video_sts = '1'");	
	}
?>