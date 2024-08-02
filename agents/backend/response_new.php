<?php
date_default_timezone_set("Asia/Kolkata");
session_start();

include("../db.php");
header('Content-type: application/json');
if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT role,email,notify_per,cmsn_login,report_allow,loa_allow FROM allusers WHERE sno = '$sessionSno'");
while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole1 = mysqli_real_escape_string($con, $row1['role']);
   $notify_per1 = mysqli_real_escape_string($con, $row1['notify_per']); 
   $cmsn_login1 = mysqli_real_escape_string($con, $row1['cmsn_login']); 
   $report_allow1 = mysqli_real_escape_string($con, $row1['report_allow']); 
   $Loggedemail = mysqli_real_escape_string($con, $row1['email']); 
   $loa_allow = mysqli_real_escape_string($con, $row1['loa_allow']); 
}
}else{
   $adminrole1 = '';
   $notify_per1 = '';
   $cmsn_login1 = '';
   $Loggedemail = '';
   $loa_allow = '';
}

$updated_by = date('Y-m-d H:i:s');

if($_GET['tag'] === "getlisting"){
	$rowbg = $_POST['rowbg'];
	if(!empty($_POST['searchtext'])){		
		$search = $_POST['searchtext'];
		$result2 = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR refid LIKE '%".$search."%'";
		$queryasd = mysqli_query($con, $result2);
	}else{
		$result2 = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop'";
		$queryasd = mysqli_query($con, $result2);
	}
	if(!empty($_POST['roletype'])){
		$roletype = $_POST['roletype'];
		if($roletype == 'All'){
			$application_type = '';
			$result3 = "SELECT * FROM st_application where application_form='1' AND flowdrp!='Drop'";
			$queryasd = mysqli_query($con, $result3);
		}else{
			$application_type = "where application_form='1' AND flowdrp!='Drop' AND app_by='$roletype'";
			$result4 = "SELECT * FROM st_application $application_type";
			$queryasd = mysqli_query($con, $result4);
		}			
	}
	while ($row = mysqli_fetch_assoc($queryasd)){		
	 $snoid = mysqli_real_escape_string($con, $row['sno']);
	 $app_by = mysqli_real_escape_string($con, $row['app_by']);
	 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
	 $refid = mysqli_real_escape_string($con, $row['refid']);
	 $student_id = mysqli_real_escape_string($con, $row['student_id']);
	 $user_id = mysqli_real_escape_string($con, $row['user_id']);
	 $fname = mysqli_real_escape_string($con, $row['fname']);
	 $lname = mysqli_real_escape_string($con, $row['lname']);
	 $dob = mysqli_real_escape_string($con, $row['dob']);
	 $dob_1 = date("F j, Y", strtotime($dob));
	 $datetime = mysqli_real_escape_string($con, $row['datetime']);
	 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
	 $admin_status_crs = $row['admin_status_crs'];
	 $admin_remark_crs = $row['admin_remark_crs'];
	 $ol_confirm = $row['ol_confirm'];
	 $offer_letter = $row['offer_letter'];
	 $loa_confirm = mysqli_real_escape_string($con, $row['loa_confirm']);
	 $loa_confirm_remarks = mysqli_real_escape_string($con, $row['loa_confirm_remarks']);
	 $agreement = mysqli_real_escape_string($con, $row['agreement']);
	 $agreement_loa = mysqli_real_escape_string($con, $row['agreement_loa']);
	 $signed_al_status = mysqli_real_escape_string($con, $row['signed_al_status']);
	 $contract_letter = mysqli_real_escape_string($con, $row['contract_letter']);
	 $signed_agreement_letter = mysqli_real_escape_string($con, $row['signed_agreement_letter']);
	 $loa_file = mysqli_real_escape_string($con, $row['loa_file']);
	 $loa_file_status = mysqli_real_escape_string($con, $row['loa_file_status']);	 
	 $signed_ol_confirm = mysqli_real_escape_string($con, $row['signed_ol_confirm']);	 
	 $file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);	
	 $prepaid_fee = mysqli_real_escape_string($con, $row['prepaid_fee']);	 
	 $fh_status = mysqli_real_escape_string($con, $row['fh_status']);
	 $v_g_r_status = mysqli_real_escape_string($con, $row['v_g_r_status']);
	 $v_g_r_invoice = mysqli_real_escape_string($con, $row['v_g_r_invoice']);
	 $inovice_status = mysqli_real_escape_string($con, $row['inovice_status']);
	 $file_upload_vr_status = mysqli_real_escape_string($con, $row['file_upload_vr_status']);
	 $file_upload_vgr_status = mysqli_real_escape_string($con, $row['file_upload_vgr_status']);	 
	 $tt_upload_report_status = mysqli_real_escape_string($con, $row['tt_upload_report_status']);	 
	 $loa_tt = mysqli_real_escape_string($con, $row['loa_tt']);	 
	 
	$stuRefId= $student_id.'<br>'.$refid;
	 
	$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
		while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
		$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
	}
		
		if($rowbg == 'error_'.$snoid){
			$chbx = "class='$rowbg'".' '."style='background-color: rgb(168, 216, 244);'";
		}else{
			$chbx = "class=error_$snoid";
		}
		 
	//1st td  !--Application Type --!
		if($app_by == 'Student'){
			$role_type = 'Student'; 
		}
		if($agent_type == 'normal'){
			$role_type = $agntname; 
		}
		if($agent_type == 'int_agent'){
			$role_type = $agntname; 
		}
	
	if($adminrole1 !== 'Excu1'){
    //5th td application status
		$editFixed = '<a href="edit.php?apid='.base64_encode($snoid).'" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>';
		$editFixed1 = '<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="'.$snoid.'"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
	
		if($admin_status_crs == ""){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassyellow" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (No Action)"></i></i></span></td>';
		} if($admin_status_crs == "No"){ 
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (Not Approved)"></i></i></span></td>';
		} 
		if($admin_status_crs == "Not Eligible"){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Not Eligible"></i></i></span></td>';
		}
		if($admin_status_crs == "Yes"){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClass" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (Approved)"></i></i></span></td>';
		}		
		
	//Conditional Offer Letter
		if(($admin_status_crs == 'No') || ($admin_status_crs == '') || ($admin_status_crs == 'Not Eligible')){
			$olval1 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter == '') && ($ol_confirm == '')){ 
			$olval1 = '<td><div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Offer Letter"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '')){
			$olval1 = '<td><div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Generated (Send)"></i></div></td>';
		}		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){ 
			$olval1 = '<td><div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Sent (Sign Pending)"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){
			$olval1 = '<td><div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Sent (Status Pending)"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No') ){
			$olval1 = '<td><div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Not Approved"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes') ){
			$olval1 = '<td><div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Approved (Request LOA)"></i></div></td>';
		}
	}
	
	// if(($adminrole1 == 'Admin') || ($adminrole1 !== 'Excu')){
	if(($adminrole1 == 'Admin') || ($adminrole1 !== 'Excu') || ($adminrole1 == 'Excu1')){
	//LOA Request Status
		if(($signed_ol_confirm !== 'Yes') && ($file_receipt == '')){
			$btnpmt2 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($signed_ol_confirm == 'Yes') && ($file_receipt == '')){
			$btnpmt2 = '<td><span class="btn checklistClassyellow btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="LOA Not Requested"><i class="fas fa-times"></i></span></td>';
		}
		if(($file_receipt !== '') && ($loa_tt == '')){
			$btnpmt2 = '<td><div class="btn checklistClassgreen btn-sm" idno='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Request Sent"></i></div></td>';
		}
		if(($file_receipt !== '') && ($loa_tt !== '')){
			$btnpmt2 = '<td><div class="btn checklistClassgreen btn-sm" idno='.$snoid.'><a style="color:#fff;" style="color:#fff;" href="../../uploads/'.$loa_tt.'" download> <i class="fas fa-download" data-toggle="tooltip" data-placement="top" title="LOA Request Sent With TT"></i></a></div></td>';
		}
		
		
	//AOL Contract			
		if($file_receipt !== '1'){
			$olval3 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($file_receipt == '1') && ($contract_letter =='')){
			$olval3 = '<td><span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Contract"></i></div></td>';
		}
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='')){
			$olval3 = '<td><span class="btn checklistClassyellow btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Contract Generated (Send)"></i></div></td>';
		}
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='1') && ($signed_agreement_letter=='') ){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generated Contract Sent"></i></div></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='')){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Sent (Update Status)"></i></div></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='No')){
			$olval3 = '<td><span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Not Approved"></i></div></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='Yes')){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Approved"></i></div></td>';
		}
		
	// Fee LOA
		if(($signed_al_status == '') || ($signed_al_status == 'No') && ($prepaid_fee == '')){
			$feesBtn = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';		
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == '')){
			$feesBtn = '<td><div class="btn checklistClassred btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Pending)"></i></div></td>';
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == 'No')){
			$feesBtn = '<td><div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(No)"></i></div></td>';
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == 'Yes')){
			$feesBtn = '<td><div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Yes)"></i></div></td>';
		}		
		
	// Upload LOA
		if(($prepaid_fee == '') || ($loa_file == '')){
			$btnloa = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($prepaid_fee !== '') && ($loa_file == '')){ 
			$btnloa = '<td><div class="btn checklistClassyellow btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate LOA"></i></div></td>';
		}
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '')){
			$btnloa = '<td><div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="LOA Generated"></i></div></td>';
		}
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '1')){
			$btnloa = '<td><div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.' ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Sent"></i></div></td>';
		}	

// F@H Status		
		// if(($loa_file_status == '') && ($fh_status == '')){
			// $fhval = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		// }
		// if(($loa_file_status == '1') && ($fh_status == '')){
			// $fhval = '<td><div class="btn checklistClassyellow btn-sm phStatusClass" data-toggle="modal" data-target="#phStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="F@H Status Pending"></i></div></td>';
		// }
		// if(($loa_file_status == '1') && ($fh_status !== '')){
			// $fhval = '<td><span class="btn checklistClassgreen btn-sm phStatusClass" data-toggle="modal" data-target="#phStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="F@H Status Approved"></i></span></td>';
		// }
		
// V-G/V-R----
		
// Pending
		if((($loa_file_status == '') && $fh_status == '') && ($v_g_r_status == '')){
			$vgrstval = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status == '')){
			$vgrstval = '<td><div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div></td>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status !== '')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div></td>';
		}
		if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status == '')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Lodged"></i></div></td>';
		}
		
// V-G		
	if(($fh_status !== '') && ($v_g_r_status == 'V-G')){
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice =='') && ($inovice_status =='')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-G Status(Invoice Pending)"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='')){
			$vgrstval = '<td><div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="V-G Invoice Processed"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='Yes')){
			$vgrstval = '<td><div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Processed by Processor"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='No')){
			$vgrstval = '<td><div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Not Processed by Processor"></i></div></td>';
		}
	}

// V-R
		if(($fh_status !== '') && ($v_g_r_status == 'V-R')){
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status =='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-R Status(Refund Docs Pending From Agent)"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Refund Docs Recvd(Status Pending)"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Processed to processor"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'No') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Not Approved"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'No')){
			$vgrstval = '<td><span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund not approved by processor"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'Yes')){
			$vgrstval = '<td><span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Approved(Download TT)"></i></span></td>';
		}	
		}
	
	}
	
	$fullname = $fname.' '.$lname;
	$fullname_1 = '<a href="../followup/add.php?stusno='.$snoid.'" target="_blank">'.$fullname.'</a><br>'.$dob_1;
		
	if($adminrole1 == 'Excu1'){
		$res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,		    
		    'appliStatus' => '',
		    'olval1' => '',
			'btnpmt2' => $btnpmt2,
			'olval3' => $olval3,
			'feesBtn' => $feesBtn,
			'btnloa' => $btnloa,					    
			// 'fhval' => '',					    
			'vgrstval' => '',					    
			// 'invoiceval' => ''					    
		);
	}
	 
	if($adminrole1 == 'Excu'){
		$res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,
		    'appliStatus' => $applicationStatus,
		    'olval1' => $olval1,
			'btnpmt2' => '',
			'olval3' => '',
			'feesBtn' => '',
			'btnloa' => '',		    
			// 'fhval' => '',		    
			'vgrstval' => '',		    
			// 'invoiceval' => ''		    
		);
	}
	if($adminrole1 == 'Admin'){
		$res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,
		    'appliStatus' => $applicationStatus,
		    'olval1' => $olval1,
			'btnpmt2' => $btnpmt2,
			'olval3' => $olval3,
			'feesBtn' => $feesBtn,
			'btnloa' => $btnloa,
			// 'fhval' => $fhval,
			'vgrstval' => $vgrstval
			// 'invoiceval' => $invoiceval
		);
	}
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


//-----------------------------------------------------

if($_GET['tag'] === "Select_Status"){	
	$status1 = $_POST['status1'];
	$uname1 = $_POST['subid'];
	$rowbg = $_POST['rowbg'];
// Agent Name
	if(($status1 == 'ascname') || ($status1 == 'descname')){
		if($uname1 !== ''){
			$uname = "AND user_id='$uname1'";
		}
		if($uname1 == ''){
			$uname = '';
		}		
		if($status1 == 'ascname'){
			$as = "$uname ORDER BY username ASC";
		}
		if($status1 == 'descname'){
			$as = "$uname ORDER BY username DESC";
		}
		$rsltQuery = "SELECT * FROM allusers INNER JOIN st_application ON allusers.sno = st_application.user_id where application_form='1' AND flowdrp!='Drop' $as";
	}
// Full Name
	if(($status1 == 'ascfullname') || ($status1 == 'descfullname')){
		if($uname1 !== ''){
			$uname = "AND user_id='$uname1'";
		}
		if($uname1 == ''){
			$uname = '';
		}		
		if($status1 == 'ascfullname'){
			$as = "ORDER BY fname ASC";
		}
		if($status1 == 'descfullname'){
			$as = "ORDER BY fname DESC";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' $uname $as";
	}
// Refrence ID
	if(($status1 == 'ridasc') || ($status1 == 'riddesc')){
		if($uname1 !== ''){
			$uname = "AND user_id='$uname1'";
		}
		if($uname1 == ''){
			$uname = '';
		}		
		if($status1 == 'ridasc'){
			$as = "ORDER BY student_id ASC";
		}
		if($status1 == 'riddesc'){
			$as = "ORDER BY student_id DESC";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' $uname $as";
	}	
	
// Date Time
	if(($status1 == 'ascdate') || ($status1 == 'descdate')){
		if($uname1 !== ''){
			$uname = "AND user_id='$uname1'";
		}
		if($uname1 == ''){
			$uname = '';
		}		
		if($status1 == 'ascdate'){
			$as = "ORDER BY sno ASC";
		}
		if($status1 == 'descdate'){
			$as = "ORDER BY sno DESC";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' $uname $as";
	}	
// Application  Name
	if(($status1 == 'Pending') || ($status1 == 'Yes') || ($status1 == 'No') || ($status1 == '')){
		if($uname1 !== ''){
			$uname = "user_id='$uname1' AND";
		}
		if($uname1 == ''){
			$uname = '';
		}
		if(($status1 == 'Pending') || ($status1 == '')){
			$as = "$uname admin_status_crs=''";
		}else{
			$as = "$uname admin_status_crs='$status1'";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND $as";		
	}
// Conditional Offer Letter	
	if(($status1 == 'col_Pending') || ($status1 == 'col_Generated') || ($status1 == 'col_Sent') || ($status1 == 'col_Recieved') || ($status1 == 'col_Confirmed') || ($status1 == '')){
		if($uname1 !== ''){
			$uname = "user_id='$uname1' AND";
		}
		if($uname1 == ''){
			$uname = '';
		}
		if(($status1 == 'col_Pending') || ($status1 == '')){
			$as = "$uname ol_confirm='' AND offer_letter=''";
		}elseif($status1 == 'col_Generated'){
			$as = "$uname ol_confirm !='1' AND offer_letter !=''";
		}elseif($status1 == 'col_Sent'){
			$as = "$uname ol_confirm ='1'";
		}elseif($status1 == 'col_Recieved'){
			$as = "$uname agreement !=''";
		}elseif($status1 == 'col_Confirmed'){
			$as = "$uname signed_ol_confirm='Yes'";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND $as";		
	}
// LOA Request Status	
	if(($status1 == 'lrs_Pending') || ($status1 == 'lrs_rs') || ($status1 == 'lrs_rs_with') || ($status1 == '')){
		if($uname1 !== ''){
			$uname = "user_id='$uname1' AND";
		}
		if($uname1 == ''){
			$uname = '';
		}
		if(($status1 == 'lrs_Pending') || ($status1 == '')){
			$as = "$uname file_receipt=''";
		}elseif($status1 == 'lrs_rs'){
			$as = "$uname file_receipt !='' AND loa_tt=''";
		}
		elseif($status1 == 'lrs_rs_with'){
			$as = "$uname file_receipt !='' AND loa_tt!=''";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND $as";		
	}
// AOL Contract	
	if(($status1 == 'aolc_Pending') || ($status1 == 'aolc_Generated') || ($status1 == 'aolc_Sent') || ($status1 == 'aolc_Recieved') || ($status1 == 'aolc_Confirmed') || ($status1 == '')){
		if($uname1 !== ''){
			$uname = "user_id='$uname1' AND";
		}
		if($uname1 == ''){
			$uname = '';
		}
		if(($status1 == 'aolc_Pending') || ($status1 == '')){
			$as = "$uname contract_letter=''";
		}elseif($status1 == 'aolc_Generated'){
			$as = "$uname contract_letter !=''";
		}elseif($status1 == 'aolc_Sent'){
			$as = "$uname agreement_loa ='1'";
		}elseif($status1 == 'aolc_Recieved'){
			$as = "$uname signed_agreement_letter !=''";
		}elseif($status1 == 'aolc_Confirmed'){
			$as = "$uname signed_al_status='Yes'";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND $as";		
	}
// Fee LOA	
	if(($status1 == 'fee_pending') || ($status1 == 'fee_yes') || ($status1 == 'fee_no') || ($status1 == '')){
		if($uname1 !== ''){
			$uname = "user_id='$uname1' AND";
		}
		if($uname1 == ''){
			$uname = '';
		}
		if(($status1 == 'fee_pending') || ($status1 == '')){
			$as = "$uname prepaid_fee=''";
		}elseif($status1 == 'fee_yes'){
			$as = "$uname prepaid_fee='Yes'";
		}elseif($status1 == 'fee_no'){
			$as = "$uname prepaid_fee='No'";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND $as";		
	}	
	
// Upload LOA	
	if(($status1 == 'fee_asc') || ($status1 == 'fee_desc') || ($status1 == 'loa_Pending') || ($status1 == 'loa_g') || ($status1 == 'loa_s') || ($status1 == '')){
		if($uname1 !== ''){
			$uname = "user_id='$uname1' AND";
		}
		if($uname1 == ''){
			$uname = '';
		}
		if(($status1 == 'fee_asc') || ($status1 == '')){
			$as = "AND loa_file !='' AND loa_file_status_date_by!='' ORDER BY loa_file_status_date_by ASC";
		}elseif($status1 == 'fee_desc'){
			$as = "AND loa_file !='' AND loa_file_status_date_by!='' ORDER BY loa_file_status_date_by DESC";
		}elseif($status1 == 'loa_Pending'){
			$as = "AND $uname loa_file=''";
		}elseif($status1 == 'loa_g'){
			$as = "AND $uname loa_file !=''";
		}elseif($status1 == 'loa_s'){
			$as = "AND $uname loa_file_status ='1'";
		}
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' $as";		
	}
	// die;
	
// F@H Status	
	// if(($status1 == 'fh_Pending') || ($status1 == 'fh_sent') || ($status1 == '')){
		// if($uname1 !== ''){
			// $uname = "user_id='$uname1' AND";
		// }
		// if($uname1 == ''){
			// $uname = '';
		// }
		// if(($status1 == 'fh_Pending') || ($status1 == '')){
			// $as = "$uname fh_status=''";
		// }elseif($status1 == 'fh_sent'){
			// $as = "$uname fh_status !=''";
		// }
		// $rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND $as";		
	// }

// V-G / V-R Details	
	if(($status1 == 'fh_lodeged') || ($status1 == 'fh_not_lodeged') || ($status1 == 'fh_Re_Lodged') || ($status1 == 'vrg_Pending') || ($status1 == 'vrg_VG') || ($status1 == 'vrg_VR') || ($status1 == 'vrg_Commission_Details_Invoice_pending_admin') || ($status1 == 'vrg_Commission_Details_Invoice_send_admin') || ($status1 == 'vrg_Commission_Details_Invoice_status_prcd_Agent') || ($status1 == 'vrg_Commission_Details_Invoice_status_not_prcd_Agent') || ($status1 == 'vrg_rfnd_rqst_recieved') || ($status1 == 'vgr_rfnd_docs_not_approved') || ($status1 == 'vrg_rfnd_rqst_prcd') || ($status1 == 'vrg_rfnd_rqst_not_prcd') || ($status1 == 'vrg_rfnd_rqst_prcd_report') || ($status1 == 'vrg_rfnd_rqst_prcd_report_not') || ($status1 == '')){
		if($uname1 !== ''){
			$uname = "user_id='$uname1' AND";
		}
		if($uname1 == ''){
			$uname = '';
		}
		if(($status1 == 'fh_lodeged') || ($status1 == '')){
			$as = "$uname loa_file_status='1' AND fh_status !='' AND v_g_r_status=''";
		}
		elseif(($status1 == 'fh_not_lodeged')){
			$as = "$uname loa_file_status='1' AND fh_status ='' AND v_g_r_status=''";
		}
		elseif(($status1 == 'fh_Re_Lodged')){
			$as = "$uname loa_file_status='1' AND fh_status !='' AND fh_re_lodgement='Re_Lodged' AND v_g_r_status=''";
		}		
		// elseif(($status1 == 'vrg_Pending')){
			// $as = "$uname loa_file_status='1' AND fh_status!='' AND v_g_r_status=''";
		// }
		elseif($status1 == 'vrg_VG'){
			$as = "$uname v_g_r_status ='V-G' AND fh_status!=''";
		}
		elseif($status1 == 'vrg_VR'){
			$as = "$uname v_g_r_status ='V-R' AND fh_status!=''";
		}
		elseif($status1 == 'vrg_Commission_Details_Invoice_pending_admin'){
			$as = "$uname v_g_r_status='V-G' and v_g_r_invoice='' AND inovice_status=''";
		}
		elseif($status1 == 'vrg_Commission_Details_Invoice_send_admin'){
			$as = "$uname v_g_r_status='V-G' and v_g_r_invoice !='' AND inovice_status=''";
		}
		elseif($status1 == 'vrg_Commission_Details_Invoice_status_prcd_Agent'){
			$as = "$uname v_g_r_status='V-G' and v_g_r_invoice !='' and inovice_status='Yes'";
		}
		elseif($status1 == 'vrg_Commission_Details_Invoice_status_not_prcd_Agent'){
			$as = "$uname v_g_r_status='V-G' and v_g_r_invoice !='' and inovice_status='No'";			
		}
		elseif($status1 == 'vrg_rfnd_rqst_recieved'){
			$as = "$uname v_g_r_status ='V-R' AND file_upload_vr_status ='Yes' AND file_upload_vgr_status=''";			
		}
		elseif($status1 == 'vgr_rfnd_docs_not_approved'){ 
			$as = "$uname v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='No' AND tt_upload_report_status=''";		
		}
		elseif($status1 == 'vrg_rfnd_rqst_prcd'){
			$as = "$uname v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND tt_upload_report_status=''";
		}
		elseif($status1 == 'vrg_rfnd_rqst_not_prcd'){
			$as = "$uname v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND tt_upload_report_status='No'";
		}
		elseif($status1 == 'vrg_rfnd_rqst_prcd_report'){
			$as = "$uname v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND settled_vr='Settled' AND tt_upload_report_status='Yes'";
		}
		elseif($status1 == 'vrg_rfnd_rqst_prcd_report_not'){
			$as = "$uname v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND settled_vr='Not Settled' AND tt_upload_report_status='Yes'";
		}
		
		
		
		$rsltQuery = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND $as";		
	}	
	// print_r($rsltQuery);
	// die;
	
	$qurySql = mysqli_query($con, $rsltQuery);	
	while ($row = mysqli_fetch_assoc($qurySql)){		
	 $snoid = mysqli_real_escape_string($con, $row['sno']);
	 $app_by = mysqli_real_escape_string($con, $row['app_by']);
	 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
	 $refid = mysqli_real_escape_string($con, $row['refid']);
	 $student_id = mysqli_real_escape_string($con, $row['student_id']);
	 $user_id = mysqli_real_escape_string($con, $row['user_id']);
	 $fname = mysqli_real_escape_string($con, $row['fname']);
	 $lname = mysqli_real_escape_string($con, $row['lname']);
	 $dob = mysqli_real_escape_string($con, $row['dob']);
	 $dob_1 = date("F j, Y", strtotime($dob));
	 $datetime = mysqli_real_escape_string($con, $row['datetime']);
	 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
	 $admin_status_crs = $row['admin_status_crs'];
	 $admin_remark_crs = $row['admin_remark_crs'];
	 $ol_confirm = $row['ol_confirm'];
	 $offer_letter = $row['offer_letter'];
	 $loa_confirm = mysqli_real_escape_string($con, $row['loa_confirm']);
	 $loa_confirm_remarks = mysqli_real_escape_string($con, $row['loa_confirm_remarks']);
	 $agreement = mysqli_real_escape_string($con, $row['agreement']);
	 $agreement_loa = mysqli_real_escape_string($con, $row['agreement_loa']);
	 $signed_al_status = mysqli_real_escape_string($con, $row['signed_al_status']);
	 $contract_letter = mysqli_real_escape_string($con, $row['contract_letter']);
	 $signed_agreement_letter = mysqli_real_escape_string($con, $row['signed_agreement_letter']);
	 $prepaid_fee = mysqli_real_escape_string($con, $row['prepaid_fee']);
	 $loa_file = mysqli_real_escape_string($con, $row['loa_file']);
	 $loa_file_status = mysqli_real_escape_string($con, $row['loa_file_status']);	 
	 $signed_ol_confirm = mysqli_real_escape_string($con, $row['signed_ol_confirm']);	 
	 $file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);
	 
	 $fh_status = mysqli_real_escape_string($con, $row['fh_status']);
	 $v_g_r_status = mysqli_real_escape_string($con, $row['v_g_r_status']);
	 $v_g_r_invoice = mysqli_real_escape_string($con, $row['v_g_r_invoice']);
	 $inovice_status = mysqli_real_escape_string($con, $row['inovice_status']);
	 $file_upload_vr_status = mysqli_real_escape_string($con, $row['file_upload_vr_status']);
	 $file_upload_vgr_status = mysqli_real_escape_string($con, $row['file_upload_vgr_status']);	 
	 $tt_upload_report_status = mysqli_real_escape_string($con, $row['tt_upload_report_status']);	 
	 $loa_tt = mysqli_real_escape_string($con, $row['loa_tt']);	 
	 
	 $stuRefId= $student_id.'<br>'.$refid;
	
	$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
		while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
		$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
	}
	 
		if($rowbg == 'error_'.$snoid){
			$chbx = "class='$rowbg'".' '."style='background-color: rgb(168, 216, 244);'";
		}else{
			$chbx = "class=error_$snoid";
		}
	 
	//1st td  !--Application Type --!
		if($app_by == 'Student'){
			$role_type = 'Student'; 
		}
		if($agent_type == 'normal'){
			$role_type = $agntname; 
		}
		if($agent_type == 'int_agent'){
			$role_type = $agntname; 
		}
		
	if($adminrole1 !== 'Excu1'){		
    //5th td application status
		$editFixed = '<a href="edit.php?apid='.base64_encode($snoid).'" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>';
		$editFixed1 = '<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="'.$snoid.'"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
	
		if($admin_status_crs == ""){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassyellow" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (No Action)"></i></i></span></td>';
		} if($admin_status_crs == "No"){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (Not Approved)"></i></i></span></td>';
		} 
		if($admin_status_crs == "Not Eligible"){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Not Eligible"></i></i></span></td>';
		}
		if($admin_status_crs == "Yes"){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClass" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (Approved)"></i></i></span></td>';
		}		
		
	//Conditional Offer Letter
		if(($admin_status_crs == 'No') || ($admin_status_crs == '') || ($admin_status_crs == 'Not Eligible')){
			$olval1 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter == '') && ($ol_confirm == '')){ 
			$olval1 = '<td><div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Offer Letter"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '')){
			$olval1 = '<td><div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Generated (Send)"></i></div></td>';
		}		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){ 
			$olval1 = '<td><div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Sent (Sign Pending)"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){
			$olval1 = '<td><div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Sent (Status Pending)"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No') ){
			$olval1 = '<td><div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Not Approved"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes') ){
			$olval1 = '<td><div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Approved (Request LOA)"></i></div></td>';
		}
	}	
	
	if(($adminrole1 == 'Admin') || ($adminrole1 !== 'Excu') || ($adminrole1 == 'Excu1')){	
	//LOA Request Status
		if(($signed_ol_confirm !== 'Yes') && ($file_receipt == '')){
			$btnpmt2 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($signed_ol_confirm == 'Yes') && ($file_receipt == '')){
			$btnpmt2 = '<td><span class="btn checklistClassyellow btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="LOA Not Requested"><i class="fas fa-times"></i></span></td>';
		}
		if(($file_receipt !== '') && ($loa_tt == '')){
			$btnpmt2 = '<td><div class="btn checklistClassgreen btn-sm" idno='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Request Sent"></i></div></td>';
		}
		if(($file_receipt !== '') && ($loa_tt !== '')){
			$btnpmt2 = '<td><div class="btn checklistClassgreen btn-sm" idno='.$snoid.'><a style="color:#fff;" href="../../uploads/'.$loa_tt.'" download> <i class="fas fa-download" data-toggle="tooltip" data-placement="top" title="LOA Request Sent With TT"></i></a></div></td>';
		}
		
	//AOL Contract			
		if($file_receipt !== '1'){
			$olval3 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($file_receipt == '1') && ($contract_letter =='')){
			$olval3 = '<td><span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Contract"></i></span></td>';
		}
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='')){
			$olval3 = '<td><span class="btn checklistClassyellow btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Contract Generated (Send)"></i></span></td>';
		}
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='1') && ($signed_agreement_letter=='') ){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generated Contract Sent"></i></span></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='')){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Sent (Update Status)"></i></span></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='No')){
			$olval3 = '<td><span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Not Approved"></i></span></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='Yes')){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Approved"></i></span></td>';
		}
	// Fee LOA
		if(($signed_al_status == '') || ($signed_al_status == 'No') && ($prepaid_fee == '')){
			$feesBtn = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';		
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == '')){
			$feesBtn = '<td><div class="btn checklistClassred btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Pending)"></i></div></td>';
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == 'No')){
			$feesBtn = '<td><div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(No)"></i></div></td>';
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == 'Yes')){
			$feesBtn = '<td><div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Yes)"></i></div></td>';
		}		
		
	// Upload LOA	
		// if(($signed_al_status == '') || ($signed_al_status == 'No')){
		if(($prepaid_fee == '') || ($loa_file == '')){
			$btnloa = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		// if(($signed_al_status == 'Yes') && ($loa_file == '')){
		if(($prepaid_fee !== '') && ($loa_file == '')){ 
			$btnloa = '<td><div class="btn checklistClassyellow btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate LOA"></i></div></td>';
		}
		// if(($loa_file !== '') && ($loa_file_status == '')){
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '')){
			$btnloa = '<td><div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="LOA Generated"></i></div></td>';
		}
		// if(($loa_file !== '') && ($loa_file_status == '1')){
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '1')){
			$btnloa = '<td><div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.' ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Sent"></i></div></td>';
		}
	}
	
// F@H Status		
		// if(($loa_file_status == '') && ($fh_status == '')){
			// $fhval = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		// }
		// if(($loa_file_status == '1') && ($fh_status == '')){
			// $fhval = '<td><div class="btn checklistClassyellow btn-sm phStatusClass" data-toggle="modal" data-target="#phStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="F@H Status Pending"></i></div></td>';
		// }
		// if(($loa_file_status == '1') && ($fh_status !== '')){
			// $fhval = '<td><span class="btn checklistClassgreen btn-sm phStatusClass" data-toggle="modal" data-target="#phStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="F@H Status Approved"></i></span></td>';
		// }
		
// V-G/V-R
		
// Pending

		if((($loa_file_status == '') && $fh_status == '') && ($v_g_r_status == '')){
			$vgrstval = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status == '')){
			$vgrstval = '<td><div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div></td>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status !== '')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div></td>';
		}
		if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status == '')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Lodged"></i></div></td>';
		}

// V-G		
	if(($fh_status !== '') && ($v_g_r_status == 'V-G')){
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice =='') && ($inovice_status =='')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-G Status(Invoice Pending)"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='')){
			$vgrstval = '<td><div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="V-G Invoice Processed"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='Yes')){
			$vgrstval = '<td><div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Processed by Processor"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='No')){
			$vgrstval = '<td><div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Not Processed by Processor"></i></div></td>';
		}
	}
		
// V-R
	if(($fh_status !== '') && ($v_g_r_status == 'V-R')){
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status =='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-R Status(Refund Docs Pending From Agent)"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Refund Docs Recvd.(Status Pending)"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Processed to processor"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'No') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Not Approved"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'No')){
			$vgrstval = '<td><span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund not approved by processor"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'Yes')){
			$vgrstval = '<td><span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Approved(Download TT)"></i></span></td>';
		}	
	}	
	
	$fullname = $fname.' '.$lname;
	$fullname_1 = '<a href="../followup/add.php?stusno='.$snoid.'" target="_blank">'.$fullname.'</a><br>'.$dob_1;
	
	if($adminrole1 == 'Excu1'){
		$res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,		    
		    'appliStatus' => '',
		    'olval1' => '',
			'btnpmt2' => $btnpmt2,
			'olval3' => $olval3,
			'feesBtn' => $feesBtn,
			'btnloa' => $btnloa,
			'vgrstval' => ''
		);
	}
	 
	if($adminrole1 == 'Excu'){
	 $res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,
		    'appliStatus' => $applicationStatus,
		    'olval1' => $olval1,
			'btnpmt2' => '',
			'olval3' => '',
			'feesBtn' => '',
			'btnloa' => '',
			'vgrstval' => ''
		);
	}
	if($adminrole1 == 'Admin'){
		$res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,
		    'appliStatus' => $applicationStatus,
		    'olval1' => $olval1,
			'btnpmt2' => $btnpmt2,
			'olval3' => $olval3,
			'feesBtn' => $feesBtn,
			'btnloa' => $btnloa,
			'vgrstval' => $vgrstval
		);
	}
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] === "remarkdb"){
	$snoid = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT sno, campus, prg_name1, prg_intake, admin_status_crs, admin_remark_crs FROM st_application where sno='$snoid'");
	while($rowstr = mysqli_fetch_array($get_query)){		
		$campus1 = $rowstr['campus'];
		$prg_name1 = $rowstr['prg_name1'];
		$prg_intake = $rowstr['prg_intake'];

		if($campus1 == ''){
			$campus = "<span style='color:red;'>N/A</span>";
		}else{
			$campus = $campus1;
		}

		if($prg_name1 == ''){
			$pname = "<span style='color:red;'>N/A</span>";
		}else{
			$pname = $prg_name1;
		}
		
		if($prg_intake == ''){
			$ptake = "<span style='color:red;'>N/A</span>";
		}else{
			$ptake = $prg_intake;			
		}
		
		$admin_status_crs1 = $rowstr['admin_status_crs'];
		if($admin_status_crs1 == ''){
			$ascStatus = "<span style='color:red;'>N/A</span>";
		}else{
			$ascStatus = $admin_status_crs1;
		}
		
		$admin_remark_crs1 = $rowstr['admin_remark_crs'];
		if($admin_remark_crs1 == ''){
			$ascStatus1 = "<span style='color:red;'>N/A</span>";
		}else{
			$ascStatus1 = $admin_remark_crs1;
		}
		
		$res1[] = array(
		    'campus' => $campus,
		    'ptake' => $ptake,
		    'pname' => $pname,
		    'admin_status_crs' => $ascStatus,
		    'admin_remark_crs' => $ascStatus1
		);
	}
	echo json_encode($res1);
}


if($_GET['tag'] === "getuname"){
	$uname = $_POST['idtype'];
	$rowbg = $_POST['rowbg'];
	$get_query = mysqli_query($con, "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND user_id='$uname'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$snoid = $rowstr['sno'];
		$app_by = $rowstr['app_by'];
		$agent_type = mysqli_real_escape_string($con, $rowstr['agent_type']);
		$refid = mysqli_real_escape_string($con, $rowstr['refid']);
		$student_id = mysqli_real_escape_string($con, $rowstr['student_id']);
		$user_id = mysqli_real_escape_string($con, $rowstr['user_id']);
		$fname = mysqli_real_escape_string($con, $rowstr['fname']);
		$lname = mysqli_real_escape_string($con, $rowstr['lname']);
		$dob = mysqli_real_escape_string($con, $rowstr['dob']);
		$dob_1 = date("F j, Y", strtotime($dob));
		$prg_type1 = mysqli_real_escape_string($con, $rowstr['prg_type1']);
		$prg_name1 = mysqli_real_escape_string($con, $rowstr['prg_name1']);
		$datetime = mysqli_real_escape_string($con, $rowstr['datetime']);
		$admin_status_crs = $rowstr['admin_status_crs'];
		$admin_remark_crs = $rowstr['admin_remark_crs'];
		$ol_confirm = $rowstr['ol_confirm'];
		$offer_letter = $rowstr['offer_letter'];
		 $loa_confirm = mysqli_real_escape_string($con, $rowstr['loa_confirm']);
		 $loa_confirm_remarks = mysqli_real_escape_string($con, $rowstr['loa_confirm_remarks']);
		 $agreement = mysqli_real_escape_string($con, $rowstr['agreement']);
		 $agreement_loa = mysqli_real_escape_string($con, $rowstr['agreement_loa']);
		 $signed_al_status = mysqli_real_escape_string($con, $rowstr['signed_al_status']);
		 $contract_letter = mysqli_real_escape_string($con, $rowstr['contract_letter']);
		 $signed_agreement_letter = mysqli_real_escape_string($con, $rowstr['signed_agreement_letter']);
		 $loa_file = mysqli_real_escape_string($con, $rowstr['loa_file']);
		 $loa_file_status = mysqli_real_escape_string($con, $rowstr['loa_file_status']);
		 $signed_ol_confirm = mysqli_real_escape_string($con, $rowstr['signed_ol_confirm']);
		 $file_receipt = mysqli_real_escape_string($con, $rowstr['file_receipt']);
		 $prepaid_fee = mysqli_real_escape_string($con, $rowstr['prepaid_fee']);
		
		 $fh_status = mysqli_real_escape_string($con, $rowstr['fh_status']);
		 $v_g_r_status = mysqli_real_escape_string($con, $rowstr['v_g_r_status']);
		 $v_g_r_invoice = mysqli_real_escape_string($con, $rowstr['v_g_r_invoice']);
		 $inovice_status = mysqli_real_escape_string($con, $rowstr['inovice_status']);
		 $file_upload_vr_status = mysqli_real_escape_string($con, $rowstr['file_upload_vr_status']);
		 $file_upload_vgr_status = mysqli_real_escape_string($con, $rowstr['file_upload_vgr_status']);	 
		 $tt_upload_report_status = mysqli_real_escape_string($con, $rowstr['tt_upload_report_status']);	 
		 $loa_tt = mysqli_real_escape_string($con, $rowstr['loa_tt']);	 
		 
		 $stuRefId = $student_id.'<br>'.$refid;
		
	 $agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
		     while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
			 $agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
			 }
			 
		if($rowbg == 'error_'.$snoid){
			$chbx = "class='$rowbg'".' '."style='background-color: rgb(168, 216, 244);'";
		}else{
			$chbx = "class=error_$snoid";
		}
	 
	//Application Type
		if($app_by == 'Student'){
			$role_type = 'Student'; 
		}
		if($agent_type == 'normal'){
			$role_type = $agntname; 
		}
		if($agent_type == 'int_agent'){
			$role_type = $agntname; 
		}
	
	if($adminrole1 !== 'Excu1'){
	//Application Status		
		$editFixed = '<a href="edit.php?apid='.base64_encode($snoid).'" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>';
		$editFixed1 = '<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="'.$snoid.'"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
	
		if($admin_status_crs == ""){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassyellow" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (No Action)"></i></i></span></td>';
		} 
		if($admin_status_crs == "No"){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (Not Approved)"></i></i></span></td>';
		} 
		if($admin_status_crs == "Not Eligible"){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Not Eligible"></i></i></span></td>';
		}
		if($admin_status_crs == "Yes"){
			$applicationStatus = '<td>'.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClass" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoid.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (Approved)"></i></i></span></td>';
		}		
		
	 //Conditional Offer Letter
		if(($admin_status_crs == 'No') || ($admin_status_crs == '') || ($admin_status_crs == 'Not Eligible')){
			$olval1 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter == '') && ($ol_confirm == '')){ 
			$olval1 = '<td><div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Offer Letter"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '')){
			$olval1 = '<td><div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Generated (Send)"></i></div></td>';
		}		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){ 
			$olval1 = '<td><div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Sent (Sign Pending)"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){
			$olval1 = '<td><div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Sent (Status Pending)"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No') ){
			$olval1 = '<td><div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Not Approved"></i></div></td>';
		}
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes') ){
			$olval1 = '<td><div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Approved (Request LOA)"></i></div></td>';
		}
	}
		 
	if(($adminrole1 == 'Admin') || ($adminrole1 !== 'Excu') || ($adminrole1 == 'Excu1')){	
	//LOA Request Status
		if(($signed_ol_confirm !== 'Yes') && ($file_receipt == '')){
			$btnpmt2 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($signed_ol_confirm == 'Yes') && ($file_receipt == '')){
			$btnpmt2 = '<td><span class="btn checklistClassyellow btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="LOA Not Requested"><i class="fas fa-times"></i></span></td>';
		}
		if(($file_receipt !== '') && ($loa_tt == '')){
			$btnpmt2 = '<td><div class="btn checklistClassgreen btn-sm" idno='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Request Sent Without TT"></i></div></td>';
		}
		if(($file_receipt !== '') && ($loa_tt !== '')){
			$btnpmt2 = '<td><div class="btn checklistClassgreen btn-sm" idno='.$snoid.'><a style="color:#fff;" href="../../uploads/'.$loa_tt.'" download> <i class="fas fa-download" data-toggle="tooltip" data-placement="top" title="LOA Request Sent With TT"></i></a></div></td>';
		}
		
	//AOL Contract			
		if($file_receipt !== '1'){
			$olval3 = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($file_receipt == '1') && ($contract_letter =='')){
			$olval3 = '<td><span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Contract"></i></span></td>';
		}
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='')){
			$olval3 = '<td><span class="btn checklistClassyellow btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Contract Generated (Send)"></i></span></td>';
		}
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='1') && ($signed_agreement_letter=='') ){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generated Contract Sent"></i></span></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='')){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Sent (Update Status)"></i></span></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='No')){
			$olval3 = '<td><span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Not Approved"></i></span></td>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='Yes')){
			$olval3 = '<td><span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoid.'> <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Approved"></i></span></td>';
		}
	
	// Fee LOA
		if(($signed_al_status == '') || ($signed_al_status == 'No') && ($prepaid_fee == '')){
			$feesBtn = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';		
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == '')){
			$feesBtn = '<td><div class="btn checklistClassred btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Pending)"></i></div></td>';
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == 'No')){
			$feesBtn = '<td><div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(No)"></i></div></td>';
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == 'Yes')){
			$feesBtn = '<td><div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Yes)"></i></div></td>';
		}		
		
	// Upload LOA
		if(($prepaid_fee == '') || ($loa_file == '')){
			$btnloa = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($prepaid_fee !== '') && ($loa_file == '')){ 
			$btnloa = '<td><div class="btn checklistClassyellow btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate LOA"></i></div></td>';
		}
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '')){
			$btnloa = '<td><div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="LOA Generated"></i></div></td>';
		}
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '1')){
			$btnloa = '<td><div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoid.' ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Sent"></i></div></td>';
		}
		
// F@H Status		
		// if(($loa_file_status == '') && ($fh_status == '')){
			// $fhval = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		// }
		// if(($loa_file_status == '1') && ($fh_status == '')){
			// $fhval = '<td><div class="btn checklistClassyellow btn-sm phStatusClass" data-toggle="modal" data-target="#phStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="F@H Status Pending"></i></div></td>';
		// }
		// if(($loa_file_status == '1') && ($fh_status !== '')){
			// $fhval = '<td><span class="btn checklistClassgreen btn-sm phStatusClass" data-toggle="modal" data-target="#phStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="F@H Status Approved"></i></span></td>';
		// }
		
// V-G/V-R
		
// Pending
		if((($loa_file_status == '') && $fh_status == '') && ($v_g_r_status == '')){
			$vgrstval = '<td><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status == '')){
			$vgrstval = '<td><div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div></td>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status !== '')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div></td>';
		}
		if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status == '')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Lodged"></i></div></td>';
		}

// V-G		
	if(($fh_status !== '') && ($v_g_r_status == 'V-G')){
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice =='') && ($inovice_status =='')){
			$vgrstval = '<td><div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-G Status(Invoice Pending)"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='')){
			$vgrstval = '<td><div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="V-G Invoice Processed"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='Yes')){
			$vgrstval = '<td><div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Processed by Processor"></i></div></td>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='No')){
			$vgrstval = '<td><div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Not Processed by Processor"></i></div></td>';
		}
	}
		
// V-R
	if(($fh_status !== '') && ($v_g_r_status == 'V-R')){
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status =='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-R Status(Refund Docs Pending From Agent)"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Refund Docs Recvd.(Status Pending)"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Processed to processor"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'No') && ($tt_upload_report_status == '')){
			$vgrstval = '<td><span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Not Approved"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'No')){
			$vgrstval = '<td><span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund not approved by processor"></i></span></td>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'Yes')){
			$vgrstval = '<td><span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Approved(Download TT)"></i></span></td>';
		}	
	}		
	
	}
	
	$fullname = $fname.' '.$lname;
	$fullname_1 = '<a href="../followup/add.php?stusno='.$snoid.'" target="_blank">'.$fullname.'</a><br>'.$dob_1;
	 
	if($adminrole1 == 'Excu1'){
		$res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,		    
		    'appliStatus' => '',
		    'olval1' => '',
			'btnpmt2' => $btnpmt2,
			'olval3' => $olval3,
			'feesBtn' => $feesBtn,
			'btnloa' => $btnloa,
			// 'fhval' => '',
			'vgrstval' => ''
		);
	}
	 
	 if($adminrole1 == 'Excu'){
	 $res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,
		    'appliStatus' => $applicationStatus,
		    'olval1' => $olval1,
			'btnpmt2' => '',
			'olval3' => '',
			'feesBtn' => '',
			'btnloa' => '',
			// 'fhval' => '',
			'vgrstval' => ''
		);
	}
	if($adminrole1 == 'Admin'){
		$res1[] = array(
		    'sno' => $snoid,
		    'chbx' => $chbx,
		    'app_by' => $role_type,
			'refid' => $stuRefId,
		    'fname' => $fullname_1,
		    'lname' => '',
		    'datetime' => $datetime,
		    'appliStatus' => $applicationStatus,
		    'olval1' => $olval1,
			'btnpmt2' => $btnpmt2,
			'olval3' => $olval3,
			'feesBtn' => $feesBtn,
			'btnloa' => $btnloa,
			// 'fhval' => $fhval,
			'vgrstval' => $vgrstval
		);
	}
	
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] === "confirm"){
	$cnfrmid = $_POST['cnfrmid'];
	$resc = "UPDATE `st_application` SET `admin_status_crs`='Confirmed' WHERE `sno`='$cnfrmid'";
	$qry = mysqli_query($con, $resc);	
	echo 1;
}


if($_GET['tag'] == "fetch"){
	$idno = $_POST["idno"];
	$get_query = mysqli_query($con, "SELECT * FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$idp1 = $rowstr['idproof'];
		$cert1 = $rowstr['certificate1'];
		$cert2 = $rowstr['certificate2'];
		$cert3 = $rowstr['certificate3'];
		if($idp1 !== ''){
			$idproof = "<a href='../../uploads/$idp1' download> Download</a>";
		}else{
			$idproof = "<span style='color:red;'>Pending</span>";
		}
		
		if($cert1 !== ''){
			$certificate1 = "<a href='../../uploads/$cert1' download> Download</a>";
		}else{
			$certificate1 = "<span style='color:red;'>Pending</span>";
		}
				
		if($cert2 !== ''){
			$certificate2 = "<a href='../../uploads/$cert2' download> Download</a>";
		}else{
			$certificate2 = "<span style='color:red;'>Pending</span>";
		}
		
		if($cert3 !== ''){
			$certificate3 = "<a href='../../uploads/$cert3' download> Download</a>";
		}else{
			$certificate3 = "<span style='color:red;'>Pending</span>";
		}		
		
		$englishpro = $rowstr['englishpro'];
		if($englishpro == 'ielts'){
			
		$ielts_file1 = $rowstr['ielts_file'];
		if($ielts_file1 !== ''){
			$ielts_file = "<a href='../../uploads/$ielts_file1' download>Download</a>";
		}else{
			$ielts_file = "<span style='color:red;'>Pending</span>";
		}
			
		$ielts_pte_over = '<b>IELTS Overall Band: </b> '.$rowstr['ieltsover'];
		$ielts_pte_not = '<b>IELTS Band not Less than: </b>'.$rowstr['ieltsnot'];
		$ielts_pte_listening = '<b>Listening: </b>'.$rowstr['ielts_listening'];
		$ielts_pte_reading = '<b>Reading: </b>'.$rowstr['ielts_reading'];
		$ielts_pte_writing = '<b>Writing: </b>'.$rowstr['ielts_writing'];
		$ielts_pte_speaking = '<b>Speaking: </b>'.$rowstr['ielts_speaking'];
		$ielts_pte_date = '<b>IELTS Date: </b>'.$rowstr['ielts_date'];
		$ielts_pte_file = '<b>IELTS TRF: </b>'.$ielts_file;
		}	
				
		if($englishpro == 'pte'){
			
		$pte_file1 = $rowstr['pte_file'];
		if($pte_file1 !== ''){
			$pte_file = "<a href='../../uploads/$pte_file1' download>Download</a>";
		}else{
			$pte_file = "<span style='color:red;'>Pending</span>";
		}
			
		$ielts_pte_over = '<b>PTE Overall Band: </b>'.$rowstr['pteover'];
		$ielts_pte_not = '<b>PTE Band not Less than: </b>'.$rowstr['ptenot'];
		$ielts_pte_listening = '<b>Listening: </b>'.$rowstr['pte_listening'];
		$ielts_pte_reading = '<b>Reading: </b>'.$rowstr['pte_reading'];
		$ielts_pte_writing = '<b>Writing: </b>'.$rowstr['pte_writing'];
		$ielts_pte_speaking = '<b>Speaking: </b>'.$rowstr['pte_speaking'];
		$ielts_pte_date = '<b>PTE Date: </b>'.$rowstr['pte_date'];
		$ielts_pte_file = '<b>PTE TRF: </b>'.$pte_file;
		}
		
		if($englishpro == ''){
		$ielts_pte_over = '';
		$ielts_pte_not = '';
		$ielts_pte_listening = '';
		$ielts_pte_reading = '';
		$ielts_pte_writing = '';
		$ielts_pte_speaking = '';
		$ielts_pte_date = '';
		$ielts_pte_file = '';
		}
		
		$res1[] = array(
		    'sno' => $rowstr['sno'],
		    'app_by' => $rowstr['app_by'],
			'refid' => $rowstr['refid'],
			'email_address' => $rowstr['email_address'],
		    'fname' => $rowstr['fname'],
		    'lname' => $rowstr['lname'],
		    'mobile' => $rowstr['mobile'],
		    'gender' => $rowstr['gender'],
		    'martial_status' => $rowstr['martial_status'],
		    'passport_no' => $rowstr['passport_no'],
		    'pp_issue_date' => $rowstr['pp_issue_date'],
		    'pp_expire_date' => $rowstr['pp_expire_date'],
		    'dob' => $rowstr['dob'],
		    'cntry_brth' => $rowstr['cntry_brth'],
		    'address1' => $rowstr['address1'],
		    'address2' => $rowstr['address2'],
		    'country' => $rowstr['country'],
		    'state' => $rowstr['state'],
		    'city' => $rowstr['city'],
		    'pincode' => $rowstr['pincode'],
		    'idproof' => $idproof,
		    'datetime' => $rowstr['datetime'],
			'englishpro' => $englishpro,
			'ielts_pte_over' => $ielts_pte_over,
			'ielts_pte_not' => $ielts_pte_not,
			'ielts_pte_listening' => $ielts_pte_listening,
			'ielts_pte_reading' => $ielts_pte_reading,
			'ielts_pte_writing' => $ielts_pte_writing,
			'ielts_pte_speaking' => $ielts_pte_speaking,
			'ielts_pte_date' => $ielts_pte_date,			
			'ielts_pte_file' => $ielts_pte_file,			
		    'qualification1' => $rowstr['qualification1'],
		    'stream1' => $rowstr['stream1'],
		    'marks1' => $rowstr['marks1'],
		    'passing_year1' => $rowstr['passing_year1'],
		    'unicountry1' => $rowstr['unicountry1'],
		    'certificate1' => $certificate1,			
		    'uni_name1' => $rowstr['uni_name1'],
			'qualification2' => $rowstr['qualification2'],
		    'stream2' => $rowstr['stream2'],
		    'marks2' => $rowstr['marks2'],
		    'passing_year2' => $rowstr['passing_year2'],
		    'unicountry2' => $rowstr['unicountry2'],
		    'certificate2' => $certificate2,
		    'uni_name2' => $rowstr['uni_name2'],
			'qualification3' => $rowstr['qualification3'],
		    'stream3' => $rowstr['stream3'],
		    'marks3' => $rowstr['marks3'],
		    'passing_year3' => $rowstr['passing_year3'],
		    'unicountry3' => $rowstr['unicountry3'],
		    'certificate3' => $certificate3,
		    'uni_name3' => $rowstr['uni_name3'],
		    'campus' => $rowstr['campus'],
		    'prg_name1' => $rowstr['prg_name1'],
		    'prg_intake' => $rowstr['prg_intake']
		);
	}	
	echo json_encode($res1);
}


if($_GET['tag'] == "campusadd") {
	$campus = $_POST['campus'];
	$qury = "SELECT sno, intake FROM contract_courses WHERE campus = '$campus' group by intake";	
	$result1 = mysqli_query($con, $qury);
	while($rowstr = mysqli_fetch_array($result1)){
		$sno = $rowstr['sno'];
		$intake = $rowstr['intake'];
		
	$res1[] = array(
		'sno' => $sno,
		'intake' => $intake
	);
	}
	echo json_encode($res1);
}

if($_GET['tag'] == "corseadd") {
	$intake = $_POST['intake'];
	$campus = $_POST['campus'];
	$qury = "SELECT sno,program_name FROM contract_courses WHERE intake = '$intake' AND campus = '$campus' AND visible_status!='2'";	
	$result1 = mysqli_query($con, $qury);
	while($rowstr = mysqli_fetch_array($result1)){
		$sno = $rowstr['sno'];
		$program_name = $rowstr['program_name'];
		
	$res1[] = array(
		'sno' => $sno,
		'program_name' => $program_name
	);
	}
	echo json_encode($res1);
}

if($_GET['tag'] == "aol_agreement"){
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT sno,campus,prg_intake,prg_name1,contract_letter, contract_handbook_signed, agreement_loa,signed_agreement_letter,signed_al_status FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$sno = $rowstr['sno'];
		$campus1 = $rowstr['campus'];
		$prg_intake = $rowstr['prg_intake'];
		$prg_name1 = $rowstr['prg_name1'];		
		$agreement_loa = $rowstr['agreement_loa'];		
		$agreement_loa = $rowstr['agreement_loa'];		
		$contract_letter = $rowstr['contract_letter'];		
		$contract_handbook_signed = $rowstr['contract_handbook_signed'];		
		$signed_agreement_letter = $rowstr['signed_agreement_letter'];		
		$signed_al_status = $rowstr['signed_al_status'];

		if($campus1 == 'Toronto'){
			$form_action = 'contract.php';
		} 
		elseif($campus1 == 'Hamilton') {
			$form_action = 'contract_hamilton.php';
		}
		else{
			$form_action = 'contract.php';
		}			
		
		if($contract_letter == ''){
			$oldnl ='<form method="post" action="'.$form_action.'">		
		<input type="hidden" name="campus" value="'.$campus1.'">
		<input type="hidden" name="pn" value="'.$prg_name1.'">
		<input type="hidden" name="pro_name_dual" class="pro_name_dual" value="">
		<input type="hidden" name="pro_name_dual_sno" class="pro_name_dual_sno" value="">
		<input type="hidden" name="pro_name_dual_campus" class="pro_name_dual_campus" value="">
		<input type="hidden" name="tk" value="'.$prg_intake.'">
		<input type="hidden" name="snoid" value="'.$sno.'">
		<button class="btn btn-success btn-sm genrateloa" name="gnrtLoa">Generate Contract</button>
		</form>';
		}else{		
			$oldnl ='<form method="post" action="'.$form_action.'">
		<input type="hidden" name="campus" value="'.$campus1.'">	
		<input type="hidden" name="pn" value="'.$prg_name1.'">
		<input type="hidden" name="pro_name_dual" class="pro_name_dual" value="">
		<input type="hidden" name="pro_name_dual_sno" class="pro_name_dual_sno" value="">
		<input type="hidden" name="pro_name_dual_campus" class="pro_name_dual_campus" value="">
		<input type="hidden" name="tk" value="'.$prg_intake.'">
		<input type="hidden" name="snoid" value="'.$sno.'">
		<button class="btn btn-success btn-sm genrateloa" name="gnrtLoa">Re-Generate Contract</button>
		</form>';	
		}

		
		if($contract_letter == ''){
			$contract_download = "<span style='color:red;'>Pending</span>";
		}else{
			$contract_download = "<a href='$contract_letter' download>Download</a>";
		}
		
		if(!empty($contract_letter)){
			$handbook_download = "<a href='../../images/Student_Handbook.pdf' download>Download</a>";
		}else{
			$handbook_download = "<span style='color:red;'>Pending</span>";
		}	
		
		if($agreement_loa == '1'){
			$btnstatus = '<input type="submit" name="loabtn" class="btn btn-danger loaAgreeFun1" value="Contract Sent(Click to Cancel)" idno='.$sno.'>';	
		}else{
			$btnstatus = '<input type="submit" name="loabtn" class="btn btn-submit loaAgreeFun" value="Send Contract" idno='.$sno.'>';
		}
		if($signed_agreement_letter !== ''){
			$loaconfirm1 = "<a href='../../uploads/$signed_agreement_letter' download>Download</a>";
		}else{
			$loaconfirm1 = "<span style='color:red;'>Pending</span>";
		}

		if($contract_handbook_signed !== ''){
			$cnt_hb_signed = "<a href='../../uploads/$contract_handbook_signed' download>Download</a>";
		}else{
			$cnt_hb_signed = "<span style='color:red;'>Pending</span>";
		}
		
		$res1[] = array(
			'agree_download' => $oldnl,		    
			'contract_download' => $contract_download,		    
			'handbook_download' => $handbook_download,		    
			'btnstatus' => $btnstatus,   
			'loaconfirm1' => $loaconfirm1,
			'cnt_hb_signed' => $cnt_hb_signed
		);		
	}	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}


if($_GET['tag'] == "aol_agreement1"){
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT sno,signed_al_status,signed_al_remarks FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$signed_al_status = $rowstr['signed_al_status'];		
		$signed_al_remarks = $rowstr['signed_al_remarks'];
		if($signed_al_status == "Yes"){
			$sals = "<span style='color:green;'>Yes</span>";
		}
		if($signed_al_status == "No"){
			$sals = "<span style='color:red;'>No</span>";
		}
		if($signed_al_status == ""){
			$sals = "<span style='color:red;'>Pending</span>";
		}
		
		if($signed_al_status == ""){
			$salr = "<span style='color:red;'>Pending</span>";
		}else{
			$salr = $signed_al_remarks;
		}
		$res1[] = array(
			'sals' => $sals,
			'salr' => $salr
		);		
	}	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}


if($_GET['tag'] == "loaGenrate"){
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT sno, campus, prg_intake, prg_name1, ol_type, ol_type_remarks, ol_revised_date, ol_defer_date, loa_type, loa_file, loa_file_status, loa_file_status_date_by, loa_revised_date, loa_defer_date, loa_tt, file_receipt, loa_receipt_file, genrate_amount_loa, genrate_amount_loa_date, loa_receipt_id, college_tt, loa_receipt_file_admin, genrate_amount_loa_admin, genrate_amount_loa_date_admin, loa_receipt_id_admin FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$sno = $rowstr['sno'];
		$campus1 = $rowstr['campus'];
		$prg_intake = $rowstr['prg_intake'];
		$prg_name1 = $rowstr['prg_name1'];		
		$loa_file = $rowstr['loa_file'];				
		$loa_file_status = $rowstr['loa_file_status'];				
		$loa_file_status_date_by1 = $rowstr['loa_file_status_date_by'];				
		$loa_type = $rowstr['loa_type'];				
		$loa_revised_date = $rowstr['loa_revised_date'];				
		$loa_defer_date = $rowstr['loa_defer_date'];
		$ol_type = $rowstr['ol_type'];				
		$ol_revised_date = $rowstr['ol_revised_date'];				
		$ol_defer_date = $rowstr['ol_defer_date'];
		$ol_type_remarks = $rowstr['ol_type_remarks'];
		$loa_tt = $rowstr['loa_tt'];
		$file_receipt = $rowstr['file_receipt'];
		$loa_receipt_file = $rowstr['loa_receipt_file'];
		$genrate_amount_loa = $rowstr['genrate_amount_loa'];
		$genrate_amount_loa_date = $rowstr['genrate_amount_loa_date'];
		$loa_receipt_id = $rowstr['loa_receipt_id'];
		$college_tt = $rowstr['college_tt'];

		$loa_receipt_file_admin = $rowstr['loa_receipt_file_admin'];
		$genrate_amount_loa_admin = $rowstr['genrate_amount_loa_admin'];
		$genrate_amount_loa_date_admin = $rowstr['genrate_amount_loa_date_admin'];
		$loa_receipt_id_admin = $rowstr['loa_receipt_id_admin'];

		if($ol_type == ''){
			$ol_type_1 = '';
		}else{
			$ol_type_1 = "<p class='mt-0 mb-1'><b>COL Type: </b>$ol_type</p>";
		}
		
		if($ol_type_remarks == ''){
			$ol_type_remarks_1 = '';
		}else{
			$ol_type_remarks_1 = "<p class='mb-1'><b>COL Remarks: </b>$ol_type_remarks</p>";
		}
		 
		
		if($ol_type !== ''){
		if($ol_type == 'Revised'){
			$col_both_datetime = "<p class='mb-1'><b>COL Date: </b>$ol_revised_date</p>";
		}
		if($ol_type == 'Defer'){
			$col_both_datetime = "<p class='mb-1'><b>COL Date: </b>$ol_defer_date</p>";
		}
		}else{
			$col_both_datetime = '';
		}
		
		$col_type = $ol_type_1.' '.$ol_type_remarks_1.' '.$col_both_datetime;

		if($campus1 == 'Toronto'){
			$form_action = 'Letter_of_Acceptance.php';
		} 
		elseif($campus1 == 'Hamilton') {
			$form_action = 'Letter_of_Acceptance_hamilton.php';
		}
		else{
			$form_action = 'Letter_of_Acceptance.php';
		}
		
		if($loa_allow == '1'){
		if($loa_file == ''){
			$btnstatus ='<form method="post" action="'.$form_action.'">		
		<input type="hidden" name="campus" value="'.$campus1.'">
		<input type="hidden" name="pn" value="'.$prg_name1.'">
		<input type="hidden" name="tk" value="'.$prg_intake.'">
		<input type="hidden" name="snoid" value="'.$sno.'">
		<input type="hidden" name="loa_type" value="">
		<button class="btn btn-success btn-sm genrateloa" name="gnrtLoa">Generate LOA</button>
		</form>';		
		}else{		
			$btnstatus ='<form method="post" action="'.$form_action.'">
		<select class="col-sm-12 form-control mb-3 loaAlert" name="loa_type" required><option value="">Select Type</option><option value="Revised">Revised</option><option value="Defer">Defer</option></select>
		<input type="hidden" name="campus" value="'.$campus1.'">
		<input type="hidden" name="pn" value="'.$prg_name1.'">
		<input type="hidden" name="tk" value="'.$prg_intake.'">
		<input type="hidden" name="snoid" value="'.$sno.'">
		<button class="btn btn-success btn-sm genrateloa" name="gnrtLoa">Generate LOA</button>
		</form>';	
		}
		}else{
			$btnstatus ='';
		}
		
		if($loa_type == ''){
			$loa_type_1 = "<p class='mb-1'><b>LOA Type: </b><span style='color:red;'>Pending</span></p>";
		}else{
			$loa_type_1 = "<p class='mb-1'><b>LOA Type: </b>$loa_type</p>";
		}
		
		if($loa_type !== ''){
		if($loa_type == 'Revised'){
			$both_datetime = "<p class='mb-1'><b>LOA Date: </b>$loa_revised_date</p>";
		}
		if($loa_type == 'Defer'){
			$both_datetime = "<p class='mb-1'><b>LOA Date: </b>$loa_defer_date</p>";
		}
		}else{
			$both_datetime = '';
		}
		
		if($loa_file == ''){
			$Loadownload_1 = "<span style='color:red;'>Pending</span>";
		}else{
			$Loadownload_1 = "<a href='$loa_file' download>Download</a> ";
		}
		
		$Loadownload = $Loadownload_1.' '.$both_datetime;
		
		if($loa_allow == '1'){
		if($loa_file_status == '1'){
			$btnstatus2 = '<input type="submit" class="btn btn-danger loastatusFun1" value="Cancel LOA Status" idno='.$sno.'>';	
		}else{
			$btnstatus2 = '<input type="submit" class="btn btn-submit loastatusFun" value="Send LOA Status" idno='.$sno.'>';
		}
		}else{
			$btnstatus2 ='';
		}
		
		
		if($loa_file_status_date_by1 == ''){
			$loa_file_status_date_by = "<span style='color:red;'>N/A</span>";
		}else{
			$loa_file_status_date_by = "<span style='color:green;'>$loa_file_status_date_by1</span>";
		}
		
		if($loa_file_status == ''){
			$loa_status = "<span style='color:red;'>Pending</span>";
		}else{
			$loa_status = "<span style='color:green;'>Verified</span>";
		}
		
		if($loa_receipt_id !=''){
			$loa_receipt_id_1 = "<p class='mb-1'><b>Receipt Id: </b>$loa_receipt_id</p>";
		}else{
			$loa_receipt_id_1 = '<p class="mb-1"><b>Receipt Id: </b><span style="color:red;">N/A</span></p>';
		}
		
		if($genrate_amount_loa !=''){
			$genrate_amount_loa_1 = "<p class='mb-1'><b>Amount: </b>$ $genrate_amount_loa</p>";
		}else{
			$genrate_amount_loa_1 = '<p class="mb-1"><b>Amount: </b><span style="color:red;">N/A</span></p>';
		}
			
		if($loa_receipt_file !=''){
			$loa_receipt_file_1 = "<p class='mb-1'><b>Receipt: </b><a href='../uploads/$loa_receipt_file' download>Download</a></p>";
		}else{
			$loa_receipt_file_1 = '<p class="mb-1"><b>Receipt: </b><span style="color:red;">N/A</span></p>';
		}
		
		if($genrate_amount_loa_date !=''){
			$genrate_amount_loa_date_1 = "<p class='mb-1'><b>Updated On: </b>$genrate_amount_loa_date</p>";
		}else{
			$genrate_amount_loa_date_1 = '<p class="mb-1"><b>Updated On: </b><span style="color:red;">N/A</span></p>';
		}		
		
		if($loa_allow == '1'){
		// if(empty($college_tt)){
		if($file_receipt == '1' && $loa_tt == '' && $college_tt == ''){
		if($loa_receipt_file == ''){		
		
		$btnstatus_3 ='<h5 style=" color:#28a745"><b>Receipt No. 1st: </b></h5><form method="post" class="row" action="loa_tt_receipt.php" autocomplete="off">
			<div class="col-sm-7">
			<input type="number" name="genrate_amount_loa" class="form-control" placeholder="Enter Receipt Amount" required>
			<input type="hidden" name="campus" value="'.$campus1.'">
			<input type="hidden" name="pn" value="'.$prg_name1.'">
		<input type="hidden" name="tk" value="'.$prg_intake.'">
		<input type="hidden" name="snoid" value="'.$sno.'">
		</div>
		<div class="col-sm-5">
		<button class="btn btn-success btn-sm genrateloa" name="gnrtLoa">1st Generate Receipt</button></div>
		</form>';
		
		$loa_fee_receipt_btn = '';
		
		}else{
			$btnstatus_3 ='<h5 style=" color:#28a745"><b>Receipt No. 1st: </b></h5><form method="post" class="row" action="loa_tt_receipt.php" autocomplete="off">
				<div class="col-sm-7">
				<input type="number" name="genrate_amount_loa" class="form-control" placeholder="Enter Receipt Amount" required>
			<input type="hidden" name="campus" value="'.$campus1.'">
			<input type="hidden" name="pn" value="'.$prg_name1.'">
			<input type="hidden" name="tk" value="'.$prg_intake.'">
			<input type="hidden" name="snoid" value="'.$sno.'">
			</div>
		<div class="col-sm-5">
		<button class="btn btn-success btn-sm genrateloa py-2" name="gnrtLoa">1st Generate Receipt</button>
		</div>
		</form>';
		
		
		
		$loa_fee_receipt_btn = $loa_receipt_id_1.' '.$genrate_amount_loa_1.' '.$loa_receipt_file_1.' '.$genrate_amount_loa_date_1;
		
		}			
		}else{		
			$btnstatus_3 ='';
			$loa_fee_receipt_btn = '';
		}
		// }else{
			// $btnstatus_3 ='';
			// $loa_fee_receipt_btn = '';
		// }
		}else{
			$btnstatus_3 ='';
			$loa_fee_receipt_btn = '';
		}

//start Only Admin loa_allow=1 show //

	if($loa_allow == '1'){
		if($file_receipt == '1' && $loa_tt == '' && $college_tt == ''){
			$btnstatus_44 ='<h5 style=" color:#28a745"><b>Receipt No. 2nd: </b></h5><form method="post"  class="row" action="loa_tt_receipt_admin.php" autocomplete="off">
			<div class="col-sm-7">
			<input type="number" name="genrate_amount_loa_admin" class="form-control" placeholder="Enter Receipt Amount" required>
			<input type="hidden" name="campus" value="'.$campus1.'">
			<input type="hidden" name="pn" value="'.$prg_name1.'">
			<input type="hidden" name="tk" value="'.$prg_intake.'">
			<input type="hidden" name="snoid" value="'.$sno.'">
			</div><div class="col-sm-5">
			<button class="btn btn-success btn-sm genrateloa py-2" name="gnrtLoa">2nd Generate Receipt</button>
		</div>
		</form>';

		if($loa_receipt_id_admin !=''){
			$loa_receipt_id_admin_1 = "<p class='mb-1'><b>Receipt Id: </b>$loa_receipt_id_admin</p>";
		}else{
			$loa_receipt_id_admin_1 = '<p class="mb-1"><b>Receipt Id: </b><span style="color:red;">N/A</span></p>';
		}
		
		if($genrate_amount_loa_admin !=''){
			$genrate_amount_loa_admin_1 = "<p class='mb-1'><b>Amount: </b>$ $genrate_amount_loa_admin</p>";
		}else{
			$genrate_amount_loa_admin_1 = '<p class="mb-1"><b>Amount: </b><span style="color:red;">N/A</span></p>';
		}
			
		if($loa_receipt_file_admin !=''){
			$loa_receipt_file_admin_1 = "<p class='mb-1'><b>Receipt: </b><a href='../uploads/$loa_receipt_file_admin' download>Download</a></p>";
		}else{
			$loa_receipt_file_admin_1 = '<p class="mb-1"><b>Receipt: </b><span style="color:red;">N/A</span></p>';
		}
		
		if($genrate_amount_loa_date_admin !=''){
			$genrate_amount_loa_date_admin_1 = "<p class='mb-1'><b>Updated On: </b>$genrate_amount_loa_date_admin</p>";
		}else{
			$genrate_amount_loa_date_admin_1 = '<p class="mb-1"><b>Updated On: </b><span style="color:red;">N/A</span></p>';
		}

		$btnstatus_4 = $btnstatus_44.' '.$loa_receipt_id_admin_1.' '.$genrate_amount_loa_admin_1.' '.$loa_receipt_file_admin_1.' '.$genrate_amount_loa_date_admin_1;

		}else{
			$btnstatus_4 = '';
		}
		
		}else{
			$btnstatus_4 = '';
		}

//End Only Admin loa_allow=1 show ///
		
		if($college_tt !=''){
			$college_tt_1 = "<p class='mb-1'><b>Receipt: </b><a href='../../uploads/$college_tt' download>Download</a></p>"; //College TT
		}else{
			$college_tt_1 = '';
		}
		
		$btnstatus_33 = $college_tt_1.' '.$btnstatus_3;
		
		$res1[] = array(	    
			'col_type' => $col_type,   
			'btnstatus' => $btnstatus,   
			'loa_type' => $loa_type_1,
			'Loadownload' => $Loadownload,
			'btnstatus2' => $btnstatus2,
			'loa_file_status_date_by' => $loa_file_status_date_by,
			'loa_status' => $loa_status,
			'btnstatus_3' => $btnstatus_33,
			'loa_fee_receipt_btn' => $loa_fee_receipt_btn,
			'btnstatus_4' => $btnstatus_4
		);		
	}	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}


if($_GET['tag'] == "chkofferclass") {
	$idno = $_POST['idno'];	
	$get_query = mysqli_query($con, "SELECT sno, campus, prg_name1, prg_intake, ol_confirm, offer_letter, ol_type, ol_revised_date, ol_defer_date, ol_type_remarks FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$sno = $rowstr['sno'];
	$campus1 = $rowstr['campus'];
	$prg_name1 = $rowstr['prg_name1'];
	$prg_intake = $rowstr['prg_intake'];	
	$ol_confirm = $rowstr['ol_confirm'];
	$offer_letter_new = $rowstr['offer_letter'];
	
	$ol_type = $rowstr['ol_type'];				
	$ol_revised_date = $rowstr['ol_revised_date'];				
	$ol_defer_date = $rowstr['ol_defer_date'];
	$ol_type_remarks = $rowstr['ol_type_remarks'];

	if($campus1 == 'Toronto'){
		$form_action = 'offer_letter.php';
	} 
	elseif($campus1 == 'Hamilton') {
		$form_action = 'offer_letter_hamilton.php';
	}
	else{
		$form_action = 'offer_letter.php';
	}
	
	if($offer_letter_new == ''){
		$linkpdf ='<form method="post" action="'.$form_action.'">		
		<input type="hidden" name="campus" value="'.$campus1.'">
		<input type="hidden" name="pn" value="'.$prg_name1.'">
		<input type="hidden" name="tk" value="'.$prg_intake.'">
		<input type="hidden" name="snoid" value="'.$sno.'">
		<input type="hidden" name="ol_type" value="">
		<input type="hidden" name="ol_type_remarks" value="">
		<button class="btn btn-success btn-sm genrateloa" name="gnrtLoa">Generate Offer Letter</button>
		</form>';	
	}else{
		$linkpdf ='<form method="post" action="'.$form_action.'">
		<select class="col-sm-12 form-control mb-3 colAlert" name="ol_type" required><option value="">Select Type</option><option value="Revised">Revised</option><option value="Defer">Defer</option></select>
		<p class="mb-0"><b>Remarks: </b></p>
		<textarea name="ol_type_remarks" class="col-sm-12 form-control mb-3" required></textarea>
		<input type="hidden" name="campus" value="'.$campus1.'">
		<input type="hidden" name="pn" value="'.$prg_name1.'">
		<input type="hidden" name="tk" value="'.$prg_intake.'">
		<input type="hidden" name="snoid" value="'.$sno.'">
		<button class="btn btn-success btn-sm genrateloa" name="gnrtLoa">Re-Generate Offer Letter</button>
		</form>';
	}
	
	if($ol_type == ''){
		$ol_type_1 = "<p><b>COL Type: </b><span style='color:red;'>Pending</span></p>";
	}else{
		$ol_type_1 = "<p><b>COL Type: </b>$ol_type</p>";
	}
	
	if($ol_type_remarks == ''){
		$ol_type_remarks_1 = '';
	}else{
		$ol_type_remarks_1 = "<p><b>COL Remarks: </b>$ol_type_remarks</p>";
	}
		
	if($ol_type !== ''){
	if($ol_type == 'Revised'){
		$ol_both_datetime = "<p><b>COL Date: </b>$ol_revised_date</p>";
	}
	
	if($ol_type == 'Defer'){
		$ol_both_datetime = "<p><b>COL Date: </b>$ol_defer_date</p>";
	}
	}else{
		$ol_both_datetime = '';
	}
	
	
	if($offer_letter_new == ''){
		$ol_download_1 = "<span style='color:red;'>Pending</span>";
	}else{
		$ol_download_1 = "<a href='$offer_letter_new' download>Download</a>";
	}
	
	$ol_download = $ol_download_1.' '.$ol_type_remarks_1.' '.$ol_both_datetime;
	
		
	if($ol_confirm == '1'){
		$col = "<span style='color:green;'>Sent</span>";	
	}else{
		$col = "<span style='color:red;'>Pending</span>";	
	}	
	
	if($ol_confirm == '1'){
		$btnstatus = '<input type="submit" name="olbtn" class="btn btn-danger btn-sm cnfmFun1" value="Cancel offer Letter" idno='.$sno.'>';	
	}else{
		$btnstatus = '<input type="submit" name="olbtn" class="btn btn-submit cnfmFun" value="Send offer Letter" idno='.$sno.'>';
	}		
	
	$res1[] = array(
		'linkpdf' => $linkpdf,
		'btnstatus' => $btnstatus,
		'ol_type' => $ol_type_1,
		'ol_download' => $ol_download,
		'col' => $col
	);	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


if($_GET['tag'] == "signedconfirm") {
	$idno = $_POST['idno'];	
	$get_query = mysqli_query($con, "SELECT sno,signed_ol_confirm,signed_ol_remarks,agreement FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
		$sno = $rowstr['sno'];
		$agreement = $rowstr['agreement'];
		$signed_ol_confirm = $rowstr['signed_ol_confirm'];
		$signed_ol_remarks = $rowstr['signed_ol_remarks'];
		
		if($agreement !== ''){
			$agl = "<a href='../../uploads/$agreement' download> Download</a>";	
		}else{
			$agl = "<span style='color:red;'> pending</span>";
		}
		if($signed_ol_confirm == 'Yes'){
			$scol = "<span style='color:green;'>$signed_ol_confirm</span>";	
		}
		if($signed_ol_confirm == 'No'){
			$scol = "<span style='color:red;'>$signed_ol_confirm</span>";	
		}
		if($signed_ol_confirm == ''){
			$scol = "<span style='color:red;'>Pending</span>";	
		}
		
		if($signed_ol_confirm == 'Yes' || $signed_ol_confirm == 'No'){
			$remarks = $signed_ol_remarks;
		}else{
			$remarks = "<span style='color:red;'>Pending</span>";
		}
		
		$res1[] = array(
			'agl' => $agl,
		    'scol' => $scol,
		    'remarks' => $remarks		    
		);	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


if($_GET['tag'] == "chktuitionclass") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT sno,tuition_fee FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$sno = $rowstr['sno'];
		$tuition_fee = $rowstr['tuition_fee'];
		if($tuition_fee !== ''){
			$oldnl = "<a href='../../uploads/$tuition_fee' download>Download Tuition Fee Letter</a>";	
		}else{
			$oldnl = "<span style='color:red;'>Not Uploaded</span>";
		}
		
		$res1[] = array(
		    'sno' => $sno,
		    'tuition_fee' => $oldnl
		);		
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "confirmbtn_ol") {
	$idno = $_POST['idno'];
	
	$delete_foldr=mysqli_query($con, "SELECT sno,user_id,refid,fname,lname FROM st_application where sno='$idno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	$user_id = $dltlist['user_id'];		
	$sno = $dltlist['sno'];
	$refid = $dltlist['refid'];
	$fullname = $dltlist['fname'].' '.$dltlist['lname'];
	$date = date('Y-m-d H:i:s');
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$adminrole1', '$sno', '$fullname', '$user_id', '$refid', 'Conditional Offer Letter Sent', 'Conditional Offer Letter', 'application?aid=error_$sno', '1', '$date')");
	
	mysqli_query($con, "update `st_application` set `ol_confirm`='1', `offer_letter_sent_datetime`='$updated_by' where `sno`='$idno'");	
	echo 1;	
}

if($_GET['tag'] == "confirmbtn_ol1") {
	$idno = $_POST['idno'];
	
	//$delete_foldr=mysqli_query($con, "SELECT sno,user_id,refid,fname,lname FROM st_application where sno='$idno'");
//	$dltlist = mysqli_fetch_assoc($delete_foldr);
//	$user_id = $dltlist['user_id'];		
//	$sno = $dltlist['sno'];
//	$refid = $dltlist['refid'];
//	$fullname = $dltlist['fname'].' '.$dltlist['lname'];
//	$date = date('Y-m-d H:i:s');
//	
//	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$adminrole1', '$sno', '$fullname', '$user_id', '$refid', 'Conditional Offer Letter Status Updated By AOL', 'Sent Conditional Offer Letter', 'application?aid=error_$sno', '1', '$date')");
	
	mysqli_query($con, "update `st_application` set `ol_confirm`='', `offer_letter_sent_datetime`='$updated_by' where `sno`='$idno'");	
	echo 1;
}

if($_GET['tag'] == "contratStatus") {
	$idno = $_POST['idno'];
	
	$delete_foldr=mysqli_query($con, "SELECT sno,user_id,refid,fname,lname FROM st_application where sno='$idno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	$user_id = $dltlist['user_id'];		
	$sno = $dltlist['sno'];
	$refid = $dltlist['refid'];
	$fullname = $dltlist['fname'].' '.$dltlist['lname'];
	$date = date('Y-m-d H:i:s');
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$adminrole1', '$sno', '$fullname', '$user_id', '$refid', 'Contract Sent', 'Contract Sent', 'application?aid=error_$sno', '1', '$date')");
	
	mysqli_query($con, "update `st_application` set `agreement_loa`='1', `aol_contract_sent_datetime`='$updated_by' where `sno`='$idno'");	
	echo 1;
}
if($_GET['tag'] == "contratStatus1") {
	$idno = $_POST['idno'];
	
	//$delete_foldr=mysqli_query($con, "SELECT sno,user_id,refid,fname,lname FROM st_application where sno='$idno'");
//	$dltlist = mysqli_fetch_assoc($delete_foldr);
//	$user_id = $dltlist['user_id'];		
//	$sno = $dltlist['sno'];
//	$refid = $dltlist['refid'];
//	$fullname = $dltlist['fname'].' '.$dltlist['lname'];
//	$date = date('Y-m-d H:i:s');
//	
//	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$adminrole1', '$sno', '$fullname', '$user_id', '$refid', 'Contract Status Updated By AOL', 'Sent Contract Status', 'application?aid=error_$sno', '1', '$date')");
	
	mysqli_query($con, "update `st_application` set `agreement_loa`='', `aol_contract_sent_datetime`='$updated_by' where `sno`='$idno'");	
	echo 1;
}

if($_GET['tag'] == "loaStatus") {
	$idno = $_POST['idno'];
	
	$delete_foldr=mysqli_query($con, "SELECT sno,user_id,refid,fname,lname FROM st_application where sno='$idno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	$user_id = $dltlist['user_id'];		
	$sno = $dltlist['sno'];
	$refid = $dltlist['refid'];
	$fullname = $dltlist['fname'].' '.$dltlist['lname'];
	$date = date('Y-m-d H:i:s');
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$adminrole1', '$sno', '$fullname', '$user_id', '$refid', 'LOA Sent', 'LOA Sent', 'application?aid=error_$sno', '1', '$date')");
	
	mysqli_query($con, "update `st_application` set `loa_file_status`='1',`loa_file_status_by`='$Loggedemail', `loa_file_status_date_by`='$updated_by' where `sno`='$idno'");	
	echo 1;
}

if($_GET['tag'] == "loaStatus1") {
	$idno = $_POST['idno'];
	mysqli_query($con, "update `st_application` set `loa_file_status`='',`loa_file_status_by`='$Loggedemail', `loa_file_status_date_by`='$updated_by', `follow_status`='0' where `sno`='$idno'");

//Followup
	mysqli_query($con, "update `followup` set `fstatus`='0', `updated`='$updated_by' where `st_app_id`='$idno'");
	
	echo 1;
}

if($_GET['tag'] == "notifyfilter"){	
	$status1 = $_POST['status1'];
			
		if($status1 == 'crt_Application'){
			$as = "notification_aol.stage = 'Application Created'";			
		}		
		if($status1 == 'signed_ol'){
			$as = "notification_aol.stage = 'Signed Conditional Offer Letter'";			
		}
		elseif($status1 == 'rqst_loa'){
			$as = "notification_aol.stage = 'LOA Request'";			
		}
		elseif($status1 == 'signed_cntrt'){
			$as = "notification_aol.stage = 'Signed Contract'";
		}
		elseif($status1 == 'Commission_Proccessed_by_Processor'){
			$as = "notification_aol.post = 'Commission Proccessed by Processor'";
		}
		elseif($status1 == 'Commission_Not_Approved_by_Processor'){
			$as = "notification_aol.post = 'Commission Not Approved by Processor'";
		}
		elseif($status1 == 'Refund_Form'){
			$as = "notification_aol.stage = 'Refund Form'";
		}
		elseif($status1 == 'For_Refund_Docs_Approved'){
			$as = "notification_aol.post = 'For Refund Docs Approved'";
		}
		elseif($status1 == 'For_Refund_Docs_Not_Approved'){
			$as = "notification_aol.post = 'For Refund Docs Not Approved'";
		}		
		elseif($status1 == 'Status_changed_to_VG'){
			$as = "notification_aol.stage = 'V-G'";
		}
		elseif($status1 == 'Status_changed_to_VR'){
			$as = "notification_aol.stage = 'V-R'";
		}
		elseif($status1 == 'Commission_Details_Updated'){
			$as = "notification_aol.post = 'Commission Details Updated'";
		}
		elseif($status1 == 'COMMISSION_Details_Remarks_For_Admin'){
			$as = "notification_aol.stage = 'COMMISSION Details'";
		}		
		elseif($status1 == 'Refund_Documents_Status'){
			$as = "notification_aol.stage = 'Refund Documents Status'";
		}
		
		// echo $as; 
		// die;
		
	if($adminrole1 == "Excu"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type1 = "AND notification_aol.clg_pr_type = 'excu'";
	}
	if($adminrole1 == "Admin"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type1 = "AND notification_aol.clg_pr_type = 'admin'";
	}
	if($adminrole1 == "Admin" && $notify_per1 == "1" && $report_allow1 == "1"){
		$agent_noti = "(notification_aol.role='Agent') AND";
		$clg_pr_type1 = " AND (notification_aol.clg_pr_type = 'admin' OR notification_aol.clg_pr_type = 'excu')";
	}
	if($adminrole1 == "Admin" && $notify_per1 == "" && $report_allow1 == ""){
		// $clg_pr_type1 = " AND (notification_aol.clg_pr_type = 'admin' OR notification_aol.clg_pr_type = 'excu')";
		$agent_noti = '';
		$clg_pr_type1 = " AND (notification_aol.role = 'Admin') AND (notification_aol.report_noti='Yes')";
	}
	
	$rsltQuery = "(SELECT allusers.username,notification_aol.sno, notification_aol.fullname, notification_aol.refid, notification_aol.post, notification_aol.stage, notification_aol.url, notification_aol.status, notification_aol.created, notification_aol.bgcolor, notification_aol.action_taken
FROM notification_aol
INNER JOIN allusers ON notification_aol.agent_id=allusers.sno 
where $agent_noti notification_aol.action_taken !='Yes' $clg_pr_type1 AND $as) ORDER BY notification_aol.status DESC, notification_aol.sno DESC";


	$qurySql = mysqli_query($con, $rsltQuery);	
	while ($row_nm = mysqli_fetch_assoc($qurySql)){		
		 $sno = mysqli_real_escape_string($con,$row_nm['sno']);
		 $username = mysqli_real_escape_string($con,$row_nm['username']);
		 $fullname = mysqli_real_escape_string($con,$row_nm['fullname']);
		 $refid = mysqli_real_escape_string($con,$row_nm['refid']);
		 $post = mysqli_real_escape_string($con,$row_nm['post']);
		 $stage = mysqli_real_escape_string($con,$row_nm['stage']);
		 $url = mysqli_real_escape_string($con, $row_nm['url']);
		 $bgcolor = mysqli_real_escape_string($con,$row_nm['bgcolor']);
		 $action_taken = mysqli_real_escape_string($con,$row_nm['action_taken']);
		 $created = mysqli_real_escape_string($con,$row_nm['created']);
		 $time = date('jS F, Y h:i:s A', strtotime("$created"));
		 
		 if($bgcolor == '#f9f3f3'){
				$actiontab = '<a href="../'.$url.'&noti='.$sno.'" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="View Status"><i class="fa fa-eye"></i></a>';
				$actiontab1 = '<a href="../'.$url.'&takenid='.$sno.'" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Action Taken"><i class="fa fa-edit"></i></a>';
			}else{
				$actiontab = '<a href="../'.$url.'&noti='.$sno.'" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="View Status"><i class="fa fa-eye"></i></a>';
				$actiontab1 = '<a href="../'.$url.'&takenid='.$sno.'" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Action Taken"><i class="fa fa-edit"></i></a>';				
			}
	
		$res1[] = array(	    
			'bgcolor' => $bgcolor,   
			'username' => $username,   
			'fullname' => $fullname,
			'refid' => $refid,
			'post' => $post,
			'stage' => $stage,
			'created' => $time,
			'actiontab' => $actiontab,
			'actiontab1' => $actiontab1
		);
	}
	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "loaFee"){	
	$idno = $_POST['idno'];
	$delete_foldr=mysqli_query($con, "SELECT loa_tt,prepaid_fee,prepaid_remarks FROM st_application where sno='$idno'");
	$row_nm = mysqli_fetch_assoc($delete_foldr);
	$prepaid_fee1 = mysqli_real_escape_string($con, $row_nm['prepaid_fee']);
	$prepaid_remarks1 = mysqli_real_escape_string($con, $row_nm['prepaid_remarks']);
	$loa_tt = mysqli_real_escape_string($con, $row_nm['loa_tt']);
	if($prepaid_fee1 == ''){
		$prepaid_fee = '<span style="color:red;">Pending</span>';
	}
	if($prepaid_fee1 == 'No'){
		$prepaid_fee = '<span style="color:green;">No</span>';
	}
	if($prepaid_fee1 == 'Yes'){
		$prepaid_fee = '<span style="color:green;">Yes</span>';
	}
	
	if($prepaid_remarks1 !== ''){
		$prepaid_remarks = $prepaid_remarks1;
	}else{
		$prepaid_remarks = '<span style="color:red;">N/A</span>';;
	}
	
	if($loa_tt !== ''){
		$loa_tt_1 = "<p><b>TT By Agent: </b><a href='../../uploads/$loa_tt' download> Download</a></p>";	
	}else{
		$loa_tt_1 = '';
	}
	
	$prepaid_remarks_1 = $prepaid_remarks.' '.$loa_tt_1;
	
	
	$res1[] = array(	    
		'prepaidFee' => $prepaid_fee,
		'pfr' => $prepaid_remarks_1
	);
	
	echo json_encode($res1);
}

if($_GET['tag'] === "followupFun"){
	$idno = $_POST['idno'];
	$fdatetime = $_POST['fdatetime'];
	$fremarks = $_POST['fremarks'];
	$fstage = $_POST['fstage'];
	$flowdrp = $_POST['flowdrp'];
	if($flowdrp == 'Drop'){
		$fstatus = '0';
	}else{
		$fstatus = '1';	
	}
	
	$queryFollow = "INSERT INTO `followup` (`st_app_id`, `fstatus`, `fdatetime`, `fremarks`, `fstage`, `flowdrp`, `created`, `updated`) VALUES ('$idno', '$fstatus', '$fdatetime', '$fremarks', '$fstage', '$flowdrp', '$updated_by', '$updated_by')";
	mysqli_query($con, $queryFollow);
		
	mysqli_query($con, "update `st_application` set `flowdrp`='$flowdrp', `follow_name`='$Loggedemail', `follow_sno`='$sessionSno', `follow_status`='$fstatus', `follow_next_date`='$fdatetime', `follow_stage`='$fstage', `follow_fremarks`='$fremarks', `follow_created`='$updated_by' where `sno`='$idno'");
	
	$delete_foldr=mysqli_query($con, "SELECT sno,user_id,refid,fname,lname FROM st_application where sno='$idno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	$user_id = $dltlist['user_id'];		
	$sno = $dltlist['sno'];
	$refid = $dltlist['refid'];
	$fullname = $dltlist['fname'].' '.$dltlist['lname'];
	$date = date('Y-m-d H:i:s');
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$adminrole1', '$sno', '$fullname', '$user_id', '$refid', 'Follow Up($fstage)', 'Follow Up', 'application?aid=error_$sno', '1', '$date')");	
	
	echo 1;
}

if($_GET['tag'] === "followSearch"){
	$follow_from1 = $_POST['follow_from'];
	$follow_to1 = $_POST['follow_to'];
	$followup = $_POST['followup'];
	
	$flag = 0;	
	if(!empty($follow_from1) || !empty($follow_to1)){
		$flag = 1;			
		if(!empty($follow_from1) && empty($follow_to1)){
			$follow_date = "`follow_created` LIKE '%$follow_from1%'";
		}
		if(empty($follow_from1) && !empty($follow_to1)){
			$follow_date = "`follow_created` LIKE '%$follow_to1%'";
		}
		if(!empty($follow_from1) && !empty($follow_to1)){
			$follow_date = "follow_created BETWEEN '$follow_from1' AND '$follow_to1'";
		}		
	}else{
		$follow_date = '';
	}
	
	if(!empty($_POST['followup'])){
		if ($flag == 1){
			$stage = "AND follow_stage = '$followup'";
			
			// if($followup == 'File_Not_Lodged'){
				// $stage = "AND (follow_stage = 'V-G' OR follow_stage = 'V-R')";
			// }else{
				// $stage = "AND follow_stage = '$followup'";
			// }
			
		}else{
			$stage = "follow_stage = '$followup'";
			
			// if($followup == 'File_Not_Lodged'){
				// $stage = "(follow_stage = 'V-G' OR follow_stage = 'V-R')";
			// }else{
				// $stage = "follow_stage = '$followup'";
			// }
			
			$flag = 1;
		}		
		
	}else{
		$stage = '';
	}
	
	
	
	$rsltQuery = "SELECT * FROM st_application where follow_status='1' AND flowdrp!='Drop' AND $follow_date $stage";
	// die;
	$qurySql = mysqli_query($con, $rsltQuery);	
	while ($row_nm = mysqli_fetch_assoc($qurySql)){
		$sno = $row_nm['sno'];
		$agent_id = $row_nm['user_id'];
		
		$agent_query = "select sno, username from allusers where sno ='$agent_id'";
		$agent_res = mysqli_query($con, $agent_query);
		$agent_row_data = mysqli_fetch_assoc($agent_res);
		$agent_name = $agent_row_data['username'];
		
		$action = "<a href='../application?aid=error_$sno' class='btn btn-success' title='View Profile'><i class='fa fa-eye'></i></a>";
		$action1 = "<a href='javascript:void(0)' class='btn btn-warning logFollow' data-target='#logFollowModel' data-toggle='modal' data-id='$sno'>Logs</a>";
		
		$studentname1 = $row_nm['fname'].' '.$row_nm['lname'];
		$studentname = "<a href='../followup/add.php?stusno=$sno' target='_blank'>$studentname1</a>";
		
		$refid = $row_nm['refid'];
		$follow_name = $row_nm['follow_name'];
		$follow_status = $row_nm['follow_status'];
		if($follow_status == '1'){
			$fstatus = 'Follow';
		}
		if($follow_status == '0'){
			$fstatus = 'DONE';
		}
		if($follow_status == ''){
			$fstatus = 'N/A';
		}		
		
		$follow_next_date = $row_nm['follow_next_date'];
		$follow_stage = $row_nm['follow_stage'];
		$follow_fremarks = $row_nm['follow_fremarks'];
		$follow_created = $row_nm['follow_created'];
		
		$res1[] = array(    
			'agent_name' => $agent_name,
			'follow_name' => $follow_name,
			'studentname' => $studentname,
			'refid' => $refid,
			'fstatus' => $fstatus,
			'follow_next_date' => $follow_next_date,
			'follow_stage' => $follow_stage,
			'follow_fremarks' => $follow_fremarks,
			'follow_created' => $follow_created,
			'action' => $action,
			'action1' => $action1
		);		
	}
	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "followElement"){	
	$idno = $_POST['idno'];
	$query = mysqli_query($con, "SELECT * FROM followup where st_app_id='$idno'");
	while ($row_nm = mysqli_fetch_assoc($query)){
	$follow_status = mysqli_real_escape_string($con, $row_nm['fstatus']);
	if($follow_status == '1'){
		$fstatus = 'Follow Up';
	}
	if($follow_status == '0'){
		$fstatus = 'Drop';
	}
	if($follow_status == ''){
		$fstatus = 'N/A';
	}	
	
	$fdatetime = mysqli_real_escape_string($con, $row_nm['fdatetime']);
	$fremarks = mysqli_real_escape_string($con, $row_nm['fremarks']);
	$fstage = mysqli_real_escape_string($con, $row_nm['fstage']);
	$created = mysqli_real_escape_string($con, $row_nm['created']);
	$updated = mysqli_real_escape_string($con, $row_nm['updated']);	
	
	$res1[] = array(	    
		'fstatus' => $fstatus,
		'fdatetime' => $fdatetime,
		'fremarks' => $fremarks,
		'fstage' => $fstage,
		'created' => $created,
		'updated' => $updated
	);
	}
	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] === "followriminder"){
	$followstage = $_POST['followstage'];
	
	$query = "SELECT * FROM stage_age_report where status='$followstage'";
	$query1 = mysqli_query($con, $query);
	$row_nm = mysqli_fetch_assoc($query1);
	$days1 = mysqli_real_escape_string($con, $row_nm['days']);
		
	$newDate = date("Y-m-d",strtotime($updated_by."-$days1 DAYS"));	
	
	if($followstage == 'Profile_stage'){
		$reminterstr = "SELECT * FROM st_application where (application_status_datetime !='' and application_status_datetime < '$newDate') AND admin_status_crs='No' AND flowdrp!='Drop' AND follow_status!='1'";	
	}
		
	if($followstage == 'Conditional_Offer_letter'){
		$reminterstr = "SELECT * FROM st_application where (offer_letter_sent_datetime !='' and offer_letter_sent_datetime < '$newDate') AND agreement='' AND ol_confirm='1' AND flowdrp!='Drop' AND follow_status!='1'";	
	}	
	
	if($followstage == 'LOA_Request'){	
		$reminterstr = "SELECT * FROM st_application where signed_ol_confirm='Yes' and (offer_letter_status_datetime !='' and offer_letter_status_datetime < '$newDate') AND file_receipt='' AND flowdrp!='Drop' AND follow_status!='1'";	
	}
	
	if($followstage == 'Contract_Stage'){
		$reminterstr = "SELECT * FROM st_application where (aol_contract_sent_datetime!='' and aol_contract_sent_datetime < '$newDate') AND signed_agreement_letter='' AND agreement_loa='1' AND flowdrp!='Drop' AND follow_status!='1'";
	}
	
	if($followstage == 'FH_Sent'){	
		$reminterstr = "SELECT * FROM st_application where (loa_file_status_date_by!='' and loa_file_status_date_by < '$newDate') AND fh_status='' AND flowdrp!='Drop' AND follow_status!='1'";	
	}		
	if($followstage == 'VG_VR'){	
		$reminterstr = "SELECT * FROM st_application where (fh_status_updated_by!='' and fh_status_updated_by < '$newDate') AND fh_status='1' AND v_g_r_status='' AND flowdrp!='Drop' AND follow_status!='1'";	
	}
	
	// print_r($reminterstr);
	// die;
	
	$queryReminder = mysqli_query($con, $reminterstr);	
	while ($row_nm = mysqli_fetch_assoc($queryReminder)){
		$ssno = mysqli_real_escape_string($con, $row_nm['sno']);
		$user_id = mysqli_real_escape_string($con, $row_nm['user_id']);
		$fname = mysqli_real_escape_string($con, $row_nm['fname']);			
		$lname = mysqli_real_escape_string($con, $row_nm['lname']);
		$student_name = $fname.' '.$lname;
		$refid = mysqli_real_escape_string($con, $row_nm['refid']);
		$application_status_datetime = mysqli_real_escape_string($con, $row_nm['application_status_datetime']);
		$offer_letter_sent_datetime = mysqli_real_escape_string($con, $row_nm['offer_letter_sent_datetime']);
     	$offer_letter_status_datetime = mysqli_real_escape_string($con, $row_nm['offer_letter_status_datetime']);
		$aol_contract_sent_datetime = mysqli_real_escape_string($con, $row_nm['aol_contract_sent_datetime']);
		$loa_file_status_date_by = mysqli_real_escape_string($con, $row_nm['loa_file_status_date_by']);
		$loa_file_status_date_by = mysqli_real_escape_string($con, $row_nm['loa_file_status_date_by']);
		$fh_status_updated_by = mysqli_real_escape_string($con, $row_nm['fh_status_updated_by']);
		
	$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
		while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
		$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
	}
	
	if($followstage == 'Profile_stage'){
		$date1 = strtotime($application_status_datetime);
	}
	
	if($followstage == 'Conditional_Offer_letter'){
		$date1 = strtotime($offer_letter_sent_datetime);
	}
	if($followstage == 'LOA_Request'){
		$date1 = strtotime($offer_letter_status_datetime);
	}
	if($followstage == 'Contract_Stage'){
		$date1 = strtotime($aol_contract_sent_datetime);
	}
	if($followstage == 'FH_Sent'){
		$date1 = strtotime($loa_file_status_date_by);
	}
	if($followstage == 'VG_VR'){
		$date1 = strtotime($fh_status_updated_by);
	}
	
	
	//////////////////////
	
 
 $date2 =  strtotime($updated_by);
$days = 0;
while (($date1 = strtotime('+1 DAYS', $date1)) <= $date2){
    $days++;
}

$nodays = $days.' Days';
$valdays = $days;
$valdays;
	
	$agent_col_datetime12 = "<span style='color:red;'>$nodays</span>";	
	 
	$action11 = "<a href='../application?aid=error_$ssno' class='btn btn-success' title='View Profile'><i class='fa fa-eye'></i></a>";	
	$action12 = "<a href='../followup/add.php?stusno=$ssno' class='btn btn-success' title='Create Follow Up'>Create Followup</a>";	
	$action = $action11.' '.$action12;
	
	$res1[] = array(	    
		'agntname' => $agntname,
		'student_name' => $student_name,
		'refid' => $refid,
		'agent_col_datetime12' => $agent_col_datetime12,
		'action' => $action
	);
	}
	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}

if($_GET['tag'] == "getfhstatusForm") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT fh_status FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$fh_status = $rowstr['fh_status'];	
		$btnstatus = '<form method="post" action="../mysqldb.php" autocomplete="off">
<p class="mb-0"><b>Update F@H Status : </b></p>
<div class="row">
<div class="col-8 col-sm-9">
<select name="fh_status" class="form-control fhStatusValue" required><option value="">Select Option</option>
<option value="1">Lodged</option>
<option value="File_Not_Lodged">Not Lodged</option>
<option value="Re_Lodged">Re-Lodged</option>
</select>
<input type="hidden" name="snid" value='.$idno.'>
</div><div class="col-4 col-sm-3">
<input type="submit" name="fhStatusBtn" value="Submit" class="btn btn-sm btn-success mt-0 fhreLodged">
</div>
</div>
</form>';
	
	$res1[] = array(		    
		'fhstatusbtn' => $btnstatus		    
	);
	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}

if($_GET['tag'] == "getfhstatus") {
	$idno = $_POST['idno'];	
	$get_query = mysqli_query($con, "SELECT fh_status, fh_status_updated_by, fh_re_lodgement FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
		$fh_status = $rowstr['fh_status'];
		$fh_status_updated_by = $rowstr['fh_status_updated_by'];
		$fh_re_lodgement = $rowstr['fh_re_lodgement'];
		
		if(!empty($fh_re_lodgement)){
			$fh_re_lodgement_1 = '(Re-Lodged)';
		}else{
			$fh_re_lodgement_1 = '';
		}
		
		if($fh_status !== ''){
			$fhst = "<span style='color:green;'>F@H$fh_re_lodgement_1</span>";	
		}else{
			$fhst = "<span style='color:red;'>Pending</span>";	
		}
		
		if($fh_status_updated_by != ''){
			$fh_status_updated = $fh_status_updated_by;
		}else{
			$fh_status_updated = "<span style='color:red;'>N/A</span>";
		}
		
		$res1[] = array(
		    'fh_status' => $fhst,		    
		    'fh_status_updated' => $fh_status_updated		    
		);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getcomRestatus") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT v_g_r_status,v_g_r_invoice,comrefund_remarks,v_g_r_amount,com_refund_datetime,inovice_status,inovice_remarks,inovice_reciept,inovice_datetime,file_upload_vgr,file_upload_vgr2,file_upload_vgr3,settled_vr,file_upload_vgr_status,file_upload_vgr_remarks,file_upload_vgr_datetime,file_upload_vr_status,file_upload_vr_remarks,file_upload_vr_datetime,com_details_remarks_vr,com_details_datetime_vr,tt_upload_report,tt_upload_report_datetime,tt_upload_report_status,tt_upload_report_remarks FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$v_g_r_status = $rowstr['v_g_r_status'];
	$v_g_r_invoice = $rowstr['v_g_r_invoice'];
	$v_g_r_amount = $rowstr['v_g_r_amount'];
	$com_refund_datetime = $rowstr['com_refund_datetime'];
	$comrefund_remarks = $rowstr['comrefund_remarks'];
	
	$inovice_status = $rowstr['inovice_status'];
	$inovice_remarks = $rowstr['inovice_remarks'];
	$inovice_reciept = $rowstr['inovice_reciept'];
	$inovice_datetime = $rowstr['inovice_datetime'];
	
	$file_upload_vr_status = $rowstr['file_upload_vr_status'];
	$file_upload_vr_remarks = $rowstr['file_upload_vr_remarks'];
	$file_upload_vr_datetime = $rowstr['file_upload_vr_datetime'];
	
	$com_details_remarks_vr = $rowstr['com_details_remarks_vr'];
	$com_details_datetime_vr = $rowstr['com_details_datetime_vr'];
	
	$tt_upload_report = $rowstr['tt_upload_report'];
	$tt_upload_report_datetime = $rowstr['tt_upload_report_datetime'];
	$tt_upload_report_status = $rowstr['tt_upload_report_status'];
	$tt_upload_report_remarks = $rowstr['tt_upload_report_remarks'];
	
	//if($file_upload_vr_status == 'Yes'){
//		$agent_status_file = "<p><b>Refund Documents: </b>DONE</p>";
//	}
//	if($file_upload_vr_status == ''){
//		$agent_status_file = '<p><b>Refund Documents: </b><span style="color:red;">Pending</span></p>';
//	}
	
	if($file_upload_vr_remarks !== ''){
		$fileVr_remarks = "<p><b>Refund Remarks: </b>$file_upload_vr_remarks</p>";
	}else{
		$fileVr_remarks = '<p><b>Refund Remarks: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($file_upload_vr_datetime !== ''){
		$fileVrDatetime = "<p><b>Updated On: </b>$file_upload_vr_datetime</p>";
	}else{
		$fileVrDatetime = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
	
	$agentUploadStatus = '<div class="remarkShow mt-2"><div>'.$fileVr_remarks.' '.$fileVrDatetime.'</div></div>';	
	
		
	if($inovice_status !== ''){
		$status = "<p><b>TT Status: </b>$inovice_status</p>";	
	}else{
		$status = '<p><b>TT Status: </b><span style="color:red;">N/A</span></p>';	
	}
	
	if($inovice_remarks !== ''){
		$remarks = "<p><b>TT Remarks: </b>$inovice_remarks</p>";
	}else{
		$remarks = '<p><b>TT Remarks: </b><span style="color:red;">N/A</span></p>';	
	}
	
	if($inovice_reciept !== ''){
		$reciept = "<p><b>Download TT: </b><a href='../../uploads/$inovice_reciept' download> Download</a></p>";	
	}else{
		$reciept = '<p><b>Download TT: </b><span style="color:red;">N/A</span></p>';		
	}
	
	if($inovice_datetime !== ''){
		$inovice_datetime1 = "<p><b>Updated On: </b>$inovice_datetime</p>";	
	}else{
		$inovice_datetime1 = '<p><b>Updated On: </b><span style="color:red;">N/A</span></p>';
	}	
		
	if($v_g_r_status !== ''){
		$vgr_status = "<p><b>Main Status: </b>$v_g_r_status</p>";
	}else{
		$vgr_status = '<p><b>Main Status: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($v_g_r_invoice !== ''){
		$vgr_invoice = "<p><b>Invoice: </b><a href='../../uploads/$v_g_r_invoice' download> Download</a></p>";
	}else{
		$vgr_invoice = '<p><b>Invoice: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($v_g_r_amount !== ''){
		$vgr_amount = "<p><b>Amount: </b>$v_g_r_amount</p>";
	}else{
		$vgr_amount = '<p><b>Amount: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($comrefund_remarks !== ''){
		$comrefund_remarks1 = "<p><b>Remarks: </b>$comrefund_remarks</p>";
	}else{
		$comrefund_remarks1 = "<p><b>Remarks: </b><span style='color:red;'>N/A</span></p>";
	}	
		
	if($v_g_r_status == 'V-G'){
		$statusVal = 'COMMISSION';
	}
	if($v_g_r_status == 'V-R'){
		$statusVal = 'REFUND';
	}
	if($v_g_r_status == ''){
		$statusVal = '';
	}
	
	if($com_refund_datetime !== ''){
		$com_refund_datetime1 = "<p><b>Updated On($statusVal Status): </b>$com_refund_datetime</p>";
	}else{
		$com_refund_datetime1 = "<p><b>Updated On($statusVal Status): </b><span style='color:red;'>N/A</span></p>";
	}	
		
	if($com_details_remarks_vr !== ''){
		$ttcom_remarks1 = "<p><b>Remarks: </b>$com_details_remarks_vr</p>";
	}else{
		$ttcom_remarks1 = "<p><b>Remarks: </b><span style='color:red;'>N/A</span></p>";
	}
	
	if($com_details_datetime_vr !== ''){
		$ttcom_datetime1 = "<p><b>Updated On: </b>$com_details_datetime_vr</p>";
	}else{
		$ttcom_datetime1 = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
	
	$com_approved_report = '<form method="post" action="../mysqldb.php" autocomplete="off">
<p><b>Remarks For -(Commission Details Uploaded by Processor)</b></p>
<p><b>Remarks : </b></p><textarea name="com_details_remarks_vr" class="form-control col-sm-12" required></textarea>
<input type="hidden" name="snid" value='.$idno.'>
<input type="submit" name="comTTBtn" value="Submit" class="btn btn-sm btn-success mt-2"></form>';
	
	if($v_g_r_status == 'V-G'){
		$formComRefund = '<form method="post" action="../mysqldb.php" enctype="multipart/form-data" autocomplete="off">
<p class="mt-3 mb-0"><b>'.$statusVal.' Details :</b></p><div class="row"><div class="col-sm-5">
<p class="mt-3 mb-0"><b>Amount : </b></p><input type="text" name="v_g_r_amount" class="form-control" palceholder="Enter Amount" required></div><div class="col-sm-7">
<p class="mt-3 mb-0"><b>V-G Invoice : </b></p><input type="file" name="v_g_r_invoice" class="form-control" required></div>
<div class="col-8 col-sm-9">
<p class="mt-3 mb-0"><b>Remarks : </b></p><textarea name="comrefund_remarks" class="form-control" required></textarea></div>
<div class="col-4 col-sm-3 pt-5">
<input type="hidden" name="snid" value='.$idno.'>
<input type="submit" name="comRefundBtn" value="Submit" class="btn btn-sm btn-success mt-2"></div></div>
</form>
<div class="remarkShow mt-2"><div><p class="text-center"><b>Commission Details by you</b></p>'.$vgr_invoice.' '.$vgr_amount.' '.$comrefund_remarks1.' '.$com_refund_datetime1.'</div></div> 
<div class="remarkShow mt-2"><div><p class="text-center"><b>Commission Details Uploaded by Processor</b></p>'.$status.' '.$remarks.' '.$reciept.' '.$inovice_datetime1.'</div></div>'.$com_approved_report.'
<div class="remarkShow mt-2"><div>'.$ttcom_remarks1.' '.$ttcom_datetime1.'</div></div>';
	}

///// V-R //////	
	$file_upload_vgr = $rowstr['file_upload_vgr'];
	$file_upload_vgr2 = $rowstr['file_upload_vgr2'];
	$file_upload_vgr3 = $rowstr['file_upload_vgr3'];	
	
	$file_upload_vgr_status = $rowstr['file_upload_vgr_status'];	
	$file_upload_vgr_remarks = $rowstr['file_upload_vgr_remarks'];	
	$file_upload_vgr_datetime = $rowstr['file_upload_vgr_datetime'];
	$settled_vr = $rowstr['settled_vr'];
	
	if($file_upload_vgr !== ''){
		if($file_upload_vr_status == 'Yes'){
			$filevgr12 = "<a href='../../uploads/$file_upload_vgr' download> Download</a>";	
		}else{
			$filevgr12 = "<span style='color:red;'>N/A</span>";	
		}
	}else{
		$filevgr12 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr2 !== ''){
		if($file_upload_vr_status == 'Yes'){
			$filevgr22 = "<a href='../../uploads/$file_upload_vgr2' download> Download</a>";
		}else{
			$filevgr22 = "<span style='color:red;'>N/A</span>";	
		}	
	}else{
		$filevgr22 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr3 !== ''){
		if($file_upload_vr_status == 'Yes'){
			$filevgr32 = "<a href='../../uploads/$file_upload_vgr3' download> Download</a>";
		}else{
			$filevgr32 = "<span style='color:red;'>N/A</span>";	
		}		
	}else{
		$filevgr32 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr_status !== ''){
		$statusFilesUpload = "<p><b>Status updated by you(For Refund Docs): </b>$file_upload_vgr_status</p>";
	}else{
		$statusFilesUpload = '<p><b>Status updated by you(For Refund Docs): </b><span style="color:red;">N/A</span></p>';
	}
	
	if($file_upload_vgr_remarks !== ''){
		$remarksFilesUpload = "<p><b>Remarks: </b>$file_upload_vgr_remarks</p>";
	}else{
		$remarksFilesUpload = '<p><b>Remarks: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($file_upload_vgr_datetime !== ''){
		$datetimeFilesUpload = "<p><b>Updated On: </b>$file_upload_vgr_datetime</p>";
	}else{
		$datetimeFilesUpload = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}	
	///////
	if($v_g_r_status == 'V-R'){
		$allfileAgent = "<table class='table table-bordered table-hover'>
	<tr><th>TT from Agent: </th><td>$filevgr12</td></tr>
	<tr><th>Refund Form: </th><td>$filevgr22</td></tr>
	<tr><th>Refusal Letter: </th><td>$filevgr32</td></tr></table>";
	$vrstst = "<p class='mb-0 mt-2'><b>$statusVal Documents From Agent :</b></p>";
	
	if($settled_vr !==''){
		$settled_vr_1 = "<p><b>Status(For Refund Docs): </b>$settled_vr</p>";
	}else{
		$settled_vr_1 = "";
	}
	
	if($tt_upload_report_status !== ''){
		$ttStatusReport = "<p><b>Status updated by processor(For Refund Docs): </b>$tt_upload_report_status</p>";
	}else{
		$ttStatusReport = '<p><b>Status updated by processor(For Refund Docs): </b><span style="color:red;">N/A</span></p>';
	}
	
	if($tt_upload_report_remarks !== ''){
		$ttRemarksReport = "<p><b>Remarks by processor: </b>$tt_upload_report_remarks</p>";
	}else{
		$ttRemarksReport = '<p><b>Remarks by processor: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($settled_vr =='Not Settled'){	
	if($tt_upload_report !== ''){
		$ttReceipt = "<p><b>TT receipt by processor: </b><a href='../../uploads/$tt_upload_report' download> Download</a></p>";	
	}else{
		$ttReceipt = "<p><b>TT receipt by processor: </b><span style='color:red;'>N/A</span></p>";	
	}
	}else{
		$ttReceipt = '';
	}
	
	if($tt_upload_report_datetime !== ''){
		$ttReceiptDT = "<p><b>Updated On: </b>$tt_upload_report_datetime</p>";
	}else{
		$ttReceiptDT = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}	
	
	$ttReceiptStatus = '<div class="remarkShow mt-2"><div>'.$settled_vr_1.' '.$ttStatusReport.' '.$ttReceipt.' '.$ttRemarksReport.' '.$ttReceiptDT.'</div></div>';
	
		$formComRefund = ''.$vrstst.' '.$allfileAgent.' '.$agentUploadStatus.' <form method="post" action="../mysqldb.php" autocomplete="off">
<p class="mt-3 mb-0"><b>Update Refund Documents Status</b></p><select name="file_upload_vgr_status" class="form-control col-sm-12" required><option value="">Select Option</option>
<option value="Yes">Yes</option><option value="No">No</option></select>
<p class="mt-3 mb-0"><b>Remarks : </b></p><div class="row"><div class="col-8 col-sm-9"><textarea name="file_upload_vgr_remarks" class="form-control col-sm-12" required></textarea></div><div class="col-4 col-sm-3">
<input type="hidden" name="snid" value='.$idno.'>
<input type="submit" name="fileVRStatusBtn" value="Submit" class="btn btn-sm btn-success mt-2"></div></div></form>
<div class="remarkShow mt-2"><div>'.$statusFilesUpload.' '.$remarksFilesUpload.' '.$datetimeFilesUpload.'</div></div>
'.$ttReceiptStatus.'';
	}
	
	if($v_g_r_status == ''){
		$formComRefund = ''.$vgr_status.'';
	}
	
	$res1[] = array(
		'formComRefund' => $formComRefund
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getSelectedStatus"){
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT v_g_r_status,v_g_r_status_datetime FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$v_g_r_status = $rowstr['v_g_r_status'];
	$v_g_r_status_datetime = $rowstr['v_g_r_status_datetime'];
	
	if($v_g_r_status !== ''){
		$v_g_r_status1 = "<p><b>You have selected Status: </b>$v_g_r_status</p>";
	}else{
		$v_g_r_status1 = "<p><b>You have selected Status: </b><span style='color:red;'>Pending</span></p>";
	}	
	
	if($v_g_r_status_datetime !== ''){
		$vgr_status_datetime = "<p><b>Updated On: </b>$v_g_r_status_datetime</p>";
	}else{
		$vgr_status_datetime = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}

	$vststatus = '<div class="remarkShow mt-2"><div>'.$v_g_r_status1.' '.$vgr_status_datetime.'</div></div>';	
	
	$res1[] = array(
		'vststatus' => $vststatus
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}




if($_GET['tag'] == "getInvicestatus") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT v_g_r_status,inovice_status,inovice_remarks,inovice_reciept,inovice_datetime,file_upload_vgr,file_upload_vgr2,file_upload_vgr3,file_upload_vgr_status,file_upload_vgr_remarks,file_upload_vgr_datetime,v_g_r_invoice,v_g_r_amount,v_g_r_status_datetime,comrefund_remarks FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$v_g_r_status = $rowstr['v_g_r_status'];
	$inovice_status = $rowstr['inovice_status'];
	$inovice_remarks = $rowstr['inovice_remarks'];
	$inovice_reciept = $rowstr['inovice_reciept'];
	$inovice_datetime = $rowstr['inovice_datetime'];
	
	$file_upload_vgr = $rowstr['file_upload_vgr'];	
	$file_upload_vgr2 = $rowstr['file_upload_vgr2'];	
	$file_upload_vgr3 = $rowstr['file_upload_vgr3'];
	
	$file_upload_vgr_status = $rowstr['file_upload_vgr_status'];	
	$file_upload_vgr_remarks = $rowstr['file_upload_vgr_remarks'];	
	$file_upload_vgr_datetime = $rowstr['file_upload_vgr_datetime'];

	$v_g_r_invoice = $rowstr['v_g_r_invoice']; 
	$v_g_r_amount = $rowstr['v_g_r_amount'];
	$v_g_r_status_datetime = $rowstr['v_g_r_status_datetime'];
	$comrefund_remarks = $rowstr['comrefund_remarks'];

	if($inovice_status !== ''){
		$status = "<span style='color:green;'>$inovice_status</span>";	
	}else{
		$status = "<span style='color:red;'>Pending</span>";	
	}
	
	if($inovice_remarks !== ''){
		$remarks = "$inovice_remarks";	
	}else{
		$remarks = "<span style='color:red;'>N/A</span>";	
	}
	
	if($inovice_reciept !== ''){
		$reciept = "<a href='../../uploads/$inovice_reciept' download> Download</a>";	
	}else{
		$reciept = "<span style='color:red;'>N/A</span>";	
	}
	
	if($inovice_datetime !== ''){
		$inovice_datetime1 = "$inovice_datetime";	
	}else{
		$inovice_datetime1 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr !== ''){
		$filevgr12 = "<a href='../../uploads/$file_upload_vgr' download> Download</a>";	
	}else{
		$filevgr12 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr2 !== ''){
		$filevgr22 = "<a href='../../uploads/$file_upload_vgr2' download> Download</a>";	
	}else{
		$filevgr22 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr3 !== ''){
		$filevgr32 = "<a href='../../uploads/$file_upload_vgr3' download> Download</a>";	
	}else{
		$filevgr32 = "<span style='color:red;'>N/A</span>";	
	}	
	
	if($file_upload_vgr_status !== ''){
		$statusFilesUpload = "<p><b>Files Status: </b>$file_upload_vgr_status</p>";
	}else{
		$statusFilesUpload = '<p><b>Files Status: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($file_upload_vgr_remarks !== ''){
		$remarksFilesUpload = "<p><b>Remarks: </b>$file_upload_vgr_remarks</p>";
	}else{
		$remarksFilesUpload = '<p><b>Remarks: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($file_upload_vgr_datetime !== ''){
		$datetimeFilesUpload = "<p><b>Updated On: </b>$file_upload_vgr_datetime</p>";
	}else{
		$datetimeFilesUpload = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
	
	if($v_g_r_invoice !== ''){
		$vgr_invoice = "<p><b>V-G Invoice: </b><a href='../../uploads/$v_g_r_invoice' download> Download</a></p>";
	}else{
		$vgr_invoice = '<p><b>V-G Invoice: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($v_g_r_amount !== ''){
		$vgr_amount = "<p><b>Amount: </b>$v_g_r_amount</p>";
	}else{
		$vgr_amount = '<p><b>Amount: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($v_g_r_status_datetime !== ''){
		$vgr_status_datetime = "<p><b>Updated On: </b>$v_g_r_status_datetime</p>";
	}else{
		$vgr_status_datetime = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
	
	if($comrefund_remarks !== ''){
		$comrefund_remarks1 = "<p><b>Remarks: </b>$comrefund_remarks</p>";
	}else{
		$comrefund_remarks1 = "<p><b>Remarks: </b><span style='color:red;'>N/A</span></p>";
	}	
	
	if($v_g_r_status == 'V-R'){
		$allfileAgent = "<table class='table table-bordered table-hover'><tr><th>File1: </th><td>$filevgr12</td></tr>
	<tr><th>File2: </th><td>$filevgr22</td></tr>
	<tr><th>File3: </th><td>$filevgr32</td></tr></table>";
	
		$filesStatusAgent = '<form method="post" action="../mysqldb.php" autocomplete="off">
<p><b>Files Status</b></p><select name="file_upload_vgr_status" class="form-control col-sm-12" required><option value="">Select Option</option>
<option value="Yes">Yes</option><option value="No">No</option></select>
<p><b>Remarks : </b></p><textarea name="file_upload_vgr_remarks" class="form-control col-sm-12" required></textarea>
<input type="hidden" name="snid" value='.$idno.'>
<input type="submit" name="fileVRStatusBtn" value="Submit" class="btn btn-sm btn-success"></form>
'.$statusFilesUpload.' '.$remarksFilesUpload.' '.$datetimeFilesUpload.'';
	}else{
		$allfileAgent = '';
		$filesStatusAgent = '';
	}

	$res1[] = array(
		'status' => $status,
		'remarks' => $remarks,
		'reciept' => $reciept,
		'crtd' => $inovice_datetime1,
		'allfileAgent' => $allfileAgent,
		'filesStatusAgent' => $filesStatusAgent,
		'vgr_amount' => $vgr_amount,
		'vgr_invoice' => $vgr_invoice,
		'comrefund_remarks1' => $comrefund_remarks1,
		'vgr_status_datetime' => $vgr_status_datetime
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "getInvicestatusReport1") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT v_g_r_status,inovice_status,inovice_remarks,inovice_reciept,inovice_datetime,com_details_remarks_vr,com_details_datetime_vr,file_upload_vgr,file_upload_vgr2,file_upload_vgr3,file_upload_vgr_status,file_upload_vgr_remarks,file_upload_vgr_datetime,tt_upload_report,tt_upload_report_datetime,settled_vr,tt_upload_report_status,tt_upload_report_remarks,file_upload_vr_status,v_g_r_invoice,v_g_r_amount,comrefund_remarks,com_refund_datetime FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$v_g_r_status = $rowstr['v_g_r_status'];
	$inovice_status = $rowstr['inovice_status'];
	$inovice_remarks = $rowstr['inovice_remarks'];
	$inovice_reciept = $rowstr['inovice_reciept'];
	$inovice_datetime = $rowstr['inovice_datetime'];
	
	$com_details_remarks_vr = $rowstr['com_details_remarks_vr'];
	$com_details_datetime_vr = $rowstr['com_details_datetime_vr'];
	
	$tt_upload_report = $rowstr['tt_upload_report'];
	$tt_upload_report_datetime = $rowstr['tt_upload_report_datetime'];
	$tt_upload_report_remarks = $rowstr['tt_upload_report_remarks'];
	$tt_upload_report_status = $rowstr['tt_upload_report_status'];
	
//V-G : Commission	
	if($v_g_r_status == 'V-G'){
	$headingTitle = '<h4 class="modal-title">Commission Details</h4>';
	if($inovice_status == 'Yes'){
		$status = "<p><b>Status: </b>Proccessed</p>";	
	}
	if($inovice_status == 'No'){
		$status = "<p><b>Status: </b>Not Proccessed</p>";	
	}
	if($inovice_status == ''){
		$status = '<p><b>Status: </b><span style="color:red;">N/A</span></p>';	
	}
	
	if($inovice_remarks !== ''){
		$remarks = "<p><b>Remarks: </b>$inovice_remarks</p>";	
	}else{
		$remarks = "<p><b>Remarks: </b><span style='color:red;'>N/A</span></p>";	
	}
	
	if($inovice_reciept !== ''){
		$reciept = "<p><b>Uploaded TT: </b><a href='../../uploads/$inovice_reciept' download> Download</a></p>";	
	}else{
		$reciept = "<p><b>Uploaded TT: </b><span style='color:red;'>N/A</span></p>";	
	}
	
	if($inovice_datetime !== ''){
		$inovice_datetime1 = "<p><b>Updated On: </b>$inovice_datetime</p>";
	}else{
		$inovice_datetime1 = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
	
//v-g Commission Details Invoice	
	$v_g_r_invoice = mysqli_real_escape_string($con, $rowstr['v_g_r_invoice']);
	if($v_g_r_invoice !== ''){
		$invoive = "<p><b>Invoice: </b><a href='../../uploads/$v_g_r_invoice' download>Download</a></p>";
	}else{
		$invoive = '<p><b>Invoice: </b><span style="color:red;">N/A</span></p>';
	}
	$v_g_r_amount1 = mysqli_real_escape_string($con, $rowstr['v_g_r_amount']);
	if($v_g_r_amount1 !=''){
		$v_g_r_amount = "<p><b>Amount: </b>$v_g_r_amount1</p>";
	}else{
		$v_g_r_amount = '<p><b>Amount: </b><span style="color:red;">N/A</span></p>';
	}
	$comrefund_remarks1 = mysqli_real_escape_string($con, $rowstr['comrefund_remarks']);
	if($comrefund_remarks1 !=''){
		$comrefund_remarks = "<p><b>Remarks: </b>$comrefund_remarks1</p>";
	}else{
		$comrefund_remarks = '<p><b>Remarks: </b><span style="color:red;">N/A</span></p>';
	}
	$com_refund_datetime1 = mysqli_real_escape_string($con, $rowstr['com_refund_datetime']);
	if($com_refund_datetime1 !=''){
		$com_refund_datetime = "<p><b>Updated On: </b>$com_refund_datetime1</p>";
	}else{
		$com_refund_datetime = '<p><b>Updated On: </b><span style="color:red;">N/A</span></p>';
	}
	
	$rprt_page_invoice = '<div class="remarkShow mt-2"><div>'.$invoive.' '.$v_g_r_amount.' '.$comrefund_remarks.' '.$com_refund_datetime.'</div></div>';
	
/////////////
	
	if($com_details_remarks_vr !== ''){
		$ttcom_remarks1 = "<p><b>Remarks: </b>$com_details_remarks_vr</p>";
	}else{
		$ttcom_remarks1 = "<p><b>Remarks: </b><span style='color:red;'>N/A</span></p>";
	}
	
	if($com_details_datetime_vr !== ''){
		$ttcom_datetime1 = "<p><b>Updated On: </b>$com_details_datetime_vr</p>";
	}else{
		$ttcom_datetime1 = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
	
	$formCommision = ''.$rprt_page_invoice.' <div class="row"><div class="col-sm-12"><form method="post" action="../mysqldb.php" enctype="multipart/form-data" autocomplete="off">
<p><b>Status</b></p>
<select name="inovice_status" class="form-control col-sm-12 inovice_status" id="inviceFile">
<option value="">Select Option</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
<p><b>Upload TT: </b></p>
<input type="file" name="inovice_reciept" class="form-control col-sm-12 invoicefile">
<p><b>Remarks: </b></p>
<textarea name="inovice_remarks" class="form-control col-sm-12 inovice_remarks mb-2"></textarea>
<input type="hidden" name="snid" class="vgrsnid" value='.$idno.'>
<input type="submit" name="vgrInvoiceBtn" value="Submit" class="btn btn-sm btn-success ttfilebtn">
</form></div></div>';
	
	$tt_duration_status = ''.$formCommision. '<div class="remarkShow mt-2"><div><p><b>Details Entered By You:</b></p>'.$status.' '.$remarks.' '.$reciept.' '.$inovice_datetime1.'</div></div>';
	$tt_duration = '<div class="remarkShow mt-2"><div><p><b>Details Updated By Operation Team:</b></p>'.$ttcom_remarks1.' '.$ttcom_datetime1.'</div></div>';
	$ttFormUpload = '';
	}
	
//V-R : Refund	
	if($v_g_r_status == 'V-R'){
	$headingTitle = '<h4 class="modal-title">Refund Documents From Agent</h4>';
	$file_upload_vgr = $rowstr['file_upload_vgr'];
	$file_upload_vgr2 = $rowstr['file_upload_vgr2'];
	$file_upload_vgr3 = $rowstr['file_upload_vgr3'];
	
	$file_upload_vgr_status = $rowstr['file_upload_vgr_status'];
	$file_upload_vgr_remarks = $rowstr['file_upload_vgr_remarks'];
	$file_upload_vgr_datetime = $rowstr['file_upload_vgr_datetime'];
	$file_upload_vr_status = $rowstr['file_upload_vr_status'];
	$settled_vr = $rowstr['settled_vr'];
	
	if($file_upload_vgr !== ''){
		$filevgr12 = "<a href='../../uploads/$file_upload_vgr' download> Download</a>";	
	}else{
		$filevgr12 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr2 !== ''){
		$filevgr22 = "<a href='../../uploads/$file_upload_vgr2' download> Download</a>";	
	}else{
		$filevgr22 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr3 !== ''){
		$filevgr32 = "<a href='../../uploads/$file_upload_vgr3' download> Download</a>";	
	}else{
		$filevgr32 = "<span style='color:red;'>N/A</span>";	
	}
	
	if($file_upload_vgr_status !== ''){
		$statusFilesUpload = "<p><b>Files Status: </b>$file_upload_vgr_status</p>";
	}else{
		$statusFilesUpload = '<p><b>Files Status: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($file_upload_vgr_remarks !== ''){
		$remarksFilesUpload = "<p><b>Remarks: </b>$file_upload_vgr_remarks</p>";
	}else{
		$remarksFilesUpload = '<p><b>Remarks: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($file_upload_vgr_datetime !== ''){
		$datetimeFilesUpload = "<p><b>Updated On: </b>$file_upload_vgr_datetime</p>";
	}else{
		$datetimeFilesUpload = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
		
	if(($file_upload_vgr_status == 'Yes') && ($file_upload_vr_status == 'Yes')){
		$tt_duration_status = "<table class='table table-bordered table-hover'>
	<tr><th>TT: </th><td>$filevgr12</td></tr>
	<tr><th>Refund Form: </th><td>$filevgr22</td></tr>
	<tr><th>Refusal Letter: </th><td>$filevgr32</td></tr></table>";
	}
	if(($file_upload_vgr_status == 'No') && ($file_upload_vr_status == 'Yes')){
		$tt_duration_status = '';
	}
	if(($file_upload_vgr_status == 'No') && ($file_upload_vr_status == '')){
		$tt_duration_status = '';
	}
	if(($file_upload_vgr_status == 'Yes') && ($file_upload_vr_status == '')){
		$tt_duration_status = '';
	}
	if(($file_upload_vgr_status == '') && ($file_upload_vr_status == 'Yes')){
		$tt_duration_status = '';
	}
		$tt_duration = '<div class="remarkShow mt-2"><div>'.$statusFilesUpload.' '.$remarksFilesUpload.' '.$datetimeFilesUpload.'</div></div>';
	
	if($settled_vr !== ''){
		$settled_vr_1 = "<p><b>Refund Type: </b>$settled_vr</p>";
	}else{
		$settled_vr_1 = '<p><b>Refund Type: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($tt_upload_report_status !== ''){
		$ttStatusReport = "<p><b>Refund Status: </b>$tt_upload_report_status</p>";
	}else{
		$ttStatusReport = '<p><b>Refund Status: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($tt_upload_report_remarks !== ''){
		$ttRemarksReport = "<p><b>Remarks: </b>$tt_upload_report_remarks</p>";
	}else{
		$ttRemarksReport = '<p><b>Remarks: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($settled_vr =='Not Settled'){
	if($tt_upload_report !== ''){
		$ttReceipt = "<p><b>TT Receipt: </b><a href='../../uploads/$tt_upload_report' download> Download</a></p>";	
	}else{
		$ttReceipt = "<p><b>TT Receipt: </b><span style='color:red;'>N/A</span></p>";	
	}
	}else{
		$ttReceipt = '';
	}
	
	if($tt_upload_report_datetime !== ''){
		$ttReceiptDT = "<p><b>Updated On: </b>$tt_upload_report_datetime</p>";
	}else{
		$ttReceiptDT = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
	
	$tt_report_upload = '<div class="remarkShow mt-2"><div>'.$settled_vr_1.' '.$ttStatusReport.''.$ttReceipt.''.$ttRemarksReport.' '.$ttReceiptDT.'</div></div>';

	
	$ttFormUpload = '<div class="row"><div class="col-sm-12">
<form method="post" action="../mysqldb.php" enctype="multipart/form-data" autocomplete="off"><p class="mt-2"><b>Refund Type</b></p><select name="settled_vr" class="form-control settled_vr mt-2 mb-2"><option value="">Select Option</option><option value="Settled">Settled</option><option value="Not Settled">Not Settled</option></select><div class="settledDiv" style="display:none;">
<p><b>Refund Status</b></p><select name="tt_upload_report_status" class="form-control col-sm-12 tturs">
<option value="">Select Option</option><option value="Yes">Yes</option><option value="No">No</option></select>
<p><b>TT Receipt: </b></p>
<input type="file" name="tt_upload_report" class="form-control col-sm-12 tturfile">
<p><b>Remarks : </b></p><textarea name="tt_upload_report_remarks" class="form-control col-sm-12 tturrmrk"></textarea><input type="hidden" name="snid" class="vgrsnid" value='.$idno.'>
<input type="submit" name="vrRefundttfile" value="Submit" class="btn btn-sm btn-success vrRefundttfile mt-2"></div>

<div class="notsettledDiv" style="display:none;"><p><b>Refund Status</b></p><select name="tt_upload_report_status_1" class="form-control col-sm-12 tturs_1">
<option value="">Select Option</option><option value="Yes">Yes</option><option value="No">No</option></select>
<p><b>Remarks : </b></p><textarea name="tt_upload_report_remarks_1" class="form-control col-sm-12 tturrmrk_1"></textarea><input type="hidden" name="snid" class="vgrsnid_1" value='.$idno.'>
<input type="submit" name="vrRefundttfile_1" value="Submit" class="btn btn-sm btn-success vrRefundttfile_1 mt-2"></div>
</form></div></div>'.$tt_report_upload.'';
	
}
		
	
	$res1[] = array(
		'titleHead' => $headingTitle,
		'tt_duration_status' => $tt_duration_status,
		'tt_duration' => $tt_duration,
		'ttFormUpload' => $ttFormUpload
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


if($_GET['tag'] == "refundVRStatusList") { 
	$nameval = $_POST['nameval'];
	if(($nameval == 'cdsbot') || ($nameval == 'crr') || ($nameval == 'cnp') || ($nameval == 'cp') || ($nameval == 'tt_Yes_settled') || ($nameval == 'tt_Yes_notsettled') || ($nameval == 'tt_rdabt') || ($nameval == 'tt_rdp')){				
		if($nameval == 'cdsbot'){
			$getval = "AND v_g_r_status='V-G' AND v_g_r_amount!='' AND v_g_r_invoice!=''";
		}elseif($nameval == 'crr'){
			$getval = "AND v_g_r_status='V-G' AND inovice_status='' AND v_g_r_invoice!=''";
		}elseif($nameval == 'cnp'){
			$getval = "AND v_g_r_status='V-G' AND inovice_status='No' AND v_g_r_invoice!=''";
		}elseif($nameval == 'cp'){
			$getval = "AND v_g_r_status='V-G' AND inovice_status='Yes' AND v_g_r_invoice!=''";
			
		}elseif($nameval == 'tt_rdabt'){
			$getval = "AND v_g_r_status='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND (tt_upload_report_status='' OR tt_upload_report_status='No')";
			
		}elseif($nameval == 'tt_Yes_settled'){
			$getval = "AND v_g_r_status='V-R' AND settled_vr='Settled' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND tt_upload_report_status='Yes'";
		}
		elseif($nameval == 'tt_Yes_notsettled'){
			$getval = "AND v_g_r_status='V-R' AND settled_vr='Not Settled' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND tt_upload_report_status='Yes'";
		}
	}else{
		$getval = '';
	}  
		
	$getq = "SELECT sno,fname,lname,refid,v_g_r_status,v_g_r_status_datetime,v_g_r_invoice,v_g_r_amount,inovice_status,file_upload_vgr_status,tt_upload_report_status,file_upload_vr_status FROM st_application where fh_status!='' $getval";
	// die;
	$get_query = mysqli_query($con, $getq);
	while ($row_nm = mysqli_fetch_assoc($get_query)){
	$ssno = mysqli_real_escape_string($con, $row_nm['sno']);
	$fname = mysqli_real_escape_string($con, $row_nm['fname']);
	$lname = mysqli_real_escape_string($con, $row_nm['lname']);
	$fullname = $fname.' '.$lname;
	$refid = mysqli_real_escape_string($con, $row_nm['refid']);
	
	$v_g_r_status_datetime = mysqli_real_escape_string($con, $row_nm['v_g_r_status_datetime']);
	$v_g_r_invoice = mysqli_real_escape_string($con, $row_nm['v_g_r_invoice']);						
	$v_g_r_amount1 = mysqli_real_escape_string($con, $row_nm['v_g_r_amount']);
	
	$inovice_status = mysqli_real_escape_string($con, $row_nm['inovice_status']);
	$v_g_r_status = mysqli_real_escape_string($con, $row_nm['v_g_r_status']);
	$file_upload_vgr_status = mysqli_real_escape_string($con, $row_nm['file_upload_vgr_status']);
	$file_upload_vr_status = mysqli_real_escape_string($con, $row_nm['file_upload_vr_status']);
	$tt_upload_report_status = mysqli_real_escape_string($con, $row_nm['tt_upload_report_status']);
	
//V-G : Commission				
	if($v_g_r_status == 'V-G'){
	if(($v_g_r_invoice == '') && ($v_g_r_amount == '')){
		$inovice_status111 = '<div class="btn checklistClassred btn-sm"><i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="Refund Documents Pending"></i></div>';
	}else{
	if($inovice_status == ''){
		$inovice_status111 = '<div class="btn checklistClassyellow btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id='.$ssno.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Commission Request Raised"></i></div>';
	}
	if($inovice_status == 'No'){
		$inovice_status111 = '<div class="btn checklistClassred btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id='.$ssno.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Commission not Proccessed"></i></div>';
	}
	if($inovice_status == 'Yes'){
		$inovice_status111 = '<div class="btn checklistClassgreen btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id='.$ssno.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Commission Proccessed"></i></div>';
	}
	}
	}

//V-R : Refund				
	if($v_g_r_status == 'V-R'){
	if(($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status =='No')){
		$inovice_status111 = '<div class="btn checklistClassred btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id='.$ssno.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Approved By Team"></i></div>';
	}
	if(($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status =='Yes')){
		$inovice_status111 = '<div class="btn checklistClassgreen btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id='.$ssno.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Recvd."></i></div>';
	}
	if(($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
		$inovice_status111 = '<div class="btn checklistClassred btn-sm"><i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="Refund Documents Pending"></i></div>';
	}
	if(($file_upload_vgr_status == 'No') && ($tt_upload_report_status == '')){
		$inovice_status111 = '<div class="btn checklistClassred btn-sm"><i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="Refund Documents Pending"></i></div>';
	}
	if(($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == '')){
		$inovice_status111 = '<div class="btn checklistClassyellow btn-sm invoiceStatusClass" data-toggle="modal" data-target="#invoiceStatusModel" data-id='.$ssno.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Pending"></i></div>';
	}
	
	}
		
	$res1[] = array(
		'ssno' => $ssno,
		'fullname' => $fullname,
		'refid' => $refid, 
		'v_g_r_status' => $v_g_r_status,
		'inovice_status12' => $inovice_status111		
	);
	}
	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


if($_GET['tag'] == "getDropstatus") { 
	$idno = $_POST['idno'];
	
	$getq = "SELECT flowdrp FROM st_application where sno='$idno'";
	$get_query = mysqli_query($con, $getq);
	$row_nm = mysqli_fetch_assoc($get_query);
	$flowdrp = $row_nm['flowdrp'];
	
	if($flowdrp == 'Drop'){
		
	$dropform = '<div class="col-sm-12">
<input type="submit" class="btn btn-submit dropreactive" value="Reactive" idno='.$idno.'>
</div>';
		
	}else{
		$dropform = '';
	}
	
	$res1[] = array(
		'dropform' => $dropform		
	);
		
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "reactiveStatus") {
	$idno = $_POST['idno'];
	mysqli_query($con, "update `st_application` set `flowdrp`='', `reactive_date`='$updated_by' where `sno`='$idno'");	
	echo 1;
}

if($_GET['tag'] == "getTTReceiptFile") {
	$idno = $_POST['idno'];
	
	$getq = "SELECT loa_tt,loa_receipt_file,college_tt,college_tt_date FROM st_application where sno='$idno'";
	$get_query = mysqli_query($con, $getq);
	$row_nm = mysqli_fetch_assoc($get_query);
	$college_tt = $row_nm['college_tt'];
	$loa_tt = $row_nm['loa_tt'];
	$college_tt_date = $row_nm['college_tt_date'];
	$loa_receipt_file = $row_nm['loa_receipt_file'];
	
	if($college_tt !=''){
		$college_tt_1 = "<p><b>Receipt: </b><a href='../../uploads/$college_tt' download>Download</a></p>"; //college tt
	}else{
		$college_tt_1 = '';
	}
	
	if($college_tt_date !=''){
		$college_tt_date_1 = "<p><b>Updated On: </b>$college_tt_date</p>";
	}else{
		$college_tt_date_1 = '';
	}
	
	if($loa_tt !=''){
		$loa_tt_1 = "<p><b>TT Receipt: </b><a href='../../uploads/$loa_tt' download>Download</a></p>";
	}else{
		$loa_tt_1 = '';
	}
	
	if($loa_receipt_file !=''){
		$loa_receipt_file_1 = "<p><b>Receipt: </b><a href='../uploads/$loa_receipt_file' download>Download</a></p>";
	}else{
		$loa_receipt_file_1 = '';
	}
	
	
	
	$collegeTT = ''.$loa_tt_1.''.$loa_receipt_file_1.'<div class="row"><div class="col-sm-12"><form method="post" action="../mysqldb.php" enctype="multipart/form-data" autocomplete="off">
<p><b>Upload Receipt: </b></p>
<input type="file" name="college_tt" class="form-control col-sm-12">
<input type="hidden" name="snid" value='.$idno.'>
<input type="submit" name="collegettbtn" value="Submit" class="btn btn-sm btn-success">
</form></div></div>'.$college_tt_1.''.$college_tt_date_1.'';
	

	$res1[] = array(
		'collegeTT' => $collegeTT		
	);
		
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


if($_GET['tag'] == "getDropstatus_Agent") {
	$idno = $_POST['idno'];
	
	$get_query = mysqli_query($con, "SELECT file_receipt,loa_tt FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$file_receipt = $rowstr['file_receipt'];
	$loa_tt = $rowstr['loa_tt'];
	
	if($file_receipt == '1'){
		$loaReceipt = "<p><b>LOA Request : </b>DONE</p>";	
	}else{
		$loaReceipt = "<p><b>LOA Request : </b><span style='color:red;'>Pending</span></p>";	
	}
	
	
	if($loa_tt !== ''){
		$loa_tt_1 = "<p><b>Requested LOA: </b><a href='../uploads/$loa_tt' download> Download</a></p>";	
	}else{
		$loa_tt_1 = '';
	}
	
	$loaReceipt_2 = $loaReceipt.' '.$loa_tt_1;
	
	$res1[] = array(
		'loaReceipt' => $loaReceipt_2		
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "loaGenrate_DateChange"){
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT sno, loa_file_date_updated_by FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_array($get_query);
	$loa_file_date_updated_by = $rowstr['loa_file_date_updated_by'];

	if(!empty($loa_file_date_updated_by)){
		$gd = "<p><b>Current Date: </b>$loa_file_date_updated_by</p>";
	}else{
		$gd = "<p><b>Current Date: </b>Pending</p>";
	}

	$loaDateChange = ''.$gd.'<div class="row"><div class="col-sm-12"><form class="row" method="post" action="../mysqldb.php" autocomplete="off">
<p class="col-12"><b>Change Date: </b></p><div class="col-8">
<input type="text" name="loa_file_date_updated_by" class="form-control date_loa">
</div>
<div class="col-4 pl-0">
<input type="hidden" name="snid" value='.$idno.'>
<input type="submit" name="loaChangeDate" value="Submit" class="btn btn-success">
</div>
</form></div></div>';

$res1[] = array(
		'loaDateChange' => $loaDateChange		
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);

}

if($_GET['tag'] == "getDualCrs"){
	$idno = $_POST['idno'];

	$get_query = "SELECT campus, prg_name1, prg_intake FROM st_application where sno='$idno'";
	$rslt = mysqli_query($con, $get_query);
	$rowstr = mysqli_fetch_array($rslt);
	$prg_name1 = $rowstr['prg_name1'];
	$prg_intake = $rowstr['prg_intake'];
	$campus = $rowstr['campus'];

	$get_query_2 = "SELECT * FROM contract_courses where intake='$prg_intake' AND program_name='$prg_name1' AND campus='$campus' AND status='0'";
	$rslt_2 = mysqli_query($con, $get_query_2);
	if(mysqli_num_rows($rslt_2)){
		$list = '';
		echo json_encode($list);
	}else{
		$qury = "SELECT sno, program_name, campus FROM contract_courses where status='0' AND campus='$campus' AND intake='$prg_intake' group by program_name";	
		$result1 = mysqli_query($con, $qury);
		while($rowstr3 = mysqli_fetch_array($result1)){
			$sno = $rowstr3['sno'];
			$program_name3 = $rowstr3['program_name'];
			$campus3 = $rowstr3['campus'];
			
			$res1[] = array(
				'sno' => $sno,
				'program_name' => $program_name3,
				'campus' => $campus3
			);
		}
		$list = isset($res1) ? $res1 : '';
		echo json_encode($list);
	}	
}
?>