<?php
session_start();
include("../../db.php");

header('Content-type: application/json');
date_default_timezone_set("America/Toronto");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

$snoid = $_POST['stusno'];
$contact_personLog = $_SESSION['contact_personLog'];
$resultsStr = "SELECT * FROM st_application WHERE sno='$snoid'";
$get_query = mysqli_query($con, $resultsStr);
$rowstr = mysqli_fetch_assoc($get_query);
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
$student_id_2 = $rowstr['student_id'];
$fullname = ucfirst($fname).' '.ucfirst($lname);
$email_address = $rowstr['email_address'];
$study_insurance_form_mail_sent = $rowstr['study_insurance_form_mail_sent'];
$prg_name1 = $rowstr['prg_name1'];
$prg_intake = $rowstr['prg_intake'];

$resultsStr2 = "SELECT sno, commenc_date FROM contract_courses WHERE intake='$prg_intake' AND program_name='$prg_name1'";
$get_query2 = mysqli_query($con, $resultsStr2);
$rowstr2 = mysqli_fetch_assoc($get_query2);
$commenc_date = $rowstr2['commenc_date'];
$commenc_date2 = date("F d, Y", strtotime($commenc_date));

$slctQry_23 = "SELECT email_address FROM international_airport_student where email_address!='' AND app_id='$snoid'";
$checkQuery_23 = mysqli_query($con, $slctQry_23);
if(mysqli_num_rows($checkQuery_23)){
	$rowStartValue_33 = mysqli_fetch_assoc($checkQuery_23);
	$email_address_33 = $rowStartValue_33['email_address'];
}else{
	$email_address_33 = '';
}

	//////////Email for student Signature Link////////////
	$subject = 'STUDY PERMIT and INSURANCE - '.$fname.' - '.$student_id_2.'';
	$snoidEncode = base64_encode($snoid);
	$msssg = base64_encode('SendEmailEncode');
	$msssg2 = base64_encode('TestSendEmailEncode');
	$m1 = '<p>Dear '.$fullname.'</p>';
	$m2 = '<p>We hope this email finds you well. As we eagerly approach the start of the Fall semester on '.$commenc_date2.', we want to remind all international students of a critical requirement for your enrollment at Granville College.</p>';
	$m3 = '<p><b>Submission of Study Permits and Insurance Information</b></p>';
	$m4 = '<p>If you have already traveled to Canada, we kindly request that you immediately fill out the Google Form linked below to provide us with your Study Permit and insurance information:</p>';
	$m5 = "<p><a href='https://granville-college.com/studyInsuranceForm/?$msssg2&snoid=$snoid&$msssg2'>Click here to Form</a></p>";
	$m6 = '<p>For those of you who have not yet arrived in Canada, please be aware that your priority upon landing should be to complete this form. It is imperative that we receive this information from you as soon as possible.</p>';
	$m7 = '<p><b>Important Note: Failure to Submit Required Documents</b></p>';
	$m8 = '<p>Please understand that compliance with this request is not optional. To ensure your eligibility to attend classes at Granville College, it is mandatory that you submit your Study Permit and insurance details via the provided Google Form. <b>Failure to do so before joining the class will result in your inability to attend.</b></p>';
	$m9 = '<p>We take your academic success and well-being seriously, and the information provided through this form is crucial for us to assist you effectively throughout your studies at Granville College.</p>';
	$m10 = '<p>If you encounter any issues or have questions regarding the submission process, please do not hesitate to reach out to me at parneet@granvillecollege.ca . </p>';
	$m11 = '<p>Thank you for your prompt attention to this matter. We look forward to welcoming you to Granville College and ensuring a smooth and successful start to your academic journey.<br><br></p>';
	
	$m12 = '<p>Best regards,<br>Thanks & Regards<br></p>';
	$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5.''.$m6.''.$m7.''.$m8.''.$m9.''.$m10.''.$m11.''.$m12;
	
	$to = $email_address;
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
	$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
	$mail->SMTPSecure = 'tls';

	$mail->From = "no-reply@granville-college.com";
	$mail->FromName = 'STUDY PERMIT and INSURANCE | Granville College';
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
		echo '2';
		exit();
	}else{
		if(!empty($study_insurance_form_mail_sent)){
			$query = "UPDATE st_application SET study_insurance_form_mail_sent='1', sif_send_by='$contact_personLog' WHERE sno='$snoid'";
			mysqli_query($con, $query);
			echo '3';
			exit();
		}else{
			$query = "UPDATE st_application SET study_insurance_form_mail_sent='1', sif_send_by='$contact_personLog' WHERE sno='$snoid'";
			mysqli_query($con, $query);
			echo '1';
			exit();
		}
	}
?>