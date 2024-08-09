<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");
date_default_timezone_set("America/Toronto");
$getCD = date('Y-m-d');

// if($roles1 == 'ClgCM' || $roles1 == 'APRStep'){

// } else {
// 	header("Location: ../../login");
//     exit();
// }

if (!empty($_GET['first_value'])) {
	$first_value = $_GET['first_value'];
} else {
	$first_value = '';
}

if (!empty($_GET['second_value'])) {
	$second_value = $_GET['second_value'];
} else {
	$second_value = '';
}
?>
<section class="container-fluid">
	<div class="main-div card">
		<div class="card-header">
			<div class="row justify-content-between">
				<div class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3">
					<h3 class="my-0">Stat Calculation</h3>
				</div>
				<a href="statLists.php?MVNlY3VSaTR5OQ==" class="btn btn-sm btn-success float-end">Back to Stat Holiday
					Lists</a>
			</div>
		</div>
		<div class="card-body">
			<div class="row justify-content-between">

				<div class="col-12">
					<div class="table-responsive">
						<table class="table table-striped text-center table-sm table-hover table-bordered">
							<thead>
								<tr class="bg-success">
									<th>Name</th>
									<th>Employee ID</th>
									<th>Status</th>
									<th>Payroll type</th>
									<!-- <td><?php echo $first_value; ?></td>
									<td><?php echo $second_value; ?></td> -->
									<th>Total Working Hours</th>
									<th>Working Days</th>
									<th>Stat Hour</th>
									<th>Per Hour</th>
									<th>Total Cal.</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (empty($first_value) && empty($second_value)) {
									echo '<tr><td colspan="16"><center>Please select Bi Date!!! <a href="statLists.php?MVNlY3VSaTR5OQ=="  class="btn btn-sm btn-info">Go to Stat Holiday List</a></center></td></tr>';
								} else {
									$firstStat = '0';
									$getFirst = "SELECT SUM(`no_of_stat`) as get_no FROM `m_stat_holiday` WHERE (first_value='$first_value' AND second_value='$second_value')";
									$rsltFirst = mysqli_query($con, $getFirst);
									$rowFirst = mysqli_fetch_assoc($rsltFirst);
									$totalFirstStat = $rowFirst['get_no'];
									if ($totalFirstStat == '0' || $totalFirstStat == NULL) {
										$firstStat = '0';
									} else {
										$firstStat = $totalFirstStat;
									}

									$qryModule = "SELECT sno, name, emp_code, payroll_type, annual_salary, status FROM m_teacher WHERE payroll_type='Hourly' order by name ASC";
									$rsltModule = mysqli_query($con, $qryModule);
									while ($rowModule = mysqli_fetch_assoc($rsltModule)) {
										$sno = $rowModule['sno'];
										$name = $rowModule['name'];
										$emp_code = $rowModule['emp_code'];
										$payroll_type = $rowModule['payroll_type'];
										$annual_salary = $rowModule['annual_salary'];
										$status2 = $rowModule['status'];
										if ($status2 == '1') {
											$statusT = 'Active';
										} else {
											$statusT = '<span style="color:red;">De-Active</span>';
										}

										$getDh = "SELECT SUM(daily_hourly) as total_hrs FROM `m_emp_instructor` WHERE status='P' AND m_instructor_id='$sno' AND bi_weekly='$first_value'";
										$rsltDh = mysqli_query($con, $getDh);
										if (mysqli_num_rows($rsltDh)) {
											$totalHrs = mysqli_fetch_assoc($rsltDh);
											$total_hrs2 = $totalHrs['total_hrs'];
											if ($total_hrs2 == '0' || $total_hrs2 == NULL) {
												$rglr_hrs = '0';
											} else {
												$rglr_hrs = $total_hrs2;
											}
										} else {
											$rglr_hrs = '0';
										}
										$getDh_2 = "SELECT SUM(daily_hourly) as total_hrs FROM `m_emp_instructor` WHERE status='P' AND m_instructor_id='$sno' AND bi_weekly='$second_value'";
										$rsltDh_2 = mysqli_query($con, $getDh_2);
										if (mysqli_num_rows($rsltDh_2)) {
											$totalHrs_2 = mysqli_fetch_assoc($rsltDh_2);
											$total_hrs2_2 = $totalHrs_2['total_hrs'];
											if ($total_hrs2_2 == '0' || $total_hrs2_2 == NULL) {
												$rglr_hrs_2 = '0';
											} else {
												$rglr_hrs_2 = $total_hrs2_2;
											}
										} else {
											$rglr_hrs_2 = '0';
										}
										
										$totalWorkingHrs = $rglr_hrs + $rglr_hrs_2;
										$totalWorkingDays = '20';
										$statHrs = $totalWorkingHrs / $totalWorkingDays;
										$getBothSum = $firstStat;
										$getFinalStat = $statHrs * $annual_salary;
										$totalAmountCalc = $getBothSum * $getFinalStat;
										?>
										<tr>
											<td><?php echo ucfirst($name); ?></td>
											<td><?php echo $emp_code; ?></td>
											<td style="white-space: nowrap;"><?php echo $statusT; ?></td>
											<td><?php echo $payroll_type; ?></td>
											<td><?php echo $rglr_hrs; ?></td>
											<td><?php echo $rglr_hrs_2; ?></td>
											<td><?php echo $totalWorkingHrs; ?></td>
											<td><?php echo $totalWorkingDays; ?></td>
											<td><?php echo $statHrs; ?></td>
											<td><?php echo $annual_salary; ?></td>
											<td><?php echo $totalAmountCalc; ?></td>
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
		var startDate = $('option:selected', this).attr('start-date');
		var startDate_2 = $('option:selected', this).attr('start-date2');
		if (getVal == '') {
			alert("Select Date!!!");
			return false;
		} else {
			location.href = "../campus/statReport.php?getDateSlot=" + getVal + "&startDate=" + startDate + "&endDate=&startDate_2=" + startDate_2 + "&endDate_2=";
			return true;
		}
	});
</script>