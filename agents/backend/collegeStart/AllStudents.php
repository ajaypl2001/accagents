<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
use PHPMailer\PHPMailer\PHPMailer;

// if($sessionid1 == "3738"){
	
// }else{
	// header("Location: ../login");
    // exit();
// }

if(isset($_POST['srchClgbtn'])){
	$search = $_POST['search'];
	$intakeInput = $_POST['intakeInput'];
	header("Location: ../collegeStart/AllStudents.php?getsearch=$search&getIntake=$intakeInput");
}

if(!empty($_GET['getIntake'])){
	$getIntake2 = $_GET['getIntake'];
	$getIntake3 = "AND prg_intake='$getIntake2'";
}else{
	$getIntake2 = '';
	$getIntake3 = '';
}

if(isset($_GET['getsearch']) && !empty($_GET['getsearch'])){
	$getsearch1 = $_GET['getsearch'];
	$search_url = "&getsearch=".$getsearch1."";
	$queryVgr2 = "SELECT COUNT(*) As total_records FROM st_application WHERE application_form='1' AND flowdrp!='Drop' AND v_g_r_status='V-G' AND (CONCAT(fname,  ' ', lname) LIKE '%$getsearch1%' OR refid LIKE '%$getsearch1%' OR student_id LIKE '%$getsearch1%' OR dob LIKE '%$getsearch1%' OR passport_no LIKE '%$getsearch1%') $getIntake3";
}else{
	$queryVgr2 = "SELECT COUNT(*) As total_records FROM st_application where application_form='1' AND flowdrp!='Drop' AND v_g_r_status='V-G' $getIntake3";
	$search_url = '';
}

if(isset($_POST['submitbtn'])){
	$app_id = $_POST['app_id'];
	$student_name = $_POST['student_name'];
	$passp = $_POST['passp'];
	$stid = $_POST['stid'];
	$refid = $_POST['refid'];
	$spr = $_POST['spr'];
	
	$agnt_qry25 = mysqli_query($con, "SELECT sno, fname, lname, email_address FROM st_application where sno='$app_id'");
	$row_agnt_qry25 = mysqli_fetch_assoc($agnt_qry25);
	$firstname = $row_agnt_qry25['fname'];
	$lastname = $row_agnt_qry25['lname'];
	$fullname = ucfirst($firstname).' '.ucfirst($lastname);
	$email_address25 = $row_agnt_qry25['email_address'];
	
	$queryGet = "SELECT app_id, with_file FROM `start_college` WHERE app_id='$app_id' ORDER BY sno DESC";
	$queryRslt = mysqli_query($con, $queryGet);

	$with_dism = $_POST['with_dism'];
	if(!empty($with_dism) && $with_dism == 'Graduate'){		
		$inp_program = $_POST['inp_program'];	
		$inp_start_date = $_POST['inp_start_date'];	
		$inp_end_date = $_POST['inp_end_date'];	
		$started_program = '';		
		$started_start_date = '';	
		$started_end_date = '';	
		$program_change = '';	
		
		$inp_programLog = $inp_program;
		$inp_start_dateLog = $inp_start_date;
		$inp_end_dateLog = $inp_end_date;
	}elseif(!empty($with_dism) && $with_dism == 'Contract Signed'){
		$program_change = $_POST['program_change'];
		if($program_change == 'Yes'){
			$started_program = $_POST['started_program'];		
			$started_start_date = $_POST['started_start_date'];		
			$started_end_date = $_POST['started_end_date'];
			$inp_program = '';	
			$inp_start_date = '';
			$inp_end_date = '';
			
			$inp_programLog = $started_program;
			$inp_start_dateLog = $started_start_date;
			$inp_end_dateLog = $started_end_date;
		}else{
			$inp_program = '';	
			$inp_start_date = '';
			$inp_end_date = '';
			$started_program = '';		
			$started_start_date = '';	
			$started_end_date = '';
			
			$inp_programLog = '';
			$inp_start_dateLog = '';
			$inp_end_dateLog = '';
		}
	}else{
		$inp_program = '';	
		$inp_start_date = '';
		$inp_end_date = '';
		$started_program = '';		
		$started_start_date = '';	
		$started_end_date = '';
		$program_change = '';
		
		$inp_programLog = '';
		$inp_start_dateLog = '';
		$inp_end_dateLog = '';
	}	 
	
	if(!empty($with_dism) && $with_dism == 'Dismissed'){
		$refund_rp = $_POST['refund_rp'];	
		$followup_status = $_POST['followup_status'];
		if($followup_status == 'Followup'){
			$follow_date = $_POST['follow_date'];			
		}else{
			$follow_date = '';			
		}			
		$rproccess = '';
		$yesp_amount = '';
		$img_name3 = '';
		$img_name4 = '';
	}elseif(!empty($with_dism) && $with_dism == 'Withdrawal'){
		$refund_rp = $_POST['refund_rp'];	
		$rproccess = $_POST['rproccess'];
		if($rproccess == 'Yes'){
			$yesp_amount = $_POST['yesp_amount'];			
		}else{
			$yesp_amount = '';			
		}
		
		$followup_status = $_POST['followup_status'];
		if($followup_status == 'Followup'){
			$follow_date = $_POST['follow_date'];			
		}else{
			$follow_date = '';			
		}
		
		$name3 = $_FILES['with_file']['name'];
		$tmp3 = $_FILES['with_file']['tmp_name'];
		
		if(mysqli_num_rows($queryRslt)){
			$studRow = mysqli_fetch_assoc($queryRslt);
			$with_file2 = $studRow['with_file'];
		}else{
			$with_file2 = '';
		}		

		if($name3 == ''){
			$img_name3 = $with_file2;
			$img_name4 = ", with_file='$img_name3'";
		}else{
			$extension = pathinfo($name3, PATHINFO_EXTENSION);
			if(!empty($with_file2)){
				unlink("../../Student_File/$with_file2");
			}
			$img_name3 = 'With_'.$refid.'_'.date('mdis').'.'.$extension;
			move_uploaded_file($tmp3, '../../Student_File/'.$img_name3);
			$img_name4 = ", with_file='$img_name3'";
		}
	
	if($refund_rp == 'Refund Request' || $refund_rp == 'Refund Processed'){
		$m1 = '<div>Dear '.ucfirst($firstname).',</p>';
		$m2 = '<p>In response to your request, I would also like to bring to your attention, the following points mentioned in the Student Declaration agreement signed by you:</p>';
		$m3 = '<p>I have reviewed the course content of the programs and I am well aware of the content to be delivered during my studies and I have my complete interest to apply for this program. I have been briefed about the opportunities and location of the college where I will study i.e. Vancouver, BC and I have prepared myself accordingly and have no problem studying at Granville College, Vancouver.</p>';
		$m4 = '<p>I affirm that I won’t be influenced by the suggestions given to change the college once I arrive in Canada as studying at Granville College is my first preference and I have no intentions of changing my priority and canceling my registration for the reasons of moving to be with my relatives or friends in Canada, change of intent or other reasons not specified here.</p>';
		$m5 = '<p>You have also agreed that in case of breach of the conditions, you authorize the college to inform Immigration, Refugees, and Citizenship Canada(IRCC) about any information regarding your file that it deems to be important to maintain the integrity of the Canadian Study Permit Program.</p>';
		$m6 = '<p>In furtherance of our conversation, Kindly provide the following mandatory documents to initiate the refund process-:</p>';		
		$m7 = '<ul style="list-style:none; line-height:24px;">
		<li><b>1. Contact Details</b></li>
		<li><b>2. Reason for Refund</b></li>
		<li><b>3. Refund request form (blank Attached)</b></li>
		<li><b>4. Letter of Acceptance from the New college</b></li>
		<li><b>5. Passport Copy</b></li>
		<li><b>6. Granville College LOA</b></li>
		<li><b>7. Study Permit</b></li>
		<li><b>8. Copy of Telegraphic Transfer ( Wire Transfer, Credit card, Debit card etc.)</b></li>
		<li><b>9. Void Cheque</b></li>
		</ul>';
		$m8 = '<p><b>Thanks & Regards,<br>Team Granville College.</b></p></div>';
		
		$msg_body = $m1.''.$m2.''.$m3.''.$m4.''.$m5.''.$m6.''.$m7.''.$m8;
		$subject = 'Withdrawal Request for Granville College - '.ucfirst($firstname).'';
		$to = $email_address25;
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
		$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
		$mail->SMTPSecure = 'tls';

		$mail->From = "no-reply@granville-college.com";
		$mail->FromName = 'Withdrawal Request | Granville College';
		$mail->AddAddress("$to");
		$mail->AddReplyTo('withdrawal@granvillecollege.ca', 'Granville College');
		$mail->addCC('students@granvillecollege.ca');
		// $mail->AddBCC('Suhail.Seth@aoltoronto.com');
		$mail->AddBCC('jaswinder@opulenceeducationgroup.com');

		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $msg_body;
		if(!$mail->Send()){
			// echo 'Mailer Error: ' . $mail->ErrorInfo;
			// exit();
		}else{
			// echo 'success';
		}
	}
	
		$subject2 = 'Withdrawal for - '.ucfirst($firstname).' - '.$stid.'';	
		$msg_body2 = '<p>Dear Cheryl,<br><br>
		The following student has withdrawn:
		<br><br>
		<b>Student Name: </b>'.$fullname.'<br>
		<b>Student ID: </b>'.$stid.'<br>
		<b>Email: </b>'.$email_address25.'<br>
		<b>Program Name: </b><br><br>
		Thanks and Regards,<br>
		Team Granville College<br>
		</p>';
		$to2 = 'sanjiv@essglobal.com'; //'cheryl@granvillecollege.ca';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
		$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
		$mail->SMTPSecure = 'tls';

		$mail->From = "no-reply@granville-college.com";
		$mail->FromName = 'Withdrawal | Granville College';
		$mail->AddAddress("$to2");
		// $mail->AddBCC('Suhail.Seth@aoltoronto.com');
		$mail->AddBCC('jaswinder@opulenceeducationgroup.com');

		$mail->IsHTML(true);
		$mail->Subject = $subject2;
		$mail->Body = $msg_body2;
		if(!$mail->Send()){
			// echo 'Mailer Error: ' . $mail->ErrorInfo;
			// exit();
		}else{
			// echo 'success';
		}
	
		
	}else{
		$refund_rp = '';
		$followup_status = '';
		$follow_date = '';
		$yesp_amount = '';
		$rproccess = '';
		$img_name3 = '';
		$img_name4 = '';
	}
	$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	$datetime_at = date('Y-m-d H:i:s');
	
	if($with_dism == 'Contract Signed'){
		$sten = ", `enrolled`='Contract Signed'";
		$sten2 = '';
		$sten3 = 'Contract Signed';
	}elseif($with_dism == 'Started'){
		$sten = ", `started`='Started'";
		$sten2 = 'Started';
		$sten3 = '';
	}else{
		$sten = '';
		$sten2 = '';
		$sten3 = '';
	}
	
	if(mysqli_num_rows($queryRslt)){
		$queryUpdate = "UPDATE `start_college` SET `student_name`='$student_name', `student_id`='$stid', `refid`='$refid', `passport_no`='$passp', `with_dism`='$with_dism', `refund_rp`='$refund_rp', `followup_status`='$followup_status', `follow_date`='$follow_date', `rproccess`='$rproccess', `yesp_amount`='$yesp_amount', `remarks`='$remarks', `datetime_at`='$datetime_at', `inp_program`='$inp_program', `inp_start_date`='$inp_start_date', `inp_end_date`='$inp_end_date', `started_program`='$started_program', `started_start_date`='$started_start_date', `started_end_date`='$started_end_date', `in_w_d`='$contact_person', `program_change`='$program_change', `spr`='$spr' $sten $img_name4 WHERE `app_id`='$app_id'";
		mysqli_query($con, $queryUpdate);
	}else{
		$queryVgr2 = "INSERT INTO `start_college` (`app_id`, `student_name`, `student_id`, `refid`, `passport_no`, `with_dism`, `refund_rp`, `followup_status`, `follow_date`, `rproccess`, `yesp_amount`, `remarks`, `datetime_at`, `inp_program`, `inp_start_date`, `inp_end_date`, `started_program`, `started_start_date`, `started_end_date`, `in_w_d`, `program_change`, `with_file`, `started`, `enrolled`, `spr`) VALUES ('$app_id', '$student_name', '$stid', '$refid', '$passp', '$with_dism', '$refund_rp', '$followup_status', '$follow_date', '$rproccess', '$yesp_amount', '$remarks', '$datetime_at', '$inp_program', '$inp_start_date', '$inp_end_date', '$started_program', '$started_start_date', '$started_end_date', '$contact_person', '$program_change', '$img_name3', '$sten2', '$sten3', '$spr')";
		mysqli_query($con, $queryVgr2);
	}
	
	$querylog = "INSERT INTO `start_college_logs` (`app_id`, `with_dism`, `refund_rp`, `followup_status`, `follow_date`, `rproccess`, `yesp_amount`, `remarks`, `datetime_at`, `inp_program`, `inp_start_date`, `inp_end_date`, `in_w_d`, `program_change`, `spr`) VALUES ('$app_id', '$with_dism', '$refund_rp', '$followup_status', '$follow_date', '$rproccess', '$yesp_amount', '$remarks', '$datetime_at', '$inp_programLog', '$inp_start_dateLog', '$inp_end_dateLog', '$contact_person', '$program_change', '$spr')";
	mysqli_query($con, $querylog);
	
	header("Location: ../collegeStart/AllStudents.php?SuccessFully_Submit$search_url");	
}

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$total_records_per_page = 100;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$as = '';
$orderDiv = "ORDER BY sno DESC LIMIT $offset, $total_records_per_page";

$queryVgr = mysqli_query($con, $queryVgr2);
$total_records = mysqli_fetch_array($queryVgr);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1
?> 
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>
<?php
if($roles1 == 'college'){	
?> 

<section class="container-fluid">
<div class="main-div">
<div class=" admin-dashboard">
	<form class="row pt-2 justify-content-end" method="post" action="">

		<div class="col-xl-2 col-lg-3 col-md-4 col-12 col-sm-5 mb-2">
		<div class="input-group input-group-sm">
			<select name="intakeInput" class="form-control">
				<option value="">Select Intake</option>
				<?php
				$rsltQuery = "SELECT intake FROM contract_courses Group BY intake ORDER BY intake DESC";
				$qurySql = mysqli_query($con, $rsltQuery);
				while($row_nm = mysqli_fetch_assoc($qurySql)){
					$intake = $row_nm['intake'];
				?>
				<option value="<?php echo $intake; ?>"<?php if ($intake == $getIntake2) { echo 'selected="selected"'; } ?>><?php echo $intake; ?></option>
				<?php } ?>
			</select>
		</div>
		</div>
				<div class="col-xl-4 col-lg-6 col-md-7 col-12 col-sm-7">
		<div class="input-group input-group-sm">
		<input type="search" class="form-control" name="search" placeholder="Search by Name,RefId,StuId & Passport No">
			<div class="input-group-append">
			<button type="submit" name="srchClgbtn" class="btn btn-more btn-success">Search</button>
			</div>
		</div>
		
		</div>
		
	</form>

	
<div class=" application-tabs pt-4">
<?php if($clg_pr == '1'){ ?> 
	<div class="col-lg-12 content-wrap">	
	<div class="row">	
    <div class="table-responsive">
	<table class="table table-bordered  table-sm" width="100%">
    <thead>
      <tr style="color:#fff;background:#596164;">		
        <th>Full Name</th>
        <th>Stu/Ref ID</th>
        <th>Intake/Program</th>
        <th>Documents</th>
		<th>COL</th>
        <th>LOA</th>
        <th>Student Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?php
	if(isset($_GET['aid']) && !empty($_GET['aid'])){
		$get_aid = $_GET['aid'];
		$expVal = explode("error_", $get_aid);
		$resultQuery = "(SELECT * FROM st_application where application_form='1' AND flowdrp!='Drop' AND v_g_r_status='V-G' AND sno='$expVal[1]' $getIntake3 LIMIT $offset, $total_records_per_page) UNION (SELECT * FROM st_application where application_form='1' AND flowdrp!='Drop' AND v_g_r_status='V-G' AND sno !='$expVal[1]' $getIntake3 order by sno ASC LIMIT $offset, $total_records_per_page)";
	}else{
	if(isset($_GET['getsearch']) && !empty($_GET['getsearch'])){
		$getsearch1 = $_GET['getsearch'];
		$resultQuery = "SELECT * FROM st_application WHERE (CONCAT(fname,  ' ', lname) LIKE '%$getsearch1%' OR refid LIKE '%$getsearch1%' OR student_id LIKE '%$getsearch1%' OR dob LIKE '%$getsearch1%' OR passport_no LIKE '%$getsearch1%') AND application_form='1' AND flowdrp!='Drop' AND v_g_r_status='V-G' $getIntake3 $orderDiv";
	}else{
		$resultQuery = "SELECT * FROM st_application where application_form='1' AND flowdrp!='Drop' AND v_g_r_status='V-G' $getIntake3 $as $orderDiv";
	}
	}	
	$result2 = mysqli_query($con, $resultQuery);
	if(mysqli_num_rows($result2)){
	while ($row = mysqli_fetch_assoc($result2)) {
		 $sno = mysqli_real_escape_string($con, $row['sno']);
		 $fname = mysqli_real_escape_string($con, $row['fname']);
		 $lname = mysqli_real_escape_string($con, $row['lname']);
		$fullname = ucfirst($fname).' '.ucfirst($lname);
		 $student_id = mysqli_real_escape_string($con, $row['student_id']);
		 $refid = mysqli_real_escape_string($con, $row['refid']);
		 $country = mysqli_real_escape_string($con, $row['country']);
		 $idproof = mysqli_real_escape_string($con, $row['idproof']);
		 $englishpro = mysqli_real_escape_string($con, $row['englishpro']);
		 $ielts_file = mysqli_real_escape_string($con, $row['ielts_file']);				
		 $pte_file = mysqli_real_escape_string($con, $row['pte_file']);			
		$certificate1 = mysqli_real_escape_string($con, $row['certificate1']);
		$sign_student_declaration_agreement = mysqli_real_escape_string($con, $row['sign_student_declaration_agreement']);
		$sign_inter_stu_appli = mysqli_real_escape_string($con, $row['sign_inter_stu_appli']);			 			 
		$admin_status_crs = mysqli_real_escape_string($con, $row['admin_status_crs']);
		$loa_file = mysqli_real_escape_string($con, $row['loa_file']);
		$prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
		$prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);
		$ol_processing = mysqli_real_escape_string($con, $row['ol_processing']);
		$offer_letter = mysqli_real_escape_string($con, $row['offer_letter']);
		$ol_confirm = mysqli_real_escape_string($con, $row['ol_confirm']);
		$prepaid_fee = mysqli_real_escape_string($con, $row['prepaid_fee']);
		$loa_tt = mysqli_real_escape_string($con, $row['loa_tt']);
		$file_receipt = mysqli_real_escape_string($con, $row['file_receipt']);
		$loa_file_status = mysqli_real_escape_string($con, $row['loa_file_status']);
		$fh_status = mysqli_real_escape_string($con, $row['fh_status']);
		$v_g_r_status = mysqli_real_escape_string($con, $row['v_g_r_status']);
		$vg_copy_file = mysqli_real_escape_string($con, $row['vg_copy_file']);
		$sigend_student_enrollment = mysqli_real_escape_string($con, $row['sigend_student_enrollment']);
		$sigend_student_declaration = mysqli_real_escape_string($con, $row['sigend_student_declaration']);
		$v_g_r_invoice = mysqli_real_escape_string($con, $row['v_g_r_invoice']);
		$inovice_status = mysqli_real_escape_string($con, $row['inovice_status']);
		$file_upload_vgr = mysqli_real_escape_string($con, $row['file_upload_vgr']);
		$file_upload_vgr2 = mysqli_real_escape_string($con, $row['file_upload_vgr2']);
		$file_upload_vgr3 = mysqli_real_escape_string($con, $row['file_upload_vgr3']);

		if(($idproof !== '') && ($englishpro == 'ielts' || $englishpro == 'Toefl' || $englishpro == 'pte') && ($certificate1 !== '') && ($offer_letter !== '')  && ($loa_tt !== '' || $file_receipt!='') && ($loa_file !== '')){
			$clr = '';
			$brd = '';				
		}else{
			$clr = '#f2dede';
			$brd = '2px solid red';
		}
		
		$queryGet2 = "SELECT with_dism FROM `start_college` WHERE with_dism!='' AND app_id='$sno'";
		$queryRslt2 = mysqli_query($con, $queryGet2);
		if(mysqli_num_rows($queryRslt2)){
			$rowSC = mysqli_fetch_assoc($queryRslt2);	
			$with_dism3 = $rowSC['with_dism'];	
		}else{
			$with_dism3 = '<span style="color:red;">No Action</span>';		
		}
	?>
      <tr style="background:<?php echo $clr;?>;border-bottom:<?php echo $brd;?>">
        <td style="white-space: normal; width:150px;">
		<?php echo $fname.' '.$lname; ?></td>
        <td>
		<?php 
		if($refid !== '' || $student_id !== ''){
			echo $student_id.'<br>'.$refid;
		}else{
			echo '<span style="color:red;">N/A</span>';
		}
		?>
		</td>
        <td style=" white-space: nowrap;">
		<?php echo $prg_intake.' /<br>'.$prg_name1; ?>
		</td>
        <td style=" white-space: nowrap;">
			<?php
			if($idproof !== ''){
				echo '<span><b>Passport : </b><a href="../../uploads/'.$idproof.'" download>Download</a></span><br>';
			}else{
				echo '<span><b>Passport : </b><span style="color:red;">N/A</span></span><br>';
			}
			if($englishpro == 'ielts'){
				echo '<span><b>IELTS : </b><a href="../../uploads/'.$ielts_file.'" download>Download</a></span><br>';
			}
			if($englishpro == 'Toefl'){
				echo '<span><b>Toefl : </b><a href="../../uploads/'.$ielts_file.'" download>Download</a></span><br>';
			}
			if($englishpro == 'pte'){
				echo '<span><b>PTE: </b><a href="../../uploads/'.$pte_file.'" download>Download</a></span><br>';
			}
			
			if($certificate1 !== ''){
				echo '<span><b>Certificate1 : </b><a href="../../uploads/'.$certificate1.'" download>Download</a></span><br>';
			}else{
				echo '<span><b>Certificate1 : </b><span style="color:red;">N/A</span></span><br>';
			}
			
			if($sign_student_declaration_agreement !== ''){
				echo '<span><b>SDA : </b><a title="Student Declaration Agreement"  href="../../uploads/'.$sign_student_declaration_agreement.'" download>Download</a></span><br>';
			}else{
				echo '<span title="Student Declaration Agreement"><b>SDA : </b><span style="color:red;">N/A</span></span><br>';
			}
			if($sign_inter_stu_appli !== ''){
				echo '<span title="International Student Application"><b>ISA : </b><a href="../../uploads/'.$sign_inter_stu_appli.'" download>Download</a></span>';
			}else{
				echo '<span title="International Student Application"><b>ISA : </b><span style="color:red;">N/A</span></span><br>';
			}
			?>
		</td>
		<td>
	<?php
	if(!empty($admin_id_clg) && $admin_id_clg == $sessionid1){
		if(!empty($offer_letter)){
			echo '<a href="../../uploads/offer_letter/'.$offer_letter.'" download>Download</a>';
		}else{
			echo '<span style="color:red;">N/A</span>';
		}
	}else{
	if($country == 'Canada'){
		if(empty($admin_status_crs) && empty($offer_letter) && empty($ol_confirm)){
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';
		}
		if(!empty($admin_status_crs) && empty($offer_letter) && empty($ol_confirm)){
			echo '<div class="btn btn-sm btn-warning olClass" data-toggle="modal" data-target="#olModel" data-id="'.$sno.'"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Generate Offer Letter"></i></div>';
		}
		if(!empty($admin_status_crs) && !empty($offer_letter) && empty($ol_confirm)){
			echo '<div class="btn btn-sm btn-danger olClass" data-toggle="modal" data-target="#olModel" data-id="'.$sno.'"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Offer Letter Generated but not send"></i></div>';
		}
		if(!empty($admin_status_crs) && !empty($offer_letter) && !empty($ol_confirm)){
			echo '<div class="btn btn-sm btn-success olClass" data-toggle="modal" data-target="#olModel" data-id="'.$sno.'"><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="Offer Letter Sent"></i></div>';
		}
	}else{
		if(!empty($offer_letter)){
			echo '<a href="../../uploads/offer_letter/'.$offer_letter.'" download>Download</a>';
		}else{
			echo '<span style="color:red;">N/A</span>';
		}
	}
		echo '<br><a href="javascript:void(0)" class="btn btn-sm btn-info mt-2 olLogsClass" data-toggle="modal" data-target="#olLogsModel" data-id="'.$sno.'" data-tab-name="OL">OL Logs</a>';
	}
		?>		
		</td>
        <td>
	<?php
	if(!empty($admin_id_clg) && $admin_id_clg == $sessionid1){
		if(!empty($loa_file)){
			echo '<a href="../../uploads/loa/'.$loa_file.'" download>Download</a>';
		}else{
			echo '<span style="color:red;">N/A</span>';
		}
	}else{
	if($country == 'Canada'){
		if(($ol_processing == '') && ($prepaid_fee == '') && ($loa_file == '') && ($loa_file_status == '')){
			echo '<span class="btn btn-sm btn-pending" data-toggle="tooltip" data-placement="top" title="" data-original-title="No Action Made"><i class="fas fa-times"></i></span>';		
		}
		if(($ol_processing == 'Conditional COL') && ($prepaid_fee == '') && ($loa_file == '') && ($loa_file_status == '')){
			echo '<span class="btn btn-sm checklistClassyellow"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Final COL Pending, Please meet the Conditions"></i></span>';		
		}
		if(($ol_processing == 'Conditional COL') && ($prepaid_fee !== '') && ($loa_file == '') && ($loa_file_status == '')){
			echo '<span class="btn btn-sm checklistClassyellow"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Final COL Pending, Please meet the Conditions"></i></span>';		
		}
		if(($ol_processing == 'Conditional COL') && ($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status !== '')){
			echo '<span class="btn btn-sm checklistClassyellow"><i class="fas fa-sync-alt" data-toggle="tooltip" data-placement="top" title="Final COL Pending, Please meet the Conditions"></i></span>';		
		}
		if(($ol_processing == 'Final COL') && ($prepaid_fee == '') && ($loa_file == '') && ($loa_file_status == '')){
			echo '<span class="btn btn-sm btn-warning"><i class="fas fa-sync-alt"  data-toggle="tooltip" data-placement="top" title="LOA Fee Pending"></i></span>';
		}
		if(($ol_processing == 'Final COL') && ($prepaid_fee !== '') && ($loa_file == '') && ($loa_file_status == '')){ ?>
		<div class="btn checklistClassyellow btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $sno;?>"><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="Generate LOA"></i></div>
		<?php }		
		if(($ol_processing == 'Final COL') && ($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '')){ ?>
		<div class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $sno;?>" ><i class="fas fa-upload" data-toggle="tooltip" data-placement="top" title="LOA Generated"></i></div>
		<?php }	
		if(($ol_processing == 'Final COL') && ($prepaid_fee !== '') && ($loa_file !== '') && ($loa_file_status == '1')){ ?>
		<span class="btn checklistClassgreen btn-sm genrateClass" data-toggle="modal" data-target="#genrateModel" data-id="<?php echo $sno;?>" ><i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="LOA Sent"></i></span>
		<?php }
		
	}else{
		
		if(!empty($loa_file)){
			echo '<a href="../../uploads/loa/'.$loa_file.'" download>Download</a>';
		}else{
			echo '<span style="color:red;">N/A</span>';
		}
	}
		echo '<br><a href="javascript:void(0)" class="btn btn-sm btn-info mt-2 loaLogsClass" data-toggle="modal" data-target="#loaLogsModel" data-id="'.$sno.'" data-tab-name="LOA">LOA Logs</a>';
	}
		?>
		
		</td>
		<td><?php echo $with_dism3; ?></td>				
		<td style="white-space: nowrap;">
		<span class="btn btn-sm btn-success statusClass" data-toggle="modal" data-target="#statusModal" data-id="<?php echo $sno; ?>" data-name="<?php echo $fullname; ?>" data-refid="<?php echo $refid; ?>" data-stid="<?php echo $student_id; ?>" data-passp="<?php echo $passport_no; ?>">Add Status</span>
		
		<span class="btn btn-sm btn-info allClass" data-toggle="modal" data-target="#allModel" data-id="<?php echo $sno; ?>" data-name="<?php echo $fullname; ?>">Logs</span>
		</td>		
      </tr>
	<?php }
	}else{
		echo '<tr> <td colspan="9" style="text-align:center;">No Result Found</td></tr>';
	} ?>
    </tbody>	
 </table>  
 </div>
	</div>
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
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page$search_url'"; } ?> class='page-link'><i class="fas fa-angle-double-left"></i></a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter$search_url' class='page-link'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter$search_url' class='page-link'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last$search_url' class='page-link'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages$search_url' class='page-link'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li class='page-item'><a href='?page_no=1$search_url' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2$search_url' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter$search_url' class='page-link'>$counter</a></li>";
				}                  
       }
       echo "<li class='page-item'><a class='page-link'>...</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$second_last$search_url' class='page-link'>$second_last</a></li>";
	   echo "<li class='page-item'><a href='?page_no=$total_no_of_pages$search_url' class='page-link'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li class='page-item'><a href='?page_no=1$search_url' class='page-link'>1</a></li>";
		echo "<li class='page-item'><a href='?page_no=2$search_url' class='page-link'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a href='?page_no=$counter$search_url' class='page-link'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='page-item disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page$search_url'"; } ?> class='page-link'><i class="fas fa-angle-double-right"></i></a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='page-item'><a href='?page_no=$total_no_of_pages$search_url' class='page-link'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>
</nav>
</div>
</div> 

  <?php 
}else{
	echo "<center><b style='color:red;'>You are Not Authorised for this page. Please Contact College!!!</b></center>";
}
?>
</div>
</div>
</section>
<style type="text/css">
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
.application-tabs .table.table-bordered thead tr th,
.application-tabs .table.table-bordered tbody tr td { font-size:14px !important; }
</style>

<div class="modal" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="getNameId"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body getStartLists"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="allModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	  
	  <div class="modal-header">
        <h4 class="modal-title"><span class="stNameLogs"></span></h4>
		<button type="button" class="close" data-dismiss="modal">×</button>
      </div>	  
	  <div class="loading_icon"></div>
      <div class="modal-body">
	  <div class="table-responsive">
		<table class="table table-bordered table-sm table-striped table-hover">
	<thead>
	<tr>
	<th>Sno.</th>
	<th>In/W/D</th>	
	<th>Inprogress Status</th>
	<th>Refund Type</th>
	<th>Refund Processed</th>
	<th>Refund Amount</th>
	<th>Followup Status</th>
	<th>Followup Date</th>
	<th>Remarks</th>
	<th>Updated On</th>
	<th>Added By</th>
	</tr>
	</thead>
	<tbody class="getAllLogsDiv">
	</tbody>
	</table>
      </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('click', '.statusClass', function () {
	var getVal = $(this).attr('data-id');
	var getVal2 = $(this).attr('data-name');
	var getVal3 = $(this).attr('data-passp');
	var getVal4 = $(this).attr('data-stid');
	var getVal5 = $(this).attr('data-refid');
	$('.getNameId').html(getVal2);
	$.post("../responseStart.php?tag=getStartLists",{"idno":getVal, "name":getVal2, "passp":getVal3, "stid":getVal4, "refid":getVal5},function(d){
		$('.getStartLists').html("");
		$('' + d[0].getStartLists +'').appendTo(".getStartLists");
		
		$(function(){
			$(".datepickerDiv").datepicker({	  
				dateFormat: 'yy-mm-dd', 
				changeMonth: false, 
				changeYear: false,
			});
		});
		
		$("#firsttab_requried").submit(function () {
			var submit = true;
			$(".is_require:visible").each(function(){
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
				$('.is_require').keyup(function(){
					$(this).removeClass('error_color');
				});
				return false;        
			}
		});		
		
	});
});
</script>

<script type="text/javascript">
$(document).on('click', '.allClass', function(){
	var idmodel = $(this).attr('data-id');
	var getHeadVal = $(this).attr('data-name');
	$('.stNameLogs').html(getHeadVal);
	$('.loading_icon').show();	
	$.post("../responseStart.php?tag=getAllLogs",{"idno":idmodel},function(il){
		$('.getAllLogsDiv').html("");
		if(il==''){
			$('.getAllLogsDiv').html("<tr><td colspan='10'><center>Not Found</center></td></tr>");
		}else{
		 for (i in il){
			$('<tr>' + 
			'<td>'+il[i].idLogs+'</td>'+
			'<td>'+il[i].with_dismLogs+'</td>'+
			'<td style="white-space: nowrap;">'+il[i].inpStLogs+'</td>'+
			'<td>'+il[i].refund_rpLogs+'</td>'+
			'<td>'+il[i].rproccessLogs+'</td>'+
			'<td>'+il[i].yesp_amountLogs+'</td>'+			
			'<td>'+il[i].followup_statusLogs+'</td>'+
			'<td>'+il[i].follow_dateLogs+'</td>'+
			'<td>'+il[i].remarksLogs+'</td>'+
			'<td>'+il[i].updateLogs+'</td>'+
			'<td>'+il[i].in_w_dLogs+'</td>'+
			'</tr>').appendTo(".getAllLogsDiv");
		}
		}		
		$('.loading_icon').hide();	
	});	
});	
</script>

<script type="text/javascript">
$(document).on('change', '.ipDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Inprogress'){
		$('.InprgsDiv').show();
	}else{
		$('.InprgsDiv').hide();		
	}
});

$(document).on('change', '.wDisDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Withdrawal' || getVal == 'Dismissed'){
		$('.contractSgndDiv').hide();
		$('.startedDiv').hide();
		$('.rfndRPDiv').show();
		$('.inpsDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}else if(getVal == 'Graduate'){
		$('.contractSgndDiv').hide();
		$('.startedDiv').hide();
		$('.inpsDiv').show();
		$('.rfndRPDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}else if(getVal == 'Contract Signed'){
		$('.contractSgndDiv').show();
		$('.startedDiv').hide();
		$('.inpsDiv').hide();
		$('.rfndRPDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}else if(getVal == 'Started'){
		$('.contractSgndDiv').hide();
		$('.startedDiv').hide();
		$('.inpsDiv').hide();
		$('.rfndRPDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}else{
		$('.contractSgndDiv').hide();
		$('.startedDiv').hide();
		$('.rfndRPDiv').hide();		
		$('.inpsDiv').hide();		
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();
		$('.withFileDiv').hide();
	}
});

$(document).on('change', '.rfndRPList', function () {
	var getVal = $(this).val();
	if(getVal == 'Refund Request'){
		$('.flupDiv').show();
		$('.rfndPrDiv').hide();
		$('.yespDiv').hide();		
		$('.withFileDiv').show();
	}else if(getVal == 'Refund Processed'){	
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').show();			
		$('.withFileDiv').show();		
	}else{
		$('.flupDiv').hide();
		$('.flwpDateDiv').hide();
		$('.rfndPrDiv').hide();		
		$('.yespDiv').hide();			
		$('.withFileDiv').hide();	
	}
});

$(document).on('change', '.fdDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Followup'){
		$('.flwpDateDiv').show();
	}else{
		$('.flwpDateDiv').hide();		
	}
});

$(document).on('change', '.contractSgndDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Followup'){
		$('.flwpDateDiv').show();
	}else{
		$('.flwpDateDiv').hide();		
	}
});

$(document).on('change', '.rproccessDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Yes'){
		$('.yespDiv').show();
	}else if(getVal == 'No'){
		$('.yespDiv').hide();		
	}else{
		$('.yespDiv').hide();		
	}
});

$(document).on('change', '.pcDiv', function () {
	var getVal = $(this).val();
	if(getVal == 'Yes'){
		$('.startedDiv').show();
	}else if(getVal == 'No'){
		$('.startedDiv').hide();		
	}else{
		$('.startedDiv').hide();		
	}
});
</script>

<?php 
include("../../footer.php");	
}else{
	header("Location: ../../login");
    exit();
}
?>