<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");
date_default_timezone_set("America/Toronto");
$datetime_at = date('Y-m-d H:i:s');

if (!isset($_SESSION['sno'])) {
	header("Location: ../../login");
	exit();
}

if (isset($_POST['sbmtTeacher'])) {
	$snom = $_POST['snom'];
	$m_intake33 = $_POST['m_intake'];
	if (!empty($_POST['program_name'])) {
		$program_name33 = $_POST['program_name'];
	} else {
		$program_name33 = '';
	}
	if (!empty($_POST['module_start_date'])) {
		$module_start_date33 = $_POST['module_start_date'];
	} else {
		$module_start_date33 = '';
	}
	$module_days33 = $_POST['module_days'];
	$shift_time33 = $_POST['shift_time'];
	$teacher_id33 = $_POST['teacher_id'];
	$status33 = $_POST['status'];
	$loggedId2 = $_POST['loggedId'];

	if (empty($snom)) {
		$qryInsert = "INSERT INTO `m_batch` (`m_intake`, `program_name`, `shift_time`, `created_on`, `status`, `teacher_id`, `module_start_date`, `module_days`) VALUES ('$m_intake33', '$program_name33', '$shift_time33', '$datetime_at', '$status33', '$teacher_id33', '$module_start_date33', '$module_days33')";
		mysqli_query($con, $qryInsert);
		$lastIdInsrt = mysqli_insert_id($con);

		$dddds3 = "SELECT sno, batch_name, batch_count FROM `m_batch` WHERE batch_name!='' ORDER BY sno DESC LIMIT 1";
		$getrslts3 = mysqli_query($con, $dddds3);
		$rowSrlNo3 = mysqli_fetch_assoc($getrslts3);
		$batch_count = $rowSrlNo3['batch_count'];
		$cntSrlNo2 = $batch_count + 1;
		$cntSrlNo3 = date('y') . '' . $cntSrlNo2;

		$qryUpdate2 = "UPDATE `m_batch` SET `batch_name`='$cntSrlNo3', `batch_count`='$cntSrlNo2' WHERE `sno`='$lastIdInsrt'";
		mysqli_query($con, $qryUpdate2);

	} else {
		$qryUpdate = "UPDATE `m_batch` SET `m_intake`='$m_intake33', `shift_time`='$shift_time33', `status`='$status33', `created_on`='$datetime_at', `teacher_id`='$teacher_id33', `module_days`='$module_days33' WHERE `sno`='$snom'";
		mysqli_query($con, $qryUpdate);

		$qryUpdate3 = "UPDATE `m_student` SET `shift_time`='$shift_time33', `teacher_id`='$teacher_id33' WHERE betch_no='$snom'";
		mysqli_query($con, $qryUpdate3);

		$dddds4 = "SELECT sno, batch_name FROM `m_batch` WHERE sno='$snom'";
		$getrslts4 = mysqli_query($con, $dddds4);
		$rowSrlNo4 = mysqli_fetch_assoc($getrslts4);
		$batch_name44 = $rowSrlNo4['batch_name'];

		$rsltAttendance = "UPDATE `m_attendance` SET `shift_time`='$shift_time33', `teacher_id`='$teacher_id33' WHERE batch_name='$batch_name44'";
		mysqli_query($con, $rsltAttendance);
	}

	$pmsg = base64_encode('TeacherAdded&Updated');
	header("Location: batchLists.php?msg=Success&$pmsg");
}

if (isset($_POST['previewTeacher'])) {
	$snom = mysqli_real_escape_string($con, $_POST['snom']);
	$m_intake33 = $_POST['m_intake'];
	$program_name33 = $_POST['program_name'];
	$module_start_date33 = $_POST['module_start_date'];
	$module_days33 = $_POST['module_days'];
	$shift_time33 = $_POST['shift_time'];
	$teacher_id33 = $_POST['teacher_id'];
	$status33 = $_POST['status'];
	$loggedId2 = $_POST['loggedId'];

	header("Location: batchAdd.php?sno=$snom&mitke=$m_intake33&pnGet=$program_name33&msdate=$module_start_date33&mdys=$module_days33&sftme=$shift_time33&tid=$teacher_id33&status=$status33");
}


if (!empty($_GET['sno'])) {
	$prmsno = $_GET['sno'];
	$AddEditHead = 'View/Edit';
} else {
	$prmsno = '';
	$AddEditHead = 'Add New';
}

if (!empty($_GET['pnGet'])) {
	$snoM = $_GET['sno'];
	$m_intake = $_GET['mitke'];
	$program_name = $_GET['pnGet'];
	$module_start_date = $_GET['msdate'];
	$module_days = $_GET['mdys'];
	$shift_time2 = $_GET['sftme'];
	$status2 = $_GET['status'];
	$teacher_id2 = $_GET['tid'];
} else {

	$resultsStr = "SELECT * FROM m_batch WHERE sno='$prmsno'";
	$get_query = mysqli_query($con, $resultsStr);
	if (mysqli_num_rows($get_query)) {
		$rowModule = mysqli_fetch_assoc($get_query);
		$snoM = $rowModule['sno'];
		$m_intake = $rowModule['m_intake'];
		$program_name = $rowModule['program_name'];
		$prgmNameDisabled = 'disabled';
		$module_start_date = $rowModule['module_start_date'];
		$module_days = $rowModule['module_days'];
		$shift_time2 = $rowModule['shift_time'];
		$status2 = $rowModule['status'];
		$teacher_id2 = $rowModule['teacher_id'];
		$added_on = $rowModule['created_on'];
	} else {
		$snoM = '';
		$program_name = '';
		$prgmNameDisabled = '';
		$module_start_date = '';
		$module_days = '';
		$shift_time2 = '';
		$status2 = '';
		$teacher_id2 = '';
		$added_on = '';
	}
}
?>
<style>
	.error_color {
		border: 2px solid #de0e0e;
	}

	.validError {
		border: 2px solid #ccc;
	}
</style>
<section class="container-fluid">
	<div class="main-div card">
		<div class="card-header">
			<h3 class="my-0 py-0" style="font-size: 22px; "><?php echo $AddEditHead; ?> Batch
			</h3>
		</div>
		<div class="card-body">

			<form method="POST" action="" class="forms-sample row" autocomplete="off">

				<div class="form-group col-sm-6 col-md-4 col-lg-3">
					<label>Intake<span style="color:red;">*</span></label>
					<select name="m_intake" class="form-control mb-3 intake" required>
						<option value="">Select Intake</option>
						<option value="May-2024" <?php if ($m_intake == 'May-2024') {
							echo 'selected="selected"';
						} ?>>
							May-2024</option>
						<option value="JAN-2024" <?php if ($m_intake == 'JAN-2024') {
							echo 'selected="selected"';
						} ?>>
							JAN-2024</option>
						<option value="OLD" <?php if ($m_intake == 'OLD') {
							echo 'selected="selected"';
						} ?>>OLD</option>
					</select>
				</div>
				<div class="form-group col-sm-6 col-md-4 col-lg-3">
					<label>Program Name<span style="color:red;">*</span></label>
					<select name="program_name" class="form-control mb-3 program_name" <?php echo $prgmNameDisabled; ?>
						required>
						<option value="">Select Option</option>
						<?php
						$rsltQuery6 = "SELECT * FROM `contract_courses` GROUP BY program_name";
						$qurySql6 = mysqli_query($con, $rsltQuery6);
						while ($row_nm6 = mysqli_fetch_assoc($qurySql6)) {
							$program_name36 = $row_nm6['program_name'];
							?>
							<option value="<?php echo $program_name36; ?>" <?php if ($program_name36 == $getPName2) {
								   echo 'selected="selected"';
							   } ?>>
								<?php echo $program_name36; ?>
							</option>
						<?php } ?>
					</select>
				</div>

				<div class="form-group col-sm-6 col-md-4 col-lg-3">
					<label>Timing<span style="color:red;">*</span></label>
					<select name="shift_time" class="form-control mb-3" required>
						<option value="">Select Option</option>
						<option value="12.30PM – 4.30PM" <?php if ($shift_time2 == '12.30PM – 4.30PM') {
							echo 'selected="selected"';
						} ?>>12.30PM – 4.30PM</option>
						<option value="1PM – 5PM" <?php if ($shift_time2 == '1PM – 5PM') {
							echo 'selected="selected"';
						} ?>>1PM – 5PM</option>
						<option value="2PM – 7PM" <?php if ($shift_time2 == '2PM – 7PM') {
							echo 'selected="selected"';
						} ?>>2PM – 7PM</option>
						<option value="3PM – 8PM" <?php if ($shift_time2 == '3PM – 8PM') {
							echo 'selected="selected"';
						} ?>>3PM – 8PM</option>
						<option value="4PM – 9PM" <?php if ($shift_time2 == '4PM – 9PM') {
							echo 'selected="selected"';
						} ?>>4PM – 9PM</option>
						<option value="5PM – 9PM" <?php if ($shift_time2 == '5PM – 9PM') {
							echo 'selected="selected"';
						} ?>>5PM – 9PM</option>
						<option value="5PM – 10PM" <?php if ($shift_time2 == '5PM – 10PM') {
							echo 'selected="selected"';
						} ?>>5PM – 10PM</option>
						<option value="6PM – 10PM" <?php if ($shift_time2 == '6PM – 10PM') {
							echo 'selected="selected"';
						} ?>>6PM – 10PM</option>
						<option value="9PM – 2PM" <?php if ($shift_time2 == '9PM – 2PM') {
							echo 'selected="selected"';
						} ?>>9PM – 2PM</option>
						<option value="7AM – 11AM" <?php if ($shift_time2 == '7AM – 11AM') {
							echo 'selected="selected"';
						} ?>>7AM – 11AM</option>
						<option value="8AM – 12PM" <?php if ($shift_time2 == '8AM – 12PM') {
							echo 'selected="selected"';
						} ?>>8AM – 12PM</option>
						<option value="9AM – 1PM" <?php if ($shift_time2 == '9AM – 1PM') {
							echo 'selected="selected"';
						} ?>>9AM – 1PM</option>
						<option value="9AM – 2PM" <?php if ($shift_time2 == '9AM – 2PM') {
							echo 'selected="selected"';
						} ?>>9AM – 2PM</option>
						<option value="9:30AM – 1.30PM" <?php if ($shift_time2 == '9:30AM – 1.30PM') {
							echo 'selected="selected"';
						} ?>>9:30AM - 1.30PM</option>
						<option value="9:30AM – 2.30PM" <?php if ($shift_time2 == '9:30AM – 2.30PM') {
							echo 'selected="selected"';
						} ?>>9:30AM - 2.30PM</option>
					</select>
				</div>

				<div class="form-group col-sm-6 col-md-4 col-lg-3">
					<label>Instructor Name<span style="color:red;">*</span></label>
					<select name="teacher_id" class="form-control mb-3" required>
						<option value="">Select Option</option>
						<?php
						$counselor = "select sno, name from m_teacher where status='1' AND role='Teacher'";
						$counselorres = mysqli_query($con, $counselor);
						while ($datacouns = mysqli_fetch_assoc($counselorres)) {
							$sno33 = $datacouns['sno'];
							$name33 = $datacouns['name'];
							?>
							<option value="<?php echo $sno33; ?>" <?php if ($sno33 == $teacher_id2) {
								   echo 'selected="selected"';
							   } ?>><?php echo $name33; ?></option>
						<?php } ?>
					</select>
				</div>

				<div class="form-group col-sm-6 col-md-4 col-lg-3">
					<label>Module - Start Date<span style="color:red;">*</span></label>
					<input type="text" name="module_start_date" class="form-control mb-3 datepicker123"
						value="<?php echo $module_start_date; ?>" <?php echo $prgmNameDisabled; ?> required>
				</div>

				<input type="hidden" name="module_days" value="28">

				<div class="form-group col-sm-6 col-md-4 col-lg-3">
					<label>Status<span style="color:red;">*</span></label>
					<select name="status" class="form-control mb-3" required>
						<?php if (empty($snoM)) { ?>
							<option value="1" selected="selected">Active</option>
							<option value="2">De-Active</option>
						<?php } else { ?>
							<option value="">Select Option</option>
							<option value="1" <?php if ($status2 == '1') {
								echo 'selected="selected"';
							} ?>>Active</option>
							<option value="2" <?php if ($status2 == '2') {
								echo 'selected="selected"';
							} ?>>De-Active</option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group col-sm-6 col-md-4 col-lg-3 pt-sm-2">
					<input type="hidden" name="loggedId" value="<?php echo $sessionid1; ?>">
					<input type="hidden" name="snom" value="<?php echo $snoM; ?>">

					<button name="previewTeacher" type="submit"
						class="btn btn-warning mt-sm-4 ml-2 float-right float-sm-left mr-3">Preview Module Wise</button>

					<button name="sbmtTeacher" type="submit"
						class="btn btn-primary mt-sm-4 float-right float-sm-left mb-3">Save & Submit</button>
				</div>
			</form>

			<?php
			if (!empty($_GET['pnGet'])) {
				$pnGet = $_GET['pnGet'];
				$msdate = $_GET['msdate'];

				?>
				<div class="col-12">
					<div class="table-responsive">
						<table class="table table-striped table-sm text-center table-hover table-bordered">
							<thead>
								<tr class="bg-success">
									<th>Sno.</th>
									<th>Module Name</th>
									<th>Start Date</th>
									<th>End Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$qryModule = "SELECT sno, module_name FROM m_program_lists WHERE program2='$pnGet' order by sno asc";
								$rsltModule = mysqli_query($con, $qryModule);
								$srnoCnt = 1;
								$srnoCnt2 = 1;
								if (mysqli_num_rows($rsltModule)) {
									while ($rowModule = mysqli_fetch_assoc($rsltModule)) {
										$module_name = $rowModule['module_name'];
										$dddf = $srnoCnt++;
										if ($dddf == 1) {
											$mdys = $_GET['mdys'];
											$getaddDays = date('Y-m-d', strtotime($msdate . ' + ' . $mdys . ' days'));
										} else {
											$mdys = $_GET['mdys'] + 1;
											$getaddDays = date('Y-m-d', strtotime($getaddDays . ' + ' . $mdys . ' days'));
											$msdate = date('Y-m-d', strtotime($msdate . ' + ' . $mdys . ' days'));
										}
										?>
										<tr>
											<td><?php echo $srnoCnt2++; ?></td>
											<td style="white-space:nowrap;"><?php echo $module_name; ?></td>
											<td style="white-space:nowrap;"><?php echo $msdate; ?></td>
											<td style="white-space:nowrap;"><?php echo $getaddDays; ?></td>
										</tr>
									<?php }
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
	</div>
	</div>
</section>

<script>
	// $(document).on('click', '.program_name', function(){
	// var pname = $(this).val();
	// $.post("response.php?tag=getModuleName",{"pname":pname},function(d){
	// $('.moduleName').html("");
	// $(''+ d[0].moduleName + '').appendTo(".moduleName");
	// });
	// });
	// $(document).on('change', '.moduleName', function(){
	// var getVal = $('option:selected', this).attr('mcd-id');
	// $(".moduleName22").attr('value', getVal);
	// });
</script>