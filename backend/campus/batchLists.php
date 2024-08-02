<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

if (!isset($_SESSION['sno'])) {
	header("Location: ../../login");
	exit();
}

if (isset($_POST['srchClickbtn'])) {
	$search = $_POST['inputval'];
	$m_intake33 = $_POST['m_intake'];
	header("Location: ../campus/batchLists.php?getsearch=$search&m_intake=$m_intake33&page_no=1");
}

if (isset($_GET['getsearch']) && $_GET['getsearch'] != "") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (batch_name LIKE '%" . $searchTerm . "%')";
	$search_url = "&getsearch=" . $searchTerm . "";
} else {
	$searchInput = '';
	$search_url = '';
	$searchTerm = '';
}

if (isset($_GET['m_intake']) && $_GET['m_intake'] != "") {
	$m_intake2 = $_GET['m_intake'];
	$m_intake3 = "AND m_intake='$m_intake2'";
} else {
	$m_intake2 = 'May-2024';
	$m_intake3 = "AND m_intake='$m_intake2'";
}

if (isset($_POST['btnsbmtst'])) {
	$snoid3 = mysqli_real_escape_string($con, $_POST['snoid']);
	$status_batch = mysqli_real_escape_string($con, $_POST['status_batch']);
	$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	$updated_at = date('Y-m-d H:i:s');

	$qryUpdate = "UPDATE `m_batch` SET `status_batch`='$status_batch', `remarks`='$remarks', `updated_at`='$updated_at' WHERE sno='$snoid3'";
	mysqli_query($con, $qryUpdate);

	$qryUpdate2 = "UPDATE `m_student` SET `batch_status`='$status_batch' WHERE betch_no='$snoid3'";
	mysqli_query($con, $qryUpdate2);

	$getQry = "SELECT * FROM `m_student` WHERE betch_no='$snoid3'";
	$getRslt = mysqli_query($con, $getQry);
	while ($rowApp = mysqli_fetch_assoc($getRslt)) {
		$app_id = $rowApp['app_id'];
		$qryUpdate3 = "UPDATE `both_main_table` SET `tearcher_assign`='$status_batch' WHERE sno='$app_id'";
		mysqli_query($con, $qryUpdate3);
	}

	$pmsg = base64_encode('BatchAdded&Updated');
	header("Location: batchLists.php?msg=Success&$pmsg");
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
			<h3 class="my-0 py-0 " style="font-size: 22px; ">Batch Lists


			</h3>
		</div>

		<div class="card-body">
			<div class="row justify-content-between">


				<!--div class="col-sm-1 col-lg-1 mt-4 pt-2">
<form method="POST" action="excelSheet.php" autocomplete="off">
	<input type="hidden" name="role" value="<?php //echo 'Student_Status'; ?>">
	<input type="hidden" name="keywordLists" value="<?php //echo $searchTerm; ?>">
	<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right" >Download Excel</button>
</form>
</div-->

				<form action="" method="post" autocomplete="off" class="col-sm-6 col-lg-4 mb-3">

					<!-- <label><b>Filter by Batch Name:</b></label> -->
					<div class="input-group">
						<select name="m_intake" class="form-control form-control-sm mr-2">
							<option value="">Select Intake</option>
							<option value="May-2024" <?php if ($m_intake2 == 'May-2024') {
								echo 'selected="selected"';
							} ?>>May-2024</option>
							<option value="JAN-2024" <?php if ($m_intake2 == 'JAN-2024') {
								echo 'selected="selected"';
							} ?>>JAN-2024</option>
							<option value="OLD" <?php if ($m_intake2 == 'OLD') {
								echo 'selected="selected"';
							} ?>>OLD
							</option>
						</select>
						<input type="text" name="inputval" placeholder="Search By Batch Name"
							class="form-control form-control-sm" value="<?php echo $searchTerm; ?>">
						<div class="input-group-append">
							<input type="submit" name="srchClickbtn" class="btn btn-sm btn-success" value="Search">
						</div>
					</div>
				</form>

				<div class="col-sm-3 col-lg-3 mb-3">
					<a href="batchAdd.php" class="btn btn-sm btn-success float-right">Add New Batch</a>
				</div>


				<div class="col-12">
					<div class="table-responsive">
						<table class="table table-striped table-sm text-center table-hover table-bordered">
							<thead>
								<tr class="bg-success">
									<th>Batch Id</th>
									<th>Intake</th>
									<th>Program Name</th>
									<th>Timing</th>
									<th>Instructor Name</th>
									<th>Status</th>
									<th>Updated On</th>
									<th>Action</th>
									<th>Completed</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$qryModule = "SELECT * FROM m_batch WHERE batch_name!='' $searchInput $m_intake3 order by sno desc";
								$rsltModule = mysqli_query($con, $qryModule);
								$srnoCnt = 1;
								if (mysqli_num_rows($rsltModule)) {
									while ($rowModule = mysqli_fetch_assoc($rsltModule)) {
										$sno = $rowModule['sno'];
										$m_intake444 = $rowModule['m_intake'];
										$batch_name = $rowModule['batch_name'];
										$program_name = $rowModule['program_name'];
										$shift_time = $rowModule['shift_time'];
										$teacher_id = $rowModule['teacher_id'];
										$status2 = $rowModule['status'];
										if ($status2 == '1') {
											$status = 'Active';
										} else {
											$status = 'De-Active';
										}
										$created_on = $rowModule['created_on'];
										$status_batch = $rowModule['status_batch'];
										$remarks = $rowModule['remarks'];
										$updated_at = $rowModule['updated_at'];

										$qryTeacher2 = "select name from m_teacher where sno='$teacher_id'";
										$rsltTeacher2 = mysqli_query($con, $qryTeacher2);
										$rowTeacher2 = mysqli_fetch_assoc($rsltTeacher2);
										$Instructorname = $rowTeacher2['name'];
										?>
										<tr id="rowdelete_<?php echo $sno; ?>">
											<td><?php echo 'B' . $batch_name; ?></td>
											<td><?php echo $m_intake444; ?></td>
											<td><?php echo $program_name; ?></td>
											<td style="white-space:nowrap;"><?php echo $shift_time; ?></td>
											<td><?php echo $Instructorname; ?></td>
											<td><?php echo $status; ?></td>
											<td><?php echo $created_on; ?></td>
											<td style="white-space:nowrap;">
												<?php if ($status_batch == 'Completed') { ?>
													<button type="btn btn-sm btn-success  button" style="background: #437f3b;
	color: #fff;  pointer-events: auto! important;
	 cursor: not-allowed! important;
	border: #437f3b;
	border-radius: 4px;" disabled>Completed</button>
												<?php } else { ?>
													<a href="batchAdd.php?sno=<?php echo $sno; ?>&Batch"
														class="btn btn-sm btn-secondary text-white">View/Edit</a>
													<!--a href="javascript:void(0)" class="btn btn-danger btn-sm deleteBatch" dataid="<?php //echo $sno; ?>" title="Delete"><i class="fa fa-trash"></i></a-->
												<?php } ?>
												<a href="batchLogs.php?btchId=<?php echo $sno; ?>&Logs"
													class="btn btn-sm btn-info text-white">Logs</a>
											</td>
											<td style="white-space:nowrap;">
												<?php
												if ($status_batch == 'Completed') {
													echo '<b>Remarks: </b>' . $remarks . '<br>';
													echo '<b>Updated On: </b>' . $updated_at . '';
													?>
												<?php } else { ?>
													<span class="btn btn-sm btn-warning text-white statusClass" data-toggle="modal"
														data-target="#statusModal" data-id="<?php echo $sno; ?>">Add Status</span>
												<?php } ?>
											</td>
										</tr>
									<?php }
								} else {
									echo '<tr><td colspan="9"><center>Not Found!!!</center></td></tr>';
								}
								?>

							</tbody>
						</table>
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
				<h4 class="modal-title">Batch Status</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form method="post" action="" autocomplete="off">
					<div class="form-group">
						<label>Select Status<span style="color:red;">*</span></label>
						<select name="status_batch" class="form-control" required>
							<option value="">Select Option</option>
							<option value="Completed">Completed</option>
						</select>
					</div>
					<div class="form-group">
						<label>Any Remarks</label>
						<textarea name="remarks" class="form-control"></textarea>
					</div>
					<input type="hidden" class="snoidd" name="snoid" value="">
					<button type="submit" name="btnsbmtst" class="btn btn-sm btn-success">Submit to Complete</button>
				</form>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>



<script>
	$(document).on('click', '.statusClass', function () {
		var callerno = $(this).attr('data-id');
		$('.snoidd').attr('value', callerno);
	});
</script>

<script>
	
	$(document).on('click', '.deleteBatch', function (e) {
		e.stopPropagation();
		var deleteID = $(this).attr('dataid');
		var row = deleteID;
		if (confirm("Are you sure you want to delete this?")) {
			$.ajax({
				type: "POST",
				url: "response.php?tag=btchDelete",
				data: "deleteID=" + deleteID,
				success: function (result) {
					if (result == '1') {
						$('#rowdelete_' + row).fadeOut();
					} else {
						alert('Something went wrong. Please try again!!!');
						return false;
					}
				}
			});
		} else {
			return false;
		}
	});
</script>

<style type="text/css">
	.btn.btn-sm.btn-success.button {

		background: green;
		color: #fff;
		border: green;
		border-radius: 4px;
	}
</style>