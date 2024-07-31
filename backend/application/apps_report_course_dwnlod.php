<?php
ob_start();
session_start();
include("../../db.php");
header("Content-Type: application/vnd.ms-excel");

if(isset($_GET['getcondion_'])){
	$queryCondition = base64_decode($_GET['getcondion_']);
} else {
	$queryCondition = '';
}

$loggedid = $_SESSION['sno'];
$rsltLogged = mysqli_query($con,"SELECT email, contact_person FROM allusers WHERE sno = '$loggedid'");
$rowLogged = mysqli_fetch_assoc($rsltLogged);
$email = mysqli_real_escape_string($con, $rowLogged['email']);
$contact_person = mysqli_real_escape_string($con, $rowLogged['contact_person']);

$viewAdminAccess = "SELECT * FROM `admin_access` where admin_id='$loggedid'";
$resultViewAdminAccess = mysqli_query($con, $viewAdminAccess);
if(mysqli_num_rows($resultViewAdminAccess)){
	$rowsViewAdminAccess = mysqli_fetch_assoc($resultViewAdminAccess);
	$viewName = $rowsViewAdminAccess['name'];
	$viewEmailId = $rowsViewAdminAccess['email_id'];
	$viewAdminId = $rowsViewAdminAccess['admin_id'];
}else{ 
	$viewName = '';
	$viewEmailId = '';
	$viewAdminId = '';
}

if(mysqli_num_rows($resultViewAdminAccess) && ($email == $viewEmailId)){
	$getAgentsId = "SELECT sno FROM allusers where role='Agent' AND created_by_id!='' AND created_by_id = '$viewAdminId'";
	$resultAgentsId = mysqli_query($con, $getAgentsId);	
	if(mysqli_num_rows($resultAgentsId)){
		while($resultAgentsRows = mysqli_fetch_assoc($resultAgentsId)){
			$userSno[] = $resultAgentsRows['sno'];
		}
		$getAccessid = implode("','", $userSno);
		$agent_id_not_show2 = "'$getAccessid'";
		
		$agent_id_not_show = "AND (st_application.user_id IN ($agent_id_not_show2) OR (st_application.app_show='$viewName'))";	
	}else{
		$agent_id_not_show = "AND (st_application.user_id IN (NULL) OR (st_application.app_show='$viewName'))";
	}
}else{
	$agent_id_not_show = '';
}

							
	 echo 'Campus' .  "\t" . 'Agent Name' .  "\t" . 'DOB'. "\t" .'client Name' . "\t" .'Mobile' .  "\t" .'Email Address' . "\t" .'Student ID' . "\t" .'Refrence Id' . "\t" .'Passport Number' . "\t" .'date time' . "\t" . 'Course' . "\t" . 'Aps Status' . "\t". 'Conditional Status' . "\t" . 'LOA Status' . "\t" . 'Contract' . "\t" . 'Upload LOA' . "\t" . 'Test Details' . "\t" . 'Overall Band' . "\t" . 'Band not Less than' . "\t" . 'Listening' . "\t" . 'Reading' . "\t" . 'Writing' . "\t" . 'Speaking' . "\t" . 'Date' . "\t" . 'Duolingo Score'."\n";
	
	 $result2 = mysqli_query($con,"SELECT * FROM st_application INNER JOIN allusers on st_application.user_id=allusers.sno ".$queryCondition." $agent_id_not_show");
	 while ($row = mysqli_fetch_assoc($result2)) {
				 
		 $snoall = mysqli_real_escape_string($con, $row['sno']);
		 $app_by = mysqli_real_escape_string($con, $row['app_by']);
		 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
		 $user_id = mysqli_real_escape_string($con, $row['user_id']);
		 $refid = mysqli_real_escape_string($con, $row['refid']);
		 $mobile = mysqli_real_escape_string($con, $row['mobile']);
		 $student_id = mysqli_real_escape_string($con, $row['student_id']);
		 $fname = mysqli_real_escape_string($con, $row['fname']);			
		 $lname = mysqli_real_escape_string($con, $row['lname']);			
		 $email_address = mysqli_real_escape_string($con, $row['email_address']);			
		 $passport_no = mysqli_real_escape_string($con, $row['passport_no']);			
		 $datetime = mysqli_real_escape_string($con, $row['datetime']);
		 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
		 $prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);
		 $admin_status_crs = mysqli_real_escape_string($con, $row['admin_status_crs']);
		 $admin_remark_crs = mysqli_real_escape_string($con, $row['admin_remark_crs']);
		 $ol_confirm = mysqli_real_escape_string($con, $row['ol_confirm']);
		 $signed_ol_confirm = mysqli_real_escape_string($con, $row['signed_ol_confirm']);
		 $offer_letter = mysqli_real_escape_string($con, $row['offer_letter']);
		 $file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);
		 $loa_confirm = mysqli_real_escape_string($con, $row['loa_confirm']);
		 $loa_confirm_remarks = mysqli_real_escape_string($con, $row['loa_confirm_remarks']);
		 $agreement = mysqli_real_escape_string($con, $row['agreement']);
		 $agreement_loa = mysqli_real_escape_string($con, $row['agreement_loa']);
		 $signed_al_status = mysqli_real_escape_string($con, $row['signed_al_status']);
		 $contract_letter = mysqli_real_escape_string($con, $row['contract_letter']);
		 $signed_agreement_letter = mysqli_real_escape_string($con, $row['signed_agreement_letter']);
		 $loa_file = mysqli_real_escape_string($con, $row['loa_file']);
		 $loa_file_status = mysqli_real_escape_string($con, $row['loa_file_status']); 
		 $dob = mysqli_real_escape_string($con, $row['dob']); 
		 $campus = mysqli_real_escape_string($con, $row['campus']); 
		 
		 $agntname = mysqli_real_escape_string($con, $row['username']);
		 $englishpro = mysqli_real_escape_string($con, $row['englishpro']);
		 
		if($englishpro == 'ielts' || $englishpro == 'Toefl'){
			$over = mysqli_real_escape_string($con, $row['ieltsover']);
			$not = mysqli_real_escape_string($con, $row['ieltsnot']);
			$listening = mysqli_real_escape_string($con, $row['ielts_listening']);
			$reading = mysqli_real_escape_string($con, $row['ielts_reading']);
			$writing = mysqli_real_escape_string($con, $row['ielts_writing']);
			$speaking = mysqli_real_escape_string($con, $row['ielts_speaking']);
			$date = mysqli_real_escape_string($con, $row['ielts_date']);
			$duolingo_score = '';					
		}
		if($englishpro == 'pte'){
			$over = mysqli_real_escape_string($con, $row['pteover']);
			$not = mysqli_real_escape_string($con, $row['ptenot']);
			$listening = mysqli_real_escape_string($con, $row['pte_listening']);
			$reading = mysqli_real_escape_string($con, $row['pte_reading']);
			$writing = mysqli_real_escape_string($con, $row['pte_writing']);
			$speaking = mysqli_real_escape_string($con, $row['pte_speaking']);
			$date = mysqli_real_escape_string($con, $row['pte_date']);
			$duolingo_score = '';
		}
		if($englishpro == 'duolingo'){
			$over = '';
			$not = '';
			$listening = '';
			$reading = '';
			$writing = '';
			$speaking = '';
			
			$duolingo_score = mysqli_real_escape_string($con, $row['duolingo_score']);
			$date = mysqli_real_escape_string($con, $row['duolingo_date']);
		}
		 
		 //Application  status
		 $apps_status = '';
		 if($admin_status_crs=='Yes'){
			 $apps_status = 'Approved';
		 }
		 if($admin_status_crs=='No'){
			 $apps_status = 'Not Approved'; 
		 }  
		 if($admin_status_crs==''){
			 $apps_status = 'Pending'; 
		 }
		 
		 //conditional offer latter status
		  $col_status = '';
		 if(($admin_status_crs == 'No') || ($admin_status_crs == '')){
			 $col_status = 'Pending';
			 
		 }
		 if(($admin_status_crs == 'Yes') && ($offer_letter == '') && ($ol_confirm == '')){
			  $col_status = 'Generate Offer Letter';
		 }
		 if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '')){
			  $col_status = 'Offer Letter Generated ';
			 
		 }
		 if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){
			  $col_status = 'Offer Letter Sent ';
			 
		 } 
		 if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){
			 $col_status = 'Signed Offer Letter Sent ';
			 
		 }
		 if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No') ){
			  $col_status = 'Signed Offer Letter Not Approved';
			 
		 }
		 if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes') ){
			  $col_status = 'Signed Offer Letter Approved ';
			 
		 }
		 
		 // LOA request status
		 $loar_status = '';
		 if(($signed_ol_confirm !== 'Yes') && ($file_receipt == '')){
			 $loar_status = 'Pending';
		 }
		 if(($signed_ol_confirm == 'Yes') && ($file_receipt == '')){
			  $loar_status = 'LOA Not Requested';
			 
		 }
		 if(($file_receipt !== '')){
			  $loar_status = 'LOA Request Sent';
			 
		 }
		 //AOL Contract	status
		 $aolc_status ='';
		 if($file_receipt !== '1'){
			 $aolc_status ='Pending';
			 
		 }
		 if(($file_receipt == '1') && ($contract_letter =='')){
			 $aolc_status ='Generate Contract';
			 
		 }
		 if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='')){
			 $aolc_status ='Contract Generated ';
			 
		 }
		 if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='1') && ($signed_agreement_letter=='') ){
			  $aolc_status ='Generated Contract Sent';
			 
		 }
		 if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='')){
			   $aolc_status ='Signed Contract Sent ';
			 
		 }
		 if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='No')){
			 $aolc_status ='Signed Contract Not Approved';
			 
		 }
		 if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='Yes')){
			 $aolc_status ='Signed Contract Approved';
			 
		 }
		 
		 // Upload LOA	status
		 $uloa_status ='';
		 if(($signed_al_status == '' || $signed_al_status == 'No') && ($loa_file == '')){
			  $uloa_status ='';
			 
		 }
		 if(($signed_al_status == 'Yes') && ($loa_file == '' || $loa_file_status == '')){
			  $uloa_status ='Generate LOA';
			 
		 }
		
		 if(($loa_file !== '') && ($loa_file_status == '')){
			 $uloa_status ='LOA Generated';
			 
		 }
		 
		 if(($loa_file !== '') && ($loa_file_status !== '')){
			 $uloa_status ='LOA Sent';
			 
		 }
					 
	echo $campus .  "\t" . $agntname .  "\t" . $dob.  "\t" . $fname.' '.$lname . "\t" . $mobile . "\t" . $email_address  . "\t" . $student_id . "\t" . $refid . "\t" . $passport_no . "\t" . $datetime . "\t" . $prg_name1 . "\t" . $apps_status. "\t" . $col_status."\t".$loar_status. "\t".$aolc_status . "\t" . $uloa_status. "\t" . $englishpro. "\t" . $over. "\t" . $not. "\t" . $listening. "\t" . $reading. "\t" . $writing. "\t" . $speaking. "\t" . $date. "\t" . $duolingo_score. "\n";

}
header("Content-disposition: attachment; filename=application_report.xls");
?>