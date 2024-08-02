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
$program = $rowstr['program'];
if($program == 'PC Support Specialist Toronto'){
	$program_Lists = 'PC Support Specialist';
}else{
	$program_Lists = $program;
}
$campus = $rowstr['campus'];
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
$fullname = $fname.' '.$lname;
$student_no = $rowstr['student_no'];
$fund_info = $rowstr['fund_info'];
$self_funded = $rowstr['self_funded'];
$fund_info_other = $rowstr['fund_info_other'];
$funding_planner_name = $rowstr['funding_planner_name'];
$bursary_award = $rowstr['bursary_award'];

$week1 = $rowstr['week1'];

$student_type = $rowstr['student_type'];
if($student_type == 'International'){
	$int_vid = '-'.$rowstr['int_vid'];
}else{
	$int_vid = '';
}

if($fund_info == 'OSAP'){
	$osapDiv = '<img src="../images/radio-checked.jpg" width="11">';
}else{
	$osapDiv = '<img src="../images/radio.jpg" width="11">';
}

if($fund_info == 'Second Career'){
	$SecondCareerDiv = '<img src="../images/radio-checked.jpg" width="11">';
}else{
	$SecondCareerDiv = '<img src="../images/radio.jpg" width="11">';
}

if($fund_info == 'Self-Funded'){
	$SelfFundedDiv = '<img src="../images/radio-checked.jpg" width="11">';
}else{
	$SelfFundedDiv = '<img src="../images/radio.jpg" width="11">';
}

if($fund_info == 'Third Party Funded'){
	$ThirdPartyFundedDiv = '<img src="../images/radio-checked.jpg" width="11">';
}else{
	$ThirdPartyFundedDiv = '<img src="../images/radio.jpg" width="11">';
}

if($fund_info == 'Other'){
	$fund_info_otherDiv = $fund_info_other;
	$otherDiv = '<img src="../images/radio-checked.jpg" width="11">';
}else{
	$fund_info_otherDiv = '';
	$otherDiv = '<img src="../images/radio.jpg" width="11">';
}

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
$total_fees = number_format((float)$total_fees2, 2, '.', '');

$start_date2 = $rowstr['start_date'];
$start_date = date("d M, Y", strtotime($start_date2));

$finish_date_mid2 = $rowstr['finish_date_mid'];
$finish_date_mid = date("d M, Y", strtotime($finish_date_mid2));

$midpoint_date2 = $rowstr['start_date_mid'];
$midpoint_date = date("d M, Y", strtotime($midpoint_date2));

$resultsStr2 = "SELECT sno, sign_doc FROM `funding_planner_name` where name='$funding_planner_name'";
$get_query2 = mysqli_query($con, $resultsStr2);
$rowstr2 = mysqli_fetch_assoc($get_query2);
$sign_doc2 = $rowstr2['sign_doc'];
if(!empty($sign_doc2)){
	$fpnDiv = '<img src="Rep_Sign/'.$sign_doc2.'" height="30">';
}else{
	$fpnDiv = '';
}

$cpl5 = $rowstr['cpl'];
$ppp_gen = $rowstr['ppp_gen'];
$due_date_fees1 = $rowstr['due_date_fees1'];
$due_date_fees2 = $rowstr['due_date_fees2'];
$contract_send_date = $rowstr['contract_send_date'];

$contract_student_signature = $rowstr['contract_student_signature'];
$getSignature = '../Student_Sign/'.$contract_student_signature;

if($campus == 'Toronto'){
	$campusAddress = ' Academy of Learning,
401 Bay Street, Suite 1000, Toronto, ON M5H 2Y4, Phone number: (416) 969-8845, www.aoltoronto.com';
 $campusName = 'Academy of Learning College – Bay Street';
}

if($campus == 'Hamilton'){
	$campusAddress = 'Academy of Learning,
401 Main Street East Hamilton, ON L8N 1J7, Phone number: (905) 777-8553, www.aolhamilton.com';
 $campusName = 'Academy of Learning College – Hamilton';
}

if($campus == 'Brampton'){
	$campusAddress = 'Academy of Learning
8740 The Gore Road Brampton, ON L6P 0B1, Phone number: (905) 508-5791, www.aolbrampton.ca';
 $campusName = 'Academy of Learning College – Brampton';
}

if($campus == ''){
	$campusAddress = '&nbsp;Campus Address';
}

$worker_id = $rowstr['worker_id'];
$agnt_qryFos = mysqli_query($con,"SELECT name FROM ulogin where name!='' AND sno='$worker_id'");
if(mysqli_num_rows($agnt_qryFos)){
	$row_agnt_qryFos = mysqli_fetch_assoc($agnt_qryFos);
	$loggedName = $row_agnt_qryFos['name'];
}else{
	$loggedName = 'N/A';
}

/////////////New Table///////////////
$resultsStr3 = "SELECT sno, ppp_form_id, pp_sign FROM `ppp_form_more` where ppp_form_id='$snoid'";
$get_query3 = mysqli_query($con, $resultsStr3);
if(mysqli_num_rows($get_query3)){
	$rowstr3 = mysqli_fetch_assoc($get_query3);
	$pp_sign = $rowstr3['pp_sign'];
}else{
	$pp_sign = '';	
}
///////////////////////////////////////

$output = "<style>
 .header { position: fixed; top: 10px;width:100%;  padding:0px 0px 25px;height:100px; display: block;  }
   footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 0px 0px;height:30px; border-top:2px solid #333;}
    h3{ margin-top:0px;}
footer p { text-align:center;}
main { position:relative;width:100%; }
   .page {width:100%;   font-size:13.5px;  margin-top:100px; margin-bottom:0px; padding:0px 0px 0px; page-break-after: always; position:relative;line-height:17px; }
      .page:last-child {page-break-after:never;}
 @page { margin:0px 40px 50px; font-weight:599;width:100%;  color:#333; font-size:14px; }
.float-left { float:left;}
.float-right { float:right;}
.heading-txt { width:100%;}
.pagenum:before { content: counter(page); }
.pagenum { float:right;margin-bottom:20px;}
.table-bordered  { border-collapse:collapse; margin:5px 0px;}
.table-bordered td { border:1px solid #666; padding:4px 2px;vertical-align:top;}
  .border-bottom { border-bottom:1px solid #333; min-height:50px ;}
  .border-bottom-dotted{ border-bottom:1px dotted #333; min-height:50px ;}
  </style>";

$output .= '
<div class="header"> 
<table width="100%">
<tr><td align="left">  
<!--span style="font-size:11px; ">DocuSign Envelope ID: A81D2BFF-4624-4059-BE78-16A568EB5BB4</span-->
<br></td></tr>
<tr><td align="center">  
<img src="../aol-pdf/images/academy_of_learning_logo.jpg" width="170" style="margin-right:30px;" />
</td></tr></table> 
</div>
<footer>
<table width="100%" >
<tr>
<td style="padding:0px; font-size:12px; text-align:center" width="80%">'.$campusAddress.'</td>
<td align="right" width="20%">
APPENDIX 1</td>
</tr>
</table>
</footer>

<main class="page"> 
<table width="100%" style="margin-bottom:0px;margin-top:0px; line-height:25px;"><tr><td align="center"><h3 class="text-center"><u>APPENDIX 1: PAYMENT SCHEDULE</u></h3></td>
</tr>
</table>

<table class="sign_table">
<tr><td width="80" align="left" style="border:0px;"><b>Program`s Name</b></td>
<td width="220" style="border-bottom:1px solid #333 !important;  padding-left:5px;vertical-align:bottom;  float:left;" colspan="2">'.$program_Lists.'&nbsp;</td></tr>
</table>

<table class="sign_table">
<tr>
<td width="65" align="left" style="border:0px;"><b>Student Name</b></td>
<td width="235" style="border-bottom:1px solid #333 !important;  padding-left:5px;vertical-align:bottom;  float:left;" colspan="2">'.$fullname.'&nbsp;</td>
<td width="35">&nbsp; &nbsp;</td>
<td width="50" align="left" style="border:0px;"><b>Student #:</b></td>
<td width="120" style="border-bottom:1px solid #333 !important;  padding-left:5px;vertical-align:bottom;  float:left;" colspan="2">'.$student_no.''.$int_vid.'&nbsp;</td>
</tr>
<tr>
<td width="65" align="left" style="border:0px;"></td>
<td width="235" style=" padding-left:5px;vertical-align:top;padding-top:0px !important; float:left;" colspan="2"><span style="font-size:11px; margin-top:0px !important; ">First name / Middle name / Last name</span></td>
<td width="35">&nbsp; &nbsp;</td>
<td width="50" align="left" style="border:0px;"></td>
<td width="120" style="" colspan="2">&nbsp;</td>
</tr>
</table>
<table class="sign_table">
<tr><td width="80" align="left" style="border:0px;"><b>Admission Advisor Name</b></td>
<td width="188" style="border-bottom:1px solid #333 !important;  padding-left:5px;vertical-align:bottom;  float:left;" colspan="2">'.$loggedName.'&nbsp;</td></tr>
</table>
<table class="sign_table" width="100%">
<tr>
<td align="left" style="border:0px;"><b>
'.$osapDiv.' * OSAP (if eligible)  &nbsp;  &nbsp;
'.$SecondCareerDiv.' Second Career  &nbsp;  &nbsp;
'.$SelfFundedDiv.' &nbsp; Self-Funded   &nbsp;  &nbsp;
'.$ThirdPartyFundedDiv.'  Third Party  &nbsp; &nbsp;
'.$otherDiv.' Other  &nbsp; &nbsp;</b>
</td>
<td width="130" style="border-bottom:1px solid #333 !important;  padding-left:0px;vertical-align:bottom;  float:left;" >'.$fund_info_otherDiv.'&nbsp;</td></tr>
</table>
<p style="font-size:13px;"><i>* Note: Dates and Disbursement amounts are estimates and are subject to change based on final OSAP eligibility. </i></p>
<table class="sign_table" width="100%">
<tr><td align="center" style="border:0px;"><b>PAYMENT SCHEDULE</b></td></table>

<table class="table-bordered" width="100%">
<tr><td bgcolor="#eee" align="center" colspan="7">For Office Use Only</td></tr>
<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center"><b>Total</b></td>
<td align="center"><b> Uniform/Prof. Exam fees</b> </td>
<td align="center"><b>Books **</b></td>
<td align="center"><b>Compulsory fees</b></td>
<td align="center"><b>Tuition fees</b></td>
<td bgcolor="#eee" align="center" rowspan="2"><b>Invoice code</b></td>
';

if($no_fees == 'Yes'){
	$output .= '
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;0.00</b></td>
<td align="center"> <b>$ &nbsp;0.00</b></td>
<td align="center"><b>$ &nbsp;0.00</b></td>
<td align="center"><b>$ &nbsp;0.00</b></td>
<td align="center"><b>$ &nbsp;0.00</b></td>
</tr>
<tr>
<td align="center"><b>&nbsp;</b></td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
</tr>
<tr>
<td align="center"><b>&nbsp;</b></td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
</tr>
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;0.00</b></td>
<td align="center"> <b>$ &nbsp;0.00</b></td>
<td align="center"><b>$ &nbsp;0.00</b></td>
<td align="center"><b>$ &nbsp;0.00</b></td>
<td align="center"><b>$ &nbsp;0.00</b></td>
<td align="center"><b>&nbsp;</td>
</tr>';
	
}else{

if(!empty($cpl5)){

$frstQry = "SELECT * FROM `cpls` WHERE `ppp_form_id`='$snoid' ORDER BY sno ASC LIMIT 1";
$rsltFirst = mysqli_query($con, $frstQry);
if(mysqli_num_rows($rsltFirst)){
	$rowFrst = mysqli_fetch_assoc($rsltFirst);
	$total = $rowFrst['total'];
	$upef = $rowFrst['upef'];
	$book = $rowFrst['book'];
	$cf = $rowFrst['cf'];
	$tfee = $rowFrst['tfee'];
}else{
	$total = '';
	$upef = '';
	$book = '';
	$cf = '';
	$tfee = '';
}	
	$output .= '</tr>
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total.'</b></td>
<td align="center"> <b>$ &nbsp;'.$upef.'</b></td>
<td align="center"><b>$ &nbsp;'.$book.'</b></td>
<td align="center"><b>$ '.$cf.'</b></td>
<td align="center"><b>'.$tfee.'</b></td>

</tr>
<tr>
<td align="center"><b>Due date</b></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
</tr>';

$frstQry2 = "SELECT * FROM `cpls` WHERE `ppp_form_id`='$snoid' ORDER by sno ASC LIMIT 1, 9";
$rsltFirst2 = mysqli_query($con, $frstQry2);
while($rowFrst2 = mysqli_fetch_assoc($rsltFirst2)){
	$due_date2 = $rowFrst2['due_date'];
	$total2 = $rowFrst2['total'];
	$upef2 = $rowFrst2['upef'];
	$book2 = $rowFrst2['book'];
	$cf2 = $rowFrst2['cf'];
	$tfee2 = $rowFrst2['tfee'];
	$in_code2 = $rowFrst2['in_code'];
	
$output .= '<tr>
<td align="center">&nbsp;'.$due_date2.'</td>
<td bgcolor="#eee" align="center">&nbsp;'.$total2.'</td>
<td bgcolor="#eee" align="center">&nbsp;'.$upef2.'</td>
<td bgcolor="#eee" align="center">&nbsp;'.$book2.'</td>
<td bgcolor="#eee" align="center">&nbsp;'.$cf2.'</td>
<td bgcolor="#eee" align="center">&nbsp;'.$tfee2.'</td>
<td bgcolor="#eee" align="center">&nbsp;'.$in_code2.'</td>
</tr>';
}

$frstQry3 = "SELECT * FROM `cpls` WHERE `ppp_form_id`='$snoid' ORDER BY sno DESC LIMIT 1";
$rsltFirst3 = mysqli_query($con, $frstQry3);
if(mysqli_num_rows($rsltFirst3)){
	$rowFrst3 = mysqli_fetch_assoc($rsltFirst3);
	$total3 = $rowFrst3['total'];
	$upef3 = $rowFrst3['upef'];
	$book3 = $rowFrst3['book'];
	$cf3 = $rowFrst3['cf'];
	$tfee3 = $rowFrst3['tfee'];
}else{
	$total3 = '';
	$upef3 = '';
	$book3 = '';
	$cf3 = '';
	$tfee3 = '';
}

$output .= '<tr>
<td align="center"><b>Total invoices</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total3.'</b></td>
<td align="center"> <b>$ &nbsp;'.$upef3.'</b></td>
<td align="center"><b>$ &nbsp;'.$book3.'</b></td>
<td align="center"><b>$ '.$cf3.'</b></td>
<td align="center"><b>'.$tfee3.'</b></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
	
}else{
	
if($fund_info == 'OSAP'){
	
	$output .= '</tr>
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>

</tr>
<tr>
<td align="center"><b>Due date</b></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
	
	// $total_fees_StDate = (($total_fees*60)/100);
	
	$tuition_fees_StDate = (($tuition_fees*60)/100);
	$tuition_fees_StDate2 = (($tuition_fees*40)/100);
	
	$total_fees_StDate = $uniforms_fees+$book_fees+$compulsory_fees+$tuition_fees_StDate;
	
	// $tuition_fees_StDate_plus = $book_fees+$compulsory_fees;
	// $tuition_fees_StDate = $total_fees_StDate-$tuition_fees_StDate_plus;	
	
	// $total_fees_MidDate = (($total_fees*40)/100);
	$total_fees_MidDate = $total_fees-$total_fees_StDate;
	
	$start_date3 = strtotime($finish_date_mid2);
	$midpoint_dateNext = date('d M, Y', strtotime($finish_date_mid2));
	
$output .= '
<tr>
<td align="center">'.$start_date.'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$total_fees_StDate, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.$uniforms_fees.'</td>
<td bgcolor="#eee" align="center">'.$book_fees.'</td>
<td bgcolor="#eee" align="center">'.$compulsory_fees.'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$tuition_fees_StDate, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">B1,C2,T3</td>
</tr>
<tr>
<td align="center">'.$midpoint_dateNext.'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$total_fees_MidDate, 2, '.', '').'</td>
<td align="center">0.00</td>
<td align="center">0.00</td>
<td align="center">0.00</td>
<td align="center">'.number_format((float)$tuition_fees_StDate2, 2, '.', '').'</td>
<td align="center">T4</td>
</tr>
<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>
<tr>
<td align="center"><b>Total invoices</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
}

/// Second Career ///
if($fund_info == 'Second Career'){
	
	$output .= '</tr>
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>

</tr>
<tr>
<td align="center"><b>Due date</b></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
	
	$qury_99 = "SELECT * FROM financial_aid_officers WHERE st_id='$snoid' AND name='$fund_info'";
	$result1_99 = mysqli_query($con, $qury_99);
	$total_fees_100 = 0;
	$uniforms_fees_100 = 0;
	$book_fees_100 = 0;
	$compulsory_fees_100 = 0;
	$tuition_fees_100 = 0;
	while($rowstr_99 = mysqli_fetch_array($result1_99)){
		$sno_99 = $rowstr_99['sno'];
		$start_date_99 = $rowstr_99['start_date'];
		$start_date2_99 = date("d M, Y", strtotime($start_date_99));
		
		$total_fees_99 = $rowstr_99['total_fees'];
		$total_fees_100 += $total_fees_99;
		
		$uniforms_fees_99 = $rowstr_99['uniforms_fees'];
		$uniforms_fees_100 += $uniforms_fees_99;
		
		$book_fees_99 = $rowstr_99['book_fees'];
		$book_fees_100 += $book_fees_99;
		
		$compulsory_fees_99 = $rowstr_99['compulsory_fees'];
		$compulsory_fees_100 += $compulsory_fees_99;
		
		$tuition_fees_99 = $rowstr_99['tuition_fees'];
		$tuition_fees_100 += $tuition_fees_99;
		
		$invoice_code_99 = $rowstr_99['invoice_code'];	
	
	$output .= '
<tr>
<td align="center">'.$start_date2_99.'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$total_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$uniforms_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$book_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$compulsory_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$tuition_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$invoice_code_99, 2, '.', '').'</td>
</tr>';
}

$output .= '<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>

<tr>
<td align="center"><b>Total invoices</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.number_format((float)$total_fees_100, 2, '.', '').'</b></td>
<td align="center"> <b>$ &nbsp;'.number_format((float)$uniforms_fees_100, 2, '.', '').'</b></td>
<td align="center"><b>$ &nbsp;'.number_format((float)$book_fees_100, 2, '.', '').'</b></td>
<td align="center"><b>$ '.number_format((float)$compulsory_fees_100, 2, '.', '').'</b></td>
<td align="center"><b>'.number_format((float)$tuition_fees_100, 2, '.', '').'</b></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
}

/// Self-Funded ///
if($fund_info == 'Self-Funded'){
	
	$output .= '</tr>
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>

</tr>
<tr>
<td align="center"><b>Due date</b></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
	
	$week1_7 = $week1*7;
	$getMonth = $week1_7/30;
	$getMonthRound = round($getMonth);
	$oneMinusMonth = $getMonthRound-1;
	
	$firstTotal = $total_fees/$oneMinusMonth;
	$firstTf = $firstTotal-($uniforms_fees+$book_fees+$compulsory_fees);
	
	$output .= '
<tr>
<td align="center">'.$start_date.'</td>
<td bgcolor="#eee" align="center">'.number_format($firstTotal, 2).'</td>
<td bgcolor="#eee" align="center">'.$uniforms_fees.'</td>
<td bgcolor="#eee" align="center">'.$book_fees.'</td>
<td bgcolor="#eee" align="center">'.$compulsory_fees.'</td>
<td bgcolor="#eee" align="center">'.number_format($firstTf, 2).'</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
</tr>';
	
	
	for($i=2;$i<=$oneMinusMonth;$i++){
		$tf = $total_fees/$oneMinusMonth;
		$uff = $uniforms_fees/$oneMinusMonth;
		$bf = $book_fees/$oneMinusMonth;
		$cslyf = $compulsory_fees/$oneMinusMonth;
		$tutf = $tuition_fees/$oneMinusMonth;
		$onemrow = $i-1;

		$start_date_month_year = date('F, Y', strtotime('+'.$onemrow.' month', strtotime(''.$start_date2.'')));

	$output .= '
<tr>
<td align="center">'.$self_funded.' '.$start_date_month_year.'</td>
<td bgcolor="#eee" align="center">'.number_format($tf, 2).'</td>
<td bgcolor="#eee" align="center">0.00</td>
<td bgcolor="#eee" align="center">0.00</td>
<td bgcolor="#eee" align="center">0.00</td>
<td bgcolor="#eee" align="center">'.number_format($tf, 2).'</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
</tr>';
	}
	
$output .= '<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>

<tr>
<td align="center"><b>Total invoices</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
}


/// Third Party Funded ///
if($fund_info == 'Third Party Funded'){
	
	$output .= '</tr>
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>

</tr>
<tr>
<td align="center"><b>Due date</b></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
	
	$qury_99 = "SELECT * FROM financial_aid_officers WHERE st_id='$snoid' AND name='$fund_info'";
	$result1_99 = mysqli_query($con, $qury_99);
	while($rowstr_99 = mysqli_fetch_array($result1_99)){
		$sno_99 = $rowstr_99['sno'];
		$start_date_99 = $rowstr_99['start_date'];
		$start_date2_99 = date("d M, Y", strtotime($start_date_99));
		$total_fees_99 = $rowstr_99['total_fees'];
		$uniforms_fees_99 = $rowstr_99['uniforms_fees'];
		$book_fees_99 = $rowstr_99['book_fees'];
		$compulsory_fees_99 = $rowstr_99['compulsory_fees'];
		$tuition_fees_99 = $rowstr_99['tuition_fees'];	
		$invoice_code_99 = $rowstr_99['invoice_code'];	
	
	$output .= '
<tr>
<td align="center">'.$start_date2_99.'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$total_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$uniforms_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$book_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$compulsory_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$tuition_fees_99, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$invoice_code_99, 2, '.', '').'</td>
</tr>';
}

$output .= '<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>

<tr>
<td align="center"><b>Total invoices</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
}


/// Other ///
if($fund_info == 'Other' && $fund_info_otherDiv == 'WSIB'){
	$output .= '</tr>
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>

</tr>
<tr>
<td align="center"><b>Due date</b></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
	
	$week1_7 = $week1*7;
	$getMonth = $week1_7/30;
	$getMonthRound = round($getMonth);
	$oneMinusMonth = $getMonthRound;
	
	for($i=1;$i<=$oneMinusMonth;$i++){
		$tf = $total_fees/$oneMinusMonth;
		$uff = $uniforms_fees/$oneMinusMonth;
		$bf = $book_fees/$oneMinusMonth;
		$cslyf = $compulsory_fees/$oneMinusMonth;
		$tutf = $tuition_fees/$oneMinusMonth;
		$onemrow = $i-1;

		$start_date_month_year = date('F, Y', strtotime('+'.$onemrow.' month', strtotime(''.$start_date2.'')));
		
		if($i==1){
			$getDayName_StDate = date("d", strtotime($start_date2));
		}else{
			$getDayName_StDate = '1st';
		}

	$output .= '
<tr>
<td align="center">'.$getDayName_StDate.' '.$start_date_month_year.'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$tf, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$uff, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$bf, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$cslyf, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">'.number_format((float)$tutf, 2, '.', '').'</td>
<td bgcolor="#eee" align="center">&nbsp;</td>
</tr>';
	}
	
$output .= '<tr>
<td align="center"></td>
<td bgcolor="#eee" align="center">- </td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
<td align="center"></td>
</tr>

<tr>
<td align="center"><b>Total invoices</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
}

/// Other ///
if($fund_info == 'Other' && $fund_info_otherDiv == 'PSW Challenge Fund'){
	$output .= '</tr>
<tr>
<td align="center"><b>Contract value</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>

</tr>
<tr>
<td align="center"><b>Due date</b></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
<td bgcolor="#eee" align="center"></td>
</tr>';

	$tuition_fees_StDate = (($tuition_fees*60)/100);	
	$total_fees_StDate = $uniforms_fees+$book_fees+$compulsory_fees+$tuition_fees;
	
$output .= '<tr>
<td align="center">'.$start_date.'</td>
<td bgcolor="#eee" align="center">'.$total_fees.'</td>
<td bgcolor="#eee" align="center">'.$uniforms_fees.'</td>
<td bgcolor="#eee" align="center">'.$book_fees.'</td>
<td bgcolor="#eee" align="center">'.$compulsory_fees.'</td>
<td bgcolor="#eee" align="center">'.$tuition_fees.'</td>
<td bgcolor="#eee" align="center"></td>
</tr>';

	$output .= '<tr>
<td align="center"><b>Total invoices</b></td>
<td bgcolor="#eee" align="center"><b>$ &nbsp;'.$total_fees.'</b></td>
<td align="center"> <b>$ &nbsp;'.$uniforms_fees.'</b></td>
<td align="center"><b>$ &nbsp;'.$book_fees.'</b></td>
<td align="center"><b>$ '.$compulsory_fees.'</b></td>
<td align="center"><b>'.$tuition_fees.'</b></td>
<td bgcolor="#eee" align="center"></td>
</tr>';
}

}

}

// die;

$output .= '</table>
<p><span style="font-size:13px;"><i>** Note: Estimated amount only. Actual cost may vary based on the prevailing market price at the time of book purchase</i></span><br><br>
Payments must be made on or before the scheduled dates or a Late Fee Charge of $25.00 will be applied.<br>
Students paying through installments are required to issue post-dated cheques and/or provide credit card number to the Student Financial Aid Office.<br>
Cheques returned by the bank for any reason are subject to an additional Administration Fee of $30.00.<br>
Late Payment Fee - $25.00 &nbsp;  &nbsp;  &nbsp; NSF Fee - $30.00<br><br>
<b>The undersigned student hereby undertakes and agrees to pay, or see to payment of, the fees indicated above in accordance with the terms of this
Enrolment Contract.</b></p>


<table class="sign_table">
<tr>
<td width="145" style="border-bottom:1px solid #333 !important;  padding-left:5px;vertical-align:bottom;  float:left;" >'.$fullname.'&nbsp;</td>
<td width="35">&nbsp; &nbsp;</td>
<td width="140" style="border-bottom:1px solid #333 !important;  padding-left:5px;vertical-align:bottom;  float:left;" ><img src="'.$getSignature.'" width="100" height="30">&nbsp;</td>
<td width="35">&nbsp; &nbsp;</td>
<td width="140" style="border-bottom:1px solid #333 !important;padding-left:5px;vertical-align:bottom; float:left;" >'.$contract_send_date.'&nbsp;</td>
</tr>
<tr>
<td style="padding-left:5px;vertical-align:top;padding-top:0px !important; float:left;"><span style="font-size:11px; margin-top:0px !important; ">Name: Student</span></td>
<td>&nbsp; &nbsp;</td>
<td align="left" style="padding-left:5px;vertical-align:top;padding-top:0px !important; float:left;">Signature: Student </td><td width="35">&nbsp; &nbsp;</td>
<td style=" padding-left:5px;vertical-align:top;padding-top:0px !important; float:left;" colspan="2">Date</td>
</tr>
</table>
<table class="sign_table">
<tr>
<td width="145" style="border-bottom:1px solid #333 !important;  padding-left:5px;vertical-align:bottom;  float:left;" >'.$funding_planner_name.'&nbsp;</td>
<td width="35">&nbsp; &nbsp;</td>
<td width="140" style="border-bottom:1px solid #333 !important;  padding-left:5px;vertical-align:bottom;float:left;">'.$fpnDiv.'&nbsp;</td>
<td width="35">&nbsp; &nbsp;</td>
<td width="140" style="border-bottom:1px solid #333 !important;padding-left:5px;vertical-align:bottom;float:left;">'.$contract_send_date.'&nbsp;</td>
</tr>
<tr>
<td style=" padding-left:5px;vertical-align:top;padding-top:0px !important; float:left;"><span style="font-size:11px; margin-top:0px !important; ">Name: Financial Planner</span></td>
<td >&nbsp; &nbsp;</td>
<td align="left" style=" padding-left:5px;vertical-align:top;padding-top:0px !important; float:left;">Signature: Financial Planner </td>
<td width="35">&nbsp; &nbsp;</td>
<td style=" padding-left:5px;vertical-align:top;padding-top:0px !important; float:left;" colspan="2">Date</td>
</tr>
</table>
</main>
';


$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($pp_sign)){
	unlink("uploads/$pp_sign");
}

$vnum = str_replace(' ', '', $student_no);
$olname = 'PP_Sign_'.$vnum;
$olname2 = 'PP_Sign_'.$vnum.'.pdf';
$filepath = "uploads/$olname.pdf";
file_put_contents($filepath, $document->output());

if(mysqli_num_rows($get_query3)){
	$getUpdate = "update `ppp_form_more` set `pp_sign`='$olname2', `pp_sign_datetime`='$ppp_datetime' where `ppp_form_id`='$snoid'";
	mysqli_query($con, $getUpdate);
}else{
	$getInsert = "INSERT INTO `ppp_form_more` (`ppp_form_id`, `pp_sign`, `pp_sign_datetime`) VALUES ('$snoid', '$olname2', '$ppp_datetime')";
	mysqli_query($con, $getInsert);
}

if(!empty($_POST['snoidbknd']) && !empty($_POST['docBackend'])){
	$document->stream("$olname2", array("Attachment"=>1));
	// 1  = Download
	// 0 = Preview
}else{
	
if($bursary_award == 'No bursary'){
	$nobrsry = 'pdf_emc.php';
}else{
	$nobrsry = 'pdf_brsry.php';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<link rel="icon" href="../images/top-logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/almuni.css">
    <title>AOLCC - Student Payment Plan Process</title>
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
                <span class="btn float-start btn-success text-center btn_next">Signed Payment Plan Docs</span>
            </div>
			
            <div class="col-12 col-sm-5 py-2">
                <a href="<?php echo $nobrsry ?>?uid=<?php echo $snoid; ?>" class="btn float-sm-end btn-primary text-center btn_next">Continue</a>
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