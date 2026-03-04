<?php require 'includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
	$time_now = date('Y-m-d H:i:s');
	if (isset($_GET['id'])) {
		$uniq_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');	
	} else {
		header("Location: " . BASE_URL . 'sign-in');
	}
?>
<?php 
	// $plus_20_mins = date("Y-m-d H:i:s", strtotime("+20 minutes")); 

	$check_uniq_id_active = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_otp = '$uniq_id' AND rev_teach_sts = '1'");

	if (mysqli_num_rows($check_uniq_id_active) > 0) {
		while($row = mysqli_fetch_assoc($check_uniq_id_active)) {
			$user_name = htmlspecialchars($row['rev_teach_name'], ENT_QUOTES, 'UTF-8');
			$user_time = htmlspecialchars($row['rev_otp_time'], ENT_QUOTES, 'UTF-8');
		}

		if ($user_time <= $time_now) {
			$die_message = "Password reset link has expired, please try again";
		}
	} else {
		$die_message = "Password reset link is inactive, please try again by clicking the below button";
	}
?>

<?php 
	if (isset($_POST['submit'])) {
		$password = mysqli_escape_string($connection, trim($_POST['password']));
		$password_again = mysqli_escape_string($connection, trim($_POST['password_again']));

		if ($password == "" || $password_again == "") {
			$error_message = "Please fill all the fields";		
		}	

		if (!isset($error_message)) {
			if (strlen($password) > 16 || strlen($password_again) < 8) {
				$error_message = "Password must be 8 to 16 characters in length";	
			}
		}

		if (!isset($error_message)) {
			if ($password != $password_again) {
				$error_message = "Both password are not matching";
			}
		}

		if (!isset($error_message)) {
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			$update_pass = mysqli_query($connection, "UPDATE rev_user_details SET rev_teach_pass = '$password_hash', rev_otp = '', rev_otp_time = '' WHERE rev_otp = '$uniq_id' AND rev_teach_sts = '1'");
			if (isset($update_pass)) {
				$success_message = "Password successfully changed, please wait for 3 seconds";	
				header( "Refresh:3; url=https://revisewellteachers.com/sign-in");
			}
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Revisewell Password</title>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Webestica.com">
	<meta name="description" content="Revisewell Teacher">

	<!-- Favicons -->
	<link href="assets/images/favicon.svg" rel="icon">
	<link href="assets/images/favicon.svg" rel="icon">
	<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script src="https://kit.fontawesome.com/a2bc8eeb47.js" crossorigin="anonymous"></script>


	<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">

	<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

	<!-- Theme CSS -->
	<link id="style-switch" rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<style type="text/css">
		.togglePassword{
	      margin-left: -30px;
	      cursor: pointer;
	  }
	  .togglePassword1{
	      margin-left: -30px;
	      cursor: pointer;
	  }
		
	</style>

</head>

<!-- Header START -->
<header class="navbar-light navbar-sticky">
	<!-- Logo Nav START -->
	<nav class="navbar navbar-expand-lg">
		<div class="container d-flex justify-content-center">
			<!-- Logo START -->
			<a href="index.php" class="mt-2 mb-4" style="display: inline-flex;"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px;"><span style="font-size:32px; font-weight: bolder; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif; margin-left: -20px;">Revisewell</span></a>
			<!-- Logo END -->

		</div>
	</nav>
</header>
<body>
<main>
	<section class="p-0 d-flex align-items-center position-relative overflow-hidden">	
		<div class="container-fluid">
			<div class="row">				
				<div class="col-12 col-lg-12">
					<div class="row">
						<div class="col-sm-10 col-xl-8 m-auto">							
							<?php 
								if (isset($success_message)) { ?>
									<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
											<?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?>
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								<?php }		?>
							<?php 
								if (isset($error_message)) { ?>
									<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
											<?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								<?php } ?>
							<?php 
								if (isset($die_message)) { ?>
									<div class="card text-center shadow-sm p-3 mb-5 bg-body rounded">
									  <div class="card-body">
									    <p style="font-family: 'Nunito Sans', sans-serif; font-size:16px" class="text-dark"><?php echo htmlspecialchars($die_message, ENT_QUOTES, 'UTF-8'); ?></p>
									    <a href="<?php echo BASE_URL; ?>sign-in"><button class="btn btn-info btn-sm"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/home+(2).svg" width="25px"> Back to Home</button></a>
									  </div>
									</div>
								<?php } else { ?>
									<span class="mb-0 fs-1">👋🏻</span>
							<h1 class="fs-2">Hi <span class='rounded px-1 py-1' style="color: #f25f22;"><?php echo ucfirst($user_name); ?></span>!</h1>
							<p class="lead mb-4">Enter the below details to reset the password.</p>
												
							<form action="" method="post" autocomplete="off">
								<div class="mb-2">
									<label for="inputPassword5" class="form-label text-primary" style="font-weight: bold;">Password <span class="text-danger">*</span></label>
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="fas fa-lock"></i></span>
										<input type="password" class="form-control border-0 bg-light rounded-end ps-1" placeholder="Password" id="password" name="password" autocomplete="off">
									</div>
									<div id="passwordHelpBlock" class="form-text text-dark" style="font-weight: bold;">
										*Your password must be 8 characters at least*
									</div>
								</div>								
								
								<!-- Password -->
								<div class="mb-2">
									<label for="inputPassword5" class="form-label text-primary" style="font-weight: bold;">Repeat Password<span class="text-danger">*</span></label>
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="fas fa-lock"></i></span>
										<input type="password" class="form-control border-0 bg-light rounded-end ps-1" placeholder="Repeat Password" id="password" name="password_again" autocomplete="off">
									</div>
									<div id="passwordHelpBlock" class="form-text text-dark" style="font-weight: bold;">
										*Your password must be 8 characters at least*
									</div>
								</div>
								
								<div class="align-items-center">
									<div class="d-grid">
										<button class="btn btn-primary mb-0" type="submit" name="submit">Login</button>
									</div>
								</div>
							</form>	
							<?php }	?>									
						</div>
					</div> <!-- Row END -->
				</div>
			</div> <!-- Row END -->
		</div>
	</section>
</main>

<footer class="pt-5">
	<div class="container">
		<!-- Row START -->
		<div class="row justify-content-center">
			<!-- Widget 1 START -->
			<div class="col-lg-3">
				<!-- logo -->
				<a href="index.html" style="display: inline-flex;"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px;"><span style="font-size:32px; font-weight: bolder; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif; margin-left: -20px;">Revisewell</span></a>
				<!-- Social media icon -->
				<ul class="list-inline mb-0 mt-3">
					<li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-youtube" href="https://www.youtube.com/channel/UCYEg01BNvUOkOGQLmSDoUAA" target="_blank"><i class="fab fa-fw fa-youtube"></i></a> </li>
					<li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-facebook" href="https://www.facebook.com/revisewelllearnerapp/" target="_blank"><i class="fab fa-fw fa-facebook-f"></i></a> </li>
					<li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-instagram" href="https://www.instagram.com/revisewell_learner_app/?utm_medium=copy_link" target="_blank"><i class="fab fa-fw fa-instagram" target="_blank"></i></a> </li>
					<li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-linkedin" href="https://www.linkedin.com/in/revisewell-edtech/" target="_blank"><i class="fab fa-fw fa-linkedin-in"></i></a></li>
					<li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-twitter" href="https://twitter.com/revisewell?t=Pe1sxFxPdWEOJ6eJZ72eaQ&s=08" target="_blank"><i class="fab fa-fw fa-twitter"></i></a></li>
				</ul>
			</div>

		<!-- Divider -->
		<hr class="mt-4 mb-0">

		<!-- Bottom footer -->
		<div class="py-3">
			<div class="container px-0">
				<div class="d-lg-flex justify-content-between align-items-center py-3 text-center text-md-left">
					<!-- copyright text -->
					<div class="text-primary-hover"> Copyrights <a href="#" class="text-body">©2022 Hillspeak Internet Pvt Ltd.</a> All rights reserved </div>
					<!-- copyright links-->
					<div class="justify-content-center mt-3 mt-lg-0">
						<ul class="nav list-inline justify-content-center mb-0">
							<li class="list-inline-item"><a class="nav-link" href="about.html">About</a></li>
							<li class="list-inline-item"><a class="nav-link" href="terms.html">Terms of use</a></li>
							<li class="list-inline-item"><a class="nav-link pe-0" href="privacypolicy.html">Privacy policy</a></li>
							<li class="list-inline-item"><a class="nav-link pe-0" href="refund.html">Refund &amp; Cancellation</a></li>
							<li class="list-inline-item"><a class="nav-link pe-0" href="index.html#contact">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<!-- =======================
Footer END -->

<!-- Back to top -->
<div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Template Functions -->
<script src="assets/js/functions.js"></script>

<script>
        const togglePassword = document.querySelector(".togglePassword");
        const togglePassword1 = document.querySelector(".togglePassword1");
        const password = document.querySelector("#password");
        $(".togglePassword1").hide();
        $(".togglePassword").show();

        $(".togglePassword").click(function(){
              $(".togglePassword1").show();
              $(".togglePassword").hide();
            });

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            $(".togglePassword1").click(function(){
              $(".togglePassword").show();
              $(".togglePassword1").hide();
            });
            
        });

        $(".togglePassword1").click(function(){
              $(".togglePassword").show();
              $(".togglePassword1").hide();
            });

        togglePassword1.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            $(".togglePassword").click(function(){
              $(".togglePassword1").show();
              $(".togglePassword").hide();
            });
            
        });
        
</script>

</body>
</html>