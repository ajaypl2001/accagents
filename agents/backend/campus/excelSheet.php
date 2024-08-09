<?php
ob_start();
include("../../db.php");
header("Content-Type: application/vnd.ms-excel");

$role2 = $_POST['role2'];
$type2 = $_POST['type2'];
$program_name2 = $_POST['program_name2'];

if($type2 == 'Program_Wise'){
	$rsltBatch6 = "SELECT * FROM m_batch where status='1' AND status_batch!='Completed' and program_name='$program_name2' order by sno desc";
	$queryBatch6 = mysqli_query($con, $rsltBatch6);
}else{
	$rsltBatch = "SELECT * FROM m_batch where status='1' AND status_batch!='Completed' order by sno desc";
	$queryBatch6 = mysqli_query($con, $rsltBatch);
}

if(mysqli_num_rows($queryBatch6)){
while($rowBatch6 = mysqli_fetch_assoc($queryBatch6)){	
	$btchId6 = $rowBatch6['sno'];
	$batch_name6 = 'B'.$rowBatch6['batch_name'];		
	$program_name6 = $rowBatch6['program_name'];		
	$module_name6 = $rowBatch6['module_name'];		
	$module_code6 = $rowBatch6['module_code'];		
	$shift_time6 = $rowBatch6['shift_time'];
	$teacher_id6 = $rowBatch6['teacher_id'];
	$mmc = $module_code6.' '.$module_name6;

	$queryGet6 = "SELECT name FROM `m_teacher` WHERE sno='$teacher_id6'";
	$queryRslt6 = mysqli_query($con, $queryGet6);
	$rowSC6 = mysqli_fetch_assoc($queryRslt6);
	$tchrName6 = ucfirst($rowSC6['name']);
	
echo $batch_name6. "\n";
echo $program_name6. "\n";
echo $mmc. "\n";
echo $shift_time6. "\n";
echo $tchrName6. "\n";
echo ' '. "\n";

$rsltQuery7 = "SELECT st_application.sno, st_application.fname, st_application.lname, st_application.student_id
FROM m_student
INNER JOIN st_application ON m_student.app_id=st_application.sno
WHERE m_student.teacher_id!='' AND m_student.betch_no='$btchId6'";
$qurySql7 = mysqli_query($con, $rsltQuery7);
if(mysqli_num_rows($qurySql7)){
	while ($row_nm7 = mysqli_fetch_assoc($qurySql7)){
		$snoid7 = $row_nm7['sno'];				
		$fname7 = $row_nm7['fname'];				
		$lname7 = $row_nm7['lname'];
		$fullname7 = ucfirst($fname7).' '.ucfirst($lname7);
		$student_id7 = $row_nm7['student_id'];
		
		$queryGet7 = "SELECT with_dism FROM `start_college` WHERE with_dism!='' AND app_id='$snoid7' ORDER BY sno DESC";
		$queryRslt7 = mysqli_query($con, $queryGet7);
		if(mysqli_num_rows($queryRslt7)){
			$rowSC7 = mysqli_fetch_assoc($queryRslt7);	
			$with_dism7 = ' - '.$rowSC7['with_dism'];
		}else{
			$with_dism7 = '';
		}
		
		$getddd = $fullname7.' ('.$student_id7.')'.$with_dism7;		
		echo $getddd. "\n";		
	}
}

}
}

header("Content-disposition: attachment; filename=".$type2."_Lists.xls");
?>