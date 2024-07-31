<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");

require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();
$document->set_option('defaultFont', 'Courier');

$campus = $_POST['campus'];
$tk = $_POST['tk'];
$pn = $_POST['pn'];
$snoid = $_POST['snoid'];
$current_date_val = date('Y-m-d H:i:s');
$current_date = date("jS F, Y", strtotime($current_date_val));

$query1 = "SELECT fname, lname, refid, support_letter, loa_file_date_updated_by FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$support_letter = $rowstr1['support_letter'];
$loa_file_date_updated_by = $rowstr1['loa_file_date_updated_by'];
$refid = $rowstr1['refid'];
$fullname = $fname.' '.$lname;
$loa_file_date = date("F j, Y", strtotime($loa_file_date_updated_by));

$query2 = "SELECT commenc_date FROM contract_courses WHERE intake = '$tk' AND  program_name= '$pn' AND campus='$campus'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$commenc_date = $rowstr2['commenc_date'];
$program_start_date = date("jS F, Y", strtotime($commenc_date));

if($campus == 'Hamilton'){
	$signature_div = '<tr>
<td><img src="../../images/sign1_small_size_brm.png" width="180"></td>
</tr>
<tr><td><b>Chamara Perera</b><br>
Academy of Learning College<br>
Regional Director
</td>
</tr>';

$footer_address = "<p>401 Main Street, East Hamilton, On L8N 1J7<br>
T: 905.777.8553 | F : 905.777.0103 | international@aolhamilton.com | www.aolhamilton.com
</p>";
}

if($campus == 'Brampton'){
	$signature_div = '<tr>
<td><img src="../../images/sign1_small_size_brm.png" width="150"></td>
</tr>
<tr><td><b>Chamara Perera</b><br>
Academy of Learning Career College<br>
Regional Director
</td>
</tr>';

$footer_address = "<p>8740 The Gore Road, Brampton, ON, L6P 0B1<br>
T: +1 905.508.5791 | F : +1 289.948.1077 | international@aolbrampton.ca | www.aolbrampton.ca
</p>";
}

if($campus == 'Toronto'){
	$signature_div = '<tr>
<td><img src="../../images/sign1_small_size_brm.png" width="180"></td>
</tr>
<tr><td><b>Chamara Perera</b><br>
Academy of Learning College<br>
Regional Director
</td>
</tr>';

$footer_address = "<p>401 Bay Street, Suite 1000, 10th Floor, Toronto, Canada, On M5H2Y4<br>
T:416-969-8845 | F :416-969-9372 | info@aoltoronto.com | www.aoltoronto.com
</p>";
}


$output = "<style>
@page { margin:0px; padding:0px;  }
body { padding: 50px 60px 10px;  }
.firstrow{width:100%;font-size:14px; font-family:Arial, Helvetica, sans-serif;  page-break-after: always;}
.firstrow #heading{margin-top:5px;margin-top:0px; margin-bottom:0px;width:100%;font-size:15px;font-weight:700;text-transform:uppercase;text-align:center;padding:2px 0;}
.logo1 { width:100%; margin-bottom:40px; }
.logo1 img { float:right;}
.middle_part { width:100%; float:left; margin-top:160px;}
.footer p {  font-size:11px; text-align:center; width:100%; margin:-40px 0px 0px 50px;}
.footer {  margin-top:-40px;}
.footer {
	position: fixed; 
	bottom: 0cm; 
	left: 0cm; 
	right: 0cm;width:100%;
	height: 10px;  
}
</style>";

$output .= '<div class="firstrow">	
<table width="100%" border="0" style="border-collapse:collapse; margin-top:-25px;">
<tr>
  <td class="box-strip"><div class="logo1" style="margin-right:-5px;">
<img src="../../images/academy_of_learning_logo.png" width="280" class="logo">
</div></td>  
</tr>
</table>
<table width="100%" class="middle_part">
<tr><td>
<p>
Date: '.$loa_file_date.'<br><br><br>
To Whom It May Concern<br><br><br>
'.$fullname.' is a prospective student for Academy of Learning career College for '.$pn.' Program with tentative start date of '.$program_start_date.'.<br><br><br>

'.$fullname.' has completed all of the necessary admissions requirements and has been pre-approved for admittance to Academy of Learning College.<br><br><br>

Academy of Learning College is accredited by the Ontario Ministry of Advanced Education and Skills Development and requires all students to write and pass our Wonderlic SLE entrance exam as a part of our entrance requirements. Additional exam results such as IELTS and PTE as supplementary and beneficial to provide language proficiency but not a requirement for admissions.<br><br><br>

Do not hesitate to communicate with of for further clarification if any Issues arise.<br><br><br><br>

Sincerely</p>
</td></tr>

'.$signature_div.'
</table>

<div class="footer">
'.$footer_address.'
<img src="../../images/border-bottom1.jpg" style="margin:0px 0px 0px 0px;">
</div>
';
	
$output .= '</div>';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if($support_letter !==''){
	unlink("$support_letter");
}

$firstname = str_replace(' ', '', $fname);
$sl_name = 'Support_Letter_'.$firstname.'_'.$refid;

$filepath = "../../uploads/sl/$sl_name.pdf";

file_put_contents($filepath, $document->output());

mysqli_query($con, "update `st_application` set `support_letter`='$filepath', `support_letter_date`='$current_date_val' where `sno`='$snoid'");

$document->stream("$sl_name", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>