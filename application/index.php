<?php
ob_start();
include("../db.php");
include("../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../login");
    exit(); 
}
?>
<style>
a.btnpdf {
    float: right;
    top: 20px; right:80px;
    position:fixed;
    padding: 4px 7px;
    background: #337AB7;
    color: #fff;
    margin-right: 10px;
}
.paybtn {
    margin-top: 5px;
}
.alertdiv {
    margin-top: 10%;
    margin-bottom: -8%;
}
.error_color{border:1px solid #de0e0e;}
.validError{border:1px solid #ccc;}
span.btn.btn-warning.btn-sm.loaRqst {
    width: 82%;
    color: #fff;
}
</style>

<link rel="stylesheet" href="../css/sweetalert.min.css">
<script src="../js/sweetalert.min.js"></script>

<?php
$sessionid = $_SESSION['sno'];


if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

if(!empty($_GET['roletype'])){
	$tab_name = $_GET['roletype'];
	if($tab_name == 'All'){
		$tab_name_val = 'All';
	}
	if($tab_name == 'Sub'){
		$tab_name_val = 'Sub';
	}
}else{
	$tab_name_val = 'All';
}

if(isset($_GET['roletype']) || isset($_GET['srchstatus']) || isset($_GET['subid']) || isset($_GET['rowbg'])){

$tabVal = $_GET['roletype'];
$searchStatus = $_GET['srchstatus']; 
$uname1 = $_GET['subid'];
$rowbg = $_GET['rowbg'];

if($tabVal == 'All'){
	// Agent Name
	if(($searchStatus == 'ascAname') || ($searchStatus == 'descAname')){				
		if($searchStatus == 'ascAname'){
			$as = "ORDER BY sno ASC";
		}
		if($searchStatus == 'descAname'){
			$as = "ORDER BY sno DESC";
		}
	}
	// Full Name
	if(($searchStatus == 'ascname') || ($searchStatus == 'descname')){				
		if($searchStatus == 'ascname'){
			$as = "ORDER BY fname ASC, lname ASC";
		}
		if($searchStatus == 'descname'){
			$as = "ORDER BY fname DESC, lname DESC";
		}
	}
	// Reference Id
	if(($searchStatus == 'ascRefId') || ($searchStatus == 'descRefId')){				
		if($searchStatus == 'ascRefId'){
			$as = "ORDER BY refid ASC";
		}
		if($searchStatus == 'descRefId'){
			$as = "ORDER BY refid DESC";
		}
	}	
	// Program Intake
	if(($searchStatus == 'ascintake') || ($searchStatus == 'descintake')){				
		if($searchStatus == 'ascintake'){
			$as = "ORDER BY prg_intake ASC";
		}
		if($searchStatus == 'descintake'){
			$as = "ORDER BY prg_intake DESC";
		}
	}
	// Course Name
	if(($searchStatus == 'asccrsn') || ($searchStatus == 'desccrsn')){				
		if($searchStatus == 'asccrsn'){
			$as = "ORDER BY prg_name1 ASC";
		}
		if($searchStatus == 'desccrsn'){
			$as = "ORDER BY prg_name1 DESC";
		}
	}
	// Application Status
	if(($searchStatus == 'asPending') || ($searchStatus == 'asYes') || ($searchStatus == 'asNo')){				
		if($searchStatus == 'asPending'){
			$as = " AND admin_status_crs=''";
		}elseif($searchStatus == 'asYes'){
			$as = " AND admin_status_crs='Yes'";
		}elseif($searchStatus == 'asNo'){
			$as = " AND admin_status_crs= 'No'";
		}
	}
	// Conditional Offer Letter
	if(($searchStatus == 'col_Pending') || ($searchStatus == 'col_Recieved') || ($searchStatus == 'col_Signed_Sent') || ($searchStatus == 'col_Approved')){		
		if($searchStatus == 'col_Pending'){
			$as = " AND ol_confirm='' AND offer_letter=''";
		}elseif($searchStatus == 'col_Recieved'){
			$as = " AND ol_confirm !='' AND offer_letter !=''";
		}elseif($searchStatus == 'col_Signed_Sent'){
			$as = " AND agreement !=''";
		}elseif($searchStatus == 'col_Approved'){
			$as = " AND signed_ol_confirm='Yes'";
		}
	}
	// Request LOA	
	if(($searchStatus == 'lrs_Pending') || ($searchStatus == 'lrs_rs')){
		if($searchStatus == 'lrs_Pending'){
			$as = " AND file_receipt=''";
		}elseif($searchStatus == 'lrs_rs'){
			$as = " AND file_receipt!=''";
		}
	}
	// ACC Contract	
	if(($searchStatus == 'aolc_Pending') || ($searchStatus == 'aolc_Recieved') || ($searchStatus == 'aolc_Signed_Sent') || ($searchStatus == 'aolc_Approved')){		
		if($searchStatus == 'aolc_Pending'){
			$as = " AND contract_letter='' AND agreement_loa=''";
		}elseif($searchStatus == 'aolc_Recieved'){
			$as = " AND contract_letter !='' AND agreement_loa !=''";
		}elseif($searchStatus == 'aolc_Signed_Sent'){
			$as = " AND signed_agreement_letter !=''";
		}elseif($searchStatus == 'aolc_Approved'){
			$as = " AND signed_al_status='Yes'";
		}
	}
	// Upload LOA	
	if(($searchStatus == 'loa_Pending') || ($searchStatus == 'loa_Processing') || ($searchStatus == 'loa_Recieved')){		
		if(($searchStatus == 'loa_Pending') || ($searchStatus == '')){
			$as = " AND loa_file='' AND signed_al_status!='No'";
		}elseif($searchStatus == 'loa_Processing'){
			$as = " AND loa_file !='' AND signed_al_status='Yes' AND loa_file_status=''";
		}elseif($searchStatus == 'loa_Recieved'){
			$as = " AND loa_file !='' AND loa_file_status='1'";
		}
	}
	// V-R Status	
	if(($searchStatus == 'vgr_Pending') || ($searchStatus == 'vgr_VG') || ($searchStatus == 'vgr_VR') || ($searchStatus == 'vgr_refund_rqst_sent') || ($searchStatus == 'vgr_refund_apprd')){		
		if(($searchStatus == 'vgr_Pending') || ($searchStatus == '')){
			$as = " AND fh_status='' AND v_g_r_status=''";
		}elseif($searchStatus == 'vgr_VG'){
			$as = " AND v_g_r_status='V-G' AND fh_status!=''";
		}elseif($searchStatus == 'vgr_VR'){
			$as = " AND v_g_r_status='V-R' AND fh_status!=''";
		}elseif($searchStatus == 'vgr_refund_rqst_sent'){
			$as = " AND file_upload_vr_status='Yes'";
		}elseif($searchStatus == 'vgr_refund_apprd'){
			$as = " AND tt_upload_report_status='Yes'";
		}
			
	}

	if($searchStatus == ''){
			$as = "";
	}
	
}


if($tabVal == 'Sub'){

	$quryHead = "SELECT head,sub FROM agent_admin where head='$sessionid'";
	$qrymy = mysqli_query($con, $quryHead);
	if(mysqli_num_rows($qrymy)){
	while ($rowhead = mysqli_fetch_assoc($qrymy)) {
		$sub[] = $rowhead['sub'];
	}	
	$arrImpld = implode(",",$sub);

	// Agent Name
	if(($searchStatus == 'ascAname') || ($searchStatus == 'descAname')){				
		if($searchStatus == 'ascAname'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY user_id ASC';
		}
		if($searchStatus == 'descAname'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY user_id DESC';
		}
	}

	// Full Name
	if(($searchStatus == 'ascname') || ($searchStatus == 'descname')){	
		if($searchStatus == 'ascname'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY fname ASC, lname ASC';
		}
		if($searchStatus == 'descname'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY fname DESC, lname DESC';
		}
	}

	// Reference Id
	if(($searchStatus == 'ascRefId') || ($searchStatus == 'descRefId')){				
		if($searchStatus == 'ascRefId'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY refid ASC';
		}
		if($searchStatus == 'descRefId'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY refid DESC';
		}
	}

	// Program Intake
	if(($searchStatus == 'ascintake') || ($searchStatus == 'descintake')){				
		if($searchStatus == 'ascintake'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY prg_intake ASC';
		}
		if($searchStatus == 'descintake'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY prg_intake DESC';
		}
	}

	// Course Name
	if(($searchStatus == 'asccrsn') || ($searchStatus == 'desccrsn')){				
		if($searchStatus == 'asccrsn'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY prg_name1 ASC';
		}
		if($searchStatus == 'desccrsn'){
			$as = 'AND user_id IN ('.$arrImpld.') ORDER BY prg_name1 DESC';
		}
	}

	// Application Status
	if(($searchStatus == 'asPending') || ($searchStatus == 'asYes') || ($searchStatus == 'asNo')){				
		if($searchStatus == 'asPending'){
			$as = "AND user_id IN (".$arrImpld.") AND admin_status_crs=''";
		}elseif($searchStatus == 'asYes'){
			$as = "AND user_id IN (".$arrImpld.") AND admin_status_crs='Yes'";
		}elseif($searchStatus == 'asNo'){
			$as = "AND user_id IN (".$arrImpld.") AND admin_status_crs= 'No'";
		}
	}
	// Conditional Offer Letter	
	if(($searchStatus == 'col_Pending') || ($searchStatus == 'col_Recieved') || ($searchStatus == 'col_Signed_Sent') || ($searchStatus == 'col_Approved')){		
		if($searchStatus == 'col_Pending'){
			$as = "AND user_id IN (".$arrImpld.") AND ol_confirm='' AND offer_letter=''";
		}elseif($searchStatus == 'col_Recieved'){
			$as = "AND user_id IN (".$arrImpld.") AND ol_confirm !='' AND offer_letter !=''";
		}elseif($searchStatus == 'col_Signed_Sent'){
			$as = "AND user_id IN (".$arrImpld.") AND agreement !=''";
		}elseif($searchStatus == 'col_Approved'){
			$as = "AND user_id IN (".$arrImpld.") AND signed_ol_confirm='Yes'";
		}	
	}	
	// Request LOA	
	if(($searchStatus == 'lrs_Pending') || ($searchStatus == 'lrs_rs')){
		if($searchStatus == 'lrs_Pending'){
			$as = "AND user_id IN (".$arrImpld.") AND file_receipt=''";
		}elseif($searchStatus == 'lrs_rs'){
			$as = "AND user_id IN (".$arrImpld.") AND file_receipt!=''";
		}
	}
	// ACC Contract
	if(($searchStatus == 'aolc_Pending') || ($searchStatus == 'aolc_Recieved') || ($searchStatus == 'aolc_Signed_Sent') || ($searchStatus == 'aolc_Approved')){		
		if($searchStatus == 'aolc_Pending'){
			$as = "AND user_id IN (".$arrImpld.") AND contract_letter='' AND agreement_loa=''";
		}elseif($searchStatus == 'aolc_Recieved'){
			$as = "AND user_id IN (".$arrImpld.") AND contract_letter !='' AND agreement_loa !=''";
		}elseif($searchStatus == 'aolc_Signed_Sent'){
			$as = "AND user_id IN (".$arrImpld.") AND signed_agreement_letter !=''";
		}elseif($searchStatus == 'aolc_Approved'){
			$as = "AND user_id IN (".$arrImpld.") AND signed_al_status='Yes'";
		}	
	}
	// Download LOA loa_Pending
	if(($searchStatus == 'loa_Pending') || ($searchStatus == 'loa_Processing') || ($searchStatus == 'loa_Recieved')){
		if($searchStatus == 'loa_Pending'){
			$as = "AND user_id IN (".$arrImpld.") AND loa_file='' AND signed_al_status!='No'";
		}elseif($searchStatus == 'loa_Processing'){
			$as = "AND user_id IN (".$arrImpld.") AND loa_file !='' AND signed_al_status='Yes' AND loa_file_status=''";
		}elseif($searchStatus == 'loa_Recieved'){
			$as = "AND user_id IN (".$arrImpld.") AND loa_file !='' AND loa_file_status='1'";
		}		
	}
	// V-R Status	
	if(($searchStatus == 'vgr_Pending') || ($searchStatus == 'vgr_VG') || ($searchStatus == 'vgr_VR') || ($searchStatus == 'vgr_refund_rqst_sent') || ($searchStatus == 'vgr_refund_apprd')){		
		if($searchStatus == 'vgr_Pending'){
			$as = "AND user_id IN (".$arrImpld.") AND fh_status='' AND v_g_r_status=''";
		}elseif($searchStatus == 'vgr_VG'){
			$as = "AND user_id IN (".$arrImpld.") AND v_g_r_status='V-G' AND fh_status!=''";
		}elseif($searchStatus == 'vgr_VR'){
			$as = "AND user_id IN (".$arrImpld.") AND v_g_r_status='V-R' AND fh_status!=''";
		}elseif($searchStatus == 'vgr_refund_rqst_sent'){
			$as = "AND user_id IN (".$arrImpld.") AND file_upload_vr_status='Yes'";
		}elseif($searchStatus == 'vgr_refund_apprd'){
			$as = "AND user_id IN (".$arrImpld.") AND tt_upload_report_status='Yes'";
		}
	}
	
	}

	if($searchStatus == ''){
		$as = "AND user_id IN (".$arrImpld.")";
	}

}

}else{
	$as = '';

	$tabVal = 'All';
	$searchStatus = '';
	$uname1 = '';
	$rowbg = '';
}

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (CONCAT(fname,  ' ', lname) LIKE '%".$searchTerm."%' OR refid LIKE '%".$searchTerm."%' OR student_id LIKE '%".$searchTerm."%' OR dob LIKE '%".$searchTerm."%' OR passport_no LIKE '%".$searchTerm."%')";
	$search_url = "&getsearch=".$searchTerm."";
} else {
	$searchInput = '';
	$search_url = '';
}


$total_records_per_page = 40;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2"; 

if($tabVal == 'All' || $tabVal == ''){
	$result_count1 = "SELECT COUNT(*) As total_records FROM `st_application` where user_id = '$sessionid' $as $searchInput";
}else{
	$result_count1 = "SELECT COUNT(*) As total_records FROM st_application where application_form='1' $as $searchInput";
}
// echo $result_count1;
$result_count = mysqli_query($con, $result_count1);
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1

?>


<?php
$result1 = mysqli_query($con,"SELECT sno,role,agent_type,verifystatus FROM allusers WHERE sno = '$sessionid'");
while ($row1 = mysqli_fetch_assoc($result1)) {
	 $role_agent = mysqli_real_escape_string($con, $row1['role']);
	 $mainloggedid = mysqli_real_escape_string($con, $row1['sno']);	 
	 $Main_agentType = mysqli_real_escape_string($con, $row1['agent_type']);	 
	 $verifystatus = mysqli_real_escape_string($con, $row1['verifystatus']);	 
if($role_agent == 'Admin'){
	header("Location: ../backend/application/");
}else{
	
if($verifystatus == ''){		
	include('../verifyemail.php');
}else{
if(isset($_GET['msg']) == 'Paymentmsg'){		
?>
<div class="alert alert-success alert-dismissible" style="width: 100%;float: left;">
  <center>
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success!</strong> Successfully Done your Payment
  </center>
</div>
<?php } 
if(isset($_GET['payError']) && !empty($_GET['payError'])){ ?> 
 <div class="alert alert-success alert-dismissible" style="width: 100%;float: left;">
  <center>
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<?php echo $_GET['payError'];?>
  </center>
</div>
<?php } ?>
<?php if(!empty($_GET['smsgAgree'])){
	$mssg =  base64_decode($_GET['smsgAgree']);
	if($mssg == 'SuccessAgreementUpload'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-success' style="text-align:center;">
			<?php echo 'Successfully Uploaded'; ?>
		</div>
    </div>     
<?php } } ?>
<?php if(!empty($_GET['msgagree'])){
	$mssg =  base64_decode($_GET['msgagree']);
	if($mssg == 'ImageAgreementUpload'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'File Not Supported'; ?>
		</div>
    </div>     
<?php }
if($mssg == 'ImageSizeAgreementUpload'){
	$getsize = $_GET['mb'];
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'File too large. File must be less than '.$getsize.' MB.'; ?>
		</div>
    </div>  
<?php } ?>
<?php } ?>
<?php if(!empty($_GET['codemsg1'])){
	$mssg =  base64_decode($_GET['codemsg1']);
	if($mssg == 'codeExceedsMsg'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'Code exceeds the limit'; ?>
		</div>
    </div>     
<?php } } ?>
<?php if(!empty($_GET['codemsg'])){
	$mssg =  base64_decode($_GET['codemsg']);
	if($mssg == 'CodeErrormsg'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'Code is not valid'; ?>
		</div>
    </div>     
<?php } } ?>
<?php if(!empty($_GET['ucodemsg'])){
	$mssg =  base64_decode($_GET['ucodemsg']);
	if($mssg == 'UploadErrormsg'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'Code is in use'; ?>
		</div>
    </div>     
<?php } }
 if(!empty($_GET['noti']) && isset($_GET['noti'])){
	$notif =  $_GET['noti'];
	mysqli_query($con, "UPDATE `notification_aol` SET  `status`='0', `bgcolor`='#fff' WHERE `sno`='$notif'");
} ?>

<div class="main-div">
<h3><center>My Application</center></h3>
<div class="container-fluid vertical_tab">  
  <div class="row">  
<div class="col-xs-12 col-sm-12 col-md-12">	
<div class="tab-content">
<div id="Personal-Details">
<?php 
  $result4 = "SELECT agent_admin.head FROM agent_admin INNER JOIN allusers ON agent_admin.sub=allusers.sno where agent_admin.head='$mainloggedid'";
  $qrysub = mysqli_query($con, $result4);
  $qrysubNumRow = mysqli_num_rows($qrysub);

if($tabVal == 'All' || $tabVal == ''){
	$activeDiv = 'active';
	$activeDiv1 = '';
}else{
	$activeDiv = '';	
	$activeDiv1 = 'active';	
}
?>
<div class="tabs tabs-style-tzoid">
<nav>
<ul>
<div class="col-md-12 mb-margin col-sm-12 col-12">
	<li id="activeId" class="<?php echo $activeDiv; ?>">
	<a href="../application/?page_no=1&srchstatus=&roletype=All&subid=<?php echo $uname1; ?>&rowbg=<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>&getsearch=" class="btn btn-lg sabbtn">
	<i class="fas fa-user mb-icon"></i><span class="mb-hide">All Applications By You</span>
	</a>
	</li>
	<?php if($qrysubNumRow){ ?>
	<li id="activeId1" class="<?php echo $activeDiv1; ?>">
	<a href="../application/?page_no=1&srchstatus=&roletype=Sub&subid=<?php echo $uname1; ?>&rowbg=&getsearch=" class="btn btn-lg sabbtn">
	<i class="fas fa-user mb-icon"></i><span class="mb-hide">Sub Agents</span>
	</a>
	</li>
	<?php } ?>

<form action="../mysqldb.php" method="post" style="float:right; max-width:370px; width:100%">
	<div class="input-group my-3">
	<input type="text" name="inputval" placeholder="Search By Name,Ref/Stu Id,Passport or DOB" autocomplete="off" class="form-control" style="border: 1px solid #2c79b3;font-size: 15px;">
    <div class="input-group-append">
	<input type="submit" class="btn" name="srchClickbtn" value="Search" style="background: #2c79b3;
    border: none;color: #fff;cursor: pointer;">
</div>
</div>
</form>

</div>

 </ul>
</nav>
</div> 
 
<div class="col-sm-12">


	<div class="row">
    <div class="table-responsive">
	<table class="table table-bordered">
    <thead>
	  <tr style="background:#fff;">
        <th></th>
        <th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="ascAname">Sort By ASC</option>
			<option value="" data-id="descAname">Sort By DESC</option>
		</select>
		</th>
        <th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="ascname">Sort By ASC</option>
			<option value="" data-id="descname">Sort By DESC</option>
		</select>
		</th>
		<th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="ascRefId">Sort By ASC</option>
			<option value="" data-id="descRefId">Sort By DESC</option>
		</select>
		</th>
		<th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="ascintake">Sort By ASC</option>
			<option value="" data-id="descintake">Sort By DESC</option>
		</select>
		</th>
		<th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="asccrsn">Sort By ASC</option>
			<option value="" data-id="desccrsn">Sort By DESC</option>
		</select>
		</th>
		<th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="asPending">Pending</option>
			<option value="" data-id="asYes">Yes</option>
			<option value="" data-id="asNo">No</option>
		</select>
		</th>
		<th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="col_Pending">Pending</option>
			<option value="" data-id="col_Recieved">Recieved</option>
			<option value="" data-id="col_Signed_Sent">Signed/Sent</option>
			<option value="" data-id="col_Approved">Approved</option>
		</select>
		</th>
		<th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="lrs_Pending">Pending</option>
			<option value="" data-id="lrs_rs">Sent</option>
		</select>
		</th>
		<!--th>
		<select class="applicationStatus" rowbg="<?php //if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php //echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="aolc_Pending">Pending</option>
			<option value="" data-id="aolc_Recieved">Recieved</option>
			<option value="" data-id="aolc_Signed_Sent">Signed/Sent</option>
			<option value="" data-id="aolc_Approved">Approved</option>
		</select>
		</th-->
		<th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="loa_Pending">Pending</option>
			<option value="" data-id="loa_Processing">Processing</option>
			<option value="" data-id="loa_Recieved">Recieved</option>
		</select>
		</th>
		<th>
		<select class="applicationStatus" rowbg="<?php if(!empty($_GET['aid'])){ echo $_GET['aid']; } ?>" tabid="<?php echo $tab_name_val; ?>">
			<option value="">Filter</option>
			<option value="" data-id="vgr_Pending">Pending</option>
			<option value="" data-id="vgr_VG">V-G</option>
			<option value="" data-id="vgr_VR">V-R</option>
			<option value="" data-id="vgr_refund_rqst_sent">Refund Rqst Sent</option>
			<option value="" data-id="vgr_refund_apprd">Refund Approved</option>
		</select>
		</th>
		<th></th>
	  </tr>
      <tr>
        <th></th>
        <th>Agent<br> Name</th>
        <th>Full<br> Name</th>
        <th>Ref Id<br> Stu Id</th>
        <th>Program<br> Intake</th>
        <th>Course<br> Name</th>
        <th>Application<br> Status</th>
        <th>Conditional <br>Offer Letter</th>
        <th>Rqst<br> LOA</th>
        <!--th>ACC<br> Contract</th-->
        <th>Download <br>LOA</th>
        <th>V-R/V-G <br>Status</th>
        <th>Quarantine<br>Plan</th>
      </tr>
    </thead>
    <tbody id="totalshow" class="searchall">
	<span class="loading_icon"></span>
	<?php
	if($tabVal == 'All' || $tabVal == ''){

	if(isset($_GET['aid']) && !empty($_GET['aid'])){
	$get_aid = $_GET['aid'];
	$expVal = explode("error_", $get_aid);
		$qryStr = "(SELECT * FROM st_application where user_id = '$mainloggedid' AND sno='$expVal[1]' $as $searchInput LIMIT $offset, $total_records_per_page) UNION (SELECT * FROM st_application where user_id = '$mainloggedid' AND sno !='$expVal[1]' $as $searchInput order by sno ASC LIMIT $offset, $total_records_per_page)";
	}else{
		$qryStr = "SELECT * FROM st_application where user_id = '$mainloggedid' $as $searchInput  LIMIT $offset, $total_records_per_page";
	}

	}else{
		$qryStr = "SELECT * FROM st_application where application_form='1' $as LIMIT $offset, $total_records_per_page";
	}
	// echo $qryStr;
	$result = mysqli_query($con, $qryStr);	
	 while ($row = mysqli_fetch_assoc($result)) {
	 $insertid = mysqli_real_escape_string($con, $row['sno']);
	 $agent_type = mysqli_real_escape_string($con, $row['agent_type']);
	 $app_by = mysqli_real_escape_string($con, $row['app_by']);
	 $user_id1 = mysqli_real_escape_string($con, $row['user_id']);
	 $fname = mysqli_real_escape_string($con, $row['fname']);
	 $lname = mysqli_real_escape_string($con, $row['lname']);
	 $refid = mysqli_real_escape_string($con, $row['refid']);
	 $student_id = mysqli_real_escape_string($con, $row['student_id']);
	 if(!empty($student_id)){
		$student_id2 = '<br>'.$student_id; 
	 }else{
		$student_id2 = ''; 
	 }
	 $dob = mysqli_real_escape_string($con, $row['dob']);
	 $dob_1 = date("F j, Y", strtotime($dob));	 
	 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
	 $prg_type1 = mysqli_real_escape_string($con, $row['prg_type1']);
	 $prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);	 	 
	 $admin_status_crs = mysqli_real_escape_string($con, $row['admin_status_crs']);
	 $offer_letter = mysqli_real_escape_string($con, $row['offer_letter']);
	 $ol_confirm = mysqli_real_escape_string($con, $row['ol_confirm']);
	 $signed_ol_confirm = mysqli_real_escape_string($con, $row['signed_ol_confirm']);
	 $agreement = mysqli_real_escape_string($con, $row['agreement']);
	 $agreement_loa = mysqli_real_escape_string($con, $row['agreement_loa']);
	 $signed_al_status = mysqli_real_escape_string($con, $row['signed_al_status']);
	 $loa_file = mysqli_real_escape_string($con, $row['loa_file']);
	 $loa_file_status = mysqli_real_escape_string($con, $row['loa_file_status']);
	 $signed_agreement_letter = mysqli_real_escape_string($con, $row['signed_agreement_letter']);
	 $signed_al_status = mysqli_real_escape_string($con, $row['signed_al_status']);
	 $file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);
	 $loa_confirm = mysqli_real_escape_string($con, $row['loa_confirm']);
	 $fh_status = mysqli_real_escape_string($con, $row['fh_status']);
	 $v_g_r_status = mysqli_real_escape_string($con, $row['v_g_r_status']);
	 $v_g_r_invoice = mysqli_real_escape_string($con, $row['v_g_r_invoice']);
	 $inovice_status = mysqli_real_escape_string($con, $row['inovice_status']);
	 $file_upload_vr_status = mysqli_real_escape_string($con, $row['file_upload_vr_status']);
	 $file_upload_vgr_status = mysqli_real_escape_string($con, $row['file_upload_vgr_status']);
 	 $tt_upload_report_status = mysqli_real_escape_string($con, $row['tt_upload_report_status']);	 
 	 $loa_receipt_file = mysqli_real_escape_string($con, $row['loa_receipt_file']);	 
 	 $college_tt = mysqli_real_escape_string($con, $row['college_tt']);	 
 	 $support_letter = mysqli_real_escape_string($con, $row['support_letter']);	 
 	 $quarantine_plan = mysqli_real_escape_string($con, $row['quarantine_plan']);	 
 	 $quarantine_datetime = mysqli_real_escape_string($con, $row['quarantine_datetime']);	 
		
	$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id1'");
	$row_agnt_qry = mysqli_fetch_assoc($agnt_qry);
	$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);	 
	?>
      <tr class="error_<?php echo $insertid;?>">
		<td>
			<input type="checkbox" id="error_<?php echo $insertid;?>" />
		</td>
        <td><?php echo $agntname;?></td>
        <td><?php echo $fname.' '.$lname;?><br><?php echo $dob_1;?></td>
        <td><?php echo $refid.''.$student_id2;?></td>
        <td><?php echo $prg_intake;?></td>
        <td><?php echo $prg_name1;?></td>
        <td style="white-space:nowrap;">    <span class="btn btn-success btn-sm divAppRemarks" data-toggle="modal" data-target="#modalAppRemarks" data-id="<?php echo $insertid;?>">
		<i class="far fa-comment-alt" data-toggle="tooltip" data-placement="top" title="Application Remarks"></i>
		</span>     
		<?php 

	if($tabVal == 'All' || $tabVal == ''){			 
		if(($admin_status_crs == "No") || ($admin_status_crs == "Not Eligible") || ($admin_status_crs == "")){
			echo '<a href="edit.php?apid='.base64_encode($insertid).'" class="btn btn-sm editbtn"><i class="fas fa-edit"  data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>';
		}else{
			echo '<span class="btn btn-sm jmjm" data-toggle="modal" data-target="#myModaljjjs" data-id="'.$insertid.'"  ><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
		}	
	}
	
	if($tabVal == 'Sub'){
		echo '<span class="btn btn-sm jmjm" data-toggle="modal" data-target="#myModaljjjs" data-id="'.$insertid.'"  ><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
	}

		if($admin_status_crs == ""){
		?>		
		<span class="btn btn-sm checklistClassyellow checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="<?php echo $insertid; ?>"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Check Application Status(Pending)"></i></span>	
        <?php }
		
		if($admin_status_crs == "No"){
		?>		
		<span class="btn btn-sm checklistClassred checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="<?php echo $insertid; ?>"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Application Not Approved (Check Remarks)"></i></span>	
        <?php }
        if($admin_status_crs == "Not Eligible"){
        ?>
		<span class="btn btn-sm checklistClassred checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="<?php echo $insertid; ?>"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Application Not Eligible (Check Remarks)"></i></span>	
		<?php } 
		if($admin_status_crs == "Yes"){ ?>
		<span class="btn btn-sm checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="<?php echo $insertid; ?>"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Application Approved by ACC (Processing Offer Letter)"></i></span>	
        <?php }	?>	
		</td>				
		<td>		
		<?php
		if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){ ?>
		<span class="btn btn-success btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="<?php echo $insertid; ?>" tabopen="<?php echo $tab_name_val; ?>"><i class="fas fa-download"  data-toggle="tooltip" data-placement="top" title="Download Conditional Offer Letter and Upload after Sign"></i></span>
		<?php }
		if($admin_status_crs == "No" || $admin_status_crs == "Not Eligible"){
			echo '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="Application Not Approved by ACC"><i class="fas fa-times"></i></span>';
		}
		if(($admin_status_crs == "") && ($offer_letter == '') && ($ol_confirm == '')){
			echo '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
		}
		if(($admin_status_crs == "Yes") && ($offer_letter == '') && ($ol_confirm == '')){
			echo "<span style='color:yellow;' class='btn tfFileClass btn-sm' data-toggle='tooltip' data-placement='top' title='Processing Conditional Offer Letter'><i class='fas fa-sync-alt'></i></span>";
		}
		if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '')){
			echo "<span style='color:yellow;' class='btn tfFileClass btn-sm' data-toggle='tooltip' data-placement='top' title='Processing Conditional Offer Letter'><i class='fas fa-sync-alt'></i></span>";
		}
		if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){ ?>
		<span class="btn checklistClassyellow btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="<?php echo $insertid; ?>" tabopen="<?php echo $tab_name_val; ?>"><i class="fas fa-sync-alt"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Sent (Status Pending)"></i></span>
		<?php }	
		
		if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No')){ ?>
		<span class="btn checklistClassred btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="<?php echo $insertid; ?>" tabopen="<?php echo $tab_name_val; ?>"><i class="fas fa-sync-alt"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Not Approved (Check Remarks)"></i></span>
		<?php }	
		
		if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes')){ ?>
		<span class="btn btn-success btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="<?php echo $insertid; ?>" tabopen="<?php echo $tab_name_val; ?>"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Approved"></i></span>
		<?php }	
		?>	
		</td>
		<td>
		<?php
		if($signed_ol_confirm == '' || $signed_ol_confirm == 'No'){
			echo '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
		}
		if(($signed_ol_confirm == 'Yes') && ($file_receipt =='')){ ?>
			<!--span class="btn btn-warning btn-sm loaRqst" idno="<?php //echo $insertid; ?>">Request LOA</span-->
			<span class="btn btn-warning loaRqstClass" data-toggle="modal" data-target="#loaRqstModel" data-id="<?php echo $insertid; ?>">Request LOA</span>
		<?php } 	
        if(($signed_ol_confirm == 'Yes') && ($file_receipt !=='')){ ?>
			<span class="btn btn-success btn-sm loaRqstClass" data-toggle="modal" data-target="#loaRqstModel" data-id="<?php echo $insertid; ?>" tabopen="<?php echo $tab_name_val; ?>"><span class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Requested LOA"></span></span>
		<?php } ?>		
		</td>
		<!--td>
		<?php
		// if($agreement_loa !== "1"){
			// echo '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
		// } 
		// if(($agreement_loa == "1") && ($signed_agreement_letter =='')){
		?>
		<span class="btn btn-success btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="<?php //echo $insertid; ?>" tabopen="<?php //echo $tab_name_val; ?>"><span class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Contract Sent (Upload Signed Contract)"></span></span>
		<?php //} 
        //if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='')){ ?>
		<span class="btn checklistClassyellow btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="<?php //echo $insertid; ?>" tabopen="<?php //echo $tab_name_val; ?>"><span class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Sent (Status Pending)"></span></span>
		<?php //} 
		
		//if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='No')){ ?>
		<span class="btn checklistClassred btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="<?php //echo $insertid; ?>" tabopen="<?php //echo $tab_name_val; ?>"><span class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Not Approved(Check Remarks)"></span></span>
		<?php //} 
        
         //if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='Yes')){ ?>
		<span class="btn btn-success btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="<?php //echo $insertid; ?>" tabopen="<?php //echo $tab_name_val; ?>"><span class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Approved (Processing LOA)"></span></span>
		<?php //} ?>
        
		</td-->
		<td>
		<?php
		if(($file_receipt == '') && ($loa_file == '')){
			echo "<span class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='bottom' title='No Action Taken'><i class='fas fa-times'></i></span>";
		}
		if(($file_receipt == '1') && ($loa_file == '')){ 
			echo "<span class='btn checklistClassyellow btn-sm' data-toggle='tooltip' data-placement='top' title='LOA Processing'><i class='fas fa-sync-alt'></i></span>";
		}
		
		if(($file_receipt == '1') && ($loa_file !== '') && ($loa_file_status == '') && ($support_letter =='') && ($loa_receipt_file == '') && ($college_tt == '')){ 
			echo "<span class='btn checklistClassgreen btn-sm' data-toggle='tooltip' data-placement='top' title='LOA Processing'><i class='fas fa-sync-alt'></i></span>";
		}
		if(($file_receipt == '1') && ($loa_file !== '') && ($loa_file_status == '1') && ($support_letter =='') && ($loa_receipt_file == '') && ($college_tt == '')){ 
			echo "<a href='uploads/$loa_file' class='btn btn-success btn-sm' download><i class='fas fa-download'></i></a>";
		}
		if(($file_receipt == '1') && ($loa_file !== '') && ($loa_file_status == '1') && ($support_letter !=='') && ($loa_receipt_file == '') && ($college_tt == '')){ 
			echo "<span class='btn checklistClassgreen btn-sm receiptClass' data-toggle='modal' data-target='#receiptModel' data-id=".$insertid."><i class='fas fa-download' data-toggle='tooltip' data-placement='top' title='LOA File Download'></i></span>";
		}
		if(($file_receipt == '1') && ($loa_file !== '') && ($loa_file_status == '1') && ($loa_receipt_file !== '' || $college_tt !== '')){
			echo "<span class='btn checklistClassgreen btn-sm receiptClass' data-toggle='modal' data-target='#receiptModel' data-id=".$insertid."><i class='fas fa-download' data-toggle='tooltip' data-placement='top' title='LOA File Download'></i></span>";
		}
		?>
		</td>
		
		<td>
		<?php 
		if(($loa_file_status == '') && ($fh_status == '') && ($v_g_r_status == '')){
			echo "<span class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='bottom' title='No Action Taken'><i class='fas fa-times'></i></span>";
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status == '')){ 		
			echo '<div class="btn checklistClassred btn-sm invoiceClass" data-toggle="modal" data-target="#invoiceModel" data-id='.$insertid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="F@H Status Pending"></i></div>';
		}
		if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status == '')){		
			echo '<div class="btn checklistClassyellow btn-sm invoiceClass" data-toggle="modal" data-target="#invoiceModel" data-id='.$insertid.'><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="File Lodged & Status Pending"></i></div>';
		}
		if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status !== '')){
			echo '<div class="btn checklistClassred btn-sm invoiceClass" data-toggle="modal" data-target="#invoiceModel" data-id='.$insertid.'><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="File Not Lodged"></i></div>';
		}
		if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status !== '')){
		if(($v_g_r_status == 'V-G')){
			if(($v_g_r_status == 'V-G') && ($v_g_r_invoice =='') && ($inovice_status =='')){
		?>
		<div class="btn checklistClassyellow btn-sm invoiceClass" data-toggle="modal" data-target="#invoiceModel" data-id="<?php echo $insertid;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="V-G Status(Invoice Pending)"></i></div>
		<?php }
			if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='')){
		?>
		<div class="btn checklistClassgreen btn-sm invoiceClass" data-toggle="modal" data-target="#invoiceModel" data-id="<?php echo $insertid;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="V-G Invoice Processed"></i></div>
		<?php }
			if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='Yes')){
		?>
		<div class="btn checklistClassgreen btn-sm invoiceClass" data-toggle="modal" data-target="#invoiceModel" data-id="<?php echo $insertid;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Processed by Processor"></i></div>
		<?php }
		if(($v_g_r_status == 'V-G') && ($v_g_r_invoice !=='') && ($inovice_status =='No')){
		?>
		<div class="btn checklistClassred btn-sm invoiceClass" data-toggle="modal" data-target="#invoiceModel" data-id="<?php echo $insertid;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Commission Not Processed by Processor"></i></div>
		<?php }
		}
		if($v_g_r_status == 'V-R'){
		if(($file_upload_vr_status == '') && ($tt_upload_report_status == '')){
			echo "<span class='btn checklistClassyellow btn-sm invoiceClass' data-toggle='modal' data-target='#invoiceModel' data-id=".$insertid."><i class='fas fa-upload' data-toggle='tooltip' data-placement='top' title='Upload Refund Forms'></i></span>";
		}
		if(($file_upload_vr_status !== '') && ($tt_upload_report_status == '')){
			echo "<span class='btn checklistClassgreen btn-sm invoiceClass' data-toggle='modal' data-target='#invoiceModel' data-id=".$insertid."><i class='fas fa-upload' data-toggle='tooltip' data-placement='top' title='Refund Forms Uploaded(Status Pending)'></i></span>";
		}
		if(($file_upload_vr_status !== '') && ($tt_upload_report_status == 'Yes')){
			echo "<span class='btn checklistClassgreen btn-sm invoiceClass' data-toggle='modal' data-target='#invoiceModel' data-id=".$insertid."><i class='fas fa-check' data-toggle='tooltip' data-placement='top' title='Refund Docs Approved(Processing Refund)'></i></span>";
		}
		if(($file_upload_vr_status !== '') && ($tt_upload_report_status == 'No')){
			echo "<span class='btn checklistClassgreen btn-sm invoiceClass' data-toggle='modal' data-target='#invoiceModel' data-id=".$insertid."><i class='fas fa-upload' data-toggle='tooltip' data-placement='top' title='Refund Files Status Not Approved'></i></span>";
		}
		}
		}
		?>
		</td>
		<td>
		<?php 
		if(($v_g_r_status=='') && ($quarantine_plan=='')){ 
		?>
		<span class="btn-danger btn btn-sm"><i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="No Action Made"></i></span>
		<?php }
		if(($v_g_r_status!='') && ($quarantine_plan=='')){
		?>
		<span class="btn-warning btn btn-sm qrnPlanClass" data-toggle="modal" data-target="#qrnPlanModel" data-id="<?php echo $insertid;?>"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Sigend Quarantine Plan Pending"></i></span>
		<?php }
		if(($v_g_r_status!='') && ($quarantine_plan!='')){
		?>
		<span class="btn-success btn btn-sm qrnPlanClass" data-toggle="modal" data-target="#qrnPlanModel" data-id="<?php echo $insertid;?>"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Student Sigend Quarantine Plan"></i></span>
		<?php } ?>	
		</td>
      </tr>
	<?php } ?>
    </tbody>
	</table>			
	</div>

<div class="col-md-8 mt-2 pl-3">
	<strong>Total Records <?php echo $total_records; ?>, </strong>
	<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<div class="col-md-4 mt-2">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-end">    
	<li <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url'"; } ?> class="page-link">Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>$counter</a></li>";
				}
        }
		echo "<li class='page-item'><a class='page-link'>...</a></li>";
		echo "<li class='page-item'><a href='?page_no=$second_last&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>$second_last</a></li>";
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li class='page-item'><a href='?page_no=1&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>$counter</a></li>";
				}                  
       }
       echo "<li class='page-item'><a class='page-link'>...</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$second_last&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>$second_last</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li class='page-item'><a href='?page_no=1&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url'"; } ?> class='page-link'>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&srchstatus=$searchStatus&roletype=$tabVal&subid=$uname1&rowbg=$rowbg&getsearch=$search_url' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>
</nav>
</div>
</div>

	</div>
	</div>
	</div>
   </div>
  </div>
 </div>
</div>
</div>
<div class="modal fade" id="myModaljjjs" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">View Details</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div id="ldld"></div>
</div>

</div>
</div>
</div>

<div class="modal fade" id="checklistModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Check Application Status</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div id="statusRemarks"></div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="olAgreementModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content"><div class="modal-header">
<h4 class="modal-title">Check Application Status</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="loading_icon"></div>
<div class="olAgreement"></div>
<div class="listSignedBtn"></div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="checkAgree" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">ACC Contract</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="row">
  <div class="col-sm-12 form-group">	
	<div id="reslist1"></div>
	
	<div id="reslist2"></div>
  </div>
</div>
</div>
</div>
</div>
</div>

<?php if(isset($_GET["aid"])){ ?>
<script>
	$(".<?php echo $_GET["aid"];?>").css({"background-color": "#A8D8F4"});
	$("#<?php echo $_GET["aid"];?>").prop('checked', true);
</script>
<?php } ?>

<script>
$(document).ready(function (e){	
	$('.formpay').on('submit', function (e) {
		$('.loading_icon').show();
		e.preventDefault();
		$.ajax({
		url: "../response.php?tag=rcppay",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(d){
			if(d == '1'){
				$('.loading_icon').hide();
				alert('Your Request LOA has been submitted.');
				window.location.href = "http://aoltorontoagents.ca/application";	
				return true;
			}
		},
		error: function(){} 	        
	    });
    });
});

$(document).on('click', '.checklistClass', function(){
	var idmodel = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=chkstatus",{"idno":idmodel},function(d){
		$('#statusRemarks').html("");
		$('<div class="remarks">' +
		'<p><strong>Status: </strong>'+d[0].asc+'</p>'+
		'<p><strong>Remarks: </strong>'+d[0].arc+'</p>'+
		'</div>').appendTo("#statusRemarks");
		$('.loading_icon').hide();
	});
});

$(document).on('click', '.ol_agreement', function(){
	var idmodel = $(this).attr('data-id');
	$('.snoid').attr('value' ,idmodel);
	var agnt = $(this).attr('tabopen'); 
	$('.loading_icon').show();
	$.post("../response.php?tag=agreement",{"idno":idmodel, "roletype":agnt},function(d){		
		$('.olAgreement').html("");
		$('<div>' +
		'<div><b>Conditional Offer Letter:</b>'+
		'<span>' + d[0].oldnl + '</span><br>' +
		'</div>'+
		'<div><b>Signed Conditional Offer Letter:</b>'+
		'<span>' + d[0].agl + '</span><br>' +
		'</div>'+
		''+d[0].uscol+''+
		'</div>').appendTo(".olAgreement");
		$('.loading_icon').hide();
		
		$.post("../response.php?tag=signedBtnLetter",{"idno":idmodel},function(d){
			$('.listSignedBtn').html("");
			$('<div>' +
			'<p><b>Signed Conditional Offer Letter Status: </b>' + d[0].oldnl + '</p>' +
			'<p><b>Remarks: </b>' + d[0].remarks + '</p>' +
			'</div>').appendTo(".listSignedBtn");
		});
		
		$('.agreementInput').on('change', function(){
			var agreementsize_image = this.files[0].size;
			if(agreementsize_image <= '3145728'){
				
			}else{
				alert('File too large. File must be less than 3 MB.');
				return false;
			}
		});	
	
	});
});

$(document).on('click', '.agreeClass', function(){
	$('.loading_icon').show();
	var idmodel = $(this).attr('data-id');
	$('.rcptid').attr('value' ,idmodel);
	var agnt = $(this).attr('tabopen');
	$.post("../response.php?tag=agreeLetter",{"idno":idmodel, "roletype":agnt},function(d){
		$('#reslist1').html("");
		$('<div>' +
		'<p><b>ACC Contract: </b>' + d[0].DownloadAgree + '&nbsp; | &nbsp;' +
		'<b>Student Handbook: </b>' + d[0].DownloadHandbook + '</p>' +
		''+d[0].usc+''+
		'</div>').appendTo("#reslist1");
		
		$('.uscDiv').on('change', function(){
			var uscDiv_image = this.files[0].size;
			if(uscDiv_image <= '5242880'){
				
			}else{
				alert('File too large. File must be less than 5 MB.');
				return false;
			}
		});
		
		$('.ushDiv').on('change', function(){
			var ushDiv_image = this.files[0].size;
			if(ushDiv_image <= '5242880'){
				
			}else{
				alert('File too large. File must be less than 5 MB.');
				return false;
			}
		});
		
	});
	$.post("../response.php?tag=agreeLetter2",{"idno":idmodel},function(d){
		$('#reslist2').html("");
		$('<div>' +
		'<p class="m-0"><b>ACC Signed Contract: </b>' + d[0].sal + '</p>' +
		'<p class="m-0"><b>Student Signed Handbook: </b>' + d[0].shb + '</p>' +
		'<p class="m-0"><b>ACC Signed Contract Status: </b>' + d[0].stts + '</p>' +
		'<p class="m-0"><b>Remarks: </b>' + d[0].aalr + '</p>' +
		'</div>').appendTo("#reslist2");
		$('.loading_icon').hide();
	});
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
		'<p><b>Full Name: </b>' + obj[0].fname + obj[0].lname + '</p>' +
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

$('.interCode').on('change',function(){
	var ic = $(this).val();
	if(ic == 'Enter Code'){
		$('.ftext').show();
		$('.frec').hide();
	}
	if(ic == 'Upload Receipt'){
		$('.ftext').hide();
		$('.frec').show();
	}
	if(ic == ''){
		$('.ftext').hide();
		$('.frec').hide();
	}	
});
$(document).ready(function () {
	$("#aol_requried").submit(function () {
		var submit = true;
		$(".is_require1:visible").each(function(){
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
			$('.is_require1').keyup(function(){
				$(this).removeClass('error_color');
			});
			return false;        
		}
	});
});

// $(document).on('click', '.sabbtn', function(){
	// var agnt = $(this).attr('uVal');
	// $('.applicationStatus').attr('tabid', agnt);
	// var rowbg = $(this).attr('rowbg');
	// var uid = '';
	// if(agnt == 'All'){
	// 	$('.dropagent').hide();
	// 	$('li#activeId1').removeClass("active");
	// 	$('li#activeId').addClass("active");
	// }
	// if(agnt == 'Sub'){
	// 	$('.dropagent').show();
	// 	$('li#activeId').removeClass("active");
	// 	$('li#activeId1').addClass("active");
	// }	
	// $('.agentuname').val("");
	// $('.loading_icon').show();
	// $.post("../response.php?tag=subget",{"roletype":agnt, "rowbg":rowbg, "subid":uid},function(d){
	// if(d == ""){	
	// 	alert("Not found");
	// 	$('.searchall').html(" ");
	// 	$('.loading_icon').hide();
	// }else{	
	// 	$('.searchall').html(" ");		
	// 	for (i in d) {
	// 		$('<tr '+d[i].chbx+'>' +
	// 		'<td>'+d[i].chkbx1+'</td>' +
	// 		'<td>'+d[i].agntname+'</td>' +
	// 		'<td>'+d[i].fname+' '+d[i].lname+'</td>' + 
	// 		'<td>'+d[i].prg_intake+'</td>' + 
	// 		'<td>'+d[i].prg_name+'</td>' + 
	// 		'<td>'+d[i].appliStatus+'</td>'+
	// 		'<td>'+d[i].col+'</td>'+
	// 		'<td>'+d[i].rqstLoa+'</td>'+
	// 		'<td>'+d[i].aolCnt+'</td>'+
	// 		'<td>'+d[i].dnldLoa+'</td>'+
	// 		'</tr>').appendTo(".searchall");
	// 	}
	// }
	// 	$('.loading_icon').hide();
	// 	$("[data-toggle='tooltip']").tooltip();	


// <!--- Request LOA --->
	// $('.loaRqst').on('click', function(){
	// var status = $(this).attr('idno');
    // var message = "You can change the status";
        // if(status){
            // var updateMessage = "LOA Request Sent";
        // }else{
            // var updateMessage = "Cancel";
        // }        
        // swal({
            // title: "Are you sure?",
            // text: message,
            // type: "warning",
            // showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            // closeOnConfirm: false
        // }, function () {
		// var url = '../response.php?tag=confirm_loa';
		// $.ajax({
			// type: "POST",
			// url: url,
			// data:'idno='+status, 
			// success :  function(data){			   
			// if(data == 1){
				// swal("Updated!", "Status " + updateMessage +" successfully", "success");   
			// }else{
			   // swal("Failed", data, "error");				   
			// }
			// setTimeout(function(){
				// location.reload(); 
			// }, 2000);  
            // }
        // })  
    // }); 
	// });	

	
// 	});	
// });

$(document).on('change', '.agentuname', function(){
	var agnt = 'Sub';
	var uid = $(this).val();
	var rowbg = $(this).attr('rowbg');	
	$('.loading_icon').show();
	$.post("../response.php?tag=subget",{"roletype":agnt, "subid":uid, "rowbg":rowbg},function(d){
	if(d == ""){		
		alert("Not found");
		$('.searchall').html(" ");
		$('.loading_icon').hide();		
	}else{
		$('.searchall').html(" ");		
		for (i in d) {
			$('<tr '+d[i].chbx+'>' +
			'<td>'+d[i].chkbx1+'</td>' +
			'<td>'+d[i].agntname+'</td>' +
			'<td>'+d[i].fname+' '+d[i].lname+'</td>' + 
			'<td>'+d[i].prg_intake+'</td>' + 
			'<td>'+d[i].prg_name+'</td>' + 
			'<td>'+d[i].appliStatus+'</td>'+
			'<td>'+d[i].col+'</td>'+
			'<td>'+d[i].rqstLoa+'</td>'+
			'<td>'+d[i].aolCnt+'</td>'+
			'<td>'+d[i].dnldLoa+'</td>'+
			'</tr>').appendTo(".searchall");
		}
	}
		$('.loading_icon').hide();
		$("[data-toggle='tooltip']").tooltip();
	});	
});


$(document).on('change', '.applicationStatus', function(){
	var agnt = $(this).attr('tabid');
	var idtype1 = $(this).val(); 
	var statusVal = $('option:selected', this).attr('data-id')
	if(idtype1 !== ''){
		idtype2 = idtype1;
	}
	if(idtype1 == ''){
		idtype2 = '';
	}
	var rowbg = $(this).attr('rowbg');

	location.href="../application/?srchstatus="+statusVal+"&page_no=1&roletype="+agnt+"&subid="+idtype2+"&rowbg="+rowbg+"&getsearch=";
	return true;


	// $('.loading_icon').show();	
	// $.post("../response.php?tag=Select_Status",{"roletype":agnt, "status1":statusVal, "subid":idtype2, "rowbg":rowbg},function(d){
	// if(d == ""){		
	// 	alert("Not found");
	// 	$('.searchall').html(" ");
	// 	$('.loading_icon').hide();		
	// }else{
	// 	$('.searchall').html(" ");		
	// 	for (i in d) {
	// 		$('<tr '+d[i].chbx+'>' +
	// 		'<td>'+d[i].chkbx1+'</td>' +
	// 		'<td>'+d[i].agntname+'</td>' +
	// 		'<td>'+d[i].fname+' '+d[i].lname+'</td>' + 
	// 		'<td>'+d[i].prg_intake+'</td>' + 
	// 		'<td>'+d[i].prg_name+'</td>' + 
	// 		'<td>'+d[i].appliStatus+'</td>'+
	// 		'<td>'+d[i].col+'</td>'+
	// 		'<td>'+d[i].rqstLoa+'</td>'+
	// 		'<td>'+d[i].aolCnt+'</td>'+
	// 		'<td>'+d[i].dnldLoa+'</td>'+
	// 		'<td>'+d[i].fh_VR_Status+'</td>'+
	// 		'</tr>').appendTo(".searchall");
	// 	}
	// }
	// 	$("[data-toggle='tooltip']").tooltip();
	// 	$('.loading_icon').hide();
	// });	
});
</script>

<script src="../js/document.js"></script>

<div class="modal fade" id="invoiceModel" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">
<div class="loading_icon"></div>
<div class="invoiceagentdiv"></div>
<div class="stuTravelDiv"></div>
</div>
</div>
</div>
</div>

<script>
$(document).on('click', '.invoiceClass', function(){
	var idmodel = $(this).attr('data-id');
	$('.loading_icon').show();
	$.post("../response.php?tag=invoiceAgentList",{"idno":idmodel},function(d){
		$('.invoiceagentdiv').html("");
		$('<div class="remarks">' +
		''+d[0].statushead+''+
		''+d[0].both_VG_VR_Status+''+
		''+d[0].tt_report_upload+''+
		'</div>').appendTo(".invoiceagentdiv");
		$('.loading_icon').hide();
		
//// first file upload	
	var progressbar1 = $('.progress-bar1');
	$(".upload-image1").on('change',function(){
		$(".form-horizontal-docu1").ajaxForm(
	{
	  target: '.preview1',
	  beforeSend: function() {  
		$('.preview1').show();
		$('#removeDoc1').show();
		$('#removeDoc1').css('margin','-16px 0px 0 88px !important');		
		$('#showbtn1').hide();
		progressbar1.width('0%');
		progressbar1.text('0%');
	  },
		uploadProgress: function (event, position, total, percentComplete) {
		$(".progress1").css("display","block");
		progressbar1.width(percentComplete + '%');
		progressbar1.text(percentComplete + '%');		
		},
		complete: function(xhr) {
			var msgs = xhr.responseText;
			if(msgs == 'failed'){
				$('.errorMsg1').show();
				$('.errorMsg1').html('uploading failed');
				$(".progress1").css("display","block");
			} else if (msgs == 'notsupport'){
				$('.errorMsg1').show();
				$('.errorMsg1').html('File is not Supported (Please upload the PDF and ZIP Files)');
			}else{
				$('#imageres1').hide();
				$('#imageres1').html(msgs);
				$('#imageDoc1Hide1').hide();				
				$(".progress1").css("display","block");
			}
		}
	})
	.submit();
	});
	
$('#removeDoc1').click(function(){
	  $('#imageDoc1Hide1').hide();
	  $('#removeDoc1').hide();
	  $('.preview1').hide();
	  $('.progress1').hide();
	  $('.errorMsg1').hide();
	  $('#showbtn1').show();
	  $('#imageres1').hide();
});


//// Second file upload	
	var progressbar2 = $('.progress-bar2');
	$(".upload-image2").on('change',function(){
		$(".form-horizontal-docu2").ajaxForm(
	{
	  target: '.preview2',
	  beforeSend: function() {  
		$('.preview2').show();
		$('#removeDoc2').show();
		$('#removeDoc2').css('margin','-16px 0px 0 88px !important');		
		$('#showbtn2').hide();
		progressbar2.width('0%');
		progressbar2.text('0%');
	  },
		uploadProgress: function (event, position, total, percentComplete) {
		$(".progress2").css("display","block");
		progressbar2.width(percentComplete + '%');
		progressbar2.text(percentComplete + '%');		
		},
		complete: function(xhr) {
			var msgs = xhr.responseText;
			if(msgs == 'failed'){
				$('.errorMsg2').show();
				$('.errorMsg2').html('uploading failed');
				$(".progress2").css("display","block");
			} else if (msgs == 'notsupport'){
				$('.errorMsg2').show();
				$('.errorMsg2').html('File is not Supported (Please upload the PDF and ZIP Files)');
			}else{
				$('#imageres2').hide();
				$('#imageres2').html(msgs);
				$('#imageDoc1Hide2').hide();				
				$(".progress2").css("display","block");
			}
		}
	})
	.submit();
	});
	
$('#removeDoc2').click(function(){
	  $('#imageDoc1Hide2').hide();
	  $('#removeDoc2').hide();
	  $('.preview2').hide();
	  $('.progress2').hide();
	  $('.errorMsg2').hide();
	  $('#showbtn2').show();
	  $('#imageres2').hide();
});


//// Third file upload	
	var progressbar3 = $('.progress-bar3');
	$(".upload-image3").on('change',function(){
		$(".form-horizontal-docu3").ajaxForm(
	{
	  target: '.preview3',
	  beforeSend: function() {  
		$('.preview3').show();
		$('#removeDoc3').show();
		$('#removeDoc3').css('margin','-16px 0px 0 88px !important');		
		$('#showbtn3').hide();
		progressbar3.width('0%');
		progressbar3.text('0%');
	  },
		uploadProgress: function (event, position, total, percentComplete) {
		$(".progress3").css("display","block");
		progressbar3.width(percentComplete + '%');
		progressbar3.text(percentComplete + '%');		
		},
		complete: function(xhr) {
			var msgs = xhr.responseText;
			if(msgs == 'failed'){
				$('.errorMsg3').show();
				$('.errorMsg3').html('uploading failed');
				$(".progress3").css("display","block");
			} else if (msgs == 'notsupport'){
				$('.errorMsg3').show();
				$('.errorMsg3').html('File is not Supported (Please upload the PDF and ZIP Files)');
			}else{
				$('#imageres3').hide();
				$('#imageres3').html(msgs);
				$('#imageDoc1Hide3').hide();				
				$(".progress3").css("display","block");
			}
		}
	})
	.submit();
	});
	
$('#removeDoc3').click(function(){
	  $('#imageDoc1Hide3').hide();
	  $('#removeDoc3').hide();
	  $('.preview3').hide();
	  $('.progress3').hide();
	  $('.errorMsg3').hide();
	  $('#showbtn3').show();
	  $('#imageres3').hide();
});
<!------------------------------------------------>		
});

//// Students Travelling Upload Div ////
	$.post("../response.php?tag=stuTravelAgent",{"idno":idmodel},function(d){
		$('.stuTravelDiv').html("");
		$('<div class="remarks">' +
		''+d[0].student_travel_div+''+
		'</div>').appendTo(".stuTravelDiv");
		$('.loading_icon').hide();
		
	//// Quarantine Plan Form
	var progressbar1 = $('.progress-bar1_91');
	$(".upload-image1_91").on('change',function(){
		$(".form-horizontal-docu1_91").ajaxForm(
	{
	  target: '.preview1_91',
	  beforeSend: function() {
		$('.preview1_91').show();
		$('#removeDoc1_91').show();
		$('#removeDoc1_91').css('margin','-16px 0px 0 88px !important');
		$('#showbtn1_91').hide();
		progressbar1.width('0%');
		progressbar1.text('0%');
	  },
		uploadProgress: function (event, position, total, percentComplete) {
		$(".progress1_91").css("display","block");
		progressbar1.width(percentComplete + '%');
		progressbar1.text(percentComplete + '%');
		},
		complete: function(xhr) {
			var msgs = xhr.responseText;
			if(msgs == 'failed'){
				$('.errorMsg1_91').show();
				$('.errorMsg1_91').html('uploading failed');
				$(".progress1_91").css("display","block");
			} else if (msgs == 'notsupport'){
				$('.errorMsg1_91').show();
				$('.errorMsg1_91').html('File is not Supported (Please upload the PDF and ZIP Files)');
			}else{
				$('#imageres1_91').hide();
				$('#imageres1_91').html(msgs);
				$('#imageDoc1Hide1_91').hide();
				$(".progress1_91").css("display","block");
			}
		}
	})
	.submit();
	});
	
$('#removeDoc1_91').click(function(){
	  $('#imageDoc1Hide1_91').hide();
	  $('#removeDoc1_91').hide();
	  $('.preview1_91').hide();
	  $('.progress1_91').hide();
	  $('.errorMsg1_91').hide();
	  $('#showbtn1_91').show();
	  $('#imageres1_91').hide();
});
	
	//// LOA/Receipt
	var progressbar1_92 = $('.progress-bar1_92');
	$(".upload-image1_92").on('change',function(){
		$(".form-horizontal-docu1_92").ajaxForm(
	{
	  target: '.preview1_92',
	  beforeSend: function() {
		$('.preview1_92').show();
		$('#removeDoc1_92').show();
		$('#removeDoc1_92').css('margin','-16px 0px 0 88px !important');
		$('#showbtn1_92').hide();
		progressbar1_92.width('0%');
		progressbar1_92.text('0%');
	  },
		uploadProgress: function (event, position, total, percentComplete) {
		$(".progress1_92").css("display","block");
		progressbar1_92.width(percentComplete + '%');
		progressbar1_92.text(percentComplete + '%');
		},
		complete: function(xhr) {
			var msgs = xhr.responseText;
			if(msgs == 'failed'){
				$('.errorMsg1_92').show();
				$('.errorMsg1_92').html('uploading failed');
				$(".progress1_92").css("display","block");
			} else if (msgs == 'notsupport'){
				$('.errorMsg1_92').show();
				$('.errorMsg1_92').html('File is not Supported (Please upload the PDF and ZIP Files)');
			}else{
				$('#imageres1_92').hide();
				$('#imageres1_92').html(msgs);
				$('#imageDoc1Hide1_92').hide();
				$(".progress1_92").css("display","block");
			}
		}
	})
	.submit();
	});	
$('#removeDoc1_92').click(function(){
	  $('#imageDoc1Hide1_92').hide();
	  $('#removeDoc1_92').hide();
	  $('.preview1_92').hide();
	  $('.progress1_92').hide();
	  $('.errorMsg1_92').hide();
	  $('#showbtn1_92').show();
	  $('#imageres1_92').hide();
});
	
	//// Air Ticket
	var progressbar1_93 = $('.progress-bar1_93');
	$(".upload-image1_93").on('change',function(){
		$(".form-horizontal-docu1_93").ajaxForm(
	{
	  target: '.preview1_93',
	  beforeSend: function() {
		$('.preview1_93').show();
		$('#removeDoc1_93').show();
		$('#removeDoc1_93').css('margin','-16px 0px 0 88px !important');
		$('#showbtn1_93').hide();
		progressbar1_93.width('0%');
		progressbar1_93.text('0%');
	  },
		uploadProgress: function (event, position, total, percentComplete) {
		$(".progress1_93").css("display","block");
		progressbar1_93.width(percentComplete + '%');
		progressbar1_93.text(percentComplete + '%');
		},
		complete: function(xhr) {
			var msgs = xhr.responseText;
			if(msgs == 'failed'){
				$('.errorMsg1_93').show();
				$('.errorMsg1_93').html('uploading failed');
				$(".progress1_93").css("display","block");
			} else if (msgs == 'notsupport'){
				$('.errorMsg1_93').show();
				$('.errorMsg1_93').html('File is not Supported (Please upload the PDF and ZIP Files)');
			}else{
				$('#imageres1_93').hide();
				$('#imageres1_93').html(msgs);
				$('#imageDoc1Hide1_93').hide();
				$(".progress1_93").css("display","block");
			}
		}
	})
	.submit();
	});	
$('#removeDoc1_93').click(function(){
	  $('#imageDoc1Hide1_93').hide();
	  $('#removeDoc1_93').hide();
	  $('.preview1_93').hide();
	  $('.progress1_93').hide();
	  $('.errorMsg1_93').hide();
	  $('#showbtn1_93').show();
	  $('#imageres1_93').hide();
});	
	
	////Passport
	var progressbar1_94 = $('.progress-bar1_94');
	$(".upload-image1_94").on('change',function(){
		$(".form-horizontal-docu1_94").ajaxForm(
	{
	  target: '.preview1_94',
	  beforeSend: function() {
		$('.preview1_94').show();
		$('#removeDoc1_94').show();
		$('#removeDoc1_94').css('margin','-16px 0px 0 88px !important');
		$('#showbtn1_94').hide();
		progressbar1_94.width('0%');
		progressbar1_94.text('0%');
	  },
		uploadProgress: function (event, position, total, percentComplete) {
		$(".progress1_94").css("display","block");
		progressbar1_94.width(percentComplete + '%');
		progressbar1_94.text(percentComplete + '%');
		},
		complete: function(xhr) {
			var msgs = xhr.responseText;
			if(msgs == 'failed'){
				$('.errorMsg1_94').show();
				$('.errorMsg1_94').html('uploading failed');
				$(".progress1_94").css("display","block");
			} else if (msgs == 'notsupport'){
				$('.errorMsg1_94').show();
				$('.errorMsg1_94').html('File is not Supported (Please upload the PDF and ZIP Files)');
			}else{
				$('#imageres1_94').hide();
				$('#imageres1_94').html(msgs);
				$('#imageDoc1Hide1_94').hide();
				$(".progress1_94").css("display","block");
			}
		}
	})
	.submit();
	});
$('#removeDoc1_94').click(function(){
	  $('#imageDoc1Hide1_94').hide();
	  $('#removeDoc1_94').hide();
	  $('.preview1_94').hide();
	  $('.progress1_94').hide();
	  $('.errorMsg1_94').hide();
	  $('#showbtn1_94').show();
	  $('#imageres1_94').hide();
});	
	
});	
	
});
</script>

<div class="modal fade" id="loaRqstModel" role="dialog">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
	<h5 class="modal-title">Request LOA</h5>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="getWithoutTT"></div>
<div class="getLOAList"></div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="qrnPlanModel" role="dialog">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
	<h5 class="modal-title">Signed	Quarantine Plan</h5>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="row">
<div class="col-sm-12">
<div class="loading_icon"></div>
<div class="qrnPlanDiv"></div>
</div>
</div>
</div>
</div>
</div>
</div>



<div class="modal fade" id="modalAppRemarks" role="dialog">
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
	<input type="hidden" name="sessionid" value="<?php echo $sessionid1;?>">
	<input type="hidden" name="sessionname" value="<?php echo $username;?>">
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
		// $('.loa_tt_remarks').val('');
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
	// var get_loa_tt_remarks1 = $('.loa_tt_remarks').val();
	var getinput = $('.ttwot').length;	
	if(get_tt == 'Request LOA With TT' && (get_tt1 == '')){
		$('.loading_icon').hide();
		$('.loa_tt').css({"border": "1px solid red"});
		// $('.loa_tt_remarks').css({"border": "1px solid red"});
		return false;
	}
	if(get_tt == 'Request LOA Without TT'){
		if($('.gc_username').val() == '' && getinput <= 4){
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
	
$(document).on('click', '.loaRqstClass', function(){
	var idmodel = $(this).attr('data-id'); 
	// $('.loaRqst_sno').attr('value', idmodel);
	$('.loading_icon').show();
	
	$.post("../response.php?tag=getAolWithoutTT",{"idno":idmodel},function(d){
		$('.getWithoutTT').html("");
		$('<div>' +
		'' + d[0].getWithoutTTVal + '' +		
		'</div>').appendTo(".getWithoutTT");
		$('.loading_icon').hide();	
	});
	
	$.post("../response.php?tag=getDropstatus",{"idno":idmodel},function(d){
		$('.getLOAList').html("");
		$('<div>' +
		'' + d[0].loaReceipt + '' +		
		'</div>').appendTo(".getLOAList");
		$('.loading_icon').hide();	
	});	
});	

$(document).on('click', '.qrnPlanClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.loading_icon').show();
	$.post("../response.php?tag=getqrnPlan",{"idno":idmodel},function(d){
		$('.qrnPlanDiv').html("");
		$('<div>' +
		'' + d[0].getQrnPlanList + '' +
		'</div>').appendTo(".qrnPlanDiv");
		$('.loading_icon').hide();	
	});	
});


$('#queryStudentbtn').on('click', function(e){
$("#queryStudentbtn").attr("disabled", true);
	e.preventDefault();
	var getMsg = $('#application_comments').val();
	var appIdDiv = $('.appIdDiv').val();
	
	if(getMsg == "") {
		$('#application_comments').css({"border":"1px solid red"});		
	}
	
	if(getMsg == ""){
	$("#queryMsg").attr("disabled", false);
		return false;
	}		
	
	var $form = $(this).closest("#registerFrm");
	var formData =  $form.serializeArray();
	var URL = "../response.php?tag=getInTouch";
	$.post(URL, formData).done(function(data) {
		if(data == 1){
		  alert('Successfully Added Your Remarks!!!');
		  window.location.href='?aid=error_'+appIdDiv+''; 
		  $("#registerFrm")[0].reset();
		  $("#queryStudentbtn").attr("disabled", false);
		  return false;
		 }
	 });
	
});

$(document).on('click', '.divAppRemarks', function(){
	$('.loading_icon').show();
	var app_id = $(this).attr('data-id');
	$('.appIdDiv').attr('value', app_id);
	$.post("../response.php?tag=appRemarkDiv",{"app_id":app_id},function(d){
		$(".applRemarks").html(" ");
		if(d==''){
			$('<tr><td colspan="3"><center>Not Found!!!</center></td></tr>').appendTo(".applRemarks");
		}else{
		for (i in d) {
			$('<tr><td>'+ d[i].application_comments +'</td><td>'+ d[i].added_by_name +'</td><td>'+ d[i].datetime_at +'</td></tr>').appendTo(".applRemarks");
		}
		}
	$('.loading_icon').hide();		
	});	
});
</script>

<div class="modal fade" id="receiptModel" role="dialog">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header">
	<h5 class="modal-title">LOA File</h5>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<div class="LOAReceiptFile"></div>
</div>
</div>
</div>
</div>

<script>
$(document).on('click', '.receiptClass', function(){
	var idmodel = $(this).attr('data-id'); 
	$('.loading_icon').show();
	$.post("../response.php?tag=getLoaReceipt",{"idno":idmodel},function(d){
		$('.LOAReceiptFile').html("");
		$('<div>' +
		'' + d[0].getloaReceiptFile + '' +		
		'</div>').appendTo(".LOAReceiptFile");
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
<?php } 
include("../footer.php");
} } ?>
