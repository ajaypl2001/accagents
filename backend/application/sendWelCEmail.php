<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
$datetime_at = date('Y-m-d H:i:s');
session_start();

header('Content-type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

$snoid = $_POST['stusno'];
$resultsStr = "SELECT * FROM st_application WHERE sno='$snoid'";
$get_query = mysqli_query($con, $resultsStr);
$rowstr = mysqli_fetch_assoc($get_query);
$gtitle = $rowstr['gtitle'];
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
if(!empty($_POST['emailId'])){
	$email_address = $_POST['emailId'];
}else{
	$email_address = $rowstr['email_address'];
}
$student_id_2 = $rowstr['student_id'];
$fullname = $gtitle.' '.$fname.' '.$lname;
$campus = $rowstr['campus'];
$pn = $rowstr['prg_name1'];
$tk = $rowstr['prg_intake'];
$passport_no = $rowstr['passport_no'];

$query2 = "SELECT commenc_date FROM contract_courses WHERE campus='$campus' AND intake = '$tk' AND program_name= '$pn'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$commenc_date1 = $rowstr2['commenc_date'];
$cd_comma = date("F j, Y", strtotime($commenc_date1)); 

$resultsStr2 = "SELECT * FROM `travel_docs` WHERE doc_name='Enrollment Letter' AND st_id='$snoid' order by sno DESC limit 1";
$get_query2 = mysqli_query($con, $resultsStr2);

if(mysqli_num_rows($get_query2)){
	
	$snoidEncode = base64_encode($snoid);
	$msssg = base64_encode('SendEmailEncode');
	$msssg2 = base64_encode('TestSendEmailEncode');
	
	$rowstr3 = mysqli_fetch_assoc($get_query2);
	$doc_file = $rowstr3['travel_file_upload'];
	
	$subject = 'Welcome Email - Avalon Community College - '.$fullname.' - SID - '.$student_id_2.'';
	$m1 = '<p>Dear '.ucfirst($fname).'</p>';
	$m2 = '<p>Greetings!!!</p>';
	$m3 = '<p>We are thrilled to welcome you as an International Student of Avalon Community College. </p>';
	$m4 = '<p>Please see below your program information: </p>';
	$m5 = '<p><b>Program Name: '.$pn.'</b></p>';
	$m6 = '<p><b>Start Date: '.$cd_comma.'</b></p>';
	$m15_1 = '<p>Please find your Avalon Community College Log in credentials as under:</p>';
	$m15_2 = '<p>URL: <a href="https://avaloncommunitycollege.com/international2/login/">https://avaloncommunitycollege.com/international/login/</a></p>';
	$m15_3 = '<p>User Name (Student ID): '.$student_id_2.'</p>';
	$m15_4 = '<p>Password (Passport number): '.$passport_no.'</p><br>';
	$m7 = '<p><b>You should have already received the signed copy of Enrollment Contract that you are supposed to be carrying (either Soft or Hard Copy) while travelling.</b></p>';
	$m8 = '<p><b>You shall be receiving Automatically generated emails as confirmation of Program Registration to set up the Student Learning Portal via</b></p>';
	$m9 = '<p><b>(check your Inbox/Spam or Junk mail)</b></p>';
	$m10 = '<p>Staff will assist all new Students to set up their online accounts and get familiar with the learning platform on the First Day of Class.</p>';
	$m11 = '<p><b>You are required to carry the following documents on the First Day of Class:<br>1. Signed Enrolment Contract<br>2. Study Permit<br>3. International Student Health Insurance  </b></p><br>';
	$m12 = '<p>We wish you all the best for your studies.<br>Please feel free to email- international@avaloncommunitycollege.com for any questions that you may have. </p><br>';
	$m13 = '<p><b>Note: Kindly click to download Travel Support Letter - </b><a href="https://avaloncommunitycollege.com/portal/travelDoc/'.$doc_file.'" target="_blank">Click Here</a></p><br>';
	$m14 = '<p>Thank you very much.</p><br>';
	$m15 = '<p>Thanks and Regards<br>Avalon Community College Team</p>';
	
	$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5.''.$m6.''.$m15_1.''.$m15_2.''.$m15_3.''.$m15_4.''.$m7.''.$m8.''.$m9.''.$m10.''.$m11.''.$m12.''.$m13.''.$m14.''.$m15;
	
	$to = $email_address;
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
	$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
	$mail->SMTPSecure = 'tls';
	$mail->From = "no-reply@avaloncommunitycollege.com";
	$mail->FromName = 'Welcome to ACC';
	$mail->AddAddress("$to");
	// $mail->addCC("vinod@opulenceeducationgroup.com");
	
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $msg_body;
	if(!$mail->Send()){
		echo '3';
		exit();
	}else{
		$resultsStr4 = "INSERT INTO `welcome_email_to_student` (`app_id`, `student_id`, `campus`, `pgn`, `start_date`, `email_id`, `send_on`) VALUES ('$snoid', '$student_id_2', '$campus', '$pn', '$cd_comma', '$email_address', '$datetime_at')";
		mysqli_query($con, $resultsStr4);
		echo '1';
		exit();
	}	
}else{
	echo '2';
	exit();
}
?>