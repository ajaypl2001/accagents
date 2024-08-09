<?php
ob_start();
include ("../../db.php");
header("Content-Type: application/vnd.ms-excel");

$role2 = 'Payroll_Calculation_Excel_Sheet';

// if(!empty($_POST['getDateSlot'])){
// 	$getDateSlot = $_POST['getDateSlot'];
// 	$endDateSlot_Search = date("Y-m-d", strtotime( $getDateSlot . "+13 day"));

// 	$newdate = date("d M Y", strtotime("$getDateSlot"));
// 	$end_date2 = date("d M Y", strtotime("$endDateSlot_Search"));
// }else{
// 	header("Location: ../../login");
//     exit();
// }

if (!empty($_POST['statusGet'])) {
	$StatusFilter = $_POST['statusGet'];
	$StatusFilter2 = "AND status='$StatusFilter'";
} else {
	$StatusFilter = '';
	$StatusFilter2 = '';
}

echo 'Name' . "\t" . 'Employee ID' . "\t" . 'Status' . "\t" . 'Bi Weekly' . "\t" . 'Payroll type' . "\t" . 'Sick Day Hrs' . "\t" . 'OT Hrs' . "\t" . 'Stat.' . "\t" . 'Reg. Hrs' . "\t" . 'Total Hrs' . "\t" . 'Annual Salary' . "\t" . 'Bi Weekly Salary' . "\t" . 'Add/(Deduct)' . "\t" . 'Commission' . "\t" . 'VAC Pay' . "\t" . 'Bonus' . "\t" . 'Total Salary' . "\n";

$qryModule = "SELECT sno, name, emp_code, payroll_type, annual_salary, weekly, status FROM m_teacher WHERE payroll_type!='' $StatusFilter2 order by emp_code ASC";
$rsltModule = mysqli_query($con, $qryModule);
while ($rowModule = mysqli_fetch_assoc($rsltModule)) {
	$sno = $rowModule['sno'];
	$name = preg_replace('/\s+/', ' ', $rowModule['name']);
	$emp_code = $rowModule['emp_code'];
	$status2 = $rowModule['status'];
	if ($status2 == '1') {
		$statusT = 'Active';
	} else {
		$statusT = 'De-Active';
	}
	$wiWeeklyDiv = $newdate . ' to ' . $end_date2;
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
		$statHrs = ''; //$rglr_hrs/10;
		$statHrs2 = '0'; //$rglr_hrs/10;
		$TotalHours_33 = $total_hrs + $statHrs2;

		$biWeeklyHourly = ($statHrs2 + $rglr_hrs + $sd_hrs) * $annual_salary + ($ot_hrs * 1.5 * $annual_salary);
	}

	$totalSaleryDiv = $biWeeklySalery . '' . $biWeeklyHourly;
	$emptyDiv = '';

	echo ucfirst($name) . "\t" . $emp_code . "\t" . $statusT . "\t" . $wiWeeklyDiv . "\t" . $payroll_type . "\t" . $sd_hrs_empty . "\t" . $ot_hrs_empty . "\t" . $statHrs . "\t" . $rglr_hrs_empty . "\t" . $TotalHours_33 . "\t" . $annual_salary . "\t" . $totalSaleryDiv . "\t" . $emptyDiv . "\t" . $emptyDiv . "\t" . $emptyDiv . "\t" . $emptyDiv . "\t" . $totalSaleryDiv . "\n";
}

header("Content-disposition: attachment; filename=" . $role2 . "_Lists.xls");
?>