<?php require 'includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
	if (isset($_POST['submit'])) {
		$name = mysqli_escape_string($connection, trim($_POST['name']));
		$whatsapp = mysqli_escape_string($connection, trim($_POST['number']));
		$email = mysqli_escape_string($connection, trim($_POST['mail']));
		$qualification = mysqli_escape_string($connection, trim($_POST['qualification']));
		$school = mysqli_escape_string($connection, trim($_POST['school']));
		$city = mysqli_escape_string($connection, trim($_POST['city'])); 

		if ($name == "" || $whatsapp == "" || $email == "" || $qualification == "" || $school == "" || $city == "") {
			$error_message = "Please fill all the fields";
		}

		if (!isset($error_message)) {
			if (strlen($whatsapp) > 10 || strlen($whatsapp) < 10) {
				$error_message = "Mobile number must be 10 digits";
			}
		}

		if (!isset($error_message)) {
			$fetch = mysqli_query($connection, "SELECT * FROM mcq_academy_user_data WHERE mcq_whats = '$whatsapp' AND mcq_sts = '1'");

			if (mysqli_num_rows($fetch) > 0) {
				$error_message = "Account already present";
			}

			if (!isset($error_message)) {
				$insert = mysqli_query($connection,"INSERT INTO mcq_academy_user_data(mcq_name,mcq_whats,mcq_email,mcq_qualification,mcq_school,mcq_city,mcq_sts,mcq_otp) VALUES ('$name', '$whatsapp', '$email', '$qualification', '$school', '$city', '1', '0')");

				if (isset($insert)) {
					$error_message = "Success, New Account created! Please Sign in to continue";
				}
			} 
		}
	}
?>

<?php 
		if (isset($_POST['signin'])) {
			$user_login_number = mysqli_escape_string($connection, trim($_POST['user_number']));

			if ($user_login_number == "") {
				$error_message = "Please enter valid mobile number";
			}

			if (!isset($error_message)) {
				if (strlen($user_login_number) > 10 || strlen($user_login_number) < 10) {
					$error_message = "Mobile number must be 10 digits";
				}
			}

			if (!isset($error_message)) {
				$checker = mysqli_query($connection, "SELECT * FROM mcq_academy_user_data WHERE mcq_whats = '$user_login_number' AND mcq_sts = '1'");			

				if (mysqli_num_rows($checker) > 0) {
					$user_otp = rand(000000,999999);
					$update_otp = mysqli_query($connection,"UPDATE mcq_academy_user_data SET mcq_otp = '$user_otp' WHERE mcq_whats = '$user_login_number' AND  mcq_sts = '1'");
					header("Location: " . BASE_URL . 'whats?id=' . $user_login_number);
				} else {
					$error_message = "Entered number is not registered. please create account";
				}
			}
		}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- <style type="text/css">
.loading_msg{
        margin: auto;
  border: 20px solid #066AC9;
  border-radius: 200%;
  border-top: 20px solid #fff;
  width: 50px;
  height: 50px;
  animation: spinner 4s linear infinite;
}
@keyframes spinner {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style> -->


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign in | Revisewell</title>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Webestica.com">
	<meta name="description" content="Eduport- LMS, Education and Course Theme">

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
			<a href="index.php" style="display: inline-flex;"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px;"><span style="font-size:32px; font-weight: bolder; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif; margin-left: -20px;">Revisewell</span></a>
			<!-- Logo END -->

		</div>
	</nav>
	<!-- Logo Nav END -->
</header>
<body>
<main>
	<section class="p-0 d-flex align-items-center position-relative overflow-hidden">	
		<div class="container-fluid" id="signin">
			<div class="row">				
				<div class="col-12 col-lg-6">
					<div class="row">
						<div class="col-sm-10 col-xl-8 m-auto">
							<!-- Title -->
							<!-- <span class="mb-0 fs-1">👋🏻</span> -->

							<span class="mb-0 fs-1"><img src="<?php echo BASE_URL; ?>assets/images/hello_bubble.svg
								" width="60px" height="60px" alt="hello_bubble"></span>
							<h1 class="fs-2">Sign-in into <span class='rounded px-1 py-1' style="color: #f25f22;">Revisewell</span>!</h1>
							<!-- <p class="lead mb-4">Don't have an account yet? <span id="signup-btn" class="text-info" style="font-weight: bold; cursor: pointer;">Create one now!</span></p>		 -->
							<?php 
								if (isset($error_message)) { ?>
							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								<strong><?php echo $error_message; ?></strong>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
							<?php	}
							?>		
							<form action="" method="post" autocomplete="off">
								<div class="mb-2">
									<label for="exampleInputnumber" class="form-label text-primary" style="font-weight: bold;">Please enter your WhatsApp number to login<span class="text-danger">*</span></label>
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-whatsapp" style="font-size: 20px;"></i></span>
										<input type="number" class="form-control border-0 bg-light rounded-end ps-1" placeholder="WhatsApp number" id="exampleInputnumber" name="user_number" value="">
									</div>
								</div>
								
								<!-- Button -->
								<div class="align-items-center">
									<div class="d-grid">
										
											<button class="btn btn-primary mb-0" type="submit" name="signin">Sign in</button>
										
									</div>
								</div>
							</form>
						</div>
					</div> <!-- Row END -->
				</div>
				<!-- <div class="Login">Login/Sign in page for Revisewell - Bring School to Home</div> -->
				<div class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-warning bg-opacity-10 h-100 mt-4" style=" border-radius: 50px;">
					<div class="p-3 p-lg-5">
						<!-- Title -->
						<div class="text-center">
							<h3 class="fw-bold">Welcome to Revisewell Academy</h3>
							<div class="shadow-lg p-3 bg-success" style="border-radius: 25px"><p class="mb-0 h5 fw-bold text-white" style="letter-spacing: 1px; margin-top: -15px">
								<lottie-player src="https://assets4.lottiefiles.com/packages/lf20_uxrgaxet.json"  background="transparent"  speed="1"  style="width: 13%; height: 13%; display: inline-flex;" loop autoplay></lottie-player><span style="margin-top: -15px;">Let's teach something new today!</span></p>
							</div>
							
						</div>
						<!-- SVG Image -->
						<img src="assets/images/MCQs.png" class="mt-5" alt="">
						<!-- Info -->
						<div class="d-sm-flex mt-3 align-items-center justify-content-center">
							<!-- Avatar group -->
							<ul class="avatar-group mb-2 mb-sm-0">
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/student.svg" alt="avatar">
								</li>
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/student.svg" alt="avatar">
								</li>
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/student.svg" alt="avatar">
								</li>

								<!-- <li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
								</li>
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar">
								</li>
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="avatar">
								</li> -->
							</ul>
							<!-- Content -->
							<p class="mb-0 h6 fw-bold ms-0 ms-sm-3">50+ Teachers joined us, now it's your turn.</p>
						</div>
					</div>
				</div>
			</div> <!-- Row END -->
		</div>
	</section>

	<section class="p-0 d-flex align-items-center position-relative overflow-hidden">	
		<div class="container-fluid" id="signup">
			<div class="row">				
				<div class="col-12 col-lg-6">
					<div class="row">
						<div class="col-sm-10 col-xl-8 m-auto">
							<!-- Title -->
							<!-- <span class="mb-0 fs-1">👋🏻</span> -->

							<span class="mb-0 fs-1"><img src="<?php echo BASE_URL; ?>assets/images/hello_bubble.svg
								" width="60px" height="60px" alt="hello_bubble"></span>
							

							<h1 class="fs-2">Sign-up in <span class='rounded px-1 py-1' style="color: #f25f22;">Revisewell</span>!</h1>
							<p class="lead mb-4">Already have an account? <span class="text-info" id="signin-btn" style="font-weight: bold; cursor: pointer;">Sign in</span></p>
							
									
													
							<form action="" method="post" autocomplete="off">	
								<div class="mb-2">
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-person-fill" style="font-size: 20px;"></i></span>
										<input type="name" class="form-control border-0 bg-light rounded-end ps-1" placeholder="Name*" id="exampleInputname" name="name" value="">
									</div>
								</div>	

								<div class="mb-2">
									<label for="exampleInputnumber" class="form-label text-primary" style="font-weight: bold;">Please enter your WhatsApp number to login<span class="text-danger">*</span></label>
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-whatsapp" style="font-size: 20px;"></i></span>
										<input type="number" class="form-control border-0 bg-light rounded-end ps-1" placeholder="WhatsApp number*" id="exampleInputnumber" name="number" value="">
									</div>
								</div>

								<div class="mb-2">
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-envelope-fill" style="font-size: 20px;"></i></span>
										<input type="email" class="form-control border-0 bg-light rounded-end ps-1" placeholder="E-mail*" id="exampleInputemail" name="mail" value="">
									</div>
								</div>

								<div class="mb-2">
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-mortarboard-fill" style="font-size: 20px;"></i></span>
										<input type="text" class="form-control border-0 bg-light rounded-end ps-1" placeholder="Qualification*" id="exampleInputgrad" name="qualification" value="">
									</div>
								</div>

								<div class="mb-2">
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-buildings-fill" style="font-size: 20px;"></i></span>
										<input type="text" class="form-control border-0 bg-light rounded-end ps-1" placeholder="School*" id="exampleInputschool" name="school" value="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Enter 'Revisewell Academy' if you don't belong to any school ">
									</div>
								</div>		

								<div class="mb-2">
									<div class="input-group input-group-lg">
										<span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-geo-alt" style="font-size: 20px;"></i></span>
										<input type="text" class="form-control border-0 bg-light rounded-end ps-1" placeholder="City*" id="exampleInputcity" name="city" value="">
									</div>
								</div>
								
								<!-- Button -->
								<div class="align-items-center">
									<div class="d-grid">
										<div class="loading_msg"></div>
										<button class="btn btn-primary mb-0" type="submit" name="submit">Sign up</button>
									</div>
								</div>
							</form>
						</div>
					</div> <!-- Row END -->
				</div>
				<!-- <div class="Login">Login/Sign in page for Revisewell - Bring School to Home</div> -->
				<div class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-warning bg-opacity-10 h-100 mt-4" style=" border-radius: 50px;">
					<div class="p-3 p-lg-5">
						<!-- Title -->
						<div class="text-center">
							<h3 class="fw-bold">Welcome to Revisewell Academy</h3>
							<div class="shadow-lg p-3 bg-success" style="border-radius: 25px"><p class="mb-0 h5 fw-bold text-white" style="letter-spacing: 1px; margin-top: -15px">
								<lottie-player src="https://assets4.lottiefiles.com/packages/lf20_uxrgaxet.json"  background="transparent"  speed="1"  style="width: 13%; height: 13%; display: inline-flex;" loop autoplay></lottie-player><span style="margin-top: -15px;">Let's teach something new today!</span></p>
							</div>
							
						</div>
						<!-- SVG Image -->
						<img src="assets/images/MCQs.png" class="mt-5" alt="">
						<!-- Info -->
						<div class="d-sm-flex mt-3 align-items-center justify-content-center">
							<!-- Avatar group -->
							<ul class="avatar-group mb-2 mb-sm-0">
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/student.svg" alt="avatar">
								</li>
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/student.svg" alt="avatar">
								</li>
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/student.svg" alt="avatar">
								</li>

								<!-- <li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
								</li>
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar">
								</li>
								<li class="avatar avatar-sm">
									<img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="avatar">
								</li> -->
							</ul>
							<!-- Content -->
							<p class="mb-0 h6 fw-bold ms-0 ms-sm-3">50+ Teachers joined us, now it's your turn.</p>
						</div>
					</div>
				</div>
			</div> <!-- Row END -->
		</div>
	</section>
</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- =======================
Footer START -->
<footer class="pt-5">
	<div class="container">
		<!-- Row START -->
		<div class="row justify-content-center">

			<!-- Widget 1 START -->
			<div class="col-lg-3">
				<!-- logo -->
				<a href="index.php" style="display: inline-flex;"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px;"><span style="font-size:32px; font-weight: bolder; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif; margin-left: -20px;">Revisewell</span></a>
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
					<div class="text-primary-hover"> Copyrights <a href="#" class="text-body">©2023 Hillspeak Internet Pvt Ltd.</a> All rights reserved </div>
					<!-- copyright links-->
					<div class="justify-content-center mt-3 mt-lg-0">
						<ul class="nav list-inline justify-content-center mb-0">
							<li class="list-inline-item"><a class="nav-link" href="about.html">About</a></li>
							<li class="list-inline-item"><a class="nav-link" href="terms.html">Terms of use</a></li>
							<li class="list-inline-item"><a class="nav-link pe-0" href="privacypolicy.html">Privacy policy</a></li>
							<li class="list-inline-item"><a class="nav-link pe-0" href="refund.html">Refund &amp; Cancellation</a></li>
							<li class="list-inline-item"><a class="nav-link pe-0" href="index.php#Contact">Contact</a></li>
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

<!-- <script>

        $('.loading_msg').hide(); 
        $('.loading').click(function() {
          $('.loading').hide();
          $('.loading_msg').show();   
        });
        
</script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
          $("#signup").hide();
        });

      $("#signup-btn").click(function(){
        $("#signup").show();
        $("#signin").hide();
      });

      $("#signin-btn").click(function(){
        $("#signup").hide();
        $("#signin").show();
      });

      $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
          $(".alert-success").slideUp(500);
      });

    </script>    

</body>
</html>