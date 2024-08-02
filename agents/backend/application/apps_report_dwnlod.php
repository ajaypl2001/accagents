<?php
		ob_start();
        session_start();
		include("../../db.php");
		//header("Content-Type: application/vnd.ms-excel");
		if(isset($_GET['getcondion_'])){
			$queryCondition = base64_decode($_GET['getcondion_']);
			
		} else {
			$queryCondition = '';
		}
							
			 echo 'Agent Name' . "\t" .'client Name' . "\t" .'Refrence Id' . "\t" .'date time' . "\t" . 'Aps Status' . "\t" . 'Conditional Status' . "\t" . 'LOA Status' . "\t" . 'AOL COntract' . "\t" . 'Upload LOA'. "\n";
			
			 $result2 = mysqli_query($con,"SELECT * FROM st_application INNER JOIN allusers on st_application.user_id = allusers.sno  " . $queryCondition . " ");
			 while ($row = mysqli_fetch_assoc($result2)) {
						 
				 $snoall = mysqli_real_escape_string($con, $row['sno']);
				 $app_by = mysqli_real_escape_string($con, $row['app_by']);
				 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
				 $user_id = mysqli_real_escape_string($con, $row['user_id']);
				 $refid = mysqli_real_escape_string($con, $row['refid']);
				 $fname = mysqli_real_escape_string($con, $row['fname']);			
				 $lname = mysqli_real_escape_string($con, $row['lname']);			
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
				 
				 $agntname = mysqli_real_escape_string($con, $row['username']);
				 
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
				 if(($signed_al_status == '') || ($signed_al_status == 'No')){
					  $uloa_status ='Pending';
					 
				 }
				 if(($signed_al_status == 'Yes') && ($loa_file == '')){
					  $uloa_status ='Generate LOA';
					 
				 }
				 if(($loa_file !== '') && ($loa_file_status == '')){
					 $uloa_status ='LOA Generated';
					 
				 }
							 
			echo $agntname . "\t" . $fname.' '.$lname . "\t" . $refid . "\t" . $datetime . "\t" . $apps_status . "\t" . $col_status."\t".$loar_status. "\t".$aolc_status . "\t" . $uloa_status.  "\n";



		}

header("Content-disposition: attachment; filename=application_report.xls"); ?>