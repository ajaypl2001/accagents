<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
session_start();
$loggedid = $_SESSION['sno'];
$rsltLogged = mysqli_query($con,"SELECT email,role FROM allusers WHERE sno = '$loggedid'");
$rowLogged = mysqli_fetch_assoc($rsltLogged);
$Loggedemail = mysqli_real_escape_string($con, $rowLogged['email']);
$adminrole1 = mysqli_real_escape_string($con, $rowLogged['role']);

require_once '../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//initialize dompdf class

$document = new Dompdf();

$document->set_option('defaultFont', 'Courier');

$col_updated = date('Y-m-d H:i:s');

$genrate_amount_loa_admin = $_POST['genrate_amount_loa_admin'];
$snoid = $_POST['snoid'];
$campus = $_POST['campus'];
$tk = $_POST['tk'];
$pn = $_POST['pn'];


$str_campus = "SELECT loa_receipt_id_admin FROM st_application where sno='$snoid' AND campus!='' AND loa_receipt_id_admin=''";
$rseult_campus = mysqli_query($con, $str_campus);
if(mysqli_num_rows($rseult_campus)){
	mysqli_query($con, "update `loa_receipt_id` set availablility='', `st_sno`='' where  `st_sno`='$snoid'");
	mysqli_query($con, "update `ham_loa_receipt_id` set availablility='', `st_sno`='' where  `st_sno`='$snoid'");
}

if($campus == 'Hamilton'){

$result2 = "SELECT loaid FROM ham_loa_receipt_id where availablility='' ORDER BY loaid ASC limit 1";
$qyaolid = mysqli_query($con, $result2);	
while ($row1 = mysqli_fetch_assoc($qyaolid)){
	$loaid = $row1['loaid'];	
}
 
$querysid = "SELECT loa_receipt_id_admin FROM st_application where sno='$snoid'";
 $rseultst_id = mysqli_query($con, $querysid);	
 while ($rowst_id = mysqli_fetch_assoc($rseultst_id)){
	 $loa_receipt_id = $rowst_id['loa_receipt_id_admin'];
}

if($loa_receipt_id ==''){		
	mysqli_query($con, "update `st_application` set loa_receipt_id_admin='$loaid' where `sno`='$snoid'");
	mysqli_query($con, "update `ham_loa_receipt_id` set availablility='used', `st_sno`='$snoid' where `loaid`='$loaid'");
}
		 
$querysid_2 = "SELECT loa_receipt_id_admin FROM st_application where sno='$snoid'";
$rseultst_id_2 = mysqli_query($con, $querysid_2);	
while ($rowst_id_2 = mysqli_fetch_assoc($rseultst_id_2)){
	$student_id_2 = $rowst_id_2['loa_receipt_id_admin'];
}

}else{
//Toronto
$result2 = "SELECT loaid FROM loa_receipt_id where availablility='' ORDER BY loaid ASC limit 1";
$qyaolid = mysqli_query($con, $result2);	
while ($row1 = mysqli_fetch_assoc($qyaolid)){
	$loaid = $row1['loaid'];	
}
 
$querysid = "SELECT loa_receipt_id_admin FROM st_application where sno='$snoid'";
 $rseultst_id = mysqli_query($con, $querysid);	
 while ($rowst_id = mysqli_fetch_assoc($rseultst_id)){
	 $loa_receipt_id = $rowst_id['loa_receipt_id_admin'];
}

if($loa_receipt_id ==''){		
	mysqli_query($con, "update `st_application` set loa_receipt_id_admin='$loaid' where `sno`='$snoid'");
	mysqli_query($con, "update `loa_receipt_id` set availablility='used', `st_sno`='$snoid' where `loaid`='$loaid'");
}
		 
$querysid_2 = "SELECT loa_receipt_id_admin FROM st_application where sno='$snoid'";
$rseultst_id_2 = mysqli_query($con, $querysid_2);	
while ($rowst_id_2 = mysqli_fetch_assoc($rseultst_id_2)){
	$student_id_2 = $rowst_id_2['loa_receipt_id_admin'];
}
}

$query1 = "SELECT * FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$sno = $rowstr1['sno'];
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$fullname = $fname.' '.$lname;
$refid = $rowstr1['refid'];
$user_id = $rowstr1['user_id'];	
$student_id = $rowstr1['student_id'];
$email_address = $rowstr1['email_address'];
$gender = $rowstr1['gender'];
$dob = $rowstr1['dob'];
$loa_receipt_id_1 = $rowstr1['loa_receipt_id_admin'];
$loa_file_date_updated_by = $rowstr1['loa_file_date_updated_by'];
$loa_file_date_updated_by_1 = date("d/m/Y", strtotime($loa_file_date_updated_by));


$query2 = "SELECT * FROM contract_courses WHERE campus='$campus' AND intake = '$tk' AND  program_name= '$pn'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$week = $rowstr2['week'];
$hours = $rowstr2['hours'];
$commenc_date = $rowstr2['commenc_date'];
$expected_date = $rowstr2['expected_date'];


$output = "<style> @page { margin:2.5rem 40px ;font-family:Arial, Helvetica, sans-serif; color:#333; font-size:15px;}

.file-no, table {border-collapse:collapse; border-color:#ccc;padding:0px; }
p, h3 {color:#333;}
.file-no tr td { color:#333;  font-size:12px;}
.p-10 { padding:6px 10px;}
.no-border-bottom {border-bottom:none !important; border-bottom:0px;}
.h-100 {height:90px;}
.m-0 { margin:0px;}
.mt-3 {margin-top:40px;}
.pl-2 {padding-left:10px;}
.m-1 { margin:8px 0px 2px; }
p a { color:#333;text-decoration:none;}
p a:hover { background:#ffffe6;text-decoration:none;}
</style>";

if($campus == 'Hamilton'){
	$campus_addess = '<td rowspan="4" colspan="2" width="58%" class="pl-2" ><div class="logo1">
<img src="../../images/logo_hamilton.png" width="220" class="logo"></div>
<p class="m-1">PCCID: 101286<br>401 Main Street East, Hamilton, ON L8N 1J7<br>T:905.777.8553 | F:289.426.2734 | <a href="https://aolhamilton.com/" target="blank">www.aolhamilton.com</a></td>';
}else{
	$campus_addess = '<td rowspan="4" colspan="2" width="58%" class="pl-2" ><div class="logo1">
<img src="../../images/academy_of_learning_logo.png" width="220" class="logo"></div>
<p class="m-1">PCCID: 101558<br>401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4<br>T:416.969.8845 | F:416.969.9372 | <a href="https://aoltoronto.com/" target="blank">www.aoltoronto.com</a></td>';
}

$output .= '
<div>
<table class="file-no" border="1" width="100%"> 
<tr>
'.$campus_addess.'
<td class="p-10" style="border-bottom:0px;" width="20%"><h3 class="m-0">Receipt # &nbsp; &nbsp; &nbsp; '.$loa_receipt_id_1.'</h3></td>

<td align="center" class="no-border-bottom" width="20%">OFFICE COPY</td>
  </tr>
  <tr>
<td class="p-10" width="25%">Date</td>
<td class="p-10" width="25%" align="center"><span>'.$loa_file_date_updated_by_1.'</span></td></tr>
<tr>
<td width="25%" class="p-10">RECEIVED BY</td>
<td width="25%" align="center"><span>ADMISSIONS</span></td></tr>
<tr>
<td class="p-10 no-border-bottom"  width="25%">Lily</td>
<td class="p-10 no-border-bottom"  width="25%" align="center">Preet B</td>
</tr>
<tr>
<td width="25%" class="p-10">StudentInformation</td>
<td width="25%" class="p-10" align="center">STUDENT ID</td>
<td width="25%" class="p-10" align="center">STUDENT STATUS</td>
<td width="25%" class="p-10" align="center">1st PAYMENT?</td></tr>
<tr>
<td width="25%" valign="top" rowspan="4" class="p-10">'.$fname.''.$lname.'<br>DOB: '.$dob.'</td>
<td width="25%" class="p-10"  align="center">'.$student_id.'</td>
<td width="25%" class="p-10" align="center">Not Started</td>
<td class="p-10" align="center">______</td></tr>
<tr>
<td class="p-10" align="center">PAYMENT METHOD</td>
<td class="p-10" align="center">FUNDING</td>
<td class="p-10" align="center">START DATE</td></tr>
<tr>
<td class="p-10" align="center">Bank Transfer</td>
<td class="p-10 no-border-bottom" align="center">International</td>
<td class="p-10" align="center">'.$commenc_date.'</td></tr>
<tr>
<td width="25%" class="p-10" align="center">PROGRAM LENGTH</td>
<td width="25%" class="p-10" align="center">CLASS</td>
<td width="25%" class="p-10" align="center">END DATE</td></tr>
<tr>
<td width="25%" class="p-10 no-border-bottom">'.$pn.'</td>
<td width="25%" class="p-10 no-border-bottom" align="center">'.$week.'</td>
<td width="25%" class="p-10 no-border-bottom" align="center">______</td>
<td width="25%" class="p-10 no-border-bottom" align="center">'.$expected_date.'</td></tr>
</table>
<table border="1" width="100%" style="margin-top:-2px;">
<tr bgcolor="#eee">
<td width="25%" class="p-10">Project <br>Item</td>
<td width="35%" class="p-10" align="center">Description</td>
<td width="20%" class="p-10" align="center">Rate</td>
<td width="20%" class="p-10" align="center">Amount</td></tr>
<tr>
<td width="25%" rowspan="2" valign="top" class="p-10">International Student</td>
<td width="35%"  rowspan="2" valign="top"class="p-10">International student fee</td>
<td class="p-10 h-100" valign="top" align="right">$'.$genrate_amount_loa_admin.'.00</td><td class="p-10 h-100" valign="top" align="right">$'.$genrate_amount_loa_admin.'.00</td>
</tr>
<tr>
<td class="p-10"><h3 class="m-0">Total</h3></td>
<td class="p-10"><h3 class="m-0" style="font-weight:normal">$'.$genrate_amount_loa_admin.'.00</h3></td>
</tr>
</table>
</div>
<div CLASS="mt-3">
<table class="file-no" border="1" width="100%">
<tr>
'.$campus_addess.'
<td class="p-10" style="border-bottom:0px;" width="20%"><h3 class="m-0">Receipt #  &nbsp; &nbsp; &nbsp; '.$loa_receipt_id_1.'</h3></td>
<td align="center" class="no-border-bottom" width="20%">STUDENT COPY</td>
  </tr>
  <tr>
<td class="p-10" width="25%">Date</td>
<td class="p-10" width="25%" align="center"><span>'.$loa_file_date_updated_by_1.'</span></td></tr>
<tr>
<td width="25%" class="p-10">RECEIVED BY</td>
<td width="25%" align="center"><span>ADMISSIONS</span></td></tr>
<tr>
<td class="p-10 no-border-bottom"  width="25%">Lily</td>
<td class="p-10 no-border-bottom"  width="25%" align="center">Preet B</td>
</tr>
<tr>
<td width="25%" class="p-10">Student Information</td>
<td width="25%" class="p-10 b" align="center">STUDENT ID</td>
<td width="25%" class="p-10" align="center">STUDENT STATUS</td>
<td width="25%" class="p-10" align="center">1st PAYMENT?</td></tr>
<tr>
<td width="25%" valign="top" rowspan="4" class="p-10">'.$fname.' '.$lname.'<br>DOB: '.$dob.'</td>
<td width="25%" class="p-10"  align="center">'.$student_id.'</td>
<td width="25%" class="p-10" align="center">Not Started</td>
<td class="p-10" align="center">______</td></tr>
<tr>
<td class="p-10" align="center">PAYMENT METHOD</td>
<td class="p-10" align="center">FUNDING</td>
<td class="p-10" align="center">START DATE</td></tr>
<tr>
<td class="p-10" align="center">Bank Transfer</td>
<td class="p-10 no-border-bottom" align="center">International</td>
<td class="p-10" align="center">'.$commenc_date.'</td></tr>
<tr>
<td width="25%" class="p-10" align="center">PROGRAM LENGTH</td>
<td width="25%" class="p-10" align="center">CLASS</td>
<td width="25%" class="p-10" align="center">END DATE</td></tr>
<tr>
<td width="25%" class="p-10 no-border-bottom">'.$pn.'</td>
<td width="25%" class="p-10 no-border-bottom" align="center">'.$week.'</td>
<td width="25%" class="p-10 no-border-bottom" align="center">______</td>
<td width="25%" class="p-10 no-border-bottom" align="center">'.$expected_date.'</td></tr>
</table>
<table border="1" width="100%" style="margin-top:-2px;">
<tr>
<td width="25%" valign="top" class="p-10">Description</td>
<td width="35%"  valign="top"class="p-10">International student fee</td>
<td class="p-10"><h3 class="m-0">Total</h3></td>
<td class="p-10"><h3 class="m-0" style="font-weight:normal">$'.$genrate_amount_loa_admin.'.00</h3></td>
</tr>
</table>
</div>
';


$document->loadHtml($output);

//set page size and orientation

$document->setPaper('A4', 'potrait');

//Render the HTML as PDF

$document->render();

$loa_receipt_file_admin = $rowstr1['loa_receipt_file_admin'];
if($loa_receipt_file_admin !==''){
unlink("$loa_receipt_file_admin");
}

$firstname = str_replace(' ', '', $fname);

$loa_rcpt_name = 'LOA_Receipt_NEW_'.$firstname.'_'.$refid;

$filepath = "../../uploads/$loa_rcpt_name.pdf";

file_put_contents($filepath, $document->output());

mysqli_query($con, "update `st_application` set `loa_receipt_file_admin`='$filepath', `genrate_amount_loa_admin`='$genrate_amount_loa_admin', `genrate_amount_loa_date_admin`='$col_updated' where `sno`='$snoid'");

$document->stream("$loa_rcpt_name", array("Attachment"=>1));
//1  = Download
//0 = Preview


?>