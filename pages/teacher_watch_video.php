<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>

<?php 
	if (isset($_GET['id'])) {
		if ($_GET['id'] != "") {
			$video_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
		} 
	}
?>
<video width="100%" height="100%" controls>
		<source src="https://rev-user.s3.ap-south-1.amazonaws.com/<?php echo $video_id; ?>">
</video>