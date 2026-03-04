<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<!-- Delete the files from all bill folder -->
<?php 
	require '../vendor/autoload.php'; // Make sure AWS SDK is installed

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// === DigitalOcean Spaces Configuration ===
$spaceName = 'rev-users'; // Your DO Space name
$region = 'blr1';          // Your region (e.g., blr1, nyc3)
$accessKey = 'DO00H47WCGZNWF2D3JWV';
$secretKey = '2cpLmblWbg2pTxMc3wVR6l3cy9qp0m28rcgITySFJBQ';
$endpoint = "https://{$region}.digitaloceanspaces.com";

// === Initialize the S3 Client ===
$s3 = new S3Client([
    'version' => 'latest',
    'region' => $region,
    'endpoint' => $endpoint,
    'credentials' => [
        'key' => $accessKey,
        'secret' => $secretKey,
    ],
    'bucket_endpoint' => false,
    'use_path_style_endpoint' => false,
]);

// === Folder/Prefix to Delete Files From ===
$folder = 'receipts/'; // End with slash (e.g., 'receipts/' or 'tmp/')

try {
    // List all objects in the folder
    $objects = $s3->listObjectsV2([
        'Bucket' => $spaceName,
        'Prefix' => $folder,
    ]);

    if (!empty($objects['Contents'])) {
        foreach ($objects['Contents'] as $object) {
            $s3->deleteObject([
                'Bucket' => $spaceName,
                'Key' => $object['Key'],
            ]);
        }
        // echo "All files in folder '{$folder}' deleted successfully.";
    } else {
        // echo "No files found in '{$folder}'.";
    }

} catch (S3Exception $e) {
    // echo 'S3 Error: ' . $e->getMessage();
}




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
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_user_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            // echo $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['rev_user_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>

<?php 
	if (isset($_GET['id'])) {
		if($_GET['id'] != "") {
			$receipt_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
		} else {
			header("Location: " . BASE_URL . 'pages/display_student_list');
		}
	} else {
		header("Location: " . BASE_URL . 'pages/display_student_list');
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
	$fetch_bill_details = mysqli_query($connection, "SELECT * FROM erp_bill WHERE tree_id = '$receipt_id' AND rev_sts = '1'");

	if (mysqli_num_rows($fetch_bill_details) > 0) {
		while($fds = mysqli_fetch_assoc($fetch_bill_details)) {
			$student_id = $fds['rev_student_id'];
			$student_bill_number = $fds['rev_bill_number'];
			$student_amount = htmlspecialchars($fds['rev_amount'], ENT_QUOTES, 'UTF-8');
			// $number = $fds['rev_amount'];
			$student_date = $fds['rev_paid_on'];
			$student_discount = $fds['rev_discount'];
			$student_academic_year = $fds['rev_academic_year'];
			$paid_to = htmlspecialchars($fds['rev_paid_to'], ENT_QUOTES, 'UTF-8');
			$erp_mode = htmlspecialchars($fds['erp_mode'], ENT_QUOTES, 'UTF-8');
			$search_student_name = htmlspecialchars($fds['rev_student_name'], ENT_QUOTES, 'UTF-8');
			$search_father_name = htmlspecialchars($fds['rev_student_father'], ENT_QUOTES, 'UTF-8');
			$student_note = htmlspecialchars($fds['erp_note'], ENT_QUOTES, 'UTF-8');
			$collected_by = htmlspecialchars($fds['collected_by'], ENT_QUOTES, 'UTF-8');
		}

	}

	$student_academic_year = str_replace('-', '_', $student_academic_year);


	$fetch_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");

	if (mysqli_num_rows($fetch_student_details) > 0) {
		while($d = mysqli_fetch_assoc($fetch_student_details)) {
			$student_f_name = $d['rev_student_fname'];
			$student_m_name = $d['rev_student_mname'];
			$student_l_name = $d['rev_student_lname'];
			$student_father_fname = $d['rev_father_fname'];
			$student_father_mname = $d['rev_father_mname'];
			$student_father_lname = $d['rev_father_lname'];
			$student_class = $d['rev_admission_class'];
			$student_sec = 'a';
			$student_sats = $d['rev_sats'];
			$student_mobile = $d['rev_father_mobile'];
			$student_full_amount = $d['rev_fees'];
			$student_book_old_amount = $d['rev_books'];
			$student_trans_fee = $d['rev_transportation'];
			$student_admission_fee = $d['rev_admission_fee'];
			$student_old_balance = $d['rev_old_balance'];
			$student_consession = $d['rev_consession'];
			$student_trans_fixed_amount = $d['rev_trans_fixed_amount'];
		}
	}
	
	$student_full_amount = $student_full_amount;
	$father_name_for_search = $student_father_fname . ' ' . $student_father_mname . ' ' . $student_father_lname;
	$student_name_for_search = $student_f_name . ' ' . $student_m_name . ' ' . $student_l_name;

	if ($search_student_name == '0') {
		$update = mysqli_query($connection, "UPDATE erp_bill SET rev_student_name = '$father_name_for_search', rev_student_father = '$student_name_for_search' WHERE tree_id = '$receipt_id'");
	}


	// Convert number

	
function numberToWords($number) {
    $words = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety'
    );

    if ($number == 0) {
        return 'zero';
    }

    if ($number < 21) {
        return $words[$number];
    }

    if ($number < 100) {
        return $words[($number - $number % 10)] . ($number % 10 != 0 ? '-' . $words[$number % 10] : '');
    }

    if ($number < 1000) {
        return $words[intval($number / 100)] . ' hundred' . ($number % 100 != 0 ? ' and ' . numberToWords($number % 100) : '');
    }

    if ($number < 1000000) {
        return numberToWords(intval($number / 1000)) . ' thousand' . ($number % 1000 != 0 ? ' ' . numberToWords($number % 1000) : '');
    }
}

$student_amount_in_words = numberToWords($student_amount);
	if ($student_m_name != '0' AND $student_l_name != '0') {
		$student_name = $student_f_name . ' ' . $student_m_name . ' ' . $student_l_name;
	} else {
		$student_name = $student_f_name;
	}

	if ($student_father_fname != '0' AND $student_father_lname != '0') {
		$father_name = $student_father_fname . ' ' . $student_father_mname . ' ' . $student_l_name;
	} else {
		$father_name = $student_father_fname;
	}
	
	// $father_name = $student_father_fname . $student_father_mname . $student_father_lname; 
?>
<!-- Paid for -->
<?php 
	if ($paid_to == 'term_1' || $paid_to == 'term_2' || $paid_to == "full_fee" || $paid_to == 'custom_fee') {
		$fetch_master_data = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_year = '$student_academic_year' AND master_sts = '1' AND master_class = '$student_class' AND master_cat = 'fee'");
		$data_name = '';
		if (mysqli_num_rows($fetch_master_data) > 0) {
		    while ($fetch_ms = mysqli_fetch_assoc($fetch_master_data)) {
		        $data_name .= "<tr style='font-size:12px; font-weight:bold;'>
		            <td>{$fetch_ms['master_name']}</td>
		            <td>Rs. {$fetch_ms['master_amount']} /-</td>
		        </tr>";
		    }

		    $total_amount_query = mysqli_query($connection, "SELECT SUM(master_amount) AS total_amount FROM erp_master_details WHERE master_year = '$student_academic_year' AND master_sts = '1' AND master_class = '$student_class' AND master_cat = 'fee';");

		    $row = mysqli_fetch_assoc($total_amount_query); 
		    $total_amount = htmlspecialchars($row['total_amount'], ENT_QUOTES, 'UTF-8');
		}
	 }
?>

<!-- For Books -->
<?php
	if ($paid_to == 'rev_books') {
		$fetch_master_data_book = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_year = '$student_academic_year' AND master_sts = '1' AND master_class = '$student_class' AND master_cat = 'book'");

		if (mysqli_num_rows($fetch_master_data_book) > 0) {
				while($fetch_ms_book = mysqli_fetch_assoc($fetch_master_data_book)) { 
				$data_name_book .= '<tr style="font-size:12px; font-weight:bold;">
								<td>' . $fetch_ms_book["master_name"] . '</td>
								
								<td>Rs. ' . $fetch_ms_book["master_amount"] . ' /-</td>
							   </tr>';
				 }

			$total_amount_query = mysqli_query($connection, "SELECT SUM(master_amount) AS total_amount FROM erp_master_details WHERE master_year = '$student_academic_year' AND master_sts = '1' AND master_class = '$student_class' AND master_cat = 'book'");
			$rows = mysqli_fetch_assoc($total_amount_query); 
			$total_amount = htmlspecialchars($rows['total_amount'], ENT_QUOTES, 'UTF-8') . ' /-';
			}	
	}
?>



<!-- For dress -->
<?php 
	// if ($paid_to == 'rev_dress') {
	// 	$fetch_master_data = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_year = '$student_academic_year' AND master_sts = '1' AND master_class = '$student_class' AND master_cat = 'dress'");

	// 	if (mysqli_num_rows($fetch_master_data) > 0) {
	// 			while($fetch_ms = mysqli_fetch_assoc($fetch_master_data)) { 
	// 			$data_name .= '<tr style="font-size:16px;">
	// 							<td>' . $fetch_ms["master_name"] . '</td>
	// 							<td>Rs. ' . $fetch_ms["master_amount"] . ' /-</td>
	// 						   </tr>';
	// 			 }
	// 		$total_amount_query = mysqli_query($connection, "SELECT SUM(master_amount) AS total_amount FROM erp_master_details WHERE master_year = '$student_academic_year' AND master_sts = '1' AND master_class = '$student_class' AND master_cat = 'dress';");
	// 		$row = mysqli_fetch_assoc($total_amount_query); 
	// 		$total_amount = htmlspecialchars($row['total_amount'], ENT_QUOTES, 'UTF-8') . ' /-';
	// 		}	
	// }
?>




<!-- For trans -->

<!-- Old balance -->
<?php 
	if ($paid_to == 'old_balance') {
			$total_amount = htmlspecialchars($student_old_balance + $student_amount + $student_discount, ENT_QUOTES, 'UTF-8') . ' /-';

			$before_paying_old_balance = htmlspecialchars($student_old_balance + $student_amount);
			// echo $student_old_balance;

			$after_paying_old_balance = htmlspecialchars($student_old_balance);

			$data_name .= '<tr style="font-size:12px; font-weight: bold;"><td>Old Balance</td>
							<td>Rs.' . $student_old_balance + $student_amount + $student_discount . ' /-</td>
						   </tr>
						   <tr style="font-size:12px; font-weight: bold;"><td>Paid Amount</td>
							<td>Rs.' . $student_amount . ' /-</td>
						   </tr>
						   	<tr style="font-size:12px; font-weight: bold;"><td>Discount</td>
								<td>Rs.' . $student_discount . ' /-</td>
							</tr>
						  	<tr style="font-size:12px; font-weight: bold;"><td>Balance</td>
								<td>Rs.' . $after_paying_old_balance . ' /-</td>
						   	</tr>';
	}
?>
<!-- school master details-->
<?php 
	$fetch_school_details = mysqli_query($connection, "SELECT * FROM rev_erp_user_details");
	if (mysqli_num_rows($fetch_school_details) > 0) {
		while($fds = mysqli_fetch_assoc($fetch_school_details)) {
			$school_name = htmlspecialchars($fds['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
			$school_address = htmlspecialchars($fds['rev_user_school_address'], ENT_QUOTES, 'UTF-8');
			$school_logo = htmlspecialchars($fds['rev_user_school_logo'], ENT_QUOTES, 'UTF-8');
		}
	}
?>

<!-- Fetch all paid amount till date -->

<?php 
	$sql = "SELECT SUM(rev_amount) AS total_sum FROM erp_bill WHERE  rev_student_id = '$student_id' AND rev_academic_year = '$academic_setter' AND rev_sts = '1' AND rev_paid_to = 'custom_fee' AND rev_paid_on <= CURDATE()";

$result = mysqli_query($connection, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $paid_till_date = $row['total_sum'] ?? 0;
} 
	$total_discount_till_date = mysqli_query($connection, "SELECT SUM(rev_discount) AS total_sum_discount FROM erp_bill WHERE  rev_student_id = '$student_id' AND rev_academic_year = '$academic_setter' AND rev_sts = '1' AND rev_paid_to = 'custom_fee' AND rev_paid_on <= CURDATE()");

	if ($total_discount_till_date) {
    $rows = mysqli_fetch_assoc($total_discount_till_date);
    $discount_till_date = $rows['total_sum_discount'] ?? 0;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt of <?php echo $student_name; ?> <?php echo $paid_to; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a8b928c9f6.js" crossorigin="anonymous"></script>
	
    <style type="text/css">
    	@media print {
		  .no-print {
		  	display: none;
		  }
		}

		.button-footer {
		    position: fixed;
		    bottom: 10%;
		    right: 0;
		    width: 100%; /* or a specific width */
		    padding: 10px;
		    z-index: 1000;
		}

		table, th, td, tr {
  border: 1px solid black;
  border-collapse: collapse;
}

    </style>
  </head>

  <body>
  	
	<div class="button-footer d-flex justify-content-around">
	  <button onclick="window.print()" class="btn btn-info no-print" style="width:90%; margin-right: 10px;">
	    Print <i class="fas fa-print"></i> 
	  </button>

	  <button class="btn btn-success no-print whats" style="width:90%" id="sendHTMLasPDF">
	    Share to Whatsapp <i class="fa-brands fa-whatsapp"></i>
	  </button>

	  <button class="btn btn-success no-print whatsapp_msg" style="width:90%">
	    Please wait
	  </button>
	  
	</div>
	

	
    
    <div class="container-fluid" style="font-family: Nunito, sans-serif;">
    	<div class="print_area">
    	<div class="row" style="margin-top: 5px;">
    		<!-- Student Copy -->
    		
    		<div class="col-12" style="border:1px solid black;" >
    			<div class="d-flex justify-content-center">
    				<div class="text-center" style="margin-right:50px;">
    					<img src="<?php echo $school_logo; ?>" width="40px" height="40px;">
    				</div>
    				<div class="text-center">
    					<h5 style="font-size: 16px; font-weight:bold;"><?php echo $school_name; ?></h5>    				
    					<h6 style="margin-top:-5px; font-size:12px; font-weight: bold;">
    						<?php echo $school_address; ?> Ph: 99453 94473
    					</h6>
    				</div>
    			</div>
    			<?php 
    				if ($paid_to == 'old_balance')  { ?>
    					<h5 style="text-align: center; font-size: 12px; margin-top:-8px;">Fee Receipt(<?php echo ($i == 0) ? "Student Copy" : "School Copy"; ?>) <span style="font-weight:bold;">Academic Year 2024-25</span></h5>
    				<?Php } else { ?>
    					<h5 style="text-align: center; font-size: 12px; margin-top:-8px;">Fee Receipt(<?php echo ($i == 0) ? "Student Copy" : "School Copy"; ?>) <span style="font-weight:bold;">Academic Year <?php echo str_replace('_', '-', $academic_setter); ?></span></h5>
    				<?php } ?>
    			<table class="table table-bordered" style="font-size:12px;">
				  <thead>
				    <tr>
				      <th scope="col" style="font-size:12px;">Receipt No.: <?php echo htmlspecialchars($student_bill_number, ENT_QUOTES, 'UTF-8'); ?></th>
				      <th scope="col" style="font-size:12px;">Receipt Date.: <?php echo htmlspecialchars(date('d-M-Y', strtotime($student_date)), ENT_QUOTES, 'UTF-8'); ?></th>				      
				    </tr>
				  </thead>		  
				</table>

				<table class="table table-bordered" style="margin-top:-20px; font-size:12px;">
				  <thead>
				    <tr>
				      <th scope="col">Student Name: <?php echo htmlspecialchars(ucfirst($student_name), ENT_QUOTES, 'UTF-8'); ?></th>

				      <th scope="col">Father Name: <?php echo htmlspecialchars(ucfirst($father_name), ENT_QUOTES, 'UTF-8'); ?></th>				      				      
				    </tr>

				    <!-- <tr>
				      <th scope="col">Father Name: <?php echo htmlspecialchars(ucfirst($father_name), ENT_QUOTES, 'UTF-8'); ?></th>				      				      
				    </tr> -->
				  </thead>		  
				</table>

				<table class="table table-bordered" style="margin-top:-20px; font-size:12px;">
				  <thead>
				    <tr>
				    	<?php
							// assume $student_class and $paid_to are set earlier (from DB/request)
							// keep original in case you need it later
							$original_class = (string) $student_class;

							// mapping to previous class
							$previous_map = [
							    '10'  => '9',
							    '9'   => '8',
							    '8'   => '7',
							    '7'   => '6',
							    '6'   => '5',
							    '5'   => '4',
							    '4'   => '3',
							    '3'   => '2',
							    '2'   => '1',
							    '1'   => 'ukg',
							    'ukg' => 'lkg',
							    'lkg' => 'baby',
							    'baby'=> 'no class',
							];

							// decide display class
							if (isset($paid_to) && $paid_to === 'old_balance') {
							    $key = (string) $original_class;
							    if (array_key_exists($key, $previous_map)) {
							        $display_class = $previous_map[$key];
							    } else {
							        // if not found in map, keep original (safe fallback)
							        $display_class = $original_class;
							    }
							} else {
							    // not old balance — show present class
							    $display_class = $original_class;
							}

							// output safely
							?>
							<th scope="col">Class: <?php echo htmlspecialchars($display_class, ENT_QUOTES, 'UTF-8'); ?></th>

				      <th scope="col">Adm No.: ------------</th>				      
				    </tr>
				  
				    <tr>
				      <!-- <th scope="col">Roll No.: 586</th> -->
				      <th scope="col">Mobile No.: <?php echo htmlspecialchars($student_mobile, ENT_QUOTES, 'UTF-8'); ?></th>	
				      <th scope="col">UTR No.: <?php if ($erp_mode != "cash") {
				      	echo htmlspecialchars($erp_mode, ENT_QUOTES, 'UTF-8');
				      } else {
				      	echo '-----------';
				      } ?></th>			      
				    </tr>

				    <tr>
				      <th scope="col">Payment Mode: <?php if ($erp_mode != "cash") {
				      	echo 'Online';
				      	
				      } else {
				      	echo 'cash';
				      } ?></th>
				      <th scope="col">Collected By: <?php echo ucfirst($collected_by); ?></th>				      
				    </tr>
				  </thead>		  
				</table>

				
				
				<table class="table table-bordered" style="font-size:12px;">
				  <thead>
				    <tr>
				      <th scope="col">Fee Type</th>
				      <th scope="col">Amount</th>
				    </tr>
				  </thead>
				  <tbody>
				  		<?php echo trim($data_name); 	
				  		if ($paid_to =='custom_fee') {
				  			if ($student_admission_fee != "0") { ?>
				  				<tr style="font-size:12px; font-weight: bold;">
				  					<td>Admission Fee</td>
				      				<td>Rs. <?php echo htmlspecialchars($student_admission_fee, ENT_QUOTES, 'UTF-8'); ?> /-
				  				</tr>
				  			<?php }	 ?>
				  				<?php 
						  			if ($student_admission_fee != "0") { 
						  				$total_amounts = $total_amount + $student_admission_fee;
						  			} else {
						  				$total_amounts = $total_amount;
						  			}
						  		?>

						  		<tr style="font-size:12px;">
							      <td style="font-weight:bold;">Total Amount</td>
							      <td style="font-weight:bold;">Rs. <?php echo htmlspecialchars($total_amounts, ENT_QUOTES, 'UTF-8'); ?> /- </td>
							    </tr>

							    <?php 
						    		if ($student_discount != '0') { ?>
						    			<tr style="font-size:12px;">
									      <td style="font-weight:bold;">Discount</td>
									      <td style="font-weight:bold;">Rs. <?php if ($student_discount != '0') {
									      	echo $student_discount;
									      } else {
									      	echo '0';
									      } ?>
									       /-</td>
									    </tr>
						    		<?php }  ?>
						    		<tr style="font-size:12px;">
								      <td style="font-weight:bold;">Paid</td>
								      <td style="font-weight:bold;">Rs. <?php echo htmlspecialchars($student_amount, ENT_QUOTES, 'UTF-8'); ?> /-(<span style="font-size:12px;"><?php echo ucwords($student_amount_in_words); ?> Rupee(s) Only</span>) </td>
								    </tr>

								    <tr style="font-size:12px;">
								      <td style="font-weight:bold;">Balance Due</td>
								      	<?php 
								      		if ($paid_to == 'old_balance') {
								      			echo '<td style="font-weight:bold;">Rs. ' . $after_paying_old_balance . '</td>';
								      			echo '<tr style="font-size:12px;">
								      <td style="font-weight:bold;">Paid</td>
								      <td style="font-weight:bold;">Rs.' . htmlspecialchars($student_amount, ENT_QUOTES, "UTF-8") . '/-(<span style="font-size:12px;">' . ucwords($student_amount_in_words) .' Rupee(s) Only</span>) </td>
								    </tr>';
								      		} else {
								      			echo '<td style="font-weight:bold;">Rs. ' . $student_full_amount . ' /-</td>';
								      		}
								      	?>
								    </tr>
				  			<?php } ?>
				  			<!-- For Books -->
				  			<?php
				  				// echo $student_book_old_amount;
				  				if ($paid_to =='rev_books') {
				  					// Convert number to text
				  					echo $data_name_book; ?>
				  					<tr style="font-size:12px;">
				  						<td style="font-weight:bold;">Paid Amount</td>
				  						<td style="font-weight:bold;">Rs. <?php echo $student_amount . ' /-' . '(' . ucfirst($student_amount_in_words) . ' Rupee(s) Only)'; ?></td>
				  					</tr>
				  					<?php 

						    		if ($student_discount != '0') { ?>
						    				<tr style="font-size:12px;">
						  						<td style="font-weight:bold;">Discount</td>
						  						<td style="font-weight:bold;">Rs. <?php echo $student_discount; ?> /-</td>
						  					</tr>
						    		<?php }  ?>
				  					

				  					<tr style="font-size:12px;">
				  						<td style="font-weight:bold;">Balance</td>
				  						<td style="font-weight:bold;">Rs. <?php echo $student_book_old_amount . ' /-'; ?></td>
				  					</tr>
				  				<?php } ?>
				  			 <!-- For Books ended-->
				  			 <!-- For Trans -->
				  			 <?php
				  				// echo $student_book_old_amount;
									if ($paid_to == 'rev_trans') {
										$trans_fee = $student_trans_fee; ?>
										<tr style="font-size:12px;">
											<td style="font-weight:bold;">Transportation Fee</td>
											<td style="font-weight:bold;">Rs. <?php echo $student_trans_fixed_amount; ?> /-</td>
										</tr>

										<tr style="font-size:12px;">
											<td style="font-weight:bold;">Paid Amount</td>
											<td style="font-weight:bold;">Rs. <?php echo $student_amount . ' /-' . '(' . ucfirst($student_amount_in_words) . ' Rupee(s) Only)'; ?> </td>
										</tr>
										<?php 

						    		if ($student_discount != '0') { ?>
										<tr style="font-size:12px;">
											<td style="font-weight:bold;">Discount</td>
											<td style="font-weight:bold;">Rs. <?php echo $student_discount; ?> /-</td>
										</tr>
									<?php } ?>

										<tr style="font-size:12px;">
											<td style="font-weight:bold;">Balance Amount</td>
											<td style="font-weight:bold;">Rs. <?php echo $trans_fee; ?> /-</td>
										</tr>
									<?php } ?>
				  			 <!-- For Trans -->
				  </tbody>
				</table>

				<!-- Old Paid details -->
				<div class="d-flex justify-content-between mb-1">
					<h4 class="fw-bold" style="font-size:14px;">Payment History</h4>
					<?php if ($paid_to == 'custom_fee') { 
						 if ($student_consession != 0) { ?>
						<button class="btn btn-sm btn-outline-dark p-0 m-0 fw-bold">Concession Amount Rs. <?php echo $student_consession; ?></button>
					<?php } 
					} ?>
				</div>
				<?php 
					if ($student_note != '0') { ?>
						<div class="" style="border: 1px solid #000; margin-bottom: 10px; padding: 0px;">
							<h4 class="fw-bold" style="font-size:14px;">Note</h4>
							<p class="fw-bold"><?php echo ucfirst($student_note); ?></p>
						</div>
					<?php } ?>
				
					<table class="table table-bordered border-primary" style="font-size:12px; font-weight:bold;">
					  <thead>
					    <tr>
					      <th scope="col" class="py-0">#</th>
					      <th scope="col" class="py-0">Bill No. </th>
					      <th scope="col" class="py-0">Amount </th>
					      <th scope="col" class="py-0">Discount </th>
					      <th scope="col" class="py-0">Paid On</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
					  		$sql_bill = mysqli_query($connection, "SELECT * FROM erp_bill WHERE  rev_student_id = '$student_id' AND rev_academic_year = '$academic_setter' AND rev_sts = '1' AND rev_paid_to = '$paid_to' ORDER BY tree_id DESC LIMIT 6");
					  		if (mysqli_num_rows($sql_bill) > 0) {
					  			$o = 1;
					  			while($fd = mysqli_fetch_assoc($sql_bill)) { ?>
					  				<tr>
								      <th scope="row" class="py-0"><?php echo $o++; ?></th>
								      <td class="py-0"><?php echo htmlspecialchars($fd['rev_bill_number'], ENT_QUOTES, 'UTF-8'); ?></td>
								      <td class="py-0">Rs. <?php echo htmlspecialchars($fd['rev_amount'], ENT_QUOTES, 'UTF-8'); ?></td>
								      <td class="py-0">Rs. <?php echo htmlspecialchars($fd['rev_discount'], ENT_QUOTES, 'UTF-8'); ?></td>
								      <td class="py-0"><?php echo htmlspecialchars(date('d-M-Y', strtotime($fd['rev_paid_on'])), ENT_QUOTES, 'UTF-8'); ?></td>
								    </tr>
					  			<?php }
					  		}
					  	?>
					  </tbody>
					</table>
				<!-- Old paid details ended -->
				
    				<div class="d-flex justify-content-around" style="margin-top:-10px;">
		    			<p style="margin-top:18px; font-weight:bold; font-size:12px;" class="text-dark">THIS IS A COMPUTER GENERATED PRINTOUT WHICH REQUIRES NO SIGNATURE</p>
		    		</div>
    		</div>
    		



    		<!-- Print Fee -->
    		<h3 class="text-center text-danger no-print">Below format will be shared to parents whatsapp</h3>
    		<div class="col-12 wht no-print" style="border:1px solid black; margin-top: 50px;" id="htmlContent">
    			<div class="d-flex justify-content-center">
    				<div class="text-center" style="margin-right:50px;">
    					<img src="<?php echo $school_logo; ?>" width="40px" height="40px;">
    				</div>
    				<div class="text-center">
    					<h5 style="font-size: 16px; font-weight:bold;"><?php echo $school_name; ?></h5>    				
    					<h6 style="margin-top:-5px; font-size:12px; font-weight: bold;">
    						<?php echo $school_address; ?> Ph: 99453 94473
    					</h6>
    				</div>
    			</div>
    			<h5 style="text-align: center; font-size: 12px; margin-top:-8px;">Fee Receipt(Student Copy) <span style="font-weight:bold;">Academic Year <?php echo str_replace('_', '-', $academic_setter); ?></span></h5>
    			<table class="table table-bordered" style="font-size:12px; border: 1px solid black; padding: 10px;">
				  <thead>
				    <tr>
				      <th scope="col" style="font-size:12px;">Receipt No.: <?php echo htmlspecialchars($student_bill_number, ENT_QUOTES, 'UTF-8'); ?></th>
				      <th scope="col" style="font-size:12px;">Receipt Date.: <?php echo htmlspecialchars(date('d-M-Y', strtotime($student_date)), ENT_QUOTES, 'UTF-8'); ?></th>				      
				    </tr>
				  </thead>		  
				</table>

				<table class="table table-bordered" style="margin-top:-20px; font-size:12px;">
				  <thead>
				    <tr>
				      <th scope="col">Student Name: <?php echo htmlspecialchars(ucfirst($student_name), ENT_QUOTES, 'UTF-8'); ?></th>

				      <th scope="col">Father Name: <?php echo htmlspecialchars(ucfirst($father_name), ENT_QUOTES, 'UTF-8'); ?></th>				      				      
				    </tr>

				    <!-- <tr>
				      <th scope="col">Father Name: <?php echo htmlspecialchars(ucfirst($father_name), ENT_QUOTES, 'UTF-8'); ?></th>				      				      
				    </tr> -->
				  </thead>		  
				</table>

				<table class="table table-bordered" style="margin-top:-20px; font-size:12px;">
				  <thead>
				    <tr>
				      <th scope="col">Class: <?php echo htmlspecialchars($student_class, ENT_QUOTES, 'UTF-8'); ?></th>
				      <th scope="col">Adm No.: ------------</th>				      
				    </tr>
				  
				    <tr>
				      <!-- <th scope="col">Roll No.: 586</th> -->
				      <th scope="col">Mobile No.: <?php echo htmlspecialchars($student_mobile, ENT_QUOTES, 'UTF-8'); ?></th>	
				      <th scope="col">UTR No.: <?php if ($erp_mode != "cash") {
				      	echo htmlspecialchars($erp_mode, ENT_QUOTES, 'UTF-8');
				      } else {
				      	echo '-----------';
				      } ?></th>			      
				    </tr>

				    <tr>
				      <th scope="col">Payment Mode: <?php if ($erp_mode != "cash") {
				      	echo 'Online';
				      	
				      } else {
				      	echo 'cash';
				      } ?></th>
				      <th scope="col">Collected By: <?php echo ucfirst($collected_by); ?></th>				      
				    </tr>
				  </thead>		  
				</table>

				
				
				<table class="table table-bordered" style="font-size:12px;">
				  <thead>
				    <tr>
				      <th scope="col">Fee Type</th>
				      <th scope="col">Amount</th>
				    </tr>
				  </thead>
				  <tbody>
				  		<?php echo trim($data_name); 	
				  		if ($paid_to =='custom_fee') {
				  			if ($student_admission_fee != "0") { ?>
				  				<tr style="font-size:12px; font-weight: bold;">
				  					<td>S D F</td>
				      				<td>Rs. <?php echo htmlspecialchars($student_admission_fee, ENT_QUOTES, 'UTF-8'); ?> /-
				  				</tr>
				  			<?php }	 ?>
				  				<?php 
						  			if ($student_admission_fee != "0") { 
						  				$total_amounts = $total_amount + $student_admission_fee;
						  			} else {
						  				$total_amounts = $total_amount;
						  			}
						  		?>

						  		<tr style="font-size:12px;">
							      <td style="font-weight:bold;">Total Amount</td>
							      <td style="font-weight:bold;">Rs. <?php echo htmlspecialchars($total_amounts, ENT_QUOTES, 'UTF-8'); ?> /- </td>
							    </tr>

							    <?php 
						    		if ($student_discount != '0') { ?>
						    			<tr style="font-size:12px;">
									      <td style="font-weight:bold;">Discount</td>
									      <td style="font-weight:bold;">Rs. <?php if ($student_discount != '0') {
									      	echo $student_discount;
									      } else {
									      	echo '0';
									      } ?>
									       /-</td>
									    </tr>
						    		<?php }  ?>
						    		<tr style="font-size:12px;">
								      <td style="font-weight:bold;">Paid</td>
								      <td style="font-weight:bold;">Rs. <?php echo htmlspecialchars($student_amount, ENT_QUOTES, 'UTF-8'); ?> /-(<span style="font-size:12px;"><?php echo ucwords($student_amount_in_words); ?> Rupee(s) Only</span>) </td>
								    </tr>

								    <tr style="font-size:12px;">
								      <td style="font-weight:bold;">Balance Due</td>
								      	<?php 
								      		if ($paid_to == 'old_balance') {
								      			echo '<td style="font-weight:bold;">Rs. ' . $after_paying_old_balance . '</td>';
								      			echo '<tr style="font-size:12px;">
								      <td style="font-weight:bold;">Paid</td>
								      <td style="font-weight:bold;">Rs.' . htmlspecialchars($student_amount, ENT_QUOTES, "UTF-8") . '/-(<span style="font-size:12px;">' . ucwords($student_amount_in_words) .' Rupee(s) Only</span>) </td>
								    </tr>';
								      		} else {
								      			echo '<td style="font-weight:bold;">Rs. ' . $student_full_amount . ' /-</td>';
								      		}
								      	?>
								    </tr>
				  			<?php } ?>
				  			<!-- For Books -->
				  			<?php
				  				// echo $student_book_old_amount;
				  				if ($paid_to =='rev_books') {
				  					// Convert number to text
				  					echo $data_name_book; ?>
				  					<tr style="font-size:12px;">
				  						<td style="font-weight:bold;">Paid Amount</td>
				  						<td style="font-weight:bold;">Rs. <?php echo $student_amount . ' /-' . '(' . ucfirst($student_amount_in_words) . ' Rupee(s) Only)'; ?></td>
				  					</tr>
				  					<?php 

						    		if ($student_discount != '0') { ?>
						    				<tr style="font-size:12px;">
						  						<td style="font-weight:bold;">Discount</td>
						  						<td style="font-weight:bold;">Rs. <?php echo $student_discount; ?> /-</td>
						  					</tr>
						    		<?php }  ?>
				  					

				  					<tr style="font-size:12px;">
				  						<td style="font-weight:bold;">Balance</td>
				  						<td style="font-weight:bold;">Rs. <?php echo $student_book_old_amount . ' /-'; ?></td>
				  					</tr>
				  				<?php } ?>
				  			 <!-- For Books ended-->
				  			 <!-- For Trans -->
				  			 <?php
				  				// echo $student_book_old_amount;
									if ($paid_to == 'rev_trans') {
										$trans_fee = $student_trans_fee; ?>
										<tr style="font-size:12px;">
											<td style="font-weight:bold;">Transportation Fee</td>
											<td style="font-weight:bold;">Rs. <?php echo $student_trans_fixed_amount; ?> /-</td>
										</tr>

										<tr style="font-size:12px;">
											<td style="font-weight:bold;">Paid Amount</td>
											<td style="font-weight:bold;">Rs. <?php echo $student_amount . ' /-' . '(' . ucfirst($student_amount_in_words) . ' Rupee(s) Only)'; ?> </td>
										</tr>
										<?php 

						    		if ($student_discount != '0') { ?>
										<tr style="font-size:12px;">
											<td style="font-weight:bold;">Discount</td>
											<td style="font-weight:bold;">Rs. <?php echo $student_discount; ?> /-</td>
										</tr>
									<?php } ?>

										<tr style="font-size:12px;">
											<td style="font-weight:bold;">Balance Amount</td>
											<td style="font-weight:bold;">Rs. <?php echo $trans_fee; ?> /-</td>
										</tr>
									<?php } ?>
				  			 <!-- For Trans -->
				  </tbody>
				</table>

				<!-- Old Paid details -->
				<div class="d-flex justify-content-between mb-1">
					<h4 class="fw-bold" style="font-size:14px;">Payment History</h4>
					<?php if ($paid_to == 'custom_fee') { 
						 if ($student_consession != 0) { ?>
						<button class="btn btn-sm btn-outline-dark p-0 m-0 fw-bold">Concession Amount Rs. <?php echo $student_consession; ?></button>
					<?php } 
					} ?>
				</div>
				<?php 
					if ($student_note != '0') { ?>
						<div class="" style="border: 1px solid #000; margin-bottom: 10px; padding: 0px;">
							<h4 class="fw-bold" style="font-size:14px;">Note</h4>
							<p class="fw-bold"><?php echo ucfirst($student_note); ?></p>
						</div>
					<?php } ?>
				
					<table class="table table-bordered border-primary" style="font-size:12px; font-weight:bold;">
					  <thead>
					    <tr>
					      <th scope="col" class="py-0">#</th>
					      <th scope="col" class="py-0">Bill No. </th>
					      <th scope="col" class="py-0">Amount </th>
					      <th scope="col" class="py-0">Discount </th>
					      <th scope="col" class="py-0">Paid On</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
					  		$sql_bill = mysqli_query($connection, "SELECT * FROM erp_bill WHERE  rev_student_id = '$student_id' AND rev_academic_year = '$academic_setter' AND rev_sts = '1' AND rev_paid_to = '$paid_to' ORDER BY tree_id DESC LIMIT 6");
					  		if (mysqli_num_rows($sql_bill) > 0) {
					  			$o = 1;
					  			while($fd = mysqli_fetch_assoc($sql_bill)) { ?>
					  				<tr>
								      <th scope="row" class="py-0"><?php echo $o++; ?></th>
								      <td class="py-0"><?php echo htmlspecialchars($fd['rev_bill_number'], ENT_QUOTES, 'UTF-8'); ?></td>
								      <td class="py-0">Rs. <?php echo htmlspecialchars($fd['rev_amount'], ENT_QUOTES, 'UTF-8'); ?></td>
								      <td class="py-0">Rs. <?php echo htmlspecialchars($fd['rev_discount'], ENT_QUOTES, 'UTF-8'); ?></td>
								      <td class="py-0"><?php echo htmlspecialchars(date('d-M-Y', strtotime($fd['rev_paid_on'])), ENT_QUOTES, 'UTF-8'); ?></td>
								    </tr>
					  			<?php }
					  		}
					  	?>
					  </tbody>
					</table>
				<!-- Old paid details ended -->
				
    				<div class="d-flex justify-content-around" style="margin-top:-10px;">
		    			<p style="margin-top:18px; font-weight:bold; font-size:12px;" class="text-dark">THIS IS A COMPUTER GENERATED PRINTOUT WHICH REQUIRES NO SIGNATURE</p>
		    		</div>
    		</div>


    		<!--  -->
    	</div>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    	$('.whatsapp_msg').hide();
        document.getElementById('sendHTMLasPDF').addEventListener('click', () => {
        	$('.whatsapp_msg').show();
        	$('.whats').hide();

		    const element = document.getElementById('htmlContent'); // your HTML block
		     const phone = '<?php echo $student_mobile; ?>'; // replace with dynamic WhatsApp number
		    // const phone = '9164454002'
		    const school_name = "<?php echo $school_name; ?>";

		    const opt = {
		       margin: 0.5,
			    filename: 'Fee receipt.pdf',
			    image: { type: 'jpeg', quality: 0.98 },
			    html2canvas: {
			        scale: 2,        // Improves sharpness
			        useCORS: true    // Ensures images/styles load correctly
			    },
			    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
		    };

		    html2pdf().from(element).set(opt).outputPdf('blob').then(function (blob) {
		        const formData = new FormData();
		        formData.append('file', blob, '<?php echo date('d-m-y'); ?> Fee receipt.pdf');
		        formData.append('phone', phone);
		        formData.append('school_name', school_name);

		        fetch('upload_and_send.php', {
		            method: 'POST',
		            body: formData
		        })
		        .then(res => res.json())
		        .then(res => {
		            alert(res.message);
		            $('.whats').show(); 
		            $('.whatsapp_msg').hide();// ✅ Show WhatsApp button again after success
		        })
		        .catch(err => alert('Something went wrong'));
		    });
		});

		
      </script>
  </body>
</html>

