<?php
// include("../../db.php");
date_default_timezone_set("Asia/Kolkata");

require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//initialize dompdf class

$document = new Dompdf();

// $document->set_option('/defaultFont', '/Courier');


$output = "<style> 
    .header { position: fixed; top: -0px;width:100%;  padding:10px 50px 25px;height:0px; display: block; }
      footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 45px 0px;height:25px; font-size:14px; }
footer p { text-align:center;}
main { position:relative;width:100%; }
   .page {width:100%;   font-size:16px;  margin-top:100px; padding:0px 50px 5px; page-break-after: always; position:relative;line-height:19px; }
      .page:last-child {page-break-after:never;}
 @page { margin:20px 15px 65px; font-weight:599;width:100%;  color:#333; font-size:18px; }
.heading-txt { width:100%;}
.heading-txt p { width:100%; margin:5px 0px;}
.mt-5 { margin-top:50px;}
.text-center { text-align:center;}
p { width:100%; margin:0px; }
</style>";

$output .= '
    <!-- Wrap the content of your PDF inside a main tag -->

  <div class="header">   

    <table width="100%"><tr><td width="80%"> </td><td align="center"><img src="../images/logo.jpg" width="70"></td>
          </tr></table>
          </div> <footer>

<p><strong> Address:</strong>  #201 – 155 Skinner Street, Nanaimo, Nanaimo, BC V9R 5E8<br>
w: <a>www.avaloncommunitycollege.ca </a> | e: <a> info@avaloncommunitycollege.ca</a> | p: 1-250-824-1545</p>



</footer>
          <!-- Wrap the content of your PDF inside a main tag -->
          <main class="page"> 

          <table width="100%"><tr><td width="80%"> </td><td>August 12, 2021 </td>
          </tr></table>
          <div class="heading-txt mt-5">
          
  
<table><tr><td>
<p>Avalon Community College<br>
#201 – 155 Skinner Street, <br>Nanaimo, Nanaimo,<br> BC V9R 5E8<br><br><br>
To Whom It May Concern:<br><br>
This is to certify that Ajaydeep Singh is enrolled as a full-time student at<br>
<b>Avalon Community College, <b> Nanaimo, British Columbia
<br><br><br>
<b>Here are the terms of the study contract:</b>
</p>

<table><tr><td>&nbsp;</td><td><b>Student:</b></td>
<td><b>Ajaydeep Singh<b></td></tr>
<tr><td>&nbsp;</td><td><b>Student #: </b></td>
<td><b>BC H1920726<b></td></tr>
<tr><td>&nbsp;</td><td><b>Program:</b></td>
<td><b>Conference and Event Planner<b></td></tr>
<tr><td>&nbsp;</td><td><b>Start Date: </b></td>
<td><b>September, 13, 2021 <b></td></tr>
<tr><td>&nbsp;</td><td><b>End Date: </b></td>
<td><b>September, 09, 2022 <b></td></tr>
<tr><td>&nbsp;</td><td><b>Study Hours: </b></td>
<td><b>Monday through Saturday 20 hours per week<b></td></tr>
</table>
<p><br><br>Should you need any further information, please do not hesitate to contact the school by
phone at 1-250-824-1545 or by email at info@avaloncommunitycollege.ca.<br><br><br>
For Avalon Community College<br><br>
</p>

<!---table>
<tr><td><img src="images/logo-img.jpg" width="70"></td><td></b></td>
</tr>
<tr><td><span style=" font-size:12px; line-height:11px !important; margin-top:20px; width:170px !important; text-align:center;"><center>401 Main Street, East<br> Hamilton, On L8N 1J7</center>
</span></td><td></b></td>
</tr>
</table--->

<p>
Authorized Signatory<br>
(Admissions Department

</td></tr></table>



          </main>
        ';

$output .= '';




$document->loadHtml($output);

//set page size and orientation

$document->setPaper('A4', 'potrait');

//Render the HTML as PDF

$document->render();

$document->stream("Enrollment_Letter", array("Attachment"=>0));
//1  = Download
//0 = Preview


?>