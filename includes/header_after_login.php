<?php 
    if (isset($_POST['save'])) {
         $current_pass = mysqli_escape_string($connection, trim($_POST['current_pass']));
         $new_pass = mysqli_escape_string($connection, trim($_POST['new_pass']));
         $new_pass1 = mysqli_escape_string($connection, trim($_POST['new_pass1']));

         if ($current_pass == "" || $new_pass == "" || $new_pass1 == "") {
               $error_messages = "Please fill all the fields";
         }

         if (strlen($new_pass) < 4 || strlen($new_pass) > 10) {
             $error_messages = "Password must be inbetween 4 to 10 characters";
         }

         if (!isset($error_messages)) {
             if ($new_pass == $new_pass1) {
                 
             } else {
                $error_messages = "Both password are not matching";
             }
         }

         if (!isset($error_messages)) {
               $fetch_current_pass = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");

               if (mysqli_num_rows($fetch_current_pass) > 0) {
                   while($gth = mysqli_fetch_assoc($fetch_current_pass)) {
                    $user_c_pass = $gth['rev_teach_pass'];
                   }
               }
               // echo $user_submitted_current = password_hash($current_pass, PASSWORD_DEFAULT);


               if (password_verify($current_pass, $user_c_pass)) {
                   $new_pass_hash = password_hash($current_pass, PASSWORD_DEFAULT);

                    $update_user_with_new_pass = mysqli_query($connection,"UPDATE rev_user_details SET rev_teach_pass = '$new_pass_hash' WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");

                   if (isset($update_user_with_new_pass)) {
                       $success = "Password updated successfully";
                   }
               } else {
                $error_messages = "not mathcing";
               }
           }  
    }
?>

<?php 
    // logo and school name details
    
    $fetch_school_logo_and_name = mysqli_query($connection, "SELECT * FROM rev_erp_user_details");

    if (mysqli_num_rows($fetch_school_logo_and_name) > 0) {
        while($ds = mysqli_fetch_assoc($fetch_school_logo_and_name)) {
            $school_name = $ds['rev_user_school_name'];
            $school_logo = $ds['rev_user_school_logo'];
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $school_name; ?>ERP</title>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Revisewell">
    <meta name="description" content="Revisewell Limitless learning at your finger tips">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <meta property="og:image" content="https://rev-user.s3.ap-south-1.amazonaws.com/7.+Logo+-+Horizontal+(White+BG).png?v=1"/>
    <meta property="og:image:width" content="1200"/>

    <meta property="og:image:height" content="630"/>

    <!-- Favicons -->
    <link href="<?php echo BASE_URL; ?>assets/images/favicon.svg" rel="icon">
    <link href="<?php echo BASE_URL; ?>assets/images/favicon.svg" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/glightbox/css/glightbox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/choices/css/choices.min.css">

    <!-- Theme CSS -->
    <link id="style-switch" rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/mc-datepicker/dist/mc-calendar.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/mc-datepicker/dist/mc-calendar.min.js"></script> 
    <style type="text/css">
        #loading{
            position: fixed;
            width: 100%;
            height: 100vh;
            background: #fff url('../assets/images/loader.gif') no-repeat center;
            z-index: 99999;
        }
    </style>
</head>

<div id="loading"></div>
<header class="navbar-light navbar-sticky">
    <?php 
        if (isset($error_messages)) {
            echo $error_messages;
        }
    ?>    
    <nav class="navbar navbar-expand-lg">
        <div class="container"> 
            <?php 
                if (isset($_SESSION['teach_details'])) { ?>
                    <div class="d-flex justify-content-center">
                       <a href="<?php echo BASE_URL; ?>pages/action" style="display: inline-flex;"><img src="<?php echo $school_logo; ?>" alt="logo_revisewell" height="100px" width="100px;"><span style="font-size:32px; font-weight: bolder; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif; margin-left: 0px;"></span></a>
                    </div>                    
                    <a href="<?php echo BASE_URL; ?>pages/logout"><button class="btn btn-primary float-end">Sign-out</button></a>
            <?php } else { ?>
                    <div class="d-flex justify-content-center">
                       <!-- <a href="<?php echo BASE_URL; ?>pages/action?param=<?php echo $teacher_changed_class; ?>" style="display: inline-flex;"> -->
                        <img src="<?php echo BASE_URL; ?><?php echo $school_logo; ?>" alt="logo_revisewell" height="100px" width="100px;"><span style="font-size:32px; font-weight: bolder; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif; margin-left: 0px;"></span>
                        <!-- </a> -->
                    </div>
            <?php } ?>
        <?php 
            if (isset($_SESSION['teach_details'])) { 
                $user_teach = htmlspecialchars($_SESSION['teach_details'], ENT_QUOTES, 'UTF-8'); 
                $fetch_tec_det = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$user_teach' AND rev_teach_sts = '1'");

                if (mysqli_num_rows($fetch_tec_det) > 0) {
                    while($fre = mysqli_fetch_assoc($fetch_tec_det)) {
                        $t_name = $fre['rev_teach_name'];
                        $t_email = $fre['rev_teach_email'];
                        $t_num = $fre['rev_teach_number'];
						$t_gender = $fre['tree_teacher_gender'];
                    }
                }
                ?>
                
            <?php }    ?>
            
            </div>
            <!-- Profile START -->
    </nav>
    <!-- Logo Nav END -->
</header>
<!-- Header END -->

<!--Edit profile Modal -->
<div class="modal fade" id="staticBackdrop_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="w-100 mt-auto d-inline-flex justify-content-center">
                <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
                    <!-- Avatar -->
                    <div class="avatar avatar-sm me-2 rounded-4">
                        <img class="avatar-img rounded-1" src="../assets/images/id-card.webp" alt="avatar">
                    </div>
                    <!-- Avatar info -->
                    <div>
                        <h6 class="mb-0 text-primary text-center">Contact school admin to update your profile</h6>
                    </div>
                </div>
            </div>
        
            <form class="row align-items-center justify-content-center my-4">
                <div class="col-md-12">
                    <div class="bg-body shadow rounded-3 p-2 mb-2">
                        <div class="input-group">
                            <button type="button" class="btn btn-blue btn-sm mb-0 rounded-3" style="cursor: default;">Name</button>
                            <input class="form-control border-0 me-1" type="text" placeholder="Fetch name here" value="<?php echo $t_name; ?>" Disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="bg-body shadow rounded-3 p-2 mb-2">
                        <div class="input-group">
                            <button type="button" class="btn btn-blue btn-sm mb-0 rounded-3" style="cursor: default;">Number</button>
                            <input class="form-control border-0 me-1" type="number" placeholder="Fetch name here" value="<?php echo $t_num; ?>" Disabled>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Change password Modal -->
<div class="modal fade" id="staticBackdrop_acc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="w-100 mt-auto d-inline-flex justify-content-center">
                <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
                    <!-- Avatar -->
                    <div class="avatar avatar-sm me-2 rounded-4">
                        <img class="avatar-img rounded-1" src="../assets/images/lock.webp" alt="avatar">
                    </div>
                    <!-- Avatar info -->
                    <div>
                        <h6 class="mb-0 text-dark text-center">Change your password</h6>
                    </div>
                </div>
            </div>
        
            <form class="row align-items-center justify-content-center my-4" action="" method="post" autocomplete="off">
                <div class="col-md-12">
                    <div class="bg-body shadow rounded-3 p-2 mb-2">
                        <div class="input-group">
                            <input class="form-control border-0 me-1" type="password" placeholder="Current password" required autocomplete="off" name="current_pass">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="bg-body shadow rounded-3 p-2 mb-2">
                        <div class="input-group">
                            <input class="form-control border-0 me-1" type="password" placeholder="New password" required autocomplete="off" name="new_pass">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="bg-body shadow rounded-3 p-2 mb-2">
                        <div class="input-group">
                            <input class="form-control border-0 me-1" type="password" placeholder="Re-enter password" required autocomplete="off" name="new_pass1">

                        </div>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-center mb-2 mt-2">
                    <button class="btn btn-blue mb-0 submit_field" type="submit" name="save">Save changes</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Help Modal -->
<div class="modal fade" id="staticBackdrop_help" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="w-100 mt-auto d-inline-flex justify-content-center">
                <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
                    <!-- Avatar -->
                    <div class="avatar avatar-sm me-2 rounded-4">
                        <img class="avatar-img rounded-1" src="../assets/images/help.webp" alt="avatar">
                    </div>
                    <!-- Avatar info -->
                    <div>
                        <h6 class="mb-0 text-dark text-center">We're here to help!</h6>
                    </div>
                </div>
            </div>
        
            <div class="col-md-12">
                <div class="card card-body bg-transparent shadow text-center h-100 btn-transition">
                    <!-- Title -->
                    <img class="mb-2" src="../assets/images/building.svg" alt="">
                    <h5 class="mb-4 text-dark">Office Address</h5>
                    <div class="row">

                    <!-- Location box -->
                    <div class="col-sm-12 col-lg-12 col-xl-12 mb-5 mb-xl-12">
                        <div class="card card-body shadow btn-transition">
                            <div class="icon-lg bg-orange text-white rounded-circle position-absolute top-0 start-100 translate-middle">
                                <i class="fas fa-location-arrow"></i>
                            </div>
                            <h6>Location</h6>

                            <p class="mb-0">
                                <a href="https://goo.gl/maps/V3mw1Up1T6F2GPA48" target="_blank" class="text-primary" style="font-weight: bold">1st Floor, Maya Tower, <br>Opp. Parvathi Nagar 2nd Cross, <br>Talur Rd, Ballari - 583101 KA IN<br>
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Working hours box -->
                    <div class="col-sm-6 col-lg-12 col-xl-6 mb-4">
                        <div class="card card-body shadow btn-transition">
                            <div class="icon-lg bg-success text-white rounded-circle position-absolute top-0 start-100 translate-middle">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h6>Open Hours</h6>
                            <p class="mb-0 text-primary" style="font-weight: bold;">Monday - Saturday</p>
                            <p class="mb-0 text-primary" style="font-weight: bold;">10:00AM - 06:00PM</p>
                        </div>
                    </div>

                    <!-- Telephone box -->
                    <div class="col-sm-6 col-lg-12 col-xl-6 mb-4">
                        <div class="card card-body shadow btn-transition">
                            <div class="icon-lg bg-purple text-white rounded-circle position-absolute top-0 start-100 translate-middle">
                                <i class="fas fa-tty"></i>
                            </div>
                            <h6>Telephone</h6>
                            <p class="mb-0"><a href="tel:73378 77778" class="text-primary" style="font-weight: bold;">+91 73378 77778</a></p><br>
                        </div>
                    </div>

                    <!-- Email box -->
                    <div class="d-flex justify-content-center">
                        <div class="col-sm-6 col-lg-12 col-xl-6 mb-5">
                            <div class="card card-body shadow mt-3 btn-transition">
                                <div class="icon-lg bg-warning text-white rounded-circle position-absolute top-0 start-100 translate-middle">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h6>Write us a note</h6>
                                <p class="mb-0"><a href="mailto:info@revisewell.com" class="text-primary" style="font-weight: bold;">info@revisewell.com</a></p>
                            </div>
                        </div>
                    </div>

                </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Sign out Modal -->
<div class="modal fade" id="staticBackdrop_sign" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="w-100 mt-auto d-flex justify-content-center">
                <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
                    <!-- Avatar -->
                    <div class="avatar avatar-sm me-2 rounded-4">
                        <img class="avatar-img rounded-1" src="../assets/images/sign-out.webp" alt="avatar">
                    </div>
                    <!-- Avatar info -->
                    <div>
                        <h6 class="mb-0 text-dark text-center">Signing out Revisewell already?<br>
                        There's so much to explore!</h6>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success-soft" data-bs-dismiss="modal">I'll stay</button>
            <a href="<?php echo BASE_URL; ?>pages/logout"><button type="button" class="btn btn-danger-soft" data-bs-dismiss="modal">I'll leave</button></a>
        </div>
      </div>
    </div>
  </div>
</div>
<main>

    <body onload="loadfun()" class="body" style="font-family: Nunito Sans;">

        
        