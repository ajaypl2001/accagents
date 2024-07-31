<?php
ob_start();
session_start();
include("../../db.php");

if(!empty($_POST['campus'])){
	$campus2 = $_POST['campus'];
	$campus3 = "AND st_application.campus='$campus2'";
}else{
	$campus2 = '';
	$campus3 = '';
}

$sessionid1 = $_SESSION['sno'];
if($sessionid1 == '300'){
	$agent_id_not_show2 = "AND notification_aol.agent_id NOT IN ('1136')";
	$agent_id_not_show = "AND user_id NOT IN ('1136')";
}else{
	$agent_id_not_show2 = '';
	$agent_id_not_show = '';
}

$status2 = $_POST['status'];
$start_date2 = $_POST['start_date'];
$end_date2 = $_POST['end_date'];

if(!empty($start_date3) && !empty($end_date3)){
	$start_end_condition = "AND (inserted_date between '$start_date3' and '$end_date3')";
}else{
	$start_end_condition = '';
}


if(($status2 == 'Yes') || ($status2 == 'No')){
	$st1 = "st_application.admin_status_crs = '$status2' AND notification_aol.stage='Application Status' AND notification_aol.created >= '$start_date2 00:00:00' and  notification_aol.created  <= '$end_date2 23:59:59'";
} elseif(($status2 == 'sol-Yes') || ($status2 == 'sol-No')){
	if($status2 == 'sol-Yes'){
		$sols = 'Yes';
	}
	if($status2 == 'sol-No'){
		$sols = 'No';
	}
	$st1 = "st_application.signed_ol_confirm = '$sols' AND notification_aol.stage='Signed Conditional Offer Letter Status' AND notification_aol.created >= '$start_date2 00:00:00' and  notification_aol.created  <= '$end_date2 23:59:59'";
} elseif(($status2 == 'scs-Yes') || ($status2 == 'scs-No')){
	if($status2 == 'scs-Yes'){
		$scs1 = 'Yes';
	}
	if($status2 == 'scs-No'){
		$scs1 = 'No';
	}
	$st1 = "st_application.signed_al_status = '$scs1' AND notification_aol.stage='Signed Contract Status' AND notification_aol.created >= '$start_date2 00:00:00' and  notification_aol.created  <= '$end_date2 23:59:59'";
	$scs2 = '';
	$scs3 = '';
} elseif($status2 == 'LOA_Generated'){
	$scs1 = "st_application.loa_file_date_updated_by >= '$start_date2 00:00:00' and  st_application.loa_file_date_updated_by  <= '$end_date2 23:59:59'";
	$st1 = "$scs1";
	$scs2 = '';
	$scs3 = '';
} elseif($status2 == 'LOA_Revised_Generated'){
	$scs2 = "st_application.loa_revised_date >= '$start_date2 00:00:00' and  st_application.loa_revised_date  <= '$end_date2 23:59:59'";
	$st1 = '';
	$scs3 = '';
} elseif($status2 == 'LOA_Defer_Generated'){
	$scs3 = "st_application.loa_defer_date >= '$start_date2 00:00:00' and  st_application.loa_defer_date  <= '$end_date2 23:59:59'";
	$st1 = '';
	$scs2 = '';
}else{
	if(empty($status2)){
		$st1 = "notification_aol.created >= '$start_date2 00:00:00' and  notification_aol.created  <= '$end_date2 23:59:59'";
	}else{
		$st1 = "notification_aol.stage = '$status2' AND notification_aol.created >= '$start_date2 00:00:00' and  notification_aol.created  <= '$end_date2 23:59:59'";
	}
	$scs2 = '';
	$scs3 = '';
}

if($status2 == 'LOA_Generated' || $status2 == 'LOA_Revised_Generated' || $status2 == 'LOA_Defer_Generated'){
	$getquery = "SELECT allusers.username, st_application.sno, st_application.user_id, st_application.campus, st_application.refid, st_application.fname, st_application.lname, st_application.loa_file_date_updated_by FROM st_application
INNER JOIN allusers ON st_application.user_id = allusers.sno
WHERE st_application.campus!='' $campus3 $agent_id_not_show AND
$st1 $scs2 $scs3";
}else{ 
	$getquery = "SELECT allusers.username, st_application.campus, st_application.user_id, st_application.admin_status_crs, st_application.signed_ol_confirm, notification_aol.sno, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.status, notification_aol.created, notification_aol.bgcolor, notification_aol.action_taken 
FROM notification_aol
INNER JOIN st_application ON notification_aol.application_id = st_application.sno
INNER JOIN allusers ON notification_aol.agent_id = allusers.sno
WHERE st_application.campus!='' $campus3 $agent_id_not_show2 AND
$st1 AND notification_aol.sno IN ( SELECT max(notification_aol.sno) FROM `notification_aol` group by notification_aol.refid)";
}
$list_all = mysqli_query($con, $getquery);
	
echo 'Campus'. "\t" .'Agent Name'. "\t" .'Student Name'. "\t" .'Reference Id'. "\t" .'Stage'. "\t" .'Date'. "\n";

if($status2 == 'LOA_Generated' || $status2 == 'LOA_Revised_Generated' || $status2 == 'LOA_Defer_Generated'){
	while($row_nm = mysqli_fetch_array($list_all)){
		$username = mysqli_real_escape_string($con,$row_nm['username']);
		$fname = mysqli_real_escape_string($con,$row_nm['fname']);
		$lname = mysqli_real_escape_string($con,$row_nm['lname']);
		$stdName = $fname.' '.$lname;
		$refid = mysqli_real_escape_string($con,$row_nm['refid']);
		$campus = mysqli_real_escape_string($con,$row_nm['campus']);
		$created = mysqli_real_escape_string($con,$row_nm['loa_file_date_updated_by']);
		$time = date('jS F, Y h:i:s A', strtotime("$created"));
		if($status2 == 'LOA_Generated'){
			$loa_1 = 'LOA Generated';
		}
		if($status2 == 'LOA_Revised_Generated'){
			$loa_1 = 'LOA Revised Generated';
		}
		if($status2 == 'LOA_Defer_Generated'){
			$loa_1 = 'LOA Defer Generated';
		}
		
	echo $campus. "\t" .$username. "\t" .$stdName. "\t" .  $refid. "\t" .  $loa_1. "\t" .  $time. "\n";	
		
	}	
}else{
	while($row_nm = mysqli_fetch_array($list_all)){
		$username = mysqli_real_escape_string($con,$row_nm['username']);
		$fullname = mysqli_real_escape_string($con,$row_nm['fullname']);
		$refid = mysqli_real_escape_string($con,$row_nm['refid']);
		$stage = mysqli_real_escape_string($con,$row_nm['stage']);
		$campus = mysqli_real_escape_string($con,$row_nm['campus']);
		$created = mysqli_real_escape_string($con,$row_nm['created']);
		$time = date('jS F, Y h:i:s A', strtotime("$created"));
		
		echo $campus. "\t" .$username. "\t" .$fullname. "\t" .  $refid. "\t" .  $stage. "\t" .  $time. "\n";
	}
}
header("Content-disposition: attachment; filename=AOL_Report.xls");
?>