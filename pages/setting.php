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
    $_SESSION['academic_setter'] = '2024_25';
  }
?>



<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap">

<style type="text/css">

   section {
/*      background-color: #f0f0f0; /* Light gray background */*/
      color: #333; /* Text color */
      font-family: 'Nunito Sans', sans-serif; /* Nunito Sans font */
    }
    .rounded-icon {
      border-radius: 50%;
      width: 100px; /* Adjust this size as needed */
      height: 100px; /* Adjust this size as needed */
      margin: 0 auto; /* Center the icon horizontally */
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem; /* Adjust icon size */
      background: linear-gradient(135deg, #8ac6d1, #81b3ff); /* Gradient background */
      color: #fff; /* Icon color */
      box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Add a subtle shadow */
    }
    .card {
      position: relative;
      border: none; /* Remove default border */
      border-radius: 15px; /* Add some border radius */
      overflow: hidden; /* Hide overflow */
      box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Add a subtle shadow */
      transition: transform 0.3s ease; /* Add smooth hover effect */
      background-color: #fff; /* Card background color */
    }
    .card:hover {
      transform: translateY(-5px); /* Lift the card on hover */
    }
    .card-body {
      padding: 20px; /* Adjust this value to your liking */
      color: #333; /* Text color */
      text-align: center;
    }
    .card-title {
      font-size: 1.5rem; /* Adjust title font size */
      margin-bottom: 10px;
      font-weight: bold; /* Make text bold */
    }
    .btn-primary {
      transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
      border-color: #85c79e; /* Change primary button hover border color */
    }
  </style>

<div class="container zindex-100 desk" style="margin-top: 0px">
	<div style="float: left;">
		<h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition student_trim_name" style="font-family: 'Nunito Sans', sans-serif;">🙋🏻‍♀️ Hi,<?php echo ucfirst($user_name); ?></h6>
	</div>

  <div style="float:right; text-decoration: underline; cursor:pointer;" class="text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal_year">
    <i class="fas fa-graduation-cap"></i> Year <?php echo htmlspecialchars(str_replace('_', '-', $_SESSION['academic_setter']), ENT_QUOTES, 'UTF-8'); ?>
  </div>
</div>

<!-- Steps START -->
<section>
	<div class="container">
  <div class="row">
    <div class="col-md-3">
      <a href="<?php echo BASE_URL; ?>pages/fee_structure" class="card mb-4" style="text-decoration: none; color: inherit;"> <!-- Added anchor tag -->
        <div class="rounded-icon mt-1" style="background: linear-gradient(135deg, #ff9a9e, #fecfef);"> 
          <i class="fas fa-sort-amount-up"></i>
        </div>
        <div class="card-body">
          <p class="card-title" style="font-family: 'Nunito Sans', sans-serif; font-size: 18px;">Fee Structure</p>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="<?php echo BASE_URL; ?>pages/user_setting" class="card mb-4" style="text-decoration: none; color: inherit;"> <!-- Added anchor tag -->
        <div class="rounded-icon mt-1" style="background: linear-gradient(135deg, #a18cd1, #fbc2eb);"> <!-- Adjusted gradient colors -->
          <i class="fas fa-users-cog"></i> <!-- Font Awesome money bill icon -->
        </div>
        <div class="card-body">
          <h5 class="card-title" style="font-family: 'Nunito Sans', sans-serif; font-size: 18px;">User settings</h5>
          <!-- <p class="card-text">This card displays fee collection details.</p> -->
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="<?php echo BASE_URL; ?>pages/school_setting" class="card mb-4" style="text-decoration: none; color: inherit;"> <!-- Added anchor tag -->
        <div class="rounded-icon mt-1" style="background: linear-gradient(135deg, #a18cd1, #fbc2eb);"> <!-- Adjusted gradient colors -->
          <i class="fas fa-users-cog"></i> <!-- Font Awesome money bill icon -->
        </div>
        <div class="card-body">
          <h5 class="card-title" style="font-family: 'Nunito Sans', sans-serif; font-size: 18px;">School Details</h5>
          <!-- <p class="card-text">This card displays fee collection details.</p> -->
        </div>
      </a>
    </div>
  </div>
</div>
</section>

<!-- Class Selector Modal -->
	<div class="modal fade" id="class_selector" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="exampleModalLabel">Select Class</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<?php 
	      		$fetch_class_of_teacher = mysqli_query($connection, "SELECT * FROM rev_teach_class WHERE rev_teach_email_id = '$teacher_email_id' AND rev_school_uniq_id = '$school_id' AND rev_teach_sts = '1'");

	      		if (mysqli_num_rows($fetch_class_of_teacher) > 0) {
	      			while($fdr = mysqli_fetch_assoc($fetch_class_of_teacher)) { ?>
	      				<a href="<?php echo BASE_URL; ?>pages/action?param=<?php echo htmlspecialchars($fdr['tree_id'], ENT_QUOTES, 'UTF-8'); ?>">
	      					<button class="btn btn-sm btn-outline-primary">Grade <?php echo htmlspecialchars($fdr['rev_teacher_class'], ENT_QUOTES, "UTF-8") . ' ' . htmlspecialchars(ucfirst($fdr['rev_teacher_sec']), ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars(ucfirst(str_replace('_', ' ', $fdr['rev_teach_subject'])), ENT_QUOTES, 'UTF-8'); ?></button></a>
	      			<?php }
	      		}
	      	?>
	      </div>	      
	    </div>
	  </div>
	</div>
</div>

<!-- Class Selector Modal Ended -->
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<!-- start webpushr code --> <script>(function(w,d, s, id) {if(typeof(w.webpushr)!=='undefined') return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.async=1;js.src = "https://cdn.webpushr.com/app.min.js";fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));webpushr('setup',{'key':'BDZUA_GgjAcTf5pnBP_ta-DCqPO_Q8kqPJXgUl4RUkgedeTH79v2s5Jz4mRDpPavSJQ8VYU4xIGR1w41YG6gFwQ' });</script><!-- end webpushr code -->