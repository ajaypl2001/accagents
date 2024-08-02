<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

$loggedid = $_SESSION['sno'];
$rsltLogged = mysqli_query($con,"SELECT agent_email, email, role FROM allusers WHERE sno = '$loggedid'");
$rowLogged = mysqli_fetch_assoc($rsltLogged);
$agent_email = mysqli_real_escape_string($con, $rowLogged['agent_email']);
$Loggedemail = mysqli_real_escape_string($con, $rowLogged['email']);
$adminrole1 = mysqli_real_escape_string($con, $rowLogged['role']);
$date_at = date('Y-m-d');
$time_at = date('H:i:s');
$loa_file_date_updated_by = date('Y-m-d H:i:s');
$current_date2 = date("F d, Y");

require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();
// $document->set_option('defaultFont', 'Courier');

$campus = $_POST['campus'];
$tk = $_POST['tk'];
$pn = $_POST['pn'];
$snoid = $_POST['snoid'];
$loa_type = $_POST['loa_type'];
$old_new = $_POST['old_new'];


$query1 = "SELECT * FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$gtitle = $rowstr1['gtitle'];
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$user_id = $rowstr1['user_id'];
$full_name = $fname.' '.$lname;
$refid = $rowstr1['refid'];
$student_id = $rowstr1['student_id'];
$dob = $rowstr1['dob'];
$fh_status = $rowstr1['fh_status'];
$getdob = date("m/ d / y",strtotime($dob)); 
$address1 = $rowstr1['address1'];
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
$prg_intake = $rowstr1['prg_intake'];
$datetime = date('Y-m-d'); 
$loadate = date("F j, Y", strtotime($datetime)); 

$stream1 = $rowstr1['stream1'];
$passing_year1 = $rowstr1['passing_year1'];
$email_address = $rowstr1['email_address'];
$mobile = $rowstr1['mobile'];
$prepaid_fee = $rowstr1['prepaid_fee'];
$prepaid_remarks = $rowstr1['prepaid_remarks'];
$loa_first_genreate_date = $rowstr1['loa_first_generate_date'];
$loa_file_date_updated_by_11 = $rowstr1['loa_file_date_updated_by'];
$loadate_5 = date("Y-m-d", strtotime($loa_file_date_updated_by_11));

if(empty($loa_file_date_updated_by_11)){
	$loa_file_date_updated_by_1 = ",`loa_file_date_updated_by`='$loa_file_date_updated_by'";
	$loadate_1 = date("F j, Y", strtotime($datetime)); 
}else{
	if($loa_type == 'Revised' || $loa_type == 'Defer'){
		if(!empty($_POST['loa_file_select'])){
			$loa_file_select = $_POST['loa_file_select'];
		}else{
			$loa_file_select = $loa_file_date_updated_by;
		}
		$loa_file_date_updated_by_1 = '';
		$loadate_1 = date("F j, Y", strtotime($loa_file_select));
	}else{
		$loa_file_date_updated_by_1 = '';
		$loadate_1 = date("F j, Y", strtotime($loa_file_date_updated_by_11));
	}
}

if(empty($loa_first_genreate_date)){
	$loa_first_genreate_date2 = ",`loa_first_generate_date`='$datetime'";
}else{
	// if(!empty($_POST['loa_file_select'])){
		// $loa_file_select3 = $_POST['loa_file_select'];
	// }else{
		// $loa_file_select3 = $loa_first_genreate_date;
	// }
	
	$loa_first_genreate_date2 = ",`loa_first_generate_date`='$loa_first_genreate_date'";
}

if($prepaid_fee == 'Yes'){
	$prePfee_Yes = '<img src="../../images/tick.png" width="7"> Yes';
}else{
	$prePfee_Yes = '<img src="../../images/box.png" width="7"> Yes';
}
if($prepaid_fee == 'No'){
	$prePfee_No = '<img src="../../images/tick.png" width="7"> No';
}else{
	$prePfee_No = '<img src="../../images/box.png" width="7"> No';
}
if($prepaid_fee == 'Yes'){
	if($prepaid_remarks !== ''){
		$prePfee_Amount = '<tr><td colspan="2">&nbsp;<b>Fees Amount:</b> '.$prepaid_remarks.'</td></tr>';
	}else{
		$prePfee_Amount = '<tr><td colspan="2"></td></tr>';
	}
}else{
	$prePfee_Amount = '<tr><td colspan="2"></td></tr>';
}


$query2 = "SELECT * FROM contract_courses WHERE campus='$campus' AND intake = '$tk' AND  program_name= '$pn'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$commenc_date1 = $rowstr2['commenc_date'];
$cd_comma = date("F j, Y", strtotime($commenc_date1)); 
$program_name = $rowstr2['program_name'];
$expected_date = $rowstr2['expected_date'];
$ed_comma_cmplt = date("F j, Y", strtotime($expected_date)); 
$practicum_start_date2 = $rowstr2['practicum_start_date'];
$practicum_start_date = date("F j, Y", strtotime($practicum_start_date2)); 
$week = $rowstr2['week'];
$tuition_fee = $rowstr2['tuition_fee'];

$hours = $rowstr2['hours'];
$hrs = explode('hrs',$hours);

// if(!empty($prepaid_remarks)){
	// $loa_total_fee = $prepaid_remarks;
// }else{
	//$rowstr2['loa_total_fee'];
// }

$practicum_date = ''; //$rowstr2['practicum_date'];
// list($week) = explode("weeks", $practicum);

// $program_start1 = $rowstr2['program_start1'];
// $program_end1 = $rowstr2['program_end1'];
// $program_start2 = $rowstr2['program_start2'];
// $program_end2 = $rowstr2['program_end2'];
$inter_stud_schlr = $rowstr2['inter_stud_schlr'];

if($pn == 'Diploma in Hospitality Management (With Co-op)'){
	$practicum = '12 weeks (480 hrs)';
	$practicum_wrk = 'Hospitality';
}else{
	$practicum = '';
	$practicum_wrk = '';
}

// if(($program_start1 !=='') && ($program_end1 !=='') && ($program_start2 !=='') && ($program_end2 !=='')){
	// $firstProgram = explode("and", $pn);
	// $frstp = $firstProgram[0];
	// $scndp = $firstProgram[1];
	
	// $ps11 = date("F j, Y", strtotime($program_start1));
	// $pe11 = date("F j, Y", strtotime($program_end1));
	// $ps22 = date("F j, Y", strtotime($program_start2));
	// $pe22 = date("F j, Y", strtotime($program_end2));
	
	// $ps1 = '&lt;'.$ps11.'&gt;';
	// $pe1 = '&lt;'.$pe11.'&gt;';
	// $ps2 = '&lt;'.$ps22.'&gt;';
	// $pe2 = '&lt;'.$pe22.'&gt;';
	// $other_information1 = "The number in bracket, is belong to the 2nd program; *The student is enrolled in two separate programs;";
	// $other_information2 = "*** $frstp starts on $ps1 and ends on $pe1. $scndp starts on $ps2 and ends on $pe2.";
// }else{
	$other_information1 = '';
	$other_information2 = '';
// }
// print_r($other_information);
// die;

//$practicum_week = explode($practicum);

if($tk == 'May-2024' || $tk == 'JAN-2024' || $tk == 'SEP-2023' || $tk == 'SEP-2024'){
	if($old_new == 'Old'){
		$mayBeforediv = '<td style=" width:200px; padding-left:10px; height:20px;">
			<img src="../../images/cross.png" width="10" style="float:left; margin-right:5px;"> 
			<span style="width:80px; float:left;"> Yes Specify:</span>
			<p style="width:80px; margin:0px; height:15px; float:left; border-bottom:1px solid #333;">'.$inter_stud_schlr.'
			</p>
		</td>';
		$mayNoSp = '<img src="../../images/box.png" width="10"> No</td>';
	}else{
		$mayBeforediv = '<td style=" width:200px; padding-left:10px; height:20px;">
			<img src="../../images/box.png" width="10" style="float:left; margin-right:5px;"> 
			<span style="width:80px; float:left;"> Yes Specify:</span>
			<p style="width:80px; margin:0px; height:15px; float:left; border-bottom:1px solid #333;">
			</p>
		</td>';
		$mayNoSp = '<img src="../../images/cross.png" width="10"> No</td>';
	}
}else{
	$mayBeforediv = '<td style=" width:200px; padding-left:10px; height:20px;">
		<img src="../../images/box.png" width="10" style="float:left; margin-right:5px;"> 
		<span style="width:80px; float:left;"> Yes Specify:</span>
		<p style="width:80px; margin:0px; height:15px; float:left; border-bottom:1px solid #333;">
		</p>
	</td>';
	$mayNoSp = '<img src="../../images/cross.png" width="10"> No</td>';
}

if($old_new == 'Old'){
	$loa_total_fee = '$13,500.00';
}else{
	$loa_total_fee = $rowstr2['tf_new'];
}

$rsltLogged3 = mysqli_query($con,"SELECT sno, agent_email FROM allusers WHERE sno='$user_id'");
$rowLogged3 = mysqli_fetch_assoc($rsltLogged3);
$agent_email3 = mysqli_real_escape_string($con, $rowLogged3['agent_email']);

$output = "<style>
@page { margin:10px; padding:2px;  width:100%;}
body { padding: 25px 10px 15px; margin-bottom:30px; width:100%; border: 3PX solid #333; }
.firstrow{width:100%;font-size:11px; font-family:Arial, Helvetica, sans-serif;  page-break-after: always; }
.logo1 .logo{ width:76px;margin-top:-15px;float:right; }
.firstrow #heading{margin-top:5px;margin-top:0px; margin-bottom:0px;width:100%;font-size:15px;font-weight:700;text-align:center;padding:2px 0;}
.logo1 { width:100%; margin-bottom:40px;float:right; }
.date1 { width:310px;float:right; }
table {vertical-align: text-top; width:100%;}
.date1 h6 {margin-top:-20px !important;float:left; width:150px;font-size:12px;}
.date1 p { width:170px; margin-top:-25px; float:right; border-bottom:1px solid #333;}
.heading-p { font-size:12px; margin-bottom:0px; margin-top:0px; }
.heading-p1 {margin-top:70px; margin-bottom:5px;}
.info-table { border-collapse:collapse; border:1px solid #333;width:100%;}
.info-table table { margin:-2px;vertical-align: text-top;} 
.info-table table td { vertical-align: text-top;padding:0px 0px;max-height:40px;}
.info-table td { padding:0px;vertical-align: text-top;border-color:#333; }
.info-table td strong { margin-left:10px;}
table td b { font-weight:900; color:#000;}
.td-heading { height:15px; width:35px !important; padding:0px;font-size:12px; font-weight:bold; border-right:1px solid #333; text-align:center;  border-bottom:1px solid #333;}
.table-padding td { padding:5px 10px !important;}
.border-left {border-left:1px solid #333;}
.sign { margin-top:10px;}
.p-m { margin-top:0px; margin-bottom:5px;}
p.sign-line { width:355px; height:55px; padding-left:15px; margin-bottom:0px; border-bottom:1px solid #333; }
p.sign-line1 { width:335px; height:15px;  padding-left:30px;border-bottom:1px solid #333; margin:0px;}
.footer p { color:#854053; font-size:13px; text-align:center; width:100%; margin:-40px 0px 0px 50px;}
.footer {  margin-top:-40px;}
.loa1 p { font-size:15px;}
.loa1 .date1 { font-size:16px; margin-top:50px; margin-bottom:20px;}
.loa1 .date1 h3 { text-align:right;}
.loa1 .heading-p { font-size:16px; margin-bottom:0px; margin-top:28px; }
 .footer {
	position: fixed; 
	bottom: 15px; 
	left: 0cm; 
	right: 0cm;width:100%;
	height: 40px;  
 }
 h5 { width:600px:text-align:center; font-size:18px;margin:0px; position:absolute;}
</style>";

if(!empty($practicum_start_date2) && ($pn == 'Diploma in Hospitality Management (With Co-op)')){
	$pyes = '<td style=" padding-left:40px; width:80px;"><img src="../../images/cross.png" width="10"> Yes </td>';
	$pno = '<td style=" padding-left:40px;width:80px;"><img src="../../images/box.png" width="10"> No</td>';
}else{
	$pyes = '<td style=" padding-left:40px; width:80px;"><img src="../../images/box.png" width="10"> Yes </td>';
	$pno = '<td style=" padding-left:40px;width:80px;"><img src="../../images/cross.png" width="10"> No</td>';
}


$output .= '<div class="firstrow">	
<table width="100%" style="margin:0px;">
<tr><td align="center " width="45%">
&nbsp;
</td><td align="center ">
&nbsp;
</td>
<td align="center ">
<h5><u>Letter of Acceptance</u></h5>
</td><td>
<div class="logo1" style="margin-right:-5px; margin-bottom:10px;">
<img src="images/logo.jpg" width="76" class="logo">
</div></td></tr></table>


<h4 class="heading-p heading-p1">Personal Information</h4>
<div class="date1"  style="margin-right:-5px;"><h6>Date (MM/DD/YYYY):</h6><p style="text-align:center; font-size:14px;">'.$loadate_1.'</p></div>
<table width="100%" border="1" class="info-table">
 <tr>
  <td width="250"><table width="100%" height="40" border="0">
 <tr>
  <td class="td-heading">1</td>
  <td><strong>Family Name</strong></td>
 </tr>
 <tr>
 
  <td colspan="2" style=" text-align:center;"><p class="p-m">'.$lname.'</p></td>
  </tr>
</table>
</td>
  <td width="250"><table width="100%"height="40" border="0">
 <tr>
  <td class="td-heading">2</td>
  <td><strong>Given  Name</strong></td>
 </tr>
 <tr>
  <td colspan="2" style=" text-align:center;"><p class="p-m">'.$fname.'</p></td>
  </tr>
</table></td>
 </tr>	
	 <tr>
  <td width="250"><table width="100%" border="0">
 <tr>
  <td class="td-heading">3</td>
  <td><strong>Date of Birth (MM/DD/YYYY)</strong></td>
 </tr>
 <tr>
	<td></td>
  <td colspan="2" style="font-size:13px; padding-left:10px;">'.$getdob.'</td>
  </tr>
</table>
</td>
  <td width="250"><table width="100%" border="0">
 <tr>
  <td class="td-heading">4</td>
  <td><strong>Student Id Number</strong></td>
 </tr>
 <tr>
  <td colspan="2" style=" text-align:center; font-size:10px;">ACC '.$student_id.'</td>
  </tr>
</table></td>
 </tr>
 <tr>
  <td colspan="2" style=" border-bottom:0px;"><table width="100%" border="0">
 <tr>
  <td class="td-heading" valign="top">5</td>
  <td><strong>Certificat d`acceptation du Quebec (CAQ) or Ministere de I1Immigration, Diversite et Inclusion (MIDI) letter</strong></td>
 </tr>
</table></td>
   </tr>
			 <tr>
  <td width="250" style=" border-top:0px;"><table width="100%" border="0">
 <tr> <td width="15%"></td>
  <td><img src="../../images/box.png" width="10"> Yes</td>
  <td><img src="../../images/cross.png" width="10"> No</td>
 </tr>
</table></td
  <td width="250" style=" border-top:0px;"><table width="100%" border="0" class="table-padding">
 <tr>
  <td> CAQ Number:</td>
  <td class="border-left"><span style=" float:left;"> Expiry</span>  <span style="width:50px; float:left;"></span><span style="width:20px;float:left;">/</span><span style="width:20px;float:left;">/</span></td>
 </tr>
</table></td>
 </tr>	
	<tr>
  <td colspan="2"><table width="100%" border="0">
 <tr>
  <td class="td-heading" style=" border-bottom:0px;">6</td>
  <td><strong>Student`s Full Mailing Address</strong></td>
 </tr>
</table></td>
</tr>
			 <tr>
  <td width="250" style=" padding:1px;"><table width="100%" border="1" class=" info-table"  style="border:0px;">
 <tr><td style="border-top:0px; border-left:0px"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;"> &nbsp; P.O.Box</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center;"> '.$address1.'</td>
		</tr></table></td>
  <td style="border-top:0px;border-left:0px;border-right:0px;border-bottom:0px;"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;"> &nbsp; Apt. /Unit</td> </tr><tr> <td></td>
		</tr></table></td>
 </tr>
	<tr> <td width="168" style="border:0px"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;"> &nbsp; City/Town</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center; ">'.$city.'</td>
		</tr></table></td>
<td style="border-right:0px;border-bottom:0px;"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;"> &nbsp; Country</td>  <td></td></tr>
		<tr> <td colspan="2" style=" text-align:center; border-bottom:0px;">'.$country.'</td>
		</tr></table></td></tr></table></td>
  <td width="250" style="padding:1px;"><table width="100%" border="1" class=" info-table" style="border:0px;">
 <tr><td style="border:0px"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;"> &nbsp; Street No.</td> </tr><tr> <td style=" padding-left:20px;">'.$address2.'</td>
		</tr></table></td>
  <td style="border-top:0px;border-right:0px; "><table width="100%" border="0"><tr>
  <td style=" font-size:10px; "> &nbsp;  Street Name</td> </tr><tr> <td>&nbsp;</td>
		</tr></table></td>
 </tr>
	<tr> <td style="border-bottom:0px; border-left:0px"><table width="100%" border="0"><tr>
  <td style="border:0px; font-size:10px;"> &nbsp; Province/Territory</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center; ">'.$state.'</td>
		</tr></table></td>
<td style="border-right:0px;border-bottom:0px;"><table width="100%" border="0"><tr>
  <td  style=" font-size:10px;"> &nbsp; Postal Code</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center;">'.$pincode.'</td>
		</tr></table></td></tr></table></td>
 </tr> 
</table>
<h4 class="heading-p">Institutional Information</h4>
<table width="600" border="1" style="width:600px;" class="info-table">
 <tr>
  <td width="240" ><table width="230" border="0">
 <tr>
  <td class="td-heading">7</td>
  <td><strong>Full Name of Institution</strong></td>
 </tr>
 <tr>
  <td colspan="2" style=" text-align:center; ">Avalon Community College</td>
  </tr>
</table>
</td>
  <td width="280"><table width="100%" border="0">
 <tr>
  <td class="td-heading">8</td>
  <td><strong>Designated Learning Institution Number</strong></td>
 </tr>
 <tr>
  <td colspan="2" style="padding-left:23%"; ">O150186247152</td>
  </tr>
</table></td>
 </tr>
	<tr>
  <td colspan="2"><table width="100%" border="0">
 <tr>
  <td class="td-heading" style=" border-bottom:0px;">9</td>
  <td><strong>Address of Institution</strong></td>
 </tr>	
	</table></td></tr> <tr>
  <td width="250" style=" padding:2px;"><table width="100%" border="1" class=" info-table" style="border-top:0px !important; border-left:0px !important;border-bottom:0px !important; border-right:0px !important;">
 <tr><td style="border-top:0px; border-left:0px; border-right:0px;"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;"> &nbsp; P.O.Box</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center; ">#201</td>
		</tr></table></td>
  <td style="border-top:0px; border-right:0px !important"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;"> &nbsp; Street No. </td> </tr><tr> <td colspan="2" style=" text-align:center; ">155 </td>
		</tr></table></td>
 </tr>
	<tr> <td style="border-bottom:0px;border-left:0px"><table width="100%" border="0"><tr>
  <td width="105" style=" font-size:10px;"> &nbsp; City/Town</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center;  ">Nanaimo</td>
		</tr></table></td>
<td style="border-bottom:0px;border-right:0px;border-left:0px"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;"> &nbsp;  Province/Territory</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center; ">British Columbia</td>
		</tr></table></td></tr></table></td>
  <td width="250" style=" padding-top:2px;border:0px;"><table width="100%" border="0" class=" info-table"style="border-top:0px; border-right:0px;border-bottom:0px;border-left:0px;">
	<tr> <td style="border-top:0px; border-right:0px;border-left:0px;"><table width="100%" border="0"><tr>
  <td style=" font-size:10px;border:0px;"> &nbsp; Street Name</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center;  "> Skinner Street</td>
		</tr></table></td>		</tr>		<tr>
<td style="border-top:1px solid #333;"><table width="100%" border="0"><tr>
  <td  style="border:0px; font-size:10px;"> &nbsp; Postal Code</td>  <td></td></tr><tr> <td colspan="2" style=" text-align:center; ">V9R 5E8</td>
		</tr></table></td></tr></table></td>
 </tr>	
	 <tr>
  <td width="250"><table width="100%" border="0">
 <tr><td width="104"><table width="100%" border="0">
 <tr>
  <td class="td-heading">10</td>
  <td style="font-size:10px;"><strong>Telephone Number</strong></td>
 </tr>
 <tr>
  <td colspan="2" style="Padding-left:10px; font-size:10px;">(416)969-8845</td>
  </tr>
</table>
</td> 
<td width="60"><table width="100%"  border="0">
 <tr>
    <td style="font-size:10px;"><strong>Extension</strong></td>
 </tr> <tr>
    <td class="border-left" style="height:20px;"><strong>-</strong></td>
 </tr></table></td>
<td width="100" class="border-left"><table width="100%" border="0">
 <tr>
  <td class="td-heading">11</td>
  <td style="font-size:10px;"><strong>Fax Number</strong></td>
 </tr>
 <tr>
  <td colspan="2" style="Padding-left:10px;  font-size:10px;"></td>
  </tr>
</table>
</td> </tr>
</table>
</td>
  <td width="50%"><table width="100%" border="0">
 <tr> <td><table width="100%" border="0">
 <tr>
  <td class="td-heading">12</td>
  <td><strong>Type of School/Institution</strong></td>
 </tr>
	</table></td></tr>
  <tr>
  <td><table width="100%" border="0">
 <tr> <td width="15%"></td>
  <td width="20%"><img src="../../images/box.png" width="10"> Public</td>
  <td><img src="../../images/cross.png" width="10"> Private</td>
		 </tr></table>
</td> </tr>
</table>
</td>
 </tr><tr>
  <td width="50%"><table width="100%" border="0">
 <tr>
  <td class="td-heading">13</td>
  <td width="248"><strong>Website</strong></td>
 </tr>
 <tr>
  <td colspan="2" style=" padding-left:20%; "><a href="#www.avaloncommunitycollege.ca" style="color:#000; text-decoration:none; "><p class="p-m">www.avaloncommunitycollege.ca</p></a></td>
  </tr>
</table>
</td>
  <td width="50%"><table width="100%" border="0">
 <tr>
  <td class="td-heading">14</td>
  <td><strong>Email:</strong></td>
 </tr>
 <tr>
	<td width="1"></td>
  <td style="  padding-left:22%; "><p class="p-m">info@avaloncommunitycollege.ca</p></td>
  </tr>
</table></td>
 </tr> 
			<tr>
  <td width="100%" style="  border-right:0px;"><table width="100%" border="0">
 <tr><td width="62%"><table width="100%" border="0">
 <tr>
  <td class="td-heading">15</td>
  <td><strong>Name of Contact</strong></td>
 </tr>
 <tr>
  <td colspan="2" style=" text-align:center;">Chamara Perera</td>
  </tr>
</table>
</td> 
<td><table width="100%"  border="0">
 <tr>
    <td><strong>Position</strong></td>
 </tr> <tr>
    <td class="border-left" style="height:20px;text-align:center;">Regional Director</td>
 </tr></table></td>
</tr>
</table>
</td>
<td width="50%" style="border-left:none !important; border-top:0px;"><table width="100%" border="0">
 <tr>
<td><table width="100%"  border="0">
 <tr>
    <td style=" border-top:0px;"><strong>Telephone Number</strong></td>
 </tr> <tr>
    <td style="padding-left:11px; height:20px; border-left:1px solid #333;">1-250-824-1545</td>
 </tr></table></td>
<td><table width="100%"  border="0">
 <tr>
    <td><strong>Extension</strong></td>
 </tr> <tr>
    <td class="border-left" style="padding-left:31px;height:20px;" valign="bottom">-</td>
 </tr></table></td>
</tr></table></td>
</tr>
			<tr>
  <td width="100%" style="border-right:0px;"><table width="100%" border="0">
 <tr><td width="55%"><table width="100%" border="0">
 <tr>
  <td class="td-heading">16</td>
  <td><strong>Name of Alternate Contact</strong></td>
 </tr>
 <tr>
  <td colspan="2" style=" text-align:center;">Manica Jetley</td>
  </tr>
</table>
</td> 
<td><table width="100%"  border="0">
 <tr>
    <td><strong>Position</strong></td>
 </tr> <tr>
    <td class="border-left" style="height:20px;text-align:center;">International Admissions Manager </td>
 </tr></table></td>
</tr>
</table>
</td>
<td width="50%" style=" border-left:0px;"><table width="100%" border="0">
 <tr>
<td><table width="100%"  border="0">
 <tr>
    <td><strong>Telephone Number after 6pm to 9am</strong></td>
 </tr> <tr>
    <td style="padding-left:11px; height:20px; border-left:1px solid #333;">1-250-824-1545</td>
 </tr></table></td>
<td><table width="100%"  border="0">
 </table></td>
</tr></table></td>
</tr>
</table>
<h4 class="heading-p">Program Information</h4>
<table width="470" border="1" style="width:470px;" class="info-table">
 <tr>
  <td width="260"><table width="100%" border="0">
 <tr>
<td><table width="100%" border="0">
 <tr>
  <td class="td-heading">17</td>
  <td colspan="2"><strong>Academic Status</strong></td>
 </tr>
	<tr> <td width="2%"></td> 
  <td style=" padding-left:10px;"><img src="../../images/cross.png" width="10"> Full-time</td>
		 <td><img src="../../images/box.png" width="10"> Part-time</td>
 </tr>
	</table></td>
	<td class="border-left" style="padding-left:0px; "><table style="margin-left:-8px; " width="100%"  border="0">
 <tr>
    <td style="padding-left:0px; font-size:10px;"><strong>Hours of Instruction Per Week</strong></td>
 </tr> <tr>
    <td style="text-align:center;">25</td>
 </tr></table></td> </tr></table></td>
  <td width="170" style="width:170px;"><table width="100%" border="0" ">
 <tr>
  <td class="td-heading">18</td>
  <td><strong>Field/Program of Study</strong></td>
 </tr>
 <tr>
  <td colspan="2" style=" text-align:center; ">'.$pn.' </td>
  </tr>
</table></td>
 </tr>	
	 <tr>
  <td><table width="100%" border="0">
 <tr>
  <td class="td-heading">19</td>
  <td><strong>Level of Study</strong></td>
 </tr>
 <tr>
  <td colspan="2" style=" padding-left:20%; font-size:10px;">Diploma</td>
  </tr>
</table>
</td>
  <td><table width="100%" border="0">
 <tr>
  <td class="td-heading">20</td>
  <td colspan="4"><strong>Type of Training Program</strong></td>
 </tr>
 <tr style="font-size:10px;">
 <td></td>
  <td style=" padding-left:5px;"><img src="../../images/cross.png" width="7"> vocational</td>
		 <td><img src="../../images/box.png" width="7"> Academic</td>
  <td><img src="../../images/box.png" width="7"> Professional</td>
		 <td><img src="../../images/box.png" width="7"> other_______</td> 
 </tr>
  </tr>
</table></td>
 </tr>
	<tr>
	 <td width="249"><table width="100%" border="0">
 <tr>
<td><table width="100%" border="0">
 <tr>
  <td class="td-heading">21</td>
  <td colspan="2"><strong>Exchange Program</strong></td>
 </tr>
	<tr> <td width="2%"></td> 
  <td style=" padding-left:10px; width:60px;"><img src="../../images/box.png" width="10"> Yes</td>
		 <td><img src="../../images/cross.png" width="10"> No</td>
 </tr>
	</table></td>
	 </tr></table></td>
	 <td width="249"><table width="100%" border="0">
 <tr>
<td><table width="249" border="0">
 <tr>
  <td class="td-heading">22</td>
  <td colspan="4"><strong>Estimate tuition Fee for the First Academic Year</strong></td>
 </tr>
	<tr style=" font-size:10px; width:260px; text-align:left;"><td width="1"></td> 
 <td width="100">
 <table border="0">
 <tr><td><p style="margin:0px 0px 5px; text-align:center; border-bottom:1px solid #333;"><b>Fees Amount:</b> &nbsp;'.$loa_total_fee.'</p></td></tr>
 </table>
 </td>
  <td class="border-left"> <table border="0"><tr><td width="80"> &nbsp;<b>Fees Prepaid:</b> '.$prePfee_Yes.'</td>
 <td width="60">'.$prePfee_No.'</td></tr>
 '.$prePfee_Amount.'</table></td>
 </tr>
	</table></td>
 </tr></table></td>	
	</tr>	
	
	<tr>
   <td width="249"><table width="100%" border="0">
 <tr>
<td><table width="100%" border="0">
 <tr>
  <td class="td-heading">23</td>
  <td colspan="2"><strong>Scholarship/Teaching assistantship/Other Financial Aid:</strong></td>
 </tr>
 <tr>
	<td width="2%"></td> 
	'.$mayBeforediv.'
 </tr>
 <tr>
	<td width="2%"></td> 
	<td style=" padding-left:10px;">
	'.$mayNoSp.'
 </tr>
 </table>
 </td>
 </tr>
 </table>
 </td>
   <td width="249">
   <table width="100%" border="0">
 <tr>
<td><table width="100%" border="0">
 <tr>
  <td class="td-heading">24</td>
  <td colspan="2"><strong>Internship/Work Practicum</strong></td>
 </tr>
	<tr> <td width="2%"></td>
<table width="100%" border="0">
 <tr><td width="3%"></td> 
  '.$pyes.'
 <td style="height:20px;"> 
 <span style="width:40px; float:left;"> Length:</span><p style="width:190px; margin:0px; height:15px; float:left; border-bottom:1px solid #333;">
 '.$practicum.'</p>
 </td>
  </tr>
		<tr><td width="3%"></td>
		
  '.$pno.'
		<td style="height:20px;">
		<span style="width:80px; float:left;"> Field of Work::</span>
		<p style="width:150px; margin:0px; height:15px; float:left; border-bottom:1px solid #333;">'.$practicum_wrk.'</p>
		</td>
</tr>
	</table></td>
		 </tr>
	</table></td>
	 </tr></table></td>
 </tr>	
 <tr>
  <td colspan="2"><table width="100%" border="0">
 <tr>
  <td class="td-heading" valign="top" style=" border-bottom:0px;">25</td>
  <td><strong>Conditions of Acceptance Specific as Clearly as Possible</strong></td>
 </tr>
	<tr>
  <td colspan="2">&nbsp;</td>
 
 </tr>
</table></td>
   </tr>
				<tr>
	 <td width="249"><table width="100%" border="0">
 <tr>
<td><table width="100%" border="0">
 <tr>
  <td class="td-heading">26</td>
  <td colspan="2"><strong>Length of Program (MM/DD/YYYY)</strong></td>
 </tr>
	<tr style="font-size:10px;"> <td width="5"></td> 
  <td align="right" width="70">Start date: </td>
		 <td><p  style="border-bottom:1px solid #333;height:12px;  width:100px;margin:0px 0 3px;">'.$cd_comma.'</p></td>
 </tr>
		<tr style="font-size:10px;"> <td width="2%"></td> 
  <td align="right">Completion Date: </td>
		 <td><p  style="border-bottom:1px solid #333;height:12px; width:100px; margin:0px 0 3px;">'.$ed_comma_cmplt.'</p></td>
 </tr><tr style="font-size:10px;"> <td width="2%"></td> 
  <td align="right">Or Minimum: </td>
		 <td> 1 Year of Full-time Studies</td>
 </tr>
	</table></td>
	 </tr></table></td>
	 <td width="249" ><table width="100%" border="0">
 <tr>
<td><table width="249" border="0">
 <tr valign="top">
  <td class="td-heading">27</td>
  <td colspan="4"><strong>Expiration of Letter of Acceptance (MM/DD/YYYY)</strong></td>
		  </tr>
	<tr style=" font-size:10px; width:249px; text-align:center;"><td width="100"></td> 
 <td width="150" align="center"><p  style="border-bottom:1px solid #333;height:10px; margin-left:60px; margin-top:10px; ">  <span style="width:100px;float:left;">'.$cd_comma.'</span></p></td>
   </tr><tr>
  <td>&nbsp;</td></tr>
	</table></td>
 </tr></table></td>	
	</tr>	
			<tr>
  <td colspan="2"><table width="100%" border="0">
 <tr>
  <td class="td-heading" valign="top">28</td>
  <td><strong>Other Relevant Information:</strong> '.$other_information1.' </td>
 </tr>
  <tr><td width="2%"></td>
  <td>'.$other_information2.'</td>
 </tr>
</table></td>
   </tr>
<tr>
  <td width="260" style="border-right:0px !important;">
  <table width="100%" border="0">
 <tr>
 
  <td><b>&nbsp; Signature of Institution Representative (e.g. Registrar):</b>
</td></tr><tr><td>
<img src="../../images/Sig_Cham.png" width="70" style="float:left; margin-left:20px;"><br><br><br></td></tr>
<tr><td><b style="margin-top:50px; width:100%;"> &nbsp; Printed Name of Institution Representative: CHAMARA PERERA</b>
 </td>
 </tr>
  
</table>
</td>
<td style="border-left:0px !important; "></td>
   </tr>
 
</table>		
 
<div class="footer">
<p>#201 – 155 Skinner Street, Nanaimo, Nanaimo, BC V9R 5E8<br/>
T: 1-250-824-1545 | info@avaloncommunitycollege.ca &nbsp; www.avaloncommunitycollege.ca</p>

</div>
	';

$output .= '</div>';

if($pn == 'Diploma in Hospitality Management (With Co-op)'){
	$output .= '<style>
	.footer1, .header1 {padding:0px 30px 5px; }
	.page1 {width:100%;font-size:15px;  margin-top:60px; padding:0px 30px 5px; page-break-after: always; position:relative;line-height:19px;}
	</style>
  <div class="header1">   
    <table width="100%">
	<tr><td width="80%"> </td>
	<td align="center"><img src="images/logo.jpg" width="70"></td>
	</tr>
	<tr>
	<td width="80%"> <b>Date :: '.$loadate_1.'</b></td><td align="center"></td>
	</tr></table>
	</div> 
	<main class="page1">
	<div class="heading-txt mt-5">     
  
<table>
<tr><td>
<p><b>CANADIAN VISA OFFICE</b><br><br>
Subject: Internship/Work Practicum- '.$full_name.'<br><br>
Dear Visa Officer:<br><br>
This refers to the application of '.$full_name.' for an Internship/Work Practicum Permit.<br><br>
'.$full_name.' is a registered full-time student in the Diploma in Hospitality Management (With Co-op)
Program commencing on '.$cd_comma.' As part of the requirements of the program, said student is required to
undergo a 12-Week Mandatory Internship/Work Practicum Commencing '.$practicum_start_date.' with a completion
date of '.$ed_comma_cmplt.'.<br><br>
In this Connection, we would like to request for your good office to issue an Internship/Work Practicum Permit so
that the above mentioned student can commence their internship during the said period.<br><br>
This letter is being issued upon the request of '.$full_name.' to support their application for the Internship/Work
Practicum and to confirm that the said applicant is required to undergo an internship as a requirement to complete
the said program.<br><br>
Incase you have any questions; please do not hesitate to contact me at 1-250-824-1545 or via email at<br>
info@avaloncommunitycollege.ca.<br><br><br>
Sincerely<br><br><br>
</p>
<p>
Authorized Signatory<br>
<img src="images/Sig_Cham1.jpg" width="100"><br>
Chamara Perera Regional Director
</td>
</tr>
</table>

<footer class="footer">
<p><strong> Address:</strong>  #201 – 155 Skinner Street, Nanaimo, Nanaimo, BC V9R 5E8<br>T: 1-250-824-1545 | info@avaloncommunitycollege.ca &nbsp; &nbsp; www.avaloncommunitycollege.ca</p>
</footer>
</main>
';
}


$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

$loa_file = $rowstr1['loa_file'];
if($loa_file !==''){
unlink("$loa_file");
}
$firstname = str_replace(' ', '', $fname);
$olname = 'Letter_of_Acceptance_'.$firstname.'_'.$refid;
$filepath = "../../uploads/loa/$olname.pdf";

file_put_contents($filepath, $document->output());

if($loa_type !== ''){
if($loa_type == 'Revised'){
	$both_datetime = ", `loa_revised_date`='$loa_file_date_updated_by'";
}
if($loa_type == 'Defer'){
	$both_datetime = ", `loa_defer_date`='$loa_file_date_updated_by'";
}
}else{
	$both_datetime = '';
}

mysqli_query($con, "update `st_application` set `loa_file`='$filepath', `loa_type`='$loa_type', `loa_file_gen_updated_by`='$Loggedemail', loa_last_generated_datetime='$loa_file_date_updated_by' $both_datetime $loa_file_date_updated_by_1 $loa_first_genreate_date2 where `sno`='$snoid'");

mysqli_query($con, "INSERT INTO `loa_generated_logs` (`application_id`, `college_name`, `loa_type`, `loa_date`, `loa_time`, `logged_id`, `intake`) VALUES ('$snoid', '$campus', '$loa_type', '$date_at', '$time_at', '$loggedid', '$tk')");

$v_g_r_status = $rowstr1['v_g_r_status'];

if($v_g_r_status == 'V-R' && $loa_type == 'Defer' && $fh_status == '1'){
	mysqli_query($con, "update `st_application` set fh_status='',fh_status_updated_by='',v_g_r_status='', v_g_r_status_datetime='', file_upload_vgr='', file_upload_vgr2='',file_upload_vgr3='', file_upload_vr_status='', file_upload_vr_remarks='',  file_upload_vr_datetime='',settled_vr='', tt_upload_report_status='', tt_upload_report='', tt_upload_report_remarks='',tt_upload_report_datetime='',file_upload_vgr_status='',file_upload_vgr_remarks='',file_upload_vgr_datetime='' where `sno`='$snoid'");
}

if($loa_type !== ''){
mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$adminrole1', '$snoid', '$full_name', '$user_id', '$refid', '$loa_type LOA', '$loa_type LOA', 'application?aid=error_$snoid', '1', '$loa_file_date_updated_by')");
}

// $result_122 = "SELECT datetime_at FROM loa_date_fix where used='used' AND datetime_at='2019-06-21'";
// $result_43 = mysqli_query($con, $result_122);
// if(mysqli_num_rows($result_43)){
	// mysqli_query($con, "update `loa_date_fix` set used='', `app_id`=''");
// }

$msg_body = '<p>Dear Partner,<br><br>
	Greetings from Avalon Community College!!<br><br>
	As per your request, LOA has been released and is available to download in the application portal.	
	<br><br>
	If any of the details on the LOA are incorrect, please contact us immediately – via email at <b>[email id - daljeet@avaloncommunitycollege.ca , admissions@avaloncommunitycollege.ca]</b> or use the chat support system in the application system.	
	<br><br>
	Please log in to the portal for further information.
	<br><br>
	Best Regards,<br>
	Team Avalon Community College</p>';
	
	if(!empty($agent_email3)){
		$agent_email2 = $agent_email3;
	}else{
		$agent_email2 = 'sanjiv@essglobal.com';
	}
	
	$subject = 'Notification for - '.$full_name.' - '.$refid.'';
	$to = $agent_email2;
	$mail = new PHPMailer();
	$mail->IsSMTP();	
	$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
	$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
	$mail->SMTPSecure = 'tls';	 
	$mail->From = "no-reply@avaloncommunitycollege.com";	
	$mail->FromName = 'ACC | Application Update';
	$mail->AddAddress("$to");
	$mail->addCC("daljeet@avaloncommunitycollege.ca");
	$mail->addCC("admissions@avaloncommunitycollege.ca");
	
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $msg_body;
	// if(!$mail->Send()){
		//// echo 'Mailer Error: ' . $mail->ErrorInfo;
		//// exit();
	// }else{
		//// echo 'success';
	// }

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>