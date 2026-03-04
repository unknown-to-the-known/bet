<?php 
require '../includes/config.php';
require ROOT_PATH . 'includes/db.php';

date_default_timezone_set('Asia/Kolkata');
$attendance_date = date('Y-m-d');
// Ensure user is logged in
if (!isset($_SESSION['teach_details'])) {
    header("Location: " . BASE_URL . 'index');
    exit();
}

$teacher_email_id = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8');

// Fetch teacher details
$query_teacher = "SELECT * FROM erp_user_settings WHERE user_email_id = '$teacher_email_id' AND user_sts = '1'";
$result_teacher = mysqli_query($connection, $query_teacher);
if ($result_teacher && mysqli_num_rows($result_teacher) > 0) {
    $row_teacher = mysqli_fetch_assoc($result_teacher);
    $user_name = htmlspecialchars($row_teacher['user_name'], ENT_QUOTES, 'UTF-8');
    $school_id = htmlspecialchars($row_teacher['tree_id'], ENT_QUOTES, 'UTF-8');
    $account_privilage = htmlspecialchars($row_teacher['user_allowed'], ENT_QUOTES, 'UTF-8');
}

// Set default academic year

    if (isset($_SESSION['academic_setter'])) {
        $academic_setter = $_SESSION['academic_setter'];
    } else {
        $academic_setter = '2025_26';
    }

    $academic_setter = str_replace('-', '_', $academic_setter);


// Determine selected class
$u_class = isset($_GET['id']) && $_GET['id'] !== "" ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8') : '1';

$message = ""; // Variable to store success/error messages

// Handle attendance submission
if (isset($_POST['submit_attendence'])) {
    $present_students = $_POST['students'] ?? [];
    $student_phone = $_POST['student_phone'];
    $student_name = $_POST['student_name'];

    // Check if attendance already exists for this class and date
    $query_check_attendance = "SELECT COUNT(*) as count FROM attendance WHERE class_id = '$u_class' AND st_date = '$attendance_date'";
    $result_check_attendance = mysqli_query($connection, $query_check_attendance);
    $row_check = mysqli_fetch_assoc($result_check_attendance);

    if ($row_check['count'] > 0) {
        // Attendance already exists for this class and date
        $message = "<div class='alert alert-warning alert-dismissible fade show mt-3' role='alert'>
            <i class='bi bi-exclamation-triangle me-2'></i>Attendance has already been recorded for today!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else {
        // Fetch all students in the class
        $query_students = "SELECT tree_id FROM rev_erp_student_details WHERE rev_admission_class = '$u_class' AND rev_sts = '1'";
        $result_students = mysqli_query($connection, $query_students);

        if ($result_students) {
            $all_students = [];
            while ($row = mysqli_fetch_assoc($result_students)) {
                $all_students[] = $row['tree_id'];
            }

            $absent_students = array_diff($all_students, $present_students);

            foreach ($all_students as $student_id) {
                $status = in_array($student_id, $present_students) ? 'present' : 'absent';

                // Store attendance in DB
                $query_attendance = "INSERT INTO attendance (student_id, class_id, st_date, status, student_name) 
                     VALUES ('$student_id', '$u_class', '$attendance_date', '$status', '" . mysqli_real_escape_string($connection, $student_name[$student_id]) . "')";
                mysqli_query($connection, $query_attendance);

                // Send WhatsApp message for absent students
                if ($status === 'absent') {
                    // sendWhatsAppMessage($student_phone[$student_id], $student_name[$student_id]);
                }
            }

            $message = "<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>
                <i class='bi bi-check-circle me-2'></i>Attendance saved successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        } else {
            $message = "<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>
                <i class='bi bi-x-circle me-2'></i>Error fetching students: " . mysqli_error($connection) . "
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    }
}

// Edit attendence
if (isset($_POST['present_btn'])) {
    $present_id = mysqli_escape_string($connection, trim($_POST['present_id']));
    if ($present_id == "") {
        $error_message = "Something went wrong, please try again";
    }

    if (!isset($error_message)) {
        $update = mysqli_query($connection, "UPDATE attendance SET status = 'present' WHERE student_id = '$present_id' AND status = 'absent'");
    }
}

if (isset($_POST['absent_btn'])) {
    $absent_id = mysqli_escape_string($connection, trim($_POST['absent_id']));
    if ($absent_id == "") {
        $error_message = "Something went wrong, please try again";
    }

    if (!isset($error_message)) {
        $update_absent = mysqli_query($connection, "UPDATE attendance SET status = 'absent' WHERE student_id = '$absent_id' AND status = 'present'");
    }
}

require ROOT_PATH . 'includes/header_after_login.php'; 

// Fetch attendance stats (using your original queries)

$fetch_present_students = mysqli_query($connection, "SELECT * FROM attendance WHERE class_id = '$u_class' AND st_date = '$attendance_date' AND status = 'present'");
$present = mysqli_num_rows($fetch_present_students);

$fetch_absent_students = mysqli_query($connection, "SELECT * FROM attendance WHERE class_id = '$u_class' AND st_date = '$attendance_date' AND status = 'absent'");
$absent = mysqli_num_rows($fetch_absent_students);

$total_working_days = mysqli_query($connection, "SELECT DISTINCT st_date FROM attendance WHERE class_id = '$u_class'");
$total_work = mysqli_num_rows($total_working_days);
?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
    .attendance-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .stats-badge {
        font-size: 1rem;
        padding: 10px 15px;
    }
    .student-row:hover {
        background-color: #f8f9fa;
    }
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
    }

    .sheen-effect {
        position: absolute;
        top: 0;
        left: -100%;
        width: 200%;
        height: 100%;
       /* background: linear-gradient(
            to right,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.3) 50%,
            rgba(255, 255, 255, 0) 100%
        );*/
        transform: rotate(30deg);
        transition: left 0.8s;
    }
    
    .position-relative:hover .sheen-effect {
        left: 100%;
    }
    
    .z-index-1 {
        z-index: 1;
    }
    
    .overflow-hidden {
        overflow: hidden;
    }

/*  Search  */

.search-container {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .search-input {
        background-color: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 50px;
        padding: 12px 25px;
        font-size: 1.1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        background-color: #fff;
        border-color: #4dabf7;
        box-shadow: 0 5px 15px rgba(77, 171, 247, 0.2);
        outline: none;
    }
    
    .search-input::placeholder {
        color: #adb5bd;
        opacity: 1;
    }
    
    .search-results-list {
        max-height: 400px;
        overflow-y: auto;
        margin-top: 8px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        display: none;
    }
    
    .search-results-list .list-group-item {
        padding: 12px 20px;
        border-left: none;
        border-right: none;
        transition: background-color 0.2s;
    }
    
    .search-results-list .list-group-item:first-child {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    
    .search-results-list .list-group-item:last-child {
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    
    .search-results-list .list-group-item:hover {
        background-color: #f1f3f5;
        cursor: pointer;
    }
    
    .search-results-list .list-group-item.active {
        background-color: #4dabf7;
        border-color: #4dabf7;
    }
    
    /* Custom scrollbar */
    .search-results-list::-webkit-scrollbar {
        width: 8px;
    }
    
    .search-results-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 0 12px 12px 0;
    }
    
    .search-results-list::-webkit-scrollbar-thumb {
        background: #ced4da;
        border-radius: 4px;
    }
    
    .search-results-list::-webkit-scrollbar-thumb:hover {
        background: #adb5bd;
    }
</style>
<div class="container mt-4">
        <h2 class="text-primary">
            <i class="bi bi-clipboard2-pulse"></i> Attendance Management
        </h2>
    <div class="d-flex justify-content-between align-items-center mb-4">
        
        <div class="d-flex">
            <form action="download_excel.php" method="post">
                <input type="hidden" name="class_id" value="<?php echo $u_class; ?>">
                <button type="submit" name="export_csv" class="btn btn-success me-2 btn-sm">
                    <i class="bi bi-download"></i> Export
                </button>
            </form>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="bi bi-people-fill"></i> Change Class
            </button>
        </div>
    </div>
    
    <!-- Stats Summary -->
    <div class="row mb-4">
    <!-- Present Card -->
    <div class="col-md-3 mb-3">
        <div class="p-3 text-white rounded d-flex justify-content-between align-items-center position-relative overflow-hidden" 
             style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="position-relative z-index-1">
                <h5 class="mb-0" style='font-family: "Prompt", sans-serif; font-weight: 500; font-style: normal; color:#fff;'>Today Present</h5>
            </div>
            <h5 class="mb-0" style='font-family: "Prompt", sans-serif; font-weight: 500; font-style: normal; color:#fff;'><?php echo $present; ?></h5>
        </div>
    </div>
    
    <!-- Absent Card -->
    <div class="col-md-3 mb-3">
        <div class="p-3 text-white rounded d-flex justify-content-between align-items-center position-relative overflow-hidden"
             style="background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);">
            <div class="position-relative z-index-1">
                <h5 class="mb-0" style='font-family: "Prompt", sans-serif; font-weight: 500; font-style: normal; color:#fff;'>Today Absent</h5>
            </div>
            <h5 class="mb-0" style='font-family: "Prompt", sans-serif; font-weight: 500; font-style: normal; color:#fff;'><?php echo $absent; ?></h5>
        </div>
    </div>
    
    <!-- Working Days Card -->
    <div class="col-md-3 mb-3">
        <div class="p-3 text-white rounded d-flex justify-content-between align-items-center position-relative overflow-hidden"
             style="background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);">
            <div class="position-relative z-index-1">
                <h5 class="mb-0" style='font-family: "Prompt", sans-serif; font-weight: 500; font-style: normal; color:#fff;'>Working days</h5>
            </div>
            <h5 class="mb-0" style='font-family: "Prompt", sans-serif; font-weight: 500; font-style: normal; color:#fff;'><?php echo $total_work; ?></h5>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="position-relative search-container">
            <input class="form-control form-control-lg search-input search" type="text" placeholder="🔍 Search students..." autocomplete="off">
            <ul id="search-results" class="search-results-list list-group position-absolute w-100 z-index-1"></ul>
        </div>
    </div>
</div>
    <?php echo $message; ?>
    <div class="card shadow attendance-card">
        <div class="card-header bg-white">
            <h4 class="mb-0">
                <i class="bi bi-list-check"></i> Grade <?php echo $u_class; ?> Attendance

                <?php 
                    $query_check_attendance = "SELECT COUNT(*) as count FROM attendance WHERE class_id = '$u_class' AND st_date = '$attendance_date'";
                    $result_check_attendance = mysqli_query($connection, $query_check_attendance);
                    $row_check = mysqli_fetch_assoc($result_check_attendance);

                    if ($row_check['count'] > 0) { ?>
                        <button class="btn btn-warning float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrops">Edit attendance</button>
                        <!-- Attendace modal -->
                    <?php }
                ?>

                <small class="text-muted float-end"><?php echo date('F j, Y'); ?></small>
            </h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="5%">Present</th>
                                <th width="35%">Student Name</th>
                                <th width="10%">Class</th>
                                <th width="30%">Attendance Summary</th>
                                <th width="15%">Download Report</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query_selected_class = "SELECT * FROM rev_erp_student_details WHERE rev_admission_class = '$u_class' AND rev_sts = '1' AND rev_academic_year = '$academic_setter'";
                            $result_selected_class = mysqli_query($connection, $query_selected_class);
                            
                            if ($result_selected_class && mysqli_num_rows($result_selected_class) > 0) {
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result_selected_class)) { 
                                    $st_id = $row['tree_id'];
                                    ?>
                                   <tr class="student-row" id="student-<?php echo $row['tree_id']; ?>">
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td>
                                            <?php 
                                                $query_check_attendance = "SELECT COUNT(*) as count FROM attendance WHERE class_id = '$u_class' AND st_date = '$attendance_date'";
                                                $result_check_attendance = mysqli_query($connection, $query_check_attendance);
                                                $row_check = mysqli_fetch_assoc($result_check_attendance);

                                                if ($row_check['count'] > 0) {
                                                    $present_checker = mysqli_query($connection, "SELECT * FROM attendance WHERE student_id = '$st_id' AND class_id = '$u_class' AND st_date = '$attendance_date' AND status = 'present'");
                                                    if (mysqli_num_rows($present_checker) > 0) { ?>
                                                            <input class="form-check-input" type="checkbox"  value="<?php echo $row['tree_id']; ?>" checked disabled>
                                                        <?php } else { ?>
                                                            <input class="form-check-input" type="checkbox"  value="<?php echo $row['tree_id']; ?>" disabled>
                                                        <?php } 
                                                } else { ?>
                                                    <input class="form-check-input" type="checkbox" name="students[]" value="<?php echo $row['tree_id']; ?>" checked>
                                                <?php } ?>
                                            
                                            <input type="hidden" name="student_phone[<?php echo $row['tree_id']; ?>]" value="<?php echo $row['rev_father_mobile']; ?>">
                                            <input type="hidden" name="student_name[<?php echo $row['tree_id']; ?>]" value="<?php echo $row['rev_student_fname']; ?>">
                                        </td>
                                        <td><?php echo $row['rev_student_fname']; ?></td>
                                        <td><?php echo $row['rev_admission_class']; ?></td>
                                        <td>
                                            <?php 
                                                $fetch_indi_present_students = mysqli_query($connection, "SELECT DISTINCT st_date FROM attendance WHERE class_id = '$u_class' AND status = 'present' AND student_id = '$st_id'");
                                                $total_present = mysqli_num_rows($fetch_indi_present_students);  
                                            ?>
                                            <span class="badge bg-success"><?php echo $total_present; ?> Present</span>
                                            <span class="badge bg-light text-dark"><?php echo $total_work; ?> Days</span>
                                        </td>
                                        <td><a href="<?php echo BASE_URL; ?>pages/d_l_r?id=<?php echo $st_id; ?>">Download report</a></td>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-4 text-muted'><i class='bi bi-emoji-frown me-2'></i>No students found</td></tr>";
                            } ?>
                        </tbody>
                    </table>
                </div>
                
                <?php 
                    $query_check_attendance = "SELECT COUNT(*) as count FROM attendance WHERE class_id = '$u_class' AND st_date = '$attendance_date'";
                    $result_check_attendance = mysqli_query($connection, $query_check_attendance);
                    $row_check = mysqli_fetch_assoc($result_check_attendance);

                    if ($row_check['count'] > 0) {
                        echo "<div class='alert alert-info mt-3 text-center'>
                            <i class='bi bi-info-circle me-2'></i>Today's attendance already recorded
                        </div>";
                    } else { ?>
                        <button type="submit" class="btn btn-primary w-100 mt-3 py-2" name="submit_attendence">
                            <i class="bi bi-save me-2"></i> Submit Attendance
                        </button>
                    <?php } ?>
            </form>
        </div>
    </div>
</div>

<!-- Class Selection Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="bi bi-people-fill me-2"></i> Select Class</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="d-flex flex-wrap justify-content-center">
            <a href="<?php echo BASE_URL; ?>pages/student_attendence?id=baby" class="btn btn-outline-primary m-2"><i class="bi bi-emoji-laughing"></i> Baby</a>
            <a href="<?php echo BASE_URL; ?>pages/student_attendence?id=lkg" class="btn btn-outline-primary m-2"><i class="bi bi-emoji-smile"></i> LKG</a>
            <a href="<?php echo BASE_URL; ?>pages/student_attendence?id=ukg" class="btn btn-outline-primary m-2"><i class="bi bi-emoji-neutral"></i> UKG</a>
            <?php for ($grade = 1; $grade <= 10; $grade++): ?>
                <a href="<?php echo BASE_URL; ?>pages/student_attendence?id=<?php echo $grade; ?>" class="btn btn-outline-primary m-2"><i class="bi bi-<?php echo ($grade <= 5) ? 'book' : 'journal-bookmark'; ?>"></i> Grade <?php echo $grade; ?></a>
            <?php endfor; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Download -->
<?php 
$total_working_query = mysqli_query($connection, "SELECT DISTINCT st_date FROM attendance WHERE class_id = '$u_class'");
$tw = mysqli_num_rows($total_working_query); // Total working days

$query = "SELECT student_id, student_name, 
                 COUNT(CASE WHEN status = 'present' THEN 1 END) AS present_days, 
                 MAX(st_date) AS last_date 
          FROM attendance 
          WHERE class_id = '$u_class' 
          GROUP BY student_id, student_name 
          ORDER BY last_date DESC";

$fetch_attendance = mysqli_query($connection, $query); ?>

<!-- Attendance Modal -->

<div class="modal fade" id="staticBackdrops" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Attendance</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-dark text-center" style="font-size:18px;">
            Edit Attendence for the date <b><?php echo date('d-M-Y', strtotime($attendance_date)); ?></b>
            <table class="table text-dark">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $present_checker = mysqli_query($connection, "SELECT * FROM attendance WHERE class_id = '$u_class' AND st_date = '$attendance_date'");
                    if (mysqli_num_rows($present_checker) > 0) { 
                        $ik = 1;
                        while($cser = mysqli_fetch_assoc($present_checker)) { ?>
                            <tr>
                              <th scope="row"><?php echo $ik++; ?></th>
                              <td><?php echo htmlspecialchars(ucfirst($cser['student_name']), ENT_QUOTES, 'UTF-8'); ?></td>
                              <td><?php echo htmlspecialchars(ucfirst($cser['status']), ENT_QUOTES, 'UTF-8'); ?></td>
                              <td>
                                <?php
                                    $student_idss = $cser['student_id']; 
                                    $sts_kju = $cser['status'];
                                    if ($sts_kju == "present") { ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="absent_id" value="<?php echo $student_idss; ?>">
                                            <button class="btn btn-danger btn-sm" type="submit" name="absent_btn">Absent</button>
                                        </form>
                                    <?php } else { ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="present_id" value="<?php echo $student_idss; ?>">
                                            <button class="btn btn-success btn-sm" type="submit" name="present_btn">Present</button>
                                        </form>
                                    <?php } ?>
                              </td>
                            </tr>
                        <?php }
                    ?>
            <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>

<script type="text/javascript">
    $(document).ready(function () {
    $('.search').keyup(function () {
        var keyword = $(this).val().trim();

        if (keyword.length > 0) {
            $.post('student_search.php', { keyword: keyword, u_class: <?php echo $u_class; ?> }, function (response) {
                let results = JSON.parse(response);
                let output = results.length
                    ? results.map(item => `<li class="list-group-item search-item fw-bold" style="background:#fff; color:#000;" data-id="${item.id}">${item.name}</li>`).join('')
                    : '<li class="list-group-item text-muted">No results found</li>';

                $('#search-results').html(output).show();
            });
        } else {
            $('#search-results').hide();
        }
    });

    // Handle click on search result
    $(document).on('click', '.search-item', function () {
        let studentId = $(this).data('id');
        let studentName = $(this).text();

        $('.search').val(studentName);
        $('#search-results').hide();

        // Scroll to and highlight the student in the table
        $('html, body').animate({
            scrollTop: $('#student-' + studentId).offset().top - 100
        }, 500);

        // Highlight the row
        $('.student-row').removeClass('table-warning');
        $('#student-' + studentId).addClass('table-warning');
    });

    // Hide results when clicking outside
    $(document).click(function (e) {
        if (!$(e.target).closest('.search, #search-results').length) {
            $('#search-results').hide();
        }
    });

    // Example of how to show/hide results (you'll need to implement your actual search logic)
    document.querySelector('.search-input').addEventListener('focus', function() {
        document.getElementById('search-results').style.display = 'block';
    });
    
    document.querySelector('.search-input').addEventListener('blur', function() {
        setTimeout(() => {
            document.getElementById('search-results').style.display = 'none';
        }, 200);
    });
});

</script>