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

	// if (isset($_SESSION['teach_details'])) {
	//         $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
	// } else {
	//     header("Location: " . BASE_URL . 'index');
	// }
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

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php
				if(isset($_POST['code']) && !empty($_POST['code']) && $_POST['code']=="PAYMENT_ERROR"){
    				echo "Txn id: ".$_POST['transactionId']." Status : ".$_POST['code'] . "Error";
				}else{
					$tran_id = $_POST['transactionId'];
					$update = mysqli_query($connection, "UPDATE erp_payment_details SET rev_sts = '1' WHERE rev_order_id = '$tran_id' AND rev_sts = '2'");

					$fetch_paid_to = mysqli_query($connection, "SELECT * FROM erp_payment_details WHERE rev_order_id = '$tran_id' AND rev_sts = '1'");

					if (mysqli_num_rows($fetch_paid_to) > 0) {
						while($frt = mysqli_fetch_assoc($fetch_paid_to)) {
							$paid_to = $frt['rev_paid_to'];
							$payment_amount = $frt['rev_payment_amount'];
							$student_id = $frt['rev_student_id'];
						}
					}
					// Term 1
					if ($paid_to == "term_1") {
						$select_term_1 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_1) > 0) {
							while($term_1_data = mysqli_fetch_assoc($select_term_1)) {
								$old_term1_data = $term_1_data['rev_term1_fee'];
								$total_fee = $term_1_data['rev_fees'];
							}

							$new_term_1 = $old_term1_data - $payment_amount;
							$new_total_fee = $total_fee - $payment_amount;

							$update_term_1 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$new_term_1' WHERE tree_id = '$student_id'");

							$update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$student_id'");
						}
					}
					// Term 2

					if ($paid_to == "term_2") {
						$select_term_2 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_2) > 0) {
							while($term_2_data = mysqli_fetch_assoc($select_term_2)) {
								$old_term2_data = $term_2_data['rev_term2_fee'];
								$total_fee = $term_2_data['rev_fees'];
							}

							$new_term_2 = $old_term2_data - $payment_amount;
							$new_total_fee = $total_fee - $payment_amount;

							$update_term_2 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$new_term_2' WHERE tree_id = '$student_id'");

							$update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$student_id'");
						}
					}


					// Term 3

					if ($paid_to == "term_3") {
						$select_term_3 = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_3) > 0) {
							while($term_3_data = mysqli_fetch_assoc($select_term_3)) {
								$old_term3_data = $term_3_data['rev_term3_fee'];
								$total_fee = $term_3_data['rev_fees'];
							}

							$new_term_3 = $old_term3_data - $payment_amount;
							$new_total_fee = $total_fee - $payment_amount;

							$update_term_3 = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term3_fee = '$new_term_3' WHERE tree_id = '$student_id'");

							$update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$student_id'");
						}
					}


					// Full Fee

					if ($paid_to == "full_fee") {
						$select_term_full_fee = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");

						if (mysqli_num_rows($select_term_full_fee) > 0) {
							while($term_full_fee_data = mysqli_fetch_assoc($select_term_full_fee)) {
								// $old_term3_data = $term_3_data['rev_term3_fee'];
								$total_fee = $term_full_fee_data['rev_fees'];
							}

							// $new_term_3 = $old_term3_data - $payment_amount;
							$new_total_fee = $total_fee - $payment_amount;

							$update_term_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee', rev_term3_fee = '0', rev_term2_fee = '0', rev_term1_fee = '0'  WHERE tree_id = '$student_id'");

							$update_full_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_fees = '$new_total_fee' WHERE tree_id = '$student_id'");
						}
					}
					

					// echo 'Payment Success';
					// header("Location: " . BASE_URL . 'pages/display_student_list');
					header( "refresh:5;url=" . BASE_URL . 'pages/display_student_list');


				    // echo "Txn id: ".$_POST['transactionId']." Status : ".$_POST['code'] . "Success";
				}

				?>
		</div>
	</div>
</div>
<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>