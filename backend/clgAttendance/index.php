<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");
$updated_on = date('Y-m-d H:i:s');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (CONCAT(fname,  ' ', lname) LIKE '%".$searchTerm."%' OR refid LIKE '%".$searchTerm."%' OR passport_no LIKE '%".$searchTerm."%' OR student_id LIKE '%".$searchTerm."%')";
	$search_url = "&getsearch=".$searchTerm."";
} else {
	$searchInput = '';
	$search_url = '';
	$searchTerm = '';
}

if(!empty($_GET['getIntake'])){
	$getIntake2 = $_GET['getIntake'];
	$getIntake3 = "AND prg_intake='$getIntake2'";
}else{
	$getIntake2 = '';
	$getIntake3 = '';
}

if(isset($_POST['stNameSbtBtn'])){
	$mobile = $_POST['mobile'];
	$email_address = $_POST['email_address'];
	$address1 = mysqli_real_escape_string($con, $_POST['address1']);
	$old_mobile = $_POST['old_mobile'];
	$old_email_address = $_POST['old_email_address'];	
	$old_address1 = $_POST['old_address1'];	
	$app_id = $_POST['app_id'];	
	$updated_by_name = $_POST['updated_by_name'];	
	
	$datetime_at = date('Y-m-d H:i:s');
	$slctQry_34 = "INSERT INTO `student_details_update` (`role`, `app_id`, `old_mobile`, `old_email_address`, `old_address1`, `mobile`, `email_address`, `address1`, `updated_by_name`, `updated_datetime`) VALUES ('IN', '$app_id', '$old_mobile', '$old_email_address', '$old_address1', '$mobile', '$email_address', '$address1', '$updated_by_name', '$datetime_at')";
	mysqli_query($con, $slctQry_34);
	
	$slctQry_3 = "UPDATE `st_application` SET `mobile`='$mobile', `email_address`='$email_address', `address1`='$address1' WHERE `sno`='$app_id'";
	mysqli_query($con, $slctQry_3);
	header("Location: ../clgAttendance/?getIntake=$getIntake2&SuccessFully_Submit$search_url");	
}

if(isset($_POST['stNameSbtBtn_44'])){
	$app_id = $_POST['app_id'];
	$can_contact_no = $_POST['can_contact_no'];
	$email_address = $_POST['email_address'];
	$can_address = mysqli_real_escape_string($con, $_POST['can_address']);
	
	$strp1 = "SELECT * FROM international_airport_student where app_id='$app_id'";
	$resultp1 = mysqli_query($con, $strp1);
	if(mysqli_num_rows($resultp1)){
		$slctQryUpdate = "UPDATE `international_airport_student` SET `can_contact_no`='$can_contact_no', `email_address`='$email_address', `can_address`='$can_address' WHERE `app_id`='$app_id'";
		mysqli_query($con, $slctQryUpdate);
	}else{
		$slctQry_34 = "INSERT INTO `international_airport_student` ( `app_id`, `can_contact_no`, `email_address`, `can_address`) VALUES ('$app_id', '$can_contact_no', '$email_address', '$can_address')";
		mysqli_query($con, $slctQry_34);
	}	
	header("Location: ../clgAttendance/?getIntake=$getIntake2&SuccessFully_Submit$search_url");	
}

if(isset($_POST['submitbtn'])){
	$app_id = $_POST['app_id'];
	$warning_letter = $_POST['warning_letter'];
	$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	$datetime_at = date('Y-m-d H:i:s');
	
	$agnt_qry25 = mysqli_query($con, "SELECT sno, student_id, refid, fname, lname, email_address, passport_no, prg_name1, prg_intake, on_off_shore FROM st_application where sno='$app_id'");
	$row_agnt_qry25 = mysqli_fetch_assoc($agnt_qry25);
	$snoid25 = $row_agnt_qry25['sno'];
	$refid = $row_agnt_qry25['refid'];
	$stid = $row_agnt_qry25['student_id'];
	$passp = $row_agnt_qry25['passport_no'];
	$firstname = $row_agnt_qry25['fname'];
	$lastname = $row_agnt_qry25['lname'];
	$fullname = ucfirst($firstname).' '.ucfirst($lastname);
	$email_address25 = $row_agnt_qry25['email_address'];
	$on_off_shore25 = $row_agnt_qry25['on_off_shore'];
	$prg_intake25 = $row_agnt_qry25['prg_intake'];
	$prg_name1 = $row_agnt_qry25['prg_name1'];
	
	$queryGet4_1 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake25'";
	$queryRslt4_1 = mysqli_query($con, $queryGet4_1);
	$rowSC4_1 = mysqli_fetch_assoc($queryRslt4_1);
	$start_date_1 = $rowSC4_1['commenc_date'];
	$expected_date_1 = $rowSC4_1['expected_date'];
	
	$queryGet = "SELECT * FROM `start_college_attendance` WHERE warning_letter='$warning_letter' AND app_id='$app_id'";
	$queryRslt = mysqli_query($con, $queryGet);
	if(mysqli_num_rows($queryRslt)){
		$queryUpdate = "UPDATE `start_college_attendance` SET `remarks`='$remarks', `update_datetime`='$datetime_at', `updated_by_name`='$contact_person' WHERE warning_letter='$warning_letter' AND app_id='$app_id'";
		mysqli_query($con, $queryUpdate);
	}else{
		$queryInsert = "INSERT INTO `start_college_attendance` (`app_id`, `warning_letter`, `remarks`, `update_datetime`, `updated_by_name`) VALUES ('$app_id', '$warning_letter', '$remarks', '$datetime_at', '$contact_person')";
		mysqli_query($con, $queryInsert);
	}
	
	if($warning_letter == 'Confirmation_of_Dismissal' || $warning_letter == 'Student_Dismissal_Letter'){
		$queryGet34 = "SELECT app_id FROM `start_college` WHERE app_id='$app_id'";
		$queryRslt34 = mysqli_query($con, $queryGet34);
		if(mysqli_num_rows($queryRslt34)){
			$queryUpdate = "UPDATE `start_college` SET `student_name`='$fullname', `student_id`='$stid', `refid`='$refid', `passport_no`='$passp', `with_dism`='Dismissed', `remarks`='Dismissed Added by Attendance Warning Letter', `datetime_at`='$datetime_at', `in_w_d`='$contact_person' WHERE `app_id`='$app_id'";
			mysqli_query($con, $queryUpdate);
		}else{
			$queryVgr2 = "INSERT INTO `start_college` (`app_id`, `student_name`, `student_id`, `refid`, `passport_no`, `with_dism`, `remarks`, `datetime_at`, `in_w_d`) VALUES ('$app_id', '$fullname', '$stid', '$refid', '$passp', 'Dismissed', 'Dismissed Added by Attendance Warning Letter', '$datetime_at', '$contact_person')";
			mysqli_query($con, $queryVgr2);
		}
		$getInQry4 = "UPDATE `st_application` SET `student_status`='Dismissed' WHERE `sno`='$app_id'";
		mysqli_query($con, $getInQry4);
		
		$querylog = "INSERT INTO `start_college_logs` (`app_id`, `with_dism`, `remarks`, `datetime_at`, `in_w_d`) VALUES ('$app_id', 'Dismissed', 'Dismissed Added by Attendance Warning Letter', '$datetime_at', '$contact_person')";
		mysqli_query($con, $querylog);
	}
	
	if($warning_letter == '1st_warning_letter'){
		$wlHead = '1st warning letter';
	}
	if($warning_letter == '2nd_warning_letter'){
		$wlHead = '2nd warning letter';
	}
	if($warning_letter == '3rd_warning_letter'){
		$wlHead = '3rd and FINAL warning letter';
	}
	
	if($warning_letter == '1st_warning_letter' || $warning_letter == '2nd_warning_letter'){
		$m1 = '<p>Dear '.$fullname.',</p>';
		$m2 = '<p>Please see the link below in this email for your <b>'.$wlHead.'</b> regarding your attendance record in the '.$prg_name1.' program. As a reminder, our Attendance Policy information is also included here. You can download a copy of your warning letter and the attendance policy by clicking on the links below.</p>';
		$m3 = '<p>Should you have any questions or information pertinent to your absences, please contact Cheryl Grenick, Campus Administrator at cheryl@granvillecollege.ca.</p>';
		$m4 = '<p>Please download the attendance policy here:</p>';
		$m5 = '<p><a href="https://granville-college.com/agents/backend/clgAttendance/policy_letter.php?snoid='.$snoid25.'"><b>Download for attendance Policy</b></a></p>';
		$m6 = '<p>Please download the attendance warning letter here:</p>';
		$m7 = '<p><a href="https://granville-college.com/agents/backend/clgAttendance/'.$warning_letter.'.php?snoid='.$snoid25.'"><b>Download for '.$wlHead.'</b></a></p>';
		$m8 = '<br><br><p>Regards<br>Student Services</p>';
		$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5.''.$m6.''.$m7.''.$m8;
		$wlHead2 = $wlHead.' Attendance';
	}elseif($warning_letter == 'Confirmation_of_Dismissal'){
		$m1 = '<p>Dear '.$fullname.',</p>';
		$m2 = '<p>This is a <b>Confirmation of Dismissal</b> from our '.$prg_name1.' at Granville college.<br>
		Should you have any questions or information pertinent to your absences, please contact Cheryl Grenick, Campus Administrator at cheryl@granvillecollege.ca.
		</p>'; 
		$m4 = '<p><a href="https://granville-college.com/agents/backend/clgAttendance/Confirmation_of_Dismissal.php?snoid='.$snoid25.'"><b>Download for Confirmation of Dismissal</b></a></p>';
		$m5 = '<br><br><p>Regards<br>Team Granville College</p>';
		$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5;
		$wlHead2 = 'Confirmation of Dismissal';
	}elseif($warning_letter == 'Confirmation_of_Enrollment'){
		$m1 = '<p>Dear '.$fullname.',</p>';
		$m2 = '<p>This is a <b>Confirmation of Enrollment</b> from our '.$prg_name1.' at Granville College.<br>
		Should you have any questions or information pertinent to your absences, please contact Cheryl Grenick, Campus Administrator at cheryl@granvillecollege.ca.
		</p>'; 
		$m4 = '<p><a href="https://granville-college.com/agents/backend/clgAttendance/Confirmation_of_Enrollment.php?snoid='.$snoid25.'"><b>Download for Confirmation of Enrollment</b></a></p>';
		$m5 = '<br><br><p>Regards<br>Team Granville College</p>';
		$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5;
		$wlHead2 = 'Confirmation of Enrollment';
	}elseif($warning_letter == 'Confirmation_of_Withdrawal'){
		$m1 = '<p>Dear '.$fullname.',</p>';
		$m2 = '<p>This is a <b>Confirmation of Withdrawal</b> from our '.$prg_name1.'. You can download the letter from the given below link.<br>
		Should you have any questions or information pertinent to your absences, please contact Cheryl Grenick, Campus Administrator at cheryl@granvillecollege.ca.</p>'; 
		$m4 = '<p><a href="https://granville-college.com/agents/backend/clgAttendance/Confirmation_of_Withdrawal.php?snoid='.$snoid25.'"><b>Download for Confirmation of Withdrawal</b></a></p>';
		$m5 = '<br><br><p>Regards<br>Team Granville College</p>';
		$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5;
		$wlHead2 = 'Confirmation of Withdrawal';
	}elseif($warning_letter == 'Letter_of_Completion'){
		$m1 = '<p>Dear '.$fullname.',</p>';
		$m2 = '<p>This is a <b>Letter of Completion</b> of '.$prg_name1.' at Granville college. We confirm That you successfully completed all necessary requirements from the following program at Granville College.<br>
		Should you require any further information or assistance, please feel free to contact us by phone (604) 683-8850 or via email info@granvillecollege.ca</p>'; 
		$m4 = '<p><a href="https://granville-college.com/agents/backend/clgAttendance/Letter_of_Completion.php?snoid='.$snoid25.'"><b>Download for Letter of Completion</b></a></p>';
		$m5 = '<br><br><p>Regards<br>Team Granville College</p>';
		$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5;
		$wlHead2 = 'Letter of Completion';
	}elseif($warning_letter == 'Student_Dismissal_Letter'){
		$m1 = '<p>Dear '.$fullname.',</p>';
		$m2 = '<p>This is a <b>Student Dismissal Letter</b> from our '.$prg_name1.' at Granville College due to unsatisfied attendance requirement. The reason for your dismissal is that you have not followed the Attendance Policy and specifically the terms of the attendance agreement.<br>
		Should you have any questions or information pertinent to your absences, please contact Cheryl Grenick, Campus Administrator at cheryl@granvillecollege.ca.
		</p>'; 
		$m4 = '<p><a href="https://granville-college.com/agents/backend/clgAttendance/Student_Dismissal_Letter.php?snoid='.$snoid25.'"><b>Download for Student Dismissal Letter</b></a></p>';
		$m5 = '<br><br><p>Regards<br>Team Granville College</p>';
		$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5;
		$wlHead2 = 'Student Dismissal Letter';
	}else{
		$m1 = '<p>Dear '.$fullname.',</p>';
		$m2 = '<p>Should you have any questions or information pertinent to your absences, please contact Cheryl Grenick, Campus Administrator at cheryl@granvillecollege.ca.</p>'; 
		$m3 = '<p>Please download the attendance warning letter here:</p>'; 
		$m4 = '<p>Something Went Wrong</p>';
		$m5 = '<br><br><p>Regards<br>Team Granville College</p>';
		$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5;
		$wlHead2 = 'Something Went Wrong!!!';
	}
	
	$slctQry_23 = "SELECT email_address FROM international_airport_student where app_id='$snoid25'";
	$checkQuery_23 = mysqli_query($con, $slctQry_23);
	if(mysqli_num_rows($checkQuery_23)){
		$rowStartValue_33 = mysqli_fetch_assoc($checkQuery_23);
		$email_address_33 = $rowStartValue_33['email_address'];
	}else{
		$email_address_33 = '';
	}
	
	$subject = ''.$wlHead2.' for Granville College - '.$firstname.'';
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
	$mail->FromName = ''.$wlHead2.' | Granville College';
	$mail->AddAddress("$to");
	if(!empty($email_address_33)){
		$mail->addCC("$email_address_33");
	}

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
	
	if($warning_letter == 'Confirmation_of_Dismissal' || $warning_letter == 'Confirmation_of_Withdrawal' || $warning_letter == 'Student_Dismissal_Letter'){
		$qryAssignTchr = "SELECT sno, teacher_id FROM `m_student` WHERE vnumber='$stid'";
		$rsltAssignTchr = mysqli_query($con, $qryAssignTchr);
		$w1 = '<p>Dear All,</p>';
		$w2 = '<p>Please find the given below List of '.$wlHead2.' by User Via Granville Portal.</p>';
		$w3 = '<table border="1" style="border-collapse:collapse; width:100%;border:1px solid #666;" cellpadding="4">
		<tr><th>Student Name</th><td>'.$fullname.'</td></tr>
		<tr><th>Location</th><td>'.$on_off_shore25.'</td></tr>
		<tr><th>Student Email</th><td>'.$email_address25.'</td></tr>
		<tr><th>Student Id</th><td>'.$stid.'</td></tr>
		<tr><th>Passport No.</th><td>'.$passp.'</td></tr>
		<tr><th>Intake</th><td>'.$prg_intake25.'</td></tr>
		<tr><th>Program</th><td>'.$prg_name25.'</td></tr>
		<tr><th>Start Date</th><td>'.$start_date_1.'</td></tr>
		<tr><th>End Date</th><td>'.$expected_date_1.'</td></tr>
		<tr><th>Status</th><td>'.$with_dism.'</td></tr>
		<tr><th>Updated By Name</th><td>'.$contact_person.'</td></tr>
		<tr><th>Updated On</th><td>'.$updated_on.'</td></tr>
		</table>';
		$w4 = '<p><b>Thanks & Regards,</b><br>Team Granville College.</p>';		
		
		$msg_body_w = $w1.''.$w2.''.$w3.''.$w4;
		$subject_w = 'Granville - '.$wlHead2.' Email - '.ucfirst($firstname).'';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
		$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
		$mail->SMTPSecure = 'tls';

		$mail->From = "no-reply@granville-college.com";
		$mail->FromName = ''.$wlHead2.' | Granville College CRM';
		$mail->AddAddress("justyna@granvillecollege.ca");
		$mail->AddAddress("Ahmed.Zaib@granvillecollege.ca");
		$mail->AddAddress("parneet@granvillecollege.ca");
		$mail->AddAddress("SAHIL.GABA@granvillecollege.ca");
		$mail->AddAddress("cheryl@granvillecollege.ca");
		$mail->AddAddress("withdrawal@granvillecollege.ca");
		if(mysqli_num_rows($rsltAssignTchr)){
			$rowTchrId = mysqli_fetch_assoc($rsltAssignTchr);
			$teacher_idFind = $rowTchrId['teacher_id'];			
			$qryTchrName = "SELECT sno, username FROM `m_teacher` WHERE sno='$teacher_idFind'";
			$rsltTchrName = mysqli_query($con, $qryTchrName);
			$rowTchrName = mysqli_fetch_assoc($rsltTchrName);
			$instructorEmailId = $rowTchrName['username'];
			$mail->addCC("$instructorEmailId");	
		}
		$mail->IsHTML(true);
		$mail->Subject = $subject_w;
		$mail->Body = $msg_body_w;
		if(!$mail->Send()){
			//// echo 'Mailer Error: ' . $mail->ErrorInfo;
			//// exit();
		}else{
			//// echo 'success';
		}
	}
	
	header("Location: ../clgAttendance/?getIntake=$getIntake2&SuccessFully_Submit$search_url");	
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	$intakeInput = $_POST['intakeInput'];
	header("Location: ../clgAttendance/?getsearch=$search&getIntake=$intakeInput&page_no=1");
}

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$total_records_per_page = 90;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

// $result_count = mysqli_query($con, "SELECT COUNT(start_college.app_id) As total_records FROM st_application INNER JOIN start_college ON start_college.app_id=st_application.sno where start_college.app_id!='' AND  st_application.study_permit='Yes' AND start_college.with_dism='Started' $searchInput $getIntake3");
$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `st_application` where (v_g_r_status='V-G' OR (on_off_shore='Onshore' AND loa_file!='')) $searchInput $getIntake3");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT sno, fname, lname, refid, student_id, prg_name1, prg_intake, email_address, on_off_shore FROM `st_application` where (v_g_r_status='V-G' OR (on_off_shore='Onshore' AND loa_file!='')) $searchInput $getIntake3 order by sno DESC LIMIT $offset, $total_records_per_page";
$qurySql = mysqli_query($con, $rsltQuery);
?> 

<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>
<section class="container-fluid">
<div class="main-div">
<div class="admin-dashboard">
<div class="row">	

<div class="col-sm-4 col-lg-4 mb-3">
<h3 class="m-0">Attendance Lists(Warning Letter)</h3>
</div>

<div class="col-sm-2 col-lg-2 mb-3">
<form method="POST" action="excelSheet.php" autocomplete="off">
	<input type="hidden" name="role" value="<?php echo 'Attendance'; ?>">
	<input type="hidden" name="keywordLists" value="<?php echo $searchTerm; ?>">
	<input type="hidden" name="intakeInput" value="<?php echo $getIntake2; ?>">
	<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right" >Download Excel</button>
</form>
</div>

<form action="" method="post" autocomplete="off" class="col-sm-6 col-lg-6">
<div class="row">
<div class="col-sm-6 mb-3">
<div class="input-group input-group-sm">
	<select name="intakeInput" class="form-control">
		<option value="">Select Intake</option>
		<?php
		$rsltQuery5 = "SELECT intake FROM contract_courses Group BY intake ORDER BY intake DESC";
		$qurySql5 = mysqli_query($con, $rsltQuery5);
		while($row_nm5 = mysqli_fetch_assoc($qurySql5)){
			$intake34 = $row_nm5['intake'];
		?>
		<option value="<?php echo $intake34; ?>"<?php if ($intake34 == $getIntake2) { echo 'selected="selected"'; } ?>><?php echo $intake34; ?></option>
		<?php } ?>
	</select>
</div>
</div>

<div class="col-sm-6 mb-3">
	<div class="input-group">
		<input type="text" name="inputval" placeholder="Search By Stu. Name or Ref Id" class="form-control form-control-sm" value="<?php echo $searchTerm; ?>">
		<div class="input-group-append">
			<input type="submit" name="srchClickbtn" class="btn btn-sm btn-success" value="Search">
		</div>
	</div>
</div>
</div>
</form>

<div class="col-12">			
    <div class="table-responsive">
	<table class="table table-sm table-bordered" width="100%">
    <thead>	  
      <tr>
        <th>Student Name</th>
        <th>Std Id</th>	
        <th>Email Address</th>	
        <th>Program</th>
        <th>Start Date</th>
        <th>End Date</th>
        <!--th>Status</th-->
        <th>Warning Letter<br>Type Sent</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>	
	<?php
	if(mysqli_num_rows($qurySql)){
		while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$snoid = $row_nm['sno'];
		$fname = $row_nm['fname'];				
		$lname = $row_nm['lname'];
		$fullname = ucfirst($fname).' '.ucfirst($lname);
		$refid = $row_nm['refid'];
		$student_id = $row_nm['student_id'];
		$email_address = $row_nm['email_address'];
		$prg_name1 = $row_nm['prg_name1'];
		$prg_intake = $row_nm['prg_intake'];
		
		$queryGet4 = "SELECT warning_letter FROM `start_college_attendance` WHERE app_id='$snoid'";
		$getWL = '';
		$queryRslt4 = mysqli_query($con, $queryGet4);
		if(mysqli_num_rows($queryRslt4)){
			while ($row_nm4 = mysqli_fetch_assoc($queryRslt4)){
				$getWL .= $row_nm4['warning_letter'].'<br>';
			}
		}else{
			$getWL .= 'N/A';
		}
		
		$queryGet5 = "SELECT commenc_date, expected_date FROM contract_courses where program_name='$prg_name1' AND intake='$prg_intake'";
		$queryRslt5 = mysqli_query($con, $queryGet5);
		$row_nm5 = mysqli_fetch_assoc($queryRslt5);
		$commenc_date = $row_nm5['commenc_date'];
		$expected_date = $row_nm5['expected_date'];
		
		$slctQry_23 = "SELECT email_address FROM international_airport_student where app_id='$snoid'";
		$checkQuery_23 = mysqli_query($con, $slctQry_23);
		if(mysqli_num_rows($checkQuery_23)){
			$rowStartValue_33 = mysqli_fetch_assoc($checkQuery_23);
			$email_address_33 = $rowStartValue_33['email_address'];
		}else{
			$email_address_33 = '';			
		}
		
		$slctQry_25 = "SELECT with_dism FROM start_college where app_id='$snoid'";
		$checkQuery_25 = mysqli_query($con, $slctQry_25);		
		if(mysqli_num_rows($checkQuery_25)){
			$rowStartValue_35 = mysqli_fetch_assoc($checkQuery_25);
			$with_dism = $rowStartValue_35['with_dism'];
		}else{
			$with_dism = '';			
		}
	?>
	<tr>
		<td><?php echo $fname.' '.$lname; ?></td>
		<td  style="white-space: nowrap;"><?php echo $student_id; ?></td>
		<td>
		- <?php echo $email_address; ?> <i class='far fa-edit editNameClass' data-toggle="modal" data-target="#editNameModel" data-id="<?php echo $snoid; ?>" st-no="<?php echo $fname.' '.$lname; ?>"></i><br>
		<?php
		if(!empty($email_address_33)){
			echo '- '.$email_address_33;
		}else{
			echo '- <span style="color:red;">Add Details</span>';
		}
		?> <i class='far fa-edit editNameNewClass' data-toggle="modal" data-target="#editNameNewModel" data-id="<?php echo $snoid; ?>" st-no="<?php echo $fname.' '.$lname; ?>"></i>
		</td>				
		<td><?php echo $prg_name1; ?></td>				
		<td><?php echo $commenc_date; ?></td>				
		<td><?php echo $expected_date; ?></td>	
		<!--td><?php //echo $with_dism; ?></td-->
		<td><?php echo $getWL; ?></td>
		<td style="white-space: nowrap;">
		<span class="btn btn-sm btn-success statusClass" data-toggle="modal" data-target="#statusModal" data-id="<?php echo $snoid; ?>" data-name="<?php echo $fullname; ?>" data-refid="<?php echo $refid; ?>" data-stid="<?php echo $student_id; ?>">Add Status</span>
		
		<span class="btn btn-sm btn-info allClass" data-toggle="modal" data-target="#allModel" data-id="<?php echo $snoid; ?>" data-name="<?php echo $fullname; ?>">Logs</span>
		</td>
	</tr>			
	<?php }
	}else{
		echo '<tr><td colspan="9"><center>Not Found!!!</center></td></tr>';
	}
	?>
    </tbody>	
	</table>  
	</div>
</div>

<div class="col-md-8 mt-2 pl-3">
	<strong>Total Records <?php echo $total_records; ?>, </strong>
	<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<div class="col-md-4 mt-2">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-end">  
	<?php if($page_no > 1){ echo "<li class='page-item'><a href='?page_no=1' class='page-link'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&getsearch=$search_url&getIntake=$getIntake2'"; } ?> class='page-link'>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
				}                  
       }
       echo "<li class='page-item'><a class='page-link'>...</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$second_last&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$second_last</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&getsearch=$search_url&getIntake=$getIntake2'"; } ?> class='page-link'>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>
</nav>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<div class="modal" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="getNameId"></span> warning letter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body getAttendLists"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="allModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	  
	  <div class="modal-header">
        <h4 class="modal-title"><span class="stNameLogs"></span></h4>
		<button type="button" class="close" data-dismiss="modal">×</button>
      </div>	  
	  <div class="loading_icon"></div>
      <div class="modal-body">
	  <div class="table-responsive">
		<table class="table table-bordered table-sm table-striped table-hover">
	<thead>
	<tr>
	<th>Sno.</th>
	<th>Letter Type</th>
	<th>Download</th>
	<th>Remarks</th>
	<th>Added Datetime</th>
	<th>Added By</th>
	</tr>
	</thead>
	<tbody class="getSIFLogsDiv">
	</tbody>
	</table>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editNameModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Details - <span class="stNameLogs"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
		<div class="editNameChange"></div>
       </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editNameNewModel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Canada Details - <span class="stNameLogs"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
       <div class="modal-body">
		<div class="editNameChangeNew"></div>
       </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('click', '.statusClass', function () {
	var getVal = $(this).attr('data-id');
	var getVal2 = $(this).attr('data-name');
	$('.getNameId').html(getVal2);
	$.post("../responseStart.php?tag=getAttendLists",{"idno":getVal, "name":getVal2},function(d){
		$('.getAttendLists').html("");
		$('' + d[0].getAttendLists +'').appendTo(".getAttendLists");
		
		$(function(){
			$(".datepickerDiv").datepicker({	  
				dateFormat: 'yy-mm-dd', 
				changeMonth: false, 
				changeYear: false,
			});
		});
		
		$("#firsttab_requried").submit(function () {
			var submit = true;
			$(".is_require:visible").each(function(){
				if($(this).val() == '') {
						$(this).addClass('error_color');
						submit = false;
				} else {
						$(this).addClass('validError');
				}
			});
			if(submit == true) {
				return true;        
			} else {
				$('.is_require').keyup(function(){
					$(this).removeClass('error_color');
				});
				return false;        
			}
		});		
		
	});
});

$(document).on('click', '.allClass', function(){
	var idmodel = $(this).attr('data-id');
	var getHeadVal = $(this).attr('data-name');
	$('.stNameLogs').html(getHeadVal);
	$('.loading_icon').show();	
	$.post("../responseStart.php?tag=getWLLogs",{"idno":idmodel},function(il){
		$('.getSIFLogsDiv').html("");
		if(il==''){
			$('.getSIFLogsDiv').html("<tr><td colspan='6'><center>Not Found</center></td></tr>");
		}else{
		 for (i in il){
			$('<tr>' + 
			'<td>'+il[i].idLogs+'</td>'+
			'<td>'+il[i].warning_letter+'</td>'+
			'<td style="white-space: nowrap;">'+il[i].warning_letterFile+'</td>'+
			'<td>'+il[i].remarks+'</td>'+
			'<td>'+il[i].update_datetime+'</td>'+
			'<td>'+il[i].updated_by_name+'</td>'+
			'</tr>').appendTo(".getSIFLogsDiv");
		}
		}		
		$('.loading_icon').hide();	
	});	
});	
</script>

<script type="text/javascript">
$(document).on('click', '.editNameClass', function () {
	var getVal = $(this).attr('data-id');
	var getHeadVal = $(this).attr('st-no');
	$('.stNameLogs').html(getHeadVal);
	$.post("../responseStart.php?tag=changeNameSt",{"idno":getVal},function(obj12){
		$('.editNameChange').html("");
		$('' + obj12[0].editNameChange +'').appendTo(".editNameChange");
	});
});

$(document).on('click', '.editNameNewClass', function () {
	var getVal = $(this).attr('data-id');
	var getHeadVal = $(this).attr('st-no');
	$('.stNameLogs').html(getHeadVal);
	$.post("../responseStart.php?tag=changeNameStNew",{"idno":getVal},function(obj12){
		$('.editNameChangeNew').html("");
		$('' + obj12[0].editNameChangeNew +'').appendTo(".editNameChangeNew");
	});
});
</script>

<?php 
include("../../footer.php");
?>