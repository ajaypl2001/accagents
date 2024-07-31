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
$campus = $rowstr['campus'];
$prgm_id = $rowstr['prgm_id'];
$student_id_2 = $rowstr['student_no'];
$program = $rowstr['program'];
if($program == 'PC Support Specialist Toronto'){
	$program_Lists = 'PC Support Specialist';
}else{
	$program_Lists = $program;
}
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
$fullname = $fname.' '.$lname;
$wordsFirst = explode(' ', $fullname);

$initialsFirst = substr("$wordsFirst[0]", 0, 1);
if(!empty($wordsFirst[1])){
	$initialsFirst1 = substr("$wordsFirst[1]", 0, 1);
}else{
	$initialsFirst1 = '';
}

if(!empty($wordsFirst[2])){
	$initialsFirst2 = substr("$wordsFirst[2]", 0, 1);
}else{
	$initialsFirst2 = '';
}

if(!empty($wordsFirst[3])){
	$initialsFirst3 = substr("$wordsFirst[3]", 0, 1);
}else{
	$initialsFirst3 = '';
}

if(!empty($wordsFirst[4])){
	$initialsFirst4 = substr("$wordsFirst[4]", 0, 1);
}else{
	$initialsFirst4 = '';
}

if(!empty($wordsFirst[5])){
	$initialsFirst5 = substr("$wordsFirst[5]", 0, 1);
}else{
	$initialsFirst5 = '';
}

$initialsStudent = $initialsFirst.''.$initialsFirst1.''.$initialsFirst2.''.$initialsFirst3.''.$initialsFirst4.''.$initialsFirst5;

// $initialsFirst = substr("$fname", 0, 1);
$title = $rowstr['title'];
$dob = $rowstr['dob'];
$province = $rowstr['province'];
$mailing_address = $rowstr['mailing_address'];
$apt = $rowstr['apt'];
$city = $rowstr['city'];
$postal_code = $rowstr['postal_code'];
$mobile_no = $rowstr['mobile_no'];
$alternate_mobile_no = $rowstr['alternate_mobile_no'];
$email_address = $rowstr['email_address'];
$parmanent_address = $rowstr['parmanent_address'];
$contract_student_signature = $rowstr['contract_student_signature'];
$getSignature = '../Student_Sign/'.$contract_student_signature;

if($campus == 'Toronto'){
	$InstitutionCode = 'EPXG';
}elseif ($campus == 'Brampton'){
	$InstitutionCode = 'EQDQ';
}elseif ($campus == 'Hamilton'){
	$InstitutionCode = 'EQDT';
}else{
	$InstitutionCode = '';
}

$location_Practicum = $rowstr['location_Practicum'];
if($location_Practicum == 'N/A'){
	$pr_Div = '<img width="10" src="../aol-pdf/images/box.jpg">';
}else{
	if($program == 'Business Administration '){
		$showAcOnly = '<img width="10" src="../aol-pdf/images/check.jpg">';
	}else{
		$showAcOnly = '<img width="10" src="../aol-pdf/images/check.jpg">';
	}
}


if($title == 'Mr'){
	$Mr_Div = '<img width="13" src="../aol-pdf/images/check.jpg">';
}else{
	$Mr_Div = '<img width="13" src="../aol-pdf/images/box.jpg">';
}
if($title == 'Miss'){
	$Miss_Div = '<img width="13" src="../aol-pdf/images/check.jpg">';
}else{
	$Miss_Div = '<img width="13" src="../aol-pdf/images/box.jpg">';
}
if($title == 'Mrs'){
	$Mrs_Div = '<img width="13" src="../aol-pdf/images/check.jpg">';
}else{
	$Mrs_Div = '<img width="13" src="../aol-pdf/images/box.jpg">';
}
if($title == 'Ms'){
	$Ms_Div = '<img width="13" src="../aol-pdf/images/check.jpg">';
}else{
	$Ms_Div = '<img width="13" src="../aol-pdf/images/box.jpg">';
}
$fund_info = $rowstr['fund_info'];
if($fund_info == 'OSAP'){
	$osapFunding = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$osapFunding = '<img width="10" src="../aol-pdf/images/box.jpg">';
}
if($fund_info == 'Second Career'){
	$csFunding = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$csFunding = '<img width="10" src="../aol-pdf/images/box.jpg">';
}
if($fund_info == 'Self-Funded'){
	$sfFunding = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$sfFunding = '<img width="10" src="../aol-pdf/images/box.jpg">';
}
if($fund_info == 'Third Party Funded'){
	$tpfFunding = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$tpfFunding = '<img width="10" src="../aol-pdf/images/box.jpg">';
}
if($fund_info == 'Other'){
	$otherFunding = '<img width="10" src="../aol-pdf/images/check.jpg">';
	$fund_info_other = $rowstr['fund_info_other'];
}else{
	$otherFunding = '<img width="10" src="../aol-pdf/images/box.jpg">';
	$fund_info_other = '';
}

$funding_planner_name = $rowstr['funding_planner_name'];
$no_fees = $rowstr['no_fees'];
$tuition_fees2 = $rowstr['tuition_fees'];
$tuition_fees = number_format((float)$tuition_fees2, 2, '.', '');
$compulsory_fees2 = $rowstr['compulsory_fees'];
$compulsory_fees = number_format((float)$compulsory_fees2, 2, '.', '');
$book_fees2 = $rowstr['book_fees'];
$book_fees = number_format((float)$book_fees2, 2, '.', '');
$uniforms_fees2 = $rowstr['uniforms_fees'];
$uniforms_fees = number_format((float)$uniforms_fees2, 2, '.', '');
$total_fees2 = $rowstr['total_fees'];
$total_fees3 = number_format((float)$total_fees2, 2, '.', '');
$int_fees2 = $rowstr['int_fees'];
$int_fees3 = number_format((float)$int_fees2, 2, '.', '');

$cpl = $rowstr['cpl'];
if(!empty($rowstr['minus_cfpl_amount']) && ($cpl == 'enabled')){
	$minus_cfpl_amount2 = $rowstr['minus_cfpl_amount'];
	$minus_cfpl_amount = number_format((float)$minus_cfpl_amount2, 2, '.', '');
	
	$total_fees4 = ($total_fees3-$minus_cfpl_amount);
}else{
	$minus_cfpl_amount = '0.00';
	
	$total_fees4 = $total_fees3;
}

$total_fees = number_format((float)$total_fees4, 2, '.', '');

$start_date2 = $rowstr['start_date'];
$finish_date2 = $rowstr['finish_date'];
// $finish_date3 = strtotime($finish_date2);
// $decHoliday1 = strtotime('2022-12-15');
// $decHoliday2 = strtotime('2022-12-31');
// if (($finish_date3 >= $decHoliday1) && ($finish_date3 <= $decHoliday2)){
	// $breakDate = '2 Weeks';
// }else{
	// $breakDate = '&nbsp;';
// }
$school_break = $rowstr['school_break'];
$location_Practicum_not = 'N/A';
$contract = $rowstr['contract'];
$study_times = $rowstr['study_times'];
$study_days = $rowstr['study_days'];
$student_type = $rowstr['student_type'];
$comp_program = $rowstr['comp_program'];
if($study_days == 'Mon to Fri'){
	$study_daysDiv = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$study_daysDiv = '<img width="10" src="../aol-pdf/images/box.jpg">';
}
if($student_type == 'International'){
	$student_typeYes = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$student_typeYes = '<img width="10" src="../aol-pdf/images/box.jpg">';
}
if($student_type == 'Domestic'){
	$student_typeNo = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$student_typeNo = '<img width="10" src="../aol-pdf/images/box.jpg">';
}
if($rowstr['more_address'] == ''){
	$AsAboveAddress = '<img width="10" src="../aol-pdf/images/box.jpg">';	
	if(isset($rowstr['mailing_address2'])){
		$mailing_address2 = mysqli_real_escape_string($con, $rowstr['mailing_address2']);
	}else{
		$mailing_address2 = '';
	}
	if(isset($rowstr['apt2'])){
		$apt2 = mysqli_real_escape_string($con, $rowstr['apt2']);
	}else{
		$apt2 = '';
	}
	// $province2 = '';
	if(isset($rowstr['province2'])){
		$province2 = mysqli_real_escape_string($con, $rowstr['province2']);
	}else{
		$province2 = '';
	}
	if(isset($rowstr['city2'])){
		$city2 = mysqli_real_escape_string($con, $rowstr['city2']);
	}else{
		$city2 = '';
	}
	if(isset($rowstr['postal_code2'])){
		$postal_code2 = mysqli_real_escape_string($con, $rowstr['postal_code2']);
	}else{
		$postal_code2 = '';
	}
	if(isset($rowstr['parmanent_address2'])){
		$parmanent_address2 = mysqli_real_escape_string($con, $rowstr['parmanent_address2']);
	}else{
		$parmanent_address2 = '';
	}		
}else{
	$AsAboveAddress = '<img width="10" src="../aol-pdf/images/check.jpg">';
	$mailing_address2 = '';
	$apt2 = '';
	$city2 = '';
	$province2 = '';
	$postal_code2 = '';
	$parmanent_address2 = '';
}
$bay_street = mysqli_real_escape_string($con, $rowstr['bay_street']);
$emg_name = mysqli_real_escape_string($con, $rowstr['emg_name']);
$emg_relation = $rowstr['emg_relation'];
$emg_address = $rowstr['emg_address'];
$emg_apt = $rowstr['emg_apt'];
$emg_city = $rowstr['emg_city'];
$emg_province = $rowstr['emg_province'];
$emg_postal_code = $rowstr['emg_postal_code'];
$emg_phone = $rowstr['emg_phone'];
$emg_alter_phone = $rowstr['emg_alter_phone'];
$emg_cell = $rowstr['emg_cell'];
$ossd = $rowstr['ossd'];
if($ossd == 'Yes'){
	$ossdNoDiv  = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$ossdNoDiv = '<img width="10" src="../aol-pdf/images/box.jpg">';
}
if($ossd == 'No'){
	$ossdYesDiv = '<img width="10" src="../aol-pdf/images/check.jpg">';
}else{
	$ossdYesDiv = '<img width="10" src="../aol-pdf/images/box.jpg">';
}

$study_weeks33 = $rowstr['week1'];
$study_hours3 = $rowstr['study_hours'];

if($student_type == 'International'){
	$intCheckDiv = 'check';
	$int_vid = '-'.$rowstr['int_vid'];
}else{
	$intCheckDiv = 'box';
	$int_vid = '';
}

$contract_send_date = $rowstr['contract_send_date'];

$worker_id = $rowstr['worker_id'];
$agnt_qryFos = mysqli_query($con,"SELECT name, rep_sign FROM ulogin where name!='' AND sno='$worker_id'");
if(mysqli_num_rows($agnt_qryFos)){
	$row_agnt_qryFos = mysqli_fetch_assoc($agnt_qryFos);
	$loggedName = $row_agnt_qryFos['name'];
	$rep_signName = $row_agnt_qryFos['rep_sign'];
	$rep_signName2 = '<img src="Rep_Sign/'.$rep_signName.'" width="100" height="30">';
}else{
	$loggedName = 'N A';
	$rep_signName2 = '';
}

// $initialsLast = substr("$loggedName", 0, 1);

$wordsLast = explode(' ', $loggedName);

$initialsLast = substr("$wordsLast[0]", 0, 1);
if(!empty($wordsLast[1])){
	$initialsLast1 = substr("$wordsLast[1]", 0, 1);
}else{
	$initialsLast1 = '';
}

if(!empty($wordsLast[2])){
	$initialsLast2 = substr("$wordsLast[2]", 0, 1);
}else{
	$initialsLast2 = '';
}

if(!empty($wordsLast[3])){
	$initialsLast3 = substr("$wordsLast[3]", 0, 1);
}else{
	$initialsLast3 = '';
}

if(!empty($wordsLast[4])){
	$initialsLast4 = substr("$wordsLast[4]", 0, 1);
}else{
	$initialsLast4 = '';
}

if(!empty($wordsLast[5])){
	$initialsLast5 = substr("$wordsLast[5]", 0, 1);
}else{
	$initialsLast5 = '';
}

$initialsAdmRep = $initialsLast.''.$initialsLast1.''.$initialsLast2.''.$initialsLast3.''.$initialsLast4.''.$initialsLast5;

/////////////New Table///////////////
$resultsStr3 = "SELECT sno, ppp_form_id, contract_signature FROM `ppp_form_more` where ppp_form_id='$snoid'";
$get_query3 = mysqli_query($con, $resultsStr3);
if(mysqli_num_rows($get_query3)){
	$rowstr3 = mysqli_fetch_assoc($get_query3);
	$contract_signature = $rowstr3['contract_signature'];
}else{
	$contract_signature = '';	
}
///////////////////////////////////////

$resultsStr2 = "SELECT * FROM `schedule_of_fees` where sno='$prgm_id'";
$get_query2 = mysqli_query($con, $resultsStr2);
$rowstr2 = mysqli_fetch_assoc($get_query2);

if(!empty($study_hours3)){
	$study_hours = $study_hours3;
}else{
	$study_hours = $rowstr2['study_hours'];
}

if($school_break == '' || $school_break == 'NA'){
	$study_weeks_winter = $study_weeks33;
}else{
	$study_weeks_winter = $study_weeks33+2;
}
$dipl_cert = $rowstr2['dipl_cert'];
$uniforms_other2 = $rowstr2['uniforms_other'];
$uniforms_other = number_format((float)$uniforms_other2, 2, '.', '');

$declarationParalegal = '';
$showAcOnly = '';

if($program == 'Personal Support Worker'){
	$dynamicNum = '11';
    $hstProfessional = '<td>Uniform/Professional exam fees</td>
	<td> $'.$uniforms_fees.'</td>';
	$examFees = '<td>&nbsp;</td><td>&nbsp;</td>';
	$pageProgramDiv = '
	<p><b>Admission Requirements</b></p>
	<p><b><img width="10" src="../aol-pdf/images/box.jpg"> Domestic Students</b></p>
	<p style="margin-left:20px;">
	'.$ossdNoDiv.' Have an Ontario Secondary School Diploma or equivalent (copy of Transcript or Diploma included); OR<br>
	'.$ossdYesDiv.' Be at least 18 years of age and pass a superintendent approved qualifying test.
	</p><br>
	<p><b><img width="10" src="../aol-pdf/images/box.jpg"> For Domestic and International Students</b></p>
	<p style="margin-left:20px;"><img width="10" src="../aol-pdf/images/check.jpg">  ; NACC Technical Literacy Test (minimum score of 18), OR IELTS English Test with a minimum average score of 6.0 with no subject test score lower than 5.5, OR TOEFL – overall score of 80 with a minimum of 20 in each component: Reading 20; Speaking 20; Listening 20; Writing 20<br>
	<img width="10" src="../aol-pdf/images/check.jpg"> Signed Vulnerable Sector Disclaimer; AND<br>
	<img width="10" src="../aol-pdf/images/check.jpg"> Signed Medical Disclaimer
	</p>';
$acknowledgeDiv = '
<table width="100%" class="sign_table">
 <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:220px;">'.$fullname.'&nbsp;</td>
 <td>  acknowledge that I have received a copy of and agree to abide by:</td>
 </tr>
 </table>
 <ul class="list-check"><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Academy of Learning Career College’s Student Handbook  </li>
 </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Academy of Learning Career College’s Privacy Policy
 </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Payment Schedule 
 </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Consent to Use of Personal Information
 </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Statement of Students’ Rights and Responsibilities Issued by the Superintendent of Private Career Colleges
 </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Fee Refund Policy 
 </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Student Complaint Procedure
 </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Policy Relating to the Expulsion of Students
 </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Sexual Violence Policy
</li></ul>';
$privacyPolicy = '  <main class="page"> 
<br>
<br>
<p><b>PRIVACY POLICY STATEMENT</b><br><Br>
Academy of Learning Career College is committed to, and accountable for, the protection and proper use of your personal information.  Our commitment extends to meeting and/or exceeding all legislated requirements.<br>
Personal Information is identifiable information such as: name, address, e-mail address, social insurance identification,        birth date and gender.  Personal information is collected by us when you provide it during the enrollment process, or requests for information regarding training.  Business contact information such as the name, title, business address, business e-mail address or the telephone number of a business or professional persona or an employee of an organization is not considered personal information.<br><br>
‘Non-personal information’ is information of an anonymous nature, such as aggregate information, including demographic statistics.
</p>
<br>
<p><b><u>Use of Personal Information</u>
</b><br>Personal Information may be used by us for the following purposes:</p>
<ul><li> To manage and administer the delivery of training and relevant services to Academy of Learning Career College students</li>
<li> To maintain the accuracy of our records in accordance with legal, regulatory and contractual obligations</li>
<li> To allow authorized personnel access to student files to ensure accuracy and regulatory compliance with same</li>
<li> To occasionally contact consumers about training and relevant services that are available from Academy of Learning Career College</li>
<li> To perform statistical analysis of the collective characteristics and behaviours of Academy of Learning Career College students in or der to monitor and improve our operations and maintain the quality of our products and services
</li></ul>
<p><u><b>Disclosure of Personal Information</b></u>
<br>
We will disclose personal information to 3rd Parties</p>
<ul><li> Where you have given us your signed consent to disclose for a designated purpose</li>
<li> Who are acting on our behalf as agents, suppliers or service providers, solely to enable us to more efficiently provide you with training and other services</li>
<li> As required by law, including by order of any court, institution or body with authority to compel the production of information
</li></ul>
<p><b><u>Access to Personal Information</u></b><br>
For access to your personal information, please contact the Campus Director.  A request should be in writing and should include sufficient identifying information so that we can expeditiously locate your information
</p><br>
<p><b><u>Questions, Comments</u></b><br>
If you have questions or comments about this Privacy Policy or any other Academy of Learning Career college privacy practice that were not answered here, please contact our designated Privacy Officer at 1855-996-9977.
</p><br>
<p><b>STATEMENT OF RELEASE OF INFORMATION</b><br><br>
I hereby consent and give Academy of Learning Career College permission to release/disclose my school information to any agent of the college, their respective employees, officers and agents, my funding agency and AOLCC’s Franchise Support Centre staff, as authorized, any or all of the information contained in my college records including personal, financial (student account information), academic, attendance and any other information entered and maintained in my files (electronic and hard copy formats).  I understand that all information will be kept confidential and utilized to provide information as it relates to the program of studies, labour market re-entry and to maintain the accuracy of my records in accordance with legal, regulatory and contractual requirements.  This information will not be used for any other purpose nor will it be released to any other parties.</p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:200px; height:30px;">'.$fullname.'&nbsp;</td>
  <td align="center" width="100">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr> <td align="center">Student Name (Please Print)</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
</tr></table> 
<table width="100%" class="sign_table">
<tr> 
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:180px; height:35px; ">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
    <td width="200">&nbsp;</td>
    <td width="30" style="vertical-align:bottom">Date</td>
    <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
</tr><tr> 
<td align="center">Signature of Student</td>
    <td>&nbsp;</td>
    <td style="vertical-align:bottom"></td>
    <td>&nbsp;</td>
</tr>
</table>
        </main>';
        $declarationParalegal = '';
$practicumRequirement = '  <main class="page"> 
<br>
<br>         
<p class="text-center"><b>PRACTICUM REQUIREMENTS – PERSONAL SUPPORT WORKER </b><p><br><p>I <u>'.$fullname.'</u> acknowledge that it is my responsibility to have the practicum requirements, as listed below, in place before I can begin my practicum to complete the Personal Support Worker program and receive credentials:
</p>
<ul><li> Minimum mark of 70% in each PSW Module with no evaluation method below 70%; and </li>
<li> Minimum mark of 70% with no critical deficiencies in each of the skills Performance Demonstrations; and</li>
<li> Minimum mark of 60% in each ILS course;</li>
<li> Satisfactory attendance record; and </li>
<li> Current Standard First Aid and Basic Rescuer (Level C) CPR Certification; and </li>
<li> Resume and Placement Preference Sheet at least 30 days prior to placement; and </li>
<li> Interview by Host may be required prior to placement.
</li></ul>
<p> I further understand that I will NOT engage in a practicum if any of the program practicum requirements, as listed above, are not met prior to placement.</p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>  
<td>&nbsp;</td>
<td width="20" style="vertical-align:bottom">Date</td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Signature of Student</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
<td align="center" >(mm/dd/yyyy)</td>
</tr></table> <br>
<p class="text-center"><b>Vulnerable Sector Disclaimer</b></p><br>
<p>As this program will involve direct contact with vulnerable individuals, you must complete a clean Vulnerable Sector Screening (“VSS”) prior to commencing any placement or practicum. It is strongly advised that you complete your VSS prior to commencing your vocational training to ensure that you can complete this program and are eligible for a placement or practicum and, subsequently, graduation. 
<br><br>
As a VSS can take 10 to 12 weeks to complete, if you choose not to complete a VSS <b>prior</b> to commencing this program, please plan your time accordingly to ensure that you have obtained documentation of a clean VSS prior to applying for a placement or practicum. If you ignore this caution, you risk being ineligible for a placement or practicum, <b>ineligible to graduateand potentially only eligible for a partial refund or no refund of tuition for this program if you fail to graduate. </b> <br><br>
A VSS involves a search of the Vulnerable Sector Database, maintained by the Ontario Provincial Police, for any information about you in police files, including criminal convictions, outstanding charges, and information about whether you are suspected of committing a criminal offence or involved in a serious criminal investigation. Police databases will also document any contact that you may have had with police services under the Mental Health Act, 1990. 
<br><br><b>
You must also ensure that you do not engage in any activities at anytime during the program, including while undertaking a placement or practicum that would render a clean VSS previously submitted by you void.  Failure to maintain a clean VSS will also render you unable to undertake or continue the placement or practicum, ineligible for graduation and only eligible for a partial refund or no refund of tuition, depending on when you withdraw or are expelled from the program.</b>
</p><br>

 <p> I   <u>'.$fullname.' </u> 
 acknowledge that I have 

 read the above disclosure and understand that I need to obtain a clean VSS  <b> prior </b> to applying for a placement or practicum and that I must, while enrolled in the program, maintain a clean VSS in order to complete the placement or practicum and to graduate. I also understand that if I do not obtain or maintain a clean VSS, I risk:  <b>1. being ineligible for placement or continued placement; 2. ineligible to graduate; 3. eligible for a partial refund or no refund of tuition, depending on when I withdraw or am expelled from this program. </b><br><br>
Further information regarding the Police Reference Check Program and the VSS process can be viewed at <a href="http://www.torontopolice.on.ca/prcp/" target="blank"> http://www.torontopolice.on.ca/prcp/.  </a>  
<table width="100%" class="sign_table">
<tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:180px; height:30px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
<td>&nbsp;</td>
<td width="20" style="vertical-align:bottom">Date</td>
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  width:160px;">'.$contract_send_date.'&nbsp;</td>
</tr> <tr> 
<td align="center">Signature of Student</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="center">(mm/dd/yyyy)</td>
</tr>
</table> </main>';
$medicalDisclaimer = '<main class="page"> 
<br>
<br>                           
<p class="text-center"><b>Medical Disclaimer</b><p><br><p>As this program will involve direct contact with vulnerable individuals, students must submit a completed and satisfactory medical report prior to commencing any practicum placement. It is mandatory to submit the medical report within<br>
45 days of commencement of study to ensure that you can complete the program and be eligible to graduate.<br><Br>
Completion of a medical report can take up to four (4) weeks to complete or longer (up to 6 months) if further vaccinations are required. If you are unable to submit the required medical report within 45 days of commencing the program, you risk (1) being ineligible for a practicum placement; (2) being ineligible to graduate from the program; and (3) being ineligible for a partial refund or no refund of tuition, depending on the date of withdrawal.
</p><br>
<p class="text-center">According to NACC Personal Support Worker Policy:</p>
<ul style="list-style:none; padding:10px 80px;"><li>“ALL students accepted into the PSW Program MUST be free from communicable disease, have an up-to-date immunization status, and have a level of fitness sufficient to complete the clinical placement. All students must be provided with an Medical Report on enrollment for completion by their medical practitioner.”</li></ul>
<p>
The completed Medical Report must be:</p>
<ol start="1"><li>  completed and returned to the college within 45 days of class start.</li>
<li>  reviewed by the PSW Program Director to ensure confirmation of current immunization status and the student is free from communicable diseases. The PSW Instructor must be consulted for any health-related interpretation that is required; and</li>
<li>   placed in the student’s file following review/interpretation.
</li></ol>
<p>No students may participate in any Clinical Placement hours prior to submitting a completed and satisfactory immunization & medical report.<br><br>
I, <u> '.$fullname.' </u> acknowledge that I have read the above disclosure and understand that I must obtain and submit up-to-date immunization status within 45 days of commencement of study and that I must, while enrolled in the program, maintain this status in order to complete the practicum placement and graduate. I also understand that if I do not obtain and maintain this up-to-date immunization status, I risk: 1. being ineligible for a practicum placement; 2. being ineligible to graduate from the program; and 3. being ineligible for a partial refund or no refund of tuition, depending on when I withdraw from this program.</p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:180px; height:30px;"><img src="'.$getSignature.'" width="100" height="30"></td>  
<td>&nbsp;</td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Student Signature</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" >Date</td>
</tr></table></main>';
$termCondition = '<ol start="1"><li> All enrolment contract fees are due and payable on commencement of the program unless specific arrangements have been made with the College.</li>
<li>  To register for and to reserve a seat in any diploma or certificate program, all applicants must include the minimum required payment, as per the <b>Private Career Colleges Act</b>, 2005, which will be applied to the enrolment contract fees, and the balance of which is to be paid as per the student payment schedule.</li>
<li>  Enrolment contract fees are tax deductible and a tax certificate will be issued in accordance with the guidelines of the federal government.  </li>
<li> Certain courses can only be enrolled in, once prerequisite courses or equivalents are met.  Refer to the course outline of each program for prerequisites, or consult one of the Admissions Representatives.</li>
<li>  No refund will be given for occasional absences from scheduled classes.</li>
<li>  The credential will not be issued until all financial obligations to Academy of Learning Career College have been met.</li>
<li>  All programs are held subject to sufficient enrolment, and may be postponed at the discretion of the College, and any fees paid will be credited to that future program or refunded according to the <b>Private Career Colleges Act</b>, 2005.</li>
<li> If an applicantis unable to commence a programon the date arranged, the applicant must notify the College as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future programor refunded according to the <b>Private Career Colleges Act</b>, 2005.</li>
<li> The duration of the program as shown on the enrolment contract indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total enrolment contract feesare still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the College. </li>
<li> Rather than conventional classroom instruction a student works as an individual, using the accessible materials/equipment.  A trained facilitator is always present to give individualized support as needed by each student.</li>
<li> A student enrolled in virtual learning works as an individual, using accessible materials/equipment and support from the facilitator and/or the virtual learning instructor.  </li>
<li> The student may choose the hours of attendance, either the morning or afternoon session, and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose (not applicable for the courses delivered by instructors). However, the student is obligated to complete the program within the time frame determined by the given end-date and the college’s guidelines for completing individual courses. The College must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.</li>
<li>It is to the student’s advantage to arrive at least 5 minutes before the scheduled time on the enrolment contract</li>
<li> Academy of Learning Career College is not responsible for loss of personal property or for personal injury from whatever cause.  </li>
<li>Students of the Academy of Learning Career College are required to follow the provisions of the current edition of the Student Handbook.  
</li></ol>';
}
elseif($program == 'Personal Support Worker challenge Fund'){
	$dynamicNum = '11';
    $hstProfessional = '<td>Uniform/Professional exam fees</td>
	<td> $195.00</td>';
	$examFees = '<td>&nbsp;</td><td>&nbsp;</td>';
	$pageProgramDiv = '
	<p><b>Admission Requirements</b></p>
	<p><b><img width="10" src="../aol-pdf/images/check.jpg"> Domestic Students</b></p>
	<p style="margin-left:20px;">
'.$ossdNoDiv.' Have an Ontario Secondary School Diploma or equivalent (copy of Transcript or Diploma included); OR<br>
'.$ossdYesDiv.' Be at least 18 years of age and pass a superintendent approved qualifying test.
</p><br>
<p><b><img width="10" src="../aol-pdf/images/check.jpg"> For Domestic and International Students</b></p>
<p style="margin-left:20px;"><img width="10" src="../aol-pdf/images/check.jpg">  ; NACC Technical Literacy Test (minimum score of 18), OR IELTS English Test with a minimum average score of 6.0 with no subject test score lower than 5.5, OR TOEFL – overall score of 80 with a minimum of 20 in each component: Reading 20; Speaking 20; Listening 20; Writing 20<br>
<img width="10" src="../aol-pdf/images/check.jpg"> Signed Vulnerable Sector Disclaimer; AND<br>
<img width="10" src="../aol-pdf/images/check.jpg"> Signed Medical Disclaimer
</p>';
$acknowledgeDiv = '<table width="100%" class="sign_table"> <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:220px;">'.$fullname.'&nbsp;</td>
 <td>  acknowledge that I have received a copy of and agree to abide by:</td>
 </tr></table><ul class="list-check"><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Academy of Learning Career College’s Student Handbook  </li></li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Academy of Learning Career College’s Privacy Policy</li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Payment Schedule </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Consent to Use of Personal Information</li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Statement of Students’ Rights and Responsibilities Issued by the Superintendent of Private Career Colleges</li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Fee Refund Policy </li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Student Complaint Procedure</li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Policy Relating to the Expulsion of Students</li><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Sexual Violence Policy</li></ul>';
 $privacyPolicy = '  <main class="page"> 
 <br>
 <br>
 <p><b>PRIVACY POLICY STATEMENT</b><br><Br>
 Academy of Learning Career College is committed to, and accountable for, the protection and proper use of your personal information.  Our commitment extends to meeting and/or exceeding all legislated requirements.<br>
 Personal Information is identifiable information such as: name, address, e-mail address, social insurance identification,        birth date and gender.  Personal information is collected by us when you provide it during the enrollment process, or requests for information regarding training.  Business contact information such as the name, title, business address, business e-mail address or the telephone number of a business or professional persona or an employee of an organization is not considered personal information.<br><br>
 ‘Non-personal information’ is information of an anonymous nature, such as aggregate information, including demographic statistics.
 </p>
 <br>
 <p><b><u>Use of Personal Information</u>
 </b><br>Personal Information may be used by us for the following purposes:</p>
 <ul><li> To manage and administer the delivery of training and relevant services to Academy of Learning Career College students</li>
 <li> To maintain the accuracy of our records in accordance with legal, regulatory and contractual obligations</li>
 <li> To allow authorized personnel access to student files to ensure accuracy and regulatory compliance with same</li>
 <li> To occasionally contact consumers about training and relevant services that are available from Academy of Learning Career College</li>
 <li> To perform statistical analysis of the collective characteristics and behaviours of Academy of Learning Career College students in or der to monitor and improve our operations and maintain the quality of our products and services
 </li></ul>
 <p><u><b>Disclosure of Personal Information</b></u>
 <br>
 We will disclose personal information to 3rd Parties</p><ul><li> Where you have given us your signed consent to disclose for a designated purpose</li>
 <li> Who are acting on our behalf as agents, suppliers or service providers, solely to enable us to more efficiently provide you with training and other services</li>
 <li> As required by law, including by order of any court, institution or body with authority to compel the production of information
 </li></ul>
<p><b><u>Access to Personal Information</u></b><br>
For access to your personal information, please contact the Campus Director.  A request should be in writing and should include sufficient identifying information so that we can expeditiously locate your information
</p><br>
<p><b><u>Questions, Comments</u></b><br>
If you have questions or comments about this Privacy Policy or any other Academy of Learning Career college privacy practice that were not answered here, please contact our designated Privacy Officer at 1855-996-9977.
</p><br>
<p><b>STATEMENT OF RELEASE OF INFORMATION</b><br><br>
I hereby consent and give Academy of Learning Career College permission to release/disclose my school information to any agent of the college, their respective employees, officers and agents, my funding agency and AOLCC’s Franchise Support Centre staff, as authorized, any or all of the information contained in my college records including personal, financial (student account information), academic, attendance and any other information entered and maintained in my files (electronic and hard copy formats).  I understand that all information will be kept confidential and utilized to provide information as it relates to the program of studies, labour market re-entry and to maintain the accuracy of my records in accordance with legal, regulatory and contractual requirements.  This information will not be used for any other purpose nor will it be released to any other parties.</p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:200px; height:30px;">'.$fullname.'&nbsp;</td>
  <td align="center" width="100">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr> <td align="center">Student Name (Please Print)</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
</tr></table> 
<table width="100%" class="sign_table">
<tr> 
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:180px; height:35px; ">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
    <td width="200">&nbsp;</td>
    <td width="30" style="vertical-align:bottom">Date</td>
      <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
        </tr>
        <tr> 
<td align="center">Signature of Student</td>
    <td>&nbsp;</td>
    <td style="vertical-align:bottom"></td>
    <td>&nbsp;</td>
</tr>
</table>
 </main>';
 $declarationParalegal = '';
	$practicumRequirement = '  <main class="page"> 
<br>
<br>  
<p class="text-center"><b>PRACTICUM REQUIREMENTS – PERSONAL SUPPORT WORKER </b><p><br><p>I <u>'.$fullname.'</u> acknowledge that it is my responsibility to have the practicum requirements, as listed below, in place before I can begin my practicum to complete the Personal Support Worker program and receive credentials:
</p>
<ul><li> Minimum mark of 70% in each PSW Module with no evaluation method below 70%; and </li>
<li> Minimum mark of 70% with no critical deficiencies in each of the skills Performance Demonstrations; and</li>
<li> Minimum mark of 60% in each ILS course;</li>
<li> Satisfactory attendance record; and </li>
<li> Current Standard First Aid and Basic Rescuer (Level C) CPR Certification; and </li>
<li> Resume and Placement Preference Sheet at least 30 days prior to placement; and </li>
<li> Interview by Host may be required prior to placement.
</li></ul>
<p> I further understand that I will NOT engage in a practicum if any of the program practicum requirements, as listed above, are not met prior to placement.</p>
    <table width="100%" class="sign_table">
  <tr> 
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>  
<td>&nbsp;</td>
<td width="20" style="vertical-align:bottom">Date</td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
  </tr>
  <tr> <td align="center">Signature of Student</td>
  <td  align="center" width="100">&nbsp;</td>
  <td align="center" ></td>
  <td align="center" >(mm/dd/yyyy)</td>
  </tr></table> <br>
<p class="text-center"><b>Vulnerable Sector Disclaimer</b></p><br>
<p>As this program will involve direct contact with vulnerable individuals, you must complete a clean Vulnerable Sector Screening (“VSS”) prior to commencing any placement or practicum. It is strongly advised that you complete your VSS prior to commencing your vocational training to ensure that you can complete this program and are eligible for a placement or practicum and, subsequently, graduation. 
<br><br>
As a VSS can take 10 to 12 weeks to complete, if you choose not to complete a VSS <b>prior</b> to commencing this program, please plan your time accordingly to ensure that you have obtained documentation of a clean VSS prior to applying for a placement or practicum. If you ignore this caution, you risk being ineligible for a placement or practicum, <b>ineligible to graduateand potentially only eligible for a partial refund or no refund of tuition for this program if you fail to graduate. </b> <br><br>
A VSS involves a search of the Vulnerable Sector Database, maintained by the Ontario Provincial Police, for any information about you in police files, including criminal convictions, outstanding charges, and information about whether you are suspected of committing a criminal offence or involved in a serious criminal investigation. Police databases will also document any contact that you may have had with police services under the Mental Health Act, 1990. 
<br><br><b>
You must also ensure that you do not engage in any activities at anytime during the program, including while undertaking a placement or practicum that would render a clean VSS previously submitted by you void.  Failure to maintain a clean VSS will also render you unable to undertake or continue the placement or practicum, ineligible for graduation and only eligible for a partial refund or no refund of tuition, depending on when you withdraw or are expelled from the program.</b>
</p><br>
 <p> I   <u>'.$fullname.' </u> 
  acknowledge that I have 
read the above disclosure and understand that I need to obtain a clean VSS  <b> prior </b> to applying for a placement or practicum and that I must, while enrolled in the program, maintain a clean VSS in order to complete the placement or practicum and to graduate. I also understand that if I do not obtain or maintain a clean VSS, I risk:  <b>1. being ineligible for placement or continued placement; 2. ineligible to graduate; 3. eligible for a partial refund or no refund of tuition, depending on when I withdraw or am expelled from this program. </b><br><br>
  Further information regarding the Police Reference Check Program and the VSS process can be viewed at <a href="http://www.torontopolice.on.ca/prcp/" target="blank"> http://www.torontopolice.on.ca/prcp/.  </a>  
<table width="100%" class="sign_table">
  <tr> 
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:180px; height:30px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
  <td>&nbsp;</td>
<td width="20" style="vertical-align:bottom">Date</td>
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  width:160px;">'.$contract_send_date.'&nbsp;</td>
  </tr> <tr> 
  <td align="center">Signature of Student</td>
  <td>&nbsp;</td>
<td>&nbsp;</td>
<td align="center">(mm/dd/yyyy)</td>
  </tr>
</table> </main>';
$medicalDisclaimer = '<main class="page"> 
<br>
<br> 
<p class="text-center"><b>Medical Disclaimer</b><p><br><p>As this program will involve direct contact with vulnerable individuals, students must submit a completed and satisfactory medical report prior to commencing any practicum placement. It is mandatory to submit the medical report within<br>
45 days of commencement of study to ensure that you can complete the program and be eligible to graduate.<br><Br>
Completion of a medical report can take up to four (4) weeks to complete or longer (up to 6 months) if further vaccinations are required. If you are unable to submit the required medical report within 45 days of commencing the program, you risk (1) being ineligible for a practicum placement; (2) being ineligible to graduate from the program; and (3) being ineligible for a partial refund or no refund of tuition, depending on the date of withdrawal.
</p><br>
<p class="text-center">According to NACC Personal Support Worker Policy:</p>
<ul style="list-style:none; padding:10px 80px;"><li>“ALL students accepted into the PSW Program MUST be free from communicable disease, have an up-to-date immunization status, and have a level of fitness sufficient to complete the clinical placement. All students must be provided with an Medical Report on enrollment for completion by their medical practitioner.”</li></ul>
<p>
The completed Medical Report must be:</p>
<ol start="1"><li>  completed and returned to the college within 45 days of class start.</li>
<li>  reviewed by the PSW Program Director to ensure confirmation of current immunization status and the student is free from communicable diseases. The PSW Instructor must be consulted for any health-related interpretation that is required; and</li>
<li>   placed in the student’s file following review/interpretation.
</li></ol>
<p>No students may participate in any Clinical Placement hours prior to submitting a completed and satisfactory immunization & medical report.<br><br>
I, <u> '.$fullname.' </u> acknowledge that I have read the above disclosure and understand that I must obtain and submit up-to-date immunization status within 45 days of commencement of study and that I must, while enrolled in the program, maintain this status in order to complete the practicum placement and graduate. I also understand that if I do not obtain and maintain this up-to-date immunization status, I risk: 1. being ineligible for a practicum placement; 2. being ineligible to graduate from the program; and 3. being ineligible for a partial refund or no refund of tuition, depending on when I withdraw from this program.</p>
    <table width="100%" class="sign_table">
  <tr> 
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:180px; height:30px;"><img src="'.$getSignature.'" width="100" height="30"></td> 
  <td>&nbsp;</td>
  <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
  </tr>
  <tr> <td align="center">Student Signature</td>
  <td  align="center" width="100">&nbsp;</td>
  <td align="center" >Date</td>
  </tr></table></main>';
  $termCondition = '<ol start="1"><li> All enrolment contract fees are due and payable on commencement of the program unless specific arrangements have been made with the College.</li>
<li>  To register for and to reserve a seat in any diploma or certificate program, all applicants must include the minimum required payment, as per the <b>Private Career Colleges Act</b>, 2005, which will be applied to the enrolment contract fees, and the balance of which is to be paid as per the student payment schedule.</li>
<li>  Enrolment contract fees are tax deductible and a tax certificate will be issued in accordance with the guidelines of the federal government.  </li>
<li> Certain courses can only be enrolled in, once prerequisite courses or equivalents are met.  Refer to the course outline of each program for prerequisites, or consult one of the Admissions Representatives.</li>
<li>  No refund will be given for occasional absences from scheduled classes.</li>
<li>  The credential will not be issued until all financial obligations to Academy of Learning Career College have been met.</li>
<li>  All programs are held subject to sufficient enrolment, and may be postponed at the discretion of the College, and any fees paid will be credited to that future program or refunded according to the <b>Private Career Colleges Act</b>, 2005.</li>
<li> If an applicantis unable to commence a programon the date arranged, the applicant must notify the College as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future programor refunded according to the <b>Private Career Colleges Act</b>, 2005.</li>
<li> The duration of the program as shown on the enrolment contract indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total enrolment contract feesare still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the College. </li>
<li> Rather than conventional classroom instruction a student works as an individual, using the accessible materials/equipment.  A trained facilitator is always present to give individualized support as needed by each student.</li>
<li> A student enrolled in virtual learning works as an individual, using accessible materials/equipment and support from the facilitator and/or the virtual learning instructor.  </li>
<li> The student may choose the hours of attendance, either the morning or afternoon session, and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose (not applicable for the courses delivered by instructors). However, the student is obligated to complete the program within the time frame determined by the given end-date and the college’s guidelines for completing individual courses. The College must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.</li>
<li>It is to the student’s advantage to arrive at least 5 minutes before the scheduled time on the enrolment contract</li>
<li> Academy of Learning Career College is not responsible for loss of personal property or for personal injury from whatever cause.  </li>
<li>Students of the Academy of Learning Career College are required to follow the provisions of the current edition of the Student Handbook.  
</li></ol>';
}
elseif($program == 'Paralegal'){
	$dynamicNum = '9';

 $hstProfessional = '<td>Uniform/Professional exam fees</td>
             <td> $'.$uniforms_fees.'</td>';
             $examFees = '<td>&nbsp;</td><td> $0.00 </td>';
             if($location_Practicum == 'N/A'){
	$pr_Div = '<img width="10" src="../aol-pdf/images/box.jpg">';
}else{
	$pr_Div = '<img width="10" src="../aol-pdf/images/check.jpg">';
}
$pageProgramDiv = '
<p><b>Admission Requirements</b></p>
<p style="margin-left:20px; margin-bottom:10px;"><img width="10" src="../aol-pdf/images/check.jpg">  Have an Ontario Secondary School Diploma (OSSD) or equivalent; and<br>
<img width="10" src="../aol-pdf/images/check.jpg">   Ontario Paralegal Licensing Disclosure; and<br><img width="10" src="../aol-pdf/images/check.jpg"> 
Interview with Legal Program Coordinator or Campus Director
</p>
<p><b><img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg"> International Students (in addition to the requirements above):</b></p>
<p style="margin-left:20px;"><img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg">  Proof of Health Insurance Coverage for entire study period; and<br>
<img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg"> Appropriate student authorization or a Study Permit from Citizenship and Immigration Canada; 
</p>
<p style="margin-top:10px;"><b><img width="10" src="../aol-pdf/images/box.jpg"> Practicum Requirements are requirements or qualifications that students must meet before they begin a practicum: </b></p>
<p style="margin-left:20px; margin-bottom:10px;">
'.$pr_Div.' All program modules completed plus minimum pass mark (60% on ILS courses and 70% on legal courses) for each subject<br>
'.$pr_Div.' 75% overall average grade for program<br>
'.$showAcOnly.' <b style=" color:red;">Program fees 100% paid</b>
</p>
  <table width="100%" class="sign_table">
   <tr>
 <td width="3"> I   </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:130px;">'.$fullname.'&nbsp;</td>
 <td width="246">   acknowledge that it is my responsibility to have the practicum requirements, as  identified above,</td>

 </tr>
 <tr><td colspan="3">  in place before I can  begin my practicum, work placement, or clinical placement.</td></tr>
 </table>';
$acknowledgeDiv = '
<table width="100%" class="sign_table">
 <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$fullname.'</td>
 <td>  acknowledge that I have received a copy of:</td>

 </tr>
 </table>  
 <ul class="list-check" style="margin-top:0px;"><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Statement of Students’ Rights and Responsibilities Issued by the Superintendent of Private Career Colleges
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Fee Refund Policy 
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Consent to Use of Personal Information
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Payment Schedule  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Student Handbook  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Student Complaint Procedure
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Policy Relating to the Expulsion of Students
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Policy on Sexual Violence and Harassment
 </li></ul>';
 $privacyPolicy = '';
 $declarationParalegal = ' <main class="page"> 
 <br>     
 <h5 class="text-center"><u>Declaration for Paralegal Licensing Requirement:</u></h5>
   <table width="100%" class="sign_table">
    <tr><td>I</td>
 <td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$fullname.'&nbsp;</td>
 <td width="346"> <b>have visited the Law Society of Ontario </b> website</td>

 </tr>
  <tr>
  <td colspan="3" width="1">(Paralegal Licensing Process | Law Society of Ontario (lso.ca)) and I am aware of the licensing requirement which includes the good character requirement. I am myself responsible to satisfy the requirement.</td>

 </tr>
 </table>
 <table width="100%" class="sign_table">
 <tr> 
 <td  align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
   <td align="center" width="160">&nbsp;</td>
   <td align="center" width="20">Date</td>
   <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Signature of Student </td>
<td  align="center" width="160">&nbsp;</td>
<td  align="center" width="20">&nbsp;</td>
<td align="center" >(mm/dd/yyyy)</td>
</tr></table> 
        </main>
        ';
 $practicumRequirement = '';
	  $medicalDisclaimer = '';
	  $noticeCollection = '';
	    $termCondition = '
	    <ol start="1" class="term-ul"><li> All program fees are due and payable on commencement of the program unless specific arrangements have been made with the Admissions Office.</li>
	    <li>  Financial assistance may be available to those who qualify.  Check with the Admissions Office for details.</li>
	    <li>  To register for and to reserve a seat in any diploma program, all applicants must include the minimum required payment, as per the PCC Act, 2005 for the program which will be applied to the program fee, the balance of which is to be paid as per the student payment schedule.</li>
	    <li>Program fees are tax deductible and a tax certificate will be issued in accordance with the guidelines of the federal government. </li>
	    <li>Certain courses can only be enrolled in, once prerequisite courses or equivalents have been taken.  Refer to the course outline of each program for prerequisites, or consult one of our Admissions Officers.</li>
	    <li>No refund will be given for occasional absences from scheduled classes.
	    </li>
	    <li>  Course Credit is not given until all financial obligations to Academy of Learning College have been met.
	    </li>
	    <li>  All courses are held subject to sufficient enrolment, and may be postponed at the discretion of the school, and any fees paid will be credited to that future course or refunded according to the <b>Private Career Colleges Act</b>. 
	    </li>
	    <li> If an applicant is unable to commence a program on the date arranged, the applicant must notify the Admissions Office as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future program or refunded according to the <b>Private Career Colleges Act</b>.
	    </li>
	    <li>The duration of the program as shown on the program outline indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total program fee is still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the Admissions Office.
	    </li>
	    <li> Rather than conventional classroom instruction a student works as an individual, using a computer (where applicable) and workbooks combined with audio instruction in a step-by-step process.  A trained facilitator is always present to give individualized help as needed by each student.
	    </li>
	    <li> A student enrolled in on-line courses works as an individual, using a computer and workbooks and instruction and guidance from the facilitator or the on-line instructor.  
	    </li>
	    <li>The student may choose the hours of attendance which suit his/her circumstances, and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose. However, the student is obligated to complete the program within the time frame determined by the given end-date and the college’s guidelines for completing individual courses, the school must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.
	    </li>
	    <li> It is to the student’s advantage to arrive at least 5 minutes before the start of each class.
	    </li>
	    <li> Academy of Learning College is not responsible for loss of personal property or for personal injury from whatever cause.  
	    </li>
	    <li>The applicable Terms and Conditions above shall apply to all programs of Academy of Learning College.
	    </li>
	    <li> Students and Academy of Learning College are required to follow the provisions of the current edition of the “Student Handbook”. </li></ol>';
}elseif($program == 'Medical Office Assistant (Instructor-Led, Capstone)'){
	$dynamicNum = '8';
	$hstProfessional = '<td>Uniform/Professional Exam Fees</td>
	            <td> $'.$uniforms_fees.'</td>';
	            $examFees = '<td>&nbsp;</td>
	            <td> $0.00    </td>';
			  
if($location_Practicum == 'N/A'){
	$pr_Div = '<img width="10" src="../aol-pdf/images/box.jpg">';
}else{
	$pr_Div = '<img width="10" src="../aol-pdf/images/check.jpg">';
}
$pageProgramDiv = '<p><b>Admission Requirements</b></p>
<p style="margin-left:20px;">
'.$ossdNoDiv.' Have an Ontario Secondary School Diploma or equivalent; or<br>
'.$ossdYesDiv.' Be at least 18 years of age (or age specified in program approval) and pass a Superintendent approved qualifying test
</p>
<p><b><img width="10" src="../aol-pdf/images/check.jpg"> International Students (in addition to the requirements above):</b></p>
<p style="margin-left:20px;"><img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg"> Proof of Health Insurance Coverage for entire study period; and<br>
<img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg"> Appropriate student authorization or a Study Permit from Citizenship and Immigration Canada 
</p>
<p><b> Practicum Requirements</b></p>
<p style="margin-left:20px;">
'.$pr_Div.' &nbsp;    Minimum pass mark for each subject (75% on Healthcare courses and 60% on ILS courses, and 75% as the overall average program grade); and
<br>'.$pr_Div.' &nbsp;   Keyboarding 40 wpm; and
<br>'.$pr_Div.' &nbsp;  Standard First Aid/CPR – Level C; and
<br>'.$pr_Div.' &nbsp;  Clear Criminal Record Check
<br>'.$pr_Div.' &nbsp; Vaccinations (like hepatitis) or medical requirements (like TB Test) if it’s required by Host or Health Regulations; and
<br>'.$pr_Div.' &nbsp;  Non-disclosure or confidentiality agreement may be required
</p>
<table width="100%" class="sign_table">
 <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:180px;">'.$fullname.'&nbsp;</td>
 <td width="246"> acknowledge that it is my responsibility to have the practicum requirements,  as</td> 
 </tr>
 <tr><td colspan="3"> identified above, in place before I can begin my practicum to complete the Medical Office Assistant program and receive credentials:</td></tr>
 </table> ';$acknowledgeDiv = '
 <table width="100%" class="sign_table">
  <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:180px;">'.$fullname.'&nbsp;</td>
 <td width="246">  acknowledge that I have received a copy of:</td>

 </tr>
 </table>  
 <ul class="list-check" style="margin-top:0px;"><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Statement of Students’ Rights and Responsibilities Issued by the Superintendent of Private Career Colleges
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Fee Refund Policy 
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Consent to Use of Personal Information
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Payment Schedule  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Student Handbook  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Student Complaint Procedure
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Policy Relating to the Expulsion of Students
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Policy on Sexual Violence and Harassment
 </li></ul>';
 $privacyPolicy = '';
 $declarationParalegal = '';
$practicumRequirement = '';
   $medicalDisclaimer = '';
   $noticeCollection = '
   ';
 $termCondition = '
 <ol start="1" class="term-ul"><li>  All program fees are due and payable on commencement of the program unless specific arrangements have been made with the Admissions Office.</li>
 <li> Financial assistance may be available to those who qualify.  Check with the Admissions Office for details.</li>
 <li>  To register for and to reserve a seat in any diploma program, all applicants must include the minimum required payment, as per the PCC Act, 2005 for the program which will be applied to the program fee, the balance of which is to be paid as per the student payment schedule.
 </li>
 <li>  Program fees are tax deductible and a tax certificate will be issued in accordance with the guidelines of the federal government.  </li>
 <li> Certain courses can only be enrolled in, once prerequisite courses or equivalents have been taken.  Refer to the course outline of each program for prerequisites, or consult one of our Admissions Officers.</li>
 <li> No refund will be given for occasional absences from scheduled classes.</li>
 <li> Course Credit is not given until all financial obligations to Academy of Learning College have been met.</li>
 <li>  All courses are held subject to sufficient enrolment, and may be postponed at the discretion of the school, and any fees paid will be credited to that future course or refunded according to the <b>Private Career Colleges Act</b>. </li>
 <li>  If an applicant is unable to commence a program on the date arranged, the applicant must notify the Admissions Office as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future program or refunded according to the <b>Private Career Colleges Act</b>.</li>
 <li>The duration of the program as shown on the program outline indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total program fee is still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the Admissions Office.</li>
 <li> Rather than conventional classroom instruction a student works as an individual, using a computer (where applicable) and workbooks combined with audio instruction in a step-by-step process.  A trained facilitator is always present to give individualized help as needed by each student.</li>
 <li> A student enrolled in on-line courses works as an individual, using a computer and workbooks and instruction and guidance from the facilitator or the on-line instructor.  </li>
 <li> The student may choose the hours of attendance which suit his/her circumstances, and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose. However, the student is obligated to complete the program within the time frame determined by the given end-date and the college’s guidelines for completing individual courses, the school must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.</li>
 <li> It is to the student’s advantage to arrive at least 5 minutes before the start of each class.
 </li>
 <li> Academy of Learning College is not responsible for loss of personal property or for personal injury from whatever cause.  </li>
 <li> The applicable Terms and Conditions above shall apply to all programs of Academy of Learning College.
 </li>
 <li> Students and Academy of Learning College are required to follow the provisions of the current edition of the “Student Handbook”. 
 </li></ol>
 ';
}elseif($program == 'Logistics and Supply Chain Operations'){
	$dynamicNum = '9';$hstProfessional = '<td>Uniform/Professional exam fees </td>
            <td> $'.$uniforms_fees.'</td>';
            $examFees = '<td>&nbsp;</td>
            <td> $0.00 </td>';
			  
if($location_Practicum == 'N/A'){
	$pr_Div = '<img width="10" src="../aol-pdf/images/box.jpg">';
}else{
	$pr_Div = '<img width="10" src="../aol-pdf/images/check.jpg">';
}
$pageProgramDiv = '
<p style="margin-top:10px;"><b>Admission Requirements</b></p>
<p style="margin-left:20px;">
'.$ossdNoDiv.' Have an Ontario Secondary School Diploma or equivalent; or<br>
'.$ossdYesDiv.' Be at least 18 years of age (or age specified in program approval) and pass a Superintendent approved qualifying test.
</p>
<p style="margin-top:10px;"><b>International Students (in addition to the requirements above):</b></p>
<p style="margin-left:20px;"><img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg"> Proof of Health Insurance Coverage for entire study period; and<br>
<img width="10" src="../aol-pdf/images/check.jpg"> Appropriate student authorization or a Study Permit from Citizenship and Immigration Canada
</p>
<p style="margin-top:10px;"><b>Practicum Requirements </b></p>
<p style="margin-left:20px;">'.$pr_Div.' Practicum Requirements are requirements or qualifications that students must meet before they begin a practicum: 
<br>'.$pr_Div.' All program modules completed plus minimum overall pass mark of 75% (60% on ILS courses and 70% in instructor led courses)  &nbsp; &nbsp; for each subject
<br>'.$showAcOnly.'  Program fees 100% paid
</p>';
$acknowledgeDiv = '
<table width="100%" class="sign_table">
 <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$fullname.'</td>
 <td>  acknowledge that I have received a copy of:</td> 
 </tr>
 </table> <ul class="list-check" style="margin-top:0px;">
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Statement of Students’ Rights and Responsibilities Issued by the Superintendent of Private Career Colleges</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Fee Refund Policy </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Consent to Use of Personal Information</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Payment Schedule </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Student Handbook</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Student Complaint Procedure</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Policy Relating to the Expulsion of Students</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Policy on Sexual Violence and Harassment
 </li></ul>';
 $privacyPolicy = '  <main class="page"> 
 <br>             
 <p><b>PRIVACY POLICY STATEMENT</b><br><Br>Academy of Learning Career College is committed to, and accountable for, the protection and proper use of your personal information.  Our commitment extends to meeting and/or exceeding all legislated requirements.
 Personal Information is identifiable information such as: name, address, e-mail address, social insurance identification,        birth date and gender.  Personal information is collected by us when you provide it during the enrollment process, or requests for information regarding training.  Business contact information such as the name, title, business address, business e-mail address or the telephone number of a business or professional persona or an employee of an organization is not considered personal information.
 <br><br>
 ‘Non-personal information’ is information of an anonymous nature, such as aggregate information, including demographic statistics.
 </p>
 <br>
 <p><b><u>Use of Personal Information</u>
 </b><br>Personal Information may be used by us for the following purposes:</p>
 <ul><li>  To manage and administer the delivery of training and relevant services to Academy of Learning Career College students</li>
 <li> To maintain the accuracy of our records in accordance with legal, regulatory and contractual obligations</li>
 <li> To allow authorized personnel access to student files to ensure accuracy and regulatory compliance with same</li>
 <li> To occasionally contact consumers about training and relevant services that are available from Academy of Learning Career College</li>
 <li> To perform statistical analysis of the collective characteristics and behaviours of Academy of Learning Career College students in or der to monitor and improve our operations and maintain the quality of our products and services
 </li></ul>
 <p><u><b>Disclosure of Personal Information</b></u>
 <br>We will disclose personal information to 3<sup>rd </sup>Parties</p>
 <ul><li>  Where you have given us your signed consent to disclose for a designated purpose</li>
 <li> Who are acting on our behalf as agents, suppliers or service providers, solely to enable us to more efficiently provide you with training and other services</li>
 <li> As required by law, including by order of any court, institution or body with authority to compel the production of information
 </li></ul>
<p><b><u>Access to Personal Information</u></b><br>
For access to your personal information, please contact the Campus Director.  A request should be in writing and should include sufficient identifying information so that we can expeditiously locate your information.
</p><br>
<p><b><u>Questions, Comments</u></b><br>If you have questions or comments about this Privacy Policy or any other Academy of Learning Career college privacy practice that were not answered here, please contact our designated Privacy Officer at 1855-996-9977.
</p><br>
<p><b>STATEMENT OF RELEASE OF INFORMATION</b><br><br>
 I hereby consent and give Academy of Learning Career College permission to release/disclose my school information to any agent of the
 college, their respective employees, officers and agents, my funding agency and AOLCC’s Franchise Support Centre staff, as authorized,
any or all of the information contained in my college records including personal, financial (student account information), academic,
attendance and any other information entered and maintained in my files (electronic and hard copy formats). I understand that all
information will be kept confidential and utilized to provide information as it relates to the program of studies, labour market re-entry and to
maintain the accuracy of my records in accordance with legal, regulatory and contractual requirements. This information will not be used
for any other purpose nor will it be released to any other parties.
</p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:200px; height:30px;">&nbsp;'.$fullname.'</td>
  <td align="center" width="100">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr> <td align="center">Student Name (Please Print)</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
</tr></table> 
<table width="100%" class="sign_table">
<tr> 
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:180px; height:35px; ">&nbsp;<img src="'.$getSignature.'" width="160" height="30"></td>
    <td width="200">&nbsp;</td>
    <td width="30" style="vertical-align:bottom">Date</td>
      <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
        </tr>
        <tr> 
<td align="center">Signature of Student</td>
    <td>&nbsp;</td>
    <td style="vertical-align:bottom"></td>
    <td>&nbsp;</td>
</tr>
</table>            
        </main>';
        $declarationParalegal = '';
        $practicumRequirement = '';
   $medicalDisclaimer = '';
   $noticeCollection = '';
$termCondition = '
<ol start="1" class="term-ul"><li>   All program fees are due and payable on commencement of the program unless specific arrangements have been made with the Admissions Office.</li>
<li>  Financial assistance may be available to those who qualify.  Check with the Admissions Office for details.</li>
<li>  To register for and to reserve a seat in any diploma program, all applicants must include the minimum required payment, as per the PCC Act, 2005 for the program which will be applied to the program fee, the balance of which is to be paid as per the student payment schedule.</li>
<li>  Program fees are tax deductible and a tax certificate will be issued in accordance with the guidelines of the federal government.  </li>
<li> Certain courses can only be enrolled in, once prerequisite courses or equivalents have been taken.  Refer to the course outline of each program for prerequisites, or consult one of our Admissions Officers.</li>
<li>  No refund will be given for occasional absences from scheduled classes.</li>
<li>  Course Credit is not given until all financial obligations to Academy of Learning College have been met.</li>
<li>  All courses are held subject to sufficient enrolment, and may be postponed at the discretion of the school, and any fees paid will be credited to that future course or refunded according to the <b>Private Career Colleges Act</b>. </li>
<li> If an applicant is unable to commence a program on the date arranged, the applicant must notify the Admissions Office as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future program or refunded according to the <b>Private Career Colleges Act</b>.</li>
<li> The duration of the program as shown on the program outline indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total program fee is still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the Admissions Office.</li>
<li> Rather than conventional classroom instruction a student works as an individual, using a computer (where applicable) and workbooks combined with audio instruction in a step-by-step process.  A trained facilitator is always present to give individualized help as needed by each student.
</li>
<li> A student enrolled in on-line courses works as an individual, using a computer and workbooks and instruction and guidance from the facilitator or the on-line instructor.  </li>
<li> The student may choose the hours of attendance which suit his/her circumstances, and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose. However, the student is obligated to complete the program within the time frame determined by the given end-date and the college’s guidelines for completing individual courses, the school must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.</li>
<li> It is to the student’s advantage to arrive at least 5 minutes before the start of each class.</li>
<li> Academy of Learning College is not responsible for loss of personal property or for personal injury from whatever cause.  </li>
<li> The applicable Terms and Conditions above shall apply to all programs of Academy of Learning College.</li>
<li> Students and Academy of Learning College are required to follow the provisions of the current edition of the “Student Handbook”. 
</li></ol>
';
}elseif($program == 'Early Childcare Assistant'){
	$dynamicNum = '10';$hstProfessional = '<td>Uniform/Professional exam fees  </td>
            <td> $'.$uniforms_fees.'</td>';
            $examFees = '<td>&nbsp;</td>
            <td>&nbsp;</td>';
            $pageProgramDiv = '<p><b>Admission Requirements</b></p>
            <p style="margin-top:10px;"><b><img width="10" src="../aol-pdf/images/box.jpg"> Domestic Students</b></p>
            <p style="margin-left:20px;">
            '.$ossdNoDiv.' Have an Ontario Secondary School Diploma or equivalent (copy of Transcript or Diploma included); OR<br>
            '.$ossdYesDiv.' Be at least 18 years of age and pass a Superintendent approved qualifying test.
            </p>
            <p style="margin-top:10px;"><b><img width="10" src="../aol-pdf/images/check.jpg"> Domestic and International Students</b></p>
            <p style="margin-left:20px;"><img width="10" src="../aol-pdf/images/check.jpg"> Passing score of 18 and higher on NACC Technical Literacy exam AND
            <br><img width="10" src="../aol-pdf/images/check.jpg"> Medical Certificate indicating that the student is fit to complete all components of the program and has up-to-date immunization <br>&nbsp; &nbsp;  status (Immunization for Hepatitis B is required for non-immune students) <b><u>within 30 business days of starting school;</u></b> AND
            <br><img width="10" src="../aol-pdf/images/check.jpg"> Signed Vulnerable Sector Disclaimer; AND Clear Criminal Record Check with Vulnerable Sector Screening <b><u>with in 30 business </u>&nbsp; <br> &nbsp; &nbsp; <u>days  of starting School</u></b>
            <br><img width="10" src="../aol-pdf/images/check.jpg"> Standard First Aid and Basic Rescuer CPR completed prior to practicum placement
            <br><img width="10" src="../aol-pdf/images/check.jpg"> Interview with ECA Program Coordinator 
            <br><img width="10" src="../aol-pdf/images/check.jpg"> <b>Two </b>different references related to employment or volunteer work completed in the early childcare field.
            </p>';
            $acknowledgeDiv = '<table width="100%" class="sign_table">
             <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$fullname.'</td>
 <td>  acknowledge that I have received a copy of and agree to abide by:</td> 
 </tr>
 </table>  
 <ul class="list-check" style="margin-top:0px;">
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Academy of Learning Career College’s Student Handbook</li>  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Academy of Learning Career College’s Privacy Policy</li>  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Payment Schedule </li>  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Consent to Use of Personal Information</li>  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Statement of Students’ Rights and Responsibilities Issued by the Superintendent of Private Career Colleges</li>  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Fee Refund Policy </li>  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Student Complaint Procedure</li>  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Policy Relating to the Expulsion of Students</li>  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Sexual Violence Policy
 </li></ul>';
 $privacyPolicy = '<main class="page"> 
 <br>
 <br>
<p><b>PRIVACY POLICY STATEMENT</b><br><Br>
Academy of Learning Career College is committed to, and accountable for, the protection and proper use of your personal information.  Our commitment extends to meeting and/or exceeding all legislated requirements.
Personal Information is identifiable information such as: name, address, e-mail address, social insurance identification,        birth date and gender.  Personal information is collected by us when you provide it during the enrollment process, or requests for information regarding training.  Business contact information such as the name, title, business address, business e-mail address or the telephone number of a business or professional persona or an employee of an organization is not considered personal information.<br><br>
‘Non-personal information’ is information of an anonymous nature, such as aggregate information, including demographic statistics.
</p>
<br>
<p><b><u>Use of Personal Information</u>
</b><br>Personal Information may be used by us for the following purposes:</p>
<ul><li> To manage and administer the delivery of training and relevant services to Academy of Learning Career College students</li>
<li>To maintain the accuracy of our records in accordance with legal, regulatory and contractual obligations</li>
<li>To allow authorized personnel access to student files to ensure accuracy and regulatory compliance with same</li>
<li>To occasionally contact consumers about training and relevant services that are available from Academy of Learning Career College</li>
<li>To perform statistical analysis of the collective characteristics and behaviours of Academy of Learning Career College students in or
der to monitor and improve our operations and maintain the quality of our products and services</li></ul>
<p><u><b>Disclosure of Personal Information</b></u>
<br>We will disclose personal information to 3rd Parties</p><ul><li>  Where you have given us your signed consent to disclose for a designated purpose</li>
<li> Who are acting on our behalf as agents, suppliers or service providers, solely to enable us to more efficiently provide you with training and other services</li>
<li> As required by law, including by order of any court, institution or body with authority to compel the production of information
</li></ul>
<p><b><u>Access to Personal Information</u></b><br>
For access to your personal information, please contact the Campus Director.  A request should be in writing and should include sufficient identifying information so that we can expeditiously locate your information
</p><br>
<p><b><u>Questions, Comments</u></b><br>
If you have questions or comments about this Privacy Policy or any other Academy of Learning Career college privacy practice that were not answered here, please contact our designated Privacy Officer at 1855-996-9977.
</p><br>
<p><b>STATEMENT OF RELEASE OF INFORMATION</b><br><br>
 I hereby consent and give Academy of Learning Career College permission to release/disclose my school information to any agent of the college, their respective employees, officers and agents, my funding agency and AOLCC’s Franchise Support Centre staff, as authorized, any or all of the information contained in my college records including personal, financial (student account information), academic, attendance and any other information entered and maintained in my files (electronic and hard copy formats).  I understand that all information will be kept confidential and utilized to provide information as it relates to the program of studies, labour market re-entry and to maintain the accuracy of my records in accordance with legal, regulatory and contractual requirements.  This information will not be used for any other purpose nor will it be released to any other parties.
 </p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:200px; height:30px;">&nbsp;'.$fullname.'</td>
  <td align="center" width="100">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr> <td align="center">Student Name (Please Print)</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
</tr></table> 
<table width="100%" class="sign_table">
<tr> 
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:280px; height:35px; ">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
    <td width="100">&nbsp;</td>
    <td width="30" style="vertical-align:bottom">Date</td>
    <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
</tr><tr> 
<td align="center">Signature of Student</td>
    <td width="100">&nbsp;</td>
    <td width="30" style="vertical-align:bottom"></td>
    <td >&nbsp;</td>
</tr>
</table>
        </main>
        ';
$declarationParalegal = '';
$practicumRequirement = ' <main class="page"> 
<br>                    
<p class="text-center"><b>PRACTICUM REQUIREMENTS – EARLY CHILDCARE ASSISTNAT PROGRAM </b><p><br><p>I <span style="border-bottom:1px solid #333; width:100px;"> '.$fullname.'&nbsp;</span> acknowledge that it is my responsibility to have the practicum requirements, as listed below, in place before I can begin my practicum to complete the Early Childcare Assistant program and receive credentials
</p>
<ul><li>   Minimum mark of 70% in each ECA Module with no evaluation method below 70%; and </li>
<li> Minimum mark of 70% with no critical deficiencies in each of the skills Performance Demonstrations; and</li>
<li> Minimum mark of 60% in each ILS course; </li>
<li> Satisfactory attendance record; and </li>
<li> Current Standard First Aid and Basic Rescuer (Level C) CPR Certification; and </li>
<li> Resume and Placement Preference Sheet at least 30 days prior to placement; and </li>
<li> Interview by Host may be required prior to placement.</li></ul>
<p>  I further understand that I will NOT engage in a practicum if any of the program practicum requirements, as listed above, are not met prior to placement.</p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>  
<td>&nbsp;</td>
<td width="20" style="vertical-align:bottom">Date</td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Signature of Student</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
<td align="center" >(mm/dd/yyyy)</td>
</tr></table> <br>
<p class="text-center"><b>Vulnerable Sector Disclaimer</b></p><br>
<p>As this program will involve direct contact with vulnerable individuals, you must complete a clean Vulnerable Sector Screening (“VSS”) prior to commencing any placement or practicum. It is strongly advised that you complete your VSS prior to commencing your vocational training to ensure that you can complete this program and are eligible for a placement or practicum and, subsequently, graduation. <br><br>
As a VSS can take 10 to 12 weeks to complete, if you choose not to complete a VSS <b>prior</b> to commencing this program, please plan your time accordingly to ensure that you have obtained documentation of a clean VSS prior to applying for a placement or practicum. If you ignore this caution, you risk being <b>ineligible for a placement or practicum, ineligible to graduateand potentially only eligible for a partial refund or no refund of tuition for this program if you fail to graduate.  </b><br><br>
A VSS involves a search of the Vulnerable Sector Database, maintained by the Ontario Provincial Police, for any information about you in police files, including criminal convictions, outstanding charges, and information about whether you are suspected of committing a criminal offence or involved in a serious criminal investigation. Police databases will also document any contact that you may have had with police services under the Mental Health Act, 1990. <br><br>
<b>
You must also ensure that you do not engage in any activities at anytime during the program, including while undertaking a placement or practicum that would render a clean VSS previously submitted by you void.  Failure to maintain a clean VSS will also render you unable to undertake or continue the placement or practicum, ineligible for graduation and only eligible for a partial refund or no refund of tuition, depending on when you withdraw or are expelled from the program.
</b>
</p>
<table width="100%" class="sign_table">
 <tr>
 <td width="12"> I   </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:280px;">&nbsp;</td>
 <td width="146">  acknowledge that I have</td>
  </tr>
  <tr><td colspan="3">read the above disclosure and understand that I need to obtain a clean VSS  <b> prior</b> to applying for a placement or practicum and that I must, while enrolled in the program, maintain a clean VSS in order to complete the placement or practicum and to graduate. I also understand that if I do not obtain or maintain a clean VSS, I risk:  <b>1. being ineligible for placement or continued placement; 2. ineligible to graduate; 3. eligible for a partial refund or no refund of tuition, depending on when I withdraw or am expelled from this program.  </b><br><br>Further information regarding the Police Reference Check Program and the VSS process can be viewed at  <a href="http://www.torontopolice.on.ca/prcp/" target="blank"> http://www.torontopolice.on.ca/prcp/.  </a>  </td></tr>
  </table>
  <table width="100%" class="sign_table">
<tr> 
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
<td>&nbsp;</td>
<td width="20" style="vertical-align:bottom">Date</td>
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr> <tr> 
<td align="center">Signature of Student</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="center">(mm/dd/yyyy)</td>
</tr>
</table> 
        </main>
        ';
   $medicalDisclaimer = '';
   $noticeCollection = '';
$termCondition = '<ol start="1" class="term-ul"><li>  All enrolment contract fees are due and payable on commencement of the program unless specific arrangements have been made with the College.</li>
<li>  To register for and to reserve a seat in any diploma or certificate program, all applicants must include the minimum required payment, as per the <b> <b>Private Career Colleges Act</b>, 2005,</b> which will be applied to the enrolment contract fees, and the balance of which is to be paid as per the student payment schedule.</li>
<li>  Enrolment contract fees are tax deductible and a tax certificate will be issued in accordance with the guidelines of the federal government.  </li>
<li>  Certain courses can only be enrolled in, once prerequisite courses or equivalents are met.  Refer to the course outline of each program for prerequisites, or consult one of the Admissions Representatives.</li>
<li>  No refund will be given for occasional absences from scheduled classes.</li>
<li>  The credential will not be issued until all financial obligations to Academy of Learning Career College have been met.
</li>
<li>  All programs are held subject to sufficient enrolment, and may be postponed at the discretion of the College, and any fees paid will be credited to that future program or refunded according to the  <b><b>Private Career Colleges Act</b>, 2005.</b></li>
<li>  If an applicantis unable to commence a programon the date arranged, the applicant must notify the College as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future programor refunded according to the <b><b>Private Career Colleges Act</b>, 2005.</b></li>
<li>  The duration of the program as shown on the enrolment contract indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total enrolment contract feesare still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the College. </li>
<li> Rather than conventional classroom instruction a student works as an individual, using the accessible materials/equipment.  A trained facilitator is always present to give individualized support as needed by each student.</li>
<li> A student enrolled in virtual learning works as an individual, using accessible materials/equipment and support from the facilitator and/or the virtual learning instructor.  </li>
<li> The student may choose the hours of attendance, either the morning or afternoon session, and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose (not applicable for the courses delivered by instructors). However, the student is obligated to complete the program within the time frame determined by the given end-date and the college’s guidelines for completing individual courses. The College must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.</li>
<li> It is to the student’s advantage to arrive at least 5 minutes before the scheduled time on the enrolment contract</li>
<li> Academy of Learning Career College is not responsible for loss of personal property or for personal injury from whatever cause.  
</li>
<li> Students of the Academy of Learning Career College are required to follow the provisions of the current edition of the Student Handbook.
</li></ol>';
}elseif($program == 'Medical Office Assistant w/ HUC Specialty (Instructor, Capstone)'){
	$dynamicNum = '9';
	$hstProfessional = '<td>Uniform/Professional exam fees </td>
            <td> $'.$uniforms_fees.'</td>';
            $examFees = '<td>&nbsp;</td>
            <td> $0.00 </td>';
            if($location_Practicum == 'N/A'){
	$pr_Div = '<img width="10" src="../aol-pdf/images/box.jpg">';
}else{
	$pr_Div = '<img width="10" src="../aol-pdf/images/check.jpg">';
}
$pageProgramDiv = '
<p><b>Admission Requirements</b></p>
<p style="margin-left:20px;">
'.$ossdNoDiv.' Have an Ontario Secondary School Diploma or equivalent; or<br>
'.$ossdYesDiv.' Be at least 18 years of age (or age specified in program approval) and pass a Superintendent approved qualifying test.
</p>
<p style="margin-top:10px;"><b>Practicum Requirements </b></p>
<p style="margin-left:20px; margin-bottom:10px;">'.$pr_Div.' Minimum pass mark for each subject (75% on Healthcare courses and 60% on ILS courses, and 75% as the overall average program grade); and
<br>'.$pr_Div.' Keyboarding 40 wpm; and
<br>'.$pr_Div.' Standard First Aid/CPR – Level C; and<br>'.$pr_Div.' Clear Criminal Record Check
<br>'.$pr_Div.' Vaccinations (like hepatitis) or medical requirements (like TB Test) if it’s required by Host or Health Regulations; and
<br>'.$pr_Div.' Non-disclosure or confidentiality agreement may be required
</p><p>I, <u>'.$fullname.'</u> acknowledge that it is my responsibility to have the practicum requirements,  as identified above, in place before I can begin my practicum to complete the Medical Office Assistant program and receive credentials:</p>
';
$acknowledgeDiv = '
<table width="100%" class="sign_table">
 <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$fullname.'</td>
 <td>  acknowledge that I have received a copy of:</td> 
 </tr>
 </table> <ul class="list-check" style="margin-top:0px;">
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Statement of Students’ Rights and Responsibilities Issued by the Superintendent of Private Career Colleges</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Fee Refund Policy </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Consent to Use of Personal Information</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Payment Schedule </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Student Handbook</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Student Complaint Procedure</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Policy Relating to the Expulsion of Students</li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The College’s Policy on Sexual Violence and Harassment
 </li></ul>';
 $privacyPolicy = ' <main class="page"> 
 <br>                   
 <p><b>PRIVACY POLICY STATEMENT</b><br><Br>Academy of Learning Career College is committed to, and accountable for, the protection and proper use of your personal information.  Our commitment extends to meeting and/or exceeding all legislated requirements.
 Personal Information is identifiable information such as: name, address, e-mail address, social insurance identification,        birth date and gender.  Personal information is collected by us when you provide it during the enrollment process, or requests for information regarding training.  Business contact information such as the name, title, business address, business e-mail address or the telephone number of a business or professional persona or an employee of an organization is not considered personal information.<br><br>
 ‘Non-personal information’ is information of an anonymous nature, such as aggregate information, including demographic statistics.
 </p>
 <br>
 <p><b><u>Use of Personal Information</u>
 </b><br>Personal Information may be used by us for the following purposes:</p>
 <ul><li>  To manage and administer the delivery of training and relevant services to Academy of Learning Career College students</li>
 <li> To maintain the accuracy of our records in accordance with legal, regulatory and contractual obligations</li>
 <li> To allow authorized personnel access to student files to ensure accuracy and regulatory compliance with same</li>
 <li> To occasionally contact consumers about training and relevant services that are available from Academy of Learning Career College</li>
 <li> To perform statistical analysis of the collective characteristics and behaviours of Academy of Learning Career College students in or der to monitor and improve our operations and maintain the quality of our products and services
 </li></ul>
 <p><u><b>Disclosure of Personal Information</b></u>
 <br>We will disclose personal information to 3<sup>rd </sup>Parties</p>
 <ul><li>  Where you have given us your signed consent to disclose for a designated purpose</li>
 <li> Who are acting on our behalf as agents, suppliers or service providers, solely to enable us to more efficiently provide you with training and other services</li>
 <li> As required by law, including by order of any court, institution or body with authority to compel the production of information
 </li></ul>
<p><b><u>Access to Personal Information</u></b><br>
For access to your personal information, please contact the Campus Director.  A request should be in writing and should include sufficient identifying information so that we can expeditiously locate your information.
</p><br>
<p><b><u>Questions, Comments</u></b><br>If you have questions or comments about this Privacy Policy or any other Academy of Learning Career college privacy practice that were not answered here, please contact our designated Privacy Officer at 1855-996-9977.
</p><br>
<p><b>STATEMENT OF RELEASE OF INFORMATION</b><br><br>
 I hereby consent and give Academy of Learning Career College permission to release/disclose my school information to any agent of the college, their respective employees, officers and agents, my funding agency and AOLCC’s Franchise Support Centre staff, as authorized, any or all of the information contained in my college records including personal, financial (student account information), academic, attendance and any other information entered and maintained in my files (electronic and hard copy formats).  I understand that all information will be kept confidential and utilized to provide information as it relates to the program of studies, labour market re-entry and to maintain the accuracy of my records in accordance with legal, regulatory and contractual requirements.  This information will not be used for any other purpose nor will it be released to any other parties.
 </p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:200px; height:30px;">&nbsp;'.$fullname.'</td>
  <td align="center" width="100">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr> <td align="center">Student Name (Please Print)</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
</tr></table> 
<table width="100%" class="sign_table">
<tr> 
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:180px; height:35px; ">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
    <td width="200">&nbsp;</td>
    <td width="30" style="vertical-align:bottom">Date</td>
      <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
        </tr>
        <tr> 
<td align="center">Signature of Student</td>
    <td>&nbsp;</td>
    <td style="vertical-align:bottom"></td>
    <td>&nbsp;</td>
</tr>
</table>           
        </main>';
        $practicumRequirement = '';
   $medicalDisclaimer = '';
   $noticeCollection = '';
$termCondition = '
<ol start="1" class="term-ul"><li>  All program fees are due and payable on commencement of the program unless specific arrangements have been made with the Admissions Office.</li>
<li>  Financial assistance may be available to those who qualify.  Check with the Admissions Office for details.
</li>
<li>  To register for and to reserve a seat in any diploma program, all applicants must include the minimum required payment, as per the PCC Act, 2005 for the program which will be applied to the program fee, the balance of which is to be paid as per the student payment schedule.
</li>
<li>  Program fees are tax deductible and a tax certificate will be issued in accordance with the guidelines of the federal government.  
</li>
<li>  Certain courses can only be enrolled in, once prerequisite courses or equivalents have been taken.  Refer to the course outline of each program for prerequisites, or consult one of our Admissions Officers.</li>
<li>  No refund will be given for occasional absences from scheduled classes.</li>
<li>  Course Credit is not given until all financial obligations to Academy of Learning College have been met.</li>
<li>  All courses are held subject to sufficient enrolment, and may be postponed at the discretion of the school, and any fees paid will be credited to that future course or refunded according to the <b>Private Career Colleges Act</b>. </li>
<li>  If an applicant is unable to commence a program on the date arranged, the applicant must notify the Admissions Office as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future program or refunded according to the <b>Private Career Colleges Act</b>.</li>
<li> The duration of the program as shown on the program outline indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total program fee is still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the Admissions Office.</li>
<li> Rather than conventional classroom instruction a student works as an individual, using a computer (where applicable) and workbooks combined with audio instruction in a step-by-step process.  A trained facilitator is always present to give individualized help as needed by each student.</li>
<li> A student enrolled in on-line courses works as an individual, using a computer and workbooks and instruction and guidance from the facilitator or the on-line instructor.  </li>
<li> The student may choose the hours of attendance which suit his/her circumstances, and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose. However, the student is obligated to complete the program within the time frame determined by the given end-date and the college’s guidelines for completing individual courses, the school must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.</li>
<li> It is to the student’s advantage to arrive at least 5 minutes before the start of each class.</li>
<li> Academy of Learning College is not responsible for loss of personal property or for personal injury from whatever cause.  </li>
<li> The applicable Terms and Conditions above shall apply to all programs of Academy of Learning College.</li>
<li> Students and Academy of Learning College are required to follow the provisions of the current edition of the “Student Handbook”. 
</li></ol>';
}else{
	$dynamicNum = '9';  
	
if($location_Practicum == 'N/A'){
	$pr_Div = '<img width="10" src="../aol-pdf/images/box.jpg">';
}else{
	$pr_Div = '<img width="10" src="../aol-pdf/images/check.jpg">';
}
	
$hstProfessional = '<td>Uniform/Professional exam fees </td>
            <td> $'.$uniforms_fees.'</td>';
            $examFees = '<td>&nbsp;</td><td>&nbsp;</td>';
            $pageProgramDiv = '<p><b>Admission Requirements</b></p><p style="margin-left:20px;">
            '.$ossdNoDiv.' Have an Ontario Secondary School Diploma or equivalent; or<br>
            '.$ossdYesDiv.' Be at least 18 years of age (or age specified in program approval) and pass a Superintendent approved qualifying test
            </p><br>
            <p><b><img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg"> International Students (in addition to the requirements above):</b></p>
            <p style="margin-left:20px;"><img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg"> Proof of Health Insurance Coverage for entire study period; and<br>
            <img width="10" src="../aol-pdf/images/'.$intCheckDiv.'.jpg"> Appropriate student authorization or a Study Permit from Citizenship and Immigration Canada 
            </p><br>
            <p><b>'.$pr_Div.' Practicum Requirements</b></p>
            <p style="margin-left:20px;">'.$pr_Div.' Practicum Requirements are requirements or qualifications that students must meet before they begin a practicum: <br>
            '.$pr_Div.' All program modules completed plus minimum overall pass mark of 75% (60% on ILS courses and 70% in instructor led courses)      for each subject<br>
            '.$showAcOnly.' Program fees 100% paid
            </p>';$acknowledgeDiv = '<table width="100%" class="sign_table">
             <tr>
 <td width="3">I, </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:220px;">'.$fullname.'</td>
 <td>  acknowledge that I have received a copy of:</td>

 </tr>
 </table> 
 <ul class="list-check" style="margin-top:0px;"><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The Statement of Students’ Rights and Responsibilities Issued by the Superintendent of Private Career Colleges
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Fee Refund Policy 
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Consent to Use of Personal Information
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Payment Schedule  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The Student Handbook  
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Student Complaint Procedure
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Policy Relating to the Expulsion of Students
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp;  The College’s Policy on Sexual Violence and Harassment
 </li></ul>';
 $privacyPolicy = ' <main class="page"> 
 <br>
 <br>
<p><b>PRIVACY POLICY STATEMENT</b><br><Br>
Academy of Learning Career College is committed to, and accountable for, the protection and proper use of your personal information.  Our commitment extends to meeting and/or exceeding all legislated requirements.<br>
Personal Information is identifiable information such as: name, address, e-mail address, social insurance identification,        birth date and gender.  Personal information is collected by us when you provide it during the enrollment process, or requests for information regarding training.  Business contact information such as the name, title, business address, business e-mail address or the telephone number of a business or professional persona or an employee of an organization is not considered personal information.<br><br>
‘Non-personal information’ is information of an anonymous nature, such as aggregate information, including demographic statistics.</p>
<br>
<p><b><u>Use of Personal Information</u>
</b><br>Personal Information may be used by us for the following purposes:</p>
<ul><li> To manage and administer the delivery of training and relevant services to Academy of Learning Career College students</li> 
<li>To maintain the accuracy of our records in accordance with legal, regulatory and contractual obligations</li> 
<li>To allow authorized personnel access to student files to ensure accuracy and regulatory compliance with same</li> 
<li>To occasionally contact consumers about training and relevant services that are available from Academy of Learning Career College</li> 
<li>To perform statistical analysis of the collective characteristics and behaviours of Academy of Learning Career College students in or der to monitor and improve our operations and maintain the quality of our products and services</li></ul>
<p><u><b>Disclosure of Personal Information</b></u>
<br>We will disclose personal information to 3rd Parties</p><ul><li>  Where you have given us your signed consent to disclose for a designated purpose</li>
<li> Who are acting on our behalf as agents, suppliers or service providers, solely to enable us to more efficiently provide you with training and other services</li>
<li> As required by law, including by order of any court, institution or body with authority to compel the production of information
</li></ul>
<p><b><u>Access to Personal Information</u></b><br>
For access to your personal information, please contact the Campus Director.  A request should be in writing and should include sufficient identifying information so that we can expeditiously locate your information
</p><br>
<p><b><u>Questions, Comments</u></b><br>
If you have questions or comments about this Privacy Policy or any other Academy of Learning Career college privacy practice that were not answered here, please contact our designated Privacy Officer at 1855-996-9977.
</p><br>
<p><b>STATEMENT OF RELEASE OF INFORMATION</b><br><br>

I hereby consent and give Academy of Learning Career College permission to release/disclose my school information to any agent of the college, their respective employees, officers and agents, my funding agency and AOLCC’s Franchise Support Centre staff, as authorized, any or all of the information contained in my college records including personal, financial (student account information), academic, attendance and any other information entered and maintained in my files (electronic and hard copy formats).  I understand that all information will be kept confidential and utilized to provide information as it relates to the program of studies, labour market re-entry and to maintain the accuracy of my records in accordance with legal, regulatory and contractual requirements.  This information will not be used for any other purpose nor will it be released to any other parties.
</p>
  <table width="100%" class="sign_table">
  <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:200px; height:30px;">&nbsp;'.$fullname.'</td>
  <td align="center" width="150">&nbsp;</td>
   <td width="20" style="vertical-align:bottom"></td>
   <td>&nbsp;</td>
</tr>
<tr> <td align="center">Student Name (Please Print)</td>
<td  align="center" width="150">&nbsp;</td>
<td align="center" ></td>
<td align="center" ></td>

 </tr></table> 
 <table width="100%" class="sign_table">
<tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:180px; height:35px; ">&nbsp;<img src="'.$getSignature.'" width="100" height="30">
</td>
<td width="200">&nbsp;</td>
<td width="30" style="vertical-align:bottom">Date</td>
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:160px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> 
<td align="center">Signature of Student</td>
    <td>&nbsp;</td>
    <td style="vertical-align:bottom"></td>
    <td>&nbsp;</td>
</tr>
</table>
         </main>';
         $practicumRequirement = '';
    $medicalDisclaimer = '';
    $noticeCollection = '';
  $declarationParalegal = '';
  $termCondition = '<ol start="1" class="term-ul"><li> All program fees are due and payable on commencement of the program unless specific arrangements have been made with the Admissions Office.</li>
  <li> Financial assistance may be available to those who qualify.  Check with the Admissions Office for details.</li>
  <li> To register for and to reserve a seat in any diploma program, all applicants must include the minimum required payment, as per the PCC Act, 2005 for the program which will be applied to the program fee, the balance of which is to be paid as per the student payment schedule.</li>
  <li>  Program fees are tax deductible and a tax certificate will be issued in accordance with the guidelines of the federal government.  </li>
  <li>  Certain courses can only be enrolled in, once prerequisite courses or equivalents have been taken.  Refer to the course outline of each program for prerequisites, or consult one of our Admissions Officers.</li>
  <li>  No refund will be given for occasional absences from scheduled classes.</li>
  <li>  Course Credit is not given until all financial obligations to Academy of Learning College have been met.</li>
  <li>  All courses are held subject to sufficient enrolment, and may be postponed at the discretion of the school, and any fees paid will be credited to that future course or refunded according to the <b>Private Career Colleges Act</b>.</li>
  <li>  If an applicant is unable to commence a program on the date arranged, the applicant must notify the Admissions Office as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future program or refunded according to the <b>Private Career Colleges Act</b>.</li>
  <li> The duration of the program as shown on the program outline indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total program fee is still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the Admissions Office.</li>
  <li> Rather than conventional classroom instruction a student works as an individual, using a computer (where applicable) and workbooks combined with audio instruction in a step-by-step process.  A trained facilitator is always present to give individualized help as needed by each student.</li>
  <li> A student enrolled in on-line courses works as an individual, using a computer and workbooks and instruction and guidance from the facilitator or the on-line instructor.  </li>
  <li> The student may choose the hours of attendance which suit his/her circumstances, and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose. However, the student is obligated to complete the program within the time frame determined by the given end-date and the college’s guidelines for completing individual courses, the school must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.</li>
  <li> It is to the student’s advantage to arrive at least 5 minutes before the start of each class.</li>
  <li> Academy of Learning College is not responsible for loss of personal property or for personal injury from whatever cause.  </li>
  <li>. The applicable Terms and Conditions above shall apply to all programs of Academy of Learning College.</li>
  <li> Students and Academy of Learning College are required to follow the provisions of the current edition of the “Student Handbook”. 
  </li></ol>';
}
  if($campus == 'Toronto'){
	$campusAddress = '<b>1069195 Ontario Inc o/a ACADEMY OF LEARNING COLLEGE</b><br>
401 Bay Street, Suite 1000, Toronto, ON M5H 2Y4, Phone number: (416) 969-8845';
 $campusName = 'Academy of Learning College – Bay Street';
}
if($campus == 'Hamilton'){
	$campusAddress = '<b>RAELIN MANAGEMENT CONSULTANTS INC o/a ACADEMY OF LEARNING COLLEGE</b> <br>
401 Main Street East Hamilton, ON L8N 1J7, Phone number: (905) 777-8553';
 $campusName = 'Academy of Learning College – Hamilton';
}
if($campus == 'Brampton'){
	$campusAddress = '<b>Leanessa Inc. o/a ACADEMY OF LEARNING CAREER COLLEGE</b> <br>
8740 The Gore Road Brampton, ON L6P 0B1, Phone number: (905) 508-5791';
 $campusName = 'Academy of Learning College – Brampton';
}
if($campus == ''){
	$campusAddress = '&nbsp;Campus Address';
}
$output = "<style> 
  .header { position: fixed; top: -0px;width:100%;  padding:0px 0px 25px;height:80px; display: block;  }
 footer {position: fixed;bottom:0px; width:100%;text-align:left; padding:0px 0px 0px;height:90px; font-size:11px; border-top:1px solid #333;}
 footer p { text-align:center;}
 main { position:relative;width:100%; }
 .page {width:100%;   font-size:13px;  margin-top:60px; margin-bottom:0px; padding:0px 0px 0px; page-break-after: always; position:relative;line-height:14.4px; }
    .page:last-child {page-break-after:never;}
     @page { margin:10px 30px 25px; font-weight:599;width:100%;  color:#333; font-size:13.5px; }
     .float-left { float:left;}
    .float-right { float:right;}
    .heading-txt { width:100%;}
    .heading-txt p, .heading-txt h4 { width:100%; margin:5px 0px;}
    .table1 td { padding:0px 0px;vertical-align:top;}
    .table1 { margin-top:10px; margin-bottom:10px;}
    .pagenum:before { content: counter(page); }
    .pagenum { float:right;margin-bottom:20px;}
    .mt-5 { margin-top:50px;}
    .text-center { text-align:center;}
  .page-number:before {
              content: counter(page);
                        }
                        p { width:100%; margin:0px; }
                        h5 { font-size:14px; line-height:17px; }
                        h4 { font-size:20px; margin-bottom:0px; margin-top:0px;}
                        .table-bordered td { border:1px solid #333; padding:3px 10px;vertical-align:top;}
                        .m-0 { margin:0px;}
                        .table-bordered  { border-collapse:collapse; margin:0px;}
                        .table-bordered table td { border:0px; padding:0px;vertical-align:top;}
.border-bottom { border-bottom:1px solid #333; min-height:50px ;}
.border-bottom-dotted{ border-bottom:1px dotted #333; min-height:50px ;}
// .sign_table td {height:18px;}
.list-check  {  margin-left:10px; padding-left:0px; }
.list-check li { list-style:none;  line-height:20px;}
.list-check li img { margin-top:2px;}
.lower-roman {list-style-type: lower-roman; }
.lower-roman li,
.lower-roman li { margin:5px 0px;}
ol li { margin:5px 0px;}
ul ,
ol  { padding-left:25px;}
.term-ul li { margin-top:7px; margin-bottom:7px; font-size:14px;}
</style>";$output .= '
  <!-- Wrap the content of your PDF inside a main tag -->
  <div class="header"> 
          <table width="100%"><tr><td width="130" valign="center" style="vertical-align: middle;">  
          <img src="../aol-pdf/images/academy_of_learning_logo.jpg" width="170"  /></td><td width="330" align="center"><span style="font-size:13px; text-align:center !important; white-space:nowrap">'.$campusAddress.' &nbsp;</span>
          </td><td width="190" >&nbsp;</td></tr></table> 
        </div><footer>
        <table width="100%" ><tr><td>ON - 2022</td>
        <td align="right">Student’s Initials </td>
        <td align="left" width="50">
		<table class="table-bordered" width="50">
		<tr>
		<td>'.$initialsStudent.'</td>
		<td>'.$initialsAdmRep.'</td>
		</tr>
		</table> </td>
        </tr><tr><td></td><td></td><td>Page <span class="page-number"></span> of '.$dynamicNum.'</td>
        </tr></table>
        </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main class="page"> 
                   <table width="100%" style="margin-bottom:0px;margin-top:10px;"><tr><td width="130">&nbsp;</td><td width="330" ><h4 class="text-center">ENROLLMENT CONTRACT </h4></td><td width="280" >&nbsp;</td>
                   </tr></table>
                    <table width="100%" style="margin-bottom:0px;margin-top:-10px;"><tr><td width="160">&nbsp;</td><td width="210">&nbsp;</td><td width="200" ><table class="table-bordered"  ><tr><td width="40" align="right" style="border:0px;"><b>&nbsp;</b></td>
                    <td width="60" colspan="2">&nbsp;'.$student_id_2.''.$int_vid.'&nbsp;</td></tr>
                    <tr>
<td  width="40" colspan="2">Institution Code</td>
<td width="60">'.$InstitutionCode.'</td>
</tr>
</table>
</td>
</tr>
</table>
       <p style=" margin-top:5px;margin-bottom:10px;"><b>This Enrolment Contract is subject to the <i> <b>Private Career Colleges Act</b>, 2005 </i> and the regulations made under the Act </b><br>
       The undersigned person hereby enrols as a student of '.$campusName.' &nbsp;for the following:
        </p>  
        <table width="100%" class="sign_table" style=" margin-top:-5px;">
<tr> 
<td><b>Student</b></td>
<td width="160" class="border-bottom">'.$lname.'&nbsp;</td><td width="5">/</td>
<td width="160" class="border-bottom">&nbsp;</td><td width="5">/</td>
<td width="160" class="border-bottom">'.$fname.'&nbsp;</td>
	</tr> 
	 <tr>
	 <td><b><span class="float-right"></span></b></td>

 <td class="ps-1" valign="top">Family Name </td><td></td>
 <td> <span class="float-left"> Initial </span></td>
  <td></td>
 <td class="ps-1" valign="top">First Name </td>
 </tr>
 </table>  
 <table width="100%">
  <tr>
	  <td width="40"><b>&nbsp;</b></td>
	  <td width="40">Mr. '.$Mr_Div.'</td>
	  <td width="40">Miss. '.$Miss_Div.'</td> 
	  <td width="40">Mrs. '.$Mrs_Div.'</td>
	  <td width="40">Ms. '.$Ms_Div.'</td>
	  <td width="60">Date of Birth: </td>
	  <td width="60" class="border-bottom">'.$dob.' &nbsp;</td>
	  <td width="250"></td>
  </tr>
  </table><br>
  <table width="100%">
  <tr>
  <td>
  <span style="margin:5px 0px0px !important;  padding:0px; font-size:16px; font-weight:bold; ">Program: <span style="color:#3a7f3d;" </span>'.$program_Lists.'&nbsp;</span>
	</td>
	   </tr>
	   </table>
	<table width="100%" class="sign_table">
	<tr>
	<td width="85"><b>Commencing On:</b></td><td style="border-bottom:1px solid #333 !important; float:left; width:107px;">'.$start_date2.' &nbsp;</td>
	<td align="center"><b>Expected Completion Date </b></td><td style="border-bottom:1px solid #333 !important; float:left; width:107px;">'.$finish_date2.'&nbsp;</td>
	<td width="80" align="center"><b>Program Hours:</b></td><td style="border-bottom:1px solid #333 !important; float:left; width:107px;">'.$study_hours.' OR '.$study_weeks33.' Weeks&nbsp;</td>
	</tr>
	</table>
        <table width="100%" class="sign_table">
        <tr>
        <td width="160"><b>Student Weeks (including breaks if applicable):  </b></td>
<td style="border-bottom:1px solid #333 !important; float:left; width:30px;" align="center">'.$study_weeks_winter.'</td>
<td width="55"><b>School breaks: </b></td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:140px;" align="center">'.$school_break.'&nbsp;</td>
<td  width="65">&nbsp;</td>
</tr>
</table>
        <table width="100%" class="sign_table">
        <tr>
        <td width="154"><b>Language of Instruction:  </b>  <img width="10" src="../aol-pdf/images/check.jpg"> English   </td> <td width="100"><b>Location of Practicum: </b></td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  width:40px;">'.$location_Practicum.'&nbsp;</td>
  <td width="165"><b>Location of Instruction if not campus:  </b></td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;">'.$location_Practicum_not.'&nbsp;</td>
  </tr>
  </table>
 <table width="100%" class="sign_table">
        <tr>
        <td width="140"><b>Additional practicum location  </b></td> <td width="50"><img width="10" src="../aol-pdf/images/check.jpg"> N/A or</td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:100px;">&nbsp;</td>
<td style="width:390px;">&nbsp;</td>
</tr>
</table>
 <table width="100%" class="sign_table" style="margin-bottom:0px;">
        <tr>
        <td width="90"><b>Class Schedule:  </b></td>
<td width="70"><img width="10" src="../aol-pdf/images/check.jpg"> Full Time</td>
<td width="70">'.$study_daysDiv.' Mon to Fri</td>
<td width="30">Times</td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:160px;">'.$study_times.'&nbsp;</td>
<td style="width:360px;">&nbsp;</td>
</tr>
</table><p style="margin-top:4px !important;"><b>All students are required to attend all scheduled classes and placements (where applicable,) on a full-time basis, in accordance with the above stated hours.<br><br>
<b>Credential</b> to be awarded upon Successful Completion of the Program: </b>'.$comp_program.'&nbsp;  
</p>
 <!--table width="100%" class="sign_table">
 <tr>
 <td width="100">Last Grade Completed:   </td>
 <td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:150px;">&nbsp;</td>
 <td width="30">Year: </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:60px;">&nbsp;</td>
 <td width="110">Additional Courses Taken: </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:150px;" >&nbsp;</td>
 </tr>
 </table-->
        <table width="100%" class="sign_table">
        <tr>
        <td width="58">Mailing Address:   </td><td style="border-bottom:1px solid #333 !important; float:left; width:200px;">'.$mailing_address.' &nbsp;</td>
<td width="40">Apt/Unit # </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:60px;">'.$apt.' &nbsp;</td>
<td width="20">City: </td><td width="115" style="border-bottom:1px solid #333 !important;vertical-align:bottom;">'.$city.' &nbsp;</td>
</tr>
</table>
<table width="100%" class="sign_table">
<tr>
<td width="43">Province  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:140px;">'.$province.' &nbsp;</td>
<td width="55">Postal Code:</td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">'.$postal_code.' &nbsp;</td>
 <td width="30">Phone:  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">'.$mobile_no.' &nbsp;</td>
 <td width="55">Alternative: </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">'.$alternate_mobile_no.' &nbsp;</td>
 <td width="20">Cell:  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">&nbsp;</td>
 </tr>
 </table>
         <table width="100%" class="sign_table">
        <tr>
        <td width="68">Email Address:  </td><td style="border-bottom:1px solid #333 !important; width:300px;vertical-align:bottom;" >'.$email_address.'</td>
<td>&nbsp;</td>
</tr>
</table>
<table width="100%" class="sign_table">
<tr>
<td width="190">Permanent Address:  As above '.$AsAboveAddress.' </td>
</table>
 <table width="100%" class="sign_table">
         <tr>
         <td width="30">Address:   </td><td style="border-bottom:1px solid #333 !important; float:left; width:220px;">'.$parmanent_address2.' &nbsp;</td>
 <td width="40">Apt/Unit # </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:60px;">'.$apt2.' &nbsp;</td>
 <td width="20">City: </td><td width="115" style="border-bottom:1px solid #333 !important;vertical-align:bottom;">'.$city2.' &nbsp;</td>
 </tr>
 </table>
<table width="100%" class="sign_table">
<tr>
<td width="43">Province  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:140px;">'.$province2.' &nbsp;</td>
<td width="55">Postal Code:</td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">'.$postal_code2.' &nbsp;</td>
 <td width="30">Phone:  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">&nbsp;</td>
 <td width="55">Alternative: </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">&nbsp;</td>
 <td width="20">Cell:  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">&nbsp;</td>
 </tr>
 </table>
         <table width="100%" class="sign_table">
        <tr>
        <td width="68">Email Address:  </td><td style="border-bottom:1px solid #333 !important; width:300px;vertical-align:bottom;" >'.$mailing_address2.'</td>
<td></td>
</tr>
</table>   
 <table width="100%" class="sign_table">
         <tr>
         <td width="110"><b>International Student: </b></td>
 <td width="60">'.$student_typeYes.' Yes</td>
 <td width="100">'.$student_typeNo.' No</td>
 <td></td>
 </tr>
 </table>
 '.$pageProgramDiv.'
 <table width="100%" class="sign_table">
 <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:180px; height:30px;">'.$fullname.'</td>
  <td align="center" width="60">&nbsp;</td>
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:180px; height:30px;"><img src="'.$getSignature.'" width="100" height="30"></td>
  <td align="center" width="60">&nbsp;</td>
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:180px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Name: Student </td>
<td align="center" width="60">&nbsp;</td> 
<td align="center">Signature: Student	</td>
<td  align="center" width="60">&nbsp;</td>
<td align="center" >Date</td>
</tr></table>
 <table width="100%" class="sign_table">
 <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:180px; height:30px;">'.$loggedName.'&nbsp;</td>
  <td align="center" width="60">&nbsp;</td>
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:180px; height:30px;">'.$rep_signName2.'&nbsp;</td>
  <td align="center" width="60">&nbsp;</td>
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:180px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Name: Admissions Advisor </td>
<td align="center" width="60">&nbsp;</td> 
<td align="center">Signature: Admissions Advisor</td>
<td  align="center" width="60">&nbsp;</td>
<td align="center" >Date </td>
</tr></table>
 <table width="100%" class="sign_table">
 <tr>
	<td width="70" style="vertical-align:bottom">Director Signature:</td>
	<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:140px; height:30px; ">'.$DirectorSign.'&nbsp;</td>
    <td width="180">&nbsp;</td>
    <td width="20" style="vertical-align:bottom">Date</td>
    <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date22.'&nbsp;</td>
</tr>
</table>
        </main>
                    <!-- Wrap the content of your PDF inside a main tag -->
                            <main class="page"> 
                            <br>
                   <table width="100%" class="sign_table">
                   <tr> <td width="290">Where did you hear about <b>'.$campusName.'? </b></td>
<td width="150" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left;">'.$bay_street.'&nbsp;</td>
<td>&nbsp;</td>
</tr></table><p><b>Emergency Contact Information</b></p>
 <table width="100%" class="sign_table">
  <tr>
 <td width="40"> Name:  </td>
 <td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:200px;">'.$emg_name.'&nbsp;</td>
 <td width="50"> Relationship:  </td>
 <td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:200px;">'.$emg_relation.'&nbsp;</td>
 <td>&nbsp;</td>
 </tr>
 </table><table width="100%" class="sign_table">
        <tr>
        <td width="30">Address:   </td><td style="border-bottom:1px solid #333 !important; float:left; width:220px;">'.$emg_address.' &nbsp;</td>
<td width="40">Apt/Unit # </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:60px;">'.$emg_apt.' &nbsp;</td>
<td width="20">City: </td><td width="115" style="border-bottom:1px solid #333 !important;vertical-align:bottom;">'.$emg_city.' &nbsp;</td>
</tr>
</table>
<table width="100%" class="sign_table">
<tr>
<td width="43">Province  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:140px;">'.$emg_province.' &nbsp;</td>
<td width="55">Postal Code:</td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">'.$emg_postal_code.' &nbsp;</td>
 <td width="30">Phone:  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">'.$emg_phone.' &nbsp;</td>
 <td width="55">Alternative: </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">'.$emg_alter_phone.' &nbsp;</td>
 <td width="20">Cell:  </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:65px;">'.$emg_cell.'&nbsp;</td>
 </tr>
 </table>';

if($no_fees == 'Yes'){
	$output .= '<table class="table-bordered" style="margin-top:5px;" width="100%">
<tr>
<td colspan="2" ><b>Fees to Academy of Learning College (CAN$):</b></td>
<td colspan="2"></td></tr>
<tr>
<td width="140">Tuition Fees</td>
<td width="70">$0.00</td>
<td  width="160">Book Fees (Business Courses Only)</td>
<td width="70"> $0.00</td>
</tr>
<tr>
<td >Other Compulsory Fees (Lab fee)</td>
<td>$0.00</td>
<td>Uniform/Professional exam fees </td>
<td> $0.00</td>
</tr>
<tr>
<td>International Student Fees</td>
<td>$0.00</td>
<td><b>MINUS</b> Credit for Prior Learning amount</td>
<td> -$0.00 </td>
</tr>
<tr>
<td>Optional Fees (specify)</td>
<td>$0.00</td>
<td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr bgcolor="#eee">
<td colspan="3"><b>Total Fees</b></td>
<td> $0.00</td>
</tr>
</table>';

}else{
	$output .= '<table class="table-bordered" style="margin-top:5px;" width="100%">
<tr>
<td colspan="2" ><b>Fees to Academy of Learning College (CAN$):</b></td>
<td colspan="2"></td></tr>
<tr>
<td width="140">Tuition Fees</td>
<td width="70">$'.$tuition_fees.'</td>
<td  width="160">Book Fees (Business Courses Only)</td>
<td width="70"> $'.$book_fees.'</td>
</tr>
<tr>
<td >Other Compulsory Fees (Lab fee)</td>
<td>$'.$compulsory_fees.'</td>
'.$hstProfessional.'
</tr>
<tr>
<td>International Student Fees</td>
<td>$'.$int_fees3.'</td>
<td><b>MINUS</b> Credit for Prior Learning amount</td>
<td> -$'.$minus_cfpl_amount.' </td>
</tr>
<tr>
<td>Optional Fees (specify)</td>
<td>$0.00</td>
'.$examFees.'
</tr>
<tr bgcolor="#eee">
<td colspan="3"><b>Total Fees</b></td>
<td> $'.$total_fees.'</td>
</tr>
</table>';
}

$output .= '
<p style="margin-top:5px;"><b>Please refer to Appendix 1 for detailed payment schedule.<br>
Funding Information:
</b></p><table width="100%" class="sign_table" style="margin-bottom:0px;">
<tr>
<td width="75">'.$osapFunding.'<b> OSAP (if eligible)</b></td>
<td width="75">'.$csFunding.'<b> Second Career</b></td>
<td width="65">'.$sfFunding.'<b> Self-Funded</b></td>
<td width="90">'.$tpfFunding.'<b> Third Party Funded</b></td>
<td style="width:50px;">'.$otherFunding.'<b> Other: </b></td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:90px;">'.$fund_info_other.'&nbsp;</td>

 </tr>
 </table>
 <p><b><u>ACKNOWLEDGEMENT</u></b></p>
 '.$acknowledgeDiv.'
 <table width="100%" class="sign_table">
  <tr>
 <td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:220px;">'.$fullname.' </td>
 <td> <b>is entitled to a copy of the signed contract immediately after it is signed.</b></td>

 </tr>
 </table>
 <p>Students Name (print)  </p>
 <table width="100%" class="sign_table">
 <tr> 
 <td  align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:28px;">&nbsp;<img src="'.$getSignature.'" width="105" height="25"></td>
   <td align="center" width="190">&nbsp;</td>
   <td align="center" width="20">Date</td>
   <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Signature of Student </td>
<td  align="center" width="70">&nbsp;</td>
<td  align="center" width="40">&nbsp;</td>
<td align="center" >(mm/dd/yyyy)</td>
</tr></table>
    <table width="100%"><tr><td><b>'.$campusName.' does not guarantee employment for any student who successfully completes a vocational program offered by '.$campusName.'</b><br>
    It is understood that fees are payable in accordance with the fees specified in this Enrolment Contract and all payments of fees shall become due forthwith upon a statement of accounting being rendered. <b>'.$campusName.'</b> reserves the right to cancel this Enrolment Contract if the undersigned student does not attend classes during the first 14 days of the program.  <b> For information regarding cancellation of this Enrolment Contract and refunds of fees paid, see section 25 to 33 of O. Reg. 415/06 made under the <b>Private Career Colleges Act</b>, 2005.</b>
    <br>
    I certify that I have read, understood and have received a copy of this Enrolment Contract. 
    <br>
    The undersigned student hereby undertakes and agrees to pay, or see to payment of, the fees specified in this Enrolment Contract in accordance with the terms of this Enrolment Contract.
</td>
        </tr>
        </table>
 <table width="100%" class="sign_table">
 <tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:200px; height:28px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>
  <td align="center" width="100">&nbsp;</td>
  <td align="center" width="20">Date</td>
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Signature of Student </td>
<td  align="center">&nbsp;</td>
<td  align="center" width="40">&nbsp;</td>
<td align="center" >(mm/dd/yyyy)</td>
</tr></table> 
<p><b>'.$campusName.'</b> agrees to supply the program to the above named student upon the terms here in mentioned. <b>'.$campusName.'</b> may cancel this Enrolment Contract if the above named student does not meet the admission requirements of the program, named on Page 1 of this contract, before the program begins.</p>  <table width="100%" class="sign_table">
<tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:200px; height:28px;">'.$rep_signName2.'&nbsp;</td>
  <td align="center" width="90">&nbsp;</td>
  <td align="center" width="20">Date</td>
  <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr>
<td align="center">Signature of Admission Officer, Registrar, Agent </td>
  <td align="center" width="90">&nbsp;</td>
  <td align="center" width="20">&nbsp;</td>
  <td align="center" >(mm/dd/yyyy)</td>
</tr></table>
                  </main>
 <!-- Wrap the content of your PDF inside a main tag -->
 '.$privacyPolicy.'
 '.$declarationParalegal.'
        <!-- Wrap the content of your PDF inside a main tag -->
                <main class="page"> 
                <br>
                <br>
<p class="text-center"><b>Consent to Use of Personal Information</b></p><br><p>
Private career colleges (PCCs) must be registered under the <i><b>Private Career Colleges Act</b>, 2005,</i> which is administered by the Superintendent of Private Career Colleges. The Act protects students by requiring PCCs to follow specific rules on, for example, fee refunds, training completions if the PCC closes, qualifications of instructors, access to transcripts and advertising.   It also requires PCCs to publish and meet certain performance standards, e.g., percentage of graduates who obtain employment. This information may be used by other students when they are deciding where to obtain their training. The consent set out below will help the Superintendent to ensure that current and future students receive the protection provided by the Act. </p><br>
<br>
<table width="100%" class="sign_table">
<tr> 
<td width="3">I,   </td><td style="border-bottom:1px solid #333 !important;vertical-align:bottom;  float:left; width:210px;">'.$fullname.'&nbsp;</td>
<td> allow <b> '.$campusName.' </b> to give my name, address, telephone  </td> 
</tr>
<tr><td colspan="3">number, e-mail address and other contact information to the Superintendent of Private Career Colleges for the purposes checked below:</td></tr></table><ul class="list-check"><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; To advise me of my rights under the <b>Private Career Colleges Act</b>, 2005 including my rights to a refund of fees, access to transcripts and a formal student complaint procedure; and 
</li>
<li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; To determine whether <b> '.$campusName.' </b> has met the performance objectives required by the Superintendent for its vocational programs. 
</li></ul>
<p>I understand that I can refuse to sign this consent form and that I can withdraw my consent at any time for future uses of my personal information by writing to:</p><p class="text-center">'.$campusAddress.'</p>
<br>
<p>I understand that if I refuse or withdraw my consent the Superintendent may not be able to contact me to inform me of my rights under the Act or collect information to help potential students make informed decisions about their educational choices.</p>
    <table width="100%" class="sign_table">
    <tr> 
    <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;"><span class="text-center"></span>&nbsp;<img src="'.$getSignature.'" width="105" height="27"></td>
    <td>&nbsp;</td>
    <td width="15" style="vertical-align:bottom">Date</td>
    <td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">(Signature of Student) </td>
<td  align="center" width="100">&nbsp;</td>
<td align="center" ></td>
<td align="center" ></td>
</tr></table> 
<p><img src="../aol-pdf/images/box.jpg" width="11"> I   <u> '.$fullname.' </u>  do <b><u>not</u></b> allow '.$campusName.' to  give my name, address, telephone number, e-mail address and other contact information to the Superintendent of Private Career Colleges for any purpose.  </p>
<table width="100%" class="sign_table">
<tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;"><span class="text-center"></span>&nbsp;</td>
<td>&nbsp;</td>
<td width="15" style="vertical-align:bottom">Date</td>
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">&nbsp;</td>
</tr>
<tr><td align="center">(Signature of Student) </td>
<td align="center" width="100">&nbsp;</td>
<td align="center"></td>
<td align="center"></td>
</tr>
</table> 
</main>
'.$practicumRequirement.'
'.$medicalDisclaimer.'
'.$noticeCollection.'
<main class="page"> 
<br>
<br>                    
<p class="text-center"><b>Fee Refund Policy as Prescribed under s. 25 to 33 of O.Reg. 415/06</b><p><br><p><b>Full refunds</b><p>
<ol start="25"><li> (1) A private career college shall refund all of the fees paid by a student under a contract for the provision of a vocational program in the following circumstances:</li></ol><ol start="1" style="padding-left:65px;"><li>
The contract is rescinded by a person within two days of receiving a copy of the contract in accordance with section 36 of the Act.
</li>
<li>The private career college discontinues the vocational program before the student completes the program, subject to subsection (2).
</li>
<li>The private career college charges or collects the fees,<ul class="lower-roman"><li> before the registration was issued for the college under the Act or before the vocational program was approved by the Superintendent, or
</li><br>
<li> before entering into a contract for the provision of the vocational program with the student, unless the fee is collected under subsection 44 (3). 
</li><ul></li></ol>
<ol start="4" style="padding-left:65px;"><li> The private career college expels the student from the college in a manner or for reasons that are contrary to the college’s expulsion policy.
</li>
<li> The private career college employs an instructor who is not qualified to teach all or part of the program under section 41.  
</li>
<li> The contract is rendered void under subsection 18 (2) or under section 22. 
</li>
<li> If a private career college fails to, or does not accurately, provide in the itemized list provided to the Superintendent under section 43 a fee item corresponding to a fee paid by a student for the provision of a vocational program, the college shall pay the student,<ul class="lower-roman"><li>  in the case of an item not provided by the college, the full amount of the fee for the item, and 
</li>
<li> in the case of a fee in excess of the amount of the fee provided for the item, the difference between the amount of the fee for the item provided to the Superintendent and the fee collected.  
</li></ul>
</li></ol>
<ul style="list-style:none;">(2) A full refund is not payable in the circumstances described in paragraph 2 of subsection (1) if the discontinuance of the vocational program coincides with the private career college ceasing to operate. </li><br><br>
<li>
(3) A refund is not payable under paragraphs 1 to 6 of subsection (1) unless the student gives the private career college a written demand for the refund.
</li><br><br><li>
(4) A refund under subsection (1) is payable by the private career college within 30 days of the day the student delivers to the college,<ul style="list-style:none; padding:0px 0px 10px 65px ;"><li>(a) in the case of a rescission under section 36 of the Act, notice of the rescission; or
</li><li>
(b) in the case of a refund under paragraphs 2 to 6 of subsection (1), a written demand for the refund.
</li></ul></li></ul>
<p style="margin-bottom:10px;"><b>Partial refund where student does not commence program</b></p>
<ol start="26"><li> (1) If a student is admitted to a vocational program, pays fees to the private career college in respect of the program and subsequently does not commence the program, the college shall refund part of the fees paid by the student in the following circumstances:
</li></ol>
<ol start="1" style="padding-left:65px;">
<li>The student gives the college notice that he or she is withdrawing from the program before the day the vocational program commences.
</li>
 <li>In the case of a student who is admitted to a vocational program on the condition that the student meet specified admission requirements before the day the program commences, the student fails to meet the requirements before that day.</li>
 <li>The student does not attend the program during the first 14 days that follow the day the program commenced and the college gives written notice to the student that it is cancelling the contract no later than 45 days after the day the program has commenced.
 </li>
 </ol><ul style="list-style:none;"><li>
 <li>(2) The amount of a refund under subsection (1) shall be an amount that is equal to the full amount paid by the student for the vocational program, less an amount equal to the lesser of 20 per cent of the full amount of the fee and $500.</li>
 <li><br>
 (3)  A refund under subsection (1) is payable,<br><ul style="list-style:none; margin-top:10px; margin-bottom:10px;"><li>(a) in the case of a refund under paragraph 1 of subsection (1), within 30 days of the day the student gives notice of withdrawing from the program;
 </li><br></li>
 </ul>
        </main>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main class="page"> 
                               <ul style="list-style:none; ">
                       <li>
<br>  
<ul style="list-style:none; margin-top:10px; margin-bottom:10px;">
<li>(b) in the case of a refund under paragraph 2 of subsection (1), within 30 days of the day the vocational program commences; and</li><br>
<li>(c) in the case of a refund under paragraph 3 of subsection (1), within 45 days of the day the vocational program commences. 
</li></ul></li>
<li>(4) For the purposes of paragraph 3 of subsection (1), it is a condition of a contract for the provision of a vocational program that the private career college may cancel the contract within 45 days of the day the vocational program commences if the person who entered the contract with the college fails to attend the program during the 14 days that follow the day the vocational program commences.
</li><br><li>
(5) A private career college that wishes to cancel a contract in accordance with subsection (4) shall give written notice of the cancellation to the other party to the contract within 45 days of the day the vocational program commences.
</li></ul><br>
<p><b>Partial refunds: withdrawals and expulsions after program commenced</b><p>
<ol start="27" style="margin-top:35px;"><li> (1) A private career college shall give a student who commences a vocational program a refund of part of the fees paid in respect of the program if, at a time during the program determined under subsection (3),<ul style="list-style:none; margin-top:10px; margin-bottom:0px;"><li>(a) the student withdraws from the program after the program has commenced; or
</li>
<li>
(b) the student is expelled from the program in circumstances where the expulsion is permitted under the private career college’s expulsion policy.</li></ul></li></ol>
<ul style="list-style:none;"><li>(2)  This section does not apply to vocational programs described in sections 28 and 29.
</li>
<br><br>
<li>(3)  A private career college shall pay a partial refund under this section only if the withdrawal or expulsion from the vocational program occurs at a time during the program determined in accordance with the following rules:
</li></ul>
<ol start="1" style="padding-left:65px;margin-top:10px;">
<li> In the case of a vocational program that is less than 12 months in duration, the withdrawal or expulsion occurs during the first half of the program.
</li>
<li> In the case of a vocational program that is 12 months or more in duration, <ul class="lower-roman" style="margin-bottom:0px; "><li> for the first 12 months in the duration of the program and for every subsequent full 12 months in the program, the withdrawal or expulsion occurs during the first six months of that 12-month period, and
</li>
<li> for any period in the duration of the vocational program remaining after the last 12-month period referred to in subparagraph i has elapsed, the withdrawal or expulsion occurs in the first half of the period.
</li></ul></li></ol>
<ul style="list-style:none;"><li>
<li>(4) If the student withdraws or is expelled from a vocational program within the first half of a period referred to in subsection (3), the amount of the refund that the private career college shall pay the student shall be equal to the full amount of the fees paid in respect of the program less,
<ul style="list-style:none; margin-top:10px;margin-bottom:10px;"><li>(a) an amount that is equal to the lesser of 20 per cent of the full amount of the fees in respect of the program and $500; and</li><br>
<li>
(b) the portion of the fees in respect of the portion of the period that had elapsed at the time of the withdrawal or expulsion.
</li></ul></li>
<li>(5) If the student withdraws or is expelled from a vocational program during the second half of a period referred to in subsection (3), the private career college is not required to pay the student any refund in respect of that period.  </li>
<br><br>
<li>(6) A private career college shall refund the full amount of fees paid in respect of a period that had not yet commenced at the time of the withdrawal or expulsion.    
</li></ul>
</li></ol><p><b>Partial refunds: distance education programs </b><p>
<ol start="28" style="margin-top:5px; margin-left:0px;"><li>(1) This section applies to a vocational program that is offered by mail, on the internet or by other similar means
</li></ol><ul style="list-style:none;"><li>
<li>(2) A private career college shall give a student who commences a vocational program referred to in subsection (1) a refund of part of the fees paid in respect of the program if, 
<ul style="list-style:none; margin-bottom:10px;margin-top:10px;"><li>
(a) the student withdraws from the program or the student is expelled from the program in circumstances where the expulsion is permitted under the private career college’s expulsion policy; and
</li>
<li>(b) at the time of the withdrawal or expulsion, the student has not submitted to the private career college all examinations that are required in order to complete the program.</li></ul></li>
<li>(3) The amount of the refund that a private career college shall give a student under subsection (1) shall be determined in accordance with the following rules:
</li></ul>
<ol start="1" style="padding-left:65px;margin-top:10px;">
<li> Determine the total number of segments in the vocational program for which an evaluation is required. 
</li>
<li> Of the total number of program segments determined under paragraph 1, determine the number of segments in respect of which an evaluation has been returned to the student.   
</li></ol>
        </main>
                    <!-- Wrap the content of your PDF inside a main tag -->
                            <main class="page"> 
                            <br><ol start="3" style="padding-left:65px;margin-top:10px;">
<li> The amount of the refund that the private career college shall pay the student shall be equal to the full amount of the fees paid in respect of the program less,<ul class="lower-roman"><li> an amount that is equal to the lesser of 20 per cent of the full amount of the fees in respect of the program and $500, and
</li>
<li> the portion of the fees in respect of the number of segments determined under paragraph 2.
</li></ul></li></ol>
<ol style="margin-top:-10px !important; list-style:none"><li>(4) A private career college is not required to give a student any refund if the student, at the time of withdrawal or expulsion, has been evaluated in respect of more than half of the total number of segments in the program.</li></ol><p style="margin-bottom:10px; margin-left:0px;"><b>Partial refunds: non-continuous programs</b><p>
<ol start="29" style="margin-top:0px;"><li>(1) This section applies to a vocational program approved by the Superintendent to be provided through a fixed number of hours of instruction over an indeterminate period of time.
</li></ol>
<ul style="list-style:none; "><li>
<li>(2) A private career college shall give a student who commences a vocational program referred to in subsection (1) a refund of part of the fees paid in respect of the program if, before completing the required number of hours of instruction, <ul style="list-style:none; margin-top:10px margin-bottom:20px;"><li>(a) the student has given the college notice that he or she is withdrawing from the program; or 
</li>
<br>
<li>(b) the student is expelled from the program in circumstances where the expulsion is permitted under the private career college’s expulsion policy. </li></ul>
</li></ul>
<ul style="list-style:none; "><li>(3) The amount of the refund that a private career college shall give a student under subsection (1) shall be equal to the full amount of the fees paid in respect of the program less,
<ul style="list-style:none; margin-top:10px;"><li>
(a) an amount that is equal to the lesser of 20 per cent of the full amount of the fees in respect of the program and $500; and
</li>
<li>
(b) a portion of the fees in respect of the program that is proportional to the number of hours of instruction that have elapsed at the time of the withdrawal or expulsion.
</li></ul></li></ul>
<ul style="list-style:none; margin-bottom:5px; margin-top:0px;"><li>(4) A private career college is not required to give a student any refund if the student, at the time of withdrawal or expulsion, has completed more than half of the required number of hours of instruction in a program.</li></ul>
<p><b>No retention of refund</b></p>
<ol start="30" style="margin-top:6px;"><li> A private career college shall not retain, by way of deduction or set-off, any refund of fees payable to a student under sections 25 to 29 in order to recover an amount owed by the student in respect of any service or program other than a vocational program offered by the private career college.</li></ol>
<p><b>Treatment of books and equipment</b></p>
<ol start="31" style="margin-top:5px; margin-bottom:0px;"><li> In calculating a refund under sections 25 to 29, a private career college may retain the retail cost of books or equipment that the private career college supplied to the student if the student,<ul style="list-style:none;"><li>
(a) fails to return the books or equipment to the private career college within 10 days of the student’s withdrawal or expulsion from the program, or</li>
<li>(b) returns the books or equipment to the private career college within the 10-day period referred to clause (a), but fails to return it unopened or in the same state it was in when supplied.  </li></ul>
</li></ol>
<p><b>Refund for international students</b></p>
<ol start="32" style="margin-top:5px;"><li>A notice to a private career college that is provided by or on behalf of an international student or of a prospective international student and that states that the student has not been issued a temporary resident visa as a member of the student class under the Immigration and Refugee Protection Act (Canada) is deemed to be,
<ul style="list-style:none;"><li>
(a) notice of a rescission of the contract for the purposes of section 36 of the Act if the notice is given within two days of receiving a copy of the contract; and</li>
<li>(b) notice that the student is withdrawing from the program for the purposes of paragraph 1 of subsection 26 (1) or clause 29 (2) (a) if the notice is received on or before half of the duration of the program has elapsed. 
</li></ul></li></ol>
<p><b>Currency</b></p>
<ol start="33" style="margin-top:5px;"><li> Any refund of fees that a private career college is required to pay under the Act shall be paid in Canadian dollars.</li></ol>
 </main>
             <!-- Wrap the content of your PDF inside a main tag -->
                     <main class="page"> <br><br><p><b>TERMS AND CONDITIONS OF ENROLMENT</b></p>
                     '.$termCondition.'
                             </main>
                <!-- Wrap the content of your PDF inside a main tag -->
                <main class="page"> <br><br>
                <p><b>ALTERNATIVE TRAINING MEASURES – COVID 19</b></p>
                <br>
  <p> I   <u> '.$fullname.' </u>  acknowledge that I have been informed of the following: </p>
   <ul class="list-check"><li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Academy of Learning Career College’s Alternative Measures of Instruction  </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The technological requirements for participation in remote learning </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; An orientation of the software or programs used  </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Provided with details on protection of student privacy and information security </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; Any implications this may have to the original training schedule </li>
 <li><img src="../aol-pdf/images/check.jpg" width="11"> &nbsp; The possibility that the program’s delivery method may change following March 31, 2023 
  </li></ul>
  <table width="100%" class="sign_table">
<tr> 
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px; height:30px;">&nbsp;<img src="'.$getSignature.'" width="100" height="30"></td>  
<td>&nbsp;</td>
<td width="20" style="vertical-align:bottom">Date</td>
<td align="center" style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr> <td align="center">Signature of Student</td>
<td  align="center" width="100">&nbsp;</td>
<td align="center"></td>
<td align="center">(mm/dd/yyyy)</td>
</tr></table> 
      ';
	  
$output .= '';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($contract_signature)){
	unlink("uploads/$contract_signature");
}

$vnum = str_replace(' ', '', $student_id_2);
$olname = 'Contract_Sign_'.$vnum;
$olname2 = 'Contract_Sign_'.$vnum.'.pdf';
$filepath = "uploads/$olname.pdf";
file_put_contents($filepath, $document->output());

if(mysqli_num_rows($get_query3)){
	$getUpdate = "update `ppp_form_more` set `contract_signature`='$olname2', `contract_sign_datetime`='$ppp_datetime' where `ppp_form_id`='$snoid'";
	mysqli_query($con, $getUpdate);
}else{
	$getInsert = "INSERT INTO `ppp_form_more` (`ppp_form_id`, `contract_signature`, `contract_sign_datetime`) VALUES ('$snoid', '$olname2', '$ppp_datetime')";
	mysqli_query($con, $getInsert);
}

if(!empty($_GET['stusno']) && isset($_GET['stusno'])){
	header("Location: ../docsign/pdf_emc.php?stusno=$snoid");
}

if(!empty($_POST['snoidbknd']) && !empty($_POST['docBackend'])){
	$getUpdate3 = "update `ppp_form_more` set `final_student_sbmit`='1', `final_student_sbmit_datetime`='$ppp_datetime' where `ppp_form_id`='$snoid'";
	mysqli_query($con, $getUpdate3);
	
	$document->stream("$olname2", array("Attachment"=>1));
	//1  = Download
	//0 = Preview
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
    <title>AOLCC - Student Enrollment Contract</title>
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
                <span class="btn float-start btn-success text-center btn_next">Signed Enrollment Contract Docs</span>
            </div>
			
			<div class="col-12 col-sm-5 py-2">
                <a href="pdf_pp.php?uid=<?php echo $snoid; ?>" class="btn float-sm-end btn-primary text-center btn_next">Continue</a>
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