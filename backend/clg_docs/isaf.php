<?php
include("../../db.php");

require_once '../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//initialize dompdf class

$document = new Dompdf();

$document->set_option('defaultFont', 'Courier');

$tk = $_POST['tk'];
$pn = $_POST['pn'];
$snoid = $_POST['snoid'];
$query1 = "SELECT fname,lname,refid,email_address,gender,dob,address1,address2,city,state,country,pincode, passport_no,pp_issue_date,pp_expire_date FROM st_application WHERE sno='$snoid'";
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
$getdob1 = date("Y",strtotime($dob)); 
$getdob2 = date("m",strtotime($dob)); 
$getdob3 = date("d",strtotime($dob));  
$address1 = $rowstr1['address1'];
$address3 = $rowstr1['address2'];
$city = $rowstr1['city'];
$state = $rowstr1['state'];
$country = $rowstr1['country'];
$pincode = $rowstr1['pincode'];
$passport_no = $rowstr1['passport_no'];
$pp_issue_date = $rowstr1['pp_issue_date'];
$pp_expire_date = $rowstr1['pp_expire_date'];

if($pn == 'Business Administration Diploma'){
	$poi1 = '<img src="../../images/tick.png" width="10">  Business Administration<br>';
}else{
	$poi1 = '<img src="../../images/box.png" width="10">  Business Administration<br>';
}
if($pn == 'Conference And Event Planner'){
	$poi2 = '<img src="../../images/tick.png" width="10">  Conference And Event Planner<br>';
}else{
	$poi2 = '<img src="../../images/box.png" width="10"> Conference And Event Planner<br>';
}
if($pn == 'Paralegal'){
	$poi3 = '<img src="../../images/tick.png" width="10">  Paralegal<br>';
}else{
	$poi3 = '<img src="../../images/box.png" width="10"> Paralegal<br>';
}
if($pn == 'Law Clerk'){
	$poi4 = '<img src="../../images/tick.png" width="10">  Law Clerk<br>';
}else{
	$poi4 = '<img src="../../images/box.png" width="10"> Law Clerk<br>';
}
if($pn == 'Network Administrator'){
	$poi5 = '<img src="../../images/tick.png" width="10">  Network Administrator<br>';
}else{
	$poi5 = '<img src="../../images/box.png" width="10"> Network Administrator<br>';
}
if($pn == 'Project Administration'){
	$poi6 = '<img src="../../images/tick.png" width="10">  Project Administration<br>';
}else{
	$poi6 = '<img src="../../images/box.png" width="10"> Project Administration<br>';
}
if($pn == 'Medical Office Assistant'){
	$poi7 = '<img src="../../images/tick.png" width="10">  Medical Office Assistant<br>';
}else{
	$poi7 = '<img src="../../images/box.png" width="10"> Medical Office Assistant<br>';
}
if($pn == 'Personal Support Worker'){
	$poi8 = '<img src="../../images/tick.png" width="10">  Personal Support Workers<br>';
}else{
	$poi8 = '<img src="../../images/box.png" width="10"> Personal Support Workers<br>';
}
if($pn == 'Logistics and Supply Chain Operations'){
	$poi9 = '<img src="../../images/tick.png" width="10">  Logistics and Supply Chain Operations<br>';
}else{
	$poi9 = '<img src="../../images/box.png" width="10"> Logistics and Supply Chain Operations<br>';
}


$output = "<style>@page { margin:25px 30px 25px;padding:10px;}
.firstrow1{width:100%;font-size:15px; color:#333;font-family:Arial, Helvetica, sans-serif;  page-break-after: always; position:relative; }
.logo1{margin:0; border:1px solid #fff; float:right;}
.header1 { width:100%; margin:0px;  text-align:center;}
.header1 h3 { font-size:22px; margin-bottom:0px;}
.header1 h6 { font-size:14px; margin-top:0px;margin-bottom:10px; }
.header1 p { font-size:12px; margin-top:0px; margin-bottom:10px; text-align:center; }
.heading3 { padding:1px 10px;font-size:17px; margin-top:0px; background:#810000; color:#fff;}
.heading2 { font-size:16px; margin-top:0px;  margin-bottom:0px;}
.heading3.center {text-align:center;}
.add-table td { font-size:11px; }
.form-table .form-table { padding:0px;margin:-10px 0px  0px;}
	 .form-table {margin:0px;}
     .form-table td { padding:0px; margin:0px; font-size:14px; } 

	 .form-table td p    {margin-top:0px; color:#000;}    
	footer { font-family:Times-Roman;
                position: fixed; font-size:15px;
                bottom: 0cm; 
                left: 0cm; color:#000;
                right: 0cm;
	 height: 60px; border:1px solid #333; background:#ccc;

	 /** Extra personal styles **/}

footer table td { padding-left:20px;padding-right:20px; font-size:13px;}


p.prog-list { margin-left:5px; font-weight:normal; margin-top:-10px !important; line-height:25px;}
.prog-list img {margin-right:5px;}
</style>";

$output .= '<div class="firstrow1">	
<div class="header1">

<table width="100%" border="0">
 <tr><td width="75%"><h3>International Student Application Form</h3>
 <h6><i>Please complete all sections of the form.</i></h6></td><td><img src="../../images/academy_of_learning_logo.png" width="170" class="logo1">
 <p>WWW.AOLTORONTO.COM</p></td><tr></table>


</div>

<h4 class="heading3">PERSONAL INFORMATION</h4>
<table width="100%" class="form-table">
 <tr>

 <td width="35%"><b style="float:left; width:240px; border-bottom:1px solid #333; height:15px;">'.$fname.'</b><br/><p><b> First/Given Name</b></p></td>
 <td width="30%"><b style="float:left; width:200px; border-bottom:1px solid #333; height:15px;"></b><br/><p><b> Middle Name(s)</b></p></td>
 <td width="35%"><b style="float:left; width:240px; border-bottom:1px solid #333; height:15px;">'.$lname.'</b><br/><p><b> Last/Family Name</b></p></td></tr>
  <tr>
  </table>
 <table width="100%" class="form-table"><tr>
 <td width="35%"><b style="float:left; width:98%; border-bottom:1px solid #333; height:15px;"></b><br/><p><b> Maiden Name</b> (if applicable)</p></td>
 <td width="40%"><b style="float:left; width:98%; border-bottom:1px solid #333; height:15px;">'.$email_address.'</b><br/><p><b> Email Address</b></p></td>
 <td width="25%"><p style="margin-top:-0px ;"><b style="float:left; width:60px;">Gender:</b> 
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
<td width="25%">Postal Code:</td>
</tr>
<tr><td width="25%" style="float:left; border-bottom:1px solid #333; border-left:1px solid #333;">'.$city.'</td>
<td width="25%" style="float:left; border-bottom:1px solid #333;border-left:1px solid #333; ">'.$country.'</td>
<td width="25%" style="float:left; border-bottom:1px solid #333;border-left:1px solid #333; height:25px;">'.$state.'</td>
<td width="25%" style="float:left; border-bottom:1px solid #333;border-left:1px solid #333; border-right:1px solid #333;">'.$pincode.'</td>
</tr>
</table><br>
<table width="100%" class="form-table"><tr><td valign="top"><h4 class="heading3 center">PASSPORT INFORMATION</h4>
<table width="100%"class="form-table">
 <tr>
 <td width="100%"><b style="float:left; width:100%; border-bottom:1px solid #333; height:15px;">'.$passport_no.'</b><br/><p>Passport Number</p></td></tr>
  
 <tr>
 <td width="100%"><b style="float:left;  width:100%; border-bottom:1px solid #333; height:15px;">'.$pp_issue_date.'</b><br/><p> Date of Issue</p></td>
</tr>
 </table>
  <table width="100%" class="form-table">
 <tr> 
 <td width="55%"><b style="float:left; width:90%; border-bottom:1px solid #333; height:15px;">'.$pp_expire_date.'</b><br/><p>Date of Expiry</p>
 </td>
 <td width="55%"><b style="float:left; width:90%; border-bottom:1px solid #333; height:15px;"></b><br/><p>Country of Birth</p>
 </td>
</table>  
<table width="100%" class="form-table">
 <tr>  
 <td width="100%"><b style="float:left; width:100%; border-bottom:1px solid #333; height:15px;"></b><br/><p>Country of Citizenship</p></td></tr>
   </tr></table>
   <table width="100%" class="form-table">
 <tr>

 <td width="25%"><p>Date of Birth:</p></td>
 <td width="15%" align="center"><b style="float:left;width:90%; border-bottom:1px solid #333; ; height:15px;">'.$getdob3.' </b>/<br/><p>DD</p></td>
 <td width="15%" align="center"><b style="float:left;  width:90%; border-bottom:1px solid #333;  height:15px;"></b>'.$getdob2.' /<br/><p>MM</p></td>
 <td width="15%" align="center"><b style="float:left;  width:90%; border-bottom:1px solid #333; height:15px;">'.$getdob1.'</b><br/><p>YEAR</p></td>
 <td width="30%"></td></tr>
  </table>
  </td>
  
  <td width="5%"></td>
  <td valign="top"><h4 class="heading3 center" style="margin-bottom:10px; ">PROGRAM OF INTEREST</h4>
  <p class="prog-list">
  '.$poi1.''.$poi2.''.$poi3.''.$poi4.''.$poi5.''.$poi6.''.$poi7.''.$poi8.''.$poi9.'
  </p>
  <table width="100%" class="form-table">
 <tr> 
 <td width="33%"><p> Other Program:</p></td>
<td><b style="float:left; width:100%; border-bottom:1px solid #333; height:15px;"></b></td>
</tr>
 </table>
 </td>
 </tr>
</table>
  <table width="100%" class="form-table"><tr><td  valign="top">
<h4 class="heading3 center">AGENT INFORMATION</h4>
<p>Do you want all your communication be sent to your agent?</p>
<table width="100%" class="form-table">
 <tr>
<td><img src="../../images/box.png" width="10"> Yes</td><td> <img src="../../images/box.png" width="10"> No</td><td><img src="../../images/box.png" width="10"> Not applicable</td></tr>
</table>
<br><table width="90%" class="form-table">
 <tr> <td width="45%"><p> Company/Agent Name:</p></td>


<td><b style="float:left; width:100%; border-bottom:1px solid #333; height:15px;"></b></td></tr>
 </table>
</td>
  <td width="5%"></td>
  <td valign="top"> 
  <h4 class="heading3 center">INTAKE</h4>
  <p style="text-align:center;">'.$tk.'</p>
  </td>
  </tr>
</table>
 <p style="margin-top:10px; font-size:14px;">Is English your first language? <img src="../../images/box.png" width="10"> Yes <img src="../../images/box.png" width="10"> No &nbsp; <b> If NO,</b> have you taken any English tests (IELTS/ TOEFL) <img src="../../images/box.png" width="10"> Yes <img src="../../images/box.png" width="10"> No</p>
  <table width="100%" class="form-table">
 <tr>
<td width="13%"><p>Test Name:</p></td>
<td width="57%"><b style="float:left; width:96%; border-bottom:1px solid #333; height:20px;"></b></td>
<td width="9%"><p style="float:left;margin-top:5px;"> Score:</p></td>
<td width="31%"><b style="float:left; width:100%; border-bottom:1px solid #333; height:20px;"></b></td></tr> 
  </table><br>
  <table width="100%" class="form-table">
 <tr>
<td width="22%"><p>Signature of Applicant:</p></td>
<td width="45%"><b style="float:left; width:96%; border-bottom:1px solid #333; height:20px;"></b></td>
<td width="7%"><p style="float:left;margin-top:5;">Date:</p></td>
<td width="25%"><b style="float:left; width:100%; border-bottom:1px solid #333; height:20px;"></b></td></tr> 
  </table>
 <footer>
 <table><tr><td><b>For more information, please contact:</b></td>
 <td><b>Tel. No.: 416-969-8845 Fax: 416-969-9372</b></td></tr>
 <tr><td>Academy of Learning College</td>
 <td><b>Website: www.aoltoronto.com</b></td></tr>
 <tr><td>1255 Bay Street, Suite 600, Toronto, Ontario, Canada M5R 2A9</td>
 <td><b>Email:</b> <b style="color:#666;">info@aoltoronto.com</b></td></tr></table>

</footer>
';
$output .= '</div>';
	
$document->loadHtml($output);

//set page size and orientation

$document->setPaper('A4', 'Portrait');

//Render the HTML as PDF

$document->render();

$firstname = str_replace(' ', '', $fname);
$olname = 'Student_Application_Form_'.$firstname.'_'.$refid;

//Get output of generated pdf in Browser

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview


?>