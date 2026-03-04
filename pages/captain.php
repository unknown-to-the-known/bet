<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<?php 
	$today = date('Y-m-d h:i a');
?>
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
           
         }  
    }
?>


<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<div class="container zindex-100 desk" style="margin-top: 10px">
	<div class="row">
		<div style="float: left;">
		<h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
		</div>
		<div class="d-flex justify-content-end" style="margin-top: -20px">
			<select class="btn btn-sm dropdown-toggle select mb-3 font-base bg-primary bg-opacity-10 text-primary rounded-2 btn-transition d-flex justify-content-end" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false" style="font-size: 15px; font-weight: bold;" onchange="javascript:handleSelect(this)">			
					<?php 
						$fetch_teacher_class = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE rev_teach_email_id = '$teacher_email_id' AND rev_teach_sts = '1'");
						if (mysqli_num_rows($fetch_teacher_class) > 0) {
							while($lo = mysqli_fetch_assoc($fetch_teacher_class)) { ?>							
							    <option style="background:#fff; color: #000;" value="<?php echo htmlspecialchars($lo['tree_id'], ENT_QUOTES, 'UTF-8'); ?>" <?php if ($lo['tree_id'] == $class_id) {
							    	echo 'selected';
							    }?>>Grade <?php echo htmlspecialchars($lo['rev_teacher_class'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars(ucfirst($lo['rev_teach_subject']), ENT_QUOTES, 'UTF-8'); ?></option>						    
							<?php }	
						}
					?>   
			</select>	    
		</div>
	</div>
</div>


	<!-- Content START -->
	<div class="container zindex-100 desk mb-4">
		<div class="row d-lg-flex justify-content-md-center g-md-5">
			<!-- Left content START -->
				<h4 class="fs-1 fw-bold d-flex justify-content-center">
					<img src="../assets/images/captain.webp" alt="add" height="30px" width="40px">
					<span class="position-relative z-index-9" style="font-size: 33px;">&nbsp;Create&nbsp;</span>
					<span class="position-relative z-index-1" style="font-size: 33px;">Captain
						
						<span class="position-absolute top-50 start-50 translate-middle z-index-n1">
							<svg width="163.9px" height="48.6px">
								<path class="fill-warning" d="M162.5,19.9c-0.1-0.4-0.2-0.8-0.3-1.3c-0.1-0.3-0.2-0.5-0.4-0.7c-0.3-0.4-0.7-0.7-1.2-0.9l0.1,0l-0.1,0 c0.1-0.4-0.2-0.5-0.5-0.6c0,0-0.1,0-0.1,0c-0.1-0.1-0.2-0.2-0.3-0.3c0-0.3,0-0.6-0.2-0.7c-0.1-0.1-0.3-0.2-0.6-0.2 c0-0.3-0.1-0.5-0.3-0.6c-0.1-0.1-0.3-0.2-0.5-0.2c-0.1,0-0.1,0-0.2,0c-0.5-0.4-1-0.8-1.4-1.1c0,0,0-0.1,0-0.1c0-0.1-0.1-0.1-0.3-0.2 c-0.9-0.5-1.8-1-2.6-1.5c-6-3.6-13.2-4.3-19.8-6.2c-4.1-1.2-8.4-1.4-12.6-2c-5.6-0.8-11.3-0.6-16.9-1.1c-2.3-0.2-4.6-0.3-6.8-0.3 c-1.2,0-2.4-0.2-3.5-0.1c-2.4,0.4-4.9,0.6-7.4,0.7c-0.8,0-1.7,0.1-2.5,0.1c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0-0.2,0 c-0.9,0-1.8,0.1-2.7,0.1c-0.9,0-1.8,0-2.7,0c-5.5-0.3-10.7,0.7-16,1.5c-2.5,0.4-5.1,1-7.6,1.5c-2.8,0.6-5.6,0.7-8.4,1.4 c-4.1,1-8.2,1.9-12.3,2.6c-4,0.7-8,1.6-11.9,2.7c-3.6,1-6.9,2.5-10.1,4.1c-1.9,0.9-3.8,1.7-5.2,3.2c-1.7,1.8-2.8,4-4.2,6 c-1,1.3-0.7,2.5,0.2,3.9c2,3.1,5.5,4.4,9,5.7c1.8,0.7,3.6,1,5.3,1.8c2.3,1.1,4.6,2.3,7.1,3.2c5.2,2,10.6,3.4,16.2,4.4 c3,0.6,6.2,0.9,9.2,1.1c4.8,0.3,9.5,1.1,14.3,0.8c0.3,0.3,0.6,0.3,0.9-0.1c0.7-0.3,1.4,0.1,2.1-0.1c3.7-0.6,7.6-0.3,11.3-0.3 c2.1,0,4.3,0.3,6.4,0.2c4-0.2,8-0.4,11.9-0.8c5.4-0.5,10.9-1,16.2-2.2c0.1,0.2,0.2,0.1,0.2,0c0.5-0.1,1-0.2,1.4-0.3 c0.1,0.1,0.2,0.1,0.3,0c0.5-0.1,1-0.3,1.6-0.3c3.3-0.3,6.7-0.6,10-1c2.1-0.3,4.1-0.8,6.2-1.2c0.2,0.1,0.3,0.1,0.4,0.1 c0.1,0,0.1,0,0.2-0.1c0,0,0.1,0,0.1-0.1c0,0,0-0.1,0.1-0.1c0.2-0.1,0.4-0.1,0.6-0.2c0,0,0.1,0,0.1,0c0.1,0,0.2-0.1,0.3-0.2 c0,0,0,0,0,0l0,0c0,0,0,0,0,0c0.2,0,0.4-0.1,0.5-0.1c0,0,0,0,0,0c0.1,0,0.1,0,0.2,0c0.2,0,0.3-0.1,0.3-0.3c0.5-0.2,0.9-0.4,1.4-0.5 c0.1,0,0.2,0,0.2,0c0,0,0.1,0,0.1,0c0,0,0.1-0.1,0.1-0.1c0,0,0,0,0.1,0c0,0,0.1,0,0.1,0c0.2,0.1,0.4,0.1,0.6,0 c0.1,0,0.1-0.1,0.2-0.2c0.1-0.1,0.1-0.2,0.1-0.3c0.5-0.2,1-0.4,1.6-0.7c1.5-0.7,3.1-1.4,4.7-1.9c4.8-1.5,9.1-3.4,12.8-6.3 c0.8-0.2,1.2-0.5,1.6-1c0.2-0.3,0.4-0.6,0.5-0.9c0.5-0.1,0.7-0.2,0.9-0.5c0.2-0.2,0.2-0.5,0.3-0.9c0-0.1,0-0.1,0.1-0.1 c0.5,0,0.6-0.3,0.8-0.5C162.3,24,163,22,162.5,19.9z M4.4,28.7c-0.2-0.4-0.3-0.9-0.1-1.2c1.8-2.9,3.4-6,6.8-8 c2.8-1.7,5.9-2.9,8.9-4.2c4.3-1.8,9-2.5,13.6-3.4c0,0.1,0,0.2,0,0.2l0,0c-1.1,0.4-2.2,0.7-3.2,1.1c-3.3,1.1-6.5,2.1-9.7,3.4 c-4.2,1.6-7.6,4.2-10.1,7.5c-0.5,0.7-1,1.3-1.6,2c-2.2,2.7-1,4.7,1.2,6.9c0.1,0.1,0.3,0.3,0.4,0.5C7.8,32.5,5.5,31.2,4.4,28.7z  M158.2,23.8c-1.7,2.8-4.1,5.1-7,6.8c-2,1.2-4.5,2.1-6.9,2.9c-3.3,1-6.4,2.4-9.5,3.7c-3.9,1.6-8.1,2.5-12.4,2.9 c-6,0.5-11.8,1.5-17.6,2.5c-4.8,0.8-9.8,1-14.7,1.5c-5.6,0.6-11.2,0.2-16.8,0.1c-3.1-0.1-6.3,0.3-9.4,0.5c-2.6,0.2-5.2,0.1-7.8-0.1 c-3.9-0.3-7.8-0.5-11.7-0.9c-2.8-0.3-5.5-0.7-8.2-1.4c-3.2-0.8-6.3-1.7-9.5-2.5c-0.5-0.1-1-0.3-1.4-0.5c-0.2-0.1-0.4-0.1-0.6-0.2 c0,0,0.1,0,0.1,0c0.3-0.1,0.5,0,0.7,0.1c0,0,0,0,0,0c3.4,0.5,6.9,1.2,10.3,1.4c0.5,0,1,0,1.5,0c0.5,0,1.3,0.2,1.3-0.3 c0-0.6-0.7-0.9-1.4-0.9c-2.1,0-4.2-0.2-6.3-0.5c-4.6-0.7-9.1-1.5-13.4-3c-2.9-1.1-5.4-2.7-6.9-5.2c-0.5-0.8-0.5-1.6-0.1-2.4 c3.2-6.2,9-9.8,16.3-12.2c6.7-2.2,13.2-4.5,20.2-6c5-1.1,10-1.8,15-2.9c8.5-1.9,17.2-2.4,26-2.7c3.6-0.1,7.1-0.8,10.8-0.6 c8.4,0.7,16.7,1.2,25,2.3c4.5,0.6,9,1.2,13.6,1.7c3.6,0.4,7.1,1.4,10.5,2.8c3.1,1.3,6,2.9,8.5,5C159.1,17.7,159.8,21.1,158.2,23.8z"/>
							</svg>
						</span>
						
					</span>
				</h4>
			
		</div> <!-- Row END -->
	</div>
	<!-- Content END -->

<div style="background: #F5F7F9">
    <!-- SVG decoration -->
    <!-- <figure class="position-absolute bottom-0 start-0 d-none d-lg-block">
        <svg width="822.2px" height="301.9px" viewBox="0 0 822.2 301.9">
            <path class="fill-warning" d="M752.5,51.9c-4.5,3.9-8.9,7.8-13.4,11.8c-51.5,45.3-104.8,92.2-171.7,101.4c-39.9,5.5-80.2-3.4-119.2-12.1 c-32.3-7.2-65.6-14.6-98.9-13.9c-66.5,1.3-128.9,35.2-175.7,64.6c-11.9,7.5-23.9,15.3-35.5,22.8c-40.5,26.4-82.5,53.8-128.4,70.7 c-2.1,0.8-4.2,1.5-6.2,2.2L0,301.9c3.3-1.1,6.7-2.3,10.2-3.5c46.1-17,88.1-44.4,128.7-70.9c11.6-7.6,23.6-15.4,35.4-22.8 c46.7-29.3,108.9-63.1,175.1-64.4c33.1-0.6,66.4,6.8,98.6,13.9c39.1,8.7,79.6,17.7,119.7,12.1C634.8,157,688.3,110,740,64.6 c4.5-3.9,9-7.9,13.4-11.8C773.8,35,797,16.4,822.2,1l-0.7-1C796.2,15.4,773,34,752.5,51.9z"/>
        </svg>
    </figure> -->
    
    <!-- SVG decoration -->
    <!-- <figure class="position-absolute bottom-0 start-50 translate-middle-x ms-n9 mb-5">
        <svg width="23px" height="23px">
            <path class="fill-primary" d="M23.003,11.501 C23.003,17.854 17.853,23.003 11.501,23.003 C5.149,23.003 -0.001,17.854 -0.001,11.501 C-0.001,5.149 5.149,-0.000 11.501,-0.000 C17.853,-0.000 23.003,5.149 23.003,11.501 Z"></path>
        </svg>
    </figure> -->

    <!-- SVG decoration -->
    <!-- <figure class="position-absolute bottom-0 end-0 me-5 mb-5">
        <svg width="22px" height="22px">
            <path class="fill-warning" d="M22.003,11.001 C22.003,17.078 17.077,22.003 11.001,22.003 C4.925,22.003 -0.001,17.078 -0.001,11.001 C-0.001,4.925 4.925,-0.000 11.001,-0.000 C17.077,-0.000 22.003,4.925 22.003,11.001 Z"></path>
        </svg>
    </figure> -->

    <!-- SVG decoration -->
    <!-- <figure class="position-absolute bottom-0 end-0 me-1 mb-1">
        <svg width="822.2px" height="301.9px" viewBox="0 0 822.2 301.9" >
            <path class="fill-primary" d="M752.5,51.9c-4.5,3.9-8.9,7.8-13.4,11.8c-51.5,45.3-104.8,92.2-171.7,101.4c-39.9,5.5-80.2-3.4-119.2-12.1 c-32.3-7.2-65.6-14.6-98.9-13.9c-66.5,1.3-128.9,35.2-175.7,64.6c-11.9,7.5-23.9,15.3-35.5,22.8c-40.5,26.4-82.5,53.8-128.4,70.7 c-2.1,0.8-4.2,1.5-6.2,2.2L0,301.9c3.3-1.1,6.7-2.3,10.2-3.5c46.1-17,88.1-44.4,128.7-70.9c11.6-7.6,23.6-15.4,35.4-22.8 c46.7-29.3,108.9-63.1,175.1-64.4c33.1-0.6,66.4,6.8,98.6,13.9c39.1,8.7,79.6,17.7,119.7,12.1C634.8,157,688.3,110,740,64.6 c4.5-3.9,9-7.9,13.4-11.8C773.8,35,797,16.4,822.2,1l-0.7-1C796.2,15.4,773,34,752.5,51.9z"/>
        </svg>
    </figure> -->

<div class="container">

	<!-- Contact form START -->
			<div class="col-md-12">
				<div class="card card-body bg-transparent p-4 p-sm-5 position-relative">
					<?Php 
						if (isset($error_message)) { ?>
							<div class="alert alert-success" role="alert">
							  <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
							</div>
						<?php }	?>
					
					<!-- Form START -->
					<form class="row g-3 position-relative d-flex justify-content-center" action="" method="post" autocomplete="off">
						<!-- Name -->
						<div class="col-md-6 col-lg-12 col-xl-6">
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1" type="text" placeholder="Enter Student ID" name="student_name" autocomplete="off" value="<?php if (isset($student_name)) {
										echo htmlspecialchars($student_name, ENT_QUOTES, 'UTF-8'); 
									} ?>" required>
								</div>
							</div>
						</div>
						
						<!-- Button -->
						<div class="col-md-12 d-flex justify-content-center">
							<button type="submit" class="btn btn-primary mb-0" name="submit">Submit</button>
						</div>
					</form>
					<!-- Form END -->
				</div>
			</div>
</div>
<div class="container zindex-100 desk mt-6" id="content">
		<div class="row d-lg-flex justify-content-lg-between g-4 g-md-5">
		<!-- Left content START -->
			<h5 class="fs-1 fw-bold d-flex justify-content-center text-center">
				<span class="position-relative z-index-9" style="font-size: 30px;">List of captain for "Subject name" </span>
			</h5>

			<div class="col-md-4">
				<div class="alert alert-success fw-bold fs-5">
					<div class="row me-2" style="float: right;">
					<button class="btn btn-sm btn-danger-soft btn-round mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-bs-whatever4=""><i class="fas fa-fw fa-times"></i></button>
					</div>
					<div class="row">
						Captain: rev842
				    </div>
				</div>
			</div>

			<!-- <div class="d-flex justify-content-center">
				<div class="shadow-lg p-3 mb-5 bg-body rounded col-md-4 d-flex justify-content-center fw-bold fs-5 text-danger">Captain: rev842</div>
			</div> -->

		</div>
</div>
</div>



<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="container">
	      <div class="w-100 mt-auto d-inline-flex justify-content-center">
	       <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
				<!-- Avatar -->
				<div class="avatar avatar-sm me-2 rounded-4">
				<img class="avatar-img rounded-1" src="../assets/images/id-card.webp" alt="avatar">
				</div>
				<!-- Avatar info -->
				<div>
				<h6 class="mb-0 text-dark">Student Name - <span class="text-primary st_id"></span></h6>
				</div>
			</div>
	   	  </div>
   
   <form class="row align-items-center justify-content-center" autocomplete="off" action="" method="post">		
		<div class="col-md-6 mt-3">
			<div class="bg-body shadow rounded-pill p-2">
				<div class="input-group">
					<input class="form-control border-0 me-1 st_number" type="number" placeholder="Number to be fetched" name="edit_mobile">
				</div>
			</div>
		</div>

 		<select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="fir">
		  <option>First Language</option>
		  <option value="english">English</option>
		  <option value="kannada">Kannada</option>
		  <option value="hindi">Hindi</option>
		  <option value="sanskrit">Sanskrit</option>
		</select>

		<select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="sec">
		  <option>Second Language</option>
		  <option value="english">English</option>
		  <option value="kannada">Kannada</option>
		  <option value="hindi">Hindi</option>
		  <option value="sanskrit">Sanskrit</option>
		</select>

		<select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="thi">
		  <option>Third Language</option>
		  <option value="english">English</option>
		  <option value="kannada">Kannada</option>
		  <option value="hindi">Hindi</option>
		  <option value="sanskrit">Sanskrit</option>
		</select>
</div>
			<input type="hidden" name="u_id" class="u_id" value="">		
			<button class="btn btn-primary mb-0" name="edit_submit" type="submit">Submit</button>
		
	</form>
        <div class="modal-footer">        	
       		<button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="d-flex justify-content-center">
        <img src="../assets/images/exclamation.webp" alt="exclamation" height="30px" width="30px"><span class="text-danger fw-bold mb-2" style="font-size: 16px;">Are you sure you want to delete</span><img src="../assets/images/exclamation.webp" alt="exclamation" height="30px" width="30px">
        </div>
        <div class="w-100 mt-auto d-inline-flex justify-content-center">
	       <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">	
			<div class="avatar avatar-sm me-2 rounded-4">
				<img class="avatar-img rounded-1" src="../assets/images/id-card.webp" alt="avatar">
			</div>	
			<div>
				<h6 class="mb-0 text-dark">Captain ID - <span class="text-danger delete_id"></span></h6>
			</div>
		   </div>
   		</div>
      </div>
      <div class="modal-footer">
      	<form action="" method="post">
        	<button type="submit" class="btn btn-danger-soft" name="delete">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/functions.js"></script>

<script type="text/javascript">
	 // requires jquery library
	jQuery(document).ready(function() {
	   jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
	 });

	$(".password_no").hide();
	$(".password_field").hide();
	$(".submit_field").hide();

	$(".password_yes").click(function(){
	  $(".password_no").show();
	  $(".password_yes").hide();
	  $(".password_field").show();
	  $(".submit_field").show();
	});

	$(".password_no").click(function(){
	  $(".password_no").hide();
	  $(".password_yes").show();
	  $(".password_field").hide();
	  $(".submit_field").hide();
	});

  function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('tbl_exporttable_to_xls');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fn || ('Student-list.' + (type || 'xlsx')));
  }

  function myFunction() {
      const element = document.getElementById("content");
      element.scrollIntoView();
    }
</script>

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


        const exampleModal = document.getElementById('staticBackdrop1')
			exampleModal.addEventListener('show.bs.modal', event => {
			  // Button that triggered the modal
			  const button = event.relatedTarget
			  // Extract info from data-bs-* attributes
			  const recipient = button.getAttribute('data-bs-whatever-name')
			  const recipient_number = button.getAttribute('data-bs-whatever-number')
			  const recipient_uniq = button.getAttribute('data-bs-whatever-uniqid')
			  
			  const modalTitle = exampleModal.querySelector('.st_id')
			  const modalBodyInput = exampleModal.querySelector('.modal-body input')
			  const modalBodyInputs = exampleModal.querySelector('.modal-body .u_id')

			  modalTitle.textContent = `${recipient}`
			  modalBodyInput.value = recipient_number
			  modalBodyInputs.value = recipient_uniq
			})

		const exampleModal2 = document.getElementById('staticBackdrop2')
			exampleModal2.addEventListener('show.bs.modal', event => {
			  // Button that triggered the modal
			  const button = event.relatedTarget
			  // Extract info from data-bs-* attributes
			  const recipient_name = button.getAttribute('data-bs-whatever-name')
			  
			  const recipient_uniq = button.getAttribute('data-bs-whatever-id')
			  
			  const modalTitle = exampleModal2.querySelector('.delete_id')			 
			  const modalBodyInputs = exampleModal2.querySelector('.modal-footer .input_del_id')

			  modalTitle.textContent = `${recipient_name}`			  
			  modalBodyInputs.value = recipient_uniq
			})        
</script>



