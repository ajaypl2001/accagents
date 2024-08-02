<?php
session_start();
include("../db.php");
date_default_timezone_set("America/Toronto");

require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();

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

$ppp_datetime = date('Y-m-d H:i:s');
$ppp_datetime2 = date('Y-m-d');
$resultsStr = "SELECT * FROM ppp_form WHERE sno='$snoid'";
$get_query = mysqli_query($con, $resultsStr);
$rowstr = mysqli_fetch_assoc($get_query);
$worker_name = $rowstr['worker_name'];
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
$fullname = $fname.' '.$lname;
$student_no = $rowstr['student_no'];
$st_hb_confn = $rowstr['st_hb_confn'];
$contract_student_signature = $rowstr['contract_student_signature'];
$contract_send_date = $rowstr['contract_send_date'];
$getSignature = '../Student_Sign/'.$contract_student_signature;

/////////////New Table///////////////
$resultsStr3 = "SELECT sno, ppp_form_id, shc_sign FROM `ppp_form_more` where ppp_form_id='$snoid'";
$get_query3 = mysqli_query($con, $resultsStr3);
if(mysqli_num_rows($get_query3)){
	$rowstr3 = mysqli_fetch_assoc($get_query3);
	$shc_sign = $rowstr3['shc_sign'];
}else{
	$shc_sign = '';	
}
///////////////////////////////////////

$output = "<style> 
 @page { margin: 140px 80px; font-family:Helvetica; font-weight:599; color:#333; font-size:15px;  }
    .header { position: fixed; top: -60px;  display: block;width:100%;text-align:center;}
     .header img {    display: block;
    margin-left:1%;}
    h2{ text-align:center; width:100%; font-size:22px;margin-top:70px; font-weight:599;}
    h3{ text-align:center; width:100%; font-size:18px; margin-bottom:40px; margin-top:30px; line-height:24px;}
  .page h4{ text-align:left; width:100%; font-size:18px; margin-top:30px; margin-bottom:20px; font-weight:600;}
  .page h5{ text-align:left; width:100%; font-size:16px; margin-top:50px; margin-bottom:0px;font-weight:600;}
    .footer { position: fixed; bottom: 60px; left: 0px; right: 0px;}
      .footer p { font-size:11.5px; text-align:right; padding-bottom:40px;}
   .page {/* page-break-after: always;*/ margin-top:60px;width:635px; line-height:25px; }

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
<p style="text-align:center"><b>
<i>This Student Handbook is subject to change without notice.<br> Check with the Admissions Office for the most current copy.</b>
</p>
<p>
Date Revised 01 Mar 2022
</i></p>
        </div>

<main class="page">  
<p class="text-justify">I hereby acknowledge that I have received a copy of the Academy of Learning® Career College Student Handbook. I further acknowledge that I have read it and understand its contents. I understand and agree that this handbook is intended to provide me with an overview of the Policies and Procedures of the campus and does not necessarily represent all such policies inforce.<br><br>
I acknowledge that it is my sole responsibility to ensure I understand the Student Handbook as provided, and that I am responsible for seeking clarification of topics as required.<br><br>
Further, the Company may, at any time, add, change or rescind any policy or procedure at its sole discretion, without notice. By signing below, I agree to adhere to the policies and procedures found in the version of the Student Handbook, dated June 14, 2020. Any changes made after the below signed date must be agreed to separately.</p>

<table class="form_table" width="100%" style="margin:0px;">
	<tr>
		<td width="200" class="border-bottom">'.$fullname.'&nbsp;</td>
		<td>&nbsp;</td>
		<td width="200" class="border-bottom">'.$contract_send_date.'&nbsp;</td>
	</tr>
	<tr>
		<td>Student Name – Please Print</td>
		<td width="50">&nbsp;</td>
		<td>Date: </td>
	</tr>
</table>
          
<table class="form_table" style="margin:0px;">
	<tr>
		<td width="220" class="border-bottom"><img src="'.$getSignature.'" width="100" height="26">&nbsp;</td>
	</tr>
	<tr>
		<td width="35">Student Signature </td>
	</tr>
</table>
<p style="margin-top:50px;"><b><i>*Note:This signed acknowledgement is to be put in the student’s file.*</i></b>
</main>
';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($shc_sign)){
	unlink("uploads/$shc_sign");
}

$vnum = str_replace(' ', '', $student_no);
$olname = 'SHC_Sign_'.$vnum;
$olname2 = 'SHC_Sign_'.$vnum.'.pdf';
$filepath = "uploads/$olname.pdf";

file_put_contents($filepath, $document->output());

if(mysqli_num_rows($get_query3)){
	$getUpdate = "update `ppp_form_more` set `shc_sign`='$olname2', `shc_sign_datetime`='$ppp_datetime' where `ppp_form_id`='$snoid'";
	mysqli_query($con, $getUpdate);
}else{
	$getInsert = "INSERT INTO `ppp_form_more` (`ppp_form_id`, `shc_sign`, `shc_sign_datetime`) VALUES ('$snoid', '$olname2', '$ppp_datetime')";
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
    <title>AOLCC - Student Handbook Confirmation</title>
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
                <span class="btn float-start btn-success text-center btn_next">Signed Student Handbook Confirmation Docs</span>
            </div>
			
            <div class="col-12 col-sm-5 py-2">
                <a href="pdf_osap_fund.php?uid=<?php echo $snoid; ?>" class="btn float-sm-end btn-primary text-center btn_next">Continue</a>
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