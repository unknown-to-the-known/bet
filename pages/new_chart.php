<!-- https://www.devwares.com/blog/create-bootstrap-charts-using-bootstrap5/ -->

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
     

  <link rel="stylesheet" href="../contrast-bootstrap-pro/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../contrast-bootstrap-pro/css/cdb.css" />
  <script src="../contrast-bootstrap-pro/js/cdb.js"></script>
  <script src="../contrast-bootstrap-pro/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/9d1d9a82d2.js" crossorigin="anonymous"></script>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<style>
  .chart-container {
    width: 100%;
    height: 100%;
    margin: auto;
  }
</style>



<div class="container zindex-100 desk" style="margin-top: 10px">
  <div style="float: left;">
  <h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
  </div>
</div>

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="card chart-container bg-body shadow p-2" style="height: 300px; width: 100%">
          <canvas id="chart"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>

<script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js">
</script>
<script>
      const ctx = document.getElementById("chart").getContext('2d');
      const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["Eng", "Kan", "Hin", "Math", "Sci", "Soc", "Sans"],
          datasets: [{
            label: 'Subjects',
            backgroundColor: 'rgba(161, 198, 247, 1)',
            borderColor: 'rgb(47, 128, 237)',
            data: [68, 38, 35, 20, 55, 28, 16],
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
              }
            }]
          }
        },
      });
</script>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>