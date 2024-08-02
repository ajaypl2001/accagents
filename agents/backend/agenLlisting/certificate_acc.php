<?php
require_once '../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
$document = new Dompdf();
$document->set_option('defaultFont', 'Courier');

include("../../db.php");
date_default_timezone_set("Asia/Kolkata");

$campus = $_POST['campus'];
$snoid = $_POST['snoid'];
$crted_by = $_POST['crted_by'];

$rslt = mysqli_query($con, "SELECT * FROM certificates WHERE agent_id='$snoid' AND campus='$campus'");
$row = mysqli_fetch_assoc($rslt);
if(mysqli_num_rows($rslt)){
	$certificateid = $row['id'];
	$certificateName = $row['certificate'];
	$certificate_generated_time = $row['certificate_generated_time'];
}else{
	$certificateid = '';
	$certificateName = '';
	$certificate_generated_time = '';
}

$rslt2 = mysqli_query($con, "SELECT username FROM allusers WHERE sno = '$snoid'");
$row2 = mysqli_fetch_assoc($rslt2);
$agentCompanyName = $row2['username'];

if(!empty($certificate_generated_time)){
	$datetime2 = $certificate_generated_time;
	$datetime21 = strtotime($datetime2);
	$date_at = date("F j, Y", strtotime($datetime2));	
	$date_at_end2 = date('Y-m-d',strtotime("+1 years",$datetime21));
	$date_at_end = date('F j, Y', strtotime('-1 day', strtotime($date_at_end2)));
}else{
	$datetime2 = date('Y-m-d H:i:s');
	$date_at = date("F j, Y", strtotime($datetime2));
	$datetime21 = strtotime($datetime2);
	$date_at_end2 = date('Y-m-d',strtotime("+1 years",$datetime21));
	$date_at_end = date('F j, Y', strtotime('-1 day', strtotime($date_at_end2)));
}

$output = "<style> 
 @page { margin: 0px; font-family:Helvetica; font-weight:599; line-height:22px !important; background:#fff; color:#333;  }
// .header { position: fixed; top: 10px; left:10px  display: block;width:100%; background:url(images/pdf_header.jpg) no-repeat;height:69px;text-align:center;}
.text-center { width:100%; text-align:center;}
.text-left {width:449px; padding-right:7%; height:80px; margin-bottom:10px; border-right:2px solid #114663; padding-top:35px; text-align:right !important;}
.text-right {width:400px; text-align:left;}
     .header img {   margin-top:30px; display: block;    }
    .black_text { font-weight:600; margin-top:0px; margin-bottom:40px; font-size:18.9px;}
        .logo1 { width:100%; }
        .authorization h3 { letter-spacing:4px; font-size:26px; margin-top:10px; color:#666; font-weight:bold}
.text_blue { font-size:22px;  }
 .logo1{ padding-top:26px;}
 .text-left h1 { font-size:68px; margin-top:0px !important; margin-bottom:0px; }

 h6 { font-size:18px; font-weight:normal; margin-top:10px;}
    h2{ text-align:center; width:100%; font-size:22px;margin-top:6px; font-weight:700;}
    h3{ text-align:center; width:100%; color:#114663; font-size:20px; font-weight:599;}
  .page h4{ width:100%; font-size:18px; margin-top:0px;font-weight:normal;}
  .page h5{  width:100%; font-size:18px;  margin-bottom:0px;font-weight:normal;}


   .page {/* page-break-after: always;*/  position:fixed;margin-top:80px;left:1px;height:100%; width:100%; line-height:15px;padding:60px ; background:url(acc-certificate.jpg) repeat-y;}
}

.form_table .border-bottom { border-bottom:2px solid #114663 !important; height:38px;}
.h5 { margin-top:90px;} 
    .check { margin-right:5px;}
           .form_table {margin-top:0px; margin-bottom:0px; width:100%;}
           .form_table1 {margin:30px auto 0px; width:980px; height:100px; border-bottom:2px solid #114663 }

.form_table td b{color:#114663 !important}
.form_table td {text-align:center; padding:5px 0px 0;height:33px;  margin-top:0px;}
        .pt-3{ padding-top:30px;}
        .form_table { margin:auto;}
        .float-left {float:left;}
        .float-right {float:right;}
</style>";

$output .= '<div class="header"></div>
        <div class="footer"></div>

        <main class="page">  
        <h4 class="logo1"><img src="../../images/logo-img.png" width="100" class="logo" ></h4>
        <table class="form_table1"><tr>
        <td>
        <div class="text-left">
 <h1>CERTIFICATE</h1>
 <div class="authorization">
 <h3>of Authorization</h3>
 </div>
 </td><td>
</div>
<div class="text-right">
 <p class="text_blue" style="margin-bottom:30px;margin-top:5px;"><b><i>This Is To Certify That</i></b></p>
 <h4><b style="color:#0294e2 !important;  font-size:30px">'.$agentCompanyName.'</b></h4>
 </div></td>
 </tr></table>
<h4 class="text-center" style="color:#114663; font-size:22px;"><b><i>is an Authorized Agent</i></b></h4>
  <p class="black_text text-center">To act on behalf of the college in the recruitment of students.<br>
The Current Agency Agreement will be due for renewal on the performance basis
</p>
<table class="form_table" width="420">
<tr>
<td class="border-bottom" valign="bottom" width="100">'.$date_at.'</td>
<td width="200"> &nbsp;</td>
<td class="border-bottom" width="100" style="padding-bottom:5px;">
<img src="../../images/suhail_sign.jpg" width="100">
</td>
</tr>
<tr>
<td width="100" class="text_blue" valign="top" style="font-size:15px !important; font-weight:700 !important; padding-top:0px;" >Date</td>
<td width="200"> &nbsp;</td>
<td class="text_blue" valign="top" width="150" style="font-size:15px !important; font-weight:700 !important; line-height:12px !important; padding-top:0px;">Suhail Seth – Director of Operations </td>
</tr>
</table>
<table style="margin-top:50px; width:100%;">
<tr><td text-align:center; style="font-size:13px; line-height:16px !important; text-align:center; width:100%;"> <b style="color:#114663">Address: </b> #201 – 155 Skinner Street,  Nanaimo, BC, V9R 5E8<br>
<b style="color:#114663">Phone Number: </b> 1-250-824-1545<b style="color:#114663"> Email:</b> info@avaloncommunitycollege.ca<br><b style="color:#114663"> Website:</b> www.avaloncommunitycollege.ca</td></tr></table>
 </div>
</main>
';

$document->loadHtml($output);
$document->setPaper('A4', 'Landscape');
$document->render();

if($certificateName !==''){
	unlink("certificate/$certificateName");
}

$olname = $campus.'_'.'Certificate_'.$snoid.date('is');
$filepath = "$olname.pdf";
$filepath_folder = "certificate/$olname.pdf";
file_put_contents($filepath_folder, $document->output());

if(mysqli_num_rows($rslt)){
mysqli_query($con, "update `certificates` set `certificate`='$filepath', `certificate_generated_by`='$crted_by', `certificate_generated_time`='$datetime2' where `id`='$certificateid'");
}else{
	mysqli_query($con, "INSERT INTO `certificates` (`agent_id`, `campus`, `certificate`, `certificate_generated_by`, `certificate_generated_time`) VALUES ('$snoid', '$campus', '$filepath', '$crted_by', '$datetime2')");
}
$document->stream("$olname", array("Attachment"=>1));


//1  = Download
//0 = Preview
?>