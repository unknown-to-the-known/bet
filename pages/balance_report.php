<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php //date_default_timezone_set('Asia/Kolkata'); ?>
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
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$teacher_email_id' AND user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['user_name'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['user_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>

<?php 
	if (isset($_SESSION['academic_setter']) && is_string($_SESSION['academic_setter'])) {
    	$academic_setter = $_SESSION['academic_setter'];
	} else {
	    $academic_setter = '2025_26';
	}

	$academic_setter = str_replace('-', '_', $academic_setter);
	 
?>







<?php
	// STEP 1: Collect all class fee data
	$classes = ['baby', 'lkg', 'ukg', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
	$class_fees = [];

	foreach ($classes as $class) {
		// echo "SELECT master_name, master_amount FROM erp_master_details WHERE master_year = '2025_26' AND master_sts = '1' AND master_class = '$class'";
	    $query = mysqli_query($connection, "SELECT master_name, master_amount FROM erp_master_details WHERE master_year = '2025_26' AND master_sts = '1' AND master_class = '$class'");

	    if (mysqli_num_rows($query) > 0) {
	        while ($row = mysqli_fetch_assoc($query)) {
	            $name = strtolower(trim($row['master_name']));
	            $value = $row['master_amount'];
	            $class_fees[$class][$name] = $value;  // Store numeric fee value
	        }
	    }
	}
?>

<?php 
	function formatFullName($fname, $mname, $lname) {
	    $parts = [];
	    if (!empty($fname) && $fname !== '0') $parts[] = $fname;
	    if (!empty($mname) && $mname !== '0') $parts[] = $mname;
	    if (!empty($lname) && $lname !== '0') $parts[] = $lname;
	    return implode(' ', $parts);
	}
?>

<?php 
	if (isset($_GET['id'])) {
		if ($_GET['id'] != '') {
			$selected_class_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
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
		<h3>Select Class</h3>
		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=baby">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade Baby
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=lkg">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade LKG
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=ukg">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade UKG
				  </div>
				</div>
			</a>
		</div>


		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=1">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 1
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=2">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 2
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=3">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 3
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=4">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 4
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=5">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 5
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=6">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 6
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=7">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 7
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=8">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 8
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=9">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 9
				  </div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-2">
			<a href="<?php echo BASE_URL; ?>pages/balance_report?id=10">
				<div class="card border">
				  <div class="card-body text-info fw-bold">
				    Grade 10
				  </div>
				</div>
			</a>
		</div>
		<?php 
			    // echo "SELECT * FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_academic_year = '$academic_setter'";
			    $fetch_all_active_bills = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_sts = '1' AND rev_academic_year = '$academic_setter' AND rev_admission_class = '$selected_class_id'");

			    if (mysqli_num_rows($fetch_all_active_bills) > 0) { ?>
		<div class="col-md-12">
			<div class="d-flex justify-content-between" style="margin-top:10px;">
				<h3 class="text-left">Grade <?php echo ucfirst($selected_class_id); ?> Balance fee till date</h3>
			</div>
				<div>
					<button class="btn btn-info btn-sm" id="downloadExcel">Download Excel <i class="fas fa-file-excel" style="font-size:16px;"></i></button>
					<button class="btn btn-warning btn-sm" id="downloadPDF">Download PDF <i class="fas fa-file-pdf" style="font-size:16px;"></i></button>
				</div>

			
			<!-- <h3 class="text-center">Amount collected from date <?php echo date('d-M-Y', strtotime($st_date)); ?> to <?php echo date('d-M-Y', strtotime($et_date)); ?></h3> -->
			<input class="form-control form-control-md mt-2 mb-2 search" type="text" placeholder="Search Student Name" aria-label=".form-control-lg example">
			<div class="se_res"></div>
			<div class="table-responsive">
			<table class="table table-bordered text-dark" id="myTable">
			  <thead class="table-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Student name & Father name</th>
			      <th scope="col">Class</th>
			      <th scope="col">(Term Fee + Tuition Fee + S D F) - Discount</th>
			      <th scope="col">Paid Till Date</th>
			      <th scope="col">Balance Amount Till Date</th>
			      <th scope="col">Old Balance Till Date &<br>Old Balance Discount Till Date</th>
			      <th scope="col">Phone</th>
			    </tr>
			  </thead>
			  <tbody>
			    <?php 
			        $i = 1;
			        while($rs = mysqli_fetch_assoc($fetch_all_active_bills)) { 
			            $temp_class = $rs['rev_admission_class'];
			            $term_fee = isset($class_fees[$temp_class]['term fee']) ? (float)$class_fees[$temp_class]['term fee'] : 0;
			            $tuition_fee = isset($class_fees[$temp_class]['tuition fee']) ? (float)$class_fees[$temp_class]['tuition fee'] : 0;
			            $admission_fee = (float)$rs['rev_admission_fee'];
			            $total_fee = $term_fee + $tuition_fee + $admission_fee;
			            $paid_till = (float)$rs['rev_fees']; // Adjust if needed
			            $student_id_for_bill = $rs['tree_id'];
			            $fetch_in_bill_discount_current_year = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_student_id = '$student_id_for_bill' AND rev_paid_to = 'custom_fee' AND rev_academic_year = '$academic_setter' AND rev_sts = '1'");
			            if (mysqli_num_rows($fetch_in_bill_discount_current_year) > 0) {
			            		while($b_d = mysqli_fetch_assoc($fetch_in_bill_discount_current_year)) {
			            			$bill_discount += $b_d['rev_discount'];
			            		}
			            }
			             
			            $fetch_in_bill_discount_old_year = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_student_id = '$student_id_for_bill' AND rev_paid_to = 'old_balance' AND rev_academic_year = '$academic_setter' AND rev_sts = '1'");
			            if (mysqli_num_rows($fetch_in_bill_discount_old_year) > 0) {
			            		while($b_d_s = mysqli_fetch_assoc($fetch_in_bill_discount_old_year)) {
			            			$bill_discount_old_balance += $b_d_s['rev_discount'];
			            		}
			            } else {
			            	$bill_discount_old_balance = '0';
			            }


			            // if ($bill_discount_old_balance == '') {
			            // 	$bill_discount_old_balance = '0';
			            // }


			            $discount = (float)$rs['rev_consession'] + $bill_discount;
			            $balance_amount = $total_fee - ($paid_till + $discount);
			            $phone = $rs['rev_father_mobile'];
			            $old_balance = $rs['rev_old_balance'];

			            // Add highlight class if discount is present
			            $row_class = $old_balance > 0 ? 'table-danger' : '';
			    ?>
			        <tr class="<?php echo $row_class; ?>">
			          <th scope="row"><?php echo $i++; ?></th>
			          <td>
			            <a href="<?php echo BASE_URL; ?>pages/full_details?id=<?php echo htmlspecialchars($rs['tree_id'],ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(formatFullName($rs['rev_student_fname'], $rs['rev_student_mname'], $rs['rev_student_lname']), ENT_QUOTES, 'UTF-8'); ?></a><br>&<?php echo htmlspecialchars(formatFullName($rs['rev_father_fname'], $rs['rev_father_mname'], $rs['rev_father_lname']), ENT_QUOTES, 'UTF-8'); ?></td>
			          <td><?php echo htmlspecialchars($temp_class, ENT_QUOTES, 'UTF-8'); ?></td>
			          <td>(Rs. <?php echo number_format($term_fee); ?> + Rs. <?php echo number_format($tuition_fee); ?> + Rs. <?php echo number_format($admission_fee); ?>) - Rs. <?php echo number_format($discount); ?> </td>
			          
			          <td>Rs. <?php echo number_format($balance_amount); ?></td>
			          <td>Rs. <?php echo number_format($paid_till); ?></td>
			          <td>Rs. <?php echo ($old_balance); ?> <br> Rs. <?php echo ($bill_discount_old_balance); ?></td>
			          <td><?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?></td>
			        </tr>
			    <?php 
			        }
			    
			    ?>
			  </tbody>
			</table>
		</div>

		</div>
	<?php } ?>
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