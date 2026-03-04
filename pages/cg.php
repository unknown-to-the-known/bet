<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php
	if (isset($_COOKIE['aut'])) {
		$auto_login_code = htmlspecialchars($_COOKIE['aut'], ENT_QUOTES, 'UTF-8');
		$fetch_user_auto_login_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_auto_login = '$auto_login_code' AND rev_teach_sts = '1'");

		if (mysqli_num_rows($fetch_user_auto_login_details) > 0) {
			while($j = mysqli_fetch_assoc($fetch_user_auto_login_details)) {
				$user_email = htmlspecialchars($j['rev_teach_email'], ENT_QUOTES, 'UTF-8');
				 $_SESSION['teach_details'] = $user_email;
				  // header("Location: " . BASE_URL . 'pages/action');	
			}
		}
	}

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
            $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['rev_user_school_id'], ENT_QUOTES, 'UTF-8');
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
		if ($_GET['id'] != "") {
				$selected_c = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
			} else {
				$selected_c = '1';
			}
	   } else {
			$selected_c = '1';
	}
?>

<!-- Delete  -->
<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<div class="container zindex-100 desk" style="margin-top: 10px">
    <div style="float: left;">
        <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px; width: 170px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
    </div>
</div>
<section>
<div class="container">
     <div class="row">
        <div class="col-md-12">
            <div class="d-flex">
                <a href="<?php echo BASE_URL; ?>pages/cg?id=baby"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Baby class</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=lkg"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade LKG</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=ukg"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade UKG</div></a>

                <a href="<?php echo BASE_URL; ?>pages/cg?id=1"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 1</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=2"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 2</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=3"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 3</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=4"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 4</div></a>

                <a href="<?php echo BASE_URL; ?>pages/cg?id=5"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 5</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=6"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 6</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=7"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 7</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=8"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 8</div></a>

                <a href="<?php echo BASE_URL; ?>pages/cg?id=9"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 9</div></a>
                <a href="<?php echo BASE_URL; ?>pages/cg?id=10"><div class="btn btn-sm btn-danger-soft" style="margin-right: 10px;">Grade 10</div></a>
            </div>
            <table class="table table-bordered text-dark fw-bold">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Student Name & Father Name</th>
                  <th scope="col">Class</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                    $fetch_selected_students = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_admission_class = '$selected_c' AND rev_sts = '1'");

                    if (mysqli_num_rows($fetch_selected_students) > 0) {
                        $i = 1;
                        while($row = mysqli_fetch_assoc($fetch_selected_students)) { ?>
                            <tr>
                              <th scope="row"><?php echo $i++; ?></th>
                              <td><?php echo htmlspecialchars(ucfirst($row['rev_student_fname']), ENT_QUOTES, 'UTF-8'); ?><br><?php echo htmlspecialchars(ucfirst($row['rev_father_fname']), ENT_QUOTES, 'UTF-8'); ?></td>
                              <td><?php echo $selected_c; ?></td>
                              <td>
                                <a href="<?php echo BASE_URL; ?>hk?id=<?php echo htmlspecialchars($row['tree_id'], ENT_QUOTES, 'UTF-8'); ?>"><button class="btn btn-outline-success btn-sm "> <i class="fas fa-download"></i> HK Certificate</button></a>
                                <button class="btn btn-sm btn-outline-success"> <i class="fas fa-download"></i> Study Certificate</button>
                                <button class="btn btn-sm btn-outline-success"> <i class="fas fa-download"></i> Transfer Certificate</button>
                              </td>
                            </tr>
                        <?php }
                    }
                ?>
                
              </tbody>
            </table>
        </div>
     </div>   
</div>
</section>
<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>

