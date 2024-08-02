<?php 
ob_start();
include("../../db.php");
		
 echo 'Campus Name'. "\t" . 'Program Name'. "\t" . 'Intake'. "\t" . 'Tuition Fee'. "\t" . 'Commence Date'. "\t" . 'Expected Date'. "\t" . 'School Break1 Start Date'.  "\t" . 'School Break1 End Date'.  "\t" . 'School Break2 Start Date'.  "\t" . 'School Break2 End Date'.  "\t" . 'Hours'.  "\t" . 'Week'.  "\t" . 'Int Fee'.  "\t" . 'Books Est'.  "\t" . 'Other Fee'.  "\t" . 'Total Fee'.  "\t" . 'Other and Book'.  "\t" . 'Total Tuition'.  "\t" . 'LOA Total Fee'.  "\t" . 'Practicum'.  "\t" . 'Practicum Wrk'.  "\t" . 'Work Practicum Commencing Date'.  "\t" . 'Program Start Date1'.  "\t" . 'Program End Date1'.  "\t" . 'Program Start Date2'.  "\t" . 'Program End Date2'. "\t". "\n";
		
	
	$quryAll_3 = "select * from contract_courses ORDER BY sno DESC";
	$rsltbrnch_3 = mysqli_query($con, $quryAll_3);
	
		while ($rowBranch_3 = mysqli_fetch_assoc($rsltbrnch_3)){
			$campus = $rowBranch_3['campus'];
			$program_name = $rowBranch_3['program_name'];
			$intake = $rowBranch_3['intake'];
			$tuition_fee = $rowBranch_3['tuition_fee'];
			$commenc_date = $rowBranch_3['commenc_date'];
			$expected_date = $rowBranch_3['expected_date'];
			$school_break1 = $rowBranch_3['school_break1'];
			$school_break2 = $rowBranch_3['school_break2'];
			$school_break_3 = $rowBranch_3['school_break_3'];
			$school_break_4 = $rowBranch_3['school_break_4'];
			$hours = $rowBranch_3['hours'];
			$week = $rowBranch_3['week'];
			$int_fee = $rowBranch_3['int_fee'];
			$books_est = $rowBranch_3['books_est'];
			$other_fee = $rowBranch_3['other_fee'];
			$total_fee = $rowBranch_3['total_fee'];
			$otherandbook = $rowBranch_3['otherandbook'];
			$total_tuition = $rowBranch_3['total_tuition'];
			$loa_total_fee = $rowBranch_3['loa_total_fee'];
			$practicum = $rowBranch_3['practicum'];
			$practicum_wrk = $rowBranch_3['practicum_wrk'];
			$practicum_date = $rowBranch_3['practicum_date'];
			$program_start1 = $rowBranch_3['program_start1'];
			$program_end1 = $rowBranch_3['program_end1'];
			$program_start2 = $rowBranch_3['program_start2'];
			$program_end2 = $rowBranch_3['program_end2']; 
	
  echo $campus. "\t" . $program_name. "\t" . $intake. "\t" . $tuition_fee. "\t" . $commenc_date. "\t" . $expected_date. "\t" . $school_break1. "\t" . $school_break2. "\t" . $school_break_3. "\t". $school_break_4. "\t". $hours. "\t". $week. "\t". $int_fee. "\t". $books_est. "\t". $other_fee. "\t". $total_fee. "\t". $otherandbook. "\t". $total_tuition. "\t". $loa_total_fee. "\t". $practicum. "\t". $practicum_wrk. "\t". $practicum_date. "\t". $program_start1. "\t". $program_end1. "\t". $program_start2. "\t". $program_end2. "\n";

}

header("Content-disposition: attachment; filename=Courses_Excel_Sheet.xls");
?>