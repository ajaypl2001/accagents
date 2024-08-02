<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

// if($roles1 == 'ClgCM' || $roles1 == 'ClgAttd'){

// } else {
// 	header("Location: ../../login");
//     exit();
// }

if (!empty($_GET['intakeFltr'])) {
	$intakeFltr2 = $_GET['intakeFltr'];
	if ($intakeFltr2 == 'all') {
		$intakeFltr3 = "AND m_intake !=''";
	} else {
		$intakeFltr3 = "AND m_intake='$intakeFltr2'";
	}

} else {
	$intakeFltr2 = 'May-2024';
	$intakeFltr3 = "AND m_intake='$intakeFltr2'";
}
?>
<link rel="stylesheet" type="text/css" href="../../css/fixed-table.css">
<script src="../../js/fixed-table.js"></script>

<section class="container-fluid">

	<div class="main-div card">
		<div class="card-header">
			<div class="row justify-content-between">
				<div class="col-sm-8 col-lg-9 col-xl-10">
					<h3 class="my-0 py-0">Program Wise - Class List and Schedule</h3>
				</div>
				<div class="col-sm-4 col-lg-3 col-xl-2">
					<select name="intakeFltr" class="form-control form-control-sm intakeFltr">
						<option value="">Filter by Intake</option>
						<option value="all" data-id="all" <?php if ($intakeFltr2 == 'all') {
							echo 'selected="selected"';
						} ?>>ALL Intake</option>
						<option value="May-2024" data-id="May-2024" <?php if ($intakeFltr2 == 'May-2024') {
							echo 'selected="selected"';
						} ?>>May-2024</option>
						<option value="JAN-2024" data-id="JAN-2024" <?php if ($intakeFltr2 == 'JAN-2024') {
							echo 'selected="selected"';
						} ?>>JAN-2024</option>
						<option value="OLD" data-id="OLD" <?php if ($intakeFltr2 == 'OLD') {
							echo 'selected="selected"';
						} ?>>OLD</option>
					</select>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">

				<div class="col-12">
					<div id="accordion">
						<?php
						$rsltBatch5 = "SELECT sno, program_name,count(program_name) as numbers_list FROM m_batch where status='1' AND status_batch!='Completed' $intakeFltr3 group by program_name order by sno desc";
						$queryBatch5 = mysqli_query($con, $rsltBatch5);
						while ($rowBatch5 = mysqli_fetch_assoc($queryBatch5)) {
							$btchId5 = $rowBatch5['sno'];
							$program_name5 = $rowBatch5['program_name'];
							$numbers_list = $rowBatch5['numbers_list'];
							?>
							<div class="card">
								<div class="card-header">
									<a class="card-link" data-toggle="collapse" href="#first<?php echo $btchId5; ?>">
										<?php echo $program_name5; ?> &nbsp; <?php echo $numbers_list; ?>
									</a>
									<form method="POST" action="excelSheet.php" class="float-right Download-btn"
										autocomplete="off">
										<input type="hidden" name="role2" value="<?php echo $roles1; ?>">
										<input type="hidden" name="type2" value="Program_Wise">
										<input type="hidden" name="program_name2" value="<?php echo $program_name5; ?>">
										<button type="submit" name="studentlist" class="btn btn-link"><img
												src="../../images/xlsx.png" width="36" alt="xlsx"></button>
									</form>
								</div>
								<div id="first<?php echo $btchId5; ?>" class="collapse" data-parent="#accordion">
									<div class="card-body">
										<div class="fixed-table-container">

											<table class="" style="width: auto;">
												<tbody>
													<tr>

														<?php
														$rsltBatch6 = "SELECT * FROM m_batch where status='1' AND status_batch!='Completed' and program_name='$program_name5' $intakeFltr3 order by sno desc";
														$queryBatch6 = mysqli_query($con, $rsltBatch6);
														while ($rowBatch6 = mysqli_fetch_assoc($queryBatch6)) {
															$btchId6 = $rowBatch6['sno'];
															$batch_name6 = $rowBatch6['batch_name'];
															$program_name6 = $rowBatch6['program_name'];
															$shift_time6 = $rowBatch6['shift_time'];
															$teacher_id6 = $rowBatch6['teacher_id'];

															$queryGet6 = "SELECT name FROM `m_teacher` WHERE sno='$teacher_id6'";
															$queryRslt6 = mysqli_query($con, $queryGet6);
															$rowSC6 = mysqli_fetch_assoc($queryRslt6);
															$tchrName6 = $rowSC6['name'];

															$rsltQuery7 = "SELECT both_main_table.sno, both_main_table.fname, both_main_table.lname, both_main_table.student_id
FROM m_student
INNER JOIN both_main_table ON m_student.app_id=both_main_table.sno
WHERE m_student.teacher_id!='' AND m_student.betch_no='$btchId6'";
															$qurySql7 = mysqli_query($con, $rsltQuery7);
															$numStudentCount = mysqli_num_rows($qurySql7);

															$rsltQuery7_W_D = "SELECT start_college.app_id
FROM m_student
INNER JOIN start_college ON m_student.app_id=start_college.app_id
WHERE m_student.teacher_id!='' AND m_student.betch_no='$btchId6' AND with_dism!='' AND (start_college.with_dism='Withdrawal' OR start_college.with_dism='Dismissed')";
															$qurySql7_W_D = mysqli_query($con, $rsltQuery7_W_D);
															$numStudentCount7_W_D = mysqli_num_rows($qurySql7_W_D);
															$getNumSCWD7 = $numStudentCount - $numStudentCount7_W_D;
															?>
															<td class="p-0">
																<table class=" table-sm table-bordered"
																	style="min-width:250px;">
																	<thead>
																		<tr>
																			<th>B<?php echo $batch_name6; ?>
																				(<?php echo $getNumSCWD7; ?>)</th>
																		</tr>
																		<tr>
																			<th><?php echo $program_name6; ?></th>
																		</tr>
																		<tr>
																			<th><?php echo $shift_time6; ?></th>
																		</tr>
																		<tr>
																			<th><?php echo ucfirst($tchrName6); ?></th>
																		</tr>
																		<tr>
																			<th>
																				<span data-toggle="modal"
																					data-target="#statusModal"
																					class="btn btn-sm btn-dark statusClass"
																					batchId="<?php echo $btchId6; ?>"
																					batch_name="<?php echo $btchId6; ?>"
																					pgw="<?php echo $program_name6; ?>"><i
																						class="fas fa-plus"></i> Add
																					Student</span>
																			</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		if (mysqli_num_rows($qurySql7)) {
																			while ($row_nm7 = mysqli_fetch_assoc($qurySql7)) {
																				$snoid7 = $row_nm7['sno'];
																				$fname7 = $row_nm7['fname'];
																				$lname7 = $row_nm7['lname'];
																				$fullname7 = ucfirst($fname7) . ' ' . ucfirst($lname7);
																				$student_id7 = $row_nm7['student_id'];

																				$queryGet7 = "SELECT with_dism FROM `start_college` WHERE with_dism!='' AND (with_dism='Withdrawal' OR with_dism='Dismissed' OR with_dism='Re-enrolled') AND app_id='$snoid7' ORDER BY sno DESC";
																				$queryRslt7 = mysqli_query($con, $queryGet7);
																				if (mysqli_num_rows($queryRslt7)) {
																					$rowSC7 = mysqli_fetch_assoc($queryRslt7);
																					$wDReE7 = $rowSC7['with_dism'];
																					if ($wDReE7 == 'Re-enrolled') {
																						$with_dism7 = ' - ' . $wDReE7;
																					} else {
																						$with_dism7 = ' - <span style="color:red;"> ' . $wDReE7 . '</span>';
																					}
																				} else {
																					$with_dism7 = '';
																				}
																				?>
																				<tr>
																					<td><?php echo $fullname7 . ' (' . $student_id7 . ')' . $with_dism7; ?>
																					</td>
																				</tr>
																			<?php }
																		} else { ?>
																			<tr>
																				<td></td>
																			</tr>
																		<?php } ?>
																	</tbody>
																</table>
															</td>
														<?php } ?>

													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="main-div card">
		<div class="card-header">
			<h3 class="my-0 py-0">Batch Wise - Class List and Schedule

				<form method="POST" action="excelSheet.php" autocomplete="off">
					<input type="hidden" name="role2" value="<?php echo $roles1; ?>">
					<input type="hidden" name="type2" value="Batch_Wise">
					<input type="hidden" name="program_name2" value="<?php echo $program_name5; ?>">
					<button type="submit" name="studentlist" class="btn btn-link float-right Download-btn1"><img
							src="../../images/xlsx.png" width="36"></button>
				</form>
			</h3>
		</div>
		<div class="card-body">
			<div class="row">

				<div class="col-12">
					<div class="fixed-table-container">

						<table class="table table-sm table-bordered" style="width: auto;">
							<tr>
								<?php
								$rsltBatch = "SELECT * FROM m_batch where status='1' AND status_batch!='Completed' $intakeFltr3 order by program_name asc";
								$queryBatch = mysqli_query($con, $rsltBatch);
								while ($rowBatch = mysqli_fetch_assoc($queryBatch)) {
									$btchId = $rowBatch['sno'];
									$batch_name = $rowBatch['batch_name'];
									$program_name = $rowBatch['program_name'];
									$shift_time = $rowBatch['shift_time'];
									$teacher_id = $rowBatch['teacher_id'];

									$queryGet34 = "SELECT name FROM `m_teacher` WHERE sno='$teacher_id'";
									$queryRslt4 = mysqli_query($con, $queryGet34);
									$rowSC4 = mysqli_fetch_assoc($queryRslt4);
									$tchrName = $rowSC4['name'];

									$rsltQuery4 = "SELECT both_main_table.sno, both_main_table.fname, both_main_table.lname, both_main_table.student_id
FROM m_student
INNER JOIN both_main_table ON m_student.app_id=both_main_table.sno
WHERE m_student.teacher_id!='' AND m_student.betch_no='$btchId'";
									$qurySql4 = mysqli_query($con, $rsltQuery4);
									$numStudentCount4 = mysqli_num_rows($qurySql4);

									$rsltQuery4_W_D = "SELECT start_college.app_id
FROM m_student
INNER JOIN start_college ON m_student.app_id=start_college.app_id
WHERE m_student.teacher_id!='' AND m_student.betch_no='$btchId' AND with_dism!='' AND (start_college.with_dism='Withdrawal' OR start_college.with_dism='Dismissed')";
									$qurySql4_W_D = mysqli_query($con, $rsltQuery4_W_D);
									$numStudentCount4_W_D = mysqli_num_rows($qurySql4_W_D);
									$getNumSCWD4 = $numStudentCount4 - $numStudentCount4_W_D;
									?>
									<td class="p-0">
										<table class="table table-sm table-bordered" style="min-width:250px;">
											<thead>
												<tr>
													<th>B<?php echo $batch_name; ?> (<?php echo $getNumSCWD4; ?>)</th>
												</tr>
												<tr>
													<th><?php echo $program_name; ?></th>
												</tr>
												<tr>
													<th><?php echo $shift_time; ?></th>
												</tr>
												<tr>
													<th><?php echo ucfirst($tchrName); ?></th>
												</tr>
												<tr>
													<th>
														<span data-toggle="modal" data-target="#statusModal"
															class="btn btn-sm btn-dark statusClass"
															batchId="<?php echo $btchId; ?>"
															batch_name="<?php echo $btchId; ?>"
															pgw="<?php echo $program_name; ?>"><i class="fas fa-plus"></i>
															Add Student</span>
													</th>
												</tr>
											</thead>
											<td>
												<?php
												if (mysqli_num_rows($qurySql4)) {
													while ($row_nm = mysqli_fetch_assoc($qurySql4)) {
														$snoid2 = $row_nm['sno'];
														$fname = $row_nm['fname'];
														$lname = $row_nm['lname'];
														$fullname = ucfirst($fname) . ' ' . ucfirst($lname);
														$student_id = $row_nm['student_id'];

														$queryGet2 = "SELECT with_dism FROM `start_college` WHERE with_dism!='' AND (with_dism='Withdrawal' OR with_dism='Dismissed' OR with_dism='Re-enrolled') AND app_id='$snoid2' ORDER BY sno DESC";
														$queryRslt2 = mysqli_query($con, $queryGet2);
														if (mysqli_num_rows($queryRslt2)) {
															$rowSC = mysqli_fetch_assoc($queryRslt2);
															$wDReE = $rowSC['with_dism'];
															if ($wDReE == 'Re-enrolled') {
																$with_dism = ' - ' . $wDReE;
															} else {
																$with_dism = ' - <span style="color:red;"> ' . $wDReE . '</span>';
															}
														} else {
															$with_dism = '';
														}
														?>
														<tr>
															<td><?php echo $fullname . ' (' . $student_id . ')' . $with_dism; ?></td>
														</tr>
													<?php }
												} else { ?>
													<tr>
														<td></td>
													</tr>
												<?php } ?>
											</td>
										</table>
									</td>
								<?php } ?>
							</tr>
						</table>
					</div>

				</div>

			</div>
		</div>
	</div>

	</div>
	</div>
</section>

<div class="modal" id="statusModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Student Assign To Batch</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form method="post" action="" autocomplete="off" name="assign_register" id="assign_register">
					<div class="getAssignTchrStdntCS"></div>
					<input type="hidden" class="student_id" name="student_id" value="">
					<input type="hidden" class="v_no" name="v_no" value="">
					<input type="hidden" class="batch_nameDiv" name="batch_name" value="">
					<button type="submit" name="assign_submit" class="btn btn-link float-right assign_submit">Select &
						Click to Assign</button>
				</form>
			</div>

		</div>
	</div>
</div>


<style type="text/css">
	@media (min-width: 992px) {
		.modal-lg {
			max-width: 900px;
		}
	}


	.btn {
		transition: .3s;
	}

	.btn:hover {
		animation: pulse 1s infinite;
		transition: .3s;
	}

	@keyframes pulse {
		0% {
			transform: scale(1);
		}

		70% {
			transform: scale(.9);
		}

		100% {
			transform: scale(1);
		}
	}


	#accordion .card .card-header .card-link:hover {
		background-position: right bottom;
		color: #000;
	}


	.card-header {
		transition: transform 0.3s ease-in-out;
	}

	.card-header:hover {
		transform: scale(1.01);
	}

	.fixed-table-container td,
	.card-body .table-sm.table-bordered td,
	.fixed-table-container .table-sm.table-bordered td,
	.table-sm.table-bordered td {
		padding: 0px 10px !important;
		font-size: 12px;
	}

	.Download-btn1,
	.Download-btn {
		margin-top: -50px;
	}

	@media only screen and (min-width:600px) {

		.Download-btn1 {
			margin-top: -35px;
			margin-right: 5px;
		}
	}

	@media only screen and (min-width:480px) {

		.Download-btn {
			margin-top: -50px;
			margin-right: 5px;
		}
	}

	.fixed-table-container td:first-child {
		background: #fff;
	}

	.fixed-table-container th:first-child {
		background: #528f4a;
	}

	.table thead th {
		vertical-align: middle;
	}

	.fixed-table-container th i {
		opacity: 0.5;
	}

	.fixed-table-container th {
		width: 100px;
	}

	.table.table-sm.table-bordered thead {
		position: relative !important;
		z-index: 999 !important;
	}

	.fixed-table-container th,
	.fixed-table-container td {
		vertical-align: top
	}

	.fixed-table-container {
		overflow: scroll;
		background: #fff
	}

	.fixed-table-container tr:first-child th input[type=checkbox] {
		border: 3px solid #fff;
	}

	.fixed-table-container tr:first-child th {
		background: #437f3a;
	}

	input[type=checkbox] {
		position: relative;
		border: 3px solid #000;
		border-radius: 2px;
		background: none;
		cursor: pointer;
		line-height: 0;
		margin: 0 0 0 0;
		outline: 0;
		padding: 0 !important;
		vertical-align: text-top;
		height: 25px;
		width: 25px;
		-webkit-appearance: none;
		opacity: .7;
	}

	input[type=checkbox]:hover {
		opacity: 1;
	}

	input[type=checkbox]:checked {
		background-color: #447d3a;
		opacity: 1;
		border: 3px solid #447d3a;
	}

	input[type=checkbox]:checked:before {
		content: '';
		position: absolute;
		right: 50%;
		top: 50%;
		width: 8px;
		height: 15px;
		border: solid #FFF;
		border-width: 0 4px 4px 0;
		margin: -1px -1px 0 -1px;
		transform: rotate(45deg) translate(-50%, -50%);
		z-index: 2;
	}


	#accordion .card {
		margin-bottom: 10px;
		border: 0;
	}

	#accordion .card .card-header {
		border: 0;
		-webkit-box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
		box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
		border-radius: 2px;
		padding: 0;
	}

	#accordion .card .card-header .card-link {
		color: #fff;
		display: block;
		text-align: left;
		font-weight: 600;
		/*  background: #e5ede2;*/
		color: #222;
		border: 1px solid #d6e9cc;
		padding: 10px 20px;
		background-image: linear-gradient(to right, #d6e9cc 0%, #f9f9f9 51%, #fff 100%);
		background-size: 200% auto;
		background-position: left top;
	}

	#accordion .card .card-header .card-link:after {
		content: "\f107";
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
		float: right;
	}

	#accordion .card .card-header .card-link.collapsed {
		background: #eee;
		border: 1px solid #ccc;
	}

	#accordion .card .card-header .card-link.collapsed:after {
		content: "\f106";
	}

	#accordion .card .collapsing {
		background: #e5ede2;
		line-height: 30px;
	}

	#accordion .card .collapse {
		border: 0;
	}

	#accordion .card .collapse.show {
		background: #e5ede2;
		line-height: 30px;
		color: #222;
	}
</style>

<script>
	$(document).on('click', '.statusClass', function () {
		var batch_name = $(this).attr('batch_name');
		var pgw = $(this).attr('pgw');
		$('.batch_nameDiv').attr('value', batch_name);
		$.post("response.php?tag=getClassSchedule", { "batch_name": batch_name, "pgw": pgw }, function (d) {
			$('.getAssignTchrStdntCS').html("");
			$('' + d[0].getAssignTchrStdntCS + '').appendTo(".getAssignTchrStdntCS");
			if (d[0].notFoundClass == 'notFound') {
				$('button.btn.btn-sm.btn-success.float-right.assign_submit').hide();
			} else {
				$('button.btn.btn-sm.btn-success.float-right.assign_submit').show();
			}

			$(document).ready(function () {
				$('.checked_all').on('change', function () {
					$('.checkbox').prop('checked', $(this).prop("checked"));

					var ctyArray1 = [];
					var ctyArray12 = [];
					$(".cons_seen:checked").each(function () {
						ctyArray1.push($(this).val());
						ctyArray12.push($(this).attr('v-no'));
					});
					var countryid1 = ctyArray1.join(',');
					var countryid12 = ctyArray12.join(',');
					$('.student_id').attr('value', countryid1);
					$('.v_no').attr('value', countryid12);
				});

				$('.checkbox').change(function () {
					if ($('.checkbox:checked').length == $('.checkbox').length) {
						$('.checked_all').prop('checked', true);
					} else {
						$('.checked_all').prop('checked', false);
					}
				});

				$('.cons_seen').on('click', function () {
					var ctyArray1 = [];
					var ctyArray12 = [];
					$(".cons_seen:checked").each(function () {
						ctyArray1.push($(this).val());
						ctyArray12.push($(this).attr('v-no'));
					});
					var countryid1 = ctyArray1.join(',');
					var countryid12 = ctyArray12.join(',');
					$('.student_id').attr('value', countryid1);
					$('.v_no').attr('value', countryid12);
				});
			});

		});
	});

	$(function () {
		$('.assign_submit').click(function (e) {
			e.preventDefault();
			var student_id = $('.student_id').val();
			var batch_name = $('.batch_name').val();
			if (student_id == '' || batch_name == '') {
				alert("Please Select Student and Select Option!!!");
				return false;
			} else {
				var $form = $(this).closest("#assign_register");
				var formData = $form.serializeArray();
				var URL = "response.php?tag=assignTeacher";
				$.post(URL, formData).done(function (data) {
					if (data == 1) {
						alert("Student Assigned to Batch!!!");
						window.location.href = '../campus/class_list_schedule.php?msg=assign';
						return true;
					} else {
						alert("Something went wrong. Please contact to Administrator!!!");
						return false;
					}
				});
			}
		});
	});
</script>

<script>
	$(document).on('change', '.intakeFltr', function () {
		var statusVal = $('option:selected', this).attr('data-id');
		location.href = "../campus/class_list_schedule.php?intakeFltr=" + statusVal + "";
		return true;
	});	
</script>

<script>
	var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script>

<?php
include ("../../footer.php");
?>