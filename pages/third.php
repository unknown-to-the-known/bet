
<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php $today = date('Y-m-d h:i a'); ?>
<?php 
    if (isset($_SESSION['teach_details'])) {
        $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
    } else {
        header("Location: " . BASE_URL . 'index');
    }        
?>
<?php 
     // echo "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'";
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$teacher_email_id' AND user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['user_name'], ENT_QUOTES, 'UTF-8');
            // /$school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['user_school_id'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>
<?php 
    $uniq_id_generator = md5(date('Y-m-d H:i:s a'));

    function generateRandomText() {
        $timestamp = date('ymdHis'); // 12 digits from date and time
        $random = rand(10, 99); // Adding 2 random digits
        return substr($timestamp . $random, 0, 12);
    }
?>
<?php 
    if (isset($_GET['uni_id'])) {
        if ($_GET['uni_id'] != "") {
            $_SESSION['student_id'] = $student_uniq_id = htmlspecialchars($_GET['uni_id'], ENT_QUOTES, 'UTF-8');
        } else {
             header("Location: " . BASE_URL . 'pages/add_student');
        }
    } else {
             header("Location: " . BASE_URL . 'pages/add_student');
        }


    $fetch_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND tree_id = '$student_uniq_id' AND rev_sts != '0'");

    if (mysqli_num_rows($fetch_student_details) > 0) {
        while($row = mysqli_fetch_assoc($fetch_student_details)) {
            $student_name = $row['rev_student_fname'];
        }
    } else {
         header("Location: " . BASE_URL . 'pages/add_student');
    }
?>

<!-- Academic setter -->
<?php 
    if (isset($_SESSION['academic_setter'])) {
        $academic_setter = $_SESSION['academic_setter'];
    } else {
        $academic_setter = '2025_26';
    }

    $academic_setter = str_replace('-', '_', $academic_setter);
?>


<?php 
    $fetch_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND tree_id = '$student_uniq_id' AND rev_sts != '0'");

    if (mysqli_num_rows($fetch_student_details) > 0) {
        while($row = mysqli_fetch_assoc($fetch_student_details)) {
            $student_name = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $st_class = htmlspecialchars($row['rev_admission_class'], ENT_QUOTES, 'UTF-8');
            $st_sem = htmlspecialchars($row['rev_semster'], ENT_QUOTES, 'UTF-8');
            $medium_of_instrtution = htmlspecialchars($row['rev_moi'], ENT_QUOTES, 'UTF-8');
            $rte_yes_no = htmlspecialchars($row['rev_rte'], ENT_QUOTES, 'UTF-8');
            $mother_tongue = htmlspecialchars($row['rev_mother_tongue'], ENT_QUOTES, 'UTF-8');
            $previous_school_affiliation_p = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_tc = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_tc_date = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_name = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_type = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_pincode = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_district = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_taluk = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_city = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $previous_school_address = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $student_pincode = htmlspecialchars($row['rev_student_pincode'], ENT_QUOTES, 'UTF-8');
            $student_district = htmlspecialchars($row['rev_student_district'], ENT_QUOTES, 'UTF-8');
            $student_taluk = htmlspecialchars($row['rev_student_taluk'], ENT_QUOTES, 'UTF-8');
            $student_city = htmlspecialchars($row['rev_student_city'], ENT_QUOTES, 'UTF-8');
            $student_locality = htmlspecialchars($row['rev_student_locality'], ENT_QUOTES, 'UTF-8');
            $student_address = htmlspecialchars($row['rev_student_address'], ENT_QUOTES, 'UTF-8');
            $student_mobile_number = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $student_email_id = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $student_father_mobile_number = htmlspecialchars($row['rev_father_mobile'], ENT_QUOTES, 'UTF-8'); 
            $student_father_email_id = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $student_mother_mobile_number = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $student_mother_email_id = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $student_term1_fee = htmlspecialchars($row['rev_term1_fee'], ENT_QUOTES, 'UTF-8');
            $student_term2_fee = htmlspecialchars($row['rev_term2_fee'], ENT_QUOTES, 'UTF-8');
            $student_sats = htmlspecialchars($row['rev_sats'], ENT_QUOTES, 'UTF-8');
            $student_books = htmlspecialchars($row['rev_books'], ENT_QUOTES, 'UTF-8');
            $student_trans = htmlspecialchars($row['rev_transportation'], ENT_QUOTES, 'UTF-8');
            $student_fees = htmlspecialchars($row['rev_fees'], ENT_QUOTES, 'UTF-8');
            $student_sts = htmlspecialchars($row['rev_sts'], ENT_QUOTES, 'UTF-8');
        }
    } else {
        header("Location: " . BASE_URL . 'pages/add_student');
    }
?>

<?php 
    if (isset($_POST['submit'])) {

        $admission_class = mysqli_escape_string($connection, trim($_POST['admission_class']));
        $admission_semster = mysqli_escape_string($connection, trim($_POST['admission_semster']));
        $admission_moi = mysqli_escape_string($connection, trim($_POST['admission_moi']));
        $admission_mt = mysqli_escape_string($connection, trim($_POST['admission_mt']));
        $new_mother_email_id = mysqli_escape_string($connection, trim($_POST['new_mother_email_id']));
        $new_mother_mobile = mysqli_escape_string($connection, trim($_POST['new_mother_mobile_number']));
        $new_father_email_id = mysqli_escape_string($connection, trim($_POST['new_father_email_id']));
        // $new_father_mobile = mysqli_escape_string($connection, trim($_POST['new_father_mobile_number']));
        $new_student_email_id = mysqli_escape_string($connection, trim($_POST['new_student_email_id']));
        $new_student_mobile = mysqli_escape_string($connection, trim($_POST['new_student_mobile_number']));
        $new_student_pincode = mysqli_escape_string($connection, trim($_POST['new_pincode']));
        $new_student_district = mysqli_escape_string($connection, trim($_POST['new_st_dis']));
        $new_student_taluk = mysqli_escape_string($connection, trim($_POST['new_st_tal']));
        $new_student_city = mysqli_escape_string($connection, trim($_POST['new_st_city']));
        $new_student_locality = mysqli_escape_string($connection, trim($_POST['new_st_locality']));
        $new_student_address = mysqli_escape_string($connection, trim($_POST['new_st_address']));
        $transportation = mysqli_escape_string($connection, trim($_POST['route']));
        $rte = mysqli_escape_string($connection, trim($_POST['inlineRadioOptions4']));
        // Previous details

        $previous_school_affiliation = mysqli_escape_string($connection, trim($_POST['psa']));
        $previous_school_tc = mysqli_escape_string($connection, trim($_POST['tc']));
        $previous_school_tc_date = mysqli_escape_string($connection, trim($_POST['tcd']));
        $previous_school_name = mysqli_escape_string($connection, trim($_POST['psn']));
        $previous_school_type = mysqli_escape_string($connection, trim($_POST['pst']));
        $previous_school_pincode = mysqli_escape_string($connection, trim($_POST['prev_pincode']));
        $previous_school_district = mysqli_escape_string($connection, trim($_POST['prev_dis']));
        $previous_school_taluk = mysqli_escape_string($connection, trim($_POST['prev_tal']));
        $previous_school_city = mysqli_escape_string($connection, trim($_POST['prev_city']));
        $previous_school_address = mysqli_escape_string($connection, trim($_POST['prev_school_address']));

        $sats_number = mysqli_escape_string($connection, trim($_POST['sats']));
        $new_student_sdf = mysqli_escape_string($connection, trim($_POST['new_student']));
        // Concession
        $con_amount = mysqli_escape_string($connection, trim($_POST['concession_fee']));
        $con_referred_by = mysqli_escape_string($connection, trim($_POST['refered_by']));


        if ($new_student_locality == "") {
            $new_student_locality = '0';
        }

        if ($new_student_mobile == "") {
            $new_student_mobile = '0';
        }
        if ($new_student_email_id == "") {
            $new_student_email_id = '0';
        }
        if ($new_father_email_id == "") {
            $new_father_email_id = '0';
        }
        if ($new_mother_email_id == "") {
            $new_mother_email_id = '0';
        }
        if ($new_mother_mobile == "") {
            $new_mother_mobile = '0';
        }

        // admission fee

        $school_with_admission_fee = ['svp.revisewell.com', 'stpeters.revisewell.com', 'bet.revisewell.com'];
        // Default fee
        $admission_fee = '0';

        // Check if admission fee is applicable
        if (in_array($_SERVER['HTTP_HOST'], $school_with_admission_fee)) {
            if ($new_student_sdf == 'yes') {
                if ($_SERVER['HTTP_HOST'] == 'stpeters.revisewell.com') {
                    if (in_array($admission_class, ['baby', 'lkg', 'ukg'])) {
                        $admission_fee = '12000';
                    } elseif (in_array($admission_class, ['1','2','3','4','5','6','7'])) {
                        $admission_fee = '10000';
                    } elseif (in_array($admission_class, ['8','9','10'])) {
                        $admission_fee = '5000';
                    }
                }

                if ($_SERVER['HTTP_HOST'] == 'svp.revisewell.com') {
                    if (in_array($admission_class, ['baby', 'lkg', 'ukg'])) {
                        $admission_fee = '1000';
                    } elseif (in_array($admission_class, ['1','2','3','4','5','6','7','8','9','10'])) {
                        $admission_fee = '2000';
                    }
                }

                if ($_SERVER['HTTP_HOST'] == 'bet.revisewell.com') {
					echo $_SERVER['HTTP_HOST'];
                    if (in_array($admission_class, ['baby', 'lkg', 'ukg'])) {
                        $admission_fee = '1000';
                    } elseif (in_array($admission_class, ['1','2','3','4','5','6','7','8','9','10'])) {
                        $admission_fee = '2000';
                    }
                }
            }
        }


        if ($con_amount != '0') {
            $con_amount = $con_amount;
        } else {
            $con_amount = '0';
        }

        $term_1_fee  = mysqli_escape_string($connection, trim($_POST['term_1_fee']));
        $books_fee = mysqli_escape_string($connection, trim($_POST['books_fee']));
        $transportation = mysqli_escape_string($connection, trim($_POST['route']));

        

        if ($con_amount != '0') {
            $term_full_fee = ($term_1_fee + $admission_fee) - $con_amount;
            $divide = ($term_full_fee - $con_amount)/2;
        } else {
            $term_full_fee = ($term_1_fee + $admission_fee);
            $divide = $term_full_fee/2;
        }

        if ($admission_class == "class" || $admission_semster == "" || $admission_moi == "" || $admission_mt == "" || $previous_school_affiliation == "" || $previous_school_name == "" || $previous_school_type == "" || $previous_school_district == "" || $previous_school_taluk == "" || $previous_school_city == "" || $new_student_pincode == "" || $new_student_district == "" || $new_student_taluk == "" || $new_student_city == "" || $new_student_address == "" || $transportation == "" || $rte == "" || $term_1_fee == "" || $books_fee == '' || $transportation == "" || $sats_number == "") {
            $error_message = "Please fill all the required fields";   
        }

        if (!isset($error_message)) {
            
                $term_full_fee = $term_full_fee;
                $divide = $term_full_fee/2;

            $update = mysqli_query($connection,"UPDATE rev_erp_student_details SET rev_admission_class = '$admission_class', rev_semster = '$admission_semster', rev_moi = '$admission_moi', rev_mother_tongue = '$admission_mt', rev_previous_affiliation = '$previous_school_affiliation', rev_previous_school_name = '$previous_school_name', rev_previous_school_type = '$previous_school_type', rev_previous_district = '$previous_school_district', rev_previous_taluk = '$previous_school_taluk', rev_previous_city = '$previous_school_city', rev_previous_tc_number = '$previous_school_tc', rev_previous_tc_date = '$previous_school_tc_date', rev_previous_pincode = '$previous_school_pincode', rev_prev_address = '$previous_school_address', rev_student_pincode = '$new_student_pincode', rev_student_district = '$new_student_district', rev_student_taluk = '$new_student_taluk',rev_student_city = '$new_student_city', rev_student_locality = '$new_student_locality', rev_student_address = '$new_student_address',rev_student_mobile = '$new_student_mobile', rev_student_email = '$new_student_email_id', rev_father_email = '$new_father_email_id', rev_mother_mobile = '$new_mother_mobile', rev_mother_email = '$new_mother_email_id', rev_rte = '$rte', rev_transportation = '$transportation', rev_sts = '1', rev_fees = '$term_full_fee', rev_term1_fee = '$divide', rev_term2_fee = '$divide', rev_books = '$books_fee', rev_sats = '$sats_number',  rev_admission_fee = '$admission_fee', rev_consession = '$con_amount',  rev_refered_by = '$con_referred_by',rev_trans_fixed_amount = '$transportation' WHERE tree_id = '$student_uniq_id'");

            if (isset($update)) {
                $error_message = "Success, Please wait for 5 seconds";
                 header( "refresh:1;url=https://" . $_SERVER['HTTP_HOST'] . "/pages/display_student_list");
            }
        }
    }
?>

<?php
    $classes = ['baby', 'lkg', 'ukg', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
    $fee_types = ['fee' => 'tution_fee', 'book' => 'books_fee', 'trans' => 'trans_fee'];

    $fees = [];
    foreach ($classes as $class) {
        foreach ($fee_types as $category => $var_name) {
            $fees[$class][$var_name] = 0;
            
            $query = "SELECT master_amount FROM erp_master_details WHERE master_year = '2025_26' 
                      AND master_sts = '1' AND master_class = '$class'";
            
            if ($category == 'trans') {
                $query .= " AND master_name = 'trans'";
            } else {
                $query .= " AND master_cat = '$category'";
            }
            
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $fees[$class][$var_name] += $row['master_amount'];
                }
            }
        }
    }

?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link href="https://releases.transloadit.com/uppy/v3.23.0/uppy.min.css" rel="stylesheet">
<div class="container zindex-100 desk" style="margin-top: 10px">
        <div style="float: left;">
            <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px; width: 170px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
        </div>
    </div>
    <section>
        <!-- Content START -->
        <div class="container zindex-100 desk mb-4">
            <div class="row d-lg-flex justify-content-md-center g-md-5">                        
                <h4 class="fs-1 fw-bold d-flex justify-content-center">
                    <img src="<?php echo BASE_URL; ?>assets/images/add-user.webp" width="50px" height="50px" alt="Homework">
                    <span class="position-relative z-index-9" style="font-size: 33px;">&nbsp;Add new&nbsp;</span>
                    <span class="position-relative z-index-1" style="font-size: 33px;">Student
                </h4>
            </div> <!-- Row END -->
        </div>              
    </section>

    <div class="col-md-12 single_upload_box">
                <div class="card card-body shadow p-4 p-sm-5 position-relative">
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
                            <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
                        </symbol>
                        <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
                            <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
                        </symbol>
                    </svg>  
                    

                        <?php 
                            if (isset($error_message)) { ?>
                                <div class="alert alert-warning" role="alert">
                                  <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            <?php } ?>

                    <!-- Form START -->                 
                    <form class="row g-3 position-relative" autocomplete="off" action="" method="post">
                        <h3>Enter details about <?php echo ucfirst($student_name); ?></h3>

                        
                        <!-- Admission_details -->


                        <div class="col-md-4">
                            <label class="text-dark fw-bold">Admission to Class<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <select class="form-select js-choice border-0 z-index-9 bg-transparent" aria-label=".form-select-sm" name="admission_class" id="amountDropdown" required>
                                     <option value="class">Class</option>
                                   <?php 
                                        $fetch_class = mysqli_query($connection, "SELECT DISTINCT master_class FROM erp_master_details WHERE master_sts = '1' AND master_year = '$academic_setter'");
                                        if (mysqli_num_rows($fetch_class) > 0) {
                                            while ($rowss = mysqli_fetch_assoc($fetch_class)) { ?>
                                                <option 
                                                      value="<?php echo $rowss['master_class']; ?>"
                                                      data-amount1="<?php echo $fees[$rowss['master_class']]['tution_fee']; ?>"
                                                      data-amount2="<?php echo $fees[$rowss['master_class']]['books_fee']; ?>"
                                                      data-amount3="<?php echo $fees[$rowss['master_class']]['trans_fee']; ?>"
                                                      <?php if ($rowss['master_class'] == $st_class) echo 'selected'; ?>>
                                                      Grade <?php echo $rowss['master_class']; ?>
                                                    </option>
                                            <?php }
                                        } 
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Semester -->
                        <div class="col-md-4">
                            <label class="text-dark fw-bold">Semster<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <select class="form-select js-choice border-0 z-index-9 bg-transparent" aria-label=".form-select-sm" name="admission_semster" required>
                                    <option value="sem1">Semster1</option>
                                                                        
                                </select>
                            </div>
                        </div>

                        <!-- Medium of Instruction -->
                        <div class="col-md-4">
                            <label class="text-dark fw-bold">Medium of Instruction<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <select class="form-select js-choice border-0 z-index-9 bg-transparent" aria-label=".form-select-sm" name="admission_moi" required>
                                    <option value="english">English</option>
                                                                 
                                </select>
                            </div>
                        </div>

                        <!-- RTE -->
                        <div class="col-md-4" >                         
                            <label class="text-dark fw-bold">RTE<span style="color:red;">*</span></label>
                            <br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="" value="yes" <?php
                                if ($rte_yes_no == "yes") {
                                    echo 'checked';
                                }
                               ?>>
                              <label class="form-check-label text-dark" for="inlineRadio4">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="" value="no" <?php
                                if ($rte_yes_no == "no") {
                                    echo 'checked';
                                }
                               ?>>
                              <label class="form-check-label text-dark" for="inlineRadio4">No</label> 
                            </div>
                                                 
                        </div>
                         <!-- Mother tongue -->
                        <div class="col-md-4">
                            <label class="text-dark fw-bold" for="browser">Mother Tongue<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <input list="mt" name="admission_mt" id="browser" class="form-control border-0 me-1" value="<?php
                                    if ($mother_tongue == '0') {
                                        echo '';
                                    } else {
                                        echo $mother_tongue;
                                    } ?>">
                                  <datalist id="mt">
                                    <option value="kannada">
                                    <option value="hindi">
                                    <option value="urdu">
                                    <option value="english">
                                    <option value="marathi">
                                    <option value="tamil">
                                    <option value="telugu">
                                  </datalist>
                            </div>
                        </div>
                        <!-- Transportation -->
                        <!-- <div class="col-md-4" >                         
                            <label class="text-dark fw-bold">Select Route<span style="color:red;">*</span></label>
                            <br>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <select class="form-select js-choice border-0 z-index-9 bg-transparent" aria-label=".form-select-sm" name="route" required>
                                    <option value="">Select Route</option>
                                    <option value="1500">Mothi Circle</option>
                                    <option value="2500">Royal Circle</option>
                                    <option value="2000">Revisewell Office</option>
                                    <option value="1800">S P Circle</option>    
                                                                
                                </select>
                            </div>
                                                 
                        </div>  -->                     
                        <hr>
                        
                        <h3>Previous School Details(If Applicable) <button class="btn btn-danger float-end not_applicable" type="button">Not applicable</button><button class="btn btn-success float-end show_applicable" type="button">Show applicable</button></h3>
                        
                        <!-- Name -->
                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold" for="psa1">Previous School Affiliation<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <input list="psa" name="psa" id="psa1" class="form-control border-0 me-1 s_afflication psa1">
                                  <datalist id="psa">
                                    <option value="state">
                                    <option value="cbse">
                                    <option value="icse">                                   
                                  </datalist>
                            </div>
                        </div>

                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold" for="psa2">Transfer Certificate No.</label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 t_c psa2" type="text" placeholder="Transfer Certificate No" name="tc" autocomplete="nope" id="psa2" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold" for="psa3">Transfer Certificate Date.</label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 t_d psa3" type="date" placeholder="Transfer Certificate No" name="tcd" autocomplete="nope" id="psa3" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold" for="psa4">Previous School Name<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 p_s psa4" type="text" placeholder="Previous School Name" name="psn" autocomplete="nope" value="" id="psa4" required>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold">Previous School Type<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <select class="form-select js-choice border-0 z-index-9 bg-transparent p_s_t psa5" aria-label=".form-select-sm" name="pst" required>
                                    <option value="0">Previous School Type</option>
                                    <option value="government_school">Government School</option>
                                    <option value="private_aided_school">Private Aided School</option>
                                    <option value="local_bodies">Local Bodies</option>
                                    <option value="private_unaided_school">Private Unaided School</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold" for="psa6">Pincode</label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 p_c psa6" type="number" placeholder="Enter Pincode" name="prev_pincode" autocomplete="nope" value="" id="psa6" required>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold" for="psa7">District<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <input list="dis" name="prev_dis" id="psa7" class="form-control border-0 me-1 d psa7">
                                  <datalist id="dis">
                                    <option value="Bengaluru_Urban">
                                    <option value="Belagavi">
                                    <option value="Bidar">
                                    <option value="Dharwad">
                                    <option value="Bidar">
                                    <option value="Chikkamagaluru">                                 
                                  </datalist>
                            </div>
                        </div>

                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold" for="psa8">Taluk<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <input list="tal" name="prev_tal" id="psa8" class="form-control border-0 me-1 t psa8">
                                  <datalist id="tal">
                                    <option value="Bengaluru taluk">
                                    <option value="Belagavi taluk">
                                    <option value="Bidar taluk">
                                    <option value="Dharwad taluk">
                                    <option value="Bidar taluk">
                                    <option value="Chikkamagaluru taluk">                                   
                                  </datalist>
                            </div>
                        </div>

                        <div class="col-md-4 apl">
                            <label class="text-dark fw-bold" for="psa9">City/Village/Town<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1 c psa9" type="text" placeholder="Enter City/Village/Town" name="prev_city" autocomplete="nope" value="" id="psa9" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-8 apl">
                            <label class="text-dark fw-bold" for="psa10">Previous School Address</label>
                            <div class="form-floating">
                              <textarea class="form-control p_add psa10" placeholder="Leave a comment here" id="psa10" name="prev_school_address"></textarea>
                              <!-- <label for="floatingTextarea"></label> -->
                            </div>
                        </div>
                        

                        <!-- Contact Details -->


                        <h3 class="text-center">Admission Details</h3>
                        <!-- Class -->
                        
                        
                        
                        
                                            
                        <h3>Student Contact Details</h3>
                        <div class="col-md-4">
                            <label class="text-dark fw-bold" for="pincode">Pincode<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="number" placeholder="Enter Pincode" name="new_pincode" autocomplete="nope" value="583101" id="pincode" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="text-dark fw-bold" for="stdis1">District<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <input list="stdis" name="new_st_dis" id="stdis1" class="form-control border-0 me-1" value="Ballari">
                                  
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="text-dark fw-bold" for="sttal1">Taluk<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <input list="sttal" name="new_st_tal" id="sttal1" class="form-control border-0 me-1" value="Ballari">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="text-dark fw-bold" for="city">City/Village/Town<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Enter City/Village/Town" name="new_st_city" autocomplete="nope" value="Ballari" id="city" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="text-dark fw-bold" for="locality">Locality</label>
                            <div class="bg-body shadow rounded-pill p-2">
                                <div class="input-group">
                                    <input class="form-control border-0 me-1" type="text" placeholder="Enter Locality" name="new_st_locality" autocomplete="nope" value="<?php if($student_locality == '0') {
                                            echo '';
                                    } else {
                                        echo $student_locality;
                                    } ?>" id="locality">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-2"></div> -->
                        <div class="col-md-4">
                            <label class="text-dark fw-bold" for="stdfloatingTextarea">Address<span style="color:red;">*</span></label>
                            <div class="form-floating">
                              <textarea class="form-control" placeholder="Leave a comment here" id="stdfloatingTextarea" name="new_st_address">
                                Sharada Vidya Peetha School
                                </textarea>
                              <!-- <label for="floatingTextarea"></label> -->
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Student Mobile number & Email Id</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="number" placeholder="Enter Mobile number" name="new_student_mobile_number" autocomplete="nope" value="">                                               
                                            </div>                              
                                        </div>  
                                        <div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter student Email Id" name="new_student_email_id" autocomplete="nope" value="">                                               
                                            </div>
                                        </div>                                  
                                </div>
                            </div>                      
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Father Email Id </label>
                                        <!-- <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="number" placeholder="Father Mobile number" name="new_father_mobile_number" autocomplete="nope" value="<?php if ($student_father_mobile_number == '0') {
                                                    echo '';
                                                }else {
                                                    echo $student_father_mobile_number;
                                                } ?>" required>                                               
                                            </div>                              
                                        </div>  --> 
                                        <div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter Father Email Id" name="new_father_email_id" autocomplete="nope" value="">                                             
                                            </div>
                                        </div>                                  
                                </div>
                            </div>                      
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Mother Mobile number & Email Id</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="number" placeholder="Mother Mobile number" name="new_mother_mobile_number" autocomplete="nope" value="" >                                               
                                            </div>                              
                                        </div>  
                                        <div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter Mother Email Id" name="new_mother_email_id" autocomplete="nope" value="" >                                             
                                            </div>
                                        </div>                                  
                                </div>
                            </div>                      
                        </div>
                        
                                <div class="col-md-4">
                                    <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                        <div class="card-body" style="background:#fff;">

                                            <label class="text-dark fw-bold">Total Fee<span style="color:red;">*</span></label>
                                                <div class="bg-body shadow rounded-pill p-2">
                                                    <div class="input-group">
                                                        <input class="form-control border-0 me-1" type="number" placeholder="Term 1 Fee" name="term_1_fee" autocomplete="nope" value="<?php echo $student_fees; ?>" id="input1" <?php if ($student_sts == '1') {
                                                            echo 'readonly';
                                                        } ?>>                                               
                                                    </div>                              
                                                </div>                        
                                        </div>
                                    </div>                      
                                </div>

                                <div class="col-md-4">
                                    <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                        <div class="card-body" style="background:#fff;">
                                            <label class="text-dark fw-bold">Books Fee<span style="color:red;">*</span></label>
                                                <div class="bg-body shadow rounded-pill p-2">
                                                    <div class="input-group">
                                                        <input class="form-control border-0 me-1" type="number" placeholder="Books fee" name="books_fee" autocomplete="nope" value="<?php echo $student_books; ?>" id="input2" <?php if ($student_sts == '1') {
                                                            echo 'readonly';
                                                        } ?>>                                               
                                                    </div>                              
                                                </div>                        
                                        </div>
                                    </div>                      
                                </div>

                                <div class="col-md-4">
                                    <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                        <div class="card-body" style="background:#fff;">
                                            <label class="text-dark fw-bold">Transportation Fee<span style="color:red;">*</span></label>
                                                <div class="bg-body shadow rounded-pill p-2">
                                                    <div class="input-group">
                                                        <input class="form-control border-0 me-1" type="number" placeholder="Transportation Fee" name="route" autocomplete="nope" value="<?php echo $student_trans; ?>" id="input3" <?php if ($student_sts == '1') {
                                                            echo 'readonly';
                                                        } ?>>
                                                    </div>                              
                                                </div>                        
                                        </div>
                                    </div>                      
                                </div>
                            

                        

                            <?php 
                                if (mysqli_num_rows($fetch_student_details) > 0) { ?>
                                    <div class="col-md-4">
                                        <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                            <div class="card-body" style="background:#fff;">
                                                <label class="text-dark fw-bold">Unique No.<span style="color:red;">*</span></label>
                                                    <div class="bg-body shadow rounded-pill p-2">
                                                        <div class="input-group">
                                                            <input class="form-control border-0 me-1" type="number" placeholder="SATS No." name="sats" autocomplete="nope" value="<?php echo generateRandomText(); ?>" readonly>                                               
                                                        </div>                              
                                                    </div>                        
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                        
                        <?php if ($student_sts != '1') { ?>
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Admission Fee(New student only)<span style="color:red;">*</span></label>
                                            <div class="input-group">
                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="new_student" id="inlineRadio1" value="yes">
                                                  <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="new_student" id="inlineRadio2" value="no">
                                                  <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>                                            
                                            </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Concession</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="number" placeholder="concession amount" name="concession_fee" autocomplete="nope" value="0" <?php if ($student_sts == '1') {
                                                            echo 'readonly';
                                                        } ?>>                                               
                                            </div>                              
                                        </div> 

                                    <label class="text-dark fw-bold">Referred By</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Referred By" name="refered_by" autocomplete="nope" value="owner" <?php if ($student_sts == '1') {
                                                            echo 'readonly';
                                                        } ?>>
                                            </div>                              
                                        </div>                        
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            
                        </div>
                        <div class="col-md-4"></div>

                        <button class="btn btn-success" style="width:100%;" type="submit" name="submit">Submit</button>


                    </form>
                </div>
    </div>
<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>

<script type="text/javascript">
    $('.apl').hide();
    $('.not_applicable').hide();
        $('.psa1').val('0');
        $('.psa2').val('0');
        $('.psa3').val('1901-01-01');
        $('.psa4').val('0');
        $('.psa5').val('0');
        $('.psa6').val('0');
        $('.psa7').val('0');
        $('.psa8').val('0');
        $('.psa9').val('0');
        $('.psa10').val('0');


    $('.not_applicable').click(function() {
        $('.psa1').val('0');
        $('.psa2').val('0');
        $('.psa3').val('1901-01-01');
        $('.psa4').val('0');
        $('.psa5').val('0');
        $('.psa6').val('0');
        $('.psa7').val('0');
        $('.psa8').val('0');
        $('.psa9').val('0');
        $('.psa10').val('0');
         $('.apl').hide();
        $('.show_applicable').show();
        $('.not_applicable').hide();
    })

    $('.show_applicable').click(function() {
        $('.psa1').val('');
        $('.psa2').val('');
        $('.psa3').val('');
        $('.psa4').val('');
        $('.psa5').val('');
        $('.psa6').val('');
        $('.psa7').val('');
        $('.psa8').val('');
        $('.psa9').val('');
        $('.psa10').val('');
         $('.apl').show();
        $('.not_applicable').show();
        $('.show_applicable').hide();
    }) 

    // Auto fee update
    $(document).ready(function(){
        $('#amountDropdown').change(function(){
            var selectedOption = $(this).find(':selected');
            $('#input1').val(selectedOption.data('amount1'));
            $('#input2').val(selectedOption.data('amount2'));
            $('#input3').val(selectedOption.data('amount3'));
        });
    });

</script>
