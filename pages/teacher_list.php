<!-- teacher_list -->

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
    $fetch_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_email = '$teacher_email_id' AND rev_teach_sts = '1'");
    if (mysqli_num_rows($fetch_teacher_details) > 0) {
         while($i = mysqli_fetch_assoc($fetch_teacher_details)) {
            $user_name = htmlspecialchars($i['rev_teach_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['gender'] = $user_gender = htmlspecialchars($i['tree_teacher_gender'], ENT_QUOTES, 'UTF-8');
            $user_school = htmlspecialchars($i['rev_teach_school'], ENT_QUOTES, 'UTF-8');
         }  
    }
?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>

<style>
/*      @import url("https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,700;1,200&display=swap");*/

	.table_scroll1 {
	/*  font-family: "Fraunces", serif;*/
	  font-size: 125%;
	  white-space: nowrap;
	  margin: 0;
	  border: none;
	  border-collapse: separate;
	  border-spacing: 0;
	  table-layout: fixed;
	  border: 1px solid #fff;
	  /*overflow-x: scroll;
	        overflow-y: visible;*/
	  /*width: 100%;
	  height: 50%;*/
	}
	.table_scroll1 td{
		border: 1px solid #066AC9;
	  padding: 0.5rem 1rem;
	}
	.table_scroll1 th {
	  border: 1px solid #fff;
	  padding: 0.5rem 1rem;
	}
	.table_scroll1 thead th {
	  padding: 3px;
	  position: sticky;
	  top: 0;
	  z-index: 1;
	  width: 25vw;
	  background: white;
	}
	.table_scroll1 td {
	  background: #fff;
	  padding: 4px 5px;
	  text-align: center;
	}

	.table_scroll1 tbody th {
	  font-weight: 100;
	/*  font-style: italic;*/
	  font-weight: bold;
	  text-align: left;
	  position: relative;
	}
	.table_scroll1 thead th:first-child {
	  position: sticky;
	  left: 0;
	  z-index: 2;
	}
	.table_scroll1 tbody th {
	  position: sticky;
	  left: 0;
	  color: #fff;
	  background:#0cbc87;
	  z-index: 1;
	}

	[role="region1"][aria-labelledby][tabindex] {
	  width: 100%;
	  max-height: 98vh;
	  overflow: auto;
	}
	[role="region1"][aria-labelledby][tabindex]:focus {
	  box-shadow: 0 0 0.5em rgba(0, 0, 0, 0.5);
	  outline: 0;
	}
</style>

<style type="text/css">
	::-webkit-scrollbar{
    height: 5px;
    width: 5px;
    background: gray;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

::-webkit-scrollbar-thumb:horizontal{
    background: gray;
    border-radius: 10px;
}
</style>

<script type = "text/javascript" 
 src = "https://www.tutorialspoint.com/jquery/jquery-3.6.0.js">
</script>

<div class="container zindex-100 desk" style="margin-top: 10px">
	<div class="row">
		<div style="float: left;">
			<h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
		</div>
		
	</div>
</div>


	<!-- Content START -->
	<div class="container zindex-100 desk">
		<div class="row d-lg-flex justify-content-md-center g-md-5">
			<!-- Left content START -->
				<h4 class="fs-1 fw-bold d-flex justify-content-center">
					<img src="<?php echo BASE_URL; ?>assets/images/Teacher_List.webp" width="50px" height="50px" alt="list">
					<span class="position-relative z-index-9" style="font-size: 33px;">Teacher&nbsp;</span>
					<span class="position-relative z-index-1" style="font-size: 33px;">list
						
						<span class="position-absolute top-50 start-50 translate-middle z-index-n1">
							<svg width="163.9px" height="48.6px">
								<path class="fill-warning" d="M162.5,19.9c-0.1-0.4-0.2-0.8-0.3-1.3c-0.1-0.3-0.2-0.5-0.4-0.7c-0.3-0.4-0.7-0.7-1.2-0.9l0.1,0l-0.1,0 c0.1-0.4-0.2-0.5-0.5-0.6c0,0-0.1,0-0.1,0c-0.1-0.1-0.2-0.2-0.3-0.3c0-0.3,0-0.6-0.2-0.7c-0.1-0.1-0.3-0.2-0.6-0.2 c0-0.3-0.1-0.5-0.3-0.6c-0.1-0.1-0.3-0.2-0.5-0.2c-0.1,0-0.1,0-0.2,0c-0.5-0.4-1-0.8-1.4-1.1c0,0,0-0.1,0-0.1c0-0.1-0.1-0.1-0.3-0.2 c-0.9-0.5-1.8-1-2.6-1.5c-6-3.6-13.2-4.3-19.8-6.2c-4.1-1.2-8.4-1.4-12.6-2c-5.6-0.8-11.3-0.6-16.9-1.1c-2.3-0.2-4.6-0.3-6.8-0.3 c-1.2,0-2.4-0.2-3.5-0.1c-2.4,0.4-4.9,0.6-7.4,0.7c-0.8,0-1.7,0.1-2.5,0.1c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0-0.2,0 c-0.9,0-1.8,0.1-2.7,0.1c-0.9,0-1.8,0-2.7,0c-5.5-0.3-10.7,0.7-16,1.5c-2.5,0.4-5.1,1-7.6,1.5c-2.8,0.6-5.6,0.7-8.4,1.4 c-4.1,1-8.2,1.9-12.3,2.6c-4,0.7-8,1.6-11.9,2.7c-3.6,1-6.9,2.5-10.1,4.1c-1.9,0.9-3.8,1.7-5.2,3.2c-1.7,1.8-2.8,4-4.2,6 c-1,1.3-0.7,2.5,0.2,3.9c2,3.1,5.5,4.4,9,5.7c1.8,0.7,3.6,1,5.3,1.8c2.3,1.1,4.6,2.3,7.1,3.2c5.2,2,10.6,3.4,16.2,4.4 c3,0.6,6.2,0.9,9.2,1.1c4.8,0.3,9.5,1.1,14.3,0.8c0.3,0.3,0.6,0.3,0.9-0.1c0.7-0.3,1.4,0.1,2.1-0.1c3.7-0.6,7.6-0.3,11.3-0.3 c2.1,0,4.3,0.3,6.4,0.2c4-0.2,8-0.4,11.9-0.8c5.4-0.5,10.9-1,16.2-2.2c0.1,0.2,0.2,0.1,0.2,0c0.5-0.1,1-0.2,1.4-0.3 c0.1,0.1,0.2,0.1,0.3,0c0.5-0.1,1-0.3,1.6-0.3c3.3-0.3,6.7-0.6,10-1c2.1-0.3,4.1-0.8,6.2-1.2c0.2,0.1,0.3,0.1,0.4,0.1 c0.1,0,0.1,0,0.2-0.1c0,0,0.1,0,0.1-0.1c0,0,0-0.1,0.1-0.1c0.2-0.1,0.4-0.1,0.6-0.2c0,0,0.1,0,0.1,0c0.1,0,0.2-0.1,0.3-0.2 c0,0,0,0,0,0l0,0c0,0,0,0,0,0c0.2,0,0.4-0.1,0.5-0.1c0,0,0,0,0,0c0.1,0,0.1,0,0.2,0c0.2,0,0.3-0.1,0.3-0.3c0.5-0.2,0.9-0.4,1.4-0.5 c0.1,0,0.2,0,0.2,0c0,0,0.1,0,0.1,0c0,0,0.1-0.1,0.1-0.1c0,0,0,0,0.1,0c0,0,0.1,0,0.1,0c0.2,0.1,0.4,0.1,0.6,0 c0.1,0,0.1-0.1,0.2-0.2c0.1-0.1,0.1-0.2,0.1-0.3c0.5-0.2,1-0.4,1.6-0.7c1.5-0.7,3.1-1.4,4.7-1.9c4.8-1.5,9.1-3.4,12.8-6.3 c0.8-0.2,1.2-0.5,1.6-1c0.2-0.3,0.4-0.6,0.5-0.9c0.5-0.1,0.7-0.2,0.9-0.5c0.2-0.2,0.2-0.5,0.3-0.9c0-0.1,0-0.1,0.1-0.1 c0.5,0,0.6-0.3,0.8-0.5C162.3,24,163,22,162.5,19.9z M4.4,28.7c-0.2-0.4-0.3-0.9-0.1-1.2c1.8-2.9,3.4-6,6.8-8 c2.8-1.7,5.9-2.9,8.9-4.2c4.3-1.8,9-2.5,13.6-3.4c0,0.1,0,0.2,0,0.2l0,0c-1.1,0.4-2.2,0.7-3.2,1.1c-3.3,1.1-6.5,2.1-9.7,3.4 c-4.2,1.6-7.6,4.2-10.1,7.5c-0.5,0.7-1,1.3-1.6,2c-2.2,2.7-1,4.7,1.2,6.9c0.1,0.1,0.3,0.3,0.4,0.5C7.8,32.5,5.5,31.2,4.4,28.7z  M158.2,23.8c-1.7,2.8-4.1,5.1-7,6.8c-2,1.2-4.5,2.1-6.9,2.9c-3.3,1-6.4,2.4-9.5,3.7c-3.9,1.6-8.1,2.5-12.4,2.9 c-6,0.5-11.8,1.5-17.6,2.5c-4.8,0.8-9.8,1-14.7,1.5c-5.6,0.6-11.2,0.2-16.8,0.1c-3.1-0.1-6.3,0.3-9.4,0.5c-2.6,0.2-5.2,0.1-7.8-0.1 c-3.9-0.3-7.8-0.5-11.7-0.9c-2.8-0.3-5.5-0.7-8.2-1.4c-3.2-0.8-6.3-1.7-9.5-2.5c-0.5-0.1-1-0.3-1.4-0.5c-0.2-0.1-0.4-0.1-0.6-0.2 c0,0,0.1,0,0.1,0c0.3-0.1,0.5,0,0.7,0.1c0,0,0,0,0,0c3.4,0.5,6.9,1.2,10.3,1.4c0.5,0,1,0,1.5,0c0.5,0,1.3,0.2,1.3-0.3 c0-0.6-0.7-0.9-1.4-0.9c-2.1,0-4.2-0.2-6.3-0.5c-4.6-0.7-9.1-1.5-13.4-3c-2.9-1.1-5.4-2.7-6.9-5.2c-0.5-0.8-0.5-1.6-0.1-2.4 c3.2-6.2,9-9.8,16.3-12.2c6.7-2.2,13.2-4.5,20.2-6c5-1.1,10-1.8,15-2.9c8.5-1.9,17.2-2.4,26-2.7c3.6-0.1,7.1-0.8,10.8-0.6 c8.4,0.7,16.7,1.2,25,2.3c4.5,0.6,9,1.2,13.6,1.7c3.6,0.4,7.1,1.4,10.5,2.8c3.1,1.3,6,2.9,8.5,5C159.1,17.7,159.8,21.1,158.2,23.8z"/>
							</svg>
						</span>
						
					</span>
				</h4>
		</div> <!-- Row END -->
	</div>
	<!-- Content END -->


<div class="container">

	<div class="row d-lg-flex justify-content-center">
		
		<div class="col-md-12 mt-2">
			<div class="badge bg-info bg-opacity-10 text-info mb-4 fw-bold btn-transition" onclick="ExportToExcel('xlsx')" style="float: right; margin-top: -20px; font-size: 12px; cursor: pointer;"><img src="../assets/images/export.webp" alt="export" height="30px" width="30px"> Export teacher list</div>
		</div>
	</div>

<div class="row d-flex justify-content-center">
    <div class="col-md-6">
            <div role="region1" aria-labelledby="caption" tabindex="0">
	    <table class="table_scroll1">
	      <thead>
	        <tr class="text-center">
	          <th style="background: #fff; color: #0CBC87" scope="col"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">&nbsp;&nbsp;#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher name</span></th>
	          <th scope="col" class="border-0"><span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Phone number</span></th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php 
	      	$fetch_all_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_school = '$user_school' AND rev_teach_sts = '1'");

	      	if (mysqli_num_rows($fetch_all_teacher_details) > 0) {
	      		$i = 1;
	      		while($row = mysqli_fetch_assoc($fetch_all_teacher_details)) { ?>
	      			<tr class="text-center" style="font-size: 18px">
	  				<th style="text-align: left; word-wrap: break-word; white-space: normal !important"><i class="far fa-user" style="font-size: 16px"></i>&nbsp;&nbsp;<?php echo $i++; ?>)&nbsp;<?php echo htmlspecialchars(ucfirst($row['rev_teach_name']), ENT_QUOTES, 'UTF-8'); ?>
			          </th>
	          <!-- <th class="fixed-side">Rakhee</th> -->
	          <td><i class="fas fa-phone-volume" style="font-size: 18px; color: #0CBC87"></i>&nbsp;<?php echo htmlspecialchars(ucfirst($row['rev_teach_number']), ENT_QUOTES, 'UTF-8'); ?></td>
	        </tr>

	      		<?php }
	      	}


	      	?>
		</tbody>
	    </table>
	  </div>
	</div>

	<div id="table-scroll" class="table-scroll" style="display: none;">
	  <div class="table-wrap">
	    <table id="tbl_exporttable_to_xls">
	      <thead>
	        <tr class="table_header text-center">
	          <th class="border-0" style="background: #fff; color: #0CBC87" scope="col">
	          	<span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">SL No.</span></th>
	          <th class="border-0" style="background: #fff; color: #0CBC87" scope="col">
	          	<span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Teacher name</span></th>
	          <th scope="col" class="border-0">
	          	<span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 16px; font-weight: bold">Phone number</span></th>
	        </tr>
	      </thead>
	      <tbody>
	        <?php 
	      	$fetch_all_teacher_details = mysqli_query($connection, "SELECT * FROM rev_user_details WHERE rev_teach_school = '$user_school' AND rev_teach_sts = '1'");

	      	if (mysqli_num_rows($fetch_all_teacher_details) > 0) {
	      		$i = 1;
	      		while($row = mysqli_fetch_assoc($fetch_all_teacher_details)) { ?>
	      			<tr class="text-center" style="font-size: 18px">
	          <th class="fixed-side"><?php echo $i++; ?></th>
	          <th class="fixed-side" style="text-align: left; max-width: 5px"><i class="far fa-user" style="font-size: 16px"></i>&nbsp;<?php echo htmlspecialchars(ucfirst($row['rev_teach_name']), ENT_QUOTES, 'UTF-8'); ?></th>
	          <!-- <th class="fixed-side">Rakhee</th> -->
	          <td><i class="fas fa-phone-volume" style="font-size: 18px; color: #0CBC87"></i>&nbsp;<?php echo htmlspecialchars(ucfirst($row['rev_teach_number']), ENT_QUOTES, 'UTF-8'); ?></td>
	        </tr>

	      		<?php }
	      	}


	      	?>
	      </tbody>
	    </table>
	  </div>
	</div>

</div>

<br><br>

<?php require ROOT_PATH . "includes/footer_after_login.php"; ?>
<script src="assets/js/functions.js"></script>

<script type="text/javascript">
	 // requires jquery library
	jQuery(document).ready(function() {
	   jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
	 });

  function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('tbl_exporttable_to_xls');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fn || ('Teacher-list.' + (type || 'xlsx')));
  }

  function myFunction() {
      const element = document.getElementById("content");
      element.scrollIntoView();
    }

</script>



