<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<?php 
	if (isset($_COOKIE['aut'])) {
		$auto_login_code = htmlspecialchars($_COOKIE['aut'], ENT_QUOTES, 'UTF-8');
		$fetch_user_auto_login_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_auto_login = '$auto_login_code' AND rev_teach_sts = '1'");

		if (mysqli_num_rows($fetch_user_auto_login_details) > 0) {
			while($j = mysqli_fetch_assoc($fetch_user_auto_login_details)) {
				$user_email = htmlspecialchars($j['rev_teach_email'], ENT_QUOTES, 'UTF-8');
				 $_SESSION['teach_details'] = $user_email;
				 //header("Location: " . BASE_URL . 'pages/action');	
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

<?php 
	$fetch_school_details = mysqli_query($connection, "SELECT * FROM  rev_school_details WHERE rev_school_name = '$user_school'");

	if (mysqli_num_rows($fetch_school_details) > 0) {
		while($tr = mysqli_fetch_assoc($fetch_school_details)) {
			$admin_mobile_number = htmlspecialchars($tr['rev_school_number'], ENT_QUOTES, 'UTF-8');
		}
	}



?>
<?php 
	if (isset($_POST['submit'])) {
		$new = mysqli_escape_string($connection, trim($_POST['chapter_name']));
		$start_date = mysqli_escape_string($connection, trim($_POST['start_date']));
		$end_date = mysqli_escape_string($connection, trim($_POST['finish_date']));
		$selected_mode = mysqli_escape_string($connection, trim($_POST['mode']));
		$file_name = mysqli_escape_string($connection, trim($_POST['plan_img']));

		if ($new == "" || $start_date == "" || $end_date == "" || $selected_mode == "" || $file_name == "") {
			$error_message = "Please enter the chapter name";
		}

		if (!isset($error_message)) {
			$convert_start_date = date('Y-m-d', strtotime($start_date));
			$convert_end_date = date('Y-m-d', strtotime($end_date));
		}

		if (!isset($error_message)) {
			$check_if_already_present = mysqli_query($connection, "SELECT * FROM rev_lesson_planner WHERE rev_lesson_name = '$new' AND rev_lesson_class = '$subject_class_yt' AND rev_lesson_sec = '$subject_teacher_sec' AND rev_teacher_id = '$teacher_email_id' AND rev_lesson_status = '1'");

			if (mysqli_num_rows($check_if_already_present) > 0) {
				$error_message = "Lesson planner already present";
			} else {
				$insert_into = mysqli_query($connection, "INSERT INTO rev_lesson_planner(rev_lesson_name,rev_lesson_img,rev_lesson_class,rev_lesson_sec,rev_teacher_id,rev_lesson_status, rev_paper_mode,rev_start_date,rev_end_date) VALUES ('$new', '$file_name', '$subject_class_yt', '$subject_teacher_sec', '$teacher_email_id', '1', '$selected_mode', '$convert_start_date', '$convert_end_date')");

				if (isset($insert_into)) {
					$success_message = "Success, new lesson planner added"; ?>
					<script type="text/javascript">
					var settings = {
						  "async": true,
						  "crossDomain": true,
						  "url": "https://api.ultramsg.com/instance26587/messages/chat",
						  "method": "POST",
						  "headers": {},
						  "data": {
						    "token": "wq6wqj6ky4or8oy7",
						    "to": "+91<?php echo $admin_mobile_number; ?>",
						    "body": "<?php echo $user_name; ?>, has uploaded a lesson plan for <?php echo $new; ?>"
						}
						}

						$.ajax(settings).done(function (response) {
						  console.log(response);
						});
						</script>
				<?php }
			}			
		}
	}
?>

<?php 
	if (isset($_POST['update'])) {
		$chapter_uniq_id = mysqli_escape_string($connection, trim($_POST['edit_chp_id']));
		$chapter_new_name = mysqli_escape_string($connection, trim($_POST['edit_chp_name']));

		if ($chapter_uniq_id == "" || $chapter_new_name == "") {
			$error_message = "something went wrong, please try again";
		}

		if (!isset($error_message)) {
			$check_if_belongs_to = mysqli_query($connection,"SELECT * FROM  rev_lesson_planner WHERE tree_id = '$chapter_uniq_id' AND rev_lesson_status = '1' AND rev_lesson_class = '$subject_class_yt' AND rev_lesson_sec = '$subject_teacher_sec' AND rev_teacher_id = '$teacher_email_id'");

			if (mysqli_num_rows($check_if_belongs_to) > 0) {
					$update_name = mysqli_query($connection,"UPDATE rev_lesson_planner SET rev_lesson_name = '$chapter_new_name' WHERE tree_id = '$chapter_uniq_id' AND rev_lesson_status = '1'");
					if (isset($update_name)) {
						$success_message = "Success, chapter name updated";
					}
				} else {
					$error_message = "Try again";
				}	
		}
	}
?>

<?php 
	if (isset($_POST['delete'])) {
			$delete_ids = mysqli_escape_string($connection, trim($_POST['del_uniq_id']));
			if ($delete_ids == "") {
				$error_message = "Something went wrong, Please try again";
			}
			if (!isset($error_message)) {
				$check_if_delete_id_belongs_to = mysqli_query($connection,"SELECT * FROM rev_lesson_planner WHERE tree_id = '$delete_ids' AND rev_teacher_id = '$teacher_email_id' AND rev_lesson_class = '$subject_class_yt' AND rev_lesson_sec = '$subject_teacher_sec' AND rev_lesson_status = '1'");
				if (mysqli_num_rows($check_if_delete_id_belongs_to) > 0) {
						$update_chapter_sts = mysqli_query($connection, "UPDATE rev_lesson_planner SET rev_lesson_status = '0' WHERE tree_id = '$delete_ids'");
						if (isset($update_chapter_sts)) {
							$success_message = "Success, chapter deleted";
						}
					} else {
						$error_message = "Sorry, something went wrong";
					}
			}
	}
?>


<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<!-- =======================
Main Banner START -->
<div class="container zindex-100 desk" style="margin-top: 10px">
	<div class="row">
			<div style="float: left;">
					<h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
			</div>
			<div class="d-flex justify-content-end" style="margin-top: -20px">
			<select class="btn btn-sm dropdown-toggle select mb-3 font-base bg-primary bg-opacity-10 text-primary rounded-2 btn-transition" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false" style="font-size: 15px; font-weight: bold;" onchange="javascript:handleSelect(this)">			
				<?php 
					$fetch_teacher_class = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE rev_teach_email_id = '$teacher_email_id' AND rev_teach_sts = '1'");
					if (mysqli_num_rows($fetch_teacher_class) > 0) {
						while($lo = mysqli_fetch_assoc($fetch_teacher_class)) { ?>							
						    <option style="background:#fff; color: #000;" value="<?php echo htmlspecialchars($lo['tree_id'], ENT_QUOTES, 'UTF-8'); ?>" <?php if ($lo['tree_id'] == $class_id) {
						    	echo 'selected';
						    }?>>Grade <?php echo htmlspecialchars($lo['rev_teacher_class'], ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars(ucfirst($lo['rev_teacher_sec']), ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $lo['rev_teach_subject'])), ENT_QUOTES, 'UTF-8'); ?></option>						    
						<?php }	
					}
				?>   
		</select>	    
		</div>
	</div>
</div>


	<!-- Content START -->
	<div class="container zindex-100 desk">
		<div class="row d-lg-flex justify-content-md-center g-md-5">
			<!-- Left content START -->
				<h4 class="fs-1 fw-bold d-flex justify-content-center">
					<img src="<?php echo BASE_URL; ?>assets/images/lesson-planner.svg" width="50px" height="50px" alt="planner">
					<span class="position-relative z-index-9" style="font-size: 33px;">&nbsp;Lesson&nbsp;</span>
					<span class="position-relative z-index-1" style="font-size: 33px;">Planner						
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

<div class="container mt-4">
	<div class="row">
		<div class="col-md-12 d-flex justify-content-center">
				<div class="badge bg-purple bg-opacity-10 text-purple fw-bold btn-transition" data-bs-toggle="modal" data-bs-target="#staticBackdrop_addchap" style="float: left; margin-top: -20px; font-size: 14px; cursor: pointer;"><img src="../assets/images/add_chapters.webp" alt="add" height="30px" width="30px"> Add new lesson planner
				</div>
		</div>
	</div>
</div>

<br><br>

<!-- =======================
Page Banner START -->
	<div class="container mb-4" style="background-image:url(/assets/images/element/map.svg); background-position: center left; background-size: auto; background-repeat: repeat;">
		
		<!-- Contact info box -->
		<div class="row mb-4">
					<?php 
						if (isset($error_message)) { ?>
							<div class="col-md-12 d-flex justify-content-center">
								<div class="col-md-4 d-flex justify-content-center alert alert-danger" role="alert">
									<ul class="feedback d-flex justify-content-center">
										<li class="ok active">
									        <div></div>
									    </li>
									</ul>
									 &nbsp;&nbsp;<span class="mt-2 fw-bold"> <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?> </span>
								</div>
							</div>		
						<?php }
					?>

					<?php 
						if (isset($success_message)) { ?>
							<div class="col-md-12 d-flex justify-content-center">
								<div class="col-md-4 d-flex justify-content-center alert alert-success" role="alert">
									<ul class="feedback">
										<li class="active happy">
									        <div>
									            <svg class="eye left">
									                <use xlink:href="#eye">
									            </svg>
									            <svg class="eye right">
									                <use xlink:href="#eye">
									            </svg>
									        </div>
							    		</li>
									</ul>
									 &nbsp;&nbsp;<span class="mt-2 fw-bold"> <?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?> </span>
								</div>	
							</div>		
						<?php }
					?>

			<!-- Box item -->
			<div class="col-lg-12 mt-lg-0">
				<div class="card card-body bg-transparent shadow text-center h-100">
					<!-- Title -->					
					<div class="row">

						<?php 
							$fetch_chapter_name = mysqli_query($connection,"SELECT * FROM rev_lesson_planner WHERE rev_teacher_id = '$teacher_email_id' AND rev_lesson_status = '1' AND rev_lesson_class = '$subject_class_yt'  AND rev_lesson_sec = '$subject_teacher_sec'");

							if (mysqli_num_rows($fetch_chapter_name) > 0) {
								$i = 1;
								while($rk = mysqli_fetch_assoc($fetch_chapter_name)) { ?>
									<div class="col-sm-4 col-lg-6 col-xl-4 mb-5">
										<div class="card card-body shadow btn-transition" style="border-radius: 100px">
											<div>
												<button href="#" class="btn btn-sm btn-success-soft btn-round me-1 mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop1" data-bs-toggle="modal" data-bs-target="#Edit" data-bs-whatever1="<?php echo htmlspecialchars(ucfirst($rk['tree_id']), ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever="<?php echo htmlspecialchars(ucfirst($rk['rev_lesson_name']), ENT_QUOTES, 'UTF-8'); ?>">
													<i class="far fa-fw fa-edit float-left" style="cursor:pointer">
													</i>
												</button>
											  					            
							        	<button class="btn btn-sm btn-danger-soft btn-round mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-bs-toggle="modal" data-bs-target="#Remove" data-bs-whatever2="<?php echo htmlspecialchars($rk['tree_id'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever3="<?php echo htmlspecialchars(ucfirst($rk['rev_lesson_name']), ENT_QUOTES, 'UTF-8'); ?>">
							        		<i class="fas fa-fw fa-times float-right" style="cursor:pointer">
							        		</i>
							        	</button>

												<div class="icon-lg bg-purple text-white rounded-circle position-absolute top-0 start-100 translate-middle ms-n6">
													<p><?php echo $i++; ?></p>
												</div>
												<a href="<?php echo BASE_URL; ?>pages/lesson_planner_details?id=<?php echo $rk['tree_id']; ?>">
													<p class="text-dark mt-2" style="font-weight: bold; font-size: 18px;"><?php echo htmlspecialchars(ucfirst($rk['rev_lesson_name']), ENT_QUOTES, 'UTF-8'); ?></p>
											  </a>
											</div>
									</div>
								</div>
								<?php }
							} else { ?>
								<div class="col-md-4"></div>
								<div class="col-md-4">
									<div class="alert alert-warning text-center alert-dismissible fade show error_message" role="alert" style="display: inline-flex;">
											<ul class="feedback d-flex justify-content-center">
												<li class="sad active">
											        <div>
											            <svg class="eye left">
											                <use xlink:href="#eye">
											            </svg>
											            <svg class="eye right">
											                <use xlink:href="#eye">
											            </svg>
											            <svg class="mouth">
											                <use xlink:href="#mouth">
											            </svg>
												    </div>
										    	</li>
									  		</ul>
											<div class="mt-2 fw-bold" style="font-size: 14px">&nbsp;&nbsp;No chapters found!</div>
										</div>
								</div>
								<div class="col-md-4"></div>
							<?php }	?>					
				</div>
				</div>
			</div>			
		</div>
	</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
        <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
        <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
    </symbol>
</svg>

<!--Edit Modal -->
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
					<div class="col-md-2">
						<div class="avatar avatar-sm me-2 rounded-4">
							<img class="avatar-img rounded-1" src="../assets/images/Chapter_list.webp" alt="avatar">
						</div>
					</div>
					<!-- Avatar info -->
					<div class="col-md-10">
						<div>
							<h6 class="mb-0 text-dark" style="text-align: justify;">Update chapter name - <span class="text-primary ch_edit_name" style="text-transform: capitalize;">"Fetch chapter name"</span></h6>
						</div>
					</div>
				</div>
		    </div>
	    
		    <form class="row align-items-center justify-content-center" action="" method="post" autocomplete="off">
				<div class="col-md-12 mt-3">
					<div class="bg-body shadow rounded-pill p-2">
						<div class="input-group">
							<input class="form-control border-0 me-1" type="text" placeholder="New name" required name="edit_chp_name" autocomplete="off">
							<input class="form-control border-0 me-1 id" type="hidden" placeholder="New nam" required name="edit_chp_id">
						</div>
					</div>
				</div>
			
			<div class="col-md-12 d-flex justify-content-center mb-2 mt-4">
				<button class="btn btn-primary mb-0 submit_field" type="submit" name="update">Submit</button>
			</div>
			
		  </form>
		</div>
        <!-- <div class="modal-footer">
	        <button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
</div>

<!--Remove Modal -->
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

	        		<div class="col-md-2">				
						<div class="avatar avatar-sm me-2 rounded-4">
							<img class="avatar-img rounded-1" src="../assets/images/Chapter_list.webp" alt="avatar">
						</div>
					</div>

					<!-- Avatar info -->
					<div class="col-md-10">
						<div>
							<h6 class="mb-0 text-dark"><span class="ch_delete_name"></span> - <span class="text-danger">All the associated data will be deleted</span></h6>
						</div>
					</div>
	    	</div>
      </div>
      <div class="modal-footer">
      	<form action="" method="post">
      		<input type="hidden" name="del_uniq_id" class="del_uniq_id" value="">
        	<button type="submit" class="btn btn-danger-soft" name="delete">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<!--Add new chapter Modal -->
<div class="modal fade" id="staticBackdrop_addchap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
						<img class="avatar-img rounded-1" src="../assets/images/Chapter_list.webp" alt="avatar">
					</div>
					<!-- Avatar info -->
					<div>
						<h6 class="mb-0 text-dark"><span class="text-primary">Add new lesson planner</span></h6>
					</div>
				</div>
		    </div>	    
		    <form class="row align-items-center justify-content-center" action="" method="post" autocomplete="off">
					<div class="col-md-12 mt-3">
						<label class="control-label" for="textinput">
			                <h6 class="text-purple fw-bold">Chapter name</h6>
			            </label>
						<div class="bg-body shadow rounded-pill p-2 mb-2">
							<div class="input-group">
								<input class="form-control border-0 me-1" type="text" name="chapter_name" required autocomplete="off">
							</div>							
						</div>

						<label class="control-label" for="textinput">
				                <h6 class="text-purple fw-bold">Start date</h6>
				        </label>
						<div class="bg-body shadow rounded-pill p-2 mb-2">
							<div class="input-group">
								<input class="form-control border-0 me-1" type="date" name="start_date" required autocomplete="off">
							</div>
						</div>

						<label class="control-label" for="textinput">
			                <h6 class="text-purple fw-bold">Finish date</h6>
			            </label>
						<div class="bg-body shadow rounded-pill p-2 mb-2">
							<div class="input-group">
								<input class="form-control border-0 me-1" type="date" name="finish_date" required autocomplete="off">
							</div>
						</div>

						<br>
						<p class="text-center h5">Select Mode</p>
						<div class="text-center">
							<small style="color:red;">Do not attach multiple PDF</small><br>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="mode" id="inlineRadio1" value="pdf">
							  <label class="form-check-label" for="inlineRadio1">PDF</label>
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="mode" id="inlineRadio2" value="image">
							  <label class="form-check-label" for="inlineRadio2">Image</label>
							</div>	
						</div>	

						<div class="text-center image">
							<input type="hidden" role="uploadcare-uploader" data-public-key="cbdac181dd6cc9f7ab5b"
    						data-tabs="file camera" name="plan_img" data-multiple="true"/>
    					</div>				
					</div>				
				<div class="col-md-12 d-flex justify-content-center mb-2 mt-4">
					<button class="btn btn-primary mb-0 submit_field" type="submit" name="submit">Submit</button>
				</div>			
		  </form>
		</div>
        <!-- <div class="modal-footer">
	        <button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
</div>



<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<script type="text/javascript">
	const exampleModal = document.getElementById('staticBackdrop1')
				exampleModal.addEventListener('show.bs.modal', event => {
				  // Button that triggered the modal
				  const button = event.relatedTarget
				  // Extract info from data-bs-* attributes
				  const recipient = button.getAttribute('data-bs-whatever')
				  const recipient_id = button.getAttribute('data-bs-whatever1')
				  // If necessary, you could initiate an AJAX request here
				  // and then do the updating in a callback.
				  //
				  // Update the modal's content.
				  const modalTitle = exampleModal.querySelector('.ch_edit_name')
				  const modalBodyInput = exampleModal.querySelector('.modal-body .id')


				  modalTitle.textContent = `${recipient}`
				  modalBodyInput.value = recipient_id
				})

	const exampleModals = document.getElementById('staticBackdrop2')
				exampleModals.addEventListener('show.bs.modal', event => {
				  // Button that triggered the modal
				  const button = event.relatedTarget
				  // Extract info from data-bs-* attributes
				  const recipient_name = button.getAttribute('data-bs-whatever3')
				  const recipient_id_name = button.getAttribute('data-bs-whatever2')
				  // If necessary, you could initiate an AJAX request here
				  // and then do the updating in a callback.
				  //
				  // Update the modal's content.
				  const modalTitles = exampleModals.querySelector('.ch_delete_name')
				  const modalBodyInputs = exampleModals.querySelector('.modal-footer .del_uniq_id')


				  modalTitles.textContent = `${recipient_name}`
				  modalBodyInputs.value = recipient_id_name
				})
</script>

<script type="text/javascript">
    const picker = MCDatepicker.create({
        el: '#datepickers',                     
        minDate: new Date()
    });
    $('#timepicker').mdtimepicker(); //Initializes the time picker
</script>