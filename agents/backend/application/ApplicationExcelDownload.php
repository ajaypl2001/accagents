<?php
ob_start();
session_start();
include("../../db.php");
//header("Content-Type: application/vnd.ms-excel");

$sessionid1 = $_SESSION['sno'];
if(!empty($_POST['pal_status']) && $_POST['pal_status'] == 'PALDiv'){
	$getPAL = "";
	$result4 = "SELECT * FROM st_application where user_id!='' and pal_status='1' ORDER BY sno DESC";
}else{
	$getPAL = '';
	$result4 = "SELECT * FROM st_application where user_id!=''  ORDER BY sno DESC";
}

$result5 = mysqli_query($con, $result4);
	
echo 'Agent Name'.  "\t" . 'Agent Sales Manager'.  "\t" . 'Agent Country'. "\t" .'Sub-Agent Name'. "\t" .'Firstname'. "\t" .'Lastname'. "\t" .'Reference Id' . "\t" .'Student Id'. "\t" .'Passport No'. "\t" .'Intake' . "\t" .'Program' . "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'."\t". 'Created On'."\t". 'Application Completed'."\t". 'Application Status'."\t". 'Application Remarks'."\t". 'Application Status Datetime'."\t". 'OL New21/22'."\t". 'OL Genreated'."\t". 'OL Issue'."\t". 'OL Type'."\t". 'OL Remarks'."\t". 'OL Revised'."\t". 'OL Defer'."\t". 'OL Send'."\t". 'OL Status'."\t". 'OL Remarks'."\t". 'Request LOA'."\t". 'Request LOA Datetime'."\t". 'Prepaid Fee Status'."\t". 'Prepaid Fee Amount'."\t". 'LOA Type'."\t". 'LOA Datetime'."\t". 'LOA Revised Datetime'."\t". 'LOA Defer Datetime' ."\t". 'Receipt Amount 1st' ."\t". 'Receipt Amount 2nd' . "\t". 'F@H' ."\t". 'F@H Datetime'."\t". 'Main Status'."\t". 'Main Status Datetime'. "\t" .'FollowUp/Drop'. "\t" .'Country Birth'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1'  . "\t" .'PAL No.' . "\t" .'PAL Issue Date' . "\t" .'PAL Expiry Date' . "\t" .'PAL Updated On' ."\n";
	
while ($row = mysqli_fetch_assoc($result5)) {
		$snoall = mysqli_real_escape_string($con, $row['sno']);
		$user_id = preg_replace('/\s+/', ' ', $row['user_id']);
		
		$getquery22 = "SELECT username, created_by_id FROM `allusers` WHERE sno='$user_id' and role='Agent'";		
		$RefundsWeeklyRslt22 = mysqli_query($con, $getquery22);
		if(mysqli_num_rows($RefundsWeeklyRslt22)){
			$row_nm22 = mysqli_fetch_assoc($RefundsWeeklyRslt22);
			$agntname = preg_replace('/\s+/', ' ', $row_nm22['username']);
			$countryAgent = ''; //preg_replace('/\s+/', ' ', $row_nm22['country']);
			$created_by_id = preg_replace('/\s+/', ' ', $row_nm22['created_by_id']);
			
			$getquery23 = "SELECT sno, name FROM `admin_access` where admin_id='$created_by_id'";
			$RefundsWeeklyRslt23 = mysqli_query($con, $getquery23);
			if(mysqli_num_rows($RefundsWeeklyRslt23)){
				$row_nm23 = mysqli_fetch_assoc($RefundsWeeklyRslt23);
				$sales_manager = preg_replace('/\s+/', ' ', $row_nm23['name']);
			}else{
				$sales_manager = 'Sahil & Vinod';
			}
		}else{
			$agntname = '';
			$countryAgent = '';
			$sales_manager = '';
		}
		
		$refid = preg_replace('/\s+/', ' ', $row['refid']);
		$student_id = preg_replace('/\s+/', ' ', $row['student_id']);
		$fname = preg_replace('/\s+/', ' ', $row['fname']);			
		$lname = preg_replace('/\s+/', ' ', $row['lname']);
		$fullname = $fname.' '.$lname;
		$sub_agent_name ='';
		$passport_no = preg_replace('/\s+/', ' ', $row['passport_no']);
		$prg_intake = preg_replace('/\s+/', ' ', $row['prg_intake']);
		$prg_name1 = preg_replace('/\s+/', ' ', $row['prg_name1']);
		$datetime = preg_replace('/\s+/', ' ', $row['datetime']);
		
		$personal_status = $row['personal_status'];
		$academic_status = $row['academic_status'];
		$course_status = $row['course_status'];
		$application_form = $row['application_form'];
		if(!empty($personal_status) && !empty($academic_status) && !empty($course_status) && !empty($application_form)){
			$appCmplt = 'All Tab Completed';
		}else{
			$appCmplt = 'Not-Completed';
		}
		
		$englishpro = preg_replace('/\s+/', ' ',$row['englishpro']);	
		$ieltsover = preg_replace('/\s+/', ' ',$row['ieltsover']);	
		$ieltsnot = preg_replace('/\s+/', ' ',$row['ieltsnot']);	
		$pteover = preg_replace('/\s+/', ' ',$row['pteover']);	
		$ptenot = preg_replace('/\s+/', ' ',$row['ptenot']);
		$admin_status_crs = preg_replace('/\s+/', ' ',$row['admin_status_crs']);
		$admin_remark_crs = preg_replace('/\s+/', ' ',$row['admin_remark_crs']);
		$application_status_datetime = preg_replace('/\s+/', ' ',$row['application_status_datetime']);
		$ol_processing = preg_replace('/\s+/', ' ',$row['ol_processing']);
		if(!empty($ol_processing)){
			if(!empty($row['ol_type'])){
				$ol_type = preg_replace('/\s+/', ' ',$row['ol_type']);
			}else{
				$ol_type = 'First-Time';
			}
		}else{
			$ol_type = '';
		}
		$ol_type_remarks = preg_replace('/\s+/', ' ',$row['ol_type_remarks']);
		$ol_revised_date = preg_replace('/\s+/', ' ',$row['ol_revised_date']);
		$ol_defer_date = preg_replace('/\s+/', ' ',$row['ol_defer_date']);
		if(!empty($row['ol_confirm'])){
			$ol_confirm = 'Send';
		}else{
			$ol_confirm = '';
		}		
		$signed_ol_confirm = preg_replace('/\s+/', ' ',$row['signed_ol_confirm']);
		$signed_ol_remarks = preg_replace('/\s+/', ' ',$row['signed_ol_remarks']);
		$offer_letter2 = preg_replace('/\s+/', ' ',$row['offer_letter']);		
		if(!empty($offer_letter2)){
			$offer_letter = 'Genreated';
		}else{
			$offer_letter = 'Pending';
		}
		
		
		$file_receipt = preg_replace('/\s+/', ' ',$row['file_receipt']);
		$loa_tt = preg_replace('/\s+/', ' ',$row['loa_tt']);
		if(empty($file_receipt) && empty($loa_tt)){
			$rqstTT = '';
		}
		
		if(!empty($file_receipt) && empty($loa_tt)){
			$rqstTT = 'Request LOA Without TT';
		}
		
		if(!empty($file_receipt) && !empty($loa_tt)){
			$rqstTT = 'Request LOA With TT';
		}
		$agent_request_loa_datetime = preg_replace('/\s+/', ' ',$row['agent_request_loa_datetime']);
		$prepaid_fee = preg_replace('/\s+/', ' ',$row['prepaid_fee']);
		$prepaid_remarks = preg_replace('/\s+/', ' ',$row['prepaid_remarks']);
		$loa_file = preg_replace('/\s+/', ' ',$row['loa_file']);
		$loa_type = preg_replace('/\s+/', ' ',$row['loa_type']);
		if(!empty($loa_file) && empty($loa_type)){
			$loa_type2 = 'First-Time';
		}else{
			$loa_type2 = $loa_type;
		}
		$loa_file_date_updated_by = preg_replace('/\s+/', ' ',$row['loa_file_date_updated_by']);
		$loa_revised_date = preg_replace('/\s+/', ' ',$row['loa_revised_date']);
		$loa_defer_date = preg_replace('/\s+/', ' ',$row['loa_defer_date']);
		
		$fh_status = preg_replace('/\s+/', ' ', $row['fh_status']);
		$fh_re_lodgement2 = preg_replace('/\s+/', ' ', $row['fh_re_lodgement']);
		if(!empty($fh_re_lodgement2)){
			$fh_re_lodgement = '-'.$fh_re_lodgement2;
		}else{
			$fh_re_lodgement = '';
		}
			
		$fh_status_updated_by = preg_replace('/\s+/', ' ', $row['fh_status_updated_by']);
		
		if($fh_status == '1'){
			$FH2 = 'F@H'.''.$fh_re_lodgement;
		}else{
			$FH2 = '.';
		}
		
		$v_g_r_status = preg_replace('/\s+/', ' ', $row['v_g_r_status']);
		$v_g_r_status_datetime = preg_replace('/\s+/', ' ', $row['v_g_r_status_datetime']);
		
		$country = preg_replace('/\s+/', ' ',$row['country']);
		$cntry_brth = preg_replace('/\s+/', ' ',$row['cntry_brth']);
	$state = preg_replace('/\s+/', ' ',$row['state']);
	$city = preg_replace('/\s+/', ' ',$row['city']);
	$address1 = preg_replace('/\s+/', ' ',$row['address1']);
	$flowdrp = preg_replace('/\s+/', ' ',$row['flowdrp']);

	$receipt_amount_loa2 = preg_replace('/\s+/', ' ',$row['genrate_amount_loa']);
	$genrate_amount_loa_admin2 = preg_replace('/\s+/', ' ',$row['genrate_amount_loa_admin']);
	if(!empty($receipt_amount_loa2)){
		$receipt_amount_loa = '$'.$receipt_amount_loa2;
	}else{
		$receipt_amount_loa = '';
	}
	if(!empty($genrate_amount_loa_admin2)){
		$genrate_amount_loa_admin = '$'.$genrate_amount_loa_admin2;
	}else{
		$genrate_amount_loa_admin = '';
	}

	$ol_new_old = '';

	$qry2 = mysqli_query($con, "SELECT * FROM `pal_apply` where `app_id`='$snoall'");
	if(mysqli_num_rows($qry2)){
		$uid2 = mysqli_fetch_assoc($qry2);
		$pal_no = $uid2['pal_no'];
		$issue_date = $uid2['issue_date'];
		$expiry_date = $uid2['expiry_date'];
		$updated_name2 = $uid2['updated_name'];
		if(!empty($updated_name2)){
			$updated_datetime = $uid2['updated_datetime'];
		}else{	
			$updated_datetime = $uid2['second_datetime'];
		}
	}else{
		$pal_no = 'N/F';
		$issue_date = '';
		$expiry_date = '';
		$updated_datetime = '';
	}
	 
echo $agntname . "\t" . $sales_manager. "\t" . $countryAgent. "\t" . $sub_agent_name . "\t" . $fname . "\t" . $lname . "\t" . $refid . "\t" . $student_id. "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover ."\t". $ptenot."\t". $datetime."\t". $appCmplt ."\t". $admin_status_crs ."\t". $admin_remark_crs ."\t". $application_status_datetime ."\t". $ol_new_old ."\t". $offer_letter ."\t". $ol_processing."\t". $ol_type ."\t". $ol_type_remarks ."\t". $ol_revised_date ."\t". $ol_defer_date ."\t". $ol_confirm ."\t". $signed_ol_confirm ."\t". $signed_ol_remarks ."\t". $rqstTT ."\t". $agent_request_loa_datetime ."\t". $prepaid_fee ."\t". $prepaid_remarks ."\t". $loa_type2 ."\t". $loa_file_date_updated_by ."\t". $loa_revised_date ."\t". $loa_defer_date ."\t". $receipt_amount_loa ."\t". $genrate_amount_loa_admin ."\t". $FH2 ."\t". $fh_status_updated_by."\t". $v_g_r_status."\t". $v_g_r_status_datetime. "\t" . $flowdrp. "\t" . $cntry_brth. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\t" . $pal_no. "\t" . $issue_date. "\t" . $expiry_date. "\t" . $updated_datetime. "\n";
}

header("Content-disposition: attachment; filename=Application_Download.xls");
?>