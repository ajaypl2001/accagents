<?php
ob_start();
session_start();
include("../../db.php");
header("Content-Type: application/vnd.ms-excel");

$uname = $_SESSION['sno'];
if($uname == '1697' || $uname == '1700' || $uname == '1919'){

if(!empty($_GET['status']) && !empty($_GET['Fisrt']) && !empty($_GET['Last'])){
	$Fisrt_Previous = $_GET['Fisrt'];
	$Last_Previous = $_GET['Last'];
	$getStatus = $_GET['status'];
	$status_wise = $_GET['status_wise'];
	$getIntake = $_GET['getIntake'];
}else{
	header("Location: ../../login");
    exit();
}

if(!empty($status_wise) && $status_wise == 'Select_ESL'){
	$eslFslCondition = "AND (englishpro='ESL' OR englishpro='FSL')";
}else{
	$eslFslCondition = '';	
}	
	
	
if(!empty($getIntake)){
	$intakeCondition = " AND prg_intake!='' AND prg_intake='$getIntake'";
	$intakeCondition2 = " AND st_application.prg_intake!='' AND st_application.prg_intake='$getIntake'";
}else{
	$intakeCondition = '';
	$intakeCondition2 = '';
}

if($getStatus == 'Application_Created'){

	$registerDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$register_str = "SELECT * FROM `st_application` where datetime!='' $registerDate $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $register_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" .'Created On'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1' ."\n";
}

if($getStatus == 'Application_Completed'){
	
	$registerCompeleteDate = "AND (date_format(datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$registerNotCompelete_str = "SELECT * FROM `st_application` where datetime!='' AND (personal_status!='' AND academic_status!='' AND course_status!='' AND application_form!='') $registerCompeleteDate $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $registerNotCompelete_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program'."\t".'Application Completed'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1' ."\n";
}

if($getStatus == 'Application_Approved'){
	$AS_Date = "AND (date_format(application_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$appApproved_str = "SELECT * FROM `st_application` where admin_status_crs='Yes' $AS_Date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $appApproved_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" .'Application Approved'. "\t" .'Remarks'. "\t" .'Approved Datetime'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1' ."\n";
}

if($getStatus == 'COL'){
	$OL = "AND (date_format(offer_letter_sent_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$PAL_str = "SELECT * FROM `st_application` where offer_letter!='' AND offer_letter_sent_datetime!='' $OL $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $PAL_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" .'COL'. "\t" .'OLD/New'. "\t" .'COL Date'. "\t" .'COL Type'. "\t" .'Revised Date'. "\t" .'Defer Date'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1' ."\n";
}

if($getStatus == 'TTWithOut'){
	$TT_date= "AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$caq_str = "SELECT * FROM `st_application` where file_receipt!='' AND agent_request_loa_datetime!='' $TT_date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $caq_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" .'With-Out TT'. "\t" .'With-Out TT Date'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1' ."\n";
}

if($getStatus == 'TTWith'){
	$TT_date= "AND (date_format(agent_request_loa_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$rqstLOA_str = "SELECT * FROM `st_application` where file_receipt!='' AND loa_tt!='' AND agent_request_loa_datetime!='' $TT_date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $rqstLOA_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" .'With TT'. "\t" .'With TT Date'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1' ."\n";
}

if($getStatus == 'LOAFirstTime'){
	$LOA_date = "AND (date_format(loa_first_generate_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Defer_str = "SELECT * FROM `st_application` WHERE loa_file!='' AND loa_first_generate_date!='' $LOA_date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $LOA_Defer_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" . 'LOA Type'. "\t" . 'LOA First Date'. "\t" . 'LOA Select Date'. "\t" . 'LOA Revised Date'. "\t" . 'LOA Defer Date'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1' ."\n";
}

if($getStatus == 'LOA_Defer'){
	$LOA_Defer_Date = "AND loa_type='Defer' AND (date_format(loa_defer_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Defer_str = "SELECT * FROM `st_application` WHERE loa_file!='' AND loa_first_generate_date!='' $LOA_Defer_Date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $LOA_Defer_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program'. "\t" . 'LOA Type'. "\t" . 'LOA First Date'. "\t" . 'LOA Select Date'. "\t" . 'LOA Revised Date'. "\t" . 'LOA Defer Date'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1'."\n";
}

if($getStatus == 'LOA_Revised'){
	$LOA_Revised_Date = "AND loa_type='Revised' AND (date_format(loa_revised_date,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$LOA_Revised_str = "SELECT * FROM `st_application` WHERE loa_file!='' AND loa_first_generate_date!='' $LOA_Revised_Date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $LOA_Revised_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program'. "\t" . 'LOA Type'. "\t" . 'LOA First Date'. "\t" . 'LOA Select Date'. "\t" . 'LOA Revised Date'. "\t" . 'LOA Defer Date'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1'."\n";
}

if($getStatus == 'FH'){
	$FH_date = "AND (date_format(fh_status_updated_by,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$rqstFH_str = "SELECT * FROM `st_application` where (fh_status!='' AND fh_status='1') $FH_date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $rqstFH_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" . 'FH'. "\t" . 'FH Updated On'. "\t" . 'Status'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1' ."\n";
}

if($getStatus == 'VR'){
	$VGR_AIP_date = "AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$rqstVR_str = "SELECT * FROM `st_application` where (v_g_r_status!='' AND v_g_r_status='V-R') $VGR_AIP_date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $rqstVR_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" .'VR Status'. "\t" . 'Status Updated On' . "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1'."\n";
}

if($getStatus == 'VG'){
	$VGR_AIP_date = "AND (date_format(v_g_r_status_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$rqstVG_str = "SELECT * FROM `st_application` where (v_g_r_status!='' AND v_g_r_status='V-G') $VGR_AIP_date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $rqstVG_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" .'VG Status'. "\t" . 'Status Updated On' . "\t" . 'V-G Copy'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1'."\n";
}

if($getStatus == 'VGVR_Refund'){
	$VGRRefund_date = "AND (date_format(file_upload_vr_datetime,'%Y-%m-%d') BETWEEN '$Fisrt_Previous' AND '$Last_Previous')";
	
	$rqstVGRRefund_str = "SELECT * FROM `st_application` where  file_upload_vr_datetime!='' $VGRRefund_date $intakeCondition $eslFslCondition";
	$rslt = mysqli_query($con, $rqstVGRRefund_str);
	
	echo 'Campus' ."\t".'Agent Name' ."\t".'Sales Manager Name'.  "\t" . 'Student Name'. "\t" .'RefId' . "\t" .'Student Id' .  "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program'. "\t" .'REFUND - TT from Agent'. "\t" .'REFUND - Refund Form'. "\t" .'REFUND - Refusal Letter'. "\t" .'Refund Docs Admin'. "\t" .'Remarks'. "\t" .'Updated On'. "\t" .'Test Name' . "\t" .'Ielts Overall' . "\t" .'Ielts Less Than' . "\t" .'PTE Overall' . "\t" .'PTE Less Than'. "\t" .'Country' . "\t" .'State' . "\t" .'City' . "\t" .'Address1'."\n";
}


while($row_nm = mysqli_fetch_assoc($rslt)){
	$user_id = mysqli_real_escape_string($con, $row_nm['user_id']);			
	$country = mysqli_real_escape_string($con, $row_nm['country']);
	
	$getquery22 = "SELECT username, created_by_id FROM `allusers` WHERE sno='$user_id'";		
	$RefundsWeeklyRslt22 = mysqli_query($con, $getquery22);
	$row_nm22 = mysqli_fetch_assoc($RefundsWeeklyRslt22);
	$username = mysqli_real_escape_string($con, $row_nm22['username']); 
	$created_by_id = mysqli_real_escape_string($con, $row_nm22['created_by_id']); 
	
	$getquery24 = "SELECT * FROM `admin_access` WHERE admin_id='$created_by_id'";		
	$RefundsWeeklyRslt24 = mysqli_query($con, $getquery24);
	if(mysqli_num_rows($RefundsWeeklyRslt24)){
		$row_nm24 = mysqli_fetch_assoc($RefundsWeeklyRslt24);
		$SalesMName = mysqli_real_escape_string($con, $row_nm24['name']);
	}else{
		if($country == 'Canada'){
			$SalesMName = 'Onshore Student';			
		}else{
			$getquery25 = "SELECT contact_person FROM `allusers` WHERE sno='$created_by_id'";		
			$RefundsWeeklyRslt25 = mysqli_query($con, $getquery25);
			if(mysqli_num_rows($RefundsWeeklyRslt25)){
				$row_nm25 = mysqli_fetch_assoc($RefundsWeeklyRslt25);
				$SalesMName = mysqli_real_escape_string($con, $row_nm25['contact_person']);
			}else{
				$SalesMName = '';
			}
		}
	}

	$fname = mysqli_real_escape_string($con, $row_nm['fname']);
	$lname = mysqli_real_escape_string($con, $row_nm['lname']);	 
	$fullname = $fname.' '.$lname;
	$refid = mysqli_real_escape_string($con, $row_nm['refid']);
	$student_id = mysqli_real_escape_string($con, $row_nm['student_id']);
	$dob = mysqli_real_escape_string($con, $row_nm['dob']);
	$passport_no = mysqli_real_escape_string($con, $row_nm['passport_no']);
	$date_at = mysqli_real_escape_string($con, $row_nm['datetime']);	
	
	$englishpro = mysqli_real_escape_string($con, $row_nm['englishpro']);
	$ieltsover = mysqli_real_escape_string($con, $row_nm['ieltsover']);
	$ieltsnot = mysqli_real_escape_string($con, $row_nm['ieltsnot']);
	$pteover = mysqli_real_escape_string($con, $row_nm['pteover']);
	$ptenot = mysqli_real_escape_string($con, $row_nm['ptenot']);
	
	$personal_status = mysqli_real_escape_string($con, $row_nm['personal_status']);
	$academic_status = mysqli_real_escape_string($con, $row_nm['academic_status']);
	$course_status = mysqli_real_escape_string($con, $row_nm['course_status']);
	$application_form = mysqli_real_escape_string($con, $row_nm['application_form']);
	if($personal_status == '1' && $academic_status == '1' && $course_status == '1' && $application_form == '1'){
		$appCompleted = 'Comepleted';
	}else{
		$appCompleted = 'Not-Comepleted';
	}
	$prg_intake = mysqli_real_escape_string($con, $row_nm['prg_intake']);
	$prg_name1 = mysqli_real_escape_string($con, $row_nm['prg_name1']);
	$admin_status_crs = mysqli_real_escape_string($con, $row_nm['admin_status_crs']);
	$admin_remark_crs = mysqli_real_escape_string($con, $row_nm['admin_remark_crs']);
	$application_status_datetime = mysqli_real_escape_string($con, $row_nm['application_status_datetime']);
	
	$sign_student_declaration_agreement_date = '';
	
	// $sign_student_declaration_agreement2 = mysqli_real_escape_string($con, $row_nm['sign_student_declaration_agreement']);
	// if(!empty($sign_student_declaration_agreement2)){
		// $sign_student_declaration_agreement = 'Uploaded';
	// }else{
		// $sign_student_declaration_agreement = 'Pending';
		$sign_student_declaration_agreement = '';
	// }
	
	$sign_inter_stu_appli_date = ''; //mysqli_real_escape_string($con, $row_nm['sign_inter_stu_appli_date']);
	
	// $sign_inter_stu_appli2 = mysqli_real_escape_string($con, $row_nm['sign_inter_stu_appli']);
	// if(!empty($sign_inter_stu_appli2)){
		// $sign_inter_stu_appli = 'Uploaded';
	// }else{
		$sign_inter_stu_appli = '';
		// $sign_inter_stu_appli = 'Pending';
	// }
	
	$offer_letter2 = mysqli_real_escape_string($con, $row_nm['offer_letter']);
	if(!empty($offer_letter2)){
		$offer_letter = 'Generated';
	}else{
		$offer_letter = 'Not-Generated';
	}
	
	$ol_new_old = '';
	$offer_letter_sent_datetime = mysqli_real_escape_string($con, $row_nm['offer_letter_sent_datetime']);
	$ol_type = mysqli_real_escape_string($con, $row_nm['ol_type']);
	$ol_revised_date = mysqli_real_escape_string($con, $row_nm['ol_revised_date']);
	$ol_defer_date = mysqli_real_escape_string($con, $row_nm['ol_defer_date']);
	
	$agent_request_loa_datetime = mysqli_real_escape_string($con, $row_nm['agent_request_loa_datetime']);
	
	$file_receipt2 = mysqli_real_escape_string($con, $row_nm['file_receipt']);
	if(!empty($file_receipt2)){
		$file_receipt = 'WOT';
	}else{
		$file_receipt = '';
	}

	$loa_tt2 = mysqli_real_escape_string($con, $row_nm['loa_tt']);
	if(!empty($loa_tt2)){
		$loa_tt = 'Uploaded';
	}else{
		$loa_tt = 'Not-Uploaded';
	}
	
	$loa_type2 = mysqli_real_escape_string($con, $row_nm['loa_type']);
	if(!empty($loa_type2)){
		$loa_type = $loa_type2;
	}else{
		$loa_type = 'FirstTime';
	}
	$loa_first_generate_date = mysqli_real_escape_string($con, $row_nm['loa_first_generate_date']);
	$loa_file_date_updated_by = mysqli_real_escape_string($con, $row_nm['loa_file_date_updated_by']);
	$loa_revised_date = mysqli_real_escape_string($con, $row_nm['loa_revised_date']);
	$loa_defer_date = mysqli_real_escape_string($con, $row_nm['loa_defer_date']);
	
	$loa_amount = mysqli_real_escape_string($con, $row_nm['genrate_amount_loa']);
	
	$fh_status = mysqli_real_escape_string($con, $row_nm['fh_status']);
	$fh_status_updated_by = mysqli_real_escape_string($con, $row_nm['fh_status_updated_by']);
	$fh_re_lodgement = mysqli_real_escape_string($con, $row_nm['fh_re_lodgement']);
	if($fh_status == '1'){
		$FH2 = 'F@H';
	}else{
		$FH2 = '.';
	}
	
	$v_g_r_status = mysqli_real_escape_string($con, $row_nm['v_g_r_status']);
	if($v_g_r_status == 'V-R'){
		$VR = 'VR';
	}else{
		$VR = '.';
	}
	
	if($v_g_r_status == 'V-G'){
		$VG = 'VG';
	}else{
		$VG = '.';
	}
	
	// $vg_copy_file2 = mysqli_real_escape_string($con, $row_nm['vg_copy_file']);
	// if($v_g_r_status == 'V-G' && !empty($vg_copy_file2)){
		// $vg_copy_file = 'Uploaded';
	// }else{
		// $vg_copy_file = 'Not-Uploaded';
		$vg_copy_file = '';
	// }	
	
	$v_g_r_status_datetime = mysqli_real_escape_string($con, $row_nm['v_g_r_status_datetime']);
	

	$file_upload_vgr11 = mysqli_real_escape_string($con, $row_nm['file_upload_vgr']);
	if(!empty($file_upload_vgr11)){
		$file_upload_vgr = 'Uploaded';
	}else{
		$file_upload_vgr = 'Not-Uploaded';
	}
	
	$file_upload_vgr22 = mysqli_real_escape_string($con, $row_nm['file_upload_vgr2']);
	if(!empty($file_upload_vgr22)){
		$file_upload_vgr2 = 'Uploaded';
	}else{
		$file_upload_vgr2 = 'Not-Uploaded';
	}
	
	$file_upload_vgr33 = mysqli_real_escape_string($con, $row_nm['file_upload_vgr3']);
	if(!empty($file_upload_vgr33)){
		$file_upload_vgr3 = 'Uploaded';
	}else{
		$file_upload_vgr3 = 'Not-Uploaded';
	}
	
	$file_upload_vgr_status = mysqli_real_escape_string($con, $row_nm['file_upload_vgr_status']);
	$file_upload_vgr_remarks = mysqli_real_escape_string($con, $row_nm['file_upload_vgr_remarks']);
	$file_upload_vr_datetime = mysqli_real_escape_string($con, $row_nm['file_upload_vr_datetime']);
	
	$country = preg_replace('/\s+/', ' ',$row_nm['country']);
	$state = preg_replace('/\s+/', ' ',$row_nm['state']);
	$city = preg_replace('/\s+/', ' ',$row_nm['city']);
	$address1 = preg_replace('/\s+/', ' ',$row_nm['address1']);
	$campus = preg_replace('/\s+/', ' ',$row_nm['campus']);
	
if($getStatus == 'Application_Created'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob  . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $date_at . "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}

if($getStatus == 'SDA'){	
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob  . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $sign_student_declaration_agreement. "\t" . $sign_student_declaration_agreement_date . "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}

if($getStatus == 'ISA'){	
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob  . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $sign_inter_stu_appli. "\t" . $sign_inter_stu_appli_date . "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'Application_Completed'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $appCompleted. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'Application_Approved'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $admin_status_crs. "\t" . $admin_remark_crs. "\t" . $application_status_datetime. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'COL'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $offer_letter. "\t" . $ol_new_old. "\t" . $offer_letter_sent_datetime. "\t" . $ol_type. "\t" . $ol_revised_date. "\t" . $ol_defer_date. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}	
	
if($getStatus == 'TTWithOut'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $file_receipt. "\t" . $agent_request_loa_datetime. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";	
}	
	
if($getStatus == 'TTWith'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $loa_tt. "\t" . $agent_request_loa_datetime. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'LOAFirstTime'){
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $loa_type. "\t" . $loa_first_generate_date. "\t" . $loa_file_date_updated_by. "\t" . $loa_revised_date. "\t" . $loa_defer_date. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'LOA_Defer'){
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $loa_type. "\t" . $loa_first_generate_date. "\t" . $loa_file_date_updated_by. "\t" . $loa_revised_date. "\t" . $loa_defer_date. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'LOA_Revised'){
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $loa_type. "\t" . $loa_first_generate_date. "\t" . $loa_file_date_updated_by. "\t" . $loa_revised_date. "\t" . $loa_defer_date. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'FH'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $FH2. "\t" . $fh_status_updated_by. "\t" . $fh_re_lodgement. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\t" . $ptenot. "\n";
}

if($getStatus == 'VR'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $VR. "\t" . $v_g_r_status_datetime. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'VG'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $VG. "\t" . $v_g_r_status_datetime. "\t" . $vg_copy_file. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}
	
if($getStatus == 'VGVR_Refund'){	 
	echo $campus .  "\t" .$username .  "\t" . $SalesMName.  "\t" . $fullname.  "\t" . $refid . "\t" . $student_id. "\t" . $dob . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $file_upload_vgr. "\t" . $file_upload_vgr2. "\t" . $file_upload_vgr3. "\t" . $file_upload_vgr_status. "\t" . $file_upload_vgr_remarks. "\t" . $file_upload_vr_datetime. "\t" . $englishpro. "\t" . $ieltsover. "\t" . $ieltsnot. "\t" . $pteover. "\t" . $ptenot. "\t" . $country. "\t" . $state. "\t" . $city. "\t" . $address1. "\n";
}

}

header("Content-disposition: attachment; filename=All_Times_Report.xls");

}else{
	header("Location: ../../login");
    exit();
}
?>