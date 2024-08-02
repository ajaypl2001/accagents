<?php
session_start();
include("../db.php");
date_default_timezone_set("America/Toronto");

require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();

$ppp_datetime = date('Y-m-d H:i:s');
$ppp_datetime2 = date('Y-m-d');

if(!empty($_POST['snoidbknd']) && !empty($_POST['docBackend'])){
	$snoid = $_POST['snoidbknd'];
}else{
	$snoid = $_SESSION['stsno'];
	if($snoid == $_GET['uid']){
		
	}else{
		header('Location: error.php?error=STWW');
		die();
	}
}

$resultsStr = "SELECT * FROM ppp_form WHERE sno='$snoid'";
$get_query = mysqli_query($con, $resultsStr);
$rowstr = mysqli_fetch_assoc($get_query);
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
$fullname = $fname.' '.$lname;
$student_no = $rowstr['student_no'];
$bursary_form = $rowstr['bursary_form'];
$bursary_award = $rowstr['bursary_award'];

if($bursary_award == '$500 CDN'){
	$bursaryDiv = '<img src="../aol-pdf/images/check.jpg" width="10px;"> $500.00 CDN';
}elseif($bursary_award == '$2000 CDN'){
	$bursaryDiv = '<img src="../aol-pdf/images/check.jpg" width="10px;"> $2000.00 CDN';
}elseif($bursary_award == 'Laptop computer'){
	$bursaryDiv = '<img src="../aol-pdf/images/check.jpg" width="10px;"> Laptop computer';
}else{
	$bursaryDiv = '';
}

if($bursary_award == 'Laptop computer'){
	$laptopCom = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
}else{
	$laptopCom = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
}


$contract_student_signature = $rowstr['contract_student_signature'];
$getSignature = '../Student_Sign/'.$contract_student_signature;

$contract_send_date = $rowstr['contract_send_date'];
$worker_id = $rowstr['worker_id'];
$agnt_qryFos = mysqli_query($con,"SELECT name, rep_sign FROM ulogin where name!='' AND sno='$worker_id'");
if(mysqli_num_rows($agnt_qryFos)){
	$row_agnt_qryFos = mysqli_fetch_assoc($agnt_qryFos);
	$loggedName = $row_agnt_qryFos['name'];
	$rep_signName = $row_agnt_qryFos['rep_sign'];
	$rep_signName2 = '<img src="Rep_Sign/'.$rep_signName.'" width="100" height="30">';
}else{
	$loggedName = 'N/A';
	$rep_signName2 = 'N/A';
}

/////////////New Table///////////////
$resultsStr3 = "SELECT sno, ppp_form_id, brsry_sign FROM `ppp_form_more` where ppp_form_id='$snoid'";
$get_query3 = mysqli_query($con, $resultsStr3);
if(mysqli_num_rows($get_query3)){
	$rowstr3 = mysqli_fetch_assoc($get_query3);
	$brsry_sign = $rowstr3['brsry_sign'];
}else{
	$brsry_sign = '';	
}
///////////////////////////////////////

$output = "<style> 
 @page { margin: 70px 65px 120px; font-family:Helvetica; font-weight:599; color:#333; font-size:15px;  }
    .header { position: fixed; top: -60px;  display: block;width:100%;text-align:center;}
     .header img {    display: block;
    margin-left:1%;}
    h2{ text-align:center; width:100%; font-size:22px;margin-top:70px; font-weight:599;}
    h3{ text-align:center; width:100%; font-size:18px; margin-bottom:40px; margin-top:30px; line-height:24px;}
  .page h4{ text-align:left; width:100%; font-size:18px; margin-top:0px; margin-bottom:20px; font-weight:600;}
  .page h5{ text-align:left; width:100%; font-size:16px; margin-top:50px; margin-bottom:0px;font-weight:600;}
    .footer { position: fixed; bottom: -0px; left: 0px; right: 0px;}
      .footer p { font-size:13px; padding-bottom:40px;}
   .page {/* page-break-after: always;*/ margin-top:0px;width:670px; line-height:15px; }

    .check { margin-right:5px;
    	   .form_table {margin-top:0px;}
.form_table td { padding:0px 0px 0;vertical-align:bottom; margin-top:0px;}
    	.pt-3{ padding-top:30px;}
    	.border-bottom { border-bottom:1px solid #333; min-height:50px ;}
    	.float-left {float:left;}
    	.float-right {float:right;}
      .text-justify { text-align:justify;}
</style>";

$output .= '
<div class="header">
   <img src="../aol-pdf/images/academy_of_learning_logo.jpg" width="240">
</div>

<div class="footer">
   <p><i>AOLCC-TO-BR-HA–Bursary Form</i></p>
</div>

<main class="page"> 
                
<h3 class=""><u>ACADEMY OF LEARNING CAREER COLLEGE<br>
BAY & QUEEN, BRAMPTON EAST, HAMILTON BURSARY PROGRAM
</u></h3>
        <h4>STUDENT INFORMATION</h4>
          <p class="text-justify">For a limited time, Academy of Learning Career College – Bay & Queen, Brampton East, Hamilton Campuses are proud to offer a dynamic Bursary Program to support individuals as they work to wards achieving a career dream.<br><br>
Through this program, Academy of Learning hopes to encourage individuals, families and communities to strive for a better life.
<br><br><b>
Students who enroll into any full-time Diploma program at Academy of Learning may be eligible to receive a bursary award of EITHER $500.00CDNOR a laptop computer, as detailed below:</b><br><br>
<b>Bursary Award Disbursement Eligibility and Terms and Conditions:</p>
</p>

<ul><li>Students must enrollinany DIPLOMA program on or before December 31, 2022 AND start the program on or before December 31, 2022.</li>
<li style="margin-top:15px;"> Bursary awards will be disbursed to students upon the student’s successful completion of the program, provided that the student:
<ul style="margin-top:15px;"><li> is in good academic AND financial standing, AND</li>
<li style="margin-top:15px;">successfully completes their Diploma program on time, as per the approved program length and according to the end date specified on the student’s Enrolment Contract.
</li></ul>
</li>
<li style="margin-top:15px;"> <b>If a student with draws (drops) their study program for ANY reason, after receiving the laptop, the student must repay $500.00 CDN (the value of the laptop)to the College. </b></li></ul>
<h4 style="background:#eee; text-align:center;padding:5px; margin-bottom:10px;">ACKNOWLEDGMENT AND SIGNATURES</h4>

          <table class="form_table" style="margin-bottom:10px;">
          <tr><td colspan="3">By signing below,</td></tr>
          <tr>
			<td width="5" >I</td>
			<td width="290" class="border-bottom">'.$fullname.'</td>
			<td>acknowledge and accept the terms and</td>
		  </tr>
         <tr><td colspan="3"> conditions required in order for me to be eligible to receive the desired bursary award of:</td></td>
          </table>
          
          <p>'.$bursaryDiv.'</p>
<p style="margin:0px;"><i>Further, by signing below, I acknowledge and accept that if I do not successfully complete my Diploma program per the terms above, I will become ineligible to receive any bursary awards and, in the case of a laptop bursary, I must repay the College as noted above.</i></p>

<table class="form_table" style="margin:0px;">
<tr><td width="110" height="28">Student Name(Print): </td>
<td width="140" class="border-bottom">'.$fullname.'&nbsp;</td>
<td width="100" >Approved by(Print): </td>
<td width="140" class="border-bottom">'.$loggedName.'&nbsp;</td></tr>
</table>

<table class="form_table" style="margin:0px;">
<tr>
<td width="100" height="28">Student Signature: </td>
<td width="130" class="border-bottom"><img src="'.$getSignature.'" width="90" height="26">&nbsp;</td>
<td width="120" >Approved by Signature: </td>
<td width="130" class="border-bottom">'.$rep_signName2.'&nbsp; </td>
</tr>
</table>

<table class="form_table" style="margin:0px;">
<tr><td width="35" height="28">Date: </td>
<td width="220" class="border-bottom">'.$contract_send_date.'&nbsp;</td></tr>
</table>
</main>
';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($brsry_sign)){
	unlink("uploads/$brsry_sign");
}

$vnum = str_replace(' ', '', $student_no);
$olname = 'BRYF_Sign_'.$vnum;
$olname2 = 'BRYF_Sign_'.$vnum.'.pdf';
$filepath = "uploads/$olname.pdf";

file_put_contents($filepath, $document->output());

if(mysqli_num_rows($get_query3)){
	$getUpdate = "update `ppp_form_more` set `brsry_sign`='$olname2', `brsry_sign_datetime`='$ppp_datetime' where `ppp_form_id`='$snoid'";
	mysqli_query($con, $getUpdate);
}else{
	$getInsert = "INSERT INTO `ppp_form_more` (`ppp_form_id`, `brsry_sign`, `brsry_sign_datetime`) VALUES ('$snoid', '$olname2', '$ppp_datetime')";
	mysqli_query($con, $getInsert);
}

if(!empty($_POST['snoidbknd']) && !empty($_POST['docBackend'])){
	$document->stream("$olname2", array("Attachment"=>1));
	// 1  = Download
	// 0 = Preview
}else{
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<link rel="icon" href="../images/top-logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/almuni.css">
    <title>AOLCC - Student Bursary Form</title>
</head>

<body>

<div class="s01 mb-5">
<div class="signin-page">
    <div class="container">
        <div class="row">
			<div class="col-12 col-sm-12 pb-2 mb-2">
                <a href=""><img src="../images/academy-of-learning-white.png" class="float-left" width="180"></a>
            </div>
			
			<div class="col-12 col-sm-7 py-2">
                <span class="btn float-start btn-success text-center btn_next">Signed Bursary Form Docs</span>
            </div>
			
            <div class="col-12 col-sm-5 py-2">
                <a href="pdf_emc.php?uid=<?php echo $snoid; ?>" class="btn float-sm-end btn-primary text-center btn_next">Continue</a>
            </div>


		<div class="col-12">
			<iframe src="<?php echo $filepath ?>" width="100%" height="600px"></iframe> 
		</div>
	</div>
</div>
</div>
</div>
</body>
</html>
<?php } ?>