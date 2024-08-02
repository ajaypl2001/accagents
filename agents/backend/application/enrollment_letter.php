<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
$datecrnt = date('Y-m-d H:i:s');
$today_date = date('F d, Y');

require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();

if(isset($_GET['stuid'])) {

  $stuid = $_GET['stuid'];
  $dtls_std = "SELECT fname,lname,student_id,prg_name1,refid,prg_intake FROM st_application WHERE sno = $stuid";

  $res_dtls = mysqli_query($con, $dtls_std);
  $row_dtls = mysqli_fetch_assoc($res_dtls);
  $fname = $row_dtls['fname'];
  $lname = $row_dtls['lname'];
  $student_id = $row_dtls['student_id'];
  $prg_name1 = $row_dtls['prg_name1'];
  $refid = $row_dtls['refid'];
  $prg_intake = $row_dtls['prg_intake'];

  $dtls_course = "SELECT commenc_date,expected_date,week FROM contract_courses WHERE program_name = '$prg_name1' AND intake = '$prg_intake' ";

  $res_course = mysqli_query($con, $dtls_course);
  $row_course = mysqli_fetch_assoc($res_course);

  $commenc_date = $row_course['commenc_date'];
  $expected_date = $row_course['expected_date'];
  $week = $row_course['week'];
  $start_date =  date("jS F, Y", strtotime($commenc_date));
  $end_date =  date("jS F, Y", strtotime($expected_date));

  $chck_file_res = mysqli_query($con, "SELECT * FROM travel_docs WHERE st_id = $stuid AND doc_name = 'Enrollment Letter' ");
  $count_file = mysqli_num_rows($chck_file_res);

  $output = "<style> 
    .header { position: fixed; top: -0px;width:100%;  padding:15px 30px 25px 70px;height:0px; display: block; }
      footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 45px 0px;height:25px; font-size:14px; }
h4 { font-size:26px ; width:100%; text-align:center;}
footer p { text-align:center;}
main { position:relative;width:100%; }
   .page {width:100%;   font-size:16px;  margin-top:150px; padding:0px 70px 5px 70px; page-break-after: always; position:relative;line-height:19px; }
      .page:last-child {page-break-after:never;}
 @page { margin:20px 15px 65px; font-weight:599;width:100%;  color:#333; font-size:18px; }
.float-left { float:left;}
.float-right { float:right;}
.heading-txt { width:100%;}
.heading-txt p, .heading-txt h4 { width:100%; margin:5px 0px;}
.table1 td { padding:0px 0px;vertical-align:top;}
.table1 { margin-top:10px; margin-bottom:10px;}
.pagenum:before { content: counter(page); }
.pagenum { float:right;margin-bottom:20px;}
.mt-5 { margin-top:50px;}
.text-center { text-align:center;}
.table2 td { font-size:18px;vertical-align:top; padding:0px 10px; line-height:19px;}
.table2 { width:100%; }
p { width:100%; margin:0px; }

</style>";

  $output .= '
    <!-- Wrap the content of your PDF inside a main tag -->

  <div class="header">   

    <table width="100%"><tr><td width="80%"> </td><td align="center"><img src="../../images/logo.jpg" width="168  "></td>
          </tr></table>
             <table width="100%" style="margin-top:20px;"><tr><td width="80%"> </td><td align="right" style="font-size:16px;">' . $today_date . '</td>
          </tr></table>
          </div> <footer>
<p style="font-size:15px;"><b>Address: #201 – 155 Skinner Street, Nanaimo, BC V9R 5E8<br>
w: <a href="#www.avaloncommunitycollege.ca" target="_blank">www.avaloncommunitycollege.ca</a> | e: <a href="mailto:info@avaloncommunitycollege.ca ">info@avaloncommunitycollege.ca </a> | p: 1-250-824-1545</b>
</p>


</footer>
          <!-- Wrap the content of your PDF inside a main tag -->
          <main class="page"> 

       
          <div class="heading-txt mt-5">      
  
<table><tr><td>
<p>Avalon Community College <br>
 #201 – 155 Skinner Street,<br>
 Nanaimo, BC V9R 5E8, Canada<br><br>
To Whom It May Concern.<br><br><br>
This is to certify that ' . $fname . " " . $lname . ' is enrolled as a full-time student at <b>Avalon Community College, Nanaimo, British Columbia.<br><br>
Here are the terms of the study contract:</b>

</p>
<br><br>
<table style="margin-left:30px;"><tr><td style="width:200px"><b>Student:</b></td>
<td><b>' . $fname . " " . $lname . '<b></td></tr>
<tr><td><b>Student Id: </b></td>
<td><b>' . $student_id . '<b></td></tr>
<tr><td><b>Program:</b></td>
<td><b>' . $prg_name1 . '<b></td></tr>
<tr><td><b>Program Length:</b></td>
<td><b>' . $week . '
<b></td></tr>
<tr><td><b>Start Date: </b></td>
<td><b>' . $start_date . '<b></td></tr>
<tr><td><b>End Date: </b></td>
<td><b>' . $end_date . '<b></td></tr>
</table>
<p><br>Should you need any further information, please do not hesitate to contact me by phone at <b>: (403) 247-4319</b> or by email at<b> <a href="mailto:international@avaloncommunitycollege.com">international@avaloncommunitycollege.com</a>.</b><br><br><br>
Yours Sincerely<br><br>
</p>

<table>
<tr><td><img src="../../images/Sig_Cham.png" width="105"></td><td></b></td>
</tr>

</table>

<p style="margin-top:0px;">
Chamara Perera<br>
Chief Operating Officer<br>


</td></tr></table>
          </main>
        ';

  $output .= '';

  $document->loadHtml($output);
  $document->setPaper('A4', 'potrait');
  $document->render();

  if ($count_file > 0) {

    $chck_file_row = mysqli_fetch_assoc($chck_file_res);
    $olname = $chck_file_row['travel_file_upload'];
    $file_sno = $chck_file_row['sno'];

    if (!empty($olname)) {
      unlink("../../travelDoc/$olname");
    }

    $olname = "enrollment_letter_" . $refid . "_" . date('is') . ".pdf";
    $filepath =  '../../travelDoc/' . $olname;

    file_put_contents($filepath, $document->output());

    $updateqry = "UPDATE  `travel_docs` SET `travel_file_upload` = '$olname' ,datetime_at = '$datecrnt' WHERE sno = $file_sno ";
    mysqli_query($con, $updateqry);
  } else {

    $olname = "enrollment_letter_" . $refid . "_" . date('is') . ".pdf";
    $filepath =  '../../travelDoc/' . $olname;

    file_put_contents($filepath, $document->output());

    $updateqry = "INSERT INTO `travel_docs` (`travel_file_upload`,doc_name,st_id,datetime_at) VALUES ('$olname','Enrollment Letter','$stuid','$datecrnt')";
    mysqli_query($con, $updateqry);
  }

  $document->stream("$olname", array("Attachment" => 0));
}
?>
