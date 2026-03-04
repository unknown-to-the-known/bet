<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<?php
    $today_date_time = date('Y-m-d H:i:s');
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
        $fetch_all_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_school_id = '$school_id'");

        if (mysqli_num_rows($fetch_all_details) > 0) {
            while($r = mysqli_fetch_assoc($fetch_all_details)) {
                $rev_fname = htmlspecialchars($r['rev_student_fname'], ENT_QUOTES, 'UTF-8');
                $rev_mname = htmlspecialchars($r['rev_student_mname'], ENT_QUOTES, 'UTF-8');
                $rev_lname = htmlspecialchars($r['rev_student_lname'], ENT_QUOTES, 'UTF-8');

                $rev_class = htmlspecialchars($r['rev_admission_class'], ENT_QUOTES, 'UTF-8');
                $rev_semster = htmlspecialchars($r['rev_semster'], ENT_QUOTES, 'UTF-8');
                $rev_mother_tongue = htmlspecialchars($r['rev_mother_tongue'], ENT_QUOTES, 'UTF-8');
                $rev_medium_of_instruction = htmlspecialchars($r['rev_moi'], ENT_QUOTES, 'UTF-8');
                $rev_previous_affiliation = htmlspecialchars($r['rev_previous_affiliation'], ENT_QUOTES, 'UTF-8');
                $rev_previous_tc_number = htmlspecialchars($r['rev_previous_tc_number'], ENT_QUOTES, 'UTF-8');
                $rev_previous_tc_date = htmlspecialchars($r['rev_previous_tc_date'], ENT_QUOTES, 'UTF-8');
                $rev_previous_school_name = htmlspecialchars($r['rev_previous_school_name'], ENT_QUOTES, 'UTF-8');
                $rev_previous_school_type = htmlspecialchars($r['rev_previous_school_type'], ENT_QUOTES, 'UTF-8');
                $rev_previous_pincode = htmlspecialchars($r['rev_previous_pincode'], ENT_QUOTES, 'UTF-8');
                $rev_previous_district = htmlspecialchars($r['rev_previous_district'], ENT_QUOTES, 'UTF-8');
                $rev_previous_taluk = htmlspecialchars($r['rev_previous_taluk'], ENT_QUOTES, 'UTF-8');
                $rev_previous_city = htmlspecialchars($r['rev_previous_city'], ENT_QUOTES, 'UTF-8');

                $rev_previous_address = htmlspecialchars($r['rev_prev_address'], ENT_QUOTES, 'UTF-8');

                $rev_student_father_name = htmlspecialchars($r['rev_father_fname'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($r['rev_father_mname'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($r['rev_father_lname'], ENT_QUOTES, 'UTF-8');

                $rev_student_mother_name = htmlspecialchars($r['rev_mother_fname'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($r['rev_mother_mname'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($r['rev_mother_lname'], ENT_QUOTES, 'UTF-8');

                $rev_student_aadhar_name = htmlspecialchars($r['rev_student_aadhaar_number'], ENT_QUOTES, 'UTF-8');
                $rev_student_aadhar_doc = htmlspecialchars($r['rev_student_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

                $rev_father_aadhar_name = htmlspecialchars($r['rev_father_aadhaar_number'], ENT_QUOTES, 'UTF-8');
                $rev_father_aadhar_doc = htmlspecialchars($r['rev_father_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

                $rev_mother_aadhar_name = htmlspecialchars($r['rev_mother_aadhaar_number'], ENT_QUOTES, 'UTF-8');
                $rev_mother_aadhar_doc = htmlspecialchars($r['rev_mother_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

                $rev_student_dob = htmlspecialchars($r['rev_student_dob'], ENT_QUOTES, 'UTF-8');
                $rev_student_dob_doc = htmlspecialchars($r['rev_student_dob_doc'], ENT_QUOTES, 'UTF-8');

                $rev_student_urban_rural = htmlspecialchars($r['rev_urban_rural'], ENT_QUOTES, 'UTF-8');

                $rev_student_gender = htmlspecialchars($r['rev_gender'], ENT_QUOTES, 'UTF-8');

                $rev_student_religion = htmlspecialchars($r['rev_religion'], ENT_QUOTES, 'UTF-8');

                $rev_student_caste_number = htmlspecialchars($r['rev_student_caste_number'], ENT_QUOTES, 'UTF-8');
                $rev_student_caste_doc = htmlspecialchars($r['rev_student_caste_doc'], ENT_QUOTES, 'UTF-8');
                $rev_student_caste_name = htmlspecialchars($r['rev_student_caste_name'], ENT_QUOTES, 'UTF-8');


                $rev_father_caste_number = htmlspecialchars($r['rev_father_caste_number'], ENT_QUOTES, 'UTF-8');
                $rev_father_caste_doc = htmlspecialchars($r['rev_father_caste_doc'], ENT_QUOTES, 'UTF-8');
                $rev_father_caste_name = htmlspecialchars($r['rev_father_caste_name'], ENT_QUOTES, 'UTF-8');


                $rev_mother_caste_number = htmlspecialchars($r['rev_mother_caste_number'], ENT_QUOTES, 'UTF-8');
                $rev_mother_caste_doc = htmlspecialchars($r['rev_mother_caste_doc'], ENT_QUOTES, 'UTF-8');
                $rev_mother_caste_name = htmlspecialchars($r['rev_mother_caste_name'], ENT_QUOTES, 'UTF-8');


                $rev_social_category = htmlspecialchars($r['rev_social_category'], ENT_QUOTES, 'UTF-8');

                $rev_social_category_doc = htmlspecialchars($r['rev_social_category_doc'], ENT_QUOTES, 'UTF-8');

                $rev_social_bpl_doc = htmlspecialchars($r['rev_bpl_doc'], ENT_QUOTES, 'UTF-8');

                $rev_bhagyalakshmi_bond_doc = htmlspecialchars($r['rev_bhagyalakshmi_bond_doc'], ENT_QUOTES, 'UTF-8');

                $rev_disabality = htmlspecialchars($r['rev_disability_child'], ENT_QUOTES, 'UTF-8');

                $rev_disabality_doc = htmlspecialchars($r['rev_disabality_doc'], ENT_QUOTES, 'UTF-8');

                $rev_special_category = htmlspecialchars($r['rev_special_category'], ENT_QUOTES, 'UTF-8');

                $rev_special_category_doc = htmlspecialchars($r['rev_special_category_doc'], ENT_QUOTES, 'UTF-8');

                $rev_student_pincode = htmlspecialchars($r['rev_student_pincode'], ENT_QUOTES, 'UTF-8');

                $rev_student_district = htmlspecialchars($r['rev_student_district'], ENT_QUOTES, 'UTF-8');

                $rev_student_taluk = htmlspecialchars($r['rev_student_taluk'], ENT_QUOTES, 'UTF-8');

                $rev_student_city = htmlspecialchars($r['rev_student_city'], ENT_QUOTES, 'UTF-8');

                $rev_student_locality = htmlspecialchars($r['rev_student_locality'], ENT_QUOTES, 'UTF-8');

                $rev_student_address = htmlspecialchars($r['rev_student_address'], ENT_QUOTES, 'UTF-8');

                $rev_student_mobile = htmlspecialchars($r['rev_student_mobile'], ENT_QUOTES, 'UTF-8');

                $rev_student_email = htmlspecialchars($r['rev_student_email'], ENT_QUOTES, 'UTF-8');

                $rev_father_mobile = htmlspecialchars($r['rev_father_mobile'], ENT_QUOTES, 'UTF-8');

                $rev_father_email = htmlspecialchars($r['rev_father_email'], ENT_QUOTES, 'UTF-8');

                $rev_mother_mobile = htmlspecialchars($r['rev_mother_mobile'], ENT_QUOTES, 'UTF-8');

                $rev_mother_email = htmlspecialchars($r['rev_mother_email'], ENT_QUOTES, 'UTF-8');

                $rev_rte = htmlspecialchars($r['rev_rte'], ENT_QUOTES , 'UTF-8');

                $current_fees_paid = htmlspecialchars($r['rev_fees'], ENT_QUOTES, 'UTF-8');
                $current_trans_paid = htmlspecialchars($r['rev_transportation'], ENT_QUOTES, 'UTF-8');
            }

            $student_full_name = $rev_fname . ' ' . $rev_mname . ' ' . $rev_lname;
        }   
?>


<?php 
    if (isset($_POST['delete_btn'])) {
        $delete_id = mysqli_escape_string($connection, trim($_POST['del']));
        $student_id = mysqli_escape_string($connection, trim($_POST['student_id']));


        if ($delete_id == "") {
            $error_message = "Something went wrong";        
        }   

        

        if (!isset($error_message)) {
            $fetch_det = mysqli_query($connection, "SELECT * FROM erp_payment_details WHERE tree_id = '$delete_id'  AND rev_student_id = '$student_id'");

            if (mysqli_num_rows($fetch_det) > 0) {
                while($rdfd = mysqli_fetch_assoc($fetch_det)) {
                    echo $paid_to = $rdfd['rev_paid_to'];
                    $paid_amount = $rdfd['rev_payment_amount'];
                    $full_amount = $rdfd['rev_fees'];
                }
            }

            $delete_query = mysqli_query($connection, "UPDATE erp_payment_details SET rev_sts = '0' WHERE tree_id = '$delete_id'");

            $fetch_total_fee_pending = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id' AND rev_sts = '1'");

            if (mysqli_num_rows($fetch_total_fee_pending) > 0) {
                while($cde = mysqli_fetch_assoc($fetch_total_fee_pending)) {
                    $pending_fee = $cde['rev_fees'];
                }
            }
            // // Coding need to be done



            if ($paid_to == 'term_1') {
                $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$paid_amount' WHERE tree_id = '$student_id'");
                $full_amount_refund = $pending_fee + $paid_amount;
                $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$paid_amount', rev_fees = '$full_amount_refund' WHERE tree_id = '$student_id'");
            }

            if ($paid_to == 'term_2') {
                $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$paid_amount' WHERE tree_id = '$student_id'");
                $full_amount_refund = $pending_fee + $paid_amount;
                $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$paid_amount', rev_fees = '$full_amount_refund' WHERE tree_id = '$student_id'");
            }

            
            if ($paid_to == 'full_fee') {
                if ($full_amount == $paid_amount) {
                    $half_amount = $paid_amount / 2;
                    echo $update_term_1_fee = "UPDATE rev_erp_student_details SET rev_term1_fee = '$half_amount', rev_term2_fee = '$half_amount', rev_fees = '$paid_amount' WHERE tree_id = '$student_id'";
                } else {
                    
                }

                $current_month = date('m');
                if ($current_month == '6' || $current_month == '7' || $current_month == '8' || $current_month == '9' || $current_month == '10' || $current_month == '11') {
                    $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$paid_amount', rev_fees = '$paid_amount' WHERE tree_id = '$student_id'");
                }

                if ($current_month == '12' || $current_month == '1' || $current_month == '2' || $current_month == '3' || $current_month == '4') {
                    $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$paid_amount', rev_fees = '$paid_amount' WHERE tree_id = '$student_id'");
                }



                
             }

            // Books
            if ($paid_to == 'book') {
                $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = '$paid_amount' WHERE tree_id = '$student_id'");
            }

            // Trans

            if ($paid_to == 'trans') {
                $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_transportation = '$paid_amount' WHERE tree_id = '$student_id'");
            }

            $error_message = "Success, Payment Cancelled";          
        }
    }
?>


<?php 
    if (isset($_POST['submit'])) {
        $order_id = mysqli_escape_string($connection, trim($_POST['order_id']));
        $receipt_no = mysqli_escape_string($connection, trim($_POST['receipt_no']));
        $student_ids = mysqli_escape_string($connection, trim($_POST['student_id']));

        if ($order_id == "" || $receipt_no == "" || $student_ids == "") {
            $error_message = "Something went wrong";        
        }   

        if (!isset($error_message)) {
            $update_data = mysqli_query($connection, "UPDATE erp_payment_details SET rev_sts = '1',rev_recept_id = '$receipt_no' WHERE rev_student_id = '$student_ids' AND tree_id = '$order_id'");
            if (isset($update_data)) {
                $error_message = "Approved";
            }
        }
    }
?>


<?php 
    // if (isset($_POST['delete_btn'])) {
    //  $delete_id = mysqli_escape_string($connection, trim($_POST['del']));

    //  if ($delete_id == "") {
    //      $error_message = "Something went wrong";        
    //  }   

    //  if (!isset($error_message)) {
    //      $fetch_det = mysqli_query($connection, "SELECT * FROM erp_payment_details WHERE tree_id = '$delete_id'  AND rev_student_id = '$student_id'");

    //      if (mysqli_num_rows($fetch_det) > 0) {
    //          while($rdfd = mysqli_fetch_assoc($fetch_det)) {
    //              $paid_to = $rdfd['rev_paid_to'];
    //              $paid_amount = $rdfd['rev_payment_amount'];
    //              $full_amount = $rdfd['rev_fees'];
    //          }
    //      }

    //      $delete_query = mysqli_query($connection, "UPDATE erp_payment_details SET rev_sts = '0' WHERE tree_id = '$delete_id'");

    //      // Coding need to be done



    //      if ($paid_to == 'term_1') {
    //          $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$paid_amount' WHERE tree_id = '$student_id'");
    //      }

    //      if ($paid_to == 'term_2') {
    //          $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$paid_amount' WHERE tree_id = '$student_id'");
    //      }

            
    //      if ($paid_to == 'full_fee') {
    //          // if ($full_amount == $paid_amount) {
    //          //  $half_amount = $paid_amount / 2;
    //          //  $update_term_1_fee = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$half_amount', rev_term2_fee = '$half_amount', rev_fees = '$paid_amount' WHERE tree_id = '$student_id'");
    //          // } else {
                    
    //          // }

    //          $current_month = date('m');
    //          if ($current_month == '6' || $current_month == '7' || $current_month == '8' || $current_month == '9' || $current_month == '10' || $current_month == '11') {
    //              $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term1_fee = '$paid_amount', rev_fees = '$paid_amount' WHERE tree_id = '$student_id'");
    //          }

    //          if ($current_month == '12' || $current_month == '1' || $current_month == '2' || $current_month == '3' || $current_month == '4') {
    //              $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_term2_fee = '$paid_amount', rev_fees = '$paid_amount' WHERE tree_id = '$student_id'");
    //          }



                
    //      }

    //      // Books
    //      if ($paid_to == 'book') {
    //          $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_books = '$paid_amount' WHERE tree_id = '$student_id'");
    //      }

    //      // Trans

    //      if ($paid_to == 'trans') {
    //          $update_in_student_details = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_transportation = '$paid_amount' WHERE tree_id = '$student_id'");
    //      }

    //      $error_message = "Success, Payment Cancelled";          
    //  }
    // }
?>






<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<script type = "text/javascript" 
 src = "https://www.tutorialspoint.com/jquery/jquery-3.6.0.js">
</script>
<style type="text/css">
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}



.apply_box{
    max-width: 100%;
    padding: 10px;
    background-color: white;
    margin:0 auto;
    margin-top: 20px;
    box-shadow: 10px 10px 30px rgba(90, 88, 88, 0.5);
    border-radius: 0px;
}
.school{
    background-color: rgb(204, 238, 225);
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 10px 10px 30px rgba(120, 190, 179, 0.5);
}
.ptext{
    margin: auto;
    width: 100%;
    color: black;
    font-size: 20px; 
}
.textBg{
    background: #9a9c9c;
    color: #1f1c1c;
    padding: 15px;
    background: rgba(176, 233, 233, 0.4);
    border-radius: 5px;
}






@media(min-width:1px) AND (max-width:786px) {
    .m {
        text-align: right;
    }
    .mb{
        margin-bottom: 10px;
    }
    .school{
        font-size: 20px;
    }
    .textBg.ptext{
        font-size: 20px;
    }
}




</style>

<div class="container zindex-100 desk" style="margin-top: 10px">
    <div style="float: left;">
        <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px; width: 170px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
    </div>
    



    
</div>

    <!-- Content START -->
    <section>
        <div class="container">
            <?php 
                if (isset($error_message)) { ?>
                    <div class="alert alert-success" role="alert">
                      <?php echo $error_message; ?>
                    </div>
                <?php } ?>

            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Class</th>
                  <th scope="col">Paid To</th>
                  <th scope="col">Amount</th>
                  <th scope="col">UTR</th>
                  <th scope="col">Receipt No.</th>
                  <th scope="col">Date & time</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $fetch_trans_details = mysqli_query($connection, "SELECT * FROM erp_payment_details WHERE rev_school_id = '$school_id' ORDER BY tree_id DESC");

                if (mysqli_num_rows($fetch_trans_details) > 0) {
                    $i = 1;
                    while($rd = mysqli_fetch_assoc($fetch_trans_details)) { 
                        $student_id = $rd['rev_student_id'];

                        $fetch_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_id'");

                        if (mysqli_num_rows($fetch_student_details) > 0) {
                            while($rfd = mysqli_fetch_assoc($fetch_student_details)) {
                                $full_name = $rfd['rev_student_fname'] . ' ' . $rfd['rev_student_mname'] . ' ' . $rfd['rev_student_lname'];
                                $class = $rfd['rev_admission_class'];
                                $student_found_id = $rfd['tree_id'];
                            }
                        }
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i++; ?></th>
                            <td><?php echo htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($class, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(str_replace('_', ' ', $rd['rev_paid_to']), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($rd['rev_payment_amount'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $rd['rev_utr_id']; ?></td>
                            <td>
                                <?php 
                                    if ($rd['rev_recept_id'] != '0') {
                                        echo htmlspecialchars($rd['rev_recept_id'], ENT_QUOTES, 'UTF-8');
                                    }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars(date('d-M-Y h:i a', strtotime($rd['rev_paid_date_time'])), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php 
                                    if ($rd['rev_payment_mode'] == 'admin_account') {
                                        echo '<p style="color:green; font-weight:bold;">Paid To Admin</p>';
                                    }

                                    if ($rd['rev_sts'] == '3') { ?>
                                        <div class="d-flex">
                                        <button type="button" class="btn btn-success btn-sm approve_btn">Approve</button>
                                        <div class="approve">
                                            <form action="" method="post" autocomplete="off">
                                                <label>Receipt No.</label>
                                                <input type="text" name="receipt_no">
                                                <input type="hidden" name="student_id" value="<?php echo $student_found_id; ?>">
                                                <input type="hidden" name="order_id" value="<?php echo $rd['tree_id']; ?>">
                                                <button class="btn btn-primary btn-sm" type="submit" autocomplete="off" name="submit">Submit</button>
                                                <button class="btn btn-danger btn-sm cancel_btn" type="button" autocomplete="off">Cancel</button>
                                            </form>
                                        </div>&nbsp;
                                        <form action="" method="post">
                                            <input type="hidden" name="student_id" value="<?php echo $student_found_id; ?>">
                                            <input type="hidden" name="del" value="<?php echo $rd['tree_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm reject_btn" name="delete_btn">Reject</button>
                                        </form>
                                        </div>
                                        
                                        <!-- echo ''; -->
                                    <?php } ?>

                                    <?php 

                                    if ($rd['rev_sts'] == '1') {
                                        echo '<p style="color:green; font-weight:bold;">Approved by Admin</p>';
                                    }

                                    if ($rd['rev_sts'] == '0') {
                                        echo '<p style="color:red; font-weight:bold;">Rejected by Admin</p>';
                                    }

                                    ?>
                            </td>
                        </tr>
                    <?php }
                }
            ?>
              </tbody>
            </table>

        </div>
    </section>
<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>






<!-- Payment history -->




<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment History</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Amount</th>
              <th scope="col">Paid To <br> Receipt No</th>
              <th scope="col">Discount</th>
              <th scope="col">Paid On</th>            
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
                $fetch_all_active_payment = mysqli_query($connection, "SELECT * FROM erp_payment_details WHERE rev_student_id = '$student_id' AND rev_sts = '1'");

                if (mysqli_num_rows($fetch_all_active_payment) > 0) {
                    $i = 1;
                    while($vfr = mysqli_fetch_assoc($fetch_all_active_payment)) { ?>
                        <tr>
                          <th scope="row"><?php echo $i++; ?></th>
                          <td><?php echo 'Rs.' . htmlspecialchars($vfr['rev_payment_amount'], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($vfr['rev_paid_to'], ENT_QUOTES, 'UTF-8'); ?> <br> <?php echo htmlspecialchars($vfr['rev_recept_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($vfr['rev_discount'], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars(date('d-M-Y h:i a', strtotime($vfr['rev_paid_date_time'])), ENT_QUOTES, 'UTF-8'); ?></td>
                          
                          <form action="" method="post">
                            <td>
                                <!-- <i class="fas fa-trash-alt" style="color:red;"></i> -->
                                <input type="hidden" name="del" value="<?Php echo $vfr['tree_id']; ?>">
                                <button class="btn btn-danger btn-sm" type="submit" name="delete_btn"><i class="fas fa-trash-alt" style="color:#000;"></i></button>
                            </td>
                          </form>
                          
                        </tr>
                    <?php }
                }
            ?>          
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">

    $('.cash_box').hide();
    $('.cheque_box').hide();
    $('.upi_box').hide();
    $('.approve').hide();

    $('.cash').click(function() {
        $('.cash_box').toggle();
        $('.upi_box').hide();
        $('.cheque_box').hide();

    })

    $('.upi').click(function() {
        $('.cash_box').hide();
        $('.upi_box').toggle();
        $('.cheque_box').hide();

    })

    $('.cheque').click(function() {
        $('.cash_box').hide();
        $('.upi_box').hide();
        $('.cheque_box').toggle();

    })

    $('.approve_btn').click(function() {
        $('.approve').show();
        $('.approve_btn').hide();
        $('.reject_btn').hide();
    })
    $('.cancel_btn').click(function() {
        $('.approve').hide();
        $('.approve_btn').show();
        $('.reject_btn').show();
    })
    const exampleModal = document.getElementById('exampleModal')
if (exampleModal) {
  exampleModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const recipient = button.getAttribute('data-bs-whatever_full_name')
    const full_amount = button.getAttribute('data-bs-whatever_full_amount')
    const pending_amount = button.getAttribute('data-bs-whatever_pending_amount')
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalTitle = exampleModal.querySelector('.modal-title')
    const modalBodyInput = exampleModal.querySelector('.modal-body .full_amount')
    const modalBodyInput_pending = exampleModal.querySelector('.modal-body .pending_amount')

    modalTitle.textContent = `Student Name: ${recipient}`
    modalBodyInput.value = full_amount
    modalBodyInput_pending.value = pending_amount

  })
}

// Trans

const exampleModal_trans = document.getElementById('exampleModal_trans')
if (exampleModal_trans) {
  exampleModal_trans.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const recipient_trans = button.getAttribute('data-bs-whatever_full_name_trans')
    const full_amount_trans = button.getAttribute('data-bs-whatever_full_amount_trans')
    const pending_amount_trans = button.getAttribute('data-bs-whatever_pending_amount_trans')
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalTitle = exampleModal_trans.querySelector('.modal-title')
    const modalBodyInput = exampleModal_trans.querySelector('.modal-body .full_amount_trans')
    const modalBodyInput_pending = exampleModal_trans.querySelector('.modal-body .pending_amount_trans')

    modalTitle.textContent = `Student Name: ${recipient_trans}`
    modalBodyInput.value = full_amount_trans
    modalBodyInput_pending.value = pending_amount_trans

  })
}

// Approval modal
const exampleModals = document.getElementById('exampleModal')
if (exampleModals) {
  exampleModals.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const recipient = button.getAttribute('data-bs-whatever')
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalTitle = exampleModal.querySelector('.modal-title')
    const modalBodyInput = exampleModal.querySelector('.modal-body input')

    modalTitle.textContent = `New message to ${recipient}`
    modalBodyInput.value = recipient
  })
}
</script>

