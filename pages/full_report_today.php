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
     $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");
     if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_teach_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>

<?php 
  if (isset($_GET['st_date'])) {
    if ($_GET['st_date'] != "") {
       $start_date = htmlspecialchars($_GET['st_date'], ENT_QUOTES, 'UTF-8');
     }else {
      header("Location: " . BASE_URL . 'pages/action');
     } 
  }else {
    header("Location: " . BASE_URL . 'pages/action');
  }
?>

<?php 
  if (isset($_GET['et_date'])) {
    if ($_GET['et_date'] != "") {
       $end_date = htmlspecialchars($_GET['et_date'], ENT_QUOTES, 'UTF-8');
     }else {
      header("Location: " . BASE_URL . 'pages/action');
     } 
  }else {
    header("Location: " . BASE_URL . 'pages/action');
  }
?>

<?php 
  if (isset($_GET['id'])) {
    if ($_GET['id'] != "") {
      $user_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    } else {
      header("Location: " . BASE_URL . 'pages/action');
     } 
  } else {
      header("Location: " . BASE_URL . 'pages/action');
     }
?>

<?php 
   $fetch_all_details = mysqli_query($connection, "SELECT * FROM app_time_spent WHERE user_id = '$user_id' AND user_date between '$start_date' AND '$end_date'");

  if (mysqli_num_rows($fetch_all_details) > 0) {
    while($fr = mysqli_fetch_assoc($fetch_all_details)) {
      $timer = $fr['user_spent_time'];
    } 
  }
?>

<?php 
  $fetch_student_details = mysqli_query($connection, "SELECT * FROM rev_student_login WHERE rev_student_id = '$user_id' AND rev_student_sts = '1'");

  if (mysqli_num_rows($fetch_student_details) > 0) {
    while($k = mysqli_fetch_assoc($fetch_student_details)) {
      $student_class = htmlspecialchars($k['rev_student_class'], ENT_QUOTES, 'UTF-8');
      $student_name = htmlspecialchars($k['rev_student_name'], ENT_QUOTES, 'UTF-8');
      $student_school = htmlspecialchars($k['rev_student_sch'], ENT_QUOTES, 'UTF-8');
    } 
  }
?>

<?php 
   $fetch_total_hw = mysqli_query($connection,"SELECT * FROM rev_list_of_student_uploaded WHERE rev_student_id = '$user_id' AND rev_system_date between '$start_date' AND '$end_date' AND rev_student_sts = '1'");

   $total_hw = mysqli_num_rows($fetch_total_hw);
?>

<?php 
   $fetch_total_test = mysqli_query($connection,"SELECT * FROM rev_list_of_student_test_submitted WHERE rev_student_id = '$user_id' AND rev_system_date between '$start_date' AND '$end_date' AND rev_student_sts = '1'");

  $total_test = mysqli_num_rows($fetch_total_test);
?>

<?php 
  //  $fetch_total_test = mysqli_query($connection,"SELECT * FROM rev_list_of_student_uploaded WHERE rev_student_id = '$user_id' AND rev_system_date between '$start_date' AND '$end_date'");

  // $total_hw = mysqli_num_rows($fetch_total_hw);


  $fetch_total_mcq = mysqli_query($connection, "SELECT * FROM rev_student_mcq_submitted_list WHERE rev_student_id = '$user_id' AND mcq_system_date between '$start_date' AND '$end_date'");

  $total_mcq = mysqli_num_rows($fetch_total_mcq);
?>

<?php 
  $fetch_video_watched_count = mysqli_query($connection, "SELECT * FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
  $video_count = mysqli_num_rows($fetch_video_watched_count);

?>

<?php 
  $calculation = $total_hw + $total_mcq + $total_test;

  $total_cal = $calculation / 100;
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <style>      
      #radial_chart {
        padding: 0;
        max-width: 650px;
        margin: 35px auto;
      }

      #columnChart {
        padding: 0;
        max-width: 650px;
        margin: 35px auto ;
      }
      
      .apexcharts-legend text {
        font-weight: 900;
      }      
    </style>

    <script>
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
        )
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    

    <script>
      // Replace Math.random() with a pseudo-random number generator to get reproducible results in e2e tests
      // Based on https://gist.github.com/blixt/f17b47c62508be59987b
      var _seed = 42;
      Math.random = function() {
        _seed = _seed * 16807 % 2147483647;
        return (_seed - 1) / 2147483646;
      };
    </script>
<!-- =======================
Main Banner START -->

<div class="container zindex-100 desk" style="margin-top: 10px">
  <div class="row">
    <div style="float: left;">
       <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>       
    </div>
  </div>
</div>

<div class="container">
    <div class="row d-lg-flex justify-content-lg-between">
      <div class="col-md-12 position-relative text-center">
        <div class="col-md-12 col-sm-12 col-xs-12 mt-5 mt-lg-0 mb-4">
                <div class="bg-body bg-opacity-10 shadow p-4 rounded-3  position-relative">                
                <div class="row g-2">
                    
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="d-flex align-items-center">
                            <div class="icon-md fs-5 text-white bg-orange rounded">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="" style="margin-left: 10px; text-align:left">
                                <h6 class="mb-0">Student name -</h6>
                                <div class="fw-bold text-primary"><?php echo ucfirst($student_name); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Item -->
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="d-flex align-items-center">
                            <div class="icon-md fs-5 text-white bg-info rounded">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="" style="margin-left: 10px; text-align:left">
                                <h6 class="mb-0">Date -</h6>
                                <div class="fw-bold text-primary"><?php echo date('d-M-Y', strtotime($start_date)); ?> to <?php echo date('d-M-Y', strtotime($end_date)); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="d-flex mb-lg-0 align-items-center">
                            <div class="icon-md fs-5 text-white bg-success rounded">
                                <i class="fas fa-hourglass-start"></i>
                            </div>
                            <div class="" style="margin-left: 10px; text-align:left">
                                <h6 class="mb-0">Total time spent -</h6>
                                <div class="fw-bold text-primary"><?php 
                                    if ($timer == "") {
                                      echo $timer = '0 Mins';
                                    } else {
                                      echo round($timer/60) . ' Mins';
                                    }
                                ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="d-flex mb-lg-0 align-items-center">
                            <div class="icon-md fs-5 text-white bg-purple rounded">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="" style="margin-left: 10px; text-align:left">
                                <h6 class="mb-0">Video streamed -</h6>
                                <div class="fw-bold text-primary"><?php echo $video_count; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Item -->
                    <!-- <div class="col-md-12 col-sm-12 col-xs-12 d-sm-flex justify-content-center">
                        <div class="d-flex mb-lg-0 align-items-center">
                            <div class="icon-md fs-5 text-white bg-purple rounded">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="" style="margin-left: 10px; text-align:left">
                                <h6 class="mb-0">Videos streamed -</h6>
                                <div class="fw-bold text-primary">2</div>
                            </div>
                        </div>
                    </div> -->
                </div> <!-- Row END -->
            </div>
       </div>
  </div>
</div>
</div>

<!-- <div class="container">
  <div class="row">
    
  </div>
</div> -->



<!-- =======================
Action box START-->

    <div class="container">
      <div class="row">
        <div class="d-flex justify-content-end mb-2">
              <a href="moredetails_report?id=<?php echo $user_id; ?>&st_date=<?php echo $start_date; ?>&et_date=<?php echo $end_date; ?>"><button class="btn btn-info-soft btn-sm"><span><img class="" src="../assets/images/view_detailed_report_1.svg" alt="Detail report" height="40px" width="40px"></span>&nbsp;&nbsp;View detailed report</button></a>
        </div>
        <div class="col-12">

          <div class="bg-light p-3 p-sm-3 rounded-3 position-relative overflow-hidden" style="margin-bottom: -100px">
            <!-- SVG decoration -->
            <figure class="position-absolute top-0 start-0 d-none d-lg-block ms-n7">
              <svg width="294.5px" height="261.6px" viewBox="0 0 294.5 261.6" style="enable-background:new 0 0 294.5 261.6;">
                <path class="fill-warning opacity-5" d="M280.7,84.9c-4.6-9.5-10.1-18.6-16.4-27.2c-18.4-25.2-44.9-45.3-76-54.2c-31.7-9.1-67.7-0.2-93.1,21.6 C82,36.4,71.9,50.6,65.4,66.3c-4.6,11.1-9.5,22.3-17.2,31.8c-6.8,8.3-15.6,15-22.8,23C10.4,137.6-0.1,157.2,0,179 c0.1,28,11.4,64.6,40.4,76.7c23.9,10,50.7-3.1,75.4-4.7c23.1-1.5,43.1,10.4,65.5,10.6c53.4,0.6,97.8-42,109.7-90.4 C298.5,140.9,293.4,111.5,280.7,84.9z"></path>
              </svg>
            </figure>
            <!-- SVG decoration -->
            <figure class="position-absolute top-50 start-50 translate-middle">
              <svg width="453px" height="211px">
                <path class="fill-orange" d="M16.002,8.001 C16.002,12.420 12.420,16.002 8.001,16.002 C3.582,16.002 -0.000,12.420 -0.000,8.001 C-0.000,3.582 3.582,-0.000 8.001,-0.000 C12.420,-0.000 16.002,3.582 16.002,8.001 Z"></path>
                <path class="fill-warning" d="M176.227,203.296 C176.227,207.326 172.819,210.593 168.614,210.593 C164.409,210.593 161.000,207.326 161.000,203.296 C161.000,199.266 164.409,196.000 168.614,196.000 C172.819,196.000 176.227,199.266 176.227,203.296 Z"></path>
                <path class="fill-primary" d="M453.002,65.001 C453.002,69.420 449.420,73.002 445.001,73.002 C440.582,73.002 437.000,69.420 437.000,65.001 C437.000,60.582 440.582,57.000 445.001,57.000 C449.420,57.000 453.002,60.582 453.002,65.001 Z"></path>
              </svg>
            </figure>
            <!-- SVG decoration -->
            <figure class="position-absolute top-0 end-0 mt-5 me-n5 d-none d-sm-block">
              <svg width="285px" height="272px">
                <path class="fill-info opacity-4" d="M142.500,-0.000 C221.200,-0.000 285.000,60.889 285.000,136.000 C285.000,211.111 221.200,272.000 142.500,272.000 C63.799,272.000 -0.000,211.111 -0.000,136.000 C-0.000,60.889 63.799,-0.000 142.500,-0.000 Z"></path>
              </svg>
            </figure>

            <div class="col-11 mx-auto position-relative">
              <div class="row align-items-center">
                <!-- Title -->
                <!-- <div class="col-lg-12">
                  <h3>Revisewell wishes you luck, inspiration and new discoveries!</h3>
                  <p class="mb-3 mb-lg-0">Speedily say has suitable disposal add boy. On forth doubt miles of child. Exercise joy man children rejoiced.</p>
                </div> -->
                <!-- Counter boxes START -->
                  <div class="row d-flex justify-content-center">
                    <!-- Counter item -->
                    <div class="col-md-6">
                      <div class="d-flex justify-content-center align-items-center p-4 bg-primary bg-opacity-15 rounded-3 btn-transition">
                        <span class="display-6 lh-1 text-primary mb-0"><i class="far fa-clock"></i></span>
                        <div class="ms-4">
                          <div class="d-flex">
                            <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="500" data-purecounter-delay="300"><?php 
                            $seconds = round($timer/60);
                                                $d = floor($seconds/86400); 
                                                $H = floor($seconds / 3600);
                                                $i = floor(($seconds / 60) % 60);
                                                $s = $seconds % 60;                                                     
                             ?></h5>
                            <span class="fw-bold text-dark" style="margin-top: 3px;">&nbsp;<?php echo round($timer/60); ?> Mins</span>
                          </div>
                          <p class="mb-0 h6 fw-light">Total time spent on Revisewell App</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-4 d-flex justify-content-center">
                    <!-- Counter item -->
                    <!-- <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
                      <div class="d-flex justify-content-center align-items-center p-4 bg-success bg-opacity-15 rounded-3 btn-transition">
                        <span class="display-6 lh-1 text-success mb-0"><i class="fas fa-medal fa-fw"></i></span>
                        <div class="ms-4">
                          <div class="d-flex">
                            <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="500" data-purecounter-delay="300">500</h5>
                          </div>
                          <p class="mb-0 h6 fw-light">Achieved Points</p>
                        </div>
                      </div>
                    </div> -->

                    <!-- Counter item -->
                    <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
                      <div class="d-flex justify-content-center align-items-center p-4 bg-purple bg-opacity-15 rounded-3 btn-transition h-100">
                        <span class="display-6 lh-1 text-purple mb-0"><i class="fas fa-clipboard-check fa-fw"></i></span>
                        <div class="ms-4">
                          <div class="d-flex">
                            <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="10" data-purecounter-delay="200">
                              <?php 
                                $fetch_video_stream = mysqli_query($connection, "SELECT SUM(rev_user_time) AS value_sum FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_user_date between '$start_date' AND '$end_date'");
                                  $row = mysqli_fetch_assoc($fetch_video_stream); 
                                  $sum = htmlspecialchars($row['value_sum'], ENT_QUOTES, 'UTF-8');

                                // if ($sum == '') {
                                  //echo $sum = '0';
                                // } else {
                                  //echo $sum;
                                // }
                                echo $video_count;
                              ?>
                            </h5>
                          </div>
                          <p class="mb-0 h6 fw-light">Videos streamed</p>
                        </div>
                      </div>
                    </div>                    
                    
                    <?php 
                      if ($total_cal != '0') { ?>
                        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
                          <div class="d-flex justify-content-center align-items-center p-4 bg-orange bg-opacity-15 rounded-3 btn-transition h-100">
                            <span class="display-6 lh-1 text-orange mb-0"><i class="fas fa-graduation-cap"></i></span>
                            <div class="ms-4">
                              <p class="mb-0 h6 fw-light">Evaluation - </p>
                              <div class="d-flex">
                                <?php 
                                  if ($total_cal >= '50') { ?>
                                    <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="4"  data-purecounter-delay="200">Pass</h5>
                                  <?php } else { ?>
                                    <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="4"  data-purecounter-delay="200">Need to work hard, we are here to help you
                                    </h5>
                                  <?php } ?>
                                
                              </div>
                              
                            </div>
                          </div>
                        </div>
                      <?php } else { ?>
                        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
                          <div class="d-flex justify-content-center align-items-center p-4 bg-orange bg-opacity-15 rounded-3 btn-transition h-100">
                            <span class="display-6 lh-1 text-orange mb-0"><i class="fas fa-graduation-cap"></i></span>
                            <div class="ms-4">
                              <div class="d-flex">
                                <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="4"  data-purecounter-delay="200">Evaluation -</h5>
                              </div>
                              <p class="mb-0 h6 fw-light">No activities are scheduled for the selected date to evaluate</p>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                  </div>
                  <!-- Counter boxes END -->

                <!-- Content and input -->
                <!-- <div class="col-lg-4 text-lg-end">
                  <a href="#" class="btn btn-warning mb-0">Schedule Tour</a>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- =======================
Action box END-->

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div id="radial_chart" class="bg-body shadow rounded p-2"></div>
      </div>
      <div class="col-md-6">
        <div id="columnChart" class="bg-body shadow rounded p-2" style="height: 360px; width: 100%;">
        </div>
      </div>
    </div>
  </div>
</section>

<script>      
    var options = {
      series: [<?php echo htmlspecialchars($total_hw, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($total_test, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($total_mcq, ENT_QUOTES, 'UTF-8'); ?>],
      chart: {
      height: 350,
      type: 'radialBar',
    },
    plotOptions: {
      radialBar: {
        offsetY: 0,
        startAngle: 0,
        endAngle: 270,
        hollow: {
          margin: 5,
          size: '30%',
          background: 'transparent',
          image: undefined
        },
        dataLabels: {
          name: {
            show: false,
          },
          value: {
            show: false,
          }
        }
      }
    },
    colors: ['#00E396', '#775DD0', '#FEB019', '#FF4B2B'],
    labels: ['Homework', 'Test', 'MCQ'],
    legend: {
      show: true,
      floating: true,
      fontSize: '15px',
      position: 'left',
      offsetX: 0,
      offsetY: 0,
      labels: {
        useSeriesColors: true,
      },
      markers: {
        size: 0
      },
      formatter: function(seriesName, opts) {
        return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
      },
      itemMargin: {
        vertical: 3
      }
    },
    };
    var radial_chart = new ApexCharts(document.querySelector("#radial_chart"), options);
    radial_chart.render();      
</script>


<?php 
    // Grammar
      $fetch_video_number_grammar = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'grammar' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row = mysqli_fetch_assoc($fetch_video_number_grammar); 
        $sum = $row['value_sum']/60;

        if ($sum == null) {
          $sum = 0;
        }

    // English
        $fetch_video_number_english = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum_english FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'english' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row_english = mysqli_fetch_assoc($fetch_video_number_english); 
        $sum_english= $row_english['value_sum_english']/60;

        if ($sum_english == null) {
          $sum_english = 0;
        }

        // Kannada
        $fetch_video_number_kannada = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum_kannada FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'kannada' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row_kannada = mysqli_fetch_assoc($fetch_video_number_english); 
        $sum_kannada= $row_kannada['value_sum_kannada']/60;

        if ($sum_kannada == null) {
          $sum_kannada = 0;
        }

        // sanskrit
        $fetch_video_number_sanskrit = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum_sanskrit FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'sanskrit' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row_sanskrit = mysqli_fetch_assoc($fetch_video_number_sanskrit); 
        $sum_sanskrit= $row_kansanskrit['value_sum_sanskrit']/60;

        if ($sum_sanskrit == null) {
          $sum_sanskrit = 0;
        }

        // math
        $fetch_video_number_math = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum_math FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'math' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row_math = mysqli_fetch_assoc($fetch_video_number_math); 
        $sum_math= $row_math['value_sum_math']/60;

        if ($sum_math == null) {
          $sum_math = 0;
        }

        // science
        $fetch_video_number_science = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum_science FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'science' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row_science = mysqli_fetch_assoc($fetch_video_number_science); 
        $sum_science= $row_science['value_sum_science']/60;

        if ($sum_science == null) {
          $sum_science = 0;
        }

        // social
        $fetch_video_number_social = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum_social FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'social' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row_social = mysqli_fetch_assoc($fetch_video_number_social); 
        $sum_social= $row_social['value_sum_social']/60;

        if ($sum_social == null) {
          $sum_social = 0;
        }


        // Hindi
        $fetch_video_number_hindi = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum_hindi FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'hindi' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row_hindi = mysqli_fetch_assoc($fetch_video_number_hindi); 
        $sum_hindi= $row_hindi['value_sum_hindi']/60;

        if ($sum_hindi == null) {
          $sum_hindi = 0;
        }

         // Coding
        $fetch_video_number_coding = mysqli_query($connection,"SELECT SUM(rev_user_time) AS value_sum_coding FROM rev_watch_details WHERE rev_user_id = '$user_id' AND rev_video_subject = 'coding' AND rev_user_date BETWEEN '$start_date' AND '$end_date'");
        $row_coding = mysqli_fetch_assoc($fetch_video_number_coding); 
        $sum_coding= $row_coding['value_sum_coding']/60;

        if ($sum_coding == null) {
          $sum_coding = 0;
        }
?>



<script type="text/javascript">
    var columnChartValues = [
      { y: <?php echo round($sum); ?>, label: "Grammar" },
      { y: <?php echo round($sum_english); ?>,  label: "English" },
      { y: <?php echo round($sum_kannada); ?>,  label: "Kannada" },
      { y: <?php echo round($sum_hindi); ?>,  label: "Hindi" },
      { y: <?php echo round($sum_sanskrit); ?>,  label: "Sanskrit" },
      { y: <?php echo round($sum_social); ?>,  label: "Social Science" },
      { y: <?php echo round($sum_math); ?>, label: "Mathematics" },
      { y: <?php echo round($sum_science); ?>,  label: "Science" },
      { y: <?php echo round($sum_coding); ?>,  label: "Coding" },
    ];
    renderColumnChart(columnChartValues);

    function renderColumnChart(values) {

      var chart = new CanvasJS.Chart("columnChart", {
        backgroundColor: "white",
        colorSet: "colorSet3",
        title: {
          text: "Videos streamed In Mins",
          fontFamily: "Roboto",
          fontSize: 20,
          fontWeight: "bold",
        },
        animationEnabled: true,
        legend: {
          verticalAlign: "bottom",
          horizontalAlign: "center"
        },
        theme: "theme2",
        data: [
          {
            indexLabelFontSize: 15,
            indexLabelFontFamily: "Monospace",
            indexLabelFontColor: "darkgrey",
            indexLabelLineColor: "darkgrey",
            indexLabelPlacement: "outside",
            type: "column",
            showInLegend: true,
            legendMarkerColor: "grey",
            dataPoints: values
          }
        ]
      });
      chart.render();
    }
</script>

<!-- bar_chart -->
<?php 
  if (strtotime($start_date) == strtotime($end_date)) {
      $expected =  '30';
    } else {
      $diff_finder = strtotime($start_date) - strtotime($end_date);                         
      $multiple = 30 * $diff_finder;
      $expected = $multiple;
    }
?>
  <?php 
      $fetch_school_sub =  mysqli_query($connection, "SELECT DISTINCT rev_teach_subject FROM rev_teach_class WHERE rev_teacher_class = '$student_class' AND rev_teach_sts = '1';");      
    ?>
    <!-- <script type="text/javascript">      
        var options = {
          series: [
          {
            name: 'Actual',
            data: [
              { 
                <?php 
                  if (mysqli_num_rows($fetch_school_sub) > 0) {
                    while ($kjh = mysqli_fetch_assoc($fetch_school_sub)) { 
                      $sch_sub_name = $kjh['rev_teach_subject']; ?> 
                       x: '<?php echo $sch_sub_name; ?>',
                        y: 1292,
                        goals: [
                          {
                            name: 'Expected',
                            value: <?php echo $expected; ?>,
                            strokeHeight: 5,
                            strokeColor: '#775DD0'
                          }
                        ],                    
                      <?Php }
                    }
                ?>              
               
              },
            ]
          }
        ],
          chart: {
          height: 350,
          type: 'bar'
        },
        plotOptions: {
          bar: {
            columnWidth: '60%'
          }
        },
        colors: ['#00E396'],
        dataLabels: {
          enabled: false
        },
        legend: {
          show: true,
          showForSingleSeries: true,
          customLegendItems: ['Actual', 'Expected'],
          markers: {
            fillColors: ['#00E396', '#775DD0']
          }
        }
        };
    </script> -->


  <?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<script type="text/javascript">
  function handleSelect(elm) {
     window.location = "https://teacher.elated-kepler.3-109-54-59.plesk.page/pages/action?param="+elm.value;
  }
</script>