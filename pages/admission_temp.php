<hr>
						
						
						<!-- Father Aadhar number -->
						<div class="col-md-4">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold" for="father_aadhar">Father Aadhaar Number</label>
										<div class="bg-body shadow rounded-pill p-2">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="number" placeholder="Enter Father Aadhaar Number" name="father_aadhaar_number" id="father_aadhar" autocomplete="nope" value="" required>
											</div>								
										</div>	
									<input class="form-control mt-1" type="file" id="father_formFile" name="father_aadhaar_doc">
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
												<input class="form-control border-0 me-1" type="number" placeholder="Enter Mother Aadhaar Number" name="mother_aadhaar_number" id="mother_aadhar" autocomplete="nope" value="" required>
											</div>								
										</div>	
									<input class="form-control mt-1" type="file" id="mother_formFile" name="mother_aadhaar_doc">
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
												<input class="form-control border-0 me-1" type="number" placeholder="Enter Mother Aadhaar Number" name="student_aadhaar_number" autocomplete="nope" value="" id="student_aadhaar" required>
											</div>								
										</div>	
									<input class="form-control mt-1" type="file" id="student_formFile" name="student_aadhaar_doc">
								</div>
							</div>						
						</div>

						<!-- Urban/Rural -->
						<div class="col-md-4" >							
							<label class="text-dark fw-bold">Urban/Rural<span style="color:red;">*</span></label>
							<br>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="urban">
							  <label class="form-check-label text-dark" for="inlineRadio1">Urban</label>
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="rural">
							  <label class="form-check-label text-dark" for="inlineRadio2">Rural</label>	
							</div>						
						</div>

						<!-- Gender -->
						<div class="col-md-4" >							
							<label class="text-dark fw-bold">Gender<span style="color:red;">*</span></label>
							<br>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="inlineRadio4" value="male">
							  <label class="form-check-label text-dark" for="inlineRadio4">Male</label>
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="inlineRadio5" value="female">
							  <label class="form-check-label text-dark" for="inlineRadio5">Female</label>	
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="inlineRadio6" value="transgender">
							  <label class="form-check-label text-dark" for="inlineRadio6">Transgender</label>	
							</div>						
						</div>
						<!-- Religion -->
						<div class="col-md-4" >
							<label class="text-dark fw-bold" for="rel1">Religion<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">								
								<input list="rel" name="rel" id="rel1" class="form-control border-0 me-1">
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
												<input class="form-control border-0 me-1" type="date" name="student_dob" autocomplete="nope" value="" required>												
											</div>								
										</div>	
										
									<input class="form-control mt-1" type="file" id="formFile10" name="dob_doc">
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
												<input class="form-control border-0 me-1" type="text" placeholder="Enter Student Caste Certificate No" name="student_certificate_no" autocomplete="nope" value="" required>												
											</div>								
										</div>	
										<div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="text" placeholder="Enter Student Caste" name="student_caste_name" autocomplete="nope" value="" required>												
											</div>
										</div>
									<input class="form-control mt-1" type="file" id="formFile10" name="certificate_doc_student">
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
												<input class="form-control border-0 me-1" type="text" placeholder="Enter Father Caste Certificate No" name="father_certificate_no" autocomplete="nope" value="" required>
											</div>								
										</div>	

										<div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="text" placeholder="Enter Father Caste" name="father_caste_name" autocomplete="nope" value="" required>												
											</div>
										</div>
									<input class="form-control mt-1" type="file" id="formFile11" name="certificate_doc_father">
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
												<input class="form-control border-0 me-1" type="text" placeholder="Enter Mother Caste Certificate No" name="mother_certficate_no" autocomplete="nope" value="" required>												
											</div>
										</div>

										<div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="text" placeholder="Enter Mother Caste" name="mother_caste_name" autocomplete="nope" value="" required>												
											</div>
										</div>	
									<input class="form-control mt-1" type="file" id="formFile12" name="certificate_doc_mother">
								</div>
							</div>						
						</div>

						<!-- Social Category -->
						<div class="col-md-4">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold">Social Category<span style="color:red;">*</span></label><br>
										<button class="btn btn-warning btn-sm general_btn" type="button">General</button>
										<button class="btn btn-warning btn-sm obc_btn" type="button">OBC</button>
										<button class="btn btn-warning btn-sm sc_btn" type="button">SC</button>
										<button class="btn btn-warning btn-sm st_btn" type="button">ST</button>

										<div class="general">
											<input type="hidden" name="general" value="obc">
											<h6 style="color:green;">General Selected</h6>
										</div>

										<div class="obc">
											<h6>Upload <span style="color:red; font-weight:bold;">OBC document</span></h6>
											<input type="hidden" name="obc" value="obc">
											<input class="form-control mt-1" type="file" id="formFile13" name="obc_doc">
										</div>

										<div class="sc">
											<h6>Upload <span style="color:red; font-weight:bold;">SC document</span></h6>
											<input type="hidden" name="sc" value="sc">
											<input class="form-control mt-1" type="file" id="formFile14" name="sc_doc">
										</div>

										<div class="st">
											<h6>Upload <span style="color:red; font-weight:bold;">ST document</span></h6>
											<input type="hidden" name="st" value="st">
											<input class="form-control mt-1" type="file" id="formFile15" name="st_doc">
										</div>
								</div>
							</div>						
						</div>

						<!-- Social Category -->
						<div class="col-md-4">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold">Belong to BPL</label><br>
											<button class="btn btn-warning btn-sm bpl_no_btn" type="button">No</button>
											<button class="btn btn-warning btn-sm bpl_yes_btn" type="button">Yes</button>										

										<div class="bpl_no">
											<h6 style="color:green;">No BPL Card</h6>
										</div>

										<div class="bpl_yes">
											<h6>Upload <span style="color:red; font-weight:bold;">BPL document</span></h6>
											<div class="bg-body shadow rounded-pill p-2">
												<div class="input-group">
													<input class="form-control border-0 me-1" type="number" placeholder="Enter BPL card No" name="bpl_number" autocomplete="nope" value="" required>	
												</div>
											</div>											
											<input type="hidden" name="bpl" value="">
											<input class="form-control mt-1" type="file" id="formFile16" name="bpl_doc">
										</div>

								</div>
							</div>						
						</div>

						<!-- Special Category -->
						<div class="col-md-4">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold">Special Category</label><br>
										<button class="btn btn-warning btn-sm spl_no_btn" type="button">None</button>
										<button class="btn btn-warning btn-sm spl_destitute_btn" type="button">Destitute</button>
										<button class="btn btn-warning btn-sm spl_hiv_btn" type="button">HIV Case</button>
										<button class="btn btn-warning btn-sm spl_orphans_btn" type="button">Orphans</button>
										<button class="btn btn-warning btn-sm spl_other_btn" type="button">Others</button>										

										<div class="spl_no">
											<h6 style="color:green;">None</h6>
										</div>

										<div class="spl_destitute">
											<h6>Upload <span style="color:red; font-weight:bold;">Destitute Document</span></h6>
											<input type="hidden" name="destitute" value="">
											<input class="form-control mt-1" type="file" id="formFile17" name="destitute_doc">
										</div>

										<div class="spl_hiv">
											<h6>Upload <span style="color:red; font-weight:bold;">HIV Document</span></h6>
											<input type="hidden" name="hiv" value="">
											<input class="form-control mt-1" type="file" id="formFile18" name="hiv_doc">
										</div>

										<div class="spl_orphans">
											<h6>Upload <span style="color:red; font-weight:bold;">Orphans Document</span></h6>
											<input type="hidden" name="orphans" value="">
											<input class="form-control mt-1" type="file" id="formFile19" name="orphans_doc">
										</div>

										<div class="spl_other">											
											<div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
												<div class="input-group">
													<input class="form-control border-0 me-1" type="text" placeholder="Enter other category" name="spl_other" autocomplete="nope" value="" required>												
												</div>
											</div>	
											<input class="form-control mt-1" type="file" id="formFile20" name="spl_other_doc">
										</div>
									<!-- <input class="form-control mt-1" type="file" id="formFile" name="father_aadhaar"> -->
								</div>
							</div>						
						</div>

						<!-- Bhagyalakshmi Bond -->

						<div class="col-md-6">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold">Bhagyalakshmi Bond No.</label>
									<button class="btn btn-warning btn-sm bhagya_bond_yes_btn" type="button">Yes</button>
									<button class="btn btn-warning btn-sm bhagya_bond_no_btn" type="button">No</button>
											<div class="bhagya_bond">
												<div class="bg-body shadow rounded-pill p-2 ">
													<div class="input-group">
														<input class="form-control border-0 me-1" type="number" placeholder="Enter Bhagyalakshmi Bond Number" name="bhagya_bond" autocomplete="nope" value="" required>
													</div>	

												</div>
												<input class="form-control mt-1" type="file" id="formFile21" name="bhagya_bond_doc">	
											</div>

										<div class="no_bhagya_bond text-danger" style="font-weight:bold;">
											No Bhagyalakshmi Bond								
										</div>	
									
								</div>
							</div>						
						</div>

						<!-- Disability Child-->
						<div class="col-md-6">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold">Disability Child<span style="color:red;">*</span></label><br>
											<button class="btn btn-outline-info btn-sm no_dis_btn" type="button">Not Applicable</button>
											<button class="btn btn-outline-info btn-sm austism_btn" type="button">Austism</button>
											<button class="btn btn-outline-info btn-sm physically_btn" type="button">Physically Handicapped</button>
											<button class="btn btn-outline-info btn-sm hearing_btn" type="button">Hearing Impartment</button>
											<button class="btn btn-outline-info btn-sm learning_btn" type="button">Learning Disability</button>
											<button class="btn btn-outline-info btn-sm loco_btn" type="button">Loco motor Impartment</button>
											<button class="btn btn-outline-info btn-sm mental_btn" type="button">Mental Retardation</button>
											<button class="btn btn-outline-info btn-sm multiple_btn" type="button">Multiple Disability</button>
											<button class="btn btn-outline-info btn-sm speech_btn" type="button">Speech Impairment</button>
											<button class="btn btn-outline-info btn-sm blindness_btn" type="button">Visual Impairment(Blindness)</button>
											<button class="btn btn-outline-info btn-sm low_btn" type="button">Visual Impairment(Low-vision)</button>
											<button class="btn btn-outline-info btn-sm cerebral_btn" type="button">Cerebral palsy</button>

										<div class="no_dis">
											<h6 style="color:green;">Not Applicable</h6>
										</div>

										<div class="austism">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Austism</span></h6>
											<input type="hidden" name="austism" value="austism">
											<input class="form-control mt-1" type="file" id="austism" name="austism_doc">
										</div>

										<div class="physically">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Physically Handicapped</span></h6>
											<input type="hidden" name="physically" value="physically">
											<input class="form-control mt-1" type="file" id="physically" name="physically_doc">
										</div>

										<div class="hearing">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Hearing Impartment</span></h6>
											<input type="hidden" name="hearing" value="hearing">
											<input class="form-control mt-1" type="file" id="hearing" name="hearing_doc">
										</div>

										<div class="learing">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Learning Disability</span></h6>
											<input type="hidden" name="learning" value="learing">
											<input class="form-control mt-1" type="file" id="learing" name="learning_doc">
										</div>

										<div class="loco_motor">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Loco motor Impartment</span></h6>
											<input type="hidden" name="loco_motor" value="loco_motor">
											<input class="form-control mt-1" type="file" id="loco_motor" name="loco_motor_doc">
										</div>

										<div class="mental">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Mental Retardation</span></h6>
											<input type="hidden" name="mental" value="mental">
											<input class="form-control mt-1" type="file" id="mental" name="mental_doc">
										</div>

										<div class="multiple">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Multiple Disability</span></h6>
											<input type="hidden" name="hearing" value="multiple">
											<input class="form-control mt-1" type="file" id="multiple" name="multiple_doc">
										</div>

										<div class="speech">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Speech Impairment</span></h6>
											<input type="hidden" name="speech" value="speech">
											<input class="form-control mt-1" type="file" id="speech" name="speech_doc">
										</div>

										<div class="blindness">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Visual Impairment(Blindness)</span></h6>
											<input type="hidden" name="blindness" value="blindness">
											<input class="form-control mt-1" type="file" id="formFile22" name="blindness_doc">
										</div>

										<div class="low_vision">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Visual Impairment(Low-vision)</span></h6>
											<input type="hidden" name="low_vision" value="low_vision">
											<input class="form-control mt-1" type="file" id="formFile23" name="low_vision_doc">
										</div>

										<div class="cerebral_palsy">
											<h6>Upload document for <span style="font-weight:bold; font-size:24px;" class="text-info">Cerebral Palsy</span></h6>
											<input type="hidden" name="cerebral_palsy" value="cerebral_palsy">
											<input class="form-control mt-1" type="file" id="formFile24" name="cerebral_palsy_doc">
										</div>
								</div>
							</div>						
						</div>
					<hr>





					<!-- Admission_details -->

					<div class="col-md-4">
							<label class="text-dark fw-bold">Admission to Class<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">
								<select class="form-select js-choice border-0 z-index-9 bg-transparent" aria-label=".form-select-sm" name="admission_class" required>
									<option value="">Class</option>
									<option value="bc">Baby Class</option>
									<option value="lkg">LKG Class</option>
									<option value="ukg">UKG Class</option>
									<option value="1">1<sup>st</sup></option>
									<option value="2">2<sup>nd</sup></option>
									<option value="3">3<sup>rd</sup></option>
									<option value="4">4<sup>th</sup></option>
									<option value="5">5<sup>th</sup></option>
									<option value="6">6<sup>th</sup></option>
									<option value="7">7<sup>th</sup></option>
									<option value="8">8<sup>th</sup></option>
									<option value="9">9<sup>th</sup></option>
									<option value="10">10<sup>th</sup></option>
								</select>
							</div>
						</div>

						<!-- Semester -->
						<div class="col-md-4">
							<label class="text-dark fw-bold">Semster<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">
								<select class="form-select js-choice border-0 z-index-9 bg-transparent" aria-label=".form-select-sm" name="admission_semster" required>
									<option value="">Semster</option>
									<option value="sem1">Semester 1</option>
									<option value="sem2">Semester 2</option>									
								</select>
							</div>
						</div>

						<!-- Medium of Instruction -->
						<div class="col-md-4">
							<label class="text-dark fw-bold">Medium of Instruction<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">								
								<select class="form-select js-choice border-0 z-index-9 bg-transparent" aria-label=".form-select-sm" name="admission_moi" required>
									<option value="">Medium of Instruction</option>
									<option value="kannada">Kannada</option>
									<option value="hindi">Hindi</option>
									<option value="urdu">Urdu</option>
									<option value="english">English</option>	
									<option value="marathi">Marathi</option>
									<option value="tamil">Tamil</option>
									<option value="telugu">Telugu</option>								
								</select>
							</div>
						</div>

						<!-- Mother tongue -->
						<div class="col-md-4"></div>

						<div class="col-md-4">
							<label class="text-dark fw-bold" for="browser">Mother Tongue<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">								
								<input list="mt" name="admission_mt" id="browser" class="form-control border-0 me-1">
								  <datalist id="mt">
								    <option value="kannada">
								    <option value="hindi">
								    <option value="urdu">
								    <option value="english">
								    <option value="marathi">
								    <option value="tamil">
								    <option value="telugu">
								  </datalist>
							</div>
						</div>
						<div class="col-md-4"></div>						
						<hr>
						<h3>Previous School Details(If Applicable) <button class="btn btn-danger float-end not_applicable" type="button">Not applicable</button><button class="btn btn-success float-end show_applicable" type="button">Show applicable</button></h3>
						
						<!-- Name -->
						<div class="col-md-4 apl">
							<label class="text-dark fw-bold" for="psa1">Previous School Affiliation<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">								
								<input list="psa" name="psa" id="psa1" class="form-control border-0 me-1 s_afflication">
								  <datalist id="psa">
								    <option value="state">
								    <option value="cbse">
								    <option value="icse">								    
								  </datalist>
							</div>
						</div>

						<div class="col-md-4 apl">
							<label class="text-dark fw-bold" for="psa2">Transfer Certificate No.</label>
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1 t_c" type="text" placeholder="Transfer Certificate No" name="tc" autocomplete="nope" id="psa2" required>
								</div>
							</div>
						</div>

						<div class="col-md-4 apl">
							<label class="text-dark fw-bold" for="psa3">Transfer Certificate Date.</label>
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1 t_d" type="date" placeholder="Transfer Certificate No" name="tcd" autocomplete="nope" id="psa3" required>
								</div>
							</div>
						</div>

						<div class="col-md-4 apl">
							<label class="text-dark fw-bold" for="psa4">Previous School Name<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1 p_s" type="text" placeholder="Previous School Name" name="psn" autocomplete="nope" value="" id="psa4" required>
								</div>
							</div>
						</div>


						<div class="col-md-4 apl">
							<label class="text-dark fw-bold">Previous School Type<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">
								<select class="form-select js-choice border-0 z-index-9 bg-transparent p_s_t" aria-label=".form-select-sm" name="pst" required>
									<option value="0">Previous School Type</option>
									<option value="sem1">Government School</option>
									<option value="sem1">Private Aided School</option>
									<option value="sem1">Local Bodies</option>
									<option value="sem1">Private Unaided School</option>
								</select>
							</div>
						</div>

						<div class="col-md-4 apl">
							<label class="text-dark fw-bold" for="psa5">Pincode</label>
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1 p_c" type="number" placeholder="Enter Pincode" name="prev_pincode" autocomplete="nope" value="" id="psa5" required>
								</div>
							</div>
						</div>


						<div class="col-md-4 apl">
							<label class="text-dark fw-bold" for="dis1">District<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">								
								<input list="dis" name="prev_dis" id="dis1" class="form-control border-0 me-1 d">
								  <datalist id="dis">
								    <option value="Bengaluru_Urban">
								    <option value="Belagavi">
								    <option value="Bidar">
								    <option value="Dharwad">
								    <option value="Bidar">
								    <option value="Chikkamagaluru">								    
								  </datalist>
							</div>
						</div>

						<div class="col-md-4 apl">
							<label class="text-dark fw-bold" for="tal1">Taluk<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">								
								<input list="tal" name="prev_tal" id="tal1" class="form-control border-0 me-1 t">
								  <datalist id="tal">
								    <option value="Bengaluru taluk">
								    <option value="Belagavi taluk">
								    <option value="Bidar taluk">
								    <option value="Dharwad taluk">
								    <option value="Bidar taluk">
								    <option value="Chikkamagaluru taluk">								    
								  </datalist>
							</div>
						</div>

						<div class="col-md-4 apl">
							<label class="text-dark fw-bold" for="psa_city">City/Village/Town<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1 c" type="text" placeholder="Enter City/Village/Town" name="prev_city" autocomplete="nope" value="" id="psa_city" required>
								</div>
							</div>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-8 apl">
							<label class="text-dark fw-bold" for="floatingTextarea">Previous School Address</label>
							<div class="form-floating">
							  <textarea class="form-control p_add" placeholder="Leave a comment here" id="floatingTextarea" name="prev_school_address"></textarea>
							  <!-- <label for="floatingTextarea"></label> -->
							</div>
						</div>


						<!-- Contact Details -->


						<h3 class="text-center">Admission Details</h3>
						<!-- Class -->
						
						
						
						
											
						<h3>Student Contact Details</h3>
						<div class="col-md-4">
							<label class="text-dark fw-bold" for="pincode">Pincode<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1" type="number" placeholder="Enter Pincode" name="number" autocomplete="nope" value="" id="pincode" required>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<label class="text-dark fw-bold" for="stdis1">District<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">								
								<input list="stdis" name="stdis" id="stdis1" class="form-control border-0 me-1">
								  <datalist id="stdis">
								    <option value="Bengaluru_Urban">
								    <option value="Belagavi">
								    <option value="Bidar">
								    <option value="Dharwad">
								    <option value="Bidar">
								    <option value="Chikkamagaluru">								    
								  </datalist>
							</div>
						</div>

						<div class="col-md-4">
							<label class="text-dark fw-bold" for="sttal1">Taluk<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">								
								<input list="sttal" name="sttal" id="sttal1" class="form-control border-0 me-1">
								  <datalist id="sttal">
								    <option value="Bengaluru taluk">
								    <option value="Belagavi taluk">
								    <option value="Bidar taluk">
								    <option value="Dharwad taluk">
								    <option value="Bidar taluk">
								    <option value="Chikkamagaluru taluk">								    
								  </datalist>
							</div>
						</div>

						<div class="col-md-4">
							<label class="text-dark fw-bold" for="city">City/Village/Town<span style="color:red;">*</span></label>
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1" type="text" placeholder="Enter City/Village/Town" name="number" autocomplete="nope" value="" id="city" required>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<label class="text-dark fw-bold" for="locality">Locality</label>
							<div class="bg-body shadow rounded-pill p-2">
								<div class="input-group">
									<input class="form-control border-0 me-1" type="text" placeholder="Enter Locality" name="number" autocomplete="nope" value="" id="locality" required>
								</div>
							</div>
						</div>
						<!-- <div class="col-md-2"></div> -->
						<div class="col-md-4">
							<label class="text-dark fw-bold" for="stdfloatingTextarea">Address<span style="color:red;">*</span></label>
							<div class="form-floating">
							  <textarea class="form-control" placeholder="Leave a comment here" id="stdfloatingTextarea"></textarea>
							  <!-- <label for="floatingTextarea"></label> -->
							</div>
						</div>

						<div class="col-md-4">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold">Student Mobile number & Email Id</label>
										<div class="bg-body shadow rounded-pill p-2">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="number" placeholder="Enter Mobile number" name="student_mobile_number" autocomplete="nope" value="" required>												
											</div>								
										</div>	
										<div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="text" placeholder="Enter student Email Id" name="student_email_id" autocomplete="nope" value="" required>												
											</div>
										</div>									
								</div>
							</div>						
						</div>

						<div class="col-md-4">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold">Father Mobile number<span style="color:red;">*</span> & Email Id</label>
										<div class="bg-body shadow rounded-pill p-2">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="number" placeholder="Father Mobile number" name="father_mobile_number" autocomplete="nope" value="" required>												
											</div>								
										</div>	
										<div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="text" placeholder="Enter Father Email Id" name="father_email_id" autocomplete="nope" value="" required>												
											</div>
										</div>									
								</div>
							</div>						
						</div>
						<div class="col-md-4">
							<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
  								<div class="card-body" style="background:#fff;">
									<label class="text-dark fw-bold">Mother Mobile number & Email Id</label>
										<div class="bg-body shadow rounded-pill p-2">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="number" placeholder="Mother Mobile number" name="mother_mobile_number" autocomplete="nope" value="" required>												
											</div>								
										</div>	
										<div class="bg-body shadow rounded-pill p-2" style="margin-top:10px;">
											<div class="input-group">
												<input class="form-control border-0 me-1" type="text" placeholder="Enter Mother Email Id" name="mother_email_id" autocomplete="nope" value="" required>												
											</div>
										</div>									
								</div>
							</div>						
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<button class="btn btn-success" style="width:100%;">Submit</button>
						</div>
						<div class="col-md-4"></div>