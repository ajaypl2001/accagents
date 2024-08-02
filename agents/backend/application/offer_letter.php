<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");

session_start();
if(!empty($_SESSION['sno'])){
	$loggedid = $_SESSION['sno'];
	$rsltLogged = mysqli_query($con,"SELECT contact_person FROM allusers WHERE sno = '$loggedid'");
	$rowLogged = mysqli_fetch_assoc($rsltLogged);
	$contact_person = mysqli_real_escape_string($con, $rowLogged['contact_person']);
}else{
	$contact_person = 'Sess-Out';
}

require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();

$col_updated = date('Y-m-d H:i:s');
$datetime = date('Y-m-d');
$crnt_date = date("F d, Y", strtotime($datetime));

$campus = $_POST['campus'];
$tk = $_POST['tk'];
$pn = $_POST['pn'];
$snoid = $_POST['snoid'];
$ol_type = $_POST['ol_type'];
$ol_type_remarks = $_POST['ol_type_remarks'];
$old_new = $_POST['old_new'];

$ol_processing = $_POST['ol_processing'];
$ol_conditional_pal = $_POST['ol_conditional_pal'];
if($ol_processing == 'Conditional COL'){
	$olCondPal = ", ol_conditional_pal='$ol_conditional_pal'";
	$ConditionalDiv = 'Conditional';
}
if($ol_processing == 'Final COL'){
	$olCondPal = ", ol_conditional_pal=''";
	$ConditionalDiv = '';
}

$query1 = "SELECT * FROM st_application WHERE sno='$snoid'";
$result1 = mysqli_query($con, $query1);
$rowstr1 = mysqli_fetch_assoc($result1);
$fname = $rowstr1['fname'];
$lname = $rowstr1['lname'];
$fullname = ucfirst($fname).' '.ucfirst($lname);
$refid = $rowstr1['refid'];
$dob = $rowstr1['dob'];
$getdob = date("d/m/Y",strtotime($dob));

$address1 = $rowstr1['address1'];
$address3 = $rowstr1['address2'];
$address22 = $rowstr1['address2'];
if($address22 !== ''){
	$address2 = ', '.$address22;
}else{
	$address2 = '';
}

$city = $rowstr1['city'];
$state = $rowstr1['state'];
$country = $rowstr1['country'];
$pincode = $rowstr1['pincode'];
$offer_letter = $rowstr1['offer_letter'];
$ol_first_date = $rowstr1['ol_first_date'];

if(!empty($ol_first_date)){
	$ol_first_date2 = ", ol_first_date='$ol_first_date'";
}else{
	$ddd = date('Y-m-d');
	$ol_first_date2 = ", ol_first_date='$ddd'";	
}

// $crnt_date = date("F d, Y", strtotime($ol_first_date));

$query2 = "SELECT * FROM contract_courses WHERE intake='$tk' AND program_name='$pn' AND campus='$campus'";
$result2 = mysqli_query($con, $query2);
$rowstr2 = mysqli_fetch_assoc($result2);
$commenc_date = $rowstr2['commenc_date'];
$expected_date = $rowstr2['expected_date'];
$tuition_fee = $rowstr2['tuition_fee'];
$app_fee = $rowstr2['app_fee'];
$stu_ra_service_fee = $rowstr2['stu_ra_service_fee'];
$textbook_cost = $rowstr2['textbook_cost'];
$inter_stud_schlr = $rowstr2['inter_stud_schlr'];
$total = $rowstr2['total'];
$week = $rowstr2['week'];
$tf_new2 = $rowstr2['tf_new'];

if($tk == 'May-2024' || $tk == 'JAN-2024' || $tk == 'SEP-2023' || $tk == 'SEP-2024'){
	if($old_new == 'Old'){
		$tf_new = '13,500.00';
		$tf_content = '(First Year Tuition Fees)';
		$maybeforeDiv = '<tr><td>International Scholarship</td>
	   <td>:</td>
	   <td>'.$inter_stud_schlr.'</td>
	   </tr>';
	   $maybeforeDiv2 = 'You are entitled to a Scholarship of '.$inter_stud_schlr.' CAD.';
	}else{
		$maybeforeDiv = '';
		$maybeforeDiv2 = '';
		$tf_new = $tf_new2;
		$tf_content = '';
	}
}else{
	$maybeforeDiv = '';
	$maybeforeDiv2 = '';
	$tf_new = '13,500.00';
	$tf_content = '(First Year Tuition Fees)';
}

$no_of_month1 = date("m");
$no_of_year = date("y");

$branchcode_query = "select * from avl_student_id";
$getbranch_res = mysqli_query($con, $branchcode_query);
$branch_codedta = mysqli_fetch_assoc($getbranch_res);
$month_number = $branch_codedta['month_number']; 
$no_of_encrement = $branch_codedta['no_of_increment']; 

$querysid_2 = "SELECT student_id FROM st_application where sno='$snoid'";
$rseultst_id_2 = mysqli_query($con, $querysid_2);
$rowst_id_2 = mysqli_fetch_assoc($rseultst_id_2);
$student_id = $rowst_id_2['student_id'];

if($month_number == $no_of_month1){
   $nooffile = $no_of_encrement+1;
    if(empty($student_id)){
        $strsup = "update avl_student_id set no_of_increment='$nooffile'";
        $resultsup = mysqli_query($con, $strsup) or die(mysqli_error($con));  
    }    
} else {
   $nooffile = 100;
   if(empty($student_id)){
        $strsup = "update avl_student_id set month_number='$no_of_month1',no_of_increment='$nooffile'";
        $resultsup = mysqli_query($con, $strsup) or die(mysqli_error($con));
   }   
}

if(empty($student_id)){
    $student_id_2 = $no_of_month1.''.$no_of_year.''.$nooffile;
}else{
    $student_id_2 = $student_id;    
}
mysqli_query($con, "update `st_application` set student_id='$student_id_2' where `sno`='$snoid'");


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
  table td { padding:2px;}
  .header { position: fixed; top:30px;width:100%;  padding:0px 60px 25px;height:80px; z-index:999; display: block; }
 footer {position: fixed;bottom:80px; width:100%; z-index:999; padding:0px 55px 0px;height:25px; }

</style>";

$output .= '
<div class="header">   
  <p><span class="float-left"> <img src="images/logo.jpg" width="70"></span> <span class="float-right mt-5"><b>DLI NO -</b> O150186247152</span>  
</p>
  </div><footer>
<p><strong> Address:</strong>  #201 – 155 Skinner Street, Nanaimo, BC V9R 5E8<br>
w: <a>www.avaloncommunitycollege.ca </a> | e: <a> info@avaloncommunitycollege.ca</a> | p: 1-250-824-1545</p>
</footer>

<main class="page">    
<p>'.$crnt_date.'<br><br>
'.$fullname.'<br>
'.$address1.''.$address2.'<br>
'.$city.', '.$pincode.', '.$country.'
</p><br>
<p style="font-size:16px;"><b>RE: '.$ConditionalDiv.' Offer Letter</p><br>
<p>
<b>#Student ID – </b> '.$student_id_2.'<br>
Date of Birth – '.$getdob.'<br><br>
Dear <b>'.$fullname.',</b><br><br>
Congratulations! We are delighted to provide you with this offer of admission into the &nbsp;  &nbsp; <b> '.$pn.' </b> at the 
<b>Avalon Community College, Nanaimo, British Columbia.</b><br><br><b>
Please note this is not a Letter of Acceptance and should not be used for Study Permit or Visa purposes.</b></p>
<table style="margin-top:15px;"><tr><td><b>Program Name:</b></td><td> '.$pn.'</td></tr>
<tr><td><b>Intake:</b></td><td> '.$tk.'</td></tr>
<tr><td><b>Duration: </b></td><td>'.$week.'</td></tr>
<tr><td><b>Start Date: </b></td><td>'.$commenc_date.'</td></tr>
<tr><td><b>College DLI No: </b></td><td>O150186247152</td></tr>
<tr><td><b>Level of Study: </b></td><td> Diploma</td></tr>
<tr><td><b>College Type:</b></td><td> Licensed Private</td></tr>
<tr><td><b>Deposit Required: </b></td><td>CAD '.$tf_new.' '.$tf_content.'</td></tr>
<tr><td><b>Fees:</b></td><td> CAD '.$total.'</td></tr>
</table>
<br>
<p><b>Admission Requirements - </b></p>
          <ol start="1">
          <li> IELTS Requirements - 6.0 overall.</li>
<li> Copy of all transcripts for the highest level of education.</li>
<li> Please note that you must deposit the fees and share the required documents before the 
deadline.</li>
<li> Your admission to the College is cancelled without notice if you are unable to deposit the fees or 
submit the required documents before the deadline.</li>
<li> The College reserves the right to change the tuition fees.</li>
         </ol><br>
<p>We welcome you to Avalon Community College, Nanaimo, British Columbia. For any information regarding your 
college admission, please contact us at <u> <a> international@avaloncommunitycollege.com</a> </u>  – International 
Department.
</p>         
          </main>


       <main class="page" style=" page-break-after: never;" > <br><br><p>The total costs of the program (tuition and fees) are <b> &nbsp; '.$total.' CAD </b> broken down as follows:</p><br>
          <table class="table1">
<tr><td colspan="3"><b><u>'.$pn.'</u></b><br></td></tr>
   <tr><td>Tuition</td>
   <td>:</td>
   <td>'.$tuition_fee.'</td>
   </tr> 
   <tr><td>Application fees (non-refundable)</td>
   <td>:</td>
   <td>'.$app_fee.'</td>
   </tr> 
 <tr><td>Student Records  Archiving and Student services FEE </td>
   <td>:</td>
   <td>'.$stu_ra_service_fee.'</td>
   </tr>
   <tr><td>Textbook, Costs (max/approx.)</td>
   <td>:</td>
   <td>'.$textbook_cost.'</td>
   </tr>  
   '.$maybeforeDiv.'    
</td></tr>
</table><br>
<p>
'.$maybeforeDiv2.'  To reserve your seat, a total amount of &nbsp; &nbsp; <b>  '.$tf_new.' CAD &nbsp; &nbsp;</b>must be paid. <br><br>
We look forward to seeing you in British Columbia and wish you success in your studies.
   <br><br><br>
   Sincerely,<br><br>
   <img src="images/Sig_Cham1.jpg" style="height:60px;">   <br><br>
Chamara Perera<br>
Chief Operating Officer<br>
<!--Direct Line: 250-619-2637-->
<p>
</main> </div>';

$document->loadHtml($output);
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($offer_letter)){
	unlink("../../uploads/offer_letter/$offer_letter");
}

$firstname = str_replace(' ', '', $fname);
$olname = 'Offer_Letter_'.$firstname.'_'.$refid;
$filepath = "../../uploads/offer_letter/$olname.pdf";
file_put_contents($filepath, $document->output());

if($ol_type !== ''){
if($ol_type == 'Revised'){
	$both_datetime = ", `ol_revised_date`='$col_updated'";
}
if($ol_type == 'Defer'){
	$both_datetime = ", `ol_defer_date`='$col_updated'";
}
}else{
	$both_datetime = '';
}

if(!empty($offer_letter)){
	$oltype = $ol_type;
}else{	
	$oltype = 'First-Time';
}

mysqli_query($con, "update `st_application` set `offer_letter`='$filepath', `ol_type`='$ol_type', `ol_type_remarks`='$ol_type_remarks', ol_processing='$ol_processing', old_new='$old_new' $olCondPal $both_datetime $ol_first_date2 where `sno`='$snoid'");

$olsd = $ol_processing.' - '.$ol_conditional_pal;

mysqli_query($con, "INSERT INTO `col_loa_logs` (`app_id`, `name`, `issue`, `type`,  `updated_at`, `updated_by`, `remarks`) VALUES ('$snoid', 'COL', '$olsd', '$oltype', '$col_updated', '$contact_person', '$tk - $pn - $ol_type_remarks')");

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>