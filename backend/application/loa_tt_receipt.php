<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");

session_start();
$loggedid = $_SESSION['sno'];
$rsltLogged = mysqli_query($con,"SELECT email,role FROM allusers WHERE sno = '$loggedid'");
$rowLogged = mysqli_fetch_assoc($rsltLogged);
$Loggedemail = mysqli_real_escape_string($con, $rowLogged['email']);
$adminrole1 = mysqli_real_escape_string($con, $rowLogged['role']);

require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();

$col_updated = date('Y-m-d H:i:s');

$genrate_amount_loa = $_POST['genrate_amount_loa'];
$snoid = $_POST['snoid'];
$campus = $_POST['campus'];
$tk = $_POST['tk'];
$pn = $_POST['pn'];

$no_of_month1 = date("m");
$no_of_year = date("y");

$query1 = "SELECT * FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$gtitle = $rowstr1['gtitle'];
$user_id = $rowstr1['user_id'];
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$fullname = ucfirst($fname).' '.ucfirst($lname);
$refid = $rowstr1['refid'];
$student_id = $rowstr1['student_id'];
$loa_receipt_id = $rowstr1['loa_receipt_id'];
$loa_first_generate_date = $rowstr1['loa_first_generate_date'];
$loa_first_generate_date2 = date("d/m/Y", strtotime($loa_first_generate_date));

$branchcode_query = "select * from loa_tt_receipt";
$getbranch_res = mysqli_query($con, $branchcode_query);
$branch_codedta = mysqli_fetch_assoc($getbranch_res);
$month_number = $branch_codedta['month_number']; 
$no_of_encrement = $branch_codedta['no_of_increment'];

if($month_number == $no_of_month1){
   $nooffile = $no_of_encrement+1;
    if(empty($loa_receipt_id)){
        $strsup = "update loa_tt_receipt set no_of_increment='$nooffile'";
        $resultsup = mysqli_query($con, $strsup) or die(mysqli_error($con));  
    }    
} else {
   $nooffile = 1001;
   if(empty($loa_receipt_id)){
        $strsup = "update loa_tt_receipt set month_number='$no_of_month1',no_of_increment='$nooffile'";
        $resultsup = mysqli_query($con, $strsup) or die(mysqli_error($con));
   }   
}

if(empty($loa_receipt_id)){
    $loa_receipt_id_2 = $no_of_month1.''.$no_of_year.''.$nooffile;
}else{
    $loa_receipt_id_2 = $loa_receipt_id;    
}
mysqli_query($con, "update `st_application` set loa_receipt_id='$loa_receipt_id_2' where `sno`='$snoid'");


$output = "<style> 
    .header { position: fixed; top: -0px;width:100%;  padding:0px 50px 25px;height:0px; display: block; }
      footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 45px 0px;height:25px; font-size:14px; }
    }
footer p { text-align:center; color:#777; font-weight:normal;}
main { position:relative;width:100%; }
   .page {width:100%;   font-size:16px;  margin-top:90px; padding:0px 50px 5px; page-break-after: always; position:relative;line-height:19px; }
      .page:last-child {page-break-after:never;}
 @page { margin:20px 15px 65px; font-weight:599;width:100%; font-family:Arial, Helvetica, sans-serif; color:#333; font-size:18px; }
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
  <div class="header">   
  <p><span class="float-left"> <img src="../../images/logo-img.png" width="70"></span> <span class="float-right mt-5">DLI NO - O150186247152</span>
</p>
 
</div>
<footer>

<p><strong>Avalon Community College<br>
#201 – 155 Skinner Street, Nanaimo, Nanaimo, BC V9R 5E8<br>
1-250-824-1545
</strong> <b class="pagenum">  /1</b></p>


</footer>
<!-- Wrap the content of your PDF inside a main tag -->
<main class="page">

<div class="heading-txt">
<p><b> '.$loa_first_generate_date2.'</b></p>
<h2>Official Receipt</h2></div>
<p><b>Receipt No - '.$loa_receipt_id_2.'</b></p>         
  
<table class="mt-5"><tr><td>
<p>For the Attention of '.$gtitle.' '.$fullname.',<br><Br><Br>
Student ID: '.$student_id.'<br><Br>
Dear '.$gtitle.' '.$fullname.',<br><Br><Br><Br>
We, Avalon Community College hereby confirm that we have received the following from<br><Br>
'.$gtitle.' '.$fullname.',<br><Br>
Tuition Fee Received: $'.$genrate_amount_loa.'.00 CAD<br><Br><Br><Br>
Mode of Transfer - Telegraphic Transfer<br><Br><Br>
Thank you!<br>
Yours Faithfully,<br><br>
<img src="../../images/Sig_Cham.png" style="height:60px;"><Br><br><b>
Chamara Perera - Chief Operating Officer</b>
</p>
</td></tr></table>

</main>

';


$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

$loa_receipt_file = $rowstr1['loa_receipt_file'];
if(!empty($loa_receipt_file)){
	unlink("../LOA_Receipt/$loa_receipt_file");
}

$firstname = str_replace(' ', '', $fname);
$loa_rcpt_name = 'LOA_Receipt_'.$firstname.'_'.$refid;
$loa_rcpt_name2 = 'LOA_Receipt_'.$firstname.'_'.$refid.'.pdf';
$filepath = "../LOA_Receipt/$loa_rcpt_name.pdf";

file_put_contents($filepath, $document->output());

mysqli_query($con, "update `st_application` set `loa_receipt_file`='$loa_rcpt_name2', `genrate_amount_loa`='$genrate_amount_loa', `genrate_amount_loa_date`='$col_updated' where `sno`='$snoid'");

mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$adminrole1', '$snoid', '$fullname', '$user_id', '$refid', 'Receipt', 'Receipt', 'application?aid=error_$snoid', '1', '$col_updated')");

$document->stream("$loa_rcpt_name", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>