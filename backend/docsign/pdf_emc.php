<?php
session_start();
include("../db.php");
date_default_timezone_set("America/Toronto");

require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();

$ppp_datetime = date('Y-m-d H:i:s');
$ppp_datetime2 = date('Y-m-d');

$DirectorSign = '';
$contract_send_date22 = '';

if(!empty($_POST['snoidbknd']) && !empty($_POST['docBackend'])){
	$snoid = $_POST['snoidbknd'];
	$resultsStr22 = "SELECT contract_mngr, contract_send_date FROM ppp_form WHERE sno='$snoid'";
	$get_query22 = mysqli_query($con, $resultsStr22);
	$rowstr22 = mysqli_fetch_assoc($get_query22);
	$contract_mngr22 = $rowstr22['contract_mngr'];
	if($contract_mngr22 == 'Accept'){
		$DirectorSign = '<img src="Rep_Sign/Sig_Cham.jpg" width="100" height="30">';	
	}
	$contract_send_date22 = $rowstr22['contract_send_date'];
}else{
if(!empty($_GET['stusno']) && isset($_GET['stusno'])){
	$_SESSION['stsno'] = $_GET['stusno'];
	$snoid = $_GET['stusno'];
	$DirectorSign = '<img src="Rep_Sign/Sig_Cham.jpg" width="100" height="30">';
	// $contract_mngr_date = $ppp_datetime2;
	
	$resultsStr22 = "SELECT contract_send_date FROM ppp_form WHERE sno='$snoid'";
	$get_query22 = mysqli_query($con, $resultsStr22);
	$rowstr22 = mysqli_fetch_assoc($get_query22);
	$contract_send_date22 = $rowstr22['contract_send_date'];
}else{
	$snoid = $_SESSION['stsno'];
	if($snoid == $_GET['uid']){
		
	}else{
		header('Location: error.php?error=STWW');
		die();
	}
}
}

$resultsStr = "SELECT * FROM ppp_form WHERE sno='$snoid'";
$get_query = mysqli_query($con, $resultsStr);
$rowstr = mysqli_fetch_assoc($get_query);
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
$fullname = $fname.' '.$lname;
$student_no = $rowstr['student_no'];
$enrolment_checklist = $rowstr['enrolment_checklist'];
$program = $rowstr['program'];
if($program == 'PC Support Specialist Toronto'){
	$program_Lists = 'PC Support Specialist';
}else{
	$program_Lists = $program;
}
$start_date2 = $rowstr['start_date'];
$identi_doc_type = $rowstr['identi_doc_type'];
$ossd = $rowstr['ossd'];
$proof_residency = $rowstr['proof_residency'];
$student_type = $rowstr['student_type'];

if($program == 'Paralegal' || $program == 'Personal Support Worker'){
	$ossdAll = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
}else{
	$ossdAll = '<img src="../aol-pdf/images/check.jpg" width="10px;">';	
}
	
if($ossd == 'Yes'){
	$ossdYes = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
}else{
	$ossdYes = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
}

if($ossd == 'No'){
	$ossdNo = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
}else{
	$ossdNo = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
}

if($program == 'Paralegal'){
	$ParalegalDiv = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$ParalegalDiv2 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
}else{
	$ParalegalDiv = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$ParalegalDiv2 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
}

if($program == 'Personal Support Worker' || $program == 'Personal Support Worker challenge Fund'){
	$pswDiv = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$pswDiv2 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$pswDiv3 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$pswDiv4 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$pswDiv5 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
}else{
	$pswDiv = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$pswDiv2 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$pswDiv3 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$pswDiv4 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$pswDiv5 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
}

if($program == 'Early Childcare Assistant'){
	$ecaDiv = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$ecaDiv2 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$ecaDiv3 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$ecaDiv4 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
	$ecaDiv5 = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
}else{
	$ecaDiv = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$ecaDiv2 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$ecaDiv3 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$ecaDiv4 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
	$ecaDiv5 = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
}

if($student_type == 'International'){
	$intCheckDiv = 'check';
}else{
	$intCheckDiv = 'box';
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
$resultsStr3 = "SELECT sno, ppp_form_id, emc_sign FROM `ppp_form_more` where ppp_form_id='$snoid'";
$get_query3 = mysqli_query($con, $resultsStr3);
if(mysqli_num_rows($get_query3)){
	$rowstr3 = mysqli_fetch_assoc($get_query3);
	$emc_sign = $rowstr3['emc_sign'];
}else{
	$emc_sign = '';	
}
///////////////////////////////////////

$output = "<style> 
 @page { margin: 50px 35px 20px 45px; font-family:Helvetica; font-weight:599; color:#333; font-size:12px;  }
    .header { position: fixed; top: -40px;  display: block;width:100%;text-align:center;}
     .header img {    display: block;}
    h2{ text-align:center; width:100%; font-size:22px;margin-top:70px; font-weight:599;}
    h3{ text-align:center; width:100%; font-size:18px; margin-bottom:40px; margin-top:30px; line-height:24px;}
  .page h4{ text-align:left; width:100%; font-size:18px; margin-top:0px; margin-bottom:20px; font-weight:600;}
  .page h5{ text-align:left; width:100%; font-size:16px; margin-top:50px; margin-bottom:0px;font-weight:600;}
    .footer { position: fixed; bottom: -0px; left: 0px; right: 0px;}
      .footer p { font-size:13px; padding-bottom:40px;}
   .page {/* page-break-after: always;*/ margin-top:-10px;width:700px; line-height:15px; }
   .border-table { border-collapse:collapse; width:100%; margin-top:10px;}
.border-table td { border:1px solid #333; padding:3px 10px; }
    .check { margin-right:5px;
    	   .form_table {margin-top:0px;  }
.form_table td { padding:0px 0px 0;vertical-align:bottom; margin-top:0px;}
    	.pt-3{ padding-top:30px;}
    .border-bottom { border-bottom:1px solid #333; min-height:50px ;}
    	.float-left {float:left;}
    	.float-right {float:right;}
      .text-justify { text-align:justify;}
</style>";

$output .= '
<div class="header">
     <img src="../aol-pdf/images/academy_of_learning_logo.jpg" width="200">
</div>
      
<main class="page"> 
                
<h3 style="margin-bottom:0px;">Enrollment Checklist</h3>
<table class="form_table" style="margin:-5px 0px 0px;">
<tr>
<td width="25" height="28">Date: </td>
<td width="250" class="border-bottom">'.$ppp_datetime2.'&nbsp;</td>
<td width="30" >&nbsp;</td>
<td width="65" >Student Name:  </td>
<td width="145" class="border-bottom">'.$fullname.'&nbsp;  </td>
</tr>
</table>
<table class="form_table" style="margin:-10px 0px 0px;">
<tr><td width="40" height="28">Program:  </td>
<td width="240" class="border-bottom">'.$program_Lists.'&nbsp;</td>
<td width="30" >&nbsp;</td>
<td width="50" >Start Date: </td>
<td width="155" class="border-bottom">'.$start_date2.'&nbsp;</td>
</tr>
</table>
<table class="border-table">
<tr bgcolor="#eee">
<td colspan="3" align="center"><b>REQUIRED FOR ALL ENROLLMENTS</b></td>
</tr>
<tr bgcolor="#eee">
<td align="center" width="28%">QUALIFICATION</td>
<td align="center" width="42%">IDENTIFICATION (For viewing only - no copies)</td>
<td align="center" width="30%">ENROLLMENT DOCUMENTS</td>
</tr>
<tr><td valign="top">'.$ossdNo.' Be at least 18 years of age (or age specified in program approval) and pass a Superintendent approved qualifying test<br><br><b>or</b><br>
'.$ossdYes.' Copy of OSSD or equivalent<br/><br/><b>Or</b><br>
<img src="../aol-pdf/images/box.jpg" width="10px;">  Foreign evaluated High School equivalency<br><br><b>AND</b><br>
'.$ossdAll.' ALL additional requirements outlined in program section below.
</td>
<td valign="top">
Campus Official has viewed Official Federal or Provincial document showing proof of age (18 years or older) and identity i.e. Birth Certificate OR Driver’s License OR Passport viewed and confirmed by (please print):<br><br>
<table class="form_table" style=" border:0px;">
<tr><td style=" border:0px;">
<b>Document Type:  </b></td>
<td class="border-bottom" style=" border-top:0px; border-left:0px; border-right:0px;" width="120">'.$identi_doc_type.'&nbsp;</td>
</tr>
</table>
<table class="form_table" style="border:0px;"><tr><td style="border:0px;">
<b>Adms Rep Name:   </b></td></tr>
<tr><td class="border-bottom" style="border-top:0px; border-left:0px; border-right:0px;" width="200">'.$loggedName.' &nbsp;</td>
</tr></table><br>
<b>Proof of Residency Verified:</b> Student Visa / Permanent Resident Card / Citizenship Card viewed and confirmed by (please print):
<br><br>

<table class="form_table"  style=" border:0px;">
<tr><td style=" border:0px;"><b>Document Type:  </b></td>
<td class="border-bottom" style=" border-top:0px; border-left:0px; border-right:0px;" width="120">'.$proof_residency.'&nbsp;</td>
</tr>
</table>
<table class="form_table"  style=" border:0px;"><tr><td style=" border:0px;">
<b>Adms Rep Name: </b></td></tr>
<tr>
<td class="border-bottom" style=" border-top:0px; border-left:0px; border-right:0px;"  width="200">'.$loggedName.' &nbsp;</td>
</tr>
</table> 
</td>
<td valign="top">';

$rsltEnrollDocs = "SELECT * FROM `enrolment_docs`";
$qryEnrollDocs = mysqli_query($con, $rsltEnrollDocs);
if(mysqli_num_rows($qryEnrollDocs)){
	while($rowEds = mysqli_fetch_assoc($qryEnrollDocs)){
		$nameDs = $rowEds['name'];
		
		$getRsltED = "SELECT * FROM `enroll_docs_selected` where st_id='$snoid' AND enroll_docs_name='$nameDs'";
		$qryRsltED = mysqli_query($con, $getRsltED);
		if(mysqli_num_rows($qryRsltED)){
			$mbdb = '<img src="../aol-pdf/images/check.jpg" width="10px;">';
		}else{
			$mbdb = '<img src="../aol-pdf/images/box.jpg" width="10px;">';
		}
		
	$output .= $mbdb.' '.$nameDs.'<br><br>';
	}
} 

$output .= '</td>
</table>

  
<table class="border-table">
<tr bgcolor="#eee">
<td align="center" width="28%"><b>PROGRAM</b></td>
<td align="center"  width="72%"><b>ADDITIONAL ADMISSION REQUIREMENTS</b></td>
</tr>

<tr>
<td><b>Early Childcare Assistant</b></td>
<td>
'.$ecaDiv.' NACC Technical Literacy  Exam (score of 18) <br>
'.$ecaDiv2.' Medical Certificate and Up To Date Immunization Status (within 30 days of starting)<br>
'.$ecaDiv3.' Signed Vulnerable Sector Disclaimer; AND Clear Criminal Record Check with Vulnerable Sector Screening within 30 business days of starting school<br>
'.$ecaDiv4.' Interview with ECA Program Coordinator <br>
'.$ecaDiv5.' Two different references related to employment or volunteer work completed in the early childcare field.
</td>
</tr>

<tr>
<td><b>Paralegal</b></td>
<td>
'.$ParalegalDiv.' Ontario Paralegal Licensing Disclosure <br>
'.$ParalegalDiv2.' Interview with Legal Program Coordinator
</td>
</tr>
<tr>
<td><b>Personal Support Worker</b></td>
<td>
'.$pswDiv.' NACC Technical Literacy Exam(score of 18) <br>
'.$pswDiv2.' Signed Medical Disclaimer<br>
'.$pswDiv3.' Medical Certificate and Up To Date Immunization Status (within 30 days of starting) <br>
'.$pswDiv4.' Signed Vulnerable Sector Disclaimer<br>
'.$pswDiv5.' Clear Criminal Record Check w/ Vulnerable Sector Screening (within 30 days of starting)
</td>
</tr>
<tr>
<td><b>For International Students</b></td>
<td><img src="../aol-pdf/images/box.jpg" width="10px;"> International Student Consent Form<br>
<img src="../aol-pdf/images/box.jpg" width="10px;"> Supplement to the Enrolment Contract<br>
<img src="../aol-pdf/images/'.$intCheckDiv.'.jpg" width="10px;"> Student Study Permit copy<br>
<img src="../aol-pdf/images/'.$intCheckDiv.'.jpg" width="10px;"> Proof of Health Insurance Coverage <br>
<img src="../aol-pdf/images/box.jpg" width="10px;"> International Student PGWP Waver<br>
<img src="../aol-pdf/images/box.jpg" width="10px;"> New International Student Kit (handed out)<br>
<img src="../aol-pdf/images/box.jpg" width="10px;"> Support Staff for International Students and Applicants (handed out)
</td>
</tr>
</table>

       <p style="margin-bottom:0px;"><b>I confirm that all required documentation for this student’s enrollment is either on file or will be on file prior to start and that the contract may now be entered into ACME as a REGISTRATION.
</b></p>

 <table class="form_table" style="margin:0px;">
    <tr>
		<td width="30" height="27">Adms Rep Signature : </td>
		<td width="167" class="border-bottom">'.$rep_signName2.'&nbsp;</td>
		<td width="30" >&nbsp;</td> <td width="25" >Date: </td>
		<td width="160" class="border-bottom">'.$contract_send_date.'&nbsp;</td>
	</tr>
	</table>
   <table class="form_table" style="margin:0px;">
	<tr>
	  <td width="40" height="27">Director signature: </td>
	  <td width="180" class="border-bottom">'.$DirectorSign.'&nbsp;</td>
	  <td width="30">&nbsp;</td>
	  <td width="25">Date:</td>
	  <td width="160" class="border-bottom">'.$contract_send_date22.'&nbsp;</td>
	</tr>
	</table>
</main>
';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($emc_sign)){
	unlink("uploads/$emc_sign");
}

$vnum = str_replace(' ', '', $student_no);
$olname = 'EMC_Sign_'.$vnum;
$olname2 = 'EMC_Sign_'.$vnum.'.pdf';
$filepath = "uploads/$olname.pdf";

file_put_contents($filepath, $document->output());

if(mysqli_num_rows($get_query3)){
	$getUpdate = "update `ppp_form_more` set `emc_sign`='$olname2', `emc_sign_datetime`='$ppp_datetime' where `ppp_form_id`='$snoid'";
	mysqli_query($con, $getUpdate);
}else{
	$getInsert = "INSERT INTO `ppp_form_more` (`ppp_form_id`, `emc_sign`, `emc_sign_datetime`) VALUES ('$snoid', '$olname2', '$ppp_datetime')";
	mysqli_query($con, $getInsert);
}

if(!empty($_GET['stusno']) && isset($_GET['stusno'])){
	header("Location: ../contract?msg=Successfully&getPage=Pending_Approval");
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
    <title>AOLCC - Student Enrollment Checklist</title>
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
                <span class="btn float-start btn-success text-center btn_next">Signed Enrollment Checklist Docs</span>
            </div>
			
            <div class="col-12 col-sm-5 py-2">
                <a href="pdf_shc.php?uid=<?php echo $snoid; ?>" class="btn float-sm-end btn-primary text-center btn_next">Continue</a>
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