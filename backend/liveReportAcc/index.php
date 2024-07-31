<?php
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
include("../../header_navbar.php");

if(($email2323 == 'admin@acc.com') || ($email2323 == 'acc_admin') || ($email2323 == 'viewdocs@acc.com')){
	
}else{
	header("Location: ../../login");
    exit();
}

if(isset($_POST['searchLiveBtn'])){
	$status_wise = $_POST['date_select'];
	$date_from = $_POST['date_from'];
	$date_to = $_POST['date_to'];		
	$intake_select = $_POST['intake_select'];		
	header("Location: ../liveReportAcc/?status_wise=$status_wise&date_from=$date_from&date_to=$date_to&intake_select=$intake_select");
}
$status_wise2 = '';
if(!empty($_GET['status_wise'])){
$status_wise2 = $_GET['status_wise'];

if($status_wise2 == 'Today'){
	$getIntake = '';
	$Fisrt_Previous = date("Y-m-d");
	$Last_Previous = date("Y-m-d");
	
	$registerDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$registerCompeleteDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$AS_Date = "AND (date_format(application_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$OL = "AND (date_format(offer_letter_sent_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$TT_date= "AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_date = "AND (date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Defer_Date = "AND loa_type='Defer' AND (date_format(loa_defer_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Revised_Date = "AND loa_type='Revised' AND (date_format(loa_revised_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$FH_date = "AND (date_format(fh_status_updated_by,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGR_AIP_date = "AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGRRefund_date = "AND (date_format(file_upload_vr_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
}

if($status_wise2 == 'Current_Month'){
	$getIntake = '';
	$Fisrt_Previous = date("Y-m-01");
	$Last_Previous = date("Y-m-d");
	
	$registerDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$registerCompeleteDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$AS_Date = "AND (date_format(application_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$OL = "AND (date_format(offer_letter_sent_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$TT_date= "AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_date = "AND (date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Defer_Date = "AND loa_type='Defer' AND (date_format(loa_defer_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Revised_Date = "AND loa_type='Revised' AND (date_format(loa_revised_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$FH_date = "AND (date_format(fh_status_updated_by,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGR_AIP_date = "AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGRRefund_date = "AND (date_format(file_upload_vr_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
}

if($status_wise2 == 'Previous_Month'){
	$getIntake = '';
	$Fisrt_Previous = date("Y-m-d", strtotime("first day of previous month"));
	$Last_Previous = date("Y-m-d", strtotime("last day of previous month"));
	
	$registerDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$registerCompeleteDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$AS_Date = "AND (date_format(application_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$OL = "AND (date_format(offer_letter_sent_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$TT_date= "AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_date = "AND (date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Defer_Date = "AND loa_type='Defer' AND (date_format(loa_defer_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Revised_Date = "AND loa_type='Revised' AND (date_format(loa_revised_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$FH_date = "AND (date_format(fh_status_updated_by,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGR_AIP_date = "AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGRRefund_date = "AND (date_format(file_upload_vr_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";	
}

if($status_wise2 == 'Select_Date'){
	$getIntake = '';
	$Fisrt_Previous = $_GET['date_from'];
	$Last_Previous = $_GET['date_to'];
	
	$registerDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$registerCompeleteDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$AS_Date = "AND (date_format(application_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$OL = "AND (date_format(offer_letter_sent_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$TT_date= "AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_date = "AND (date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Defer_Date = "AND loa_type='Defer' AND (date_format(loa_defer_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Revised_Date = "AND loa_type='Revised' AND (date_format(loa_revised_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$FH_date = "AND (date_format(fh_status_updated_by,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGR_AIP_date = "AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGRRefund_date = "AND (date_format(file_upload_vr_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
}

if($status_wise2 == 'Select_Intake'){
	$getIntake = $_GET['intake_select'];
	$Fisrt_Previous = '2018-01-01';
	$Last_Previous = date("Y-m-d");	
	
	$intakeCondition = "AND (englishpro!='ESL' AND englishpro!='FSL') AND prg_intake!='' AND prg_intake='$getIntake'";
	
	$registerDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$registerCompeleteDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$AS_Date = "AND (date_format(application_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$OL = "AND (date_format(offer_letter_sent_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$TT_date= "AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$LOA_date = "AND (date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$LOA_Defer_Date = "AND loa_type='Defer' AND (date_format(loa_defer_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$LOA_Revised_Date = "AND loa_type='Revised' AND (date_format(loa_revised_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$FH_date = "AND (date_format(fh_status_updated_by,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$VGR_AIP_date = "AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
	
	$VGRRefund_date = "AND (date_format(file_upload_vr_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous') $intakeCondition";
}

if($status_wise2 == 'Select_ESL'){
	$getIntake = '';
	$Fisrt_Previous = '2018-01-01';
	$Last_Previous = date("Y-m-d");	
	
	$registerDate = "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$registerCompeleteDate = "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$AS_Date = "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(application_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$OL = "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(offer_letter_sent_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$TT_date= "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_date = "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Defer_Date = "AND (englishpro='ESL' OR englishpro='FSL') AND loa_type='Defer' AND (date_format(loa_defer_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Revised_Date = "AND (englishpro='ESL' OR englishpro='FSL') AND loa_type='Revised' AND (date_format(loa_revised_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$FH_date = "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(fh_status_updated_by,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGR_AIP_date = "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGRRefund_date = "AND (englishpro='ESL' OR englishpro='FSL') AND (date_format(file_upload_vr_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";	
}

}else{
	$getIntake = '';
	$Fisrt_Previous = date("Y-m-d");
	$Last_Previous = date("Y-m-d");
	
	$registerDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$registerCompeleteDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$AS_Date = "AND (date_format(application_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$OL = "AND (date_format(offer_letter_sent_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$TT_date= "AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_date = "AND (date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Defer_Date = "AND loa_type='Defer' AND (date_format(loa_defer_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Revised_Date = "AND loa_type='Revised' AND (date_format(loa_revised_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$FH_date = "AND (date_format(fh_status_updated_by,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGR_AIP_date = "AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$VGRRefund_date = "AND (date_format(file_upload_vr_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
}

	$register_str = "SELECT sno FROM `st_application` where datetime!='' $registerDate";
	$rsltregister = mysqli_query($con, $register_str);
	$registerCount = mysqli_num_rows($rsltregister);
	
	$registerNotCompelete_str = "SELECT sno FROM `st_application` where datetime!='' AND (personal_status!='' AND academic_status!='' AND course_status!='' AND application_form!='') $registerCompeleteDate";
	$rsltregisterNotCompelete = mysqli_query($con, $registerNotCompelete_str);
	$registerNotCompeleteCount = mysqli_num_rows($rsltregisterNotCompelete);
	
	$appApproved_str = "SELECT sno FROM `st_application` where admin_status_crs='Yes' $AS_Date";
	$rsltappApproved = mysqli_query($con, $appApproved_str);
	$appApprovedCount = mysqli_num_rows($rsltappApproved);
	
	$PAL_str = "SELECT sno FROM `st_application` where offer_letter!='' AND offer_letter_sent_datetime!='' $OL";
	$rsltPAL = mysqli_query($con, $PAL_str);
	$PALCount = mysqli_num_rows($rsltPAL);
	
	$rqstTTWO_str = "SELECT sno FROM `st_application` where file_receipt!='' AND agent_request_loa_datetime!='' $TT_date";
	$rsltrqstTTWO = mysqli_query($con, $rqstTTWO_str);
	$rqstTTWOCount = mysqli_num_rows($rsltrqstTTWO);
	
	$rqstTTW_str = "SELECT sno FROM `st_application` where file_receipt!='' AND loa_tt!='' AND agent_request_loa_datetime!='' $TT_date";
	$rsltrqstTTW = mysqli_query($con, $rqstTTW_str);
	$rqstTTWCount = mysqli_num_rows($rsltrqstTTW);
	
	$LOA_Defer_str = "SELECT sno FROM `st_application` WHERE loa_file!='' AND loa_first_generate_date!='' $LOA_Defer_Date";
	$rsltLOA_Defer = mysqli_query($con, $LOA_Defer_str);
	$LOA_Defer = mysqli_num_rows($rsltLOA_Defer);
	
	$LOA_Revised_str = "SELECT sno FROM `st_application` WHERE loa_file!='' AND loa_first_generate_date!='' $LOA_Revised_Date";
	$rsltLOA_Revised = mysqli_query($con, $LOA_Revised_str);
	$LOA_Revised = mysqli_num_rows($rsltLOA_Revised);
	
	$LOA_First_str = "SELECT sno FROM `st_application` WHERE loa_file!='' AND loa_first_generate_date!='' $LOA_date";
	$rsltLOA_First = mysqli_query($con, $LOA_First_str);
	$LOA_FirstCount = mysqli_num_rows($rsltLOA_First);
	
	$rqstFH_str = "SELECT sno FROM `st_application` where (fh_status!='' AND fh_status='1') $FH_date";
	$rsltrqstFH = mysqli_query($con, $rqstFH_str);
	$rqstFHCount = mysqli_num_rows($rsltrqstFH);
	
	$rqstVR_str = "SELECT sno FROM `st_application` where (v_g_r_status!='' AND v_g_r_status='V-R') $VGR_AIP_date";
	$rsltrqstVR = mysqli_query($con, $rqstVR_str);
	$rqstVRCount = mysqli_num_rows($rsltrqstVR);
	
	$rqstVG_str = "SELECT sno FROM `st_application` where (v_g_r_status!='' AND v_g_r_status='V-G') $VGR_AIP_date";
	$rsltrqstVG = mysqli_query($con, $rqstVG_str);
	$rqstVGCount = mysqli_num_rows($rsltrqstVG);
	
	$rqstVGRRefund_str = "SELECT sno FROM `st_application` where  file_upload_vr_datetime!='' $VGRRefund_date";
	$rsltrqstVGRRefund = mysqli_query($con, $rqstVGRRefund_str);
	$rqstVGRRefundCount = mysqli_num_rows($rsltrqstVGRRefund);
?>
<section>
<div class="main-div">
<div class="col-lg-12">
<div class=" admin-dashboard">
<div class="row">	

<div class="col-sm-6 col-lg-6 col-xl-6">
<h3 class="mb-0 mt-2">All Times Report</h3>
</div>
</div>
	
	
<form method="POST" action="" class="row form_bg pt-1" autocomplete="off">		

<div class="col-md-4 col-xl-3 col-sm-6 mt-2">
	<select class="form-control form-control-sm date_select" name="date_select">
		<option value="">Select Option</option>
		<option value="Today"<?php if($status_wise2 == 'Today'){ ?> selected="selected" <?php } ?>>Today</option>
		<option value="Current_Month"<?php if($status_wise2 == 'Current_Month'){ ?> selected="selected" <?php } ?>>Current Month</option>
		<option value="Previous_Month"<?php if($status_wise2 == 'Previous_Month'){ ?> selected="selected" <?php } ?>>Previous Month</option>
		<option value="Select_Date"<?php if($status_wise2 == 'Select_Date'){ ?> selected="selected" <?php } ?>>Select Date</option>
		<option value="Select_Intake"<?php if($status_wise2 == 'Select_Intake'){ ?> selected="selected" <?php } ?>>Select Intake</option>
	</select>
</div>

<?php
if($status_wise2 == 'Select_Date'){
	$fixedDateFrom = "display:block";
	$date_from2 = $_GET['date_from'];
	$date_to2 = $_GET['date_to'];
}else{
	$fixedDateFrom = "display:none";
	$date_from2 = '';
	$date_to2 = '';
} ?>
		 <div class="col-md-4 col-xl-3 col-sm-6 mt-2 fixedDateFrom" style="<?php echo $fixedDateFrom; ?>">
	<input type="text" name="date_from" class="datepicker123 form-control form-control-sm" value="<?php echo $date_from2; ?>" placeholder="Date From">
</div>
<div class="col-md-4 col-xl-3 col-sm-6 mt-2 fixedDateFrom" style="<?php echo $fixedDateFrom; ?>">
	<input type="text" name="date_to" class="datepicker123 form-control form-control-sm" value="<?php echo $date_to2; ?>" placeholder="Date To">
</div>

<?php
if($status_wise2 == 'Select_Intake'){
	$fixedIntakeDiv = "display:block";
}else{
	$fixedIntakeDiv = "display:none";
} ?>
<div class="col-md-4 col-xl-3 col-sm-6 mt-2 fixedIntake" style="<?php echo $fixedIntakeDiv; ?>">
	<select class="form-control form-control-sm" name="intake_select">
		<option value="">Select Intake</option>
		<?php
		$getCrsesId = "SELECT * FROM `contract_courses` where intake!='' group by intake order by sno desc";
		$resultCrsesId = mysqli_query($con, $getCrsesId);
		while($resultCrsesRows = mysqli_fetch_assoc($resultCrsesId)){
			$intake = $resultCrsesRows['intake'];
		?>
		<option value="<?php echo $intake; ?>" <?php if($getIntake == $intake){ ?> selected="selected" <?php } ?>><?php echo $intake; ?></option>
		<?php } ?>
	</select>
</div>
<div class="dropagent col-md-4 col-xl-3 col-sm-6 mt-2">
	<input type="submit" name="searchLiveBtn" class=" btn btn-success float-sm-left float-right btn-sm px-4" value="Search">
</div>	
</form>	
	
<div class="row mt-4 justify-content-center">
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>Application Created</b>
		<p class="card-text">
		<a href="allTimeReportExcel.php?status=Application_Created&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>&status_wise=<?php echo $status_wise2; ?>" class="btn btn-success btn-sm mt-2"><?php echo $registerCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>Application Completed</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=Application_Completed&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $registerNotCompeleteCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>Application Approved</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=Application_Approved&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $appApprovedCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>COL</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=COL&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $PALCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>Without TT</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=TTWithOut&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $rqstTTWOCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>With TT</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=TTWith&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $rqstTTWCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>LOA First Time</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=LOAFirstTime&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $LOA_FirstCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>LOA Defer</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=LOA_Defer&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $LOA_Defer; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>LOA Revised</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=LOA_Revised&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $LOA_Revised; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>F@H</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=FH&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $rqstFHCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>VG</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=VG&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $rqstVGCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>VR</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=VR&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $rqstVRCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	<div class="col-6 col-xl-3 col-lg-4 col-sm-6 my-1">
	<div class="card">
    <div class="card-body text-center p-2">
	<b>VR Refund</b>
	  	<p class="card-text">
		<a href="allTimeReportExcel.php?status=VGVR_Refund&Fisrt=<?php echo $Fisrt_Previous; ?>&Last=<?php echo $Last_Previous; ?>&getIntake=<?php echo $getIntake; ?>" class="btn btn-success btn-sm mt-2"><?php echo $rqstVGRRefundCount; ?></a>
		</p>
	  </div>
	</div>
	</div>
	
	
	</div>
	</div>
</section>

</div>
</div>
</div>
<?php
	include("../../footer.php");
?>

<script>
$(document).on('change', '.date_select', function(){	
	var getOption2 = $(this).val();
	if(getOption2 == 'Select_Date' || getOption2 == 'Select_Intake'){
		if(getOption2 == 'Select_Date'){
			$('.fixedDateFrom').show();
			$('.fixedIntake').hide();
		}
		if(getOption2 == 'Select_Intake'){
			$('.fixedDateFrom').hide();
			$('.fixedIntake').show();
		}
	}else{
		$('.fixedDateFrom').hide();
		$('.fixedIntake').hide();
	}
});
</script>