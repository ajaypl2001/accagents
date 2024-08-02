<?php
session_start();
include("../db.php");
date_default_timezone_set("America/Toronto");

require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();

if(!empty($_POST['snoidbknd']) && !empty($_POST['docBackend'])){
	$snoid = $_POST['snoidbknd'];
}else{
	$snoid = $_SESSION['stsno'];
	if($snoid == $_GET['uid']){
		
	}else{
		header('Location: error.php?error=STWW');
		die();
	}
}

$ppp_datetime = date('Y-m-d H:i:s');
$ppp_datetime2 = date('Y-m-d');
$resultsStr = "SELECT * FROM ppp_form WHERE sno='$snoid'";
$get_query = mysqli_query($con, $resultsStr);
$rowstr = mysqli_fetch_assoc($get_query);
$student_no = $rowstr['student_no'];
$program = $rowstr['program'];
if($program == 'PC Support Specialist Toronto'){
	$program_Lists = 'PC Support Specialist';
}else{
	$program_Lists = $program;
}
$method_list = $rowstr['method_list'];
$fname = $rowstr['fname'];
$lname = $rowstr['lname'];
$fullname = $fname.' '.$lname;
$pia = $rowstr['pia'];
$contract_student_signature = $rowstr['contract_student_signature'];
$getSignature = '../Student_Sign/'.$contract_student_signature;

$contract_send_date = $rowstr['contract_send_date'];
$worker_id = $rowstr['worker_id'];
$agnt_qryFos = mysqli_query($con,"SELECT name, rep_sign FROM ulogin where name!='' AND sno='$worker_id'");
if(mysqli_num_rows($agnt_qryFos)){
	$row_agnt_qryFos = mysqli_fetch_assoc($agnt_qryFos);
	$loggedName = $row_agnt_qryFos['name'];
	$rep_signName = $row_agnt_qryFos['rep_sign'];
	$rep_signName2 = '<img src="Rep_Sign/'.$rep_signName.'" width="100" height="30">';
}else{
	$loggedName = 'N/A';
	$rep_signName2 = 'N/A';
}

/////////////New Table///////////////
$resultsStr3 = "SELECT sno, ppp_form_id, pai_sign FROM `ppp_form_more` where ppp_form_id='$snoid'";
$get_query3 = mysqli_query($con, $resultsStr3);
if(mysqli_num_rows($get_query3)){
	$rowstr3 = mysqli_fetch_assoc($get_query3);
	$pai_sign = $rowstr3['pai_sign'];
}else{
	$pai_sign = '';	
}
///////////////////////////////////////

$output = "<style> 
  .header { position: fixed; top: -0px;width:100%;  padding:0px 0px 25px;height:60px; display: block;  }
   footer {position: fixed;bottom:0px; width:100%;text-align:left; padding:0px 0px 0px;height:100px; font-size:11px; border-top:1px solid #333;}
    
footer p { text-align:center;}
main { position:relative;width:100%; }
   .page {width:100%;   font-size:15px;  margin-top:100px; margin-bottom:0px; padding:0px 0px 0px; page-break-after: always; position:relative;line-height:21px; }
      .page:last-child {page-break-after:never;}
 @page { margin:60px 70px 15px; font-weight:599;width:100%;  color:#333; font-size:15px; }
.float-left { float:left;}
.border-bottom { border-bottom:1px solid #333; min-height:50px ;}
  .border-bottom-dotted{ border-bottom:1px dotted #333; min-height:50px ;}
  h4 { font-size:17px; text-align:center;}
</style>";

$output .= '
  <div class="header"> 
          <table width="100%"><tr><td align="center" valign="center" style="vertical-align: middle;">  
          <img src="../aol-pdf/images/academy_of_learning_logo.jpg" width="170"  /></td></tr></table> 
        </div>
       <main class="page"> 
       <h4>Proof of Admissions Interview</h4>
<br>
<p>
I, <u> '.$loggedName.' </u> hereby acknowledge that an admissions interview was conducted with <u> '.$fullname.' </u> on <u> '.$ppp_datetime2.' </u> via <u> '.$method_list.' </u> for <u> '.$program_Lists.' </u>. </p>
<br><br>
 <table width="100%" class="sign_table">
 <tr> <td width="150" style="vertical-align:bottom">Admissions Advisor Signature: </td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:120px; height:30px; ">'.$rep_signName2.'&nbsp;</td>
    <td width="130">&nbsp;</td>
    <td width="20" style="vertical-align:bottom">Date</td>
    <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
</table><br><br>
<p>I, <u> '.$fullname.' </u> hereby acknowledge that I participated in an admissions interview scheduled by <u> '.$loggedName.' </u> on <u> '.$ppp_datetime2.' </u> via <u> '.$method_list.' </u> for <u> '.$program_Lists.' </u>. </p>
<br><br>
 <table width="100%" class="sign_table">
 <tr> <td width="88" style="vertical-align:bottom">Student Signature:</td>
<td style="border-bottom:1px solid #333 !important;vertical-align:bottom;float:left; width:170px; height:30px; "><img src="'.$getSignature.'" width="100" height="26">&nbsp;</td>
    <td width="130">&nbsp;</td>
    <td width="20" style="vertical-align:bottom">Date</td>
    <td style="border-bottom:1px solid #333 !important;vertical-align:bottom; float:left; width:110px;">'.$contract_send_date.'&nbsp;</td>
</tr>
</table>
</main>
';

$output .= '';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($pai_sign)){
	unlink("uploads/$pai_sign");
}

$vnum = str_replace(' ', '', $student_no);
$olname = 'PIA_Sign_'.$vnum;
$olname2 = 'PIA_Sign_'.$vnum.'.pdf';
$filepath = "uploads/$olname.pdf";

file_put_contents($filepath, $document->output());

if(mysqli_num_rows($get_query3)){
	$getUpdate = "update `ppp_form_more` set `pai_sign`='$olname2', `pai_sign_datetime`='$ppp_datetime' where `ppp_form_id`='$snoid'";
	mysqli_query($con, $getUpdate);
}else{
	$getInsert = "INSERT INTO `ppp_form_more` (`ppp_form_id`, `pai_sign`, `pai_sign_datetime`) VALUES ('$snoid', '$olname2', '$ppp_datetime')";
	mysqli_query($con, $getInsert);
}

if(!empty($_POST['snoidbknd']) && !empty($_POST['docBackend'])){
	$document->stream("$olname2", array("Attachment"=>1));
	// 1  = Download
	// 0 = Preview
}else{
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<link rel="icon" href="../images/top-logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/almuni.css">
    <title>AOLCC - Proof of Admissions Interview</title>
</head>

<body>

<div class="s01 mb-5">
<div class="signin-page">
    <div class="container">
        <div class="row">
			<div class="col-12 col-sm-12 pb-2 mb-2">
                <a href=""><img src="../images/academy-of-learning-white.png" class="float-left" width="180"></a>
            </div>
			
			<div class="col-12 col-sm-7 py-2">
                <span class="btn float-start btn-success text-center btn_next">Signed Proof of Admissions Interview Docs</span>
            </div>
			
            <div class="col-12 col-sm-5 py-2">
                <a href="success.php?uid=<?php echo $snoid; ?>" class="btn float-sm-end btn-primary text-center btn_next">Final Submit</a>
            </div>


		<div class="col-12">
			<iframe src="<?php echo $filepath ?>" width="100%" height="600px"></iframe> 
		</div>
	</div>
</div>
</div>
</div>
</body>
</html>
<?php } ?>