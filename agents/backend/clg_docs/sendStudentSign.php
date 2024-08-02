<?php
session_start();
include("../../db.php");
date_default_timezone_set("America/Toronto");

header('Content-type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

$snoid = $_POST['stusno'];
$getEmail = $_POST['getEmail'];
$query1 = "SELECT sno, fname, lname, refid, email_address, student_id, campus, prg_name1, prg_intake, passport_no FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$campus = $rowstr1['campus'];
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$refid = $rowstr1['refid'];
$email_address = $rowstr1['email_address'];
$student_id = $rowstr1['student_id'];
$pn = $rowstr1['prg_name1'];
$tk = $rowstr1['prg_intake'];
$passport_no = $rowstr1['passport_no'];

$query2 = "SELECT commenc_date FROM contract_courses WHERE campus='$campus' AND intake = '$tk' AND  program_name= '$pn'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$commenc_date1 = $rowstr2['commenc_date'];
$cd_comma = date("F j, Y", strtotime($commenc_date1)); 

$getQry = "SELECT id, app_id, stud_enrld, send_date FROM `st_app_more` WHERE app_id='$snoid'";
$getQryRslt = mysqli_query($con, $getQry);
if(mysqli_num_rows($getQryRslt)){
	$rowS = mysqli_fetch_assoc($getQryRslt);
	$stud_enrld = $rowS['stud_enrld'];	
	$send_date = $rowS['send_date'];	
}else{
	$stud_enrld = '';
	$send_date = '';
}

if(empty($stud_enrld)){
	echo '4';
	exit();
}else{
		
	$snoidEncode = base64_encode($snoid);
	$msssg = base64_encode('GSendEmailEncode');
	$msssg2 = base64_encode('TGestSendEmailEncode');

	$m1 = '<p>Dear '.ucfirst($fname).'</p>';
	$m2 = '<p>To complete your Admission in <b>Granville College</b>, please click the following link to review and sign the <b>Enrollment Contract</b>:</p>';
	$m3 = "<p><a href='https://granville-college.com/docsign/?$msssg2&id=$snoidEncode&tab=Signed&$msssg'>Click here to Sign</a></p>";
	$m6 = '<p>Should you have any questions or require a correction on the document(s), please connect with your Admission Advisor.</p><br>';
	$m7 = '<p>Regards,<br>Admissions Team - Granville College<br><img src="https://granville-college.com/agents/images/logo.jpg" style="pointer-events: none;width:140px;height:100px;"></p>';
	$msg_body = $m1.''.$m2.''.$m3.''.$m6.''.$m7;

	$subject = 'Contract Signature for Granville College - '.$fname.' - '.$student_id_2.'';
	$to = $getEmail;
	$mail = new PHPMailer();	
	$mail->IsSMTP();
	$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
	$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
	$mail->SMTPSecure = 'tls';	
	$mail->From = "no-reply@granville-college.com";
	$mail->FromName = 'Contract Signature | Granville College';
	$mail->AddAddress("$to");

	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $msg_body;
	if(!$mail->Send()){
		// echo 'Mailer Error: ' . $mail->ErrorInfo;
		// exit();
		echo '2';
		exit();
	}else{
		$datetime_at = date('Y-m-d H:i:s');
		$query = "update `st_app_more` set send_date='$datetime_at', signed_contract='', signed_contract_datetime='', contract_status='', contract_remarks='', contract_datetime='' where `app_id`='$snoid'";
		mysqli_query($con, $query);
		
		$resultsStr4 = "INSERT INTO `welcome_email_to_student` (`page`, `app_id`, `student_id`, `campus`, `pgn`, `start_date`, `email_id`, `send_on`) VALUES ('Contract', '$snoid', '$student_id', '$campus', '$pn', '$cd_comma', '$getEmail', '$datetime_at')";
		mysqli_query($con, $resultsStr4);
		
		if(!empty($send_date)){
			echo '3';
			exit();
		}else{
			echo '1';
			exit();
		}
	}
}
?>