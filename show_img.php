<?php 
	  // error_reporting(0);
    defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
    defined('DB_USER')   ? null : define('DB_USER', 'karthik'); //u538764663_karth 
    defined('DB_PASS')   ? null : define('DB_PASS', '#Uk9zv45'); //3Pj6LD#5IKo9U1CwX~
    defined('DB_NAME')   ? null : define('DB_NAME', 'test_data'); //u538764663_video
    

    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if (!$connection) {
        die("There is a problem to connect the database, Please try after some time");
    } 
      
   session_start();  

	if (isset($_GET['id'])) {
		$k = $_GET['id'];	
	}
?>
<?php 
	$fetch_img = mysqli_query($connection, "SELECT * FROM rev_base64 WHERE tree_id = '$k'");

	if (mysqli_num_rows($fetch_img) > 0) {
		while($kl = mysqli_fetch_assoc($fetch_img)) { ?>
			<img src="<?php echo htmlspecialchars($kl['base64_img_text'], ENT_QUOTES, 'UTF-8'); ?>" width="100%">
		<?php }
	}


?>