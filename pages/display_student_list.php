<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php
	// if (isset($_COOKIE['aut'])) {
	// 	$auto_login_code = htmlspecialchars($_COOKIE['aut'], ENT_QUOTES, 'UTF-8');
	// 	$fetch_user_auto_login_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_auto_login = '$auto_login_code' AND rev_teach_sts = '1'");

	// 	if (mysqli_num_rows($fetch_user_auto_login_details) > 0) {
	// 		while($j = mysqli_fetch_assoc($fetch_user_auto_login_details)) {
	// 			$user_email = htmlspecialchars($j['rev_teach_email'], ENT_QUOTES, 'UTF-8');
	// 			 $_SESSION['teach_details'] = $user_email;
	// 			  // header("Location: " . BASE_URL . 'pages/action');	
	// 		}
	// 	}
	// }

	if (isset($_SESSION['teach_details'])) {
	       $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
	} else {
	    header("Location: " . BASE_URL . 'index');
	}
?>

<?php 
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$teacher_email_id' AND user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['user_name'], ENT_QUOTES, 'UTF-8');
            $user_gender = "School";
            $school_name = "School";
            $school_id = htmlspecialchars($i['user_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>

<?php 
    if (isset($_SESSION['academic_setter'])) {
        $academic_setter = $_SESSION['academic_setter'];
    } else {
        $academic_setter = '2025_26';
    }

    $academic_setter = str_replace('-', '_', $academic_setter);
?>

<?php 
	function generateUniqueRandomAlphabets($length = 32) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    if ($length > strlen($characters)) {
        throw new Exception("Cannot generate a non-repeating string longer than 52 characters using only alphabets.");
    }

    $shuffled = str_shuffle($characters);
    return substr($shuffled, 0, $length);
}

$uniq_id = generateUniqueRandomAlphabets(32);	

	if (isset($_POST['cash'])) {		
		$today_date = date('Y-m-d H:i');		
		$paying_to = mysqli_escape_string($connection, trim($_POST['paying_to']));
		$paying_student_name = mysqli_escape_string($connection, trim($_POST['student_name']));
		$paying_student_id = mysqli_escape_string($connection, trim($_POST['student_id']));
		$paying_amount = mysqli_escape_string($connection, trim($_POST['total_amount']));
		$paying_discount = mysqli_escape_string($connection, trim($_POST['discount']));
		 $paying_receipt = mysqli_escape_string($connection, trim($_POST['receipt_no'])); 
		$paying_utr = mysqli_escape_string($connection, trim($_POST['utr_no']));
		// $paying_date = mysqli_escape_string($connection, trim($_POST['date']));
		$just_date = mysqli_escape_string($connection, trim($_POST['date']));
		$erp_note = mysqli_escape_string($connection, trim($_POST['note']));

		if ($paying_to == "" || $paying_student_name == "" || $paying_student_id == "" || $paying_amount == "" || $just_date == "" || $paying_receipt == "") {
			$error_message = "Please fill all fields";
		}

		if ($paying_discount == "") {
			$paying_discount = '0';
		}

		if ($paying_utr == "") {
			$paying_utr = 'cash';
		} else {
			$paying_utr = $paying_utr;
		}


		// if ($_SERVER['HTTP_HOST'] == 'anand.revisewell.com') {
		// 	if ($paying_to == 'old_balance') {
		// 		$fetch_receipt_id = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_paid_to = 'old_balance' AND rev_sts = '1'");
		// 			if (mysqli_num_rows($fetch_receipt_id) > 0) {
		// 				while($hgtd = mysqli_fetch_assoc($fetch_receipt_id)) {
		// 					$old_number = $hgtd['rev_bill_number'];
		// 				}
		// 			}

		// 			$paying_receipt = $old_number + 1;
		// 	} else {
		// 		$fetch_receipt_id = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_paid_to = 'custom_fee' AND rev_sts = '1'");
		// 			if (mysqli_num_rows($fetch_receipt_id) > 0) {
		// 				while($hgtd = mysqli_fetch_assoc($fetch_receipt_id)) {
		// 					$old_number = $hgtd['rev_bill_number'];
		// 				}
		// 			}

		// 			$paying_receipt = $old_number + 1;
		// 	}
		// } else {
		// 	$fetch_receipt_id = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_sts = '1'");
		// 			if (mysqli_num_rows($fetch_receipt_id) > 0) {
		// 				while($hgtd = mysqli_fetch_assoc($fetch_receipt_id)) {
		// 					$old_number = $hgtd['rev_bill_number'];
		// 				}
		// 			}

		// 			$paying_receipt = $old_number + 1;
		// }

		if (!isset($error_message)) {
					if ($paying_to == "term_1") {
						$select_term_1 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_1) > 0) {
							while($term_1_data = mysqli_fetch_assoc($select_term_1)) {
								$old_term1_data = $term_1_data['rev_term1_fee'];
								$total_fee = $term_1_data['rev_fees'];
							}

							if ($paying_amount > $total_fee) {
								$error_message = "Paying amount is more than required amount";
							}

							if (!isset($error_message)) {
								$new_term_1 = $old_term1_data - ($paying_amount + $paying_discount);
								$new_total_fee = $total_fee - ($paying_amount + $paying_discount);

							$update_term_1 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$new_term_1', rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");

							$insert_into_bill_section = "INSERT INTO erp_bill(rev_student_id,rev_bill_number,rev_paid_to,rev_amount,rev_paid_on,rev_sts, rev_discount,rev_academic_year, erp_mode, erp_note) VALUES('$paying_student_id', '$paying_receipt','term_1', '$paying_amount', '$just_date', '1', '$paying_discount', '$academic_setter', '$paying_utr', '$note')";

							if (mysqli_query($connection, $insert_into_bill_section)) {
									  $last_id = mysqli_insert_id($connection);
								}

							$insert = mysqli_query($connection,"INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id, rev_school_id) VALUES ('$paying_student_id', '$paying_to', 'admin_account', '$paying_amount', '$paying_discount', '$paying_receipt', '$paying_utr', '$today_date', '1', '$order_id', '$school_id')");
								header("Location: " . BASE_URL . 'pages/bill_generator?id=' . $last_id);
							}
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

							if ($paying_amount > $total_fee) {
								$error_message = "Paying amount is more than required amount";
							}

							if (!isset($error_message)) {
								$new_term_2 = $old_term2_data - ($paying_amount + $paying_discount);
								$new_total_fee = $total_fee - ($paying_amount + $paying_discount);

							$update_term_2 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$new_term_2', rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");

							$insert_into_bill_section = "INSERT INTO erp_bill(rev_student_id,rev_bill_number,rev_paid_to,rev_amount,rev_paid_on,rev_sts, rev_discount,rev_academic_year, erp_mode) VALUES('$paying_student_id', '$paying_receipt','term_2', '$paying_amount', '$just_date', '1', '$paying_discount', '$academic_setter', '$paying_utr')";

							if (mysqli_query($connection, $insert_into_bill_section)) {
									  $last_id = mysqli_insert_id($connection);
								}

							$insert = mysqli_query($connection,"INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id, rev_school_id) VALUES ('$paying_student_id', '$paying_to', 'admin_account', '$paying_amount', '$paying_discount', '$paying_receipt', '$paying_utr', '$today_date', '1', '$order_id', '$school_id')");
								header("Location: " . BASE_URL . 'pages/bill_generator?id=' . $last_id);
							}
						}
					}

					// full fee
					if ($paying_to == "full_fee") {
						// echo 'ok';
						$select_term_full_fee = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_full_fee) > 0) {
							while($term_full_data = mysqli_fetch_assoc($select_term_full_fee)) {
								// $old_term_full_data = $term_full_data['rev_fees'];
								$total_fee = $term_full_data['rev_fees'];
							}

							if ($paying_amount > $total_fee) {
								$error_message = "Paying amount is more than required amount";
							}							 

							if (!isset($error_message)) {
								// $new_term_2 = $old_term2_data - ($paying_amount + $paying_discount);
							 $new_total_fee = $total_fee - ($paying_amount + $paying_discount);

							$update_term_2 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '0', rev_term1_fee = '0', rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");

							$insert_into_bill_section = "INSERT INTO erp_bill(rev_student_id,rev_bill_number,rev_paid_to,rev_amount,rev_paid_on,rev_sts, rev_discount,rev_academic_year, erp_mode) VALUES('$paying_student_id', '$paying_receipt','full_fee', '$paying_amount', '$just_date', '1', '$paying_discount', '$academic_setter', '$paying_utr')";

							if (mysqli_query($connection, $insert_into_bill_section)) {
									  $last_id = mysqli_insert_id($connection);
								}

							$insert = mysqli_query($connection,"INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id, rev_school_id) VALUES ('$paying_student_id', '$paying_to', 'admin_account', '$paying_amount', '$paying_discount', '$paying_receipt', '$paying_utr', '$today_date', '1', '$order_id', '$school_id')");
								header("Location: " . BASE_URL . 'pages/bill_generator?id=' . $last_id);
							}
						}
					}

					// Custom fee
					if ($paying_to == "custom_fee") {
						// echo 'ok';
						// echo "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'";
						$select_term_1 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						// if ($payment_mode == '') {
						// 	$paying_utr = 'online';
						// } else {
						// 	$paying_utr = 'cash';
						// }

						if (mysqli_num_rows($select_term_1) > 0) {
							while($term_1_data = mysqli_fetch_assoc($select_term_1)) {
								// $old_term1_data = $term_1_data['rev_term1_fee'];
								$total_fee = $term_1_data['rev_fees'];
							}

							if ($paying_amount > $total_fee) {
								$error_message = "Paying amount is more than required amount";
							}



							if (!isset($error_message)) {
								$new_term_1 = $old_term1_data - ($paying_amount + $paying_discount);
								$new_total_fee = $total_fee - ($paying_amount + $paying_discount);

							$update_term_1 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");
							
								$insert_into_bill_section = "INSERT INTO erp_bill(rev_student_id,rev_bill_number,rev_paid_to,rev_amount,rev_paid_on,rev_sts, rev_discount,rev_academic_year, erp_mode,erp_note,collected_by) VALUES('$paying_student_id', '$paying_receipt','custom_fee', '$paying_amount', '$just_date', '1', '$paying_discount', '$academic_setter', '$paying_utr', '$erp_note', '$user_name')";
							

							if (mysqli_query($connection, $insert_into_bill_section)) {
								$last_id = mysqli_insert_id($connection);
							}

							$insert = mysqli_query($connection,"INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id, rev_school_id) VALUES ('$paying_student_id', '$paying_to', 'admin_account', '$paying_amount', '$paying_discount', '$paying_receipt', '$paying_utr', '$today_date', '1', '$order_id', '$school_id')");
								header("Location: " . BASE_URL . 'pages/bill_generator?id=' . $last_id);
							}
						}
					}

					// Books
							if ($paying_to == "book") {
									$select_term_full_fee = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

									if (mysqli_num_rows($select_term_full_fee) > 0) {
										while($term_full_data = mysqli_fetch_assoc($select_term_full_fee)) {
											// $old_term_full_data = $term_full_data['rev_fees'];
											$total_fee = $term_full_data['rev_books'];
										}

										if ($paying_amount > $total_fee) {
											$error_message = "Paying amount is more than required amount";
										}

										if (!isset($error_message)) {
											// $new_term_2 = $old_term2_data - ($paying_amount + $paying_discount);
											$new_total_fee = $total_fee - ($paying_amount + $paying_discount);

										// $update_term_2 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = 'new_total_fee', rev_term1_fee = '0', rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");

										$insert_into_bill_section = "INSERT INTO erp_bill(rev_student_id,rev_bill_number,rev_paid_to,rev_amount,rev_paid_on,rev_sts, rev_discount,rev_academic_year,erp_mode,erp_note) VALUES('$paying_student_id', '$paying_receipt','rev_books', '$paying_amount', '$just_date', '1', '$paying_discount', '$academic_setter', '$paying_utr','$erp_note')";

										if (mysqli_query($connection, $insert_into_bill_section)) {
												  $last_id = mysqli_insert_id($connection);
											}


											$update = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = '$new_total_fee' WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

										$insert = mysqli_query($connection,"INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id, rev_school_id) VALUES ('$paying_student_id', '$paying_to', 'admin_account', '$paying_amount', '$paying_discount', '$paying_receipt', '$paying_utr', '$today_date', '1', '$order_id', '$school_id')");
											header("Location: " . BASE_URL . 'pages/bill_generator?id=' . $last_id);
										}
									}
								}


					// Trans
							if ($paying_to == "trans") {
						// echo 'ok';
						$select_term_full_fee = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_full_fee) > 0) {
							while($term_full_data = mysqli_fetch_assoc($select_term_full_fee)) {
								// $old_term_full_data = $term_full_data['rev_fees'];
								$total_fee = $term_full_data['rev_transportation'];
							}

							if ($paying_amount > $total_fee) {
								$error_message = "Paying amount is more than required amount";
							}

							if (!isset($error_message)) {
								// $new_term_2 = $old_term2_data - ($paying_amount + $paying_discount);
								$new_total_fee = $total_fee - ($paying_amount + $paying_discount);

							// $update_term_2 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = 'new_total_fee', rev_term1_fee = '0', rev_fees = '$new_total_fee' WHERE tree_id = '$paying_student_id'");

							$insert_into_bill_section = "INSERT INTO erp_bill(rev_student_id,rev_bill_number,rev_paid_to,rev_amount,rev_paid_on,rev_sts, rev_discount,rev_academic_year,erp_mode,erp_note) VALUES('$paying_student_id', '$paying_receipt','rev_trans', '$paying_amount', '$just_date', '1', '$paying_discount', '$academic_setter', '$paying_utr','$erp_note')";

							if (mysqli_query($connection, $insert_into_bill_section)) {
									  $last_id = mysqli_insert_id($connection);
								}


								$update = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_transportation = '$new_total_fee' WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

							$insert = mysqli_query($connection,"INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id, rev_school_id) VALUES ('$paying_student_id', '$paying_to', 'admin_account', '$paying_amount', '$paying_discount', '$paying_receipt', '$paying_utr', '$today_date', '1', '$order_id', '$school_id')");
								header("Location: " . BASE_URL . 'pages/bill_generator?id=' . $last_id);
							}
						}
					}




					// old balance fee
					if ($paying_to == "old_balance") {
						// echo 'ok';
						// echo "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'";
						$select_term_1 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$paying_student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_1) > 0) {
							while($term_1_data = mysqli_fetch_assoc($select_term_1)) {
								// $old_term1_data = $term_1_data['rev_term1_fee'];
								$total_fee = $term_1_data['rev_old_balance'];
							}

							if ($paying_amount > $total_fee) {
								$error_message = "Paying amount is more than required amount";
							}

							if (!isset($error_message)) {
								// $new_term_1 = $old_term1_data - ($paying_amount + $paying_discount);
								$new_total_fee = $total_fee - ($paying_amount + $paying_discount);

							$update_term_1 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_old_balance = '$new_total_fee' WHERE tree_id = '$paying_student_id'");

							$insert_into_bill_section = "INSERT INTO erp_bill(rev_student_id,rev_bill_number,rev_paid_to,rev_amount,rev_paid_on,rev_sts, rev_discount,rev_academic_year, erp_mode,erp_note) VALUES('$paying_student_id', '$paying_receipt','old_balance', '$paying_amount', '$just_date', '1', '$paying_discount', '$academic_setter', '$paying_utr','$erp_note')";

							if (mysqli_query($connection, $insert_into_bill_section)) {
								$last_id = mysqli_insert_id($connection);
							}

							$insert = mysqli_query($connection,"INSERT INTO erp_payment_details(rev_student_id,rev_paid_to,	rev_payment_mode,rev_payment_amount,rev_discount,rev_recept_id,rev_utr_id,rev_paid_date_time,rev_sts, rev_order_id, rev_school_id) VALUES ('$paying_student_id', '$paying_to', 'admin_account', '$paying_amount', '$paying_discount', '$paying_receipt', '$paying_utr', '$today_date', '1', '$order_id', '$school_id')");
								header("Location: " . BASE_URL . 'pages/bill_generator?id=' . $last_id);
							}
						}
					}
		}
	}
?>
<?php 
	if (isset($_POST['delete'])) {
		$delete_id = mysqli_escape_string($connection, trim($_POST['del_id']));

		if ($delete_id == "") {
			$error_message = "Something went wrong";
		}		

		if (!isset($error_message)) {
			$check_ownership = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$delete_id' AND rev_sts = '1' || rev_sts = '2'");
			if (mysqli_num_rows($check_ownership) > 0) {
				$update_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_sts = '0' WHERE tree_id = '$delete_id'");
				if (isset($update_student_details)) {
					$error_message = "Success, Student data removed";	
				}
			}
		}
	}
?>


<?php 
	if (isset($_GET['c'])) {
    	if ($_GET['c'] != "") {
        	$selected_class = htmlspecialchars($_GET['c'], ENT_QUOTES, 'UTF-8');
    	} else {
        	$selected_class = 'baby';
    	}
	} else {
        $selected_class = 'baby';
    }
?>

<?php 
	if (isset($_GET['p'])) {
		if ($_GET['p'] != "") {
			$pending_selected = htmlspecialchars($_GET['p'], ENT_QUOTES, 'UTF-8');
		} 
	} 
?>

<!-- Fetch last successfull bill number -->
<?php 
	$fetch_bill_number = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_sts = '1'");

	if (mysqli_num_rows($fetch_bill_number) > 0) {
		while($kk = mysqli_fetch_assoc($fetch_bill_number)) {
			$last_bill_number = $kk['rev_bill_number'];
		}
	}

	$new_bill_number = $last_bill_number + 1;
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
		<h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px; width: 270px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
	</div>

	<div style="float:right; text-decoration: underline; cursor:pointer;" class="text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal_year">
    <i class="fas fa-graduation-cap"></i> Year <?php echo htmlspecialchars(str_replace('_', '-', $academic_setter), ENT_QUOTES, 'UTF-8'); ?>
  </div>
</div>

	<!-- Content START -->
	<section style="margin-top: -20;">
	<div class="container">
		<div class="row d-lg-flex justify-content-md-center g-md-5">
			<?php 
				if (isset($error_message)) {
					echo $error_message;
				}
			?>
			<!-- Left content START -->
				<h4 class="fs-1 fw-bold mb-4 text-center" style="margin-top:-20px;">
					<img src="<?php echo BASE_URL; ?>assets/images/student_list.webp" width="50px" height="50px" alt="Homework">
					<span class="position-relative z-index-9" style="font-size: 30px; font-family: 'Nunito Sans', sans-serif;">Student list</span>
				</h4>
		</div> <!-- Row END -->
	</div>


<div class="container" style="margin-top: -20px;">
	<?php 
		$fetch_fee_structure_data = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_year = '$academic_setter' AND master_sts = '1'");
		if (mysqli_num_rows($fetch_fee_structure_data) > 0) { ?>
			<a href="<?php echo BASE_URL; ?>pages/add_student?uniq_id=<?php echo $uniq_id; ?>" style="text-decoration: none;"><div class="badge bg-info bg-opacity-10 text-info mb-4 fw-bold btn-transition float-start" style="float: left; margin-top: -5px; font-size: 12px; cursor: pointer;"><i class="fas fa-plus" style="font-size:18px;"></i><br>Add Student</div></a>
	<?php } ?>
	
	<div style="width: 100%; overflow-x: scroll; display: inline-flex;">
	    <?php
		    $classes = ['baby', 'lkg', 'ukg', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Pending'];
		    $query = "SELECT DISTINCT master_class FROM erp_master_details WHERE master_year = '$academic_setter' AND master_sts = '1'";
		    $result = mysqli_query($connection, $query);
		    
		    $available_classes = [];
		    while ($row = mysqli_fetch_assoc($result)) {
		        $available_classes[] = $row['master_class'];
		    }
		    
		    foreach ($classes as $class) {
		        if ($class === 'all' || in_array($class, $available_classes)) {
		            echo "<a href='" . BASE_URL . "pages/display_student_list?c=$class'><span class='badge text-bg-primary'>Grade " . ucfirst($class) . "</span></a>";
		        }
		    }
	    ?>
	</div> 

    <div class="row" id="studentList">
    		<?php 
    			$fetch_all_student_list_1 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND rev_sts != '0' AND rev_admission_class = '$selected_class' AND rev_academic_year = '$academic_setter' ORDER BY rev_student_fname ASC");
    		?>

    			<table class="table" id="studentTable" style="display: none;">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Student Name</th>
				      <th scope="col">Father Name</th>
				      <th scope="col">Mobile Number</th>
				      <th scope="col">Section</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php 
				  		if (mysqli_num_rows($fetch_all_student_list_1)) {
				  			$i = 1;
				  			while($fde = mysqli_fetch_assoc($fetch_all_student_list_1)) { ?>
				  			<tr>
						      <th scope="row"><?php echo $i++; ?></th>
						      <td><?php echo htmlspecialchars($fde['rev_student_fname'], ENT_QUOTES, 'UTF-8'); ?></td>
						      <td><?php echo htmlspecialchars($fde['rev_father_fname'], ENT_QUOTES, 'UTF-8'); ?></td>
						      <td><?php echo htmlspecialchars($fde['rev_father_mobile'], ENT_QUOTES, 'UTF-8'); ?></td>
						      <td><?php echo htmlspecialchars(ucfirst($fde['rev_section']), ENT_QUOTES, 'UTF-8'); ?></td>
						    </tr>
				  		<?php }
				  		  } ?>
				  </tbody>
				</table>

    	<?php 
    		if ($selected_class == 'all') {
    			$fetch_all_student_list = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND rev_sts = '2'  AND rev_academic_year = '$academic_setter' ORDER BY rev_student_fname ASC");
    		} else {
    			$fetch_all_student_list = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND rev_sts != '0' AND rev_admission_class = '$selected_class' AND rev_academic_year = '$academic_setter' ORDER BY rev_student_fname ASC");
    		}    		

    		if (mysqli_num_rows($fetch_all_student_list) > 0) { ?>
    			<input class="form-control form-control-lg searchquery" type="text" placeholder="Search Student name" aria-label=".form-control-lg example" style="margin: 10px 0 10px 0;">
    			<div class="search_result"></div>
    			<div class="d-flex justify-content-between">
    				<span class="badge rounded-pill text-bg-primary"><i class="fas fa-users"></i> Class Strength: <?php echo mysqli_num_rows($fetch_all_student_list); ?></span>
    				<span class="badge rounded-pill text-bg-success showA" style="cursor:pointer;"><i class="fas fa-school"></i> Section A </span>
    				<span class="badge rounded-pill text-bg-info showB" style="cursor:pointer;"><i class="fas fa-school"></i> Section B </span>
    				<span class="badge rounded-pill text-bg-danger" id="exportExcel" style="cursor: pointer;"><i class="fas fa-file-excel"></i> Download List</span>
    			</div>
    			
    			<?php
    				while($rd = mysqli_fetch_assoc($fetch_all_student_list)) { 
    					$student_sec = $rd['rev_section'];
    					if ($rd['rev_student_mname'] != '0') {
    						$full_name = $rd['rev_student_fname'] . ' ' . $rd['rev_student_mname'];
    					} 
    					if($rd['rev_student_lname'] != '0') {
    						$full_name = $rd['rev_student_fname'] . ' ' . $rd['rev_student_lname'];
    					}

    					if ($rd['rev_student_mname'] == "0" AND $rd['rev_student_lname'] == '0') {
    						$full_name = $rd['rev_student_fname'];
    					}

    					// Father name
    					if ($rd['rev_father_mname'] != '0') {
    						$full_name_father = $rd['rev_father_fname'] . ' ' . $rd['rev_father_mname'];
    					} 
    					if($rd['rev_father_lname'] != '0') {
    						$full_name_father = $rd['rev_father_fname'] . ' ' . $rd['rev_father_lname'];
    					}

    					if ($rd['rev_father_mname'] == "0" AND $rd['rev_father_lname'] == '0') {
    						$full_name_father = $rd['rev_father_fname'];
    					}
    				
    			?>

    				<div class="col-md-4 mb-4 section section<?php echo ucfirst($student_sec); ?>" style="font-family: 'Nunito Sans', sans-serif;">
				        <div class="card">
				          <div class="card-body">
				          	<?php 
				          		if ($rd['rev_sts'] == '2') { ?>
				          			<span class="badge text-bg-danger float-end">Pending</span>
				          	<?php } ?>

				          	<?php 
				          		if ($rd['rev_sts'] == '3') { ?>
				          			<span class="badge text-bg-info float-end">Paused</span>
				          	<?php } ?>

				          	<?php 
				          		if ($rd['rev_rte'] == '58000') { ?>
				          			<span class="badge text-bg-danger float-end">RTE</span>
				          		<?php } ?>
				            	<h5 class="card-title font-weight-bold sec" id="<?php echo $rd['tree_id']; ?>" style="font-family: 'Nunito Sans', sans-serif;"><?php echo ucfirst($full_name); ?>
				            		<small class="text-dark fw-bold float-end">F: <?php echo $full_name_father; ?></small>
				        		</h5>

				        	
				            <p class="card-text">
				              <span class="student-class"><span class="class-label">Grade&amp;Sec:</span> <?php echo htmlspecialchars(ucfirst($rd['rev_admission_class']), ENT_QUOTES, 'UTF-8'); ?> &amp; <?php echo htmlspecialchars(ucfirst($rd['rev_section']), ENT_QUOTES, 'UTF-8'); ?></span>
				              <i class="bi bi-telephone"></i> <a href="tel:+91<?php echo htmlspecialchars($rd['rev_father_mobile'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($rd['rev_father_mobile'], ENT_QUOTES, 'UTF-8'); ?></a>
				            </p>
				            <div class="d-flex justify-content-around">
				            	<!-- for admission fee -->
				            		<?php 
				            			if ($rd['rev_admission_fee'] != '0') {
				            				$sch_fee = (float) $rd['rev_admission_fee'];
				            				$admisson_fee = (float) $rd['rev_fees'];
				            				$full_fee_with_admission = $admisson_fee;
				            			}else {
				            				$full_fee_with_admission = $rd['rev_fees'];
				            			}
				            		?>

				            	<!-- For admission fee ended -->
				            	<?php 
				            		if ($full_fee_with_admission > 0) { ?>
				            			<p style="line-height: 10px; cursor:pointer;" class="btn btn-danger-soft btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="custom_fee" data-bs-whatever_amount="<?php echo htmlspecialchars($full_fee_with_admission, ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars(ucfirst($full_name), ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-school"></i> Rs. <?php echo htmlspecialchars($full_fee_with_admission, ENT_QUOTES, 'UTF-8'); ?></p>
				            	<?php } else { ?>
				            			<p style="line-height: 10px; cursor:pointer;" class="btn btn-danger-soft btn-sm"><i class="fas fa-school"></i> Rs. <?php echo htmlspecialchars($full_fee_with_admission, ENT_QUOTES, 'UTF-8'); ?></p>
				            	<?php } ?>
				              
				            	<!-- Books -->
				            	<?php 
				            		if ($rd['rev_books'] > 0) { ?>
				              			<p style="line-height: 10px; color:chocolate;" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="book" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_books'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer;"><i class="fas fa-book"></i> Rs. <?php echo htmlspecialchars($rd['rev_books'], ENT_QUOTES, 'UTF-8'); ?></p>
						          <?php } else { ?>
						          		<p style="line-height: 10px; color:chocolate;" class="btn btn-warning btn-sm" style="cursor:pointer;"><i class="fas fa-book"></i> Rs. <?php echo htmlspecialchars($rd['rev_books'], ENT_QUOTES, 'UTF-8'); ?></p>
						          <?php } ?>

						        <!-- Trans -->
						        <?php 
				            		if ($rd['rev_transportation'] > 0) { ?>	
					              <p style="line-height: 10px; color:purple;" class="btn btn-info-soft btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="trans" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_transportation'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer;"><i class="fas fa-bus-alt"></i> Rs. <?php echo htmlspecialchars($rd['rev_transportation'], ENT_QUOTES, 'UTF-8'); ?></p>
					            <?php } else { ?>
					            	<p style="line-height: 10px; color:purple;" class="btn btn-info-soft btn-sm" style="cursor:pointer;"><i class="fas fa-bus-alt"></i> Rs. <?php echo htmlspecialchars($rd['rev_transportation'], ENT_QUOTES, 'UTF-8'); ?></p>

					            <?php } ?>

				            </div>

				            <div class="payment_button">
				            	<div class="d-flex badge-container">
				            		<?php 
				            			if ($rd['rev_term1_fee'] != '0') { ?>
				            				<span class="badge badge-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="term_1" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_term1_fee'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer;">Term 1<br>Rs.<small><?php echo htmlspecialchars($rd['rev_term1_fee'], ENT_QUOTES, 'UTF-8'); ?></small></span>
				            			<?php }	?>
					              

				            			<?php 
				            			if ($rd['rev_term2_fee'] != '0') { ?>
							              <span class="badge badge-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="term_2" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_term2_fee'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer;">Term 2<br>Rs.<small><?php echo htmlspecialchars($rd['rev_term2_fee'], ENT_QUOTES, 'UTF-8'); ?></small></span>
					          			<?php } ?>


					              
					          			<?php 
				            			if ($rd['rev_fees'] != '0') { ?>
							              <span class="badge badge-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="full_fee" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_fees'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer;">Full fee<br>Rs.<small><?php echo htmlspecialchars($rd['rev_fees'], ENT_QUOTES, 'UTF-8'); ?></small></span>
							          <?php } ?>

							          <?php 
				            			if ($rd['rev_fees'] != '0') { ?>
							              <span class="badge badge-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="custom_fee" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_fees'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer;">Custom fee</span>
							          <?php } ?>

							          <?php 
				            			if ($rd['rev_books'] != '0') { ?>
								              <span class="badge badge-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="book" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_books'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer;">Books fee<br>Rs.<small><?php echo htmlspecialchars($rd['rev_books'], ENT_QUOTES, 'UTF-8'); ?></small></span>
								      <?php } ?>	 

								      <?php 
								      	if ($rd['rev_transportation'] != '0') { ?>
							              <span class="badge badge-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="trans" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_transportation'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer;">Pay Transportation fee<br>Rs.<small><?php echo htmlspecialchars($rd['rev_transportation'], ENT_QUOTES, 'UTF-8'); ?></small></span>
							          <?php } ?>

							          <!-- Old balance -->
							          
					            </div>
				            </div>
				            

				            <div class="d-flex justify-content-around">
				            	<a href="<?php echo BASE_URL; ?>pages/full_details?id=<?php echo htmlspecialchars($rd['tree_id'], ENT_QUOTES, 'UTF-8'); ?>" style="width:33%;"><button class="btn btn-outline-info btn-sm"><i class="fas fa-info-circle"></i> Details</button></a>
				            	<?php 
				            		if ($rd['rev_sts'] != '1') { ?>
				            			
				            		<?php } else { ?>
				            			
				            			<button class="btn btn-outline-success btn-sm whatsapp" style="width:33%; margin-left:-15px;"  id="<?php echo htmlspecialchars($rd['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
				            				<i class="fab fa-whatsapp"></i> Remind</button>
				            		<?php }	?>
				            		<!-- <form action="" method="post" style="display: inline-flex;"> -->
				            			<input type="hidden" name="del_id" value="<?php echo htmlspecialchars($rd['tree_id'], ENT_QUOTES, 'UTF-8'); ?>" style="margin-top: -10px;">
				            			<button class="btn btn-outline-danger btn-sm" type="button" style="padding: 5px; width:33%" data-bs-toggle="modal" data-bs-target="#delete" data-bs-whatever="<?php echo $rd['tree_id']; ?>" data-bs-whatever1="<?php echo htmlspecialchars($rd['rev_student_fname'], ENT_QUOTES, 'UTF-8'); ?>">Delete
				            				<i class="fas fa-trash-alt"></i>
				            			</button>
				            		<!-- </form> -->
				            </div>
				            <?php 
						      	if ($rd['rev_old_balance'] != '0') { ?>
					              <span class="badge text-bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="old_balance" data-bs-whatever_amount="<?php echo htmlspecialchars($rd['rev_old_balance'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatever_student_id="<?php echo $rd['tree_id']; ?>" data-bs-whatever_student_name="<?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?>" style="cursor:pointer; width: 100%; padding: 10px;">Pay old balance Rs.<small><?php echo htmlspecialchars($rd['rev_old_balance'], ENT_QUOTES, 'UTF-8'); ?></small></span>
					          <?php } ?>
				          </div>
				        </div>
				      </div>
    			<?php }
    		} else {
    			echo 'No Students present for selected class';
    		}
    	?>            
    </div>
  </div>

<div class="row">
    <div class="col-md-12">
       <div role="region1" aria-labelledby="caption" tabindex="0">
    	<table class="table_scroll1" id="tbl_exporttable_to_xls" style="display: none;">
        <!-- <caption id="caption">Baseball numbers mmkay.</caption> -->
        <thead>
            <tr class="text-center">
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">#</span></th>
              <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Name</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">ID</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Phone number</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Section</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Gender</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">First Language</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Second Language</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Third Language</span></th>
            </tr>
        </thead>
        <tbody>
            <?php 
	      		$fetch_all_student_list = mysqli_query($connection,"SELECT * FROM rev_student_login WHERE rev_student_sch = '$user_school' AND rev_student_class = '$subject_class_yt'  AND rev_student_sts = '1' AND rev_student_id != '0' AND rev_student_sec = '$class_sec'");

	      		if (mysqli_num_rows($fetch_all_student_list) > 0) {
	      			$i = 1;
	      			while($jh = mysqli_fetch_assoc($fetch_all_student_list)) { ?>
	      				<tr class="text-center" style="font-size: 18px" id="<?php echo htmlspecialchars($jh['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
	      				  <th><?php echo $i++; ?></th>
				          <th><?php echo htmlspecialchars(ucfirst($jh['rev_student_name']), ENT_QUOTES, 'UTF-8'); ?> 
				          </th>
				          <td><?php echo htmlspecialchars($jh['rev_student_id'], ENT_QUOTES, 'UTF-8'); ?></td>
				          <td><i class="fas fa-phone-volume" style="font-size: 18px; color: #0CBC87"></i>&nbsp;<?php echo htmlspecialchars($jh['rev_student_phone'], ENT_QUOTES, 'UTF-8'); ?></td>
				          <td><?php echo htmlspecialchars(ucfirst($jh['rev_student_sec']), ENT_QUOTES, 'UTF-8'); ?></td>
				          <td><?php echo htmlspecialchars(ucfirst($jh['rev_gender']), ENT_QUOTES, 'UTF-8'); ?></td>
				          <td><?php echo htmlspecialchars(ucfirst($jh['rev_student_first']), ENT_QUOTES, 'UTF-8'); ?></td>
				          <td><?php echo htmlspecialchars(ucfirst($jh['rev_student_second']), ENT_QUOTES, 'UTF-8'); ?></td>
				          <td><?php echo htmlspecialchars(ucfirst($jh['rev_student_third']), ENT_QUOTES, 'UTF-8'); ?></td>
				        </tr>
	      				<?php }                    
            } 
            ?>	      	
        </tbody>
    </table>

</div>
</div>
</div>
</div>
</section>

<!-- Term 1 -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel" style="font-family: 'Nunito Sans'">New message</h1>        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <p style="color:crimson; text-align:center; font-size:18px; font-weight:bold; margin-bottom:-20px;" class="amount_pending"></p>
      <div class="modal-body">
      	<div class="negative_msg" style="color: crimson; font-size: 18px; text-align: center; text-align: center; border: 1px solid crimson; border-radius: 10px;">
      		Alert Discount is more than the total amount, Please enter valid amount
      	</div>     	

      	<div class="postive_msg" style="color: crimson; font-size: 18px; text-align: center; text-align: center; border: 1px solid crimson; border-radius: 10px;">
      		Alert Entered amount is more than the pending amount, Please enter valid amount
      	</div>
        <form action="" method="post">
	          <div class="mb-3">
	            <!-- <label for="recipient-name" class="col-form-label">Recipient:</label> -->
	            <input type="hidden" class="form-control paying_to" name="paying_to">
	            <input type="hidden" class="form-control student_name" name="student_name">
	            <input type="hidden" class="form-control student_id" name="student_id">
	            <div class="d-flex justify-content-around">
	            	<div>	            		
	            		<label for="recipient-name" class="col-form-label text-dark" style="margin-bottom:-10px;">Amount:</label>
		            	<input type="number" class="form-control total_amount" placeholder="amount" name="total_amount" autocomplete="off">
		            </div>
	            	<div>	            		
	            		<label for="recipient-name" class="col-form-label text-dark" style="margin-bottom:-10px;">Discount:</label>
		            	<input type="number" class="form-control discount" placeholder="Discount" name="discount" value="0" autocomplete="off">
		            </div>
		            <div>
		            	<label for="recipient-name" class="col-form-label text-dark" style="margin-bottom:-10px;">Receipt No.</label>
		            	<input type="text" class="form-control" placeholder="Receipt No." name="receipt_no" value="<?php echo $new_bill_number; ?>" disabled>
		          	</div>
	            </div>

	            	<div class="d-flex justify-content-around">
	            		<label for="recipient-date" class="col-form-label text-dark" style="margin-bottom:-10px;">Date
	            			<input type="date" class="form-control" placeholder="date" name="date" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
	            		</label>
	            		
	            		<br>
	            		<label for="recipient-name" class="col-form-label text-dark utr">UTR No.<br><span class="col-form-label  mode_text_2" style="margin-bottom:-20px; color: red;">(By default it's cash enter UTR number to make it as Online)</span>
				            <input type="text" class="form-control" placeholder="UTR NO." name="utr_no" autocomplete="off">
				        </label>

				        <!-- <label for="recipient-name" class="col-form-label text-dark" style="font-size:14px;">Mode of payment
				            <div class="form-check">
							  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="online">
							  <label class="form-check-label" for="exampleRadios1" style="font-size:14px;">
							    Online
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="offline" checked>
							  <label class="form-check-label" for="exampleRadios2" style="font-size:14px;">
							    Offline
							  </label>
							</div>
				        </label> -->
				        <div>
				        	<p class="col-form-label text-dark mode_text" style="margin-bottom:-10px;">Mode of Payment<br><span style="color:red;">(Select only for online)</span></p>
				        	
					        <button class="btn btn-info btn-sm online" type="button"><i class="fas fa-globe-asia"></i> Online</button>
		            		
		            	</div>
	            	</div>

	            	<div class="col-md-12 mt-2">
	            		<div class="form-floating">
						  <textarea class="form-control" placeholder="Note" id="floatingTextarea" name="note"></textarea>
						  <label for="floatingTextarea">Notes</label>
						</div>
	            	</div>
	          </div>
	          <button type="submit" class="btn btn-outline-success pay" name="cash" style="width: 100%;">Submit</button>
	        </form>
      </div>
    </div>
  </div>
</div>
<!-- Term 1 ended -->

<!-- Delete student modal -->

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family: 'Nunito Sans', sans-serif;">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="" method="post">
          <div class="mb-3">
            <input type="hidden" class="form-control" id="recipient-name" name="del_id">
          </div>
          <button class="btn btn-outline-danger" name="delete" type="submit">Delete Student</button>
        </form>
      </div>
      
    </div>
  </div>
</div>
<!-- Delete modal ended -->
<!-- Toast -->
<!-- Bootstrap Toast -->
<div id="liveToast" class="toast align-items-center text-bg-info border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body" id="toastMessage">
      <!-- Message will be updated dynamically -->
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<!-- Complete Modal -->
<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>

<script type="text/javascript">
    $('.whatsapp').click(function() {
        var st_id = $(this).attr('id');
        $.post("whatsapp.php?uniq=<?php echo uniqid(); ?>", { student_id: st_id }).done(function(text) {
            showToast("Remainder Sent successfully");
        });
    });

    function showToast(message) {
        $('#toastMessage').text(message); // Update toast body
        var toastEl = document.getElementById('liveToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
</script>



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



<script type="text/javascript">
  function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('tbl_exporttable_to_xls');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fn || ('Grade <?php echo $subject_class_yt; ?> sec <?php echo $class_sec; ?> Student-list.' + (type || 'xlsx')));
  }

  function myFunction() {
      const element = document.getElementById("content");
      element.scrollIntoView();
    }
</script>

<script type="text/javascript">
	$('.utr').hide();
	$('.online').click(function() {
		$('.utr').show();
		$('.mode_text').hide();
		$('.online').hide();
		$('.mode_text_2').show();
	})
	

	$(document).ready(function () {
    $('.negative_msg, .postive_msg, .payment_button').hide();

    $('.searchquery').keyup(function () {
        let search_q = $(this).val();
        let sel_class = "<?php echo $selected_class; ?>";

        $.post("search.php", { search: search_q, seal_class: sel_class }, function (data) {
            $('.search_result').html(data);
        });
    });

    $(".form").submit(function (e) {
        e.preventDefault();
    });

    $('.pay_now_btn').click(function () {
        $('.payment_button').toggle();
    });

    $('.pay').click(function() {
    	$('.pay').hide();
    })

    const exampleModal_payment = document.getElementById('exampleModal');
    if (exampleModal_payment) {
        exampleModal_payment.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const amount_name = button.getAttribute('data-bs-whatever');
            const total_amount = parseFloat(button.getAttribute('data-bs-whatever_amount'));
            const student_id = button.getAttribute('data-bs-whatever_student_id');
            const student_name = button.getAttribute('data-bs-whatever_student_name');

            const modalTitle = exampleModal_payment.querySelector('.modal-title');
            const modalBodyInput_paying_to = exampleModal_payment.querySelector('.modal-body .paying_to');
            const modalBodyInput = exampleModal_payment.querySelector('.modal-body .total_amount');
            const modalBodyInput_student_id = exampleModal_payment.querySelector('.modal-body .student_id');
            const modalBodyInput_student_name = exampleModal_payment.querySelector('.modal-body .student_name');

            let formattedName = amount_name.replace(/_/g, ' ');
            modalTitle.textContent = `${student_name} Payment Page`;
            // modalBodyInput.value = total_amount;
            modalBodyInput_student_id.value = student_id;
            modalBodyInput_student_name.value = student_name;
            modalBodyInput_paying_to.value = amount_name;

            $('.amount_pending').text("Pending Amount Rs. " + total_amount);

			$('.discount').off('keyup').on('keyup', function () {
			    let discount = parseFloat($('.discount').val()) || 0;

			    if (discount < 0) {
			        $('.negative_msg').show();
			        $('.postive_msg').hide();
			        $('.pay').hide();
			        $('.total_amount, .payable_amount').val('');
			        return;
			    }

			    if (discount > total_amount) {
			        $('.postive_msg').show();
			        $('.negative_msg').hide();
			        $('.pay').hide();
			        $('.total_amount, .payable_amount').val('');
			        return;
			    }

			    let payable = total_amount - discount;

			    // Convert to string without trailing zeros
			    let payableText = parseFloat(payable.toFixed(10)).toString();

			    $('.total_amount').val(payableText);
			    $('.payable_amount').val(payableText);

			    $('.negative_msg, .postive_msg').hide();
			    $('.pay').show();
			});




        });
    }

    // QR Code button
    $('.qrcode_btn').click(function () {
        let t_amount = $('.total_amount').val();
        let amount_name = $('.paying_to').val();
        let { qrUrl } = generateQRCode(amount_name, t_amount);
        $('.qr_htl').html(`<img src="${qrUrl}" width='100%' style='border:1px solid red; padding: 1px; border-radius:10px;'>`);
    });

    // WhatsApp button
    $('.whatsapp_btn').click(function () {
        let t_amount = $('.total_amount').val();
        let amount_name = $('.paying_to').val();
        let userPhone = '919164454002';

        let { upiLink } = generateQRCode(amount_name, t_amount);

        let chatId = userPhone + "@c.us";

        $.ajax({
            type: "POST",
            url: "send_whatsapp.php",
            data: {
                chatId: chatId,
                amou: t_amount,
                paying_to: amount_name,
                message: upiLink
            },
            success: function (res) {
                alert("Payment link sent via WhatsApp!");
                console.log(res);
            },
            error: function (err) {
                alert("Failed to send WhatsApp message.");
                console.error(err);
            }
        });
    });

    const exampleModal = document.getElementById('delete');
    if (exampleModal) {
        exampleModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const recipient = button.getAttribute('data-bs-whatever');
            const recipients = button.getAttribute('data-bs-whatever1');
            const modalTitle = exampleModal.querySelector('.modal-title');
            const modalBodyInput = exampleModal.querySelector('.modal-body input');

            modalTitle.textContent = `Are you sure to delete ${recipients}?`;
            modalBodyInput.value = recipient;
        });
    }

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
});


</script>

<!-- Excel Sheet -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
   document.getElementById('exportExcel').addEventListener('click', function () {
    const table = document.getElementById('studentTable');
    const workbook = XLSX.utils.table_to_book(table, { sheet: "Students" });
    XLSX.writeFile(workbook, 'students_list.xlsx');
  });

   // Student_section

    $(".showA").click(function(){
      $('.sectionA').show();
      $('.sectionB').hide();
    });

    // When user clicks "Show Section B"
    $(".showB").click(function(){
      $('.sectionB').show();
      $('.sectionA').hide();
    });

    
</script>