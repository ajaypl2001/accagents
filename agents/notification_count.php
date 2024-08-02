<?php
session_start();
include_once("db.php");
date_default_timezone_set("Asia/Kolkata");

if($_SESSION){
$uname = $_SESSION['sno'];
$result = mysqli_query($con,"SELECT sno, role, email, notify_per, report_allow, cmsn_login, loa_allow FROM allusers WHERE sno = '$uname'");
$row = mysqli_fetch_assoc($result);
$snoNoti = mysqli_real_escape_string($con, $row['sno']);
$roleNoti = mysqli_real_escape_string($con, $row['role']);
$email2323 = mysqli_real_escape_string($con, $row['email']);
$notify_per = mysqli_real_escape_string($con, $row['notify_per']);
$report_allow = mysqli_real_escape_string($con, $row['report_allow']);
$cmsn_login = mysqli_real_escape_string($con, $row['cmsn_login']);
$loa_allow = mysqli_real_escape_string($con, $row['loa_allow']);

if(($roleNoti == "Admin") || ($roleNoti == "Excu") || ($roleNoti == "Excu1")){
	
if($email2323 == 'operation@aol'){
	$agent_id_not_show = "AND agent_id NOT IN ('1136')";
}else{
	$agent_id_not_show = '';
}	
	
	if(($roleNoti == "Admin") && ($loa_allow == '1')){
		// $agent_noti = "AND (role = 'Admin') AND notification_aol.stage='Signed Contract Status' AND created >= '2019-04-18'";
		// $clg_pr_type = '';
		
		$agent_noti = "AND (role = 'Agent') AND created >= '2019-04-01'";
		$clg_pr_type = " AND (clg_pr_type = 'admin' OR clg_pr_type = 'excu')";
	}else{
	
	if($roleNoti == "Excu"){
		$agent_noti = "AND (role = 'Agent') ";
		$clg_pr_type = "AND clg_pr_type = 'excu'";
	}
	if($roleNoti == "Admin"){
		$agent_noti = "AND (role = 'Agent') ";
		$clg_pr_type = "AND clg_pr_type = 'admin'";
	}
	if($roleNoti == "Excu1"){
		$agent_noti = "AND (role = 'Agent') ";
		$clg_pr_type = "AND clg_pr_type = 'admin'";
	}
	// if($roleNoti == "Admin" && $notify_per == "1"){
	if($roleNoti == "Admin" && $notify_per == "1" && $report_allow == "1"){	
		$agent_noti = "AND (role = 'Agent') AND created >= '2019-04-01'";
		$clg_pr_type = " AND (clg_pr_type = 'admin' OR clg_pr_type = 'excu')";
	}
	if($roleNoti == "Admin" && $notify_per == "" && $report_allow == ""){
		$agent_noti = '';
		$clg_pr_type = " AND (notification_aol.role = 'Admin') AND (notification_aol.report_noti='Yes')";
	}
	}	
	
	$strcheckc = "SELECT sno FROM notification_aol WHERE status=1 $agent_noti $clg_pr_type $agent_id_not_show";	
	
	// echo $strcheckc;
	// die;
}else{
	if($cmsn_login == '1'){
		$strcheckc = "SELECT sno FROM notification_aol WHERE status=1 AND (role = 'Admin' OR role = 'Excu' OR role = 'Excu1') AND (stage!='COMMISSION Details' AND stage!='Refund Documents Status') AND notification_aol.report_noti='Yes' AND agent_id='$snoNoti'";
	}else{
		$strcheckc = "SELECT sno FROM notification_aol WHERE status=1 AND (role = 'Admin' OR role = 'Excu' OR role = 'Excu1') AND (stage!='COMMISSION Details' AND stage!='Refund Documents Status') AND notification_aol.report_noti!='Yes' AND agent_id='$snoNoti'";
	}
}
	$resultcheckc=mysqli_query($con,$strcheckc);
	if(mysqli_num_rows($resultcheckc)){
		echo mysqli_num_rows($resultcheckc);
		echo "<style>span#count_notify_me{color: #fff !important;font-size: 12px;font-weight: bold;position: absolute;top: -9px;right: 4px;border-radius: 10px;background: #ea3859;min-width: 22px;min-height: 22px; line-height:22px;padding: 0;border-radius:50%;}</style>";		
	}else{
		echo "";
	}
}
?>