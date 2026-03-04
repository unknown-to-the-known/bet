<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>
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
<?php 
	if (isset($_GET['id'])) {
		if ($_GET['id'] != "") {
			$class_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
		} else {
			header("Location: " . BASE_URL . 'pages/action');
		}
	} else {
			header("Location: " . BASE_URL . 'pages/action');
		}	
?>


<?php 
	$check_if_planner_already_present = mysqli_query($connection, "SELECT * FROM rev_lesson_planner WHERE tree_id = '$class_id' AND rev_lesson_status = '1'");

	if (mysqli_num_rows($check_if_planner_already_present) > 0) {
		while($g = mysqli_fetch_assoc($check_if_planner_already_present)) {
			$url = htmlspecialchars($g['rev_lesson_img'], ENT_QUOTES, 'UTF-8');
			$mode = htmlspecialchars($g['rev_paper_mode'], ENT_QUOTES, 'UTF-8');
			$comment = htmlspecialchars($g['rev_teacher_comments'], ENT_QUOTES, 'UTF-8');
		}
	} else {
		header("Location: " . BASE_URL . 'pages/action');
	}

	$url = $url;
    $values = parse_url($url);
    $host = explode('~',$values['path']);
    $videos = $host[1];                 
    $result = str_replace('/','',$videos); 
?>

<?php 
	if (isset($_POST['submit'])) {
		$comments_by_teacher = mysqli_escape_string($connection, trim($_POST['comments']));

		if ($comments_by_teacher == "") {
				$error_message = "Please enter your comments";
			}	

		if (!isset($error_message)) {
			$update = mysqli_query($connection, "UPDATE rev_lesson_planner SET rev_teacher_comments = '$comments_by_teacher' WHERE tree_id = '$class_id' AND rev_teacher_id = '$teacher_email_id'");

			if (isset($update)) {
				$error_message = "Your comments updated";
			}
		}
	}
?>


<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<div class="container zindex-100 desk" style="margin-top: 10px">
	<div class="row">
			<div style="float: left;">
				<h6 class="mb-3 font-base bg-light bg-opacity-10 text-primary py-2 px-4 rounded-2 btn-transition" style="font-size: 16px;">🙋🏻‍♀️ Hi, <?php echo ucfirst($user_name); ?></h6>
			</div>
			<div class="d-flex justify-content-end" style="margin-top: -20px">
				    
			</div>
	</div>
</div>


	<!-- Content START -->
	<div class="container zindex-100 desk">
		<div class="row">
			<!-- Left content START -->
				<div class="d-flex justify-content-center mt-2">
                    <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center text-purple fw-bold" role="alert" style="font-size: 18px; text-align: center;">
                        <img src="<?php echo BASE_URL; ?>assets/images/submitted.webp" width="30px" height="30px" alt="submitted">&nbsp;Plan your lesson and upload the details
                    </div>  
                </div>	
		</div> <!-- Row END -->
	</div>

<br><br>

<!-- =======================
Page Banner START -->
	<div class="container mb-4" style="background-image:url(/assets/images/element/map.svg); background-position: center left; background-size: auto; background-repeat: repeat;">
		
		<!-- Contact info box -->
		<div class="row mb-4">
					<?php 
						if (isset($error_message)) { ?>
							<div class="col-md-12 d-flex justify-content-center">
								<div class="col-md-4 d-flex justify-content-center alert alert-danger" role="alert">
									<ul class="feedback d-flex justify-content-center">
										<li class="ok active">
									        <div></div>
									    </li>
									</ul>
									 &nbsp;&nbsp;<span class="mt-2 fw-bold"> <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?> </span>
								</div>
							</div>		
						<?php }
					?>

					<?php 
						if (isset($success_message)) { ?>
							<div class="col-md-12 d-flex justify-content-center">
								<div class="col-md-4 d-flex justify-content-center alert alert-success" role="alert">
									<ul class="feedback">
										<li class="active happy">
									        <div>
									            <svg class="eye left">
									                <use xlink:href="#eye">
									            </svg>
									            <svg class="eye right">
									                <use xlink:href="#eye">
									            </svg>
									        </div>
							    		</li>
									</ul>
									 &nbsp;&nbsp;<span class="mt-2 fw-bold"> <?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?> </span>
								</div>	
							</div>		
						<?php }
					?>

			<!-- Box item -->
			<div class="col-lg-12 mt-lg-0">
				<div class="card card-body bg-transparent shadow text-center h-100">
					<!-- Title -->					
					<div class="row">						
						<?php 
							if ($mode == "image") { 
								for ($i=0; $i < $result; $i++) { ?>		
								<div class="col-md-4" style="margin-bottom:10px;">							
									<a href="<?php echo $url; ?>nth/<?php echo $i; ?>/" target="_blank"><img src="<?php echo $url; ?>nth/<?php echo $i; ?>/" width="100%" style="border-radius: 10px;"></a>
								</div>
							<?php } ?>
						<?php } ?>



							<?php 
							for ($k=0; $k < $result; $k++) { 
								$pdf_id = $url . 'nth/' . $k . '/';
							}



						?>			
									

						<?php 
							if ($mode == "pdf") { ?>
							  	<div id="adobe-dc-view"></div>
									<script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>
									
									<script type="text/javascript">
										document.addEventListener("adobe_dc_view_sdk.ready", function(){ 
											var adobeDCView = new AdobeDC.View({clientId: "<?php echo $pdf_reader_for_teacher; ?>", divId: "adobe-dc-view"});
											adobeDCView.previewFile({
												content:{location: {url: "<?php echo $pdf_id; ?>"}},
												metaData:{fileName: "Bodea Survey.pdf"}
											}, {});
										});
									</script>
									<?php } ?>
							
						<h5 class="mt-4" style="font-size: 18px">💬 Post your comments</h5>
						<form action="" method="post">
							<div class="form-floating">
							  <textarea class="form-control text-dark" id="floatingTextarea" name="comments" required><?php if($comment != '0') {echo $comment;} ?></textarea>							  
							</div>
							<button class="btn btn-primary mt-2" type="submit" name="submit">Submit</button>
						</form>															
					</div>
				</div>
			</div>			
		</div>
	</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
        <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
        <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
    </symbol>
</svg>

<!--Edit Modal -->
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><img src="https://rwl.sgp1.cdn.digitaloceanspaces.com/assets/Logo_symbol.svg" alt="logo_revisewell" height="50px" width="50px"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<div class="container">
	      	<div class="w-100 mt-auto d-inline-flex justify-content-center">
		        <div class="shadow-lg p-2 mb-3 bg-body rounded d-flex align-items-center">
					<!-- Avatar -->
					<div class="col-md-2">
						<div class="avatar avatar-sm me-2 rounded-4">
							<img class="avatar-img rounded-1" src="../assets/images/Chapter_list.webp" alt="avatar">
						</div>
					</div>
					<!-- Avatar info -->
					<div class="col-md-10">
						<div>
							<h6 class="mb-0 text-dark" style="text-align: justify;">Update chapter name - <span class="text-primary ch_edit_name" style="text-transform: capitalize;">"Fetch chapter name"</span></h6>
						</div>
					</div>
				</div>
		    </div>
	    
		    <form class="row align-items-center justify-content-center" action="" method="post" autocomplete="off">
				<div class="col-md-12 mt-3">
					<div class="bg-body shadow rounded-pill p-2">
						<div class="input-group">
							<input class="form-control border-0 me-1" type="text" placeholder="New name" required name="edit_chp_name" autocomplete="off">
							<input class="form-control border-0 me-1 id" type="hidden" placeholder="New nam" required name="edit_chp_id">
						</div>
					</div>
				</div>
			
			<div class="col-md-12 d-flex justify-content-center mb-2 mt-4">
				<button class="btn btn-primary mb-0 submit_field" type="submit" name="update">Submit</button>
			</div>			
		  </form>
		</div>
        <!-- <div class="modal-footer">
	        <button type="button" class="btn btn-primary-soft" data-bs-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
</div>




<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
<script type="text/javascript">
	const exampleModal = document.getElementById('staticBackdrop1')
				exampleModal.addEventListener('show.bs.modal', event => {
				  // Button that triggered the modal
				  const button = event.relatedTarget
				  // Extract info from data-bs-* attributes
				  const recipient = button.getAttribute('data-bs-whatever')
				  const recipient_id = button.getAttribute('data-bs-whatever1')
				  // If necessary, you could initiate an AJAX request here
				  // and then do the updating in a callback.
				  //
				  // Update the modal's content.
				  const modalTitle = exampleModal.querySelector('.ch_edit_name')
				  const modalBodyInput = exampleModal.querySelector('.modal-body .id')


				  modalTitle.textContent = `${recipient}`
				  modalBodyInput.value = recipient_id
				})

	const exampleModals = document.getElementById('staticBackdrop2')
				exampleModals.addEventListener('show.bs.modal', event => {
				  // Button that triggered the modal
				  const button = event.relatedTarget
				  // Extract info from data-bs-* attributes
				  const recipient_name = button.getAttribute('data-bs-whatever3')
				  const recipient_id_name = button.getAttribute('data-bs-whatever2')
				  // If necessary, you could initiate an AJAX request here
				  // and then do the updating in a callback.
				  //
				  // Update the modal's content.
				  const modalTitles = exampleModals.querySelector('.ch_delete_name')
				  const modalBodyInputs = exampleModals.querySelector('.modal-footer .del_uniq_id')


				  modalTitles.textContent = `${recipient_name}`
				  modalBodyInputs.value = recipient_id_name
				})
</script>

<script type="text/javascript">
    const picker = MCDatepicker.create({
        el: '#datepickers',                     
        minDate: new Date()
    });
    $('#timepicker').mdtimepicker(); //Initializes the time picker
</script>