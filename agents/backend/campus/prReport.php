<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");
date_default_timezone_set("America/Toronto");
$getCD = date('Y-m-d');

$date_at22_hdr = strtotime($getCD);
$getMonthYear_hdr = date('Y-m');

// if($roles1 == 'ClgCM' || $roles1 == 'APRStep'){

// } else {
// 	header("Location: ../../login");
//     exit();
// }

$showMonthStart_HDR = '';
$dssad_hdr = "SELECT start_date FROM `m_bi_weekly_start_date` where (start_date LIKE '%$getMonthYear_hdr%')";
$login_hdr = mysqli_query($con, $dssad_hdr);
while ($row_hdr = mysqli_fetch_array($login_hdr)) {
	$row2_hdr[] = $row_hdr['start_date'];
}
$getStartDate1_HDR = strtotime($row2_hdr[0]);
$endDate_HDR = strtotime($row2_hdr[0] . '+13 days');

$getStartDate2_HDR = strtotime($row2_hdr[1]);
$endDate2_HDR = strtotime($row2_hdr[1] . '+13 days');

if (!empty($row2_hdr[2])) {
	$getStartDate3_HDR = strtotime($row2_hdr[2]);
	$endDate3_HDR = strtotime($row2_hdr[2] . '+13 days');
} else {
	$getStartDate3_HDR = '';
	$endDate3_HDR = '';
}

if ($getStartDate1_HDR >= $date_at22_hdr || $date_at22_hdr <= $endDate_HDR) {
	$showMonthStart_HDR = $row2_hdr[0];
} elseif ($getStartDate2_HDR >= $date_at22_hdr || $date_at22_hdr <= $endDate2_HDR) {
	$showMonthStart_HDR = $row2_hdr[1];
} elseif ($getStartDate3_HDR >= $date_at22_hdr || $date_at22_hdr <= $endDate3_HDR) {
	$showMonthStart_HDR = $row2_hdr[2];
}


if (!empty($_GET['getDateSlot'])) {
	$getDateSlot = $_GET['getDateSlot'];
	$endDateSlot_Search = date("Y-m-d", strtotime($getDateSlot . "+13 day"));

	$newdate = date("d M Y", strtotime("$getDateSlot"));
	$end_date2 = date("d M Y", strtotime("$endDateSlot_Search"));
} else {
	$getDateSlot = $showMonthStart_HDR;
	$endDateSlot_Search = date("Y-m-d", strtotime($getDateSlot . "+13 day"));

	$newdate = date("d M Y", strtotime("$getDateSlot"));
	$end_date2 = date("d M Y", strtotime("$endDateSlot_Search"));
}

if (!empty($_GET['statusGet'])) {
	$StatusFilter = $_GET['statusGet'];
	$StatusFilter2 = "AND status='$StatusFilter'";
} else {
	$StatusFilter = '';
	$StatusFilter2 = '';
}
?>

<!-- <link rel="stylesheet" type="text/css" href="https://granville-college.com/agents/css/fixed-table.css">
<script src="https://granville-college.com/agents/js/fixed-table.js"></script> -->

<section class="container-fluid">
	<div class="main-div card">

		<div class="card-header">
			<h3 class="mt-0">
				<i class="far fa-calendar-alt"></i> Payroll Calculation
			</h3>

			<div class="row">
				<div class="col-12 col-sm-5 col-md-5 col-lg-4 col-xl-3 mb-2">
					<select class="bIWeeklyFilter form-control form-control-sm">
						<option value="">Select Bi Weekly Filter</option>
						<?php
						$qryBiWeekly = "SELECT sno, bi_weekly FROM `m_emp_instructor` group by bi_weekly ORDER BY sno DESC";
						$rsltBiWeekly = mysqli_query($con, $qryBiWeekly);
						while ($rowBiWeekly = mysqli_fetch_assoc($rsltBiWeekly)) {
							$bi_weekly = $rowBiWeekly['bi_weekly'];
							$toSE = explode('to', $bi_weekly);
							$start_date = date("Y-m-d", strtotime("$toSE[0]"));
							$end_date = date("Y-m-d", strtotime("$toSE[1]"));
							if ($start_date == $getDateSlot) {
								$selectedVal = 'selected="selected"';
							} else {
								$selectedVal = '';
							}
							?>
							<option value="<?php echo $start_date; ?>" data-id="<?php echo $start_date; ?>"
								end-id="<?php echo $end_date; ?>" <?php echo $selectedVal; ?>><?php echo $bi_weekly; ?>
							</option>
						<?php } ?>
					</select>
				</div>
				<div class="col-12 col-sm-5 col-md-5 col-lg-4 col-xl-3 mb-2">
					<select class="StatusFilter form-control form-control-sm">
						<option value="">Select Status</option>
						<option value="1" <?php if ($StatusFilter == '1') {
							echo 'selected="selected"';
						} ?>>Active</option>
						<option value="2" <?php if ($StatusFilter == '2') {
							echo 'selected="selected"';
						} ?>>De-Active
						</option>
					</select>
				</div>
				<div class="col-12 col-sm-2 col-md-2 col-lg-4 col-xl-6 text-sm-right">
					<form method="POST" action="excelSheetPayrollC.php" autocomplete="off">
						<input type="hidden" name="getDateSlot" value="<?php echo $getDateSlot; ?>">
						<input type="hidden" name="endDateSlot_Search" value="<?php echo $endDateSlot_Search; ?>">
						<input type="hidden" name="StatusFilter" value="<?php echo $StatusFilter; ?>">
						<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right">Download
							Excel</button>
					</form>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="row justify-content-between">

				<div class="col-12">
					<!-- <div id="fixed-table-container-1" class="fixed-table-container"> -->
					<div class="table-responsive secondaryContainer">
						<table class="table table-striped text-center table-sm table-hover table-bordered">
							<thead>
								<tr class="bg-success">
									<th align="left" class="text-left">Name</th>
									<th>Employee ID</th>
									<th>Status</th>
									<th>Bi Weekly</th>
									<th>Payroll type</th>
									<th>Sick Day Hrs</th>
									<th>OT Hrs</th>
									<th>Stat.</th>
									<th>Reg. Hrs</th>
									<th>Total Hrs</th>
									<th>Annual Salary</th>
									<th>Bi Weekly Salary</th>
									<th>Add/(Deduct)</th>
									<th>Commission</th>
									<th>VAC Pay</th>
									<th>Bonus</th>
									<th>Total Salary</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (empty($getDateSlot) && empty($endDateSlot_Search)) {
									echo '<tr><td colspan="16"><center>Please select Bi Weekly!!!</center></td></tr>';
								} else {
									$qryModule = "SELECT sno, name, emp_code, payroll_type, annual_salary, weekly, status FROM m_teacher WHERE payroll_type!='' $StatusFilter2 order by emp_code ASC";
									$rsltModule = mysqli_query($con, $qryModule);
									while ($rowModule = mysqli_fetch_assoc($rsltModule)) {
										$sno = $rowModule['sno'];
										$name = $rowModule['name'];
										$emp_code = $rowModule['emp_code'];
										$status2 = $rowModule['status'];
										if ($status2 == '1') {
											$statusT = 'Active';
										} else {
											$statusT = '<span style="color:red;">De-Active</span>';
										}
										$payroll_type = $rowModule['payroll_type'];
										$annual_salary = $rowModule['annual_salary'];
										$Weekly = $rowModule['weekly'];
										$biWeeklySalery = '';
										if ($payroll_type == 'Salaried') {
											$biWeeklySalery2 = $Weekly;
											$biWeeklyHourly = $biWeeklySalery2; //round($biWeeklySalery2,2);
										}
										$ot_hrs = '';
										$ot_hrs_empty = '';
										$sd_hrs = '';
										$sd_hrs_empty = '';
										$statHrs = '';
										$rglr_hrs = '';
										$rglr_hrs_empty = '';
										$TotalHours_33 = '';
										if ($payroll_type == 'Hourly') {
											$getDh = "SELECT SUM(daily_hourly) as total_hrs FROM `m_emp_instructor` WHERE status='P' AND m_instructor_id='$sno' AND (date_at BETWEEN '$getDateSlot' AND '$endDateSlot_Search')";
											$rsltDh = mysqli_query($con, $getDh);
											if (mysqli_num_rows($rsltDh)) {
												$totalHrs = mysqli_fetch_assoc($rsltDh);
												$total_hrs2 = $totalHrs['total_hrs'];
												if ($total_hrs2 == '0' || $total_hrs2 == NULL) {
													$rglr_hrs = '0';
													$rglr_hrs_empty = '';
												} else {
													$rglr_hrs = $total_hrs2;
													$rglr_hrs_empty = $total_hrs2;
												}
											} else {
												$rglr_hrs = '0';
												$rglr_hrs_empty = '';
											}

											$getDh_2 = "SELECT SUM(ot) as ot_hrs FROM `m_emp_instructor` WHERE (ot_status='Approved' OR ot_status='Partial-Approved') AND ot!='0' AND m_instructor_id='$sno' AND (date_at BETWEEN '$getDateSlot' AND '$endDateSlot_Search')";
											$rsltDh_2 = mysqli_query($con, $getDh_2);
											if (mysqli_num_rows($rsltDh_2)) {
												$totalHrs_2 = mysqli_fetch_assoc($rsltDh_2);
												$ot_hrs2 = $totalHrs_2['ot_hrs'];
												if ($ot_hrs2 == '0' || $ot_hrs2 == NULL) {
													$ot_hrs = '0';
													$ot_hrs_empty = '';
												} else {
													$ot_hrs = $ot_hrs2;
													$ot_hrs_empty = $ot_hrs2;
												}
											} else {
												$ot_hrs = '0';
												$ot_hrs_empty = '';
											}

											$getDh_3 = "SELECT SUM(sd) as sd_hrs FROM `m_emp_instructor` WHERE (sd_status='Approved' OR sd_status='Partial-Approved') AND sd!='0' AND m_instructor_id='$sno' AND (date_at BETWEEN '$getDateSlot' AND '$endDateSlot_Search')";
											$rsltDh_3 = mysqli_query($con, $getDh_3);
											if (mysqli_num_rows($rsltDh_3)) {
												$totalHrs_3 = mysqli_fetch_assoc($rsltDh_3);
												$sd_hrs2 = $totalHrs_3['sd_hrs'];
												if ($sd_hrs2 == '0' || $sd_hrs2 == NULL) {
													$sd_hrs = '0';
													$sd_hrs_empty = '';
												} else {
													$sd_hrs = $sd_hrs2;
													$sd_hrs_empty = $sd_hrs2;
												}
											} else {
												$sd_hrs = '0';
												$sd_hrs_empty = '';
											}

											$total_hrs = $rglr_hrs + $ot_hrs + $sd_hrs;
											$statHrs = '0'; //$rglr_hrs/10;
											$TotalHours_33 = $total_hrs + $statHrs;

											$biWeeklyHourly = ($statHrs + $rglr_hrs + $sd_hrs) * $annual_salary + ($ot_hrs * 1.5 * $annual_salary);
										}
										?>
										<tr>
											<td align="left" class="text-left text-nowrap"><?php echo ucfirst($name); ?></td>
											<td><?php echo $emp_code; ?></td>
											<td style="white-space: nowrap;"><?php echo $statusT; ?></td>
											<td style="white-space: nowrap;"><?php echo $newdate . ' to ' . $end_date2; ?></td>
											<td><?php echo $payroll_type; ?></td>
											<td><?php echo $sd_hrs_empty; ?></td>
											<td><?php echo $ot_hrs_empty; ?></td>
											<td><?php //echo $statHrs; ?></td>
											<td><?php echo $rglr_hrs_empty; ?></td>
											<td><?php echo $TotalHours_33; ?></td>
											<td>$<?php echo $annual_salary; ?></td>
											<td>$<?php echo $biWeeklySalery . '' . $biWeeklyHourly; ?></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>$<?php echo $biWeeklySalery . '' . $biWeeklyHourly; ?></td>
										</tr>
									<?php } ?>
								<?php } ?>

							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$(document).on('change', '.bIWeeklyFilter', function () {
		var getVal = $(this).val();
		var statusGet = $('.StatusFilter').val();
		var statusVal = $('option:selected', this).attr('data-id');
		var statusVal2 = $('option:selected', this).attr('end-id');
		if (getVal == '') {
			alert("Select Date!!!");
			return false;
		} else {
			location.href = "../campus/prReport.php?getDateSlot=" + statusVal + "&endDateSlot=" + statusVal2 + "&statusGet=" + statusGet + "";
			return true;
		}
	});

	$(document).on('change', '.StatusFilter', function () {
		var getVal = $('.bIWeeklyFilter').val();
		var statusGet = $('.StatusFilter').val();
		var statusVal = $('option:selected', '.bIWeeklyFilter').attr('data-id');
		var statusVal2 = $('option:selected', '.bIWeeklyFilter').attr('end-id');
		if (getVal == '') {
			alert("Select Date!!!");
			return false;
		} else {
			location.href = "../campus/prReport.php?getDateSlot=" + statusVal + "&endDateSlot=" + statusVal2 + "&statusGet=" + statusGet + "";
			return true;
		}
	});
</script>


<style type="text/css">
	.table {
		overflow: scroll;
		border-collapse: collapse;
		background: white;
	}

	.secondaryContainer {
		overflow: scroll;
		border-collapse: collapse;
		height: 660px;
		border: 2px solid rgba(255, 255, 255, 0.3);
		border-radius: 10px;
	}

	.table thead tr th {
		white-space: nowrap;
		position: sticky;
		background: #3a7f3e;
		top: 0;
	}


	.secondaryContainer::-webkit-scrollbar-track {
		border: 3px solid #3a7f3e;
		-webkit-box-shadow: inset 0 0 6px #3a7f3e;
		background-color: #F5F5F5;
	}

	.secondaryContainer::-webkit-scrollbar {
		width: 10px;
		height: 10px;
		background-color: #F5F5F5;
	}

	.secondaryContainer::-webkit-scrollbar-thumb {
		background-color: #000000;
		border: 2px solid #555555;
	}

	.table td .form-control {
		padding: 2px 5px !important;
		height: 24px;
		line-height: 18px;
		font-size: 15px;
		text-align: center;
		width: 35px;
	}

	@media only screen and (min-width: 700px) {

		.main-div .table thead tr th:nth-of-type(1) {
			z-index: 999;
			background: #3a7f3e;
		}

		.main-div .table tbody td:nth-of-type(1),
		.main-div .table thead tr th:nth-of-type(1) {
			position: sticky;
			top: 0;
			left: 0;
			/*      background: lightgoldenrodyellow;*/

		}

		.table tr:hover {
			transform: scale(1);
		}

		.main-div .table thead tr th:nth-of-type(1),
		.main-div .table tbody td:nth-of-type(1) {
			left: 0;
		}

	}
</style>
<script>
	var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script>