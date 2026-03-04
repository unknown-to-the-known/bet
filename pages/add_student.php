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
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$teacher_email_id' AND user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['user_name'], ENT_QUOTES, 'UTF-8');
            $school_name = 'sds';
            $school_id = htmlspecialchars($i['user_school_id'], ENT_QUOTES, 'UTF-8');                       
         }  
    }
?>

<?php 
    $uniq_id_generator = bin2hex(random_bytes(16));
?>

<?php 
    if (isset($_GET['uniq_id'])) {
        if ($_GET['uniq_id'] != "") {
            $student_uniq_id = htmlspecialchars($_GET['uniq_id'], ENT_QUOTES, 'UTF-8');
        } else {
            header("Location: " . BASE_URL . 'pages/action');
        }
    } else {
        header("Location: " . BASE_URL . 'pages/action');
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
if (isset($_POST['submit'])) {
    $student_first_name = mysqli_escape_string($connection, trim($_POST['student_fname']));
    $father_first_name = mysqli_escape_string($connection, trim($_POST['father_fname']));
    $mother_first_name = mysqli_escape_string($connection, trim($_POST['mother_fname']));
    $uniq_id = mysqli_escape_string($connection, trim($_POST['uniq_id']));

    $student_middle_name = mysqli_escape_string($connection, trim($_POST['student_mname']));
    $father_middle_name = mysqli_escape_string($connection, trim($_POST['father_mname']));
    $mother_middle_name = mysqli_escape_string($connection, trim($_POST['mother_mname']));

    $student_last_name = mysqli_escape_string($connection, trim($_POST['student_lname']));
    $father_last_name = mysqli_escape_string($connection, trim($_POST['father_lname']));
    $mother_last_name = mysqli_escape_string($connection, trim($_POST['mother_lname']));
    $p_number = mysqli_escape_string($connection, trim($_POST['primary_number']));
    $stu_number = mysqli_real_escape_string($connection, trim($_POST['section_of_class']));
    $stu_admission_number = mysqli_escape_string($connection, trim($_POST['admission_number_student']));

    if ($student_first_name == "" || $father_first_name == "" || $mother_first_name == "" || $uniq_id == "" || $p_number == "" || $stu_number == "") {
        $error_message = "please fill all the fields";
    }

    if (!isset($error_message)) {
        if (strlen($student_first_name) > 20 || strlen($student_first_name) < 2) {
            $error_message = "Student first name must be more than 2 and less than 20 characters";
        }
    }


    if (!isset($error_message)) {
        if (strlen($father_first_name) > 20 || strlen($father_first_name) < 2) {
            $error_message = "Father first name must be more than 2 and less than 20 characters";
        }
    }

    if (!isset($error_message)) {
        if (strlen($mother_first_name) > 20 || strlen($mother_first_name) < 2) {
            $error_message = "Mother first name must be more than 2 and less than 20 characters";
        }
    }

    if (!isset($error_message)) {
        if (strlen($p_number) > 10 || strlen($p_number) < 10) {
            $error_message = "Mobile number must be 10 digits";
        }
    }


    if (!isset($error_message)) {
        // Check if uniq_id present
        // echo "SELECT * FROM rev_erp_student_details WHERE rev_uniq_id = '$student_uniq_id' AND rev_sts = '1'";
        // echo "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_uniq_id' AND rev_sts = '1'";
            $uniq_id_checker = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_uniq_id' AND rev_sts = '1'");
            if (mysqli_num_rows($uniq_id_checker) > 0) {
                // header("Refresh:0");
                $update = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_student_fname = '$student_first_name', rev_student_mname = '$student_middle_name', rev_student_lname = '$student_last_name', rev_father_fname = '$father_first_name', rev_father_mname = '$father_middle_name', rev_father_lname = '$father_last_name', rev_mother_fname = '$mother_first_name',    rev_mother_mname = '$mother_middle_name', rev_mother_lname = '$mother_last_name',rev_father_mobile = '$p_number', rev_section = '$stu_number', stud_admiss_number = '$stu_admission_number' WHERE tree_id = '$student_uniq_id'");

                if (isset($update)) {
                      header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
                }
            } else {
                $new_data_insert = "INSERT INTO rev_erp_student_details(rev_student_fname,rev_father_fname,rev_mother_fname,rev_uniq_id,rev_student_mname,rev_student_lname,rev_father_mname,rev_father_lname,rev_mother_mname,rev_mother_lname,rev_school_id,rev_school_name,rev_academic_year,rev_father_mobile, rev_section,stud_admiss_number) VALUES ('$student_first_name','$father_first_name', '$mother_first_name', '$uniq_id_generator', '$student_middle_name', '$student_last_name','$father_middle_name','$father_last_name', '$mother_middle_name', '$mother_last_name', '$school_id', '$school_name', '$academic_setter','$p_number','$stu_number', '$stu_admission_number')";
                if (mysqli_query($connection, $new_data_insert)) {
                  $last_id = mysqli_insert_id($connection);
                  $uni_id = $last_id;
                       header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $uni_id);
                } else {
                  $error_message = "Error, something went wrong";
                }
            }       
    }    
   }
?>

<!-- Save and Exit -->
<?php 
if (isset($_POST['submit_2'])) {
    $student_first_name = mysqli_escape_string($connection, trim($_POST['student_fname']));
    $father_first_name = mysqli_escape_string($connection, trim($_POST['father_fname']));
    $mother_first_name = mysqli_escape_string($connection, trim($_POST['mother_fname']));
    $uniq_id = mysqli_escape_string($connection, trim($_POST['uniq_id']));

    $student_middle_name = mysqli_escape_string($connection, trim($_POST['student_mname']));
    $father_middle_name = mysqli_escape_string($connection, trim($_POST['father_mname']));
    $mother_middle_name = mysqli_escape_string($connection, trim($_POST['mother_mname']));

    $student_last_name = mysqli_escape_string($connection, trim($_POST['student_lname']));
    $father_last_name = mysqli_escape_string($connection, trim($_POST['father_lname']));
    $mother_last_name = mysqli_escape_string($connection, trim($_POST['mother_lname']));
    $p_number = mysqli_escape_string($connection, trim($_POST['primary_number']));
    $stu_number = mysqli_real_escape_string($connection, trim($_POST['section_of_class']));
    $stu_admission_number = mysqli_escape_string($connection, trim($_POST['admission_number_student']));

    if ($student_first_name == "" || $father_first_name == "" || $mother_first_name == "" || $uniq_id == "" || $p_number == "" || $stu_number == "") {
        $error_message = "please fill all the fields";
    }

    if (!isset($error_message)) {
        if (strlen($student_first_name) > 20 || strlen($student_first_name) < 2) {
            $error_message = "Student first name must be more than 2 and less than 20 characters";
        }
    }


    if (!isset($error_message)) {
        if (strlen($father_first_name) > 20 || strlen($father_first_name) < 2) {
            $error_message = "Father first name must be more than 2 and less than 20 characters";
        }
    }

    if (!isset($error_message)) {
        if (strlen($mother_first_name) > 20 || strlen($mother_first_name) < 2) {
            $error_message = "Mother first name must be more than 2 and less than 20 characters";
        }
    }

    if (!isset($error_message)) {
        if (strlen($p_number) > 10 || strlen($p_number) < 10) {
            $error_message = "Phone number must be 10 digits";
        }
    }

    if (!isset($error_message)) {
        // Check if uniq_id present
        // echo "SELECT * FROM rev_erp_student_details WHERE rev_uniq_id = '$student_uniq_id' AND rev_sts = '1'";
            $uniq_id_checker = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_uniq_id' AND rev_sts = '1'");
            if (mysqli_num_rows($uniq_id_checker) > 0) {
                // header("Refresh:0");
                $update = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_student_fname = '$student_first_name', rev_student_mname = '$student_middle_name', rev_student_lname = '$student_last_name', rev_father_fname = '$father_first_name', rev_father_mname = '$father_middle_name', rev_father_lname = '$father_last_name', rev_mother_fname = '$mother_first_name',    rev_mother_mname = '$mother_middle_name', rev_mother_lname = '$mother_last_name',rev_father_mobile = '$p_number',rev_section = '$stu_number', stud_admiss_number = '$stu_admission_number' WHERE tree_id = '$student_uniq_id'");

                if (isset($update)) {
                     header("Location: " . BASE_URL . 'pages/display_student_list');
                }
            } else {
                $new_data_insert = "INSERT INTO rev_erp_student_details(rev_student_fname,rev_father_fname,rev_mother_fname,rev_uniq_id,rev_student_mname,rev_student_lname,rev_father_mname,rev_father_lname,rev_mother_mname,rev_mother_lname,rev_school_id,rev_school_name,rev_academic_year,rev_father_mobile,rev_section, stud_admiss_number) VALUES ('$student_first_name','$father_first_name', '$mother_first_name', '$uniq_id_generator', '$student_middle_name', '$student_last_name','$father_middle_name','$father_last_name', '$mother_middle_name', '$mother_last_name', '$school_id', '$school_name', '$academic_setter','$p_number', '$stu_number', '$stu_admission_number')";
                if (mysqli_query($connection, $new_data_insert)) {
                  $last_id = mysqli_insert_id($connection);
                  $uni_id = $last_id;
                     header("Location: " . BASE_URL . 'pages/display_student_list');
                } else {
                  $error_message = "Error, something went wrong";
                }
            }       
    }    
   }
?>
<?php 
    // echo "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND tree_id = '$student_uniq_id' AND rev_sts != '0'";
if (strlen($student_uniq_id) > 7) {
    
} else {
    $fetch_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND tree_id = '$student_uniq_id' AND rev_sts != '0'");

    if (mysqli_num_rows($fetch_student_details) > 0) {
        while($row = mysqli_fetch_assoc($fetch_student_details)) {
            $student_name = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $student_m_name = htmlspecialchars($row['rev_student_mname'], ENT_QUOTES, 'UTF-8');
            $student_l_name = htmlspecialchars($row['rev_student_lname'], ENT_QUOTES, 'UTF-8');
            $father_aadhaar_number_f = htmlspecialchars($row['rev_father_aadhaar_number'], ENT_QUOTES, 'UTF-8');
            $father_aadhaar_doc_f = htmlspecialchars($row['rev_father_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

            $father_f_name = htmlspecialchars($row['rev_father_fname'], ENT_QUOTES, 'UTF-8');
            $father_m_name = htmlspecialchars($row['rev_father_mname'], ENT_QUOTES, 'UTF-8');
            $father_l_name = htmlspecialchars($row['rev_father_lname'], ENT_QUOTES, 'UTF-8');


            $mother_f_name = htmlspecialchars($row['rev_mother_fname'], ENT_QUOTES, 'UTF-8');
            $mother_m_name = htmlspecialchars($row['rev_mother_mname'], ENT_QUOTES, 'UTF-8');
            $mother_l_name = htmlspecialchars($row['rev_mother_lname'], ENT_QUOTES, 'UTF-8');

            $mother_aadhaar_number_f = htmlspecialchars($row['rev_mother_aadhaar_number'], ENT_QUOTES, 'UTF-8');
            $mother_aadhaar_doc_f = htmlspecialchars($row['rev_mother_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

            $student_aadhaar_number_f = htmlspecialchars($row['rev_student_aadhaar_number'], ENT_QUOTES, 'UTF-8');
            $student_aadhaar_doc_f = htmlspecialchars($row['rev_student_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

            $student_urban_rural_f = htmlspecialchars($row['rev_urban_rural'], ENT_QUOTES, 'UTF-8');
            $student_gender_f = htmlspecialchars($row['rev_gender'], ENT_QUOTES, 'UTF-8');

            $student_religion_f = htmlspecialchars($row['rev_religion'], ENT_QUOTES, 'UTF-8');
            $student_dob_f = htmlspecialchars($row['rev_student_dob'], ENT_QUOTES, 'UTF-8');
            $student_dob_doc_f = htmlspecialchars($row['rev_student_dob_doc'], ENT_QUOTES, 'UTF-8');


            $student_caste_number_f = htmlspecialchars($row['rev_student_caste_number'], ENT_QUOTES, 'UTF-8');
            $student_caste_name_f = htmlspecialchars($row['rev_student_caste_name'], ENT_QUOTES, 'UTF-8');
            $student_caste_doc_f = htmlspecialchars($row['rev_student_caste_doc'], ENT_QUOTES, 'UTF-8');

            $father_caste_number_f = htmlspecialchars($row['rev_father_caste_number'], ENT_QUOTES, 'UTF-8');
            $father_caste_name_f = htmlspecialchars($row['rev_father_caste_name'], ENT_QUOTES, 'UTF-8');
            $father_caste_doc_f = htmlspecialchars($row['rev_father_caste_doc'], ENT_QUOTES, 'UTF-8');

            $mother_caste_number_f = htmlspecialchars($row['rev_mother_caste_number'], ENT_QUOTES, 'UTF-8');
            $mother_caste_name_f = htmlspecialchars($row['rev_mother_caste_name'], ENT_QUOTES, 'UTF-8');
            $mother_caste_doc_f = htmlspecialchars($row['rev_mother_caste_doc'], ENT_QUOTES, 'UTF-8');

            $social_category_name_f = htmlspecialchars($row['rev_social_category'], ENT_QUOTES, 'UTF-8');
            $social_category_doc_f = htmlspecialchars($row['rev_social_category_doc'], ENT_QUOTES, 'UTF-8');

            $student_bpl_doc_f = htmlspecialchars($row['rev_bpl_doc'], ENT_QUOTES, 'UTF-8');

            $special_category_name_f = htmlspecialchars($row['rev_special_category'], ENT_QUOTES, 'UTF-8');
            $special_category_doc_f = htmlspecialchars($row['rev_special_category_doc'], ENT_QUOTES, 'UTF-8');

            $bhagya_lakshmi_doc_f = htmlspecialchars($row['rev_bhagyalakshmi_bond_doc'], ENT_QUOTES, 'UTF-8');

            $disbalility_name_f = htmlspecialchars($row['rev_disability_child'], ENT_QUOTES, 'UTF-8');
            $disabality_doc_f = htmlspecialchars($row['rev_disabality_doc'], ENT_QUOTES, 'UTF-8');

            $student_phone_number_father = htmlspecialchars($row['rev_father_mobile'], ENT_QUOTES, 'UTF-8');
            $student_admission_number = htmlspecialchars($row['stud_admiss_number'], ENT_QUOTES, 'UTF-8');
        }
    } else {
        // header("Location: " . BASE_URL . 'pages/add_student');
    }
}
    

?>


<!-- Bulk Upload -->
<?php
if (isset($_POST['b_i'])) {
    $file = $_FILES['file'];
    $name = strtolower($file['name']);
    $size = $file['size'];
    $explode_ext = explode('.', $name);
    $allowed_ext = $explode_ext[1];
    $array = array('csv');

    if (!in_array($allowed_ext, $array)) {
        $error_message = "Sorry, only .csv file is allowed.";
    }

    if ($size > 100000) {
        $error_message =  "File size must be less than 100 KB";
    }

    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $firstRow = true;
    $rowCount = 0;
    $inserted = 0;

    while (($data = fgetcsv($handle)) !== FALSE) {
        if ($firstRow) {
            $firstRow = false; // skip header
            continue;
        }
        $rowCount++;
        // Sanitize and extract values from CSV row
        $student_first_name_excel = mysqli_real_escape_string($connection, trim($data[0]));
        $student_father_name_excel = mysqli_real_escape_string($connection, trim($data[1]));
        $student_mother_name_excel = mysqli_real_escape_string($connection, trim($data[2]));
        $student_urbal_rural_excel = mysqli_real_escape_string($connection, trim($data[3]));
        $student_gender_excel = mysqli_real_escape_string($connection, trim($data[4]));
        $student_religion_excel = mysqli_real_escape_string($connection, trim($data[5]));
        $student_dob_excel = mysqli_real_escape_string($connection, trim($data[6]));
        $student_social_category_excel = mysqli_real_escape_string($connection, trim($data[7]));
        $student_disabality_excel = mysqli_real_escape_string($connection, trim($data[8]));
        $student_admission_excel = mysqli_real_escape_string($connection, trim($data[9]));
        $student_sem_excel = mysqli_real_escape_string($connection, trim($data[10]));
        $student_moi_excel = mysqli_real_escape_string($connection, trim($data[11]));
        $student_pincode_excel = mysqli_real_escape_string($connection, trim($data[12]));
        $student_district_excel = mysqli_real_escape_string($connection, trim($data[13]));
        $student_taluk_excel = mysqli_real_escape_string($connection, trim($data[14]));
        $student_city_excel = mysqli_real_escape_string($connection, trim($data[15]));
        $student_address_excel = mysqli_real_escape_string($connection, trim($data[16]));
        $student_father_mobile_excel = mysqli_real_escape_string($connection, trim($data[17]));
        $student_term1_excel = mysqli_real_escape_string($connection, trim($data[18]));
        $student_term2_excel = mysqli_real_escape_string($connection, trim($data[19]));
        $student_books_excel = mysqli_real_escape_string($connection, trim($data[20]));
        $student_trans_excel = mysqli_real_escape_string($connection, trim($data[21]));
        $student_sats_excel = mysqli_real_escape_string($connection, trim($data[22]));
        $student_rte_excel = mysqli_real_escape_string($connection, trim($data[23]));
        $student_mother_tongue_excel = mysqli_real_escape_string($connection, trim($data[24]));
        $student_section = mysqli_real_escape_string($connection, trim($data[25]));

        $sum_fees = (int)$student_term1_excel + (int)$student_term2_excel;
        $uniq_id = uniqid();

        $sql = "INSERT INTO rev_erp_student_details (
            rev_school_id, rev_school_name, rev_admission_class, rev_semster,
            rev_mother_tongue, rev_moi, rev_previous_affiliation, rev_previous_tc_number, rev_previous_tc_date,
            rev_previous_school_name, rev_previous_school_type, rev_previous_pincode, rev_previous_district,
            rev_previous_taluk, rev_previous_city, rev_prev_address, rev_student_fname, rev_student_mname,
            rev_student_lname, rev_father_fname, rev_father_mname, rev_father_lname, rev_mother_fname,
            rev_mother_mname, rev_mother_lname, rev_father_aadhaar_number, rev_father_aadhaar_doc,
            rev_mother_aadhaar_number, rev_mother_aadhaar_doc, rev_student_dob, rev_student_dob_doc,
            rev_student_age_appropriation_reason, rev_student_aadhaar_number, rev_student_aadhaar_doc,
            rev_urban_rural, rev_gender, rev_religion, rev_student_caste_number, rev_student_caste_doc,
            rev_student_caste_name, rev_father_caste_number, rev_father_caste_doc, rev_father_caste_name,
            rev_mother_caste_doc, rev_mother_caste_number, rev_mother_caste_name, rev_social_category,
            rev_social_category_doc, rev_bpl, rev_bpl_doc, rev_bpl_number, rev_bhagyalakshmi_bond_number,
            rev_bhagyalakshmi_bond_doc, rev_disability_child, rev_disabality_doc, rev_special_category,
            rev_special_category_doc, rev_student_pincode, rev_student_district, rev_student_taluk,
            rev_student_city, rev_student_locality, rev_student_address, rev_student_mobile, rev_student_email,
            rev_father_mobile, rev_father_email, rev_mother_mobile, rev_mother_email, rev_rte,
            rev_transportation, rev_fees, rev_uniq_id, rev_term1_fee, rev_term2_fee, rev_dress,
            rev_books, rev_sats, rev_old_balance, rev_academic_year, rev_admission_fee, rev_semster
        ) VALUES (
            '$school_id', '$school_name', '$student_admission_excel', '$student_sem_excel','$student_mother_tongue_excel', '$student_moi_excel', '0', '0', '0', '0', '0', '0', '0','0', '0', '0', '$student_first_name_excel', '0','0', '$student_father_name_excel', '0', '0', '$student_mother_name_excel','0', '0', '0', '0','0', '0', '$student_dob_excel', '0','0', '0', '0','$student_urbal_rural_excel', '$student_gender_excel', '$student_religion_excel', '0', '0','0', '0', '0', '0','0', '0', '$student_social_category_excel','0', '0', '0', '0', '0','0', '0', '$student_disabality_excel', '0','0', '$student_pincode_excel', '$student_district_excel', '$student_taluk_excel','$student_city_excel', '0', '$student_address_excel', '0', '0','0','$student_father_mobile_excel', '0', '0', '0','$student_rte_excel', '$student_trans_excel', '$sum_fees', '$uniq_id','$student_term1_excel', '$student_term2_excel', '0','$student_books_excel', '$student_sats_excel', '0', '$academic_setter', '0', '$student_section')";

        if (mysqli_query($connection, $sql)) {
           $error_message = "Success all data Inserted";
            
        } else {
            $error_message = "❌ Error on row $rowCount: " . mysqli_error($connection) . "<br>";
        }
    }
    fclose($handle);
}
?>
<!-- Final submission after bulk upload -->
<?php 
  
  if (isset($_POST['final'])) {
    $final_update = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_sts = '2'");

    if (mysqli_num_rows($final_update) > 0) {
        $update_sts = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_sts = '1' WHERE rev_sts = '2'");
        if (isset($update_sts)) {
              $error_message = "Success Student Added";
          }  
    } 
  }
?>

<!-- Delete Id -->
<?php 
    if (isset($_POST['delete'])) {
        $delete_id = mysqli_real_escape_string($connection, trim($_POST['delete_id']));

        if ($delete_id == "") {
            $error_message = "Something went wrong";
        }

        if (!isset($error_message)) {
            $delete_query = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_sts = '0' WHERE tree_id = '$delete_id'");
            if (isset($delete_query)) {
                $error_message = "Success, Student removed";
            }
        }
    }
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4 border-0" style="background-color: #f8f9fa;">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); border: none;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-dark">
                            <i class="fas fa-user-plus me-2"></i>Student Admission Portal
                        </h4>
                        <div>
                            <button class="btn btn-sm single-upload-btn" style="background-color: #e3f2fd; color: #1976d2;">
                                <i class="fas fa-user me-1"></i> Single Entry
                            </button>
                            <a href="<?php echo BASE_URL; ?>pages/bulk?uniq_id=<?php echo $student_uniq_id; ?>&bulk=1"><button class="btn btn-sm bulk-upload-btn ms-2" style="background-color: #e8f5e9; color: #388e3c;">
                                <i class="fas fa-users me-1"></i> Bulk Upload
                            </button></a>
                        </div>
                    </div>
                </div>
                
                <!-- Success/Error Message -->
                <?php if (isset($error_message)): ?>
                <div class="alert alert-<?php echo strpos($error_message, 'Success') !== false ? 'success' : 'danger'; ?> alert-dismissible fade show mx-4 mt-4 mb-0" role="alert" style="border-radius: 12px;">
                    <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <div class="card-body" style="background-color: #ffffff; border-radius: 0 0 12px 12px;">
                    <!-- Single Student Form -->
                    <div id="singleUploadSection">
                        <form class="row g-3" action="" method="post" autocomplete="off">
                            <input type="hidden" name="uniq_id" value="<?php echo htmlspecialchars($uniq_id_generator, ENT_QUOTES, 'UTF-8'); ?>" class="uniq_id">
                            
                            <div class="col-12">
                                <div class="p-3 mb-4" style="background-color: #f3e5f5; border-radius: 10px;">
                                    <h5 class="mb-0 text-purple"><i class="fas fa-user-graduate me-2"></i>Student Information</h5>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary">First Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #e3f2fd;"><i class="fas fa-user text-primary"></i></span>
                                    <input type="text" class="form-control student_first_name" placeholder="Student first name" name="student_fname" value="<?php if(isset($error_message)) { 
                                        echo $student_first_name;
                                    } else { 
                                        echo $student_name;
                                    } ?>" required style="border-left: none;">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary">Middle Name</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #e3f2fd;"><i class="fas fa-user text-primary"></i></span>
                                    <input type="text" class="form-control student_middle_name" placeholder="Student middle name" name="student_mname" value="<?php if(isset($error_message)) { 
                                        echo $student_middle_name;
                                    } else { 
                                        echo $student_mname;
                                    } ?>" style="border-left: none;">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary">Last Name</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #e3f2fd;"><i class="fas fa-user text-primary"></i></span>
                                    <input type="text" class="form-control student_last_name" placeholder="Student last name" name="student_lname" value="<?php if(isset($error_message)) { 
                                        echo $student_last_name;
                                    } else { 
                                        echo $student_lname;
                                    } ?>" style="border-left: none;">
                                </div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <div class="p-3 mb-4" style="background-color: #e8f5e9; border-radius: 10px;">
                                    <h5 class="mb-0 text-green"><i class="fas fa-user-friends me-2"></i>Parent Information</h5>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary">Father's First Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #ffecb3;"><i class="fas fa-male text-amber"></i></span>
                                    <input type="text" class="form-control father_first_name" placeholder="Father's first name" name="father_fname" value="<?php if(isset($error_message)) { 
                                        echo $father_first_name;
                                    } else { 
                                        echo $father_f_name;
                                    } ?>" required style="border-left: none;">
                                </div>

                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary">Father's Middle Name</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #ffecb3;"><i class="fas fa-male text-amber"></i></span>
                                    <input type="text" class="form-control father_middle_name" placeholder="Father's middle name" name="father_mname" value="<?php if(isset($error_message)) { 
                                        echo $father_middle_name;
                                    } else { 
                                        echo $father_m_name;
                                    } ?>" style="border-left: none;">
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary">Father's Last Name</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #ffecb3;"><i class="fas fa-male text-amber"></i></span>
                                    <input type="text" class="form-control father_last_name" placeholder="Father's last name" name="father_lname" value="<?php if(isset($error_message)) { 
                                        echo $father_last_name;
                                    } else { 
                                        echo $father_l_name;
                                    } ?>" style="border-left: none;">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mt-3">
                                <label class="form-label fw-semibold text-secondary">Mother's First Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #ffcdd2;"><i class="fas fa-female text-pink"></i></span>
                                    <input type="text" class="form-control mother_first_name" placeholder="Mother's first name" name="mother_fname" value="<?php if(isset($error_message)) { 
                                        echo $mother_first_name;
                                    } else { 
                                        echo $mother_f_name;
                                    } ?>" required style="border-left: none;">
                                </div>
                            </div>

                            
                            
                            <div class="col-md-4 mt-3">
                                <label class="form-label fw-semibold text-secondary">Mother's Middle Name</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #ffcdd2;"><i class="fas fa-female text-pink"></i></span>
                                    <input type="text" class="form-control mother_middle_name" placeholder="Mother's middle name" name="mother_mname" value="<?php if(isset($error_message)) { 
                                        echo $mother_middle_name;
                                    } else { 
                                        echo $mother_m_name;
                                    } ?>" style="border-left: none;">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mt-3">
                                <label class="form-label fw-semibold text-secondary">Mother's Last Name</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #ffcdd2;"><i class="fas fa-female text-pink"></i></span>
                                    <input type="text" class="form-control mother_last_name" placeholder="Mother's last name" name="mother_lname" value="<?php if(isset($error_message)) { 
                                        echo $mother_middle_name;
                                    } else { 
                                        echo $mother_m_name;
                                    } ?>" style="border-left: none;">
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="form-label fw-semibold text-secondary">Primary contact Number<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #ffcdd2;"><i class="fas fa-phone text-pink"></i></span>
                                    <input type="number" class="form-control mother_last_name" placeholder="Primary Contact Number" name="primary_number" value="<?php if(isset($error_message)) { 
                                        echo $p_number;
                                    } else { 
                                        echo $student_phone_number_father;
                                    } ?>" style="border-left: none;">
                                </div>
                            </div>
                            

                            <div class="col-md-4 mt-3">
                                <label class="form-label fw-semibold text-secondary">Select Section</label>
                                <select class="form-select" aria-label="Default select example" name="section_of_class">
                                  <option value="a" selected>A Sec</option>
                                  <option value="b">B Sec</option>
                                </select>
                            </div>

                            <!-- Admission Number -->
                            <div class="col-md-4 mt-3">
                                <label class="form-label fw-semibold text-secondary">Admission Number</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #ffcdd2;"><i class="fas fa-phone text-pink"></i></span>
                                    <input type="text" class="form-control mother_last_name" placeholder="Admission Number" name="admission_number_student" value="<?php echo $student_admission_number; ?>" style="border-left: none;">
                                </div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm" name="submit">
                                    <i class="fas fa-save me-2"></i>Save & Continue
                                </button>
                                <?php 
                                    if (strlen($_GET['uniq_id']) < 6) { ?>
                                        <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm" name="submit_2">
                                            <i class="fas fa-save me-2"></i>Save & Exit
                                        </button>
                                    <?php } ?>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Bulk Upload Section -->
                    <div id="bulkUploadSection" style="display: none;">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card border-0 shadow-sm" style="background-color: #f5f5f5;">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark mb-4">
                                            <i class="fas fa-file-upload me-2 text-info"></i>Bulk Student Upload
                                        </h5>
                                        <div class="alert alert-info" style="background-color: #e1f5fe; border-color: #b3e5fc;">
                                            <i class="fas fa-info-circle me-2"></i> Upload a CSV file containing multiple student records.

                                            <a href="https://rev-users.blr1.cdn.digitaloceanspaces.com/Revisewell_ERP_mandatory_fields_sheet.csv" class="text-decoration-none fw-bold" download="Add bulk student list">
                                                <i class="fas fa-download me-1"></i>Download template file
                                            </a>
                                        </div>
                                        
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-4">
                                                <label for="formFile" class="form-label fw-semibold text-secondary">Select CSV File</label>
                                                <div class="file-upload-wrapper">
                                                    <input class="form-control" type="file" id="formFile" name="file" accept=".csv" style="background-color: #f8f9fa; border: 2px dashed #bbdefb; padding: 20px; border-radius: 10px;">
                                                </div>
                                            </div>

                                            <button type="submit" name="b_i">ads</button>
                                            
                                            <!-- <button type="submit" class="btn btn-success px-4 py-2 shadow-sm" name="b_i">
                                                <i class="fas fa-upload me-2"></i>Upload File
                                            </button> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <?php 
                            $fetch_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_sts = '2'");
                            if (mysqli_num_rows($fetch_student_details) > 0): ?>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm" style="background-color: #f5f5f5;">
                                    <div class="card-header py-3" style="background: linear-gradient(135deg, #b2dfdb 0%, #e0f2f1 100%);">
                                        <h5 class="mb-0 text-dark">
                                            <i class="fas fa-users me-2 text-teal"></i>Uploaded Students (Preview)
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless">
                                                <thead style="background-color: #e0f7fa;">
                                                    <tr>
                                                        <th class="text-secondary">#</th>
                                                        <th class="text-secondary">Student Name</th>
                                                        <th class="text-secondary">Father's Name</th>
                                                        <th class="text-secondary">Class</th>
                                                        <th class="text-secondary">DOB</th>
                                                        <th class="text-secondary">Gender</th>
                                                        <th class="text-secondary">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $i = 1;
                                                    while($dssa = mysqli_fetch_assoc($fetch_student_details)): ?>
                                                    <tr style="border-bottom: 1px solid #e0e0e0;">
                                                        <td class="text-secondary"><?php echo $i++; ?></td>
                                                        <td><?php echo htmlspecialchars($dssa['rev_student_fname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($dssa['rev_father_fname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-secondary"><?php echo htmlspecialchars($dssa['rev_admission_class'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-secondary"><?php echo htmlspecialchars($dssa['rev_student_dob'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($dssa['rev_gender'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td>
                                                            <form action="" method="post" class="d-inline">
                                                                <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($dssa['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                                                <button class="btn btn-sm btn-outline-danger rounded-circle" name="delete" type="submit" style="width: 32px; height: 32px;">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="mt-4 text-center">
                                            <form action="" method="post">
                                                <button type="submit" class="btn btn-success px-4 py-2 shadow-sm" name="final" style="background: linear-gradient(135deg, #81c784 0%, #a5d6a7 100%); border: none;">
                                                    <i class="fas fa-check-circle me-2"></i>Confirm & Submit All Students
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>

<style>
    body {
        background-color: #fafafa;
    }
    
    .card {
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-radius: 16px 16px 0 0 !important;
    }
    
    .form-control {
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #90caf9;
        box-shadow: 0 0 0 0.25rem rgba(144, 202, 249, 0.25);
    }
    
    .input-group-text {
        border-radius: 10px 0 0 10px;
        border-right: none;
    }
    
    .single-upload-btn.active {
        background: linear-gradient(135deg, #bbdefb 0%, #e3f2fd 100%) !important;
        color: #0d47a1 !important;
        font-weight: 600;
    }
    
    .bulk-upload-btn.active {
        background: linear-gradient(135deg, #c8e6c9 0%, #e8f5e9 100%) !important;
        color: #1b5e20 !important;
        font-weight: 600;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(200, 230, 201, 0.3);
    }
    
    .btn {
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .file-upload-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .file-upload-wrapper:after {
        content: "Drag & drop file here or click to browse";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #90a4ae;
        pointer-events: none;
    }
    
    .text-purple {
        color: #7e57c2;
    }
    
    .text-green {
        color: #66bb6a;
    }
    
    .text-teal {
        color: #26a69a;
    }
    
    .text-amber {
        color: #ffa000;
    }
    
    .text-pink {
        color: #ec407a;
    }
</style>

<script>
$(document).ready(function() {
    // Toggle between single and bulk upload
    $('.single-upload-btn').click(function() {
        $('#singleUploadSection').show();
        $('#bulkUploadSection').hide();
        $('.single-upload-btn').addClass('active');
        $('.bulk-upload-btn').removeClass('active');
        window.location.hash = '&bulk=0';
    });
    
    $('.bulk-upload-btn').click(function() {
        $('#singleUploadSection').hide();
        $('#bulkUploadSection').show();
        $('.bulk-upload-btn').addClass('active');
        $('.single-upload-btn').removeClass('active');
        window.location.hash = '&bulk=1';
    });
    
    // Show appropriate section based on URL hash
    if (window.location.hash.indexOf("bulk=1") > -1) {
        $('.bulk-upload-btn').click();
    } else {
        $('.single-upload-btn').click();
    }
    
    // Form validation
    $('form').submit(function() {
        let valid = true;
        
        // Check required fields
        $(this).find('[required]').each(function() {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid');
                $(this).parent().append('<div class="invalid-feedback">This field is required</div>');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });
        
        // Name length validation
        const nameFields = [
            { selector: '.student_first_name', min: 2, max: 20, field: 'Student first name' },
            { selector: '.father_first_name', min: 2, max: 20, field: 'Father first name' },
            { selector: '.mother_first_name', min: 2, max: 20, field: 'Mother first name' }
        ];
        
        nameFields.forEach(field => {
            const $el = $(field.selector);
            const val = $el.val().trim();
            
            if (val.length < field.min || val.length > field.max) {
                $el.addClass('is-invalid');
                if (!$el.next('.invalid-feedback').length) {
                    $el.after(`<div class="invalid-feedback">${field.field} must be between ${field.min} and ${field.max} characters</div>`);
                }
                valid = false;
            }
        });
        
        return valid;
    });
    
    // File upload styling
    $('#formFile').on('change', function() {
        const fileName = $(this).val().split('\\').pop();
        if (fileName) {
            $(this).css('background-color', '#e8f5e9');
            $(this).parent().find(':after').hide();
        } else {
            $(this).css('background-color', '#f8f9fa');
        }
    });
});
</script>