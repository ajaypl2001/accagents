<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Kolkata");
include("../../db.php");

if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT sno,role FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']);  
 }
}else{
   $adminrole = ''; 
}

$output = '';
$snoall = '';  
$output = '';
sleep(1);

$snoall = $_POST['last_video_id'];
$query = "SELECT COUNT(*) as num_row FROM st_application WHERE application_form='1' AND sno < ".$snoall." ORDER BY sno DESC";
 $prjs = mysqli_query($con, $query);
 $row212122 = $prjs->fetch_assoc();
$totalrow212Count = $row212122['num_row'];

$showLimit = 100;

$queryVal = "SELECT * FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND sno < ".$snoall." ORDER BY sno DESC LIMIT $showLimit";
$prj = mysqli_query($con, $queryVal);
if(mysqli_num_rows($prj) > 0){
	
while($row212 = mysqli_fetch_assoc($prj)) {
	 $snoall = mysqli_real_escape_string($con, $row212['sno']);
	 $app_by = mysqli_real_escape_string($con, $row212['app_by']);
	 $agent_type = mysqli_real_escape_string($con, $row212['agent_type']);
	 $user_id = mysqli_real_escape_string($con, $row212['user_id']);
	 $refid = mysqli_real_escape_string($con, $row212['refid']);
	 $student_id = mysqli_real_escape_string($con, $row212['student_id']);
	 $fname = mysqli_real_escape_string($con, $row212['fname']);			
	 $lname = mysqli_real_escape_string($con, $row212['lname']);
	 $dob = mysqli_real_escape_string($con, $row212['dob']);
	 $dob_1 = date("F j, Y", strtotime($dob)); 
	 $datetime = mysqli_real_escape_string($con, $row212['datetime']);
	 $prg_name1 = mysqli_real_escape_string($con, $row212['prg_name1']);
	 $prg_intake = mysqli_real_escape_string($con, $row212['prg_intake']);
	 $admin_status_crs = mysqli_real_escape_string($con, $row212['admin_status_crs']);
	 $admin_remark_crs = mysqli_real_escape_string($con, $row212['admin_remark_crs']);
	 $ol_confirm = mysqli_real_escape_string($con, $row212['ol_confirm']);
	 $signed_ol_confirm = mysqli_real_escape_string($con, $row212['signed_ol_confirm']);
	 $offer_letter = mysqli_real_escape_string($con, $row212['offer_letter']);
	 $file_receipt = mysqli_real_escape_string($con, $row212['file_receipt']);
	 $loa_confirm = mysqli_real_escape_string($con, $row212['loa_confirm']);
	 $loa_confirm_remarks = mysqli_real_escape_string($con, $row212['loa_confirm_remarks']);
	 $agreement = mysqli_real_escape_string($con, $row212['agreement']);
	 $agreement_loa = mysqli_real_escape_string($con, $row212['agreement_loa']);
	 $signed_al_status = mysqli_real_escape_string($con, $row212['signed_al_status']);
	 $contract_letter = mysqli_real_escape_string($con, $row212['contract_letter']);
	 $signed_agreement_letter = mysqli_real_escape_string($con, $row212['signed_agreement_letter']);
	 $prepaid_fee = mysqli_real_escape_string($con, $row212['prepaid_fee']);
	 $loa_file = mysqli_real_escape_string($con, $row212['loa_file']);
	 $loa_file_status = mysqli_real_escape_string($con, $row212['loa_file_status']);
	 $fh_status = mysqli_real_escape_string($con, $row212['fh_status']);
	 $v_g_r_status = mysqli_real_escape_string($con, $row212['v_g_r_status']);
	 $v_g_r_invoice = mysqli_real_escape_string($con, $row212['v_g_r_invoice']);
	 $inovice_status = mysqli_real_escape_string($con, $row212['inovice_status']);
	 $file_upload_vr_status = mysqli_real_escape_string($con, $row212['file_upload_vr_status']);
	 $file_upload_vgr_status = mysqli_real_escape_string($con, $row212['file_upload_vgr_status']);
	 $tt_upload_report_status = mysqli_real_escape_string($con, $row212['tt_upload_report_status']);
	
	  $agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id'");
			while ($row212_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
			$agntname = mysqli_real_escape_string($con, $row212_agnt_qry['username']);
	  }
	  
	$editFixed = '<a href="edit.php?apid='.base64_encode($snoall).'" class="btn edit-aplic btn-sm"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>';
	$editFixed1 = '<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="'.$snoall.'"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';

///// Application Status		
	if($adminrole !== 'Excu1'){	
	if($admin_status_crs == ""){
		$applicationStatus = ''.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassyellow" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoall.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (No Action)"></i></i></span>';
	} if($admin_status_crs == "No"){
		$applicationStatus = ''.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoall.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (Not Approved)"></i></i></span>';
	} if($admin_status_crs == "Yes"){
		$applicationStatus = ''.$editFixed.' '.$editFixed1.' <span class="btn btn-sm confirmbtn1 checklistClass" data-toggle="modal" data-target="#confirmbtn2" data-id="'.$snoall.'"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (Approved)"></i></i></span>';
	}
	

//Conditional Offer Letter
	if(($admin_status_crs == 'No') || ($admin_status_crs == '')){
		$olval1 = '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
	}
	if(($admin_status_crs == 'Yes') && ($offer_letter == '') && ($ol_confirm == '')){ 
		$olval1 = '<div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoall.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Offer Letter"></i></div>';
	}
	if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '')){
		$olval1 = '<div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoall.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Generated (Send)"></i></div>';
	}		
	if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){ 
		$olval1 = '<div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoall.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Sent (Sign Pending)"></i></div>';
	}
	if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){
		$olval1 = '<div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoall.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Sent (Status Pending)"></i></div>';
	}
	if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No') ){
		$olval1 = '<div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoall.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Not Approved"></i></div>';
	}
	if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes') ){
		$olval1 = '<div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Approved (Request LOA)"></i></div>';
	}
	}
	
	if(($adminrole == 'Admin') || ($adminrole !== 'Excu') || ($adminrole == 'Excu1')){
//LOA Request Status
	if(($signed_ol_confirm !== 'Yes') && ($file_receipt == '')){
		$btnpmt2 = '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
	}
	if(($signed_ol_confirm == 'Yes') && ($file_receipt == '')){
		$btnpmt2 = '<span class="btn checklistClassyellow btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="LOA Not Requested"><i class="fas fa-times"></i></span>';
	}
	if(($file_receipt !== '')){
		$btnpmt2 = '<div class="btn checklistClassgreen btn-sm" idno='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Request Sent"></i></div>';
	}

//AOL Contract			
		if($file_receipt !== '1'){
			$olval3 = '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
		}
		if(($file_receipt == '1') && ($contract_letter =='')){
			$olval3 = '<span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoall.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Contract"></i></div>';
		}
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='')){
			$olval3 = '<span class="btn checklistClassyellow btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoall.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Contract Generated (Send)"></i></div>';
		}
		if(($file_receipt == '1') && ($contract_letter !=='') && ($agreement_loa=='1') && ($signed_agreement_letter=='') ){
			$olval3 = '<span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoall.'> <i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generated Contract Sent"></i></div>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='')){
			$olval3 = '<span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoall.'> <i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Sent (Update Status)"></i></div>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='No')){
			$olval3 = '<span class="btn checklistClassred btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoall.'> <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Not Approved"></i></div>';
		}
		if(($agreement_loa !=='') && ($agreement_loa =='1') && ($signed_agreement_letter !=='') && ($signed_al_status=='Yes')){
			$olval3 = '<span class="btn checklistClassgreen btn-sm loaAgreeCl" data-toggle="modal" data-target="#loaAgreeModel" data-id='.$snoall.'> <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Approved"></i></div>';
		}
		
// Fee LOA
		if(($signed_al_status == '') || ($signed_al_status == 'No') && ($prepaid_fee == '')){
			$feesBtn = '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';		
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == '')){
			$feesBtn = '<div class="btn checklistClassred btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Pending)"></i></div>';
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == 'No')){
			$feesBtn = '<div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(No)"></i></div>';
		}
		if(($signed_al_status == 'Yes') && ($prepaid_fee == 'Yes')){
			$feesBtn = '<div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Yes)"></i></div>';
		}

// Upload LOA
		if(($prepaid_fee == '') || ($loa_file == '')){
			$btnloa = '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
		}
		if(($prepaid_fee !== '') && ($loa_file == '')){ 
			$btnloa = '<div class="btn checklistClassyellow btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoall.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate LOA"></i></div>';
		}
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '')){
			$btnloa = '<div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoall.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="LOA Generated"></i></div>';
		}
		if(($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '1')){
			$btnloa = '<div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id='.$snoall.' ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Sent"></i></div>';
		}

// V-G/V-R----
		
// Pending
		if((($loa_file_status == '') && $fh_status == '') && ($v_g_r_status == '')){
			$vgrstval = '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status == '')){
			$vgrstval = '<div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status !== '')){
			$vgrstval = '<div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div>';
		}
		if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status == '')){
			$vgrstval = '<div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Lodged"></i></div>';
		}
		
// V-G		
	if(($fh_status !== '') && ($v_g_r_status == 'V-G')){
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice =='') && ($inovice_status =='')){			
			$vgrstval = '<div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-G Status(Invoice Pending)"></i></div>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='')){			
			$vgrstval = '<div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="V-G Invoice Processed"></i></div>';			
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='Yes')){
			$vgrstval = '<div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Processed by Processor"></i></div>';
		}
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='No')){
			$vgrstval = '<div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Not Processed by Processor"></i></div>';
		}
	}

// V-R			
		if(($fh_status !== '') && ($v_g_r_status == 'V-R')){ 
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status =='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){	
			$vgrstval = '<span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-R Status(Refund Docs Pending From Agent)"></i></span>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
			$vgrstval = '<span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Refund Docs Recvd.(Status Pending)"></i></span>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == '')){
			$vgrstval = '<span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Processed to processor"></i></span>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'No') && ($tt_upload_report_status == '')){
			$vgrstval = '<span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Not Approved"></i></span>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'No')){
			$vgrstval = '<span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund not approved by processor"></i></span>';
		}
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'Yes')){
			$vgrstval = '<span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Approved(Download TT)"></i></span>';
		}	
		}	
	
	}   

	if($adminrole == 'Excu1'){
	$fhval_11 = '';
	$vgrstval_11 = '';
	$applicationStatus_11 = '';
	$olval1_11 = '';
	 $output .= '<tr class="error_'.$snoall.'">
        <td><input type="checkbox" id="error_'.$snoall.'" /></td>
        <td>'.$agntname.'</td>
        <td><a href="../followup/add.php?stusno='.$snoall.'" target="_blank">'.$fname.' '.$lname.'</a><br>'.$dob_1.'</td>
        <td>'.$student_id.'<br>'.$refid.'</td>
        <td>'.$datetime.'</td>;
        '.$applicationStatus_11.'
        '.$olval1_11.'
        <td>'.$btnpmt2.'</td>
        <td>'.$olval3.'</td>
        <td>'.$feesBtn.'</td>
        <td>'.$btnloa.'</td>
        '.$fhval_11.'
        '.$vgrstval_11.'
    </tr>';		
	}
	
	if($adminrole == 'Excu'){
	$btnpmt2 = '';
	$olval3 = '';
	$feesBtn = '';
	$btnloa = '';
	$fhval = '';
	$vgrstval = '';	
	$output .= '<tr class="error_'.$snoall.'">
        <td><input type="checkbox" id="error_'.$snoall.'" /></td>
        <td>'.$agntname.'</td>
        <td><a href="../followup/add.php?stusno='.$snoall.'" target="_blank">'.$fname.' '.$lname.'</a><br>'.$dob_1.'</td>
        <td>'.$student_id.'<br>'.$refid.'</td>
        <td>'.$datetime.'</td>;
        <td>'.$applicationStatus.'</td>
		<td>'.$olval1.'</td>
		'.$btnpmt2.'
		'.$olval3.'
		'.$feesBtn.'
		'.$btnloa.'
		'.$fhval.'
		'.$vgrstval.'        
    </tr>';		
	}
	
	if($adminrole == 'Admin'){
	$output .= '<tr class="error_'.$snoall.'">
        <td><input type="checkbox" id="error_'.$snoall.'" /></td>
        <td>'.$agntname.'</td>
        <td><a href="../followup/add.php?stusno='.$snoall.'" target="_blank">'.$fname.' '.$lname.'</a><br>'.$dob_1.'</td>
        <td>'.$student_id.'<br>'.$refid.'</td>
        <td>'.$datetime.'</td>;
        <td>'.$applicationStatus.'</td>
		<td>'.$olval1.'</td>
        <td>'.$btnpmt2.'</td>
        <td>'.$olval3.'</td>
        <td>'.$feesBtn.'</td>
        <td>'.$btnloa.'</td>
        <td>'.$vgrstval.'</td>
    </tr>';
	}
}	


 if($totalrow212Count > $showLimit){
$output .= '<tr class="border-0 border bg-white"><td colspan="10" class="bg-white"><div id="remove_row212'.$snoall.'" class="col-sm-12 text-center">  
	<center><button type="button" name="btn_more" data-vid='.$snoall.' class="btn btn-more btn_more">Load more applications</button></center>
</div></td></tr>';
 }
echo $output;
}
