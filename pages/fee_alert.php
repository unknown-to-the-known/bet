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
            // $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['tree_id'], ENT_QUOTES, 'UTF-8');
            $account_privilage = htmlspecialchars($i['user_allowed'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>

<?php 
  if (!isset($_SESSION['academic_setter'])) {
    $_SESSION['academic_setter'] = '2025_26';
  }
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap">

<div class="container zindex-100 desk" style="margin-top: 0px">
    <div style="float: left;">
        <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition student_trim_name" style="font-family: 'Nunito Sans', sans-serif;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
    </div>

  <div style="float:right; text-decoration: underline; cursor:pointer;" class="text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal_year">
    <i class="fas fa-graduation-cap"></i> Year <?php echo htmlspecialchars(str_replace('_', '-', $_SESSION['academic_setter']), ENT_QUOTES, 'UTF-8'); ?>
  </div>
</div>
<section>
<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-around" style="overflow-y: scroll;">
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=baby"><button class="btn btn-outline-info btn-sm">Grade Baby</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=lkg"><button class="btn btn-outline-info btn-sm">Grade LKG</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=ukg"><button class="btn btn-outline-info btn-sm">Grade UKG</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=1"><button class="btn btn-outline-info btn-sm">Grade 1</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=2"><button class="btn btn-outline-info btn-sm">Grade 2</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=3"><button class="btn btn-outline-info btn-sm">Grade 3</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=4"><button class="btn btn-outline-info btn-sm">Grade 4</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=5"><button class="btn btn-outline-info btn-sm">Grade 5</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=6"><button class="btn btn-outline-info btn-sm">Grade 6</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=7"><button class="btn btn-outline-info btn-sm">Grade 7</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=8"><button class="btn btn-outline-info btn-sm">Grade 8</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=9"><button class="btn btn-outline-info btn-sm">Grade 9</button></a>
            <a href="<?php echo BASE_URL; ?>pages/fee_alert?id=10"><button class="btn btn-outline-info btn-sm">Grade 10</button></a>
        </div>
    </div>
</div>
</section>
<?php 
    if (isset($_GET['id'])) {
        if ($_GET['id'] != "") {
            $u_class = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
        } else {
            header("Location: " . BASE_URL . 'pages/fee_alert');
        }
    } else {
        header("Location: " . BASE_URL . 'pages/fee_alert');
    }
?>


<?php
$successMessage = "";
$errorMessage = "";


if (isset($_POST['send_whatsapp']) || isset($_POST['send_all_whatsapp'])) {
    if (!isset($_POST['students']) && !isset($_POST['send_all_whatsapp'])) {
        $errorMessage = "⚠️ Please select at least one student to send a message.";
    } else {
        // Green-API credentials
        $idInstance = '7105206644';         // Replace with your Green-API ID
        $apiToken = 'aca8587084c6411f8ce0ab8bcf994f587b52bcf7b73e4f5eb8';    // Replace with your Green-API token

        $students = isset($_POST['send_all_whatsapp']) 
            ? mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_admission_class = '$u_class' AND rev_sts = '1'") 
            : $_POST['students'];

        foreach ($students as $student) {
            // Prepare student data depending on the mode
            $studentData = isset($_POST['send_all_whatsapp']) ? [
                'pho' => $student['rev_father_mobile'],
                'name' => $student['rev_student_fname'],
                'tuition' => $student['rev_fees'],
                'books' => $student['rev_books'],
                'father' => $student['rev_father_fname'],
                'student_class' => $student['rev_admission_class'],
                'transportation' => $student['rev_transportation']
            ] : json_decode(stripslashes($student), true);

            // Format phone number for WhatsApp (e.g., 91XXXXXXXXXX@c.us)
            // $cleanPhone = preg_replace('/[^0-9]/', '', $studentData['pho']) . '@c.us';

            // Construct message
            $message = "*FEE ALERT*\nFrom *Sharada Vidya Peetha*\n*Student*: " . $studentData['name'] . "\n*Grade*: " . $u_class . "\n*Total Annual Fee*: ₹" . $studentData['tuition'] . "/-\n\nPlease pay the fee on or before the due date to avoid late fees, as mentioned in the school diary.\nKindly ignore this message if the fee is already paid.\n\nFor queries, contact the school office.\nThank you!";

            // Send message using cURL
            $url = "https://api.green-api.com/waInstance{$idInstance}/SendMessage/{$apiToken}";
            $payload = json_encode([
                'chatId' => '91' . $studentData['pho'] . '@c.us',
                'message' => $message
            ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Log or handle errors if needed
            if ($httpCode != 200) {
                console.log("Failed to send message to {$studentData['pho']}: $response");
            }
        }

        $successMessage = "✅ Messages sent successfully!";
    }
}


?>

<?php 
    if (isset($u_class)) { ?>
        <div class="container">
            <?php if ($successMessage): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $successMessage; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($errorMessage): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $errorMessage; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Select Class</h3>
                        <table class="table table-bordered text-dark">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Action</th>
                                    <th>Name</th>
                                    <th>Pending Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $get_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_admission_class = '$u_class' AND rev_sts = '1'");
                                if (mysqli_num_rows($get_student_details) > 0) {
                                $i = 1;
                                while ($ds = mysqli_fetch_assoc($get_student_details)) { ?>
                                    <tr>
                                        <th><?php echo $i++; ?></th>
                                        <td>
                                            <input type="checkbox" name="students[]" value="<?php echo htmlspecialchars(json_encode([ 
                                                'pho' => $ds['rev_father_mobile'], 
                                                'name' => $ds['rev_student_fname'],
                                                'tuition' => $ds['rev_fees'], 
                                                'books' => $ds['rev_books'], 
                                                'transportation' => $ds['rev_transportation'] 
                                            ])); ?>">
                                        </td>
                                        <td><?php echo $ds['rev_student_fname']; ?></td>
                                        <td>
                                            Tution Fee: ₹<?php echo $ds['rev_fees']; ?><br>
                                            Books Fee: ₹<?php echo $ds['rev_books']; ?><br>
                                            Transportation Fee: ₹<?php echo $ds['rev_transportation']; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <p class="text-dark text-center fw-bold" style="font-size:20px;">No Students in the selected class</p>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php 
                            if (mysqli_num_rows($get_student_details) > 0) { ?>
                            <button type="submit" name="send_whatsapp" class="btn btn-success load">Send Remainder to Selected Students</button>
                            <button type="submit" name="send_all_whatsapp" class="btn btn-success load">Send Remainder to All</button>
                            <p class="text alert alert-info text-center fw-bold" role="alert"></p>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    <?php } ?>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<script>
    $('.text').hide();
    $('.load').click(function() {
        $('.load').hide();
        $('.text').show();
        $('.text').html('Please wait messages are being sent');
    })
</script>