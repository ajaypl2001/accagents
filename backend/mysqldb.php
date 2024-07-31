<?php
session_start();
include("../db.php");
date_default_timezone_set("Asia/Kolkata");

if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
	$loggedid = $_SESSION['sno'];
	$rsltLogged = mysqli_query($con,"SELECT sno,role,email FROM allusers WHERE sno = '$loggedid'");
	$rowLogged = mysqli_fetch_assoc($rsltLogged);
	$Loggedrole = mysqli_real_escape_string($con, $rowLogged['role']);
	$Loggedemail = mysqli_real_escape_string($con, $rowLogged['email']);
}else{
   header("Location: ../login");
   exit();
}
$follow_datetime = date('Y-m-d H:i:s');


if(isset($_POST['appbtncrs'])){
// print_r($_POST);	
// die;

	$campus = $_POST['campus'];	
	$userid = $_POST['snoid'];
	$getApplication = "SELECT sno, campus, user_id,refid,fname,lname,follow_stage FROM `st_application` where `sno`='$userid'";
	$qry = mysqli_query($con, $getApplication);
	$uid = mysqli_fetch_assoc($qry);
	$get_campus = $uid['campus'];	
	if($campus == $get_campus){
		$student_id_update = '';
		$loa_receipt_id = '';
	}else{
		if(empty($get_campus)){
			$student_id_update = '';
			$loa_receipt_id = '';
		}else{
			$student_id_update = "`student_id`='',";
			$loa_receipt_id = ", `loa_receipt_id`='', `loa_receipt_id_admin`=''";
		}
	}	

	$intake = $_POST['intake'];
	$prg_name1 = $_POST['prg_name1'];
	$asc = $_POST['admin_status_crs'];
	$arc = mysqli_real_escape_string($con, $_POST['admin_remark_crs']);
	$tab = $_POST['rowbg1'];
	if($tab !==''){
		$tab1 = '&tab='.$tab;
	}else{
		$tab1 = '';
	}

	$pdfMsg = base64_encode('Donotpdf1');	
	if($asc == 'No'){
		$update_stu_status = "update `st_application` set $student_id_update `campus`='$campus', `prg_intake`='$intake', `prg_type1`='$prg_name1', `admin_status_crs`='$asc', `admin_remark_crs`='$arc', `application_status_datetime`='$follow_datetime' $loa_receipt_id where `sno`='$userid'";
	}
	if($asc == 'Yes'){
		$update_stu_status = "update `st_application` set $student_id_update `campus`='$campus', `prg_intake`='$intake', `prg_name1`='$prg_name1', `admin_status_crs`='$asc', `admin_remark_crs`='$arc', `application_status_datetime`='$follow_datetime', follow_status='0' $loa_receipt_id where `sno`='$userid'";	
	}
	if($asc == 'Not Eligible'){	
		$update_stu_status = "update `st_application` set $student_id_update `campus`='$campus', `prg_intake`='$intake', `prg_name1`='$prg_name1', `admin_status_crs`='$asc', `admin_remark_crs`='$arc', `application_status_datetime`='$follow_datetime' $loa_receipt_id where `sno`='$userid'";	
	}
	mysqli_query($con, $update_stu_status);
	$user_id = $uid['user_id'];	
	$sno = $uid['sno'];
	$refid = $uid['refid'];
	$follow_stage = $uid['follow_stage'];
	$fullname = $uid['fname'].' '.$uid['lname'];
	$date = date('Y-m-d H:i:s');


	$log_type = 'Application';
	$process_logs = "INSERT INTO `process_logs`(`st_id`, `campus`, `prg_intake`,`prg_name1`, `status`, `remarks`,`update_by` ,`log_type`, `created_datetime`) VALUES ('$userid','$campus','$intake','$prg_name1','$asc','$arc','$Loggedemail' ,'$log_type','$date')";
	mysqli_query($con,$process_logs);


	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Application Status Updated', 'Application Status', 'application?aid=error_$sno', '1', '$date')");	
	if($asc == 'Yes'){
//Followup

	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$userid' AND fstage='$follow_stage' order by sno asc";
	$flowRsltQury = mysqli_query($con, $flowQury);
	$flowList = mysqli_fetch_assoc($flowRsltQury);
	$fsno = $flowList['sno'];
	$fstage = $flowList['fstage'];
	if(!empty($fstage)){
		mysqli_query($con, "update `followup` set `updated`='$date' where `sno`='$fsno'");
	}
	mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$userid'");
	}
	header("Location: ../backend/application?did=$user_id&aid=error_$userid$tab1");

}


if(isset($_POST['paymentproved'])){

	$admin_payment_status = $_POST['admin_payment_status'];

	$admin_payment_remarks = $_POST['admin_payment_remarks'];

	$snoid = $_POST['snoid'];

	if($admin_payment_status == 'Yes'){

		$aps = 'Done';

	}

	if($admin_payment_status == 'No'){

		$aps = 'Pending';

	}

	mysqli_query($con, "update `payments` set `status`='$aps' where `sid`='$snoid' AND fee_type='Application Fee'");

	mysqli_query($con, "update `st_application` set `admin_payment_status`='$admin_payment_status', `admin_payment_remarks`='$admin_payment_remarks'  where `sno`='$snoid'");

	header("Location: ../backend/application");

}



if(isset($_POST['tfproved'])){

	$admin_tf_status = $_POST['admin_tf_status'];

	$admin_tf_remarks = $_POST['admin_tf_remarks'];

	$snoid = $_POST['snoid'];

	if($admin_tf_status == 'Yes'){

		$aps = 'Done';

	}

	if($admin_tf_status == 'No'){

		$aps = 'Pending';

	}

	mysqli_query($con, "update `payments` set `status`='$aps' where `sid`='$snoid' AND fee_type='tuition Fee'");

	mysqli_query($con, "update `st_application` set `admin_tf_status`='$admin_tf_status', `admin_tf_remarks`='$admin_tf_remarks'  where `sno`='$snoid'");

	header("Location: ../backend/application");

}



if(isset($_POST['olbtn'])){

	$snoid = $_POST['olid'];

	$name3 = $_FILES['offer_letter']['name'];

	$tmp3 = $_FILES['offer_letter']['tmp_name'];

	$explode_array = explode('.',$name3);

	if(isset($explode_array[1])){

		$array_doc = $explode_array[1];

	}

	if(($array_doc == "pdf")  || ($array_doc == "jpg")){	

	$delete_foldr=mysqli_query($con, "SELECT offer_letter FROM st_application where sno='$snoid'");

	$dltlist = mysqli_fetch_assoc($delete_foldr);

	$docimage1 = $dltlist['offer_letter'];		

	unlink("../uploads/$docimage1");

	$img_name3 = date('YmdHis').'_'.$name3;

	move_uploaded_file($tmp3, '../uploads/'.$img_name3);

	mysqli_query($con, "update `st_application` set `offer_letter`='$img_name3' where `sno`='$snoid'");

	header("Location: ../backend/application");

	}else{

		$imgMsg = base64_encode('ImageUpload');

		header("Location: ../backend/application?imgMsg=$imgMsg");

	}	

}





if(isset($_POST['tfbtn'])){
	$snoid = $_POST['tffileid'];
	$name3 = $_FILES['tuition_fee']['name'];
	$tmp3 = $_FILES['tuition_fee']['tmp_name'];
	$explode_array = explode('.',$name3);
	if(isset($explode_array[1])){
		$array_doc = $explode_array[1];
	}
	if(($array_doc == "pdf")  || ($array_doc == "jpg")){
	$delete_foldr=mysqli_query($con, "SELECT tuition_fee FROM st_application where sno='$snoid'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	$docimage1 = $dltlist['tuition_fee'];
	if(!empty($docimage1)){
		unlink("../uploads/$docimage1");
	}
	$img_name3 = date('YmdHis').'_'.$name3;
	move_uploaded_file($tmp3, '../uploads/'.$img_name3);
	mysqli_query($con, "update `st_application` set `tuition_fee`='$img_name3' where `sno`='$snoid'");
	header("Location: ../backend/application");
	}else{
		$imgMsg = base64_encode('ImageUpload');
		header("Location: ../backend/application?imgMsg=$imgMsg");
	}	
}

if(isset($_POST['admPayLOAbtn'])){
	$stuid = $_POST['stuid'];
	$admstatus = $_POST['admstatus'];
	$admRemarks = $_POST['admRemarks'];
	$df = explode(",", $stuid);
	for($i=0; $i<count($df); $i++) {
		mysqli_query($con, "update `payments` set `admin_status`='$admstatus', `admin_remarks`='$admRemarks' where `sid`='$df[$i]'");
	}
	$loaMsg = base64_encode('LOAPayStatus');
	header("Location: ../backend/application?ploaMsg=$loaMsg");
}


if(isset($_POST['personalbtn'])){
	// echo '<pre>';
	// print_r($_POST);
	// echo '</pre>';
	// die;
	
	$userid = $_POST['snid'];
	
	$agent_id = $_POST['user_id'];	
	if(isset($_POST['app_show'])){
		$app_show = $_POST['app_show'];
	}else{
		$app_show = '';
	}
	
	if(!empty($app_show)){
		$sales_name = $app_show;
	}else{
		$result4 = mysqli_query($con, "SELECT admin_access.name, admin_access.admin_id FROM `allusers` INNER JOIN admin_access ON admin_access.admin_id=allusers.created_by_id where allusers.created_by_id!='' AND allusers.sno='$agent_id'");
		if(mysqli_num_rows($result4)){
			$row4 = mysqli_fetch_assoc($result4);
			$sales_name = $row4['name'];
		}else{
			$sales_name = '';
		}
	}
	
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$gtitle = mysqli_real_escape_string($con, $_POST['gtitle']);
	$fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
	$username = $fname.' '.$lname;
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
	
	$calling_code = mysqli_real_escape_string($con, $_POST['calling_code']);
    $calling_cntry_code = mysqli_real_escape_string($con, $_POST['calling_cntry_code']);
	$emg_cc = mysqli_real_escape_string($con, $_POST['emg_cc']);
    $emg_cnty_c = mysqli_real_escape_string($con, $_POST['emg_cnty_c']);
	
	$gender = $_POST['gender'];
	$on_off_shore = $_POST['on_off_shore'];
	$martial_status = mysqli_real_escape_string($con, $_POST['martial_status']);
	$dob = mysqli_real_escape_string($con, $_POST['dob']);
	$cntry_brth = mysqli_real_escape_string($con, $_POST['cntry_brth']);
	$address1 = mysqli_real_escape_string($con, $_POST['address1']);
	$address2 = mysqli_real_escape_string($con, $_POST['address2']);
	$country = mysqli_real_escape_string($con, $_POST['country']);
	$state = mysqli_real_escape_string($con, $_POST['state']);
	$city = mysqli_real_escape_string($con, $_POST['city']);
	$pincode = mysqli_real_escape_string($con, $_POST['pincode']);
	$passport_no = mysqli_real_escape_string($con, $_POST['passport_no']);
	$pp_issue_date = mysqli_real_escape_string($con, $_POST['pp_issue_date']);
	$personal_status = $_POST['personal_status'];
	$mother_father_select = mysqli_real_escape_string($con, $_POST['mother_father_select']);
	if($mother_father_select == 'Mother'){
		$mother_father_name = mysqli_real_escape_string($con, $_POST['mother_name']);
	}
	if($mother_father_select == 'Father'){		
		$mother_father_name = mysqli_real_escape_string($con, $_POST['father_name']);
	}
	$emergency_contact_no = mysqli_real_escape_string($con, $_POST['emergency_contact_no']);
	$pp_expire_date = mysqli_real_escape_string($con, $_POST['pp_expire_date']);

	/*$date2=date_create($pp_issue_date);	
	date_add($date2,date_interval_create_from_date_string("10 years"));
	$expire_date = date_format($date2,"Y-m-d");	
	$newdate = strtotime('-1 day' ,strtotime ($expire_date));
	$newdate2 = date ('Y-m-d' , $newdate);	
	$pp_expire_date = $newdate2;*/

	$update_query = mysqli_query($con, "update `st_application` set `fname`='$fname',`lname`='$lname', `on_off_shore`='$on_off_shore', `app_show`='$sales_name', `email_address`='$email', `mobile`='$mobile', `calling_code`='$calling_code', `calling_cntry_code`='$calling_cntry_code', `emg_cc`='$emg_cc', `emg_cnty_c`='$emg_cnty_c', `gtitle`='$gtitle', `gender`='$gender', `dob`='$dob', `cntry_brth`='$cntry_brth', `martial_status`='$martial_status', `mother_father_select`='$mother_father_select', `mother_father_name`='$mother_father_name', `emergency_contact_no`='$emergency_contact_no', `address1`='$address1', `address2`='$address2', `country`='$country', `state`='$state', `city`='$city', `pincode`='$pincode', `passport_no`='$passport_no', `pp_issue_date`='$pp_issue_date', `pp_expire_date`='$pp_expire_date', `personal_status`='$personal_status' where `sno`='$userid'");

	$msg = base64_encode('Academic-Details');
	$uid = base64_encode($userid);
	$random = base64_encode(rand());
	header("Location: application/edit.php?pt=$msg&apid=$uid&$random");
}


if(isset($_POST['academicbtn'])){
	$userid = $_POST['snid'];
	$qualifications1 = $_POST['qualifications1'];
	$stream1 = $_POST['stream1'];
	$cgpa_prcntge1 = $_POST['cgpa_prcntge1'];
	$marks1 = $_POST['marks1'];
	$passing_year1 = $_POST['passing_year1'];
	$unicountry1 = $_POST['unicountry1'];
	$uni_name1 = $_POST['uni_name1'];	

	// $delete_foldr=mysqli_query($con, "SELECT sno,fname,refid, certificate1, certificate2, certificate3, ielts_file, pte_file, duolingo_file FROM st_application where sno='$userid'");
	// $dltlist = mysqli_fetch_assoc($delete_foldr);
	// $docimage1 = $dltlist['certificate1'];
	// $ieltsFile = $dltlist['ielts_file'];
	// $pdfFile = $dltlist['pte_file'];
	// $duolingo_file = $dltlist['duolingo_file'];
	// $fname = $dltlist['fname'];	
	// $refid = $dltlist['refid'];	
	// $firstname = str_replace(' ', '', $fname);
	$crnt_year = date('Y');
	$gap_status = $_POST['gap_status'];
	$passing_year_gap_2 = $_POST['passing_year_gap'];
	if($passing_year_gap_2 == $crnt_year){
		$passing_year_gap = $passing_year_gap_2;
		
		$passing_justify_gap = '';
		$gap_duration_2 = '';
		$gap_other = '';
		
	}else{
		
		$passing_year_gap = $passing_year_gap_2;		
		$passing_justify_gap_2 = $_POST['passing_justify_gap'];
			
		if($passing_justify_gap_2 == 'Yes'){
			$passing_justify_gap = $passing_justify_gap_2;
			$gap_duration_2 = $_POST['gap_duration'];
			if($gap_duration_2 == 'other'){
				$gap_other = $_POST['gap_other'];
			}else{
				$gap_other = '';
			}			
		}
		if($passing_justify_gap_2 == 'No'){
			$passing_justify_gap = $passing_justify_gap_2;
			$gap_duration_2 = '';
			$gap_other = '';
		}
	}

	$qualifications2 = $_POST['qualifications2'];
	$stream2 = $_POST['stream2'];
	$cgpa_prcntge2 = $_POST['cgpa_prcntge2'];
	$marks2 = $_POST['marks2'];
	$passing_year2 = $_POST['passing_year2'];
	$unicountry2 = $_POST['unicountry2'];
	$uni_name2 = $_POST['uni_name2'];

	$qualifications3 = $_POST['qualifications3'];
	$stream3 = $_POST['stream3'];
	$cgpa_prcntge3 = $_POST['cgpa_prcntge3'];
	$marks3 = $_POST['marks3'];
	$passing_year3 = $_POST['passing_year3'];
	$unicountry3 = $_POST['unicountry3'];
	$uni_name3 = $_POST['uni_name3'];

	$englishpro = $_POST['englishpro'];
	if($englishpro == 'ielts'){
		$ieltsover = $_POST['ieltsover'];
		$ieltsnot = $_POST['ieltsnot'];
		$ielts_listening = $_POST['ielts_listening'];
		$ielts_reading = $_POST['ielts_reading'];
		$ielts_writing = $_POST['ielts_writing'];
		$ielts_speaking = $_POST['ielts_speaking'];
		$ielts_date = $_POST['ielts_date'];		
	}
	
	if($englishpro == 'Toefl'){
		$ieltsover = $_POST['Toeflover'];
		$ieltsnot = $_POST['Toeflnot'];
		$ielts_listening = $_POST['Toefl_listening'];
		$ielts_reading = $_POST['Toefl_reading'];
		$ielts_writing = $_POST['Toefl_writing'];
		$ielts_speaking = $_POST['Toefl_speaking'];
		$ielts_date = $_POST['Toefl_date'];		
	}

	if($englishpro == 'pte'){
		$pteover = $_POST['pteover'];
		$ptenot = $_POST['ptenot'];
		$pte_listening = $_POST['pte_listening'];
		$pte_reading = $_POST['pte_reading'];
		$pte_writing = $_POST['pte_writing'];
		$pte_speaking = $_POST['pte_speaking'];
		$pte_date = $_POST['pte_date'];	
		$pte_username = $_POST['pte_username'];	
		$pte_password = $_POST['pte_password'];	
	}	

	if($englishpro == 'duolingo'){
		$duolingo_score = $_POST['duolingo_score'];
		$duolingo_date = $_POST['duolingo_date'];	
	}				

	$academic_status = $_POST['academic_status'];

	$rsltqry = "SELECT englishpro, ielts_file, pte_file, duolingo_file FROM st_application WHERE sno = '$userid'";
	$result = mysqli_query($con, $rsltqry);
	$row = mysqli_fetch_assoc($result);
	$englishpro2 = mysqli_real_escape_string($con, $row['englishpro']);
	$ielts_file2 = mysqli_real_escape_string($con, $row['ielts_file']);
	$pte_file2 = mysqli_real_escape_string($con, $row['pte_file']);
	$duolingo_file2 = mysqli_real_escape_string($con, $row['duolingo_file']);

	if($englishpro2 == $englishpro){		
	}else{
		if(!empty($ielts_file2)){
			unlink("../uploads/$ielts_file2");
		}
		mysqli_query($con, "update `st_application` set `ielts_file`='' where `sno`='$userid'");
	}
	

	if($englishpro == 'ielts' || $englishpro == 'Toefl'){
		if(!empty($pte_file2)){
			unlink("../uploads/$pte_file2");
		}
		if(!empty($duolingo_file2)){
			unlink("../uploads/$duolingo_file2");
		}

	$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='$ieltsover',`ieltsnot`='$ieltsnot',`ielts_listening`='$ielts_listening',`ielts_reading`='$ielts_reading',`ielts_writing`='$ielts_writing',`ielts_speaking`='$ielts_speaking',`ielts_date`='$ielts_date', `pteover`='', `ptenot`='', `pte_listening`='', `pte_reading`='',`pte_writing`='',`pte_speaking`='',`pte_date`='',`pte_file`='', `pte_username`='', `pte_password`='', `duolingo_score`='', `duolingo_date`='', `duolingo_file`='', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");

	}

	if($englishpro == 'pte'){
		if(!empty($ielts_file2)){
			unlink("../uploads/$ielts_file2");
		}
		if(!empty($duolingo_file2)){
			unlink("../uploads/$duolingo_file2");
		}
	$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='',`ieltsnot`='',`ielts_listening`='',`ielts_reading`='',`ielts_writing`='',`ielts_speaking`='',`ielts_date`='',`ielts_file`='',`pteover`='$pteover',`ptenot`='$ptenot',`pte_listening`='$pte_listening',`pte_reading`='$pte_reading', `pte_writing`='$pte_writing', `pte_speaking`='$pte_speaking',`pte_date`='$pte_date', `pte_username`='$pte_username', `pte_password`='$pte_password', `duolingo_score`='', `duolingo_date`='', `duolingo_file`='', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");

	}	

	if($englishpro == 'duolingo'){
		if(!empty($ielts_file2)){
			unlink("../uploads/$ielts_file2");
		}
		if(!empty($pte_file2)){
			unlink("../uploads/$pte_file2");
		}

	$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='',`ieltsnot`='',`ielts_listening`='',`ielts_reading`='',`ielts_writing`='',`ielts_speaking`='',`ielts_date`='',`ielts_file`='',`pteover`='',`ptenot`='',`pte_listening`='',`pte_reading`='',`pte_writing`='',`pte_speaking`='',`pte_date`='',`pte_file`='', `pte_username`='', `pte_password`='', `duolingo_score`='$duolingo_score', `duolingo_date`='$duolingo_date', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");

	}	

	// $msg = base64_encode('Course-Details');
	$msg = base64_encode('Academic-Details-Docs');
	$uid = base64_encode($userid);
	$random = base64_encode(rand());
	header("Location: application/edit.php?pt=$msg&apid=$uid&$random");
}


if(isset($_POST['coursebtn'])){
	$userid = $_POST['snid'];
	$campus = $_POST['campus'];
	$prg_name1 = $_POST['prg_name1'];
	$prg_intake = $_POST['intake'];
	$course_status = $_POST['course_status'];
	
	$getApplication = "SELECT sno, campus FROM `st_application` where `sno`='$userid'";
	$qry = mysqli_query($con, $getApplication);
	$uid = mysqli_fetch_assoc($qry);
	$get_campus = $uid['campus'];	
	if($campus == $get_campus){
		$student_id_update = '';
		$loa_receipt_id = '';
	}else{
		if(empty($get_campus)){
			$student_id_update = '';
			$loa_receipt_id = '';
		}else{
			$student_id_update = "`student_id`='',";
			$loa_receipt_id = ", `loa_receipt_id`='', `loa_receipt_id_admin`=''";
		}
	}

	mysqli_query($con, "update `st_application` set $student_id_update `campus`='$campus', `prg_name1`='$prg_name1', `prg_intake`='$prg_intake', `course_status`='$course_status' $loa_receipt_id where `sno`='$userid'");
	$msg = base64_encode('Application-Details');
	$uid = base64_encode($userid);
	$random = base64_encode(rand());
	header("Location: application/edit.php?pt=$msg&apid=$uid&$random");
}

if(isset($_POST['SignedolBtn'])){
	$userid = $_POST['snid'];
	$signed_ol_confirm = $_POST['signed_ol_confirm'];
	$signed_ol_remarks = $_POST['signed_ol_remarks'];
	$tab = $_POST['rowbg1'];
	if($tab !==''){
		$tab1 = '&tab='.$tab;
	}else{
		$tab1 = '';
	}	

	if($signed_ol_confirm == 'Yes'){
		$follow_status_2 = ", `follow_status`='0'";
	}else{
		$follow_status_2 = '';
	}	

	mysqli_query($con, "update `st_application` set `signed_ol_confirm`='$signed_ol_confirm', `signed_ol_remarks`='$signed_ol_remarks', `offer_letter_status_datetime`='$follow_datetime' $follow_status_2 where `sno`='$userid'");	

	$msg = base64_encode('Application-Details');
	$uid = base64_encode($userid);	

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,follow_stage FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$user_id = $uid1['user_id'];	
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$follow_stage = $uid1['follow_stage'];
	$fullname = $uid1['fname'].' '.$uid1['lname'];
	$date = date('Y-m-d H:i:s');	


	$log_type = 'Signed OL';
	$process_logs = "INSERT INTO `process_logs`(`st_id`, `status`, `remarks`,`update_by` ,`log_type`, `created_datetime`) VALUES ('$userid','$signed_ol_confirm','$signed_ol_remarks','$Loggedemail' ,'$log_type','$date')";
	mysqli_query($con,$process_logs);


	if($signed_ol_confirm == 'Yes'){
	//Followup

	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$userid' AND fstage='$follow_stage' order by sno asc";
	$flowRsltQury = mysqli_query($con, $flowQury);
	$flowList = mysqli_fetch_assoc($flowRsltQury);
	$fsno = $flowList['sno'];
	$fstage = $flowList['fstage'];
	if(!empty($fstage)){
		mysqli_query($con, "update `followup` set `updated`='$date' where `sno`='$fsno'");
	}
	mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$userid'");
	}

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Signed Conditional Offer Letter Status Updated', 'Signed Conditional Offer Letter Status', 'application?aid=error_$userid', '1', '$date')");	

	header("Location: application?pt=$msg&did=$user_id&aid=error_$userid&apid=$uid$tab1");
}

if(isset($_POST['SignedalBtn'])){

	$userid = $_POST['snid'];

	$signed_al_status = $_POST['signed_al_status'];

	$signed_al_remarks = $_POST['signed_al_remarks'];

	$tab = $_POST['rowbg1'];

	if($tab !==''){

		$tab1 = '&tab='.$tab;

	}else{

		$tab1 = '';

	}

	

	if($signed_al_status == 'Yes'){

		$follow_status_1 = ", follow_status='0'";

	}else{

		$follow_status_1 = '';

	}

	

	mysqli_query($con, "update `st_application` set `signed_al_status`='$signed_al_status', `signed_al_remarks`='$signed_al_remarks', `aol_contract_status_datetime`='$follow_datetime' $follow_status_1 where `sno`='$userid'");

	$msg = base64_encode('Application-Details');

	$uid = base64_encode($userid);

	

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,follow_stage FROM `st_application` where `sno`='$userid'");

	$uid1 = mysqli_fetch_assoc($qry);

	$user_id = $uid1['user_id'];	

	$sno = $uid1['sno'];

	$refid = $uid1['refid'];

	$follow_stage = $uid1['follow_stage'];

	$fullname = $uid1['fname'].' '.$uid1['lname'];

	$date = date('Y-m-d H:i:s');

	

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Signed Contract Status Updated', 'Signed Contract Status', 'application?aid=error_$userid', '1', '$date')");

	

//Followup

	// mysqli_query($con, "update `followup` set `fstatus`='0', `updated`='$date' where `st_app_id`='$userid'");	

	

	

	if($signed_al_status == 'Yes'){

//Followup

	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$userid' AND fstage='$follow_stage' order by sno asc";

	$flowRsltQury = mysqli_query($con, $flowQury);

	$flowList = mysqli_fetch_assoc($flowRsltQury);

	$fsno = $flowList['sno'];

	$fstage = $flowList['fstage'];

	if(!empty($fstage)){

		mysqli_query($con, "update `followup` set `updated`='$date' where `sno`='$fsno'");

	}

	mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$userid'");

	}

	

	

	header("Location: application?pt=$msg&did=$user_id&aid=error_$userid&apid=$uid$tab1");

}



if(isset($_POST['loarsBtn'])){

	$userid = $_POST['snid'];

	$loa_confirm = $_POST['loa_confirm'];

	$loa_confirm_remarks = $_POST['loa_confirm_remarks'];	

	mysqli_query($con, "update `st_application` set `loa_confirm`='$loa_confirm', `loa_confirm_remarks`='$loa_confirm_remarks' where `sno`='$userid'");	   

	$msg = base64_encode('Application-Details');

	$uid = base64_encode($userid);

	$random = base64_encode(rand());

	header("Location: application?pt=$msg&aid=error_$userid&apid=$uid&$random");

}



if(isset($_POST['loaFeeBtn'])){

	$userid = $_POST['snid'];

	$prepaid_fee = $_POST['prepaid_fee'];

	if($prepaid_fee == 'Yes'){

		$prepaid_remarks = $_POST['prepaid_remarks'];

	}

	if($prepaid_fee == 'No'){

		$prepaid_remarks = '';

	}

	

	$fee_status_updated_by = $Loggedemail;

	$fee_date_updated_by = date('Y-m-d H:i:s');


	$log_type = 'LOA Fee';
	$process_logs = "INSERT INTO `process_logs`(`st_id`, `status`, `remarks`,`update_by` ,`log_type`, `created_datetime`) VALUES ('$userid','$prepaid_fee','$prepaid_remarks','$fee_status_updated_by' ,'$log_type','$fee_date_updated_by')";
	mysqli_query($con,$process_logs);

	mysqli_query($con, "update `st_application` set `prepaid_fee`='$prepaid_fee', `prepaid_remarks`='$prepaid_remarks', `fee_status_updated_by`='$fee_status_updated_by',`fee_date_updated_by`='$fee_date_updated_by', `follow_status`='0' where `sno`='$userid'");

	$msg = base64_encode('Application-Details');

	$uid = base64_encode($userid);

	

//Followup

	mysqli_query($con, "update `followup` set `fstatus`='0', `updated`='$fee_date_updated_by' where `st_app_id`='$userid'");

	

	header("Location: application?pt=$msg&aid=error_$userid&apid=$uid");

}

if(isset($_POST['reportbtn'])){
	$campus = $_POST['campus'];
	$status = $_POST['status'];
	$created = $_POST['created'];
	$created1 = $_POST['created1'];
	header("Location: daily_reports?campus=$campus&status=$status&crt=$created&crt1=$created1");
}

if(isset($_POST['vgrBtn'])){
	$userid = $_POST['snid'];
	$v_g_r_status = $_POST['v_g_r_status'];
	$tab = $_POST['rowbg1'];
	if($tab !==''){
		$tab1 = '&tab='.$tab;
	}else{
		$tab1 = '';
	}

	if (isset($_POST['vg_date'])) {
		$vg_date = $_POST['vg_date'];
	} else {
		$vg_date = '';
	}

	$qry = mysqli_query($con, "SELECT sno, user_id, refid, fname, lname, follow_stage, vg_file, v_g_r_status_datetime, v_g_r_crnt_amnt FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$user_id = $uid1['user_id'];
	$follow_stage = $uid1['follow_stage'];
	$docimage1 = $uid1['vg_file'];
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$fname2 = $uid1['fname'];
	$fullname = $fname2.' '.$uid1['lname'];
	$uid = base64_encode($userid);
	$v_g_r_status_datetime2 = $uid1['v_g_r_status_datetime'];
	$v_g_r_crnt_amnt2 = $uid1['v_g_r_crnt_amnt'];
	if(empty($v_g_r_status_datetime2)){
		
		$url_CtoI = "https://api.getgeoapi.com/v2/currency/convert?api_key=52ebbf96ebf4be21eb7902f66e855727d961943a&format=json&&from=CAD&to=INR";
		$curl_CtoI = curl_init($url_CtoI);
		curl_setopt($curl_CtoI, CURLOPT_RETURNTRANSFER, true);
		$response_CtoI = curl_exec($curl_CtoI);
		curl_close($curl_CtoI);
		$json_CtoI = json_decode($response_CtoI, true);
		$getCrntAmountInRupes = $json_CtoI['rates']['INR']['rate'];
		
		$getCrntAmountInRupes2 = ", v_g_r_crnt_amnt='$getCrntAmountInRupes'";
		$v_g_r_status_datetime21 = ", v_g_r_status_datetime='$follow_datetime'";
	}else{		
		$getCrntAmountInRupes2 = '';
		$v_g_r_status_datetime21 = ", v_g_r_status_datetime='$v_g_r_status_datetime2'";
	}	

	if (isset($_FILES['vg_file']) && $_FILES['vg_file']['name'] !='') {
		$vg_file = $_FILES['vg_file']['name'];
		$vg_tmp = $_FILES['vg_file']['tmp_name'];
		$file_type = $_FILES['vg_file']['type'];
		$vg_file_size = $_FILES['vg_file']['size'];

		$file_ext = strtolower(end(explode('.', $_FILES['vg_file']['name'])));
		$expensions = array("pdf", "jpg", "PDF", "JPG", "jpeg", "JPEG");

		if (in_array($file_ext, $expensions)) {
			if ($vg_file_size <= '3145728') {
				$date = date('Y-m-d H:i:s');
				if (!empty($docimage1)) {
					unlink("../uploads/vg_files/$docimage1");
				}
				$img_vg_file = 'VG' . $userid . '-' . $refid . '.' . $file_ext;
				move_uploaded_file($vg_tmp, '../uploads/vg_files/' . $img_vg_file);
			} else {
				$imgMsg = base64_encode('ImageSizevg_fileUpload');
				echo "<script>alert('File too large. File must be less than 3 MB.'); window.location='application?aid=error_$userid&mb=3&msgagree=$imgMsg'</script>";
				exit;
			}
		} else {
			$imgMsg = base64_encode('ImageExtensionvg_fileUpload');
			echo "<script>alert('Extension Not allowed'); window.location='application?msgagree=$imgMsg'</script>";
			exit;
		}
	} else {
		$img_vg_file = '';
	}

	if ($v_g_r_status != 'V-G') {
		$img_vg_file = '';
		$vg_date = '';
		if (!empty($docimage1)) {
			unlink("../uploads/vg_files/$docimage1");
		}
	}

	$vg_sts_logs = "INSERT INTO `vg_vr_sts_logs`(`user_id`,`st_id`, `vg_date`, `v_g_r_status`, `created_datetime`) VALUES ('$loggedid','$userid','$vg_date','$v_g_r_status','$follow_datetime')";
	mysqli_query($con, $vg_sts_logs);

	mysqli_query($con, "update `st_application` set `v_g_r_status`='$v_g_r_status', `vg_date`='$vg_date', `vg_file`='$img_vg_file', `v_g_r_status_updated_by_name`='$Loggedemail', follow_status='0' $v_g_r_status_datetime21 $getCrntAmountInRupes2 where `sno`='$userid'");		
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Status changed to $v_g_r_status', '$v_g_r_status', 'application?aid=error_$userid', '1', '$follow_datetime')");

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Status changed to $v_g_r_status', '$v_g_r_status', 'application?aid=error_$userid', '1', '$follow_datetime', 'Yes')");	

//Followup
	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$userid' AND fstage='$follow_stage' order by sno asc";
	$flowRsltQury = mysqli_query($con, $flowQury);
	$flowList = mysqli_fetch_assoc($flowRsltQury);
	$fsno = $flowList['sno'];
	$fstage = $flowList['fstage'];
	if(!empty($fstage)){
		mysqli_query($con, "update `followup` set `updated`='$follow_datetime' where `sno`='$fsno'");
	}
	mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$userid'");	

	$msg = base64_encode('Application-Details');
	header("Location: application?pt=$msg&did=$user_id&aid=error_$userid&apid=$uid$tab1");
}

if(isset($_POST['comRefundBtn'])){
	$userid = $_POST['snid'];
	$comrefund_remarks = $_POST['comrefund_remarks'];
	$v_g_r_amount = $_POST['v_g_r_amount'];
	$tab = $_POST['rowbg1'];
	if($tab !==''){
		$tab1 = '&tab='.$tab;
	}else{
		$tab1 = '';
	}

	$name3 = $_FILES['v_g_r_invoice']['name'];
	$tmp3 = $_FILES['v_g_r_invoice']['tmp_name'];	

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,v_g_r_status,v_g_r_invoice FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$user_id = $uid1['user_id'];
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$v_g_r_invoice1 = $uid1['v_g_r_invoice'];
	$v_g_r_status = $uid1['v_g_r_status'];
	$fname2 = $uid1['fname'];
	$fullname = $fname2.' '.$uid1['lname'];
	$fnames = str_replace(' ', '_', $fname2);
	$uid = base64_encode($userid);

	if($name3 == ''){
		$img_name3 = $v_g_r_invoice1;	
	}else{
		$extension = pathinfo($name3, PATHINFO_EXTENSION);
		if($extension=='pdf' || $extension=='PDF' || $extension=='JPG' || $extension=='jpg' || $extension=='jpeg' || $extension=='JPEG'){
			if($v_g_r_invoice1 !==''){
				unlink("../uploads/$v_g_r_invoice1");
			}
			$img_name3 = $fnames.'_'.$v_g_r_status.'_Invoice_'.$refid.'_'.date('mdis').'.'.$extension;			
			move_uploaded_file($tmp3, '../uploads/'.$img_name3);
		}else{
			$imgMsg = base64_encode('ImageUpload');
			echo "<script>alert('File is not Supported (Please upload the PDF and JPG Files)'); window.location='application?imgMsg=$imgMsg&did=$user_id&aid=error_$userid&apid=$uid$tab1'</script>";
			exit;
		}
	}
	mysqli_query($con, "update `st_application` set `comrefund_remarks`='$comrefund_remarks', `v_g_r_amount`='$v_g_r_amount', `v_g_r_invoice`='$img_name3', `com_refund_datetime`='$follow_datetime', `commission_updated_by_name`='$Loggedemail' where `sno`='$userid'");		

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Commission Details Updated', 'COMMISSION Details', 'application?aid=error_$userid', '1', '$follow_datetime', 'Yes')");
	
	$msg = base64_encode('Application-Details');
	header("Location: application?pt=$msg&did=$user_id&aid=error_$userid&apid=$uid$tab1");
}

if(isset($_POST['vgrInvoiceBtn'])){
// print_r($_POST);
// print_r($_FILES);
// die;
	$userid = $_POST['snid'];
	$inovice_status = $_POST['inovice_status'];
	$inovice_remarks = $_POST['inovice_remarks'];
	if($inovice_status == 'Yes'){
		$status_notification = 'Proccessed';
	}
	if($inovice_status == 'No'){
		$status_notification = 'Not Approved';
	}	

	$name3 = $_FILES['inovice_reciept']['name'];
	$tmp3 = $_FILES['inovice_reciept']['tmp_name'];	

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,inovice_reciept FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	//$user_id = $uid1['user_id'];	
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$inovice_reciept = $uid1['inovice_reciept'];
	$fname2 = $uid1['fname'];
	$fullname = $fname2.' '.$uid1['lname'];
	$fnames = str_replace(' ', '_', $fname2);

	if($name3 == ''){
		$img_name3 = $inovice_reciept;
	}else{
		$extension = pathinfo($name3, PATHINFO_EXTENSION);

		if($extension=='pdf' || $extension=='PDF' || $extension=='JPG' || $extension=='jpg' || $extension=='jpeg' || $extension=='JPEG'){
			if($inovice_reciept !==''){
				unlink("../uploads/$inovice_reciept");
			}
			$img_name3 = 'Invoice_Reciept_'.$fnames.'_'.$refid.'_'.date('mdis').'.'.$extension;
			move_uploaded_file($tmp3, '../uploads/'.$img_name3);
		}else{
			$imgMsg = base64_encode('ImageUpload');
			echo "<script>alert('File is not Supported (Please upload the PDF and JPG Files)'); window.location='report/vgrapplication.php?aid=error_$userid&$imgMsg'</script>";
			exit;
		}
	}

	mysqli_query($con, "update `st_application` set `inovice_status`='$inovice_status', `inovice_remarks`='$inovice_remarks', `inovice_reciept`='$img_name3', `inovice_datetime`='$follow_datetime' where `sno`='$userid'");	

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('Agent', 'admin', '$sno', '$fullname', '$loggedid', '$refid', 'Commission $status_notification by Processor', 'Commission Details Uploaded by Processor', 'application?aid=error_$userid', '1', '$follow_datetime')");
	$msg = base64_encode('Application-Details');
	header("Location: report/vgrapplication.php?aid=error_$userid&$msg");
}

if(isset($_POST['fileVRStatusBtn'])){
	$userid = $_POST['snid'];
	$file_upload_vgr_status = $_POST['file_upload_vgr_status'];
	$file_upload_vgr_remarks = $_POST['file_upload_vgr_remarks'];
	$tab = $_POST['rowbg1'];
	if($tab !==''){
		$tab1 = '&tab='.$tab;
	}else{
		$tab1 = '';
	}
	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$user_id = $uid1['user_id'];
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$fname2 = $uid1['fname'];
	$fullname = $fname2.' '.$uid1['lname'];
	$uid = base64_encode($userid);	

	mysqli_query($con, "update `st_application` set `file_upload_vgr_status`='$file_upload_vgr_status',`file_upload_vgr_remarks`='$file_upload_vgr_remarks',`file_upload_vgr_datetime`='$follow_datetime' where `sno`='$userid'");			

	if($file_upload_vgr_status == 'Yes'){
		mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Refund Documents Sent For', 'Refund Documents Status', 'application?aid=error_$userid', '1', '$follow_datetime', 'Yes')");
	}
	$msg = base64_encode('Application-Details');
	header("Location: application?pt=$msg&did=$user_id&aid=error_$userid&apid=$uid$tab1");
}

if(isset($_POST['fhStatusBtn'])){
	$userid = $_POST['snid'];
	$fh_status1 = $_POST['fh_status'];
	if($fh_status1 == ''){
		$fh_status = '';
		$fh_re_lodgement = '';
	}
	if($fh_status1 == '1'){
		$fh_status = '1';
		$fh_re_lodgement = '';
	}
	if($fh_status1 == 'File_Not_Lodged'){
		$fh_status = '';
		$fh_re_lodgement = '';
	}

	if($fh_status1 == 'Re_Lodged'){
		$fh_status = '1';
		$fh_re_lodgement = ",fh_re_lodgement='Re_Lodged'";
	}

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,follow_stage FROM `st_application` where `sno`='$userid'");

	$uid1 = mysqli_fetch_assoc($qry);

	$user_id = $uid1['user_id'];	

	$sno = $uid1['sno'];

	$refid = $uid1['refid'];

	$fname2 = $uid1['fname'];

	$follow_stage = $uid1['follow_stage'];

	$fullname = $fname2.' '.$uid1['lname'];

	$uid = base64_encode($userid);



	// if($follow_stage == 'FH_Sent'){

		// $stage = ", `follow_stage`='0'";

	// }elseif($follow_stage == 'V-R'){

		// $stage = ", `follow_stage`='0'";

	// }elseif($follow_stage == 'V-G'){

		// $stage = ", `follow_stage`='0'";

	// }else{

		// $stage = '';

	// }

	

	if($follow_stage == 'File_Not_Lodged' && $fh_status1 == '1'){

		$follow_status_1 = ",follow_status='0'";

	}else{

		$follow_status_1 = '';

	}

	$qury = "update `st_application` set `fh_status`='$fh_status', `fh_status_updated_by`='$follow_datetime', `fh_status_updated_name`='$Loggedemail' $follow_status_1 $fh_re_lodgement where `sno`='$userid'";

    mysqli_query($con, $qury);	

	if($fh_status1 == 'Re_Lodged'){

		$qryEmpty = "update `st_application` set v_g_r_status='', v_g_r_invoice='', v_g_r_amount='', v_g_r_status_datetime='', com_refund_datetime='', comrefund_remarks='', inovice_status='', inovice_remarks='', inovice_reciept='', inovice_datetime='', file_upload_vgr='', file_upload_vgr2='', file_upload_vgr3='', file_upload_vr_status='', file_upload_vr_remarks='',  file_upload_vr_datetime='', settled_vr='', tt_upload_report_status='', tt_upload_report='', tt_upload_report_remarks='', tt_upload_report_datetime='' ,file_upload_vgr_status='', file_upload_vgr_remarks='', file_upload_vgr_datetime='', com_details_status_vr='', com_details_remarks_vr='', com_details_datetime_vr=''  where `sno`='$userid'";
		mysqli_query($con, $qryEmpty);
	}			

	// mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'F@H Status', 'F@H Status', 'application?aid=error_$userid', '1', '$follow_datetime', 'Yes')");

//Followup

	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$userid' AND fstage='$follow_stage' order by sno asc";
	$flowRsltQury = mysqli_query($con, $flowQury);
	$flowList = mysqli_fetch_assoc($flowRsltQury);
	$fsno = $flowList['sno'];
	$fstage = $flowList['fstage'];
	if(!empty($fstage)){
		mysqli_query($con, "update `followup` set `updated`='$follow_datetime' where `sno`='$fsno'");
	}
	mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$userid'");
	$msg = base64_encode('Application-Details');
	header("Location: application?pt=$msg&did=$user_id&aid=error_$userid&apid=$uid");
}

if(isset($_POST['comTTBtn'])){
	$userid = $_POST['snid'];
	$com_details_status_vr = $_POST['com_details_status_vr'];
	$com_details_remarks_vr = $_POST['com_details_remarks_vr'];	

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$user_id = $uid1['user_id'];
	$sno = $uid1['sno'];

	$refid = $uid1['refid'];

	$fname2 = $uid1['fname'];

	$fullname = $fname2.' '.$uid1['lname'];

	$uid = base64_encode($userid);	

	

	mysqli_query($con, "update `st_application` set `com_details_status_vr`='$com_details_status_vr', `com_details_remarks_vr`='$com_details_remarks_vr', `com_details_datetime_vr`='$follow_datetime' where `sno`='$userid'");

			

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Remarks For -(Commission Details Uploaded by Processor)', 'COMMISSION Details', 'application?aid=error_$userid', '1', '$follow_datetime', 'Yes')");



	$msg = base64_encode('Application-Details');

	header("Location: application?pt=$msg&did=$user_id&aid=error_$userid&apid=$uid");

}



if(isset($_POST['srchClickbtn'])){

	$search = $_POST['search'];

	header("Location: ../backend/application?getsearch=$search");

}



if(isset($_POST['vrRefundttfile'])){

	$userid = $_POST['snid'];

	$settled_vr = $_POST['settled_vr'];

	$tt_upload_report_status = $_POST['tt_upload_report_status'];

	$tt_upload_report_remarks = $_POST['tt_upload_report_remarks'];	

	

	if($tt_upload_report_status == 'Yes'){

		$tt_upload_report_status_1 = 'Approved';

	}

	if($tt_upload_report_status == 'No'){

		$tt_upload_report_status_1 = 'Not Approved';

	}

	

	$name3 = $_FILES['tt_upload_report']['name'];

	$tmp3 = $_FILES['tt_upload_report']['tmp_name'];

	

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,tt_upload_report FROM `st_application` where `sno`='$userid'");

	$uid1 = mysqli_fetch_assoc($qry);

	$user_id = $uid1['user_id'];	

	$sno = $uid1['sno'];

	$refid = $uid1['refid'];

	$tt_upload_report = $uid1['tt_upload_report'];

	$fname2 = $uid1['fname'];

	$fullname = $fname2.' '.$uid1['lname'];

	$fnames = str_replace(' ', '_', $fname2);	

	

	if($name3 == ''){	

		$img_name3 = $tt_upload_report;		

	}else{

		$extension = pathinfo($name3, PATHINFO_EXTENSION);			

		if($extension=='pdf' || $extension=='PDF' || $extension=='JPG' || $extension=='jpg' || $extension=='jpeg' || $extension=='JPEG'){

			if($tt_upload_report !==''){

				unlink("../uploads/$tt_upload_report");

			}

			$img_name3 = 'TT_Reciept_'.$fnames.'_'.$refid.'_'.date('mdis').'.'.$extension;			

			move_uploaded_file($tmp3, '../uploads/'.$img_name3);			

		}else{			

			$imgMsg = base64_encode('ImageUpload');

			echo "<script>alert('File is not Supported (Please upload the PDF and JPG Files)'); window.location='report/vgrapplication.php?aid=error_$userid&$imgMsg'</script>";

			exit;

		}			

	}

	

	mysqli_query($con, "update `st_application` set `settled_vr`='$settled_vr', `tt_upload_report_status`='$tt_upload_report_status', `tt_upload_report_remarks`='$tt_upload_report_remarks', `tt_upload_report`='$img_name3', `tt_upload_report_datetime`='$follow_datetime' where `sno`='$userid'");

	

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('Agent', 'admin', '$sno', '$fullname', '$user_id', '$refid', 'TT Receipt(Refund)', 'For Refund Docs', 'application?aid=error_$userid', '1', '$follow_datetime')");



	if(($tt_upload_report_status == 'Yes') && !empty($name3)){

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'TT Receipt(Refund)', 'For Refund Docs', 'application?aid=error_$userid', '1', '$follow_datetime')");

	}

			

	$msg = base64_encode('Application-Details');

	header("Location: report/vgrapplication.php?aid=error_$userid&$msg");

}



if(isset($_POST['vrRefundttfile_1'])){

	$userid = $_POST['snid'];

	$settled_vr = $_POST['settled_vr'];

	$tt_upload_report_status = $_POST['tt_upload_report_status_1'];

	$tt_upload_report_remarks = $_POST['tt_upload_report_remarks_1'];	

	

	if($tt_upload_report_status == 'Yes'){

		$tt_upload_report_status_1 = 'Approved';

	}

	if($tt_upload_report_status == 'No'){

		$tt_upload_report_status_1 = 'Not Approved';

	}

		

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,tt_upload_report FROM `st_application` where `sno`='$userid'");

	$uid1 = mysqli_fetch_assoc($qry);

	$user_id = $uid1['user_id'];	

	$sno = $uid1['sno'];

	$refid = $uid1['refid'];

	$tt_upload_report = $uid1['tt_upload_report'];

	$fname2 = $uid1['fname'];

	$fullname = $fname2.' '.$uid1['lname'];

	$fnames = str_replace(' ', '_', $fname2);	

	

	if($tt_upload_report !==''){

		unlink("../uploads/$tt_upload_report");

	}	

	

	mysqli_query($con, "update `st_application` set `settled_vr`='$settled_vr', `tt_upload_report_status`='$tt_upload_report_status', `tt_upload_report_remarks`='$tt_upload_report_remarks', `tt_upload_report`='', `tt_upload_report_datetime`='$follow_datetime' where `sno`='$userid'");

	

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('Agent', 'admin', '$sno', '$fullname', '$user_id', '$refid', 'Refund Docs $tt_upload_report_status_1', 'For Refund Docs', 'application?aid=error_$userid', '1', '$follow_datetime')");

	

	if($tt_upload_report_status == 'Yes'){

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'Refund Docs $tt_upload_report_status_1', 'For Refund Docs', 'application?aid=error_$userid', '1', '$follow_datetime')");

	}

			

	$msg = base64_encode('Application-Details');

	header("Location: report/vgrapplication.php?aid=error_$userid&$msg");

}



if(isset($_POST['collegettbtn'])){

	$snid = $_POST['snid'];

	$name3 = $_FILES['college_tt']['name'];

	$tmp3 = $_FILES['college_tt']['tmp_name'];

	

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,college_tt FROM `st_application` where `sno`='$snid'");

	$uid1 = mysqli_fetch_assoc($qry);

	$user_id = $uid1['user_id'];	

	$sno = $uid1['sno'];

	$refid = $uid1['refid'];

	$college_tt = $uid1['college_tt'];

	$fname2 = $uid1['fname'];

	$fullname = $fname2.' '.$uid1['lname'];

	$fnames = str_replace(' ', '_', $fname2);

	if($name3 == ''){	
		$img_name3 = $college_tt;	

	}else{

		$extension = pathinfo($name3, PATHINFO_EXTENSION);			

		if($extension=='pdf' || $extension=='PDF' || $extension=='JPG' || $extension=='jpg' || $extension=='jpeg' || $extension=='JPEG'){

			if($college_tt !==''){

				unlink("../uploads/$college_tt");

			}

			$img_name3 = 'Receipt_'.$fnames.'_'.$refid.'_'.date('mdis').'.'.$extension; //College_TT	

			move_uploaded_file($tmp3, '../uploads/'.$img_name3);			

		}else{			

			$imgMsg = base64_encode('ImageUpload');

			echo "<script>alert('File is not Supported (Please upload the PDF and JPG Files)'); window.location='report/loa_receipt.php?aid=error_$snid&$imgMsg'</script>";

			exit;

		}			

	}

	mysqli_query($con, "update `st_application` set `college_tt`='$img_name3', `college_tt_date`='$follow_datetime' where `sno`='$snid'");

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('Agent', 'admin', '$sno', '$fullname', '$user_id', '$refid', 'Receipt Uploaded by Processor', 'Receipt Uploaded by Processor', 'application?aid=error_$snid', '1', '$follow_datetime')");	

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('Admin', '$sno', '$fullname', '$user_id', '$refid', 'Receipt Uploaded by Processor', 'Receipt Uploaded by Processor', 'application?aid=error_$snid', '1', '$follow_datetime')");

	$msg = base64_encode('Application-Details');
	header("Location: report/loa_receipt.php?aid=error_$snid&$msg");
}


if(isset($_POST['courseBtnNew'])){

	if(!empty($_POST['program_name_input'])){
		$program_name = $_POST['program_name_input'];
	} elseif(!empty($_POST['program_name_drop'])){
		$program_name = $_POST['program_name_drop'];
	}else{
		$program_name = '';
	}

	$campus = $_POST['campus'];
	$intake = $_POST['intake'];
	$tuition_fee = $_POST['tuition_fee'];
	$commenc_date = $_POST['commenc_date'];
	$expected_date = $_POST['expected_date'];
	$app_fee = $_POST['app_fee'];
	$stu_ra_service_fee = $_POST['stu_ra_service_fee'];
	$textbook_cost = $_POST['textbook_cost'];
	$inter_stud_schlr = $_POST['inter_stud_schlr'];
	$total = $_POST['total'];
	$week = $_POST['week'];
	$practicum_start_date = $_POST['practicum_start_date'];
	$practicum_end_date = $_POST['practicum_end_date'];
	
	$created_datetime = date('Y-m-d H:i:s');
	$snoCheck = $_POST['snoCheck'];

	if(empty($snoCheck)){
	 $quryCrs = "INSERT INTO `contract_courses` (`campus`, `program_name`, `intake`, `tuition_fee`, `commenc_date`, `expected_date`, `app_fee`, `stu_ra_service_fee`, `textbook_cost`, `inter_stud_schlr`, `total`, `week`, `created_datetime`, `campus_status`, `practicum_start_date`, `practicum_end_date`) VALUES ('$campus', '$program_name', '$intake', '$tuition_fee', '$commenc_date', '$expected_date', '$app_fee', '$stu_ra_service_fee', '$textbook_cost', '$inter_stud_schlr', '$total', '$week', '$created_datetime', '1', '$practicum_start_date', '$practicum_end_date')";
	 mysqli_query($con, $quryCrs);
	 
	}else{
		mysqli_query($con, "update `contract_courses` set `program_name`='$program_name', `campus`='$campus', `intake`='$intake', `tuition_fee`='$tuition_fee', `commenc_date`='$commenc_date', `expected_date`='$expected_date', `app_fee`='$app_fee', `stu_ra_service_fee`='$stu_ra_service_fee', `textbook_cost`='$textbook_cost', `inter_stud_schlr`='$inter_stud_schlr', `total`='$total', `week`='$week', `campus_status`='$campus_status', `practicum_start_date`='$practicum_start_date', `practicum_end_date`='$practicum_end_date' where `sno`='$snoCheck'");
	}

	$msg = base64_encode('Course-Details');
	header("Location: courses/all_courses.php?$msg");
}


if(isset($_POST['loaRqstbtn'])){
	$idno = $_POST['idno'];
	$name1 = $_FILES['loa_tt']['name'];
	$random = base64_encode(rand());	

	if(!empty($name1)){
	$tmp1 = $_FILES['loa_tt']['tmp_name'];
	$loa_tt_remarks = mysqli_real_escape_string($con, $_POST['loa_tt_remarks']);
	$extension = pathinfo($name1, PATHINFO_EXTENSION);
	
	if($extension=='pdf'  || $extension=='PDF'|| $extension=='zip' || $extension=='rar' || $extension=='jpg' || $extension=='JPG' || $extension=='PNG' || $extension=='png'){	

	$result = mysqli_query($con,"SELECT sno, app_by, user_id, refid, fname, lname, loa_tt,  follow_stage FROM st_application WHERE sno='$idno'");
	$row = mysqli_fetch_assoc($result);
	$sno = $row['sno'];
	$agent_type = $row['app_by'];
	$agent_id = $row['user_id'];
	$follow_stage = $row['follow_stage'];
	$refid = $row['refid'];
	$loa_tt = $row['loa_tt'];
	$fullname = $row['fname'].' '.$row['lname'];
	$date = date('Y-m-d H:i:s');	

	// if($follow_stage == 'Conditional_Offer_letter'){
		// $stage = ", `follow_status`='0'";
	// }elseif($follow_stage == 'LOA_Request'){
		// $stage = ", `follow_status`='0'";
	// }elseif($follow_stage == 'Contract_Stage'){
		// $stage = ", `follow_status`='0'";
	// }else{
		// $stage = '';
	// }

	if(!empty($loa_tt)){
		unlink("../uploads/$loa_tt");
	}

	$firstname = str_replace(' ', '', $fullname);
	$img_name1 = 'Rqst_LOA_TT'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
	move_uploaded_file($tmp1, '../uploads/'.$img_name1);	

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'admin', '$sno', '$fullname', '$agent_id', '$refid', 'LOA Requested', 'LOA Request', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");	

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('Admin', '$sno', '$fullname', '$agent_id', '$refid', 'TT Receipt', 'TT Receipt', 'report/loa_receipt.php?aid=error_$sno', '1', '$date', 'Yes')");	

	mysqli_query($con, "update `st_application` set `file_receipt`='1', `loa_tt`='$img_name1', `loa_tt_remarks`='$loa_tt_remarks', `agent_request_loa_datetime`='$date', follow_status='0' where `sno`='$idno'");

//Followup

	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$idno' AND fstage='$follow_stage' order by sno asc";
	$flowRsltQury = mysqli_query($con, $flowQury);
	$flowList = mysqli_fetch_assoc($flowRsltQury);
	$fsno = $flowList['sno'];
	$fstage = $flowList['fstage'];

	if(!empty($fstage)){
		mysqli_query($con, "update `followup` set `updated`='$date' where `sno`='$fsno'");
	}
	mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$idno'");	 

	$msg = base64_encode('Application-Details');
	header("Location: ../backend/application?pt=$msg&aid=error_$idno&$random");	 

	}else{
		$msg = base64_encode('Application-Details');
		header("Location: ../backend/application?pt=$msg&aid=error_$idno&$random");
	}
/////////////////////////
	}else{		

	$result = mysqli_query($con,"SELECT sno,app_by,user_id,refid,fname,lname,loa_tt,follow_stage FROM st_application WHERE sno='$idno'");
	$row = mysqli_fetch_assoc($result);
	$sno = $row['sno'];
	$agent_type = $row['app_by'];
	$agent_id = $row['user_id'];
	$follow_stage = $row['follow_stage'];
	$refid = $row['refid'];
	$loa_tt = $row['loa_tt'];
	$fullname = $row['fname'].' '.$row['lname'];
	$date = date('Y-m-d H:i:s');	

	if(!empty($loa_tt)){
		unlink("../uploads/$loa_tt");
	}
	
	//if($agent_id == '2' || $agent_id == '3'){ //Condition For:Q&A is Not show Ess Global & Aum Global
		
	// }else{
		
	// if(isset($_POST['gc_username'])){
		// $gc_username = $_POST['gc_username'];
	// }else{
		// $gc_username = '';
	// }
	// if(isset($_POST['color'])){
		// $color = $_POST['color'];
	// }else{
		// $color = '';
	// }
	// if(isset($_POST['country'])){
		// $country = $_POST['country'];
	// }else{
		// $country = '';
	// }
	// if(isset($_POST['favourite_person'])){
		// $favourite_person = $_POST['favourite_person'];
	// }else{
		// $favourite_person = '';
	// }
	// if(isset($_POST['city'])){
		// $city = $_POST['city'];
	// }else{
		// $city = '';
	// }
	// if(isset($_POST['pet'])){
		// $pet = $_POST['pet'];
	// }else{
		// $pet = '';
	// }
	// if(isset($_POST['sport'])){
		// $sport = $_POST['sport'];
	// }else{
		// $sport = '';
	// }
	// if(isset($_POST['memorable_day'])){
		// $memorable_day = $_POST['memorable_day'];
	// }else{
		// $memorable_day = '';
	// }
	// if(isset($_POST['car'])){
		// $car = $_POST['car'];
	// }else{
		// $car = '';
	// }
	// if(isset($_POST['movie'])){
		// $movie = $_POST['movie'];
	// }else{
		// $movie = '';
	// }	
    // $agntid = $_POST['agntid'];
	
	// $query = "SELECT * FROM `without_tt` where st_app_id!='' AND st_app_id='$idno'";
	// $rslt = mysqli_query($con, $query);
	// if(mysqli_num_rows($rslt)){
		 // $updateWithOutTT = "UPDATE `without_tt` SET `gc_username` = '$gc_username', `color` = '$color', `country` = '$country', `favourite_person` = '$favourite_person', `city` = '$city', `pet` = '$pet', `sport` = '$sport', `memorable_day` = '$memorable_day', `car` = '$car', `movie` = '$movie', `agent_id` = '$agntid', `updated_at` = '$date' WHERE `st_app_id` = '$idno'";
		// mysqli_query($con, $updateWithOutTT);
	// }else{
		 // $insertWithOutTT = "INSERT INTO `without_tt` (`agent_id`, `st_app_id`, `gc_username`, `color`, `country`, `favourite_person`, `city`, `pet`, `sport`, `memorable_day`, `car`, `movie`, `created_at`) VALUES ('$agntid', '$idno', '$gc_username', '$color', '$country', '$favourite_person', '$city', '$pet', '$sport', '$memorable_day', '$car', '$movie', '$date')";
		// mysqli_query($con, $insertWithOutTT);
	// }
	
	//} ////End Condtion Show Q&A
	

	// if($follow_stage == 'Conditional_Offer_letter'){
		// $stage = ", `follow_status`='0'";
	// }elseif($follow_stage == 'LOA_Request'){
		// $stage = ", `follow_status`='0'";
	// }elseif($follow_stage == 'Contract_Stage'){
		// $stage = ", `follow_status`='0'";
	// }else{
		// $stage = '';
	// }	

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'admin', '$sno', '$fullname', '$agent_id', '$refid', 'LOA Requested', 'LOA Request', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");	

	// mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('Admin', '$sno', '$fullname', '$agent_id', '$refid', 'TT Receipt', 'TT Receipt', 'report/loa_receipt.php?aid=error_$sno', '1', '$date', 'Yes')");	

	mysqli_query($con, "update `st_application` set `file_receipt`='1', `loa_tt`='', `loa_tt_remarks`='', `agent_request_loa_datetime`='$date', follow_status='0' where `sno`='$idno'");

//Followup

	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$idno' AND fstage='$follow_stage' order by sno asc";
	$flowRsltQury = mysqli_query($con, $flowQury);
	$flowList = mysqli_fetch_assoc($flowRsltQury);
	$fsno = $flowList['sno'];
	$fstage = $flowList['fstage'];

	if(!empty($fstage)){
		mysqli_query($con, "update `followup` set `updated`='$date' where `sno`='$fsno'");
	}

	mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$idno'");
	$msg = base64_encode('Application-Details');
	header("Location: ../backend/application?pt=$msg&aid=error_$idno");
	}
}


if(isset($_POST['loaChangeDate'])){
	$snid = $_POST['snid'];
	$loa_file_date_updated_by = $_POST['loa_file_date_updated_by'];
	$datechange = $loa_file_date_updated_by.' '.date('H:i:s');
	mysqli_query($con, "update `st_application` set `loa_file_date_updated_by`='$datechange' where `sno`='$snid'");
	$msg = base64_encode('Application-Details');
	header("Location: application/index_loa_date.php?aid=error_$snid&pt=$msg");
}


if(isset($_POST['srchAolbtn'])){
	$search = $_POST['search'];
	header("Location: ../backend/application/index_loa_date.php?getsearch=$search");
}

if(isset($_POST['srchClgbtn'])){
	$search = $_POST['search'];
	header("Location: ../backend/clg_docs/?getsearch=$search");
}

if(isset($_POST['ppBtnNew'])){
	$ppid = $_POST['ppid'];
	$crs_id = $_POST['crs_id'];
	$due_date2 = $_POST['due_date'];

	if(!empty($due_date2)){
		$due_date = date("F j, Y", strtotime($due_date2));
	}else{
		$due_date = '';
	}

	$total_fee2 = $_POST['total_fee'];
	if(!empty($total_fee2)){
		$total_fee = $total_fee2;
	}else{
		$total_fee = '';
	}	

	$int_fee2 = $_POST['int_fee'];
	if(!empty($int_fee2)){
		$int_fee = $int_fee2;
	}else{
		$int_fee = '';
	}	

	$book2 = $_POST['book'];
	if(!empty($book2)){
		$book = $book2;
	}else{
		$book = '';
	}	

	$comp_fees2 = $_POST['comp_fees'];
	if(!empty($comp_fees2)){
		$comp_fees = $comp_fees2;
	}else{
		$comp_fees = '';
	}	

	$tuition_fees2 = $_POST['tuition_fees'];
	if(!empty($tuition_fees2)){
		$tuition_fees = $tuition_fees2;
	}else{
		$tuition_fees = '';
	}	

	$invoice_code2 = $_POST['invoice_code'];
	if(!empty($invoice_code2)){
		$invoice_code = $invoice_code2;
	}else{
		$invoice_code = '';	
	}	

	if(empty($ppid)){
		$insert_update = "INSERT INTO `cc_date_wise_fee` (`crs_id`, `due_date`, `total_fee`, `int_fee`, `book`, `comp_fees`, `tuition_fees`, `invoice_code`) VALUES ('$crs_id', '$due_date', '$total_fee', '$int_fee', '$book', '$comp_fees', '$tuition_fees', '$invoice_code')";
	}else{
		$insert_update = "update `cc_date_wise_fee` set `crs_id`='$crs_id', `due_date`='$due_date', `total_fee`='$total_fee', `int_fee`='$int_fee', `book`='$book', `comp_fees`='$comp_fees', `tuition_fees`='$tuition_fees', `invoice_code`='$invoice_code' where `sno`='$ppid'";
	}
	mysqli_query($con, $insert_update);

	$crs_id2 = base64_encode("$crs_id");
	$msg = base64_encode('payments-plan-Details');
	header("Location: courses/payp_list.php?idCrs_=$crs_id2&$msg");
}

if(isset($_POST['btnPostiveRes'])){
	$agentid = $_POST['agentid'];
	if(isset($_POST['notiAgain'])){
		$notiAgain = 'Yes';
	}else{
		$notiAgain = 'No';		
	}
	$_SESSION["agentPostiveResponseAOL"]=$notiAgain;
	
	$agentQry = "update `allusers` set `status2`='$notiAgain' where `sno`='$agentid'";
	mysqli_query($con, $agentQry);
	header("Location: application/");
}


if (isset($_POST["add_amount"])) {


	$sno = $_POST["sno"];
	$created_date = date("Y-m-d");
	$created_time = date("H:i:s");
	$tot_amt = $_POST["tot_amt"];
	$amt_rec = $_POST["amt_rec"];
	$follow_sts = $_POST["follow_sts"];
	$followup_date = $_POST["followup_date"];
	$remarks = $_POST["remarks"];
	$updated_by = $_POST["updated_by"];
	$docu_sign = $_POST["docu_sign"];
	$stud_travelled = $_POST["stud_travelled"];
	$strt_date = $_POST["strt_date"];
	$date_of_vg = $_POST["date_of_vg"];
	$cad_amt = $_POST["cad_amt"];
	$docusign_sent = $_POST["docusign_sent"];
	$tt_sts = $_POST["tt_sts"];
	$tt_amt = $_POST["tt_amt"];

	if ($tt_amt != '') {
		$tt_amt_inr = $tt_amt * 60;
	} else {
		$tt_amt_inr = '0';
	}

	$tt_verified = $_POST["tt_verified"];
	$travel_issue = $_POST["travel_issue"];
	$fileno = $_POST["fileno"];

	if ($follow_sts != 'followup') {
		$followup_date = '';
	}




	$check_exits = "SELECT * FROM vg_payment WHERE st_app_id = '$sno'";
	$check_res = mysqli_query($con, $check_exits);
	if (mysqli_num_rows($check_res) > 0) {
		$check_row = mysqli_fetch_assoc($check_res);
		$vg_id = $check_row["id"];
		$amt_pending = $check_row["amt_pending"];
		$amt_rec1 = $check_row["amt_rec"];
		$amt_rec2 = $amt_rec1 + $amt_rec;
		$tt_amt1 = $check_row["tt_amt"];
		$tt_amt2 = $tt_amt1 + $tt_amt;
		$total_amt_rec = $check_row["total_amt_rec"];

		$amt_pending1 = $amt_pending - $amt_rec - $tt_amt_inr;
		$total_amt_rec1 = $total_amt_rec + $amt_rec + $tt_amt_inr;
		$tot_amt_rec = $tt_amt_inr + $amt_rec;

		if ($amt_pending1 < 0) {
			$amt_pending1 = "0";
		}

		$insert_sql_logs = "INSERT INTO `vg_payment_logs`(`st_app_id`, `tot_amt`, `amt_rec`,`amt_dollar`,  `follow_sts`, `followup_date`, `remarks`,`updated_by`, `created_time`, `created_date`) VALUES ('$sno','$tot_amt_rec','$amt_rec','$tt_amt','$follow_sts','$followup_date','$remarks','$updated_by','$created_date','$created_time')";
		 $insert_res_logs = mysqli_query($con, $insert_sql_logs);

		$insert_sql = "UPDATE `vg_payment` SET `total_amt_rec`  = '$total_amt_rec1',  `amt_rec` = '$amt_rec2',`tt_amt` = '$tt_amt2', `amt_pending`  = '$amt_pending1', `follow_sts` = '$follow_sts', `followup_date` = '$followup_date', `remarks` = '$remarks',`updated_by` = '$updated_by' WHERE id = '$vg_id' AND st_app_id = '$sno' ";
		$insert_res = mysqli_query($con, $insert_sql);
	} else {


		$amt_pending = $tot_amt - $amt_rec - $tt_amt_inr;
		$total_amt_rec = $amt_rec + $tt_amt_inr;
		if ($amt_pending < 0) {
			$amt_pending = "0";
		}

		 $insert_sql_logs = "INSERT INTO `vg_payment_logs`(`st_app_id`, `tot_amt`, `amt_rec`,`amt_dollar`,  `follow_sts`, `followup_date`, `remarks`,`updated_by`, `created_time`, `created_date`) VALUES ('$sno','$total_amt_rec','$amt_rec','$tt_amt','$follow_sts','$followup_date','$remarks','$updated_by','$created_date','$created_time')";
		$insert_res_logs = mysqli_query($con, $insert_sql_logs);

		$insert_sql = "INSERT INTO `vg_payment`(`st_app_id`, `tot_amt`, `amt_rec`,`total_amt_rec`, `amt_pending`, `follow_sts`, `followup_date`, `remarks`,`updated_by`, `created_time`, `created_date`,`fileno`, `cad_amt`, `docusign_sent`, `tt_sts`, `tt_amt`, `tt_verified`, `strt_date`, `date_of_vg`, `docu_sign`, `stud_travelled`, `travel_issue`) VALUES ('$sno','$tot_amt','$amt_rec','$total_amt_rec','$amt_pending','$follow_sts','$followup_date','$remarks','$updated_by','$created_date','$created_time','$fileno', '$cad_amt', '$docusign_sent', '$tt_sts', '$tt_amt', '$tt_verified', '$strt_date', '$date_of_vg', '$docu_sign', '$stud_travelled', '$travel_issue')";
		$insert_res = mysqli_query($con, $insert_sql);
	}

	if ($insert_res == "TRUE") {
		header("Location: accounts/?sts=Successful");
	} else {
		header("Location: accounts?sts=UnSuccessful");
	}
}

if (isset($_POST['docstsSubmit'])) {

	$sno = $_POST['sno'];
	$doc_status = $_POST['doc_status'];
	$remarks = $_POST['remarks'];

	$res_stid = mysqli_query($con, "SELECT st_id FROM travel_docs WHERE sno = '$sno' GROUP BY st_id ");
	$row_stid = mysqli_fetch_assoc($res_stid);
	$stid = mysqli_real_escape_string($con, $row_stid['st_id']);

	$qury = "update `travel_docs` set `remarks`='$remarks', `doc_status`='$doc_status' where `sno`='$sno'";

	mysqli_query($con, $qury);
	header("Location: application/travel_doc.php?st=" . $stid);
}

if(isset($_POST['new_agentid'])){
	
	$agentid = $_POST['agentid'];
	$agent_name = $_POST['agent_name'];
	$new_agentid = $_POST['new_agentid'];
	$remarks = $_POST['remarks'];
	$application_id = $_POST['application_id'];
	
	$newagent_res = mysqli_query($con,"SELECT sno,username FROM allusers WHERE sno = '$new_agentid' AND  role = 'Agent' ");
	$newagent_row = mysqli_fetch_assoc($newagent_res);
	$new_agent_name = $newagent_row['username'];
	
	$logs_res = mysqli_query($con,"INSERT INTO `agents_logs`(`application_id`, `agentid`, `agent_name`, `new_agentid`, `new_agent_name`, `remarks`, `created_datetime`) VALUES ('$application_id', '$agentid', '$agent_name', '$new_agentid', '$new_agent_name', '$remarks', '$follow_datetime')");
	
	$upd_stTable ="UPDATE st_application SET user_id = '$new_agentid',agent_name = '$new_agent_name' WHERE sno = '$application_id'"; 
	$upd_stTable_res = mysqli_query($con,$upd_stTable);
	$upd_notification ="UPDATE notification_aol SET agent_id = '$new_agentid' WHERE application_id = '$application_id' AND agent_id = '$agentid' "; 
	$upd_notifi_res = mysqli_query($con,$upd_notification);	
	
	if($upd_notifi_res == 'TRUE'){
		echo $application_id;
	}else{
		echo '00';
	}
}

if(isset($_POST['palCABtn'])){
	$pal_no = $_POST['pal_no'];
	$issue_date = $_POST['issue_date'];
	$expiry_date = $_POST['expiry_date'];
	$userid = $_POST['snid'];

	$name3 = $_FILES['pal_letter']['name'];
	$tmp3 = $_FILES['pal_letter']['tmp_name'];	

	$qry = mysqli_query($con, "SELECT sno, user_id, refid, fname, lname FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$user_id = $uid1['user_id'];
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$fname2 = $uid1['fname'];
	$fullname = $fname2.' '.$uid1['lname'];
	$fnames = str_replace(' ', '_', $fname2);

	$qry2 = mysqli_query($con, "SELECT sno, pal_letter FROM `pal_apply` where `app_id`='$userid'");
	if(mysqli_num_rows($qry2)){
		$uid2 = mysqli_fetch_assoc($qry2);
		$pal_letter = $uid2['pal_letter'];
	}else{
		$pal_letter = '';
	}

	if($name3 == ''){
		$img_name3 = $pal_letter;	
	}else{
		$extension = pathinfo($name3, PATHINFO_EXTENSION);
		if($extension=='pdf' || $extension=='PDF'){
			if($pal_letter !==''){
				unlink("PALFiles/$pal_letter");
			}
			$img_name3 = 'PAL_'.$refid.'_'.date('mdis').'.'.$extension;	
			move_uploaded_file($tmp3, 'PALFiles/'.$img_name3);
		}else{
			$imgMsg = base64_encode('ImageUpload');
			echo "<script>alert('File is not Supported (Please upload only PDF Files)'); window.location='application/?aid=error_$userid&$imgMsg'</script>";
			exit;
		}
	}
	
	if(mysqli_num_rows($qry2)){
		$ddddUpdated = "UPDATE `pal_apply` SET `pal_letter`='$img_name3', `pal_no`='$pal_no', `issue_date`='$issue_date', `expiry_date`='$expiry_date', `second_upd_name`='$Loggedemail', `second_datetime`='$follow_datetime' WHERE `app_id`='$userid'";	
		mysqli_query($con, $ddddUpdated);
	}else{
		$dddd = "update `st_application` set `pal_status`='1' where `sno`='$userid'";	
		mysqli_query($con, $dddd);
		
		$ddddAdded = "INSERT INTO `pal_apply` (`app_id`, `pal_letter`, `pal_no`, `issue_date`, `expiry_date`, `updated_name`, `updated_datetime`) VALUES ('$userid', '$img_name3', '$pal_no', '$issue_date', '$expiry_date', '$Loggedemail', '$follow_datetime');";	
		mysqli_query($con, $ddddAdded);
	}

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'PAL File Sent', 'For PAL Docs', 'application?aid=error_$userid', '1', '$follow_datetime')");

	$msg = base64_encode('PALAPP042024-Status');	
	$random = base64_encode(rand());
	header("Location: ../backend/application?pt=$msg&aid=error_$userid&$random");
}

if(isset($_POST['gicCrtfctBtn'])){
	$gic_pr = $_POST['gic_pr'];
	$userid = $_POST['snid'];
	$urlDiv = $_POST['clgsite'];	

	$qry = mysqli_query($con, "SELECT sno, user_id, refid, fname, lname FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$user_id = $uid1['user_id'];
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$fname2 = $uid1['fname'];
	$fullname = $fname2.' '.$uid1['lname'];
	$fnames = str_replace(' ', '_', $fname2);

	$qry2 = mysqli_query($con, "SELECT sno, gic_file FROM `pal_apply` where `app_id`='$userid'");
	if(mysqli_num_rows($qry2)){
		$uid2 = mysqli_fetch_assoc($qry2);
		$gic_file = $uid2['gic_file'];
	}else{
		$gic_file = '';
	}
	
	if($gic_pr == 'Received'){
		$name3 = $_FILES['gic_file']['name'];
		$tmp3 = $_FILES['gic_file']['tmp_name'];
		
		if($name3 == ''){
			$img_name3 = $gic_file;	
		}else{
			$extension = pathinfo($name3, PATHINFO_EXTENSION);
			if($extension=='pdf' || $extension=='PDF'){
				if($gic_file !==''){
					unlink("GICFiles/$gic_file");
				}
				$img_name3 = 'GIC_'.$refid.'.'.$extension;	
				move_uploaded_file($tmp3, 'GICFiles/'.$img_name3);
			}else{
				$imgMsg = base64_encode('ImageUpload');
				if(!empty($urlDiv)){
					echo "<script>alert('File is not Supported (Please upload only PDF Files)'); window.location='clg_docs/?aid=error_$userid&$imgMsg'</script>";
					exit;
				}else{
					echo "<script>alert('File is not Supported (Please upload only PDF Files)'); window.location='application/?aid=error_$userid&$imgMsg'</script>";
					exit;
				}
			}
		}
	}else{
		$img_name3 = '';
		if($gic_file !==''){
			unlink("GICFiles/$gic_file");
		}
	}
	
	if(mysqli_num_rows($qry2)){
		$ddddUpdated = "UPDATE `pal_apply` SET `gic_file`='$img_name3', `gic_pr`='$gic_pr', `gic_added_by`='$loggedid', `gic_datetime`='$follow_datetime' WHERE `app_id`='$userid'";	
		mysqli_query($con, $ddddUpdated);
	}else{
		
		$ddddAdded = "INSERT INTO `pal_apply` (`app_id`, `gic_file`, `gic_pr`, `gic_added_by`, `gic_datetime`) VALUES ('$userid', '$img_name3', '$gic_pr', '$loggedid', '$follow_datetime');";	
		mysqli_query($con, $ddddAdded);
	}

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$Loggedrole', '$sno', '$fullname', '$user_id', '$refid', 'GIC Updated', 'For GIC Updated', 'application?aid=error_$userid', '1', '$follow_datetime')");

	$msg = base64_encode('GICAPP0420334-Status');	
	$random = base64_encode(rand());	
	if(!empty($urlDiv)){
		header("Location: ../backend/clg_docs?pt=$msg&aid=error_$userid&$random");
	}else{
		header("Location: ../backend/application?pt=$msg&aid=error_$userid&$random");
	}
}
?>