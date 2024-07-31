<?php
include("db.php");
date_default_timezone_set("Asia/Kolkata");
$current_date3 = date('Y-m-d');
$current_date = date("Y-m-d",strtotime($current_date3." -1 day"));

$time=strtotime($current_date);
$month_present=date("F",$time);
$getAgent_str = "SELECT allusers.sno, allusers.username FROM allusers INNER JOIN st_application ON allusers.sno = st_application.user_id where allusers.role='Agent' GROUP BY allusers.sno ORDER BY allusers.username ASC";
$rsltAgent = mysqli_query($con, $getAgent_str);
$totalCountApplication = mysqli_num_rows($rsltAgent);

$getAgent_str2 = "SELECT * FROM `allusers` where allusers.role='Agent'";
$rsltAgent2 = mysqli_query($con, $getAgent_str2);
$totalCountApplication2 = mysqli_num_rows($rsltAgent2);
$minusApplication = ($totalCountApplication2-$totalCountApplication);

$msg_body = '<h2 style="text-align:center;">AOL College Full Report</h2>
	<p style="text-align:center;"><b>Total Agents who Created Application : </b>'.$totalCountApplication.'</p>
	<p style="text-align:center;"><b>Total Agents who didn`t Create Application : </b>'.$minusApplication.'</p>
	<table border="1" style="border-collapse:collapse; width:100%;text-align:center;border:1px solid #666;" cellpadding="4">
		<tr bgcolor="#eee">
			<th>Agent Name</th>
			<th>Registered</th>
			<th>Registered Completed</th>
			<th>Application Approved</th>
			<th>COL Sent</th>
			<th>Rqst LOA</th>			
			<th>LOA Sent</th>
			<th>V-G</th>
			<th>V-R</th>
		</tr>';

$registerCount_sum=0;
$registerNotCompeleteCount_sum=0;
$APSTCount_sum=0;
$COLCount_sum=0;
$rqstLOACount_sum=0;
$LOACount_sum=0;
$rqstVGCount_sum=0;
$rqstVRCount_sum=0;
while($rowAgent = mysqli_fetch_assoc($rsltAgent)){
	$username = $rowAgent['username'];
	$agent_id = $rowAgent['sno'];
	
	$register_str = "SELECT sno FROM `st_application` where user_id='$agent_id' AND datetime!=''";
	$rsltregister = mysqli_query($con, $register_str);
	if(mysqli_num_rows($rsltregister)){
		$registerCount = mysqli_num_rows($rsltregister);
		$registerCount2 = mysqli_num_rows($rsltregister);
	}else{
		$registerCount = '';
		$registerCount2 = '0';
	}
	$registerCount_sum +=$registerCount2;

	$registerNotCompelete_str = "SELECT sno FROM `st_application` where user_id='$agent_id' AND datetime!='' AND personal_status!='' AND academic_status!='' AND course_status!='' AND application_form!=''";
	$rsltregisterNotCompelete = mysqli_query($con, $registerNotCompelete_str);
	if(mysqli_num_rows($rsltregisterNotCompelete)){
		$registerNotCompeleteCount = mysqli_num_rows($rsltregisterNotCompelete);
		$registerNotCompeleteCount2 = mysqli_num_rows($rsltregisterNotCompelete);
	}else{
		$registerNotCompeleteCount = '';
		$registerNotCompeleteCount2 = '0';
	}
	$registerNotCompeleteCount_sum +=$registerNotCompeleteCount2;
	
	$APST_str = "SELECT sno FROM `st_application` where user_id='$agent_id' AND admin_status_crs='Yes'";
	$rsltAPST = mysqli_query($con, $APST_str);
	if(mysqli_num_rows($rsltAPST)){
		$APSTCount = mysqli_num_rows($rsltAPST);
		$APSTCount2 = mysqli_num_rows($rsltAPST);
	}else{
		$APSTCount = '';
		$APSTCount2 = '0';
	}
	$APSTCount_sum +=$APSTCount2;
	
	$COL_str = "SELECT sno FROM `st_application` where user_id='$agent_id' AND offer_letter_sent_datetime!=''";
	$rsltCOL = mysqli_query($con, $COL_str);
	if(mysqli_num_rows($rsltCOL)){
		$COLCount = mysqli_num_rows($rsltCOL);
		$COLCount2 = mysqli_num_rows($rsltCOL);
	}else{
		$COLCount = '';
		$COLCount2 = '0';
	}	
	$COLCount_sum +=$COLCount2;
	
	$rqstLOA_str = "SELECT sno FROM `st_application` where user_id='$agent_id' AND agent_request_loa_datetime!=''";
	$rsltrqstLOA = mysqli_query($con, $rqstLOA_str);
	if(mysqli_num_rows($rsltrqstLOA)){
		$rqstLOACount = mysqli_num_rows($rsltrqstLOA);
		$rqstLOACount2 = mysqli_num_rows($rsltrqstLOA);
	}else{
		$rqstLOACount = '';
		$rqstLOACount2 = '0';
	}	
	$rqstLOACount_sum +=$rqstLOACount2;	
	
	$LOA_str = "SELECT sno FROM `st_application` where user_id='$agent_id' AND loa_file_date_updated_by!=''";
	$rsltLOA = mysqli_query($con, $LOA_str);
	if(mysqli_num_rows($rsltLOA)){
		$LOACount = mysqli_num_rows($rsltLOA);
		$LOACount2 = mysqli_num_rows($rsltLOA);
	}else{
		$LOACount = '';
		$LOACount2 = '0';
	}	
	$LOACount_sum +=$LOACount2;
	
	$rqstVG_str = "SELECT sno FROM `st_application` where user_id='$agent_id' AND (v_g_r_status!='' AND v_g_r_status='V-G')";
	$rsltrqstVG = mysqli_query($con, $rqstVG_str);
	if(mysqli_num_rows($rsltrqstVG)){
		$rqstVGCount = mysqli_num_rows($rsltrqstVG);
		$rqstVGCount2 = mysqli_num_rows($rsltrqstVG);
	}else{
		$rqstVGCount = '';
		$rqstVGCount2 = '0';
	}	
	$rqstVGCount_sum +=$rqstVGCount2;
	
	$rqstVR_str = "SELECT sno FROM `st_application` where user_id='$agent_id' AND (v_g_r_status!='' AND v_g_r_status='V-R')";
	$rsltrqstVR = mysqli_query($con, $rqstVR_str);
	if(mysqli_num_rows($rsltrqstVR)){
		$rqstVRCount = mysqli_num_rows($rsltrqstVR);
		$rqstVRCount2 = mysqli_num_rows($rsltrqstVR);
	}else{
		$rqstVRCount = '';
		$rqstVRCount2 = '0';
	}
	$rqstVRCount_sum +=$rqstVRCount2;
	
	$msg_body .= '<tr>
			<td>'.$username.'</td>
			<td>'.$registerCount.'</td>
			<td>'.$registerNotCompeleteCount.'</td>
			<td>'.$APSTCount.'</td>
			<td>'.$COLCount.'</td>
			<td>'.$rqstLOACount.'</td>
			<td>'.$LOACount.'</td>
			<td>'.$rqstVGCount.'</td>
			<td>'.$rqstVRCount.'</td>
		</tr>';
}

	$msg_body .= '<tr>
			<td>Total</td>
			<td>'.$registerCount_sum.'</td>
			<td>'.$registerNotCompeleteCount_sum.'</td>
			<td>'.$APSTCount_sum.'</td>
			<td>'.$COLCount_sum.'</td>
			<td>'.$rqstLOACount_sum.'</td>
			<td>'.$LOACount_sum.'</td>
			<td>'.$rqstVGCount_sum.'</td>
			<td>'.$rqstVRCount_sum.'</td>
		</tr>';

$msg_body .= '</table>';
// print_r($msg_body);
// die;

$qry_userlist = "select * from report_sent where status3='1'";
$rslt_userlist = mysqli_query($con, $qry_userlist);
while($row_userlist = mysqli_fetch_array($rslt_userlist)){
    $email_send[] = mysqli_real_escape_string($con, $row_userlist['email_address']);
}

$subject = 'AOL College Full Report';
foreach($email_send as $email_address){
    $to = $email_address;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: AOL College Full Report<no-reply@aoltorontoagents.ca>' . "\r\n";
    mail ($to,$subject,$msg_body,$headers);
}
?>