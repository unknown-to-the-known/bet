<?php 
require '../includes/config.php'; 
require ROOT_PATH . 'includes/db.php'; 
date_default_timezone_set('Asia/Kolkata');

$today_date_time = date('Y-m-d H:i:s');


// Check for auto-login cookie
if (isset($_COOKIE['aut'])) {
    $auto_login_code = htmlspecialchars($_COOKIE['aut'], ENT_QUOTES, 'UTF-8');
    $fetch_user_auto_login_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_auto_login = '$auto_login_code' AND rev_teach_sts = '1'");

    if (mysqli_num_rows($fetch_user_auto_login_details) > 0) {
        while($j = mysqli_fetch_assoc($fetch_user_auto_login_details)) {
            $user_email = htmlspecialchars($j['rev_teach_email'], ENT_QUOTES, 'UTF-8');
            $_SESSION['teach_details'] = $user_email;
        }
    }
}

// Check if teacher is logged in
if (isset($_SESSION['teach_details'])) {
    $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
} else {
    header("Location: " . BASE_URL . 'index');
    exit();
}


    if (isset($_SESSION['academic_setter'])) {
        $academic_setter = $_SESSION['academic_setter'];
    } else {
        $academic_setter = '2025_26';
    }

    $academic_setter = str_replace('-', '_', $academic_setter);


// Fetch teacher details
$fetch_teacher_details = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$teacher_email_id' AND user_sts = '1'");
if (mysqli_num_rows($fetch_teacher_details) > 0) {
    while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
        $user_name = htmlspecialchars($i['user_name'], ENT_QUOTES, 'UTF-8');
        $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
        $school_id = htmlspecialchars($i['user_school_id'], ENT_QUOTES, 'UTF-8');
    }  
}

// Check student ID parameter
if (isset($_GET['id'])) {
    if ($_GET['id'] != "") {
        $student_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    } else {
        header("Location: " . BASE_URL . "pages/display_student_list");
        exit();
    }
} else {
    header("Location: " . BASE_URL . "pages/display_student_list");
    exit();
}

// Fetch all student details
$fetch_all_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_school_id = '$school_id'");

if (mysqli_num_rows($fetch_all_details) > 0) {
    while($r = mysqli_fetch_assoc($fetch_all_details)) {
        $rev_fname = htmlspecialchars($r['rev_student_fname'], ENT_QUOTES, 'UTF-8');
        $rev_mname = htmlspecialchars($r['rev_student_mname'], ENT_QUOTES, 'UTF-8');
        $rev_lname = htmlspecialchars($r['rev_student_lname'], ENT_QUOTES, 'UTF-8');

        $rev_class = htmlspecialchars($r['rev_admission_class'], ENT_QUOTES, 'UTF-8');
        $rev_semster = htmlspecialchars($r['rev_semster'], ENT_QUOTES, 'UTF-8');
        $rev_mother_tongue = htmlspecialchars($r['rev_mother_tongue'], ENT_QUOTES, 'UTF-8');
        $rev_medium_of_instruction = htmlspecialchars($r['rev_moi'], ENT_QUOTES, 'UTF-8');
        $rev_previous_affiliation = htmlspecialchars($r['rev_previous_affiliation'], ENT_QUOTES, 'UTF-8');
        $rev_previous_tc_number = htmlspecialchars($r['rev_previous_tc_number'], ENT_QUOTES, 'UTF-8');
        $rev_previous_tc_date = htmlspecialchars($r['rev_previous_tc_date'], ENT_QUOTES, 'UTF-8');
        $rev_previous_school_name = htmlspecialchars($r['rev_previous_school_name'], ENT_QUOTES, 'UTF-8');
        $rev_previous_school_type = htmlspecialchars($r['rev_previous_school_type'], ENT_QUOTES, 'UTF-8');
        $rev_previous_pincode = htmlspecialchars($r['rev_previous_pincode'], ENT_QUOTES, 'UTF-8');
        $rev_previous_district = htmlspecialchars($r['rev_previous_district'], ENT_QUOTES, 'UTF-8');
        $rev_previous_taluk = htmlspecialchars($r['rev_previous_taluk'], ENT_QUOTES, 'UTF-8');
        $rev_previous_city = htmlspecialchars($r['rev_previous_city'], ENT_QUOTES, 'UTF-8');
        $rev_previous_address = htmlspecialchars($r['rev_prev_address'], ENT_QUOTES, 'UTF-8');

        $rev_student_father_name = htmlspecialchars($r['rev_father_fname'], ENT_QUOTES, 'UTF-8') . ' ' . 
                                  htmlspecialchars($r['rev_father_mname'], ENT_QUOTES, 'UTF-8') . ' ' . 
                                  htmlspecialchars($r['rev_father_lname'], ENT_QUOTES, 'UTF-8');

        $rev_student_mother_name = htmlspecialchars($r['rev_mother_fname'], ENT_QUOTES, 'UTF-8') . ' ' . 
                                  htmlspecialchars($r['rev_mother_mname'], ENT_QUOTES, 'UTF-8') . ' ' . 
                                  htmlspecialchars($r['rev_mother_lname'], ENT_QUOTES, 'UTF-8');

        $rev_student_aadhar_name = htmlspecialchars($r['rev_student_aadhaar_number'], ENT_QUOTES, 'UTF-8');
        $rev_student_aadhar_doc = htmlspecialchars($r['rev_student_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

        $rev_father_aadhar_name = htmlspecialchars($r['rev_father_aadhaar_number'], ENT_QUOTES, 'UTF-8');
        $rev_father_aadhar_doc = htmlspecialchars($r['rev_father_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

        $rev_mother_aadhar_name = htmlspecialchars($r['rev_mother_aadhaar_number'], ENT_QUOTES, 'UTF-8');
        $rev_mother_aadhar_doc = htmlspecialchars($r['rev_mother_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

        $rev_student_dob = htmlspecialchars($r['rev_student_dob'], ENT_QUOTES, 'UTF-8');
        $rev_student_dob_doc = htmlspecialchars($r['rev_student_dob_doc'], ENT_QUOTES, 'UTF-8');

        $rev_student_urban_rural = htmlspecialchars($r['rev_urban_rural'], ENT_QUOTES, 'UTF-8');
        $rev_student_gender = htmlspecialchars($r['rev_gender'], ENT_QUOTES, 'UTF-8');
        $rev_student_religion = htmlspecialchars($r['rev_religion'], ENT_QUOTES, 'UTF-8');

        $rev_student_caste_number = htmlspecialchars($r['rev_student_caste_number'], ENT_QUOTES, 'UTF-8');
        $rev_student_caste_doc = htmlspecialchars($r['rev_student_caste_doc'], ENT_QUOTES, 'UTF-8');
        $rev_student_caste_name = htmlspecialchars($r['rev_student_caste_name'], ENT_QUOTES, 'UTF-8');

        $rev_father_caste_number = htmlspecialchars($r['rev_father_caste_number'], ENT_QUOTES, 'UTF-8');
        $rev_father_caste_doc = htmlspecialchars($r['rev_father_caste_doc'], ENT_QUOTES, 'UTF-8');
        $rev_father_caste_name = htmlspecialchars($r['rev_father_caste_name'], ENT_QUOTES, 'UTF-8');

        $rev_mother_caste_number = htmlspecialchars($r['rev_mother_caste_number'], ENT_QUOTES, 'UTF-8');
        $rev_mother_caste_doc = htmlspecialchars($r['rev_mother_caste_doc'], ENT_QUOTES, 'UTF-8');
        $rev_mother_caste_name = htmlspecialchars($r['rev_mother_caste_name'], ENT_QUOTES, 'UTF-8');

        $rev_social_category = htmlspecialchars($r['rev_social_category'], ENT_QUOTES, 'UTF-8');
        $rev_social_category_doc = htmlspecialchars($r['rev_social_category_doc'], ENT_QUOTES, 'UTF-8');
        $rev_social_bpl_doc = htmlspecialchars($r['rev_bpl_doc'], ENT_QUOTES, 'UTF-8');
        $rev_bhagyalakshmi_bond_doc = htmlspecialchars($r['rev_bhagyalakshmi_bond_doc'], ENT_QUOTES, 'UTF-8');
        $rev_disabality = htmlspecialchars($r['rev_disability_child'], ENT_QUOTES, 'UTF-8');
        $rev_disabality_doc = htmlspecialchars($r['rev_disabality_doc'], ENT_QUOTES, 'UTF-8');
        $rev_special_category = htmlspecialchars($r['rev_special_category'], ENT_QUOTES, 'UTF-8');
        $rev_special_category_doc = htmlspecialchars($r['rev_special_category_doc'], ENT_QUOTES, 'UTF-8');

        $rev_student_pincode = htmlspecialchars($r['rev_student_pincode'], ENT_QUOTES, 'UTF-8');
        $rev_student_district = htmlspecialchars($r['rev_student_district'], ENT_QUOTES, 'UTF-8');
        $rev_student_taluk = htmlspecialchars($r['rev_student_taluk'], ENT_QUOTES, 'UTF-8');
        $rev_student_city = htmlspecialchars($r['rev_student_city'], ENT_QUOTES, 'UTF-8');
        $rev_student_locality = htmlspecialchars($r['rev_student_locality'], ENT_QUOTES, 'UTF-8');
        $rev_student_address = htmlspecialchars($r['rev_student_address'], ENT_QUOTES, 'UTF-8');

        $rev_student_mobile = htmlspecialchars($r['rev_student_mobile'], ENT_QUOTES, 'UTF-8');
        $rev_student_email = htmlspecialchars($r['rev_student_email'], ENT_QUOTES, 'UTF-8');
        $rev_father_mobile = htmlspecialchars($r['rev_father_mobile'], ENT_QUOTES, 'UTF-8');
        $rev_father_email = htmlspecialchars($r['rev_father_email'], ENT_QUOTES, 'UTF-8');
        $rev_mother_mobile = htmlspecialchars($r['rev_mother_mobile'], ENT_QUOTES, 'UTF-8');
        $rev_mother_email = htmlspecialchars($r['rev_mother_email'], ENT_QUOTES, 'UTF-8');

        $rev_rte = htmlspecialchars($r['rev_rte'], ENT_QUOTES, 'UTF-8');
        $rev_sts = htmlspecialchars($r['rev_sts'], ENT_QUOTES, 'UTF-8');
        $current_fees_paid = htmlspecialchars($r['rev_fees'], ENT_QUOTES, 'UTF-8');
        $current_trans_paid = htmlspecialchars($r['rev_transportation'], ENT_QUOTES, 'UTF-8');
        $rev_sats = htmlspecialchars($r['rev_sats'], ENT_QUOTES, 'UTF-8');
        $rev_old_balance = htmlspecialchars($r['rev_old_balance'], ENT_QUOTES, 'UTF-8');
    }

    $student_full_name = $rev_fname . ' ' . $rev_mname . ' ' . $rev_lname;

}

// Handle old balance submission
if (isset($_POST['submit_old_balance'])) {
    $user_old_balance = mysqli_escape_string($connection, trim($_POST['old_balance']));

    if ($user_old_balance == "") {
        $error_message = "Please enter old balance amount";
    }

    if (!isset($error_message)) {
        $update = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_old_balance = '$user_old_balance' WHERE tree_id = '$student_id'");

        if (isset($update)) {
            $error_message = "Success, Old balance added";
            header('Location: ' . BASE_URL . 'pages/full_details?id=' . $student_id);
            exit();
        }
    }
}

// Handle receipt deletion
if (isset($_POST['delete_btn'])) {
    $delete_id = mysqli_escape_string($connection, trim($_POST['del']));
    $delete_id_query = mysqli_query($connection, "SELECT * FROM erp_bill WHERE tree_id = '$delete_id' AND rev_sts = '1'");

    if (mysqli_num_rows($delete_id_query) > 0) {
        while($dsa = mysqli_fetch_assoc($delete_id_query)) {
            $paid_to = $dsa['rev_paid_to'];
            $paid_amount = $dsa['rev_amount'];
            $academic_year = $dsa['rev_academic_year'];
            $student_id = $dsa['rev_student_id'];
            $student_discount = $dsa['rev_discount'];
        }
        
        // Handle different payment types
        if ($paid_to == 'term_1') {
            $fetch_existing_fees = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");
            if (mysqli_num_rows($fetch_existing_fees) > 0) {
                while($k = mysqli_fetch_assoc($fetch_existing_fees)) {
                    // $old_term1_fee = $k['rev_term1_fee'];
                    $old_full_fee = $k['rev_fees'];
                }
                $t = $old_term1_fee + $paid_amount + $student_discount;
                $k = $old_full_fee + $paid_amount + $student_discount;

                $update_term1_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$t', rev_fees = '$k' WHERE tree_id = '$student_id' AND rev_sts = '1'");
                $update_receipt = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$delete_id' AND rev_sts = '1'");
            }
        }

        if ($paid_to == 'term_2') {
            $fetch_existing_fees = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");
            if (mysqli_num_rows($fetch_existing_fees) > 0) {
                while($k = mysqli_fetch_assoc($fetch_existing_fees)) {
                    $old_term1_fee = $k['rev_term2_fee'];
                    $old_full_fee = $k['rev_fees'];
                }
                $t = $old_term1_fee + $paid_amount + $student_discount;
                $k = $old_full_fee + $paid_amount + $student_discount;

                $update_term1_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$t', rev_fees = '$k' WHERE tree_id = '$student_id' AND rev_sts = '1'");
                $update_receipt = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$delete_id' AND rev_sts = '1'");
            }
        }

        if ($paid_to == 'full_fee') {
            $fetch_existing_fees = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");
            if (mysqli_num_rows($fetch_existing_fees) > 0) {
                while($k = mysqli_fetch_assoc($fetch_existing_fees)) {
                    $old_full_fee = $k['rev_fees'];
                }
                $k = $old_full_fee + $paid_amount + $student_discount;

                $update_term1_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$k', rev_fees = '$k' WHERE tree_id = '$student_id' AND rev_sts = '1'");
                $update_receipt = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$delete_id' AND rev_sts = '1'");
            }
        }

        if ($paid_to == 'old_balance') {
            $fetch_existing_fees = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");
            if (mysqli_num_rows($fetch_existing_fees) > 0) {
                while($k = mysqli_fetch_assoc($fetch_existing_fees)) {
                    $old_full_fee = $k['rev_old_balance'];
                }
                $k = $old_full_fee + $paid_amount + $student_discount;
                
                $update_term1_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_old_balance = '$k' WHERE tree_id = '$student_id' AND rev_sts = '1'");
                $update_receipt = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$delete_id' AND rev_sts = '1'");
            }
        }

        if ($paid_to == 'custom_fee') {
            $fetch_existing_fees = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");
            if (mysqli_num_rows($fetch_existing_fees) > 0) {
                while($k = mysqli_fetch_assoc($fetch_existing_fees)) {
                    $old_full_fee = $k['rev_fees'];
                }
                $k = $old_full_fee + $paid_amount + $student_discount;

                $update_term1_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$k', rev_fees = '$k' WHERE tree_id = '$student_id' AND rev_sts = '1'");
                $update_receipt = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$delete_id' AND rev_sts = '1'");
            }
        }

        if ($paid_to == 'rev_books') {
            $fetch_existing_fees = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");
            if (mysqli_num_rows($fetch_existing_fees) > 0) {
                while($k = mysqli_fetch_assoc($fetch_existing_fees)) {
                    $old_book_fee = $k['rev_books'];
                }
                $k = $old_book_fee + $paid_amount + $student_discount;

                $update_term1_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = '$k' WHERE tree_id = '$student_id' AND rev_sts = '1'");
                $update_receipt = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$delete_id' AND rev_sts = '1'");
            }
        }

        if ($paid_to == 'rev_trans') {
            $fetch_existing_fees = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");
            if (mysqli_num_rows($fetch_existing_fees) > 0) {
                while($k = mysqli_fetch_assoc($fetch_existing_fees)) {
                    $old_book_fee = $k['rev_transportation'];
                }
                $k = $old_book_fee + $paid_amount + $student_discount;

                $update_term1_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_transportation = '$k' WHERE tree_id = '$student_id' AND rev_sts = '1'");
                $update_receipt = mysqli_query($connection, "UPDATE erp_bill SET rev_sts = '0' WHERE tree_id = '$delete_id' AND rev_sts = '1'");
            }
        }
    }
}

// Handle RTE assignment
if (isset($_POST['assign_rte'])) {
    $rte_amount = '58000';
    $update = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_rte = '$rte_amount' WHERE tree_id = '$student_id' AND rev_sts = '1'");
    if (isset($update)) {
        $error_message = "Success student assigned to RTE";
    }
}

// Handle RTE deassignment
if (isset($_POST['deassign_rte'])) {
    $rte_amount = '0';
    $update = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_rte = '$rte_amount' WHERE tree_id = '$student_id' AND rev_sts = '1'");
    if (isset($update)) {
        $error_message = "Success student Deassigned to RTE";
    }
}

// Handle student account pause
if (isset($_POST['unlink_user'])) {
    $update_user_sts = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_sts = '3' WHERE tree_id = '$student_id' AND rev_sts = '1'");
    if (isset($update_user_sts)) {
        $error_message = "Success student account is paused";
    }
} 

// Handle student account unpause
if (isset($_POST['link_user'])) {
    $update_user_sts = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_sts = '1' WHERE tree_id = '$student_id' AND rev_sts = '3'");
    if (isset($update_user_sts)) {
        $error_message = "Success student account is active";
    }
}

require ROOT_PATH . 'includes/header_after_login.php';
?>

<style type="text/css">
    :root {
        --pastel-blue: #a7c7e7;
        --pastel-green: #c1e1c1;
        --pastel-peach: #ffd8b1;
        --pastel-lavender: #d8bfd8;
        --pastel-pink: #ffb6c1;
        --pastel-yellow: #fdfd96;
        --pastel-mint: #b5ead7;
    }
    
    .student-profile-container {
        background-color: #f9f9f9;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        padding: 25px;
        margin-top: 20px;
    }
    
    .profile-header {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-mint));
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        color: #333;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
    }
    
    .profile-header h2 {
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        margin-left: 10px;
    }
    
    .status-active {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-paused {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-rte {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .section-card {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-left: 5px solid var(--pastel-blue);
    }
    
    .section-title {
        font-weight: 600;
        color: #444;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: var(--pastel-blue);
    }
    
    .detail-row {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #eee;
    }
    
    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .detail-label {
        font-weight: 600;
        color: #666;
        margin-bottom: 5px;
    }
    
    .detail-value {
        font-weight: 500;
        color: #333;
    }
    
    .document-thumbnail {
        width: 120px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #eee;
        transition: transform 0.3s;
    }
    
    .document-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .action-btn {
        border-radius: 8px;
        padding: 8px 15px;
        font-size: 14px;
        margin-right: 10px;
        margin-bottom: 10px;
        display: inline-flex;
        align-items: center;
    }
    
    .action-btn i {
        margin-right: 5px;
    }
    
    .badge-pill {
        border-radius: 10px;
        padding: 5px 10px;
        font-size: 12px;
    }
    
    @media (max-width: 768px) {
        .profile-header {
            text-align: center;
        }
        
        .status-badge {
            display: block;
            margin: 10px auto 0;
            width: fit-content;
        }
    }
</style>

<div class="container student-profile-container">
    <!-- Student Status Alerts -->
    <?php if ($rev_sts == '3') : ?>
        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div>
                <strong>⚠️ Account Paused:</strong> This student account is currently inactive
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($rev_rte != 'no') : ?>
        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-award me-2"></i>
            <div>
                <strong>🏆 RTE Student:</strong> This student is under the Right to Education program
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Student Header -->
    <div class="profile-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h2>👨‍🎓 <?php echo ucfirst($student_full_name); ?></h2>
                <p class="mb-0">📚 Grade <?php echo $rev_class; ?> | 🏫 <?php echo ucfirst($school_name); ?></p>
            </div>
            <div class="mt-2 mt-md-0">
                <span class="badge-pill bg-light text-dark">
                    🔢 SATS No: <?php echo $rev_sats; ?>
                </span>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="d-flex flex-wrap mb-4">
        <a href="<?php echo BASE_URL; ?>pages/add_student?uniq_id=<?php echo $student_id; ?>" class="btn btn-primary action-btn">
            <i class="far fa-edit"></i> Edit Profile
        </a>
        
        <button class="btn btn-secondary action-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop_old_balance">
            <i class="fas fa-coins"></i> Old Balance: ₹<?php echo $rev_old_balance; ?>
        </button>
        
        <form action="" method="post" class="d-inline">
            <?php if ($rev_rte == '58000') : ?>
                <button class="btn btn-warning action-btn" type="submit" name="deassign_rte">
                    <i class="fas fa-times-circle"></i> Remove RTE
                </button>
            <?php else : ?>
                <button class="btn btn-success action-btn" type="submit" name="assign_rte">
                    <i class="fas fa-check-circle"></i> Assign RTE
                </button>
            <?php endif; ?>
        </form>
        
        <form action="" method="post" class="d-inline">
            <?php if ($rev_sts == '1') : ?>
                <button class="btn btn-danger action-btn" type="submit" name="unlink_user">
                    <i class="fas fa-user-slash"></i> Disable Account
                </button>
            <?php else : ?>
                <button class="btn btn-success action-btn" type="submit" name="link_user">
                    <i class="fas fa-user-check"></i> Activate Account
                </button>
            <?php endif; ?>
        </form>
        
        <button class="btn btn-info action-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="fas fa-history"></i> Payment History
        </button>
    </div>
    
    <!-- Admission Details Section -->
    <div class="section-card">
        <h5 class="section-title">
            <i class="fas fa-file-signature"></i> Admission Details
        </h5>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">📝 Medium of Instruction</div>
                    <div class="detail-value"><?php echo ucfirst($rev_medium_of_instruction); ?></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🗣️ Mother Tongue</div>
                    <div class="detail-value"><?php echo ucfirst($rev_mother_tongue); ?></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🏡 Urban/Rural</div>
                    <div class="detail-value"><?php echo ucfirst($rev_student_urban_rural); ?></div>
                </div>
            </div>
        </div>
        
        <!-- Previous School Details (if applicable) -->
        <?php if ($rev_previous_affiliation != '0') : ?>
            <hr class="my-4">
            
            <h6 class="section-title">
                <i class="fas fa-school"></i> Previous School Details
            </h6>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="detail-label">🏛️ School Name</div>
                        <div class="detail-value"><?php echo ucfirst($rev_previous_school_name); ?></div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="detail-label">🏷️ Affiliation</div>
                        <div class="detail-value"><?php echo ucfirst($rev_previous_affiliation); ?></div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="detail-label">📜 TC Number</div>
                        <div class="detail-value"><?php echo ucfirst($rev_previous_tc_number); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="detail-label">📅 TC Date</div>
                        <div class="detail-value"><?php echo ucfirst($rev_previous_tc_date); ?></div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="detail-label">🏙️ City/Village</div>
                        <div class="detail-value"><?php echo ucfirst($rev_previous_city); ?></div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="detail-label">📍 District</div>
                        <div class="detail-value"><?php echo str_replace('_', ' ', ucfirst($rev_previous_district)); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="detail-row">
                        <div class="detail-label">🏠 Address</div>
                        <div class="detail-value"><?php echo ucfirst($rev_previous_address); ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Student Personal Details -->
    <div class="section-card">
        <h5 class="section-title">
            <i class="fas fa-user-graduate"></i> Student Details
        </h5>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">👶 Date of Birth</div>
                    <div class="detail-value"><?php echo date('d-M-Y', strtotime($rev_student_dob)); ?></div>
                    <?php if ($rev_student_dob_doc != "0") : ?>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com<?php echo $rev_student_dob_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com<?php echo $rev_student_dob_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🚻 Gender</div>
                    <div class="detail-value"><?php echo ucfirst($rev_student_gender); ?></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🛐 Religion</div>
                    <div class="detail-value"><?php echo ucfirst($rev_student_religion); ?></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🆔 Aadhaar Number</div>
                    <div class="detail-value"><?php echo $rev_student_aadhar_name ?: 'Not Provided'; ?></div>
                    <?php if ($rev_student_aadhar_doc != "0") : ?>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_student_aadhar_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_student_aadhar_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">👨 Father's Aadhaar</div>
                    <div class="detail-value"><?php echo $rev_father_aadhar_name ?: 'Not Provided'; ?></div>
                    <?php if ($rev_father_aadhar_doc != "0") : ?>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_father_aadhar_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_father_aadhar_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">👩 Mother's Aadhaar</div>
                    <div class="detail-value"><?php echo $rev_mother_aadhar_name ?: 'Not Provided'; ?></div>
                    <?php if ($rev_mother_aadhar_doc != "0") : ?>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_mother_aadhar_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_mother_aadhar_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Father Name -->
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">👨 Father Name</div>
                    <div class="detail-value"><?php echo $rev_student_father_name ?: 'Not Provided'; ?></div>
                </div>
            </div>
            <!-- Mother Name -->
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">👩 Mother Name</div>
                    <div class="detail-value"><?php echo $rev_student_mother_name ?: 'Not Provided'; ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Caste & Category Details -->
    <div class="section-card">
        <h5 class="section-title">
            <i class="fas fa-users"></i> Caste & Category Details
        </h5>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">📜 Student Caste</div>
                    <div class="detail-value">
                        <?php echo $rev_student_caste_name ?: 'Not Provided'; ?>
                        <?php if ($rev_student_caste_number) echo "($rev_student_caste_number)"; ?>
                    </div>
                    <?php if ($rev_student_caste_doc != "0") : ?>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_student_caste_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_student_caste_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">👨 Father's Caste</div>
                    <div class="detail-value">
                        <?php echo $rev_father_caste_name ?: 'Not Provided'; ?>
                        <?php if ($rev_father_caste_number) echo "($rev_father_caste_number)"; ?>
                    </div>
                    <?php if ($rev_father_caste_doc != "0") : ?>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_father_caste_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_father_caste_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">👩 Mother's Caste</div>
                    <div class="detail-value">
                        <?php echo $rev_mother_caste_name ?: 'Not Provided'; ?>
                        <?php if ($rev_mother_caste_number) echo "($rev_mother_caste_number)"; ?>
                    </div>
                    <?php if ($rev_mother_caste_doc != "0") : ?>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_mother_caste_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_mother_caste_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🏷️ Social Category</div>
                    
                    <?php if ($rev_social_category_doc != '0') { ?>
                        <div class="detail-value"><?php echo ucfirst($rev_social_category); ?></div>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_social_category_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_social_category_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php } else {
                        echo '<p class="text-dark">Not Provided</p>';
                    } ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🏷️ BPL Status</div>
                    <div class="detail-value">
                        <?php echo ($rev_social_bpl_doc != '0') ? 'Yes' : 'No'; ?>
                        <?php if ($rev_social_bpl_doc != '0') : ?>
                            <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_social_bpl_doc; ?>" target="_blank">
                                <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_social_bpl_doc; ?>" class="document-thumbnail mt-2">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🏷️ Special Category</div>
                    
                    <?php if ($rev_special_category_doc != '0'){ ?>
                        <div class="detail-value"><?php echo ucfirst($rev_special_category); ?></div>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_special_category_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_special_category_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php } else {
                        echo 'No';
                    } ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🧑‍🦼 Disability Status</div>
                    
                    <?php if ($rev_disabality_doc != '0') { ?>
                        <div class="detail-value"><?php echo str_replace('_', ' ', ucfirst($rev_disabality)); ?></div>
                        <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_disabality_doc; ?>" target="_blank">
                            <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_disabality_doc; ?>" class="document-thumbnail mt-2">
                        </a>
                    <?php } else {
                        echo 'No';
                    } ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">💝 Bhagyalakshmi Bond</div>
                    <div class="detail-value">
                        <?php echo ($rev_bhagyalakshmi_bond_doc != '0') ? 'Yes' : 'No'; ?>
                        <?php if ($rev_bhagyalakshmi_bond_doc != '0') : ?>
                            <a href="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_bhagyalakshmi_bond_doc; ?>" target="_blank">
                                <img src="https://rev-users.blr1.digitaloceanspaces.com/<?php echo $rev_bhagyalakshmi_bond_doc; ?>" class="document-thumbnail mt-2">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contact Details -->
    <div class="section-card">
        <h5 class="section-title">
            <i class="fas fa-address-book"></i> Contact Details
        </h5>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">📍 Address</div>
                    <div class="detail-value"><?php echo ucfirst($rev_student_address); ?></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🏙️ City/Village</div>
                    <div class="detail-value"><?php echo ucfirst($rev_student_city); ?></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🗺️ District</div>
                    <div class="detail-value"><?php echo str_replace('_', ' ', ucfirst($rev_student_district)); ?></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">📌 Pincode</div>
                    <div class="detail-value"><?php echo $rev_student_pincode; ?></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🏘️ Locality</div>
                    <div class="detail-value"><?php echo ucfirst($rev_student_locality); ?></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">🏞️ Taluk</div>
                    <div class="detail-value"><?php echo ucfirst($rev_student_taluk); ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contact Information -->
    <div class="section-card">
        <h5 class="section-title">
            <i class="fas fa-phone-alt"></i> Contact Information
        </h5>
        
        <div class="row">
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">📱 Student Mobile</div>
                    <div class="detail-value">
                        <?php if ($rev_student_mobile != '0') : ?>
                            <a href="tel:+91<?php echo $rev_student_mobile; ?>" class="text-decoration-none">
                                <i class="fas fa-phone-alt"></i> <?php echo $rev_student_mobile; ?>
                            </a>
                        <?php else : ?>
                            <span class="text-dark">Not provided</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="detail-label mt-2">📧 Student Email</div>
                    <div class="detail-value">
                        <?php if ($rev_student_email != '0') : ?>
                            <a href="mailto:<?php echo $rev_student_email; ?>" class="text-decoration-none">
                                <i class="fas fa-envelope"></i> <?php echo $rev_student_email; ?>
                            </a>
                        <?php else : ?>
                            <span class="text-dark">Not provided</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">📱 Father's Mobile</div>
                    <div class="detail-value">
                        <?php if ($rev_father_mobile != '0') : ?>
                            <a href="tel:+91<?php echo $rev_father_mobile; ?>" class="text-decoration-none">
                                <i class="fas fa-phone-alt"></i> <?php echo $rev_father_mobile; ?>
                            </a>
                        <?php else : ?>
                            <span class="text-muted">Not provided</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="detail-label mt-2">📧 Father's Email</div>
                    <div class="detail-value">
                        <?php if ($rev_father_email != '0') : ?>
                            <a href="mailto:<?php echo $rev_father_email; ?>" class="text-decoration-none">
                                <i class="fas fa-envelope"></i> <?php echo $rev_father_email; ?>
                            </a>
                        <?php else : ?>
                            <span class="text-dark">Not provided</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="detail-row">
                    <div class="detail-label">📱 Mother's Mobile</div>
                    <div class="detail-value">
                        <?php if ($rev_mother_mobile != '0') : ?>
                            <a href="tel:+91<?php echo $rev_mother_mobile; ?>" class="text-decoration-none">
                                <i class="fas fa-phone-alt"></i> <?php echo $rev_mother_mobile; ?>
                            </a>
                        <?php else : ?>
                            <span class="text-dark">Not provided</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="detail-label mt-2">📧 Mother's Email</div>
                    <div class="detail-value">
                        <?php if ($rev_mother_email != '0') : ?>
                            <a href="mailto:<?php echo $rev_mother_email; ?>" class="text-decoration-none">
                                <i class="fas fa-envelope"></i> <?php echo $rev_mother_email; ?>
                            </a>
                        <?php else : ?>
                            <span class="text-dark">Not provided</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment History Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">💰 Payment History</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment For</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Date</th>
                        <th scope="col">Receipt No</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php 
                // echo "SELECT * FROM erp_bill WHERE rev_student_id = '$student_id' AND rev_sts = '1'";
                $fetch_all_active_payment = mysqli_query($connection, "SELECT * FROM erp_bill WHERE rev_student_id = '$student_id' AND rev_sts = '1' AND rev_academic_year = '$academic_setter'");

                if (mysqli_num_rows($fetch_all_active_payment) > 0) {
                    $i = 1;
                    while($vfr = mysqli_fetch_assoc($fetch_all_active_payment)) { ?>
                        <tr>
                          <th scope="row"><?php echo $i++; ?></th>
                          <td class="text-success fw-bold text-dark"><?php echo 'Rs.' . htmlspecialchars($vfr['rev_amount'], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td class="text-dark">
                            <?php 
                                if ($vfr['rev_paid_to'] == 'rev_trans') {
                                    echo 'Transportation'; 
                                 } 
                                if ($vfr['rev_paid_to'] == 'custom_fee') {
                                    echo 'Fee';
                                }  

                                if ($vfr['rev_paid_to'] == 'rev_books') {
                                    echo 'Books';
                                } 

                                if ($vfr['rev_paid_to'] == 'old_balance') {
                                    echo 'Old Balance';
                                }   
                                 ?>
                          </td>
                          <td class="text-danger fw-bold">Rs. <?php echo htmlspecialchars($vfr['rev_discount'], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td class="text-dark"><?php echo htmlspecialchars(date('d-M-Y', strtotime($vfr['rev_paid_on'])), ENT_QUOTES, 'UTF-8'); ?></td>
                          <td class="text-dark"><?php echo htmlspecialchars($vfr['rev_bill_number'], ENT_QUOTES, 'UTF-8'); ?></td>
                          <form action="" method="post">
                            <td>
                                <!-- <i class="fas fa-trash-alt" style="color:red;"></i> -->
                                <input type="hidden" name="del" value="<?php echo $vfr['tree_id']; ?>">
                                <div class="delete-block">
                                    <!-- Receipt icon -->
                                    <a href="<?php echo BASE_URL; ?>pages/bill_generator?id=<?php echo $vfr['tree_id']; ?>">
                                        <button class="btn btn-outline-info btn-sm" type="button">
                                            <i class="fas fa-long-arrow-alt-down"></i> <i class="fas fa-receipt"></i>
                                        </button>
                                    </a>
                                    <!-- Trash icon button -->
                                    <button class="btn btn-outline-danger btn-sm show_delete" type="button">
                                        <i class="fa fa-trash"></i>
                                    </button>


                                    
                                    <!-- Hidden confirmation UI -->
                                    <div class="show_div" style="display:none;">
                                        <small class="text-dark">Are you sure to delete the receipt?</small><br>
                                        <button class="btn btn-success btn-sm" type="submit" name="delete_btn">Yes</button>
                                        <button class="btn btn-danger btn-sm no" type="button">No</button>
                                    </div>
                                </div>

                                
                            </td>
                          </form>
                          
                        </tr>
                    <?php }
                } else { ?>
                    <div class="alert alert-info" role="alert" style="">
                      <h4>No Payment History</h4>
                    </div>
                <?php } ?>  
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Old Balance Modal -->
<div class="modal fade" id="staticBackdrop_old_balance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">💸 Update Old Balance</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="old_balance" class="form-label">Current Old Balance: ₹<?php echo $rev_old_balance; ?></label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input type="number" class="form-control" id="old_balance" name="old_balance" placeholder="Enter new old balance amount">
                </div>
            </div>
            <button class="btn btn-warning" name="submit_old_balance" type="submit">
                <i class="fas fa-save me-1"></i> Update Balance
            </button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>

<script type="text/javascript">
   $('.show_delete').click(function () {
    $(this).hide(); // hide the trash icon button
    $(this).siblings('.show_div').show(); // show the confirmation
});

$('.no').click(function () {
    let block = $(this).closest('.delete-block');
    block.find('.show_div').hide(); // hide the confirmation
    block.find('.show_delete').show(); // show the trash icon back
});

</script>