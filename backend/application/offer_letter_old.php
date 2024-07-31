<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");

require_once '../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//initialize dompdf class

$document = new Dompdf();

$document->set_option('defaultFont', 'Courier');

$col_updated = date('Y-m-d H:i:s');

$campus = $_POST['campus'];
$tk = $_POST['tk'];
$pn = $_POST['pn'];
$snoid = $_POST['snoid'];
$ol_type = $_POST['ol_type'];
$ol_type_remarks = $_POST['ol_type_remarks'];

$ol_processing = $_POST['ol_processing'];
$ol_conditional_pal = $_POST['ol_conditional_pal'];
if($ol_processing == 'Conditional COL'){
	$olCondPal = ", ol_conditional_pal='$ol_conditional_pal'";
	$ConditionalDiv = 'Conditional';
}
if($ol_processing == 'Final COL'){
	$olCondPal = ", ol_conditional_pal=''";
	$ConditionalDiv = '';
}

$query1 = "SELECT fname,lname,refid,email_address,gender,dob,address1,address2,city,state,country,pincode, passport_no,datetime,pp_issue_date,pp_expire_date,englishpro,ieltsover,pteover, offer_letter FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$refid = $rowstr1['refid'];
$email_address = $rowstr1['email_address'];
$gender = $rowstr1['gender'];
if($gender == 'Male'){
	$getmale = '<span style="width:130px;margin-left:10px;"><img src="../../images/tick.png" width="10"> Male </span>';
}else{
	$getmale = '<span style="width:130px;margin-left:10px;"><img src="../../images/box.png" width="10"> Male </span>';
}
if($gender == 'Female'){
	$getfemale = '<span style=" margin-left:10px;width:100px;"><img src="../../images/tick.png" width="10"> female</span>';
}else{
	$getfemale = '<span style=" margin-left:10px;width:100px;"><img src="../../images/box.png" width="10"> female</span>';
}
	
$dob = $rowstr1['dob'];
$getdob = date("d/m/Y",strtotime($dob));
$getdob1 = date("Y",strtotime($dob)); 
$getdob2 = date("m",strtotime($dob)); 
$getdob3 = date("d",strtotime($dob));  
$address1 = $rowstr1['address1'];
$address3 = $rowstr1['address2'];
$address22 = $rowstr1['address2'];
if($address22 !== ''){
	$address2 = $address22.', ';
}else{
	$address2 = '';
}
$city = $rowstr1['city'];
$state = $rowstr1['state'];
$country = $rowstr1['country'];
$pincode = $rowstr1['pincode'];
$passport_no = $rowstr1['passport_no'];
$pp_issue_date = $rowstr1['pp_issue_date'];
$pp_expire_date = $rowstr1['pp_expire_date'];
$offer_letter = $rowstr1['offer_letter'];
$testd1 = $rowstr1['englishpro'];
if($testd1 == 'ielts'){
	$testd = 'IELTS';
	$overall = $rowstr1['ieltsover'];
}else{
	$testd = 'PTE';
	$overall = $rowstr1['pteover'];
}

$datetime = date('Y-m-d');
$getdate = date("F d, Y", strtotime($datetime)); 

// if($pn == 'Business Administration Diploma'){
	// $poi1 = '<img src="../../images/tick.png" width="10">  Business Administration<br>';
// }else{
	// $poi1 = '<img src="../../images/box.png" width="10">  Business Administration<br>';
// }
// if($pn == 'Conference And Event Planner'){
	// $poi2 = '<img src="../../images/tick.png" width="10">  Conference And Event Planner<br>';
// }else{
	// $poi2 = '<img src="../../images/box.png" width="10"> Conference And Event Planner<br>';
// }
// if($pn == 'Paralegal'){
	// $poi3 = '<img src="../../images/tick.png" width="10">  Paralegal<br>';
// }else{
	// $poi3 = '<img src="../../images/box.png" width="10"> Paralegal<br>';
// }
// if($pn == 'Law Clerk'){
	// $poi4 = '<img src="../../images/tick.png" width="10">  Law Clerk<br>';
// }else{
	// $poi4 = '<img src="../../images/box.png" width="10"> Law Clerk<br>';
// }
// if($pn == 'Network Administrator'){
	// $poi5 = '<img src="../../images/tick.png" width="10">  Network Administrator<br>';
// }else{
	// $poi5 = '<img src="../../images/box.png" width="10"> Network Administrator<br>';
// }
// if($pn == 'Project Administration'){
	// $poi6 = '<img src="../../images/tick.png" width="10">  Project Administration<br>';
// }else{
	// $poi6 = '<img src="../../images/box.png" width="10"> Project Administration<br>';
// }
// if($pn == 'Medical Office Assistant'){
	// $poi7 = '<img src="../../images/tick.png" width="10">  Medical Office Assistant<br>';
// }else{
	// $poi7 = '<img src="../../images/box.png" width="10"> Medical Office Assistant<br>';
// }
// if($pn == 'Personal Support Worker'){
	// $poi8 = '<img src="../../images/tick.png" width="10">  Personal Support Workers<br>';
// }else{
	// $poi8 = '<img src="../../images/box.png" width="10"> Personal Support Workers<br>';
// }
// if($pn == 'Logistics and Supply Chain Operations'){
	// $poi9 = '<img src="../../images/tick.png" width="10">  Logistics and Supply Chain Operations<br>';
// }else{
	// $poi9 = '<img src="../../images/box.png" width="10"> Logistics and Supply Chain Operations<br>';
// }

$query2 = "SELECT commenc_date,program_name,expected_date,total_tuition,otherandbook,week,hours FROM contract_courses WHERE intake='$tk' AND program_name='$pn' AND campus='$campus'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$commenc_date = $rowstr2['commenc_date'];
$program_name = $rowstr2['program_name'];
$expected_date = $rowstr2['expected_date'];
$total_tuition = $rowstr2['total_tuition'];
$otherandbook = $rowstr2['otherandbook'];
$
$week = $rowstr2['week'];
$hours = $rowstr2['hours'];

$output = "<style>
.firstrow{width:100%;font-size:12px; color:#333;font-family:Arial, Helvetica, sans-serif;  page-break-after: always; position:relative; }
.logo{margin-top:0px; width:170px; margin-bottom:5px; float:left;}
.headertop
{margin-top:-15px; margin-bottom:0px;width:70%;float:left;font-size:10px;text-transform:uppercase;text-align:center;padding:2px 0;}
.firstrow #heading{margin-top:70px; margin-bottom:0px;width:100%;font-size:17px;font-weight:700;text-transform:uppercase;text-align:center;padding:2px 0;}

/*---------offer letter--------*/
.table1 { border-top:1px solid #333; margin-bottom:10px;}
.table1 td { border-bottom:1px solid #333; font-size:11px; padding:1px 0px 1px 2px;}
.signature img {margin-top:10px;}
.signature { float:left; width:100%;}
h4 { font-size:16px;  margin-bottom:10px;text-transform:uppercase;}
ul { margin-top:0px;}
.bank-table { border:1px solid #333;}
.bank-table td { border:1px solid #333; padding:3px 10px;}
.stu-name {  margin-left:5%;  margin-top:0px;}
.line2 { margin-bottom:5px;}
.form-table1 { float:right; }
.form-table1 td {padding:0px 0px; text-align:center;}
.list-ul { margin:0px 0px;}
.list-ul li { list-style:none;}
.condition-list { border:1px solid #333; padding:15px 30px;}
.footer{width:100%;position: fixed; 
	bottom: 0cm; 
	left: 0cm; 
	right: 0cm;
	height: 60px;}	

@page { margin:25px 30px 25px;padding:10px;}
.firstrow1{width:100%;font-size:15px; color:#333;font-family:Arial, Helvetica, sans-serif;  page-break-after: always; position:relative; }
.logo1{margin:0; border:1px solid #fff; float:right;}
.header1 { width:100%; margin:0px;  text-align:center;}
.header1 h3 { font-size:22px; margin-bottom:0px;}
.header1 h6 { font-size:14px; margin-top:0px;margin-bottom:10px; }
.header1 p { font-size:12px; margin-top:0px; margin-bottom:10px; text-align:center; }
.heading3 { padding:1px 10px;font-size:17px; margin-top:0px; margin-bottom:20px; background:#810000; color:#fff;}
.heading2 { font-size:16px; margin-top:0px;  margin-bottom:0px;}
.heading3.center {text-align:center;}
.add-table td { font-size:11px; }
.form-table .form-table { padding:0px;margin:-10px 0px  0px;}
.form-table {margin:0px;}
.form-table td { padding:0px; font-size:14px; } 
.form-table td p{margin-top:0px; color:#000;}    
footer1 { font-family:Times-Roman;
	position: fixed; font-size:15px;
	bottom: 0cm; 
	left: 0cm; color:#000;
	right: 0cm;
	height: 60px; border:1px solid #333; background:#ccc;
}
p.prog-list { margin-left:5px; font-weight:normal; margin-top:-10px !important; line-height:25px;}
.prog-list img {margin-right:5px;}
footer1 table td { padding-left:14px;padding-right:14px; font-size:12.6px;}	
</style>";

$output .= '<div class="firstrow1">	
<div class="header1">
<table width="100%" border="0">
 <tr><td width="75%"><h3>International Student Application Form</h3>
 <h6><i>Please complete all sections of the form.</i></h6></td><td><img src="../../images/academy_of_learning_logo.png" width="180" class="logo1">
 <p>WWW.AOLTORONTO.COM</p></td><tr></table>
</div>

<h4 class="heading3">PERSONAL INFORMATION</h4>
<table width="100%" class="form-table">
 <tr>

 <td width="35%"><span style="float:left; width:240px; border-bottom:1px solid #333; height:15px;">'.$fname.'</span><br/><p><span> First/Given Name</span></p></td>
 <td width="30%"><span style="float:left; width:200px; border-bottom:1px solid #333; height:15px;"></span><br/><p><span> Middle Name(s)</span></p></td>
 <td width="35%"><span style="float:left; width:240px; border-bottom:1px solid #333; height:15px;">'.$lname.'</span><br/><p><span> Last/Family Name</span></p></td></tr>
  <tr>
  </table>
 <table width="100%" class="form-table">
 <tr>
 <td width="35%"><span style="float:left; width:98%; border-bottom:1px solid #333; height:15px;"></span><br/><p><span> Maiden Name</span> (if applicable)</p></td>
 <td width="40%"><span style="float:left; width:98%; border-bottom:1px solid #333; height:15px;">'.$email_address.'</span><br/><p><span> Email Address</span></p></td>
 <td width="25%">
 <p style="margin-top:-0px ;">
 <b style="float:left; width:60px;">Gender:</b> 
 '.$getmale.''.$getfemale.'
 </p></td>
 </tr>
 <tr>
 </table>
 <h4 class="heading2">Full Mailing Address</h4>
<table width="100%" class="add-table">
<tr><td width="50%">Address1</td>
<td width="50%">Address2</td>
</tr>
<tr><td width="50%" style="float:left; border-bottom:1px solid #333; border-left:1px solid #333; padding-left:5px;">'.$address1.'</td>
<td width="50%" style="float:left;  padding-left:5px;border-bottom:1px solid #333;border-left:1px solid #333; border-right:1px solid #333;" height:30px;">'.$address3.'</td>
</tr>
</table>
<table width="100%" class="add-table">
<tr>
<td width="25%">City/Town:</td>
<td width="25%">Country:</td>
<td width="25%">Province/State:</td>
<td width="25%">Postal Code:
</td>
</tr>
<tr><td width="25%" style="float:left;  padding-left:5px;border-bottom:1px solid #333; border-left:1px solid #333;">'.$city.'</td>
<td width="25%" style="float:left; padding-left:5px; border-bottom:1px solid #333;border-left:1px solid #333;">'.$country.'</td>
<td width="25%" style="float:left; padding-left:5px; border-bottom:1px solid #333;border-left:1px solid #333; height:30px;">'.$state.'</td>
<td width="25%" style="float:left;  padding-left:5px; border-bottom:1px solid #333;border-left:1px solid #333; border-right:1px solid #333;">
'.$pincode.'</td>
</tr>
</table><br>
<table width="100%" class="form-table"><tr><td valign="top"><h4 class="heading3 center">PASSPORT INFORMATION</h4>
<table width="100%"class="form-table">
 <tr>
 <td width="100%"><span style="float:left; width:100%; border-bottom:1px solid #333; height:15px;">'.$passport_no.'</span><br/><p>Passport Number</p></td></tr>
 <tr>
 <td width="100%"><span style="float:left;  width:100%; border-bottom:1px solid #333; height:15px;">'.$pp_issue_date.'</span><br/><p> Date of Issue</p></td>
</tr>
 
</table>
<table width="100%" class="form-table">
 <tr>
 <td width="55%"><span style="float:left; width:90%; border-bottom:1px solid #333; height:15px;">'.$pp_expire_date.'</span><br/><p>Date of Expiry</p></td>
 <td width="45%"><span style="float:left;  width:100%; border-bottom:1px solid #333; height:15px;"></span><br/><p>Country of Birth</p></td>
 </tr> 
  </table>  
<table width="100%" class="form-table">
 <tr>  
 <td width="100%"><span style="float:left; width:100%; border-bottom:1px solid #333; height:15px;"></span><br/><p>Country of Citizenship</p></td></tr>
 </tr>
</table> 
  
   <table width="100%" class="form-table">
 <tr>

 <td width="25%"><p>Date of Birth:</p></td>
 <td width="15%" align="center"><b style="float:left;  width:90%; border-bottom:1px solid #333; ; height:15px;">'.$getdob3.'</b>/<br/><p>DD</p></td>
 <td width="15%" align="center"><b style="float:left;  width:90%; border-bottom:1px solid #333;  height:15px;">'.$getdob2.'</b>/<br/><p>MM</p></td>
 <td width="15%" align="center"><b style="float:left;  width:90%; border-bottom:1px solid #333; height:15px;">'.$getdob1.'</b><br/><p>YEAR</p></td>
 <td width="30%"></td></tr>
  </table>
  </td>
  
  <td width="5%"></td>  
  <td valign="top"><h4 class="heading3 center" style="margin-bottom:10px; ">PROGRAM OF INTEREST</h4>
  <p class="prog-list" style="padding-top:30px;">  
  '.$pn.'
  </p> 
 </td>  
  </tr></table>
  

  <table width="100%" class="form-table"><tr><td valign="top">
<h4 class="heading3 center">AGENT INFORMATION</h4>
<p>Do you want all your communication be sent to your agent?</p>
<table width="100%" class="form-table">
<tr>
<td><img src="../../images/tick.png" width="10"> Yes</td>
<td><img src="../../images/box.png" width="10"> No</td>
<td><img src="../../images/box.png" width="10"> Not applicable</td>
</tr>
</table>
<br><table width="90%" class="form-table">
<!--tr> 
<td width="45%"><p> Company/Agent Name:</p></td>
<td><b style="float:left; width:100%; border-bottom:1px solid #333; height:15px;"></b></td>
</tr-->
</table>
</td>
  <td width="5%"></td><td valign="top"> <h4 class="heading3 center">INTAKE</h4>
  <p style="text-align:center;">'.$tk.'</p></td>
</tr>
</table>    
 <p style="margin-top:10px; font-size:14px;">
 Is English your first language? 
 <img src="../../images/box.png" width="10"> Yes 
 <img src="../../images/box.png" width="10"> No &nbsp; 
 <b> If NO,</b> have you taken any English tests (IELTS/ TOEFL) 
 <img src="../../images/box.png" width="10"> Yes 
 <img src="../../images/box.png" width="10"> No</p>
 <br>
  <table width="100%" class="form-table">
 <tr>
<td width="22%"><p>Signature of Applicant:</p></td>
<td width="45%"><b style="float:left; width:96%; border-bottom:1px solid #333; height:20px;"></b></td>
<td width="7%"><p style="float:left;margin-top:5;">Date:</p></td>
<td width="25%"><b style="float:left; width:100%; border-bottom:1px solid #333; height:20px;"></b></td></tr> 
  </table>
 <footer1>
 <table><tr><td><b>For more information, please contact:</b></td>
 <td><b>Tel. No.: 416-969-8845 Fax: 416-969-9372</b></td></tr>
 <tr><td>Academy of Learning College</td>
 <td><b>Website: www.aoltoronto.com</b></td></tr>
 <tr><td>401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4</td>
 <td><b>Email:</b> <b style="color:#666;">info@aoltoronto.com</b></td></tr></table>

</footer>
';
$output .= '</div>';

$output .= '<div class="firstrow">	
<img src="../../images/academy_of_learning_logo.png" class="logo">
<br><br><br>
<h4 id="heading">'.$ConditionalDiv.' Offer Letter</h4><br>
<div class="offer-let">
<p>'.$getdate.'<br>
'.$fname.' '.$lname.'<br>
DOB: '.$getdob.'<br>
Student Address: <span style="text-transform:uppercase;"> '.$address1.', '.$address2.$city.', '.$state.', '.$pincode.', '.$country.'</span>
</p>
<p><b>Regarding:</b>
Application for <span> '.$program_name.' Program</p>
<p>Dear '.$fname.' '.$lname.',</p>
<p>
Congratulations! Based on the assessment of your application, we are pleased to offer you the following program at our college. Please see the program details below.</p>
</div>
<table width="100%" class="table1">
 <tr>
  <td><b>Campus Location</b></td>
  <td><span style="text-transform:uppercase;"> 401 Bay Street, Suite 1000, Toronto, 10th Floor, On M5H 2Y4</span></td>
 </tr>
 <tr>
  <td><b>Program Name</b></td>
  <td><span style="text-transform:uppercase;"> '.$program_name.'</span></td>
 </tr>
 <tr>
  <td><b>Level of Study</b></td>
  <td>Diploma</td>
 </tr>
 <tr>
  <td><b>Academic Status</b></td>
  <td>Full Time</td>
 </tr>	
 <tr>
  <td><b>Program Duration</b></td>
  <td>'.$hours.'</td>
 </tr>
 <tr>
  <td><b>Starting Date</b></td>
  <td>'.$commenc_date.'</td>
 </tr>
 <tr>
  <td><b>Expected Completion Date</b></td>
  <td>'.$expected_date.'</td>
 </tr>
  <tr>
  <td><b>Class Timings</b></td>
  <td>To be Advised</td>
  </tr> 
 
 <tr>
  <td><b>Tuition Fee</b></td>
  <td>'.$total_tuition.'</td>
  </tr> 
 <tr>
  <td><b>Material fee (Books Fee and Other Fee in addition to tuition fee)</b></td>
  <td>'.$otherandbook.'</td>
 </tr>
</table>
<h4><b>Conditions:</b></h4>
<ul class="condition-list">
<li>Payment of 1st year tuition fee deposit.</li>
<li> IELTS 6.0 overall no individual band under 6.0 in each module (please ignore this condition if you already submitted)
</li>
<li> Copy of all transcripts for highest level of education (please ignore this condition if you
already submitted)
</li>
</ul>
<h4><b>Bank Account Details:</b></h4>

<table width="100%" border="1" class="bank-table">
 <tr>
  <td>Business Name, Address: </td>
  <td>ACADEMY OF LEARNING CAREER AND BUSINESS COLLEGE - CUMBERLAND, 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4</td>
 </tr>
 <tr>
  <td>Branch Name:</td>
  <td>Royal Bank of Canada</td>
 </tr>
 <tr>
  <td>Bank Address:</td>
  <td>2 Bloor St. E. Toronto Ontario M4W 1A8</td>
 </tr>
 <tr>
  <td>Bank Tel:</td>
  <td>+1-416-974-2746</td>
 </tr>
	
	<tr>
  <td>Bank Code:</td>
  <td>003</td>
 </tr>	
	<tr>
  <td>Bank Swift Code:</td>
  <td>ROYCCAT2</td>
 </tr>
		<tr>
  <td>Account Number</td>
  <td>067021077510</td>
 </tr>
</table>';
$output .= '</div>';

$output .= '<div class="firstrow">	
<img src="../../images/academy_of_learning_logo.png" class="logo"><br><br><br>
	<br><p>Academy of Learning College is registered by the Ministry of Advanced Education and Skills Development and listed on Service Toronto as a PCC in good standing and is a Designated Learning Institution (DLI#O19859544417)<br>
	The Private Career Colleges Act governs Academy of Learning College for the purpose of tuition fee retention. Tuition fees are tax deductible, and tuition receipts will be issued for each taxation year (T2202A).<br>
	
	</p>
<p><b> <span style="color:red;">Please note</span> that this letter is not to be used for Study Permit Application Purpose and you will be required to have health insurance coverage for the complete time period of study in the college. You need to buy the health insurance before you come for enrolment.</b><br><br>

I confirm and certify that neither the College nor my Consultant’s staff has guaranteed or advised me about being eligible for applying to the Post Graduate Work Permit (PGWP) as per the guidelines by Immigration, Refugees and Citizenship Canada (IRCC) are completing my program at Academy of Learning College - Toronto. I understand that international students can obtain Post Graduate Work Permit (PGWP) only upon completion of a diploma or a degree at a eligible Post-Secondary institution in Canada and therefore I understand that I may be eligible for the post graduate work permit, if and only when I transfer to and complete my program at any of Academy of Learning College - Toronto partner public postsecondary institution or a private degree granting institution as per the policy and PGWP regulations of IRCC.<br><br>
I affirm that I won’t be influenced by the suggestions given to change the college once I arrive in Canada as studying at Academy of Learning College - Toronto is my first preference and I have no intentions of changing my priority and canceling my registration for the reasons of moving to be with my relatives or friends in Canada, change of intent or other reasons not specified here. I recognize that such behavior shall be considered fraudulent application or misrepresentation for a study permit. I authorize that such information be released to Canada Border Services Agency for the purposes of investigation into potenal visa fraud or money laundering. I also confirm and understand that the Refund Policy is dictated by PTIB and is as detailed on the PTIB website.
<br><br>

<p>
<p><b>You should read the information Carefully before accepting your offer and entering into a written agreement with AOLCC.</b></p>

<p>Academy of Learning College reserves all the rights to cancel the admission at any point of time if any misrepresentation of facts or documents is found.<p>
<p>Please Contact me if you have any questions or require additional information.</p><br><br>
<p>Sincerely</p>

<span class="signature"><img src="../../images/Sig_Cham.png" width="150">
<table width="200" class="form-table1" >
 <tr>
  
  <td><span class="stu-name"><b></b>
<br><span class="line2">______________________________</span><br> <span style=" font-size:12px;">Student Signature</span></span></td>
  <td><span class="stu-name"><b style="text-transform:uppercase;"></b>
<br><span class="line2">______________</span><br> <span style=" font-size:12px;">Date</span></span></td>
 </tr></table>

</span>
<p style="width:100%;"><b> Chamara Perera</b><br>Academy of Learning College <br>Regional Director</p>
<div class="footer">
<hr><p style="text-align:center;">Academy of Learning College  - 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4<br> Tel: 1-416-969-8845 | Fax : 1-416-969-9372 | www.aoltoronto.com <p></div>
';
$output .= '</div>';


$document->loadHtml($output);

//set page size and orientation

$document->setPaper('A4', 'potrait');

//Render the HTML as PDF

$document->render();

if(!empty($offer_letter)){
	unlink("../../uploads/offer_letter/$offer_letter");
}

$firstname = str_replace(' ', '', $fname);

$olname = 'Offer_Letter_'.$firstname.'_'.$refid;

$filepath = "../../uploads/offer_letter/$olname.pdf";

file_put_contents($filepath, $document->output());

if($ol_type !== ''){
if($ol_type == 'Revised'){
	$both_datetime = ", `ol_revised_date`='$col_updated'";
}
if($ol_type == 'Defer'){
	$both_datetime = ", `ol_defer_date`='$col_updated'";
}
}else{
	$both_datetime = '';
}


mysqli_query($con, "update `st_application` set `offer_letter`='$filepath', `ol_type`='$ol_type', `ol_type_remarks`='$ol_type_remarks', ol_processing='$ol_processing' $olCondPal $both_datetime where `sno`='$snoid'");

//Get output of generated pdf in Browser
//$olname = 'Offer_Letter_'.$fname.'_'.$refid;
$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview


?>