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

        $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_teach_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
         }  
    }       
?>

<?php 
	if (isset($_GET['param'])) {
		if ($_GET['param'] != "") {
			$class_id = htmlspecialchars($_GET['param'], ENT_QUOTES, 'UTF-8');
			$fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE tree_id = '$class_id' AND rev_teach_sts = '1'");
			if (mysqli_num_rows($fetch_teacher_subject) > 0) {
				while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
					$subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
					$subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
					$subject_teacher_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
				}
			}
		} 
	} else {
		$fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE  rev_teach_sts = '1'  ORDER BY tree_id DESC");
		if (mysqli_num_rows($fetch_teacher_subject) > 0) {
			while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
				$subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
				$subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
				$class_id = htmlspecialchars($l['tree_id'], ENT_QUOTES, 'UTF-8');	
				$subject_teacher_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');		
		}
		}
	}		
?>


<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<div class="container zindex-100 desk" style="margin-top: 10px">
    <div class="row">
        <div style="float: left;">
            <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
        </div>
    </div>
</div>


<!-- =======================
Main Banner START -->

<!-- Content START -->
<div class="container zindex-100 desk mt-2" id="scroll_up">
    <div class="row d-lg-flex justify-content-md-center g-md-5">
        <!-- Left content START -->
            <h4 class="fs-1 fw-bold d-flex justify-content-center">
                <img src="<?php echo BASE_URL; ?>assets/images/communication_center.svg" width="55px" height="55px" alt="communication-center" style="margin-top: -15px;">
                <span class="position-relative z-index-9 text-center" style="font-size: 30px;">&nbsp;Communication center</span>
            </h4>           
    </div> 
</div>

    <!-- Svg decoration -->
    <figure class="position-absolute z-index-999 top-50 end-0 translate-middle-y me-n8 d-none d-sm-block mt-8">
        <svg class="fill-success opacity-1" width="634.1px" height="676px">
            <path d="M161.4,200.8c-9,40.1-7.5,82.5-20.8,121.6c-17.5,52.8-58.5,93.8-92,138.1c-33,44.8-59.9,101.8-42.5,154.6
                c23.1,70.2,109,94.8,181.6,108.4c77.4,14.6,154.7,29.2,232.5,43.8c41,8,85.8,15.1,123.1-4.7c47.2-25,63.7-83,72.2-135.3
                C650.5,419.6,675-127.8,306.2,27.3C234,57.5,178.4,124.5,161.4,200.8z"/>
            </svg>
    </figure>

    <!-- Svg decoration -->
    <figure class="position-absolute z-index-999 top-50 end-0 translate-middle-y me-n4 mt-n8 d-none d-lg-block">
        <svg class="fill-dark" width="349px" height="188.4px">
                <path d="M64.5,85.4c-0.2-0.3,0.2-0.8,0.6-0.6c3.2,1.6,5.7,4.4,4.6,8c-1,3.2-4.1,5.2-7.3,4.1c-2.9-0.8-5.3-3.9-4.5-7.1 C58.6,87.2,61.6,84.6,64.5,85.4z M63.5,95.3c2.3,0.4,4.3-1.5,4.6-3.7c0.4-2.3-1.2-3.9-2.7-5.3c-0.1,0.3-0.3,0.5-0.6,0.6 c-2.2,0.2-4.4,1.2-5,3.5C59.1,92.6,61.2,94.9,63.5,95.3z"/>
                <path d="M79.1,99.4c1.9-1.6,5.2-1.9,6.8,0.4c0.1,0.2,0,0.4-0.2,0.7c0.8,1.2,0.9,3,0.2,4.4c-1.1,2.6-4.2,2.8-6.4,1.3 C77.6,104.3,77,101.2,79.1,99.4z M80.6,104.8c1.4,1.1,3.3,0.9,4.1-0.7c0.7-1.4,0.4-3-0.8-4.1c-1.2-0.5-2.6-0.4-3.7,0.4 C78.7,101.6,79.2,103.7,80.6,104.8z"/>
                <path d="M94.9,116.6c0.9-2.2,3.8-3.4,5.8-2c0.1,0,0.2,0.2,0.2,0.3c1.3,0.9,2,2.7,1.5,4.4c-0.6,2.3-2.9,3.2-5,2.5 C95.2,121,93.8,118.7,94.9,116.6z M98,120.3c2.9,0.8,4.1-2.7,2.4-4.6c-0.2,0.1-0.3,0.1-0.4,0c-1.4-0.5-3.3,0.1-3.9,1.5 C95.7,118.7,96.8,120,98,120.3z"/>
                <path d="M15.6,62.5c7.8-3.3,16.6-3.9,24.8-2.6C56.3,62.1,69.5,71.3,81.2,82c0.1-0.4,0.5-0.7,0.9-0.7 c8-1,15.9,0.1,23.7,2.1c3.7,1,13,2.1,14.9,6.5c3.5,8-13.9,12.1-19.7,12.3c4.6,4.8,9.1,9.6,13.9,14.1c4.8,4.5,9.8,8.7,15.8,10.8 c1.9-2.2,3.3-6.7,7-6.1c2.9,0.5,4.9,4.6,5.8,7.6c2.6,0,5.2,0.3,7.9,1c0.7,0.2,0.9,0.8,0.8,1.4c-1.5,9.2-5.5,29.6-18.4,27.3 c-7.7-1.4-15.8-6.2-22.5-10c-7-3.9-13.7-8.6-19.7-14.1c0.2,5.9,0.9,11.8,2.1,17.6c0.6,3.5,3.2,8.6,0,11.4 c-7.9,6.8-21.5-14.6-24.5-19.6c-4-6.5-7.1-13.5-9.9-20.4c-1.5-3.5-3.4-7.9-3.7-12.2c-0.4,0.3-0.8,0.3-1.3,0.2 c-11.1-5.5-21.7-11.9-31.8-19.1c-5.3-3.7-18-10.7-19.1-17.5C2.7,68.2,11,64.6,15.6,62.5z M37.3,62.3c-0.1,0-0.2-0.2-0.2-0.3 c-2.9-0.2-6-0.2-8.9,0.1c-3,0.3-6.4,0.8-9.7,1.9c4.1,7,10.2,11.4,17.2,15.3c2.8,1.5,4.2,2,7.5,2.6c5.3,2.3,7.6-0.4,6.9-7.8 c-1-1.1-2.1-2.4-3-3.6C43.8,67.4,40.4,65.1,37.3,62.3z M112.7,97c2.5-1.4,7.2-4.3,4.2-7.9c-1.2-1.5-6-2.2-7.7-2.7 c-8.7-2.7-17.4-4.1-26.5-3.3c3,2.8,5.9,5.8,8.7,8.5c3,3.1,5.9,6.3,8.9,9.4c0,0,0-0.1,0.2-0.1C104.6,100.2,108.7,99.1,112.7,97z  M141.5,126.8c-0.6-1-1.6-3-2.7-3.6c-1.2,0.1-2.2,0.1-3.4,0.2c-0.2,0.4-0.4,0.6-0.8,0.9c-0.3,0.5-0.6,1-0.8,1.5 c-0.3,0.6-0.8,1.2-1.2,1.8c0.9,0.3,2,0.5,3.1,0.7c2.3,0.4,4.5,0.4,6.8,0.4C142.2,128,141.8,127.3,141.5,126.8z M21.6,88.1 c10.8,8.1,22.3,15,34.2,21.2l0.1,0c0-1.1,0.4-2.3,0.8-3.4c2.1-5.1,5.5-4.4,9.9-2.3c8.6,3.8,16.4,8.6,23.5,14.6 c0.6,0.4-0.2,1.4-0.9,1.1c-4.8-3-9.5-6-14.4-8.8c-1.9-1.1-4.6-3.3-6.8-3.6c-0.9-0.8-1.8-1.2-2.7-1.3c-0.9-0.5-2-0.7-3-0.5 c-1.8,0.2-3.6,1.6-4.1,3.5c-0.4,1.5-0.3,2.8,0,4.3c0.1,0.3,0.3,0.6,0.3,0.9c0.1,0.2,0.2,0.5,0.1,0.6c0,0,0,0.1,0.1,0.2 c0.1,0.7,0.3,1.4,0.8,1.9c0.6,4.6,4,10,5.9,14.1c2.1,4.4,4.2,8.6,6.8,12.7c2.4,3.7,5,7.2,8,10.5c0.2,0.3,0.4,0.7,0.6,0.9 c0.2,0.2,0.3,0.4,0.6,0.6c1.2,1.9,2.7,3.6,5,4.9c2.1,1.3,4.2,0.7,5.6-0.6c-0.2-1.3-0.3-2.5-0.4-3.8c-0.5-1.3-0.5-3.4-0.4-4.3 c-0.2-0.9-0.4-1.7-0.5-1.9c-1.6-9.7-2-19.4-1.6-29.3c0.1-1.5,2.4-1.6,2.4,0c-0.2,3.9-0.1,7.8-0.1,11.7c9.8,7,19.5,13.8,30.4,18.8 c2.8,1.3,8.1,4.8,11.5,4.6c0.1,0,0.1,0,0.2-0.1c-5.1-0.7-3.7-7.6-5.5-10.8c-0.4-0.7,0.2-1.4,0.9-1.2c0.1-0.3,0.4-0.6,0.8-0.5 c2.9,0.4,5.9,1,8.9,1.7c0.3,0.1,0.3,0.6,0,0.6c-2.9-0.2-5.9-0.5-8.8-0.8c1.1,2.7,0.3,7.1,2.9,8.9c4.3,3.2,5.5-5.9,6.4-8.1 c0.3-0.5,1-0.1,0.9,0.4c-0.9,2.6-0.9,7.6-3.6,9.4c4-1.3,7-4.8,8.8-8.5c1.4-3,3.4-7.1,3.7-10.4c0.4-4.6,0.7-5.2-5.4-5.3 c-10.1-0.3-16.4-1.5-24.7-7.9c-9.7-7.5-17.8-17-26.3-25.9C78.6,81.8,61.3,65.7,40.4,62.5c5,3.7,12,8.1,12.7,14.3 c0.4,4.1-2.2,7.1-6.2,7.9c-6.2,1.3-12.9-3.8-17.7-7c-5.1-3.4-9.6-7.5-11.6-13.3c-2.7,1-5.2,2.2-7,4C1.7,76.5,16.7,84.3,21.6,88.1z "/>
                <path d="M148.9,144.4c0.2-0.4,0.7-0.1,0.5,0.3c-4.3,9.4,10.7,17.5,17.1,20.8c8.2,4.2,18.1,6.8,27.3,4.5 c2.9-0.8,6-2.4,8.5-4.4c-2.6-1.9-5.1-3.8-7.3-6c-7.3-7.3-13.9-24.1-0.1-28.5c12.3-3.9,21.1,9.9,18.7,20.7 c-1.2,5.4-4.1,9.7-7.9,13.1c1.2,0.8,2.5,1.4,3.6,2c12.9,6.4,27.7,11,41.9,12.6c31.3,3.4,61.4-14.2,67.6-46.4 c3-15.8-0.4-31.6-8.2-45.4c-5.8-10.3-13.2-19.9-16.2-31.5C287,25.6,318,7.6,343.8,3.5c0.7-0.1,1,1,0.3,1.1 c-20.7,3.3-43.8,13.4-48.7,36.3c-4.2,19.9,12.3,35.8,20.2,52.3c14.6,30.3,3.8,68.9-27.6,83.5c-14.9,6.9-32,6.8-47.9,3.3 c-11.8-2.5-25.6-6.6-36.4-13.6c-6.4,4.5-14.8,6.4-22.8,5.2C171.5,170.2,142.1,158.3,148.9,144.4z M205.2,133.2 c-6-3.4-14.3-1.1-16.4,5.8c-1.4,4.8,0.9,10.3,3.5,14.3c3.1,4.6,7.3,7.9,12,10.7C213.5,155.5,218.3,140.8,205.2,133.2z"/>
        </svg>
    </figure>

<div class="container">
	<div class="row g-4 mt-1">

		<div class="col-md-8">
            <!-- Item -->
            <div class="row">

               <!-- Category item -->
			<div class="col-md-6 px-4 mt-2">
				<div class="card card-body shadow rounded-3 shadow-hover btn-transition">
					<div class="d-flex align-items-center">
						<!-- Icon -->
						<div class="icon-lg bg-primary bg-opacity-10 rounded-circle text-primary"><i class="fas fa-image" style="font-size: 28px; margin-top: 15px;"></i></div>
						<div class="ms-3">
							<h5 class="mb-0"><a href="<?php echo BASE_URL; ?>pages/send_msg?id=image&param=<?php echo $class_id; ?>" class="stretched-link">Send image</a></h5>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 px-4 mt-2">
				<div class="card card-body shadow rounded-3 shadow-hover btn-transition">
					<div class="d-flex align-items-center">
						<!-- Icon -->
						<div class="icon-lg bg-orange bg-opacity-10 rounded-circle text-orange"><i class="fas fa-microphone" style="font-size: 28px; margin-top: 15px;"></i></div>
						<div class="ms-3">
							<h5 class="mb-0"><a href="<?php echo BASE_URL; ?>pages/send_msg?id=audio&param=<?php echo $class_id; ?>" class="stretched-link">Send audio</a></h5>
						</div>
					</div>
				</div>
			</div>
              </div>

                 <!-- Item -->
                 <div class="row">
                 	<div class="col-md-6 px-4 mt-2">
				<div class="card card-body shadow rounded-3 shadow-hover btn-transition">
					<div class="d-flex align-items-center">
						<!-- Icon -->
						<div class="icon-lg bg-success bg-opacity-10 rounded-circle text-success"><i class="fas fa-video" style="font-size: 28px; margin-top: 15px;"></i></div>
						<div class="ms-3">
							<h5 class="mb-0"><a href="<?php echo BASE_URL; ?>pages/send_msg?id=video&param=<?php echo $class_id; ?>" class="stretched-link">Send video</a></h5>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 px-4 mt-2">
				<div class="card card-body shadow rounded-3 shadow-hover btn-transition">
					<div class="d-flex align-items-center">
						<!-- Icon -->
						<div class="icon-lg bg-purple bg-opacity-10 rounded-circle text-purple"><i class="fas fa-font" style="font-size: 28px; margin-top: 15px;"></i></div>
						<div class="ms-3">
							<h5 class="mb-0"><a href="<?php echo BASE_URL; ?>pages/send_msg?id=text&param=<?php echo $class_id; ?>" class="stretched-link">Send text</a></h5>
						</div>
					</div>
				</div>
			</div>
                 </div>
                 
             </div>

             <div class="col-md-4">
                <div class="position-relative">

                    <!-- Image -->
                    <img src="../assets/images/communication_center_hero1.png" class="rounded-3" alt="Communication centre" width="100%" height="100%">
                </div>
            </div>

		
	</div>
</div>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>