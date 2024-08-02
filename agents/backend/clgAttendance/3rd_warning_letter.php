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
$commenc_date = date("jS F, Y", strtotime($commenc_date2));

$crnt_dte = date('Y-m-d');
$get_crnt_dte = date("jS F, Y", strtotime($crnt_dte));

$output = "<style> 
    .header { position: fixed; top: -0px;width:100%;  padding:0px 55px 25px;height:0px; display: block; }
      footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 55px 0px;height:25px; font-size:12px; }
    
footer p { text-align:center;}
main { position:relative;width:100%; }
   .page {width:100%;   margin-top:90px; padding:0px 55px 5px; position:relative;line-height:22px; }
 @page { margin:20px 15px 30px; font-weight:599;width:100%;  color:#333; font-size:16px; }
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
<!-- Wrap the content of your PDF inside a main tag -->
<div class="header">   
<p>
<span class="float-left"> <img src="../../images/Granville-New-logo.jpg" width="90"></span> <span class="float-right mt-5"><b>DLI NO - O116736261697</b></span>
</p>
</div>

<footer>
<p>
<strong>Granville College<br>
725-570 Dunsmuir Street Vancouver, BC V6B 1Y1, Canada<br>
(604) 683-8850
</strong> <b class="pagenum">  /1</b>
</p>
</footer>

<!-- Wrap the content of your PDF inside a main tag -->
<main class="page"> 
<div class="heading-txt">

<!---h2 class="text-center">Attendance Warning Letters</h2--->
<br><br><br>
<table>
<tr><td>
<p>'.$get_crnt_dte.'<br><br>
Dear '.ucfirst($fname).' '.ucfirst($lname).' and '.$student_id.' #,<br><br>
<b>Re: 3rd Attendance Warning</b>
<br><Br>
We are writing to advise you that you have missed 10 consecutive classes of your weekly scheduled study time. As this is a third warning, we feel it is necessary to remind your academic / attendance obligations. In order to graduate and receive your diploma, you must achieve an at least 75% attendance overall.
<br><br>
Although you have been classified to be in Good Academic Standing, we feel it is appropriate to provide you with this gentle reminder of your academic obligations. If you are not in attendance for your program, your academic standing will be in jeopardy.
<br><br>
We also remind you that we have people at the campus to help you if you feel you need any further counseling, remember that we are here to assist you.
<br><br><br>

Best regards,<br><br>
<img src="../../images/Cheryl-Singature.jpg" height="25"><br>
Cheryl Grenick<br>
Campus Administrator<br><br>

t. <a href="tel:604.683.8850">604.683.8850</a><br>
e. <a href="mailto:cheryl@granvillecollege.ca">cheryl@granvillecollege.ca</a><br>
w. <a href="www.granvillecollege.ca" target="blank">www.granvillecollege.ca</a><br>
a. 725-570 Dunsmuir St, Vancouver BC  V6B 1Y1

 </p>
</td></tr>
</table>

</div>
</main>
';

$output .= '';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

$firstname = str_replace(' ', '', $fname);
$olname = '3rd_WL_'.$firstname.'_'.$refid;

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>