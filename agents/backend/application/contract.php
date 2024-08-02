<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");

require_once '../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//initialize dompdf class

$document = new Dompdf();

$document->set_option('defaultFont', 'Courier');

$pro_name_dual = $_POST['pro_name_dual'];
$pro_name_dual_sno = $_POST['pro_name_dual_sno'];
$pro_name_dual_campus = $_POST['pro_name_dual_campus'];
$campus = $_POST['campus'];
$tk = $_POST['tk'];
$pn = $_POST['pn'];
$snoid = $_POST['snoid'];

$genrate_date = date('Y-m-d');
$get_crnt_date = date("jS F, Y", strtotime($genrate_date));

		// $result_131 = "SELECT * FROM ham_aol_student_id where st_sno='$snoid' AND availablility!='' ORDER BY aolid ASC limit 1";
		// $qyaolid_131 = mysqli_query($con, $result_131);
		// if(mysqli_num_rows($qyaolid_131)){
			// mysqli_query($con, "update `ham_aol_student_id` set availablility='', `st_sno`='' where `st_sno`='$snoid'");
		// }
		
		// $result_131 = "SELECT * FROM brm_aol_student_id where st_sno='$snoid' AND availablility!='' ORDER BY aolid ASC limit 1";
		// $qyaolid_131 = mysqli_query($con, $result_131);
		// if(mysqli_num_rows($qyaolid_131)){
			// mysqli_query($con, "update `brm_aol_student_id` set availablility='', `st_sno`='' where `st_sno`='$snoid'");
		// }
		
		$result_13 = "SELECT aolid FROM aol_student_id where st_sno='$snoid' AND availablility!='' ORDER BY aolid ASC limit 1";
		$qyaolid_13 = mysqli_query($con, $result_13);
		if(mysqli_num_rows($qyaolid_13)){
			$row_13 = mysqli_fetch_assoc($qyaolid_13);
			$aolid = $row_13['aolid'];
		}else{
	        $result2 = "SELECT aolid FROM aol_student_id where availablility='' ORDER BY aolid ASC limit 1";
			$qyaolid = mysqli_query($con, $result2);	
			while ($row1 = mysqli_fetch_assoc($qyaolid)){
			 	$aolid = $row1['aolid'];	
			}
		}
	 
		$querysid = "SELECT student_id FROM st_application where sno='$snoid'";
	    $rseultst_id = mysqli_query($con, $querysid);	
		while ($rowst_id = mysqli_fetch_assoc($rseultst_id)){
			$student_id = $rowst_id['student_id'];
	    }
		
		if($student_id ==''){
		
		mysqli_query($con, "update `st_application` set student_id='$aolid' where `sno`='$snoid'");
		
		mysqli_query($con, "update `aol_student_id` set availablility='used', `st_sno`='$snoid' where `aolid`='$aolid'");
	
		}
		 
		 $querysid_2 = "SELECT student_id FROM st_application where sno='$snoid'";
	     $rseultst_id_2 = mysqli_query($con, $querysid_2);	
		 while ($rowst_id_2 = mysqli_fetch_assoc($rseultst_id_2)){
		 $student_id_2 = $rowst_id_2['student_id'];
	     }
				
		 

$query1 = "SELECT * FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$student_id = $rowstr1['student_id'];
$gtitle = $rowstr1['gtitle'];
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$refid = $rowstr1['refid'];
$user_id = $rowstr1['user_id'];
$dob = $rowstr1['dob'];
$getdob = date("d/m/Y",strtotime($dob)); 
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
$datetime = date('Y-m-d');
$getdate = date("F jS, Y", strtotime($datetime)); 

$stream1 = $rowstr1['stream1'];
$passing_year1 = $rowstr1['passing_year1'];
$email_address = $rowstr1['email_address'];
$mobile = $rowstr1['mobile'];

if((!empty($pro_name_dual) && $pro_name_dual == 'Personal Support Worker') && (!empty($pro_name_dual_campus))){
	$query2 = "SELECT * FROM contract_courses WHERE intake = '$tk' AND  program_name= '$pro_name_dual' AND campus='$pro_name_dual_campus'";
}else{
	if(!empty($pro_name_dual) && !empty($pro_name_dual_campus)){
		$query2 = "SELECT * FROM contract_courses WHERE intake = '$tk' AND  program_name= '$pro_name_dual' AND campus='$pro_name_dual_campus'";
	}else{
		$query2 = "SELECT * FROM contract_courses WHERE intake = '$tk' AND  program_name= '$pn' AND campus='$campus'";
	}
}

$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$crs_sno = $rowstr2['sno'];
$commenc_date = $rowstr2['commenc_date'];
$program_name = $rowstr2['program_name'];
$expected_date = $rowstr2['expected_date'];
$total_tuition = $rowstr2['total_tuition'];
$otherandbook = $rowstr2['otherandbook'];
$week = $rowstr2['week'];
$school_break1 = $rowstr2['school_break1'];
$school_break2 = $rowstr2['school_break2'];
$tuition_fee = $rowstr2['tuition_fee'];
$books_est = $rowstr2['books_est'];
$other_fee = $rowstr2['other_fee'];
$int_fee = $rowstr2['int_fee'];
$hours = $rowstr2['hours'];
$total_fee = $rowstr2['total_fee'];

$admQry = "SELECT username FROM allusers WHERE sno='$user_id'";
$result_adm = mysqli_query($con, $admQry);
$rowstrAdm = mysqli_fetch_assoc($result_adm);
$username = $rowstrAdm['username'];


if(!empty($pro_name_dual_sno)){
	$query4 = "SELECT * FROM cc_date_wise_fee WHERE crs_id='$pro_name_dual_sno' GROUP by crs_id";
}else{
	$query4 = "SELECT * FROM cc_date_wise_fee WHERE crs_id='$crs_sno' GROUP by crs_id";
}
$result_query4 = mysqli_query($con, $query4);

if(($pn == 'Personal Support Worker' && $campus == 'Toronto') || ($pro_name_dual == 'Personal Support Worker' && $pro_name_dual_campus == 'Hamilton') || ($pro_name_dual == 'Personal Support Worker' && $pro_name_dual_campus == 'Brampton')){
	// echo '1';
	$total_pages = '14';
	$countPage_11 = '11';
	$countPage_12 = '12';
	$countPage_13 = '13';
	$countPage_14 = '14';	
}else{
	if(mysqli_num_rows($result_query4)){
		// echo 'hello';
		$total_pages = '13';
		$countPage_11 = '';
		$countPage_12 = '11';
		$countPage_13 = '12';
		$countPage_14 = '13';
	}else{
		// echo '3';
		$total_pages = '12';
		$countPage_11 = '';
		$countPage_12 = '10';
		$countPage_13 = '11';
		$countPage_14 = '12';
	}
}
// print_r($query4);
// die;

$output = "<style>
 @page { margin: 70px 25px 0px; }
    header { position: fixed; top: -30px; left: 30px; right: -30px;width:100%; height:170px; }
    .footer { position: fixed; bottom: -10px; left: 30px; right: 0px;height:70px;  }
body { padding: 30px 30px 10px; }
.firstrow{width:100%;font-size:12px; color:#333;font-family:Arial, Helvetica, sans-serif;  page-break-after: always; position:relative; }
.logo{margin-top:-20px; width:180px; margin-bottom:5px; float:left;}
.logo2{width:180px; margin-bottom:5px; float:left;}
.logo1{margin-top:-40px; width:180px; margin-bottom:5px; float:left;}
.headertop2
{margin-top:0px; margin-bottom:0px;width:70%;float:left;font-size:10px;text-transform:uppercase;text-align:center;padding:2px 0;}
.headertop
{margin-top:-15px; margin-bottom:0px;width:70%;float:left;font-size:10px;text-transform:uppercase;text-align:center;padding:2px 0;}


.firstrow #heading{margin-top:0px; margin-bottom:0px;width:100%;font-size:14px;font-weight:700;text-transform:uppercase;text-align:center;}
.line3 { background:#000; height:3px; width:100%;  margin-top:50px;}
.line { background:#000; height:3px; width:100%;  margin-top:30px;}
.id-aol { width:100%;}
.aol-id { float:right; padding:3px 10px; width:120px; border:1px solid #333; border-bottom:0px; }
.code1 { height:22px; float:right;   width:200px;margin-top:20px;margin-bottom:20px; }
.note-text { width:100%; clear:both;}
.note-text p { margin-top:0px; margin-bottom:0px;}
.inst-code, .inst-code1 {float:right; padding:4px 10px; width:100px;  border:1px solid #333;}
.inst-code1 { margin-left:220px; border-left:0px;}
.inst-code { margin-left:100px;}
.name-table { margin-top:0px 0px;}
.mr span { margin-left:6%;}
.mr span .check-box { margin-top:6px;}
.miss span { margin-left:6%;}
.miss span .check-box { margin-top:6px;}
.mrs span { margin-left:6%;}
.mrs span .check-box { margin-top:6px;}
.ms span { margin-left:6%;}
.ms span .check-box { margin-top:6px;}
.birth-date span { margin-left:6%; font-weight:bold;}
.program-table {margin-top:0px;  border-collapse:collapse; border:1px dashed #999;}
.program-table td, .program-table1 td  {border:1px dashed #999;  font-size:11px; padding:3px 5px;}
.program-table td i, .program-table1 td i { font-size:11px;}
.program-table1 { border-collapse:collapse; border:1px dashed #999;}
.text-p1 h3 { margin-bottom:0px; margin-top:10px; }
.text-p p { margin-top:10px; margin-bottom:0px;}
.text-p1 p { margin-bottom:0px;line-height:12px;}
.text-p1 h4{font-size:17px; text-transform:uppercase; margin-top:0px; margin-bottom:0px;}
.stu-name {width:200px;    margin-top:0px;}
.stu-name span { margin:-10px 0px 0px !important;}
.stu-name .line2 {border-bottom:1px solid #ccc !impoprtant;margin:0px 10px 0px !important;float:left; width:100%;height:2px;}
.form-table { margin-top:10px;margin-bottom:0px; width:100%; }
.form-table td {padding:2px 0px; text-align:center;}

.student-in {width:400px;}
.funding { margin-top:0px; margin-bottom:0px;}
.table1 { border-collapse:collapse; margin-bottom:10px; }
.table1 td { border:1px solid #ccc; padding:2px 5px;}
.table { border-top:1px solid #333;}
.table td { border-bottom:1px solid #333; padding:3px 5px;}
.table2 td { border:1px solid #333; padding:3px 5px;}
.table2 {border:1px solid #333; }
.acknowledge span, .acknowledge1 span {float:left; margin-right:4px;}
.acknowledge p  { width:250px;float:left; margin-top:0px; height:15px; border-bottom:1px solid #333;}
.acknowledge1 p  { width:150px;float:left; margin-top:0px; height:15px; border-bottom:1px solid #333;}

.ul-count-list li { color:#000; font-size:13px; }
.ul-count-list li span { font-size:11px; color:#333;}
 .ul-count-list li ul, .ul-count-list li ul li ul, .list-alfa { margin-left:0px; padding-left:16px;}
.ul-count-list li { list-style:decimal;}
.counting { margin-left:0px; margin-top:-10px; position:absolute;}
.ul-count-list li ul li ul li {list-style:upper-roman;}
.ul-count-list { margin-top:-40px !important; margin-bottom:0px; position:relative;}
.list-alfa li, .un-list .list-alfa li{list-style:lower-alpha ;}
.list-alfa{ margin-bottom:0px;}
.un-list li {list-style:none; }
.un-list {margin-top:-40px !important;  padding-left:20px;}
.list-ul { margin:0px 0px;}
.list-ul li { list-style:none;}
.condition-list { border:1px solid #333; padding:15px 30px;}
.last-h4 { width:70%;margin-left:15%; margin-top:30%; margin-bottom:60px;  font-size:16px; font-weight:normal; line-height:30px;}
.table-width { width:70%;margin-left:15%;}
.ul-count-list1 li span { font-size:13px;}
.ul-count-list1 li { margin:5px 0px;}
.ul-roman-list li { list-style:upper-roman;}
.ul-roman-list { padding-left:10px;}
</style>";


if($gtitle == 'Mr'){
	$mr = '<td><span class="mr">Mr. <span>[  <img src="../../images/cross.png" class="cross" width="10">  ]</span></span></td>';
}else{
	$mr = '<td><span class="mr">Mr. <span>[  <img src="../../images/box.png" width="10">  ]</span></span></td>';
}
if($gtitle == 'Miss'){
	$Miss = '<td><span class="miss">Miss <span>[ <img src="../../images/cross.png" class="cross" width="10"> ]</span></span></td>';
}else{
	$Miss = '<td><span class="miss">Miss <span>[ <img src="../../images/box.png" width="10"> ]</span></span></td>';
}
if($gtitle == 'Mrs'){
	$Mrs = '<td><span class="mrs">Mrs. <span>[ <img src="../../images/cross.png" class="cross" width="10"> ]</span></span></td>';
}else{
	$Mrs = '<td><span class="mrs">Mrs. <span>[ <img src="../../images/box.png" width="10"> ]</span></span></td>';
}
if($gtitle == 'Ms'){
	$Ms = '<td><span class="ms">Ms. <span>[ <img src="../../images/cross.png" class="cross" width="10"> ]</span></span></td>';
}else{
	$Ms = '<td><span class="ms">Ms. <span>[ <img src="../../images/box.png" width="10"> ]</span></span></td>';
}


$output .= '<div class="firstrow "><header>	
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>
</div></header>
<h4 id="heading">Enrollment Contract</h4>
<div class="id-aol">
<div class="aol-id">AOL '.$student_id_2.'</div>
<div class="code1">
<div class="inst-code" style=" width:100px;">Institution Code</div><div class="inst-code1" style=" border-left:1px solid #333; width:100px;">EPXG</div></div>
</div>
<div class="note-text">
<p> <b>This Enrollment Contract is subject to the <i>Private Career Colleges Act, 2005</i> and the regulations made under the Act.</b><br>
The undersigned person at this moment enrolls as a student of ACADEMY OF LEARNING COLLEGE for the following:</p>
</div>
<table width="700" class="form-table" style=" margin-top:0px;" >
 <tr><td style="width:60px;"><b>Student</b></td>
  <td><span class="stu-name"><b>'.$lname.'</b>
<br><span class="line2">&nbsp;</span><br> <span style=" font-size:11px;margin-top:-10px;">Family Name</span></span> </td><td>/</td>
  <td><span class="stu-name"><b></b>
<br><span class="line2">&nbsp;</span><br> <span style=" font-size:11px;margin-top:-10px;">Initial</span></span> </td><td>/</td>
 <td><span class="stu-name"><b>'.$fname.'</b><br>
<span class="line2">&nbsp;</span><br> <span style=" font-size:11px;margin-top:-10px;">First Name</span></span></td>
 </tr>
 </table>

<table width="100%"  class="name-table">
 <tr>
	'.$mr.' '.$Miss.' '.$Mrs.' '.$Ms.'
	<td><span class="mrs"><span class="birth-date">Date fo Birth   <span> '.$getdob.'</span></span></td>
 </tr>
</table>
<h3><b>Program:'.$program_name.'</b></h3>

<table width="100%" class="program-table">
 <tr>
  <td>Commencing <b>On:'.$commenc_date.'</b> </td>
  <td>Expected Completion Date: <span style="font-size:10px;font-weight:600;">'.$expected_date.'</span></td>
  <td>Program Duration: <b>'.$hours.'</b></td>
 </tr>
 <tr>
  <td>Study Period:(<i>Including Break if applicable</i>):<b>'.$week.'</b></td>
  <td>School breaks: <b>'.$school_break1.'</b></td>
  <td><b>'.$school_break2.'</b></td>
 </tr>
 <tr>
  <td>The Language of Instruction: <img src="../../images/cross.png" class="cross" width="10"> English</td>
  <td>Location of Practicum:<b>N/A</b></td>
  <td>Location of Instruction if not campus:<b>N/A</b></td>
 </tr><tr>
  <td>Additional Practicum Location <img src="../../images/cross.png" class="cross" width="10"> <b> N/A</b></td>
   <td colspan="2">Or</td>
 </tr><tr>
  <td>Class Schedule: <img src="../../images/cross.png" class="cross" width="10"> Full Time <img src="../../images/cross.png" class="cross" width="10"> Monday to Sunday</td>
   <td colspan="2"><b style=" text-decoration:underline;">Times: Monday to Friday 8am - 1pm, 1pm - 5pm, 5pm - 10pm , Saturday to Sunday 9am to 7pm</b></td>
 </tr>
</table>
<div class="text-p"><p><b>All Students are required to attend all scheduled classes and placements (where applicable,)
on a full-time basis, by the above stated hours.</b>
</p><p>Credential to be awarded upon Successful Completion of the Program:<b> Diploma</b></p>
</div>

<table width="100%" class="program-table">
 <tr>
  <td>Last Grade Completed:'.$stream1.'</td>
  <td>Year: <b>'.$passing_year1.'</b></td>
  <td colspan="2">Additional Education/Courses Taken: <b>University</b></td>
 </tr>
 <tr>
  <td colspan="3">Mailing Address:<b style=" text-transform:uppercase;"> '.$address1.', '.$address2.$city.', '.$state.', '.$pincode.', '.$country.' </b></td>
  <td>Apt/Unit#:</td>
  
 </tr>
 <tr>
  <td>City:<b style=" text-transform:uppercase;"> '.$city.'</b> </td>
  <td colspan="2">Province:<b style=" text-transform:uppercase;"> '.$state.'</b></td>
  <td>Postal Code:<b> '.$pincode.'</b></td>
 </tr><tr>
  <td>Phone Number: <b>'.$mobile.'</b></td>
   <td colspan="2">Alternative:<b>	</b></td>	<td><b>Cell:</b></td>
 </tr>
	
	 <tr>
 
  <td colspan="4">Email Address:<b> '.$email_address.'</b></td>
  
 </tr>
	<tr>
  <td colspan="3">Permanent Address:<b> ___As above___ </b></td>
  <td>Apt/Unit#: <b> ___As above___ </b></td>  
 </tr>
	
	 <tr>
  <td>City:  <b> ___As above___ </b></td>
  <td colspan="2">Province:  <b> ___As above___ </b></td>
  <td>Postal Code: <b> ___As above___ </b></td>
 </tr><tr>
  <td>Phone Number: < <b> ___As above___ </b></td>
   <td colspan="2">Alternative:  <b> ___As above___ </b></td>			<td><b>Cell: </b></td>
 </tr>

</table>
<div class="text-p1">
<p>International Student:  <img src="../../images/cross.png" class="cross" width="10"> Yes &nbsp; &nbsp; &nbsp; <img src="../../images/box.png" width="10"> No
</p>
<h3><b>Admission Requirements</b></h3>
<p><span class="stu-name"><img src="../../images/box.png" width="10"></span> Have an Ontario Secondary School Diploma or Equivalent, or<br>
<span class="stu-name"><img src="../../images/box.png" width="10"> </span> Be at least 18 years of age ( or age specified in program approval) and pass a Superintendent approved qualifying test</p>

<h3><b style="text-transform:capitalized;"> <img src="../../images/cross.png" class="cross" width="10"> International Students (in addition to the requirements above):</b>
</h3>
<p><span class="stu-name"><img src="../../images/cross.png" width="10">
</span> Proof of Health Insurance Coverage for entire study period; and<br>
<span class="stu-name"><img src="../../images/cross.png" width="10">
</span> Appropriate student authorization or a Study Permit From Citizenship and immigration Canada</p>



<table width="700" class="form-table" style=" margin-top:8px;" >
 <tr>
  <td><span class="stu-name"><b>'.$fname.' '.$lname.'</b>
<br><span class="line2">&nbsp;</span><br> <span style=" font-size:11px;">Student Name</span></span></td>
  <td><span class="stu-name"><b></b>
<br><span class="line2">&nbsp;</span><br> <span style=" font-size:11px;">Student Signature</span></span></td>
  <td><span class="stu-name">&nbsp;<b style="text-transform:uppercase;"></b>
<br><span class="line2"></span><br> <span style=" font-size:11px;">Date</span></span></td>
 </tr>
 </table>
 
<table width="700" class="form-table" style=" margin-top:8px;" >
 <tr>
  <td><span class="stu-name"><b style="height:68px; vertical-align:bottom;"><br>Vinod Kumar</b>
<br><span class="line2">&nbsp;</span><br> <span style=" font-size:11px;">Admission Adviser Name</span></span></td>
  <td><span class="stu-name"><b style="height:68px;"><img src="sign2.png" width="110"></b>
<br><span class="line2">&nbsp;</span><br> <span style=" font-size:11px;">Admission Adviser Signature</span></span></td>
 <td><span class="stu-name"><b style="text-transform:uppercase; height:68px; vertical-align:bottom;">'.$get_crnt_date.'</b><br>
<br><span class="line2">&nbsp;</span><br> <span style=" font-size:11px;">Date</span></span></td>
 </tr>
 </table>
 <table class="form-table" style=" margin-top:15px;" >
	 <tr>
  <td width="30%"><span class="stu-name"></span></td>
  <td width="30%" style="padding-top:15px;"><span class="stu-name"><b style="text-transform:uppercase;">&nbsp;</b>
<span class="line2">&nbsp;</span><br> <span style=" font-size:12px;"><b >Director Signature</b></span></span></td>
  <td width="30%"><span class="stu-name"><b style="text-transform:uppercase;"></b>
<br><span class="line2">&nbsp;</span><br> <span style=" font-size:11px;">Date</span></span></td>
 </tr>
</table>

</div><br><br>
<div class="2 footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px !important;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page 1 of '.$total_pages.'</span></span></div>




	';
	$output .= '</div>';	
	
$output .= '<div class="firstrow">	<header>	
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>
</div></header>

<p style=" margin-top:5px;margin-bottom:0px; text-align:left;">Where did you hear about <b style=" text-trans-form:uppercase;">Academy of Learning College?</b></p>
<p style=" margin-top:5px;margin-bottom:0px; "><b style=" text-transform:uppercase;">Emergency Contract Information</b></p>
<table width="100%" border="1" class="table1" bordercolor="#ccc;">
 <tr>
  <td>Name: <span></span></td>
  <td>&nbsp;</td>
  <td>Relationship: <span></span></td>
 </tr>
 <tr>
  <td colspan="2">Street Address: <span></span></td>
  <td>Apt/Unit # <span></span></td>
 </tr>
 <tr>
  <td>City: <span></span></td>
  <td>Province: <span></span></td>
  <td>Postal Code: <span></span></td>
 </tr>
	 <tr>
  <td>Phone: <span></span></td>
  <td>Alternative: <span></span></td>
  <td>Cell: <span></span></td>
 </tr>
</table><table width="100%" class="table2" border="1">
 <tr>
  <td colspan="4"><b>Fees to Academy of Learning College (CAD)):</b></td>

 </tr>
 <tr>
  <td>Tuition Fees</td>
  <td>'.$tuition_fee.'</td>
  <td>Book Fees</td>
  <td>'.$books_est.'</td>
 </tr>
 <tr>
  <td>Other Compulsory Fees (Lab Fee)</td>
  <td>'.$other_fee.'</td>
  <td>HST</td>
  <td>&nbsp;</td>
 </tr>	
  <tr>
  <td>International Student Fees</td>
  <td>'.$int_fee.'</td>
  <td><b>Minus</b> Credit for Prior Learning amount</td>
  <td>&nbsp;</td>
 </tr>
	 <tr>
  <td>Optional Fees (specify)</td>
  <td>&nbsp;</td>
 <td>&nbsp;</td>
		<td>&nbsp;</td>
 </tr>
	 <tr bgcolor="#ccc">
  <td colspan="3">Total Fees</td>
		 <td>'.$total_fee.'</td>
		</tr>
</table>

<p style="text-transform:uppercase; margin-bottom:5px;"><strong>Funding Information</strong></p>

<p class="funding"><span class="mr1"><span> <img src="../../images/box.png" width="10"> </span>  OSAP (if eligible)</span>
<span class="miss1"><span> <img src="../../images/box.png" width="10"> </span> Second Career </span>
<span class="mrs1"><span> <img src="../../images/cross.png" class="cross" width="10"> </span> Self-Funded </span>
<span class="ms1"><span> <img src="../../images/box.png" width="10">  </span> Third-party Funded </span>
<span class="birth-date1"><span> <img src="../../images/box.png" width="10">  </span> Other: <span>______________</span></span></p>

<p style="text-transform:uppercase; margin-bottom:5px;"><b>Acknowledgement</b></p>
<div class="acknowledge" style=" margin-bottom:0px;"><span>1, </span> <p> '.$fname.' '.$lname.'</p> .acknowledge that I have received a copy of:</div>

<p class="statement" style="margin-bottom:5px; margin-top:0px;">
<span><img src="../../images/cross.png" class="cross" width="11"> </span> The Statement of students` Rights and Responsibilities Issued by the Superintendent of Private Career Colleges<br>
<span><img src="../../images/cross.png" class="cross" width="11"> </span> The College’s Fee Refund Policy<br>
<span><img src="../../images/cross.png" class="cross" width="11"> </span> The Consent to Use of Personal Information<br>
<span><img src="../../images/cross.png" class="cross" width="11"> </span> The Payment Schedule	<br>
<span><img src="../../images/cross.png" class="cross" width="11"> </span> The Student Handbook<br>
<span><img src="../../images/cross.png" class="cross" width="11"> </span> The College’s Student Complaint Procedure<br>
<span><img src="../../images/cross.png" class="cross" width="11"> </span> The College’s Policy Relating to the Expulsion of Students<br>
<span><img src="../../images/cross.png" class="cross" width="11"> </span> The College’s Policy on Sexual Violence and Harassment</p>
<div class="acknowledge" > <p> <b>'.$fname.' '.$lname.'</b></p><b> , is entitled to a copy of the signed contract immediately after it is signed.</b><Br><Br>
<p style=" margin-top:-15px; border:none;">Students Name (print)</p></div>



<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span style="text-decoration:underline;">X</span><p>'.$fname.' '.$lname.'</p><Br><Br>
<p style=" margin-top:-15px; border:none; text-align:center">Students Name (print)</p></div></td>

  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span>Date:</span><p></p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD)</p></div></td>
 </tr>
</table>
<p style=" margin-top:0px;"><strong>Academy of Learning College do not guarantee employment for any student who completes a vocational program offered by Academy of Learning College </strong><br>
It is understood that fees are payable by the fees specified in this Enrollment Contract and all payments of fees shall become due forthwith upon a statement of accounting being rendered. <strong>Academy of Learning College </strong> serves the right to cancel this Enrolment Contract if the undersigned student does not attend classes during the first 14 days of the program. <strong> For information regarding cancellation of this Enrolment Contract and refunds of fees paid, see section 25 to 33 of O. Reg. 415/06 made under the Private Career Colleges Act, 2005.</strong><br>
I certify that I have read, understood and have received a copy of this Enrolment Contract.<br>
The undersigned student at this moment undertakes and agrees to pay or see to the payment of, the fees specified in this Enrolment Contract by the terms of this Enrolment Contract.
</p>


<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span style="text-decoration:underline;">X</span><p>'.$fname.' '.$lname.'</p><Br><Br>
<p style=" margin-top:-15px; border:none; text-align:center">Students Name (print)</p></div></td>

  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span>Date:</span><p></p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD)</p></div></td>
 </tr>
</table>
<p style=" margin-top:0px;"><strong>Academy of Learning College </strong>agree to supply the program to the above-named student upon the terms herein mentioned.<strong> Academy of Learning College </strong> may cancel this Enrolment Contract if the above-named student does not meet the admission requirements of the program, named on Page 1 of this contract before the program begins.</p>

<table width="700px" border="0" align="center">

<tr>
  <td width="48%"><div class="acknowledge"> <div  style=" width:300px; text-align:center"> <img src="sign2.png"  width="100"> 
</div></div></td>

  <td width="48%"><div class="acknowledge"> <div  style=" width:300px; text-align:center">&nbsp;</div></div></td>
 </tr>
 <tr><td width="48%"><div class="acknowledge"> <div  style=" width:300px; text-align:center"><p><strong> Vinod Kumar</strong></p><Br><Br>
<p style=" border:none;margin-top:-15px;font-size:11px;text-align:center">(Signature of Admission Officer, Registrar, Agent)</p></div></div></td>

  <td width="48%"><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span><b>Date:</b></span><p>'.$get_crnt_date.'</p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD</p></div></div></td>
 </tr>
</table>
<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page 2 of '.$total_pages.'</span></span></div>

';

$output .= '</div>';	


$output .= '<div class="firstrow">	<header>	
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>
</div></header>
<h4>PRIVACY POLICY STATEMENT</h4>


<p style="  text-align:left;">Academy of Learning Career College is committed to, and accountable for, the protection and proper use of your personal information. Our commitment extends to meeting and(or) exceeding all legislated requirements.<br><br>
Personal Information is identifiable information such as name, address, e-mail address, social insurance identification, birth date and gender. We collect personal information when you provide it during the enrollment process or requests for information regarding training. Business contact information such as the name, title, business address, business e-mail address or the telephone number of a business or professional person or an employee of an organization is not considered personal information.<br><br>
Non-personal information’ is information of an anonymous nature, such as aggregate information, including demographic statistics.
</p>
<p style="text-decoration:underline;"><strong>USE OF PERSONAL INFORMATION</strong></p>
<p><strong>
We may use Personal Information for the following purposes:</strong></p>
<ul><li>To manage and administer the delivery of training and relevant services to Academy of Learning Career College students
</li><li>To maintain the accuracy of our records by legal, regulatory and contractual obligations
</li><li>	To allow authorized personnel access to student files to ensure accuracy and regulatory compliance with same
</li><li>	To occasionally contact consumers about training and relevant services that are available from Academy of Learning Career College
</li><li>	To perform statistical analysis of the collective characteristics and behaviours of Academy of Learning Career College students to monitor and improve our operations and maintain the quality of our products and services
</li></ul>
<p style="text-decoration:underline;"><strong>DISCLOSURE OF PERSONAL INFORMATION</strong></p>
<p><strong>We will disclose personal information to Third Parties</strong></p>
<ul><li>To manage and administer the delivery of training and relevant services to Academy of Learning Career College students
</li><li>	Where you have given us your signed consent to disclose for a designated purpose
</li><li>	Who are acting on our behalf as agents, suppliers or service providers, solely to enable us to provide you with training and other services more efficiently
</li><li>		As required by law, including by order of any court, institution or body with authority to compel the production of information
</li></ul>

<p style="text-decoration:underline;"><strong>ACCESS TO PERSONAL INFORMATION</strong></p>
<p>For access to your personal information, please contact the Campus Director.  A request should be in writing and should include sufficient identifying information so that we can expeditiously locate your information.</p>

<p style="text-decoration:underline;"><strong>QUESTIONS, COMMENTS</strong></p>
<p>If you have questions or comments about this Privacy Policy or any other Academy of Learning Career college privacy practice that was not answered here, please contact our designated Privacy Officer at 1855-996-9977.</p>
<p><b>STATEMENT OF RELEASE OF INFORMATION</b></p>
<p>I at this moment consent and give Academy of Learning Career College permission to release/disclose my school information to any agent of the college, their respective employees, officers and agents.My funding agency and AOLCC’s Franchise Support Centre staff, as authorized, any or all of the information contained in my college records including personal, financial (student account information), academic, attendance and any other information entered and maintained in my files (electronic and hard copy formats). I understand that all information will be kept confidential and utilized to provide information as it relates to the program of studies, labour market re-entry and to maintain the accuracy of my records by legal, regulatory and contractual requirements.  This information will not be used for any other purpose nor will it be released to any other parties.</p>


<table width="100%" border="0" class="form-table" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span style="text-decoration:underline;">X</span><p>'.$fname.' '.$lname.'</p><Br><Br>
<p style=" margin-top:-15px; border:none; text-align:center">Students Name (print)</p></div></td>

  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span>Date:</span><p></p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD)</p></div></td>
 </tr>
</table>
<div class="footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page 3 of '.$total_pages.'</span></span></div>

';

$output .= '</div>';	





$output .= '<div class="firstrow">	<header>	
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>
</div></header>	
<h4>CONSENT TO USE OF PERSONAL INFORMATION
</h4>


<p style="  text-align:left;">Private career colleges (PCCs) must be registered under the Private Career Colleges Act, 2005, which is administered by the Superintendent of Private Career Colleges. The Act protects students by requiring PCCs to follow specific rules on, for example, fee refunds, training completions if the PCC closes qualifications of instructors, access to transcripts and advertising.   It also requires PCCs to publish and meet certain performance standards, e.g., the percentage of graduates who obtain employment. Other students may use this information when they are deciding where to obtain their training. The consent set out below will help the Superintendent to ensure that current and future students receive the protection provided by the Act.
</p>
<div class="acknowledge"><span>1, </span> <p><strong> '.$fname.' '.$lname.'</strong></p> <strong>allow ACADEMY OF LEARNING COLLEGE to give</strong><br><br>my name, address, telephone number, e-mail address and other contact information to the Superintendent of Private Career Colleges for the purposes checked below:</div>
<p><img src="../../images/cross.png" width="11">  To advise me of my rights under the Private Career Colleges Act, 2005 including my rights to a refund of fees, access to transcripts and a formal student complaint procedure; and<br><br>
<img src="../../images/cross.png" width="11">   To determine whether ACADEMY OF LEARNING COLLEGE has met the performance objectives required by the Superintendent for its vocational programs.<br><br>
I understand that I can refuse to sign this consent form and that I can withdraw my consent at any time for future uses of my personal information by writing to:</p>

<p style="text-align:center;"><b>ACADEMY OF LEARNING COLLEGE</b><br><br>
401 BAY STREET, SUITE 1000, 10TH FLOOR,<br><br>
Toronto, On M5H 2Y4
</p>

<p>I understand that if I refuse or withdraw my consent, the Superintendent may not be able to contact me to inform me of my rights under the Act or collect information to help potential students make informed decisions about their educational choices</p>


<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span style="text-decoration:underline;">X</span><p></p><Br><Br>
<p style=" margin-top:-15px; border:none; text-align:center">(Signature of Student)</p></div></td>

  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span>Date:</span><p></p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD)</p></div></td>
 </tr>
</table>
<div class="acknowledge"><span><img src="../../images/box.png" width="11"> &nbsp;  &nbsp; 1, </span> <p><strong> '.$fname.' '.$lname.'</strong></p> <strong>,do not allow Academy of Learning College to give my <br><br>name, address,
telephone number, e-mail address and other contact information to the Superintendent of Private Career Colleges
for any purpose.</div>
<table width="100%" border="0" class="form-table" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span style="text-decoration:underline;">X</span><p></p><Br><Br>
<p style=" margin-top:-15px; border:none; text-align:center">(Signature of Student)
</p></div></td>

  <td><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span>Date:</span><p> </p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD)</p></div></td>
 </tr>
</table>
<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page 4 of '.$total_pages.'</span></span></div>

';

$output .= '</div>';	


$output .= '<div class="firstrow">	<header>	
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>
</div></header>	
<h4 style="text-align:center;">SCHEDULE C: INTERNATIONAL STUDENT CONSENT FORM<br>
NOTICE OF COLLECTION OF PERSONAL INFORMATION AND CONSENT<br>
(ONTARIO MINISTRY OF ADVANCED EDUCATION AND SKILLS DEVELOPMENT)
</h4>


<p style="  text-align:left;">International students seeking a study permit to attend a post secondary learning institution in Ontario must attend a postsecondary institution designated by Ontario for the Immigration and Refugee Protection Regulations (Canada). This is often referred to as the International Student Program (“ISP”).<br>
Under the ISP, private postsecondary institutions are designated by Ontario on an annual basis. As a result, private postsecondary institutions that wish to remain designated apply for designation annually.<br>
At the time that you are asked to read and sign this document, you are (1) applying to be enrolled in an institution that is applying for designation for the first time, (2) applying to be enrolled in a designated institution, or (3) enrolled in a designated institution.  If you are enrolled in an institution that is currently designated, the institution may be applying for further designation annually. <br>
When reviewing an institution’s application for designation under the ISP, Ontario’s Ministry of Advanced Education and Skills Development (the “Ministry”) conducts a site assessment to verify the information in the institution’s application concerning its educational policies and procedures. The Ministry may also monitor institutions that are designated to determine whether those institutions are complying with the terms and conditions of designation.<br>
As part of the site assessment and the Ministry’s ongoing monitoring of designated institutions, the Ministry reviews a representative sample of student and prospective student records, such as student and prospective student contracts, registration forms, records of enrollment, documents pertaining to academic assessment and progress, and other documents contained in the student or prospective student file. The Ministry also may need to make copies of student and prospective student records to complete its review of the institution’s (1) application for designation or (2) ongoing compliance with the terms and conditions of designation. <br>
Your consent is requested to allow the Ministry to access the personal information you have provided to the institution that may be contained in your student records.  Without your consent, the Ministry cannot access your records as may be required to assess the institution’s application for designation or ongoing compliance with designation conditions.
The Ministry collects and uses this information under the authority of ss. 38(2) and 39(1)(a) of the Freedom of Information and Protection of Privacy Act and the Immigration and Refugee Protection Act (Canada) and its Regulations. Questions about the collection, use and disclosure of this information may be addressed to:
</p>
<p style="text-align:center;">MANAGER, QUALITY AND PARTNERSHIP UNIT<br>
PRIVATE CAREER COLLEGES BRANCH<br>
MINISTRY OF TRAINING COLLEGES AND UNIVERSITIES<br>
77 WELLESLEY STREET WEST P.O. BOX 977<br>
TORONTO, ONTARIO M7A 1N3<br>
416-314-0500 OR ISP.TCU@ONTARIO.CA

</p>
<p><strong>CONSENT</strong><br>
By signing below, I hereby consent to (check boxes that apply)
</p>
<p><img src="../../images/cross.png" width="11">  The Ministry’s collection of my personal information from the institution at which I am enrolled or applying to be enrolled to assess the institution’s current and future applications for designation under the International Student Program.<br><br>
<img src="../../images/cross.png" width="11">   The Ministry’s collection of my personal information from the institution at which I am enrolled or applying to be enrolled to assess the institution’s ongoing compliance with the terms and conditions of designation if Ontario designates it</p>


<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:500px;"><span><strong>Name: </strong></span><p style=" width:500px;"></p></div>
</div></td>

 </tr>
</table><br><br>

<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:150px;"><b>Signature</b><span></span>	</div></div></td>

  <td><div class="acknowledge" style=" width:150px;" > <div  style=" width:150px; text-align:center"><span>Date:</span><p></p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD)</p></div></div> </td>
 </tr>
</table>


<p style="text-decoration:underline;"><strong>For students under 16 years of age, the parent or guardian must also sign.</strong></p>


<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:500px;"><span><strong>Name of Parent/Guardian:</strong></span><p style=" height:20px; width:500px;"></p></div>
</div></td>

 </tr>
</table><br><br>

<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:150px;"><b>Signature</b><span></span>	</div></div></td>

  <td><div class="acknowledge" style=" width:150px;" > <div  style=" width:150px; text-align:center"><span>Date:</span><p></p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD)</p></div></div> </td>
 </tr>
</table>
<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page 5 of '.$total_pages.'</span></span></div>

';

$output .= '</div>';	





$output .= '<div class="firstrow">	<header>	
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div></div></header>	
<h4 style="text-align:center; ">FEE REFUND POLICY AS PRESCRIBED UNDER S.25 TO 33 OF O.REG. 415/06
</h4>

<p style=" margin-top:2px;margin-bottom:0px;"><strong>FULL REFUNDS</strong>
</p><b class="counting">25.</b> 
<ul class="ul-count-list"><li><span> a private career college shall refund all of the fees paid by a student under a contract for the provision of a vocational program in the following circumstances:</span>

<ul><li><span>A person rescinds the contract within two days of receiving a copy of the contract by section 36 of the Act.
</span></li><li><span>	The private career college discontinues the vocational program before the student completes the program, subject to subsection (2).</span>
</li><li><span>	The private career college charges or collects the fees,</span>
<ul><li><span>	Before the registration was issued for the college under the Act or before the vocational program was approved by the Superintendent, or</span>
</li><li><span>Before entering into a contract for the provision of the vocational program with the student, unless the fee is collected under subsection 44 (3).</span>
</li></ul></li>


<li>	<span>The private career college expels the student from the college in a manner or for reasons that are contrary to the college’s expulsion policy.</span>
</li><li>	<span>The private career college employs an instructor who is not qualified to teach all or part of the program under section 41.</span>
</li><li><span>The contract is rendered void under subsection 18 (2) or section 22.</span>
</li><li>	<span>If a private career college fails to, or does not accurately, provide in the itemized list provided to the Superintendent under section 43 a feed item corresponding to a fee paid by a student for the provision of a vocational program, the college shall pay the student,</span>

<ul><li>	<span>In the case of an item not provided by the college, the full amount of the fee for the item, and</span>
</li><li><span>	In the case of a fee more than the amount of the fee provided for the item, the difference between the amount of the fee for the item provided to the Superintendent and the fee collected.</span>
</li></ul>
</li>
</ul></li>

<li><span>A full refund is not payable in the circumstances described in paragraph 2 of subsection (1) if the discontinuance of the vocational program coincides with the private career college ceasing to operate.</span>
</li><li><span>A refund is not payable under paragraphs 1 to 6 of subsection (1) unless the student gives the private career college a written demand for the refund.</span>
</li><li><span>A refund under subsection (1) is payable by the private career college within 30 days of the day the student delivers to the college,
</span>
<ul class="list-alfa"><li><span>
	In the case of rescission under section 36 of the Act, notice of the rescission; or</span>
</li><li>	<span>In the case of a refund under paragraphs 2 to 6 of subsection (1), a written demand for the refund.</span>

</li></ul>
</li></ul>





<p style=" margin-bottom:0px;"><strong>PARTIAL REFUND WHERE THE STUDENT DOES NOT COMMENCE THE PROGRAM</strong>
</p><b class="counting">26.</b> 
<ul class="ul-count-list"><li> <span> If a student is admitted to a vocational program, pays fees to the private career college in respect of the program and subsequently does not commence the program, the college shall refund part of the fees paid by the student in the following circumstances:</span>
<ul class="list-alfa"><li>	<span>The student gives the college notice that he or she is withdrawing from the program before the day the vocational program commences.</span>
</li><li>	<span>	The student does not attend the program during the first 14 days that follow the day the program commenced,and the college gives written notice to the student that it is canceling the contract no later than 45 days after the day the program has commenced.</span>
</li>
</ul></li>


<li><span>The amount of a refund under subsection (1) shall be an amount that is equal to the full amount paid by the student for the vocational program, less an amount equal to the littlest of 20 percent of the full amount of the fee and $500.</span>
</li><li><span>A refund under subsection (1) is payable,</span>
<ul class="list-alfa"><li><span>In the case of a refund under paragraph 1 of subsection (1), within 30 days of the day, the student gives notice of withdrawing from the program;</span>
</li><li><span>In the case of a refund under paragraph 2 of subsection (1), within 30 days of the day, the vocational program commences; and</span>
</li><li>	<span>In the case of a refund under paragraph 3 of subsection (1), within 45 days of the day, the vocational program commences.</span>
</li></ul>

</li>
<li>	<span>For paragraph 3 of subsection (1); it is a condition of a contract for the provision of a vocational program that the private career college may cancel the contract within 45 days of the day the vocational program commences.If the person who entered the contract with the college fails to attend the program during the 14 days that follow the day the vocational program commences.</span>
</li><li><span>A private career college that wishes to cancel a contract by subsection (4) shall give written notice of the cancellation to the other party to the contract within 45 days of the day the vocational program commences.</span>

</li></ul>

<p style=" margin-bottom:0px;"><strong style=" margin-bottom:0px;">PARTIAL REFUNDS: WITHDRAWALS AND EXPULSIONS AFTER PROGRAM COMMENCED</strong></p>

<b class="counting">27. </b>
<ul class="ul-count-list"><li> <span> A private career college shall give a student who commences a vocational program a refund of part of the fees paid in respect of the program if, at a time during the program determined under subsection (3),</span>
<ul class="list-alfa"><li>	<span>	The student withdraws from the program after the program has commenced; or</span>
</li><li>	<span>	The student is expelled from the program in circumstances where the expulsion is permitted under the private career college’s expulsion policy.</span>
</li>
</ul></li>


<li><span>This section does not apply to vocational programs described in sections 28 and 29</span>
</li><li><span>	A private career college shall pay a partial refund under this section only if the withdrawal or expulsion from the vocational program occurs at a time during the program determined by the following rules:</span>

<ul><li><span>	In the case of a vocational program that is less than 12 months in duration, the withdrawal or expulsion occurs during the first half of the program.</span>
</li><li><span>	In the case of a vocational program, that is 12 months or more in duration,</span>
<ul><li><span>For the first 12 months in the duration of the program and every subsequent full 12 months in the program, the withdrawal or expulsion occurs during the first six months of that 12-month period, and</span>
</li><li><span>	For any period in the duration of the vocational program remaining after the last 12-month period referred to in sub paragraph,(I) has elapsed, the withdrawal or expulsion occurs in the first half of the period.</span>
</li></ul></li></ul></li></ul>
<div class="footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:0px;"> Page 6 of '.$total_pages.'</span></span></div>
';

$output .= '</div>';	
$output .= '<div class="firstrow">	<header>
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>
<div class="header-text">
<div class="line3"></div></div>
</header><ul class="ul-count-list"><li style="list-style:none;">
<ul><li style="list-style:none;"></li>
<li style="list-style:none;"></li>
<li><span>	If the student withdraws or is expelled from a vocational program within the first half of a period referred to in subsection (3), the amount of the refund that the private career college shall pay the student shall be equal to the full amount of the fees paid in respect of the program less,</span>
<ul class="list-alfa"><li><span>	An amount that is equal to the lesser of 20 percent of the full amount of the fees in respect of the program and $500; and</span>
<li></li><span>	
The portion of the fees in respect of the portion of the period that had elapsed at the time of the withdrawal or expulsion.</span>	
</li>

<li><span>	If the student withdraws or is expelled from a vocational program during the second half of a period referred to in subsection (3), the private career college is not required to pay the student any refund in respect of that period.</span>
</li>
<li><span>		A private career college shall refund the full amount of fees paid in respect of a period that had not yet commenced at the time of the withdrawal or expulsion.</span></li>
</ul></li>
</ul>
<div class="margin-left">
<p style=" margin-bottom:0px;margin-top:3px;"><b>PARTIAL REFUNDS: DISTANCE EDUCATION PROGRAMS</b></p>
<b class="counting">28.</b>
<ul class="ul-count-list">
<li><span>this section applies to a vocational program that is offered by mail, on the internet or by other similar means.</span></li>
<li><span>A private career college shall give a student who commences a vocational program referred to in subsection (1) a refund of part of the fees paid in respect of the program if,</span>

<ul class="list-alfa"><li><span>The student withdraws from the program or the student is expelled from the program in circumstances where the expulsion is permitted under the private career college’s expulsion policy; and</span>
</li>	<li><span>At the time of the withdrawal or expulsion, the student has not submitted to the private career college all examinations that are required to complete the program.</span>
</li></ul></li>

<li><span>The amount of the refund that a private career college shall give a student under subsection (1) shall be determined by the following rules</span>

<ul><li><span>Determine the total number of segments in the vocational program for which an evaluation is required.</span>
</li>	<li><span>Of the total number of program segments determined under paragraph 1, determine the number of segments in respect of which evaluation has been returned to the student.</span>
</li>	<li>	<span>The amount of the refund that the private career college shall pay the student shall be equal to the full amount of the fees paid in respect of the program less,</span>
<ul><li>		<span>An amount that is equal to the lesser of 20 percent of the full amount of the fees in respect of the program and $500, and	/<span></li>
	<li>	<span>The portion of the fees in respect of the number of segments determined under paragraph 2.	</span>
</li><ul></li></ul></li>
<li><span>A private career college is not required to give a student any refund if the student, at the time of withdrawal or expulsion, has been evaluated in respect of more than half of the total number of segments in the program.
</span></li></ul>
<p style=" margin-bottom:0px;margin-top:3px;"><b>PARTIAL REFUNDS: NON-CONTINUOUS PROGRAMS</b></p>

<b class="counting">29</b>
<ul class="ul-count-list"><li>	<span>this section applies to a vocational program approved by the Superintendent to be provided through a fixed number of hours of instruction over an indeterminate period.	</span></li>
<li>		<span>A private career college shall give a student who commences a vocational program referred to in subsection (1) a refund of part of the fees paid in respect of the program if, before completing the required number of hours of instruction,	</span>
<ul class="list-alfa"><li>	<span>The student has given the college notice that he or she is withdrawing from the program; or	</span></li><li>	<span>
The student is expelled from the program in circumstances where the expulsion is permitted under the private career college’s expulsion policy.	</span></li></ul>
</li>
<li>	<span>The amount of the refund that a private career college shall give a student under subsection (1) shall be equal to the full amount of the fees paid in respect of the program less,	</span>
<ul class="list-alfa"><li>		<span>An amount that is equal to the lesser of 20 percent of the full amount of the fees in respect of the program and $500; and	</span></li>
<li><span>A portion of the fees in respect of the program that is proportional to the number of hours of instruction that have elapsed at the time of the withdrawal or expulsion.</span></li></ul></li>
<li>	<span>A private career college is not required to give a student any refund if the student, at the time of withdrawal or expulsion, has completed more than half of the required number of hours of instruction in a program.</span></li>
</ul>
<p style=" margin-bottom:0px;margin-top:3px;"><b>NO RETENTION OF REFUND</b></p>
<b class="counting">30.</b>
<ul class="un-list" style="margin-bottom:5px;"><li>	<span>A private career college shall not retain, by way of deduction or set-off, any refund of fees payable to a student under sections 25 to 29 to recover an amount owed by the student in respect of any service or program other than a vocational program offered by the private career college.</span></li></ul>
<p style="margin-bottom:0px;margin-top:3px;"><b>TREATMENT OF BOOKS AND EQUIPMENT</b></p>
<b class="counting">31.	</b>
<ul class="un-list"  style="margin-bottom:5px;"><li><span>In calculating a refund under sections 25 to 29, a private career college may retain the retail cost of books or equipment that the private career college supplied to the student if the student,</span>
<ul class="list-alfa"><li><span>Fails to return the books or equipment to the private career college within ten days of the student’s withdrawal or expulsion from the program, or</span>
</li><li><span>	Returns the books or equipment to the private career college within the 10-day period referred to clause (a), but fails to return it unopened or in the same state it was in when supplied.</span>
</li></ul></li></ul>
<p style=" margin-bottom:0px;margin-top:3px;"><b>REFUND FOR INTERNATIONAL STUDENTS</b></p>
<b class="counting">32.	</b>
<ul class="un-list"  style="margin-bottom:5px;"><li><span>A notice to a private career college that is provided by or on behalf of an international student or of a prospective international student and that states that the student has not been issued a temporary resident visa as a member of the student class under the Immigration and Refugee Protection Act (Canada) is deemed to be,</span>
<ul class="list-alfa"  style="margin-bottom:5px;"><li><span>Notice of a rescission of the contract for section 36 of the Act if the notice is given within two days of receiving a copy of the contract; and</span></li>
<li>	<span>Notice that the student is withdrawing from the program for paragraph 1 of subsection 26 (1) or clause 29 (2)  if the notice is received on or before half of the duration of the program has elapsed</span>
</li></ul></li></ul>
<p style=" margin-bottom:0px;margin-top:3px;"><b>CURRENCY</b></p>
<b class="counting">33.	</b>
<ul class="un-list"><li>Any refund of fees that a private career college is required to pay under the Act shall be paid in Canadian dollars</li></ul>


<div class="footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:1px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:5px; margin-top:0px;"> Page 7 of '.$total_pages.'</span></span></div>
</div>
';

$output .= '</div>';	





$output .= '<div class="firstrow">	<header>
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>
</div></header>
<h4 id="heading" style="margin:10px;">TERMS AND CONDITIONS OF ENROLLMENT</h4>

<ul class="ul-count-list ul-count-list1" style="margin-bottom:0px;"><li><span>All program fees are due and payable on commencement of the program unless specific arrangements have been made with the Admissions Office.</span>
</li><li><span>		Financial assistance may be available to those who qualify.  Check with the Admissions Office for details.</span>
</li><li><span>	To register for and to reserve a seat in any diploma program, all applicants must include the minimum required payment, as per the PCC Act, 2005 for the program which will be applied to the program fee, the balance of which is to be paid as per the student payment schedule.</span>
</li><li><span>		Program fees are tax-deductible,and the guidelines of the federal government will issue a tax certificate.
</span>
</li><li><span>		Certain courses can only be enrolled in, once prerequisite courses or equivalents have been taken.  Refer to the course outline of each program for prerequisites, or consult one of our Admissions Officers.
</span>
</li><li><span>		No refund will be given for occasional absences from scheduled classes.
</span>
</li><li><span>		Course Credit is not given until all financial obligations to Academy of Learning College have been met.
</span>
</li><li><span>	All courses are held subject to sufficient enrollment and may be postponed at the discretion of the school, and any fees paid will be credited to that future course or refunded according to the PRIVATE CAREER COLLEGES ACT.
</span>
</li><li><span>	If an applicant is unable to commence a program on the date arranged, the applicant must notify the Admissions Office as early as possible to arrange an alternate commencement date and any fees paid will be credited to that future program or refunded according to the PRIVATE CAREER COLLEGES ACT.
</span>
</li><li><span>	The duration of the program as shown in the program outline indicates the time it should take the student to complete the program.  If the student finishes the program in less than the time that is stated, the total program fee is still applicable.  If the student takes longer than the time as indicated, the student may be charged additional fees based on the tuition rate in effect at that time, solely at the discretion of the Admissions Office.
</span>
</li><li><span>	Rather than conventional classroom instruction, a student works as an individual, using a computer (where applicable) and workbooks combined with audio instruction in a systematic process. A trained facilitator is always present to give individualized help as needed by each student.
</span>
</li><li><span>		A student enrolled in online courses works as an individual, using a computer and workbooks and instruction and guidance from the facilitator or the online instructor.
</span>
</li><li><span>		The student may choose the hours of attendance which suit his/her circumstances and may put in additional hours without extra charge, providing that arrangements have been made to reserve a computer for this purpose. However, the student is obligated to complete the program within the period determined by the given end-date and the college’s guidelines for completing individual courses; the school must approve any extension. The setting of a completion date may be determined by requirements for financial support such as a government student loan or grant.
</span>
</li><li><span>		It is to the student’s advantage to arrive at least 5 minutes before the start of each class.
</span>
</li><li><span>	Academy of Learning College is not responsible for the loss of personal property or personal injury from whatever cause.
</span>
</li><li><span>		The applicable Terms and Conditions above shall apply to all programs of Academy of Learning College.
</span>
</li><li><span>		Students and Academy of Learning College are required to follow the provisions of the current edition of the “Student Handbook.”
</li></ul>


<div class=" footer" ><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page 8 of '.$total_pages.'</span></span></div>

';

$output .= '</div>';	





$output .= '<div class="firstrow">	<header>
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>

</div></header>
<h5 class="last-h4">This is to confirm that Academy of Learning Career College has informed me that <span style="text-decoration:underline;">international students who <br>graduate from diploma programs at Private Career Colleges are not<br> currently able to receive Post Graduate Work Permits (PGWP).<br></span> I have also been informed to contact a Registered Immigration<br> Consultant or an Immigration Lawyer for immigration advice.</h5>
<div class="table-width">
<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:200px; text-align:center"><p style=" width:200px;">'.$fname.' '.$lname.'</p><Br><Br>
<p style=" margin-top:-15px; border:none; text-align:center">Students Name (print)
</p></div></td>

  <td><div class="acknowledge"> <div  style=" width:200px; text-align:center"><span style="text-decoration:underline;">X</span><p style=" width:200px;"> </p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">(Signature of Student)</p></div></td>
 </tr>
</table>
<br><br><br><br>



<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:400px; text-align:center"><span>Date:</span><p style=" width:400px;"> </p><Br><Br>
<p style=" margin-top:-15px;  text-align:center; border:none;">YYYY/MM/DD</p></div></td>

 </tr>
</table></div>

<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page 9 of '.$total_pages.'</span></span></div>
';

$output .= '</div>';

if(!empty($pro_name_dual_sno)){
	$query3 = "SELECT * FROM cc_date_wise_fee WHERE crs_id='$pro_name_dual_sno'";
}else{
	$query3 = "SELECT * FROM cc_date_wise_fee WHERE crs_id='$crs_sno'";
}
$result3 = mysqli_query($con, $query3);
if(mysqli_num_rows($result3)){

$output .= '<div class="firstrow">	<header>
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>

</div></header><h4 id="heading" style=" text-decoration:underline; margin-top:10px; margin-bottom:15;">APPENDIX 1: PAYMENT SCHEDULE</h4>
<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:400px; text-align:center"><span>Name of Program:</span><p style=" width:400px;"> <b>'.$program_name.'   			
</b></p></div></td>

 </tr>
</table>
<p style=" font-size:14px; margin-top:30px;"><b>Schedule:</b> &nbsp; Full Time:  Monday to Friday 8am-10pm     Saturday to Sunday 10am-6pm </p>
<table width="100%" border="0" align="center">
 <tr>
  <td valign="top"><div class="acknowledge"> <div  style=" width:300px; text-align:center"><span><b>Student Name:</b></span><p style=" width:230px;">'.$fname.' '.$lname.' </p><Br><Br>
<p style=" margin-top:-15px;width:230px;float:right;  text-align:center; border:none;">First name/ Middle name / Last name</p></div></td>
 <td valign="top"><div class="acknowledge"> <div  style=" width:250px; text-align:center"><span><b>Student #:</b></span><p style=" width:250px;">AOL '.$student_id_2.'</p>
</div></td>

 </tr>
</table>
<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:400px; text-align:center"><span><b>Admission Advisor Name: </b></span><p style=" width:400px;"> <b>'.$username.'</b></p></div></td>

 </tr>
</table><br>
<p style="text-transform:uppercase; margin-bottom:5px;"><strong>Funding Information</strong></p>

<p class="funding"><span class="mr1"><span> <img src="../../images/box.png" width="10"> </span>  OSAP (if eligible)</span>
<span class="miss1"><span> <img src="../../images/box.png" width="10"> </span> Second Career </span>
<span class="mrs1"><span> <img src="../../images/cross.png" class="cross" width="10"> </span> Self-Funded </span>
<span class="ms1"><span> <img src="../../images/box.png" width="10">  </span> Third-party Funded </span>
<span class="birth-date1"><span> <img src="../../images/box.png" width="10">  </span> Other: <span>______________</span></span></p>
<p><b>* Note:</b> Dates and Disbursement amounts are estimates and are subject to change based on final OSAP eligibility.</p>
<h4 id="heading" style=" margin-top:20px; margin-bottom:10px;">PAYMENT SCHEDULE</h4>
<table width="100%" class="table2" style=" border-collapse: collapse;" border="1">
 <tr>
  <th colspan="7" align="center"><b>For Office Use Only</b></th><th rowspan="8"></th>

 </tr>
 <tr>
  <th></th>
  <th>Total</th>
  <th>International fees</th>
  <th>Books **</th>
  <th>Compulsory fees</th>
  <th>Tuition fees</th>
  <th rowspan="2">Invoice code</th>  
 </tr>
 <tr><th>Contract value</th>
  <th>'.$total_fee.'</th>
  <th>'.$int_fee.'</th>
  <th>'.$books_est.'</th>
  <th>'.$other_fee.'</th>
  <th>'.$tuition_fee.'</th>
 </tr>
 <tr>
 	<th>Due date</th>
 	<th></th>  
 	<th></th>  
 	<th></th>  
 	<th></th>  
 	<th></th>
 	<th></th>
 </tr>';  

while ($rowstr3 = mysqli_fetch_assoc($result3)){
$due_date = $rowstr3['due_date'];
$total_fee_23 = $rowstr3['total_fee'];
$int_fee_23 = $rowstr3['int_fee'];
$book_23 = $rowstr3['book'];
$comp_fees_23 = $rowstr3['comp_fees'];
$tuition_fees_23 = $rowstr3['tuition_fees'];
$invoice_code_23 = $rowstr3['invoice_code'];
 $output .= '<tr>
	<td>'.$due_date.'</td>
	<td>'.$total_fee_23.'</td>
	<td>'.$int_fee_23.'</td>
	<td>'.$book_23.'</td>
	<td>'.$comp_fees_23.'</td>
	<td>'.$tuition_fees_23.'</td>
	<td>'.$invoice_code_23.'</td>
 </tr>';
}


 $output .= '
 <tr>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td rowspan="4" style="padding:0px;"><table bgcolor="#eee" style="border-collapse: collapse; border:0px !important;  margin:0px;" border="0">
<tr><td colspan="2" style="border:0px;font-size:11px;">Invoices match contract value?</td></tr>
<tr><td style="border:0px;font-size:10px;">Intl fees</td><td style="border:0px;font-size:10px;"> Yes </td></tr>
<tr><td style="border:0px;font-size:10px;">Books</td><td style="border:0px;font-size:10px;"> Yes </td></tr>
<tr><td style="border:0px;font-size:10px;">Comp fees</td><td style="border:0px;font-size:10px;"> Yes </td></tr>
<tr><td style="border:0px;font-size:10px;">Tuition fees</td><td style="border:0px;font-size:10px;"> Yes </td></tr>
  </table> </td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td></td>
  <td> 	</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td></td>
  <td> 	</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>

 <tr>
  <td>Total invoices</td>
  <th>'.$total_fee.'</th>
  <th>'.$int_fee.'</th>
  <th>'.$books_est.'</th>
  <th>'.$other_fee.'</th>
  <th>'.$tuition_fee.'</th>
  <td></td>
 </tr>


</table>
<p><b>** Note:</b> Estimated amount only. Actual cost may vary based on the prevailing market price at the time of book purchase.</p>
<p style="font-size:13px;">Payments must be made on or before the scheduled dates or a Late Fee Charge of $25.00 will be applied. <br>Students paying through installments are required to issue post-dated cheques and/or provide credit card number to the Student Financial Aid Office. <br>
Cheques returned by the bank for any reason are subject to an additional Administration Fee of $30.00. <br>
Late Payment Fee - $25.00 &nbsp; &nbsp; &nbsp; NSF Fee - $30.00</p>
<h4>The undersigned student hereby undertakes and agrees to pay, or see to payment of, the fees indicated above in accordance with the terms of this Enrolment Contract.</h4>
<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:200px; text-align:center"><p style=" width:200px;"><b>'.$fname.' '.$lname.'			
</b></p><Br><Br>
<p style=" margin-top:-15px; border:none; width:200px; text-align:center">Name: Student
</p></div></td>

  <td><div class="acknowledge"> <div  style=" width:200px; text-align:center"><p style=" width:200px;"> </p><Br><Br>
<p style=" margin-top:-15px;   width:200px;text-align:center; border:none;">Signature: Student</p></div></td>
<td><div class="acknowledge"> <div  style=" width:200px; text-align:center"><p style=" width:200px;"> </p><Br><Br>
<p style=" margin-top:-15px;  width:200px; text-align:center; border:none;">Date</p></div></td>
 </tr>
</table>

<table width="100%" border="0" align="center">
 <tr>
  <td><div class="acknowledge"> <div  style=" width:200px; text-align:center"><p style=" width:200px;"><b>'.$fname.' '.$lname.'			
</b></p><Br><Br>
<p style=" margin-top:-15px; border:none; width:200px; text-align:center">Name: Financial Planner
</p></div></td>

  <td><div class="acknowledge"> <div  style=" width:200px; text-align:center"><p style=" width:200px;"> </p><Br><Br>
<p style=" margin-top:-15px;   width:200px;text-align:center; border:none;">Signature: Financial Planner</p></div></td>
<td><div class="acknowledge"> <div  style=" width:200px; text-align:center"><p style=" width:200px;"> </p><Br><Br>
<p style=" margin-top:-15px;  width:200px; text-align:center; border:none;">Date</p></div></td>
 </tr>
</table>

<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page 10 of '.$total_pages.'</span></span></div>
<!----div class=" footer" style="padding-top:0px;">
<hr/ style="margin-top:0px;"><p style="text-align:center;">Academy of Learning, 600 - 1255 Bay Street, Toronto, ON M5R 2A9 www.aoltoronto.com </p>
 <span class="student-int" style="float:right; width:200px;"><span style=" float:right;">APPENDIX 1
 </span>
</div---->
';

$output .= '</div>';

}

if(($pn == 'Personal Support Worker' && $campus == 'Toronto') || ($pro_name_dual == 'Personal Support Worker' && $pro_name_dual_campus == 'Hamilton')){
	$output .= '<div class="firstrow">	<header>
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>

</div></header><h4 id="heading" style="  margin-top:10px; margin-bottom:15;">PRACTICUM REQUIREMENTS – PERSONAL SUPPORT WORKER</h4>

<div class="acknowledge" style=" margin-bottom:0px;"><span>I, </span> <p style="  margin-top:-2px;margin-bottom:0px;"> '.$fname.' '.$lname.'</p>(student name), acknowledge that it is my responsibility to have the practicum requirements, as listed below, in place before I can begin my practicum to complete the Personal Support Worker program and receive credentials:</div>
<ul style="margin-bottom:0px; margin-top:0px;"><li>
	Minimum mark of 70% in each PSW Module with no evaluation method below 70%; and </li><li>
	Minimum mark of 70% with no critical deficiencies in each of the skills Performance Demonstrations; and</li><li>
	Minimum mark of 60% in each ILS course; </li><li>
	Satisfactory attendance record; and </li><li>
	Current Standard First Aid and Basic Rescuer (Level C) CPR Certification; and </li><li>
	Resume and Placement Preference Sheet at least 30 days prior to placement; and </li><li>
	Interview by Host may be required prior to placement.
</li></ul>
<p  style="margin-top:0px;"> I further understand that I will NOT engage in a practicum if any of the program practicum requirements, as listed above, are not met prior to placement.</p>

<table width="100%" border="0" align="center">
 <tr>
  <td valign="top"><div class="acknowledge"> <div  style=" width:300px; text-align:center"><p style=" width:300px;"> </p><Br><Br>
<p style=" margin-top:-15px;width:300px;float:right;  text-align:center; border:none;">Signature of Student</p></div></td>
 <td valign="top"><div class="acknowledge"> <div  style=" width:250px; text-align:center"><span><b>Date :</b></span><p style=" width:250px;"> ngkf </p><Br><Br>
<p style=" margin-top:-15px;width:230px;float:right;  text-align:center; border:none;">(mm/dd/yyyy)</p>
</div></td>

 </tr>
</table>
<p style=" text-align:center;"><b>Vulnerable Sector Disclaimer</b></p>
<p>As this program will involve direct contact with vulnerable individuals, you must complete a clean Vulnerable Sector Screening (“VSS”) prior to commencing any placement or practicum. It is strongly advised that you complete your VSS prior to commencing your vocational training to ensure that you can complete this program and are eligible for a placement or practicum and, subsequently, graduation. 
<br><br>
As a VSS can take 10 to 12 weeks to complete, if you choose not to complete a VSS prior to commencing this program, please plan your time accordingly to ensure that you have obtained documentation of a clean VSS prior to applying for a placement or practicum. If you ignore this caution, you risk being ineligible for a placement or practicum, ineligible to graduateand potentially only eligible for a partial refund or no refund of tuition for this program if you fail to graduate.  <br><br>

A VSS involves a search of the Vulnerable Sector Database, maintained by the Ontario Provincial Police, for any information about you in police files, including criminal convictions, outstanding charges, and information about whether you are suspected of committing a criminal offence or involved in a serious criminal investigation. Police databases will also document any contact that you may have had with police services under the Mental Health Act, 1990. 
<br><br>
You must also ensure that you do not engage in any activities at anytime during the program, including while undertaking a placement or practicum that would render a clean VSS previously submitted by you void.  Failure to maintain a clean VSS will also render you unable to undertake or continue the placement or practicum, ineligible for graduation and only eligible for a partial refund or no refund of tuition, depending on when you withdraw or are expelled from the program.
</p>
<div class="acknowledge" style=" margin-bottom:0px;"><span>I, </span> <p style="  margin-top:-2px;margin-bottom:0px;"> '.$fname.' '.$lname.'</p>acknowledge that I have
read the above disclosure and understand that I need to obtain a clean VSS  prior to applying for a placement or practicum and that I must, while enrolled in the program, maintain a clean VSS in order to complete the placement or practicum and to graduate. I also understand that if I do not obtain or maintain a clean VSS, I risk: <b> 1. being ineligible for placement or continued placement; 2. ineligible to graduate; 3. eligible for a partial refund or no refund of tuition, depending on when I withdraw or am expelled from this program.  </b><br><br>

Further information regarding the Police Reference Check Program and the VSS process can be viewed at <a href="http://www.torontopolice.on.ca/prcp/" target="blank">http://www.torontopolice.on.ca/prcp/</a>.   
</div>

<table width="100%" border="0" align="center" style="margin-top:50px;">
 <tr>
  <td valign="top"><div class="acknowledge"> <div  style=" width:300px; text-align:center"><p style=" width:300px;"> </p><Br><Br>
<p style=" margin-top:-15px;width:300px;float:right;  text-align:center; border:none;">Signature of Student</p></div></td>
 <td valign="top"><div class="acknowledge"> <div  style=" width:250px; text-align:center"><span><b>Date :</b></span><p style=" width:250px;"> ngkf </p><Br><Br>
<p style=" margin-top:-15px;width:230px;float:right;  text-align:center; border:none;">(mm/dd/yyyy)</p>
</div></td>

 </tr>
</table>
<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page '.$countPage_11.' of '.$total_pages.'</span></span></div>
';

$output .= '</div>';

}


$output .= '<div class="firstrow">	<header>
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>

</div></header><h4 id="heading" style="  margin-top:10px; margin-bottom:15;">Sexual Violence Policy  </h4>
<ul class="list-alfa"><li><span>Academy of Learning Career College is committed to providing its students with an educational environment free from sexual violence and treating its students who report incidents of sexual violence with dignity and respect.  
</span>
</li><br><br><li><span> Academy of Learning Career College has adopted this Sexual Violence Policy, which defines sexual violence and outlines its training, reporting, investigative and disciplinary responses to complaints of sexual violence made by its students that have occurred on its campus, or at one of its events and involve its students. </span>
</li><br><br><li>	<span>The person accused of engaging in sexual violence will be referred to as the “Respondent” and the person making the allegation as the “Complainant”. </span>
</li></ul>
<p>2.  Definition of Sexual Violence </p>
<p>Sexual violence means any sexual act or act targeting a person’s sexuality, gender identity or gender expression, whether the act is physical or psychological in nature, that is committed, threatened or attempted against a person without the person’s consent, and includes sexual assault, sexual harassment, stalking, indecent exposure, voyeurism and sexual exploitation. </p>
<p>3.  Training, Reporting and Responding to Sexual Violence </p>
<ul class="list-alfa"><li>
  Academy of Learning Career College shall include a copy of the Sexual Violence Policy in every contract made between it and its students, and provide a copy of the Sexual Violence Policy to career college management (corporate directors, controlling shareholders, owners,  partners,  other persons who manage or direct the career college’s affairs, and their agents), instructors, staff, other employees and contractors and train them about the policy and its processes of reporting, investigating and responding to complaints of sexual violence involving its students. *Any company participating in offering student internships on their premises must provide an undertaking in writing that it is in compliance with all applicable legislation, including the Ontario Human Rights Code and the Occupational Health and Safety Act and will provide students access to those policies should they encounter issues relating to sexual violence in the workplace.  
</li><br><br><li>  The Sexual Violence Policy shall be published on its website. 
</li><br><br><li> Career college management, instructors, staff, other employees and contractors of Academy of Learning Career College will report incidents of or complaints of sexual violence to the Campus Director upon becoming aware of them.  
</li><br><br><li>  Students who have been affected by sexual violence or who need information about support services should contact the Campus Director. 
</li><br><br><li> Subject to Section 4 below, to the extent it is possible, Academy of Learning Career College will attempt to keep all personal information of persons involved in the investigation confidential except in those circumstances where it believes an individual is at imminent risk of self-harm, or of harming another, or there are reasonable grounds to believe that others on its campus or the broader community are at risk. This will be done by:<br><br>
<ul class="ul-roman-list"><li>	<span> Ensuring that all complaints/reports and information gathered as a result of the complaint/reports will be only available to those who need to know for purposes of investigation, implementing safety measures and other circumstances that arise from any given case; and </span>
</li><br><br><li><span>	Ensuring that the documentation is kept in a separate file from that of the Complainant/student or the Respondent. 
</span>
</li>
</ul><br><br></li>
<li>  Academy of Learning Career College recognizes the right of the Complainant not to report an incident of or make a complaint about sexual violence or not request an investigation and not to participate in any investigation that may occur. 
</li><br><br><li> Notwithstanding (f), in certain circumstances, Academy of Learning Career College may be required by law or its internal policies to initiate an internal investigation and/or inform police without the complainant’s consent if it believes the safety of members of its campus or the broader community is at risk. 
</li><br><br><li>  In all cases, including (f) above, Academy of Learning Career College will appropriately accommodate the needs of its students who are affected by sexual violence.  Students seeking accommodation should contact the Campus Director. <br><br>
In this regard, Academy of Learning Career College will assist students who have experienced sexual violence in obtaining counselling and medical care, and provide them with information about sexual violence supports and services available in the community as set out in Appendix 1 attached hereto.  Students are not required to file a formal complaint in order to access supports and services. </li>
</ul>

<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page '.$countPage_12.' of '.$total_pages.'</span></span></div>
';

$output .= '</div>';	



$output .= '<div class="firstrow">	<header>
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>

</div></header>
<p>4.  Investigating Reports of Sexual Violence  </p>
<ul class="list-alfa">
<li>  Under this Sexual Violence Policy, any student of Academy of Learning Career College may file a report of an incident or a complaint to the Campus Director in writing.  The other officials, offices or departments that will be involved in the investigation are Director of Operations, School Director and/or The President. 
</li><br><br><li> Upon receipt of a report of an incident or a complaint of alleged sexual violence being made, the Campus Director will respond promptly and: <br><br> 
<ul class="ul-roman-list"><li>
 determine whether an investigation should proceed and if the Complainant wishes to participate in an investigation; 
</li><br><br><li>  determine who should conduct the investigation having regard to the seriousness of the allegation and the parties involved; 
</li><br><br><li> determine whether the incident should be referred immediately to the police;  
In such cases or where civil proceedings are commenced in respect of allegations of sexual violence, Academy of Learning Career College may conduct its own independent investigation and make its own determination in accordance with its own policies and procedures; and 
</li><br><br><li> determine what interim measures ought to be put in place pending the investigation process such as removal of the Respondent or seeking alternate methods of providing necessary course studies.  
</li></ul>
</li><br><br>
<li>  Once an investigation is initiated, the following will occur<br><br>
<ul class="ul-roman-list"><li>  the Complainant and the Respondent will be advised that they may ask another person to be present throughout the investigation;  
</li><br><br><li>  interviewing the Complainant to ensure a complete understanding of the allegation and gathering additional information that may not have been included in the written complaint such as the date and time of the incident, the persons involved, the names of any person who witnessed the incident and a complete description of what occurred; 
</li><br><br><li>   informing and interviewing the Respondent of the complaint, providing details of the allegations and giving the Respondent an opportunity to respond to those allegations and to provide any witnesses the Respondent feels are essential to the investigation;  
</li><br><br><li>   interviewing any person involved or who has, or may have, knowledge of the incident and any identified witnesses;  
</li><br><br><li>  providing reasonable updates to the Complainant and the Respondent about the status of the investigation; and 
</li><br><br><li>  following the investigation, the Campus Director will: <br>
<p>(A)  review all of the evidence collected during the investigation;  
</p><p>(B)  determine whether sexual violence occurred; and if so </p>
<p>(C)  determine what disciplinary action, if any, should be taken as set out in Section 5 below. </p></li></ul></li>
</ul>
<p> 
5.  Disciplinary Measures </p>
<ul class="list-alfa"><li>  If it is determined by Academy of Learning Career College that the Respondent did engage in sexual violence, immediate disciplinary or corrective action will be taken. This may include:  <br><br>
<ul class="ul-roman-list"><li> disciplinary action up to and including termination of employment of instructors or staff; or  
</li><br><br><li>  expulsion of a student; and /or 
</li><br><br><li>   the placement of certain restrictions on the Respondent’s ability to access certain premises or facilities; and/or 
</li><br><br><li>   any other actions that may be appropriate in the circumstances.</li></ul>
</li></ul>

<p>6.  Appeal</p>
<ul class="list-alfa"><li>  Should the Complainant or the Respondent not agree with the decision resulting from the investigation, he or she may appeal the decision to the President within 10 days by submitting a letter addressed to the President advising of the person’s intent to appeal the decision. </li></ul>
<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page '.$countPage_13.' of '.$total_pages.'</span></span></div>
';

$output .= '</div>';	




$output .= '<div class="firstrow">	<header>
<img src="../../images/academy_of_learning_logo.png" class="logo">

<p class="headertop2">1069195 Ontario inc o/a Academy of Learning college<br/> 401 Bay Street, Suite 1000, 10th Floor, Toronto, On M5H 2Y4 </p>

<div class="header-text">
<div class="line3"></div>

</div></header>

<p>7.  Making False Statements </p>
<ul class="list-alfa">
<li> It is a violation of this Sexual Violence Policy for anyone to knowingly make a false complaint of sexual violence or to provide false information about a complaint.  
</li><br><br><li>  Individuals who violate this Sexual Violence Policy are subject to disciplinary and / or corrective action up to and including termination of employment of instructors or staff or expulsion of a student. </li></ul>
<p>8.  Reprisal </p>
<ul class="list-alfa">
<li>  It is a violation of this Sexual Violence Policy to retaliate or threaten to retaliate against a complainant who has brought forward a complaint of sexual violence, provided information related to a complaint, or otherwise been involved in the complaint investigation process.  
</li><br><br><li> Individuals who violate the Sexual Violence Policy are subject to disciplinary and /or corrective action, up to and including termination of employment of instructors or staff or expulsion of a student</li></ul>
<p>9.  Review  </p>
<ul class="list-alfa">
<li> Academy of Learning Career College shall ensure that student input is considered in the development of its Sexual Violence Policy and every time it is reviewed or amended.  
</li><br><br><li> Academy of Learning Career College shall review its Sexual Violence Policy 3 years after it is first implemented and amend it where appropriate. This date is January 1, 2020. </li></ul>
<p>10.  Collection of Student Data</p>
<ul class="list-alfa">
<li>  Academy of Learning Career College shall collect and be prepared to provide upon request by the Superintendent of Private Career Colleges such data and information as required according to Subsections 32.1 (8), (9), (10) and (11)of Schedule 5 of the Private Career Colleges Act, 2005 as amended. </li></ul>
<p><b>Appendix 1</b></p>
<p>The following represents a list of <span style="text-decoration:underline">Provincial Rape Crisis Centres:</span>  <br><br>  
Canadian Association of Sexual Assault Centres Ontario <br> English - Assaulted Women’s Helpline<br>  Toll Free: 1-866-863-0511 <br> #SAFE (#7233) on Bell, Rogers, Fido or Telus mobile <br> TTY: 416-364-8762 <br> www.awhl.org <br> <br> 
 
Français - Fem’aide <br> Telephone Toll-Free: 1-877-336-2433 <br> ATS: 1 866 860-7082<br>  www.femaide.ca <br> Sexual Assault/Domestic Violence Treatment Centres <br> <br> 
 
Sexual Assault/Domestic Violence Treatment Centres <br> <br> 
 
35 hospital-based centres that provide 24/7 emergency care to women - http://sadvtreatmentcentres.ca/ <br> <br> 
 
Sexual  Assault/Domestic Violence Treatment Centres -   http://www.satcontario.com/ 
 <br> <br> 
<span  style="text-decoration:underline">Local Centres</span> </p>
<table width="100%">
<tr>
<td valign="top">Toronto<br> Oasis Centre des Femmes<br> Téléphone: 416-591-6565<br> Courriel : services@oasisfemmes.org <br> http://oasisfemmes.org/  
 </td><td valign="top">Toronto Rape Crisis Centre: Multicultural<br> Women Against Rape <br>Crisis: 416-597-8808 <br>Office: 416-597-1171 <br>info@trccmwar.ca<br>  crisis@trccmwar.ca <br> www.trccmwar.ca <br> www.daso.ca
 </td>
</tr></table>
<div class=" footer"><span style=" float:left;">ON-2018</span> <span class="student-int" style="float:right; width:200px;"><span style=" float:left;">Student`s Initials </span>
<div style=" width:80px;  float:right;height:10px; border:1px solid #000; padding:3px 10px;"> &nbsp;</div><br><span style=" width:80px;  float:right;height:10px; margin-top:2px;"> Page '.$countPage_14.' of '.$total_pages.'</span></span></div>
';

$output .= '</div>';


$document->loadHtml($output);

//set page size and orientation

$document->setPaper('A4', 'potrait');

//Render the HTML as PDF

$document->render();

$contract_letter = $rowstr1['contract_letter'];
if($contract_letter !==''){
unlink("$contract_letter");
}

$firstname = str_replace(' ', '', $fname);

$olname = 'Contract_'.$firstname.'_'.$refid;

$filepath = "../../uploads/contract/$olname.pdf";

file_put_contents($filepath, $document->output());

mysqli_query($con, "update `st_application` set `contract_letter`='$filepath' where `sno`='$snoid'");

//Get output of generated pdf in Browser

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview

?>