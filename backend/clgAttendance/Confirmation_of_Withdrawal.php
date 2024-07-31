<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");

require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();
$document->set_option('/defaultFont', '/Courier');

$snoid = $_GET['snoid'];
$query1 = "SELECT fname, lname, refid, student_id, prg_name1, prg_intake FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$refid = $rowstr1['refid'];
$student_id = $rowstr1['student_id'];
$prg_name1 = $rowstr1['prg_name1'];
$prg_intake = $rowstr1['prg_intake'];

$query2 = "SELECT sno, commenc_date, expected_date FROM contract_courses WHERE intake='$prg_intake' AND program_name='$prg_name1'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$sno2 = $rowstr2['sno'];
$commenc_date2 = $rowstr2['commenc_date'];
$commenc_date = date("F j, Y", strtotime($commenc_date2));
$expected_date2 = $rowstr2['expected_date'];
$expected_date = date("F j, Y", strtotime($expected_date2));

$query23 = "SELECT sno, update_datetime FROM start_college_attendance WHERE warning_letter='Confirmation_of_Enrollment' AND app_id='$snoid'";
$result23 = mysqli_query($con, $query23);
if(mysqli_num_rows($result23)){
	$rowstr23 = mysqli_fetch_assoc($result23);
	$update_datetime = $rowstr23['update_datetime'];
	$get_crnt_dte = date("F j, Y", strtotime($update_datetime));
}else{
	$crnt_dte = date('Y-m-d');
	$get_crnt_dte = date("F j, Y", strtotime($crnt_dte));	
}

if($prg_name1 == 'Diploma in Hospitality Management' || $prg_name1 == 'Diploma in Hospitality Management(1)' || $prg_name1 == 'Diploma in Hospitality Management(2)' || $prg_name1 == 'Diploma in Hospitality Management(3)' || $prg_name1 == 'Diploma in Hospitality Management(4)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP'){
	$fullTimeDuration = '5';
}else{
	$fullTimeDuration = '4';	
}

if($prg_name1 == 'Diploma in Hospitality Management' || $prg_name1 == 'Diploma in Hospitality Management(1)' || $prg_name1 == 'Diploma in Hospitality Management(2)' || $prg_name1 == 'Diploma in Hospitality Management(3)' || $prg_name1 == 'Diploma in Hospitality Management(4)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP'){
	$weekLenght = '48';
}elseif($prg_name1 == 'Business Administration / Global Supply Chain Management Speciality'){
	$weekLenght = '81';	
}elseif($prg_name1 == 'Business Administration / Human Resources Management Speciality'){
	$weekLenght = '69';	
}else{
	$weekLenght = '40';	
}


$output = "<style> 
.header { position: fixed; top: -0px;width:100%;  padding:0px 55px 25px;height:0px; display: block; }
footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 55px 0px;height:25px; font-size:12px; }
    
footer p { text-align:center;}
main { position:relative;width:100%; }
   .page {width:100%;   margin-top:90px; padding:0px 55px 5px; position:relative;line-height:22px; }
 @page { margin:40px 15px 30px; font-weight:599;width:100%;  color:#333; font-size:16px; }
.float-left { float:left;}
.float-right { float:right;}
.heading-txt { width:100%;}
.heading-txt h2 { line-height:30px;}
.heading-txt h2, .heading-txt h3  { width:100%; margin:10px 0px;}
.heading-txt p, .heading-txt h4 { width:100%; margin:5px 0px;}
.table1 td { padding:5px 0px;}
.table1 { margin-top:0px; margin-bottom:30px;}
.pagenum:before { content: counter(page); }
.pagenum { float:right;margin-bottom:20px;}
.mt-5 { margin-top:50px;}
.text-center { text-align:center;}
.table2 td { border:1px solid #333; vertical-align:top; padding:5px 10px;}
.table2 { width:100%; }
p a { color:#333; text-decoration:none;}
p { width:100%; }
</style>";

$output .= '
  <div class="header">   
  <p><span class="float-left"> <img src="../../images/Granville-New-logo.jpg" width="90"></span>
</p>
  </div>
 
<main class="page"> 
<div class="heading-txt">

<br><br><br>
<table><tr><td>
<p>'.$get_crnt_dte.'<br><br><br>
Dear '.ucfirst($fname).' '.ucfirst($lname).':<br><br></p></td></tr>
<tr><td>
 
<table><tr><td><b>RE:  </b></td>
<td><b>Confirmation of Withdraw </b></td></tr>
<tr><td><b>Program:  </b></td>
<td><b>'.$prg_name1.'</b></td></tr>
<tr><td><b>Student:  </b></td>
<td><b> '.ucfirst($fname).' '.ucfirst($lname).'</b></td></tr>
<tr><td><b>Student ID:    </b></td>
<td><b> GC'.$student_id.'</b>
</td></tr></table>
<hr><br>
</td></tr>
<tr><td>
<p>This letter is to confirm that <b>'.ucfirst($fname).' '.ucfirst($lname).'</b> was enrolled in the <b>'.$prg_name1.'</b> (the “Program”) at Granville College. The Program commenced on <b>'.$commenc_date.'</b> and the student withdrew on <b>'.$get_crnt_dte.'.</b> <br><br>

The Program is full-time which is taught from Monday through Friday for <b> '.$fullTimeDuration.' hours </b> a day. The total length of the program is <b>'.$weekLenght.' weeks. </b><br><br>

Granville College is registered by the Private Training Institutions Branch and our programs are approved by the Ministry of Advanced Education.<br><br>

Should you require further information or assistance, please feel free to contact us by phone <b> (604) 683-8850</b> or via email to <b>info@granvillecollege.ca</b>



<br><br>
Sincerely,<br><br>
<img src="../../images/Cheryl-Singature.jpg" width="150" alt=""><br>
<b>Cheryl Grenick</b><br>
Campus Administrator
 </p>
</td></tr></table>
</div>

</main>
';


$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

$firstname = str_replace(' ', '', $fname);
$olname = 'COWD_'.$firstname.'_'.$refid;

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>