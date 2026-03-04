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
		
    // $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'");
    // if (mysqli_num_rows($fetch_teacher_details) > 0) {
    //      while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
    //         $user_name = htmlspecialchars($i['rev_user_name'], ENT_QUOTES, 'UTF-8');
    //         $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
    //         $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
    //         $school_id = htmlspecialchars($i['rev_user_school_id'], ENT_QUOTES, 'UTF-8');
    //      }  
    // }

    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$teacher_email_id' AND user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['user_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
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

<!-- Delete  -->

<?php 
	if (isset($_POST['del_btn'])) {
		$delete_id = mysqli_escape_string($connection, trim($_POST['del_id']));	
		if ($delete_id == "") {
			$error_message = "Something went wrong";
		}

		if (!isset($error_message)) {
			$fetch_delete_id = mysqli_query($connection, "SELECT * FROM erp_bill WHERE tree_id = '$delete_id' AND rev_sts = '1' AND rev_academic_year = '$academic_setter'");

			if (mysqli_num_rows($fetch_delete_id) > 0) {
				while($fred = mysqli_fetch_assoc($fetch_delete_id)) {
					$user_paid_to = $fred['rev_paid_to'];
					$user_amount = $fred['rev_amount'];
					$user_discount = $fred['rev_discount'];
					$user_id = $fred['rev_student_id'];
					$uniq_id = $fred['tree_id'];
				}

				$total_amount_paid = $user_amount + $user_discount;

				// Fetch_current_user_payment
				$fetch_current_paid_data = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$user_id' AND rev_sts = '1'");

				if (mysqli_num_rows($fetch_current_paid_data) > 0) {
					while($dfrs = mysqli_fetch_assoc($fetch_current_paid_data)) {
						$term_1_fee = $dfrs['rev_term1_fee'];
						$term_2_fee = $dfrs['rev_term2_fee'];
						$full_fee = $dfrs['rev_fees'];
						$books_fee = $dfrs['rev_books'];
						$trans_fee = $dfrs['rev_transportation'];
						$old_balance = $dfrs['rev_old_balance'];

					}
				}

				if ($user_paid_to == "rev_books") {
					$refund_amount = $books_fee + $total_amount_paid;
					$update_amount = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = '$refund_amount' WHERE tree_id = '$user_id' AND rev_sts = '1'");
					$update_bill = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$uniq_id' AND rev_sts = '1'");
					if (isset($update_bill)) {
						$error_message = "Success bill deleted";
					}
				}


				if ($user_paid_to == "rev_trans") {
					$refund_amount = $trans_fee + $total_amount_paid;
					$update_amount = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_transportation = '$refund_amount' WHERE tree_id = '$user_id' AND rev_sts = '1'");
					$update_bill = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$uniq_id' AND rev_sts = '1'");
					if (isset($update_bill)) {
						$error_message = "Success bill deleted";
					}
				}

				if ($user_paid_to == "term_1") {
					$refund_amount = $term_1_fee + $total_amount_paid;
					$refund_full_fee = $total_amount_paid + $full_fee;

					$update_amount = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$refund_amount', rev_fees = '$refund_full_fee' WHERE tree_id = '$user_id' AND rev_sts = '1'");

					$update_bill = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$uniq_id' AND rev_sts = '1'");
					if (isset($update_bill)) {
						$error_message = "Success bill deleted";
					}
				}

				if ($user_paid_to == "term_2") {
					$refund_amount = $term_2_fee + $total_amount_paid;
					$refund_full_fee = $total_amount_paid + $full_fee;

					$update_amount = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$refund_amount', rev_fees = '$refund_full_fee' WHERE tree_id = '$user_id' AND rev_sts = '1'");

					$update_bill = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$uniq_id' AND rev_sts = '1'");
					if (isset($update_bill)) {
						$error_message = "Success bill deleted";
					}
				}

				if ($user_paid_to == "full_fee") {
					// $refund_amount = $term_2_fee + $user_amount;
					$refund_full_fee = $total_amount_paid;
					$divide_amount = $total_amount_paid /2;

					$update_amount = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$divide_amount', rev_term2_fee = '$divide_amount', rev_fees = '$refund_full_fee' WHERE tree_id = '$user_id' AND rev_sts = '1'");

					$update_bill = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$uniq_id' AND rev_sts = '1'");
					if (isset($update_bill)) {
						$error_message = "Success bill deleted";
					}
				}

				// Custom fee
				if ($user_paid_to == "custom_fee") {
					// $refund_amount = $term_2_fee + $user_amount;
					$refund_full_fee = $total_amount_paid;
					$divide_amount = $total_amount_paid /2;
					$custome_amount = $full_fee + $refund_full_fee;

					$update_amount = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$divide_amount', rev_term2_fee = '$custome_amount', rev_fees = '$custome_amount' WHERE tree_id = '$user_id' AND rev_sts = '1'");

					$update_bill = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$uniq_id' AND rev_sts = '1'");
					if (isset($update_bill)) {
						$error_message = "Success bill deleted";
					}
				}

				// Old balance

				if ($user_paid_to == "old_balance") {
					$refund_amount = $total_amount_paid + $old_balance;
					// $refund_full_fee = $total_amount_paid + $full_fee;

					$update_amount = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_old_balance = '$refund_amount' WHERE tree_id = '$user_id' AND rev_sts = '1'");

					$update_bill = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$uniq_id' AND rev_sts = '1'");
					if (isset($update_bill)) {
						$error_message = "Success bill deleted";
					}
				}

			}
		}
	}
?>

<!-- Start_date -->
<?php 
	if (isset($_GET['st_date'])) {
		if ($_GET['st_date'] != "") {
			$st_date = htmlspecialchars($_GET['st_date'], ENT_QUOTES, 'UTF-8');
		} else {
			$st_date = date('Y-m-d');
		}
	} else {
		$st_date = date('Y-m-d');
	}

	if (isset($_GET['et_date'])) {
		if ($_GET['et_date'] != "") {
			$et_date = htmlspecialchars($_GET['et_date'], ENT_QUOTES, 'UTF-8');
		} else {
			$et_date = date('Y-m-d');
		}
	} else {
		$et_date = date('Y-m-d');
	}
?>

<?php 
	$update_student_name_and_father_name_in_erp_bill = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_sts = '1' AND rev_student_name = ''");
	if (mysqli_num_rows($update_student_name_and_father_name_in_erp_bill) > 0) {
		while($frdes = mysqli_fetch_assoc($update_student_name_and_father_name_in_erp_bill)) {
			$stident_id = $frdes['rev_student_id'];
			$get_user_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$stident_id' AND rev_sts = '1'");
			if (mysqli_num_rows($get_user_details) > 0) {
				while($bg = mysqli_fetch_assoc($get_user_details)) {
					$student_name_from_bill = $bg['rev_student_fname'] . 	' ' . $bg['rev_student_mname'] . ' ' . $bg['rev_student_lname'];
					$father_name_from_bill = $bg['rev_father_fname'] . ' ' . $bg['rev_father_mname'] . ' ' . $bg['rev_father_lname'];
					$up = mysqli_query($connection, "UPDATE erp_bill SET rev_student_name = '$student_name_from_bill', rev_student_father = '$father_name_from_bill' WHERE rev_student_id = '$stident_id'");
				}
			}
		}
	}




?>


<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<div class="container zindex-100 desk" style="margin-top: 10px">
	<div style="float: left;">
		<h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px; width: 170px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
	</div>
</div>
<section></section>
<div class="container full_fee_receipt" style="margin-top:-30px;">
	<div class="row">
		<div class="col-md-12">
			<div class="d-flex justify-content-between" style="margin-top:10px;">
				<h3 class="text-left">Tuition Fee till date</h3>
			</div>

				<div>
					<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModals">Select Date  <i class="fas fa-calendar-alt" style="font-size:16px;"></i></button>

					<button class="btn btn-info btn-sm" id="downloadExcel">Download Excel <i class="fas fa-file-excel" style="font-size:16px;"></i></button>

					<button class="btn btn-warning btn-sm" id="downloadPDF">Download PDF <i class="fas fa-file-pdf" style="font-size:16px;"></i></button>
					
				</div>

			<div class="d-flex justify-content-around">
				<button type="button" class="btn btn-outline-primary btn-sm">
				  Total Amount Collected Rs. 
				  <?php 
				  	$sql = "SELECT SUM(rev_amount) AS total_amount FROM erp_bill WHERE rev_sts = '1' AND rev_academic_year = '$academic_setter' AND rev_paid_on BETWEEN '$st_date' AND '$et_date'";
						$result = mysqli_query($connection, $sql);

						// Check if the query was successful
						if ($result) {
						    $row = mysqli_fetch_assoc($result);
						    echo number_format($row['total_amount'], 0, '.', ',');
						} 
				  ?>
				</button>

				<button type="button" class="btn btn-outline-primary btn-sm">
				  Total Tuition fee Rs. <?php 
				  	$sqls = "SELECT SUM(rev_amount) AS total_amounts FROM erp_bill WHERE (rev_paid_to = 'term_1' OR rev_paid_to = 'term_2' OR rev_paid_to = 'full_fee' OR rev_paid_to = 'custom_fee') AND rev_academic_year = '$academic_setter' AND rev_sts = '1' AND rev_paid_on BETWEEN '$st_date' AND '$et_date'";
						$results = mysqli_query($connection, $sqls);

						// Check if the query was successful
						if ($results) {
						    $rows = mysqli_fetch_assoc($results);
						    echo number_format($rows['total_amounts'], 0, '.', ',');
						} 
				  ?>
				</button>

				

				
			</div>
			<h3 class="text-center">Amount collected from date <?php echo date('d-M-Y', strtotime($st_date)); ?> to <?php echo date('d-M-Y', strtotime($et_date)); ?></h3>
			<input class="form-control form-control-md mt-2 mb-2 search" type="text" placeholder="Search Student Name" aria-label=".form-control-lg example">
			<div class="se_res"></div>
			<table class="table table-bordered text-dark" id="myTable">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Bill No.</th>
			      <th scope="col">Date</th>
			      <th scope="col">Student name & Father name</th>
			      <th scope="col">Class</th>
			      <th scope="col">Paid To</th>
			      <th scope="col">Amount</th>
			      <th scope="col">Discount</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php 
			  		$fetch_all_active_bills = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_sts = '1' AND rev_academic_year = '$academic_setter' AND rev_paid_on BETWEEN '$st_date' AND '$et_date' ORDER BY tree_id DESC");
			  		if (mysqli_num_rows($fetch_all_active_bills) > 0) {
			  			$i = 1;
			  			while($rs = mysqli_fetch_assoc($fetch_all_active_bills)) { ?>

			  				<tr id='<?php echo $rs['rev_student_id']; ?>'>
						      <th scope="row"><?php echo $i++; ?></th>
						      <td><?php echo htmlspecialchars($rs['rev_bill_number'], ENT_QUOTES, 'UTF-8'); ?></td>
						      <td><?php echo htmlspecialchars(date('d-M-Y', strtotime($rs['rev_paid_on'])), ENT_QUOTES, 'UTF-8'); ?></td>
						      <td>
						      	<?php 
						      		$st_id = $rs['rev_student_id'];
						      		$fetch_student_name = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$st_id' AND rev_sts = '1'");

						      		if (mysqli_num_rows($fetch_student_name) > 0) {
						      			while($d = mysqli_fetch_assoc($fetch_student_name)) {
						      				$student_f_name = $d['rev_student_fname'];
						      				
						      				$student_m_name = $d['rev_student_mname'];
						      				$student_l_name = $d['rev_student_lname'];

						      				$father_f_name = $d['rev_father_fname'];
						      				$father_m_name = $d['rev_father_mname'];
						      				$father_l_name = $d['rev_father_lname'];
						      				$student_class = $d['rev_admission_class'];
						      			}
						      		}

						      		if ($student_m_name != '0') {
						      				echo $student_m_name = $student_m_name;
						      		} else {
						      			$student_m_name = "";
						      		}

						      		if ($student_l_name != '0') {
						      				echo $student_l_name = $student_l_name;
						      		} else {
						      			$student_l_name = "";
						      		}

						      		if ($father_m_name != '0') {
						      				echo $father_m_name = $father_m_name;
						      		} else {
						      			$father_m_name = "";
						      		}

						      		if ($father_l_name != '0') {
						      				echo $father_l_name = $father_l_name;
						      		} else {
						      			$father_l_name = "";
						      		}

						      		echo $student_f_name . ' ' . $student_m_name . ' ' . $student_l_name . '<br>' . $father_f_name . ' ' . $father_m_name . ' ' . $father_l_name;
						      	?>

						    	</td>
						    	<td><?php echo $student_class; ?></td>
						      	<?php 
						      		if ($rs['rev_paid_to'] == "term_1") {
						      			$paid_to = "Term 1 Fee";
						      		}

						      		if ($rs['rev_paid_to'] == "term_2") {
						      			$paid_to = "Term 2 Fee";
						      		}

						      		if ($rs['rev_paid_to'] == "full_fee") {
						      			$paid_to = "Full Fee";
						      		}

						      		if ($rs['rev_paid_to'] == "custom_fee") {
						      			$paid_to = "Fee";
						      		}

						      		if ($rs['rev_paid_to'] == "rev_books") {
						      			$paid_to = "Books";
						      		}

						      		if ($rs['rev_paid_to'] == "rev_trans") {
						      			$paid_to = "Transportation";
						      		}

						      		if ($rs['rev_paid_to'] == "old_balance") {
						      			$paid_to = "old balance";
						      		}
						      	?>
						      <td><?php echo htmlspecialchars($paid_to, ENT_QUOTES, 'UTF-8'); ?></td>
						      <td>Rs. <?php echo htmlspecialchars($rs['rev_amount'], ENT_QUOTES, 'UTF-8'); ?></td>
						      <td>Rs. <?php echo htmlspecialchars($rs['rev_discount'], ENT_QUOTES, 'UTF-8'); ?></td>
						      <td class="d-flex justify-content-around">
						      	<a href="bill_generator?id=<?php echo htmlspecialchars($rs['tree_id'], ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-file-download" style="font-size:20px; color: green;"></i></a>
						      	<i class="fas fa-trash-alt" style="font-size:20px; color: red; cursor: pointer;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo htmlspecialchars($rs['rev_bill_number'], ENT_QUOTES, 'UTF-8'); ?>" data-bs-whatevern="<?php echo htmlspecialchars($rs['tree_id'], ENT_QUOTES, 'UTF-8'); ?>"></i>
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

<!-- Tution receipt -->
<!--Remove Modal -->
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
            <h5>All the associated data will be deleted</h5>
            <input type="hidden" class="form-control" id="recipient-name" name="del_id">
          </div>
          <button class="btn btn-primary" type="submit" name="del_btn">Submit</button>
          
        </form>
      </div>
      
    </div>
  </div>
</div>

<!-- Select Date -->
<div class="modal fade" id="exampleModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Select Date</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="get">
	        <div class="d-flex justify-content-around">
	        		<div>
	        			<label class="text-dark">Start date</label>
				  		<input type="date" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" max="<?php echo date('Y-m-d'); ?>" name="st_date" value="<?php echo date('Y-m-d'); ?>">
	        		</div>
	        		<div>
				  		<label class="text-dark">End date</label>
				  		<input type="date" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" max="<?php echo date('Y-m-d'); ?>" name="et_date" value="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>
				<div class="text-center">
					<button class="btn btn-success text-center mt-2">Get Data</button>
				</div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Select Date ended -->
<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>
<script type="text/javascript">
	

	$('#downloadExcel').click(function () {
    // Get the table element
    var table = document.getElementById('myTable');

    // Convert the table to a worksheet
    var worksheet = XLSX.utils.table_to_sheet(table);

    // Create a new workbook and append the worksheet
    var workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

    // Export the workbook as an Excel file
    XLSX.writeFile(workbook, 'full fee receipt <?php echo date('d-m-y'); ?>.xlsx');
    
});


	$('#downloadPDF').click(function () {
  // Import jsPDF and autoTable from the UMD module
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  // Convert HTML table to an array of rows and columns
  doc.autoTable({
    html: '#myTable',   // Select the HTML table by ID
    theme: 'striped',       // Optional: Use 'striped', 'grid', or 'plain' themes
    startY: 20           // Optional: Start the table at Y position 20
  });

  // Save the PDF with a filename
  doc.save('full fee receipt <?php echo date('d-m-y'); ?>.pdf');
});

	// modal data
	const exampleModal = document.getElementById('exampleModal')
if (exampleModal) {
  exampleModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const recipient = button.getAttribute('data-bs-whatever')
    const recipient2 = button.getAttribute('data-bs-whatevern')
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalTitle = exampleModal.querySelector('.modal-title')
    const modalBodyInput = exampleModal.querySelector('.modal-body input')
    // const modalBodyInput2 = exampleModal.querySelector('.modal-body .delete_id')

    modalTitle.textContent = `Are you sure to delete bill id ${recipient} ?`
    modalBodyInput.value = recipient2
    // modalBodyInput2 = recipient2
  })
}


// search
$('.search').keyup(function() {
	var q = $('.search').val();

	if (q.length == "") {
		$('.se_res').hide();
	}
	
	
$.post( "search_fee.php", {name: q, st_date: "<?php echo $st_date; ?>", et_date: "<?php echo $et_date; ?>"}).done(function( text ) {
    $('.se_res').html(text);
    if (q.length != "") {
		$('.se_res').show();
	}
  });
})
</script>