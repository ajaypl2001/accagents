<?php
date_default_timezone_set("America/Toronto");
session_start();
include("../../db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

header('Content-type: application/json');
if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT role,email,notify_per,cmsn_login,report_allow,loa_allow, only_view FROM allusers WHERE sno = '$sessionSno'");
while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole1 = mysqli_real_escape_string($con, $row1['role']);
   $notify_per1 = mysqli_real_escape_string($con, $row1['notify_per']); 
   $cmsn_login1 = mysqli_real_escape_string($con, $row1['cmsn_login']); 
   $report_allow1 = mysqli_real_escape_string($con, $row1['report_allow']); 
   $Loggedemail = mysqli_real_escape_string($con, $row1['email']); 
   $loa_allow = mysqli_real_escape_string($con, $row1['loa_allow']); 
   $only_view = mysqli_real_escape_string($con, $row1['only_view']); 
}
}else{
   $adminrole1 = '';
   $notify_per1 = '';
   $cmsn_login1 = '';
   $Loggedemail = '';
   $loa_allow = '';
   $only_view = '';
}

$datetime_at = date('Y-m-d H:i:s');
$date_at = date('Y-m-d');
$time_at = date('H:i:s');

if($_GET['tag'] == "assignTeacher"){
	$batch_name = $_POST['batch_name'];
	$v_no = $_POST['v_no'];
	$v_no2 = explode(',',$v_no);
	$implodeId = $_POST['student_id'];
	$implodeId2 = explode(',',$implodeId);
	$getcdd = implode("','", $implodeId2);
	$getCPL = "'$getcdd'";
	$countValue = sizeof($implodeId2);
	
	$counselor2 = "select * from m_batch where sno='$batch_name'"; 
	$counselorres2 = mysqli_query($con, $counselor2);
	$rowModule = mysqli_fetch_assoc($counselorres2);
	$program = $rowModule['program_name'];
	$shift_time = $rowModule['shift_time'];
	$teacher_id = $rowModule['teacher_id'];
	$batch_name33 = $rowModule['batch_name'];
	
	for ($i=0;$i<$countValue;$i++) {
		$getQry = "INSERT INTO `m_student` (`teacher_id`, `betch_no`, `app_id`, `vnumber`, `updated_on`, `program`,`shift_time`) VALUES ('$teacher_id', '$batch_name', '$implodeId2[$i]', '$v_no2[$i]', '$datetime_at', '$program', '$shift_time')";
		$resultTchr = mysqli_query($con, $getQry);
		
		$getQry2 = "UPDATE `both_main_table` SET `tearcher_assign`='Yes' WHERE `sno` ='$implodeId2[$i]'";
		mysqli_query($con, $getQry2);
	}
	
	$getQry4 = "SELECT name, username FROM `m_teacher` WHERE sno='$teacher_id'";
	$rsltGet4 = mysqli_query($con, $getQry4);
	$row4 = mysqli_fetch_assoc($rsltGet4);
	$name25 = $row4['name'];
	$email_address25 = $row4['username'];
	
	$getStudentLists = '<table style="border:1px solid #333;border-collapse:collapse;" border="1" width="100%">
		<tr>
			<th align="center">Student Name</th>
			<th align="center">VNumber</th>
			<th align="center">Student Contract Email</th>
			<th align="center">Student Canvas Email</th>
			<th align="center">Batch Name</th>
			<th align="center">Program</th>
			<th align="center">Timing</th>
			<th align="center">Instructor Name</th>
		</tr>';
	$getQry3 = "SELECT sno, fname, lname, student_id, email_address FROM `both_main_table` WHERE sno IN ($getCPL)";
	$rsltGet = mysqli_query($con, $getQry3);
	while($row = mysqli_fetch_assoc($rsltGet)){
		$snoEml = $row['sno'];
		$fname = $row['fname'];
		$lname = $row['lname'];
		$student_id = $row['student_id'];
		$email_address = $row['email_address'];
		
		$slctQry_23 = "SELECT email_address FROM international_airport_student where app_id='$snoEml'";
		$checkQuery_23 = mysqli_query($con, $slctQry_23);
		if(mysqli_num_rows($checkQuery_23)){
			$rowStartValue_33 = mysqli_fetch_assoc($checkQuery_23);
			if(!empty($rowStartValue_33['email_address'])){
				$canvasEmail = $rowStartValue_33['email_address'];
			}else{
				$canvasEmail = 'N/A';
			}
		}else{
			$canvasEmail = 'N/A';
		}
		
		$getStudentLists .= '<tr>
			<td align="center">'.$fname.' '.$lname.'</td>
			<td align="center">'.$student_id.'</td>
			<td align="center">'.$email_address.'</td>
			<td align="center">'.$canvasEmail.'</td>
			<td align="center">B'.$batch_name33.'</td>
			<td align="center">'.$program.'</td>
			<td align="center">'.$shift_time.'</td>
			<td align="center">'.$name25.'</td>
		</tr>';
	}
	$getStudentLists .= '</table>';
	
	$msg_body = $getStudentLists;
	$subject = 'Campus Manager - New Student Assign to Instructor | Granville College';
	
	$to = $email_address25;
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
	$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
	$mail->SMTPSecure = 'tls';

	$mail->From = "no-reply@granville-college.com";
	$mail->FromName = 'New Student Assign to Instructor | Granville College';
	$mail->AddAddress("$to");
	$mail->addCC("justyna@granvillecollege.ca");
	$mail->addCC("SAHIL.GABA@granvillecollege.ca");
	$mail->addCC("cheryl@granvillecollege.ca");
	$mail->addCC("chander@opulenceeducationgroup.com");

	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $msg_body;
	if(!$mail->Send()){
		// echo 'Mailer Error: ' . $mail->ErrorInfo;
		// exit();
	}else{
		// echo 'success';
		// exit();
	}
	
	echo '1';
	exit;
}

if($_GET['tag'] == "getAssignDivLists"){
    $agentId = $_POST['agentId']; 
    $getVal2 = $_POST['getVal2']; 
	$getNotes = '<option value="">Select Option</option>';
	$counselor2 = "select * from m_batch where status='1' AND status_batch!='Completed' order by sno desc"; 
	$counselorres2=mysqli_query($con, $counselor2);
		while ($datacouns2=mysqli_fetch_array($counselorres2)){
			$snoId = $datacouns2['sno'];
			$batchId = $datacouns2['batch_name'];
			$program_name = $datacouns2['program_name'];
			$shift_time = $datacouns2['shift_time'];
			$teacher_id = $datacouns2['teacher_id'];
			
			$qryTeacher2 = "select name from m_teacher where sno='$teacher_id'"; 
			$rsltTeacher2 = mysqli_query($con, $qryTeacher2);
			$rowTeacher2 = mysqli_fetch_assoc($rsltTeacher2);
			$Instructorname = $rowTeacher2['name'];
			
			$getNotes .= '<option value='.$snoId.'>B'.$batchId.' / '.$program_name.' / '.$shift_time.' / '.$Instructorname.'</option>';
		}
	
	$res1[] = array(
		'getAssignTchrStdntForm' => $getNotes
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getIntkWise"){
    $intake = $_POST['intake'];

	$getNotes = '<option value="">Select Option</option>';
	 $counselor2 = "select * from m_batch where status='1' AND status_batch!='Completed' AND m_intake='$intake' order by sno desc"; 

	$counselorres2=mysqli_query($con, $counselor2);
		while ($datacouns2=mysqli_fetch_array($counselorres2)){
			$snoId = $datacouns2['sno'];
			$batchId = $datacouns2['c'];
			$program_name = $datacouns2['program_name'];
			$shift_time = $datacouns2['shift_time'];
			$teacher_id = $datacouns2['teacher_id'];
			
			$qryTeacher2 = "select name from m_teacher where sno='$teacher_id'"; 
			$rsltTeacher2 = mysqli_query($con, $qryTeacher2);
			$rowTeacher2 = mysqli_fetch_assoc($rsltTeacher2);
			$Instructorname = $rowTeacher2['name'];
			
			$getNotes .= '<option value='.$snoId.'>B'.$batchId.' / '.$program_name.' / '.$shift_time.' / '.$Instructorname.'</option>';
		}
	
	$res1[] = array(
		'getIntkWiseLists' => $getNotes
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getClassSchedule"){
    $batch_name = $_POST['batch_name']; 
    $pgw = $_POST['pgw']; 
	$tchrStdntCS = '<form method="post" action="" autocomplete="off" name="assign_register" id="assign_register">
	<div class="table-responsive">
	<table id="add-data" class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>
        <th style="padding: 6px 4px !important;">Select For Assign <input name="product_all" class="checked_all" type="checkbox"></th>
        <th>Student Name</th>
        <th>vNumber</th>	
        <th>Location</th>		
        <th>Program</th>
        <th>Start Date(LOA)</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>';
	if($pgw == 'Human Resources'){
		$getPName3 = " AND (prg_name1='Human Resources Management Speciality(1)' OR prg_name1='Human Resources Management Speciality(2)' OR prg_name1='Human Resources Management Speciality(3)' OR prg_name1='Human Resources Management Speciality(4)' OR prg_name1='Human Resources Management Speciality')";
		
	}elseif($pgw == 'HCOA'){
		$getPName3 = " AND (prg_name1='Healthcare Office Administration Diploma(1)' OR prg_name1='Healthcare Office Administration Diploma(2)' OR prg_name1='Healthcare Office Administration Diploma(3)' OR prg_name1='Healthcare Office Administration Diploma(4)' OR prg_name1='Healthcare Office Administration Diploma')";
		
	}elseif($pgw == 'Hospitality'){
		$getPName3 = " AND (prg_name1='Diploma in Hospitality Management(1)' OR prg_name1='Diploma in Hospitality Management(2)' OR prg_name1='Diploma in Hospitality Management(3)' OR prg_name1='Diploma in Hospitality Management(4)' OR prg_name1='Diploma in Hospitality Management')";
		
	}elseif($pgw == 'Business Administration'){
		$getPName3 = " AND (prg_name1='Business Administration Diploma(1)' OR prg_name1='Business Administration Diploma(2)' OR prg_name1='Business Administration Diploma(3)' OR prg_name1='Business Administration Diploma(4)' OR prg_name1='Business Administration Diploma')";
		
	}elseif($pgw == 'Global Supply Chain'){
		$getPName3 = " AND (prg_name1='Global Supply Chain Management Diploma(1)' OR prg_name1='Global Supply Chain Management Diploma(2)' OR prg_name1='Global Supply Chain Management Diploma(3)' OR prg_name1='Global Supply Chain Management Diploma(4)' OR prg_name1='Global Supply Chain Management Diploma')";
		
	}elseif($pgw == 'BA / GSCMS'){
		$getPName3 = " AND (prg_name1='Business Administration / Global Supply Chain Management Speciality(1)' OR prg_name1='Business Administration / Global Supply Chain Management Speciality(2)' OR prg_name1='Business Administration / Global Supply Chain Management Speciality(3)' OR prg_name1='Business Administration / Global Supply Chain Management Speciality(4)' OR prg_name1='Business Administration / Global Supply Chain Management Speciality')";
		
	}elseif($pgw == 'BA / HRM'){
		$getPName3 = " AND (prg_name1='Business Administration / Human Resources Management Speciality(1)' OR prg_name1='Business Administration / Human Resources Management Speciality(2)' OR prg_name1='Business Administration / Human Resources Management Speciality(3)' OR prg_name1='Business Administration / Human Resources Management Speciality(4)' OR prg_name1='Business Administration / Human Resources Management Speciality')";
	}else{
		$getPName3 = '';
	}
	
	$rsltQuery = "SELECT sno, fname, lname, student_id, prg_name1, prg_intake, on_off_shore, student_status FROM both_main_table where prg_name1!='' AND  on_off_shore!='' AND (v_g_r_status='V-G' OR (on_off_shore='Onshore' AND loa_file!='')) AND (STR_TO_DATE(prg_intake, '%b-%Y')) >= '2024-05-00' AND (tearcher_assign='' OR tearcher_assign='Completed') AND (student_status!='' AND student_status!='Not started') $getPName3";
	$qurySql = mysqli_query($con, $rsltQuery);
	if(mysqli_num_rows($qurySql)){
	$notFoundClass = '';
	while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$snoid = $row_nm['sno'];
		$fname = $row_nm['fname'];				
		$lname = $row_nm['lname'];
		$fullname = ucfirst($fname).' '.ucfirst($lname);
		$student_id = $row_nm['student_id'];
		$prg_name1 = $row_nm['prg_name1'];
		$prg_intake = $row_nm['prg_intake'];		
		$on_off_shore343 = $row_nm['on_off_shore'];
		$student_status = $row_nm['student_status'];
		
		$queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
		$queryRslt4 = mysqli_query($con, $queryGet4);
		$rowSC4 = mysqli_fetch_assoc($queryRslt4);
		$start_date = $rowSC4['commenc_date'];
		$expected_date = $rowSC4['expected_date'];
		
		$queryGet2 = "SELECT with_dism FROM `start_college` WHERE with_dism!='' AND app_id='$snoid' ORDER BY sno DESC";
		$queryRslt2 = mysqli_query($con, $queryGet2);
		if(mysqli_num_rows($queryRslt2)){
			$rowSC = mysqli_fetch_assoc($queryRslt2);
			$with_dism2 = $rowSC['with_dism'];
			if($student_status == 'Dismissed' || $student_status == 'Withdrawal'){
				$with_dism = '<span style="color:red;">'.$with_dism2.'</span>';
			}else{
				$with_dism = $with_dism2;
			}
		}else{
			$with_dism = '<span style="color:red;">Pending</span>';
		}		
		
		$tchrStdntCS .= '<tr>
		<td style="padding: 6px 4px !important;">';
		if($student_status == 'Dismissed' || $student_status == 'Withdrawal'){
			
		}else{
		$tchrStdntCS .= '<div class=" custom_check" id="cons_seen" name="submit">
		<input type="checkbox" name="cons_seen" value="'.$snoid.'" v-no="'.$student_id.'" class="checkbox cons_seen" style="margin-left:auto; margin-right:auto;">
		</div>';
		}
		
		$tchrStdntCS .= '</td>
		<td style="white-space: nowrap;">'.$fname.' '.$lname.'</td>
		<td style="white-space: nowrap;">'.$student_id.'</td>	
		<td style="white-space: nowrap;">'.$on_off_shore343.'</td>	
		<td style="white-space: nowrap;">'.$pgw.'</td>		
		<td style="white-space: nowrap;">'.$start_date.'</td>		
		<td style="white-space: nowrap;">'.$with_dism.'</td>	
	</tr>';
		$notFoundClass .= '';
	}
	}else{
		$tchrStdntCS .= '<tr><td colspan="7"><center>This Program is Not Found any Student!!!</center></td></tr>';
		$notFoundClass .= 'notFound';
	}
	$tchrStdntCS .= '</tbody>
	</table>
	</div>
	</form>';
	
	$res1[] = array(
		'getAssignTchrStdntCS' => $tchrStdntCS,
		'notFoundClass' => $notFoundClass
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getBIDDiv"){
	$getBID = $_POST['getBID'];
	$qryBatch = "select * from m_batch where sno='$getBID'"; 
	$rsltBatch = mysqli_query($con, $qryBatch);
	$rowModule = mysqli_fetch_assoc($rsltBatch);
	$batch_name = $rowModule['batch_name'];
	$program_name = $rowModule['program_name'];
	$shift_time = $rowModule['shift_time'];
	$teacher_id = $rowModule['teacher_id'];
	
	$qryTeacher2 = "select name from m_teacher where sno='$teacher_id'"; 
	$rsltTeacher2 = mysqli_query($con, $qryTeacher2);
	$rowTeacher2 = mysqli_fetch_assoc($rsltTeacher2);
	$Instructorname = $rowTeacher2['name'];
	
	$m1 = '<span><b>Batch Id: </b>B'.$batch_name.'</span><br>';
	$m2 = '<span><b>Program Name: </b>'.$program_name.'</span><br>';
	$m4 = '<span><b>Timing: </b>'.$shift_time.'</span><br>';
	$m5 = '<span><b>Instructor Name: </b>'.$Instructorname.'</span>';
	
	$batchLists = $m1.''.$m2.''.$m3.''.$m4.''.$m5;
	
	$res1[] = array(
		'getBatchLists' => $batchLists
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getModuleName"){
	$pname = $_POST['pname'];
	
	$getNotes = '<option value="">Select Option</option>';
	$counselor2 = "select * from m_program_lists where status='1' and program2='$pname' and module_name!='' order by module_name desc"; 
	$counselorres2 = mysqli_query($con, $counselor2);
	if(mysqli_num_rows($counselorres2)){
		while ($datacouns2=mysqli_fetch_array($counselorres2)){
			$snoId = $datacouns2['sno'];
			$module_name = $datacouns2['module_name'];
			$module_code = $datacouns2['module_code'];
			$getNotes .= '<option mcd-id="'.$module_code.'" value="'.$module_name.'">'.$module_code.' '.$module_name.'</option>';
		}
	}
	
	$res1[] = array(
		'moduleName' => $getNotes
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "btchDelete"){
	$ids = $_POST['deleteID'];
	
	$getQry = "SELECT * FROM `m_student` WHERE betch_no='$ids'";
	$getRslt = mysqli_query($con, $getQry);
	while($rowApp = mysqli_fetch_assoc($getRslt)){			
		$app_id = $rowApp['app_id'];
		$qryUpdate3="UPDATE `` SET tearcher_assign='' WHERE sno='$app_id'";
		mysqli_query($con, $qryUpdate3);
	}
	
	mysqli_query($con, "DELETE FROM `m_student` WHERE `betch_no`='$ids'");	
	mysqli_query($con, "DELETE FROM `m_batch` WHERE `sno`='$ids'");

	echo '1';
	exit;
}

if($_GET['tag'] == "getInstructorName"){
	$inatke = $_POST['inatke'];
	$instName = $_POST['instName'];
	
	$getQry="SELECT shift_time FROM `m_batch` WHERE m_intake='$inatke' AND teacher_id='$instName' group by shift_time";
	$getRslt=mysqli_query($con, $getQry);
	$shiftTime = '<option value="">Select Option</option>';
	if(mysqli_num_rows($getRslt)){
		while ($datacouns2=mysqli_fetch_array($getRslt)){
			$shift_time = $datacouns2['shift_time'];
			$shiftTime .= '<option value="'.$shift_time.'">'.$shift_time.'</option>';
		}
	}
	$res1[] = array(
		'shiftTimeDiv' => $shiftTime
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getPrgmName"){
	$inatke = $_POST['inatke'];
	$instName = $_POST['instName'];
	$shiftTime = $_POST['shiftTime'];
	
	$getQry="SELECT sno, program_name, module_start_date FROM `m_batch` WHERE m_intake='$inatke' AND teacher_id='$instName' AND shift_time='$shiftTime' group by program_name";
	$getRslt=mysqli_query($con, $getQry);
	$programName = '<option value="">Select Option</option>';
	if(mysqli_num_rows($getRslt)){
		while ($datacouns2=mysqli_fetch_array($getRslt)){
			$program_name = $datacouns2['program_name'];
			$module_start_date = $datacouns2['module_start_date'];
			$programName .= '<option value="'.$program_name.'" data-sd="'.$module_start_date.'">'.$program_name.'</option>';
		}
	}
	$res1[] = array(
		'prgmDiv' => $programName
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getmoduleNamePW"){
	$getPrgm = $_POST['getPrgm'];
	$msdate3 = $_POST['getStDate'];
	
	$getQry="SELECT module_name FROM `m_program_lists` WHERE program2='$getPrgm' group by module_name ORDER BY sno asc";
	$getRslt=mysqli_query($con, $getQry);
	$moduleName = '<option value="">Select Option</option>';
	if(mysqli_num_rows($getRslt)){
		$srnoCnt=1;
		while ($datacouns2=mysqli_fetch_array($getRslt)){
			$module_name = $datacouns2['module_name'];

			$dddf = $srnoCnt++;
			if($dddf == 1){
				$mdys = 28;
				$getaddDays = date('Y-m-d', strtotime($msdate3. ' + '.$mdys.' days'));
			}else{
				$mdys = 28+1;
				$getaddDays = date('Y-m-d', strtotime($getaddDays. ' + '.$mdys.' days'));
				$msdate3 = date('Y-m-d', strtotime($msdate3. ' + '.$mdys.' days'));
			}
			
			$moduleName .= '<option value="'.$module_name.'" first_date="'.$msdate3.'" last_date="'.$getaddDays.'">'.$module_name.'</option>';
		}
	}
	$res1[] = array(
		'moduleDiv' => $moduleName
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getmoduleNamePW_New"){
	$intke2 = $_POST['inatke'];
	$instorName2 = $_POST['instName'];
	$shiftTime2 = $_POST['shiftTime'];
	$progName2 = $_POST['getPrgm'];
	
	$getQry="SELECT sno, module_name, start_date, end_date FROM `m_module_start_end_date` where intake='$intke2' AND teacher_id='$instorName2' AND shift_time='$shiftTime2' AND prog_name='$progName2' AND status!='Complete'";
	$getRslt=mysqli_query($con, $getQry);
	$moduleName = '<option value="">Select Option</option>';
	if(mysqli_num_rows($getRslt)){
		while ($rowMSE=mysqli_fetch_array($getRslt)){
			$module_name = $rowMSE['module_name'];
			$start_date = $rowMSE['start_date'];
			$end_date = $rowMSE['end_date'];
			
			$moduleName .= '<option value="'.$module_name.'" first_date="'.$start_date.'" last_date="'.$end_date.'">'.$module_name.'</option>';
		}
	}
	$res1[] = array(
		'moduleDiv' => $moduleName
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getStDetailsDiv"){
	$snoid = $_POST['snoid'];
	
	$slctQry_2 = "SELECT sno, on_off_shore, mobile, email_address, dob FROM  where sno='$snoid'";
	$checkQuery_2 = mysqli_query($con, $slctQry_2);
	$rowStartValue = mysqli_fetch_assoc($checkQuery_2);
	$on_off_shore = $rowStartValue['on_off_shore'];
	$mobile = $rowStartValue['mobile'];
	$email_address = $rowStartValue['email_address'];
	$dob = $rowStartValue['dob'];
	
	$getStDetails = '<form>
		<div class="form-group">
			<label>Location:</label>
			<input type="text" class="form-control" value="'.$on_off_shore.'" disabled>
		</div>
		<div class="form-group">
		<label>Email Address:</label>
		<input type="text" class="form-control" value="'.$email_address.'" disabled>
		</div>
		<div class="form-group">
		<label>Contact No:</label>
		<input type="text" class="form-control" value="'.$mobile.'" disabled>
		</div>
		<div class="form-group">
		<label>Date of Birth:</label>
		<input type="text" class="form-control" value="'.$dob.'" disabled>
		</div>
	</form>
	';
	
	$res1[] = array(
		'getStDetails' => $getStDetails
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getAttBatchLists"){
	$getBatch = $_POST['getBatch'];
	if(!empty($getBatch) && $getBatch!='All'){
		$bdiv = "AND program_name='$getBatch'";
	}else{
		$bdiv = '';
	}
	
	$getQry="SELECT sno, batch_name FROM `m_batch` WHERE program_name!='' $bdiv group by batch_name";
	$getRslt=mysqli_query($con, $getQry);
	$attBatchDiv = '<option value="">Select Option</option>';
	if(mysqli_num_rows($getRslt)){
		while ($datacouns2=mysqli_fetch_array($getRslt)){
			$batch_name = $datacouns2['batch_name'];
			$attBatchDiv .= '<option value="'.$batch_name.'">B'.$batch_name.'</option>';
		}
	}
	$res1[] = array(
		'attBatchDiv' => $attBatchDiv
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "leaveRstStatusDiv"){
	$leaveId = $_POST['snoid'];
	$role = $_POST['role'];
	$ubn = $_POST['ubn'];
	$tid = $_POST['tid'];
	$status_admin = $_POST['status_admin'];
	
	$leaveRstStatusDiv = '<form method="post" action="" autocomplete="off" name="leaveStatusForm" id="leaveStatusForm">
		<div class="form-group">
		<label>Any Reason:<span style="color:red;">*</span></label>
			<textarea name="remarks" class="form-control remarks" placeholder="Reason...." rows="4"></textarea>
		</div>
		
		<div class="form-group col-sm-12 mb-2 text-right">
		<input type="hidden" name="snoid" value="'.$leaveId.'">
		<input type="hidden" name="role" value="'.$role.'">
		<input type="hidden" name="ubn" value="'.$ubn.'">
		<input type="hidden" name="tid" value="'.$tid.'">
		<input type="hidden" name="status_admin" value="'.$status_admin.'">
		<button type="submit" name="leaveApplyBtn" class="btn btn-sm btn-success leaveApplyBtn">Submit to Update</button>		
	</div>
	</form>
	';
	
	$res1[] = array(
		'getLeaveClass' => $leaveRstStatusDiv
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "leaveStatusApproval"){
	$status = $_POST['status_admin'];
	$leave_id = $_POST['snoid'];
	$role = $_POST['role'];
	$updated_by_name = $_POST['ubn'];
	$teacher_id = $_POST['tid'];
	if(!empty($_POST['remarks'])){
		$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	}else{
		$remarks = 'N/A';
	}
	
	$qryLeaveApproval = "UPDATE `m_leave` SET `status_admin`='$status', `updated_by_name`='$updated_by_name' WHERE `sno`='$leave_id'";
	mysqli_query($con, $qryLeaveApproval);
	
	$updateLeaveLogs = "INSERT INTO `m_leave_logs` (`role`, `teacher_id`, `leave_id`, `status`, `remarks`, `updated_by`, `updated_by_name`) VALUES ('$role', '$teacher_id', '$leave_id', '$status', '$remarks', '$datetime_at', '$updated_by_name')";
	mysqli_query($con, $updateLeaveLogs);
	
	echo 1;
	exit;

}

if($_GET['tag'] == "getLeaveRemarks"){
	$panel = $_POST['panel'];
	$leave_id = $_POST['snoid'];
	$role = $_POST['role'];
	$updated_by_name = $_POST['updated_by_name'];
	// $status = $_POST['status_admin'];
	
	$gradStChange = '<div class="table-responsive">
	<table class="table table-bordered table-sm table-striped table-hover">
	<tr>
		<th>Status</th>
		<th>Remarks</th>
		<th>Updated By Date</th>
		<th>Updated By Name</th>
	</tr>';
	$getSL = "SELECT * FROM `m_leave_logs` WHERE role='$panel' AND leave_id='$leave_id'";
	$rsltSL = mysqli_query($con, $getSL);
	if(mysqli_num_rows($rsltSL)){
	while($rowSL = mysqli_fetch_assoc($rsltSL)){
	$status = $rowSL['status'];
	$remarks = $rowSL['remarks'];
	$updated_by = $rowSL['updated_by'];
	$updated_by_name = $rowSL['updated_by_name'];
		$gradStChange .= '<tr>
			<td>'.$status.'</td>
			<td>'.$remarks.'</td>
			<td>'.$updated_by.'</td>
			<td>'.$updated_by_name.'</td>
		</tr>';
	}
	}else{
		$gradStChange .= '<tr>
		<td colspan="4"><center>Not Found!!!</center></td>
	</tr>';
	}
	$gradStChange .= '</table>
	</div>
	';
	$res1[] = array(
		'getLeaveLogs' => $gradStChange
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "otStatusApproval"){
	$status = $_POST['ot_status'];
	$ot_id = $_POST['snoid'];
	$role = $_POST['role'];
	$updated_by_name = $_POST['ubn'];
	$teacher_id = $_POST['tid'];
	$tab_name = $_POST['tab_name'];
	
	if($tab_name == 'SickDay'){
		$getDiv = "`sd_status`='$status', `sd_datetime`='$datetime_at'";
	}else{
		$getDiv = "`ot_status`='$status', `ot_datetime`='$datetime_at'";		
	}
	
	if(!empty($_POST['remarks'])){
		$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	}else{
		$remarks = 'Approved';
	}
	if(!empty($_POST['ot_pr'])){
		$ot_pr = $_POST['ot_pr'];
		if($tab_name == 'SickDay'){
			$dhdd = ", sd='$ot_pr'";
		}else{
			$dhdd = ", ot='$ot_pr'";
		}
	}else{
		$dhdd = '';
	}
	
	$updateOtApproval = "UPDATE `m_emp_instructor` SET $getDiv $dhdd WHERE `sno`='$ot_id'";
	mysqli_query($con, $updateOtApproval);
	
	$insertOTLogs = "INSERT INTO `m_hourly_logs` (`tab_name`, `role`, `m_emp_inst_id`, `ot_status`, `ot_remarks`, `ot_datetime`, `ot_updated_id`) VALUES ('$tab_name', '$role', '$ot_id', '$status', '$remarks', '$datetime_at', '$updated_by_name');";
	mysqli_query($con, $insertOTLogs);
	
	echo 1;
	exit;

}

if($_GET['tag'] == "getOTRemarks"){
	$ot_id = $_POST['snoid'];
	// $role = $_POST['role'];
	// $updated_by_name = $_POST['ubn'];
	$panel = $_POST['panel'];
	
	$gradStChange = '<div class="table-responsive">
	<table class="table table-bordered table-sm table-striped table-hover">
	<tr>
		<th>Type</th>
		<th>Status</th>
		<th>Remarks</th>
		<th>Updated By Date</th>
		<th>Updated By Name</th>
	</tr>';
	$getSL = "SELECT * FROM `m_hourly_logs` WHERE role='$panel' AND m_emp_inst_id='$ot_id' ORDER BY id DESC";
	$rsltSL = mysqli_query($con, $getSL);
	if(mysqli_num_rows($rsltSL)){
	while($rowSL = mysqli_fetch_assoc($rsltSL)){
	$tab_name = $rowSL['tab_name'];
	$status = $rowSL['ot_status'];
	$remarks = $rowSL['ot_remarks'];
	$updated_by = $rowSL['ot_datetime'];
	$updated_by_name = $rowSL['ot_updated_id'];
		$gradStChange .= '<tr>
			<td>'.$tab_name.' Hrs</td>
			<td>'.$status.'</td>
			<td>'.$remarks.'</td>
			<td>'.$updated_by.'</td>
			<td>'.$updated_by_name.'</td>
		</tr>';
	}
	}else{
		$gradStChange .= '<tr>
		<td colspan="5"><center>Not Found!!!</center></td>
	</tr>';
	}
	$gradStChange .= '</table>
	</div>
	';
	$res1[] = array(
		'getOTLogs' => $gradStChange
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "otRstStatusDiv"){
	$snoid = $_POST['snoid'];
	$ot_status = $_POST['ot_status'];
	$role = $_POST['role'];
	$ubn = $_POST['ubn'];
	$tid = $_POST['tid'];
	$tab_name = $_POST['tab_name'];
	
	if($tab_name == 'OT'){
		$divName = '(OT Hours)';
	}elseif($tab_name == 'SickDay'){
		$divName = '(Sick Day Hours)';
	}else{
		$divName = '';
	}
	
	$PartialReject = '';
	if($ot_status == 'Partial-Approved'){
		$PartialReject .= '<div class="form-group">
		<label>Partial Approved '.$divName.':<span style="color:red;">*</span></label>
		<select name="ot_pr" class="form-control" required>
		<option value="">Select '.$divName.'</option>';
		for($j='0';$j<=8;$j++){		
			$PartialReject .= '<option value="'.$j.'">'.$j.'</option>';
		}
		$PartialReject .= '</select>
		</div>';
	}
	
	$otRstStatusDiv = '<form method="post" action="" autocomplete="off" name="otStatusForm" id="otStatusForm">
		'.$PartialReject.'
		<div class="form-group">
		<label>Any Reason:<span style="color:red;">*</span></label>
			<textarea name="remarks" class="form-control remarks" placeholder="Reason...." rows="4" required></textarea>
		</div>
		
		<div class="form-group col-sm-12 mb-2 text-right">
		<input type="hidden" name="snoid" value="'.$snoid.'">
		<input type="hidden" name="role" value="'.$role.'">
		<input type="hidden" name="ubn" value="'.$ubn.'">
		<input type="hidden" name="tid" value="'.$tid.'">
		<input type="hidden" name="tab_name" value="'.$tab_name.'">
		<input type="hidden" name="ot_status" value="'.$ot_status.'">
		<button type="submit" name="otBtnSbmit" class="btn btn-sm btn-success otBtnSbmit">Submit to Update</button>		
	</div>
	</form>
	';
	
	$res1[] = array(
		'getOTClass' => $otRstStatusDiv
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "stActiveDe"){
	$stusno = $_POST['stusno'];
	$getval = $_POST['getval'];
	$loggedName = $_POST['loggedName'];
	
	$uqry = "update `m_teacher` set status='$getval', added_by='$loggedName' where `sno`='$stusno'";
	mysqli_query($con, $uqry);
	
	echo '1';
	die;	
}

if($_GET['tag'] == "actchangepass") {	
	
	if(isset($_POST['newpwd'])){
		$newpwd = $_POST['newpwd'];
	} else {
		$newpwd = '';
	}
	if(isset($_POST['cnfmpwd'])){
		$cnfmpwd = $_POST['cnfmpwd'];
	} else {
		$cnfmpwd = '';
	}
	if(isset($_POST['sno'])){
		$unique_code_all = $_POST['sno'];
	} else {
		$unique_code_all = '';
	}
	if($newpwd =='' || $cnfmpwd==''){
		echo "5";
		die();
	}
	
	$newpwd_count =  strlen($newpwd);
	if($newpwd_count < 8){
		echo "3";
		die();
	}
	if($newpwd != $cnfmpwd){
		echo "2";
		die();
	}
	$convert_pass = md5($newpwd);
	
	$update_pass = "update m_teacher SET org_pass='$newpwd', password='$convert_pass' where sno='$unique_code_all'";
	$update_data=mysqli_query($con, $update_pass);
	
	if($update_data=='TRUE'){
		echo "1";
		die();
	}
}

if($_GET['tag'] == "statDivList"){
	$updated_by = $_POST['updated_by'];
	
	$statDivList = '<form name="statHForm" class="statHForm" id="statHForm" autocomplete="off">
		  
		  <div class="form-group">
			<label for="no_of_stat"><b>No of Stat:</b></label>
			<input type="text" class="form-control mb-2" id="no_of_stat" name="no_of_stat" required>
		  </div>
		  
		  <div class="form-group">
			<label for="holiday_name"><b>Holiday Name:</b></label>
			<input type="text" class="form-control mb-2" id="holiday_name" name="holiday_name" required>
		  </div>
		  
		  <div class="form-group">
			<label for="bi_weekly"><b>Holiday Bi Weekly:</b></label>
			<select class="form-control mb-2 bi_weeklyDiv" name="bi_weekly" required>
				<option value="">Select Option</option>';			
				$dssad_hdr = "SELECT m_bi_weekly_start_date.start_date, m_bi_weekly_start_date.end_date FROM m_bi_weekly_start_date WHERE m_bi_weekly_start_date.status='1' AND m_bi_weekly_start_date.start_date NOT IN ( SELECT m_stat_holiday.start_date FROM m_stat_holiday )";
				$login_hdr = mysqli_query($con, $dssad_hdr);
				while($rowsd = mysqli_fetch_assoc($login_hdr)){
					$start_date =  $rowsd['start_date'];
					$end_date =  $rowsd['end_date'];
					
					$newdate = date("d M Y", strtotime("$start_date"));
					$end_date2 = date("d M Y", strtotime("$end_date"));

					$statDivList .= '<option value="'.$newdate.' to '.$end_date2.'" start_date="'.$start_date.'">'.$newdate.' to '.$end_date2.'</option>';
				}
			$statDivList .= '</select>
		  </div>
		  <div class="form-group">
			<label for="p_bi_weekly"><b>Previous Bi Weekly:</b></label>
			<select class="form-control mb-2 bi_weeklyDiv2" name="p_bi_weekly" required>
				<option value="">Select Option</option>
			</select>
		  </div>
			<input type="hidden" name="updated_by" value="'.$updated_by.'">
			<input type="hidden" class="getSD" name="start_date" value="">
			<input type="hidden" class="getSD2" name="p_start_date" value="">
			<input type="hidden" class="firstValue" name="first_value" value="">
			<input type="hidden" class="secondValue" name="second_value" value="">
		  <button type="submit" class="btn btn-success statBtnSbmit" id="statBtnSbmit">Submit</button>
		</form>';
	
	$res1[] = array(
		'statDivList' => $statDivList
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "statSavedLists"){
	$no_of_stat = $_POST['no_of_stat'];
	$holiday_name = $_POST['holiday_name'];
	$bi_weekly = $_POST['bi_weekly'];
	$p_bi_weekly = $_POST['p_bi_weekly'];
	$updated_by = $_POST['updated_by'];
	$start_date = $_POST['start_date'];
	$p_start_date = $_POST['p_start_date'];
	$first_value = $_POST['first_value'];
	$second_value = $_POST['second_value'];
	
	$getQryLists = "INSERT INTO `m_stat_holiday` (`no_of_stat`, `holiday_name`, `bi_weekly`, `updated_on`, `updated_by`, `start_date`, `p_bi_weekly`, `p_start_date`, `first_value`, `second_value`) VALUES ('$no_of_stat', '$holiday_name', '$bi_weekly', '$datetime_at', '$updated_by', '$start_date', '$p_bi_weekly', '$p_start_date', '$first_value', '$second_value')";
	mysqli_query($con, $getQryLists);
	
	echo "1";
	die();
}

if($_GET['tag'] == "getPrevStat"){
	$startDate_Get = $_POST['start_date'];
	$endDate_Get = date("Y-m-d", strtotime( $startDate_Get . "-14 day"));
	$endDate_Get2 = date("Y-m-d", strtotime( $endDate_Get . "+13 day"));
	
	$startDate_Get3 = date("d M, Y", strtotime("$endDate_Get"));
	$endDate_Get3 = date("d M, Y", strtotime("$endDate_Get2"));	
	
	$endDate_Start = date("Y-m-d", strtotime( $endDate_Get2 . "-14 day"));
	$endDate_First = date("Y-m-d", strtotime( $endDate_Start . "-13 day"));
	
	$endDate_First2 = date("d M, Y", strtotime("$endDate_First"));
	$endDate_Start2 = date("d M, Y", strtotime("$endDate_Start"));
	
	$prevLists = '<option value="">Select Option</option>
	<option first-value="'.$endDate_First2.' to '.$endDate_Start2.'" value="'.$startDate_Get3.' to '.$endDate_Get3.'" p_bi_weekly="'.$endDate_Get.'">'.$endDate_First2.' to '.$endDate_Start2.' - '.$startDate_Get3.' to '.$endDate_Get3.'</option>';
	
	$res1[] = array(
		'prevLists' => $prevLists
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "empHourseDiv"){
	$snoid = $_POST['snoid'];
	$daily_hourly = $_POST['daily_hourly'];
	$tabtd = $_POST['tabtd'];
	$logged_id = $_POST['logged_id'];
	$date_on = $_POST['date_on'];
	$name_id = $_POST['name_id'];
	$emp_code = $_POST['emp_code'];
	if(!empty($_POST['bi_weekly'])){		
		$bi_weekly = $_POST['bi_weekly'];
	}else{
		$bi_weekly = '';
	}
	if(!empty($_POST['remarks'])){
		$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	}else{
		$remarks = 'N/A';
	}

	if($tabtd == 'HoursTab' && (!empty($daily_hourly) || $daily_hourly == '0')){
		$rsltQueryD = "SELECT * FROM `m_emp_instructor` WHERE m_instructor_id='$logged_id' AND date_at='$date_on' AND sno='$snoid'";
		$getRslt = mysqli_query($con, $rsltQueryD);
		if(mysqli_num_rows($getRslt)){		
			$rsltQueryU = "UPDATE `m_emp_instructor` SET daily_hourly='$daily_hourly', signout='$time_at', bi_weekly='$bi_weekly' WHERE sno='$snoid'";
			mysqli_query($con, $rsltQueryU);
		}else{
			$rsltQueryU = "INSERT INTO `m_emp_instructor` (`m_instructor_id`, `date_at`, `signin`, `status`, `daily_hourly`, `bi_weekly`, `inst_name`, `emp_code`) VALUES ('$logged_id', '$date_on', '$time_at', 'P', '$daily_hourly', '$bi_weekly', '$name_id', '$emp_code')";
			mysqli_query($con, $rsltQueryU);
		}
		$getError = '1';
	}elseif($tabtd == 'OTTab' && !empty($daily_hourly)){		
		$rsltQueryU = "UPDATE `m_emp_instructor` SET ot='$daily_hourly', ot_status='Pending', ot_datetime='$datetime_at' WHERE sno='$snoid'";
		mysqli_query($con, $rsltQueryU);
		
		$insertOTLogs = "INSERT INTO `m_hourly_logs` (`tab_name`, `role`, `m_emp_inst_id`, `ot_status`, `ot_remarks`, `ot_datetime`, `ot_updated_id`) VALUES ('OT', 'Emp', '$snoid', 'Pending', '$remarks', '$datetime_at', '$name_id');";
		mysqli_query($con, $insertOTLogs);
	
		$getError = '1';
	}elseif($tabtd == 'SDTab' && !empty($daily_hourly)){		
		$rsltQueryU = "UPDATE `m_emp_instructor` SET sd='$daily_hourly', sd_status='Pending', sd_datetime='$datetime_at' WHERE sno='$snoid'";
		mysqli_query($con, $rsltQueryU);
		
		$insertOTLogs = "INSERT INTO `m_hourly_logs` (`tab_name`, `role`, `m_emp_inst_id`, `ot_status`, `ot_remarks`, `ot_datetime`, `ot_updated_id`) VALUES ('SickDay', 'Emp', '$snoid', 'Pending', '$remarks', '$datetime_at', '$name_id');";
		mysqli_query($con, $insertOTLogs);
	
		$getError = '1';
	}else{
		$getError = '2';
	}
	
	$getDh = "SELECT SUM(daily_hourly) as rglr_hrs, SUM(ot) as ot_hrs, SUM(sd) as sd_hrs FROM `m_emp_instructor` WHERE m_instructor_id='$logged_id'";
	$rsltDh = mysqli_query($con, $getDh);
	$totalHrs = mysqli_fetch_assoc($rsltDh);
	$rglr_hrs2 = $totalHrs['rglr_hrs'];
	if($rglr_hrs2 == '0' || $rglr_hrs2 == NULL){
		$rglr_hrs = '0';
	}else{
		$rglr_hrs = $rglr_hrs2;
	}

	$ot_hrs2 = $totalHrs['ot_hrs'];
	if($ot_hrs2 == '0' || $ot_hrs2 == NULL){
		$ot_hrs = '0';
	}else{
		$ot_hrs = $ot_hrs2;
	}

	$sd_hrs2 = $totalHrs['sd_hrs'];
	if($sd_hrs2 == '0' || $sd_hrs2 == NULL){
		$sd_hrs = '0';
	}else{
		$sd_hrs = $sd_hrs2;
	}
	$total_hrs = $rglr_hrs+$ot_hrs+$sd_hrs;
	
	$rh = '<span><b>Regular Hours:</b> '.$rglr_hrs.'</span>&nbsp;&nbsp;';
	$ot = '<span><b>Total OverTime:</b> '.$ot_hrs.'</span>&nbsp;&nbsp;';
	$sd = '<span><b>Total Sick Day:</b> '.$sd_hrs.'</span>&nbsp;&nbsp;';
	$thrs = '<span><b>Total Hours:</b> '.$total_hrs.'</span>';
	
	$getTotalHrs = $rh.''.$ot.''.$sd.''.$thrs;
	
	$res1[] = array(
		'getTotalHrs' => $getTotalHrs,
		'getError' => $getError
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "otAWRDiv"){	
	$daily_hourly = $_POST['daily_hourly'];
	$snoid = $_POST['snoid'];
	$tabtd = $_POST['tabtd'];
	$logged_id = $_POST['logged_id'];
	$name_id = $_POST['name_id'];
	$date_on = $_POST['date_on'];

	if(!empty($_POST['remarks'])){
		$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	}else{
		$remarks = 'N/A';
	}
	
	if($tabtd == 'OTTab'){
		$getTabName = 'OT';
	}elseif($tabtd == 'SDTab'){
		$getTabName = 'Sick Day';
	}else{
		$getTabName = 'Other';
	}
	
	$getOTDiv = '<form method="post" action="" autocomplete="off" name="otStatusForm" id="otStatusForm">
		<div class="form-group">
		<label>Please share '.$getTabName.' Remarks:<span style="color:red;">*</span></label>
			<textarea name="remarks" class="form-control remarks" placeholder="Please share '.$getTabName.' Remarks" rows="4"></textarea>
		</div>
		
		<div class="form-group col-sm-12 mb-2 text-right">
		<input type="hidden" name="daily_hourly" value="'.$daily_hourly.'">
		<input type="hidden" name="snoid" value="'.$snoid.'">
		<input type="hidden" name="role" value="Emp">
		<input type="hidden" name="name_id" value="'.$name_id.'">
		<input type="hidden" name="logged_id" value="'.$logged_id.'">
		<input type="hidden" name="tabtd" value="'.$tabtd.'">
		<input type="hidden" name="date_on" value="'.$date_on.'">
		<button type="submit" name="otBtnSbmit" class="btn btn-sm btn-success otBtnSbmit">Submit</button>		
	</div>
	</form>
	';
	
	$res1[] = array(
		'getOTClass' => $getOTDiv
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}
?>