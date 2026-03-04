<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<?php $today = date('Y-m-d h:i a'); ?>

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
            $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['user_school_id'], ENT_QUOTES, 'UTF-8');
                       
         }  
    }
?>

<?php $host = $_SERVER['HTTP_HOST']; ?>


<?php 
    $uniq_id_generator = md5(date('Y-m-d H:i:s a'));
?>

<?php 
    if (isset($_GET['uni_id'])) {
        if ($_GET['uni_id'] != "") {
            $student_uniq_id = htmlspecialchars($_GET['uni_id'], ENT_QUOTES, 'UTF-8');
        } else {
            header("Location: " . BASE_URL . 'pages/add_student');
        }
    } else {
            header("Location: " . BASE_URL . 'pages/add_student');
        }

        if (strlen($student_uniq_id) > 6) {
            $error_message_load = 'something went wrong';
        }

    $fetch_student_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE rev_school_id = '$school_id' AND tree_id = '$student_uniq_id' AND rev_sts != '0'");

    if (mysqli_num_rows($fetch_student_details) > 0) {
        while($row = mysqli_fetch_assoc($fetch_student_details)) {
            $student_name = htmlspecialchars($row['rev_student_fname'], ENT_QUOTES, 'UTF-8');
            $father_aadhaar_number_f = htmlspecialchars($row['rev_father_aadhaar_number'], ENT_QUOTES, 'UTF-8');
            $father_aadhaar_doc_f = htmlspecialchars($row['rev_father_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

            $mother_aadhaar_number_f = htmlspecialchars($row['rev_mother_aadhaar_number'], ENT_QUOTES, 'UTF-8');
            $mother_aadhaar_doc_f = htmlspecialchars($row['rev_mother_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

            $student_aadhaar_number_f = htmlspecialchars($row['rev_student_aadhaar_number'], ENT_QUOTES, 'UTF-8');
            $student_aadhaar_doc_f = htmlspecialchars($row['rev_student_aadhaar_doc'], ENT_QUOTES, 'UTF-8');

            $student_urban_rural_f = htmlspecialchars(strtolower($row['rev_urban_rural']), ENT_QUOTES, 'UTF-8');
            $student_gender_f = htmlspecialchars($row['rev_gender'], ENT_QUOTES, 'UTF-8');

            $student_religion_f = htmlspecialchars($row['rev_religion'], ENT_QUOTES, 'UTF-8');
            $student_dob_f = htmlspecialchars($row['rev_student_dob'], ENT_QUOTES, 'UTF-8');
            $student_dob_doc_f = htmlspecialchars($row['rev_student_dob_doc'], ENT_QUOTES, 'UTF-8');


            $student_caste_number_f = htmlspecialchars($row['rev_student_caste_number'], ENT_QUOTES, 'UTF-8');
            $student_caste_name_f = htmlspecialchars($row['rev_student_caste_name'], ENT_QUOTES, 'UTF-8');
            $student_caste_doc_f = htmlspecialchars($row['rev_student_caste_doc'], ENT_QUOTES, 'UTF-8');

            $father_caste_number_f = htmlspecialchars($row['rev_father_caste_number'], ENT_QUOTES, 'UTF-8');
            $father_caste_name_f = htmlspecialchars($row['rev_father_caste_name'], ENT_QUOTES, 'UTF-8');
            $father_caste_doc_f = htmlspecialchars($row['rev_father_caste_doc'], ENT_QUOTES, 'UTF-8');

            $mother_caste_number_f = htmlspecialchars($row['rev_mother_caste_number'], ENT_QUOTES, 'UTF-8');
            $mother_caste_name_f = htmlspecialchars($row['rev_mother_caste_name'], ENT_QUOTES, 'UTF-8');
            $mother_caste_doc_f = htmlspecialchars($row['rev_mother_caste_doc'], ENT_QUOTES, 'UTF-8');

            $social_category_name_f = htmlspecialchars($row['rev_social_category'], ENT_QUOTES, 'UTF-8');
            $social_category_doc_f = htmlspecialchars($row['rev_social_category_doc'], ENT_QUOTES, 'UTF-8');

            $student_bpl_doc_f = htmlspecialchars($row['rev_bpl_doc'], ENT_QUOTES, 'UTF-8');

            $special_category_name_f = htmlspecialchars($row['rev_special_category'], ENT_QUOTES, 'UTF-8');
            $special_category_doc_f = htmlspecialchars($row['rev_special_category_doc'], ENT_QUOTES, 'UTF-8');

            $bhagya_lakshmi_doc_f = htmlspecialchars($row['rev_bhagyalakshmi_bond_doc'], ENT_QUOTES, 'UTF-8');

            $disbalility_name_f = htmlspecialchars($row['rev_disability_child'], ENT_QUOTES, 'UTF-8');
            $disabality_doc_f = htmlspecialchars($row['rev_disabality_doc'], ENT_QUOTES, 'UTF-8');
        }
    } else {
        // header("Location: " . BASE_URL . 'pages/add_student');
    }


    if (isset($_POST['submit'])) {

        

        $father_aadhaar_number = mysqli_escape_string($connection, trim($_POST['father_aadhaar_number']));
        // $father_aadhaar_doc = mysqli_escape_string($connection, trim($_POST['father_aadhaar_doc']));

        $mother_aadhaar_number = mysqli_escape_string($connection, trim($_POST['mother_aadhaar_number']));
        // $mother_aadhaar_doc =  mysqli_escape_string($connection, trim($_POST['mother_aadhaar_doc']));

        $student_aadhaar_number = mysqli_escape_string($connection, trim($_POST['student_aadhaar_number']));
        // $student_aadhaar_doc =  mysqli_escape_string($connection, trim($_POST['student_aadhaar_doc']));

        $student_urban_rural = mysqli_escape_string($connection, trim($_POST['inlineRadioOptions']));
        $student_gender = mysqli_escape_string($connection, trim($_POST['inlineRadioOptions4']));
        $student_religion = mysqli_escape_string($connection, trim($_POST['rel']));
        $student_dob = mysqli_escape_string($connection, trim($_POST['student_dob']));
        // $student_dob_certificate = mysqli_escape_string($connection, trim($_POST['dob_doc']));

        $student_caste_name = mysqli_escape_string($connection, trim($_POST['student_caste_name']));
        $student_caste_ceritificate_number = mysqli_escape_string($connection, trim($_POST['student_certificate_no']));
        // $student_caste_certificate_doc = mysqli_escape_string($connection, trim($_POST['certificate_doc_student']));

        $father_caste_name = mysqli_escape_string($connection, trim($_POST['father_caste_name']));
        $father_caste_ceritificate_number = mysqli_escape_string($connection, trim($_POST['father_certificate_no']));
        // $father_caste_certificate_doc = mysqli_escape_string($connection, trim($_POST['']));


        $mother_caste_name = mysqli_escape_string($connection, trim($_POST['mother_caste_name']));
        $mother_caste_ceritificate_number = mysqli_escape_string($connection, trim($_POST['mother_certficate_no']));
        // $mother_caste_certificate_doc = mysqli_escape_string($connection, trim($_POST['certificate_doc_mother']));


        if ($student_urban_rural == "" || $student_gender == "" || $student_religion == "" || $student_dob == "") {
            $error_message = "Please fill all the required fields";
        }



        if (!isset($error_message)) {    
            // echo "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_uniq_id' AND rev_sts != '0'";        
            $fetch_all_mandatory_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$student_uniq_id' AND rev_sts != '0'");

            if (mysqli_num_rows($fetch_all_mandatory_details) > 0) {
                while($cfd = mysqli_fetch_assoc($fetch_all_mandatory_details)) {
                    $student_dob_doc = htmlspecialchars($cfd['rev_student_dob_doc'], ENT_QUOTES, 'UTF-8');
                    $student_social_category_doc = htmlspecialchars($cfd['rev_social_category_doc'], ENT_QUOTES, 'UTF-8');
                    $student_disabality_doc = htmlspecialchars($cfd['rev_disabality_doc'], ENT_QUOTES, 'UTF-8');
                }

                if ($student_dob_doc == "" || $student_social_category_doc == "" || $student_disabality_doc == "") {
                    $error_message = "Please fill required fileds";
                }

                // if ($student_dob_doc == '0') {
                //     $error_message = "Please fill all required fields";
                // }

                // if (!isset($error_message)) {
                //    if ($student_social_category_doc == '0') {
                //         $error_message = "Please fill all required fields";
                //     } 
                // }

                // if (!isset($error_message)) {
                //    if ($student_disabality_doc == '0') {
                //         $error_message = "Please fill all required fields";
                //     } 
                // }
                // Father aadhar details
                if (!isset($error_message)) {
                    if (strlen($father_aadhaar_number) > 0) {
                        $father_aadhaar_number = $father_aadhaar_number;
                    } else {
                        $father_aadhaar_number = '0';
                    }
                }

                // Mother aadhar details
                if (!isset($error_message)) {
                    if (strlen($mother_aadhaar_number) > 0) {
                        $mother_aadhaar_number = $mother_aadhaar_number;
                    } else {
                        $mother_aadhaar_number = '0';
                    }
                }

                // Student aadhar details
                if (!isset($error_message)) {
                    if (strlen($student_aadhaar_number) > 0) {
                        $student_aadhaar_number = $student_aadhaar_number;
                    } else {
                        $student_aadhaar_number = '0';
                    }
                }


                // Student caste name details
                if (!isset($error_message)) {
                    if (strlen($student_caste_name) > 0) {
                        $student_caste_name = $student_caste_name;
                    } else {
                        $student_caste_name = '0';
                    }
                }

                // Student caste certificate details 
                if (!isset($error_message)) {
                    if (strlen($student_caste_ceritificate_number) > 0) {
                        $student_caste_ceritificate_number = $student_caste_ceritificate_number;
                    } else {
                        $student_caste_ceritificate_number = '0';
                    }
                }



                // Father caste name details
                if (!isset($error_message)) {
                    if (strlen($father_caste_name) > 0) {
                        $father_caste_name = $father_caste_name;
                    } else {
                        $father_caste_name = '0';
                    }
                }

                // Father caste certificate details 
                if (!isset($error_message)) {
                    if (strlen($father_caste_ceritificate_number) > 0) {
                        $father_caste_ceritificate_number = $father_caste_ceritificate_number;
                    } else {
                        $father_caste_ceritificate_number = '0';
                    }
                }


                // mother caste name details
                if (!isset($error_message)) {
                    if (strlen($mother_caste_name) > 0) {
                        $mother_caste_name = $mother_caste_name;
                    } else {
                        $mother_caste_name = '0';
                    }
                }

                // mother caste certificate details 
                if (!isset($error_message)) {
                    if (strlen($mother_caste_ceritificate_number) > 0) {
                        $mother_caste_ceritificate_number = $mother_caste_ceritificate_number;
                    } else {
                        $mother_caste_ceritificate_number = '0';
                    }
                }

                // Update data
                
                $update = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_father_aadhaar_number = '$father_aadhaar_number', rev_mother_aadhaar_number = '$mother_aadhaar_number', rev_student_aadhaar_number = '$student_aadhaar_number', rev_urban_rural = '$student_urban_rural',  rev_gender = '$student_gender', rev_religion = '$student_religion', rev_student_dob = '$student_dob', rev_student_caste_number = '$student_caste_ceritificate_number', rev_student_caste_name = '$student_caste_name', rev_father_caste_number = '$father_caste_ceritificate_number', rev_father_caste_name = '$father_caste_name', rev_mother_caste_number = '$mother_caste_ceritificate_number', rev_mother_caste_name = '$mother_caste_name' WHERE tree_id = '$student_uniq_id'");


                if (isset($update)) {
                    header('Location: ' . BASE_URL . 'pages/third?uni_id=' . $student_uniq_id);
                }
            }
        }
    }
?>
<!-- Delete category -->
<?php 
    if (isset($_POST['father_aadhar_delete'])) {
        $father_aadhar_uniq_id_c = mysqli_escape_string($connection, trim($_POST['father_aadhar_c']));

        $delete_father_aadhar_id = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_father_aadhaar_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }

    if (isset($_POST['mother_aadhar_delete'])) {
        $mother_aadhar_uniq_id_c = mysqli_escape_string($connection, trim($_POST['mother_aadhar_c']));

        $delete_father_aadhar_id = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_mother_aadhaar_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }

    if (isset($_POST['student_aadhar_delete'])) {
        $student_aadhar_uniq_id_c = mysqli_escape_string($connection, trim($_POST['student_aadhar_c']));

        $delete_student_aadhar_id = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_student_aadhaar_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }


    if (isset($_POST['student_dob_delete'])) {
        $student_dob_c = mysqli_escape_string($connection, trim($_POST['student_dob_c']));

        $delete_student_dob_id = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_student_dob_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }


    if (isset($_POST['student_caste_delete'])) {
        $student_caste_c = mysqli_escape_string($connection, trim($_POST['student_caste_c']));

        $delete_caste_delete = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_student_caste_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }

    if (isset($_POST['father_caste_delete'])) {
        $father_caste_c = mysqli_escape_string($connection, trim($_POST['father_caste_c']));

        $delete_caste_delete = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_father_caste_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }


    if (isset($_POST['mother_caste_delete'])) {
        $mother_caste_c = mysqli_escape_string($connection, trim($_POST['mother_caste_c']));

        $delete_caste_delete = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_mother_caste_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }



    if (isset($_POST['social_category_cdelete'])) {
        $social_category_c = mysqli_escape_string($connection, trim($_POST['social_category_c']));

        $delete_social_category_delete = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_social_category_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }

    if (isset($_POST['sostudent_bpldelete'])) {
        $student_bpl_c = mysqli_escape_string($connection, trim($_POST['student_bpl_c']));

        $delete_bpl_delete = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_bpl_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }


    if (isset($_POST['special_category_delete'])) {
        $special_category_c = mysqli_escape_string($connection, trim($_POST['special_category_c']));

        $delete_special_category_delete = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_special_category_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }

    if (isset($_POST['bhagya_bond_delete'])) {
        $bhagya_bond_delete_c = mysqli_escape_string($connection, trim($_POST['bhagya_bond_c']));

        $delete_bhagya_bond_delete = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_bhagyalakshmi_bond_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }

         

    if (isset($_POST['disabality_c_delete'])) {
        $disabality_delete_c = mysqli_escape_string($connection, trim($_POST['disabality_c']));

        $delete_disabality_delete = mysqli_query($connection, "UPDATE rev_erp_student_details SET rev_disabality_doc = '0' WHERE tree_id = '$student_uniq_id' AND rev_school_id = '$school_id'"); 
            header("Location: " . BASE_URL . 'pages/second_box?uni_id=' . $student_uniq_id);
         }
?>
<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link href="https://releases.transloadit.com/uppy/v3.23.0/uppy.min.css" rel="stylesheet">
<?php if (!isset($error_message_load)) { ?>
<div class="container zindex-100 desk" style="margin-top: 10px">
        <div style="float: left;">
            <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px; width: 170px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
        </div>
    </div>
    <section>
        <!-- Content START -->
        <div class="container zindex-100 desk mb-4">
            <div class="row d-lg-flex justify-content-md-center g-md-5">                        
                <h4 class="fs-1 fw-bold d-flex justify-content-center">
                    <img src="<?php echo BASE_URL; ?>assets/images/add-user.webp" width="50px" height="50px" alt="Homework">
                    <span class="position-relative z-index-9" style="font-size: 33px;">&nbsp;Add new&nbsp;</span>
                    <span class="position-relative z-index-1" style="font-size: 33px;">Student
                </h4>
            </div> <!-- Row END -->
        </div>              
    </section>


    <div class="col-md-12 single_upload_box">
                <div class="card card-body shadow p-4 p-sm-5 position-relative">
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
                            <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
                        </symbol>
                        <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
                            <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
                        </symbol>
                    </svg>                  
                    <!-- Form START -->       
                    <?php 
                            if (isset($error_message)) {
                                echo $error_message;
                            }
                        ?>          
                    <form class="row g-3 position-relative" autocomplete="off" action="" method="post">
                        <h3>Enter details about <?php echo ucfirst($student_name); ?></h3>

                        

                        <!-- Father Aadhar number -->
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold" for="father_aadhar">Father Aadhaar Number</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="number" placeholder="Enter Father Aadhaar Number" name="father_aadhaar_number" id="father_aadhar" autocomplete="nope" value="<?php if ($father_aadhaar_number_f != '0') {
                                                    echo $father_aadhaar_number_f;
                                                }; ?>">
                                            </div>                              
                                        </div>  
                                    <!-- <input class="form-control mt-1" type="file" id="father_formFile" name="father_aadhaar_doc"> -->
                                    <button class="btn btn-primary" id="uppyModalOpener_father_aadhar" type="button">Attach Document</button>
                                    <div id="uppyModalOpener_father_aadhar"></div>
                                    <?php 
                                        if (strlen($father_aadhaar_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $father_aadhaar_doc_f; ?>"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $father_aadhaar_doc_f; ?>" alt="father aadhar doc" class="new_father_aadhar_doc" style="width: 50px; height:50px;"></a> 
                                             <!-- <form action="" method="post"> -->
                                                <input type="hidden" name="father_aadhar_c" value="<?php echo $father_aadhaar_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="father_aadhar_delete">Delete</button>
                                            <!-- </form> -->
                                           
                                        <?php } ?>
                                    
                                    <div id="uppyModalOpener_father_aadhar_message"></div>
                                </div>
                            </div>                      
                        </div>

                        <!-- Mother Aadhar number -->
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold" for="mother_aadhar">Mother Aadhaar Number</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="number" placeholder="Enter Mother Aadhaar Number" name="mother_aadhaar_number" id="mother_aadhar" autocomplete="nope" value="<?php if ($mother_aadhaar_number_f != '0') {
                                                    echo $mother_aadhaar_number_f;
                                                }; ?>">
                                            </div>                              
                                        </div>  
                                    <button class="btn btn-primary" id="uppyModalOpener_mother_aadhar" type="button">Attach Document</button>
                                    <div id="uppyModalOpener_mother_aadhar"></div>
                                    <div id="uppyModalOpener_mother_aadhar_message"></div>
                                    <?php 
                                        if (strlen($mother_aadhaar_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $mother_aadhaar_doc_f; ?>">
                                            <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $mother_aadhaar_doc_f; ?>" alt="mother aadhar doc" class="new_mother_aadhar_doc" style="width: 50px; height:50px;"></a>

                                            <input type="hidden" name="mother_aadhar_c" value="<?php echo $mother_aadhaar_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="mother_aadhar_delete">Delete</button>

                                        <?php } ?>
                                </div>
                            </div>                      
                        </div>

                        <!-- Student Aadhar number -->
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold" for="student_aadhaar">Student Aadhaar Number</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="number" placeholder="Enter Mother Aadhaar Number" name="student_aadhaar_number" autocomplete="nope" value="<?php if ($father_aadhaar_number_f != '0') {
                                                    echo $student_aadhaar_number_f;
                                                }; ?>" id="student_aadhaar">
                                            </div>                              
                                        </div>  
                                    <button class="btn btn-primary" id="uppyModalOpener_student_aadhar" type="button">Attach Document</button>
                                    <div id="uppyModalOpener_student_aadhar"></div>
                                    <div id="uppyModalOpener_student_aadhar_message"></div>
                                    <?php 
                                        if (strlen($student_aadhaar_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $student_aadhaar_doc_f; ?>">
                                                <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $student_aadhaar_doc_f; ?>" alt="student aadhar doc" class="new_student_aadhar_doc" style="width: 50px; height:50px;">
                                            </a>

                                            <input type="hidden" name="student_aadhar_c" value="<?php echo $student_aadhaar_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="student_aadhar_delete">Delete</button>
                                        <?php } ?>
                                </div>
                            </div>                      
                        </div>

                        <!-- Urban/Rural -->
                        <div class="col-md-4" >                         
                            <label class="text-dark fw-bold">Urban/Rural<span style="color:red;">*</span></label>
                            <br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="urban" <?php

                                if ($student_urban_rural_f == 'urban') {
                                    echo 'checked';
                                }                                
                               ?>>

                              <label class="form-check-label text-dark" for="inlineRadio1">Urban</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="rural" <?php
                                if ($student_urban_rural_f == 'rural') {
                                    echo 'checked';
                                }                                
                               ?>>
                              <label class="form-check-label text-dark" for="inlineRadio2">Rural</label>    
                            </div>                      
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4" >                         
                            <label class="text-dark fw-bold">Gender<span style="color:red;">*</span></label>
                            <br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="inlineRadio4" value="male" <?php
                                if ($student_gender_f == 'male') {
                                    echo 'checked';
                                }                                
                               ?>>
                              <label class="form-check-label text-dark" for="inlineRadio4">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="inlineRadio5" value="female" <?php
                                if ($student_gender_f == 'female') {
                                    echo 'checked';
                                }                                
                               ?>>
                              <label class="form-check-label text-dark" for="inlineRadio5">Female</label>   
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="inlineRadio6" value="transgender" <?php
                                if ($student_gender_f == 'transgender') {
                                    echo 'checked';
                                }                                
                               ?>>
                              <label class="form-check-label text-dark" for="inlineRadio6">Transgender</label>  
                            </div>                      
                        </div>
                        <!-- Religion -->
                        <div class="col-md-4" >
                            <label class="text-dark fw-bold" for="rel1">Religion<span style="color:red;">*</span></label>
                            <div class="bg-body shadow rounded-pill p-2">                               
                                <input list="rel" name="rel" id="rel1" class="form-control border-0 me-1" value="<?php if ($student_religion_f != '0') {
                                    echo $student_religion_f;
                                }; ?>"> 
                                  <datalist id="rel">
                                    <option value="Hindu">
                                    <option value="Muslim">
                                    <option value="Christian">
                                    <option value="Sikh">
                                    <option value="Buddhist">
                                    <option value="Parsi">
                                    <option value="Jain">                                   
                                  </datalist>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Student DOB<span style="color:red">*</span> & Birth Certificate<span style="color:red">*</span></label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" name="student_dob" autocomplete="off" value="<?php if ($student_dob_f != '0') { echo $student_dob_f; } ?>" pattern="\d{2}[-/]\d{2}[-/]\d{4}" placeholder="DD-MM-YYYY or DD/MM/YYYY" title="Enter date in DD-MM-YYYY or DD/MM/YYYY format">                                           
                                            </div>                              
                                        </div>  
                                        
                                    <button class="btn btn-primary" id="uppyModalOpener_student_bob" type="button">Attach Document</button>
                                    <div id="uppyModalOpener_student_bob"></div>
                                    <div id="uppyModalOpener_student_bob_message"></div>
                                    <?php 
                                        if (strlen($student_dob_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $student_dob_doc_f; ?>">
                                            <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $student_dob_doc_f; ?>" alt="student dob doc" class="student_dob_doc_f" style="width: 50px; height:50px;"></a>

                                                <input type="hidden" name="student_dob_c" value="<?php echo $student_dob_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="student_dob_delete">Delete</button>
                                        <?php } ?>
                                </div>
                            </div>                      
                        </div>

                        <!-- Student Caste Certificate No -->
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Student Caste & Certificate No.</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter Student Caste Certificate No" name="student_certificate_no" autocomplete="nope" value="<?php if ($student_caste_number_f != '0') {
                                                    echo $student_caste_number_f;
                                                }; ?>">                                             
                                            </div>                              
                                        </div>  
                                        <div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter Student Caste" name="student_caste_name" autocomplete="nope" value="<?php if ($student_caste_name_f != '0') {
                                                    echo $student_caste_name_f;
                                                }; ?>" >                                                
                                            </div>
                                        </div>
                                    <button class="btn btn-primary" id="uppyModalOpener_student_caste_ceritificate" type="button">Attach Document</button>
                                    <div id="uppyModalOpener_student_caste_ceritificate"></div>
                                    <div id="uppyModalOpener_student_caste_ceritificate_message"></div>

                                    <?php 
                                        if (strlen($student_caste_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $student_caste_doc_f; ?>">
                                            <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $student_caste_doc_f; ?>" alt="student caste doc" class="student_caste_doc_f" style="width: 50px; height:50px;"></a>

                                            <input type="hidden" name="student_caste_c" value="<?php echo $student_caste_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="student_caste_delete">Delete</button>
                                        <?php } ?>
                                    
                                </div>
                            </div>                      
                        </div>

                        <!-- Father's Caste Certificate No -->
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Father's Caste & Certificate No.</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter Father Caste Certificate No" name="father_certificate_no" autocomplete="nope" value="<?php if ($father_caste_number_f != '0') {
                                                    echo $father_caste_number_f;
                                                }; ?>" >
                                            </div>                              
                                        </div>  

                                        <div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter Father Caste" name="father_caste_name" autocomplete="nope" value="<?php if ($father_caste_name_f != '0') {
                                                    echo $father_caste_name_f;
                                                }; ?>" >                                              
                                            </div>
                                        </div>
                                    <button class="btn btn-primary" id="uppyModalOpener_father_caste_ceritificate" type="button">Attach Document</button>
                                    <div id="uppyModalOpener_father_caste_ceritificate"></div>
                                    <div id="uppyModalOpener_father_caste_ceritificate_message"></div>
                                    <?php 
                                        if (strlen($father_caste_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $father_caste_doc_f; ?>">
                                            <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $father_caste_doc_f; ?>" alt="father caste doc" class="father_caste_doc_f" style="width: 50px; height:50px;">
                                            </a>

                                            <input type="hidden" name="father_caste_c" value="<?php echo $father_caste_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="father_caste_delete">Delete</button>
                                        <?php } ?>
                                </div>
                            </div>                      
                        </div>

                        <!-- Mother's Caste Certificate No -->
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Mother's Caste & Certificate No.</label>
                                        <div class="bg-body shadow rounded-pill p-2">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter Mother Caste Certificate No" name="mother_certficate_no" autocomplete="nope" value="<?php if ($mother_caste_number_f != '0') {
                                                    echo $mother_caste_number_f;
                                                }; ?>" >                                                
                                            </div>
                                        </div>

                                        <div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
                                            <div class="input-group">
                                                <input class="form-control border-0 me-1" type="text" placeholder="Enter Mother Caste" name="mother_caste_name" autocomplete="nope" value="<?php if ($mother_caste_name_f != '0') {
                                                    echo $mother_caste_name_f;
                                                }; ?>" >                                              
                                            </div>
                                        </div>  
                                    <button class="btn btn-primary" id="uppyModalOpener_mother_caste_ceritificate" type="button">Attach Document</button>
                                    <div id="uppyModalOpener_mother_caste_ceritificate"></div>
                                    <div id="uppyModalOpener_mother_caste_ceritificate_message"></div>
                                    <?php 
                                        if (strlen($mother_caste_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $mother_caste_doc_f; ?>">
                                            <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $mother_caste_doc_f; ?>" alt="mother caste doc" class="mother_caste_doc_f" style="width: 50px; height:50px;">
                                            </a>

                                            <input type="hidden" name="mother_caste_c" value="<?php echo $mother_caste_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="mother_caste_delete">Delete</button>
                                        <?php } ?>
                                </div>
                            </div>                      
                        </div>

                        <!-- Social Category -->
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Social Category<span style="color:red;">*</span></label><br>
                                        <button class="btn btn-warning btn-sm general_btn social_category" type="button" name="General">General</button>
                                        <button class="btn btn-warning btn-sm obc_btn social_category" type="button" name="obc" id="uppyModalOpener_student_social_category">OBC</button>
                                        <button class="btn btn-warning btn-sm sc_btn social_category" type="button" name="sc" id="uppyModalOpener_student_social_category">SC</button>
                                        <button class="btn btn-warning btn-sm st_btn social_category" type="button" name="st" id="uppyModalOpener_student_social_category">ST</button>

                                        

                                        <div id="uppyModalOpener_student_social_category"></div>
                                        <div id="uppyModalOpener_student_social_category_message"></div>
                                        <div class="show_social_category" style="color:green; font-weight: bold; font-size: 18px; text-transform: uppercase;">
                                            <?php 
                                            if ($social_category_name_f != '0') {
                                                echo "Social Category: " . $social_category_name_f;
                                            }
                                        ?>
                                        </div>
                                        <?php 
                                        if (strlen($social_category_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $social_category_doc_f; ?>">
                                            <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $social_category_doc_f; ?>" alt="social categroy doc" class="social_category_doc_f" style="width: 50px; height:50px;">
                                            </a>
                                            <input type="hidden" name="social_category_c" value="<?php echo $social_category_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="social_category_cdelete">Delete</button>
                                        <?php } ?>

                                </div>
                            </div>                      
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Belong to BPL</label><br>
                                            <button class="btn btn-warning btn-sm bpl_btn" type="button" name="No BPL">No</button>
                                            <button class="btn btn-warning btn-sm bpl_btn" type="button" id="uppyModalOpener_student_bpl" name="bpl">Yes</button>                                       
                                            <div id="uppyModalOpener_student_bpl"></div>
                                            <div id="uppyModalOpener_student_bpl_message"></div>

                                            <div class="show_bpl" style="color:green; font-weight: bold; font-size: 18px; text-transform: uppercase;">
                                            <?php 
                                                if (strlen($student_bpl_doc_f) > 1) {
                                                    echo 'BPL: Yes';
                                                } else {
                                                    echo 'BPL: No';
                                                }
                                            ?>
                                            </div>

                                            <?php 
                                        if (strlen($student_bpl_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $student_bpl_doc_f; ?>">
                                                 <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $student_bpl_doc_f; ?>" alt="BPL doc" class="student_bpl_doc_f" style="width: 50px; height:50px;">
                                            </a>

                                            <input type="hidden" name="student_bpl_c" value="<?php echo $student_bpl_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="sostudent_bpldelete">Delete</button>
                                        <?php } ?>
                                            
                                        <!-- <div class="bpl_no">
                                            <h6 style="color:green;">No BPL Card</h6>
                                        </div> -->

                                        
                                </div>
                            </div>                      
                        </div>

                        <!-- Special Category -->
                        <div class="col-md-4">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Special Category</label><br>
                                        <button class="btn btn-warning btn-sm spl_cate" type="button" name="none">None</button>
                                        <button class="btn btn-warning btn-sm spl_cate" type="button" name="Destitute" id="uppyModalOpener_student_special_category">Destitute</button>
                                        <button class="btn btn-warning btn-sm spl_cate" type="button" name="HIV_Case" id="uppyModalOpener_student_special_category">HIV Case</button>
                                        <button class="btn btn-warning btn-sm spl_cate" type="button" name="Orphans" id="uppyModalOpener_student_special_category">Orphans</button>
                                        <button class="btn btn-warning btn-sm spl_cate" type="button" name="Others" id="uppyModalOpener_student_special_category">Others</button>


                                        <div id="uppyModalOpener_student_special_category"></div>
                                        <div id="uppyModalOpener_student_special_category_message"></div>
                                        

                                        <div class="show_special_category" style="color:green; font-weight: bold; font-size: 18px; text-transform: uppercase;">
                                            <?php 
                                                if (strlen($special_category_name_f) > 1) {
                                                    echo "Special Category: " . $special_category_name_f;
                                                } 
                                            ?>
                                            </div>
                                        <?php 
                                        if (strlen($special_category_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $special_category_doc_f; ?>">
                                                <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $special_category_doc_f; ?>" alt="special categroy doc" class="special_category_doc_f" style="width: 50px; height:50px;">
                                            </a>

                                            <input type="hidden" name="special_category_c" value="<?php echo $special_category_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="special_category_delete">Delete</button>
                                        <?php } ?>                                      <!-- <input class="form-control mt-1" type="file" id="formFile" name="father_aadhaar"> -->
                                </div>
                            </div>                      
                        </div>

                        <!-- Bhagyalakshmi Bond -->

                        <div class="col-md-6">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Bhagyalakshmi Bond No.</label>
                                    <button class="btn btn-warning btn-sm bhagya_bond" type="button" id="uppyModalOpener_student_bhagya_lakshmi" name="bhagya">Yes</button>
                                    <button class="btn btn-warning btn-sm bhagya_bond" type="button" name="not applicable">No</button>
                                        <div id="uppyModalOpener_student_bhagya_lakshmi"></div>
                                        <div id="uppyModalOpener_student_bhagya_lakshmi_message"></div> 

                                        <div class="show_bhagya" style="color:green; font-weight: bold; font-size: 18px; text-transform: uppercase;">
                                            <?php 
                                                if (strlen($bhagya_lakshmi_doc_f) > 1) {
                                                    echo "Bhagyalakshmi Bond: Yes";
                                                } else {
                                                    echo 'Not Applicable';
                                                }
                                            ?>
                                            </div>

                                        <?php 
                                        if (strlen($bhagya_lakshmi_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $bhagya_lakshmi_doc_f; ?>">
                                                <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $bhagya_lakshmi_doc_f; ?>" alt="bhagya_lakshmi doc" class="bhagya_lakshmi_doc_f" style="width: 50px; height:50px;">
                                            </a>

                                            <input type="hidden" name="bhagya_bond_c" value="<?php echo $bhagya_lakshmi_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="bhagya_bond_delete">Delete</button>
                                        <?php } ?>  
                                </div>
                            </div>                      
                        </div>

                        <!-- Disability Child-->
                        <div class="col-md-12">
                            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                                <div class="card-body" style="background:#fff;">
                                    <label class="text-dark fw-bold">Disability Child<span style="color:red;">*</span></label><br>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="not applicable">Not Applicable</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="austism" id="uppyModalOpener_student_disability">Austism</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="physically_handicapped" id="uppyModalOpener_student_disability">Physically Handicapped</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="hearing_impartment" id="uppyModalOpener_student_disability">Hearing Impartment</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="learning_disability" id="uppyModalOpener_student_disability">Learning Disability</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="loco_motor" id="uppyModalOpener_student_disability">Loco motor Impartment</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="mental_retardation" id="uppyModalOpener_student_disability">Mental Retardation</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="multiple_disability" id="uppyModalOpener_student_disability">Multiple Disability</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="speech_impairment" id="uppyModalOpener_student_disability">Speech Impairment</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="Visual_Impairment_Blindness" id="uppyModalOpener_student_disability">Visual Impairment(Blindness)</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="Visual_Impairment_low_vision" id="uppyModalOpener_student_disability">Visual Impairment(Low-vision)</button>
                                            <button class="btn btn-outline-info btn-sm austism" type="button" name="cerebral_palsy" id="uppyModalOpener_student_disability">Cerebral palsy</button>

                                            <div id="uppyModalOpener_student_disability"></div>
                                            <div id="uppyModalOpener_student_disability_message"></div>
                                            

                                            <div class="show_disablity" style="color:green; font-weight: bold; font-size: 18px; text-transform: uppercase;">
                                            <?php 
                                                if ($disbalility_name_f != '0') {
                                                echo $disbalility_name_f;
                                                }
                                            ?>
                                            </div>
                                            
                                            <?php 
                                        if (strlen($disabality_doc_f) > 1) { ?>
                                            <a href="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $disabality_doc_f; ?>">
                                                <img src="https://rev-users.s3.ap-south-1.amazonaws.com/<?php echo $disabality_doc_f; ?>" alt="disabality doc" class="disabality_doc_f" style="width: 50px; height:50px;">
                                            </a>

                                            <input type="hidden" name="disabality_c" value="<?php echo $disabality_doc_f; ?>">
                                                <button class="btn btn-primary" type="submit" name="disabality_c_delete">Delete</button>
                                            <!-- <form action="" method="post">
                                                <input type="text" name="disabality_doc" value="<?php echo $disabality_doc_f; ?>">
                                                <button class="btn btn-primary btn-sm" type="submit" name="dis_doc">Delete</button>
                                            </form> -->

                                        <?php } ?>

                                       
                                </div>
                            </div>                                              
                        </div>
                        <div class="col-md-4"></div> 
                            <div class="col-md-4">   
                                <button class="btn btn-primary" type="submit" name="submit" style="width:100%;">Submit</button>
                            </div>
                            <div class="col-md-4"></div>
                    <hr>
                    </form>
                </div>
            </div>  
        <?php } else { ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                       <img src="../sad_cat.png" style="height: 55%" width="70%">
                        <div class="alert alert-danger text-center fw-bold" role="alert">
                          Sorry Admin something went wrong, please try again by clicking the below button
                          <a href="<?php echo BASE_URL; ?>pages/action"><button class="btn btn-success">GO BACK</button></a>
                        </div> 
                    </div>
                </div>
            </div>
            
        <?php } ?>

              


<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>

<script type="text/javascript">
   
    // Disabolity
    $('.austism').click(function() {
        var disablity = $(this).attr('name');
        $('.show_disablity').html(disablity);

        // alert(disablity);
         $.post("disabality_data.php", { data: disablity }).done(function(response) {
            // Handle successful response
            console.log("Success:", response);
          }).fail(function(jqXHR, textStatus, errorThrown) {
            // Handle error
            console.error("Error:", errorThrown);
          });
    })
    // special category
    // var spl_cate = "Initial data";
    $('.spl_cate').click(function() {
        spl_cate = $(this).attr('name');
        $('.show_special_category').html('Special category: ' + spl_cate);
        $.post("special_category_data.php", { data: spl_cate }).done(function(response) {
            // Handle successful response
            console.log("Success:", response);
          }).fail(function(jqXHR, textStatus, errorThrown) {
            // Handle error
            console.error("Error:", errorThrown);
          });
        // alert(spl_cate);
    })

    // alert(spl_cate);

    // social category
    $('.social_category').click(function() {
        var social_category = $(this).attr('name');
        $('.show_social_category').html('Social category: ' + social_category);
         $.post("social_category_data.php", { data: social_category }).done(function(response) {
            // Handle successful response
            console.log("Success:", response);
          }).fail(function(jqXHR, textStatus, errorThrown) {
            // Handle error
            console.error("Error:", errorThrown);
          });
    })

   

    // BPL button
    $('.bpl_btn').click(function() {
        var bpl = $(this).attr('name');
        $('.show_bpl').html("Not Applicable");
        // $('.show_bpl').html(bpl);
        // alert(bpl);
    })

    // Bhagyalakshmi button
    $('.bhagya_bond').click(function() {
        var bhagya_bond = $(this).attr('name');
        $('.show_bhagya').html("Not Applicable");
    })
</script>

<script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_student_disability'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/disablity.php'})
        .use(Compressor);     
       uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_student_disability_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="disabality_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="disabality_c_delete">Delete</button></form>');
            $('.disabality_doc_f').hide();
        });
    </script>

<!-- Special Category -->
    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_student_special_category'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/special_category.php'})
        .use(Compressor);     
       uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_student_special_category_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="special_category_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="special_category_delete">Delete</button></form>');
            $('.special_category_doc_f').hide();
            // $('.show_special_category').html('Special Category:' . );
        });        
    </script>

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_student_social_category'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/social_category.php'})
        .use(Compressor);     
       uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_student_social_category_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="social_category_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="social_category_cdelete">Delete</button></form>');
            $('.social_category_doc_f').hide();

        });
       
    </script>


    <!-- BPL -->

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_student_bpl'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/bpl.php'})
        .use(Compressor);     
       uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_student_bpl_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="student_bpl_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="sostudent_bpldelete">Delete</button></form>');
            $('.student_bpl_doc_f').hide();
            $('.show_bpl').html('BPL: Yes');
        }); 
    </script>


    <!-- Bhagyalakshmi -->

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_student_bhagya_lakshmi'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/bhagya.php'})
        .use(Compressor);     
       uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_student_bhagya_lakshmi_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="bhagya_bond_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="bhagya_bond_delete">Delete</button></form>');
            $('.bhagya_lakshmi_doc_f').hide();
            $('.show_bhagya').html('Bhagyalakshmi Bond: Yes');
        }); 
    </script>


    <!-- Father_aadhaar -->
    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_father_aadhar'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/father_aadhaar.php'})
        .use(Compressor);     
       uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_father_aadhar_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="father_aadhar_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="father_aadhar_delete">Delete</button></form>');
            $('.new_father_aadhar_doc').hide();
        });        
    </script>   



    <!-- Mother aadhar -->

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_mother_aadhar'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/mother_aadhaar.php'})
        .use(Compressor);     
       uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_mother_aadhar_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="mother_aadhar_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="mother_aadhar_delete">Delete</button></form>');
            $('.new_mother_aadhar_doc').hide();
        }); 
    </script>


    <!-- Student aadhar -->

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_student_aadhar'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/student_aadhaar.php'})
        .use(Compressor);     
        uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_student_aadhar_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="student_aadhar_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="student_aadhar_delete">Delete</button></form>');
            $('.new_student_aadhar_doc').hide();
        });      
    </script>


    <!-- DOB certificate -->

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_student_bob'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/student_dob.php'})
        .use(Compressor);     
       uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_student_bob_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="student_dob_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="student_dob_delete">Delete</button></form>');
            $('.student_dob_doc_f').hide();            
        });         
    </script>


    <!-- Father caste -->

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_father_caste_ceritificate'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/father_caste.php'})
        .use(Compressor);     
        uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_father_caste_ceritificate_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="father_caste_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="father_caste_delete">Delete</button></form>');
            $('.father_caste_doc_f').hide(); 
            
        });
       
    </script>

    <!-- Student Caste -->

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_student_caste_ceritificate'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/student_caste.php'})
        .use(Compressor);     
        uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_student_caste_ceritificate_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="student_caste_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="student_caste_delete">Delete</button></form>');
            $('.student_caste_doc_f').hide(); 
        });
       
    </script>


    <!-- Mother caste -->

    <script type="module">
      import {
        Core,
        Uppy,
        Dashboard,
        Webcam,
        XHRUpload,
        Compressor,
      } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false,restrictions: {maxNumberOfFiles: 1, allowedFileTypes: ['image/*']}})
        .use(Dashboard, { trigger: '#uppyModalOpener_mother_caste_ceritificate'})
        .use(Webcam, { target: Dashboard, modes:['picture'] }) 
        .use(XHRUpload, { endpoint: 'https://<?php echo $host; ?>/pages/mother_caste.php'})
        .use(Compressor);     
        uppy.on('upload-success', (file, text) => { 
            var up_img = (text.body);        
            $('#uppyModalOpener_mother_caste_ceritificate_message').html('<a href="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '"><img src="https://rev-users.s3.ap-south-1.amazonaws.com/' + up_img + '" style="width:50px; height:50px;"></a><form action="" method=""><input type="hidden" name="mother_caste_c" value="' + up_img + '"><button class="btn btn-primary btn-sm" type="submit" name="mother_caste_delete">Delete</button></form>');
            $('.mother_caste_doc_f').hide(); 
        });       
    </script>
