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
	$agent_id_not_show = "AND notification_aol.agent_id NOT IN ('1136')";
}else{
	$agent_id_not_show = '';
}
	
	if(($roleNoti == "Admin") && ($loa_allow == '1')){
		// $agent_noti = "(notification_aol.role = 'Admin') AND notification_aol.stage='Signed Contract Status' AND notification_aol.created >= '2019-04-18' AND";
		// $clg_pr_type = '';
		$agent_noti = "(notification_aol.role='Agent') AND notification_aol.created >= '2019-04-01' AND";
		$clg_pr_type = " AND (notification_aol.clg_pr_type = 'admin' OR notification_aol.clg_pr_type = 'excu')";
	}else{
		
	if($roleNoti == "Excu"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type = "AND (notification_aol.clg_pr_type = 'excu')";
	}
	if($roleNoti == "Admin"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type = "AND (notification_aol.clg_pr_type = 'admin')";
	}
	if($roleNoti == "Excu1"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type = " AND (notification_aol.clg_pr_type = 'admin')";
	}
	if($roleNoti == "Admin" && $notify_per == "1" && $report_allow == "1"){
		$agent_noti = "(notification_aol.role='Agent') AND notification_aol.created >= '2019-04-01' AND";
		$clg_pr_type = " AND (notification_aol.clg_pr_type = 'admin' OR notification_aol.clg_pr_type = 'excu')";
	}
	if($roleNoti == "Admin" && $notify_per == "" && $report_allow == ""){
		$agent_noti = '';
		$clg_pr_type = " AND (notification_aol.role = 'Admin') AND (notification_aol.report_noti='Yes')";
	}
	}
	// echo $clg_pr_type;
	// die;
	
	$strcheckc = "SELECT allusers.username,notification_aol.sno, notification_aol.application_id, notification_aol.role, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.created, notification_aol.bgcolor
FROM notification_aol
INNER JOIN allusers ON notification_aol.agent_id=allusers.sno where $agent_noti status='1' $clg_pr_type $agent_id_not_show ORDER BY notification_aol.created desc LIMIT 5";
// echo $strcheckc;
	// die;
}else{
	if($cmsn_login == '1'){
		
		$strcheckc = "SELECT allusers.username,notification_aol.sno, notification_aol.application_id,notification_aol.role, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.created, notification_aol.bgcolor
FROM notification_aol
INNER JOIN allusers ON notification_aol.agent_id=allusers.sno where (notification_aol.role='Admin' OR notification_aol.role= 'Excu' OR notification_aol.role= 'Excu1') AND notification_aol.status='1' AND notification_aol.report_noti='Yes' AND (notification_aol.stage!='COMMISSION Details' AND notification_aolstage!='Refund Documents Status') ORDER BY notification_aol.sno desc LIMIT 5";
	}else{
		
		$strcheckc = "SELECT allusers.username,notification_aol.sno, notification_aol.application_id,notification_aol.role, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.created, notification_aol.bgcolor
FROM notification_aol
INNER JOIN allusers ON notification_aol.agent_id=allusers.sno where (notification_aol.role='Admin' OR notification_aol.role= 'Excu' OR notification_aol.role= 'Excu1') AND status='1' AND agent_id='$snoNoti' AND notification_aol.report_noti!='Yes' AND (stage!='COMMISSION Details' AND stage!='Refund Documents Status')  ORDER BY notification_aol.sno desc LIMIT 5";
	}
	
}
// echo $strcheckc;
	// die;

	 $resultcheckc=mysqli_query($con,$strcheckc);
	 if(mysqli_num_rows($resultcheckc)){
	if($roleNoti == "Admin" && $notify_per == "" && $report_allow == ""){	 
	   while ($rowslctd=mysqli_fetch_array($resultcheckc)){
		 $sno = mysqli_real_escape_string($con,$rowslctd['sno']);
		 $role = mysqli_real_escape_string($con,$rowslctd['role']);
		 $report_noti = mysqli_real_escape_string($con,$rowslctd['report_noti']);
		 $username = mysqli_real_escape_string($con,$rowslctd['username']);
		 $fullname = mysqli_real_escape_string($con,$rowslctd['fullname']);
		 $post = mysqli_real_escape_string($con,$rowslctd['post']);
		 $stage = mysqli_real_escape_string($con,$rowslctd['stage']);
		 $url = mysqli_real_escape_string($con,$rowslctd['url']);
		 $bgcolor = mysqli_real_escape_string($con,$rowslctd['bgcolor']);
		 $created = mysqli_real_escape_string($con,$rowslctd['created']);
		 $application_id = mysqli_real_escape_string($con,$rowslctd['application_id']);
		 $time = date('jS F, Y h:i:s A', strtotime("$created"));
		 
		 if($role == 'Admin'){			
		   $name_both = "<span style='margin-left:-10px;color:#000;'>$post ($fullname)</span> <br>";
		}else{
			$name_both = "<span style='margin-left:-10px;'>$post ($username)</span> <br>		   
		   <span style='color:#3a7f3e;'>$fullname</span><br>";
		}	
		
		if($stage == 'TT Receipt'){
			$report_page_url = 'loa_receipt';
		}else{
			$report_page_url = 'vgrapplication';
		}
		   
		   echo "<li style='background:$bgcolor;'>
		   <a href='../report/$report_page_url.php?noti=$sno&cmsn=Yes&aid=error_$application_id' style='width: 100%; line-height:0;'>
		    $name_both
		   <span style='font-size:10px;margin-right:0px;float:right; text-align:right;color:#000;margin-top:4px; margin-bottom:12px;'>$time</span></a>
	</li>";
	  }
	}else{
		while ($rowslctd=mysqli_fetch_array($resultcheckc)){
		 $sno = mysqli_real_escape_string($con,$rowslctd['sno']);
		 $role = mysqli_real_escape_string($con,$rowslctd['role']);
		 $username = mysqli_real_escape_string($con,$rowslctd['username']);
		 $fullname = mysqli_real_escape_string($con,$rowslctd['fullname']);
		 $post = mysqli_real_escape_string($con,$rowslctd['post']);
		 $url = mysqli_real_escape_string($con,$rowslctd['url']);
		 $bgcolor = mysqli_real_escape_string($con,$rowslctd['bgcolor']);
		 $created = mysqli_real_escape_string($con,$rowslctd['created']);
		 $time = date('jS F, Y h:i:s A', strtotime("$created"));
		
		 if($role == 'Admin'){			
		   $name_both = "<span style='margin-left:-10px;color:#000;'>$post ($fullname)</span> <br>";
		}else{
			$name_both = "<span style='margin-left:-10px;color:#000;'>$post ($username)</span> <br>		   
		   <span style='color:#3a7f3e;'>$fullname</span><br>";
		}
		 
		   echo "<li style='background:$bgcolor;'>
		   <a href='../$url&noti=$sno' style='width: 100%; line-height:0;'>
		   $name_both
		   <span style='font-size:11px;margin-right:0px;float:right; text-align:right;color:#000;margin-top:4px; margin-bottom:12px;'>$time</span></a>
	</li>";
	  }
	}
	 }else{
	 echo "<center>No New Notification</center>";
	 }
 }
?>