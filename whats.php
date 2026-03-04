<?php require 'includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<?php 
  if (isset($_GET['id'])) {
    if ($_GET['id'] != "") {
       $user_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
     } else {
      header("Location: " . BASE_URL . 'register');
     }
  } else {
      header("Location: " . BASE_URL . 'register');
    }
 
  if (isset($_POST['validate'])) {
    $user_entered_otp = mysqli_escape_string($connection, trim($_POST['e_otp']));

    if ($user_entered_otp == "") {
      $error_message = "Please enter 6 digit OTP";
    }

    if (!isset($error_message)) {
       $check_otp_sts = mysqli_query($connection,"SELECT * FROM mcq_academy_user_data WHERE mcq_whats = '$user_id' AND mcq_otp = '$user_entered_otp' AND mcq_sts = '1'");

       if (mysqli_num_rows($check_otp_sts) > 0) {
         $update_otp_code = mysqli_query($connection,"UPDATE mcq_academy_user_data SET mcq_otp = '' WHERE mcq_whats = '$user_id' AND mcq_sts = '1'");
         $_SESSION['user_login'] = $user_id;
         header('Location: ' . BASE_URL . 'dash?');
       } else {
        $error_message = "Invalid OTP";
       }
    }
  }  
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<?php   
       $fetch_otp = mysqli_query($connection, "SELECT * FROM mcq_academy_user_data WHERE mcq_whats = '$user_id' AND mcq_sts = '1'");

        if (mysqli_num_rows($fetch_otp) > 0) {
          while($ro = mysqli_fetch_assoc($fetch_otp)) {
            $user_gen_otp = htmlspecialchars($ro['mcq_otp'], ENT_QUOTES, 'UTF-8');
          } 
        }

        $otp_to_login = "OTP to login " . $user_gen_otp; ?>

    <script type="text/javascript">
          var settings = {
          "async": true,
          "crossDomain": true,
          "url": "https://api.ultramsg.com/instance26587/messages/chat",
          "method": "POST",
          "headers": {},
          "data": {
            "token": "wq6wqj6ky4or8oy7",
            "to": "+91<?php echo $user_id; ?>",
            "body": "<?php echo $otp_to_login; ?>" 
          }
        }
        $.ajax(settings).done(function (response) {
          console.log(response);
        });
    </script>
     
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign in | Revisewell</title>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Webestica.com">
  <meta name="description" content="Eduport- LMS, Education and Course Theme">

  <!-- Favicons -->
  <link href="assets/images/favicon.svg" rel="icon">
  <link href="assets/images/favicon.svg" rel="icon">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/a2bc8eeb47.js" crossorigin="anonymous"></script>


  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">

  <!-- Plugins CSS -->
  <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <!-- Theme CSS -->
  <link id="style-switch" rel="stylesheet" type="text/css" href="assets/css/style.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <style type="text/css">
    .togglePassword{
        margin-left: -30px;
        cursor: pointer;
    }
    .togglePassword1{
        margin-left: -30px;
        cursor: pointer;
    }    
  </style>

  <style type="text/css">
    .base-timer {
      position: relative;
      width: 80px;
      height: 80px;
    }

    .base-timer__svg {
      transform: scaleX(-1);
    }

    .base-timer__circle {
      fill: none;
      stroke: none;
    }

    .base-timer__path-elapsed {
      stroke-width: 7px;
      stroke: grey;
    }

    .base-timer__path-remaining {
      stroke-width: 7px;
      stroke-linecap: round;
      transform: rotate(90deg);
      transform-origin: center;
      transition: 1s linear all;
      fill-rule: nonzero;
      stroke: currentColor;
    }

    .base-timer__path-remaining.blue {
      color: #3F7FCA;
    }

    .base-timer__path-remaining.orange {
      color: orange;
    }

    .base-timer__path-remaining.red {
      color: red;
    }

    .base-timer__label {
      position: absolute;
      width: 80px;
      height: 80px;
      top: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 25px;
    }
    </style>

    <script>
      let mode = window.localStorage.getItem('mode'),
          root = document.getElementsByTagName('html')[0];
      if (mode !== undefined && mode === 'dark') {
        root.classList.add('dark-mode');
      } else {
        root.classList.remove('dark-mode');
      }
    </script>

    <script>
      (function () {
        window.onload = function () {
          const preloader = document.querySelector('.page-loading');
          preloader.classList.remove('active');
          setTimeout(function () {
            preloader.remove();
          }, 1500);
        };
      })();      
    </script>
</head>

<!-- Header START -->
<header class="navbar-light navbar-sticky">
  <!-- Logo Nav START -->
  <nav class="navbar navbar-expand-lg">
    <div class="container d-flex justify-content-center">
      <!-- Logo START -->
      <a href="index.php" style="display: inline-flex;"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px;"><span style="font-size:32px; font-weight: bolder; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif; margin-left: -20px;">Revisewell</span></a>
      <!-- Logo END -->

    </div>
  </nav>
  <!-- Logo Nav END -->
</header>
<body>
<main>
  <section class="p-0 position-relative overflow-hidden"> 
    <div class="d-flex flex-column position-relative h-100 pt-5">
        <div class="container" style="margin-top: 80px">
          <div class="row align-items-center">
            <div class="col-md-12 col-xl-12 d-flex justify-content-center">
              <div class="ps-md-3 ps-lg-5 ps-xl-0">
                <h2 class="h2 pb-2 pb-lg-3 text-center"><img src="assets/images/OTP.svg" width="45" height="45" alt="OTP">&nbsp;Enter OTP</h2>
                <p style="text-align: center; font-weight: bold; font-size: 14px; color: #8e9eab;">Enter OTP received to given WhatsApp number</p>
                  <div class="alert alert-info text-center" style="font-weight: bold;" role="alert">
                    OTP sent successfully <i class="fas fa-check"></i>
                  </div>
                  <div class="wait" style="display: inline-flex;">
                    <p style="text-align: center; font-weight: bold; font-size: 14px;" class="text-danger">
                      *Please wait for <span id="app" class="d-flex justify-content-center" style="color: #3F7FCA"></span> seconds to re-initiate OTP if not received*
                    </p>                    
                  </div>

                  <?php 
                  if (isset($error_message)) { ?>
                    <div class="alert alert-danger text-center" role="alert">
                      <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                    </div>                   
                  <?php } ?>
                  
                  <form class="needs-validation" novalidate action="" method="post">
                    <div class="password-toggle mb-4">
                      <div class="position-relative">
                        <img class="fs-lg position-absolute top-50 start-0 translate-middle-y ms-3" src="assets/images/whatsapp.svg" width="25" alt="Whatsapp">
                        <input class="form-control form-control-lg ps-5" type="number" placeholder="Enter OTP" required name="e_otp">
                      </div>
                    </div>
                    <a style="text-align: center; font-weight: bold; font-size: 15px; text-decoration: none; float: right; cursor: pointer;" class="text-info mb-4 mt-2 resend" href="<?php echo BASE_URL; ?>whats?id=<?php echo $user_id; ?>">Resend OTP</a>
                    <button class="btn btn-info w-50 mb-4" style="float: left" name="validate">Validate</button>
                  </form>
              </div>
            </div>          
          </div>
        </div>
      </div>  
  </section>
</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- =======================
Footer START -->
<footer class="pt-5">
  <div class="container">
    <!-- Row START -->
    <div class="row justify-content-center">

      <!-- Widget 1 START -->
      <div class="col-lg-3">
        <!-- logo -->
        <a href="index.php" style="display: inline-flex;"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px;"><span style="font-size:32px; font-weight: bolder; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif; margin-left: -20px;">Revisewell</span></a>
        <!-- Social media icon -->
        <ul class="list-inline mb-0 mt-3">
          <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-youtube" href="https://www.youtube.com/channel/UCYEg01BNvUOkOGQLmSDoUAA" target="_blank"><i class="fab fa-fw fa-youtube"></i></a> </li>
          <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-facebook" href="https://www.facebook.com/revisewelllearnerapp/" target="_blank"><i class="fab fa-fw fa-facebook-f"></i></a> </li>
          <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-instagram" href="https://www.instagram.com/revisewell_learner_app/?utm_medium=copy_link" target="_blank"><i class="fab fa-fw fa-instagram" target="_blank"></i></a> </li>
          <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-linkedin" href="https://www.linkedin.com/in/revisewell-edtech/" target="_blank"><i class="fab fa-fw fa-linkedin-in"></i></a></li>
          <li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-twitter" href="https://twitter.com/revisewell?t=Pe1sxFxPdWEOJ6eJZ72eaQ&s=08" target="_blank"><i class="fab fa-fw fa-twitter"></i></a></li>
        </ul>
      </div>

    <!-- Divider -->
    <hr class="mt-4 mb-0">

    <!-- Bottom footer -->
    <div class="py-3">
      <div class="container px-0">
        <div class="d-lg-flex justify-content-between align-items-center py-3 text-center text-md-left">
          <!-- copyright text -->
          <div class="text-primary-hover"> Copyrights <a href="#" class="text-body">©2023 Hillspeak Internet Pvt Ltd.</a> All rights reserved </div>
          <!-- copyright links-->
          <div class="justify-content-center mt-3 mt-lg-0">
            <ul class="nav list-inline justify-content-center mb-0">
              <li class="list-inline-item"><a class="nav-link" href="about.html">About</a></li>
              <li class="list-inline-item"><a class="nav-link" href="terms.html">Terms of use</a></li>
              <li class="list-inline-item"><a class="nav-link pe-0" href="privacypolicy.html">Privacy policy</a></li>
              <li class="list-inline-item"><a class="nav-link pe-0" href="refund.html">Refund &amp; Cancellation</a></li>
              <li class="list-inline-item"><a class="nav-link pe-0" href="index.php#Contact">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</footer>

<!-- =======================
Footer END -->

<!-- Back to top -->
<div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Template Functions -->
<script src="assets/js/functions.js"></script>

<!-- <script>

        $('.loading_msg').hide(); 
        $('.loading').click(function() {
          $('.loading').hide();
          $('.loading_msg').show();   
        });
        
</script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
          $("#signup").hide();
        });

      $("#signup-btn").click(function(){
        $("#signup").show();
        $("#signin").hide();
      });

      $("#signin-btn").click(function(){
        $("#signup").hide();
        $("#signin").show();
      });

      $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
          $(".alert-success").slideUp(500);
      });

    </script>    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
        // $(".wait").hide();
        $(".resend").hide();
      });
      // Credit: Mateusz Rybczonec

      const FULL_DASH_ARRAY = 283;
      const WARNING_THRESHOLD = 10;
      const ALERT_THRESHOLD = 5;

      const COLOR_CODES = {
        info: {
          color: "blue"
        },
        warning: {
          color: "orange",
          threshold: WARNING_THRESHOLD
        },
        alert: {
          color: "red",
          threshold: ALERT_THRESHOLD
        }
      };

      const TIME_LIMIT = 30;
      let timePassed = 0;
      let timeLeft = TIME_LIMIT;
      let timerInterval = null;
      let remainingPathColor = COLOR_CODES.info.color;

      document.getElementById("app").innerHTML = `
      <div class="base-timer">
        <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
          <g class="base-timer__circle">
            <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
            <path
              id="base-timer-path-remaining"
              stroke-dasharray="283"
              class="base-timer__path-remaining ${remainingPathColor}"
              d="
                M 50, 50
                m -45, 0
                a 45,45 0 1,0 90,0
                a 45,45 0 1,0 -90,0
              "
            ></path>
          </g>
        </svg>
        <span id="base-timer-label" class="base-timer__label">${formatTime(
          timeLeft
        )}</span>
      </div>
      `;

      startTimer();

      function onTimesUp() {
        clearInterval(timerInterval);
      }

      function startTimer() {
        timerInterval = setInterval(() => {
          timePassed = timePassed += 1;
          timeLeft = TIME_LIMIT - timePassed;
          document.getElementById("base-timer-label").innerHTML = formatTime(
            timeLeft
          );
          setCircleDasharray();
          setRemainingPathColor(timeLeft);

          if (timeLeft === 0) {
            onTimesUp();
            $(".wait").hide('slow');
            $(".resend").show('slow');
          }
        }, 1000);
      }

      function formatTime(time) {
        const minutes = Math.floor(time / 60);
        let seconds = time % 60;

        if (seconds < 10) {
          seconds = `0${seconds}`;
        }

        return `${minutes}:${seconds}`;
      }

      function setRemainingPathColor(timeLeft) {
        const { alert, warning, info } = COLOR_CODES;
        if (timeLeft <= alert.threshold) {
          document
            .getElementById("base-timer-path-remaining")
            .classList.remove(warning.color);
          document
            .getElementById("base-timer-path-remaining")
            .classList.add(alert.color);
        } else if (timeLeft <= warning.threshold) {
          document
            .getElementById("base-timer-path-remaining")
            .classList.remove(info.color);
          document
            .getElementById("base-timer-path-remaining")
            .classList.add(warning.color);
        }
      }

      function calculateTimeFraction() {
        const rawTimeFraction = timeLeft / TIME_LIMIT;
        return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
      }

      function setCircleDasharray() {
        const circleDasharray = `${(
          calculateTimeFraction() * FULL_DASH_ARRAY
        ).toFixed(0)} 283`;
        document
          .getElementById("base-timer-path-remaining")
          .setAttribute("stroke-dasharray", circleDasharray);
      }

    </script>

</body>
</html>