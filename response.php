<?php
session_start();
include("db.php");
date_default_timezone_set("Asia/Kolkata");
header('Content-type: application/json');
// $sessionSno = $_SESSION['sno'];

if(!empty($_SESSION['sno'])){
	$sessionSno = $_SESSION['sno'];
}else{
	$sessionSno = '';
}


if(isset($_POST['emailaddress'])){
    $emailaddress = $_POST['emailaddress'];    
    $resEmail = mysqli_query($con,"SELECT email FROM allusers WHERE email!='' AND email = '$emailaddress'");
    if (mysqli_num_rows($resEmail)){
		echo "false";
		die;
	} else {
		echo "true";
		die;
	}
}

if(isset($_POST['passportno'])){
    $passport_no = $_POST['passportno'];    
    $resPass = mysqli_query($con,"SELECT passport_no FROM st_application WHERE passport_no = '$passport_no'");
    if (mysqli_num_rows($resPass)){
		echo "false";
		die;
	} else {
		echo "true";
		die;
	}
}

if(isset($_POST['emailaddress1'])){
    $emailaddress = $_POST['emailaddress1'];    
    $resEmail = mysqli_query($con,"SELECT email_address FROM st_application WHERE email_address = '$emailaddress'");
    if (mysqli_num_rows($resEmail)){
		echo "false";
		die;
	} else {
		echo "true";
		die;
	}
}

if(isset($_POST['mobileexistdashboard'])){
    $mobile = $_POST['mobileexistdashboard'];    
    $resMobile2 = mysqli_query($con,"SELECT mobile FROM st_application WHERE mobile = '$mobile'");
    if (mysqli_num_rows($resMobile2)){
		echo "false";
		die;
	} else {
		echo "true";
		die;
	}
}

if(isset($_POST['agent_email_bk'])){
    $agent_email_bk = $_POST['agent_email_bk'];    
    $resEmail = mysqli_query($con,"SELECT agent_email FROM allusers WHERE agent_email!='' AND agent_email = '$agent_email_bk'");
    if (mysqli_num_rows($resEmail)){
		echo "false";
		die;
	} else {
		echo "true";
		die;
	}
}

if(isset($_POST['mobile_bk'])){
    $mobile_bk = $_POST['mobile_bk'];    
    $resMobile = mysqli_query($con,"SELECT mobile FROM allusers WHERE mobile!='' AND mobile = '$mobile_bk'");
    if (mysqli_num_rows($resMobile)){
		echo "false";
		die;
	} else {
		echo "true";
		die;
	}
}

if($_GET['tag'] == "pType") {
	$pt = $_POST['catg'];
	$get_query = mysqli_query($con, "SELECT * FROM aol_courses where program_type='$pt'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$pn = $rowstr['program_name'];		
		$res1[] = array(
		    'sno' => $rowstr['sno'],
		    'program_name' => $pn
		);
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
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
			$idproof = "<a href='../uploads/$idp1' download>Download</a>";
		}else{
			$idproof = "<span style='color:red;'>Pending</span>";
		}
		
		if($cert1 !== ''){
			$certificate1 = "<a href='../uploads/$cert1' download>Download</a>";
		}else{
			$certificate1 = "<span style='color:red;'>Pending</span>";
		}
		
		if($cert2 !== ''){
			$certificate2 = "<a href='../uploads/$cert2' download>Download</a>";
		}else{
			$certificate2 = "<span style='color:red;'>Pending</span>";
		}
		
		if($cert3 !== ''){
			$certificate3 = "<a href='../uploads/$cert3' download>Download</a>";
		}else{
			$certificate3 = "<span style='color:red;'>Pending</span>";
		}
		$englishpro = $rowstr['englishpro'];
		if($englishpro == 'ielts'){
			$ielts_Toefl = 'IELTS';
		}
		if($englishpro == 'Toefl'){
			$ielts_Toefl = 'Toefl';
		}		
		
		if($englishpro == 'ielts' || $englishpro == 'Toefl'){
			
		$ielts_file1 = $rowstr['ielts_file'];
		if($ielts_file1 !== ''){
			$ielts_file = "<a href='../uploads/$ielts_file1' download>Download</a>";
		}else{
			$ielts_file = "<span style='color:red;'>Pending</span>";
		}
			
		$ielts_pte_over = '<b>'.$ielts_Toefl.' Overall Band: </b> '.$rowstr['ieltsover'];
		$ielts_pte_not = '<b>'.$ielts_Toefl.' Band not Less than: </b>'.$rowstr['ieltsnot'];
		$ielts_pte_listening = '<b>Listening: </b>'.$rowstr['ielts_listening'];
		$ielts_pte_reading = '<b>Reading: </b>'.$rowstr['ielts_reading'];
		$ielts_pte_writing = '<b>Writing: </b>'.$rowstr['ielts_writing'];
		$ielts_pte_speaking = '<b>Speaking: </b>'.$rowstr['ielts_speaking'];
		$ielts_pte_date = '<b>'.$ielts_Toefl.' Date: </b>'.$rowstr['ielts_date'];
		$ielts_pte_file = '<b>'.$ielts_Toefl.' TRF: </b>'.$ielts_file;
		$ielts_pte_username = '';
		$ielts_pte_password = '';
		}	
				
		if($englishpro == 'pte'){
		
		$pte_file1 = $rowstr['pte_file'];
		if($pte_file1 !== ''){
			$pte_file = "<a href='../uploads/$pte_file1' download>Download</a>";
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
		$ielts_pte_username = '<p><b>PTE Username: </b>'.$rowstr['pte_username'].'</p>';
		$ielts_pte_password = '<p><b>PTE Password: </b>'.$rowstr['pte_password'].'</p>';
		}
		
	if($englishpro == 'duolingo'){
			
		$duolingo_file2 = $rowstr['duolingo_file'];
		if($duolingo_file2 !== ''){
			$duolingo_file = "<a href='../uploads/$duolingo_file2' download>Download</a>";
		}else{
			$duolingo_file = "<span style='color:red;'>Pending</span>";
		}
			
		$duolingo_score = '<b>DuolingoOverall Score: </b>'.$rowstr['duolingo_score'];
		$duolingo_date = '<b>Duolingo Test Date: </b>'.$rowstr['duolingo_date'];
		$duolingo_file1 = '<b>Duolingo File: </b>'.$duolingo_file;
		$ielts_pte_over = '';
		$ielts_pte_not = '';
		$ielts_pte_listening = '';
		$ielts_pte_reading = '';
		$ielts_pte_writing = '';
		$ielts_pte_speaking = '';
		$ielts_pte_date = '';
		$ielts_pte_file = '';
		$duolingo_div = $duolingo_score.' '.$duolingo_date.' '.$duolingo_file1;
		$ielts_pte_username = '';
		$ielts_pte_password = '';
	}else{
		$duolingo_div = '';
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
		$ielts_pte_username = '';
		$ielts_pte_password = '';
	}
		
	$crnt_year = date('Y');	
	$passing_year_gap_2 = $rowstr['passing_year_gap'];
	if($passing_year_gap_2 == $crnt_year){
		$passing_year_gap = '<p><b>Passing Year: </b>'.$passing_year_gap_2.'</p>';
		
		$passing_justify_gap = '';
		$gap_duration_2 = '';
		$gap_other = '';
		
	}else{
		
		$passing_year_gap = '<p><b>Passing Year: </b>'.$passing_year_gap_2.'</p>';		
		$passing_justify_gap_2 = $rowstr['passing_justify_gap'];
			
		if($passing_justify_gap_2 == 'Yes'){
			$passing_justify_gap = '<p><b>Justification for Gap: </b>'.$passing_justify_gap_2.'</p>';
			$gap_duration_2 = '<p><b>During Gap: </b>'.$rowstr['gap_duration'].'</p>';
			if($rowstr['gap_duration'] == 'other'){
				$gap_other = '<p><b>Gap Reson: </b>'.$rowstr['gap_other'].'</p>';
			}else{
				if($rowstr['gap_duration'] == "job"){
					$gap_other = '<p><b>Gap Docs: </b>Salery Slip, Joining Letter, Bank Statement';
				}
				if($rowstr['gap_duration'] == "business"){
					$gap_other = '<p><b>Gap Docs: </b>ITR, TAN Number, Bank Statement';
				}
				if($rowstr['gap_duration'] == "exam_prepration"){
					$gap_other = '<p><b>Gap Docs: </b>Admit Card';
				}
				if($rowstr['gap_duration'] == ""){
					$gap_other = '';
				}
			}			
		}
		if($passing_justify_gap_2 == 'No'){
			$passing_justify_gap = '<p><b>Justification for Gap: </b>'.$passing_justify_gap_2.'</p>';
			$gap_duration_2 = '';
			$gap_other = '';
		}
		if($passing_justify_gap_2 == ''){
			$passing_justify_gap = '';
			$gap_duration_2 = '';
			$gap_other = '';
		}
	}

	$passing_year_gap_justification = $passing_year_gap.' '.$passing_justify_gap.' '.$gap_duration_2.' '.$gap_other;
		
		$mother_father_select = $rowstr['mother_father_select'];
		if($mother_father_select == 'Mother'){
			$mother_father_name = '<p>'.'<b>Mother Name: </b>'.$rowstr['mother_father_name'].'</p>';
		}
		if($mother_father_select == 'Father'){		
			$mother_father_name = '<p>'.'<b>Father Name: </b>'.$rowstr['mother_father_name'].'</p>';
		}
		
		if($mother_father_select == ''){		
			$mother_father_name = '<p>'.'<b>Mother/Father Name: </b>N/A</p>';
		}
		
		$emergency_contact_no = '<p>'.'<b>Emergency Contact No: </b>'.$rowstr['emergency_contact_no'].'</p>';
		
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
		    'dob' => $rowstr['dob'].''.$mother_father_name.''.$emergency_contact_no,
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
			'ielts_pte_file' => $ielts_pte_file.''.$ielts_pte_username.''.$ielts_pte_password,			
			'duolingo_div' => $duolingo_div,			
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
		    'prg_name1' => $rowstr['prg_name1'],
		    'prg_intake' => $rowstr['prg_intake'],
		    'passing_year_gap_justification' => $passing_year_gap_justification
		);
	}	
	echo json_encode($res1);
}


if($_GET['tag'] == "chkstatus") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT admin_status_crs,admin_remark_crs FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$admin_status_crs = $rowstr['admin_status_crs'];
		$admin_remark_crs = $rowstr['admin_remark_crs'];
		if($admin_status_crs == ''){
			$status = '<span style="color:red;">Pending<span>';
		}else{
			$status = $admin_status_crs;
		}
		if($admin_remark_crs == ''){
			$remarks = '<span style="color:red;">Not Found<span>';
		}else{
			$remarks = $admin_remark_crs;
		}
		$res1[] = array(
		    'asc' => $status,
		    'arc' => $remarks
		);
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}


// if($_GET['tag'] == "chkResLetter") {
	// $idno = $_POST['idno'];
	// $get_query = mysqli_query($con, "SELECT file_receipt,loa_confirm,loa_confirm_remarks FROM st_application where sno='$idno'");
	// while($rowstr = mysqli_fetch_array($get_query)){
		// $file_receipt = $rowstr['file_receipt'];
		// $loa_confirm = $rowstr['loa_confirm'];
		// $loa_confirm_remarks = $rowstr['loa_confirm_remarks'];
		// if($file_receipt !== ''){
			// $oldnl = "<a href='uploads/$file_receipt' download>Download</a>";	
		// }else{
			// $oldnl = "<span style='color:red;'>Pending</span>";
		// }
		// if($loa_confirm == '1'){
			// $loaconfirm = "<span style='color:green;'>Verified</span>";	
		// }else{
			// $loaconfirm = "<span style='color:red;'>Pending</span>";
		// }
		//if($loa_confirm_remarks == '1'){
			// $loacr = $loa_confirm_remarks;	
		//}else{
			//$loacr = "<span style='color:red;'>Pending</span>";
		//}
		// $res1[] = array(
		    // 'fileReceipt' => $oldnl,
		    // 'loaconfirm' => $loaconfirm,
		    // 'loa_confirm_remarks' => $loacr
			// );
	// }	
	// $list = isset($res1) ? $res1 : '';
	// echo json_encode($list);	
// }

if($_GET['tag'] == "signedBtnLetter") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT signed_ol_confirm,signed_ol_remarks FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$signed_ol_confirm = $rowstr['signed_ol_confirm'];
		$signed_ol_remarks = $rowstr['signed_ol_remarks'];
		if($signed_ol_confirm == 'Yes'){
			$oldnl = "<span style='color:green;'>$signed_ol_confirm</span>";	
		}
		if($signed_ol_confirm == 'No'){
			$oldnl = "<span style='color:red;'>$signed_ol_confirm</span>";	
		}
		if($signed_ol_confirm == ''){
			$oldnl = "<span style='color:red;'>Pending</span>";
		}
		if($signed_ol_remarks !== ''){
			$remarks = $signed_ol_remarks;	
		}else{
			$remarks = "<span style='color:red;'>Pending</span>";
		}		
		$res1[] = array(
		    'oldnl' => $oldnl,
		    'remarks' => $remarks
			);
	}	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}

if($_GET['tag'] == "agreeLetter") {
	$idno = $_POST['idno'];
	$tabVal = $_POST['roletype'];
	$get_query = mysqli_query($con, "SELECT contract_letter  FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){			
		$contract_letter = $rowstr['contract_letter'];

		if(!empty($contract_letter)){
			$oldnl_1 = "<a href='uploads/$contract_letter' download>Download</a>";
		}else{
			$oldnl_1 = '<span style="color:red;">Pending</span>';
		}

		if(!empty($contract_letter)){
			$oldnl_2 = "<a href='../images/Student_Handbook.pdf' download>Download</a>";
		}else{
			$oldnl_2 = '<span style="color:red;">Pending</span>';
		}

		if($tabVal == 'All'){
		$usc_1 = '<form method="post" action="../mysqldb.php" autocomplete="off" enctype="multipart/form-data">
		<label><b>Upload Signed Contract :</b></label>
		<div class="row">
		<div class=" col-8">	  
		<div class="input-group w-100">	  
		<input type="file" name="safile" class="form-control uscDiv" required />			
		</div>
		<span style="color:red; float:left;">Upload PDF File Only,</span>
		<span style="color:red; float:right;">Maximum Size: 5MB</span><br />
		</div><div class=" col-4">
			<input type="hidden" name="rcptid" class="rcptid" value='.$idno.'>
			<input type="submit" name="salbtn" class="btn btn-submit " value="Submit">
			</div></div>
		</form>';

		$usc_2 = '<form method="post" class="mt-3 mb-3" action="../mysqldb.php" autocomplete="off" enctype="multipart/form-data">
		<label><b>Upload student handbook :</b></label>	
		<div class="row">
		<div class=" col-8">
		<div class="input-group">	  
		<input type="file" name="shbfile" class="form-control ushDiv" required />			
		</div>
		<span style="color:red; float:left;">Upload PDF File Only,</span>
		<span style="color:red; float:right;">Maximum Size: 5MB</span><br />
		</div>	
		<div class=" col-4">
			<input type="hidden" name="snoid" class="snoid" value='.$idno.'>
			<input type="submit" name="signedHBbtn" class="btn btn-submit" value="Submit">
			</div></div>
		</form>';

		$usc = $usc_1.''.$usc_2;
		}
		if($tabVal == 'Sub'){
			$usc = '';
		}
		
		$res1[] = array(
		    'DownloadAgree' => $oldnl_1,
		    'DownloadHandbook' => $oldnl_2,
		    'usc' => $usc
		);
	}	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}

if($_GET['tag'] == "agreeLetter2") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT signed_agreement_letter, contract_handbook_signed, signed_al_status, signed_al_remarks FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$sal = $rowstr['signed_agreement_letter'];		
		$chbs = $rowstr['contract_handbook_signed'];		
		$sals = $rowstr['signed_al_status'];		
		$signed_al_remarks = $rowstr['signed_al_remarks'];		
		if($sal == ''){
			$loaconfirm = "<span style='color:red;'>Pending</span>";
		}else{
			$loaconfirm = "<a href='../uploads/$sal' download>Download</a>";
		}

		if(!empty($sal)){
			if($chbs == ''){
				$show_chbs = "<span style='color:red;'>Pending</span>";
			}else{
				$show_chbs = "<a href='../uploads/$chbs' download>Download</a>";
			}
		}else{
			$show_chbs = "<span style='color:red;'>Pending</span>";
		}


		if($sals == 'Yes'){
			$sals1 = "<span style='color:green;'>Approved</span>";
		}
		if($sals == 'No'){
			$sals1 = "<span style='color:red;'>Not Approved</span>";
		}
		if($sals == ''){
			$sals1 = "<span style='color:red;'>Pending</span>";
		}
		
			$aalr = $signed_al_remarks;
		
		$res1[] = array(
		    'sal' => $loaconfirm,
		    'shb' => $show_chbs,
		    'stts' => $sals1,
		    'aalr' => $aalr
		);
	}	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}


if($_GET['tag'] == "rcppay") {	
	$name1 = $_FILES['receipt_file']['name'];
	$tmp1 = $_FILES['receipt_file']['tmp_name'];	
	$img_name1 = date('YmdHis').'_'.$name1;
	move_uploaded_file($tmp1, 'uploads/'.$img_name1);	
	$receipt_text = $_POST['receipt_text'];	
	$created = date('Y-m-d H:i:s');
	
	$stuid = $_POST['stuid'];
	$df = explode(",", $stuid);
	for($i=0; $i<count($df); $i++) {
		$result1 = mysqli_query($con,"SELECT sno,refid,prg_name1,prg_type1 FROM st_application WHERE sno = '$df[$i]'");
		while ($row1 = mysqli_fetch_assoc($result1)) {
		$sno1 = mysqli_real_escape_string($con, $row1['sno']);
		$refid = mysqli_real_escape_string($con, $row1['refid']);
		$prg_name1 = mysqli_real_escape_string($con, $row1['prg_name1']);
		$prg_type1 = mysqli_real_escape_string($con, $row1['prg_type1']);
		$queryrslt1 = "SELECT tuition_fee FROM aol_courses where (program_name='$prg_type1' and program_type='$prg_name1')";
		$queryrslt = mysqli_query($con, $queryrslt1);
		while ($rowcrs = mysqli_fetch_assoc($queryrslt)){
		$tuition_fee = $rowcrs['tuition_fee'];		
		$insrtData = "INSERT INTO `payments` (`sid`, `refid`, `pname`, `ptype`, `pamount`, `receipt_file`, `receipt_text`, `created`) VALUES('$sno1', '$refid','$prg_name1','$prg_type1', '$tuition_fee', '$img_name1', '$receipt_text', '$created')";
		$querypaymt = mysqli_query($con, $insrtData);			
		}
		}
	}
	echo 1;	
}

if($_GET['tag'] == "campusadd") {
	$campus = $_POST['campus'];
	$qury = "SELECT sno, intake FROM contract_courses WHERE campus='$campus' and show_oeg_status='1' group by intake ORDER BY sno DESC";	
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

// if($_GET['tag'] == "corseadd") {
	// $intake = $_POST['intake'];
	//// $qury = "SELECT sno,program_name FROM contract_courses WHERE intake = '$intake' AND visible_status!='2' AND campus_status!='2'";
	
	// if($sessionSno == '1136'){ //apply board
		// $campus = "AND campus='Toronto'";
	// }else{
		// $campus = "AND campus='Hamilton'";
	// }
	
	//if($sessionSno == '2' || $sessionSno == '3' || $sessionSno == '1029' || $sessionSno == '38'){ //ess & aum
		//// $campus2 = " AND (campus='Toronto' OR campus='Hamilton')";
		// $campus2 = '';
	// }else{
		// $campus2 = '';
	// }

	// $qury = "SELECT sno,program_name FROM contract_courses WHERE intake='$intake' AND visible_status!='2' AND week >= '38 weeks' $campus $campus2 group by program_name";	
	// $result1 = mysqli_query($con, $qury);
	// while($rowstr = mysqli_fetch_array($result1)){
		// $sno = $rowstr['sno'];
		// $program_name = $rowstr['program_name'];
		
	// $res1[] = array(
		// 'sno' => $sno,
		// 'program_name' => $program_name
	// );
	// }
	// echo json_encode($res1);
// }


if($_GET['tag'] == "agreement") {
	$idno = $_POST['idno'];
	$tabVal = $_POST['roletype'];
	$get_query = mysqli_query($con, "SELECT offer_letter,agreement FROM st_application where sno='$idno'");
	while($rowstr = mysqli_fetch_array($get_query)){
		$offer_letter = $rowstr['offer_letter'];		
		if($offer_letter !== ''){
			$oldnl = "<a href='uploads/$offer_letter' download> Download</a>";	
		}else{
			$oldnl = "<span style='color:red;'> Pending</span>";
		}
		
		$agreement = $rowstr['agreement'];
		if($agreement !== ''){
			$agl = "<a href='../uploads/$agreement' download> Download</a>";	
		}else{
			$agl = "<span style='color:red;'> Not Uploaded By You</span>";
		}
		
		if($tabVal == 'All'){
			$uscol = '<form method="post" action="../mysqldb.php" autocomplete="off" enctype="multipart/form-data">
					<hr>
					<b>Upload Signed Conditional Offer Letter:</b>
					<br><input type="file" name="agreement" class="form-control agreementInput" required>
					<span style="color:red;">Upload Scanned PDF File</span>
					<span style="float:right;color:red;">Maximum Size: 3MB</span><br>
					<input type="hidden" name="snoid" class="snoid" value='.$idno.'>
					<input type="submit" name="agreeBtn" class="btn btn-submit mt-2 mb-2" value="Upload">
					</form>';			
		}
		
		if($tabVal == 'Sub'){
			$uscol = '';
		}
		
		
		$res1[] = array(
		'oldnl' => $oldnl,
		'uscol' => $uscol,
		'agl' => $agl
	);
	}
	echo json_encode($res1);
}

if($_GET['tag'] == "confirm_loa") {
	$idno = $_POST['idno'];	
		
	$result = mysqli_query($con,"SELECT sno,app_by,user_id,refid,fname,lname,follow_stage FROM st_application WHERE sno='$idno'");
	$row = mysqli_fetch_assoc($result);
	$sno = $row['sno'];
	$agent_type = $row['app_by'];
	$agent_id = $row['user_id'];
	$follow_stage = $row['follow_stage'];
	$refid = $row['refid'];
	$fullname = $row['fname'].' '.$row['lname'];
	$date = date('Y-m-d H:i:s');
	
	if($follow_stage == 'Conditional_Offer_letter'){
		$stage = ", `follow_status`='0'";
	}elseif($follow_stage == 'LOA_Request'){
		$stage = ", `follow_status`='0'";
	}elseif($follow_stage == 'Contract_Stage'){
		$stage = ", `follow_status`='0'";
	}else{
		$stage = '';
	}	
	
	mysqli_query($con, "INSERT INTO `notification_aol` (`role`, `clg_pr_type`, `application_id`, `fullname`, `agent_id`, `refid`, `post`, `stage`, `url`, `status`, `created`) VALUES ('$agent_type', 'admin', '$sno', '$fullname', '$agent_id', '$refid', 'LOA Requested', 'LOA Request', '../backend/application?did=$agent_id&aid=error_$sno', '1', '$date')");
	
	mysqli_query($con, "update `st_application` set `file_receipt`='1', `agent_request_loa_datetime`='$date' $stage where `sno`='$idno'");	

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
	
	echo 1;
}


if($_GET['tag'] == "subget") {	
	$tabVal = $_POST['roletype'];
	$rowbg = $_POST['rowbg'];
	if($tabVal == 'All'){
		if(isset($rowbg) && !empty($rowbg)){
		$expVal = explode("error_", $rowbg);
		$qryStr = "(SELECT * FROM st_application where user_id = '$sessionSno' AND sno='$expVal[1]') UNION (SELECT * FROM st_application where user_id = '$sessionSno' AND sno !='$expVal[1]' order by sno ASC)";
		}else{
		$qryStr = "SELECT * FROM st_application where user_id = '$sessionSno'";
		}
	}	
	if($tabVal == 'Sub'){		
		$subid = $_POST['subid'];
		if($subid !== ''){
			$qryStr = "SELECT * FROM st_application WHERE application_form='1' AND user_id='$subid'";
		}else{
		$quryHead = "SELECT head,sub FROM agent_admin where head='$sessionSno'";
		$qrymy = mysqli_query($con, $quryHead);
		if(mysqli_num_rows($qrymy)){
		while ($rowhead = mysqli_fetch_assoc($qrymy)) {
			$sub[] = $rowhead['sub'];
		}	
			$arrImpld = implode(",",$sub);
			$total_id = 'user_id IN ('.$arrImpld.')';
			// $total_id = 'user_id IN ('.$sessionSno.','.$arrImpld.')';
		}else{
			$total_id = 'user_id IN ('.$sessionSno.')';
		}
		
			$qryStr = "SELECT * FROM st_application where application_form='1' AND $total_id";
		}				
	}
	// die;
	$result = mysqli_query($con, $qryStr);
	while ($row = mysqli_fetch_assoc($result)) {
	 $snoid = mysqli_real_escape_string($con, $row['sno']);
	 $user_id1 = mysqli_real_escape_string($con, $row['user_id']);
	 $fname = mysqli_real_escape_string($con, $row['fname']);
	 $lname = mysqli_real_escape_string($con, $row['lname']);
	 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
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
	 $file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);
	 
	$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id1'");
		while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
		$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
	}	
	
	if($rowbg == 'error_'.$snoid){
		$chkbx = "class='$rowbg'".' '."style='background-color: rgb(168, 216, 244);'";
		$chkbx1 = '<input type="checkbox" id="error_'.$snoid.'" checked="checked">';
	}else{
		$chkbx = "class=error_$snoid";
		$chkbx1 = '<input type="checkbox" id="error_'.$snoid.'">';
	}
		
	//Application Status
	
	if($tabVal == 'Sub'){
		$applicationStatus1 = '<span class="btn btn-sm jmjm" data-toggle="modal" data-target="#myModaljjjs" data-id="'.$snoid.'"  ><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
	}
	if($tabVal == 'All'){
		if($admin_status_crs == "Yes"){	
			$applicationStatus1 = '<span class="btn btn-sm jmjm" data-toggle="modal" data-target="#myModaljjjs" data-id="'.$snoid.'"  ><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
		}else{
			$applicationStatus1 = '<a href="edit.php?apid='.base64_encode($snoid).'" class="btn btn-sm editbtn"><i class="fas fa-edit"  data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>';
		}
	}	
	if($admin_status_crs == ""){
		$applicationStatus = '<span class="btn btn-sm checklistClassyellow checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="'.$snoid.'"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Check Application Status(Pending)"></i></span>';
	}
	if($admin_status_crs == "No"){
		$applicationStatus = '<span class="btn btn-sm checklistClassred checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="'.$snoid.'"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Application Not Approved (Check Remarks)"></i></span>';
	}
	if($admin_status_crs == "Yes"){
		$applicationStatus = '<span class="btn btn-sm checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="'.$snoid.'"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Application Approved by ACC (Processing Offer Letter)"></i></span>';
	}
	
	//Conditional Offer Letter
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){
		$col = '<span class="btn btn-success btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><i class="fas fa-download"  data-toggle="tooltip" data-placement="top" title="Download Conditional Offer Letter and Upload after Sign"></i></span>';
	}
	if($admin_status_crs == "No"){
		$col = '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="Application Not Approved by ACC"><i class="fas fa-times"></i></span>';
	}
	if(($admin_status_crs == "") && ($offer_letter == '') && ($ol_confirm == '')){
		$col = '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
	}
	if(($admin_status_crs == "Yes") && ($offer_letter == '') && ($ol_confirm == '')){
		$col = "<span style='color:yellow;' class='btn tfFileClass btn-sm' data-toggle='tooltip' data-placement='top' title='Processing Conditional Offer Letter'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '')){
		$col = "<span style='color:yellow;' class='btn tfFileClass btn-sm' data-toggle='tooltip' data-placement='top' title='Processing Conditional Offer Letter'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){
		$col = '<span class="btn checklistClassyellow btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><i class="fas fa-sync-alt"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Sent (Status Pending)"></i></span>';
	}
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No')){
		$col = '<span class="btn checklistClassred btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><i class="fas fa-sync-alt"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Not Approved (Check Remarks)"></i></span>';
	}
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes')){
		$col = '<span class="btn btn-success btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Approved"></i></span>';
	}
	
	//Request LOA
	if($signed_ol_confirm == '' || $signed_ol_confirm == 'No'){
		$rqstLoa = '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
	}
	if(($signed_ol_confirm == 'Yes') && ($file_receipt =='')){
		if($tabVal == 'All'){
		$rqstLoa = '<span class="btn btn-warning btn-sm loaRqst" idno="'.$snoid.'" style="width:82%;">Request LOA</span>';
		}
		if($tabVal == 'Sub'){
		$rqstLoa = '<input type="text" class="btn btn-warning btn-sm" value="Request LOA" style="width:58%;" readonly>';
		}
	}
	if(($signed_ol_confirm == 'Yes') && ($file_receipt !=='')){
		$rqstLoa = '<span class="btn btn-success btn-sm" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Requested LOA"></span></span>';		
	}
	
	//ACC Contract
	if($agreement_loa !== "1"){
		$aolCnt = '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
	}
	if(($agreement_loa == "1") && ($signed_agreement_letter =='')){
		$aolCnt = '<span class="btn btn-success btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Contract Sent (Upload Signed Contract)"></span></span>';
	}
	if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='')){
		$aolCnt = '<span class="btn checklistClassyellow btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Sent (Status Pending)"></span></span>';
	}
	if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='No')){
		$aolCnt = '<span class="btn checklistClassred btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Not Approved(Check Remarks)"></span></span>';
	}
	if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='Yes')){
		$aolCnt = '<span class="btn btn-success btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Approved (Processing LOA)"></span></span>';
	}
	
	//Download LOA
	if(($signed_al_status == '') || ($signed_al_status == 'No')){
		$dnldLoa = "<span class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='bottom' title='No Action Taken'><i class='fas fa-times'></i></span>";
	}
	if(($signed_al_status == 'Yes') && ($loa_file == '')){
		$dnldLoa = "<span class='btn checklistClassyellow btn-sm' data-toggle='tooltip' data-placement='top' title='LOA Processing'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($signed_al_status == 'Yes') && ($loa_file !== '') && ($loa_file_status == '')){
		$dnldLoa = "<span class='btn checklistClassgreen btn-sm' data-toggle='tooltip' data-placement='top' title='LOA Processing'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($signed_al_status == 'Yes') && ($loa_file !== '') && ($loa_file_status == '1')){ 
		$dnldLoa = "<a href='uploads/$loa_file' class='btn btn-success btn-sm' download><i class='fas fa-download'></i></a>";
	}	
	
////-------------------///////	
  
	$res1[] = array(
		'sno' => $snoid,
		'chbx' => $chkbx,
		'chkbx1' => $chkbx1,
		'agntname' => $agntname,
		'fname' => $fname,
		'lname' => $lname,
		'prg_intake' => $prg_intake,
		'prg_name' => $prg_name1,
		'appliStatus' => $applicationStatus1.' '.$applicationStatus,
		'col' => $col,
		'rqstLoa' => $rqstLoa,
		'aolCnt' => $aolCnt,
		'dnldLoa' => $dnldLoa
	);
	}
	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


if($_GET['tag'] === "Select_Status"){	
	$tabVal = $_POST['roletype'];
	$status1 = $_POST['status1'];
	$uname1 = $_POST['subid'];
	$rowbg = $_POST['rowbg'];
if($tabVal == 'All'){
	// Agent Name
	if(($status1 == 'ascAname') || ($status1 == 'descAname')){				
		if($status1 == 'ascAname'){
			$as = "where user_id = '$sessionSno' ORDER BY user_id ASC";
		}
		if($status1 == 'descAname'){
			$as = "where user_id = '$sessionSno' ORDER BY user_id DESC";
		}
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// Full Name
	if(($status1 == 'ascname') || ($status1 == 'descname')){				
		if($status1 == 'ascname'){
			$as = "where user_id = '$sessionSno' ORDER BY fname ASC, lname ASC";
		}
		if($status1 == 'descname'){
			$as = "where user_id = '$sessionSno' ORDER BY fname DESC, lname DESC";
		}
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// Program Intake
	if(($status1 == 'ascintake') || ($status1 == 'descintake')){				
		if($status1 == 'ascintake'){
			$as = "where user_id = '$sessionSno' ORDER BY prg_intake ASC";
		}
		if($status1 == 'descintake'){
			$as = "where user_id = '$sessionSno' ORDER BY prg_intake DESC";
		}
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// Course Name
	if(($status1 == 'asccrsn') || ($status1 == 'desccrsn')){				
		if($status1 == 'asccrsn'){
			$as = "where user_id = '$sessionSno' ORDER BY prg_name1 ASC";
		}
		if($status1 == 'desccrsn'){
			$as = "where user_id = '$sessionSno' ORDER BY prg_name1 DESC";
		}
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// Application Status
	if(($status1 == 'asPending') || ($status1 == 'asYes') || ($status1 == 'asNo')){				
		if($status1 == 'asPending'){
			$as = "where user_id = '$sessionSno' AND admin_status_crs=''";
		}elseif($status1 == 'asYes'){
			$as = "where user_id = '$sessionSno' AND admin_status_crs='Yes'";
		}elseif($status1 == 'asNo'){
			$as = "where user_id = '$sessionSno' AND admin_status_crs= 'No'";
		}
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// Conditional Offer Letter
	if(($status1 == 'col_Pending') || ($status1 == 'col_Recieved') || ($status1 == 'col_Signed_Sent') || ($status1 == 'col_Approved')){		
		if(($status1 == 'col_Pending') || ($status1 == '')){
			$as = "where user_id = '$sessionSno' AND ol_confirm='' AND offer_letter=''";
		}elseif($status1 == 'col_Recieved'){
			$as = "where user_id = '$sessionSno' AND ol_confirm !='' AND offer_letter !=''";
		}elseif($status1 == 'col_Signed_Sent'){
			$as = "where user_id = '$sessionSno' AND agreement !=''";
		}elseif($status1 == 'col_Approved'){
			$as = "where user_id = '$sessionSno' AND signed_ol_confirm='Yes'";
		}		
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// Request LOA	
	if(($status1 == 'lrs_Pending') || ($status1 == 'lrs_rs')){
		if(($status1 == 'lrs_Pending') || ($status1 == '')){
			$as = "where user_id = '$sessionSno' AND file_receipt=''";
		}elseif($status1 == 'lrs_rs'){
			$as = "where user_id = '$sessionSno' AND file_receipt!=''";
		}
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// ACC Contract	
	if(($status1 == 'aolc_Pending') || ($status1 == 'aolc_Recieved') || ($status1 == 'aolc_Signed_Sent') || ($status1 == 'aolc_Approved')){		
		if(($status1 == 'aolc_Pending') || ($status1 == '')){
			$as = "where user_id = '$sessionSno' AND contract_letter='' AND agreement_loa=''";
		}elseif($status1 == 'aolc_Recieved'){
			$as = "where user_id = '$sessionSno' AND contract_letter !='' AND agreement_loa !=''";
		}elseif($status1 == 'aolc_Signed_Sent'){
			$as = "where user_id = '$sessionSno' AND signed_agreement_letter !=''";
		}elseif($status1 == 'aolc_Approved'){
			$as = "where user_id = '$sessionSno' AND signed_al_status='Yes'";
		}		
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// Upload LOA	
	if(($status1 == 'loa_Pending') || ($status1 == 'loa_Processing') || ($status1 == 'loa_Recieved')){		
		if(($status1 == 'loa_Pending') || ($status1 == '')){
			$as = "where user_id = '$sessionSno' AND loa_file='' AND signed_al_status!='No'";
		}elseif($status1 == 'loa_Processing'){
			$as = "where user_id = '$sessionSno' AND loa_file !='' AND signed_al_status='Yes' AND loa_file_status=''";
		}elseif($status1 == 'loa_Recieved'){
			$as = "where user_id = '$sessionSno' AND loa_file !='' AND loa_file_status='1'";
		}		
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	// V-R Status	
	if(($status1 == 'vgr_Pending') || ($status1 == 'vgr_VG') || ($status1 == 'vgr_VR') || ($status1 == 'vgr_refund_rqst_sent') || ($status1 == 'vgr_refund_apprd')){		
		if(($status1 == 'vgr_Pending') || ($status1 == '')){
			$as = "where user_id = '$sessionSno' AND fh_status='' AND v_g_r_status=''";
		}elseif($status1 == 'vgr_VG'){
			$as = "where user_id = '$sessionSno' AND v_g_r_status='V-G' AND fh_status!=''";
		}elseif($status1 == 'vgr_VR'){
			$as = "where user_id = '$sessionSno' AND v_g_r_status='V-R' AND fh_status!=''";
		}elseif($status1 == 'vgr_refund_rqst_sent'){
			$as = "where user_id = '$sessionSno' AND file_upload_vr_status='Yes'";
		}elseif($status1 == 'vgr_refund_apprd'){
			$as = "where user_id = '$sessionSno' AND tt_upload_report_status='Yes'";
		}
			
		$rsltQuery = "SELECT * FROM st_application $as";
	}
	
}
// die;

if($tabVal == 'Sub'){
	$quryHead = "SELECT head,sub FROM agent_admin where head='$sessionSno'";
	$qrymy = mysqli_query($con, $quryHead);
	if(mysqli_num_rows($qrymy)){
	while ($rowhead = mysqli_fetch_assoc($qrymy)) {
		$sub[] = $rowhead['sub'];
	}	
	$arrImpld = implode(",",$sub);
	
	// Agent Name
	if(($status1 == 'ascAname') || ($status1 == 'descAname')){				
		if($status1 == 'ascAname'){
			$total_id = 'user_id IN ('.$arrImpld.') ORDER BY user_id ASC';
		}
		if($status1 == 'descAname'){
			$total_id = 'user_id IN ('.$arrImpld.') ORDER BY user_id DESC';
		}
	}
	// Full Name
	if(($status1 == 'ascname') || ($status1 == 'descname')){	
		if($status1 == 'ascname'){
			$total_id = 'user_id IN ('.$arrImpld.') ORDER BY fname ASC, lname ASC';
		}
		if($status1 == 'descname'){
			$total_id = 'user_id IN ('.$arrImpld.') ORDER BY fname DESC, lname DESC';
		}
	}
	// Program Intake
	if(($status1 == 'ascintake') || ($status1 == 'descintake')){				
		if($status1 == 'ascintake'){
			$total_id = 'user_id IN ('.$arrImpld.') ORDER BY prg_intake ASC';
		}
		if($status1 == 'descintake'){
			$total_id = 'user_id IN ('.$arrImpld.') ORDER BY prg_intake DESC';
		}
	}
	// Course Name
	if(($status1 == 'asccrsn') || ($status1 == 'desccrsn')){				
		if($status1 == 'asccrsn'){
			$total_id = 'user_id IN ('.$arrImpld.') ORDER BY prg_name1 ASC';
		}
		if($status1 == 'desccrsn'){
			$total_id = 'user_id IN ('.$arrImpld.') ORDER BY prg_name1 DESC';
		}
	}
	// Application Status
	if(($status1 == 'asPending') || ($status1 == 'asYes') || ($status1 == 'asNo')){				
		if($status1 == 'asPending'){
			$total_id = "user_id IN (".$arrImpld.") AND admin_status_crs=''";
		}elseif($status1 == 'asYes'){
			$total_id = "user_id IN (".$arrImpld.") AND admin_status_crs='Yes'";
		}elseif($status1 == 'asNo'){
			$total_id = "user_id IN (".$arrImpld.") AND admin_status_crs= 'No'";
		}
	}
	// Conditional Offer Letter	
	if(($status1 == 'col_Pending') || ($status1 == 'col_Recieved') || ($status1 == 'col_Signed_Sent') || ($status1 == 'col_Approved')){		
		if(($status1 == 'col_Pending') || ($status1 == '')){
			$total_id = "user_id IN (".$arrImpld.") AND ol_confirm='' AND offer_letter=''";
		}elseif($status1 == 'col_Recieved'){
			$total_id = "user_id IN (".$arrImpld.") AND ol_confirm !='' AND offer_letter !=''";
		}elseif($status1 == 'col_Signed_Sent'){
			$total_id = "user_id IN (".$arrImpld.") AND agreement !=''";
		}elseif($status1 == 'col_Approved'){
			$total_id = "user_id IN (".$arrImpld.") AND signed_ol_confirm='Yes'";
		}	
	}	
	// Request LOA	
	if(($status1 == 'lrs_Pending') || ($status1 == 'lrs_rs')){
		if(($status1 == 'lrs_Pending') || ($status1 == '')){
			$total_id = "user_id IN (".$arrImpld.") AND file_receipt=''";
		}elseif($status1 == 'lrs_rs'){
			$total_id = "user_id IN (".$arrImpld.") AND file_receipt!=''";
		}
	}
	// ACC Contract
	if(($status1 == 'aolc_Pending') || ($status1 == 'aolc_Recieved') || ($status1 == 'aolc_Signed_Sent') || ($status1 == 'aolc_Approved')){		
		if(($status1 == 'aolc_Pending') || ($status1 == '')){
			$total_id = "user_id IN (".$arrImpld.") AND contract_letter='' AND agreement_loa=''";
		}elseif($status1 == 'aolc_Recieved'){
			$total_id = "user_id IN (".$arrImpld.") AND contract_letter !='' AND agreement_loa !=''";
		}elseif($status1 == 'aolc_Signed_Sent'){
			$total_id = "user_id IN (".$arrImpld.") AND signed_agreement_letter !=''";
		}elseif($status1 == 'aolc_Approved'){
			$total_id = "user_id IN (".$arrImpld.") AND signed_al_status='Yes'";
		}	
	}
	// Download LOA
	if(($status1 == 'loa_Pending') || ($status1 == 'loa_Processing') || ($status1 == 'loa_Recieved')){
		if(($status1 == 'loa_Pending') || ($status1 == '')){
			$total_id = "user_id IN (".$arrImpld.") AND loa_file='' AND signed_al_status!='No'";
		}elseif($status1 == 'loa_Processing'){
			$total_id = "user_id IN (".$arrImpld.") AND loa_file !='' AND signed_al_status='Yes' AND loa_file_status=''";
		}elseif($status1 == 'loa_Recieved'){
			$total_id = "user_id IN (".$arrImpld.") AND loa_file !='' AND loa_file_status='1'";
		}		
	}
	// V-R Status	
	if(($status1 == 'vgr_Pending') || ($status1 == 'vgr_VG') || ($status1 == 'vgr_VR') || ($status1 == 'vgr_refund_rqst_sent') || ($status1 == 'vgr_refund_apprd')){		
		if(($status1 == 'vgr_Pending') || ($status1 == '')){
			$as = "user_id IN (".$arrImpld.") AND fh_status='' AND v_g_r_status=''";
		}elseif($status1 == 'vgr_VG'){
			$as = "user_id IN (".$arrImpld.") AND v_g_r_status='V-G' AND fh_status!=''";
		}elseif($status1 == 'vgr_VR'){
			$as = "user_id IN (".$arrImpld.") AND v_g_r_status='V-R' AND fh_status!=''";
		}elseif($status1 == 'vgr_refund_rqst_sent'){
			$as = "user_id IN (".$arrImpld.") AND file_upload_vr_status='Yes'";
		}elseif($status1 == 'vgr_refund_apprd'){
			$as = "user_id IN (".$arrImpld.") AND tt_upload_report_status='Yes'";
		}
	}	
	
	}else{
		$total_id = 'user_id IN ('.$sessionSno.')';
	}
	$rsltQuery = "SELECT * FROM st_application where application_form='1' AND $total_id";
}
	// echo $rsltQuery;
	// die;
	$qurySql = mysqli_query($con, $rsltQuery);
	while ($row = mysqli_fetch_assoc($qurySql)) {
	 $snoid = mysqli_real_escape_string($con, $row['sno']);
	 $user_id1 = mysqli_real_escape_string($con, $row['user_id']);
	 $fname = mysqli_real_escape_string($con, $row['fname']);
	 $lname = mysqli_real_escape_string($con, $row['lname']);
	 $dob = mysqli_real_escape_string($con, $row['dob']);
	 $dob_1 = date("F j, Y", strtotime($dob));
	 $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
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
	 $file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);
	 $fh_status = mysqli_real_escape_string($con, $row['fh_status']);
	 $v_g_r_status = mysqli_real_escape_string($con, $row['v_g_r_status']);
	 $tt_upload_report_status = mysqli_real_escape_string($con, $row['tt_upload_report_status']);
	 $file_upload_vr_status = mysqli_real_escape_string($con, $row['file_upload_vr_status']);

	$agnt_qry = mysqli_query($con,"SELECT username FROM allusers where sno='$user_id1'");
		while ($row_agnt_qry = mysqli_fetch_assoc($agnt_qry)) {
		$agntname = mysqli_real_escape_string($con, $row_agnt_qry['username']);
	}
	// die;
	
	if($rowbg == 'error_'.$snoid){
		$chkbx = "class='$rowbg'".' '."style='background-color: rgb(168, 216, 244);'";
		$chkbx1 = '<input type="checkbox" id="error_'.$snoid.'" checked="checked">';
	}else{
		$chkbx = "class=error_$snoid";
		$chkbx1 = '<input type="checkbox" id="error_'.$snoid.'">';
	}
		
	//Application Status
	
	if($tabVal == 'Sub'){
		$applicationStatus1 = '<span class="btn btn-sm jmjm" data-toggle="modal" data-target="#myModaljjjs" data-id="'.$snoid.'"  ><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
	}
	if($tabVal == 'All'){
		if($admin_status_crs == "Yes"){	
			$applicationStatus1 = '<span class="btn btn-sm jmjm" data-toggle="modal" data-target="#myModaljjjs" data-id="'.$snoid.'"  ><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="View Application"></i></span>';
		}else{
			$applicationStatus1 = '<a href="edit.php?apid='.base64_encode($snoid).'" class="btn btn-sm editbtn"><i class="fas fa-edit"  data-toggle="tooltip" data-placement="top" title="Edit Application"></i></a>';
		}
	}	
	if($admin_status_crs == ""){
		$applicationStatus = '<span class="btn btn-sm checklistClassyellow checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="'.$snoid.'"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Check Application Status(Pending)"></i></span>';
	}
	if($admin_status_crs == "No"){
		$applicationStatus = '<span class="btn btn-sm checklistClassred checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="'.$snoid.'"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Application Not Approved (Check Remarks)"></i></span>';
	}
	if($admin_status_crs == "Yes"){
		$applicationStatus = '<span class="btn btn-sm checklistClass" data-toggle="modal" data-target="#checklistModel" data-id="'.$snoid.'"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Application Approved by ACC (Processing Offer Letter)"></i></span>';
	}
	
	//Conditional Offer Letter
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement == '')){
		$col1 = '<span class="btn btn-success btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><i class="fas fa-download"  data-toggle="tooltip" data-placement="top" title="Download Conditional Offer Letter and Upload after Sign"></i></span>';
	}
	if($admin_status_crs == "No"){
		$col1 = '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="Application Not Approved by ACC"><i class="fas fa-times"></i></span>';
	}
	if(($admin_status_crs == "") && ($offer_letter == '') && ($ol_confirm == '')){
		$col1 = '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
	}
	if(($admin_status_crs == "Yes") && ($offer_letter == '') && ($ol_confirm == '')){
		$col1 = "<span style='color:yellow;' class='btn tfFileClass btn-sm' data-toggle='tooltip' data-placement='top' title='Processing Conditional Offer Letter'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '')){
		$col1 = "<span style='color:yellow;' class='btn tfFileClass btn-sm' data-toggle='tooltip' data-placement='top' title='Processing Conditional Offer Letter'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == '')){
		$col1 = '<span class="btn checklistClassyellow btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><i class="fas fa-sync-alt"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Sent (Status Pending)"></i></span>';
	}
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'No')){
		$col1 = '<span class="btn checklistClassred btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><i class="fas fa-sync-alt"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Not Approved (Check Remarks)"></i></span>';
	}
	if(($admin_status_crs == "Yes") && ($offer_letter !== '') && ($ol_confirm == '1') && ($agreement !== '') && ($signed_ol_confirm == 'Yes')){
		$col1 = '<span class="btn btn-success btn-sm ol_agreement" data-toggle="modal" data-target="#olAgreementModel" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><i class="fas fa-check"  data-toggle="tooltip" data-placement="top" title="Signed Conditional Offer Letter Approved"></i></span>';
	}
	
	//Request LOA
	if($signed_ol_confirm == '' || $signed_ol_confirm == 'No'){
		$rqstLoa = '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
	}
	if(($signed_ol_confirm == 'Yes') && ($file_receipt =='')){		
		if($tabVal == 'All'){
		$rqstLoa = '<span class="btn btn-warning btn-sm loaRqst" idno="'.$snoid.'" style="width:82%;">Request LOA</span>';
		}
		if($tabVal == 'Sub'){
		$rqstLoa = '<input type="text" class="btn btn-warning btn-sm" value="Request LOA" style="width:58%;" readonly>';
		}		
	}
	if(($signed_ol_confirm == 'Yes') && ($file_receipt !=='')){
		$rqstLoa = '<span class="btn btn-success btn-sm" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Requested LOA"></span></span>';		
	}
	
	//ACC Contract
	if($agreement_loa !== "1"){
		$aolCnt = '<span class="btn btn-sm btn-pending"  data-toggle="tooltip" data-placement="top" title="No Action Taken"><i class="fas fa-times"></i></span>';
	}
	if(($agreement_loa == "1") && ($signed_agreement_letter =='')){
		$aolCnt = '<span class="btn btn-success btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Contract Sent (Upload Signed Contract)"></span></span>';
	}
	if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='')){
		$aolCnt = '<span class="btn checklistClassyellow btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Sent (Status Pending)"></span></span>';
	}
	if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='No')){
		$aolCnt = '<span class="btn checklistClassred btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Signed Contract Not Approved(Check Remarks)"></span></span>';
	}
	if(($agreement_loa == "1") && ($signed_agreement_letter !=='') && ($signed_al_status =='Yes')){
		$aolCnt = '<span class="btn btn-success btn-sm agreeClass" data-toggle="modal" data-target="#checkAgree" data-id="'.$snoid.'" tabopen="'.$tabVal.'"><span class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Signed Contract Approved (Processing LOA)"></span></span>'; 
	}
	
	//Download LOA
	if(($signed_al_status == '') || ($signed_al_status == 'No')){
		$dnldLoa = "<span class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='bottom' title='No Action Taken'><i class='fas fa-times'></i></span>";
	}
	if(($signed_al_status == 'Yes') && ($loa_file == '')){
		$dnldLoa = "<span class='btn checklistClassyellow btn-sm' data-toggle='tooltip' data-placement='top' title='LOA Processing'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($signed_al_status == 'Yes') && ($loa_file !== '') && ($loa_file_status == '')){
		$dnldLoa = "<span class='btn checklistClassgreen btn-sm' data-toggle='tooltip' data-placement='top' title='LOA Processing'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($signed_al_status == 'Yes') && ($loa_file !== '') && ($loa_file_status == '1')){ 
		$dnldLoa = "<span class='btn checklistClassgreen btn-sm receiptClass' data-toggle='modal' data-target='#receiptModel' data-id=".$snoid."><i class='fas fa-download' data-toggle='tooltip' data-placement='top' title='LOA File Download'></i></span>";
	}

	//V-R Status
	if(($loa_file_status == '') && ($fh_status == '') && ($v_g_r_status == '')){
		$fh_VR_Status = "<span class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='bottom' title='No Action Taken'><i class='fas fa-times'></i></span>";
	}
	if(($loa_file_status == '1') && ($fh_status == '') && ($v_g_r_status == '')){ 
		$fh_VR_Status = "<span class='btn checklistClassyellow btn-sm' data-toggle='tooltip' data-placement='top' title='F@H Status Pending'><i class='fas fa-sync-alt'></i></span>";
	}
	if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status == '')){ 
		$fh_VR_Status = "<span class='btn checklistClassyellow btn-sm' data-toggle='tooltip' data-placement='top' data-id=".$snoid." tabopen=".$tabVal." title='F@H Status Approved'><i class='fas fa-check'></i></span>";
	}	
	
	if(($loa_file_status == '1') && ($fh_status !== '') && ($v_g_r_status !== '')){		
		if(($v_g_r_status == 'V-G')){
			$fh_VR_Status = "<span class='btn checklistClassgreen btn-sm' data-toggle='tooltip' data-placement='top' title='V-G' disabled>V-G</span>";
		}
		if($v_g_r_status == 'V-R'){
		if(($file_upload_vr_status == '') && ($tt_upload_report_status == '')){
			$fh_VR_Status = "<span class='btn checklistClassyellow btn-sm invoiceClass' data-toggle='modal' data-target='#invoiceModel' data-id=".$snoid."><i class='fas fa-upload' data-toggle='tooltip' data-placement='top' title='Upload Refund Forms'></i></span>";
		}
		if(($file_upload_vr_status !== '') && ($tt_upload_report_status == '')){
			$fh_VR_Status = "<span class='btn checklistClassgreen btn-sm invoiceClass' data-toggle='modal' data-target='#invoiceModel' data-id=".$snoid."><i class='fas fa-upload' data-toggle='tooltip' data-placement='top' title='Refund Forms Uploaded(Status Pending)'></i></span>";
		}
		if(($file_upload_vr_status !== '') && ($tt_upload_report_status == 'Yes')){
			$fh_VR_Status = "<span class='btn checklistClassgreen btn-sm invoiceClass' data-toggle='modal' data-target='#invoiceModel' data-id=".$snoid."><i class='fas fa-check' data-toggle='tooltip' data-placement='top' title='Refund Docs Approved(Processing Refund)'></i></span>";
		}
		if(($file_upload_vr_status !== '') && ($tt_upload_report_status == 'No')){
			$fh_VR_Status = "<span class='btn checklistClassgreen btn-sm invoiceClass' data-toggle='modal' data-target='#invoiceModel' data-id=".$snoid."><i class='fas fa-upload' data-toggle='tooltip' data-placement='top' title='Refund Files Status Not Approved'></i></span>";
		}
		}
	}
	
	
////-------------------///////

	$lname_1 = "$lname<br>$dob_1";
  
	$res1[] = array(
		'sno' => $snoid,
		'chbx' => $chkbx,
		'chkbx1' => $chkbx1,
		'agntname' => $agntname,
		'fname' => $fname,
		'lname' => $lname_1,
		'prg_intake' => $prg_intake,
		'prg_name' => $prg_name1,
		'appliStatus' => $applicationStatus1.' '.$applicationStatus,
		'col' => $col1,
		'rqstLoa' => $rqstLoa,
		'aolCnt' => $aolCnt,
		'dnldLoa' => $dnldLoa,
		'fh_VR_Status' => $fh_VR_Status,
	);
	}	
	
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "invoiceAgentList") {
	$idno = $_POST['idno'];
	$get_query = "SELECT * FROM st_application where sno='$idno'";
	$get_rslt = mysqli_query($con, $get_query);
	$rowstr = mysqli_fetch_assoc($get_rslt);
	$fh_status = $rowstr['fh_status'];
	$fh_status_updated_by = $rowstr['fh_status_updated_by'];
	$fh_re_lodgement = $rowstr['fh_re_lodgement'];	
	$v_g_r_status = $rowstr['v_g_r_status'];
	$comrefund_remarks = $rowstr['comrefund_remarks'];
	$v_g_r_invoice = $rowstr['v_g_r_invoice'];
	$v_g_r_amount = $rowstr['v_g_r_amount'];
	$vg_date = $rowstr['vg_date'];
	$vg_file = $rowstr['vg_file'];
	$com_refund_datetime = $rowstr['com_refund_datetime'];
	$file_upload_vgr = $rowstr['file_upload_vgr'];
	$file_upload_vgr2 = $rowstr['file_upload_vgr2'];
	$file_upload_vgr3 = $rowstr['file_upload_vgr3'];
	
	$file_upload_vgr_status = $rowstr['file_upload_vgr_status'];	
	$file_upload_vgr_remarks = $rowstr['file_upload_vgr_remarks'];	
	$file_upload_vgr_datetime = $rowstr['file_upload_vgr_datetime'];
	
	$file_upload_vr_remarks = $rowstr['file_upload_vr_remarks'];
	$file_upload_vr_datetime = $rowstr['file_upload_vr_datetime'];
	
	$tt_upload_report_status = $rowstr['tt_upload_report_status'];
	$tt_upload_report_remarks = $rowstr['tt_upload_report_remarks'];
	$tt_upload_report = $rowstr['tt_upload_report'];
	$tt_upload_report_datetime = $rowstr['tt_upload_report_datetime'];	
	$inovice_status = $rowstr['inovice_status'];
	$inovice_remarks = $rowstr['inovice_remarks'];
	$inovice_reciept = $rowstr['inovice_reciept'];
	$inovice_datetime = $rowstr['inovice_datetime'];
	$file_upload_vr_status = $rowstr['file_upload_vr_status'];
	$file_upload_vr_remarks = $rowstr['file_upload_vr_remarks'];
	$file_upload_vr_datetime = $rowstr['file_upload_vr_datetime'];
	$com_details_remarks_vr = $rowstr['com_details_remarks_vr'];
	$com_details_datetime_vr = $rowstr['com_details_datetime_vr'];	

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
		$fh_status_updated = '';
	}
	
	$fhgetVal = '<div class="fhstatuslist"><div class="remarkShow row border-0 mt-0"><p class="mt-3 mb-0 col-sm-5"><b>Status: </b><span style="color:green;">'.$fhst.'</span></p><p class="col-sm-7 mt-0 mt-sm-3 mb-0 "><b>Updated On: </b>'.$fh_status_updated.'</p></div></div>';
	
	$fhStatusDiv = $btnstatus.''.$fhgetVal;
	
	if($v_g_r_status == 'V-G'){
		$statusVal = '<p><b>You have selected Status: V-G(COMMISSION Details)</b><p><b>V-G File : <a href="../uploads/vg_files/'.$vg_file.'" download> Download</a></b><p><b>V-G Date: '.$vg_date.'</b>
		<a href="travel_doc_upload.php?st='.$idno.'" class="btn btn-sm btn-success mt-3 mb-3 float-right w-100" target="_blank">Upload Travel Documents</a></p>';
	}
	if($v_g_r_status == 'V-R'){
		$statusVal = '<p><b>You have selected Status: V-R(Refund Details)</b></p>';
	}
	if($v_g_r_status == ''){
		$statusVal = '<p><b>You have selected Status: Pending</b></p>';
	}

if($fh_status !== '' || $fh_re_lodgement !== ''){
	$VgVrStatusDiv = '<form method="post" action="../mysqldb.php" enctype="multipart/form-data" autocomplete="off">
<p class="mb-0 mt-3"><b>Select File Status: </b></p>
<div class="row">
<div class="col-8 col-sm-9">
<select name="v_g_r_status" class="form-control vgrClass mb-2" onchange="getval(this);" required>
<option value="">Select Option</option>
<option value="V-G">V-G</option>
<option value="V-R">V-R</option>
</select>
</div></div>
<div class="row" id="vg-dtls">
</div>
<div class="row">
<div class="col-4 col-sm-3">
<input type="hidden" name="rowbg1" class="rowbg1" value="">
<input type="hidden" name="snid" class="vgrsnid" value='.$idno.'>
<input type="submit" name="vgrBtn" value="Submit" class="btn btn-sm btn-success">

</div>
</div></form>';
}else{
	$VgVrStatusDiv = '';
}

$fh_status_div = $fhStatusDiv.''.$VgVrStatusDiv.''.$statusVal;

if($v_g_r_status == ''){
	$both_VG_VR_Status = '';
}

//// V-G Status ////
if($v_g_r_status == 'V-G'){
	if($v_g_r_invoice !== ''){
		$vgr_invoice = "<p><b>Invoice: </b><a href='../uploads/$v_g_r_invoice' download> Download</a></p>";
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
	
	if($com_refund_datetime !== ''){
		$com_refund_datetime1 = "<p><b>Updated On($v_g_r_status Status): </b>$com_refund_datetime</p>";
	}else{
		$com_refund_datetime1 = "<p><b>Updated On($v_g_r_status Status): </b><span style='color:red;'>N/A</span></p>";
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
		$reciept = "<p><b>Download TT: </b><a href='../uploads/$inovice_reciept' download> Download</a></p>";	
	}else{
		$reciept = '<p><b>Download TT: </b><span style="color:red;">N/A</span></p>';		
	}
	
	if($inovice_datetime !== ''){
		$inovice_datetime1 = "<p><b>Updated On: </b>$inovice_datetime</p>";	
	}else{
		$inovice_datetime1 = '<p><b>Updated On: </b><span style="color:red;">N/A</span></p>';
	}

$com_approved_report = '<p><b>Remarks For -(Commission Details Uploaded by Processor)</b></p>';	
	
	$both_VG_VR_Status = '<form method="post" action="../mysqldb.php" enctype="multipart/form-data" autocomplete="off">
<p class="mt-3 mb-0"><b>'.$v_g_r_status.' Status :</b></p><div class="row"><div class="col-sm-5">
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

//// V-R Status ////
if($v_g_r_status == 'V-R'){
	
	// refund_form File Download	
	// if($v_g_r_invoice !== ''){
		$vgr_file_clg = "<p><b>Refund Form: </b><a href='../backend/refund_form.docx' download> Download</a></p>";
	// }else{
		// $vgr_file_clg = '<p><b>Refund Form: </b><span style="color:red;">N/A</span></p>';
	// }

	if($file_upload_vr_remarks !== ''){
		$fileVr_remarks = "<p><b>Your Remarks: </b>$file_upload_vr_remarks</p>";
	}else{
		$fileVr_remarks = '<p><b>Your Remarks: </b><span style="color:red;">N/A</span></p>';
	}
	
	if($file_upload_vr_datetime !== ''){
		$fileVrDatetime = "<p><b>Updated On: </b>$file_upload_vr_datetime</p>";
	}else{
		$fileVrDatetime = "<p><b>Updated On: </b><span style='color:red;'>N/A</span></p>";
	}
	
	$agentUploadStatus = $fileVr_remarks.''.$fileVrDatetime;
	
	$agent_Refund_status = '<form method="post" action="../mysqldb.php" autocomplete="off">
<p><b>Any Remarks : </b></p>
<textarea name="file_upload_vr_remarks" class="form-control col-sm-12" required></textarea>
<input type="hidden" name="snid" value='.$idno.'>
<input type="submit" name="agentVRStatus" value="Save Documents and Remarks" class="btn btn-sm btn-success mt-2">
</form>' .$agentUploadStatus.'';

//// First File upload	
	if($file_upload_vgr != ""){
		$files_11 = '<a href="../uploads/'.$file_upload_vgr.'" id="imageDoc1Hide1" download>Download</a>
		<span id="removeDoc1" removeDoc1_id='.$idno.'><i class="fa fa-times" aria-hidden="true"></i></span>                             
		<div class="preview1"></div><span id="imageres1" style="display:none;"></span>';
		
		$files_12 = '<div class="col-sm-6 col-md-6">                                       
			  <input type="file" name="file_upload_vgr" class="form-control upload-image1" id="showbtn1" style="display:none;" />
			  </div>';
	} else {
		$files_11 = '<span id="imageres1" style="display:none;"></span>
		<div class="preview1"></div> 
		<span id="removeDoc1" removeDoc1_id='.$idno.' style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></span> ';
		
		$files_12 = '<input type="file" name="file_upload_vgr" class="form-control upload-image1" id="showbtn1" />';
	}
	
	
	$fileForm1 = '<table class="table table-bordered table-hover"><tr><td>Upload TT:<span style="color:red;">*</span></td>
	<td><form action="../fileUpload.php" enctype="multipart/form-data" class="form-horizontal-docu1" method="post">
'.$files_11.'<div class="progress1" style="display:none">
<div class="progress-bar1" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
</div><input type="hidden" name="asno" value='.$idno.' /><div class="errorMsg1" style="color:red;"></div>'.$files_12.'</form>
	</td>
	</tr>';
	
	
//// Second File upload	
	if($file_upload_vgr2 != ""){
		$files_21 = '<a href="../uploads/'.$file_upload_vgr2.'" id="imageDoc1Hide2" download>Download</a>
		<span id="removeDoc2" removeDoc2_id='.$idno.'><i class="fa fa-times" aria-hidden="true"></i></span>                             
		<div class="preview2"></div><span id="imageres2" style="display:none;"></span>';
		
		$files_22 = '<div class="col-sm-6 col-md-6">                                       
			  <input type="file" name="file_upload_vgr2" class="form-control upload-image2" id="showbtn2" style="display:none;" />
			  </div>';
	} else {
		$files_21 = '<span id="imageres2" style="display:none;"></span>
		<div class="preview2"></div> 
		<span id="removeDoc2" removeDoc2_id='.$idno.' style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></span> ';
		
		$files_22 = '<input type="file" name="file_upload_vgr2" class="form-control upload-image2" id="showbtn2" />';
	}
	
	
	$fileForm2 = '<tr><td>Refund Form:<span style="color:red;">*</span></td>
	<td><form action="../fileUpload.php" enctype="multipart/form-data" class="form-horizontal-docu2" method="post">
'.$files_21.'<div class="progress2" style="display:none">
<div class="progress-bar2" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
</div><input type="hidden" name="asno" value='.$idno.' /><div class="errorMsg2" style="color:red;"></div>'.$files_22.'</form>
	</td>
	</tr>';
	
//// Third File upload	
	if($file_upload_vgr3 != ""){
		$files_31 = '<a href="../uploads/'.$file_upload_vgr3.'" id="imageDoc1Hide3" download>Download</a>
		<span id="removeDoc3" removeDoc3_id='.$idno.'><i class="fa fa-times" aria-hidden="true"></i></span>                             
		<div class="preview3"></div><span id="imageres3" style="display:none;"></span>';
		
		$files_32 = '<div class="col-sm-6 col-md-6">                                       
			  <input type="file" name="file_upload_vgr3" class="form-control upload-image3" id="showbtn3" style="display:none;" />
			  </div>';
	} else {
		$files_31 = '<span id="imageres3" style="display:none;"></span>
		<div class="preview3"></div> 
		<span id="removeDoc3" removeDoc3_id='.$idno.' style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></span> ';
		
		$files_32 = '<input type="file" name="file_upload_vgr3" class="form-control upload-image3" id="showbtn3" />';
	}
	
	
	$fileForm3 = '<tr><td>Refusal Letter:<span style="color:red;">*</span></td>
	<td><form action="../fileUpload.php" enctype="multipart/form-data" class="form-horizontal-docu3" method="post">
'.$files_31.'<div class="progress3" style="display:none">
<div class="progress-bar3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
</div><input type="hidden" name="asno" value='.$idno.' /><div class="errorMsg3" style="color:red;"></div>'.$files_32.'</form>
	</td>
	</tr></table>';
	$both_VG_VR_Status = $vgr_file_clg.''.$fileForm1.''.$fileForm2.''.$fileForm3.''.$agent_Refund_status;
}

// Report page tt receipt
	if($tt_upload_report_status == 'Yes' && $tt_upload_report !== ''){
		$ttReceipt = "<div class='remarkShow mt-2'><div><p><b>TT Receipt: </b><a href='../uploads/$tt_upload_report' download> Download</a></p></div></div>";	
	}else{
		$ttReceipt = '';	
	}
		
	$res1[] = array(
		'statushead' => $fh_status_div,	
		'both_VG_VR_Status' => $both_VG_VR_Status,	
		'tt_report_upload' => $ttReceipt		
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "stuTravelAgent") {
	$idno = $_POST['idno'];
	$get_query = mysqli_query($con, "SELECT * FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$v_g_r_status = $rowstr['v_g_r_status'];
	
if(!empty($v_g_r_status)){
		$qpf = $rowstr['quarantine_plan'];
		$loa_receipt = $rowstr['loa_file'];
		$air_ticket = $rowstr['air_ticket'];
		$passport_file = $rowstr['idproof'];
		$stu_travel_updated_date = $rowstr['stu_travel_updated_date'];
		
	//// First File upload	
	if($qpf != ""){
		$qpf_11 = '<a href="../uploads/'.$qpf.'" download>Download</a>';
	} else {
		$qpf_11 = 'Pending';
	}
	
	$fileFormQpf1 = '<table class="table table-bordered table-hover"><tr><td>Quarantine Plan Form:<span style="color:red;">*</span></td>
	<td>'.$qpf_11.'</td>
	</tr>';
	
	//// Second File upload	
	if($loa_receipt != ""){
		$loa_receipt_11 = '<a href="../uploads/loa/'.$loa_receipt.'" download>Download</a>';
	} else {
		$loa_receipt_11 = 'Pending';
	}	
	
	$fileFormQpf2 = '<tr><td>LOA/Receipt:<span style="color:red;">*</span></td>
	<td>'.$loa_receipt_11.'</td>
	</tr>';
	
	//// Third File upload	
	if($air_ticket != ""){
		$air_ticket_11 = '<a href="../Students_Travelling/'.$air_ticket.'" id="imageDoc1Hide1_93" download>Download</a>
		<span id="removeDoc1_93" removeDoc1_id_93='.$idno.'><i class="fa fa-times" aria-hidden="true"></i></span>                             
		<div class="preview1_93"></div><span id="imageres1_93" style="display:none;"></span>';
		
		$air_ticket_12 = '<div class="col-sm-6 col-md-6">                                       
			  <input type="file" name="air_ticket" class="form-control upload-image1_93" id="showbtn1_93" style="display:none;" />
			  </div>';
	} else {
		$air_ticket_11 = '<span id="imageres1_93" style="display:none;"></span>
		<div class="preview1_93"></div> 
		<span id="removeDoc1_93" removeDoc1_id_93='.$idno.' style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></span> ';
		
		$air_ticket_12 = '<input type="file" name="air_ticket" class="form-control upload-image1_93" id="showbtn1_93" />';
	}
	
	
	$fileFormQpf3 = '<tr><td>Air Ticket:<span style="color:red;">*</span></td>
	<td><form action="../Students_Travelling.php" enctype="multipart/form-data" class="form-horizontal-docu1_93" method="post">
'.$air_ticket_11.'<div class="progress1_93" style="display:none">
<div class="progress-bar1_93" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
</div><input type="hidden" name="asno" value='.$idno.' /><div class="errorMsg1_93" style="color:red;"></div>'.$air_ticket_12.'</form>
	</td>
	</tr>';
	
	//// Passport upload	
	if($passport_file != ""){
		$passport_file_11 = '<a href="../uploads/'.$passport_file.'" download>Download</a>';
	} else {
		$passport_file_11 = 'Pending';
	}
	
	
	$fileFormQpf4 = '<tr><td>Passport:<span style="color:red;">*</span></td>
	<td>'.$passport_file_11.'</td>
	</tr></table>';
		
	$submitform = '<form method="post" action="../mysqldb.php">
<input type="hidden" name="snid" value="'.$idno.'">
<input type="submit" name="agentStuTravelbtn" value="Click to Save Documents" class="btn btn-sm btn-success mt-1 mb-3">
</form>';		
		
	$student_travel_div = '<p style="background-color:#47de6e;color: white;margin-top:10px;"><b>Students Travelling</b></p>'.$fileFormQpf1.''.$fileFormQpf2.''.$fileFormQpf3.''.$fileFormQpf4.''.$submitform;
}else{
	$student_travel_div = '';
}
	
	
	$res1[] = array(
		'student_travel_div' => $student_travel_div	
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}

if($_GET['tag'] == "getDropstatus") {
	$idno = $_POST['idno'];
	
	$get_query = mysqli_query($con, "SELECT file_receipt, loa_tt, loa_tt_remarks, agent_request_loa_datetime FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$file_receipt = $rowstr['file_receipt'];
	$loa_tt = $rowstr['loa_tt'];
	$loa_tt_remarks = $rowstr['loa_tt_remarks'];
	$agent_request_loa_datetime = $rowstr['agent_request_loa_datetime'];
	
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
	
	// if(!empty($loa_tt_remarks)){
		// $loa_tt_remarks_1 = "<p><b>Remarks: </b>$loa_tt_remarks</p>";	
	// }else{
		$loa_tt_remarks_1 = '';
	// }
	
	if(!empty($agent_request_loa_datetime)){
		$agent_request_loa_datetime_1 = "<p><b>Remarks: </b>$agent_request_loa_datetime</p>";	
	}else{
		$agent_request_loa_datetime_1 = '';
	}
	
	$loaReceipt_2 = $loaReceipt.''.$loa_tt_1.''.$loa_tt_remarks_1.''.$agent_request_loa_datetime_1;
	
	$res1[] = array(
		'loaReceipt' => $loaReceipt_2		
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


if($_GET['tag'] == "getLoaReceipt") {
	$idno = $_POST['idno'];
	
	$get_query = mysqli_query($con, "SELECT user_id, loa_file, loa_receipt_file, loa_receipt_file_admin, support_letter, college_tt FROM st_application where sno='$idno'");
	$rowstr = mysqli_fetch_assoc($get_query);
	$user_id = $rowstr['user_id']; 
	$loa_receipt_file = $rowstr['loa_receipt_file']; 
	$loa_receipt_file_admin = $rowstr['loa_receipt_file_admin'];
	$college_tt = $rowstr['college_tt'];	
	$loa_file = $rowstr['loa_file'];
	$support_letter = $rowstr['support_letter'];
	
	if($loa_file !=''){
		$loa_file_1 = "<p><b>LOA File: </b><a href='uploads/$loa_file' download>Download</a></p>";
	}else{
		$loa_file_1 = '<p><b>LOA File: </b><span style="color:red;">N/A</span></p>';
	}
				
	// if($loa_receipt_file !=''){
		// $loa_receipt_file_1 = "<p><b>Receipt: </b><a href='../backend/LOA_Receipt/$loa_receipt_file' download>Download</a></p>";
	// }else{
		$loa_receipt_file_1 = ''; 
	// }
	
	// if($sessionSno == '2' || $sessionSno == '1029' || $sessionSno == '3' || $sessionSno == '38'){
		// if(!empty($loa_receipt_file_admin)){
			// $loa_receipt_file_2 = "<p><b>Receipt2: </b><a href='uploads/$loa_receipt_file_admin' download>Download</a></p>";
		// }else{
			// $loa_receipt_file_2 = ''; 
		// }
	// }else{
		$loa_receipt_file_2 = ''; 
	// }
	
	// if($college_tt !=''){
		// $college_tt_1 = "<p><b>Receipt: </b><a href='../uploads/$college_tt' download>Download</a></p>"; //College TT
	// }else{
		$college_tt_1 = '';
	// }

// if($user_id == '1136'){
	// $support_letter_2 = '';
// }else{
	// if($support_letter !=''){
		// $support_letter_2 = "<p><b>Support Letter: </b><a href='../uploads/sl/$support_letter' download>Download</a></p>"; //College TT
	// }else{
		$support_letter_2 = '';
	// }
// }
	
	$getloaReceiptFile = $loa_file_1.' '.$loa_receipt_file_1.' '.$loa_receipt_file_2.' '.$college_tt_1.' '.$support_letter_2;
	
	$res1[] = array(
		'getloaReceiptFile' => $getloaReceiptFile		
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if($_GET['tag'] == "AddAOLId"){
    $aolid = $_POST['aolid'];    
    $aolqury = "SELECT aolid FROM aol_student_id order by sno desc limit 1";
	$get_query = mysqli_query($con, $aolqury);
	$rowstr = mysqli_fetch_assoc($get_query);
	$aolid_1 = $rowstr['aolid'];

	for($i=1; $i <=$aolid; $i++){
		$last_id = $aolid_1+$i;
		$inserted_query = "INSERT INTO `aol_student_id` (`aolid`) VALUES ('$last_id')";
		mysqli_query($con, $inserted_query);			
	}
	echo '1';
	die;
}

if($_GET['tag'] == "AddAOLId_2"){
    $aolid = $_POST['aolid_2'];    
    $aolqury = "SELECT aolid FROM ham_aol_student_id order by sno desc limit 1";
	$get_query = mysqli_query($con, $aolqury);
	$rowstr = mysqli_fetch_assoc($get_query);
	$aolid_2 = $rowstr['aolid'];
	$aolid_1 = explode("H", $aolid_2);

	for($i=1; $i <=$aolid; $i++){
		$last_id_3 = $aolid_1[1]+$i;
		$last_id = 'H'.$last_id_3;
		$inserted_query = "INSERT INTO `ham_aol_student_id` (`aolid`) VALUES ('$last_id')";
		mysqli_query($con, $inserted_query);			
	}
	echo '1';
	die;
}

if($_GET['tag'] == "AddAOLId_3"){
    $aolid = $_POST['aolid_3'];    
    $aolqury = "SELECT aolid FROM brm_aol_student_id order by sno desc limit 1";
	$get_query = mysqli_query($con, $aolqury);
	$rowstr = mysqli_fetch_assoc($get_query);
	$aolid_2 = $rowstr['aolid'];
	$aolid_1 = explode("B", $aolid_2);

	for($i=1; $i <=$aolid; $i++){
		$last_id_3 = $aolid_1[1]+$i;
		$last_id = 'B'.$last_id_3;
		$inserted_query = "INSERT INTO `brm_aol_student_id` (`aolid`) VALUES ('$last_id')";
		mysqli_query($con, $inserted_query);			
	}
	echo '1';
	die;
}

if($_GET['tag'] == "AddLOAReceipt"){
    $aolid = $_POST['aolid'];    
    $aolqury = "SELECT loaid FROM loa_receipt_id order by sno desc limit 1";
	$get_query = mysqli_query($con, $aolqury);
	$rowstr = mysqli_fetch_assoc($get_query);
	$aolid_2 = $rowstr['loaid'];
	$aolid_1 = explode("A", $aolid_2);

	for($i=1; $i <=$aolid; $i++){
		$last_id_1 = $aolid_1[1]+$i;
		$last_id = 'A'.''.$last_id_1;
		$inserted_query = "INSERT INTO `loa_receipt_id` (`loaid`) VALUES ('$last_id')";
		mysqli_query($con, $inserted_query);			
	}
	echo '1';
	die;
}

if($_GET['tag'] == "AddLOAReceipt_h"){
    $aolid = $_POST['aolid_h'];    
    $aolqury = "SELECT loaid FROM ham_loa_receipt_id order by sno desc limit 1";
	$get_query = mysqli_query($con, $aolqury);
	$rowstr = mysqli_fetch_assoc($get_query);
	$aolid_2 = $rowstr['loaid'];
	$aolid_1 = explode("H", $aolid_2);

	for($i=1; $i <=$aolid; $i++){
		$last_id_1 = $aolid_1[1]+$i;
		$last_id = 'H'.''.$last_id_1;
		$inserted_query = "INSERT INTO `ham_loa_receipt_id` (`loaid`) VALUES ('$last_id')";
		mysqli_query($con, $inserted_query);			
	}
	echo '1';
	die;
}

if($_GET['tag'] == "AddLOAReceipt_B"){
    $aolid = $_POST['aolid_B'];    
    $aolqury = "SELECT loaid FROM brm_loa_receipt_id order by sno desc limit 1";
	$get_query = mysqli_query($con, $aolqury);
	$rowstr = mysqli_fetch_assoc($get_query);
	$aolid_2 = $rowstr['loaid'];
	$aolid_1 = explode("B", $aolid_2);

	for($i=1; $i <=$aolid; $i++){
		$last_id_1 = $aolid_1[1]+$i;
		$last_id = 'B'.''.$last_id_1;
		$inserted_query = "INSERT INTO `brm_loa_receipt_id` (`loaid`) VALUES ('$last_id')";
		mysqli_query($con, $inserted_query);			
	}
	echo '1';
	die;
}

if($_GET['tag'] == "getAolWithoutTT"){
    $idno = $_POST['idno'];
	
	$query2 = "SELECT user_id, dob FROM `st_application` where sno='$idno'";
	$rslt2 = mysqli_query($con, $query2);	
	$rowWithTT2 = mysqli_fetch_assoc($rslt2);
	$user_id = $rowWithTT2['user_id'];
	// $dob = $rowWithTT2['dob'];
	// if($user_id == '2' || $user_id == '3'){
		// $withttDiv = '';
	// }else{
	
	// $query = "SELECT * FROM `without_tt` where st_app_id!='' AND st_app_id='$idno'";
	// $rslt = mysqli_query($con, $query);
	// if(mysqli_num_rows($rslt)){
		// $rowWithTT = mysqli_fetch_assoc($rslt);
		// $gc_username = $rowWithTT['gc_username'];
		
		// $color = $rowWithTT['color'];
		// if(!empty($color)){ $color_checked ="checked"; }else{ $color_checked =""; }
		
		// $country = $rowWithTT['country'];
		// if(!empty($country)){ $country_checked = "checked"; }else{ $country_checked = ""; }
		
		// $favourite_person = $rowWithTT['favourite_person'];
		// if(!empty($favourite_person)){ $favourite_person_checked = "checked"; }else{ $favourite_person_checked = ""; }
		
		// $city = $rowWithTT['city'];
		// if(!empty($city)){ $city_checked = "checked"; }else{ $city_checked = ""; }
		
		// $pet = $rowWithTT['pet'];
		// if(!empty($pet)){ $pet_checked = "checked"; }else{ $pet_checked = ""; }
		
		// $sport = $rowWithTT['sport'];
		// if(!empty($sport)){ $sport_checked = "checked"; }else{ $sport_checked = ""; }
		
		// $memorable_day = $rowWithTT['memorable_day'];
		// if(!empty($memorable_day)){ $memorable_day_checked = "checked"; }else{ $memorable_day_checked = ""; }
		
		// $car = $rowWithTT['car'];
		// if(!empty($car)){ $car_checked = "checked"; }else{ $car_checked = ""; }
		
		// $movie = $rowWithTT['movie'];
		// if(!empty($movie)){ $movie_checked = "checked"; }else{ $movie_checked = ""; }
		// $btnwithtt = "display:block;";
		
		// $withttDiv = '<div class="withoutTT" style="'.$btnwithtt.'">
		// <b style="text-decoration:underline;"><center>Request LOA Without TT </center></b><br>
		// <b style="color:red;">Note: </b>4 Question are mondatory to be Answered<br>
		// <b>Question & Answers to be Followed: </b><br>
		// <label>Q1: GC Key Username. </label>
		// <p>A1: <input type="input" name="gc_username" value="'.$gc_username.'" class="gc_username"></p>
		// <label>Q2: Password </label>
		// <p>A2: Aol@1234</p>
		// <label>Q3: What is your favorite Color?</label>
		// <p>A3: Black <input type="checkbox" name="color" value="Black" '.$color_checked.' class="ttwot"></p>
		// <label>Q4: Which is your favorite Country?</label>
		// <p>A4: India <input type="checkbox" name="country" value="India" '.$country_checked.' class="ttwot"></p>
		// <label>Q5: Which is your favorite Person?</label>
		// <p>A5: My Mother <input type="checkbox" name="favourite_person" value="My Mother" '.$favourite_person_checked.' class="ttwot"></p>
		// <label>Q6: Which is your favorite city?</label>
		// <p>A6: Chandigarh <input type="checkbox" name="city" value="Chandigarh" '.$city_checked.' class="ttwot"></p>
		// <label>Q7: Who is you name of your pet?</label>
		// <p>A7: Tommy <input type="checkbox" name="pet" value="Tommy" '.$pet_checked.' class="ttwot"></p>		
		// <label>Q8: Which is your favorite Sport?</label>
		// <p>A8: Cricket <input type="checkbox" name="sport" value="Cricket" '.$sport_checked.' class="ttwot"></p>		
		// <label>Q9: Which is your memorable day?</label>
		// <p>A9: '.$dob.' <input type="checkbox" name="memorable_day" value="'.$dob.'" '.$memorable_day_checked.' class="ttwot"></p>
		// <label>Q10: Which your favorite Car?</label>
		// <p>A10: Maruti <input type="checkbox" name="car" value="Maruti" '.$car_checked.' class="ttwot"></p>
		// <label>Q11: Which your favorite Movie?</label>
		// <p>A11: Jab We Met <input type="checkbox" name="movie" value="Jab We Met" '.$movie_checked.' class="ttwot"></p>		
	// </div>';
		
	// }else{
		// $gc_username = '';
		// $color_checked = '';
		// $country_checked = '';
		// $favourite_person_checked = '';
		// $city_checked = '';
		// $pet_checked = '';
		// $sport_checked = '';
		// $memorable_day_checked = '';
		// $car_checked = '';
		// $movie_checked = '';
		// $btnwithtt = "display:none;";
		
		// $withttDiv = '<div class="withoutTT" style="'.$btnwithtt.'">
		// <b style="text-decoration:underline;"><center>Request LOA Without TT </center></b><br>
		// <b style="color:red;">Note: </b>4 Question are mondatory to be Answered<br>
		// <b>Question & Answers to be Followed: </b><br>
		// <label>Q1: GC Key Username. </label>
		// <p>A1: <input type="input" name="gc_username" value="'.$gc_username.'" class="gc_username"></p>
		// <label>Q2: Password </label>
		// <p>A2: Aol@1234</p>
		// <label>Q3: What is your favorite Color?</label>
		// <p>A3: Black <input type="checkbox" name="color" value="Black" '.$color_checked.'></p>
		// <label>Q4: Which is your favorite Country?</label>
		// <p>A4: India <input type="checkbox" name="country" value="India" '.$country_checked.'></p>
		// <label>Q5: Which is your favorite Person?</label>
		// <p>A5: My Mother <input type="checkbox" name="favourite_person" value="My Mother" '.$favourite_person_checked.'></p>
		// <label>Q6: Which is your favorite city?</label>
		// <p>A6: Chandigarh <input type="checkbox" name="city" value="Chandigarh" '.$city_checked.'></p>
		// <label>Q7: Who is you name of your pet?</label>
		// <p>A7: Tommy <input type="checkbox" name="pet" value="Tommy" '.$pet_checked.'></p>		
		// <label>Q8: Which is your favorite Sport?</label>
		// <p>A8: Cricket <input type="checkbox" name="sport" value="Cricket" '.$sport_checked.'></p>		
		// <label>Q9: Which is your memorable day?</label>
		// <p>A9: '.$dob.' <input type="checkbox" name="memorable_day" value="'.$dob.'" '.$memorable_day_checked.'></p>
		// <label>Q10: Which your favorite Car?</label>
		// <p>A10: Maruti <input type="checkbox" name="car" value="Maruti" '.$car_checked.'></p>
		// <label>Q11: Which your favorite Movie?</label>
		// <p>A11: Jab We Met <input type="checkbox" name="movie" value="Jab We Met" '.$movie_checked.'></p>		
	// </div>';
	// }
	// }
	$withttDiv = '';
	
	if($user_id == '1136'){
		$notShowWithOutTT = '';
	}else{
		$notShowWithOutTT = '<option value="Request LOA Without TT">Request LOA Without TT</option>';
	}
	
	$getWithoutTTVal = '<form id="uploadForm" action="../mysqldb.php" method="post" enctype="multipart/form-data">
	<select class="form-control rqstSelected mb-3">
		<option value="">Select Option</option>
		<option value="Request LOA With TT">Request LOA With TT</option>
		'.$notShowWithOutTT.'
	</select>
	<div class="upload_tt" style="display:none;">
	<b style="text-decoration:underline;"><center>Request LOA With TT </center></b><br>
	<label>Upload TT: </label>
		<input type="file" name="loa_tt" class="form-control loa_tt mb-2">
	</div>
	'.$withttDiv.'
	<p class="rqustloa" style="display:none;">
		<input type="hidden" name="idno" class="loaRqst_sno" value="'.$idno.'">
		<input type="hidden" name="agntid" class="loaRqst_sno" value="'.$user_id.'">
		<input type="submit" name="loaRqstbtn" value="Request LOA Submit" class="btn btn-success btn-sm loaRqstbtn" />
	</p>
</form>';

	$res1[] = array(
		'getWithoutTTVal' => $getWithoutTTVal		
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}

if($_GET['tag'] == "getqrnPlan"){
	$idno = $_POST['idno'];
	$get_query2 = "SELECT sno, quarantine_plan, quarantine_datetime FROM st_application where sno='$idno'";
	$get_query = mysqli_query($con, $get_query2);
	$rowstr = mysqli_fetch_assoc($get_query);
	$quarantine_plan = $rowstr['quarantine_plan'];
	$quarantine_datetime = $rowstr['quarantine_datetime'];
	
	if(empty($quarantine_plan)){
		$btn = 'Submit';
		$btnColor = 'warning';
	}else{
		$btn = 'Re-Submit';
		$btnColor = 'success';
	}
	
$getQrnPlanList2 = '<form action="../mysqldb.php" method="post" enctype="multipart/form-data" class="form_bg col-12">
	<p class="upload_tt">
	<label class="w-100">Upload Quarantine Plan</label>
		<input type="file" name="quarantine_plan" class="form-control" required>
	    <span style="color:red;">Upload JPG, PNG and PDF file</span>
	</p>
	<div class="rqustloa col-12 p-0">
		<input type="hidden" name="idno" value="'.$idno.'">
		<input type="submit" name="qrnPlanbtn" value="'.$btn.'" class="btn btn-'.$btnColor.' float-right btn-sm" /><br><br>
	</div>
</form>';

	if(!empty($quarantine_plan)){
		$quarantine_plan2 = "<p><b>Quarantine Plan: </b><a href='../uploads/$quarantine_plan' download>Download</a></p>";
	}else{
		$quarantine_plan2 = '<p><b>Quarantine Plan: </b><span style="color:red;">N/A</span></p>';
	}

	if(!empty($quarantine_datetime)){
		$quarantine_datetime2 = "<p><b>Updated On: </b>$quarantine_datetime</p>";
	}else{
		$quarantine_datetime2 = '';
	}

	$getQrnPlanList = $getQrnPlanList2.''.$quarantine_plan2.''.$quarantine_datetime2;

	$res1[] = array(
		'getQrnPlanList' => $getQrnPlanList
	);
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}


if($_GET['tag'] == "getInTouch"){
	
	$sessionname = $_POST['sessionname'];
	$sessionid = $_POST['sessionid'];
	$application_id = $_POST['application_id'];
	$application_comments = mysqli_real_escape_string($con, $_POST['application_comments']);
	$datetime_at = date('Y-m-d H:i:s');

	$qryinsert = "INSERT INTO `application_remarks` (`app_id`, `added_by_name`, `added_by_id`, `application_comments`, comments_color, `datetime_at`) VALUES ('$application_id', '$sessionname', '$sessionid', '$application_comments', '#f9d5d5', '$datetime_at');";
	mysqli_query($con, $qryinsert);
	
	////comments_color -- Agent
	////comments_color2 -- Admin
	$updateColor = "UPDATE `st_application` SET `comments_color2`='#fff', `comments_color`='#f9d5d5', comments_datetime='$datetime_at' WHERE `sno`='$application_id'";
	mysqli_query($con, $updateColor);
	
	echo '1';
	exit;
}
if($_GET['tag'] == "appRemarkDiv"){
	$app_id = $_POST['app_id'];
	$qury = "SELECT * FROM application_remarks WHERE app_id = '$app_id' order by sno desc";
	$result1 = mysqli_query($con, $qury);
	while($rowstr = mysqli_fetch_array($result1)){
		$added_by_name = $rowstr['added_by_name'];
		$application_comments = $rowstr['application_comments'];
		$datetime_at = $rowstr['datetime_at'];
		
	$res1[] = array(
		'application_comments' => $application_comments,
		'added_by_name' => $added_by_name,
		'datetime_at' => $datetime_at
	);
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);	
}


if($_GET['tag'] == "V-G"){
	echo '<div class="col-6 col-sm-6">
	<p class="mb-0 mt-3"><b>V-G Date: </b></p>
<input type="text" name="vg_date" class="form-control datepicker123" placeholder="YYY/MM/DD" value="" required>
	</div>
	<div class="col-6 col-sm-6">
	<p class="mb-0 mt-3"><b>File Upload: </b></p>
	<input type="file" name="vg_file" class="form-control vgrClass mb-2" required>
	</div><script>	  $( function() {
    $(".datepicker123").datepicker({	  
		dateFormat: "yy-mm-dd", 
		changeMonth: true, 
		changeYear: true,
		yearRange: "-80:+0"
    });
  });</script>';
}
?>