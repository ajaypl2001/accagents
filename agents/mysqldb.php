<?php
session_start();
include("db.php");
date_default_timezone_set("Asia/Kolkata");

if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
	$loggedid = $_SESSION['sno'];
	$rsltLogged = mysqli_query($con,"SELECT sno,email FROM allusers WHERE sno = '$loggedid'");
	$rowLogged = mysqli_fetch_assoc($rsltLogged);
	$Loggedemail = mysqli_real_escape_string($con, $rowLogged['email']);
}else{
   header("Location: login");
   exit(); 
}
$follow_datetime = date('Y-m-d H:i:s');



/*rm = Register Message*/
/*em = Error Message*/
if(isset($_POST['smtbtn'])){
   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $username = $fname.' '.$lname;
   $email = $_POST['email'];
   $mobile = $_POST['mobile'];
   $password = $_POST['password'];
   $original_pass = md5(sha1($password));
   $gender = $_POST['gender'];
   $passport = $_POST['passport'];
   $cpassword = $_POST['cpassword'];
   $created = date('Y-m-d H:i:s');
   $status = '';
   $msg = base64_encode('Register_Form');
   $emsg = base64_encode('Register_Email');
   $pmsg = base64_encode('Register_Passport');
   $role = 'Student';
   
   
	$resEmail = mysqli_query($con,"SELECT email FROM allusers WHERE email = '$email'");   
	if (mysqli_num_rows($resEmail) == '1'){
		header("Location: ../signup?em=$emsg");
	}else{
	$resPassport = mysqli_query($con,"SELECT passport_no FROM st_application WHERE passport_no = '$passport'"); 
	if (mysqli_num_rows($resPassport) == '1'){
		header("Location: ../signup?em=$pmsg");
	}else{
	mysqli_query($con, "INSERT INTO `allusers` (`role`, `username`, `email`, `password`, `original_pass`,`verifystatus`, `created`) VALUES('$role', '$username', '$email', '$original_pass', '$password', '$status', '$created')");
	$last_id = mysqli_insert_id($con);	
	$year = date('Y');
	$year_two = substr($year, -2);
	$month = date('m');
	$refid = 'R'.'-'.$last_id.''.$year_two.''.$month;	
	$inserted = "INSERT INTO `st_application` (`app_by`, `user_id`, `refid`, `email_address`, `fname`, `lname`, `mobile`, `gender`, `passport_no`, `datetime`) VALUES('$role', '$last_id', '$refid', '$email', '$fname', '$lname', '$mobile', '$gender', '$passport', '$created')";
	$register_query = mysqli_query($con, $inserted);
		header("Location: login?rm=$msg");
   }
 }
}

if(isset($_POST['personalbtn'])){
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
	
	$gender = mysqli_real_escape_string($con, $_POST['gender']);
	$martial_status = mysqli_real_escape_string($con, $_POST['martial_status']);
	$dob = mysqli_real_escape_string($con, $_POST['dob']);
	$cntry_brth = mysqli_real_escape_string($con, $_POST['cntry_brth']);
	$address1 = mysqli_real_escape_string($con, $_POST['address1']);
	$address2 = mysqli_real_escape_string($con, $_POST['address2']);
	$on_off_shore = mysqli_real_escape_string($con, $_POST['on_off_shore']);
	$country = mysqli_real_escape_string($con, $_POST['country']);
	$state = mysqli_real_escape_string($con, $_POST['state']);
	$city = mysqli_real_escape_string($con, $_POST['city']);
	$pincode = mysqli_real_escape_string($con, $_POST['pincode']);
	$passport_no = mysqli_real_escape_string($con, $_POST['passport_no']);
	
	$query_passport_no = mysqli_query($con, "SELECT sno, passport_no FROM st_application where passport_no='$passport_no' and `sno` != '$userid'");
	if(mysqli_num_rows($query_passport_no)){
		$msg333 = base64_encode('Academic-Details22');
		$uid333 = base64_encode($userid);
		echo "<script>alert('Passport Number Already Exist!!!'); window.location='application/edit.php?pt=$msg333&apid=$uid333'</script>";
		exit;
	}else{
		mysqli_query($con, "UPDATE `st_application` SET `passport_no` = '$passport_no' WHERE `sno` = '$userid'");
	}
	
	$query_mobile_no = mysqli_query($con, "SELECT sno, mobile FROM st_application where mobile='$mobile' and `sno` != '$userid'");
	if(mysqli_num_rows($query_mobile_no)){
		$msg333 = base64_encode('Academic-Details22');
		$uid333 = base64_encode($userid);
		echo "<script>alert('Mobile Number Already Exist!!!'); window.location='application/edit.php?pt=$msg333&apid=$uid333'</script>";
		exit;
	}else{
		mysqli_query($con, "UPDATE `st_application` SET `mobile` = '$mobile' WHERE `sno` = '$userid'");
	}
	
	$pp_issue_date = mysqli_real_escape_string($con, $_POST['pp_issue_date']);
	$personal_status = $_POST['personal_status'];
	$mother_father_select = $_POST['mother_father_select'];
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
	$editfixed = $_POST['edit'];
	if($editfixed == 'editfixed'){
		$update_query = mysqli_query($con, "update `st_application` set `fname`='$fname',`lname`='$lname', `on_off_shore`='$on_off_shore', `app_show`='$sales_name', `email_address`='$email', `gtitle`='$gtitle', `gender`='$gender', `dob`='$dob', `cntry_brth`='$cntry_brth', `martial_status`='$martial_status', `mother_father_select`='$mother_father_select', `mother_father_name`='$mother_father_name', `emergency_contact_no`='$emergency_contact_no', `address1`='$address1', `address2`='$address2', `country`='$country', `state`='$state', `city`='$city', `pincode`='$pincode', `pp_issue_date`='$pp_issue_date', `pp_expire_date`='$pp_expire_date', `personal_status`='$personal_status', `calling_code`='$calling_code', `calling_cntry_code`='$calling_cntry_code', `emg_cc`='$emg_cc', `emg_cnty_c`='$emg_cnty_c' where `sno`='$userid'");
		$msg = base64_encode('Academic-Details');
		$uid = base64_encode($userid);
		$random = base64_encode(rand());
        header("Location: application/edit.php?pt=$msg&apid=$uid&$random");
	}else{
	  mysqli_query($con, "update `allusers` set `username`='$username'  where `sno`='$userid'");
	  $update_query = mysqli_query($con, "update `st_application` set `fname`='$fname',`lname`='$lname', `on_off_shore`='$on_off_shore', `app_show`='$sales_name', `gtitle`='$gtitle', `gender`='$gender', `dob`='$dob', `cntry_brth`='$cntry_brth', `martial_status`='$martial_status', `mother_father_select`='$mother_father_select', `mother_father_name`='$mother_father_name', `emergency_contact_no`='$emergency_contact_no', `address1`='$address1', `address2`='$address2', `country`='$country', `state`='$state', `city`='$city', `pincode`='$pincode', `pp_issue_date`='$pp_issue_date', `pp_expire_date`='$pp_expire_date',  `personal_status`='$personal_status', `calling_code`='$calling_code', `calling_cntry_code`='$calling_cntry_code', `emg_cc`='$emg_cc', `emg_cnty_c`='$emg_cnty_c' where `user_id`='$userid'"); 
		$msg = base64_encode('Academic-Details');
		$random = base64_encode(rand());
        header("Location: dashboard?pt=$msg&$random");
	}
}

if(isset($_POST['personalAgentbtn'])){
	$lastid1 = $_POST['lastid'];
	$lastid = base64_encode($lastid1);
	$agentid = $_POST['snid'];
	$querysid = "SELECT username FROM allusers where sno='$agentid'";
	$rseultst_id = mysqli_query($con, $querysid);
	$rowstr_2212 = mysqli_fetch_assoc($rseultst_id);
	$agent_name = mysqli_real_escape_string($con, $rowstr_2212['username']);
	
	if(isset($_POST['app_show'])){
		$app_show = $_POST['app_show'];
	}else{
		$app_show = '';
	}
	
	if(!empty($app_show)){
		$sales_name = $app_show;
	}else{
		$result4 = mysqli_query($con, "SELECT admin_access.name, admin_access.admin_id FROM `allusers` INNER JOIN admin_access ON admin_access.admin_id=allusers.created_by_id where allusers.created_by_id!='' AND allusers.sno='$agentid'");
		if(mysqli_num_rows($result4)){
			$row4 = mysqli_fetch_assoc($result4);
			$sales_name = $row4['name'];
		}else{
			$sales_name = '';
		}
	}
	
	$app_type = $_POST['app_type'];
	$app_by = $_POST['app_by'];
	$gtitle = $_POST['gtitle'];
	$on_off_shore = $_POST['on_off_shore'];
	$fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
	
	$calling_code = mysqli_real_escape_string($con, $_POST['calling_code']);
    $calling_cntry_code = mysqli_real_escape_string($con, $_POST['calling_cntry_code']);
	$emg_cc = mysqli_real_escape_string($con, $_POST['emg_cc']);
    $emg_cnty_c = mysqli_real_escape_string($con, $_POST['emg_cnty_c']);
	
	$query_mobile_no = mysqli_query($con, "SELECT sno, mobile FROM st_application where mobile='$mobile'");
	$row_mmno = mysqli_fetch_assoc($query_mobile_no);
	$mobile2 = $row_mmno['mobile'];
	if($mobile2 == $mobile){
		$mobile3 = $mobile2;
	}else{
		$mobile3 = $mobile;
	}	
	
    $email = mysqli_real_escape_string($con, $_POST['email']);
	$gender = mysqli_real_escape_string($con, $_POST['gender']);
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
	$query_passport_no = mysqli_query($con, "SELECT sno, passport_no FROM st_application where passport_no='$passport_no'");
	$row_ppno = mysqli_fetch_assoc($query_passport_no);
	$passport_no2 = $row_ppno['passport_no'];
	if($passport_no2 == $passport_no){
		$passport_no3 = $passport_no2;
	}else{
		$passport_no3 = $passport_no;
	}
	
	
	$mother_father_select = mysqli_real_escape_string($con, $_POST['mother_father_select']);
	if($mother_father_select == 'Mother'){
		$mother_father_name = mysqli_real_escape_string($con, $_POST['mother_name']);
	}
	if($mother_father_select == 'Father'){		
		$mother_father_name = mysqli_real_escape_string($con, $_POST['father_name']);
	}
	$emergency_contact_no = mysqli_real_escape_string($con, $_POST['emergency_contact_no']);
	$pp_issue_date = mysqli_real_escape_string($con, $_POST['pp_issue_date']);
	$pp_expire_date = mysqli_real_escape_string($con, $_POST['pp_expire_date']);

	/*$date2=date_create($pp_issue_date);
	date_add($date2,date_interval_create_from_date_string("10 years"));
	$expire_date = date_format($date2,"Y-m-d");	
	$newdate = strtotime('-1 day' ,strtotime ($expire_date));
	$newdate2 = date ('Y-m-d' , $newdate);	
	$pp_expire_date = $newdate2;*/

	$personal_status = $_POST['personal_status'];
	$created = date('Y-m-d H:i:s');
	if($lastid == ''){
	$inserted =  "INSERT INTO `st_application` (`gtitle`, `on_off_shore`, `app_by`, `agent_type`, agent_name, `user_id`, `app_show`, `fname`, `lname`, `mobile`, `email_address`, `martial_status`, `mother_father_select`, `mother_father_name`, `emergency_contact_no`, `gender`, `dob`, `cntry_brth`, `address1`, `address2`, `country`, `state`, `city`, `pincode`, `passport_no`, `pp_issue_date`, `pp_expire_date`, `personal_status`, `datetime`, `calling_code`, `calling_cntry_code`, `emg_cc`, `emg_cnty_c`) VALUES('$gtitle', '$on_off_shore', '$app_by', '$app_type', '$agent_name', '$agentid', '$sales_name', '$fname', '$lname', '$mobile3', '$email', '$martial_status', '$mother_father_select', '$mother_father_name', '$emergency_contact_no', '$gender', '$dob', '$cntry_brth', '$address1', '$address2', '$country', '$state', '$city', '$pincode', '$passport_no3', '$pp_issue_date', '$pp_expire_date', '$personal_status', '$created', '$calling_code', '$calling_cntry_code', '$emg_cc', '$emg_cnty_c')";
	mysqli_query($con, $inserted);
	$last_id1 = mysqli_insert_id($con);
	$last_id = base64_encode($last_id1);
	$year = date('Y');
	$year_two = substr($year, -2);
	$month = date('m');
	$refid = 'R'.'-'.$last_id1.''.$year_two.''.$month;
	 $update1 = "update `st_application` set `refid`='$refid' where `sno`='$last_id1'";	
	 mysqli_query($con, $update1);
	}	
	if($lastid !== ''){
		$update = "update `st_application` set `gtitle`='$gtitle', `on_off_shore`='$on_off_shore', `app_by`='$app_by', `agent_type`='$app_type', agent_name='$agent_name', `app_show`='$sales_name', `user_id`='$agentid', `fname`='$fname', `lname`='$lname', `mobile`='$mobile3', `email_address`='$email', `martial_status`='$martial_status', `mother_father_select`='$mother_father_select', `mother_father_name`='$mother_father_name', `emergency_contact_no`='$emergency_contact_no', `gender`='$gender', `dob`='$dob', `cntry_brth`='$cntry_brth', `address1`='$address1', `address2`='$address2', `country`='$country', `state`='$state', `city`='$city', `pincode`='$pincode', `passport_no`='$passport_no3', `pp_issue_date`='$pp_issue_date', `pp_expire_date`='$pp_expire_date', `personal_status`='$personal_status', `calling_code`='$calling_code', `calling_cntry_code`='$calling_cntry_code', `emg_cc`='$emg_cc', `emg_cnty_c`='$emg_cnty_c' where `sno`='$lastid1'";
		mysqli_query($con, $update);
		$year = date('Y');
		$year_two = substr($year, -2);
		$month = date('m');
		$refid = 'R'.'-'.$lastid1.''.$year_two.''.$month;	
		$update1 = "update `st_application` set `refid`='$refid' where `sno`='$lastid1'";
		mysqli_query($con, $update1);
	}	
	$msg = base64_encode('Academic-Details');
	$random = base64_encode(rand());
	if($lastid == ''){
		header("Location: dashboard?pt=$msg&last=$last_id&$random");
	}
	if($lastid !== ''){
		header("Location: dashboard?pt=$msg&last=$lastid&$random");
	}
}

if(isset($_POST['academicbtn'])){
	$userid = $_POST['snid'];
	$englishpro = $_POST['englishpro'];
//---ielts
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
	
//---pte	
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
	
//---qualifications1	
	$qualifications1 = $_POST['qualifications1'];
	if($qualifications1 !== ''){
		$stream1 = $_POST['stream1'];
		$cgpa_prcntge1 = $_POST['cgpa_prcntge1'];
		$marks1 = $_POST['marks1'];
		$passing_year1 = $_POST['passing_year1'];
		$unicountry1 = $_POST['unicountry1'];
		$uni_name1 = $_POST['uni_name1'];
	}
//---qualifications2		
	$qualifications2 = $_POST['qualifications2'];	
	if($qualifications2 !== ''){
		$stream2 = $_POST['stream2'];
		$cgpa_prcntge2 = $_POST['cgpa_prcntge2'];
		$marks2 = $_POST['marks2'];
		$passing_year2 = $_POST['passing_year2'];
		$unicountry2 = $_POST['unicountry2'];
		$uni_name2 = $_POST['uni_name2'];
	}else{
		$stream2 = '';
		$cgpa_prcntge2 = '';
		$passing_year2 = '';
		$unicountry2 = '';
		$uni_name2 = '';
	}
//---qualifications3	
	$qualifications3 = $_POST['qualifications3'];
	if($qualifications3 !== ''){
		$stream3 = $_POST['stream3'];
		$cgpa_prcntge3 = $_POST['cgpa_prcntge3'];
		$marks3 = $_POST['marks3'];
		$passing_year3 = $_POST['passing_year3'];
		$unicountry3 = $_POST['unicountry3'];
		$uni_name3 = $_POST['uni_name3'];
	}else{
		$stream3 = '';
		$cgpa_prcntge3 = '';
		$marks3 = '';
		$passing_year3 = '';
		$unicountry3 = '';
		$uni_name3 = '';
	}
	
	$passing_year_gap_2 = $_POST['passing_year_gap'];
	$gap_status = $_POST['gap_status'];
	$crnt_year = date('Y');	

	if($passing_year_gap_2 == $crnt_year){
		$passing_year_gap = $passing_year_gap_2;
		$passing_justify_gap = '';
		$gap_duration_2 = '';
		$gap_other = '';
	}else{
		$passing_year_gap = $passing_year_gap_2;
		$passing_justify_gap_2 = $_POST['passing_justify_gap'];
		
		if($passing_justify_gap_2 == ''){
			$passing_justify_gap = '';
			$gap_duration_2 = '';
			$gap_other = '';	
		}

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
					
	$academic_status = $_POST['academic_status'];
	$editfixed = $_POST['edit'];
	
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
			unlink("uploads/$ielts_file2");
		}
		mysqli_query($con, "update `st_application` set `ielts_file`='' where `sno`='$userid'");
	}
	
	
	if($editfixed == 'editfixed'){
		if($englishpro == 'ielts' || $englishpro == 'Toefl'){
			if(!empty($pte_file2)){
				unlink("uploads/$pte_file2");
			}
			if(!empty($duolingo_file2)){
				unlink("uploads/$duolingo_file2");
			}
			
		$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='$ieltsover',`ieltsnot`='$ieltsnot',`ielts_listening`='$ielts_listening',`ielts_reading`='$ielts_reading',`ielts_writing`='$ielts_writing',`ielts_speaking`='$ielts_speaking',`ielts_date`='$ielts_date', `pteover`='', `ptenot`='', `pte_listening`='', `pte_reading`='', `pte_writing`='', `pte_speaking`='', `pte_date`='', `pte_file`='', `pte_username`='', `pte_password`='', `duolingo_score`='', `duolingo_date`='', `duolingo_file`='', `qualification1`='$qualifications1', `stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");
	}
		
	if($englishpro == 'pte'){
			if(!empty($ielts_file2)){
				unlink("uploads/$ielts_file2");
			}
			if(!empty($duolingo_file2)){
				unlink("uploads/$duolingo_file2");
			}
			
		$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='',`ieltsnot`='',`ielts_listening`='',`ielts_reading`='',`ielts_writing`='',`ielts_speaking`='',`ielts_date`='',`ielts_file`='',`pteover`='$pteover',`ptenot`='$ptenot',`pte_listening`='$pte_listening',`pte_reading`='$pte_reading',`pte_writing`='$pte_writing',`pte_speaking`='$pte_speaking',`pte_date`='$pte_date', `pte_username`='$pte_username', `pte_password`='$pte_password', `duolingo_score`='', `duolingo_date`='', `duolingo_file`='', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");
	}
		
		if($englishpro == 'duolingo'){
			if(!empty($ielts_file2)){
				unlink("uploads/$ielts_file2");
			}
			if(!empty($pte_file2)){
				unlink("uploads/$pte_file2");
			}			
			
			$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='',`ieltsnot`='',`ielts_listening`='',`ielts_reading`='',`ielts_writing`='',`ielts_speaking`='',`ielts_date`='',`ielts_file`='',`pteover`='',`ptenot`='',`pte_listening`='',`pte_reading`='',`pte_writing`='',`pte_speaking`='',`pte_date`='',`pte_file`='', `pte_username`='', `pte_password`='', `duolingo_score`='$duolingo_score', `duolingo_date`='$duolingo_date',  `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2',  `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");
	}		
		$msg = base64_encode('Academic-Details-Docs');		// $msg = base64_encode('Course-Details');
		$uid = base64_encode($userid);
		$random = base64_encode(rand());
		header("Location: application/edit.php?pt=$msg&apid=$uid&$random");
	}else{
		
	if($englishpro == 'ielts' || $englishpro == 'Toefl'){
		$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='$ieltsover',`ieltsnot`='$ieltsnot',`ielts_listening`='$ielts_listening',`ielts_reading`='$ielts_reading',`ielts_writing`='$ielts_writing', `ielts_speaking`='$ielts_speaking',`ielts_date`='$ielts_date', `pteover`='', `ptenot`='', `pte_listening`='', `pte_reading`='', `pte_writing`='', `pte_speaking`='', `pte_date`='', `pte_username`='', `pte_password`='', `duolingo_score`='', `duolingo_date`='', `duolingo_file`='', `qualification1`='$qualifications1', `stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1',  `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");
	}
		
	if($englishpro == 'pte'){
		$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='',`ieltsnot`='',`ielts_listening`='',`ielts_reading`='',`ielts_writing`='',`ielts_speaking`='',`ielts_date`='',`pteover`='$pteover',`ptenot`='$ptenot',`pte_listening`='$pte_listening',`pte_reading`='$pte_reading',`pte_writing`='$pte_writing',`pte_speaking`='$pte_speaking',`pte_date`='$pte_date', `pte_username`='$pte_username', `pte_password`='$pte_password', `duolingo_score`='', `duolingo_date`='', `duolingo_file`='', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");	
	}
		
	if($englishpro == 'duolingo'){
		$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='',`ieltsnot`='',`ielts_listening`='',`ielts_reading`='',`ielts_writing`='',`ielts_speaking`='',`ielts_date`='',`pteover`='', `ptenot`='', `pte_listening`='', `pte_reading`='', `pte_writing`='', `pte_speaking`='', `pte_date`='', `pte_username`='', `pte_password`='', `duolingo_score`='$duolingo_score', `duolingo_date`='$duolingo_date', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid'");	
	}
		
		// $msg = base64_encode('Course-Details');
		$msg = base64_encode('Academic-Details-Docs');
		$random = base64_encode(rand());
		header("Location: dashboard?pt=$msg&$random"); 
	}	
}

if(isset($_POST['academicAgentbtn'])){
	$userid = $_POST['lastid'];
	$userid1 = base64_decode($userid);
	$qualifications1 = $_POST['qualifications1'];
	$stream1 = $_POST['stream1'];
	$marks1 = $_POST['marks1'];
	$passing_year1 = $_POST['passing_year1'];
	$unicountry1 = $_POST['unicountry1'];
	$uni_name1 = $_POST['uni_name1'];
	
	$qualifications2 = $_POST['qualifications2'];
	$stream2 = $_POST['stream2'];
	$marks2 = $_POST['marks2'];
	$passing_year2 = $_POST['passing_year2'];
	$unicountry2 = $_POST['unicountry2'];
	$name2 = $_FILES['certificate2']['name'];
	$tmp2 = $_FILES['certificate2']['tmp_name'];
	$uni_name2 = $_POST['uni_name2'];
	
	$qualifications3 = $_POST['qualifications3'];
	$stream3 = $_POST['stream3'];
	$marks3 = $_POST['marks3'];
	$passing_year3 = $_POST['passing_year3'];
	$unicountry3 = $_POST['unicountry3'];
	$name3 = $_FILES['certificate3']['name'];
	$tmp3 = $_FILES['certificate3']['tmp_name'];
	$uni_name3 = $_POST['uni_name3'];					
	$academic_status = $_POST['academic_status'];	
	$englishpro = $_POST['englishpro'];
	
	$passing_year_gap_2 = $_POST['passing_year_gap'];
	$gap_status = $_POST['gap_status'];
	$cgpa_prcntge1 = $_POST['cgpa_prcntge1'];
	$cgpa_prcntge2 = $_POST['cgpa_prcntge2'];
	$cgpa_prcntge3 = $_POST['cgpa_prcntge3'];
	$crnt_year = date('Y');

	if($passing_year_gap_2 == $crnt_year){
		$passing_year_gap = $passing_year_gap_2;
		$passing_justify_gap = '';
		$gap_duration_2 = '';
		$gap_other = '';	

	}else{
		$passing_year_gap = $passing_year_gap_2;
		$passing_justify_gap_2 = $_POST['passing_justify_gap'];	
		
		if($passing_justify_gap_2 == ''){
			$passing_justify_gap = '';
			$gap_duration_2 = '';
			$gap_other = '';
		}		

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
	
	$rsltqry = "SELECT englishpro, ielts_file, pte_file, duolingo_file FROM st_application WHERE sno = '$userid1'";
	$result = mysqli_query($con, $rsltqry);
	$row = mysqli_fetch_assoc($result);
	$englishpro2 = mysqli_real_escape_string($con, $row['englishpro']);
	$ielts_file2 = mysqli_real_escape_string($con, $row['ielts_file']);
	$pte_file2 = mysqli_real_escape_string($con, $row['pte_file']);
	$duolingo_file2 = mysqli_real_escape_string($con, $row['duolingo_file']);
	
	if($englishpro2 == $englishpro){		
	}else{
		if(!empty($ielts_file2)){
			unlink("uploads/$ielts_file2");
		}
		mysqli_query($con, "update `st_application` set `ielts_file`='' where `sno`='$userid1'");
	}
	
	if($englishpro == 'ielts' || $englishpro == 'Toefl'){
	
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
	
	if(!empty($pte_file2)){
		unlink("uploads/$pte_file2");
	}
	if(!empty($duolingo_file2)){
		unlink("uploads/$duolingo_file2");
	}	
	
	mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='$ieltsover',`ieltsnot`='$ieltsnot',`ielts_listening`='$ielts_listening',`ielts_reading`='$ielts_reading',`ielts_writing`='$ielts_writing',`ielts_speaking`='$ielts_speaking',`ielts_date`='$ielts_date', `pteover`='', `ptenot`='', `pte_listening`='', `pte_reading`='', `pte_writing`='', `pte_speaking`='',`pte_date`='', `pte_username`='', `pte_password`='',`pte_file`='', `duolingo_score`='', `duolingo_date`='', `duolingo_file`='', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid1'");
	}
	
	if($englishpro == 'pte'){
		if(!empty($ielts_file2)){
			unlink("uploads/$ielts_file2");
		}
		if(!empty($duolingo_file2)){
			unlink("uploads/$duolingo_file2");
		}	
		
	$pteover = $_POST['pteover'];
	$ptenot = $_POST['ptenot'];
	$pte_listening = $_POST['pte_listening'];
	$pte_reading = $_POST['pte_reading'];
	$pte_writing = $_POST['pte_writing'];
	$pte_speaking = $_POST['pte_speaking'];
	$pte_date = $_POST['pte_date'];
	$pte_username = $_POST['pte_username'];
	$pte_password = $_POST['pte_password'];
	
	mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='',`ieltsnot`='',`ielts_listening`='',`ielts_reading`='',`ielts_writing`='',`ielts_speaking`='',`ielts_date`='',`ielts_file`='',`pteover`='$pteover',`ptenot`='$ptenot',`pte_listening`='$pte_listening',`pte_reading`='$pte_reading',`pte_writing`='$pte_writing',`pte_speaking`='$pte_speaking',`pte_date`='$pte_date', `pte_username`='$pte_username', `pte_password`='$pte_password', `duolingo_score`='', `duolingo_date`='', `duolingo_file`='', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid1'");
	}
	
	if($englishpro == 'duolingo'){
	$duolingo_score = $_POST['duolingo_score'];
	$duolingo_date = $_POST['duolingo_date'];
	
	if(!empty($ielts_file2)){
		unlink("uploads/$ielts_file2");
	}
	if(!empty($pte_file2)){
		unlink("uploads/$pte_file2");
	}	
	
	mysqli_query($con, "update `st_application` set `englishpro`='$englishpro', `ieltsover`='', `ieltsnot`='', `ielts_listening`='', `ielts_reading`='', `ielts_writing`='', `ielts_speaking`='', `ielts_date`='', `ielts_file`='', `pteover`='', `ptenot`='', `pte_listening`='', `pte_reading`='', `pte_writing`='', `pte_speaking`='', `pte_date`='', `pte_file`='', `duolingo_score`='$duolingo_score', `duolingo_date`='$duolingo_date', `qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `uni_name3`='$uni_name3', `academic_status`='$academic_status', `passing_year_gap`='$passing_year_gap', `passing_justify_gap`='$passing_justify_gap', `gap_duration`='$gap_duration_2',`gap_other`='$gap_other', `cgpa_prcntge1`='$cgpa_prcntge1', `cgpa_prcntge2`='$cgpa_prcntge2',`cgpa_prcntge3`='$cgpa_prcntge3' where `sno`='$userid1'");
	}
	
	$msg = base64_encode('Academic-Details-Docs');
	// $msg = base64_encode('Course-Details');
	$random = base64_encode(rand());
    header("Location: dashboard?pt=$msg&last=$userid&$random");
}

if(isset($_POST['coursebtn'])){	
	$userid = $_POST['snid'];
	$campus = $_POST['campus'];	
	$prg_name1 = $_POST['prg_name1'];	
	$prg_intake = $_POST['intake'];
	$course_status = $_POST['course_status'];
	$editfixed = $_POST['edit'];
	if($editfixed == 'editfixed'){
		$update_query = mysqli_query($con, "update `st_application` set `campus`='$campus', `prg_name1`='$prg_name1', `prg_intake`='$prg_intake', `course_status`='$course_status' where `sno`='$userid'");
	   //if($update_query){ 
		$msg = base64_encode('Application-Details');
		$uid = base64_encode($userid);
		$random = base64_encode(rand());
        header("Location: application/edit.php?pt=$msg&apid=$uid&$random"); 
       //}
	}else{
	$update_query = mysqli_query($con, "update `st_application` set `campus`='$campus', `prg_name1`='$prg_name1', `prg_intake`='$prg_intake', `course_status`='$course_status' where `user_id`='$userid'");
	//if($update_query){ 
	$msg = base64_encode('Application-Details');
	$random = base64_encode(rand());
    header("Location: dashboard?pt=$msg&$random"); 
    //}
	}
}

if(isset($_POST['courseAgentbtn'])){	
	$userid = $_POST['lastid'];
	$userid1 = base64_decode($userid);
	$campus = $_POST['campus'];	
	$prg_name1 = $_POST['prg_name1'];	
	$prg_intake = $_POST['intake'];
	$course_status = $_POST['course_status'];
	$update_query = mysqli_query($con, "update `st_application` set `campus`='$campus', `prg_name1`='$prg_name1', `prg_intake`='$prg_intake', `course_status`='$course_status' where `sno`='$userid1'");
	if($update_query){ 
	$msg = base64_encode('Application-Details');
	$random = base64_encode(rand());
        header("Location: dashboard?pt=$msg&last=$userid&$random"); 
    }
}

if(isset($_POST['smtapplctnbtn'])){
	$userid = $_POST['snid'];
	$application_form = $_POST['application_form'];
	$editfixed = $_POST['edit'];
	
	$result = mysqli_query($con,"SELECT sno,app_by,user_id,refid,fname,lname,application_form FROM st_application WHERE sno='$userid'");
	$row = mysqli_fetch_assoc($result);
	$sno = $row['sno'];
	$agent_type = $row['app_by'];
	$agent_id = $row['user_id'];
	$refid = $row['refid'];
	$fullname = $row['fname'].' '.$row['lname'];
	
	$application_form2 = $row['application_form'];
	if(empty($application_form2)){
		$dateupdate = " , datetime = '$follow_datetime'";
	}else{
		$dateupdate = '';
	}
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'excu', '$sno', '$fullname', '$agent_id', '$refid', 'New Application Created', 'Application Created', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$follow_datetime')");
	
	if($editfixed == 'editfixed'){
		$update_query = mysqli_query($con, "update `st_application` set `application_form`='$application_form' $dateupdate where `sno`='$userid'");
	   if($update_query){ 
		$msg = base64_encode('Application-Details');
		$uid = base64_encode($userid);
		$random = base64_encode(rand());
        header("Location: application?apid=$uid&$random&msgLoad=Success"); 
       }
	}else{
	$update_query = mysqli_query($con, "update `st_application` set `application_form`='$application_form' $dateupdate where `sno`='$userid'");
	if($update_query){ 
	$msg = base64_encode('Application-Details');
	$random = base64_encode(rand());
        header("Location: application/?pt=$msg&$random&msgLoad=Success"); 
    }
	}
}

if(isset($_POST['applctnAgentbtn'])){
	$userid = $_POST['lastid'];
	$userid1 = base64_decode($userid);
	$application_form = $_POST['application_form'];
	$date = date('Y-m-d H:i:s');
	$update_query = mysqli_query($con, "update `st_application` set `application_form`='$application_form' where `sno`='$userid1'");
	
	$result = mysqli_query($con,"SELECT sno,app_by,user_id,refid,fname,lname FROM st_application WHERE sno='$userid1'");
	$row = mysqli_fetch_assoc($result);
	$sno = $row['sno'];
	$agent_type = $row['app_by'];
	$agent_id = $row['user_id'];
	$refid = $row['refid'];
	$fullname = $row['fname'].' '.$row['lname'];
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'excu', '$sno', '$fullname', '$agent_id', '$refid', 'New Application Created', 'Application Created', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");
	
	$msg = base64_encode('Application-Details');
	$random = base64_encode(rand());
    header("Location: application?pt=$msg&last=$userid&$random&msgLoad=Success");   
}

if(isset($_POST['agreeBtn'])){
	$snoid = $_POST['snoid'];
	$name3 = $_FILES['agreement']['name'];
	$tmp3 = $_FILES['agreement']['tmp_name'];
	$file_type = $_FILES['agreement']['type'];
	$filename = str_replace(' ', '', $name3);	
	$file_ext=strtolower(end(explode('.',$_FILES['agreement']['name'])));	
	$expensions= array("pdf","jpg","PDF","JPG","jpeg","JPEG");	
	if(in_array($file_ext,$expensions)=== false){
         $imgMsg = base64_encode('ImageAgreementUpload');
		header("Location: application?msgagree=$imgMsg");
    }
	
	$agreement_size = $_FILES['agreement']['size'];
	if($agreement_size <= '3145728'){
		
	}else{
		$imgMsg = base64_encode('ImageSizeAgreementUpload');
		echo "<script>alert('File too large. File must be less than 3 MB.'); window.location='application?aid=error_$snoid&mb=3&msgagree=$imgMsg'</script>";
		exit;
	}	
	
	if(in_array($file_ext,$expensions)=== true){
	$date = date('Y-m-d H:i:s');
	$delete_foldr=mysqli_query($con, "SELECT sno,app_by,user_id,refid,fname,lname,agreement,follow_stage FROM st_application where sno='$snoid'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	$docimage1 = $dltlist['agreement'];
	$follow_stage = $dltlist['follow_stage'];
	if(!empty($docimage1)){
		unlink("uploads/$docimage1");
	}
	$img_name3 = date('YmdHis').'_'.$filename;
	move_uploaded_file($tmp3, 'uploads/'.$img_name3);
	
	// if($follow_stage == 'Conditional_Offer_letter'){
		// $stage = ", `follow_status`='0'";
	// }elseif($follow_stage == 'LOA_Request'){
		// $stage = ", `follow_status`='0'";
	// }elseif($follow_stage == 'Contract_Stage'){
		// $stage = ", `follow_status`='0'";
	// }else{
		// $stage = '';
	// }	
	
	// mysqli_query($con, "update `st_application` set `agreement`='$img_name3', `agent_col_datetime`='$date' $stage where `sno`='$snoid'");
	
	mysqli_query($con, "update `st_application` set `agreement`='$img_name3', `agent_col_datetime`='$date' where `sno`='$snoid'");
	
	$sno = $dltlist['sno'];
	$agent_type = $dltlist['app_by'];
	$agent_id = $dltlist['user_id'];
	$refid = $dltlist['refid'];
	$fullname = $dltlist['fname'].' '.$dltlist['lname'];
	
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'excu', '$sno', '$fullname', '$agent_id', '$refid', 'Signed Conditional Offer Letter Uploaded', 'Signed Conditional Offer Letter', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");	
	
//Followup
	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$snoid' AND fstage='$follow_stage' order by sno asc";
	$flowRsltQury = mysqli_query($con, $flowQury);
	$flowList = mysqli_fetch_assoc($flowRsltQury);
	$fsno = $flowList['sno'];
	$fstage = $flowList['fstage'];
	// if(!empty($fstage)){
		// mysqli_query($con, "update `followup` set `updated`='$date' where `sno`='$fsno'");
	// }
	// mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$snoid'");
	
	$imgMsg = base64_encode('SuccessAgreementUpload');
	header("Location: application?aid=error_$snoid&smsgAgree=$imgMsg");
	}	
}


if(isset($_POST['salbtn'])){	
	$snoid = $_POST['rcptid'];
	$name3 = $_FILES['safile']['name'];
	$tmp3 = $_FILES['safile']['tmp_name'];
	$file_type = $_FILES['safile']['type'];
	$filename = str_replace(' ', '', $name3);
	
	$safile_size = $_FILES['safile']['size'];
	if($safile_size <= '5242880'){
		
	}else{
		$imgMsg = base64_encode('ImageSizeAgreementUpload');
		echo "<script>alert('File too large. File must be less than 5 MB.'); window.location='application?aid=error_$snoid&mb=5&msgagree=$imgMsg'</script>";
		exit;
	}
	
	$file_ext=strtolower(end(explode('.',$_FILES['safile']['name'])));	
	$expensions= array("pdf","PDF");	
	if(in_array($file_ext,$expensions)=== false){
         $imgMsg = base64_encode('ImageAgreementUpload');
		header("Location: application?msgagree=$imgMsg");
    }	
	$date = date('Y-m-d H:i:s');
	if(in_array($file_ext,$expensions)=== true){
	$delete_foldr=mysqli_query($con, "SELECT sno,app_by,user_id,refid,fname,lname,signed_agreement_letter,follow_stage FROM st_application where sno='$snoid'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	$docimage1 = $dltlist['signed_agreement_letter'];
	$follow_stage = $dltlist['follow_stage'];
	unlink("uploads/$docimage1");
	$img_name3 = date('YmdHis').'_'.$filename;
	move_uploaded_file($tmp3, 'uploads/'.$img_name3);
	
	// if($follow_stage == 'Conditional_Offer_letter'){
		// $stage = ", `follow_status`='0'";
	// }elseif($follow_stage == 'LOA_Request'){
		// $stage = ", `follow_status`='0'";
	// }elseif($follow_stage == 'Contract_Stage'){
		// $stage = ", `follow_status`='0'";
	// }else{
		// $stage = '';
	// }
	
	
	mysqli_query($con, "update `st_application` set `signed_agreement_letter`='$img_name3',`agent_aol_contract_datetime`='$date' where `sno`='$snoid'");
	
	$sno = $dltlist['sno'];
	$agent_type = $dltlist['app_by'];
	$agent_id = $dltlist['user_id'];
	$refid = $dltlist['refid'];
	$fullname = $dltlist['fname'].' '.$dltlist['lname'];	
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'admin', '$sno', '$fullname', '$agent_id', '$refid', 'Signed Contract Uploaded', 'Signed Contract', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");	
	
//Followup
	$flowQury = "SELECT sno,fstage FROM followup where st_app_id='$snoid' AND fstage='$follow_stage' order by sno asc";
	
	$flowRsltQury = mysqli_query($con, $flowQury);
	$flowList = mysqli_fetch_assoc($flowRsltQury);
	$fsno = $flowList['sno'];
	$fstage = $flowList['fstage'];
	// if(!empty($fstage)){
		// mysqli_query($con, "update `followup` set `updated`='$date' where `sno`='$fsno'");
	// }

	// mysqli_query($con, "update `followup` set `fstatus`='0' where `st_app_id`='$snoid'");
	
		$imgMsg = base64_encode('SuccessAgreementUpload');
		header("Location: application?aid=error_$snoid&smsgAgree=$imgMsg");
	}
}


if(isset($_POST['signedHBbtn'])){	
	$snoid = $_POST['snoid'];
	$name3 = $_FILES['shbfile']['name'];
	$tmp3 = $_FILES['shbfile']['tmp_name'];
	$file_type = $_FILES['shbfile']['type'];
	$filename = str_replace(' ', '', $name3);
	
	$file_ext=strtolower(end(explode('.',$_FILES['shbfile']['name'])));	
	$expensions= array("pdf","PDF");	
	if(in_array($file_ext,$expensions)=== false){
         $imgMsg = base64_encode('ImageAgreementUpload');
		header("Location: application?msgagree=$imgMsg");
    }

	$shbfile_size = $_FILES['shbfile']['size'];
	if($shbfile_size <= '5242880'){
		
	}else{
		$imgMsg = base64_encode('ImageSizeAgreementUpload');
		echo "<script>alert('File too large. File must be less than 5 MB.'); window.location='application?aid=error_$snoid&mb=5&msgagree=$imgMsg'</script>";
		exit;
	}
	
	$date = date('Y-m-d H:i:s');
	if(in_array($file_ext,$expensions)=== true){
	$delete_foldr=mysqli_query($con, "SELECT sno,app_by,user_id,refid,fname,lname,contract_handbook_signed FROM st_application where sno='$snoid'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	$docimage1 = $dltlist['contract_handbook_signed'];
	unlink("uploads/$docimage1");
	$img_name3 = date('YmdHis').'_'.$filename;
	move_uploaded_file($tmp3, 'uploads/'.$img_name3);
	
	mysqli_query($con, "update `st_application` set `contract_handbook_signed`='$img_name3',`contract_handbook_signed_datetime`='$date' where `sno`='$snoid'");
	
	$sno = $dltlist['sno'];
	$agent_type = $dltlist['app_by'];
	$agent_id = $dltlist['user_id'];
	$refid = $dltlist['refid'];
	$fullname = $dltlist['fname'].' '.$dltlist['lname'];	
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'admin', '$sno', '$fullname', '$agent_id', '$refid', 'Signed Handbook Uploaded', 'Signed Handbook', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");	

		$imgMsg = base64_encode('SuccessAgreementUpload');
		header("Location: application?aid=error_$snoid&smsgAgree=$imgMsg");
	}
}


if(isset($_POST['agentVRStatus'])){
	$userid = $_POST['snid'];
	$file_upload_vr_remarks = $_POST['file_upload_vr_remarks'];
	$date = date('Y-m-d H:i:s');		
	
	$update_query = mysqli_query($con, "update `st_application` set `file_upload_vr_remarks`='$file_upload_vr_remarks',`file_upload_vr_datetime`='$date' where `sno`='$userid'");
	
	$result = mysqli_query($con,"SELECT sno,app_by,user_id,refid,fname,lname,file_upload_vgr,file_upload_vgr2,file_upload_vgr3 FROM st_application WHERE sno='$userid'");
	$row = mysqli_fetch_assoc($result);
	$sno = $row['sno'];
	$agent_type = $row['app_by'];
	$agent_id = $row['user_id'];
	$refid = $row['refid'];
	$fullname = $row['fname'].' '.$row['lname'];
	$file_upload_vgr = $row['file_upload_vgr'];	
	$file_upload_vgr2 = $row['file_upload_vgr2'];	
	$file_upload_vgr3 = $row['file_upload_vgr3'];
	
	// $result_11 = mysqli_query($con,"SELECT username FROM allusers WHERE sno='$agent_id'");
	// $row_11 = mysqli_fetch_assoc($result_11);
	// $username = $row_11['username'];
	
	if($file_upload_vgr !='' && $file_upload_vgr2 !='' && $file_upload_vgr3 !=''){
	mysqli_query($con, "update `st_application` set `file_upload_vr_status`='Yes' where `sno`='$userid'");
	}
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'excu', '$sno', '$fullname', '$agent_id', '$refid', 'Refund Docs Send By - ', 'Refund Form', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");
	
	$random = base64_encode(rand());
    header("Location: application?aid=error_$userid&$random");   
}

if(isset($_POST['loaRqstbtn'])){
	$idno = $_POST['idno'];	
	$name1 = $_FILES['loa_tt']['name'];
	$random = base64_encode(rand());
	
	if(!empty($name1)){
	$tmp1 = $_FILES['loa_tt']['tmp_name'];
	// $loa_tt_remarks = mysqli_real_escape_string($con, $_POST['loa_tt_remarks']);
	$extension = pathinfo($name1, PATHINFO_EXTENSION);	
	
	if($extension=='pdf'  || $extension=='PDF'|| $extension=='zip' || $extension=='rar' || $extension=='jpg' || $extension=='JPG' || $extension=='PNG' || $extension=='png'){	
	
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
		unlink("uploads/$loa_tt");
	}
	$firstname = str_replace(' ', '', $fullname);
	$img_name1 = 'Rqst_LOA_TT'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
	move_uploaded_file($tmp1, 'uploads/'.$img_name1);
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'admin', '$sno', '$fullname', '$agent_id', '$refid', 'LOA Requested', 'LOA Request', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('Admin', '$sno', '$fullname', '$agent_id', '$refid', 'TT Receipt', 'TT Receipt', 'report/loa_receipt.php?aid=error_$sno', '1', '$date', 'Yes')");
	
	mysqli_query($con, "update `st_application` set `file_receipt`='1', `loa_tt`='$img_name1',  `agent_request_loa_datetime`='$date', follow_status='0' where `sno`='$idno'");

	// mysqli_query($con, "DELETE FROM `without_tt` WHERE `st_app_id`='$idno'");

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
	 
	 header("Location: application?aid=error_$idno&$random"); 
	 
	}else{
		header("Location: application?aid=error_$idno&$random");
	}
	
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
		unlink("uploads/$loa_tt");
	}
	
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
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'admin', '$sno', '$fullname', '$agent_id', '$refid', 'LOA Requested', 'LOA Request', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");
	
	//// mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('Admin', '$sno', '$fullname', '$agent_id', '$refid', 'TT Receipt', 'TT Receipt', 'report/loa_receipt.php?aid=error_$sno', '1', '$date', 'Yes')");
	
	mysqli_query($con, "update `st_application` set `file_receipt`='1', `loa_tt`='',  `agent_request_loa_datetime`='$date', follow_status='0' where `sno`='$idno'");	

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
	
	header("Location: application?aid=error_$idno&$random");
	}	
	
}

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	header("Location: application?getsearch=$search&page_no=1&srchstatus=&roletype=All&subid=&rowbg=");
}

if(isset($_POST['qrnPlanbtn'])){
	$snoid = $_POST['idno'];
	
	$name1 = $_FILES['quarantine_plan']['name'];
	$tmp1 = $_FILES['quarantine_plan']['tmp_name'];	
	$delete_foldr = mysqli_query($con, "SELECT * FROM st_application where sno='$snoid'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);	
	$quarantine_plan = $dltlist['quarantine_plan'];
	$fname = $dltlist['fname'];
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);
	$agent_type = $dltlist['app_by'];
	$agent_id = $dltlist['user_id'];
	$fullname = $dltlist['fname'].' '.$dltlist['lname'];	

	$uid = base64_encode($snoid);
	$date = date('Y-m-d H:i:s');
	$created_date = date('Y-m-d');	
	$created_time = date('H:i:s');

	if($name1 == ''){	
		$img_name1 = $quarantine_plan;	
	}else{
		$extension = pathinfo($name1, PATHINFO_EXTENSION);
		if($extension=='pdf'  || $extension=='PDF' || $extension=='PNG' || $extension=='png' || $extension=='jpg' || $extension=='jpg' || $extension=='jpeg' || $extension=='JPEG'){
			if(!empty($quarantine_plan)){
				unlink("uploads/$quarantine_plan");
			}
			$img_name1 = 'Q_Plan_'.$firstname.'_'.$refid.'.'.$extension;
			move_uploaded_file($tmp1, 'uploads/'.$img_name1);
		}else{ 
			$imgMsg = base64_encode('ImageQuarantineUpload');
			echo "<script>alert('File is not Supported (Please upload the JPG, PNG and PDF File)'); window.location='application/?aid=$uid&msgagree=$imgMsg'</script>";
			exit;
		}
	}

	$updated_app = "update `st_application` set `quarantine_plan`='$img_name1',`quarantine_datetime`='$date', `last_updated_at`='$date' where `sno`='$snoid'";
	mysqli_query($con, $updated_app);

	$msg = base64_encode('Sined-Quarantine-Letter');
	$random = base64_encode(rand());
	header("Location: application/?aid=error_$snoid&$random&$msg");
}

if(isset($_POST['agentStuTravelbtn'])){
	$userid = $_POST['snid'];
	$date = date('Y-m-d H:i:s');	

	$update_query = mysqli_query($con, "update `st_application` set `stu_travel_updated_date`='$date', last_updated_at='$date' where `sno`='$userid'");	

	$result = mysqli_query($con,"SELECT sno,app_by,user_id,refid,fname,lname FROM st_application WHERE sno='$userid'");
	$row = mysqli_fetch_assoc($result);
	$sno = $row['sno'];
	$agent_type = $row['app_by'];
	$agent_id = $row['user_id'];
	$refid = $row['refid'];
	$fullname = $row['fname'].' '.$row['lname'];

	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'excu', '$sno', '$fullname', '$agent_id', '$refid', 'Students Travelling Docs Uploaded ', 'Students Travelling', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");

	$random = base64_encode(rand());
	header("Location: application?aid=error_$userid&$random");
}

if(isset($_POST['comRefundBtn'])){
	$userid = $_POST['snid'];
	$comrefund_remarks = $_POST['comrefund_remarks'];
	$v_g_r_amount = $_POST['v_g_r_amount'];
	$tab1 = '';
	
	$name3 = $_FILES['v_g_r_invoice']['name'];
	$tmp3 = $_FILES['v_g_r_invoice']['tmp_name'];	

	$qry = mysqli_query($con, "SELECT sno, app_by, user_id, refid, fname, lname, v_g_r_status, v_g_r_invoice FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$agent_id = $uid1['user_id'];
	$agent_type = $uid1['app_by'];
	$refid = $uid1['refid'];
	$v_g_r_invoice1 = $uid1['v_g_r_invoice'];
	$v_g_r_status = $uid1['v_g_r_status'];
	$fname2 = $uid1['fname'];
	$fullname = $fname2.' '.$uid1['lname'];
	$fnames = str_replace(' ', '_', $fname2);
	$uid = base64_encode($userid);
	$follow_datetime = date('Y-m-d H:i:s');
	
	if($name3 == ''){
		$img_name3 = $v_g_r_invoice1;
	}else{
		$extension = pathinfo($name3, PATHINFO_EXTENSION);
		if($extension=='pdf' || $extension=='PDF' || $extension=='JPG' || $extension=='jpg' || $extension=='jpeg' || $extension=='JPEG'){
			if($v_g_r_invoice1 !==''){
				unlink("uploads/$v_g_r_invoice1");
			}
			$img_name3 = $fnames.'_'.$v_g_r_status.'_Invoice_'.$refid.'_'.date('mdis').'.'.$extension;
			move_uploaded_file($tmp3, 'uploads/'.$img_name3);	
		}else{
			$imgMsg = base64_encode('ImageUpload');
			echo "<script>alert('File is not Supported (Please upload the PDF and JPG Files)'); window.location='application?imgMsg=$imgMsg&did=$agent_id&aid=error_$userid&apid=$uid$tab1'</script>";
			exit;
		}
	}
	mysqli_query($con, "update `st_application` set `comrefund_remarks`='$comrefund_remarks', `v_g_r_amount`='$v_g_r_amount', `v_g_r_invoice`='$img_name3', `com_refund_datetime`='$follow_datetime', `commission_updated_by_name`='$Loggedemail', last_updated_at='$follow_datetime' where `sno`='$userid'");	
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'excu', '$userid', '$fullname', '$agent_id', '$refid', 'Commission Details Updated', 'COMMISSION Details', '../backend/application?did=$uid&aid=error_$userid', '1', '$follow_datetime')");
	
	$msg = base64_encode('Application-Details');
	header("Location: application?pt=$msg&did=$agent_id&aid=error_$userid&apid=$uid$tab1");
}

if(isset($_POST['vgrBtn'])){
	$userid = $_POST['snid'];
	$v_g_r_status = $_POST['v_g_r_status'];	

	if (isset($_POST['vg_date'])) {
		$vg_date = $_POST['vg_date'];
	} else {
		$vg_date = '';
	}

	$qry = mysqli_query($con, "SELECT sno, app_by, user_id, refid, fname, lname, follow_stage, vg_file, v_g_r_status_datetime, v_g_r_crnt_amnt FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$agent_id = $uid1['user_id'];
	$agent_type = $uid1['app_by'];
	$follow_stage = $uid1['follow_stage'];
	$docimage1 = $uid1['vg_file'];
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$fname2 = $uid1['fname'];
	$fullname = $fname2.' '.$uid1['lname'];
	$uid = base64_encode($userid);
	$follow_datetime = date('Y-m-d H:i:s');
	$tab1 = '';
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

	if (isset($_FILES['vg_file'])) {
		$vg_file = $_FILES['vg_file']['name'];
		$vg_tmp = $_FILES['vg_file']['tmp_name'];
		$file_type = $_FILES['vg_file']['type'];
		$vg_file_size = $_FILES['vg_file']['size'];

		$file_ext = strtolower(end(explode('.', $_FILES['vg_file']['name'])));
		$expensions = array("pdf", "jpg", "PDF", "JPG", "jpeg", "JPEG");

		if (in_array($file_ext, $expensions)){
			if ($vg_file_size <= '3145728') {
				$date = date('Y-m-d H:i:s');				
				if (!empty($docimage1)) {
					unlink("uploads/vg_files/$docimage1");
				}
				$img_vg_file = 'VG' . $userid . '-' . $refid . '.' . $file_ext;
				move_uploaded_file($vg_tmp, 'uploads/vg_files/' . $img_vg_file);
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
			unlink("uploads/vg_files/$docimage1");
		}
	}

	$vg_sts_logs = "INSERT INTO `vg_vr_sts_logs`(`user_id`,`st_id`, `agent_type`, `vg_date`, `v_g_r_status`, `created_datetime`) VALUES ('$loggedid','$userid','$agent_type','$vg_date','$v_g_r_status','$follow_datetime')";
	mysqli_query($con, $vg_sts_logs);

	mysqli_query($con, "update `st_application` set `v_g_r_status`='$v_g_r_status', `vg_date`='$vg_date', `vg_file`='$img_vg_file', `v_g_r_status_updated_by_name`='$Loggedemail', follow_status='0', last_updated_at='$follow_datetime' $v_g_r_status_datetime21 $getCrntAmountInRupes2 where `sno`='$userid'");
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'excu', '$userid', '$fullname', '$agent_id', '$refid', 'Status changed to $v_g_r_status', '$v_g_r_status', '../backend/application?did=$uid&aid=error_$userid', '1', '$follow_datetime')");

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
	header("Location: application?pt=$msg&did=$agent_id&aid=error_$userid&apid=$uid$tab1");
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

	if($follow_stage == 'File_Not_Lodged' && $fh_status1 == '1'){
		$follow_status_1 = ",follow_status='0'";
	}else{
		$follow_status_1 = '';
	}	

	$qury = "update `st_application` set `fh_status`='$fh_status', `fh_status_updated_by`='$follow_datetime', `fh_status_updated_name`='$Loggedemail', last_updated_at='$follow_datetime' $follow_status_1 $fh_re_lodgement where `sno`='$userid'";
    mysqli_query($con, $qury);	

	if($fh_status1 == 'Re_Lodged'){
		$qryEmpty = "update `st_application` set v_g_r_status='', v_g_r_invoice='', v_g_r_amount='', v_g_r_status_datetime='', com_refund_datetime='', comrefund_remarks='', inovice_status='', inovice_remarks='', inovice_reciept='', inovice_datetime='', file_upload_vgr='', file_upload_vgr2='', file_upload_vgr3='', file_upload_vr_status='', file_upload_vr_remarks='',  file_upload_vr_datetime='', settled_vr='', tt_upload_report_status='', tt_upload_report='', tt_upload_report_remarks='', tt_upload_report_datetime='' ,file_upload_vgr_status='', file_upload_vgr_remarks='', file_upload_vgr_datetime='', com_details_status_vr='', com_details_remarks_vr='', com_details_datetime_vr=''  where `sno`='$userid'";
		mysqli_query($con, $qryEmpty);
	}	

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
?>