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

$output = "<style> 
.header {  top: 0px;width:100%; padding:0px 55px 25px;height:0px; display: block; }
footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 55px 0px;height:25px; font-size:12px; }
footer p { text-align:center;}
main { position:relative;width:100%; }
.page {width:100%;   margin-top:0px; padding:0px 55px 5px; position:relative;line-height:22px; }
 @page { margin:60px 15px 30px; font-weight:599;width:100%;  color:#333; font-size:16px; }
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

$output .= '<div class="header">   
<p><span class="float-left"> <img src="../../images/Granville-New-logo.jpg" width="90"></span> 
</p> 
</div>
<main class="page"> 
<div class="heading-txt">

<table width="100%" class="sign_table" style=" margin-top:80px;">
<tr> 
  <td style="border-bottom:1px solid #333 !important;float:left; width:200px;"  valign="bottom"><b>Attendance Policy</b></td>
    <td width="30">&nbsp;</td>
<td style="border-bottom:1px solid #333 !important; float:left; width:100px;" valign="bottom">Monday, October 3, 2022
</td> 
  </tr>
  <tr> <td valign="top" style="padding-top:0px;">Name of Policy</td>
  <td width="30">&nbsp;</td>
  <td valign="top" style="padding-top:0px;">Implementation Date</td> 
  </tr>
   <tr>
  <td width="30" colspan="3">&nbsp;</td>
 
  </tr>
  <tr> 
  <td style="border-bottom:1px solid #333 !important;float:left; width:200px;" valign="bottom"><b>Campus Director / Campus Administrator
Senior Education Administrator</b></td>
    <td width="30">&nbsp;</td>
<td style="border-bottom:1px solid #333 !important; float:left; width:100px;" valign="bottom">Monday, October 3, 2022</td> 
  </tr>
  <tr> <td valign="top" style="padding-top:0px;">Position(s) Responsible  </td>
  <td width="30">&nbsp;</td>
  <td valign="top" style="padding-top:0px;">Date of Last Revision</td> 
  </tr></table>

<p>Granville College expects students to attend classes regularly and to be punctual while completing a
program of study. This includes attendance to all labs, lectures, classroom activities, quizzes, tests and
examinations. Students who are absent for more than 20% of a module or more than 30% of an overall
program, may receive an incomplete grade for that module or program, respectively.<br><br>
Program end dates will not be extended due to absences or a leave of absence. Students are expected to
complete their program of study in accordance with the program end date indicated on the Enrollment
Contract.<br><br>
Whenever possible, the College will make a reasonable effort to accommodate an excused absence or
approved leave of absence by re-scheduling the student into an alternate class for the same course on
their return; or by providing the instructional materials missed during their absence; and/or rescheduling
a time to write a missed test or exam; however, it is ultimately the responsibility of the student to makeup any instruction, tests or exams missed during their absence.<br><br><b>
Absence</b><br>
Students will be required to provide explanations for absences however this does not equal an ‘excused absence’.
Absence to be marked as an ‘excused absence’ and be exempt from the 80% attendance requirement must be
approved by the Campus Administrator.<br><br>
Students who are absent from class due to illness for more than one day are required to submit a medical note to
the Campus Administrator. This document must include the name of the physician, address, telephone number,
verbiage affirming the medical issue along with dates that support the period of time the student was absent.<br><br><b>

Leave of Absences</b><br>
Students may apply for a leave of absence in the case of an unavoidable personal or family emergency. Students
must complete a Leave of Absence Request Form and deliver that form in person, by email or by registered mail to the Campus Administrator prior to being granted a leave. Students will not be granted a leave of absence for
vacations, study for exams or visits from family or friends.<br><br>
Leaves of absence may not be granted for more than a period of two (2) weeks and must be substantiated by
providing the College with all relevant documentation (including, but not limited to, a doctor’s note or report) to
support their application for leave.<br><br>
A leave of absence does not excuse the student from completing the work, quizzes, tests, labs and exams assigned
during the student’s leave. In the event a leave of absence constitutes an absence of more than 20% of a course or
30% of an overall program, the student may be required to repeat the course or program at their own expense. <br><br>
<b>Excessive Absences 
</b><br>
Students are expected to be in attendance as per the Enrollment Contract. Each student is provided a program
schedule outlining his or her day-to-day sessions throughout the educational period at Granville College.
Excessive absence includes but is not limited to:</p>
<ul><li> Unscheduled, unexplained absences</li>
<li> Tardiness including late arrivals or early departures</li></ul>
<p>
Students with excessive, erratic, unexplained attendance may face the following consequences:</p>
<ul><li> A verbal warning for regular unexplained absences</li>
<li> A first warning letter for three days of unexplained consecutive absences and/or for sporadic
attendance resulting in falling below 80% attendance requirement</li>
<li> A second warning letter for five days of unexplained consecutive absences</li>
<li> A program dismissal letter after ten days of unexplained consecutive absences</li></ul>
<p>
Attendance and punctuality are very important and are recorded on a daily basis. Attendance is tracked by the
hour and may be used in reporting purposes to the following organizations;</p>
<ul><li> Student Loans</li>
<li> Citizenship and Immigration Canada</li>
<li> Workers Compensation Board</li>
<li> Employment and Social Development Canada and more.</li>
</ul>
<p>
Additionally, these records are used when calculating participation marks, practicum or co-op work experience. In
order to organize the work experience placement, it is required that attendance be at 80% or higher. Should
attendance rate hinder work experience placement, the program is considered incomplete. 
 </p>

</div>
</main>
';

$output .= '';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

$firstname = str_replace(' ', '', $fname);
$olname = 'Att_Policy_'.$firstname.'_'.$refid;

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>