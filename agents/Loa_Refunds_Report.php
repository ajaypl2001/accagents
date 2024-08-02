<?php
include("db.php");
date_default_timezone_set("Asia/Kolkata");
$weburl = 'https://collegeavalon.com/agents/loa_report_excel_download.php';

$first_current_date = date('Y-m-d');
$seven_current_date = date("Y-m-d",strtotime("-7 days"));
$get_month=date("Y-m");

$msg_body = '<style>
table td, table th { width:50%; }
table td:second-child, table th:second-child { text-align:left;}
</style>
<h2 style="text-align:center;">Date : ('.$seven_current_date.' - '.$first_current_date.')</h2>';	
		
$getAgent_str2_woEACO = "SELECT sno FROM `st_application` WHERE loa_file!='' AND date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$seven_current_date' AND '$first_current_date'";
$rsltAgent2_woEACO = mysqli_query($con, $getAgent_str2_woEACO);
$totalGenerated_woEACO = mysqli_num_rows($rsltAgent2_woEACO);

$getAgent_str2_woEACO2 = "SELECT sno FROM `st_application` WHERE v_g_r_status='V-R' AND date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$seven_current_date' AND '$first_current_date'";
$rsltAgent2_woEACO2 = mysqli_query($con, $getAgent_str2_woEACO2);
$totalGenerated_woEACO2 = mysqli_num_rows($rsltAgent2_woEACO2);

//////Total/////////////
$getAgent_str2_woEACO3 = "SELECT sno FROM `st_application` WHERE loa_file!=''";
$rsltAgent2_woEACO3 = mysqli_query($con, $getAgent_str2_woEACO3);
$totalGenerated_woEACO3 = mysqli_num_rows($rsltAgent2_woEACO3);

$getAgent_str2_woEACO4 = "SELECT sno FROM `st_application` WHERE v_g_r_status='V-R'";
$rsltAgent2_woEACO4 = mysqli_query($con, $getAgent_str2_woEACO4);
$totalGenerated_woEACO4 = mysqli_num_rows($rsltAgent2_woEACO4);

$msg_body .= '<p style="text-align:center;"><b>Weekly Report</b></p>
<table border="1" style="border-collapse:collapse; width:100%;border:1px solid #666; margin-top:5px;" cellpadding="4">
		<tr>
			<th bgcolor="#eee">LOA issued</th>
			<th>'.$totalGenerated_woEACO.'</th>
		</tr>
		<tr>
			<th bgcolor="#eee">V-R issued</th>
			<th>'.$totalGenerated_woEACO2.'</th>
		</tr>
		</table>
<br><p style="text-align:center;"><b>Total Report</b></p>
<table border="1" style="border-collapse:collapse; width:100%;border:1px solid #666; margin-top:5px;" cellpadding="4">
		<tr>
			<th bgcolor="#eee">LOA issued</th>
			<th>'.$totalGenerated_woEACO3.'</th>
		</tr>
		<tr>
			<th bgcolor="#eee">V-R issued</th>
			<th>'.$totalGenerated_woEACO4.'</th>
		</tr>
		</table>';
// print_r($msg_body);
// die;
$qry_userlist = "select * from report_sent where loa_nd_refund='1'";
$rslt_userlist = mysqli_query($con, $qry_userlist);
while($row_userlist = mysqli_fetch_array($rslt_userlist)){
    $email_send[] = mysqli_real_escape_string($con, $row_userlist['email_address']);
}

$subject = 'AOL College Weekly LOA & V-R Report';
foreach($email_send as $email_address){
    $to = $email_address;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: AOL College Weekly Report<no-reply@aoltorontoagents.ca>' . "\r\n";
    mail ($to,$subject,$msg_body,$headers);
}
?>