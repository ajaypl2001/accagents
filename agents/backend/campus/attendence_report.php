<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

// if(($roles1 == 'ClgCM') || ($stu_att_rprt == 'Yes')){

// } else {
// 	header("Location: ../../login");
//     exit();
// }

if (isset($_POST['srchClickbtn'])) {
	$batchInput4 = $_POST['batchInput'];
	$inputval4 = $_POST['inputval'];
	$pNameInput4 = $_POST['pNameInput'];
	$from_atInput4 = $_POST['from_at'];
	$to_atInput4 = $_POST['to_at'];
	header("Location: ../campus/attendence_report.php?inputval=$inputval4&batchInput=$batchInput4&pNameInput=$pNameInput4&from_atInput=$from_atInput4&to_atInput=$to_atInput4&page_no=1");
}

if (!empty($_GET['batchInput'])) {
	$batchInput2 = $_GET['batchInput'];
	$batchInput3 = "AND batch_name='$batchInput2'";
} else {
	$batchInput2 = '';
	$batchInput3 = '';
}

if (!empty($_GET['pNameInput'])) {
	$pNameInput2 = $_GET['pNameInput'];
	$pNameInput3 = "AND program='$pNameInput2'";
} else {
	$pNameInput2 = '';
	$pNameInput3 = '';
}

if (!empty($_GET['from_atInput']) && !empty($_GET['to_atInput'])) {
	$from_atInput2 = $_GET['from_atInput'];
	$to_atInput2 = $_GET['to_atInput'];
	$dateInput3 = "AND (date_at BETWEEN '$from_atInput2' AND '$to_atInput2')";
} else {
	$from_atInput2 = '';
	$to_atInput2 = '';
	$dateInput3 = '';
}

if (isset($_GET['inputval']) && $_GET['inputval'] != "") {
	$inputval2 = $_GET['inputval'];
	$inputval3 = "AND (fullname LIKE '%" . $inputval2 . "%' OR student_no LIKE '%" . $inputval2 . "%')";
} else {
	$inputval2 = '';
	$inputval3 = '';
}

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$total_records_per_page = 110;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records, SUM(status) as totalh FROM m_attendance where date_at!='' $batchInput3 $pNameInput3 $dateInput3 $inputval3");
$total_records2 = mysqli_fetch_assoc($result_count);
$total_records = $total_records2['total_records'];
$totalh = $total_records2['totalh'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltAttendance = "SELECT * FROM m_attendance where date_at!='' $batchInput3 $pNameInput3 $dateInput3 $inputval3 order by date_at desc LIMIT $offset, $total_records_per_page";
$queryAttendance = mysqli_query($con, $rsltAttendance);
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
			<h3 class="my-0 py-0" style="font-size: 22px;">Attendance Report</h3>
		</div>
		<div class="card-body">
			<div class="row justify-content-between mt-4">
				<form action="" method="post" autocomplete="off" class="col-sm-12">
					<div class="row">
						<div class="col-sm-6 col-md-4 col-xl-2 mb-3">
							<label><b>Program Name:</b></label>
							<div class="input-group input-group-sm">
								<select name="pNameInput" class="form-control form-control-sm attProgramDiv">
									<option value="">Filter by Program</option>
									<?php
									$rsltQuery2 = "SELECT program_name FROM m_batch WHERE status='1' AND program_name!='' Group by program_name ORDER BY program_name ASC";
									$qurySql2 = mysqli_query($con, $rsltQuery2);
									while ($row_nm2 = mysqli_fetch_assoc($qurySql2)) {
										$program_name2 = $row_nm2['program_name'];
										?>
										<option value="<?php echo $program_name2; ?>" <?php if ($program_name2 == $pNameInput2) {
											   echo 'selected="selected"';
										   } ?>>
											<?php echo $program_name2; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-xl-2 mb-3">
							<label><b>Batch Name:</b></label>
							<div class="input-group input-group-sm">
								<select name="batchInput" class="form-control form-control-sm batchDiv">
									<option value="">Filter by Batch</option>
									<?php
									$rsltQuery1 = "SELECT sno, batch_name FROM `m_batch` WHERE program_name!='' AND program_name='$pNameInput2' group by batch_name";
									$qurySql1 = mysqli_query($con, $rsltQuery1);
									if (mysqli_num_rows($qurySql1)) {
										while ($row_nm1 = mysqli_fetch_assoc($qurySql1)) {
											$batch_name1 = $row_nm1['batch_name'];
											?>
											<option value="<?php echo $batch_name1; ?>" <?php if ($batch_name1 == $batchInput2) {
												   echo 'selected="selected"';
											   } ?>>B<?php echo $batch_name1; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>


						<div class="col-sm-6 col-md-4 col-xl-2 mb-3">
							<label><b>Date From:</b></label>
							<div class="input-group input-group-sm">
								<input type="text" name="from_at" placeholder="Attendance Form Date"
									class="form-control form-control-sm datepicker123"
									value="<?php echo $from_atInput2; ?>" required>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-xl-2 mb-3">
							<label><b>Date To:</b></label>
							<div class="input-group input-group-sm">
								<input type="text" name="to_at" placeholder="Attendance To Date"
									class="form-control form-control-sm datepicker123"
									value="<?php echo $to_atInput2; ?>" required>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-xl-2 mb-3">
							<label><b>Name &amp; ID:</b></label>
							<div class="input-group input-group-sm">
								<input type="text" name="inputval" placeholder="Search By Stu. Name or ID"
									class="form-control " value="<?php echo $inputval2; ?>">
							</div>
						</div>
						<div class="col-sm-6 col-md-4 col-xl-2 mt-sm-4 pt-2 mb-3">
							<div class=" text-sm-left text-right">

								<input type="submit" name="srchClickbtn"
									class="input-group-append btn btn-sm btn-success float-sm-left float-right"
									value="Search">
							</div>
						</div>

					</div>
				</form>

				<div class="col-sm-12 mb-3 text-right">
					<?php
					if (mysqli_num_rows($queryAttendance) && !empty($to_atInput2) && !empty($from_atInput2)) {
						?>
						<form method="POST" action="excelSheetDailyAttReport.php" autocomplete="off">
							<input type="hidden" name="role" value="Attendance Report">
							<input type="hidden" name="batchInput" value="<?php echo $batchInput2; ?>">
							<input type="hidden" name="inputval" value="<?php echo $inputval2; ?>">
							<input type="hidden" name="to_atInput" value="<?php echo $to_atInput2; ?>">
							<input type="hidden" name="from_atInput" value="<?php echo $from_atInput2; ?>">
							<button type="submit" name="studentlist" class="btn btn-sm btn-success ">Download Excel</button>
						</form>
					<?php } ?>
				</div>

				<div class="col-12">
					<?php
					if (mysqli_num_rows($queryAttendance) && !empty($to_atInput2) && !empty($from_atInput2)) {
						?>
						<p style="text-align: center;"><b>No of Student: </b><?php echo $total_records; ?>, <b>Total Hours:
							</b><?php echo $totalh; ?></p>
					<?php } ?>
					<div class="table-responsive">
						<table class="table table-sm table-bordered" width="100%">
							<thead>
								<tr class="bg-success text-white">
									<th>Batch Name</th>
									<th>Intake</th>
									<th>Teacher Name</th>
									<th>Student Name</th>
									<th>Program Name</th>
									<th>Timing</th>
									<th>Module Name</th>
									<th>vNumber</th>
									<th>Start Date(LOA)</th>
									<th>Attendance Date</th>
									<th>Hours</th>
									<!--th>Running Average</th-->
								</tr>
							</thead>
							<tbody>
								<?php
								if (mysqli_num_rows($queryAttendance) && !empty($to_atInput2) && !empty($from_atInput2)) {
									while ($rowAttendance = mysqli_fetch_assoc($queryAttendance)) {
										$batch_name2 = $rowAttendance['batch_name'];
										$fullname = $rowAttendance['fullname'];
										$student_no = $rowAttendance['student_no'];
										$intake = $rowAttendance['intake'];
										$start_date = $rowAttendance['start_date'];
										$program = $rowAttendance['program'];
										$module_name = $rowAttendance['module_name'];
										$shift_time = $rowAttendance['shift_time'];
										$date_at = $rowAttendance['date_at'];
										$time_at = $rowAttendance['time_at'];
										$status = $rowAttendance['status'];
										$teacher_id = $rowAttendance['teacher_id'];
										// $status22 = count($status);
								
										$getQry33 = "SELECT name FROM `m_teacher` WHERE sno='$teacher_id'";
										$getRslt33 = mysqli_query($con, $getQry33);
										$rowTN = mysqli_fetch_assoc($getRslt33);
										$nameTN = $rowTN['name'];
										?>
										<tr>
											<td style="white-space: nowrap;">B<?php echo $batch_name2; ?></td>
											<td style="white-space: nowrap;"><?php echo $intake; ?></td>
											<td style="white-space: nowrap;"><?php echo $nameTN; ?></td>
											<td style="white-space: nowrap;"><?php echo $fullname; ?></td>
											<td style="white-space: nowrap;"><?php echo $program; ?></td>
											<td style="white-space: nowrap;"><?php echo $shift_time; ?></td>
											<td style="white-space: nowrap;"><?php echo $module_name; ?></td>
											<td style="white-space: nowrap;"><?php echo $student_no; ?></td>
											<td style="white-space: nowrap;"><?php echo $start_date; ?></td>
											<td style="white-space: nowrap;"><?php echo $date_at; ?></td>
											<td style="white-space: nowrap;"><?php echo $status; ?></td>
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

				<?php
				if (mysqli_num_rows($queryAttendance) && !empty($to_atInput2) && !empty($from_atInput2)) {
					?>
					<div class="col-md-8 mt-2 pl-3">
						<strong>Total Records <?php echo $total_records; ?>, </strong>
						<strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
					</div>

					<div class="col-md-4 mt-2">
						<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-end">
								<?php if ($page_no > 1) {
									echo "<li><a href='?page_no=1' class='page-link'>First Page</a></li>";
								} ?>

								<li <?php if ($page_no <= 1) {
									echo "class='page-item disabled'";
								} ?>>
									<a <?php if ($page_no > 1) {
										echo "href='?page_no=$previous_page&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2'";
									} ?> class='page-link'>Previous</a>
								</li>

								<?php
								if ($total_no_of_pages <= 10) {
									for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
										if ($counter == $page_no) {
											echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
										} else {
											echo "<li class='page-item'><a href='?page_no=$counter&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>$counter</a></li>";
										}
									}
								} elseif ($total_no_of_pages > 10) {

									if ($page_no <= 4) {
										for ($counter = 1; $counter < 8; $counter++) {
											if ($counter == $page_no) {
												echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
											} else {
												echo "<li class='page-item'><a href='?page_no=$counter&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>$counter</a></li>";
											}
										}
										echo "<li><a>...</a></li>";
										echo "<li><a href='?page_no=$second_last&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>$second_last</a></li>";
										echo "<li><a href='?page_no=$total_no_of_pages&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>$total_no_of_pages</a></li>";
									} elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
										echo "<li class='page-item'><a href='?page_no=1&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>1</a></li>";
										echo "<li class='page-item'><a href='?page_no=2&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>2</a></li>";
										echo "<li class='page-item'><a class='page-link'>...</a></li>";
										for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
											if ($counter == $page_no) {
												echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
											} else {
												echo "<li class='page-item'><a href='?page_no=$counter&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>$counter</a></li>";
											}
										}
										echo "<li class='page-item'><a class='page-link'>...</a></li>";
										echo "<li class='page-item'><a href='?page_no=$second_last&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>$second_last</a></li>";
										echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>$total_no_of_pages</a></li>";
									} else {
										echo "<li class='page-item'><a href='?page_no=1&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>1</a></li>";
										echo "<li class='page-item'><a href='?page_no=2&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>2</a></li>";
										echo "<li class='page-item'><a class='page-link'>...</a></li>";

										for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
											if ($counter == $page_no) {
												echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
											} else {
												echo "<li class='page-item'><a href='?page_no=$counter&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>$counter</a></li>";
											}
										}
									}
								}
								?>

								<li <?php if ($page_no >= $total_no_of_pages) {
									echo "class='page-item disabled'";
								} ?>>
									<a <?php if ($page_no < $total_no_of_pages) {
										echo "href='?page_no=$next_page&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2'";
									} ?> class='page-link'>Next</a>
								</li>
								<?php if ($page_no < $total_no_of_pages) {
									echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&batchInput=$batchInput2&pNameInput=$pNameInput2&from_atInput=$from_atInput2&to_atInput=$to_atInput2&inputval=$inputval2' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
								} ?>
							</ul>
						</nav>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
</section>

<script>
	$(document).on('change', '.attProgramDiv', function () {
		var getBatch = $(this).val();
		$.post("response.php?tag=getAttBatchLists", { "getBatch": getBatch }, function (d) {
			$('.batchDiv').html("");
			$('' + d[0].attBatchDiv + '').appendTo(".batchDiv");
		});
	});
</script>