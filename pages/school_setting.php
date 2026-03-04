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
    // echo "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'";
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_erp_user_details WHERE rev_user_id = '$teacher_email_id' AND rev_user_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_user_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $school_id = htmlspecialchars($i['tree_id'], ENT_QUOTES, 'UTF-8');
            $school_name = htmlspecialchars($i['rev_user_school_name'], ENT_QUOTES, 'UTF-8');
            $school_hm_s = htmlspecialchars($i['rev_hm_name'], ENT_QUOTES, 'UTF-8');
            $school_number = htmlspecialchars($i['rev_user_school_number'], ENT_QUOTES, 'UTF-8');
            $school_address = htmlspecialchars($i['rev_user_school_address'], ENT_QUOTES, 'UTF-8');
            $school_logo = htmlspecialchars($i['rev_user_school_logo'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>


<?php 
  if (!isset($_SESSION['academic_setter'])) {
    $_SESSION['academic_setter'] = '2025_26';
  }
?>
<!-- Php code -->


<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve form data
    $schoolName = mysqli_real_escape_string($connection, $_POST['schoolName']);
    $ownerName = mysqli_real_escape_string($connection, $_POST['ownerName']);
    $ownerNumber = mysqli_real_escape_string($connection, $_POST['ownerNumber']);
    $schoolAddress = mysqli_real_escape_string($connection, $_POST['schoolAddress']);
    $school_hm = mysqli_real_escape_string($connection, $_POST['ownerName']);

    if ($schoolName == "" || $ownerName == "" || $ownerNumber == "" || $schoolAddress == "" || $school_hm == "") {
        $error_message = "Please fill all the fields";
    }

    if (!isset($error_message)) {
        // Handle file upload
        if (isset($_FILES['schoolImage']) && $_FILES['schoolImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/'; // Folder to store uploaded images
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create the folder if it doesn't exist
            }

            $fileInfo = pathinfo($_FILES['schoolImage']['name']);
            $uniqueFileName = uniqid('school_', true) . '.' . $fileInfo['extension']; // Generate unique name
            $filePath = $uniqueFileName;

            // Move the uploaded file to the uploads folder
            if (move_uploaded_file($_FILES['schoolImage']['tmp_name'], $filePath)) {
                // echo "File uploaded successfully: " . $uniqueFileName;
            } else {
                die("Error uploading file.");
            }
        } else {
            die("No file uploaded or there was an error.");
        }

        // Insert data into the database
        $update = "UPDATE rev_erp_user_details SET rev_user_school_name = '$schoolName', rev_user_school_address = '$schoolAddress', rev_user_school_logo = '$filePath', rev_user_school_number = '$ownerNumber', rev_hm_name = '$ownerName'";

        if (mysqli_query($connection, $update)) {
            $successMessage = "School details saved successfully!";
        } 
        }
    }

    
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<style type="text/css">
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            text-align: center;
            padding: 20px;
            border-bottom: none;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.5);
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(106, 17, 203, 0.4);
        }
        .file-upload {
            position: relative;
            overflow: hidden;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .file-upload:hover {
            background: #e9ecef;
        }
        .file-upload input[type="file"] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
        .file-upload-label {
            display: block;
            font-size: 14px;
            color: #666;
        }
        .file-upload-icon {
            font-size: 24px;
            color: #6a11cb;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-white"><i class="fas fa-school"></i> School Details</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($successMessage)): ?>
                            <div class="alert alert-success"><?php echo $successMessage; ?></div>
                        <?php endif; ?>
                        <?php if (isset($errorMessage)): ?>
                            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                        <?php endif; ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <!-- School Name -->
                            <div class="mb-4">
                                <label for="schoolName" class="form-label">School Name</label>
                                <input type="text" class="form-control" id="schoolName" name="schoolName" placeholder="Enter School Name" value="<?php echo $school_name; ?>" required>
                            </div>

                            <!-- School Owner Name -->
                            <div class="mb-4">
                                <label for="ownerName" class="form-label">HM Name</label>
                                <input type="text" class="form-control" id="ownerName" name="ownerName" placeholder="Enter HM Name" value="<?php echo $school_hm_s; ?>" required>
                            </div>

                            <!-- School Owner Number -->
                            <div class="mb-4">
                                <label for="ownerNumber" class="form-label">School Number</label>
                                <input type="text" class="form-control" id="ownerNumber" name="ownerNumber" placeholder="Enter School Number" value="<?php echo $school_number; ?>" required>
                            </div>

                            <!-- School Address -->
                            <div class="mb-4">
                                <label for="schoolAddress" class="form-label">School Address</label>
                                <textarea class="form-control" id="schoolAddress" name="schoolAddress" rows="3" placeholder="Enter School Address" required><?php echo $school_address; ?></textarea>
                            </div>

                            <!-- Upload School Image -->
                            <div class="mb-4">
                                <label for="schoolImage" class="form-label">Upload School Image</label>
                                <input type="file" class="form-control" id="schoolImage" name="schoolImage" accept="image/*" required>

                                <?php 
                                    if (strlen($school_logo) > 2) { ?>
                                        <a href="<?php echo $school_logo; ?>"><img src="<?php echo $school_logo; ?>" width="50px" height="50px" target="_blank"></a>
                                    <?php } ?>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>