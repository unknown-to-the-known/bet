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
					<span class="position-relative z-index-1" style="font-size: 33px;">Details						
											
					</span>
				</h4>
			
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



<div class="container">
	<div style="width: 100%;  overflow-x: scroll; display:inline-flex;">
	<a href="<?php echo BASE_URL; ?>pages/fee_collection?c=all"><span class="badge text-bg-primary">All Students</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=baby"><span class="badge text-bg-primary">Grade Baby</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=lkg"><span class="badge text-bg-primary">Grade LKG</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=ukg"><span class="badge text-bg-primary">Grade UKG</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=1"><span class="badge text-bg-primary">Grade 1</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=2"><span class="badge text-bg-primary">Grade 2</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=3"><span class="badge text-bg-primary">Grade 3</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=4"><span class="badge text-bg-primary">Grade 4</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=5"><span class="badge text-bg-primary">Grade 5</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=6"><span class="badge text-bg-primary">Grade 6</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=7"><span class="badge text-bg-primary">Grade 7</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=8"><span class="badge text-bg-primary">Grade 8</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=9"><span class="badge text-bg-primary">Grade 9</span></a>
    <a href="<?php echo BASE_URL; ?>pages/fee_collection?c=10"><span class="badge text-bg-primary">Grade 10</span>
    </a>
    <br>
</div> 

	<div class="row">
		<div class="col-md-12">
				<table class="table text-dark">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Student Name</th>
				      <th scope="col">Father Name & <br> Number</th>
				      <th scope="col">Class</th>
				      <th scope="col">Pending School Fee</th>
				      <th scope="col">Pending Books Fee</th>
				      <th scope="col">Pending Transportation Fee</th>
				    </tr>
				  </thead>
				  <tbody>

				  	<?php 
				  	if ($selected_class == 'all') {
		    			$fethc_all_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND rev_sts = '1'");
		    		} else {
		    			$fethc_all_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND rev_sts = '1' AND rev_admission_class = '$selected_class'");
		    		} 

				  	
				  		// $fethc_all_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND rev_sts = '1'");

				  		if (mysqli_num_rows($fethc_all_student_details) > 0) {
				  			$i = 1;
				  			while($ftrd = mysqli_fetch_assoc($fethc_all_student_details)) { ?>
				  				<tr class="text-dark">
							      <th scope="row"><?php echo $i++; ?></th>
							      <td><?php echo $ftrd['rev_student_fname'] . ' ' . $ftrd['rev_student_mname'] . ' ' . $ftrd['rev_student_lname']; ?></td>
							      <td><?php echo $ftrd['rev_father_fname'] . ' ' . $ftrd['rev_father_mname'] . ' ' . $ftrd['rev_father_lname']; ?> <br> <?php echo $ftrd['rev_father_mobile']; ?></td>
							      <td><?php echo $ftrd['rev_admission_class']; ?></td>
							      <td>
							      	<?php echo $ftrd['rev_fees']; ?>
							      </td>
							      <td><?php echo $ftrd['rev_books']; ?></td>
							      <td><?php echo $ftrd['rev_transportation']; ?></td>
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

<!-- Payment modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form action="" method="post">
	          <div class="mb-3">
	            <label for="recipient-name" class="col-form-label">Recipient:</label>
	            <input type="hidden" class="form-control paying_to" name="paying_to">
	            <input type="hidden" class="form-control student_name" name="student_name">
	            <input type="hidden" class="form-control student_id" name="student_id">
	            <input type="hidden" class="form-control total_amount" name="total_amount">
	            <label for="recipient-name" class="col-form-label">Discount:</label>
	            <input type="text" class="form-control" placeholder="Discount" name="discount">
	            <label for="recipient-name" class="col-form-label">Receipt No.</label>
	            

	            <input type="text" class="form-control" placeholder="Receipt No." name="receipt_no">
	            <label for="recipient-name" class="col-form-label">UTR No.</label>
	            <small style="color:red;">Use only while paying through UPI</small>
	            <input type="text" class="form-control" placeholder="UTR NO." name="utr_no">

	          </div>
	          <div class="img_src"></div>
	          <button type="submit" class="btn btn-primary" name="upi">Pay By UPI</button>
	          <button type="submit" class="btn btn-primary" name="cash">Pay By Cash</button>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        
	      </div>
	    </div>
	  </div>
	</div>
<!-- Payment modal ended -->







<!--Remove Modal -->


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
	$('.searchquery').keyup(function() {
		var search_q = $('.searchquery').val();
		var sel_class = "<?php echo $selected_class; ?>";
		$.post( "search.php", { search: search_q, seal_class: sel_class }).done(function( data ) {
			// console.log(data);
		    $('.search_result').html(data);
		  });
	})
	$(".form").submit(function(e){
        e.preventDefault();
    });

    


    // Payment code
    const exampleModal_payment = document.getElementById('exampleModal')
	if (exampleModal_payment) {
	  exampleModal_payment.addEventListener('show.bs.modal', event => {
	    // Button that triggered the modal
	    const button = event.relatedTarget
	    // Extract info from data-bs-* attributes
	    const amount_name = button.getAttribute('data-bs-whatever')
	    const total_amount = button.getAttribute('data-bs-whatever_amount')
	    const student_id = button.getAttribute('data-bs-whatever_student_id')
	    const student_name = button.getAttribute('data-bs-whatever_student_name')
	    // If necessary, you could initiate an Ajax request here
	    // and then do the updating in a callback.

	    if (amount_name == 'term_1' || amount_name == "term_2" || amount_name == "term_3" || amount_name == "full_fee") {
	    	$('.img_src').html("<img src='../IMG_3511.JPG'>");
	    }

	    if (amount_name == 'book') {
	    	$('.img_src').html("<img src='../IMG_3512.JPG'>");
	    	// console.log('book');
	    }

	    if (amount_name == 'trans') {
	    	$('.img_src').html("<img src='../IMG_3513.JPG'>");
	    }
	    // console.log(amount_name);
	    // Update the modal's content.
	    const modalTitle = exampleModal_payment.querySelector('.modal-title')
	    const modalBodyInput_paying_to = exampleModal_payment.querySelector('.modal-body .paying_to')
	    const modalBodyInput = exampleModal_payment.querySelector('.modal-body .total_amount')
	    const modalBodyInput_student_id = exampleModal_payment.querySelector('.modal-body .student_id')
	    const modalBodyInput_student_name = exampleModal_payment.querySelector('.modal-body .student_name')

	    modalTitle.textContent = `${student_name} ${amount_name} fee details`
	    modalBodyInput.value = total_amount
	    modalBodyInput_student_id.value = student_id
	    modalBodyInput_student_name.value = student_name
	    modalBodyInput_paying_to.value = amount_name
	  })
	}
    // Payment code ended
</script>