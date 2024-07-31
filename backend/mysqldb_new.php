<?php
session_start();
include("../db.php");
/* practivum_databes for update_courses_date*/

// $hostname5="localhost";
// $user5="aol_practicum";
// $pass5="aol_practicum@4321";
// $dbhost5="aol_practicum";
// $cons5 = mysqli_connect($hostname5,$user5,$pass5,$dbhost5) or die("UNABLE TO CONNECT TO DATABASE");

/* end of practicum database connection  */
date_default_timezone_set("Asia/Kolkata");
if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$loggedid = $_SESSION['sno'];
$rsltLogged = mysqli_query($con,"SELECT sno,role,email FROM allusers WHERE sno = '$loggedid'");
$rowLogged = mysqli_fetch_assoc($rsltLogged);
$Loggedrole = mysqli_real_escape_string($con, $rowLogged['role']);
$Loggedemail = mysqli_real_escape_string($con, $rowLogged['email']);
}else{
   $Loggedrole = '';
   $Loggedemail = ''; 
}

$follow_datetime = date('Y-m-d H:i:s');


if(isset($_POST['appbtncrs'])){
// print_r($_POST);	
// die;
	$campus = $_POST['campus'];
	$intake = $_POST['intake'];
	$prg_name1 = $_POST['prg_name1'];
	$asc = $_POST['admin_status_crs'];
	$arc = $_POST['admin_remark_crs'];
	$userid = $_POST['snoid'];
	$tab = $_POST['rowbg1'];
	if($tab !==''){
		$tab1 = '&tab='.$tab;
	}else{
		$tab1 = '';
	}
	
	$pdfMsg = base64_encode('Donotpdf1');	
	if($asc == 'No'){
		mysqli_query($con, "update `st_application` set `campus`='$campus', `prg_intake`='$intake', `prg_type1`='$prg_name1', `admin_status_crs`='$asc', `admin_remark_crs`='$arc', `application_status_datetime`='$follow_datetime' where `sno`='$userid'");
	}
	if($asc == 'Yes'){		
		mysqli_query($con, "update `st_application` set `campus`='$campus', `prg_intake`='$intake', `prg_name1`='$prg_name1', `admin_status_crs`='$asc', `admin_remark_crs`='$arc', `application_status_datetime`='$follow_datetime', follow_status='0' where `sno`='$userid'");	
	}
	if($asc == 'Not Eligible'){		
		mysqli_query($con, "update `st_application` set `campus`='$campus', `prg_intake`='$intake', `prg_name1`='$prg_name1', `admin_status_crs`='$asc', `admin_remark_crs`='$arc', `application_status_datetime`='$follow_datetime' where `sno`='$userid'");	
	}

	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,follow_stage FROM `st_application` where `sno`='$userid'");
	$uid = mysqli_fetch_assoc($qry);
	$user_id = $uid['user_id'];		
	$sno = $uid['sno'];
	$refid = $uid['refid'];
	$follow_stage = $uid['follow_stage'];
	$fullname = $uid['fname'].' '.$uid['lname'];
	$date = date('Y-m-d H:i:s');
	
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
	unlink("../uploads/$docimage1");
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
	$userid = $_POST['snid'];
	$email = $_POST['email'];
	$gtitle = $_POST['gtitle'];
	$fname = $_POST['fname'];
    $lname = $_POST['lname'];
	$username = $fname.' '.$lname;
    $mobile = $_POST['mobile'];
	$gender = $_POST['gender'];
	$martial_status = $_POST['martial_status'];
	$dob = $_POST['dob'];
	$cntry_brth = $_POST['cntry_brth'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$country = $_POST['country'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$pincode = $_POST['pincode'];
	$passport_no = $_POST['passport_no'];
	$pp_issue_date = $_POST['pp_issue_date'];
	$personal_status = $_POST['personal_status'];
	
	$date2=date_create($pp_issue_date);	
	date_add($date2,date_interval_create_from_date_string("10 years"));
	$expire_date = date_format($date2,"Y-m-d");	
	$newdate = strtotime('-1 day' ,strtotime ($expire_date));
	$newdate2 = date ('Y-m-d' , $newdate);	
	$pp_expire_date = $newdate2;
	
		
	$name1 = $_FILES['idproof']['name'];
	$tmp1 = $_FILES['idproof']['tmp_name'];	
	$delete_foldr=mysqli_query($con, "SELECT sno,refid, idproof FROM st_application where sno='$userid'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	
	$idproof = $dltlist['idproof'];	
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);		
	if($name1 == ''){	
			$img_name1 = $idproof;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);				
		if($extension=='pdf' || $extension=='zip' || $extension=='rar'){
			unlink("../uploads/$idproof");
			$img_name1 = 'Passport'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmp1, '../uploads/'.$img_name1);
		}else{ 
			$uid = base64_encode($userid);
			$imgMsg = base64_encode('ImageAgreementUpload');			
			echo "<script>alert('File is not Supported (Please upload the PDF and ZIP Files)'); window.location='application/edit.php?apid=$uid&msgagree=$imgMsg'</script>";
			//header("Location: application/edit.php?apid=$uid&msgagree=$imgMsg");
			exit;
		}				
	}		
	$update_query = mysqli_query($con, "update `st_application` set `fname`='$fname',`lname`='$lname', `email_address`='$email', `mobile`='$mobile', `gtitle`='$gtitle', `gender`='$gender', `dob`='$dob', `cntry_brth`='$cntry_brth', `martial_status`='$martial_status', `address1`='$address1', `address2`='$address2', `country`='$country', `state`='$state', `city`='$city', `pincode`='$pincode', `passport_no`='$passport_no', `pp_issue_date`='$pp_issue_date', `pp_expire_date`='$pp_expire_date', `idproof`='$img_name1', `personal_status`='$personal_status' where `sno`='$userid'");
	$msg = base64_encode('Academic-Details');
	$uid = base64_encode($userid);
	$random = base64_encode(rand());
	header("Location: application/edit.php?pt=$msg&apid=$uid&$random");	
}


if(isset($_POST['academicbtn'])){
	$userid = $_POST['snid'];
	$qualifications1 = $_POST['qualifications1'];
	$stream1 = $_POST['stream1'];
	$marks1 = $_POST['marks1'];
	$passing_year1 = $_POST['passing_year1'];
	$unicountry1 = $_POST['unicountry1'];
	$name1 = $_FILES['certificate1']['name'];
	$tmp1 = $_FILES['certificate1']['tmp_name'];
	$uni_name1 = $_POST['uni_name1'];
	
	$delete_foldr=mysqli_query($con, "SELECT sno,fname,refid, certificate1, certificate2, certificate3,ielts_file,pte_file FROM st_application where sno='$userid'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);
	
	$docimage1 = $dltlist['certificate1'];	
	$ieltsFile = $dltlist['ielts_file'];	
	$pdfFile = $dltlist['pte_file'];
	$fname = $dltlist['fname'];	
	$refid = $dltlist['refid'];	
	$firstname = str_replace(' ', '', $fname);	
	if($name1 == ''){	
		$img_name1 = $docimage1;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);
		if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='rar'){
			unlink("../uploads/$docimage1");
			$img_name1 = 'Crt1'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmp1, '../uploads/'.$img_name1);
		}else{
			$msg = base64_encode('Academic-Details'); 
			$uid = base64_encode($userid);
			$imgMsg = base64_encode('ImageAgreementUpload');
			//header("Location: application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg");
			echo "<script>alert('File is not Supported (Please upload the PDF and ZIP Files)'); window.location='application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg'</script>";
			exit;
		}				
	}
	
	$qualifications2 = $_POST['qualifications2'];
	$stream2 = $_POST['stream2'];
	$marks2 = $_POST['marks2'];
	$passing_year2 = $_POST['passing_year2'];
	$unicountry2 = $_POST['unicountry2'];
	$name2 = $_FILES['certificate2']['name'];
	$tmp2 = $_FILES['certificate2']['tmp_name'];
	$uni_name2 = $_POST['uni_name2'];	
	
	$docimage2 = $dltlist['certificate2'];	
	if($name2 == ''){	
		$img_name2 = $docimage2;	
	}else{				
		$extension2 = pathinfo($name2, PATHINFO_EXTENSION);		
		if($extension2=='pdf' || $extension2=='PDF' || $extension2=='zip' || $extension2=='rar'){
		unlink("../uploads/$docimage2");
		$img_name2 = 'Crt2'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension2;
		move_uploaded_file($tmp2, '../uploads/'.$img_name2);
		}else{
			$msg = base64_encode('Academic-Details'); 
			$uid = base64_encode($userid);
			$imgMsg = base64_encode('ImageAgreementUpload');
			//header("Location: application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg");
			echo "<script>alert('File is not Supported (Please upload the PDF and ZIP Files)'); window.location='application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg'</script>";
			exit;						
		}
	}
	
	$qualifications3 = $_POST['qualifications3'];
	$stream3 = $_POST['stream3'];
	$marks3 = $_POST['marks3'];
	$passing_year3 = $_POST['passing_year3'];
	$unicountry3 = $_POST['unicountry3'];
	$name3 = $_FILES['certificate3']['name'];
	$tmp3 = $_FILES['certificate3']['tmp_name'];
	$uni_name3 = $_POST['uni_name3'];
	
	$docimage3 = $dltlist['certificate3'];	
	if($name3 == ''){	
		$img_name3 = $docimage3;	
	}else{
		$extension3 = pathinfo($name3, PATHINFO_EXTENSION);
		if($extension3=='pdf' || $extension3=='PDF' || $extension3=='zip' || $extension3=='rar'){
		unlink("../uploads/$docimage3");
		$img_name3 = 'Crt3'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension3;
		move_uploaded_file($tmp3, '../uploads/'.$img_name3);
		}else{
			$msg = base64_encode('Academic-Details'); 
			$uid = base64_encode($userid);
			$imgMsg = base64_encode('ImageAgreementUpload');
			//header("Location: application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg");
			echo "<script>alert('File is not Supported (Please upload the PDF and ZIP Files)'); window.location='application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg'</script>";
			exit;					
		}
	}
	$englishpro = $_POST['englishpro'];
	if($englishpro == 'ielts'){
	$ieltsover = $_POST['ieltsover'];
	$ieltsnot = $_POST['ieltsnot'];
	$ielts_listening = $_POST['ielts_listening'];
	$ielts_reading = $_POST['ielts_reading'];
	$ielts_writing = $_POST['ielts_writing'];
	$ielts_speaking = $_POST['ielts_speaking'];
	$ielts_date = $_POST['ielts_date'];
		
	$nameielts = $_FILES['ielts_file']['name'];
	$tmpielts = $_FILES['ielts_file']['tmp_name'];	
	if($nameielts == ''){	
		$img_name_ielts = $ieltsFile;		
	}else{
		$extension = pathinfo($nameielts, PATHINFO_EXTENSION);			
		if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='rar'){
			unlink("../uploads/$ieltsFile");
			$img_name_ielts = 'Ielts'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmpielts, '../uploads/'.$img_name_ielts);
		}else{
			$msg = base64_encode('Academic-Details'); 
			$uid = base64_encode($userid);
			$imgMsg = base64_encode('ImageAgreementUpload');
			//header("Location: application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg");
			echo "<script>alert('File is not Supported (Please upload the PDF and ZIP Files)'); window.location='application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg'</script>";
			exit;
		}			
	}	
	}
	
	if($englishpro == 'pte'){
	$pteover = $_POST['pteover'];
	$ptenot = $_POST['ptenot'];
	$pte_listening = $_POST['pte_listening'];
	$pte_reading = $_POST['pte_reading'];
	$pte_writing = $_POST['pte_writing'];
	$pte_speaking = $_POST['pte_speaking'];
	$pte_date = $_POST['pte_date'];	
	
	$namepdf = $_FILES['pte_file']['name'];
	$tmppdf = $_FILES['pte_file']['tmp_name'];	
	if($namepdf == ''){	
			$img_name_pte = $pdfFile;		
	}else{			
		$extension = pathinfo($namepdf, PATHINFO_EXTENSION);			
		if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='rar'){
			unlink("../uploads/$pdfFile");
			$img_name_pte = 'Pte'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_pte);
		}else{
			$msg = base64_encode('Academic-Details'); 
			$uid = base64_encode($userid);
			$imgMsg = base64_encode('ImageAgreementUpload');
			//header("Location: application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg");
			echo "<script>alert('File is not Supported (Please upload the PDF and ZIP Files)'); window.location='application/edit.php?pt=$msg&apid=$uid&msgagree=$imgMsg'</script>";
			exit;
		}				
	 }
	}	
					
	$academic_status = $_POST['academic_status'];	
	if($englishpro == 'ielts'){
	$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='$ieltsover',`ieltsnot`='$ieltsnot',`ielts_listening`='$ielts_listening',`ielts_reading`='$ielts_reading',`ielts_writing`='$ielts_writing',`ielts_speaking`='$ielts_speaking',`ielts_date`='$ielts_date',`ielts_file`='$img_name_ielts',`pteover`='',`ptenot`='',`pte_listening`='',`pte_reading`='',`pte_writing`='',`pte_speaking`='',`pte_date`='',`pte_file`='',`qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `certificate1`='$img_name1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `certificate2`='$img_name2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `certificate3`='$img_name3', `uni_name3`='$uni_name3', `academic_status`='$academic_status' where `sno`='$userid'");
	}
	if($englishpro == 'pte'){
	$update_query = mysqli_query($con, "update `st_application` set `englishpro`='$englishpro',`ieltsover`='',`ieltsnot`='',`ielts_listening`='',`ielts_reading`='',`ielts_writing`='',`ielts_speaking`='',`ielts_date`='',`ielts_file`='',`pteover`='$pteover',`ptenot`='$ptenot',`pte_listening`='$pte_listening',`pte_reading`='$pte_reading',`pte_writing`='$pte_writing',`pte_speaking`='$pte_speaking',`pte_date`='$pte_date',`pte_file`='$img_name_pte',`qualification1`='$qualifications1',`stream1`='$stream1', `marks1`='$marks1', `passing_year1`='$passing_year1', `unicountry1`='$unicountry1', `certificate1`='$img_name1', `uni_name1`='$uni_name1', `qualification2`='$qualifications2',`stream2`='$stream2', `marks2`='$marks2', `passing_year2`='$passing_year2', `unicountry2`='$unicountry2', `certificate2`='$img_name2', `uni_name2`='$uni_name2', `qualification3`='$qualifications3',`stream3`='$stream3', `marks3`='$marks3', `passing_year3`='$passing_year3', `unicountry3`='$unicountry3', `certificate3`='$img_name3', `uni_name3`='$uni_name3', `academic_status`='$academic_status' where `sno`='$userid'");
	}
	$msg = base64_encode('Course-Details');
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
		mysqli_query($con, "update `st_application` set `campus`='$campus', `prg_name1`='$prg_name1', `prg_intake`='$prg_intake', `course_status`='$course_status' where `sno`='$userid'");	   
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
	mysqli_query($con, "update `st_application` set `prepaid_fee`='$prepaid_fee', `prepaid_remarks`='$prepaid_remarks', `fee_status_updated_by`='$fee_status_updated_by',`fee_date_updated_by`='$fee_date_updated_by', `follow_status`='0' where `sno`='$userid'");
	$msg = base64_encode('Application-Details');
	$uid = base64_encode($userid);
	
//Followup
	mysqli_query($con, "update `followup` set `fstatus`='0', `updated`='$fee_date_updated_by' where `st_app_id`='$userid'");
	
	header("Location: application?pt=$msg&aid=error_$userid&apid=$uid");
}

if(isset($_POST['reportbtn'])){
	$status = $_POST['status'];
	$created = $_POST['created'];
	$created1 = $_POST['created1'];
	header("Location: daily_reports?status=$status&crt=$created&crt1=$created1");
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
	
	$qry = mysqli_query($con, "SELECT sno,user_id,refid,fname,lname,follow_stage FROM `st_application` where `sno`='$userid'");
	$uid1 = mysqli_fetch_assoc($qry);
	$user_id = $uid1['user_id'];	
	$follow_stage = $uid1['follow_stage'];	
	$sno = $uid1['sno'];
	$refid = $uid1['refid'];
	$fname2 = $uid1['fname'];
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
	
	mysqli_query($con, "update `st_application` set `v_g_r_status`='$v_g_r_status',`v_g_r_status_datetime`='$follow_datetime', follow_status='0' where `sno`='$userid'");
			
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
	mysqli_query($con, "update `st_application` set `comrefund_remarks`='$comrefund_remarks', `v_g_r_amount`='$v_g_r_amount', `v_g_r_invoice`='$img_name3', `com_refund_datetime`='$follow_datetime' where `sno`='$userid'");
		
		
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
	
	$qury = "update `st_application` set `fh_status`='$fh_status', `fh_status_updated_by`='$follow_datetime' $follow_status_1 $fh_re_lodgement where `sno`='$userid'";
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
	if(!empty($_POST['visible_status'])){
		$visible_status_2 = $_POST['visible_status'];
	}else{
		$visible_status_2 = '0';
	}

	if($visible_status_2 == '0'){
		$status_status = '0';
		$visible_status = '0';
	}
	if($visible_status_2 == '1'){
		$status_status = '1';
		$visible_status = '1';
	}
	if($visible_status_2 == '2'){
		$status_status = '0';
		$visible_status = '2';
	}
	
	if(!empty($_POST['program_name_input'])){
		$program_name = $_POST['program_name_input'];
	} elseif(!empty($_POST['program_name_drop'])){
		$program_name = $_POST['program_name_drop'];
	}else{
		$program_name = '';
	}
	
	$intake = $_POST['intake'];	
	$tuition_fee = $_POST['tuition_fee'];
	
	$commenc_date_1 = $_POST['commenc_date'];
	if(!empty($commenc_date_1)){	
		$unixTimestamp = strtotime($commenc_date_1);
		$dayOfWeek = date("l", $unixTimestamp);
		$commenc_date = substr($dayOfWeek, 0,3).', '.$commenc_date_1;
	}else{
		$commenc_date = '';	
	}
	
	$expected_date_1 = $_POST['expected_date'];
	if(!empty($expected_date_1)){
		$unixTimestamp_1 = strtotime($expected_date_1);
		$dayOfWeek_1 = date("l", $unixTimestamp_1);
		$expected_date = substr($dayOfWeek_1, 0,3).', '.$expected_date_1;
	}else{
		$expected_date = '';	
	}
	
	$school_break1_1 = $_POST['school_break1'];
	if(!empty($school_break1_1)){
		$unixTimestamp_2 = strtotime($school_break1_1);
		$dayOfWeek_2 = date("l", $unixTimestamp_2);
		$school_break1 = substr($dayOfWeek_2, 0,3).', '.$school_break1_1;
	}else{
		$school_break1 = '';	
	}
	
	$school_break2_2 = $_POST['school_break2'];
	if(!empty($school_break2_2)){
		$unixTimestamp_3 = strtotime($school_break2_2);
		$dayOfWeek_3 = date("l", $unixTimestamp_3);
		$school_break2 = substr($dayOfWeek_3, 0,3).', '.$school_break2_2;
	}else{
		$school_break2 = '';	
	}
	
	$school_break_3_3 = $_POST['school_break_3'];
	if(!empty($school_break_3_3)){
		$unixTimestamp_4 = strtotime($school_break_3_3);
		$dayOfWeek_4 = date("l", $unixTimestamp_4);
		$school_break_3 = substr($dayOfWeek_4, 0,3).', '.$school_break_3_3;
	}else{
		$school_break_3 = '';	
	}
	
	$school_break_4_4 = $_POST['school_break_4'];
	if(!empty($school_break_4_4)){
		$unixTimestamp_5 = strtotime($school_break_4_4);
		$dayOfWeek_5 = date("l", $unixTimestamp_5);
		$school_break_4 = substr($dayOfWeek_5, 0,3).', '.$school_break_4_4;
	}else{
		$school_break_4 = '';	
	}
	
	$campus = $_POST['campus'];
	$week = $_POST['week'];
	$hours = $_POST['hours'];
	$int_fee = $_POST['int_fee'];
	$books_est = $_POST['books_est'];
	$other_fee = $_POST['other_fee'];
	$total_fee = $_POST['total_fee'];
	$total_tuition = $_POST['total_tuition'];
	$loa_total_fee = $_POST['loa_total_fee'];
	$otherandbook = $_POST['otherandbook'];
	$practicum = $_POST['practicum'];
	$practicum_wrk = $_POST['practicum_wrk'];
	$practicum_date = $_POST['practicum_date'];
	
	$program_start1_1 = $_POST['program_start1'];
	if(!empty($program_start1_1)){
		$program_start1 = $program_start1_1;
	}else{
		$program_start1 = '';	
	}
	
	$program_end1_1 = $_POST['program_end1'];
	if(!empty($program_end1_1)){
		$program_end1 = $program_end1_1;
	}else{
		$program_end1 = '';	
	}
	
	$program_start2_1 = $_POST['program_start2'];
	if(!empty($program_start2_1)){
		$program_start2 = $program_start2_1;
	}else{
		$program_start2 = '';	
	}
	
	$program_end2_1 = $_POST['program_end2'];
	if(!empty($program_end2_1)){
		$program_end2 = $program_end2_1;
	}else{
		$program_end2 = '';	
	}
	
	$created_datetime = date('Y-m-d H:i:s');
	
	$snoCheck = $_POST['snoCheck'];
	if(empty($snoCheck)){
	
	 $quryCrs = "INSERT INTO `contract_courses` (`campus`, `program_name`, `intake`, `tuition_fee`, `commenc_date`, `expected_date`, `school_break1`, `school_break2`, `school_break_3`, `school_break_4`, `week`, `hours`, `int_fee`, `books_est`, `other_fee`, `total_fee`, `total_tuition`, `loa_total_fee`, `otherandbook`, `practicum`, `practicum_wrk`, `practicum_date`, `program_start1`, `program_end1`, `program_start2`, `program_end2`, `created_datetime`, `created_id`, status, visible_status) VALUES ('$campus', '$program_name', '$intake', '$tuition_fee', '$commenc_date', '$expected_date', '$school_break1', '$school_break2', '$school_break_3', '$school_break_4', '$week', '$hours', '$int_fee', '$books_est', '$other_fee', '$total_fee', '$total_tuition', '$loa_total_fee', '$otherandbook', '$practicum', '$practicum_wrk', '$practicum_date', '$program_start1', '$program_end1', '$program_start2', '$program_end2', '$created_datetime', '$loggedid', '$status_status', '$visible_status')";
	mysqli_query($con, $quryCrs);
	
	// $quryCrs1 = "INSERT INTO `contract_courses` (`campus`, `program_name`, `intake`, `tuition_fee`, `commenc_date`, `expected_date`, `school_break1`, `school_break2`, `school_break_3`, `school_break_4`, `week`, `hours`, `int_fee`, `books_est`, `other_fee`, `total_fee`, `total_tuition`, `loa_total_fee`, `otherandbook`, `practicum`, `practicum_wrk`, `practicum_date`, `program_start1`, `program_end1`, `program_start2`, `program_end2`, `created_datetime`, `created_id`) VALUES ('$campus', '$program_name', '$intake', '$tuition_fee', '$commenc_date', '$expected_date', '$school_break1', '$school_break2', '$school_break_3', '$school_break_4', '$week', '$hours', '$int_fee', '$books_est', '$other_fee', '$total_fee', '$total_tuition', '$loa_total_fee', '$otherandbook', '$practicum', '$practicum_wrk', '$practicum_date', '$program_start1', '$program_end1', '$program_start2', '$program_end2', '$created_datetime', '$loggedid')";
	// mysqli_query($cons5, $quryCrs1);
	
	}else{
		mysqli_query($con, "update `contract_courses` set `program_name`='$program_name', `campus`='$campus', `intake`='$intake', `tuition_fee`='$tuition_fee', `commenc_date`='$commenc_date', `expected_date`='$expected_date', `school_break1`='$school_break1', `school_break2`='$school_break2', `school_break_3`='$school_break_3', `school_break_4`='$school_break_4', `week`='$week', `hours`='$hours', `int_fee`='$int_fee', `books_est`='$books_est', `other_fee`='$other_fee', `total_fee`='$total_fee', `total_tuition`='$total_tuition', `loa_total_fee`='$loa_total_fee', `otherandbook`='$otherandbook', `practicum`='$practicum', `practicum_wrk`='$practicum_wrk', `practicum_date`='$practicum_date', `program_start1`='$program_start1', `program_end1`='$program_end1', `program_start2`='$program_start2', `program_end2`='$program_end2', `created_datetime`='$created_datetime', `created_id`='$loggedid', `status`='$status_status', `visible_status`='$visible_status' where `sno`='$snoCheck'");

		// mysqli_query($cons5, "update `contract_courses` set `campus`='$campus', `program_name`='$program_name', `intake`='$intake', `tuition_fee`='$tuition_fee', `commenc_date`='$commenc_date', `expected_date`='$expected_date', `school_break1`='$school_break1', `school_break2`='$school_break2', `school_break_3`='$school_break_3', `school_break_4`='$school_break_4', `week`='$week', `hours`='$hours', `int_fee`='$int_fee', `books_est`='$books_est', `other_fee`='$other_fee', `total_fee`='$total_fee', `total_tuition`='$total_tuition', `loa_total_fee`='$loa_total_fee', `otherandbook`='$otherandbook', `practicum`='$practicum', `practicum_wrk`='$practicum_wrk', `practicum_date`='$practicum_date', `program_start1`='$program_start1', `program_end1`='$program_end1', `program_start2`='$program_start2', `program_end2`='$program_end2', `created_datetime`='$created_datetime', `created_id`='$loggedid' where `sno`='$snoCheck'");
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
		unlink("../uploads/$loa_tt");
	}
	$firstname = str_replace(' ', '', $fullname);
	$img_name1 = 'Rqst_LOA_TT'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
	move_uploaded_file($tmp1, '../uploads/'.$img_name1);
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'admin', '$sno', '$fullname', '$agent_id', '$refid', 'LOA Requested', 'LOA Request', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`, `report_noti`) VALUES ('Admin', '$sno', '$fullname', '$agent_id', '$refid', 'TT Receipt', 'TT Receipt', 'report/loa_receipt.php?aid=error_$sno', '1', '$date', 'Yes')");
	
	mysqli_query($con, "update `st_application` set `file_receipt`='1', `loa_tt`='$img_name1', `agent_request_loa_datetime`='$date', follow_status='0' where `sno`='$idno'");	

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
	
	mysqli_query($con, "update `st_application` set `file_receipt`='1', `loa_tt`='', `agent_request_loa_datetime`='$date', follow_status='0' where `sno`='$idno'");	

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
?>