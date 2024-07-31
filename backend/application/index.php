<?php
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
include("../../header_navbar.php");

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['search'];
	header("Location: ../application/?srchstatus=&page_no=1&getsearch=$search&agentid=");
}

$viewAdminAccess = "SELECT * FROM `admin_access` where admin_id='$sessionid1'";
$resultViewAdminAccess = mysqli_query($con, $viewAdminAccess);
if(mysqli_num_rows($resultViewAdminAccess)){
	$rowsViewAdminAccess = mysqli_fetch_assoc($resultViewAdminAccess);
	$viewName = $rowsViewAdminAccess['name'];
	$viewEmailId = $rowsViewAdminAccess['email_id'];
	$viewAdminId = $rowsViewAdminAccess['admin_id'];
	$viewEditStep = $rowsViewAdminAccess['edit_step'];
	$viewAppStatusSubmit = $rowsViewAdminAccess['app_status_submit'];
	$viewPal = $rowsViewAdminAccess['pal'];
	$pal_generate = $rowsViewAdminAccess['pal_generate'];
	$viewLoaRqst = $rowsViewAdminAccess['loa_rqst'];
	$viewLoaFees = $rowsViewAdminAccess['loafees'];
	$loafees_sbmt = $rowsViewAdminAccess['loafees_sbmt'];
	$viewLoa = $rowsViewAdminAccess['loa_step'];
	$viewStatus = $rowsViewAdminAccess['status'];
	$viewQuarantine = $rowsViewAdminAccess['quarantine'];
}else{
	$viewName = '';
	$viewEmailId = '';
	$viewAdminId = '';
	$viewEditStep = '';
	$viewAppStatusSubmit = '';
	$viewPal = '';
	$pal_generate = '';
	$viewLoaRqst = '';
	$viewLoaFees = '';
	$loafees_sbmt = '';
	$viewLoa = '';
	$viewStatus = '';
	$viewQuarantine = '';
}

if(($viewEditStep == '1') && mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){ ?>
	<script>$(document).ready(function(){ $('.Editdiv').show(); });</script>
<?php }else{
	if(($viewEditStep !== '1') && !mysqli_num_rows($resultViewAdminAccess) && ($email2323 !== $viewEmailId) ){ ?>
		<script>$(document).ready(function(){ $('.Editdiv').show(); });</script>
<?php }else{ ?>
		<script>$(document).ready(function(){ $('.Editdiv').hide(); });</script>
<?php }
}

if(($viewPal == '1') && mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){ ?>
	<script>$(document).ready(function(){ $('.oldiv').show(); });</script>
<?php }else{
	if(($viewPal !== '1') && !mysqli_num_rows($resultViewAdminAccess) && ($email2323 !== $viewEmailId) ){ ?>
		<script>$(document).ready(function(){ $('.oldiv').show(); });</script>
<?php }else{ ?>
		<script>$(document).ready(function(){ $('.oldiv').hide(); });</script>
<?php }
}

if(($viewLoaRqst == '1') && mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){ ?>
	<script>$(document).ready(function(){ $('.rqstLoadiv').show(); });</script>
<?php 
}else{
	if(($viewLoaRqst !== '1') && !mysqli_num_rows($resultViewAdminAccess) && ($email2323 !== $viewEmailId)){
	?>
		<script>$(document).ready(function(){ $('.rqstLoadiv').show(); });</script>
		<?php 
	}else{ ?>
		<script>$(document).ready(function(){ $('.rqstLoadiv').hide(); });</script>
	<?php } 
}

if(($viewLoaFees == '1') && mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){ ?>
	<script>$(document).ready(function(){ $('.loaFeedivCol').show(); });</script>
<?php 
}else{
	if(($viewLoaFees !== '1') && !mysqli_num_rows($resultViewAdminAccess) && ($email2323 !== $viewEmailId)){
	?>
		<script>$(document).ready(function(){ $('.loaFeedivCol').show(); });</script>
		<?php 
	}else{ ?>
		<script>$(document).ready(function(){ $('.loaFeedivCol').hide(); });</script>
	<?php } 
}

if(($viewLoa == '1') && mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){ ?>
	<script>$(document).ready(function(){ $('.loadivCol').show(); });</script>
<?php 
}else{
	if(($viewLoa !== '1') && !mysqli_num_rows($resultViewAdminAccess) && ($email2323 !== $viewEmailId)){
	?>
		<script>$(document).ready(function(){ $('.loadivCol').show(); });</script>
		<?php 
	}else{ ?>
		<script>$(document).ready(function(){ $('.loadivCol').hide(); });</script>
	<?php } 
}

if(($viewStatus == '1') && mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){ ?>
	<script>$(document).ready(function(){ $('.statusdiv').show(); });</script>
<?php 
}else{
	if(($viewStatus !== '1') && !mysqli_num_rows($resultViewAdminAccess) && ($email2323 !== $viewEmailId)){
	?>
		<script>$(document).ready(function(){ $('.statusdiv').show(); });</script>
		<?php 
	}else{ ?>
		<script>$(document).ready(function(){ $('.statusdiv').hide(); });</script>
	<?php } 
}

if(($viewQuarantine == '1') && mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){ ?>
	<script>$(document).ready(function(){ $('.quarantineDiv').show(); });</script>
<?php 
}else{
	if(($viewQuarantine !== '1') && !mysqli_num_rows($resultViewAdminAccess) && ($email2323 !== $viewEmailId)){
	?>
		<script>$(document).ready(function(){ $('.quarantineDiv').show(); });</script>
		<?php 
	}else{ ?>
		<script>$(document).ready(function(){ $('.quarantineDiv').hide(); });</script>
	<?php } 
}
if($sessionid1 == '1919'){
	$agent_id_not_show = '';
	$agent_user_table = '';
}else{
if(mysqli_num_rows($resultViewAdminAccess) && ($email2323 == $viewEmailId)){
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
}
?> 
<?php 
if(isset($_GET['imgMsg'])){
	$mssg =  base64_decode($_GET['imgMsg']);
	if(isset($mssg) == 'ImageUpload'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'You can upload only jpg and pdf file.'; ?>
		</div>
    </div>     
<?php } } 
if(isset($_GET['ploaMsg'])){
	$mssg =  base64_decode($_GET['ploaMsg']);
	if(isset($mssg) == 'LOAPayStatus'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-success' style="text-align:center;">
			<?php echo 'Your Status successfully Updated'; ?>
		</div>
    </div>     
<?php } } 
if(isset($_GET['msgalt'])){
	$mssg =  base64_decode($_GET['msgalt']);
	if(isset($mssg) == 'Donotpdf1'){ 
?>
<script>
$(document).ready(function(){    
    $("#yes_application_alert").modal('show');    
});
</script>	    
<?php } } 
if(!empty($_GET['noti']) && isset($_GET['noti'])){
	$notif =  $_GET['noti'];
	mysqli_query($con, "UPDATE `notification_aol` SET  `status`='0', `bgcolor`='#fff' WHERE `sno`='$notif'");
}
if(!empty($_GET['takenid']) && isset($_GET['takenid'])){
	$takenid =  $_GET['takenid'];
	mysqli_query($con, "UPDATE `notification_aol` set `action_taken`='Yes', `status`='0' where `sno`='$takenid'");
} ?>

<style>
input#searchbtn {
    float: right;
   left:100px; margin-left:40px;
    right: 0px; padding:5px 10px; margin-bottom:8px; margin-right:0px;

}
.alertdiv {
    margin-top: 126px;
    width: 100%;
    margin-bottom: -6%;
}
body { background:#eeee;}
.form-control.searchbtn_btn, .ui-menu .ui-menu-item-wrapper { font-size:14px;}
.ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front {height:250px; overflow-y:scroll;overflow-x:hidden;}
table thead tr th { text-align:left; }
</style>
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../css/fixed-table.css">
<script src="../../js/fixed-table.js"></script>
<?php
if(isset($_GET['srchstatus']) || isset($_GET['getsearch']) || isset($_GET['agentid'])){
	
$as = '';
$inputSearch = '';
$idTopSearch = '';
$agentsno = '';
$getsearch2 = '';
$srch_status_name = '';
$get_aid = '';
$orederby = '';

if(isset($_GET['srchstatus']) && !empty($_GET['srchstatus'])){
	$srch_status_name = $_GET['srchstatus'];
	
	// Full Name
	if($srch_status_name == 'ascfullname'){
		$as = "AND user_id!=''";
		$orederby = 'ORDER BY fname ASC';
	}
	if($srch_status_name == 'descfullname'){
		$as = "AND user_id!=''";
		$orederby = 'ORDER BY fname DESC';
	}
	
	// Application  Name
	if($srch_status_name == 'Pending'){
		$as = "AND admin_status_crs=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'Yes'){
		$as = "AND admin_status_crs='$srch_status_name'";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'No'){
		$as = "AND admin_status_crs='$srch_status_name'";
		$orederby = 'ORDER BY sno DESC';
	}
	
	
	//onshore/offshore
	if($srch_status_name == 'Onshore'){
		$as = "AND on_off_shore='$srch_status_name'";
		$orederby = 'ORDER BY sno DESC';
	}

	if($srch_status_name == 'Offshore'){

		$as = "AND on_off_shore='$srch_status_name'";

		$orederby = 'ORDER BY sno DESC';

	}
			
//application remarks

		if ($srch_status_name == 'remark_asc') {

			$as = "AND comments_datetime !=''";
			$orederby = 'ORDER BY comments_datetime ASC';
		}

		if ($srch_status_name == 'remark_desc') {

			$as = "AND comments_datetime !=''";
			$orederby = 'ORDER BY comments_datetime DESC';
		}

	// Conditional Offer Letter
	if($srch_status_name == 'col_Pending'){
		$as = "AND admin_status_crs='Yes' AND ol_confirm='' AND offer_letter=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'col_Generated'){
		$as = "AND admin_status_crs='Yes' AND offer_letter !='' AND ol_type=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'cond_COL_Generated'){
		$as = "AND admin_status_crs='Yes' AND ol_processing='Conditional COL' AND offer_letter !=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'final_COL_Generated'){
		$as = "AND admin_status_crs='Yes' AND ol_processing='Final COL' AND offer_letter !='' AND ol_type!=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'col_Sent'){
		$as = "AND admin_status_crs='Yes' AND ol_confirm ='1'";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'col_Recieved'){
		$as = "AND admin_status_crs='Yes' AND agreement !=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'col_Confirmed'){
		$as = "AND admin_status_crs='Yes' AND signed_ol_confirm='Yes'";
		$orederby = 'ORDER BY sno DESC';
	}
	
	
	// LOA Request Status
	if($srch_status_name == 'lrs_Pending'){
		$as = "AND file_receipt=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'lrs_rs'){
		$as = "AND file_receipt !='' AND loa_tt=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'lrs_rs_with'){
		$as = "AND file_receipt !='' AND loa_tt!=''";
		$orederby = 'ORDER BY sno DESC';
	}	
	
	// LOA Fee
	if($srch_status_name == 'fee_pending'){
		$as = "AND prepaid_fee=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'fee_yes'){
		$as = "AND prepaid_fee='Yes'";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'fee_no'){
		$as = "AND prepaid_fee='No'";
		$orederby = 'ORDER BY sno DESC';
	}
	
	// Upload LOA
	if($srch_status_name == 'fee_asc'){
		$as = "AND loa_file !=''";
		$orederby = 'ORDER BY sno ASC';
	}
	if($srch_status_name == 'fee_desc'){
		$as = "AND loa_file !=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'loa_Pending'){
		$as = "AND loa_file=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'loa_g'){
		$as = "AND loa_file !=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'loa_s'){
		$as = "AND loa_file_status ='1'";
		$orederby = 'ORDER BY sno DESC';
	}
	
	// V-G / V-R Details
	if($srch_status_name == 'fh_lodeged'){
		$as = "AND loa_file_status='1' AND fh_status !='' AND v_g_r_status=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if(($srch_status_name == 'fh_not_lodeged')){
		$as = "AND loa_file_status='1' AND fh_status ='' AND v_g_r_status=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if(($srch_status_name == 'fh_Re_Lodged')){
		$as = "AND loa_file_status='1' AND fh_status !='' AND fh_re_lodgement='Re_Lodged' AND v_g_r_status=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_VG'){
		$as = "AND v_g_r_status ='V-G' AND fh_status!=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_VR'){
		$as = "AND v_g_r_status ='V-R' AND fh_status!=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_Commission_Details_Invoice_pending_admin'){
		$as = "AND v_g_r_status='V-G' and v_g_r_invoice='' AND inovice_status=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_Commission_Details_Invoice_send_admin'){
		$as = "AND v_g_r_status='V-G' and v_g_r_invoice !='' AND inovice_status=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_Commission_Details_Invoice_status_prcd_Agent'){
		$as = "AND v_g_r_status='V-G' and v_g_r_invoice !='' and inovice_status='Yes'";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_Commission_Details_Invoice_status_not_prcd_Agent'){
		$as = "AND v_g_r_status='V-G' and v_g_r_invoice !='' and inovice_status='No'";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_rfnd_rqst_recieved'){
		$as = "AND v_g_r_status ='V-R' AND file_upload_vr_status ='Yes' AND file_upload_vgr_status=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vgr_rfnd_docs_not_approved'){ 
		$as = "AND v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='No' AND tt_upload_report_status=''";	
		$orederby = 'ORDER BY sno DESC';		
	}
	if($srch_status_name == 'vrg_rfnd_rqst_prcd'){
		$as = "AND v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND tt_upload_report_status=''";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_rfnd_rqst_not_prcd'){
		$as = "AND v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND tt_upload_report_status='No'";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_rfnd_rqst_prcd_report'){
		$as = "AND v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND settled_vr='Settled' AND tt_upload_report_status='Yes'";
		$orederby = 'ORDER BY sno DESC';
	}
	if($srch_status_name == 'vrg_rfnd_rqst_prcd_report_not'){
		$as = "AND v_g_r_status ='V-R' AND file_upload_vr_status='Yes' AND file_upload_vgr_status='Yes' AND settled_vr='Not Settled' AND tt_upload_report_status='Yes'";
		$orederby = 'ORDER BY sno DESC';
	}	
}

/////////////
if(isset($_GET['getsearch']) && !empty($_GET['getsearch'])){
	$getsearch2 = $_GET['getsearch'];
	$inputSearch = "AND (CONCAT(fname,  ' ', lname) LIKE '%$getsearch2%' OR refid LIKE '%$getsearch2%' OR student_id LIKE '%$getsearch2%' OR dob LIKE '%$getsearch2%' OR passport_no LIKE '%$getsearch2%')";
	$orederby = 'ORDER BY sno DESC';
}

/////////////
if(isset($_GET['agentid']) && !empty($_GET['agentid'])){
	$get_aid = $_GET['agentid'];
	$agentsno = "AND user_id='$get_aid'";
	$orederby = 'ORDER BY sno DESC';
}

}else{
	$as = '';
	$orederby = 'ORDER BY sno DESC';
	$inputSearch = '';
	$agentsno = '';
	$getsearch2 = '';
	$get_aid = '';
	$srch_status_name = '';
}

$total_records_per_page = 120;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

if(isset($_GET['aid']) && !empty($_GET['aid'])){
	$get_aid = $_GET['aid'];
	$expVal = explode("error_", $get_aid);			
	$result3 = "SELECT COUNT(*) As total_records FROM st_application where academic_status='1' AND course_status='1' AND application_form='1' AND flowdrp!='Drop' AND user_id!='1001' $agent_id_not_show $as";		
}else{
	$result3 = "SELECT COUNT(*) As total_records FROM st_application where academic_status='1' AND course_status='1' AND application_form='1' AND user_id!='1001' $agent_id_not_show $as $agentsno $inputSearch";
}

$result2 = mysqli_query($con, $result3);
$total_records = mysqli_fetch_array($result2);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1
?>

<section class="container-fluid">
<div class="main-div">
<h3 class="mt-1">All Application
<?php
if($email2323 == 'admin@acc.com' || $email2323 == 'acc_admin' || $email2323 == "viewdocs@acc.com"){
?>
	<form class="float-right" action="ApplicationExcelDownload.php" method="post">
		<button type="submit" name="submit" class="btn btn-success btn-sm float-right mt-sm-1 mr-3">Excel Download</button>
	</form>
<?php } ?>
</h3> 
<div class="col-lg-12 admin-dashboard content-wrap">

<div class="row">	
	<div class="col-sm-3 mb-3">	
	<select class="form-control form-control-sm applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>">
		<option value="">Filter By</option>
		<option style="color:red;" disabled>Student Name</option>
		<option value="" data-id="ascfullname">Sort By ASC</option>
		<option value="" data-id="descfullname">Sort By DESC</option>
		<option style="color:red;" disabled>Application Status</option>
		<option value="" data-id="Pending">Pending</option>
		<option value="" data-id="Yes">Approved</option>
		<option value="" data-id="No">Not-Approved</option>
		<option style="color:red;" disabled>Onshore/OffShore</option>
		<option value="" data-id="Onshore">Onshore</option>
		<option value="" data-id="Offshore">OffShore</option>

		<option style="color:red;" disabled>Application Remarks</option>
		<option value="" data-id="remark_asc">Date By ASC</option>
		<option value="" data-id="remark_desc">Date By DESC</option>
				
		<option style="color:red;" disabled>COL</option>		
		<option value="" data-id="col_Pending">Pending</option>
		<option value="" data-id="cond_COL_Generated">Conditional COL Generated</option>
		<option value="" data-id="final_COL_Generated">Final COL Generated</option>
		<option value="" data-id="col_Generated">First Time Generated</option>
		<option value="" data-id="col_Sent">Sent</option>
		<option value="" data-id="col_Recieved">Recieved</option>
		<option value="" data-id="col_Confirmed">Confirmed</option>
		
		<option style="color:red;" disabled>LOA Rqst Status</option>
		<option value="" data-id="lrs_Pending">Pending</option>
		<option value="" data-id="lrs_rs">Rqust Without TT</option>
		<option value="" data-id="lrs_rs_with">Rqust With TT</option>
		<option style="color:red;" disabled>Fee Status</option>		
		<option value="" data-id="fee_pending">Pending</option>
		<option value="" data-id="fee_yes">Yes</option>
		<option value="" data-id="fee_no">No</option>
		<option style="color:red;" disabled>LOA</option>
		<option value="" data-id="fee_asc">Date By ASC</option>
		<option value="" data-id="fee_desc">Date By DESC</option>
		<option value="" data-id="loa_Pending">Pending</option>
		<option value="" data-id="loa_g">Generated</option>
		<option value="" data-id="loa_s">Sent</option>
		
		<option style="color:red;" disabled>Status</option>
		<option value="" data-id="fh_lodeged">File Lodged</option>
		<option value="" data-id="fh_not_lodeged">File Not Lodged</option>
		<option value="" data-id="fh_Re_Lodged">File Re-Lodged</option>
		<option value="" data-id="vrg_VG">V-G</option>
		<option value="" data-id="vrg_VR">V-R</option>
		<option value="" data-id="vrg_Commission_Details_Invoice_pending_admin">Com Inv Pending</option>
		<option value="" data-id="vrg_Commission_Details_Invoice_send_admin">Com Inv Sent</option>
		<option value="" data-id="vrg_Commission_Details_Invoice_status_prcd_Agent">Com Settled</option>
		<option value="" data-id="vrg_Commission_Details_Invoice_status_not_prcd_Agent">Com not aprvd</option>			
		<option value="" data-id="vrg_rfnd_rqst_recieved">Rfd Rqst Rcvd(Status Pdng)</option>	
		<option value="" data-id="vgr_rfnd_docs_not_approved">Rfnd Docs Not Aprvd</option>		
		<option value="" data-id="vrg_rfnd_rqst_prcd">Refund Docs Approved</option> 
		<option value="" data-id="vrg_rfnd_rqst_not_prcd">Refund not aprvd</option>
		<option value="" data-id="vrg_rfnd_rqst_prcd_report">Refund Approved(Settled)</option>
		<option value="" data-id="vrg_rfnd_rqst_prcd_report_not">Refund Approved(Not Settled)</option>
	</select>
	</div>
	<div class="col-sm-3 mt-2">
	<?php 
	  if(!empty($_GET['did'])){ $guid = $_GET['did']; }else{ $guid = '';}
	  $result4 = mysqli_query($con, "SELECT sno, username FROM allusers where role='Agent' $agent_user_table ORDER BY username"); ?>
		<select class="form-control form-control-sm agentuname">
			<option value="">Filter By Agent</option>
			<?php while($rowUname = mysqli_fetch_assoc($result4)){
			$usno = $rowUname['sno'];
			?>
			<option value="<?php echo $usno; ?>" <?php if($usno == $guid) { echo 'selected="selected"'; } ?>><?php echo $rowUname['username']; ?></option>
		<?php } ?>
		</select>				
	</div>
	
	<div class="col-sm-6 mt-2 mt-sm-0 text-right mb-3">
	<div class=" search-col">
	<form method="post" action=""> 
	
		<input type="text" id="searchbtn_btn" class="searchbtn_btn ui-autocomplete-input form-control-sm" placeholder="Search by Name,DOB,RefId, Passport No. &amp; Student Id" name="search" style="border: 1px solid #333;width: 76%;border-top-left-radius: 6px;  border-bottom-left-radius: 6px;padding: 5px;margin:0px 0 0; font-size: 14px;" autocomplete="off">		
	
		<input type="submit" name="srchClickbtn" class=" btn-danger btn-submit" value="Search" style="background: #2c79b3 !important;
    border: none;color: #fff;padding: 6px;margin: 0 0px 0 -8px;font-size: 14px;border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;cursor: pointer;">
	
	</form>
	</div>
	</div>
	
	</div>

<div class="loading_icon"></div>
    <div id="fixed-table-container-1" class="fixed-table-container">
	<table class="table table-sm table-bordered" width="100%">
    <thead>
      <tr class="text-white" bgcolor="#333">
        <th><input type="checkbox"></th>	
        <th>Student Name</th>
        <th>RefId StuId</th>
        <th>Agent Name</th>
	<?php if($roles1 !== 'Excu1'){ ?>
        <th>Application Status</th>
        <th class="oldiv">COL</th>
	<?php } 
		if(($roles1 == 'Admin') || ($roles1 !== 'Excu') || ($roles1 == 'Excu1')){ ?>
	    <th class="rqstLoadiv">LOA Rqst Status</th>
        <th class="loaFeedivCol">LOA Fee</th>
        <th class="loadivCol">LOA</th>
        <th class="statusdiv">PAL & Status</th>
	<?php } ?>
        <th class="quarantineDiv">Signed Qrn. Plan</th>
	  </tr>
    </thead>	
    <tbody id="totalshow" class="searchall">     	  
	<?php
	if(isset($_GET['aid']) && !empty($_GET['aid'])){
		$get_aid2 = $_GET['aid'];
		$expVal2 = explode("error_", $get_aid2);			
		$result4 = "(SELECT * FROM st_application where academic_status='1' AND course_status='1' AND application_form='1' AND user_id!='1001' AND sno='$expVal2[1]' $agent_id_not_show LIMIT $offset, $total_records_per_page) UNION (SELECT * FROM st_application where academic_status='1' AND course_status='1' AND application_form='1' AND user_id!='1001' AND sno !='$expVal2[1]' $agent_id_not_show order by sno DESC LIMIT $offset, $total_records_per_page)";		
	}else{
		$result4 = "SELECT * FROM st_application where academic_status='1' AND course_status='1' AND application_form='1' AND user_id!='1001' $agent_id_not_show $as $agentsno $inputSearch $orederby LIMIT $offset, $total_records_per_page";
	}
	// print_r($result4);
	$result2 = mysqli_query($con, $result4);
	while ($row = mysqli_fetch_assoc($result2)) {
		$snoall = mysqli_real_escape_string($con, $row['sno']);
		$user_id = mysqli_real_escape_string($con, $row['user_id']);
		$refid = mysqli_real_escape_string($con, $row['refid']);
		$student_id = mysqli_real_escape_string($con, $row['student_id']);
		$fname = mysqli_real_escape_string($con, $row['fname']);			
		$lname = mysqli_real_escape_string($con, $row['lname']);			
		$dob = mysqli_real_escape_string($con, $row['dob']);
		$dob_1 = date("F j, Y", strtotime($dob)); 
		$datetime = mysqli_real_escape_string($con, $row['datetime']);
		$passport_no = mysqli_real_escape_string($con, $row['passport_no']);
		$on_off_shore = mysqli_real_escape_string($con, $row['on_off_shore']);
		$prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
		$prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);
		$admin_status_crs = mysqli_real_escape_string($con, $row['admin_status_crs']);
		$admin_remark_crs = mysqli_real_escape_string($con, $row['admin_remark_crs']);
		$ol_confirm = mysqli_real_escape_string($con, $row['ol_confirm']);
		$signed_ol_confirm = mysqli_real_escape_string($con, $row['signed_ol_confirm']);
		$ol_processing = mysqli_real_escape_string($con, $row['ol_processing']);
		$offer_letter = mysqli_real_escape_string($con, $row['offer_letter']);
		$file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);
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
		$fh_status = mysqli_real_escape_string($con, $row['fh_status']);
		$v_g_r_status = mysqli_real_escape_string($con, $row['v_g_r_status']);
		$v_g_r_invoice = mysqli_real_escape_string($con, $row['v_g_r_invoice']);
		$inovice_status = mysqli_real_escape_string($con, $row['inovice_status']);
		$file_upload_vr_status = mysqli_real_escape_string($con, $row['file_upload_vr_status']);
		$file_upload_vgr_status = mysqli_real_escape_string($con, $row['file_upload_vgr_status']);
		$tt_upload_report_status = mysqli_real_escape_string($con, $row['tt_upload_report_status']);
		$flowdrp = mysqli_real_escape_string($con, $row['flowdrp']);
		$follow_stage = mysqli_real_escape_string($con, $row['follow_stage']);
		$loa_tt = mysqli_real_escape_string($con, $row['loa_tt']);
		$quarantine_plan = mysqli_real_escape_string($con, $row['quarantine_plan']);

		$agnt_qry = mysqli_query($con, "SELECT username, email, agent_email, mobile_no, alternate_mobile, original_pass, country, created_by_id FROM allusers where sno='$user_id'");
		$row_agnt_qry = mysqli_fetch_assoc($agnt_qry);
		$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
		$email_username = mysqli_real_escape_string($con, $row_agnt_qry['email']);
		$agent_email = mysqli_real_escape_string($con, $row_agnt_qry['agent_email']);
		$mobile_no = mysqli_real_escape_string($con, $row_agnt_qry['mobile_no']);
		$alternate_mobile = mysqli_real_escape_string($con, $row_agnt_qry['alternate_mobile']);
		$original_pass = mysqli_real_escape_string($con, $row_agnt_qry['original_pass']);
		$countryAgent = $row_agnt_qry['country'];
		$created_by_id = $row_agnt_qry['created_by_id'];
		
		$qrySalesMngr = "SELECT sno, name FROM `admin_access` where admin_id='$created_by_id'";
		$rsltSalesMngr = mysqli_query($con, $qrySalesMngr);
		if(mysqli_num_rows($rsltSalesMngr)){
			$rowSalesMngr = mysqli_fetch_assoc($rsltSalesMngr);
			$salesName = $rowSalesMngr['name'];
		}else{
			$salesName = 'Delta Immigration Admin';
		}
		
		if(!empty($on_off_shore)){
			$onshoreDiv = '<br>'.$on_off_shore.' Student';
		}else{
			$onshoreDiv = '';
		}		

		$qryCntRemarks = "SELECT sno FROM `application_remarks` where comments_color='#f9d5d5' AND app_id='$snoall'";
							$rsltCntRemarks = mysqli_query($con, $qryCntRemarks);
							if (mysqli_num_rows($rsltCntRemarks)) {
								$myRemarksTotal = mysqli_num_rows($rsltCntRemarks);
							} else {
								$myRemarksTotal = '';
							}
	?>
	<tr class="error_<?php echo $snoall;?>">
        <td>
		<input type="checkbox" id="error_<?php echo $snoall;?>" />
		</td>
		<td>
		    <span data-toggle="collapse" data-target="#demo_<?php echo $snoall;?>" class="accordion-toggle collapsed text-success float-left mt-2 mr-2">
		    </span>
		    <a class="text-danger" href="../followup/add.php?stusno=<?php echo $snoall; ?>" target="_blank">
				<?php echo $fname.' '.$lname;?></a>
				<br><?php echo $dob_1;?>
		</td>
		<td><?php echo $refid.'<br>'.$student_id;?></td>
		<td><?php echo $agntname; ?></td>
	<?php if($roles1 !== 'Excu1'){ ?>
		<td style="white-space:nowrap;">
		<span class="btn btn-success btn-sm divAppRemarks" data-toggle="modal" data-target="#modalAppRemarks" data-id="<?php echo $snoall; ?>"><i class="far fa-comment-alt" data-toggle="tooltip" data-placement="top" title="Application Remarks"></i></span><span class="badge badge-pill badge-danger divAppRemarks-bdge"><?php echo $myRemarksTotal; ?></span>
		<a href="edit.php?apid=<?php echo base64_encode($snoall); ?>" class="btn edit-aplic btn-sm Editdiv"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Application"></i>
		</a>
		
		<span class="btn btn-sm jmjm" data-toggle="modal" title="View" data-target="#myModaljjjs" data-id="<?php echo $snoall; ?>"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>
        <?php if($admin_status_crs == ""){ ?>
	    <span class="btn btn-sm confirmbtn1 checklistClassyellow" data-toggle="modal" data-target="#confirmbtn2" data-id="<?php echo $snoall; ?>"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Update Application Status (No Action)"></i></i></span>
        <?php } if($admin_status_crs == "No"){ ?>
	    <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="<?php echo $snoall; ?>"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Application Not Approved"></i></i></span>
        <?php }
		if($admin_status_crs == "Not Eligible"){ ?>
	    <span class="btn btn-sm confirmbtn1 checklistClassred" data-toggle="modal" data-target="#confirmbtn2" data-id="<?php echo $snoall; ?>"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Not Eligible"></i></i></span>
        <?php } 
		if($admin_status_crs == "Yes"){	?>
	    <span class="btn btn-sm confirmbtn1 checklistClass" data-toggle="modal" data-target="#confirmbtn2" data-id="<?php echo $snoall; ?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Application Approved (Processing Offer Letter)"></i></i></span>
        <?php } ?>		
		<?php echo $onshoreDiv; ?>
		</td>
		<td class="oldiv">
		<?php		
		if(($admin_status_crs == 'No') || ($admin_status_crs == '') || ($admin_status_crs == 'Not Eligible')){ 
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
		}		
		if(($admin_status_crs == 'Yes') && ($offer_letter == '') && ($ol_confirm == '')){ ?>
			<div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate Offer Letter"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '')){ ?>
			<div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Generated (Send)"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){ ?>
			<div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Offer Letter Sent (Sign Pending)"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){ ?>
			<div class="btn btn-sm checklistClassyellow olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Sent (Status Pending)"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No') ){ ?>
			<div class="btn btn-sm checklistClassred olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Not Approved"></i></div>		
		<?php }
		
		if(($admin_status_crs == 'Yes') && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes') ){ ?>
			<div class="btn btn-sm checklistClassgreen olClass" data-toggle="modal" data-target="#olModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Offer Letter Approved (Request LOA)"></i></div>		
		<?php }	?>
		</td>
	<?php } 
		if(($roles1 == 'Admin') || ($roles1 !== 'Excu') || ($roles1 == 'Excu1')){ ?>
		<td class="rqstLoadiv">
		<?php if(($signed_ol_confirm !== 'Yes') && ($file_receipt == '')){ ?>
		<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span>
		<?php } 
		if(($signed_ol_confirm == 'Yes') && ($file_receipt == '')){ ?>
		<span class="btn btn-sm checklistClassyellow loaRqstClass" data-toggle="modal" data-target="#loaRqstModel" data-id="<?php echo $snoall; ?>" data-toggle="tooltip" data-placement="top" data-original-title="LOA Not Requested">Request LOA</span>
		<?php }       
        if(($file_receipt !== '') && ($loa_tt == '')){ ?>
		<div class="btn btn-sm checklistClassgreen loaRqstClass" data-toggle="modal" data-target="#loaRqstModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Request Sent Without TT"></i></div>
		<?php }  
		if(($file_receipt !== '') && ($loa_tt !== '')){ ?>	
		<!--div class="btn checklistClassgreen btn-sm"><a style="color:#fff;" href='../../uploads/<?php //echo $loa_tt; ?>' download> <i class="fas fa-download" data-toggle="tooltip" data-placement="top" title="LOA Request Sent With TT"></i></a></div-->
		
		<div class="btn btn-sm checklistClassgreen loaRqstClass" data-toggle="modal" data-target="#loaRqstModel" data-id="<?php echo $snoall; ?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Request Sent With TT"></i></div>
		<?php } ?>				
		</td>
		<td class="loaFeedivCol">
		<?php
		// if((($signed_al_status == '') || ($signed_al_status == 'No')) && ($prepaid_fee == '')){
		if(($file_receipt == '') && ($prepaid_fee == '')){
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';		
		}
		// if(($signed_al_status == 'Yes') && ($prepaid_fee == '')){
		if(($file_receipt == '1') && ($prepaid_fee == '')){
		?>
		<div class="btn checklistClassred btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id="<?php echo $snoall;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Pending)"></i></div>
		<?php }
		if(($file_receipt == '1') && ($prepaid_fee == 'No')){ ?>
		<div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id="<?php echo $snoall;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(No)"></i></div>
		<?php }
		if(($file_receipt == '1') && ($prepaid_fee == 'Yes')){ ?>
		<div class="btn checklistClassgreen btn-sm prepaidClass" data-toggle="modal" data-target="#prepaidClassModel" data-id="<?php echo $snoall;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Fee(Yes)"></i></div>
		<?php }
		?>
		</td>
<!-- // Generate LOA  -->
		<td class="loadivCol">
		<?php
		if(($ol_processing == '') && ($prepaid_fee == '') && ($loa_file == '') && ($loa_file_status == '')){
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';		
		}
		if(($ol_processing == 'Conditional COL') && ($prepaid_fee == '') && ($loa_file == '') && ($loa_file_status == '')){
			echo '<span class="btn btn-sm checklistClassyellow"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Final COL Pending, Please meet the Conditions"></i></span>';		
		}
		if(($ol_processing == 'Conditional COL') && ($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status !== '')){
			echo '<span class="btn btn-sm checklistClassyellow"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Final COL Pending, Please meet the Conditions"></i></span>';		
		}
		if(($ol_processing == 'Final COL') && ($prepaid_fee == '') && ($loa_file == '') && ($loa_file_status == '')){
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';		
		}
		if(($ol_processing == 'Final COL') && ($prepaid_fee !== '') && ($loa_file == '') && ($loa_file_status == '')){ ?>
		<div class="btn checklistClassyellow btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate LOA"></i></div>
		<?php }		
		if(($ol_processing == 'Final COL') && ($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '')){ ?>
		<div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="LOA Generated"></i></div>
		<?php }
		if(($ol_processing == 'Final COL') && ($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '1')){
		?>
		<span class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Sent"></i></span>
		<?php }	?>	
		</td>
<!--- Drop --->
		<?php if($flowdrp == 'Drop'){ ?>
		<td class="statusdiv"><b>Satus:</b> Drop<br>
		<b>Stage:</b> <?php 
		if($follow_stage == 'FH_Sent'){
			echo 'F@H';
		}else{
			echo $follow_stage;
		}; ?>
		</td>
	<?php }
		if($flowdrp == 'Drop'){
			echo '<td class="statusdiv"><span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span></td>';
		}else{
		?>		
		
<!---// V-G/V-R  --->
		<td class="statusdiv">
		<?php
		if(($loa_file_status == '') && ($fh_status == '') && ($v_g_r_status == '')){
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status == '')){
			echo '<div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status !== '')){
			echo '<div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div>';
		}
		if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status == '')){
			echo '<div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id='.$snoall.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Lodged"></i></div>';
		}
	
		//}
	// V-G	
		if(($ol_processing == 'Final COL') && ($fh_status !== '') && ($v_g_r_status == 'V-G')){
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice =='') && ($inovice_status =='')){
		?>
		<div class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-G Status(Invoice Pending)"></i></div>
		<?php }
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='')){		
		?>
		<div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="V-G Invoice Processed"></i></div>
		<?php }
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='Yes')){	
		?>
		<div class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Processed by Processor"></i></div>
		<?php }
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='No')){
		?>
		<div class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Not Processed by Processor"></i></div>
		<?php } ?>
		<?php } 
	// V-R	
		if(($ol_processing == 'Final COL') && ($fh_status !== '') && ($v_g_r_status == 'V-R')){ 
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status =='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
		?>
		<span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-R Status(Refund Docs Pending From Agent)"></i></span>
		<?php }
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == '') && ($tt_upload_report_status == '')){
		?>
		<span class="btn checklistClassyellow btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Refund Docs Recvd.(Status Pending)"></i></span>
		<?php }		
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == '')){
		?>
		<span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Processed to processor"></i></span>
		<?php }
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'No') && ($tt_upload_report_status == '')){
		?>
		<span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Docs Not Approved"></i></span>
		<?php }
		
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'No')){
		?>
		<span class="btn checklistClassred btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund not approved by processor"></i></span>
		<?php }
		
		
		if(($v_g_r_status == 'V-R') && ($file_upload_vr_status !=='') && ($file_upload_vgr_status == 'Yes') && ($tt_upload_report_status == 'Yes')){
		?>
		<span class="btn checklistClassgreen btn-sm vgrStatusClass" data-toggle="modal" data-target="#vgrStatusModel" data-id="<?php echo $snoall;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Refund Approved(Download TT)"></i></span>
		<?php } } ?>
		</td>		
		<td class="quarantineDiv">
		<?php if(!empty($quarantine_plan) && ($v_g_r_status == 'V-R')){ ?>
			<a href="../../uploads/<?php echo $quarantine_plan; ?>" class="btn btn-sm btn-outline-success" download><i class="fas fa-download" data-toggle="tooltip" data-placement="top" title="Signed International Student Quarantine Plan"></i></a>
		<?php }else{ 
			echo '<span class="btn-outline-danger btn btn-sm btn-pending"><i class="fas fa-times"  data-toggle="tooltip" data-placement="top" title="No Action Made"></i></span>';
		}?>
		</td>
	<?php } } ?>
	</tr>
	
	<tr>
        <td colspan="11" class="p-0 border-0 hiddenRow">
		<div class="accordian-body collapse m-0" id="demo_<?php echo $snoall;?>"> 
		<table width="100%" border="0">
		<tbody>
        <tr>
			<td></td>
			<td>ID/ Ref ID</td>
		   <td>
			<?php echo $student_id; ?>
			<?php if($flowdrp == 'Drop'){ ?>
			<a href="javascript:void(0)" class="dropClass" data-toggle="modal" data-target="#dropModel" data-id="<?php echo $snoall; ?>">
			<?php echo $refid;?></a>
			<?php }else{
				echo $refid;
			}
			?>			
			</td>
		</tr>
		<tr>
			<td></td>
			<td>Passport Number</td>
			<td><?php echo $passport_no;?></td>
		</tr>
		<?php if($email2323 == 'admin@acc.com' || $email2323 == 'operation@acc' || $email2323 == 'acc_admin'){ ?>
		<tr>
			<td></td>
			<td>Agent Email Id</td>
			<td><?php echo $agent_email;?></td>
		</tr>
		<tr>
			<td></td>
			<td>Agent Number</td>
			<td><?php echo $mobile_no.' '.$alternate_mobile;?></td>
		</tr>
		<tr>
			<td></td>
			<td>Agent Username / Password</td>
			<td><?php echo $email_username.' / '.$original_pass;?></td>
		</tr>
		<tr>
			<td></td>
			<td>Agent Country</td>
			<td><?php echo $countryAgent;?></td>
		</tr>
		<?php } ?>
		<tr>
			<td></td>
			<td>Sales Manager Name</td>
			<td><?php echo $salesName;?></td>
		</tr>
		<tr>
			<td></td>
			<td>Created On</td>
			<td><?php echo $datetime;?></td>
		</tr>
        </tbody>
        </table> 
		</div> 
		</td>
        </tr>
	<?php } ?>
    </tbody>	
 </table> 
</div>

<div class="row">
<div class="col-md-8 mt-2 pl-3">
	<strong>Total Records <?php echo $total_records; ?>, </strong>
	<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>
<div class="col-md-4 mt-2">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-end"> 
	<li <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid'"; } ?> class="page-link"><i class="fas fa-angle-double-left"></i></a>
	</li>       

    <?php 

	if ($total_no_of_pages <= 10){  	 

		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){

			if ($counter == $page_no) {

		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	

				}else{

           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$counter</a></li>";

				}

        }

	}

	elseif($total_no_of_pages > 10){

		

	if($page_no <= 4) {			

	 for ($counter = 1; $counter < 8; $counter++){		 

			if ($counter == $page_no) {

		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	

				}else{

           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$counter</a></li>";

				}

        }

		echo "<li class='page-item'><a class='page-link'>...</a></li>";

		echo "<li class='page-item'><a href='?page_no=$second_last&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$second_last</a></li>";

		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$total_no_of_pages</a></li>";

		}



	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 

		echo "<li class='page-item'><a href='?page_no=1&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>1</a></li>";

		echo "<li class='page-item'><a href='?page_no=2&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>2</a></li>";

        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			

           if ($counter == $page_no) {

		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	

				}else{

           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$counter</a></li>";

				}                  

       }

       echo "<li class='page-item'><a class='page-link'>...</a></li>";

	   echo "<li class='page-item'><a href='?page_no=$second_last&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$second_last</a></li>";

	   echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$total_no_of_pages</a></li>";      

            }

		

		else {

        echo "<li class='page-item'><a href='?page_no=1&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>1</a></li>";

		echo "<li class='page-item'><a href='?page_no=2&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>2</a></li>";

        echo "<li class='page-item'><a class='page-link'>...</a></li>";



        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {

          if ($counter == $page_no) {

		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	

				}else{

           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>$counter</a></li>";

				}                   

                }

            }

	}

?>

    

	<li <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>

	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid'"; } ?> class='page-link'><i class="fas fa-angle-double-right"></i></a>

	</li>

    <?php if($page_no < $total_no_of_pages){

		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$srch_status_name&getsearch=$getsearch2&agentid=$get_aid' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";

		} ?>

</ul>
</nav>
</div>
</div>

	
</div>
</div>
</section>

<div class="modal fade main-modal" id="confirmbtn2" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Application Status</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
<div class="loading_icon"></div>
<?php
if($viewAppStatusSubmit != '2'){
?>

<form method="post" action="../mysqldb.php">
<div class="row">
		 <div class="col-sm-12">	
		 	<h3 style="font-size:22px;">Update Application Status and Course</h3>  
		 	</div>   
	 <div class="col-sm-6">

	 	<strong>Campus </strong>:
		<select name="campus" class="form-control campusDiv mb-3" required>
			<option value="">Select Campus</option>
			<?php 
			$campusFetch = mysqli_query($con, "Select campus from contract_courses group by campus");
			while ($rowCampus = mysqli_fetch_assoc($campusFetch)) {
				$campusVal = $rowCampus['campus'];
			?>
			<option value="<?php echo $campusVal; ?>"><?php echo $campusVal; ?></option>
			<?php } ?>
		</select>
	</div>
	 <div class="col-sm-6">
	 		<strong>Intake </strong>:
		<select name="intake" class="form-control intkeAppend mb-3" data-campus="" required>
			<option value="">Select Intake</option>
		</select>
	</div>
	 <div class="col-sm-6">
		<strong>Program Type:</strong>
		<select name="prg_name1" class="form-control prgmAppend mb-3" required>
			<option value="">Select Option</option>			
		</select>
	</div>
	 <div class="col-sm-6">
		<strong> Status </strong>: 
		<select name="admin_status_crs" class="form-control mb-3" required>
			<option value="">Select Option</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
			<option value="Not Eligible">Not Eligible</option>
		</select>	</div>
		 <div class="col-sm-12">	
		<strong>Remarks </strong>: 
		<textarea name="admin_remark_crs" class="form-control  mb-3" required></textarea>		
	</div>
	</div>
    <p>
	<input type="hidden" name="rowbg1" class="rowbg1" value="<?php if(!empty($_GET['tab'])){ echo $_GET['tab']; } ?>">
	<input type="hidden" name="snoid" class="ssid" value="">
	<input type="submit" name="appbtncrs" class="btn btn-submit float-right mb-4">
	</p>  
	<br>  
</form>
<?php } ?>

 <div class="remarkShow"></div>
</div>

</div>
</div>
</div>

<div class="modal fade main-modal" id="olModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" >Conditional Offer Letter</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="row">
<div class="col-sm-12">
<div class="loading_icon"></div>
<div id="oldownload" class="mt-0"></div>

<?php
if($pal_generate == '2'){
	
}else{
?>
<form method="post" action="../mysqldb.php">
<p><b>Update Status</b></p>
<select name="signed_ol_confirm" class="form-control col-sm-12" required>
<option value="">Select Option</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select><br>
<textarea name="signed_ol_remarks" class="form-control col-sm-12" required></textarea><br>
<input type="hidden" name="rowbg1" class="rowbg1" value="<?php if(!empty($_GET['tab'])){ echo $_GET['tab']; } ?>">
<input type="hidden" name="snid" class="olsnid" value="">
<input type="submit" name="SignedolBtn" value="Submit" class="btn btn-sm btn-success">
</form>
<?php } ?>
<div id="agdownload" class="mt-3"></div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<div class="modal fade" id="loaRqstModel" role="dialog">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
	<h5 class="modal-title">Request LOA</h5>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="getLOAList"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

<div class="modal fade main-modal" id="prepaidClassModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Loa Fee Status</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div class="col-sm-12 mt-3">


<?php if($loa_allow == '1' || $loafees_sbmt !== '2'){ ?>
<form method="post" class="row" action="../mysqldb.php" id="loaFeeBtnForm">
	<div class=" col-sm-6">
<label>Prepaid Fee Status : </label>
<select name="prepaid_fee" class="form-control form-control-sm pfDiv is_require4">
<option value="">Select Status</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</div>
<?php
if($headid == '1700'){
?>
<input type="hidden" name="prepaid_remarks" value="">
<?php 
}else{
?>
<div class="feeClassDiv  col-sm-6" style="display:none;">
<label>Fee Amount : </label>
<input type="text" name="prepaid_remarks" class="form-control form-control-sm">
</div>
<?php } ?>
<div class=" col-sm-6 mt-2 mt-sm-4 pt-sm-2">
<input type="hidden" name="rowbg1" class="rowbg1" value="<?php if(!empty($_GET['tab'])){ echo $_GET['tab']; } ?>">
<input type="hidden" name="snid" class="feesnid" value="">
<input type="submit" name="loaFeeBtn" value="Submit" class="btn btn-sm btn-success float-right float-sm-left">
</div>
</form><br />
<?php } ?>
<div class="loaFeediv"></div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

<div class="modal fade main-modal" id="genrateModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Generate LOA</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body pt-0">
<div class="loading_icon"></div>
<div class="row">
<div class="col-sm-12 mt-0">
	<div class="gloadiv"></div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<div class="modal fade" id="vgrStatusModel" role="dialog">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title"><u>PAL & Status</u></h4>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="row">
<div class="col-sm-12">
<div class="loading_icon"></div>

<div class="fhstatusForm"></div>
<div class="fhstatuslist"></div>

<span class="getSelectedStatusDiv"></span>

<form method="post" action="../mysqldb.php" enctype="multipart/form-data" autocomplete="off">
<p class="mb-0 mt-3"><b>Select File Status: </b></p>
<div class="row">
<div class="col-8 col-sm-9">
<select name="v_g_r_status" class="form-control form-control-sm vgrClass mb-2" onchange="getval(this);" required>
<option value="">Select Option</option>
<option value="V-G">V-G</option>
<option value="V-R">V-R</option>
</select>
</div></div>
<div class="row" id="vg-dtls">
</div>
<div class="row">
<div class="col-4 col-sm-3">
<input type="hidden" name="rowbg1" class="rowbg1" value="<?php if(!empty($_GET['tab'])){ echo $_GET['tab']; } ?>">
<input type="hidden" name="snid" class="vgrsnid" value="">
<input type="submit" name="vgrBtn" value="Submit" class="btn btn-sm btn-success">
</form>
</div>
</div>
</div>
</div>
<div class="vgrstatuslist"></div>
<div class="studentTravelLists"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

<div class="modal fade" id="myModaljjjs" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">

<h4 class="modal-title">Student Application</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div id="ldld"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

<div class="modal fade" id="dropModel" role="dialog">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="dropstatus"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

<div class="modal fade" id="invoiceStatusModel" role="dialog">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="invoicestatuslist"></div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div></div>
</div>
</div>

<style type="text/css">
  .table tr {
    cursor: pointer;
}
.hiddenRow {
    padding: 0 4px !important;
    background-color: #eeeeee;
    font-size: 13px;
}
.accordion-toggle {
  cursor: pointer;
  height: 20px;
  position: relative;border-radius: 20px;
  width: 20px; background:#2c79b3;
}
.accordion-toggle:before,
.accordion-toggle:after {
  background: #fff;
  content: "";
  height: 2px;
  left: 5px;
  position: absolute;
  top: 10px;
  width: 10px;
  transition: transform 500ms ease;
}
.accordion-toggle:after {
  transform-origin: center;
}
.accordion-toggle.collapsed:after {
  transform: rotate(90deg);
}
.accordion-toggle.collapsed:before {
  transform: rotate(180deg);
}
</style>


<div class="modal" id="modalAppRemarks">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Application Remarks</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<form method="post" class="form well-form" autocomplete="off" name="registerFrm" id="registerFrm">
					<div class="form-group">
						<textarea class="form-control" name="application_comments" id="application_comments" rows="5" placeholder="Enter Here..."></textarea>
					</div>
					<input type="hidden" name="application_id" class="appIdDiv" value="">
					<input type="hidden" name="sessionid" value="<?php echo $sessionid1; ?>">
					<input type="hidden" name="sessionname" value="<?php echo $username; ?>">
					<div class="form-group">
						<button type="submit" class="btn btn-sm btn-success float-right mt-2" id="queryStudentbtn">Submit</button>
					</div>
				</form>

				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Remarks</th>
								<th>Updated By</th>
								<th>Updated at</th>
							</tr>
						</thead>
						<tbody class="applRemarks"></tbody>
					</table>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

<script>
$(document).on('change', '.applicationStatus', function(){
	var statusVal = $('option:selected', this).attr('data-id');
	
	location.href="../application/?srchstatus="+statusVal+"&page_no=1&getsearch=&agentid=";
	return true;
});

$(document).on('change', '.agentuname', function(){	
	var agentid = $(this).val();
	location.href="../application/?srchstatus=&page_no=1&getsearch=&agentid="+agentid+"";
	return true;
});

$(document).on('click', '.jmjm', function(){
	var ssss = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=fetch",{"idno":ssss},function(obj){		
		$('#ldld').html("");
		$('<div class="overclass">' +		
		'<div class="pd-detail">' +
		'<h3><strong>Personal Details</strong></h3>' +
		'<p><b>Role: </b>' + obj[0].app_by + '</p>' +
		'<p><b>Reference Id: </b>' + obj[0].refid + '</p>' +
		'<p><b>Full Name: </b>' + obj[0].fname +' '+ obj[0].lname + '</p>' +
		'<p><b>Email Address: </b>' + obj[0].email_address + '</p>' +
		'<p><b>Mobile Number: </b>' + obj[0].mobile + '</p>' +
		'<p><b>Gender: </b>' + obj[0].gender + '</p>' +
		'<p><b>Martial Status: </b>' + obj[0].martial_status + '</p>' +
		'<p><b>Date of Birth: </b>' + obj[0].dob + '</p>' +
		'<p><b>Passport Number: </b>' + obj[0].passport_no + '</p>' +
		'<p><b>Passport Issue Date: </b>' + obj[0].pp_issue_date + '</p>' +
		'<p><b>Passport Expiry Date: </b>' + obj[0].pp_expire_date + '</p>' +
		'<p><b>Address-1: </b>' + obj[0].address1 + '</p>' +
		'<p><b>Address-2: </b>' + obj[0].address2 + '</p>' +
		'<p><b>Country: </b>' + obj[0].country + '</p>' +
		'<p><b>State: </b>' + obj[0].state + '</p>' +
		'<p><b>City: </b>' + obj[0].city + '</p>' +
		'<p><b>PIN Code: </b>' + obj[0].pincode + '</p>' +
		'<p><b>Passport: </b>' + obj[0].idproof + '</p>' +
		'<p><b>Created Date: </b>' + obj[0].datetime + '</p>' +
		'</div>'+
		'<div class="pd-detail">' +
		'<h3><strong>Courses</strong></h3>' +
		'<p><b>Campus Name: </b>' + obj[0].campus + '</p>' +
		'<p><b>Program Name: </b>' + obj[0].prg_name1 + '</p>' +
		'<p><b>Intake: </b>' + obj[0].prg_intake + '</p>' +
		'</div>'+
		'<div class="pd-detail">' +
		'<h3><strong>Test Details</strong></h3>' +
		'<p><b>Test Details: </b>' + obj[0].englishpro + '</p>' +
		'<p>' + obj[0].ielts_pte_over + '</p>' +		
		'<p>' + obj[0].ielts_pte_not + '</p>' +		
		'<p>' + obj[0].ielts_pte_listening + '</p>' +		
		'<p>' + obj[0].ielts_pte_reading + '</p>' +		
		'<p>' + obj[0].ielts_pte_writing + '</p>' +		
		'<p>' + obj[0].ielts_pte_speaking + '</p>' +		
		'<p>' + obj[0].ielts_pte_date + '</p>' +		
		'<p>' + obj[0].ielts_pte_file + '</p>' +		
		'<p>' + obj[0].duolingo_div + '</p>' +		
		'<h3><strong>Academic Details</strong></h3>' +
		'<h5><strong>Education Details<span style="color:red;">*</span></strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification1 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream1 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks1 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year1 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry1 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate1 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name1 + '</p>' +
		'<h5><strong>Education Details</strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification2 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream2 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks2 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year2 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry2 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate2 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name2 + '</p>' +
		'<h5><strong>Education Details</strong></h5>' +
		'<p><b>Qualifications: </b>' + obj[0].qualification3 + '</p>' +
		'<p><b>Education Type: </b>' + obj[0].stream3 + '</p>' +
		'<p><b>Marks(%): </b>' + obj[0].marks3 + '</p>' +
		'<p><b>Passing Year: </b>' + obj[0].passing_year3 + '</p>' +
		'<p><b>University Country: </b>' + obj[0].unicountry3 + '</p>' +
		'<p><b>Upload Certificate: </b>' + obj[0].certificate3 + '</p>' +
		'<p><b>University Name: </b>' + obj[0].uni_name3 + '</p>' +
		'<h5><strong>Gap Justification</strong></h5>' +
		'<p>' + obj[0].passing_year_gap_justification + '</p>' +
		'</div>'+
		'</div>').appendTo("#ldld");
		$('.loading_icon').hide();	
	});
});

$(document).on('click', '.confirmbtn1', function(){
	var idmodel = $(this).attr('data-id');
	$('.ssid').attr('value' ,idmodel);
	$('.loading_icon').show();
	$.post("../response.php?tag=remarkdb",{"idno":idmodel},function(obj){
		$('.remarkShow').html("");
		$('<div>' +
		'<p><strong>Application Status : </strong>' + obj[0].admin_status_crs + '</p>' +
		'<p><strong>Application Remarks : </strong> ' + obj[0].admin_remark_crs + '</p>' +
		'<p><strong>Campus: </strong>' + obj[0].campus + '</p>' +
		'<p><strong>Course Intake: </strong>' + obj[0].ptake + '</p>' +
		'<p><strong>Course Type : </strong> ' + obj[0].pname + '</p>' +
		'</div>').appendTo(".remarkShow");
		$('.loading_icon').hide();	
	});
});

$(document).on('change', '.campusDiv', function(){
	$('.loading_icon').show();
	var vl = $(this).val();
	$(".prgmAppend").html("<option value=''>Select Option</option>");
	$('.intkeAppend').attr('data-campus', vl);
	$.post("../response.php?tag=campusadd",{"campus":vl},function(d){
		$(".intkeAppend").html(" ");
		$(".intkeAppend").html("<option value=''>Select Intake</option>");		
		for (i in d) {
			$('<option value="' + d[i].intake + '">'+ d[i].intake +'</option>').appendTo(".intkeAppend");
		}
	$('.loading_icon').hide();		
	});	
});


$(document).on('change', '.intkeAppend', function(){
	$('.loading_icon').show();
	var vl = $(this).val();
	var vl2 = $(this).attr('data-campus');
	$.post("../response.php?tag=corseadd",{"intake":vl, "campus":vl2},function(d){
		$(".prgmAppend").html(" ");
		$(".prgmAppend").html("<option value=''>Select Option</option>");		
		for (i in d) {
			$('<option value="' + d[i].program_name + '">'+ d[i].program_name +'</option>').appendTo(".prgmAppend");
		}
	$('.loading_icon').hide();		
	});	
});

$(document).on('click', '.olClass', function(){
	var idmodel = $(this).attr('data-id');
	$('.olsnid').attr('value' ,idmodel);
	$('.loading_icon').show();
	$.post("../response.php?tag=chkofferclass",{"idno":idmodel},function(d){		
		$('#oldownload').html("");
		$('<div>' +
		'<p class="mb-0"><b>Campus Name: </b>' + d[0].campus_name + '</p>' +	
		'<p><b><span style="fot-size:8px; color:red;">Note : <span> <span style="fot-size:6px; color:#666;">Refresh the page after generating the contract to view the latest file on download link<span></b>' + d[0].linkpdf + '</p>' +
		'' + d[0].ol_type + '' +
		'<p><b>Generated Conditional Offer Letter: </b>' + d[0].ol_download + '</p>' +
		'<p>'+ d[0].btnstatus + '</p>' +
		'<p><b>Status: </b>' + d[0].col + '</p>' +
		'</div>').appendTo("#oldownload");
	
	$('.ol_processing').on('change', function(){
		var olProcessing = $('.ol_processing').val();
		if(olProcessing == 'Final COL'){
			$('.ol_typeDiv').show();
			$('.ol_conditional_pal').hide();
		}
		if(olProcessing == 'Conditional COL'){
			$('.ol_typeDiv').hide();
			$('.ol_conditional_pal').show();
		}
		if(olProcessing == ''){
			$('.ol_typeDiv').hide();
			$('.ol_conditional_pal').hide();
		}
	});		
		
<!--- send ol status--->		
	$('.cnfmFun').on('click', function(){
	var status = $(this).attr('idno');
    var message = "Are you want to change the status";
        if(status){
            var updateMessage = "Offer Letter Sent";
        }else{
            var updateMessage = "Cancel";
        }        
        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        }, function () {
		var url = '../response.php?tag=confirmbtn_ol';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "" + updateMessage +" successfully", "success");   
			}else{
			   swal("Failed", data, "error");				   
			}
			setTimeout(function(){
				location.reload(); 
			}, 2000);  
            }
        })  
    }); 
	});
	
<!--- cancel ol status--->		
$('.cnfmFun1').on('click', function(){
	var status = $(this).attr('idno');
    var message = "Are you want to change the status";
        if(status){
            var updateMessage = "Cancel Letter Sent";
        }else{
            var updateMessage = "Cancel";
        }        
        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        }, function () {
		var url = '../response.php?tag=confirmbtn_ol1';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "" + updateMessage +" successfully", "success");   
			}else{
			   swal("Failed", data, "error");				   
			}
			setTimeout(function(){
				location.reload(); 
			}, 2000);  
            }
        })  
    }); 
	});
		
	});
	$.post("../response.php?tag=signedconfirm",{"idno":idmodel},function(d){		
		$('#agdownload').html("");
		$('<div>' +	
		'<p><b>Signed Conditional Offer Letter: </b>' + d[0].agl + '</p>' +	
		'<p><b>Status by ACC: </b>' + d[0].scol + '</p>' +
		'<p><b>Remarks by ACC: </b>' + d[0].remarks + '</p>' +
		'</div>').appendTo("#agdownload");		
		$('.loading_icon').hide();		
	});
});

$(document).on('click', '.loaRqstClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.loaRqst_sno').attr('value', idmodel);
	$('.loading_icon').show();
	$.post("../response.php?tag=getDropstatus_Agent",{"idno":idmodel},function(d){
		$('.getLOAList').html("");
		$('<div>' +
		'' + d[0].loaReceipt + '' +		
		'</div>').appendTo(".getLOAList");
		$('.loading_icon').hide();	
	});	
});

$(document).on('change', '.rqstSelected', function(){
	var getval = $(this).val();	
	if(getval == 'Request LOA With TT'){
		$('.upload_tt').show();
		$('.rqustloa').show();
		$('.withoutTT').hide();
	}
	if(getval == 'Request LOA Without TT'){
		$('.upload_tt').hide();
		$('.loa_tt').val('');
		$('.loa_tt_remarks').val('');
		$('.rqustloa').show();
		$('.withoutTT').show();
	}
	if(getval == ''){
		$('.upload_tt').hide();
		$('.rqustloa').hide();
		$('.withoutTT').hide();
	}	
});

$(document).on('click', '.loaRqstbtn', function(){	
	$('.loading_icon').show();
	var get_tt = $('.rqstSelected').val();
	var get_tt1 = $('.loa_tt').val();
	var get_loa_tt_remarks1 = $('.loa_tt_remarks').val();
	var getinput = $('.ttwot').length;	
	if(get_tt == 'Request LOA With TT' && (get_tt1 == '' || get_loa_tt_remarks1 == '')){
		$('.loading_icon').hide();
		$('.loa_tt').css({"border": "1px solid red"});
		$('.loa_tt_remarks').css({"border": "1px solid red"});
		return false;
	}
	if(get_tt == 'Request LOA Without TT'){
		if(($('.gc_username').val() == '') && (getinput <= 4)){
			$('.loading_icon').hide();
			alert('4 Question are mondatory to be Answered!!!');
			$('.gc_username').css({"border": "1px solid red"});
			$('.ttwot').css({"border": "1px solid red"});
			return false;
		}else{		
			$('.loading_icon').hide();
			return true;
		}
	}
});

<!--- Prepaid --->
$(document).on('click', '.prepaidClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.feesnid').attr('value' ,idmodel);
	$('.loading_icon').show();
	$.post("../response.php?tag=loaFee",{"idno":idmodel},function(d){
		$('.loaFeediv').html("");
		$('<div>' +	
		'<p><b>Prepaid Fee: </b>' + d[0].prepaidFee + '</p>' +
		 '' + d[0].pfr + '' +	
		'</div>').appendTo(".loaFeediv");
		$('.loading_icon').hide();
	});
});

<!--- LOA --->	
$(document).on('click', '.genrateClass', function(){
	var idmodel = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=loaGenrate",{"idno":idmodel},function(d){
		$('.gloadiv').html("");
		$('<div>' +
		'<p class="mb-1"><b>Campus Name: </b>' + d[0].campus_name + '</p>' +	
		'<p class="mb-1">' + d[0].col_type + '</p>' +	
		'<p class="mb-1">' + d[0].btnstatus + '</p>' +	
		'<p class="mb-1">' + d[0].loa_type + '</p>' +	
		'<p class="mb-1"><b>Generated LOA: </b>' + d[0].Loadownload + '</p>' +
		'<p class="mb-1">' + d[0].gsl_div + '</p>' +
		'<p class="mb-1">' + d[0].btnstatus2 + '</p>' +
		'<p class="mb-1"><b>LOA Sent Date: </b>' + d[0].loa_file_status_date_by + '</p>' +
		'<p class="mb-1"><b>LOA Status: </b>' + d[0].loa_status + '</p>' +
		'<p class="mb-1">' + d[0].btnstatus_3 + '</p>' +
		'<p class="mb-1">' + d[0].loa_fee_receipt_btn + '</p>' +
		'<p class="mb-1">' + d[0].btnstatus_4 + '</p>' +
		'</div>').appendTo(".gloadiv");
		$('.loading_icon').hide();
		
<!--- Cancel --->		
$('.loastatusFun1').on('click', function(){ 
	var status = $(this).attr('idno');
    var message = "Are you want to change the status";
        if(status){
            var updateMessage = "LOA Cancel Status Sent";
        }else{
            var updateMessage = "Cancel";
        }        
        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        }, function () {
		var url = '../response.php?tag=loaStatus1';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "" + updateMessage +" successfully", "success");   
			}else{
			   swal("Failed", data, "error");				   
			}
			setTimeout(function(){
				location.reload(); 
			}, 2000);  
            }
        })  
    }); 
	});
	
<!--- Verified --->	
	$('.loastatusFun').on('click', function(){
	var status = $(this).attr('idno');
    var message = "Are you want to change the status";
        if(status){
            var updateMessage = "LOA Status Sent";
        }else{
            var updateMessage = "Cancel";
        }        
        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        }, function () {
		var url = '../response.php?tag=loaStatus';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "" + updateMessage +" successfully", "success");   
			}else{
			   swal("Failed", data, "error");				   
			}
			setTimeout(function(){
				location.reload(); 
			}, 2000);  
            }
        })  
    }); 
	});	

	$('.loaAlert').on('change', function() {
		var gettval = $(this).val();
		if(gettval == 'Defer'){
	   if(confirm("Are you sure you want to proceed")){
			return true;
	   }else{
		   return false;
	   }
		}
	});
	
	$(function(){
		$(".date_loa").datepicker({	  
			dateFormat: 'yy-mm-dd', 
			changeMonth: false, 
			changeYear: false,
		});
	});

    });	
});

<!--- VGR Status --->	
$(document).on('click', '.vgrStatusClass', function(){	
	var idmodel = $(this).attr('data-id'); 
	$('.vgrsnid').attr('value' ,idmodel);
	$('.loading_icon').show();	
	
	$.post("../response.php?tag=getfhstatusForm",{"idno":idmodel},function(d){
		$('.fhstatusForm').html("");
		$('<div>' +	
		'' + d[0].fhstatusbtn + '' +
		'</div>').appendTo(".fhstatusForm");
		$('.loading_icon').hide();
		
		$(function(){
			$(".datePAL").datepicker({	  
				dateFormat: 'yy-mm-dd', 
				changeMonth: false, 
				changeYear: false,
			});
		});
		
		$('.gicDiv').on('change', function(){
			var getVal4 = $(this).val();
			if(getVal4 == 'Paid'){
				$('.GIC_Crtfct').hide();
			}
			if(getVal4 == 'Received'){
				$('.GIC_Crtfct').show();
			}
			if(getVal4 == ''){
				$('.feeClassDiv').hide();
			}
		});
		
	});
	
	$.post("../response.php?tag=getfhstatus",{"idno":idmodel},function(d){
		$('.fhstatuslist').html("");
		$('<div class="remarkShow row border-0 mt-0">' +	
		'<p class="mt-3 mb-0 col-sm-5"><b>Status: </b>' + d[0].fh_status + '</p>' +
		'<p class="col-sm-7 mt-0 mt-sm-3 mb-0 "><b>Updated On: </b>' + d[0].fh_status_updated + '</p>' +
		'</div>').appendTo(".fhstatuslist");
		$('.loading_icon').hide();
	});
	
	$.post("../response.php?tag=getcomRestatus",{"idno":idmodel},function(d){
		$('.vgrstatuslist').html("");
		$('<div>' +	
		'' + d[0].formComRefund + '' +
		'</div>').appendTo(".vgrstatuslist");
		$('.loading_icon').hide();
	});	
	
	$.post("../response.php?tag=getSelectedStatus",{"idno":idmodel},function(d){
		$('.getSelectedStatusDiv').html("");
		$('<div>' +	
		'' + d[0].vststatus + '' +
		'</div>').appendTo(".getSelectedStatusDiv");
		$('.loading_icon').hide();
	});
	
	$.post("../response.php?tag=stuTravelAgent",{"idno":idmodel},function(d){
		$('.studentTravelLists').html("");
		$('<div>' +	
		'' + d[0].student_travel_div + '' +
		'</div>').appendTo(".studentTravelLists");
		$('.loading_icon').hide();
	});
	
	$(document).on('click', '.fhreLodged', function(){
		var getfhRelodged = $('.fhStatusValue').val();
		if(getfhRelodged == 'Re_Lodged'){
		var checkstr =  confirm('are you sure you want to Re-Lodged this file?');
		if(checkstr == true){
			return true;
		}else{
			return false;
		}
		}else{
			return true;
		}
	});
});

$(document).on('click', '.dropClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.loading_icon').show();
	$.post("../response.php?tag=getDropstatus",{"idno":idmodel},function(d){
		$('.dropstatus').html("");
		$('<div>' +
		'' + d[0].dropform + '' +		
		'</div>').appendTo(".dropstatus");
		$('.loading_icon').hide();
		
		
	$('.dropreactive').on('click', function(){
	var status = $(this).attr('idno');
    var message = "You want to change the status";
        if(status){
            var updateMessage = "Activated";
        }else{
            var updateMessage = "Cancel";
        }        
        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        }, function () {
		var url = '../response.php?tag=reactiveStatus';
		$.ajax({
			type: "POST",
			url: url,
			data:'idno='+status, 
			success :  function(data){			   
			if(data == 1){
				swal("Updated!", "" + updateMessage +" successfully", "success");   
			}else{
			   swal("Failed", data, "error");				   
			}
			setTimeout(function(){
				location.reload(); 
			}, 2000);  
            }
        })  
    }); 
	});		
		
	});	
});

$(document).on('click', '.invoiceStatusClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.loading_icon').show();	
	$.post("../response.php?tag=getInvicestatus",{"idno":idmodel},function(d){
		$('.invoicestatuslist').html("");
		$('<div>' +	
		'<p><b>Status: </b>' + d[0].status + '</p>' +
		'<p><b>Remarks: </b>' + d[0].remarks + '</p>' +
		'<p><b>Updated On: </b>' + d[0].crtd + '</p>' +
		'' + d[0].allfileAgent + '' +		
		'' + d[0].filesStatusAgent + '' +		
		'' + d[0].vgr_amount + '' +		
		'' + d[0].vgr_invoice + '' +		
		'' + d[0].comrefund_remarks1 + '' +		
		'' + d[0].vgr_status_datetime + '' +		
		'</div>').appendTo(".invoicestatuslist");
		$('.loading_icon').hide();
	});	
});

$(document).ready(function () {
$('.pfDiv').on('change', function(){
	var getVal = $(this).val();
	// alert(getVal);
	if(getVal == 'Yes'){
		$('.feeClassDiv').show();
	}
	if(getVal == 'No'){
		$('.feeClassDiv').hide();
	}
	if(getVal == ''){
		$('.feeClassDiv').hide();
	}
});	
	
$("#loaFeeBtnForm").submit(function () {
	var submit = true;
	$(".is_require4:visible").each(function(){
		if($(this).val() == '') {
				$(this).addClass('error_color');
				submit = false;
		} else {
				$(this).addClass('validError');
		}
	});
	if(submit == true) {
		return true;        
	} else {
		$('.is_require4').keyup(function(){
			$(this).removeClass('error_color');
		});
		return false;        
	}
});
});	
</script>
<style type="text/css">
	.fixed-table-container th  { width:100px;}
	.fixed-table-container { overflow: scroll; }
	.fixed-table-container tr:first-child th {
    background: #114663;
}
</style>	
<script>
  var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script> 
<script>
	$('#queryStudentbtn').on('click', function(e) {
		$("#queryStudentbtn").attr("disabled", true);
		e.preventDefault();
		var getMsg = $('#application_comments').val();
		var appIdDiv = $('.appIdDiv').val();

		if (getMsg == "") {
			$('#application_comments').css({
				"border": "1px solid red"
			});
		}

		if (getMsg == "") {
			$("#queryMsg").attr("disabled", false);
			return false;
		}

		var $form = $(this).closest("#registerFrm");
		var formData = $form.serializeArray();
		var URL = "../response.php?tag=getInTouch";
		$.post(URL, formData).done(function(data) {
			if (data == 1) {
				alert('Successfully Added Your Remarks!!!');
				window.location.href = '?aid=error_' + appIdDiv + '';
				$("#registerFrm")[0].reset();
				$("#queryStudentbtn").attr("disabled", false);
				return false;
			}
		});

	});

	$(document).on('click', '.divAppRemarks', function() {
		$('.loading_icon').show();
		var app_id = $(this).attr('data-id');
		$('.appIdDiv').attr('value', app_id);
		$.post("../response.php?tag=appRemarkDiv", {
			"app_id": app_id
		}, function(d) {
			$(".applRemarks").html(" ");
			if (d == '') {
				$('<tr><td colspan="3"><center>Not Found!!!</center></td></tr>').appendTo(".applRemarks");
			} else {
				for (i in d) {
					$('<tr><td>' + d[i].application_comments + '</td><td>' + d[i].added_by_name + '</td><td>' + d[i].datetime_at + '</td></tr>').appendTo(".applRemarks");
				}
			}
			$('.loading_icon').hide();
		});
	});
</script>
<script>
function getval(sel){
	var val  = sel.value;

		if(val == 'V-G'){
			$.ajax({
					type: 'POST',
					url: '../response.php?tag='+val,
					dataType: 'html',
					success: function(response) {
						$("#vg-dtls").append(response);
		
					},
			});
			
		}else{
			$("#vg-dtls").html("");
		}

}
</script>
<?php 
include("../../footer.php");
?>
