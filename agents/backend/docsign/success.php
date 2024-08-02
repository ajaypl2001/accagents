<?php
session_start();
include("../db.php");

date_default_timezone_set("America/Toronto");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
$mail = new PHPMailer(true);

$snoid = $_SESSION['stsno'];
if($snoid == $_GET['uid']){
	
$ppp_datetime = date('Y-m-d H:i:s');
$resultsStr = "SELECT sno, worker_id, campus, student_no, fname, lname, program, start_date FROM ppp_form WHERE sno='$snoid'";
$get_query = mysqli_query($con, $resultsStr);
$rowstr = mysqli_fetch_assoc($get_query);
$campus25 = $rowstr['campus'];
$student_no25 = $rowstr['student_no'];
$fname25 = $rowstr['fname'];
$lname25 = $rowstr['lname'];
$program25 = $rowstr['program'];
$start_date25 = $rowstr['start_date'];
$worker_id25 = $rowstr['worker_id'];

$resultsStr3 = "SELECT sno, final_student_sbmit FROM `ppp_form_more` where ppp_form_id='$snoid'";
$get_query3 = mysqli_query($con, $resultsStr3);
$rowstr3 = mysqli_fetch_assoc($get_query3);
$final_student_sbmit = $rowstr3['final_student_sbmit'];

$agnt_qry = mysqli_query($con,"SELECT name, email_address FROM ulogin where email_address!='' AND sno='$worker_id25'");
$row_agnt_qry = mysqli_fetch_assoc($agnt_qry);
$agntname = $row_agnt_qry['name'];
$email_address45 = $row_agnt_qry['email_address'];

$msssg = base64_encode('SendEmailEncode');
$msssg2 = base64_encode('TestSendEmailEncode');
	
if(empty($final_student_sbmit)){
	$m1 = '<p>Dear Team,</p>';
	$m2 = '<p>The Student has signed the documents, pending from campus manager. Please check below Link:</p>';
	$m3 = '<p><a href="https://aoltorontoagents.ca/student_contract/docsign/download_docs_signed.php?'.$msssg.'&stusno='.$snoid.'&'.$msssg2.'">Click here to Download Signed Docs</a></p>';
	$m4 = '<table border="1" style="border-collapse:collapse; width:100%;border:1px solid #666;" cellpadding="4">
	<tr><th>Campus</th><td>'.$campus25.'</td></tr>
	<tr><th>VNo.</th><td>'.$student_no25.'</td></tr>
	<tr><th>Name of Student</th><td>'.$fname25.' '.$lname25.'</td></tr>
	<tr><th>Name of Program</th><td>'.$program25.'</td></tr>
	<tr><th>Start Date</th><td>'.$start_date25.'</td></tr>
	<tr><th>Rep Name</th><td>'.$agntname.'</td></tr>
	</table>';
	$msg_body = $m1.''.$m2.''.$m3.''.$m4;
	
	$subject = 'Student Sign Documents - '.$fname25.' - '.$student_no25.'';
	$to = $email_address45;
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
	$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
	$mail->SMTPSecure = 'tls';

	$mail->From = "no-reply@aoltorontoagents.ca";
	$mail->FromName = 'Sign Contract Signature | AOLCC';
	$mail->AddAddress("$to");

	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $msg_body;
	if(!$mail->Send()){
		// echo 'Mailer Error: ' . $mail->ErrorInfo;
		// exit();
	}else{
		$send_timedate = date('Y-m-d H:i:s');
		$query = "UPDATE ppp_form_more SET final_student_sbmit='1', final_student_sbmit_datetime='$send_timedate' WHERE ppp_form_id='$snoid'";
		mysqli_query($con, $query);
		
		$query2 = "UPDATE ppp_form SET final_student_sign_sbmit='1' WHERE sno='$snoid'";
		mysqli_query($con, $query2);
	}
}
	
}else{
	header('Location: error.php?error=STWW');
	die();
}

session_destroy();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<link rel="icon" href="../images/top-logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<link rel="stylesheet" type="text/css" href="../css/almuni.css">
    <title>AOLCC-Student Contract</title>
</head>

<body>

<div class="s01 mb-5">
<div class="signin-page">
    <div class="container">
        <div class="row">
	
<div class="col-12 mt-5 text-center" id="main">

    <div class="fof  p-md-5 p-2 bg-white">
	<a href=""><img src="../images/academy_of_learning_logo.png" class="mb-5" width="200">
	</a>
		<div class="alert alert-success">
    <strong>Success!</strong> Thanks for your signed AOLCC.
  </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<style>
*{transition: all 0.6s;}
html {height: 100%;}
body{
    font-family: 'Lato', sans-serif;
    color: #888;
    margin: 0;
}
#main{
    display: table;
    width: 100%;
    height: 100vh;
    text-align: center;
}
.fof { border-radius:5px; border:1px solid #ccc;}
.fof h1{
	font-size: 50px;
	display: inline-block;
	padding-right: 12px;
	animation: type .5s alternate infinite;
}
@keyframes type{
	from{box-shadow: inset -3px 0px 0px #888;}
	to{box-shadow: inset -3px 0px 0px transparent;}
}
</style>
</body>
</html>