<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php $today = date('Y-m-d h:i a'); ?>

<?php 
    if (isset($_SESSION['teach_details'])) {
        $teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');
    } else {
        // header("Location: " . BASE_URL . 'index');
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
    // $uniq_id_generator = md5(date('Y-m-d H:i:s a'));
    if (isset($_GET['uniq_id'])) {
        if ($_GET['uniq_id'] != "") {
            $uniq_id_generator = htmlspecialchars(trim($_GET['uniq_id']), ENT_QUOTES, 'UTF-8');
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
        $student_dob_excel_2 = mysqli_real_escape_string($connection, trim($data[6]));
        $student_social_category_excel = mysqli_real_escape_string($connection, trim($data[7]));
        $student_admission_excel = mysqli_real_escape_string($connection, trim($data[8]));
        
        $student_moi_excel = mysqli_real_escape_string($connection, trim($data[9]));
        $student_address_excel = mysqli_real_escape_string($connection, trim($data[10]));
        $student_father_mobile_excel = mysqli_real_escape_string($connection, trim($data[11]));
        $sum_fees = mysqli_real_escape_string($connection, trim($data[12]));
        $student_books_excel = mysqli_real_escape_string($connection, trim($data[13]));
        $student_trans_excel = mysqli_real_escape_string($connection, trim($data[14]));
        $student_sats_excel = mysqli_real_escape_string($connection, trim($data[15]));
        $student_mother_tongue_excel = mysqli_real_escape_string($connection, trim($data[16]));
        $student_old_balance = mysqli_real_escape_string($connection, trim($data[17]));
        $student_section = mysqli_real_escape_string($connection, trim($data[18]));
        $student_dob_excel = date('Y-m-d', strtotime($student_dob_excel_2));
        $uniq_id = uniqid();

        $sql = "INSERT INTO rev_erp_student_details (rev_student_fname,rev_father_fname,rev_mother_fname,rev_urban_rural,   rev_gender,rev_student_dob,rev_religion,rev_social_category,rev_admission_class,rev_moi,rev_student_address,    rev_father_mobile,rev_fees, rev_books,rev_trans_fixed_amount,rev_transportation,rev_sats,rev_mother_tongue,rev_academic_year,rev_old_balance,rev_section) VALUES ('$student_first_name_excel','$student_father_name_excel','$student_mother_name_excel','$student_urbal_rural_excel','$student_gender_excel','$student_dob_excel','$student_religion_excel','$student_social_category_excel','$student_admission_excel','$student_moi_excel','$student_address_excel','$student_father_mobile_excel','$sum_fees','$student_books_excel','$student_trans_excel','$student_trans_excel','$student_sats_excel','$student_mother_tongue_excel', '$academic_setter','$student_old_balance','$student_section')";

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
                            <a href="<?php echo BASE_URL; ?>pages/add_student?uniq_id=<?php echo $uniq_id_generator; ?>"><button class="btn btn-sm single-upload-btn" style="background-color: #e3f2fd; color: #1976d2;">
                                <i class="fas fa-user me-1"></i> Single Entry
                            </button></a>
                            <a href="<?php echo BASE_URL; ?>pages/bulk"><button class="btn btn-sm bulk-upload-btn ms-2" style="background-color: #e8f5e9; color: #388e3c;">
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
                
                
                    
                    <!-- Bulk Upload Section -->
                    <div id="bulkUploadSection">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card border-0 shadow-sm" style="background-color: #f5f5f5;">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark mb-4">
                                            <i class="fas fa-file-upload me-2 text-info"></i>Bulk Student Upload
                                        </h5>
                                        <div class="alert alert-info" style="background-color: #e1f5fe; border-color: #b3e5fc;">
                                            <i class="fas fa-info-circle me-2"></i> Upload a CSV file containing multiple student records.

                                            <a href="https://rev-users.blr1.cdn.digitaloceanspaces.com/Revisewell_ERP_mandatory_fields_excel_sheet_2025_26.csv" class="text-decoration-none fw-bold" download="Add bulk student list">
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
                                            
                                            <button type="submit" class="btn btn-success px-4 py-2 shadow-sm" name="b_i">
                                                <i class="fas fa-upload me-2"></i>Upload File
                                            </button>
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
                                            <table class="table table-hover table-borderless text-dark">
                                                <thead style="background-color: #e0f7fa;">
                                                    <tr>
                                                        <th class="text-secondary">#</th>
                                                        <th class="text-secondary">Student Name</th>
                                                        <th class="text-secondary">Father's Name</th>
                                                        <th class="text-secondary">Class</th>
                                                        <th class="text-secondary">DOB</th>
                                                        <th class="text-secondary">Gender</th>
                                                        <th class="text-secondary">Mobile Number</th>
                                                        <th class="text-secondary">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $i = 1;
                                                    while($dssa = mysqli_fetch_assoc($fetch_student_details)): ?>
                                                    <tr style="border-bottom: 1px solid #e0e0e0;">
                                                        <td class="text-secondary"><?php echo $i++; ?></td>
                                                        <td><?php echo htmlspecialchars(ucfirst($dssa['rev_student_fname']), ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars(ucfirst($dssa['rev_father_fname']), ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-secondary text-dark"><?php echo htmlspecialchars(ucfirst($dssa['rev_admission_class']), ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td class="text-secondary text-dark"><?php echo htmlspecialchars($dssa['rev_student_dob'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($dssa['rev_gender'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($dssa['rev_father_mobile'], ENT_QUOTES, 'UTF-8'); ?></td>
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
// $(document).ready(function() {
//     // Toggle between single and bulk upload
//     $('.single-upload-btn').click(function() {
//         $('#singleUploadSection').show();
//         $('#bulkUploadSection').hide();
//         $('.single-upload-btn').addClass('active');
//         $('.bulk-upload-btn').removeClass('active');
//         window.location.hash = '&bulk=0';
//     });
    
//     $('.bulk-upload-btn').click(function() {
//         $('#singleUploadSection').hide();
//         $('#bulkUploadSection').show();
//         $('.bulk-upload-btn').addClass('active');
//         $('.single-upload-btn').removeClass('active');
//         window.location.hash = '&bulk=1';
//     });
    
//     // Show appropriate section based on URL hash
//     if (window.location.hash.indexOf("bulk=1") > -1) {
//         $('.bulk-upload-btn').click();
//     } else {
//         $('.single-upload-btn').click();
//     }
    
//     // Form validation
//     $('form').submit(function() {
//         let valid = true;
        
//         // Check required fields
//         $(this).find('[required]').each(function() {
//             if ($(this).val().trim() === '') {
//                 $(this).addClass('is-invalid');
//                 $(this).parent().append('<div class="invalid-feedback">This field is required</div>');
//                 valid = false;
//             } else {
//                 $(this).removeClass('is-invalid');
//                 $(this).next('.invalid-feedback').remove();
//             }
//         });
        
//         // Name length validation
//         const nameFields = [
//             { selector: '.student_first_name', min: 2, max: 20, field: 'Student first name' },
//             { selector: '.father_first_name', min: 2, max: 20, field: 'Father first name' },
//             { selector: '.mother_first_name', min: 2, max: 20, field: 'Mother first name' }
//         ];
        
//         nameFields.forEach(field => {
//             const $el = $(field.selector);
//             const val = $el.val().trim();
            
//             if (val.length < field.min || val.length > field.max) {
//                 $el.addClass('is-invalid');
//                 if (!$el.next('.invalid-feedback').length) {
//                     $el.after(`<div class="invalid-feedback">${field.field} must be between ${field.min} and ${field.max} characters</div>`);
//                 }
//                 valid = false;
//             }
//         });
        
//         return valid;
//     });
    
//     // File upload styling
//     $('#formFile').on('change', function() {
//         const fileName = $(this).val().split('\\').pop();
//         if (fileName) {
//             $(this).css('background-color', '#e8f5e9');
//             $(this).parent().find(':after').hide();
//         } else {
//             $(this).css('background-color', '#f8f9fa');
//         }
//     });
// });
</script>