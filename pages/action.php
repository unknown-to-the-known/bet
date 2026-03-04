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

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap">

<style type="text/css">
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    
    .dashboard-container {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        padding: 25px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    
    .welcome-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50px;
        padding: 8px 15px;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
    }
    
    .year-selector {
        background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);
        color: white;
        border-radius: 50px;
        padding: 8px 15px;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(161, 140, 209, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .year-selector:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(161, 140, 209, 0.4);
    }
    
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        margin-bottom: 20px;
        height: 100%;
        position: relative;
        z-index: 1;
    }
    
    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(0,0,0,0.1), 0 10px 10px rgba(0,0,0,0.08);
    }
    
    .card-body {
        padding: 25px;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .icon-container {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 30px;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
    }
    
    .card-title {
        font-family: 'Nunito Sans', sans-serif;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
    }
    
    .card-text {
        color: #718096;
        font-size: 14px;
    }
    
    /* Unique colors for each card */
    .card-1::before { background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); }
    .card-1 .icon-container { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    
    .card-2::before { background: linear-gradient(90deg, #f78ca0 0%, #f9748f 100%); }
    .card-2 .icon-container { background: linear-gradient(135deg, #f78ca0 0%, #f9748f 100%); }
    
    .card-3::before { background: linear-gradient(90deg, #48c6ef 0%, #6f86d6 100%); }
    .card-3 .icon-container { background: linear-gradient(135deg, #48c6ef 0%, #6f86d6 100%); }
    
    .card-4::before { background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%); }
    .card-4 .icon-container { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    
    .card-5::before { background: linear-gradient(90deg, #a18cd1 0%, #fbc2eb 100%); }
    .card-5 .icon-container { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
    
    .card-6::before { background: linear-gradient(90deg, #ff9a9e 0%, #fad0c4 100%); }
    .card-6 .icon-container { background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%); }
    
    .card-7::before { background: linear-gradient(90deg, #ffc3a0 0%, #ffafbd 100%); }
    .card-7 .icon-container { background: linear-gradient(135deg, #ffc3a0 0%, #ffafbd 100%); }
    
    .card-8::before { background: linear-gradient(90deg, #a1c4fd 0%, #c2e9fb 100%); }
    .card-8 .icon-container { background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); }
    
    .card-9::before { background: linear-gradient(90deg, #84fab0 0%, #8fd3f4 100%); }
    .card-9 .icon-container { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); }
</style>

<div class="container dashboard-container zindex-100 desk">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="welcome-badge">
            <i class="fas fa-user-circle me-2"></i> Welcome, <?php echo ucfirst($user_name); ?>
        </div>
        
        <div class="year-selector" data-bs-toggle="modal" data-bs-target="#exampleModal_year">
            <i class="fas fa-calendar-alt me-2"></i> Academic Year: 
            <?php echo htmlspecialchars(str_replace('_', '-', $academic_setter), ENT_QUOTES, 'UTF-8'); ?>
        </div>
    </div>
    <!-- Dashboard Cards -->
    <div class="row">
        <!-- Student Details -->
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/display_student_list" class="card card-1 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="card-title">Student Details</h5>
                    <p class="card-text">Manage all student information and profiles</p>
                </div>
            </a>
        </div>

        <!-- Fee Collection -->
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/fee_collection" class="card card-2 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h5 class="card-title">Fee Collection</h5>
                    <p class="card-text">Process and track student fee payments</p>
                </div>
            </a>
        </div>

        <!-- Reports -->
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/reports" class="card card-3 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h5 class="card-title">Reports</h5>
                    <p class="card-text">Generate detailed reports and analytics</p>
                </div>
            </a>
        </div>

        <!-- Certificate Generator -->
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/cg" class="card card-4 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h5 class="card-title">Certificate Generator</h5>
                    <p class="card-text">Create and print student certificates</p>
                </div>
            </a>
        </div>

        <!-- Student Promotion -->
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/promote" class="card card-5 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h5 class="card-title">Student Promotion</h5>
                    <p class="card-text">Promote students to next academic level</p>
                </div>
            </a>
        </div>

        <!-- Fee Alert -->
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/fee_alert" class="card card-6 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h5 class="card-title">Fee Alert</h5>
                    <p class="card-text">Send reminders for pending fee payments</p>
                </div>
            </a>
        </div>

        <!-- Attendance -->
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/student_attendence" class="card card-7 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h5 class="card-title">Student Attendance</h5>
                    <p class="card-text">Record and manage daily attendance</p>
                </div>
            </a>
        </div>

        <!-- Hall Tickets -->
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/reports" class="card card-8 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h5 class="card-title">Hall Ticket Generator</h5>
                    <p class="card-text">Create examination hall tickets</p>
                </div>
            </a>
        </div>

        <!-- System Settings (Admin Only) -->
        <?php if ($account_privilage == "admin") { ?>
        <div class="col-md-4">
            <a href="<?php echo BASE_URL; ?>pages/setting" class="card card-9 h-100">
                <div class="card-body">
                    <div class="icon-container">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h5 class="card-title">System Settings</h5>
                    <p class="card-text">Configure system preferences and settings</p>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>

<!-- Class Selector Modal -->
<div class="modal fade" id="class_selector" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Select Class</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                    $fetch_class_of_teacher = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE rev_teach_email_id = '$teacher_email_id' AND rev_school_uniq_id = '$school_id' AND rev_teach_sts = '1'");

                    if (mysqli_num_rows($fetch_class_of_teacher) > 0) {
                        while($fdr = mysqli_fetch_assoc($fetch_class_of_teacher)) { ?>
                            <a href="<?php echo BASE_URL; ?>pages/action?param=<?php echo htmlspecialchars($fdr['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <button class="btn btn-sm btn-outline-primary">Grade <?php echo htmlspecialchars($fdr['rev_teacher_class'], ENT_QUOTES, "UTF-8") . ' ' . htmlspecialchars(ucfirst($fdr['rev_teacher_sec']), ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars(ucfirst(str_replace('_', ' ', $fdr['rev_teach_subject'])), ENT_QUOTES, 'UTF-8'); ?></button></a>
                        <?php }
                    }
                ?>
            </div>          
        </div>
    </div>
</div>

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>