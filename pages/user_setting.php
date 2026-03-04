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
            $school_id = htmlspecialchars($i['user_school_id'], ENT_QUOTES, 'UTF-8');
        }  
    }
?>
<?php 
    if (!isset($_SESSION['academic_setter'])) {
        $_SESSION['academic_setter'] = '2024_25';
    } else {
        $academic_setter = htmlspecialchars($_SESSION['academic_setter'], ENT_QUOTES, 'UTF-8');
    }
?>
<?php 
    if (isset($_GET['c'])) {
        $class = htmlspecialchars($_GET['c'], ENT_QUOTES, 'UTF-8');
    } else {
        $class = '1';
    }
?>

<?php 
    if (isset($_POST['submit'])) {
        
        $user_name = mysqli_escape_string($connection, trim($_POST['u_name']));
        $user_email = mysqli_escape_string($connection, trim($_POST['u_email']));
        $user_pass = mysqli_escape_string($connection, trim($_POST['u_pass']));
        $user_role = mysqli_escape_string($connection, trim($_POST['role']));

        if ($user_name == "" || $user_email == "" || $user_pass == "" || $user_role == "") {
            $error_message = "Please fill all fields";
        }

        if (!isset($error_message)) {
            $check_if_id_already_present = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_email_id = '$user_email' AND user_sts = '1'");
            if (mysqli_num_rows($check_if_id_already_present) > 0) {
                $error_message = "User id already present";
            }
            if (!isset($error_message)) {
                $user_pass_hash = password_hash($user_pass, PASSWORD_DEFAULT);
                $insert = mysqli_query($connection, "INSERT INTO erp_user_settings(user_name,user_email_id,user_password,user_allowed,user_sts,user_school_id) VALUES ('$user_name', '$user_email', '$user_pass_hash', '$user_role', '1', '22')");

                if (isset($insert)) {
                    $error_message = "Success, New User Added";
                }
            }
        }
    }
?>

<!-- Delete -->

<?php 
    if (isset($_POST['del'])) {
        $delete_id = mysqli_escape_string($connection, trim($_POST['del_id']));

        if ($delete_id == "") {
            $error_message = "Something went wrong";
        }

        if (!isset($error_message)) {
            $delete_user = mysqli_query($connection, "UPDATE erp_user_settings SET user_sts = '0' WHERE tree_id = '$delete_id' AND user_sts = '1'");

            if (isset($delete_user)) {
                $error_message = "Success user deleted";
            }
        }

    }
    


?>
<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap">
<style type="text/css">
    body {
        background-color: #f8f9fa;
        font-family: 'Nunito Sans', sans-serif;
    }
    /*.card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: scale(1.05);
    }*/
    .form-control {
        border-radius: 10px;
    }
    .btn-success {
        background-color: #28a745;
        border-radius: 10px;
    }
    .btn-danger {
        background-color: #dc3545;
        border-radius: 10px;
    }
    .alert {
        border-radius: 10px;
    }
</style>

<div class="container zindex-100 desk" style="margin-top: 20px;">
    <div class="d-flex justify-content-between align-items-center">
        <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition student_trim_name">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
        <div class="text-dark" style="text-decoration: underline; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal_year">
            <i class="fas fa-graduation-cap"></i> Year <?php echo htmlspecialchars(str_replace('_', '-', $_SESSION['academic_setter']), ENT_QUOTES, 'UTF-8'); ?>
        </div>
    </div>
</div>

<section class="mt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4 p-4">
                    <?php if (isset($error_message)) { ?>
                        <div class="alert alert-info mt-2" role="alert">
                            <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                        </div>            
                    <?php } ?>
                    <h3 class="text-center mb-4" style="text-decoration:underline;">Add User</h3>
                    <form action="" method="post" class="text-left text-dark">
                        <div class="mb-3">
                            <label class="form-label">User Name</label>
                            <input class="form-control form-control-lg" type="text" placeholder="User Name" name="u_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Email Id</label>
                            <input class="form-control form-control-lg" type="email" placeholder="User email Id" name="u_email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Password</label>
                            <input class="form-control form-control-lg" type="password" placeholder="User password" name="u_pass">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Role</label>
                            <select class="form-select" name="role">
                                <option selected>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="accountant">Accountant</option>
                            </select>
                        </div>
                        <button class="btn btn-success w-100" type="submit" name="submit">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php 
                    $fetch_all_user_details = mysqli_query($connection, "SELECT * FROM erp_user_settings WHERE user_sts = '1'");
                    if (mysqli_num_rows($fetch_all_user_details) > 0) { ?>
                        <h3 class="text-center mb-4">List Of Users</h3>
                        <div class="row">
                            <?php while($fd = mysqli_fetch_assoc($fetch_all_user_details)) { ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-lg border-0 rounded-4">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold text-primary"><?php echo htmlspecialchars(ucfirst($fd['user_name']), ENT_QUOTES, 'UTF-8'); ?></h5>
                                            <p class="card-text text-dark">
                                                User created as <b><?php echo htmlspecialchars(ucfirst($fd['user_allowed']), ENT_QUOTES, 'UTF-8'); ?></b>
                                            </p>
                                            <?php 
                                                if (mysqli_num_rows($fetch_all_user_details) > 1 ) { ?>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="del_id" value="<?php echo htmlspecialchars($fd['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                                        <button class="btn btn-danger" type="submit" name="del">Delete</button>
                                                    </form>
                                                <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>