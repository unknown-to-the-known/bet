<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

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
        $school_id = htmlspecialchars($i['tree_id'], ENT_QUOTES, 'UTF-8');
        $account_privilage = htmlspecialchars($i['user_allowed'], ENT_QUOTES, 'UTF-8');
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
    if (isset($_GET['id'])) {
        if ($_GET['id'] != '') {
            $selected_c = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
        } else {
            $selected_c = 'baby';
        }
    } else {
        $selected_c = 'baby';
    }
?>

<!-- Promote -->

<?php 
$alert_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get values first
    $student_ids = $_POST['student_ids'] ?? [];
    $new_class = trim($_POST['new_class'] ?? '');
    $p_fees_array = $_POST['pending_fees'] ?? [];
    $names_array = $_POST['names'] ?? [];

    $fetch_new_class_amount = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_year = '2025_26' AND master_class = '$new_class' AND master_sts = '1' AND master_cat = 'fee'");

    if (mysqli_num_rows($fetch_new_class_amount) > 0) {
        while($cds_fee = mysqli_fetch_assoc($fetch_new_class_amount)) {
            $new_fees += $cds_fee['master_amount'];
        }
    }


    $fetch_new_class_amount_books = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_year = '2025_26' AND master_class = '$new_class' AND master_sts = '1' AND master_cat = 'book'");

    if (mysqli_num_rows($fetch_new_class_amount_books) > 0) {
        while($cds_book = mysqli_fetch_assoc($fetch_new_class_amount_books)) {
            $new_fees_books = $cds_book['master_amount'];
        }
    } else {
        $new_fees_books = '0';
    }

    

    $fetch_new_class_amount_trans = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_year = '2025_26' AND master_class = '$new_class' AND master_sts = '1' AND master_cat = 'transportation'");

    if (mysqli_num_rows($fetch_new_class_amount_trans) > 0) {
        while($cds_trans = mysqli_fetch_assoc($fetch_new_class_amount_trans)) {
            $new_fees_trans = $cds_trans['master_amount'];
        }
    } else {
        $new_fees_trans = '0';
    }

    

    $divide = $new_fees/2;


    // Validations
    if (empty($student_ids)) {
        $alert_messages[] = ['type' => 'warning', 'msg' => '❌ Please select at least one student to promote.'];
    }

    if (empty($new_class)) {
        $alert_messages[] = ['type' => 'warning', 'msg' => '❌ Please select a class to promote to.'];
    }

    // Proceed only if both are valid
    if (empty($alert_messages)) {
        foreach ($student_ids as $student_id) {
            $student_id = (int) $student_id;
            $p_fees = mysqli_real_escape_string($connection, $p_fees_array[$student_id] ?? '0');
                $student_name = mysqli_real_escape_string($connection, $names_array[$student_id] ?? 'Unknown');
            

            $sql = "SELECT * FROM rev_erp_student_details WHERE tree_id = $student_id";
            $result = mysqli_query($connection, $sql);

            if ($row = mysqli_fetch_assoc($result)) {
                $current_class = $row['rev_admission_class'];
                $pending_fees = $p_fees;
                $student_name = $student_name;

                if ($current_class === $new_class) {
                    $alert_messages[] = ['type' => 'danger', 'msg' => "❌ $student_name (ID: $student_id) is already in class $current_class."];
                    continue;
                }

               $fetch_all_balance = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");
               if (mysqli_num_rows($fetch_all_balance) > 0) {
                   while($k = mysqli_fetch_assoc($fetch_all_balance)) {
                        $pending_fees = floatval($k['rev_old_balance'])  
                         + floatval($k['rev_dress']) 
                         + floatval($k['rev_books']) 
                         + floatval($k['rev_fees']) 
                         + floatval($k['rev_transportation']);
                   }
               }

                $update_sql = "UPDATE rev_erp_student_details SET rev_admission_class = '$new_class', rev_old_balance = $pending_fees, rev_fees = '$new_fees',rev_term1_fee= '$divide', rev_term2_fee = '$divide',rev_dress = '0', rev_books = '$new_fees_books', rev_promoted = '1', rev_admission_fee = '0', rev_academic_year = '2025_26', rev_consession = '0' WHERE tree_id = $student_id";
                if (mysqli_query($connection, $update_sql)) {
                    $alert_messages[] = ['type' => 'success', 'msg' => "✅ $student_name promoted to $new_class. Fees carried forward: ₹$pending_fees"];
                } else {
                    $alert_messages[] = ['type' => 'danger', 'msg' => "❌ Error updating $student_name: " . mysqli_error($connection)];
                }
            } else {
                $alert_messages[] = ['type' => 'danger', 'msg' => "❌ Student with ID $student_id not found."];
            }
        }
    }
}
?>

<?php 
    if (isset($_GET['id'])) {
        if ($_GET['id'] != '') {
            $class_sel = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
        } else {
            $class_sel = 'baby';
        }
    } else {
        $class_sel = 'baby';
    }
?>

<?php 
    $promotion_map = [
    'baby' => 'lkg',
    'lkg' => 'ukg',
    'ukg' => '1',
    '1' => '2',
    '2' => '3',
    '3' => '4',
    '4' => '5',
    '5' => '6',
    '6' => '7',
    '7' => '8',
    '8' => '9',
    '9' => '10',
    '10' => 'Completed'
    ];
    $promote_to = $promotion_map[$class_sel] ?? 'Unknown';
?>



<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<div class="container-fluid px-4 py-4" style="background-color: #f8f9fa;">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0" style="color: #5d647b;">
                        <i class="fas fa-graduation-cap me-2"></i>Student Promotion
                    </h3>
                    <div>
                        <span class="badge rounded-pill px-3 py-2" style="background-color: #e3f2fd; color: #1976d2;" data-bs-toggle="modal" data-bs-target="#exampleModal_year">
                            Academic Year: <?php echo htmlspecialchars($_SESSION['academic_setter']); ?>
                        </span>
                    </div>
                </div>
                <hr style="border-top: 2px solid #dee2e6;">
            </div>
        </div>

        <!-- Grade Navigation -->
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="grade-scroller">
                    <div class="d-flex overflow-auto pb-3">
                        <?php
                        $grade_ids = ['baby', 'lkg', 'ukg', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
                        $grades = ['Baby Class', 'LKG Class', 'UKG Class', 'Grade 1', 'Grade 2', 'Grade 3', 
                                  'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];
                        $colors = ['#FFD1DC', '#FFECB3', '#B5EAD7', '#C7CEEA', '#E2F0CB', '#FFDAC1', 
                                  '#B5EAD7', '#C7CEEA', '#E2F0CB', '#FFDAC1', '#B5EAD7', '#C7CEEA', '#E2F0CB'];

                        foreach ($grades as $index => $grade) {
                            echo '<div class="me-3">';
                            echo '<a href="' . BASE_URL . 'pages/promote?id=' . $grade_ids[$index] . '">';
                            echo '<button class="btn grade-pill px-4 py-2" style="background-color: '.$colors[$index].'; color: #5d647b;">';
                            echo '<i class="fas fa-chalkboard-teacher me-2"></i>'.$grade;
                            echo '</button>';
                            echo '</a>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promotion Panel -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-header border-0" style="background-color: #f0f7ff; border-radius: 12px 12px 0 0 !important;">
                        <h5 class="mb-0" style="color: #5d647b;">
                            <i class="fas fa-exchange-alt me-2"></i>Promote Students
                        </h5>
                    </div>
                    <?php if (!empty($alert_messages)): ?>
                        <div class="mt-3">
                            <?php foreach ($alert_messages as $alert): ?>
                                <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                                    <?php echo $alert['msg']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                    <div class="card-body">
                        <!-- Student List Table -->
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" style="border-radius: 8px; overflow: hidden;">
                                <thead style="background-color: #f0f7ff;">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        <th scope="col" style="color: #6c757d;">Student ID</th>
                                        <th scope="col" style="color: #6c757d;">Name</th>
                                        <th scope="col" style="color: #6c757d;">Current Grade</th>
                                        <th scope="col" style="color: #6c757d">Promote to</th>
                                        <th scope="col" style="color: #6c757d;">Pending Amount</th>
                                        <th scope="col" style="color: #6c757d;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // echo "SELECT * FROM rev_erp_student_details WHERE rev_admission_class = '$selected_c' AND rev_sts = '1'";
                                        $fetch_class_student = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_admission_class = '$selected_c' AND rev_sts = '1' AND rev_academic_year = '$academic_setter'");
                                        if (mysqli_num_rows($fetch_class_student) > 0) {
                                            while($rd = mysqli_fetch_assoc($fetch_class_student)) { ?>
                                                <tr style="background-color: #ffffff;">
                                                    <td>
                                                        <div class="form-check">

                                                            <input class="form-check-input student-checkbox" type="checkbox" name="student_ids[]" value="<?php echo htmlspecialchars($rd['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                                        </div>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($rd['rev_sats'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span><?php echo htmlspecialchars(ucfirst($rd['rev_student_fname']), ENT_QUOTES, 'UTF-8'); ?><br><?php echo htmlspecialchars(ucfirst($rd['rev_father_fname']), ENT_QUOTES, 'UTF-8'); ?>
                                                                <input type="hidden" value="<?php echo $rd['rev_student_fname']; ?>" name="name<?php echo $rd['tree_id']; ?>" >
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-dark">Grade <?php echo $selected_c; ?></td>
                                                    <td class="text-dark">
                                                        Grade <?php echo ucfirst($promote_to); ?>
                                                        <input type="hidden" name="new_class" value="<?php echo $promote_to; ?>">
                                                    </td>

                                                    <?php $sum = floatval($rd['rev_old_balance']) 
                                                                 + floatval($rd['rev_dress']) 
                                                                 + floatval($rd['rev_books']) 
                                                                 + floatval($rd['rev_fees']) 
                                                                 + floatval($rd['rev_transportation']);  ?>
                                                    <td>₹<?php echo $sum; ?><input type="hidden" value="<?php echo $sum; ?>" name="pending_fees<?php echo $rd['tree_id']; ?>" ></td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL; ?>pages/full_details?id=<?php echo htmlspecialchars($rd['tree_id'], ENT_QUOTES); ?>">
                                                            <button type='button' class="btn btn-sm" style="background-color: #e3f2fd; color: #1976d2;">
                                                                <i class="fas fa-eye"></i> View
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            
                            <div>
                                <button class="btn me-2" style="background-color: #ffebee; color: #c62828;">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button class="btn" style="background-color: #e8f5e9; color: #2e7d32;" type="submit" name="promote">
                                    <i class="fas fa-check me-2"></i>Confirm Promotion
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .grade-scroller::-webkit-scrollbar {
        height: 6px;
    }
    .grade-scroller::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .grade-scroller::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    .grade-scroller::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    .grade-pill {
        border-radius: 20px;
        white-space: nowrap;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .grade-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card {
        overflow: hidden;
    }
    .form-select, .form-control {
        border: 1px solid #e0e0e0;
    }
    .form-select:focus, .form-control:focus {
        border-color: #90caf9;
        box-shadow: 0 0 0 0.25rem rgba(144, 202, 249, 0.25);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
    
    // If any student checkbox is unchecked, uncheck the "Select All" checkbox
    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (!this.checked) {
                selectAllCheckbox.checked = false;
            } else {
                // Check if all student checkboxes are checked
                const allChecked = Array.from(studentCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            }
        });
    });
});
</script>