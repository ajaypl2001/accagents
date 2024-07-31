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

$query2 = "SELECT sno, commenc_date FROM contract_courses WHERE intake='$prg_intake' AND program_name='$prg_name1'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$sno2 = $rowstr2['sno'];
$commenc_date2 = $rowstr2['commenc_date'];
$commenc_date = date("F j, Y", strtotime($commenc_date2));


$query23 = "SELECT sno, update_datetime FROM start_college_attendance WHERE warning_letter='1st_warning_letter' AND app_id='$snoid'";
$result23 = mysqli_query($con, $query23);
if(mysqli_num_rows($result23)){
	$rowstr23 = mysqli_fetch_assoc($result23);
	$update_datetime = $rowstr23['update_datetime'];
	$get_crnt_dte = date("F j, Y", strtotime($update_datetime));
}else{
	$crnt_dte = date('Y-m-d');
	$get_crnt_dte = date("F j, Y", strtotime($crnt_dte));	
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
<p>'.$get_crnt_dte.'<br><br>
Dear '.ucfirst($fname).' '.ucfirst($lname).'<br><b>Student ID:</b>'.$student_id.',<br><br>
<b><u>Re: 1st Attendance Warning</u></b>
<br><Br>We are writing to advice you that you have missed 3 consecutive classes during your scheduled study time.As this is a first warning, we feel it is necessary to remind you about your academic/attendance obligations. In order to graduate and receive your diploma, you must achieve at least 75% overall attendance.Please find attached Granville College`s attendance policy. <br><br>
We hope that this first warning serves as a guide for you to pursue better attendance in your program. We remind you that our team is available at the campus to help you if you feel you need any further coaching/assistance with regards to your academics.

<br><br><br>

Best regards,<br><br><br>
<img src="../../images/Cheryl-Singature.jpg" width="150" alt=""><br>
Cheryl Grenick<br>
Campus Administrator<br><br>

t. <a href="tel:604.683.8850">604.683.8850</a><br>
e. <a href="mailto:cheryl@granvillecollege.ca">cheryl@granvillecollege.ca</a><br>
w. <a href="https://granvillecollege.ca/" target="blank">www.granvillecollege.ca</a><br>
a.  Suite 600 & 700 - 549 Howe Street Vancouver, BC V6C 2C2

 </p>
</td></tr></table>

</div>

</main>';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

$firstname = str_replace(' ', '', $fname);
$olname = '1st_WL_'.$firstname.'_'.$refid;

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>