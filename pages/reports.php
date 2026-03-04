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
?>

<?php 
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_user_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['rev_user_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>


<?php 
	if (isset($_POST['upi'])) {

		$order_id = 'aks_sch_' . uniqid(); 

		$today_date = date('Y-m-d H:i');
		$paying_to = mysqli_escape_string($connection, trim($_POST['paying_to']));
		$paying_student_name = mysqli_escape_string($connection, trim($_POST['student_name']));
		$paying_student_id = mysqli_escape_string($connection, trim($_POST['student_id']));
		$paying_amount = mysqli_escape_string($connection, trim($_POST['total_amount']));
		$paying_discount = mysqli_escape_string($connection, trim($_POST['discount']));


		if ($paying_to == "" || $paying_student_name == "" || $paying_student_id == "" || $paying_amount == "") {
			$error_message = "something went wrong";
		}

		if ($paying_discount == "") {
			$paying_discount = '0';
		}

		if (!isset($error_message)) {
			$insert = mysqli_query($connection,"INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id) VALUES ('$paying_student_id', '$paying_to', 'upi', '$paying_amount', '$paying_discount', '0', '0', '$today_date', '2', '$order_id')");

			header("Location: " . BASE_URL . 'pages/phonepe?order_id=' . $order_id);


		}
	}





	if (isset($_POST['delete'])) {
		$delete_id = mysqli_escape_string($connection, trim($_POST['del_id']));

		if ($delete_id == "") {
			$error_message = "something went wrong please try again"; 
		}

		if (!isset($error_message)) {
			$check_if_same_cla = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_id = '$delete_id' AND rev_student_sch = '$user_school' AND rev_student_class = '$subject_class_yt' AND rev_student_sec = '$class_sec' AND rev_student_sts = '1'");
			if (mysqli_num_rows($check_if_same_cla) > 0) {
				$delete_query = mysqli_query($connection, "UPDATE rev_student_login SET rev_student_sts = '0' WHERE rev_student_id = '$delete_id'");

				if (isset($delete_id)) {
					$error_message = "Success student deleted";
				}
			}
		}
	}
?>

<?php 
	if (isset($_POST['cash'])) {
		$today_date = date('Y-m-d H:i');
		$paying_to = mysqli_escape_string($connection, trim($_POST['paying_to']));
		$paying_student_name = mysqli_escape_string($connection, trim($_POST['student_name']));
		$paying_student_id = mysqli_escape_string($connection, trim($_POST['student_id']));
		$paying_amount = mysqli_escape_string($connection, trim($_POST['total_amount']));
		$paying_discount = mysqli_escape_string($connection, trim($_POST['discount']));
		$paying_receipt = mysqli_escape_string($connection, trim($_POST['receipt_no'])); 
		$paying_utr = mysqli_escape_string($connection, trim($_POST['utr_no']));


		if ($paying_to == "" || $paying_student_name == "" || $paying_student_id == "" || $paying_amount == "" || $paying_receipt == "") {
			$error_message = "Please fill all fields";
		}

		if ($paying_discount == "") {
			$paying_discount = '0';
		}

		if ($paying_utr == "") {
			$paying_utr = '0';
		}

		if (!isset($error_message)) {
			$insert = "INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id) VALUES ('$paying_student_id', '$paying_to', 'admin_account', '$paying_amount', '$paying_discount', '$paying_receipt', '$paying_utr', '$today_date', '1', '$order_id')";

			if (mysqli_query($connection, $insert)) {
			  $last_id = mysqli_insert_id($connection);
			  echo "Success, Payment received";


			  // Term 1
					if ($paying_to == "term_1") {
						$select_term_1 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_1) > 0) {
							while($term_1_data = mysqli_fetch_assoc($select_term_1)) {
								$old_term1_data = $term_1_data['rev_term1_fee'];
								$total_fee = $term_1_data['rev_fees'];
							}

							$new_term_1 = $old_term1_data - $paying_amount;
							$new_total_fee = $total_fee - $paying_amount;

							$update_term_1 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$new_term_1' WHERE tree_id = '$paying_student_id'");

							$update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");
						}
					}
					// Term 2

					if ($paying_to == "term_2") {
						$select_term_2 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_2) > 0) {
							while($term_2_data = mysqli_fetch_assoc($select_term_2)) {
								$old_term2_data = $term_2_data['rev_term2_fee'];
								$total_fee = $term_2_data['rev_fees'];
							}

							$new_term_2 = $old_term2_data - $paying_amount;
							$new_total_fee = $total_fee - $paying_amount;

							$update_term_2 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$new_term_2' WHERE tree_id = '$paying_student_id'");

							$update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");
						}
					}


					// Term 3

					if ($paying_to == "term_3") {
						$select_term_3 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_3) > 0) {
							while($term_3_data = mysqli_fetch_assoc($select_term_3)) {
								$old_term3_data = $term_3_data['rev_term3_fee'];
								$total_fee = $term_3_data['rev_fees'];
							}

							$new_term_3 = $old_term3_data - $paying_amount;
							$new_total_fee = $total_fee - $paying_amount;

							$update_term_3 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term3_fee = '$new_term_3' WHERE tree_id = '$paying_student_id'");

							$update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");
						}
					}


					// Full Fee

					if ($paying_to == "full_fee") {
						$select_term_full_fee = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_full_fee) > 0) {
							while($term_full_fee_data = mysqli_fetch_assoc($select_term_full_fee)) {
								// $old_term3_data = $term_3_data['rev_term3_fee'];
								$total_fee = $term_full_fee_data['rev_fees'];
							}

							// $new_term_3 = $old_term3_data - $payment_amount;
							$new_total_fee = $total_fee - $paying_amount;

							$update_term_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee', rev_term3_fee = '0', rev_term2_fee = '0', rev_term1_fee = '0'  WHERE tree_id = '$paying_student_id'");

							$update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");
						}
					}


					// books Fee

					if ($paying_to == "book") {
						$select_term_full_fee = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_full_fee) > 0) {
							while($term_full_fee_data = mysqli_fetch_assoc($select_term_full_fee)) {
								// $old_term3_data = $term_3_data['rev_term3_fee'];
								echo $total_fee = $term_full_fee_data['rev_books'];
							}

							// $new_term_3 = $old_term3_data - $payment_amount;
							echo $new_total_fee = $total_fee - $paying_amount;

							$update_term_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = '$new_total_fee' WHERE tree_id = '$paying_student_id'");

							// $update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = '$new_total_fee' WHERE tree_id = '$paying_student_id'");
						}
					}


					// Trans Fee

					if ($paying_to == "trans") {
						$select_term_full_fee = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_full_fee) > 0) {
							while($term_full_fee_data = mysqli_fetch_assoc($select_term_full_fee)) {
								// $old_term3_data = $term_3_data['rev_term3_fee'];
								$total_fee = $term_full_fee_data['rev_transportation'];
							}

							// $new_term_3 = $old_term3_data - $payment_amount;
							$new_total_fee = $total_fee - $paying_amount;

							$update_term_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_transportation = '$new_total_fee' WHERE tree_id = '$paying_student_id'");

							// $update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = '$new_total_fee' WHERE tree_id = '$paying_student_id'");
						}
					}

			} else {
				echo "Contact admin";
			}
		}
	}
?>




<?php 
	// $_SESSION['uniq_student_id'] = $temp_id = md5(date('Y-m-d H:i:s a'));
	// $insert_into_rev_erp_student = mysqli_query($connection, "INSERT INTO rev_erp_student_details(rev_school_id,rev_school_name,rev_admission_class,rev_semster,rev_mother_tongue,rev_temp_id, rev_sts, rev_moi) VALUES ('$school_id', '$school_name', '0', '0', '0', '$temp_id', '4', '0')");


if (isset($_GET['c'])) {
	if ($_GET['c'] != "") {
		$selected_class = htmlspecialchars($_GET['c'], ENT_QUOTES, 'UTF-8');
	} else {
		$selected_class = 'all';
	}
} else {
		$selected_class = 'all';
	}
?>

<?php 
	if (isset($_GET['p'])) {
		if ($_GET['p'] != "") {
			$pending_selected = htmlspecialchars($_GET['p'], ENT_QUOTES, 'UTF-8');
		} 
	} 
?>


<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>


<style>
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s;
    }

    .card:hover {
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card-body {
      padding: 15px;
    }

    .card-title {
      font-size: 1.2rem;
      margin-bottom: 5px;
      color: #343a40; /* Dark text color */
    }

    .card-text {
      font-size: 1rem;
      margin-bottom: 5px;
      color: #343a40; /* Dark text color */
    }

    .badge-container {
      display: flex;
      flex-wrap: wrap;
    }

    .badge {
      margin-right: 10px;
      margin-bottom: 5px;
      font-size: 0.9rem;
      padding: 8px 12px;
      border-radius: 20px;
    }

    .badge i {
      margin-right: 5px;
    }

    .badge-info {
      background-color: #17a2b8;
      color: #fff;
    }

    .badge-warning {
      background-color: #ffc107;
      color: #212529;
    }

    .badge-secondary {
      background-color: #6c757d;
      color: #fff;
    }

    /* Remove underline from anchor tags on hover */
    a.card:hover {
      text-decoration: none;
    }

    .student-class {
      float: right; /* Align on the right side */
      margin-left: 10px;
    }

    .class-label {
      font-weight: bold;
    }

    .sec:target {
        background-color: yellow;
    }


  </style>
  
<div class="container zindex-100 desk" style="margin-top: 10px">
	<div style="float: left;">
		<h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px; width: 170px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
	</div>
</div>

	<!-- Content START -->
	<section>
	<div class="container">
		<div class="row d-lg-flex justify-content-md-center g-md-5">
			<!-- Left content START -->
				<h4 class="fs-1 fw-bold mb-4 d-flex justify-content-center">
					<img src="<?php echo BASE_URL; ?>assets/images/student_list.webp" width="50px" height="50px" alt="Homework">
					<span class="position-relative z-index-9" style="font-size: 33px;">Payment &nbsp;</span>
					<span class="position-relative z-index-1" style="font-size: 33px;">Details</span>
				</h4>
				<h3 class="text-center">Get Data Date wise</h3>
				<form action="" method="post">
					<div class="row">
					  <div class="col-md-6">
					    <input type="date" class="form-control" placeholder="From Date" aria-label="First name" name="from" max="<?php echo date('Y-m-d'); ?>">
					  </div>
					  <div class="col-md-6">
					    <input type="date" class="form-control" placeholder="To Date" aria-label="Last name" name="to" max="<?php echo date('Y-m-d'); ?>">
					  </div>
					</div><br>
					<button class="btn btn-primary" type="submit" name="sub">Submit</button>
				</form>

				<?php 
					if (isset($_POST['sub'])) {
						$from_date = mysqli_escape_string($connection, trim($_POST['from']));
						$to_date = mysqli_escape_string($connection, trim($_POST['to']));

						if ($from_date == "" || $to_date == "") {
							$error_message = "Please fill all fields";
						}

						if (!isset($error_message)) {
							$from_date_with_sec = $from_date . ' 00:00';
							$to_date_with_sec = $to_date . ' 00:00'; ?>


							<!-- Table of Data -->
							<table class="table text-dark">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Student Name</th>
							      <th scope="col">Paid For</th>
								  <th scope="col">UTR ID</th>
							      <th scope="col">Amount</th>
							      <th scope="col">Date</th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php 
							  		$tow_dates = mysqli_query($connection,"SELECT * FROM erp_payment_details WHERE rev_paid_date_time BETWEEN '" . $from_date_with_sec . "' AND  '" . $to_date_with_sec . "' AND rev_sts = '1' AND rev_utr_id != ''");

							  		if (mysqli_num_rows($tow_dates) > 0) {
							  			$i = 1;
							  			while($fd = mysqli_fetch_assoc($tow_dates)) { ?>
							  				<tr>
										      <th scope="row"><?php echo $i++; ?></th>
										      <td><?php $student_id = htmlspecialchars($fd['rev_student_id'], ENT_QUOTES, 'UTF-8'); ?>
										      	<?php 
										      		$fetch_student_name = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id'");

										      		if (mysqli_num_rows($fetch_student_name) > 0) {
										      			while($cds = mysqli_fetch_assoc($fetch_student_name)) {
										      				echo htmlspecialchars($cds['rev_student_fname'], ENT_QUOTES, 'UTF-8');
										      			}
										      		}


										      	?>

										    	</td>
										      <td><?php echo htmlspecialchars($fd['rev_paid_to'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($fd['rev_utr_id'], ENT_QUOTES, 'UTF-8'); ?></td>
										      <td><?php echo htmlspecialchars($fd['rev_payment_amount'], ENT_QUOTES, 'UTF-8'); ?></td>
										      <td><?php echo htmlspecialchars(date('d-M-Y', strtotime($fd['rev_paid_date_time'])), ENT_QUOTES, 'UTF-8'); ?></td>
										    </tr>
							  			<?php }
							  		} else {
							  			echo '<p class="text-danger">No data found, Please try with another date</p>';
							  		}
							  	?>							    
							  </tbody>
							</table>
						<?php }
					}



				?>
							
							
		</div> <!-- Row END -->
	</div>

	<!-- Content END -->

	<div class="container" style="margin-top:5px;">
		<div class="row">
			<div class="d-flex justify-content-around">
				<!-- <a href="<?php echo BASE_URL; ?>pages/add_student" style="text-decoration: none;"><div class="badge bg-info bg-opacity-10 text-info mb-4 fw-bold btn-transition" style="float: left; margin-top: -20px; font-size: 12px; cursor: pointer;"><i class="fas fa-plus" style="font-size:25px;"></i><br></div></a> -->

				<!-- <div class="badge bg-info bg-opacity-10 text-info mb-4 fw-bold btn-transition" style="text-align: center; margin-top: -20px; font-size: 12px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#change_sec"><i class="fas fa-exchange-alt" style="font-size: 25px;"></i><br>Change Sec</div>

				<div class="badge bg-info bg-opacity-10 text-info mb-4 fw-bold btn-transition" onclick="ExportToExcel('xlsx')" style="float: right; margin-top: -20px; font-size: 12px; cursor: pointer;"><i class="far fa-file-excel" style="font-size: 25px;"></i><br>Download List</div> -->
			</div>
		</div>
	</div>
</div>
</section>
<div class="container">
	<div class="row">

		<!-- Total_fees -->

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	Tution Fee
			  	<!-- Pending fee -->
			  	<?php 
			  		$tution_fee_total = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum FROM rev_erp_student_details WHERE rev_sts = '1'");
			  		$row_total = mysqli_fetch_assoc($tution_fee_total); 
						$total_tution_fee = $row_total['total_sum'];
			  	?>
			  	<!-- Pending fee Ended-->

			  	<!-- Pending fee Collected -->
			  		<?php 
			  		// term 1
				  		$tution_fee_total_collected_term_1 = mysqli_query($connection, "SELECT SUM(rev_payment_amount) AS total_sum_collected_term_1 FROM erp_payment_details WHERE rev_sts = '1' AND rev_paid_to = 'term_1'");
				  		$row_total_collected_term_1 = mysqli_fetch_assoc($tution_fee_total_collected_term_1); 
							$total_tution_fee_collected_term_1 = $row_total_collected_term_1['total_sum_collected_term_1'];

							// term 2
				  		$tution_fee_total_collected_term_2 = mysqli_query($connection, "SELECT SUM(rev_payment_amount) AS total_sum_collected_term_2 FROM erp_payment_details WHERE rev_sts = '1' AND rev_paid_to = 'term_2'");
				  		$row_total_collected_term_2 = mysqli_fetch_assoc($tution_fee_total_collected_term_2); 
							$total_tution_fee_collected_term_2 = $row_total_collected_term_2['total_sum_collected_term_2'];

							// full fee
				  		$tution_fee_total_collected_term_full = mysqli_query($connection, "SELECT SUM(rev_payment_amount) AS total_sum_collected_term_full FROM erp_payment_details WHERE rev_sts = '1' AND rev_paid_to = 'full_fee'");
				  		$row_total_collected_term_full = mysqli_fetch_assoc($tution_fee_total_collected_term_full); 
							$total_tution_fee_collected_term_full = $row_total_collected_term_full['total_sum_collected_term_full'];

							$full_collected_fee = $total_tution_fee_collected_term_1 + $total_tution_fee_collected_term_2 + $total_tution_fee_collected_term_full; 
				  	?>
			  	<!-- Pending fee Collected Ended-->
			  	<p style="font-size:18px;" class="d-flex justify-content-around">
			  		<button class="btn btn-danger btn-sm">Pending <br> Rs.<span class="text-light"><?php echo $total_tution_fee; ?></span></button>
			  		<button class="btn btn-success btn-sm">Collected <br> Rs.<span class="text-light"><?php echo $full_collected_fee; ?></span></button>
			  	</p>	  	

			  </div>
			</div>
		</div>

		<!-- Total Fees ended -->


		<!-- Total_books_fees -->

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	Books
			  	<?php 
			  		$books_fee_total = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books FROM rev_erp_student_details WHERE rev_sts = '1'");
			  		$row_total_books = mysqli_fetch_assoc($books_fee_total); 
						$total_books_fee = $row_total_books['total_sum_books'];
			  	?>

			  	<?php 
			  		// total books
				  		$books_fee_total_collected = mysqli_query($connection, "SELECT SUM(rev_payment_amount) AS total_sum_collected_book FROM erp_payment_details WHERE rev_sts = '1' AND rev_paid_to = 'book'");
				  		$row_total_collected_book = mysqli_fetch_assoc($books_fee_total_collected); 
							$total_book_fee_collected = $row_total_collected_book['total_sum_collected_book'];
					?>
			  	<p style="font-size:18px" class="d-flex justify-content-around">
			  		<button class="btn btn-danger btn-sm">Pending <br> Rs.<span class="text-light"><?php echo $total_books_fee; ?></span></button>
			  		<button class="btn btn-success btn-sm">Collected <br> Rs.<span class="text-light"><?php echo $total_book_fee_collected; ?></span></button>			  		
			  	</p>
			  </div>
			</div>
		</div>

		<!-- Total Books Fees ended -->


		<!-- Total_trans_fees -->

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	Transportation
			  	<?php 
			  		$books_fee_total = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_transportation FROM rev_erp_student_details WHERE rev_sts = '1'");
			  		$row_total_trans = mysqli_fetch_assoc($books_fee_total); 
						$total_trans_fee = $row_total_trans['total_sum_transportation'];
			  	?>

			  	<?php 
			  		// total trans
				  		$trans_fee_total_collected = mysqli_query($connection, "SELECT SUM(rev_payment_amount) AS total_sum_collected_trans FROM erp_payment_details WHERE rev_sts = '1' AND rev_paid_to = 'trans'");
				  		$row_total_collected_trans = mysqli_fetch_assoc($trans_fee_total_collected); 
							$total_trans_fee_collected = $row_total_collected_trans['total_sum_collected_trans'];
					?>
			  	<p style="font-size:18px;" class="d-flex justify-content-around">
			  			<button class="btn btn-danger btn-sm">Pending <br> Rs.<span class="text-light"><?php echo $total_trans_fee; ?></span></button>

			  			<button class="btn btn-success btn-sm">Collected <br> Rs.<span class="text-light"><?php echo $total_trans_fee_collected; ?></span></button>

			  	</p>
			  </div>
			</div>
		</div>

		<!-- Total Trans Fees ended -->







		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_gradebaby = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_gradebaby FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = 'bc'");
			  		$row_gradebaby = mysqli_fetch_assoc($tution_fee_for_gradebaby); 
						$gradebaby_tution_fee = $row_gradebaby['total_sum_gradebaby'];

						$books_fee_for_gradebaby = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_gradebaby FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = 'bc'");
			  		$row_books_gradebaby = mysqli_fetch_assoc($books_fee_for_gradebaby); 
						$gradebaby_books_fee = $row_books_gradebaby['total_sum_books_gradebaby'];

						$trans_fee_for_gradebaby = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_gradebaby FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = 'bc'");
			  		$row_trans_gradebaby = mysqli_fetch_assoc($trans_fee_for_gradebaby); 
						$gradebaby_tution_trans = $row_trans_gradebaby['total_sum_trans_gradebaby'];
			  	?>
			    Baby
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $gradebaby_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $gradebaby_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $gradebaby_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>


		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_gradelkg = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_gradelkg FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = 'lkg'");
			  		$row_gradelkg = mysqli_fetch_assoc($tution_fee_for_gradelkg); 
						$gradelkg_tution_fee = $row_gradelkg['total_sum_gradelkg'];

						$books_fee_for_gradelkg = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_gradelkg FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '1'");
			  		$row_books_gradelkg = mysqli_fetch_assoc($books_fee_for_gradelkg); 
						$gradelkg_books_fee = $row_books_gradelkg['total_sum_books_gradelkg'];

						$trans_fee_for_gradelkg = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_gradelkg FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = 'lkg'");
			  		$row_trans_gradelkg = mysqli_fetch_assoc($trans_fee_for_gradelkg); 
						$gradelkg_tution_trans = $row_trans_gradelkg['total_sum_trans_gradelkg'];
			  	?>
			    LKG
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $gradelkg_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $gradelkg_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $gradelkg_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_gradeukg = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_gradeukg FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = 'ukg'");
			  		$row_gradeukg = mysqli_fetch_assoc($tution_fee_for_gradeukg); 
						$gradeukg_tution_fee = $row_gradeukg['total_sum_gradeukg'];

						$books_fee_for_gradeukg = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_gradeukg FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = 'ukg'");
			  		$row_books_gradeukg = mysqli_fetch_assoc($books_fee_for_gradeukg); 
						$gradeukg_books_fee = $row_books_gradeukg['total_sum_books_gradeukg'];

						$trans_fee_for_gradeukg = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_gradeukg FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = 'ukg'");
			  		$row_trans_gradeukg = mysqli_fetch_assoc($trans_fee_for_gradeukg); 
						$gradeukg_tution_trans = $row_trans_gradeukg['total_sum_trans_gradeukg'];
			  	?>
			    UKG
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $gradeukg_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $gradeukg_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $gradeukg_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>




		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade1 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade1 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '1'");
			  		$row_grade1 = mysqli_fetch_assoc($tution_fee_for_grade1); 
						$grade1_tution_fee = $row_grade1['total_sum_grade1'];

						$books_fee_for_grade1 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade1 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '1'");
			  		$row_books_grade1 = mysqli_fetch_assoc($books_fee_for_grade1); 
						$grade1_books_fee = $row_books_grade1['total_sum_books_grade1'];

						$trans_fee_for_grade1 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade1 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '1'");
			  		$row_trans_grade1 = mysqli_fetch_assoc($trans_fee_for_grade1); 
						$grade1_tution_trans = $row_trans_grade1['total_sum_trans_grade1'];
			  	?>
			    Grade 1
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade1_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade1_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade1_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade2 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade2 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '2'");
			  		$row_grade2 = mysqli_fetch_assoc($tution_fee_for_grade2); 
						$grade2_tution_fee = $row_grade2['total_sum_grade2'];

						$books_fee_for_grade2 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade2 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '2'");
			  		$row_books_grade2 = mysqli_fetch_assoc($books_fee_for_grade2); 
						$grade2_books_fee = $row_books_grade2['total_sum_books_grade2'];

						$trans_fee_for_grade2 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade2 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '2'");
			  		$row_trans_grade2 = mysqli_fetch_assoc($trans_fee_for_grade2); 
						$grade2_tution_trans = $row_trans_grade2['total_sum_trans_grade2'];
			  	?>
			    Grade 2
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade2_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade2_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade2_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade3 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade3 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '3'");
			  		$row_grade3 = mysqli_fetch_assoc($tution_fee_for_grade3); 
						$grade3_tution_fee = $row_grade3['total_sum_grade3'];

						$books_fee_for_grade3 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade3 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '3'");
			  		$row_books_grade3 = mysqli_fetch_assoc($books_fee_for_grade3); 
						$grade3_books_fee = $row_books_grade3['total_sum_books_grade3'];

						$trans_fee_for_grade3 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade3 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '3'");
			  		$row_trans_grade3 = mysqli_fetch_assoc($trans_fee_for_grade3); 
						$grade3_tution_trans = $row_trans_grade3['total_sum_trans_grade3'];
			  	?>
			    Grade 3
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade3_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade3_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade3_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade4 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade4 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '4'");
			  		$row_grade4 = mysqli_fetch_assoc($tution_fee_for_grade4); 
						$grade4_tution_fee = $row_grade4['total_sum_grade4'];

						$books_fee_for_grade4 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade4 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '4'");
			  		$row_books_grade4 = mysqli_fetch_assoc($books_fee_for_grade4); 
						$grade4_books_fee = $row_books_grade4['total_sum_books_grade4'];

						$trans_fee_for_grade4 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade4 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '4'");
			  		$row_trans_grade4 = mysqli_fetch_assoc($trans_fee_for_grade4); 
						$grade4_tution_trans = $row_trans_grade4['total_sum_trans_grade4'];
			  	?>
			    Grade 4
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade4_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade4_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade4_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade5 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade5 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '5'");
			  		$row_grade5 = mysqli_fetch_assoc($tution_fee_for_grade5); 
						$grade5_tution_fee = $row_grade5['total_sum_grade5'];

						$books_fee_for_grade5 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade5 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '5'");
			  		$row_books_grade5 = mysqli_fetch_assoc($books_fee_for_grade5); 
						$grade5_books_fee = $row_books_grade5['total_sum_books_grade5'];

						$trans_fee_for_grade5 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade5 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '5'");
			  		$row_trans_grade5 = mysqli_fetch_assoc($trans_fee_for_grade5); 
						$grade5_tution_trans = $row_trans_grade5['total_sum_trans_grade5'];
			  	?>
			    Grade 5
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade5_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade5_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade5_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
				<a href="<?php echo BASE_URL; ?>pages/full_report?c=6">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade6 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade6 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '6'");
			  		$row_grade6 = mysqli_fetch_assoc($tution_fee_for_grade6); 
						$grade6_tution_fee = $row_grade6['total_sum_grade6'];

						$books_fee_for_grade6 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade6 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '6'");
			  		$row_books_grade6 = mysqli_fetch_assoc($books_fee_for_grade6); 
						$grade6_books_fee = $row_books_grade6['total_sum_books_grade6'];

						$trans_fee_for_grade6 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade6 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '6'");
			  		$row_trans_grade6 = mysqli_fetch_assoc($trans_fee_for_grade6); 
						$grade6_tution_trans = $row_trans_grade6['total_sum_trans_grade6'];
			  	?>
			    Grade 6
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade6_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade6_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade6_tution_trans; ?></span></h6>
			  </div>
			  </a>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade7 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade7 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '7'");
			  		$row_grade7 = mysqli_fetch_assoc($tution_fee_for_grade7); 
						$grade7_tution_fee = $row_grade7['total_sum_grade7'];

						$books_fee_for_grade7 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade7 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '7'");
			  		$row_books_grade7 = mysqli_fetch_assoc($books_fee_for_grade7); 
						$grade7_books_fee = $row_books_grade7['total_sum_books_grade7'];

						$trans_fee_for_grade7 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade7 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '7'");
			  		$row_trans_grade7 = mysqli_fetch_assoc($trans_fee_for_grade7); 
						$grade7_tution_trans = $row_trans_grade7['total_sum_trans_grade7'];
			  	?>
			    Grade 7
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade7_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade7_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade7_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade8 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade8 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '8'");
			  		$row_grade8 = mysqli_fetch_assoc($tution_fee_for_grade8); 
						$grade8_tution_fee = $row_grade8['total_sum_grade8'];

						$books_fee_for_grade8 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade8 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '8'");
			  		$row_books_grade8 = mysqli_fetch_assoc($books_fee_for_grade8); 
						$grade8_books_fee = $row_books_grade8['total_sum_books_grade8'];

						$trans_fee_for_grade8 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade8 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '8'");
			  		$row_trans_grade8 = mysqli_fetch_assoc($trans_fee_for_grade8); 
						$grade8_tution_trans = $row_trans_grade8['total_sum_trans_grade8'];
			  	?>
			    Grade 8
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade8_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade8_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade8_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade9 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade9 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '9'");
			  		$row_grade9 = mysqli_fetch_assoc($tution_fee_for_grade9); 
						$grade9_tution_fee = $row_grade9['total_sum_grade9'];

						$books_fee_for_grade9 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade9 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '9'");
			  		$row_books_grade9 = mysqli_fetch_assoc($books_fee_for_grade9); 
						$grade9_books_fee = $row_books_grade9['total_sum_books_grade9'];

						$trans_fee_for_grade9 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade9 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '9'");
			  		$row_trans_grade9 = mysqli_fetch_assoc($trans_fee_for_grade9); 
						$grade9_tution_trans = $row_trans_grade9['total_sum_trans_grade9'];
			  	?>
			    Grade 9
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade9_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade9_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade9_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>

		<div class="col-md-4 mb-2 text-dark fs-3">
			<div class="card">
			  <div class="card-body">
			  	<?php 
			  		$tution_fee_for_grade10 = mysqli_query($connection, "SELECT SUM(rev_fees) AS total_sum_grade10 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '10'");
			  		$row_grade10 = mysqli_fetch_assoc($tution_fee_for_grade10); 
						$grade10_tution_fee = $row_grade10['total_sum_grade10'];

						$books_fee_for_grade10 = mysqli_query($connection, "SELECT SUM(rev_books) AS total_sum_books_grade10 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '10'");
			  		$row_books_grade10 = mysqli_fetch_assoc($books_fee_for_grade10); 
						$grade10_books_fee = $row_books_grade10['total_sum_books_grade10'];

						$trans_fee_for_grade10 = mysqli_query($connection, "SELECT SUM(rev_transportation) AS total_sum_trans_grade10 FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_admission_class = '10'");
			  		$row_trans_grade10 = mysqli_fetch_assoc($trans_fee_for_grade10); 
						$grade10_tution_trans = $row_trans_grade10['total_sum_trans_grade10'];
			  	?>
			    Grade 10
			    <h6>Tution Fees pending <span class="text-danger">Rs.<?php echo $grade10_tution_fee; ?></span></h6>
			    <h6>Books Fees pending <span class="text-danger">Rs.<?php echo $grade10_books_fee; ?></span></h6>
			    <h6>Transportation Fees pending <span class="text-danger">Rs.<?php echo $grade10_tution_trans; ?></span></h6>
			  </div>
			</div>
		</div>
	</div>
</div>

<!-- Complete Modal -->
<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>

<!-- <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div> -->

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
    <div class="toast-header">
      <img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" class="rounded me-2" alt="..." width="55px" height="55px">
      <strong class="me-auto text-dark">Alert</strong>
      <!-- <small>11 mins ago</small> -->
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Login details has been sent to student registered Whatsapp number
    </div>
  </div>
</div>
<!-- <script src="assets/js/functions.js"></script> -->
