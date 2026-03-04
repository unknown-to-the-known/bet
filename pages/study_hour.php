<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
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
            $user_school = htmlspecialchars($i['rev_teach_school'], ENT_QUOTES, 'UTF-8');
            
         }  
    }

    $date_of_uplading = date('Y-m-d H:i:s a');
    $uniq_url_of_uploading = $date_of_uplading . '_' . $teacher_email_id;
    $uniq_identifier = md5($uniq_url_of_uploading); 

    if (isset($_GET['param'])) {
        if ($_GET['param'] != "") {
            $class_id = htmlspecialchars($_GET['param'], ENT_QUOTES, 'UTF-8');
            $fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE tree_id = '$class_id' AND rev_teach_sts = '1'");

            if (mysqli_num_rows($fetch_teacher_subject) > 0) {
                while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
                    $subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
                    $subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
                    $class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
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
                $class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');      
        }
        }
    }       
?>

<?php 
	if (isset($_POST['submit'])) {
		$date = mysqli_escape_string($connection, trim($_POST['date']));
		$topic = mysqli_escape_string($connection, trim($_POST['study_hour_name']));
		if ($date == "" || $topic == "") {
			$error_message = "Please fill all fields";
		}
		if (!isset($error_message)) {
			$convert_submit_date = date('Y-m-d', strtotime($date));
			$check_if_already_present = mysqli_query($connection, "SELECT * FROM rev_study_hour WHERE rev_study_teacher_id = '$teacher_email_id' AND rev_study_class = '$subject_class_yt' AND rev_study_sec = '$class_sec' AND rev_study_sts = '1' AND rev_study_date = '$convert_submit_date'");

			if (mysqli_num_rows($check_if_already_present) > 0) {
				$error_message = "Study hour already present";
			} else {
				$insert = mysqli_query($connection, "INSERT INTO rev_study_hour(rev_study_name,rev_study_date,	rev_study_sts,rev_study_teacher_id,rev_study_class,rev_study_sec,rev_study_subject) VALUES ('$topic', '$convert_submit_date', '1', '$teacher_email_id', '$subject_class_yt', '$class_sec', '$subject_name_yt')");
				if (isset($insert)) {
					$error_message = "Success, Study hour added";
				}
			}
		}
	}
?>

<?php 
	if (isset($_POST['edit'])) {
		$edit_name = mysqli_escape_string($connection, trim($_POST['name']));
		$edit_date = mysqli_escape_string($connection, trim($_POST['date_up']));
		$edit_uniq_id = mysqli_escape_string($connection, trim($_POST['edit_id']));

		if ($edit_name == "" || $edit_date == "" || $edit_uniq_id == "") {
			$error_message = "Please fill all the fields";	
		}	

		if (!isset($error_message)) {
			$conveert_date = date('Y-m-d', strtotime($edit_date));
			$check_if_there_is_a_crash = mysqli_query($connection, "SELECT * FROM rev_study_hour WHERE rev_study_date = '$conveert_date' AND rev_study_sts = '1' AND rev_study_subject = '$subject_name_yt' AND rev_study_class = '$subject_class_yt' AND rev_study_sec = '$class_sec'");

			if (mysqli_num_rows($check_if_there_is_a_crash) > 0) {
				$error_message = "Study hour already present";
			}
		}

		if (!isset($error_message)) {			
			$check_study_hour_belongs_to = mysqli_query($connection, "SELECT * FROM rev_study_hour WHERE tree_id = '$edit_uniq_id' AND rev_study_sts = '1'");
			if (mysqli_num_rows($check_study_hour_belongs_to) > 0) {
				$update = mysqli_query($connection, "UPDATE rev_study_hour SET rev_study_name = '$edit_name', rev_study_date = '$edit_date' WHERE tree_id = '$edit_uniq_id'");
				if (isset($update)) {
					$error_message = "Success, Data Updated";		
				}	
			} else {
				$error_message = "Sorry something went wrong";
			}
		}
	}
?>

<?php 
	if (isset($_POST['delete'])) {
		$delete_ids = mysqli_escape_string($connection, trim($_POST['delete_id']));

		if ($delete_ids == "") {
			$error_message = "Something went wrong";
		}

		if (!isset($error_message)) {
			$delete_check_id = mysqli_query($connection, "SELECT * FROM rev_study_hour WHERE tree_id = '$delete_ids' AND rev_study_teacher_id = '$teacher_email_id' AND rev_study_sts = '1'");

			if (mysqli_num_rows($delete_check_id) > 0) {
				$update_sts = mysqli_query($connection, "UPDATE rev_study_hour SET rev_study_sts = '0' WHERE tree_id = '$delete_ids'");
				if (isset($update_sts)) {
					$error_message = "Deleted successfully";
				}
			}
		}
	}
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<link rel="stylesheet" type="text/css" href="../includes/time_picker.css">
<!-- =======================
Main Banner START -->
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

<style type="text/css">
		.table-scroll th, .table-scroll td {
			border:1px solid #0CBC87;
		}
</style>


	<!-- Content START -->
	<div class="container zindex-100 desk">
		<div class="row d-lg-flex justify-content-md-center g-md-5">
			<!-- Left content START -->
				<h4 class="fs-1 fw-bold d-flex justify-content-center">
					<img src="<?php echo BASE_URL; ?>assets/images/Study_hour.webp" width="50px" height="50px" alt="books">
					<span class="position-relative z-index-9" style="font-size: 33px;">&nbsp;Create&nbsp;</span>
					<span class="position-relative z-index-1" style="font-size: 33px;">study hour
						
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

<div class="container">
	<div class="row">
		<div class="col-md-12 mt-4">
			<a href="captain.php">
				<div class="badge bg-danger bg-opacity-10 text-danger mb-4 fw-bold btn-transition" style="float: right; margin-top: -20px; font-size: 12px; cursor: pointer;"><img src="../assets/images/captain.webp" alt="add" height="30px" width="30px"> Create captain
				</div>
			</a>			
		</div>
	</div>

	<!-- Contact form START -->
			<div class="col-md-12">
				<div class="card card-body shadow p-4 p-sm-5 position-relative">	

					<?php 
						if (isset($error_message)) { ?>
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
									 &nbsp;&nbsp;<span class="mt-2 fw-bold"> <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?> </span>
								</div>	
							</div>		
						<?php }
					?>

					<form class="row g-3 position-relative" action="" method="post" autocomplete="off">
						<!-- Study hour Name -->
						<div class="col-md-6 col-lg-12 col-xl-6">
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1" type="text" placeholder="Study hour date*" name="date"  id="datepickers" autocomplete="off" required>
									<p style="font-size: 20px;">🗓️</p>
								</div>
							</div>
						</div>

						<!-- Name -->
						<div class="col-md-6 col-lg-12 col-xl-6">
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1" type="text" placeholder="Topic of the study hour*" autocomplete="off" name="study_hour_name" required>
									<p style="font-size: 20px;"><img>📚</p>
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

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
        <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
        <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
    </symbol>
</svg>

<div class="container">
	<h3 class="mt-5 mb-4 text-center">Study hour List</h3>
	<div id="table-scroll" class="table-scroll">
	  <div class="table-wrap">
	    <table class="main-table">
	      <thead>
	        <tr class="table_header text-center">
	          <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">#</span></th>
	          <th class="fixed-side border-0" style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Study hour name</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Subject</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Date</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Action</span></th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php 
	      		$fetch_active_study_hour = mysqli_query($connection, "SELECT * FROM rev_study_hour WHERE rev_study_teacher_id = '$teacher_email_id' AND rev_study_sts = '1' AND rev_study_subject = '$subject_name_yt' AND rev_study_class = '$subject_class_yt' AND rev_study_sec = '$class_sec'");

	      		if (mysqli_num_rows($fetch_active_study_hour) > 0) {
	      			$k = 1;
	      			while($kj = mysqli_fetch_assoc($fetch_active_study_hour)) { ?>
	      				<tr class="text-center" style="font-size: 18px">
				          <th class="fixed-side"><?php echo $k++; ?></th>
				          <th class="fixed-side" style="text-align: left; word-wrap: break-word; white-space: normal !important;"><img src="<?php echo BASE_URL; ?>assets/images/books.webp" width="25px" height="25px" alt="books">&nbsp;<?php echo htmlspecialchars($kj['rev_study_name'], ENT_QUOTES, 'UTF-8'); ?></th>
				          <td><?php echo htmlspecialchars(ucfirst($subject_name_yt), ENT_QUOTES, 'UTF-8'); ?></td>
				          <td style="word-wrap: break-word; white-space: normal !important;"><img src="<?php echo BASE_URL; ?>assets/images/calendar.webp" width="20px" height="20px" alt="Calendar">&nbsp;<?php echo htmlspecialchars(date('d-M-Y', strtotime($kj['rev_study_date'])), ENT_QUOTES, 'UTF-8'); ?></td>
				          <td>
							<button href="#" class="btn btn-sm btn-success-soft btn-round me-1 mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop1" data-bs-whatever-name="<?php echo htmlspecialchars($kj['rev_study_name'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever-id="<?php echo htmlspecialchars($kj['tree_id'], ENT_QUOTES, 'UTF-8'); ?>"><i class="far fa-fw fa-edit"></i></button>
							<button class="btn btn-sm btn-danger-soft btn-round mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-bs-whatever-name_id="<?php echo htmlspecialchars($kj['rev_study_name'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever-delete-id="<?php echo htmlspecialchars($kj['tree_id'], ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-fw fa-times"></i></button>
						  </td>				          
				        </tr>
	      			<?php }
	      		}
	      	?>
	      </tbody>
	    </table>
	  </div>
	</div>
</div>
<br><br>
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
					<div class="avatar avatar-sm me-2 rounded-4">
						<img class="avatar-img rounded-1" src="../assets/images/books.webp" alt="avatar">
					</div>
					<!-- Avatar info -->
					<div>
						<h6 class="mb-0 text-dark">Update study hour details of <span class="text-primary study_name" >"Fetch study hour name"</span></h6>
					</div>
				</div>
		    </div>
	    
	    		<form class="row g-3 position-relative" action="" method="post">
					<!-- Topic -->
					<div class="col-md-6 col-lg-12 col-xl-6">
						<div class="bg-body shadow rounded-pill p-2">
							<div class="input-group">
								<input class="form-control border-0 me-1" type="text" placeholder="Study hour topic name*" name="name" required>
							</div>
						</div>
					</div>
					<!-- Date -->
					<div class="col-md-6 col-lg-12 col-xl-6">
						<div class="bg-body shadow rounded-pill p-2">
							<div class="input-group">
                  				<input type="date" class="form-control border-0 me-1 hm_da" placeholder="Date*" name="date_up" id="datepickers_t" min="<?php echo date('Y-m-d'); ?>"/>
                  				<input type="hidden" name="edit_id" class="edit_id_name">
							</div>
						</div>
					</div>
					<!-- Button -->
					<div class="col-md-12 mb-4 d-flex justify-content-center">
						<button type="submit" class="btn btn-primary mb-0" name="edit">Submit</button>
					</div>
				</form>
		</div>
        <div class="modal-footer">
	        <button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div>
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
				<!-- Avatar -->
				<div class="avatar avatar-sm me-2 rounded-4">
					<img class="avatar-img rounded-1" src="../assets/images/books.webp" alt="avatar">
				</div>
				<!-- Avatar info -->
				<div>
					<h6 class="mb-0 text-dark">Study hour - <span class="text-danger">Study hour name</span></h6>
				</div>
			</div>
	    </div>
      </div>
      <div class="modal-footer">
      	<form action="" method="post">
      		<input type="hidden" name="delete_id" class="delete_id_name" value="">
        	<button type="submit" class="btn btn-danger" name="delete">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    const picker = MCDatepicker.create({
        el: '#datepickers',                     
        minDate: new Date()
    });
    // $('#timepicker').mdtimepicker(); //Initializes the time picker
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="../includes/time_picker.js"></script>
<script type="text/javascript">
    $('#timepicker').mdtimepicker(); //Initializes the time picker
    $('#timepicker_2').mdtimepicker(); //Initializes the time picker
    $('#timepicker3').mdtimepicker(); //Initializes the time picker
	$('#timepicker4').mdtimepicker(); //Initializes the time picker

	const exampleModal = document.getElementById('staticBackdrop1')
		exampleModal.addEventListener('show.bs.modal', event => {
		  // Button that triggered the modal
		  const button = event.relatedTarget
		  // Extract info from data-bs-* attributes
		  const recipient = button.getAttribute('data-bs-whatever-name')
		  const recipient_id = button.getAttribute('data-bs-whatever-id')		  
		  const modalTitle = exampleModal.querySelector('.modal-body h6 .study_name')
		  const modalBodyInput = exampleModal.querySelector('.modal-body .edit_id_name')
		  modalTitle.textContent = `${recipient}`
		  modalBodyInput.value = recipient_id
		})


	// Delete Id

	const exampleModals = document.getElementById('staticBackdrop2')
	exampleModals.addEventListener('show.bs.modal', event => {
	  
	  const buttons = event.relatedTarget
	  
	  const recipients = buttons.getAttribute('data-bs-whatever-delete-id')
	  
	  const modalTitles = exampleModals.querySelector('.modal-title')
	  const modalBodyInputs = exampleModals.querySelector('.modal-footer .delete_id_name')

	   // modalTitles.textContent = `New message to ${recipients}`
	  modalBodyInputs.value = recipients
	})

</script>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>