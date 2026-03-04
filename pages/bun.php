<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>

<?php require ROOT_PATH . 'includes/bunnycdn.php'; 
$bunnyCDNStorage = new BunnyCDNStorage("teacher-upload-video", "8aef6e6f-aef9-48bd-8063-43a25f285b173d0d51ba-5720-4573-ab29-986c9dad80ab", "sg");  
$bunnyCDNStorage->uploadFile("delete_image.php", "/teacher-upload-video/delete_image.php");
?>