<!-- generate_report1 - new table with active anchor tag -->

<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
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
			$fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE tree_id = '$class_id' AND rev_teach_sts = '1' AND rev_teach_email_id = '$teacher_email_id'");
			if (mysqli_num_rows($fetch_teacher_subject) > 0) {
				while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
					$subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
					$subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
					$class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
				}
			} else {
				$fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE rev_teach_sts = '1' AND rev_teach_email_id = '$teacher_email_id'");
				if (mysqli_num_rows($fetch_teacher_subject) > 0) {
					while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
						$subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
						$subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
						$class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
						$class_id = htmlspecialchars($l['tree_id'], ENT_QUOTES, 'UTF-8');
					}
					 header("Location: " . BASE_URL . 'pages/generate_report?param=' . $class_id);
				}
			}
		} else {
			 $fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE  rev_teach_sts = '1' AND rev_teach_email_id = '$teacher_email_id'");
			if (mysqli_num_rows($fetch_teacher_subject) > 0) {
				while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
					$subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
					$subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
					$class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
					$class_id = htmlspecialchars($l['tree_id'], ENT_QUOTES, 'UTF-8');
				}
			}
		}
	} else {
		$fetch_teacher_subject = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE  rev_teach_sts = '1' AND rev_teach_email_id = '$teacher_email_id'");
			if (mysqli_num_rows($fetch_teacher_subject) > 0) {
				while($l = mysqli_fetch_assoc($fetch_teacher_subject)) {
					$subject_name_yt = htmlspecialchars($l['rev_teach_subject'], ENT_QUOTES, 'UTF-8');
					$subject_class_yt = htmlspecialchars($l['rev_teacher_class'], ENT_QUOTES, 'UTF-8');
					$class_sec = htmlspecialchars($l['rev_teacher_sec'], ENT_QUOTES, 'UTF-8');
					$class_id = htmlspecialchars($l['tree_id'], ENT_QUOTES, 'UTF-8');
				}
				 header("Location: " . BASE_URL . 'pages/generate_report?param=' . $class_id);
			}
	}		
?>

<?php 
	$date_of_uplading = date('Y-m-d');
?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<style type="text/css">
	html{
		scroll-behavior: smooth;
	}
	.text_highlight:target {
    background-color: #ffa;
    -webkit-transition: all 1s linear;
    }
    .watermark {
    position: absolute;
    color: lightgray;
    opacity: 0.19;
    font-size: 3em;
    width: 100%;
/*    right: 5%;*/
    top: 8%;    
    text-align: center;
    z-index: 0;
		}
</style>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<style type="text/css">
        .share-button {
          position:fixed;
          width:60px;
          height:60px;
          bottom:40px;
          right:80px;
          background-color:#fff;
          color:#FFF;
          border-radius:50px;
          text-align:center;
                font-size:30px;
          box-shadow: 2px 2px 3px #999;
                z-index:100;
          cursor: pointer;
        }

        
        @media screen and (max-width: 767px){
            .share-button {
                width: 40px;
                height: 40px;
                bottom: 18px;
                font-size: 22px;
                right: 10px;
            }
        }
</style>

<style>
/*      @import url("https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,700;1,200&display=swap");*/

	.table_scroll1 {
	/*  font-family: "Fraunces", serif;*/
	  font-size: 125%;
	  white-space: nowrap;
	  margin: 0;
	  border: none;
	  border-collapse: separate;
	  border-spacing: 0;
	  table-layout: fixed;
	  border: 1px solid #fff;
	  /*overflow-x: scroll;
	        overflow-y: visible;*/
	  /*width: 100%;
	  height: 50%;*/
	}
	.table_scroll1 td{
		border: 1px solid #066AC9;
	  padding: 0.5rem 1rem;
	}
	.table_scroll1 th {
	  border: 1px solid #fff;
	  padding: 0.5rem 1rem;
	}
	.table_scroll1 thead th {
	  padding: 3px;
	  position: sticky;
	  top: 0;
	  z-index: 1;
	  width: 25vw;
	  background: white;
	}
	.table_scroll1 td {
	  background: #fff;
	  padding: 4px 5px;
	  text-align: center;
	}

	.table_scroll1 tbody th {
	  font-weight: 100;
	/*  font-style: italic;*/
	  font-weight: bold;
	  text-align: left;
	  position: relative;
	}
	.table_scroll1 thead th:first-child {
	  position: sticky;
	  left: 0;
	  z-index: 2;
	}
	.table_scroll1 tbody th {
	  position: sticky;
	  left: 0;
	  color: #fff;
	  background:#0cbc87;
	  z-index: 1;
	}

	[role="region1"][aria-labelledby][tabindex] {
	  width: 100%;
	  max-height: 98vh;
	  overflow: auto;
	}
	[role="region1"][aria-labelledby][tabindex]:focus {
	  box-shadow: 0 0 0.5em rgba(0, 0, 0, 0.5);
	  outline: 0;
	}
</style>

<style type="text/css">
	::-webkit-scrollbar{
    height: 5px;
    width: 5px;
    background: gray;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

::-webkit-scrollbar-thumb:horizontal{
    background: gray;
    border-radius: 10px;
}
</style>

<div class="container zindex-100 desk" style="margin-top: 10px">

	<img class="share-button" src="../assets/images/share_1.svg" alt="share">

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
						    }?>>Grade <?php echo htmlspecialchars($lo['rev_teacher_class'], ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars(ucfirst($lo['rev_teacher_sec']), ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars(ucfirst($lo['rev_teach_subject']), ENT_QUOTES, 'UTF-8'); ?></option>						    
						<?php }	
					}
				?>   
			</select>	    
		</div>
  </div>
</div>

<!-- =======================
Main Banner START -->

	<!-- Content START -->
	<div class="container">
		<div class="row d-lg-flex justify-content-lg-between">

					<div class="col-md-8 position-relative text-center">
				<!-- Title -->

				<!-- Outer tabs START -->
				<h4 class="mb-4 text-primary text-center">
					<img src="../assets/images/report.webp" height="35px" width="35px" alt="report">&nbsp;&nbsp;Generate Report
			     </h4>
					<ul class="nav nav-pills nav-pill-soft mb-3 d-flex justify-content-center" id="course-pills-tab" role="tablist">
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link active" id="course-pills-tab-6" data-bs-toggle="tab" data-bs-target="#course-pills-tab6" type="button" role="tab" aria-controls="course-pills-tab6" aria-selected="true">Today</button>
						</li>
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link" id="course-pills-tab-7" data-bs-toggle="tab" data-bs-target="#course-pills-tab7" type="button" role="tab" aria-controls="course-pills-tab7" aria-selected="false">Yesterday</button>
						</li>
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link" id="course-pills-tab-8" data-bs-toggle="tab" data-bs-target="#course-pills-tab8" type="button" role="tab" aria-controls="course-pills-tab8" aria-selected="false">Last 7 days</button>
						</li>
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link" id="course-pills-tab-9" data-bs-toggle="tab" data-bs-target="#course-pills-tab9" type="button" role="tab" aria-controls="course-pills-tab9" aria-selected="false">Last 30 days</button>
						</li>
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link" id="course-pills-tab-10" data-bs-toggle="tab" data-bs-target="#course-pills-tab10" type="button" role="tab" aria-controls="course-pills-tab10" aria-selected="false">Custom</button>
						</li>
					</ul> 

			<!-- Outer tabs contents START -->
			<div class="tab-content mb-0" id="course-pills-tabContent">
			<!-- Outer tabs END -->
			<div class="tab-pane fade show active" id="course-pills-tab6" role="tabpanel" aria-labelledby="course-pills-tab-6">
				<div class="row">
					<div class="col-lg-8"></div>
					<div class="col-lg-4 d-flex justify-content-end">
						<div class="badge bg-danger bg-opacity-10 text-danger mb-4 fw-bold btn-transition" onclick="generatePDF()" style="float: right; margin-top: -20px; font-size: 12px; cursor: pointer;"><img src="../assets/images/pdf_file.svg" alt="export_pdf" height="30px" width="30px"> Download PDF</div>
					</div>
				</div>

				<form class="bg-body shadow rounded p-2">
							<div class="input-group">
								<input class="form-control border-0 me-1 se_today" type="search" placeholder="Search student name...">
								<button type="button" class="btn btn-primary mb-0 rounded z-index-1"><i class="fas fa-search"></i></button>
							</div>
							<div class="search_result"></div>
				</form>
				<div id="divToExport">
				<div class="row">
					
					<!-- Left content START -->
					<div class="col-lg-12">
						<!-- Title -->
						<h4>Report for the date</h4>
						<!-- Fetch today's date here -->
						<h5 class="text-success fw-bold"><?php echo date('d-M-Y', strtotime($date_of_uplading)); ?></h5>
						
					</div>
				</div> <!-- Row END -->
				<!-- Today report -->

				<?php 
					$today_date = date('Y-m-d');
					$fetch_test_today_report = mysqli_query($connection, "SELECT * FROM rev_test WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$today_date' AND '$today_date' AND rev_hw_sts = '1'");

					$count_for_test_today = mysqli_num_rows($fetch_test_today_report);


					$fetch_hw_today_report = mysqli_query($connection, "SELECT * FROM rev_homework WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$today_date' AND '$today_date' AND rev_hw_sts = '1'");

					$count_for_hw_today = mysqli_num_rows($fetch_hw_today_report);

					$fetch_mcq_today_report = mysqli_query($connection,"SELECT * FROM rev_mcq_name WHERE mcq_class = '$subject_class_yt' AND mcq_sec = '$class_sec' AND mcq_school = '$user_school' AND mcq_date BETWEEN '$today_date' AND '$today_date' AND mcq_sts = '1'");

					$count_for_mcq_today = mysqli_num_rows($fetch_mcq_today_report);
				?>				

<div class="row">
    <div class="col-md-12">
            <div role="region1" aria-labelledby="caption" tabindex="0">
    <table class="table_scroll1">
        <!-- <caption id="caption">Baseball numbers mmkay.</caption> -->
        <thead>
            <tr class="text-center">
            	  <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</span></th>
                <!-- <th>Teams</th> -->
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Video Streamed</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Test (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Homework (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;MCQ (5)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;LSRW (6)</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
<tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
        </tbody>
    </table>
</div>
     </div>


			</div>
					</div>
			</div>

			<!-- Today report ended -->


			<!-- Yesterday report -->

			<div class="tab-pane fade" id="course-pills-tab7" role="tabpanel" aria-labelledby="course-pills-tab-7">
				<div class="row">
					<!-- Left content START -->
					<div class="col-lg-12">
						<!-- Title -->
						<h4>Report for the date</h4>
						<!-- Fetch today's date here -->
						<h5 class="text-success fw-bold"><?php echo date('d-M-Y', strtotime('-1 day')); ?></h5>
						<form class="bg-body shadow rounded p-2">
							<div class="input-group">
								<input class="form-control border-0 me-1" type="search" placeholder="Search student name...">
								<button type="button" class="btn btn-primary mb-0 rounded z-index-1"><i class="fas fa-search"></i></button>
							</div>
							<div class="search_result_yesterday"></div>
						</form>
					</div>

				</div> <!-- Row END -->

				<?php 
					$yesterday_date = date('Y-m-d', strtotime('yesterday'));
					$fetch_test_yesterday_report = mysqli_query($connection, "SELECT * FROM rev_test WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$yesterday_date' AND '$yesterday_date' AND rev_hw_sts = '1'");

					$count_for_test_yesterday = mysqli_num_rows($fetch_test_yesterday_report);


					$fetch_hw_yesterdy_report = mysqli_query($connection, "SELECT * FROM rev_homework WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$yesterdy_date' AND '$yesterdy_date' AND rev_hw_sts = '1'");

					$count_for_hw_yesterday = mysqli_num_rows($fetch_hw_yesterdy_report);

					$fetch_mcq_yesterday_report = mysqli_query($connection,"SELECT * FROM rev_mcq_name WHERE mcq_class = '$subject_class_yt' AND mcq_sec = '$class_sec' AND mcq_school = '$user_school' AND mcq_date BETWEEN '$yesterday_date' AND '$yesterday_date' AND mcq_sts = '1'");

					$count_for_mcq_yesterday = mysqli_num_rows($fetch_mcq_yesterday_report);
				?>

				<div class="row">
          <div class="col-md-12">
            <div role="region1" aria-labelledby="caption" tabindex="0">
    <table class="table_scroll1">
        <!-- <caption id="caption">Baseball numbers mmkay.</caption> -->
        <thead>
            <tr class="text-center">
            	  <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</span></th>
                <!-- <th>Teams</th> -->
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Video Streamed</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Test (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Homework (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;MCQ (5)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;LSRW (6)</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
        </tbody>
    </table>
</div>
     </div>


			</div>
			</div>

			<!-- Yesterday ended -->

			<!-- Last 7 days -->
			<?php 
				$last_7_days = date('Y-m-d', strtotime('-7 day'));
					$fetch_test_last7days_report = mysqli_query($connection, "SELECT * FROM rev_test WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$yesterday_date' AND '$today_date' AND rev_hw_sts = '1'");

					$count_for_test_last_7_days = mysqli_num_rows($fetch_test_last7days_report);


					$fetch_hw_last7days_report = mysqli_query($connection, "SELECT * FROM rev_homework WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$yesterdy_date' AND 'today_date' AND rev_hw_sts = '1'");

					$count_for_hw_last_7_days = mysqli_num_rows($fetch_test_last7days_report);

					$fetch_mcq_last7days_report = mysqli_query($connection,"SELECT * FROM rev_mcq_name WHERE mcq_class = '$subject_class_yt' AND mcq_sec = '$class_sec' AND mcq_school = '$user_school' AND mcq_date BETWEEN '$yesterday_date' AND '$today_date' AND mcq_sts = '1'");

					$count_for_mcq_last_7_days = mysqli_num_rows($fetch_mcq_last7days_report);
				?>

			<div class="tab-pane fade" id="course-pills-tab8" role="tabpanel" aria-labelledby="course-pills-tab-8">
				<div class="row">
					<!-- Left content START -->
					<div class="col-lg-12">
						<!-- Title -->
						<h4>Report for the date</h4>						
						
						<h5 class="text-success fw-bold"><?php echo date('d-M-Y', strtotime($last_7_days)); ?> To <?php echo date('d-M-Y', strtotime($today_date)); ?></h5>
						<form class="bg-body shadow rounded p-2">
							<div class="input-group">
								<input class="form-control border-0 me-1" type="search" placeholder="Search student name...">
								<button type="button" class="btn btn-primary mb-0 rounded z-index-1"><i class="fas fa-search"></i></button>
							</div>
							<div class="search_result_7_days"></div>
						</form>
					</div>

				</div> <!-- Row END -->

				<div class="row">
          <div class="col-md-12">
            <div role="region1" aria-labelledby="caption" tabindex="0">
    <table class="table_scroll1">
        <!-- <caption id="caption">Baseball numbers mmkay.</caption> -->
        <thead>
            <tr class="text-center">
            	  <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</span></th>
                <!-- <th>Teams</th> -->
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Video Streamed</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Test (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Homework (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;MCQ (5)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;LSRW (6)</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
        </tbody>
    </table>
</div>
     </div>


			</div>
			</div>
<!-- Last 7 days ended -->

<!-- Last 30 days -->
			<?php 
				$last_30_days = date('Y-m-d', strtotime('-30 day'));
					$fetch_test_last30days_report = mysqli_query($connection, "SELECT * FROM rev_test WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$last_30_date' AND '$today_date' AND rev_hw_sts = '1'");

					$count_for_test_last_30_days = mysqli_num_rows($fetch_test_last30days_report);


					$fetch_hw_last30days_report = mysqli_query($connection, "SELECT * FROM rev_homework WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$last_30_date' AND 'today_date' AND rev_hw_sts = '1'");

					$count_for_hw_last_30_days = mysqli_num_rows($fetch_test_last30days_report);

					$fetch_mcq_last30days_report = mysqli_query($connection,"SELECT * FROM rev_mcq_name WHERE mcq_class = '$subject_class_yt' AND mcq_sec = '$class_sec' AND mcq_school = '$user_school' AND mcq_date BETWEEN '$last_30_date' AND '$today_date' AND mcq_sts = '1'");

					$count_for_mcq_last_30_days = mysqli_num_rows($fetch_mcq_last30days_report);
				?>

			<div class="tab-pane fade" id="course-pills-tab9" role="tabpanel" aria-labelledby="course-pills-tab-9">
				<div class="row">
					<!-- Left content START -->
					<div class="col-lg-12">
						<!-- Title -->
						
						<h4>Report for the date</h4>
						<!-- Fetch today's date here -->
						<h5 class="text-success fw-bold"><?php echo date('d-M-Y', strtotime($last_30_days)); ?> To <?php echo date('d-M-Y', strtotime('today')); ?></h5>
						<form class="bg-body shadow rounded p-2">
							<div class="input-group">
								<input class="form-control border-0 me-1" type="search" placeholder="Search student name...">
								<button type="button" class="btn btn-primary mb-0 rounded z-index-1"><i class="fas fa-search"></i></button>
							</div>
							<div class="search_result_30_days"></div>
						</form>
					</div>

				</div> <!-- Row END -->

				<div class="row">
          <div class="col-md-12">
            <div role="region1" aria-labelledby="caption" tabindex="0">
    <table class="table_scroll1">
        <!-- <caption id="caption">Baseball numbers mmkay.</caption> -->
        <thead>
            <tr class="text-center">
            	  <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</span></th>
                <!-- <th>Teams</th> -->
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Video Streamed</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Test (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Homework (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;MCQ (5)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;LSRW (6)</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
        </tbody>
    </table>
</div>
     </div>


			</div>
		</div>

		<!-- Last 30 days ended -->


		<!-- Custom data -->


		

			<div class="tab-pane fade" id="course-pills-tab10" role="tabpanel" aria-labelledby="course-pills-tab-10">
				<div class="row">
					<!-- Left content START -->
					<div class="col-lg-12">
						<!-- Title -->
						<h4>Select From and To date</h4>
						<!-- Fetch today's date here -->
						<form class="row g-3 position-relative mb-4" id="mkform" action="" method="post">
						<div class="col-md-6">
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1 dates" type="text" placeholder="From*" name="from_date"  id="datepicker" required autocomplete="off">
									<p style="font-size: 20px;">🗓️</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1 dates" type="text" placeholder="To*" name="to_date"  id="datepicker2" required autocomplete="off">
									<p style="font-size: 20px;">🗓️</p>
								</div>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary text-center" name="submit">Get Report</button>
						</div>
						<div class="col-md-4"></div>
						</form>

						<form class="bg-body shadow rounded p-2">
							<div class="input-group">
								<input class="form-control border-0 me-1" type="search" placeholder="Search student name...">
								<button type="button" class="btn btn-primary mb-0 rounded z-index-1"><i class="fas fa-search"></i></button>
							</div>
						</form>
					</div>
				</div> <!-- Row END -->
					<?php 
						if (isset($_POST['submit'])) {
							$from_date = mysqli_escape_string($connection, trim($_POST['from_date']));
							$to_date = mysqli_escape_string($connection, trim($_POST['to_date']));

							$from_date = date('Y-m-d', strtotime($from_date));
							$to_date = date('Y-m-d', strtotime($to_date));
							
								$fetch_total_test_for_last7days =  mysqli_query($connection, "SELECT * FROM rev_test WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$from_date' AND  '$to_date' AND rev_hw_sts = '1'");
								$total_last7days_test = mysqli_num_rows($fetch_total_test_for_last7days);

								$fetch_total_hw_for_yesterday = mysqli_query($connection, "SELECT * FROM rev_homework WHERE rev_hw_class = '$subject_class_yt' AND rev_hw_sec = '$class_sec' AND rev_hw_school = '$user_school' AND rev_hw_date BETWEEN '$from_date' AND '$to_date' AND rev_hw_sts = '1'");
								$total_yestrday_hw = mysqli_num_rows($fetch_total_hw_for_yesterday);

								$fetch_total_lsrw_for_yesterday = mysqli_query($connection, "SELECT * FROM rev_lsrw WHERE rev_class = '$subject_class_yt' AND rev_sec = '$class_sec' AND rev_sch = '$user_school' AND rev_date BETWEEN '$from_date' AND '$to_date' AND rev_sts = '1'");
								$total_yesterday_lsrw = mysqli_num_rows($fetch_total_lsrw_for_yesterday); ?>
						<div class="row">
          <div class="col-md-12">
            <div role="region1" aria-labelledby="caption" tabindex="0">
    <table class="table_scroll1">
        <!-- <caption id="caption">Baseball numbers mmkay.</caption> -->
        <thead>
            <tr class="text-center">
            	  <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</span></th>
                <!-- <th>Teams</th> -->
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Video Streamed</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Test (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;Homework (2)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;MCQ (5)</span></th>
                <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;LSRW (6)</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">1)&nbsp;Rakhee</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>Today</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	  <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">2)&nbsp;Keerthi</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
            <tr>
            	 <th style="text-align: left; word-wrap: break-word; white-space: normal !important"><a href="<?php echo BASE_URL; ?>pages/full_report_today?id=<?php echo htmlspecialchars($user_id_today, ENT_QUOTES, 'UTF-8'); ?>&st_date=<?php echo $date_of_uplading; ?>&et_date=<?php echo $date_of_uplading; ?>" style="text-decoration: none; color: #fff">3)&nbsp;Karthik</a></th>
                <!-- <th><a href="google.com">Milwaukee Brewers</a></th> -->
                <td>2 Mins</td>
                <td>3 Submitted</td>
                <td>2 Submitted</td>
                <td>0 Submitted</td>
                <td>3 Submitted</td>
            </tr>
        </tbody>
    </table>
</div>
     </div>


			</div>				
						<?php }	?>				
			</div>

			<!-- Custom data ended -->

			</div>
			<!-- Left Content End -->
		</div> <!-- Row END -->
			<div class="col-md-4 position-relative text-center">
				<!-- Title -->
				<img src="../assets/images/RW_top.png" height="50%" width="50%" alt="top">
				

				<!-- Outer tabs START -->
				<h4 class="mb-4 text-danger text-center">
					<img src="../assets/images/element/17.svg" height="25px" width="25px" alt="badge">&nbsp;&nbsp;Revisewell Toppers
					<br>
					<span class="text-dark" style="float: right; font-size: 13px;">*for the month <?php echo date('M'); ?>*</span>
					<br>
			     </h4>
					<ul class="nav nav-pills nav-pill-soft mb-3 d-flex justify-content-center" id="course-pills-tab" role="tablist">
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link active smaller" id="course-pills-tab-1" data-bs-toggle="pill" data-bs-target="#course-pills-tab1" type="button" role="tab" aria-controls="course-pills-tab1" aria-selected="true">Videos</button>
						</li>
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link smaller" id="course-pills-tab-2" data-bs-toggle="pill" data-bs-target="#course-pills-tab2" type="button" role="tab" aria-controls="course-pills-tab2" aria-selected="false">Homework</button>
						</li>
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link smaller" id="course-pills-tab-3" data-bs-toggle="pill" data-bs-target="#course-pills-tab3" type="button" role="tab" aria-controls="course-pills-tab3" aria-selected="false">Test</button>
						</li>
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link smaller" id="course-pills-tab-4" data-bs-toggle="pill" data-bs-target="#course-pills-tab4" type="button" role="tab" aria-controls="course-pills-tab4" aria-selected="false">MCQ</button>
						</li>
						<!-- Tab item -->
						<li class="nav-item me-2" role="presentation">
							<button class="nav-link smaller" id="course-pills-tab-5" data-bs-toggle="pill" data-bs-target="#course-pills-tab5" type="button" role="tab" aria-controls="course-pills-tab5" aria-selected="false">LSRW</button>
						</li>
					</ul> 
					<!-- Outer tabs END -->

					<!-- Outer tabs contents START -->
			<div class="tab-content mb-0" id="course-pills-tabContent">

			<!-- Outer tabs END -->
			<div class="tab-pane fade show active" id="course-pills-tab1" role="tabpanel" aria-labelledby="course-pills-tab-1">
				<!-- Video toppers -->

				<?php 
						$current_date = date('Y-m-01');
						$current_month = date('Y-m-t');

						$top_time_spent_in_watching_videos = mysqli_query($connection,"SELECT DISTINCT rev_user_name, rev_user_class FROM rev_watch_details WHERE rev_user_sch = '$user_school' AND rev_user_class = '$subject_class_yt' AND rev_user_sec = '$class_sec' AND rev_user_sts = '1' AND rev_user_date BETWEEN '$current_date' AND '$current_month' ORDER BY rev_user_time DESC LIMIT 3");

						if (mysqli_num_rows($top_time_spent_in_watching_videos) > 0) {
							$i = 1;
							while($tv = mysqli_fetch_assoc($top_time_spent_in_watching_videos)) { 
								?>
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-xl">
										<!-- Avatar image -->
										<img class="avatar-img rounded-circle" src="../assets/images/female_avatar.webp" alt="avatar">
										<!-- Medal badge -->
										<div class="position-absolute bottom-0 end-0">
											<img src="../assets/images/element/medal-badge.png" class="position-relative" alt="">
											<span class="fw-bold text-dark position-absolute top-50 start-50 translate-middle"><?php echo $i++; ?><sup>st</sup></span>
										</div>
									</div>
									<!-- Title -->
									<div class="ms-3">
										<h5 class="mb-1"><?php echo htmlspecialchars(ucfirst($tv['rev_user_name']), ENT_QUOTES, 'UTF-8'); ?></h5>
										<p class="mb-0">Grade <?php echo htmlspecialchars($tv['rev_user_class'], ENT_QUOTES, 'UTF-8'); ?></p>
									</div>
								</div>
							<?php }
						}
					?>				
				<hr>
			</div>

			<!-- Homework toppers -->

			<!-- Outer tabs END -->
			<div class="tab-pane fade" id="course-pills-tab2" role="tabpanel" aria-labelledby="course-pills-tab-2">
				<!-- Homework toppers -->

				<?php $current_month = date('m'); ?>
				
				<?php
					$fetch_hw = mysqli_query($connection, "SELECT * FROM total_count_of_lsrw_hw_test_mcq WHERE rev_cate = 'homework' AND rev_month = '$current_month' AND rev_sch = '$user_school' AND 	rev_class = '$subject_class_yt' AND rev_sec = '$class_sec' ORDER BY rev_count DESC");

					if (mysqli_num_rows($fetch_hw) > 0) {
							while($kl = mysqli_fetch_assoc($fetch_hw)) { 
								$user_gender = $kl['rev_student_gender'];
								?>
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-xl">
										<!-- Avatar image -->
										<?php 
											if ($user_gender == 'male') { ?>
												<img class="avatar-img rounded-circle" src="../assets/images/male_avatar.webp" alt="avatar">
											<?php } else { ?>
												<img class="avatar-img rounded-circle" src="../assets/images/female_avatar.webp" alt="avatar">
											<?php }	?>										
										<!-- Medal badge -->
										<div class="position-absolute bottom-0 end-0">
											<img src="../assets/images/element/medal-badge.png" class="position-relative" alt="">
											<span class="fw-bold text-dark position-absolute top-50 start-50 translate-middle"><?php echo $i++; ?><sup>st</sup></span>
										</div>
									</div>
									<!-- Title -->
									<div class="ms-3">
										<h5 class="mb-1"><?php echo htmlspecialchars(ucfirst($kl['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></h5>
										<p class="mb-0">Grade <?php echo htmlspecialchars($kl['rev_class'], ENT_QUOTES, 'UTF-8'); ?></p>
									</div>
								</div>

							<?php }	
					}
				?>
				<hr>
			</div>

			<!-- Test toppers -->

			<!-- Outer tabs END -->
			<div class="tab-pane fade" id="course-pills-tab3" role="tabpanel" aria-labelledby="course-pills-tab-3">
				<!-- test -->

				<?php $current_month = date('m'); ?>
				
				<?php
					$fetch_hw = mysqli_query($connection, "SELECT * FROM total_count_of_lsrw_hw_test_mcq WHERE rev_cate = 'test' AND rev_month = '$current_month' AND rev_sch = '$user_school' AND rev_class = '$subject_class_yt' AND rev_sec = '$class_sec' ORDER BY rev_count DESC");

					if (mysqli_num_rows($fetch_hw) > 0) {
							while($kl = mysqli_fetch_assoc($fetch_hw)) { 
								$user_gender = $kl['rev_student_gender'];
								?>
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-xl">
										<!-- Avatar image -->
										<?php 
											if ($user_gender == 'male') { ?>
												<img class="avatar-img rounded-circle" src="../assets/images/male_avatar.webp" alt="avatar">
											<?php } else { ?>
												<img class="avatar-img rounded-circle" src="../assets/images/female_avatar.webp" alt="avatar">
											<?php }	?>										
										<!-- Medal badge -->
										<div class="position-absolute bottom-0 end-0">
											<img src="../assets/images/element/medal-badge.png" class="position-relative" alt="">
											<span class="fw-bold text-dark position-absolute top-50 start-50 translate-middle"><?php echo $i++; ?><sup>st</sup></span>
										</div>
									</div>
									<!-- Title -->
									<div class="ms-3">
										<h5 class="mb-1"><?php echo htmlspecialchars(ucfirst($kl['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></h5>
										<p class="mb-0">Grade <?php echo htmlspecialchars($kl['rev_class'], ENT_QUOTES, 'UTF-8'); ?></p>
									</div>
								</div>

							<?php }	
					}
				?>
				<!-- test ended-->
				<hr>
			</div>

			<!-- Outer tabs END -->
			<div class="tab-pane fade" id="course-pills-tab4" role="tabpanel" aria-labelledby="course-pills-tab-4">
				<?php $current_month = date('m'); ?>				
				<?php
					$fetch_hw = mysqli_query($connection, "SELECT * FROM total_count_of_lsrw_hw_test_mcq WHERE rev_cate = 'lsrw' AND rev_month = '$current_month' AND rev_sch = '$user_school' AND rev_class = '$subject_class_yt' AND rev_sec = '$class_sec' ORDER BY rev_count DESC");

					if (mysqli_num_rows($fetch_hw) > 0) {
							while($kl = mysqli_fetch_assoc($fetch_hw)) { 
								$user_gender = $kl['rev_student_gender'];
								?>
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-xl">
										<!-- Avatar image -->
										<?php 
											if ($user_gender == 'male') { ?>
												<img class="avatar-img rounded-circle" src="../assets/images/male_avatar.webp" alt="avatar">
											<?php } else { ?>
												<img class="avatar-img rounded-circle" src="../assets/images/female_avatar.webp" alt="avatar">
											<?php }	?>										
										<!-- Medal badge -->
										<div class="position-absolute bottom-0 end-0">
											<img src="../assets/images/element/medal-badge.png" class="position-relative" alt="">
											<span class="fw-bold text-dark position-absolute top-50 start-50 translate-middle"><?php echo $i++; ?><sup>st</sup></span>
										</div>
									</div>
									<!-- Title -->
									<div class="ms-3">
										<h5 class="mb-1"><?php echo htmlspecialchars(ucfirst($kl['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></h5>
										<p class="mb-0">Grade <?php echo htmlspecialchars($kl['rev_class'], ENT_QUOTES, 'UTF-8'); ?></p>
									</div>
								</div>

							<?php }	
					}
				?>
				<!-- mcq ended-->
				<hr>
			</div>

			<!-- Outer tabs END -->
			<div class="tab-pane fade" id="course-pills-tab5" role="tabpanel" aria-labelledby="course-pills-tab-5">
				<!-- lsrw -->

				<?php $current_month = date('m'); ?>
				
				<?php
					$fetch_hw = mysqli_query($connection, "SELECT * FROM total_count_of_lsrw_hw_test_mcq WHERE rev_cate = 'lsrw' AND rev_month = '$current_month' AND rev_sch = '$user_school' AND rev_class = '$subject_class_yt' AND rev_sec = '$class_sec' ORDER BY rev_count DESC");

					if (mysqli_num_rows($fetch_hw) > 0) {
							while($kl = mysqli_fetch_assoc($fetch_hw)) { 
								$user_gender = $kl['rev_student_gender'];
								?>
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-xl">
										<!-- Avatar image -->
										<?php 
											if ($user_gender == 'male') { ?>
												<img class="avatar-img rounded-circle" src="../assets/images/male_avatar.webp" alt="avatar">
											<?php } else { ?>
												<img class="avatar-img rounded-circle" src="../assets/images/female_avatar.webp" alt="avatar">
											<?php }	?>										
										<!-- Medal badge -->
										<div class="position-absolute bottom-0 end-0">
											<img src="../assets/images/element/medal-badge.png" class="position-relative" alt="">
											<span class="fw-bold text-dark position-absolute top-50 start-50 translate-middle"><?php echo $i++; ?><sup>st</sup></span>
										</div>
									</div>
									<!-- Title -->
									<div class="ms-3">
										<h5 class="mb-1"><?php echo htmlspecialchars(ucfirst($kl['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?></h5>
										<p class="mb-0">Grade <?php echo htmlspecialchars($kl['rev_class'], ENT_QUOTES, 'UTF-8'); ?></p>
									</div>
								</div>

							<?php }	
					}
				?>
				<!-- lsrw ended-->
				<hr>
			</div>
		</div>
	</div>			

	</div>

		
	</div>
	<!-- Content END -->

<!-- =======================
Main Banner END -->

<script type="text/javascript">
	const picker = MCDatepicker.create({
		el: '#datepicker',						
		maxDate: new Date()			
	 });

    const datepicker2 = MCDatepicker.create({ 
 			el: '#datepicker2',      			
			maxDate: new Date()				
	 });
</script>

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<script type="text/javascript">
  function handleSelect(elm) {
     window.location = "https://teacher.amazing-feynman.3-108-84-48.plesk.page/pages/generate_report?param="+elm.value;
  }

function myFunction() {
      const element = document.getElementById("content");
      element.scrollIntoView();
    }
</script>

<script type="text/javascript">
	$('.se_today').keyup(function() {
		var search_q = $('.se_today').val();
		$.post( "search_today.php", { search: search_q, teacher_class: "<?php echo $subject_class_yt; ?>", teacher_sec: "<?php echo $class_sec; ?>", teacher_school: "<?php echo $user_school; ?>" }).done(function( data ) {
			$('.search_result').show();
		    $('.search_result').html(data);
		  });
	})
	

  $('.se_yesterday').keyup(function() {
		var search_q = $('.se_yesterday').val();
		$.post( "search_yesterday.php", { search: search_q, teacher_class: "<?php echo $subject_class_yt; ?>", teacher_sec: "<?php echo $class_sec; ?>", teacher_school: "<?php echo $user_school; ?>" }).done(function( data ) {
			$('.search_result_yesterday').show();
		    $('.search_result_yesterday').html(data);
		  });
	})

	$('.se_last_7_days').keyup(function() {
		var search_q = $('.se_last_7_days').val();
		$.post( "search_last_7_days.php", { search: search_q, teacher_class: "<?php echo $subject_class_yt; ?>", teacher_sec: "<?php echo $class_sec; ?>", teacher_school: "<?php echo $user_school; ?>" }).done(function( data ) {
			$('.search_result_7_days').show();
		    $('.search_result_7_days').html(data);
		  });
	})

	$('.se_last_30_days').keyup(function() {
		var search_q = $('.se_last_30_days').val();
		$.post( "search_last_30_days.php", { search: search_q, teacher_class: "<?php echo $subject_class_yt; ?>", teacher_sec: "<?php echo $class_sec; ?>", teacher_school: "<?php echo $user_school; ?>" }).done(function( data ) {
			$('.search_result_30_days').show();
		    $('.search_result_30_days').html(data);
		  });
	})	

	$(".form").submit(function(e){
    e.preventDefault();
  });		
</script>

<script>
$(document).ready(function(){
	$('button[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('id'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('#course-pills-tab button[id="' + activeTab + '"]').tab('show');
	}
	// window.localStorage.removeItem('activeTab');
	localStorage.removeItem("activeTab");
	// localStorage.setItem('activeTab', false);
});


</script>

<script type="text/javascript">
	const shareButton = document.querySelector('.share-button');
const shareDialog = document.querySelector('.share-dialog');
const closeButton = document.querySelector('.close-button');

    shareButton.addEventListener('click', event => {
	
  if (navigator.share) { 
   navigator.share({   		
      title: 'Revisewell Homework Student List',
      url: '<?php echo $short_url; ?>',
      text: 'Welcome to Revisewell',
      // files: [file]
    }).then(() => {
      console.log('Welcome developer, send your resume to info@revisewell.com');
    })
    .catch(console.error);
    } else {
        shareDialog.classList.add('is-open');
    }
});
  
closeButton.addEventListener('click', event => {
  shareDialog.classList.remove('is-open');
});
</script>

<script type="text/javascript">
  function generatePDF() {
        
        // Choose the element id which you want to export.
        var element = document.getElementById('divToExport');
        element.style.width = '100%';
        element.style.height = '100%';
        var opt = {
            margin:       0.5,
            filename:     'myfile.pdf',
            image:        { type: 'jpeg', quality: 1 },
            html2canvas:  { scale: 1 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
          };
        
        // choose the element and pass it to html2pdf() function and call the save() on it to save as pdf.
        html2pdf().set(opt).from(element).save();
      }
</script>