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
$student_no = $rowstr['student_no'];
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
$fullname = $fname.' '.$lname;
$funding_planner_name = $rowstr['funding_planner_name'];
$osap_grf = $rowstr['osap_grf'];
$student_type = $rowstr['student_type'];
$contract_send_date = $rowstr['contract_send_date'];
$contract_student_signature = $rowstr['contract_student_signature'];
$getSignature = '../Student_Sign/'.$contract_student_signature;

$resultsStr2 = "SELECT sno, sign_doc FROM `funding_planner_name` where name='$funding_planner_name'";
$get_query2 = mysqli_query($con, $resultsStr2);
$rowstr2 = mysqli_fetch_assoc($get_query2);
$sign_doc2 = $rowstr2['sign_doc'];
if(!empty($sign_doc2)){
	$fpnDiv = '<img src="Rep_Sign/'.$sign_doc2.'" width="100" height="30">';
}else{
	$fpnDiv = '';
}

/////////////New Table///////////////
$resultsStr3 = "SELECT sno, ppp_form_id, osap_fund_sign FROM `ppp_form_more` where ppp_form_id='$snoid'";
$get_query3 = mysqli_query($con, $resultsStr3);
if(mysqli_num_rows($get_query3)){
	$rowstr3 = mysqli_fetch_assoc($get_query3);
	$osap_fund_sign = $rowstr3['osap_fund_sign'];
}else{
	$osap_fund_sign = '';	
}
///////////////////////////////////////

if($student_type == 'Domestic'){
	
$output = "<style>
.header { position: fixed; top: -0px;width:100%;  padding:0px 0px 25px;height:60px; display: block;}
main { position:relative;width:100%; }
.page {width:100%;   font-size:14.5px;  margin-top:90px; margin-bottom:0px; padding:0px 0px 0px; page-break-after: always; position:relative;line-height:16px; }
.page:last-child {page-break-after:never;}
@page { margin:70px 80px 15px; font-weight:599;width:100%;  color:#333; font-size:14.5px; }
.float-left { float:left;}
.float-right { float:right;}
.heading-txt { width:100%;}
.heading-txt p, .heading-txt h4 { width:100%; margin:5px 0px;}
.mt-5 { margin-top:50px;}
.text-center { text-align:center;}
.page-number:before {content: counter(page);}
p { width:100%; margin:0px; }
h4 { font-size:17px; margin-bottom:0px; margin-top:0px; border-bottom:1px solid #ccc; font-weight:400;padding-bottom:10px;}
.table-bordered td { border:1px solid #333; padding:3px 10px;vertical-align:top;}
.m-0 { margin:0px;}
.border-bottom { border-bottom:1px solid #333; min-height:50px ;}
.border-bottom-dotted{ border-bottom:1px dotted #333; min-height:50px ;}
// .sign_table td {height:18px;}
ol li { margin:5px 0px;}
ul ,
ol { padding-left:25px;}
</style>";

$output .= '
<!-- Wrap the content of your PDF inside a main tag -->
<div class="header"> 
   <table width="100%"><tr><td width="170" valign="center" style="vertical-align: middle;">

<img src="../aol-pdf/images/academy_of_learning_logo.jpg" width="170" style="margin-right:30px;" /></td></tr></table>
</div>

<!-- Wrap the content of your PDF inside a main tag -->
<main class="page"> 

<h4 class="text-center">OSAP GUIDELINES FOR RELEASING FUNDS</h4>
<br><br>
<p>Dear Student,<br><br>
Academy of Learning is committed to ensuring that Students understand their responsibilities and the
policies concerning their funding. This document explains the specific guidelines for the release of OSAP
funding. Students must read the following information and sign this document as confirmation that
Academy of Learning has provided this information to the Student, and that all questions have been
answered satisfactorily.<br><br>
Once a Student has been approved for OSAP funding, the current OSAP guidelines are as follows:</p>

<ul><li style="margin-bottom="15px;"">The first portion of approved funds will be released at the commencement of studies, no sooner
than the Disbursement Date allowable. The student must show their commitment to study by
following the Active Participation Policy.</li><br><br>
<li style="margin-bottom="15px;"> The second portion of approved funds will be released:<br><br>
<ul><li style="margin-bottom:10px;"> No sooner than the Disbursement Date shown in the Confirmation of Enrolment work
queue AND</li>
<li style="margin-bottom:10px;"> When Student has successfully completed an amount of course work which meets the
60% progress requirement to remain in good standing with OSAP AND</li>
<li style="margin-bottom:10px;"> The student has shown that they are attending as a full-time student at 20 hours or 25
hours/week with no unexplained absences AND</li>
<li> After the student has undergone a positive mid-point evaluation
</li></ul></li><br><br>
<li>In order to remain in good standing with OSAP, the student MUST successfully complete at 100%
of their courses by their original scheduled end date. Failure to do so may negatively impact your
OSAP standing and you may no longer be eligible for Grant.</li></ul>
<p>Please note that Academy of Learning has no influence or decision power over the requirements outlined
above. These requirements are set forth by OSAP and the Government of Ontario, and any concerns or
disputes regarding these policies and requirements must be addressed to those bodies.
</p>
<table width="100%" class="sign_table" style="margin-top:30px;">
 <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:180px;">'.$fullname.'&nbsp;</td>
 <td width="246"> have read and understand the contents of this document, </td> 
 </tr>

 <tr><td colspan="3"> unding release policies outlined by OSAP, and my responsibilities for ensuring funding.
</td></tr>
</table> <br><br>
 <p>Signed:</p>
 <table width="100%" class="sign_table">
    <tr>
    <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;"><span class="text-center"></span><img src="'.$getSignature.'" width="100" height="26">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="15" style="vertical-align:bottom">Date</td>
    <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr>
<td align="center">(Signature of Student)</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
<td align="center" ></td>
</tr>
</table><br><br>
<p>Witnessed by:</p>

<table width="100%" class="sign_table">
<tr>
    <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;">
	<span class="text-center"></span>'.$fpnDiv.'&nbsp;</td>
    <td>&nbsp;</td>
    <td width="15" style="vertical-align:bottom">Date</td>
    <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr>
	<td align="center">Name: Position Title FAO </td>
	<td align="center" width="100">&nbsp;</td>
	<td align="center"></td>
	<td align="center"></td>
</tr>
</table>
';
$pagename = 'OSAP_GRF_';
$pagename2 = 'OSAP Guidelines for Releasing Funds';
}else{
$output = "<style> 
.header { position: fixed; top: -0px;width:100%;  padding:10px 25px 25px;height:0px; display: block; }
footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 45px 0px;height:25px; font-size:14px; }
footer p { text-align:center;}
main { position:relative;width:100%; }
.mt-0 { margin-top:0px;}
.m-0 {margin:0px !important;}
.page {width:100%;   font-size:14px;  margin-top:20px; padding:0px 25px 5px; page-break-after: always; position:relative;line-height:14px; }
.page:last-child {page-break-after:never;}
h3 { color:#1f497d; font-size:22px; }
 @page { margin:20px 15px 25px; font-weight:599;width:100%;  color:#333; font-size:18px; }
.heading-txt { width:100%;}
.heading-txt p { width:100%; margin:5px 0px;}
.mt-5 { margin-top:50px;}
.text-center { text-align:center;}
p { width:100%; margin:0px; }
.text-justify { text-align:justify;}
.border-bottom { border-bottom:1px solid #ccc;}
</style>";

$output .= '
  <div class="header"></div>
  <footer></footer>
<main class="page"> 
<h4 class="text-center m-0">26</h4>
<h3 class="text-center my-2">Schedule C: International Student Consent Form</h3>
<p class="text-center mt-0" style=" margin:0px; line-height:18px;"><b><u>Notice of Collection of Personal Information and Consent<br>
(Ontario Ministry of Colleges and Universities)</u></b></p><br><br>
<p class="text-justify">International students seeking a study permit to attend a postsecondary learning institution in Ontario must attend a 
postsecondary institution designated by Ontario for the purposes of the Immigration and Refugee Protection Regulations (Canada). This is often referred to as the International Student Program (“ISP”).<br><br>
Under the ISP, private postsecondary institutions are designated by Ontario on an annual basis. As a result, private postsecondary institutions that wish to remain designated apply for designation annually.<br><br>
At the time that you are asked to read and sign this document, you are (1) applying to be enrolled in an institution that is applying for designation for the first time, (2) applying to be enrolled in a designated institution, or (3) enrolled in a designated 
institution. If you are enrolled in an institution that is currently designated, the institution may be applying for further designation annually.<br><br>
When reviewing an institution’s application for designation under the ISP, Ontario’s Ministry of Colleges and Universities (the “Ministry”) conducts a site assessment to verify the information in the institution’s application with respect to its educational policies and procedures. The Ministry may also monitor institutions that are designated to determine whether  those institutions are complying with the terms and conditions of designation.<br><br>
As part of the site assessment and the Ministry’s ongoing monitoring of designated institutions, the Ministry reviews a representative sample of student and prospective student records, such as student and prospective student contracts, registration forms, records of enrollment, documents pertaining to academic assessment and progress, and other documents contained in the student or prospective student file. The Ministry also may need to make copies of student and prospective student records in order to complete its review of the institution’s (1) application for designation or (2) ongoing compliance with the terms and conditions of designation.<br><br>
Your consent is requested to allow the Ministry to access the personal information you have provided to the institution that may be contained in your student records. Without your consent, the Ministry cannot access your records as may be required in order to assess the institution’s application for designation or ongoing compliance with designation conditions.<br><br>
The Ministry collects and uses this information under the authority of ss. 38(2) and 39(1)(a) of the Freedom of Information and Protection of Privacy Act and the Immigration and Refugee Protection Act (Canada) and its Regulations. Questions about the collection, use and disclosure of this information may be addressed to</p>
<table style=" margin:10px 0px;"><tr><td style="padding-left:50px">Manager, International Student Program<br>
Private Career Colleges Branch<br>
Ministry of Colleges and Universities<br>
77 Wellesley Street West, P.O. Box 977<br>
Toronto, Ontario M7A 1N3<br>
416-314-0500 or <a href="ISP@ontario.ca">ISP@ontario.ca</a></td></tr></table>
<p style="margin:5px 0px;"><b>CONSENT</b></p>
<p>By signing below, I hereby consent to: (check boxes that apply)</p>
<ul style="margin-top:10px; text-align:justify"><li>the Ministry’s collection of my personal information from the institution at which I am enrolled or applying to be enrolled for the purposes of assessing the institution’s current and future applications for designation under the 
International Student Program</li><br><br>
<li>the Ministry’s collection of my personal information from the institution at which I am enrolled or applying to be enrolled for the purposes of assessing the institution’s ongoing compliance with the terms and conditions of 
designation, if it is designated by Ontario</li></ul>
<table>
<tr>
<td height="23" valign="bottom">Name:</td>
<td valign="bottom" class=" border-bottom" width="365">'.$fullname.'&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
<table>
<tr>
<td height="23" valign="bottom">Signature:</td>
<td valign="bottom" class=" border-bottom" width="160"><img src="'.$getSignature.'" width="100" height="26">&nbsp;</td>
<td valign="bottom">Date:</td>
<td class=" border-bottom" width="160" valign="bottom">'.$contract_send_date.'&nbsp;</td>
</tr>
</table>
<p style=" margin-top:10px;"><b>For students under 16 years of age, the parent or guardian must also sign:</b></p>
<table><tr><td height="23" valign="bottom">Name:</td><td class=" border-bottom" width="365">&nbsp;</td> 
<td>&nbsp;</td></tr></table>
<table><tr><td height="23" valign="bottom">Signature:</td><td class=" border-bottom" width="160" valign="bottom">&nbsp;</td> <td valign="bottom">Date:</td><td class=" border-bottom" width="160"  valign="bottom">&nbsp;</td></tr></table>
</main>';
$pagename = 'ISCF_';
$pagename2 = 'Schedule C: International Student Consent Form';
}

$output .= '';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($osap_fund_sign)){
	unlink("uploads/$osap_fund_sign");
}

$vnum = str_replace(' ', '', $student_no);
$olname = $pagename.$vnum;
$olname2 = $pagename.$vnum.'.pdf';
$filepath = "uploads/$olname.pdf";

file_put_contents($filepath, $document->output());

if(mysqli_num_rows($get_query3)){
	$getUpdate = "update `ppp_form_more` set `osap_fund_sign`='$olname2', `osap_fund_sign_datetime`='$ppp_datetime' where `ppp_form_id`='$snoid'";
	mysqli_query($con, $getUpdate);
}else{
	$getInsert = "INSERT INTO `ppp_form_more` (`ppp_form_id`, `osap_fund_sign`, `osap_fund_sign_datetime`) VALUES ('$snoid', '$olname2', '$ppp_datetime')";
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
    <title>AOLCC - <?php echo $pagename2; ?></title>
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
                <span class="btn float-start btn-success text-center btn_next">Signed <?php echo $pagename2; ?> Docs</span>
            </div>
			
            <div class="col-12 col-sm-5 py-2">
                <a href="pdf_pai.php?uid=<?php echo $snoid; ?>" class="btn float-sm-end btn-primary text-center btn_next">Continue</a>
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