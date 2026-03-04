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
    $academic_setter = '2024-25';
  } else {
    $academic_setter = $_SESSION['academic_setter']; 
  }
?>

<?php 
    if (isset($_POST['name'])) {
        $item_name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    } else {
        $error_message = "sorry something went wrong1";
    }


    if (isset($_POST['time'])) {
        $item_amount = htmlspecialchars($_POST['time'], ENT_QUOTES, 'UTF-8');
    } else {
        $error_message = "sorry something went wrong2";
    }


    if (isset($_POST['st_class'])) {
        $item_class = htmlspecialchars($_POST['st_class'], ENT_QUOTES, 'UTF-8');
    } else {
        $error_message = "sorry something went wrong3";
    }

    if (isset($_POST['fe_ca'])) {
        $item_category = htmlspecialchars($_POST['fe_ca'], ENT_QUOTES, 'UTF-8');
    } else {
        $error_message = "sorry something went wrong4";
    }


    $check_if_item_is_already_present_for_the_class = mysqli_query($connection, "SELECT * FROM erp_master_details WHERE master_name = '$item_name' AND master_class = '$item_class' AND master_cat = '$item_category' AND master_sts = '1' AND master_year = '$academic_setter'");

    if (mysqli_num_rows($check_if_item_is_already_present_for_the_class) > 0) {
        $error_message = "Data name already present, please enter other name";   
    } else {
        $insert = mysqli_query($connection, "INSERT INTO erp_master_details(master_name, master_amount, master_class, master_sts, master_year, master_cat) VALUES('$item_name', '$item_amount', '$item_class', '1', '$academic_setter', '$item_category')");

        if (isset($insert)) {
            $error_message = "Success data entered";
        }
    }

    echo trim($error_message);
?>