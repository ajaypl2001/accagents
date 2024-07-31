<?php
// include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
//initialize dompdf class
$document = new Dompdf();
// $document->set_option('/defaultFont', '/Courier');


$output = "<style>

a { color:#2f8be3}
footer p { text-align:center;}
main { position:relative;width:100%;background:transparents !important;}
   .page {width:100%;   font-size:14px;  margin-top:110px; padding:0px 60px 5px; page-break-after: always; position:relative;line-height:17px;background:transparents !important;
   .page:last-child {page-break-after:never;}
 @page { margin:0px; padding:90px 10px 10px;font-weight:599;width:100%;  color:#333;     font-family: poppins,helvetica neue,Arial,sans-serif;font-size:14px; height:100%; letter-spacing:-0.6; }
.float-left { float:left;}
.float-right { float:right;}
.mt-5 { margin-top:50px;}
.text-center { text-align:center;}
p { width:100%; margin:0px 0px 5px; }
h4 { font-size:17px;}
.m-0 { margin:0px;}
  .lower-roman {list-style-type: lower-roman}
  .list-alfa { list-style-type: lower-alpha;}
  ol li { margin-top:5px;}
  .header { position: fixed; top:30px;width:100%;  padding:0px 60px 25px;height:80px; z-index:999; display: block; }
 footer {position: fixed;bottom:80px; width:100%; z-index:999; padding:0px 55px 0px;height:25px; }

</style>";

$output .= '    <!-- Wrap the content of your PDF inside a main tag --> 

<div class="header">   
  <p><span class="float-left"> <img src="images/logo.jpg" width="70"></span> <span class="float-right mt-5"><b>DLI NO -</b> O150186247152</span>  
</p>
  </div><footer>
<p><strong> Address:</strong>  #201 – 155 Skinner Street, Nanaimo, BC V9R 5E8<br>
w: <a>www.avaloncommunitycollege.ca </a> | e: <a> info@avaloncommunitycollege.ca</a> | p: 1-250-824-1545</p>
</footer>

          <main class="page">    
          <p>[Current Date]<br><br>
[Student Name]<br>
[Student Address]<br>
[City], [Pin code], [Country]<br><br>
<b>#Student ID – </b> 2206001<br>
Date of Birth – [Date of Birth]<br><br>
Dear <b>[Student Name],</b><br><br>
Congratulations! We are delighted to provide you with this offer of admission into the &nbsp;  &nbsp; <b> [Course Name] </b> at the 
<b>Avalon Community College, Nanaimo, British Columbia.</b><br><br><b>
Please note this is not a Letter of Acceptance and should not be used for Study Permit or Visa purposes.</b></p>
<table><tr><td><b>Program Name:</b></td><td> [Course Name]</td></tr>
<tr><td><b>Intake:</b></td><td> [Intake Name]</td></tr>
<tr><td><b>Duration: </b></td><td>[Duration]</td></tr>
<tr><td><b>Start Date: </b></td><td>[Course Start Date]</td></tr>
<tr><td><b>College DLI No:</b></td><td> [DLI No]</td></tr>
<tr><td><b>Level of Study: </b></td><td> Diploma</td></tr>
<tr><td><b>College Type:</b></td><td> Licensed Private</td></tr>
<tr><td><b>Deposit Required: </b></td><td>CAD 13,900 (First Year Tuition Fees)</td></tr>
<tr><td><b>Fees:</b></td><td> CAD 23,900</td></tr>
<tr><td><b>Payment Transfer Information:</b></td><td> </td></tr></table>
<br>
<p><b>Admission Requirements - </b></p>
          <ol start="1">
          <li> IELTS Requirements - 6.0 overall, no individual band under 5.5 in each module.</li>
<li> Copy of all transcripts for the highest level of education.</li>
<li> Please note that you must deposit the fees and share the required documents before the 
deadline.</li>
<li> Your admission to the College is cancelled without notice if you are unable to deposit the fees or 
submit the required documents before the deadline.</li>
<li> The College reserves the right to change the tuition fees.</li>
         </ol><br>
<p>We welcome you to Avalon Community College, Nanaimo, British Columbia. For any information regarding your 
college admission, please contact us at <u> <a> international@avaloncommunitycollege.com</a> </u>  – International 
Department.<br><br>Sincerely,<br><br>
[Sign]<br>
[Name</p>         
          </main>


       <main class="page" style=" page-break-after: never;" > <br><br><p>The total costs of the program (tuition and fees) are <b> &nbsp;  CAD </b> broken down as follows:</p><br>
          <table class="table1">
<tr><td colspan="3"><b><u>HCOA (MOA)</u></b><br></td></tr>
   <tr><td>Tuition</td>
   <td>:</td>
   <td>$15,500.</td>
   </tr> 
   <tr><td>Application fees (non-refundable)</td>
   <td>:</td>
   <td>$1,000.</td>
   </tr> 
 <tr><td>Student Records  Archiving and Student services FEE </td>
   <td>:</td>
   <td>$110</td>
   </tr>
   <tr><td>Textbook, Costs (max/approx.)</td>
   <td>:</td>
   <td>$1,200.00 </td>
   </tr> 

  
   <tr><td>International Scholarship</td>
   <td>:</td>
   <td>$4,340</td>
   </tr>    
</td></tr>
</table><br>
<p> 
  You are entitled to a Scholarship of $10,140.00 CAD. To reserve your seat, a total amount of &nbsp; &nbsp; <b>  $13,500.00 CAD &nbsp; &nbsp;</b>must be paid. <br><br>
We look forward to seeing you in British Columbia and wish you success in your studies.
   <br><br><br>
   Sincerely,<br><br>
   <img src="images/Sig_Cham1.jpg" style="height:60px;">   <br><br>
Chamara Perera<br>
Chief Operating Officer<br>
Direct Line: 250-619-2637
<p>
</main> </div>';
$document->loadHtml($output);
//set page size and orientation
$document->setPaper('A4', 'potrait');
//Render the HTML as PDF
$document->render();
$document->stream("international-student-application", array("Attachment"=>0));
//1  = Download
//0 = Preview
?>