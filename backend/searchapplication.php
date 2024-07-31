<?php
ob_start();
session_start();
include("../db.php");

if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$loggedid = $_SESSION['sno'];
$rsltLogged = mysqli_query($con,"SELECT email, contact_person, report_allow FROM allusers WHERE sno = '$loggedid'");
$rowLogged = mysqli_fetch_assoc($rsltLogged);
	$email = mysqli_real_escape_string($con, $rowLogged['email']);
	$report_allow1 = mysqli_real_escape_string($con, $rowLogged['report_allow']);
	$contact_person = mysqli_real_escape_string($con, $rowLogged['contact_person']);
}else{
	$email = '';
	$report_allow1 = '';
	$contact_person = '';
}

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
		
		$agent_id_not_show = "AND (user_id IN ($agent_id_not_show2) OR (app_show='$viewName'))";
		$agent_user_table = "AND sno IN ($agent_id_not_show2)";		
	}else{
		$agent_id_not_show = "AND (user_id IN (NULL) OR (app_show='$viewName'))";
		$agent_user_table = "AND sno IN (NULL)";
	}
}else{
	$agent_id_not_show = '';
	$agent_user_table = '';
}

// if($loggedid == '300'){
	// $agent_user_table = "AND sno NOT IN ('1136')";
// }else{
	// $agent_user_table = '';
// }

if(isset($_GET['searchdata']) == "filter"){
	
	$output = '';
	$queryCondition = '';
	$queryCondition1 = '';
	
	$flag = 0;
	if(!empty($_POST['agent_wise'])){ 
			$flag = 1;    
			$agent_wise = $_POST['agent_wise'];
			if($agent_wise > 0 ){
				$agent_data = join("','",$agent_wise); 
				$queryCondition .= " allusers.sno IN ('$agent_data')";
				
			} else {
			  	$queryCondition .= "allusers.sno ='$agent_wise'";	
			}
			
		if(!empty($_POST['course_wise'])){      
			$course_wise = $_POST['course_wise'];
			if($course_wise > 0 ){
				$course_data = join("','",$course_wise); 
				if ($flag == 1){
					$queryCondition1 .= " AND st_application.prg_name1 IN ('$course_data')";
				} else {
					$queryCondition1 .= " st_application.prg_name1 IN ('$course_data')";
					 $flag = 1;
				}
			} else {
				
				if ($flag == 1){
					$queryCondition1 .= " AND st_application.prg_name1 ='$course_wise'";
				} else {
					$queryCondition1 .= " st_application.prg_name1 ='$course_wise'";
					 $flag = 1;
				}
			}
			
			
				
			
		}
		
		if(!empty($_POST['intake_wise'])){      
			$intake_wise = $_POST['intake_wise'];
			if($intake_wise > 0 ){
				
				$intake_data = join("','",$intake_wise); 
				if ($flag == 1){
					$queryCondition1 .= " AND st_application.prg_intake IN ('$intake_data')";
				} else {
					$queryCondition1 .= " st_application.prg_intake IN ('$intake_data')";
					 $flag = 1;
				}
				
			} else { 
				   if ($flag == 1){
					 $queryCondition1 .= " AND st_application.prg_intake ='$intake_wise'";
				   }
				   else {
					$queryCondition1 .= " st_application.prg_intake ='$intake_wise'";
					 $flag = 1;
				   }
			}
		}
		
		if(!empty($_POST['status_wise'])){      
			$status_wise = $_POST['status_wise'];
			if($status_wise=='blank_as'){
				$status_datas = '';
				$status_data = 'Pending';
				$status_head = 'Application Status';
			} if($status_wise=='Yes_as'){
			  $status_datas = 'Yes';
			  $status_data = 'Approved';			  
			  $status_head = 'Application Status';
			}
			 if($status_wise=='No_as'){
			  $status_datas = 'No';	
			   $status_data = 'NOt Approved';
			  $status_head = 'Application Status';
			}
			
			if($status_wise=='Pending_cos'){
				$status_data = 'Pending';
				$status_head = 'Conditional Offer Letter';
			}
			if($status_wise=='Generated_cos'){
				$status_data = 'Generated';
				$status_head = 'Conditional Offer Letter';
			} if($status_wise=='Sent_cos'){
			  $status_data = 'Sent';
			  $status_head = 'Conditional Offer Letter';			  
			}
			if($status_wise=='Recieved_cos'){
			  $status_data = 'Recieved';	
			}
			if($status_wise=='Confirmed_cos'){
			  $status_data = 'Confirmed';
			  $status_head = 'Conditional Offer Letter';			  
			}
			
			if($status_wise=='Pending_lrs'){
			  $status_data = 'Pending';	
			  $status_head = 'LOA Request Status';
			}
			if($status_wise=='Sent_lrs'){
			  $status_data = 'Sent';
			  $status_head = 'LOA Request Status';
			}
			
			if($status_wise=='Pending_aolc'){
			  $status_data = 'Pending';	
			  $status_head = 'AOL Contract';
			}
			if($status_wise=='Generated_aolc'){
			  $status_data = 'Generated';
			  $status_head = 'AOL Contract';			  
			}
			if($status_wise=='Sent_aolc'){
			  $status_data = 'Sent';
			  $status_head = 'AOL Contract';
			}
			if($status_wise=='Recieved_aolc'){
			  $status_data = 'Recieved';	
			  $status_head = 'AOL Contract';
			}
			if($status_wise=='Confirmed_aolc'){
			  $status_data = 'Confirmed';	
			  $status_head = 'AOL Contract';
			}
			
			if($status_wise=='Pending_uloas'){
			  $status_data = 'Pending';	
			  $status_head = 'Upload LOA';
			}
			if($status_wise=='Generated_uloas'){
			  $status_data = 'Generated';	
			  $status_head = 'Upload LOA';
			}
			if($status_wise=='Sent_uloas'){
			  $status_data = 'Sent';	
			  $status_head = 'Upload LOA';
			}
			
			
			
			
			
			
			
			if($status_wise=='blank_as' || $status_wise=='Yes_as' || $status_wise=='No_as') {
			
				if($flag == 1){
				$queryCondition1 .= " AND st_application.admin_status_crs ='$status_datas'";
				}
				else {
				$queryCondition1 .= " st_application.admin_status_crs ='$status_datas'";
				 $flag = 1;
				}
			}
			
			if($status_wise=='Generated_cos') {
				if($flag == 1){
				$queryCondition1 .= "AND st_application.ol_confirm !='1' AND st_application.offer_letter !=''";
				}
				else {
				$queryCondition1 .= "st_application.ol_confirm !='1' AND st_application.offer_letter !=''";
				 $flag = 1;
				}
				
			}
			if($status_wise=='Pending_cos') {
				if($flag == 1){
				$queryCondition1 .= "AND st_application.ol_confirm ='' AND st_application.offer_letter =''";
				
				}
				else {
				$queryCondition1 .= "st_application.ol_confirm ='' AND st_application.offer_letter =''";
				 $flag = 1;
				}
				
			}
			if($status_wise=='Sent_cos') {
				if($flag == 1){
				$queryCondition1 .= "AND st_application.ol_confirm ='1'";
				
				}
				else {
				$queryCondition1 .= "st_application.ol_confirm ='1'";
				 $flag = 1;
				}
				
			}
			if($status_wise=='Recieved_cos') {
				if($flag == 1){
				$queryCondition1 .= "AND st_application.agreement !=''";
				
				}
				else {
				$queryCondition1 .= "st_application.agreement !=''";
				 $flag = 1;
				}
				
			}
			if($status_wise=='Confirmed_cos') {
				if($flag == 1){
				$queryCondition1 .= "AND st_application.signed_ol_confirm ='Yes'";
				
				}
				else {
				$queryCondition1 .= "st_application.signed_ol_confirm ='Yes'";
				 $flag = 1;
				}
				
			}
			
			
			if($status_wise=='Pending_lrs') {
				if($flag == 1){
				$queryCondition1 .= "AND st_application.file_receipt =''";
				
				}
				else {
				$queryCondition1 .= "st_application.file_receipt =''";
				 $flag = 1;
				}
			} 
			if($status_wise=='Sent_lrs') {
				if($flag == 1){
				$queryCondition1 .= "AND st_application.file_receipt !=''";
				
				}
				else {
				$queryCondition1 .= "st_application.file_receipt !=''";
				 $flag = 1;
				}
			}
			
			if($status_wise=='Pending_aolc' || $status_wise=='Generated_aolc' || $status_wise=='Sent_aolc' || $status_wise=='Recieved_aolc' || $status_wise=='Confirmed_aolc') {
				
				if($status_wise=='Pending_aolc') {
					if($flag == 1){
					$queryCondition1 .= "AND st_application.contract_letter =''";
					
					}
					else {
					$queryCondition1 .= "st_application.contract_letter =''";
					 $flag = 1;
					}
				}
				if($status_wise=='Generated_aolc') {
					if($flag == 1){
					$queryCondition1 .= "AND st_application.contract_letter !=''";
					
					}
					else {
					$queryCondition1 .= "st_application.contract_letter !=''";
					 $flag = 1;
					}
				}
				if($status_wise=='Sent_aolc') {
					if($flag == 1){
					$queryCondition1 .= "AND st_application.agreement_loa ='1'";
					
					}
					else {
					$queryCondition1 .= "st_application.agreement_loa ='1'";
					 $flag = 1;
					}
				}
				if($status_wise=='Recieved_aolc') {
					if($flag == 1){
					$queryCondition1 .= "AND st_application.signed_agreement_letter !=''";
					
					}
					else {
					$queryCondition1 .= "st_application.signed_agreement_letter !=''";
					 $flag = 1;
					}
				}
				if($status_wise=='Confirmed_aolc') {
					if($flag == 1){
					$queryCondition1 .= "AND st_application.signed_al_status ='Yes'";
					
					}
					else {
					$queryCondition1 .= "st_application.signed_al_status ='Yes'";
					 $flag = 1;
					}
				}
				
			}
			
			if($status_wise=='Pending_uloas' || $status_wise=='Generated_uloas' || $status_wise=='Sent_uloas') {
				
				if($status_wise=='Pending_uloas') {
					if($flag == 1){
					$queryCondition1 .= "AND st_application.loa_file =''";
					
					}
					else {
					$queryCondition1 .= "st_application.loa_file =''";
					 $flag = 1;
					}
				}
				if($status_wise=='Generated_uloas') {
					if($flag == 1){
					$queryCondition1 .= "AND st_application.loa_file !=''";
					
					}
					else {
					$queryCondition1 .= "st_application.loa_file !=''";
					 $flag = 1;
					}
				}
				if($status_wise=='Sent_uloas') {
					if($flag == 1){
					$queryCondition1 .= "AND st_application.loa_file_status ='1'";
					
					}
					else {
					$queryCondition1 .= "st_application.loa_file_status ='1'";
					 $flag = 1;
					}
				}
				
			}
		} 
			
			
		
	}




	
		 $output .= '<br /><div class="row"><div class="col-lg-6"><h4 class="filter-title text-center">Application Report data</h4>	
							<div class="table-responsive text-center" border="1">
									<table class="table table-striped table-scroll" align="center">
								 </thead>
									<tr>
										<th>Agent </th>
										<th>Application no </th>
									</tr> 
								 </thead>';
		 
		  $agnt_qry = "SELECT username, sno FROM allusers  where " . $queryCondition . " $agent_user_table";
		  $queryasd = mysqli_query($con, $agnt_qry);
		  $application_num = mysqli_num_rows($queryasd);
		  if($application_num > 0){
			$total_application = 0;
			while($datarow = mysqli_fetch_array($queryasd)){
				$user_id=mysqli_real_escape_string($con, $datarow['sno']);
				$user_nam=mysqli_real_escape_string($con, $datarow['username']);
				$query2 = "SELECT * FROM st_application  where user_id='$user_id' ".$queryCondition1." $agent_id_not_show";
				//print_r($query2);
				$result2 = mysqli_query($con, $query2);
				$application_numss = mysqli_num_rows($result2);
				$total_application += $application_numss;
				$quer_strung_agent = "where user_id='$user_id' ".$queryCondition1."";
				$output .= '  
					<tr>  
						<td>'.$user_nam.'</td>';
						if($application_numss > 0){
							$output .=  '<td><a href="../application/apps_details.php?getcondion = '.base64_encode($quer_strung_agent).'">'.$application_numss.'</a></td>';
						} else {
							$output .=  '<td>'.$application_numss.'</td>';
						}
						
					$output .= '</tr> ';  
				
			}
			 $quer_strung = "where".$queryCondition." ".$queryCondition1."";
			
			
			$output .= '  
					<tr>  
						<td>Total</td>';
						if($total_application > 0) {
							$output .= '<td><a href="../application/apps_details.php?getcondion = '.base64_encode($quer_strung).'">'.$total_application.'</a></td>';
						} else {
							$output .= '<td>'.$total_application.'</td>';
						}
					$output .= '</tr> ';  
		
	} else {
			$output .= '<td colspan="2">No Result Found</td>';
	}
	
		$output .= '</table></div></div>'; 
		
		/* here is start filter information */
		 $output .= '<div class="col-lg-6"><h4 class="filter-title text-center">Filter data With</h4>	
				<div class="table-responsive text-center" border="1">
						<table class="table table-striped" align="center">
					 </thead>
						<tr>
							<th> Status </th>							
							<th> Course </th>
							<th> Intake </th>
						</tr> 
					 </thead>';
								 
								 $output .= '  
					<tr>'; 
						 if(!empty($status_data) && $status_head!=''){
							$output .= '<td>'.$status_head.'<sup>('.$status_data.')</sup></td>';
						 } else {
							$output .= '<td></td>'; 
						 }
						
						$output .= '<td class="p-0">
						<table class="table mb-0 table-scroll">';
						if(!empty($course_wise)){
							foreach($course_wise as $cousrse_filter){
								$output .='<tr><td>'.$cousrse_filter.'</td></tr>';	
							}
						} else { 
						//	$output .='<tr><td></td></tr>';
						}
						 $output .= '</table></td>
						
						<td class="p-0">
						<table class="table mb-0 table-scrol">';
						if(!empty($intake_wise)){
							foreach($intake_wise as $intake_filter){
								$output .='<tr><td>'.$intake_filter.'</td></tr>';
							}
						} else {
						//$output .='<tr><td></td></tr>';	
						}
						$output .= '</table></td>';
						
						
					$output .= '</tr> ';
								 
		$output .= '</table></div></div></div>'; 						 
		echo $output;
		die();

}

/* start for course data using agent filter */

if(isset($_GET['coursedata']) == "coursefilter"){
	$queryCondition1 = '';
	$flag = 0;
	if(!empty($_POST['intake_wise'])){      
		$intake_wise = $_POST['intake_wise'];
		if($intake_wise > 0 ){				
			$intake_data = join("','",$intake_wise); 
			$intake_datass = join(", ",$intake_wise); 
			$queryCondition1 .= " AND st_application.prg_intake IN ('$intake_data')";	
			
		} else {				  
			$queryCondition1 .= " AND st_application.prg_intake ='$intake_wise'";
		}
	}
	
	if(!empty($_POST['status_wise'])){      
			$status_wise = $_POST['status_wise'];
			if($status_wise=='blank_as'){
				$status_datas = '';
				$status_data = 'Pending';
				$status_head = 'Application Status';
			} if($status_wise=='Yes_as'){
			  $status_datas = 'Yes';
			  $status_data = 'Approved';			  
			  $status_head = 'Application Status';
			}
			 if($status_wise=='No_as'){
			  $status_datas = 'No';	
			   $status_data = 'NOt Approved';
			  $status_head = 'Application Status';
			}
			
			if($status_wise=='Pending_cos'){
				$status_data = 'Pending';
				$status_head = 'Conditional Offer Letter';
			}
			if($status_wise=='Generated_cos'){
				$status_data = 'Generated';
				$status_head = 'Conditional Offer Letter';
			} if($status_wise=='Sent_cos'){
			  $status_data = 'Sent';
			  $status_head = 'Conditional Offer Letter';			  
			}
			if($status_wise=='Recieved_cos'){
			  $status_data = 'Recieved';	
			}
			if($status_wise=='Confirmed_cos'){
			  $status_data = 'Confirmed';
			  $status_head = 'Conditional Offer Letter';			  
			}
			
			if($status_wise=='Pending_lrs'){
			  $status_data = 'Pending';	
			  $status_head = 'LOA Request Status';
			}
			if($status_wise=='Sent_lrs'){
			  $status_data = 'Sent';
			  $status_head = 'LOA Request Status';
			}
			
			if($status_wise=='Pending_aolc'){
			  $status_data = 'Pending';	
			  $status_head = 'AOL Contract';
			}
			if($status_wise=='Generated_aolc'){
			  $status_data = 'Generated';
			  $status_head = 'AOL Contract';			  
			}
			if($status_wise=='Sent_aolc'){
			  $status_data = 'Sent';
			  $status_head = 'AOL Contract';
			}
			if($status_wise=='Recieved_aolc'){
			  $status_data = 'Recieved';	
			  $status_head = 'AOL Contract';
			}
			if($status_wise=='Confirmed_aolc'){
			  $status_data = 'Confirmed';	
			  $status_head = 'AOL Contract';
			}
			
			if($status_wise=='Pending_uloas'){
			  $status_data = 'Pending';	
			  $status_head = 'Upload LOA';
			}
			if($status_wise=='Generated_uloas'){
			  $status_data = 'Generated';	
			  $status_head = 'Upload LOA';
			}
			if($status_wise=='Sent_uloas'){
			  $status_data = 'Sent';	
			  $status_head = 'Upload LOA';
			}
			if($status_wise=='File_Lodged'){
			  $status_data = 'Sent';	
			  $status_head = 'Lodged';
			}
			if($status_wise=='File_Not_Lodged'){
			  $status_data = 'Pending';	
			  $status_head = 'File Not Lodged';
			}
			if($status_wise=='File_Re_Lodged'){
			  $status_data = 'Re-Lodged';	
			  $status_head = 'File Re-Lodged';
			}
			if($status_wise=='V_G'){
			  $status_data = 'Status';	
			  $status_head = 'V-G';
			}
			if($status_wise=='V_R'){
			  $status_data = 'Status';	
			  $status_head = 'V-R';
			}
			
			
			if($status_wise=='blank_as' || $status_wise=='Yes_as' || $status_wise=='No_as') {
			
				$queryCondition1 .= " AND st_application.admin_status_crs ='$status_datas' AND st_application.flowdrp!='Drop'";
				
			}
			
			if($status_wise=='Generated_cos') {
				$queryCondition1 .= "AND st_application.ol_confirm !='1' AND st_application.offer_letter !='' AND st_application.flowdrp!='Drop'";
				
				
			}
			if($status_wise=='Pending_cos') {
				$queryCondition1 .= "AND st_application.ol_confirm ='' AND st_application.offer_letter ='' AND st_application.flowdrp!='Drop'";
				
				
				
			}
			if($status_wise=='Sent_cos') {
				$queryCondition1 .= "AND st_application.ol_confirm ='1' AND st_application.flowdrp!='Drop'";
				
				
				
			}
			if($status_wise=='Recieved_cos') {
				$queryCondition1 .= "AND st_application.agreement !='' AND st_application.flowdrp!='Drop'";
				
				
				
			}
			if($status_wise=='Confirmed_cos') {
				$queryCondition1 .= "AND st_application.signed_ol_confirm ='Yes' AND st_application.flowdrp!='Drop'";
				
				
				
			}
			
			
			if($status_wise=='Pending_lrs') {
				$queryCondition1 .= "AND st_application.file_receipt ='' AND st_application.flowdrp!='Drop'";
				
				
			} 
			if($status_wise=='Sent_lrs') {
				$queryCondition1 .= "AND st_application.file_receipt !='' AND st_application.flowdrp!='Drop'";
				
				
			}
			
			if($status_wise=='Pending_aolc' || $status_wise=='Generated_aolc' || $status_wise=='Sent_aolc' || $status_wise=='Recieved_aolc' || $status_wise=='Confirmed_aolc') {
				
				if($status_wise=='Pending_aolc') {
					$queryCondition1 .= "AND st_application.contract_letter ='' AND st_application.flowdrp!='Drop'";
					
					
				}
				if($status_wise=='Generated_aolc') {
					$queryCondition1 .= "AND st_application.contract_letter !='' AND st_application.flowdrp!='Drop'";
					
					
					
				}
				if($status_wise=='Sent_aolc') {
					$queryCondition1 .= "AND st_application.agreement_loa ='1'";
					
					
					
				}
				if($status_wise=='Recieved_aolc') {
					$queryCondition1 .= "AND st_application.signed_agreement_letter !='' AND st_application.flowdrp!='Drop'";
					
					
					
				}
				if($status_wise=='Confirmed_aolc') {
					$queryCondition1 .= "AND st_application.signed_al_status ='Yes' AND st_application.flowdrp!='Drop'";
					
					}
					
				}
				
			
			
			if($status_wise=='Pending_uloas' || $status_wise=='Generated_uloas' || $status_wise=='Sent_uloas') {
				
				if($status_wise=='Pending_uloas') {
					$queryCondition1 .= "AND st_application.loa_file ='' AND st_application.flowdrp!='Drop'";
					
					
					
				}
				if($status_wise=='Generated_uloas') {
					$queryCondition1 .= "AND st_application.loa_file !='' AND st_application.flowdrp!='Drop'";
					
					
					
				}
				if($status_wise=='Sent_uloas') {
					$queryCondition1 .= "AND st_application.loa_file_status ='1' AND st_application.flowdrp!='Drop'";
					
					
				}			
				
			}
			
			if($status_wise=='File_Lodged' || $status_wise=='File_Not_Lodged' || $status_wise=='File_Re_Lodged' || $status_wise=='V_G' || $status_wise=='V_R') {
				
				if($status_wise=='File_Lodged') {
					// $queryCondition1 .= "AND st_application.fh_status !=''";					
					$queryCondition1 .= "AND st_application.loa_file_status='1' AND st_application.flowdrp!='Drop' AND st_application.fh_status !='' AND st_application.v_g_r_status=''";					
				}
				
				if($status_wise=='File_Not_Lodged') {
					// $queryCondition1 .= "AND st_application.fh_status=''";					
					$queryCondition1 .= "AND st_application.loa_file_status='1' AND st_application.flowdrp!='Drop' AND st_application.fh_status ='' AND st_application.v_g_r_status=''";					
				}
				
				if($status_wise=='File_Re_Lodged') {
					// $queryCondition1 .= "AND st_application.fh_status=''";					
					$queryCondition1 .= "AND st_application.loa_file_status='1' AND st_application.flowdrp!='Drop' AND st_application.fh_status !='' AND st_application.fh_re_lodgement='Re_Lodged' AND st_application.v_g_r_status=''";					
				}
				
				if($status_wise=='V_G') {
					// $queryCondition1 .= "AND st_application.v_g_r_status='V-G'";					
					$queryCondition1 .= "AND st_application.v_g_r_status ='V-G' AND st_application.fh_status!=''";					
				}
				
				if($status_wise=='V_R') {
					// $queryCondition1 .= "AND st_application.v_g_r_status='V-R'";					
					$queryCondition1 .= "AND st_application.v_g_r_status ='V-R' AND st_application.fh_status!=''";					
				}
			}
	
		}
		
		if(!empty($_POST['course_wise'])){      
			$course_wise = $_POST['course_wise'];
			if($course_wise > 0 ){
				$course_data = join("','",$course_wise); 
				$course_datasa = join(", ",$course_wise); 
				if ($flag == 1){
					$queryCondition1 .= " AND st_application.prg_name1 IN ('$course_data')";
				} else {
					$queryCondition1 .= " AND st_application.prg_name1 IN ('$course_data')";
					 $flag = 1;
				}
			} else {				
				if ($flag == 1){
					$queryCondition1 .= " AND st_application.prg_name1 ='$course_wise'";
				} else {
					$queryCondition1 .= " AND st_application.prg_name1 ='$course_wise'";
					 $flag = 1;
				}
			}
			
		}
			 $output = '';
			 $output .= '<br /><div class="row"><div class="col-lg-12"><p class="filter-title text-center"> Report Summery(Status: '.@$status_head.'<sup>('.@$status_data.')</sup> Intake: '.@$intake_datass.' Courses: '.@$course_datasa.')</p>	
							<div class="table-responsive text-center" border="1">
							<table class="table table-striped table-scroll">
						 <thead>
							<tr>
								<th>Agent </th>
								<th>Total </th>
							</tr> 
						 </thead>';
						 
						
	 $agnt_qry = "SELECT username, sno FROM allusers  where role='Agent' $agent_user_table GROUP BY username";
		  $queryasd = mysqli_query($con, $agnt_qry);
		  $application_num = mysqli_num_rows($queryasd);		    
			$all_total_course = 0;
			while($datarow = mysqli_fetch_array($queryasd)){
				$user_id=mysqli_real_escape_string($con, $datarow['sno']);
				$user_nam=mysqli_real_escape_string($con, $datarow['username']);
							
				$total_course = "SELECT sno FROM st_application where user_id='$user_id' AND prg_name1 !='' ".$queryCondition1." $agent_id_not_show";
				
				$total_res = mysqli_query($con, $total_course);
				$total_caoyurse = mysqli_num_rows($total_res);
				$all_total_course += $total_caoyurse;
				$all_totle_by_agent =" where user_id='$user_id'  AND prg_name1 !=''  " . $queryCondition1 . "";
				$all_totlecors =" where prg_name1 !=''  " . $queryCondition1 . "";
				
				$output .=  
					'<tbody class="searchall">
					  <tr>  
						<td>'.$user_nam.'</td>';
						if($total_caoyurse > 0) {
							if($report_allow1 == '1'){
								$output .= '<td><a href="../application/apps_details_course.php?getcondion = '.base64_encode($all_totle_by_agent).'"  target="_blank">'.$total_caoyurse.'</a></td>';
							}else{
								$output .= '<td>'.$total_caoyurse.'</td>';
							}
						} else {
							$output .= '<td>'.$total_caoyurse.'</td>';
						}
				
					$output .= '</tr>
					<tbody>';  
				
			}
			
			
			
			$output .='  
					<tr>  
						
					<td>Total</td>';						
						if($all_total_course > 0) {
							if($report_allow1 == '1'){
								$output .= '<td><a href="../application/apps_details_course.php?getcondion = '.base64_encode($all_totlecors).'" target="_blank">'.$all_total_course.'</a></td>';	
							}else{
								$output .= '<td>'.$all_total_course.'</td>';
							}
						} else {
							$output .= '<td>'.$all_total_course.'</td>';
						}
						
					 $output .= '</tr> ';  
		
	
		$output .= '</table></div></div>'; 
		echo $output;
				
				
	}
?>
<style>
.table { border:1px solid #ccc; font-size:14px;}
.table.table-scroll { height:100px; overflow-y:scroll;}
.table.table-striped.table-scroll td, .table.table-striped.table-scroll th  { text-align:left; padding-left:10%;}
.table.table-striped.table-scroll td:first-child, .table.table-striped.table-scroll th:first-child  { text-align:left; font-weight:700;  padding-left:10%;}
.table.table-striped.table-scroll td a { font-size:16px; font-weight:bold;}

</style>
