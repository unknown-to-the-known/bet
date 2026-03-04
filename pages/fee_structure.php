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
if (!isset($_SESSION['academic_setter'])) {
    $_SESSION['academic_setter'] = '2025_26';
} else {
    $academic_setter = htmlspecialchars($_SESSION['academic_setter'], ENT_QUOTES, 'UTF-8');
}
?>
<?php 
if (isset($_GET['c'])) {
    if ($_GET['c'] != "") {
        $class = htmlspecialchars($_GET['c'], ENT_QUOTES, 'UTF-8');
    } else {
        $class = '1';
    }
} else {
    $class = '1';
}
?>
<?php 
if (isset($_POST['del'])) {
    $delete_id = mysqli_escape_string($connection, trim($_POST['del_id']));

    if ($delete_id == "") {
        $error_message = "Please try again";
    }

    if (!isset($error_message)) {
        $delete_id = mysqli_query($connection, "UPDATE erp_master_details SET master_sts = '0' WHERE tree_id = '$delete_id'");

        if (isset($delete_id)) {
            $error_message = "Success, Data deleted";
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
        color: #333;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header h6 {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 16px;
        margin: 0;
    }
    .header .year-selector {
        background: #fff;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-section {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .form-section h3 {
        text-align: center;
        margin-bottom: 20px;
        color: #2575fc;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }
    .form-control, .form-select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2575fc;
        outline: none;
    }
    .btn-primary-soft {
        background: #2575fc;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    .btn-primary-soft:hover {
        background: #1a5bbf;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .table th, .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .table th {
        background: #2575fc;
        color: #fff;
    }
    .table tr:hover {
        background: #f1f1f1;
    }
    .btn-danger {
        background: #dc3545;
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    .btn-danger:hover {
        background: #c82333;
    }
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
        }
        .header .year-selector {
            margin-top: 10px;
        }
        .form-section {
            padding: 15px;
        }
        .form-group label {
            font-size: 14px;
        }
        .form-control, .form-select {
            font-size: 14px;
        }
        .btn-primary-soft {
            font-size: 14px;
        }
    }
</style>
<div class="container">
    <div class="header">
        <h6>🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
        <div class="year-selector" data-bs-toggle="modal" data-bs-target="#exampleModal_year">
            <i class="fas fa-graduation-cap"></i> Year <?php echo htmlspecialchars(str_replace('_', '-', $_SESSION['academic_setter']), ENT_QUOTES, 'UTF-8'); ?>
        </div>
    </div>
    <!-- Form Section -->
    <section class="form-section">
        <h3>Setup Fee Structure</h3>
        <div class="row">
            <div class="col-md-12">
                <p data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="font-weight:bold; color:#2575fc; font-size:18px; text-decoration:underline; cursor:pointer;">
                    Grade <?php echo $class; ?> <i class="fas fa-chevron-down"></i>
                </p>
                <div class="error_message alert alert-danger text-center fw-bold" role="alert" style="font-size:14px; margin-bottom:10px;"></div>
            </div>
            <div class="col-md-4 form-group">
                <label>Name</label>
                <input class="form-control name" type="text" placeholder="Enter Name">
            </div>
            <div class="col-md-4 form-group">
                <label>Amount</label>
                <input class="form-control amount" type="number" placeholder="Enter Amount">
            </div>
            <div class="col-md-4 form-group">
                <label>Category</label>
                <select class="form-select category" name="category">
                    <option selected>Select Category</option>
                    <option value="fee">SDF</option>
                    <option value="fee">Tution Fee</option>
                    <option value="book">Books</option>
                    <option value="transportation">Transportation</option>
                </select>
            </div>
            <div class="col-md-12 text-center">
                <button class="btn btn-primary-soft submit" type="button">Add</button>
            </div>
        </div>
    </section>
    <!-- Table Section -->
    <div class="after_refresh">
        <?php 
        if (isset($_GET['c'])) {
            if ($_GET['c'] != "") {
                $user_class = htmlspecialchars($_GET['c'], ENT_QUOTES, 'UTF-8');
            } else {
                $user_class = '1'; 
            }
        } else {
            $user_class = '1';
        }
        $fetch_master_data = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_class = '$user_class' AND master_sts = '1' AND master_year = '$academic_setter' ORDER BY tree_id DESC");

        if (mysqli_num_rows($fetch_master_data) > 0) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    while($ds = mysqli_fetch_assoc($fetch_master_data)) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars(ucwords($ds['master_name']), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><i class="fas fa-rupee-sign"></i><?php echo htmlspecialchars(ucwords($ds['master_amount']), ENT_QUOTES, 'UTF-8'); ?>/-</td>
                            <td><?php echo htmlspecialchars(ucwords($ds['master_class']), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="del_id" value="<?php echo htmlspecialchars($ds['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button class="btn btn-danger" type="submit" name="del"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>


<!-- Class changer -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Select Class</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=baby">
            <button class="btn btn-info-soft btn-sm">Baby class</button>
        </a>
        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=lkg">
            <button class="btn btn-info-soft btn-sm">LKG</button>
        </a>

        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=ukg">
            <button class="btn btn-info-soft btn-sm">UKG</button>
        </a>

        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=1">
            <button class="btn btn-info-soft btn-sm">Grade 1</button>
        </a>
        
        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=2">
            <button class="btn btn-info-soft btn-sm">Grade 2</button>
        </a>
        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=3">
            <button class="btn btn-info-soft btn-sm">Grade 3</button>
        </a>
        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=4">
            <button class="btn btn-info-soft btn-sm">Grade 4</button>
        </a>
        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=5">
            <button class="btn btn-info-soft btn-sm">Grade 5</button>
        </a>

        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=6">
            <button class="btn btn-info-soft btn-sm">Grade 6</button>
        </a>

        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=7">
            <button class="btn btn-info-soft btn-sm">Grade 7</button>
        </a>

        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=8">
            <button class="btn btn-info-soft btn-sm">Grade 8</button>
        </a>

        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=9">
            <button class="btn btn-info-soft btn-sm">Grade 9</button>
        </a>

        <a href="<?php echo BASE_URL; ?>pages/fee_structure?c=10">
            <button class="btn btn-info-soft btn-sm">Grade 10</button>
        </a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Class changer ended -->

<!-- Modals and Scripts -->
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<script type="text/javascript">
    $('.error_message').hide();
    $('.submit').click(function() {
        var am = $('.amount').val();
        var na = $('.name').val();
        var ca = $('.category').val();

        if (na.length == '0' || am.length == '0' || ca.length == '0') {
            $('.error_message').show().text("Please fill all the fields");
        } else {
            $.post("master_data.php?<?php echo uniqid(); ?>", { name: na, time: am, fe_ca: ca, st_class: '<?php echo $class; ?>'}).done(function(text) {
                $('.error_message').show().text(text);
                $('.amount').val(''); 
                $('.name').val('');

                if (text.trim() === 'Success data entered') {
                    $.get("master_data_loader.php?<?php echo uniqid(); ?>&c=<?php echo $class; ?>", function(data) {
                        $(".result").html(data);
                        $('.after_refresh').hide();
                    });
                }    
            });
        }
    });
</script>