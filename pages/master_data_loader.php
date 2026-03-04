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
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_user_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['tree_id'], ENT_QUOTES, 'UTF-8');
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

<table class="table table-bordered text-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Amount</th>
      <th scope="col">Class</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

<?php 
    if (isset($_GET['c'])) {
        if ($_GET['c'] != "") {
            $user_class = htmlspecialchars($_GET['c'], ENT_QUOTES, 'UTF-8');
        } else {
            $error_message = "s";
        }
    } else {
        $error_message = 'ss';
    }

    $fetch_master_data = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_class = '$user_class' AND master_sts = '1' ORDER BY tree_id DESC");

    if (mysqli_num_rows($fetch_master_data) > 0) {
        $i = 1;
        while($ds = mysqli_fetch_assoc($fetch_master_data)) { ?>
                <tr>
                  <th scope="row"><?php echo $i++; ?></th>
                  <td><?php echo htmlspecialchars(ucwords($ds['master_name']), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><i class="fas fa-rupee-sign"></i><?php echo htmlspecialchars(ucwords($ds['master_amount']), ENT_QUOTES, 'UTF-8'); ?>/-</td>
                  <td><?php echo htmlspecialchars(ucwords($ds['master_class']), ENT_QUOTES, 'UTF-8'); ?></td>
                  <td>
                    <form action="" method="post">
                        <input type="hidden" name="del_id" value="<?php echo htmlspecialchars($ds['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <button class="btn btn-danger btn-sm" type="submit" name="del"><i class="fas fa-trash-alt"></i></button>
                    </form>
                  </td>
                </tr>
        <?php }
    }
?>
              </tbody>
            </table>