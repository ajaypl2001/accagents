<?php
ob_start();
include ("../../db.php");
include ("../../header_navbar.php");
date_default_timezone_set("America/Toronto");
$updated_on = date('Y-m-d H:i:s');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

if (!empty($_GET['getStatus'])) {
	$getStatus = $_GET['getStatus'];
} else {
	$getStatus = '';
}

if (isset($_POST['srchClickbtn'])) {
	$search = $_POST['inputval'];
	$intakeInput = $_POST['intakeInput'];
	$locationInput = '';
	$pNameInput = $_POST['pNameInput'];
	$getVGInput = $_POST['getVGInput'];
	$getStatus2 = $_POST['getStatus'];
	$statusInput22 = $_POST['statusInput'];
	$statusInput22_cont = $_POST['statusInput_cont'];
	$agentInput = $_POST['agentInput'];

	header("Location: ../collegeStart/?getsearch=$search&getIntake=$intakeInput&getPName=$pNameInput&getVGDate=$getVGInput&getLocation=$locationInput&getStatus=$getStatus2&statusInput=$statusInput22&statusInput_cont=$statusInput22_cont&getAgent=$agentInput&page_no=1");
}

if (isset($_GET['getsearch']) && $_GET['getsearch'] != "") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (CONCAT(fname,  ' ', lname) LIKE '%" . $searchTerm . "%' OR refid LIKE '%" . $searchTerm . "%' OR passport_no LIKE '%" . $searchTerm . "%' OR student_id LIKE '%" . $searchTerm . "%')";
	$search_url = "&getsearch=" . $searchTerm . "";
} else {
	$searchInput = '';
	$search_url = '';
	$searchTerm = '';
}

if (!empty($_GET['getIntake'])) {
	$getIntake2 = $_GET['getIntake'];
	$getIntake3 = "AND prg_intake='$getIntake2'";
} else {
	$getIntake2 = '';
	$getIntake3 = '';
}

if (!empty($_GET['getVGDate'])) {
	$getVGDate2 = $_GET['getVGDate'];
	$getVGDate3 = "AND v_g_r_status_datetime LIKE '%$getVGDate2%'";
} else {
	$getVGDate2 = '';
	$getVGDate3 = '';
}

if (!empty($_GET['getAgent'])) {
	$agentInput2 = $_GET['getAgent'];
	$agentInput3 = "AND user_id='$agentInput2'";
} else {
	$agentInput2 = '';
	$agentInput3 = '';
}

if (!empty($_GET['statusInput'])) {
	$statusInput2 = $_GET['statusInput'];
	if ($statusInput2 == 'Started') {
		$statusInput3 = "AND student_status='Started'";
	} elseif ($statusInput2 == 'Not_started') {
		$statusInput3 = "AND student_status='Not started'";
	} elseif ($statusInput2 == 'Deferred') {
		$statusInput3 = "AND student_status='Deferred'";
	} elseif ($statusInput2 == 'Withdrawal') {
		$statusInput3 = "AND student_status='Withdrawal'";
	} elseif ($statusInput2 == 'Dismissed') {
		$statusInput3 = "AND student_status='Dismissed'";
	}
} else {
	$statusInput2 = '';
	$statusInput3 = '';
}


if (!empty($_GET['statusInput_cont'])) {
	$statusInput2_cont = $_GET['statusInput_cont'];
	if ($statusInput2_cont == 'Accept' || $statusInput2_cont == 'Reject') {
		$statusInput3_cont = "AND contract_docs_status='$statusInput2_cont'";
	} elseif ($statusInput2_cont == 'Pending') {
		$statusInput3_cont = "AND contract_docs_status=''";
	}
} else {
	$statusInput2_cont = '';
	$statusInput3_cont = '';
}

if (!empty($_GET['getPName'])) {
	$getPName2 = $_GET['getPName'];
	$getPName3 = "AND prg_name1='$getPName2'";
} else {
	$getPName2 = '';
	$getPName3 = '';
}

if (isset($_POST['submitbtnStuPmt'])) {
	$userid = $_POST['app_id'];
	$study_permit_yes = $_POST['study_permit'];
	$passp = $_POST['passp'];
	$stid = $_POST['stid'];
	$refid = $_POST['refid'];
	$spr = $_POST['spr'];
	$created_date2 = date('Y-m-d H:i:s');

	$qry = mysqli_query($con, "SELECT * FROM `international_airport_student` where `app_id`='$userid'");
	if (mysqli_num_rows($qry)) {
		$uid1 = mysqli_fetch_assoc($qry);
		$study_permit22 = $uid1['study_permit'];
		$insurance22 = $uid1['insurance'];
	} else {
		$study_permit22 = '';
		$insurance22 = '';
	}

	$name1 = $_FILES['study_permit_file']['name'];
	$tmp1 = $_FILES['study_permit_file']['tmp_name'];

	$name2 = $_FILES['insurance']['name'];
	$tmp2 = $_FILES['insurance']['tmp_name'];

	if ($name1 == '') {
		$img_name1 = $study_permit22;
	} else {
		$extension = pathinfo($name1, PATHINFO_EXTENSION);
		if (!empty($study_permit22)) {
			unlink("../../uploads/$study_permit22");
		}
		$img_name1 = 'StudyPermit_' . $userid . '_' . date('dhis') . '.' . $extension;
		move_uploaded_file($tmp1, '../../uploads/' . $img_name1);
	}

	if ($name2 == '') {
		$img_name2 = $insurance22;
	} else {
		$extension2 = pathinfo($name2, PATHINFO_EXTENSION);
		if (!empty($insurance22)) {
			unlink("../../uploads/$insurance22");
		}
		$img_name2 = 'Insurance_' . $userid . '_' . date('dhis') . '.' . $extension2;
		move_uploaded_file($tmp2, '../../uploads/' . $img_name2);
	}

	$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
	$datetime_at = date('Y-m-d H:i:s');

	if ($study_permit_yes == 'Yes') {
		if (mysqli_num_rows($qry)) {
			echo $mainTableUpdate = "UPDATE `international_airport_student` SET `study_permit`='$img_name1', `insurance`='$img_name2', `datetime_at`='$created_date2' WHERE `app_id`='$userid'";
			mysqli_query($con, $mainTableUpdate);
		} else {
			mysqli_query($con, "INSERT INTO `international_airport_student` (`app_id`, `student_id`, `study_permit`, `insurance`, `datetime_at`) VALUES ('$userid', '$stid', '$img_name1', '$img_name2', '$created_date2')");
		}
	}
	$mainTableQry = "UPDATE `both_main_table` SET `study_permit`='$study_permit_yes', `sif_send_by`='$contact_person' WHERE `sno`='$userid'";
	mysqli_query($con, $mainTableQry);

	header("Location: ../collegeStart/?getIntake=$getIntake2&SuccessFully_Submit$search_url&getStatus=$getStatus");
}

// if (isset($_POST['submitbtnStuPmt_1'])) {
// 	$name1 = $_FILES['study_permit_file']['name'];
// 	$tmp1 = $_FILES['study_permit_file']['tmp_name'];

// 	$name2 = $_FILES['insurance']['name'];
// 	$tmp2 = $_FILES['insurance']['tmp_name'];

// 	if ($name1 == '') {
// 		$img_name1 = $study_permit22;
// 	} else {
// 		$extension = pathinfo($name1, PATHINFO_EXTENSION);
// 		if (!empty($study_permit22)) {
// 			unlink("../../uploads/$study_permit22");
// 		}
// 		$img_name1 = 'StudyPermit_' . $userid . '_' . date('dhis') . '.' . $extension;
// 		move_uploaded_file($tmp1, '../../uploads/' . $img_name1);
// 	}

// 	if ($name2 == '') {
// 		$img_name2 = $insurance22;
// 	} else {
// 		$extension2 = pathinfo($name2, PATHINFO_EXTENSION);
// 		if (!empty($insurance22)) {
// 			unlink("../../uploads/$insurance22");
// 		}
// 		$img_name2 = 'Insurance_' . $userid . '_' . date('dhis') . '.' . $extension2;
// 		move_uploaded_file($tmp2, '../../uploads/' . $img_name2);
// 	}

// 	$pmtquery="INSERT INTO `both_main_table`('study_permit', 'insurance')VALUES('$name1', '$name2')";
// 	$pmtrsult=mysqli_query($con, $pmtquery);
// 	if(!$pmtrsult){
// 		echo "yesss"; die;
// 	}else{
// 		echo "noo"; die;
// 	}
// }

if (isset($_POST['submitbtn'])) {
	$app_id = $_POST['app_id'];
	$student_name = $_POST['student_name'];
	$passp = $_POST['passp'];
	$stid = $_POST['stid'];
	$refid = $_POST['refid'];
	$spr = ''; //$_POST['spr'];	
	$datetime_at = date('Y-m-d H:i:s');

	$agnt_qry25 = mysqli_query($con, "SELECT sno, fname, lname, on_off_shore, email_address, prg_intake, prg_name1 FROM st_application where sno='$app_id'");
	$row_agnt_qry25 = mysqli_fetch_assoc($agnt_qry25);
	$firstname = $row_agnt_qry25['fname'];
	$lastname = $row_agnt_qry25['lname'];
	$fullname = ucfirst($firstname) . ' ' . ucfirst($lastname);
	$email_address25 = $row_agnt_qry25['email_address'];
	$on_off_shore25 = $row_agnt_qry25['on_off_shore'];
	$prg_intake25 = $row_agnt_qry25['prg_intake'];
	$prg_name25 = $row_agnt_qry25['prg_name1'];

	$queryGet4_1 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name25' AND intake='$prg_intake25'";
	$queryRslt4_1 = mysqli_query($con, $queryGet4_1);
	$rowSC4_1 = mysqli_fetch_assoc($queryRslt4_1);
	$start_date_1 = $rowSC4_1['commenc_date'];
	$expected_date_1 = $rowSC4_1['expected_date'];

	$queryGet = "SELECT app_id, with_file FROM `start_college` WHERE app_id='$app_id' ORDER BY sno DESC";
	$queryRslt = mysqli_query($con, $queryGet);

	$with_dism = $_POST['with_dism'];
	if (!empty($with_dism) && $with_dism == 'Graduate') {
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
	} elseif (!empty($with_dism) && $with_dism == 'Contract Signed') {
		$program_change = $_POST['program_change'];
		if ($program_change == 'Yes') {
			$started_program = $_POST['started_program'];
			$started_start_date = $_POST['started_start_date'];
			$started_end_date = $_POST['started_end_date'];
			$inp_program = '';
			$inp_start_date = '';
			$inp_end_date = '';

			$inp_programLog = $started_program;
			$inp_start_dateLog = $started_start_date;
			$inp_end_dateLog = $started_end_date;
		} else {
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
	} else {
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

	if (!empty($with_dism) && $with_dism == 'Dismissed') {
		$dismissal_date = $_POST['dismissal_date'];
		$refund_rp = $_POST['refund_rp'];
		$rproccess = $_POST['rproccess'];
		if ($rproccess == 'Yes') {
			$yesp_amount = $_POST['yesp_amount'];
		} else {
			$yesp_amount = '';
		}


		$followup_status = $_POST['followup_status'];
		if ($followup_status == 'Followup') {
			$follow_date = $_POST['follow_date'];
		} else {
			$follow_date = '';
		}

		$name3 = $_FILES['with_file']['name'];
		$tmp3 = $_FILES['with_file']['tmp_name'];

		if (mysqli_num_rows($queryRslt)) {
			$studRow = mysqli_fetch_assoc($queryRslt);
			$with_file2 = $studRow['with_file'];
		} else {
			$with_file2 = '';
		}

		if (mysqli_num_rows($queryRslt)) {
			$studRow = mysqli_fetch_assoc($queryRslt);
			$with_file2 = $studRow['with_file'];
		} else {
			$with_file2 = '';
		}

		if ($name3 == '') {
			$img_name3 = $with_file2;
			$img_name4 = ", with_file='$img_name3'";
		} else {
			$extension = pathinfo($name3, PATHINFO_EXTENSION);
			if (!empty($with_file2)) {
				unlink("../../Student_File/$with_file2");
			}
			$img_name3 = 'With_' . $refid . '_' . date('mdis') . '.' . $extension;
			move_uploaded_file($tmp3, '../../Student_File/' . $img_name3);
			$img_name4 = ", with_file='$img_name3'";
		}

	} elseif (!empty($with_dism) && $with_dism == 'Withdrawal') {
		$datetime_at = $_POST['withdrawal_date'];
		$refund_rp = $_POST['refund_rp'];
		$rproccess = $_POST['rproccess'];
		if ($rproccess == 'Yes') {
			$yesp_amount = $_POST['yesp_amount'];
		} else {
			$yesp_amount = '';
		}

		$followup_status = $_POST['followup_status'];
		if ($followup_status == 'Followup') {
			$follow_date = $_POST['follow_date'];
		} else {
			$follow_date = '';
		}

		$name3 = $_FILES['with_file']['name'];
		$tmp3 = $_FILES['with_file']['tmp_name'];

		if (mysqli_num_rows($queryRslt)) {
			$studRow = mysqli_fetch_assoc($queryRslt);
			$with_file2 = $studRow['with_file'];
		} else {
			$with_file2 = '';
		}

		if ($name3 == '') {
			$img_name3 = $with_file2;
			$img_name4 = ", with_file='$img_name3'";
		} else {
			$extension = pathinfo($name3, PATHINFO_EXTENSION);
			if (!empty($with_file2)) {
				unlink("../../Student_File/$with_file2");
			}
			$img_name3 = 'With_' . $refid . '_' . date('mdis') . '.' . $extension;
			move_uploaded_file($tmp3, '../../Student_File/' . $img_name3);
			$img_name4 = ", with_file='$img_name3'";
		}

		if ($refund_rp == 'Refund Request' || $refund_rp == 'Refund Processed') {

		}

	} else {
		$refund_rp = '';
		$followup_status = '';
		$follow_date = '';
		$yesp_amount = '';
		$rproccess = '';
		$img_name3 = '';
		$img_name4 = '';
	}

	if ($with_dism == 'Withdrawal') {
		$qryAssignTchr = "SELECT sno, teacher_id FROM `m_student` WHERE vnumber='$stid'";
		$rsltAssignTchr = mysqli_query($con, $qryAssignTchr);
		$w1 = '<p>Dear All,</p>';
		$w2 = '<p>Please find the given below List of Student Withdrawal by User Via Granville Portal.</p>';
		$w3 = '<table border="1" style="border-collapse:collapse; width:100%;border:1px solid #666;" cellpadding="4">
		<tr><th>Student Name</th><td>' . $fullname . '</td></tr>
		<tr><th>Location</th><td>' . $on_off_shore25 . '</td></tr>
		<tr><th>Student Email</th><td>' . $email_address25 . '</td></tr>
		<tr><th>Student Id</th><td>' . $stid . '</td></tr>
		<tr><th>Passport No.</th><td>' . $passp . '</td></tr>
		<tr><th>Intake</th><td>' . $prg_intake25 . '</td></tr>
		<tr><th>Program</th><td>' . $prg_name25 . '</td></tr>
		<tr><th>Start Date</th><td>' . $start_date_1 . '</td></tr>
		<tr><th>End Date</th><td>' . $expected_date_1 . '</td></tr>
		<tr><th>Status</th><td>' . $with_dism . '</td></tr>
		<tr><th>Updated By Name</th><td>' . $contact_person . '</td></tr>
		<tr><th>Updated On</th><td>' . $datetime_at . '</td></tr>
		</table>';
		$w4 = '<p><b>Thanks & Regards,</b><br>Team Granville College.</p>';

		$msg_body_w = $w1 . '' . $w2 . '' . $w3 . '' . $w4;
		$subject_w = 'Granville - Withdrawn Student Email - ' . ucfirst($firstname) . '';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
		$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
		$mail->SMTPSecure = 'tls';

		$mail->From = "no-reply@granville-college.com";
		$mail->FromName = 'Withdrawal Student | Granville College CRM';
		$mail->AddAddress("justyna@granvillecollege.ca");
		if (mysqli_num_rows($rsltAssignTchr)) {
			$rowTchrId = mysqli_fetch_assoc($rsltAssignTchr);
			$teacher_idFind = $rowTchrId['teacher_id'];
			$qryTchrName = "SELECT sno, username FROM `m_teacher` WHERE sno='$teacher_idFind'";
			$rsltTchrName = mysqli_query($con, $qryTchrName);
			$rowTchrName = mysqli_fetch_assoc($rsltTchrName);
			$instructorEmailId = $rowTchrName['username'];
			$mail->addCC("$instructorEmailId");
		}
		$mail->IsHTML(true);
		$mail->Subject = $subject_w;
		$mail->Body = $msg_body_w;
		if (!$mail->Send()) {
			//// echo 'Mailer Error: ' . $mail->ErrorInfo;
			//// exit();
		} else {
			//// echo 'success';
		}
	}

	if ($with_dism == 'Dismissed') {
		$qryAssignTchr = "SELECT sno, teacher_id FROM `m_student` WHERE vnumber='$stid'";
		$rsltAssignTchr = mysqli_query($con, $qryAssignTchr);
		$w1 = '<p>Dear All,</p>';
		$w2 = '<p>Please find the given below List of Student Dismissed by User Via Granville Portal.</p>';
		$w3 = '<table border="1" style="border-collapse:collapse; width:100%;border:1px solid #666;" cellpadding="4">
		<tr><th>Student Name</th><td>' . $fullname . '</td></tr>
		<tr><th>Location</th><td>' . $on_off_shore25 . '</td></tr>
		<tr><th>Student Email</th><td>' . $email_address25 . '</td></tr>
		<tr><th>Student Id</th><td>' . $stid . '</td></tr>
		<tr><th>Passport No.</th><td>' . $passp . '</td></tr>
		<tr><th>Intake</th><td>' . $prg_intake25 . '</td></tr>
		<tr><th>Program</th><td>' . $prg_name25 . '</td></tr>
		<tr><th>Start Date</th><td>' . $start_date_1 . '</td></tr>
		<tr><th>End Date</th><td>' . $expected_date_1 . '</td></tr>
		<tr><th>Status</th><td>' . $with_dism . '</td></tr>
		<tr><th>Updated By Name</th><td>' . $contact_person . '</td></tr>
		<tr><th>Updated On</th><td>' . $updated_on . '</td></tr>
		</table>';
		$w4 = '<p><b>Thanks & Regards,</b><br>Team Granville College.</p>';

		$msg_body_w = $w1 . '' . $w2 . '' . $w3 . '' . $w4;
		$subject_w = 'Granville - Dismissed Student Email - ' . ucfirst($firstname) . '';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->Username = "AKIA4C527CJUVPOZ6OEJ";
		$mail->Password = "BAvCRc2T5owMvVwUuMl1eMJRwahHsZYuxoRqitRyS9IY";
		$mail->SMTPSecure = 'tls';

		$mail->From = "no-reply@granville-college.com";
		$mail->FromName = 'Dismissed Student | Granville College CRM';
		$mail->AddAddress("justyna@granvillecollege.ca");

		if (mysqli_num_rows($rsltAssignTchr)) {
			$rowTchrId = mysqli_fetch_assoc($rsltAssignTchr);
			$teacher_idFind = $rowTchrId['teacher_id'];
			$qryTchrName = "SELECT sno, username FROM `m_teacher` WHERE sno='$teacher_idFind'";
			$rsltTchrName = mysqli_query($con, $qryTchrName);
			$rowTchrName = mysqli_fetch_assoc($rsltTchrName);
			$instructorEmailId = $rowTchrName['username'];
			$mail->addCC("$instructorEmailId");
		}
		$mail->IsHTML(true);
		$mail->Subject = $subject_w;
		$mail->Body = $msg_body_w;
		if (!$mail->Send()) {
			//// echo 'Mailer Error: ' . $mail->ErrorInfo;
			//// exit();
		} else {
			//// echo 'success';
		}
	}

	$remarks = mysqli_real_escape_string($con, $_POST['remarks']);

	if ($with_dism == 'Contract Signed') {
		$sten = ", `enrolled`='Contract Signed'";
		$sten2 = '';
		$sten3 = 'Contract Signed';
	} elseif ($with_dism == 'Started') {
		$sten = ", `started`='Started'";
		$sten2 = 'Started';
		$sten3 = '';
	} elseif ($with_dism == 'Re-enrolled') {
		$sten = '';
		$sten2 = '';
		$sten3 = '';

		$qryMStdLists = "SELECT teacher_id, betch_no FROM `m_student` WHERE app_id='$app_id'";
		$rsltMStdLists = mysqli_query($con, $qryMStdLists);
		$rowLists = mysqli_fetch_assoc($rsltMStdLists);
		$teacher_id = $rowLists['teacher_id'];
		$betch_no = $rowLists['betch_no'];

		$qryMStdLists2 = "INSERT INTO `m_student_delete_from_batch` (`app_id`, `vnumber`, `teacher_id`, `betch_no`, `updated_on`, `updated_by`) VALUES ('$app_id', '$stid', '$teacher_id', '$betch_no', '$updated_on', '$contact_person')";
		mysqli_query($con, $qryMStdLists2);

		$qryDelete = "DELETE FROM `m_student` WHERE vnumber ='$stid' AND app_id='$app_id'";
		mysqli_query($con, $qryDelete);

		$getQry2 = "UPDATE `st_application` SET `tearcher_assign`='', `tearcher_assign_old`='' WHERE `sno` ='$app_id'";
		mysqli_query($con, $getQry2);

	} else {
		$sten = '';
		$sten2 = '';
		$sten3 = '';
	}

	if ($with_dism == 'Started' || $with_dism == 'Re-enrolled') {
		$started_yesno = $_POST['started_yesno'];
		if ($started_yesno == 'Yes') {
			$commenc_date22 = $_POST['selected_start_date'];
			$expected_date22 = $_POST['selected_end_date'];
			$getQry = "SELECT * FROM `st_app_more` WHERE app_id='$app_id'";
			$getQryRslt = mysqli_query($con, $getQry);
			if (mysqli_num_rows($getQryRslt)) {
				mysqli_query($con, "update `st_app_more` set started_yesno='Yes', selected_start_date='$commenc_date22', selected_end_date='$expected_date22' where `app_id`='$app_id'");
			} else {
				$getQry3 = "INSERT INTO `st_app_more` (`app_id`, `selected_start_date`, `selected_end_date`, `started_yesno`) VALUES ('$app_id', '$commenc_date22', '$expected_date22', 'Yes')";
				mysqli_query($con, $getQry3);
			}
		}
	}

	if (mysqli_num_rows($queryRslt)) {
		$queryUpdate = "UPDATE `start_college` SET `dismissal_date`='$dismissal_date',`student_name`='$student_name', `student_id`='$stid', `refid`='$refid', `passport_no`='$passp', `with_dism`='$with_dism', `refund_rp`='$refund_rp', `followup_status`='$followup_status', `follow_date`='$follow_date', `rproccess`='$rproccess', `yesp_amount`='$yesp_amount', `remarks`='$remarks', `datetime_at`='$datetime_at', `inp_program`='$inp_program', `inp_start_date`='$inp_start_date', `inp_end_date`='$inp_end_date', `started_program`='$started_program', `started_start_date`='$started_start_date', `started_end_date`='$started_end_date', `in_w_d`='$contact_person', `program_change`='$program_change', `spr`='$spr' $sten $img_name4 WHERE `app_id`='$app_id'";
		mysqli_query($con, $queryUpdate);
	} else {
		$queryVgr2 = "INSERT INTO `start_college` (`dismissal_date`,`app_id`, `student_name`, `student_id`, `refid`, `passport_no`, `with_dism`, `refund_rp`, `followup_status`, `follow_date`, `rproccess`, `yesp_amount`, `remarks`, `datetime_at`, `inp_program`, `inp_start_date`, `inp_end_date`, `started_program`, `started_start_date`, `started_end_date`, `in_w_d`, `program_change`, `with_file`, `started`, `enrolled`, `spr`) VALUES ('$dismissal_date','$app_id', '$student_name', '$stid', '$refid', '$passp', '$with_dism', '$refund_rp', '$followup_status', '$follow_date', '$rproccess', '$yesp_amount', '$remarks', '$datetime_at', '$inp_program', '$inp_start_date', '$inp_end_date', '$started_program', '$started_start_date', '$started_end_date', '$contact_person', '$program_change', '$img_name3', '$sten2', '$sten3', '$spr')";
		mysqli_query($con, $queryVgr2);
	}

	$getInQry4 = "UPDATE `st_application` SET `student_status`='$with_dism' WHERE `sno`='$app_id'";
	mysqli_query($con, $getInQry4);

	$querylog = "INSERT INTO `start_college_logs` (`dismissal_date`,`app_id`, `with_dism`, `refund_rp`, `followup_status`, `follow_date`, `rproccess`, `yesp_amount`, `remarks`, `datetime_at`, `inp_program`, `inp_start_date`, `inp_end_date`, `in_w_d`, `program_change`, `spr`) VALUES ('$dismissal_date','$app_id', '$with_dism', '$refund_rp', '$followup_status', '$follow_date', '$rproccess', '$yesp_amount', '$remarks', '$datetime_at', '$inp_programLog', '$inp_start_dateLog', '$inp_end_dateLog', '$contact_person', '$program_change', '$spr')";
	mysqli_query($con, $querylog);
	header("Location: ../collegeStart/?getIntake=$getIntake2&SuccessFully_Submit$search_url&getStatus=$getStatus&getsearch=$refid");
}

if (isset($_POST['stNameSbtBtn'])) {
	$mobile = $_POST['mobile'];
	$email_address = $_POST['email_address'];
	$address1 = mysqli_real_escape_string($con, $_POST['address1']);
	$old_mobile = $_POST['old_mobile'];
	$old_email_address = $_POST['old_email_address'];
	$old_address1 = $_POST['old_address1'];
	$app_id = $_POST['app_id'];
	$updated_by_name = $_POST['updated_by_name'];

	$datetime_at = date('Y-m-d H:i:s');
	$slctQry_34 = "INSERT INTO `student_details_update` (`role`, `app_id`, `old_mobile`, `old_email_address`, `old_address1`, `mobile`, `email_address`, `address1`, `updated_by_name`, `updated_datetime`) VALUES ('IN', '$app_id', '$old_mobile', '$old_email_address', '$old_address1', '$mobile', '$email_address', '$address1', '$updated_by_name', '$datetime_at')";
	mysqli_query($con, $slctQry_34);

	$slctQry_3 = "UPDATE `st_application` SET `mobile`='$mobile', `email_address`='$email_address', `address1`='$address1' WHERE `sno`='$app_id'";
	mysqli_query($con, $slctQry_3);
	header("Location: ../collegeStart/?getIntake=$getIntake2&SuccessFully_Submit$search_url&getStatus=$getStatus");
}

if (isset($_POST['stNameSbtBtn_44'])) {
	$app_id = $_POST['app_id'];
	$can_contact_no = $_POST['can_contact_no'];
	$email_address = $_POST['email_address'];
	$can_address = mysqli_real_escape_string($con, $_POST['can_address']);

	$strp1 = "SELECT * FROM international_airport_student where app_id='$app_id'";
	$resultp1 = mysqli_query($con, $strp1);
	if (mysqli_num_rows($resultp1)) {
		$slctQryUpdate = "UPDATE `international_airport_student` SET `can_contact_no`='$can_contact_no', `email_address`='$email_address', `can_address`='$can_address' WHERE `app_id`='$app_id'";
		mysqli_query($con, $slctQryUpdate);
	} else {
		$slctQry_34 = "INSERT INTO `international_airport_student` ( `app_id`, `can_contact_no`, `email_address`, `can_address`) VALUES ('$app_id', '$can_contact_no', '$email_address', '$can_address')";
		mysqli_query($con, $slctQry_34);
	}
	header("Location: ../collegeStart/?getIntake=$getIntake2&SuccessFully_Submit$search_url&getStatus=$getStatus");
}

$getLocation2 = '';

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$total_records_per_page = 80;
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";



$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `both_main_table` where student_id!='' AND v_g_r_status='V-G' AND on_off_shore='Offshore' $searchInput $getIntake3 $getPName3 $getVGDate3 $statusInput3 $statusInput3_cont $agentInput3");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$rsltQuery = "SELECT * FROM both_main_table where student_id!='' AND v_g_r_status='V-G' AND on_off_shore='Offshore'  $searchInput $getIntake3 $getPName3 $getVGDate3 $statusInput3 $statusInput3_cont $agentInput3 order by main_id DESC LIMIT $offset, $total_records_per_page";
?>
<link rel="stylesheet" href="../../css/sweetalert.min.css">
<script src="../../js/sweetalert.min.js"></script>
<style>
	.error_color {
		border: 2px solid #de0e0e;
	}

	.validError {
		border: 2px solid #ccc;
	}

	.blink-bg {
		color: #fff;
		padding: 3px;
		display: inline-block;
		border-radius: 4px;
		animation: blinkingBackground 2s infinite;
	}

	@keyframes blinkingBackground {
		0% {
			background-color: #10c018;
		}

		25% {
			background-color: #1056c0;
		}

		50% {
			background-color: #ef0a1a;
		}

		75% {
			background-color: #254878;
		}

		100% {
			background-color: #04a1d5;
		}
	}
</style>

<link rel="stylesheet" type="text/css" href="../../css/fixed-table.css">
<script src="../../js/fixed-table.js"></script>
<section class="container-fluid">
	<div class="main-div">
		<div class="admin-dashboard">
			<div class="row justify-content-between">

				<div class="col-8 mb-3">
					<h3 class=" my-0"><span class="blink-bg"><u>VG</span>(Student Status)</u></h3>
				</div>
				<div class="col-4 mb-3">
					<form method="POST" action="excelSheet.php" autocomplete="off">
						<input type="hidden" name="role" value="<?php echo 'Student_Status'; ?>">
						<input type="hidden" name="keywordLists" value="<?php echo $searchTerm; ?>">
						<input type="hidden" name="intakeInput" value="<?php echo $getIntake2; ?>">
						<input type="hidden" name="pNameInput" value="<?php echo $getPName2; ?>">
						<input type="hidden" name="getVGDate" value="<?php echo $getVGDate2; ?>">
						<input type="hidden" name="getLocation" value="<?php echo $getLocation2; ?>">
						<input type="hidden" name="getStatus" value="<?php echo $getStatus; ?>">
						<input type="hidden" name="statusInput" value="<?php echo $statusInput2; ?>">
						<input type="hidden" name="statusInput_cont" value="<?php echo $statusInput2_cont; ?>">
						<input type="hidden" name="sessionid1" value="<?php echo $sessionid1; ?>">
						<?php if ($sessionid1 == '3716') { ?>
							<input type="hidden" name="OnshoreShow" value="Onshore">
						<?php } else { ?>
							<input type="hidden" name="Onshore" value="">
						<?php } ?>
						<button type="submit" name="studentlist" class="btn btn-sm btn-success float-right">Download
							Excel</button>
					</form>
				</div>



				<form action="" method="post" autocomplete="off" class="col-sm-12">
					<div class="row">
						<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-3">
							<label><b>Program Name:</b></label>
							<div class="input-group input-group-sm">
								<select name="pNameInput" class="form-control">
									<option value="">Filter by Program</option>
									<option value="">All</option>
									<?php
									$rsltQuery6 = "SELECT * FROM `contract_courses` GROUP BY program_name";
									$qurySql6 = mysqli_query($con, $rsltQuery6);
									while ($row_nm6 = mysqli_fetch_assoc($qurySql6)) {
										$program_name36 = $row_nm6['program_name'];
										?>
										<option value="<?php echo $program_name36; ?>" <?php if ($program_name36 == $getPName2) {
											   echo 'selected="selected"';
										   } ?>>
											<?php echo $program_name36; ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-lg-3 col-xl-1 mb-3">
							<label><b>Intake:</b></label>
							<div class="input-group input-group-sm">
								<select name="intakeInput" class="form-control">
									<option value="">Select Intake</option>
									<option value="">All</option>
									<?php
									if ($sessionid1 == '3716') {
										$rsltQuery5 = "SELECT intake FROM contract_courses WHERE program_name!='' Group BY intake ORDER BY sno DESC";
									} else {
										$rsltQuery5 = "SELECT intake FROM contract_courses WHERE program_name!='' AND (STR_TO_DATE(commenc_date, '%Y/%m/%d')) >= '2024/05/13' Group BY intake ORDER BY intake DESC";
									}
									$qurySql5 = mysqli_query($con, $rsltQuery5);
									while ($row_nm5 = mysqli_fetch_assoc($qurySql5)) {
										$intake34 = $row_nm5['intake'];
										?>
										<option value="<?php echo $intake34; ?>" <?php if ($intake34 == $getIntake2) {
											   echo 'selected="selected"';
										   } ?>><?php echo $intake34; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-3">
							<label><b>Agent:</b></label>
							<div class="input-group input-group-sm">
								<select name="agentInput" class="form-control">
									<option value="">Select Agent</option>
									<option value="">All</option>
									<?php
									$rsltQuery8 = "SELECT sno, username FROM `allusers` WHERE role='Agent'";
									$qurySql8 = mysqli_query($con, $rsltQuery8);
									while ($row_nm8 = mysqli_fetch_assoc($qurySql8)) {
										$sno34 = $row_nm8['sno'];
										$username34 = $row_nm8['username'];
										?>
										<option value="<?php echo $sno34; ?>" <?php if ($sno34 == $agentInput2) {
											   echo 'selected="selected"';
										   } ?>><?php echo $username34; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-lg-3 col-xl-1 mb-3">
							<label><b>VG Date:</b></label>
							<div class="input-group input-group-sm">
								<select name="getVGInput" class="form-control">
									<option value="">V-G Submit Date</option>
									<option value="">All</option>
									<?php
									$rsltQuery6 = "SELECT v_g_r_status_datetime FROM st_application where v_g_r_status='V-G' AND (STR_TO_DATE(prg_intake, '%b-%Y')) >= '2024-05-00' Group BY DATE_FORMAT(v_g_r_status_datetime, '%Y-%m-%d') ORDER BY v_g_r_status_datetime DESC";
									$qurySql6 = mysqli_query($con, $rsltQuery6);
									while ($row_nm6 = mysqli_fetch_assoc($qurySql6)) {
										$intake36_1 = $row_nm6['v_g_r_status_datetime'];
										$intake36 = date('Y-m-d', strtotime("$intake36_1"));
										?>
										<option value="<?php echo $intake36; ?>" <?php if ($intake36 == $getVGDate2) {
											   echo 'selected="selected"';
										   } ?>><?php echo $intake36; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-lg-3 col-xl-1 mb-3">
							<label><b>Status:</b></label>
							<div class="input-group input-group-sm">
								<select name="statusInput" class="form-control">
									<option value="">Select Option</option>
									<option value="Started" <?php if ($statusInput2 == 'Started') {
										echo 'selected="selected"';
									} ?>>Started</option>
									<option value="Not_started" <?php if ($statusInput2 == 'Not_started') {
										echo 'selected="selected"';
									} ?>>Not started</option>
									<option value="Deferred" <?php if ($statusInput2 == 'Deferred') {
										echo 'selected="selected"';
									} ?>>Deferred</option>
									<option value="Withdrawal" <?php if ($statusInput2 == 'Withdrawal') {
										echo 'selected="selected"';
									} ?>>Withdrawal</option>
									<option value="Dismissed" <?php if ($statusInput2 == 'Dismissed') {
										echo 'selected="selected"';
									} ?>>Dismissed</option>
								</select>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-lg-3 col-xl-1 mb-3">
							<label><b>Contract St:</b></label>
							<div class="input-group input-group-sm">
								<select name="statusInput_cont" class="form-control">
									<option value="">Select Option</option>
									<option value="Accept" <?php if ($statusInput2_cont == 'Accept') {
										echo 'selected="selected"';
									} ?>>Signed Contract - Done</option>
									<option value="Pending" <?php if ($statusInput2_cont == 'Pending') {
										echo 'selected="selected"';
									} ?>>Signed Contract - Pending</option>
								</select>
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-3">
							<label><b>Name & ID:</b></label>
							<div class="input-group">
								<input type="text" name="inputval" placeholder="Search By Stu. Name or ID"
									class="form-control form-control-sm" value="<?php echo $searchTerm; ?>">
								<input type="hidden" name="getStatus" value="<?php echo $getStatus; ?>">
							</div>
						</div>

						<div class="col-sm-6 col-md-4 col-lg-3 col-xl-1 mb-3 mt-sm-4 pt-2">
							<input type="submit" name="srchClickbtn"
								class="btn btn-sm float-sm-left float-right btn-success" value="Search">

						</div>
					</div>
				</form>

				<div class="col-12 mt-2">
					<div id="fixed-table-container-1" class="fixed-table-container">
						<table class="table table-sm table-bordered" width="100%">
							<thead>
								<tr>
									<th>Std. Name</th>
									<th>Std. ID</th>
									<th>Location</th>
									<th>Agent Name</th>
									<th>DOB</th>
									<th>Program Name</th>
									<th>Start Date(LOA)</th>
									<th>End Date(LOA)</th>
									<th>Passport</th>
									<th>VG Date</th>
									<th>All Docs</th>
									<th>Docs Status</th>
									<th>Email/Edit</th>
									<th>Study Permit</th>
									<th>Action/Logs</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$qurySql = mysqli_query($con, $rsltQuery);
								// $clg_serial_no=1;
								if (mysqli_num_rows($qurySql)) {
									while ($row_nm = mysqli_fetch_assoc($qurySql)) {
										$snoid = $row_nm['sno'];
										$clg_serial_no_bkup = $row_nm['clg_serial_no2'];
										$user_id = $row_nm['user_id'];
										$fname = $row_nm['fname'];
										$lname = $row_nm['lname'];
										$fullname = ucfirst($fname) . ' ' . ucfirst($lname);
										$refid = $row_nm['refid'];
										$dob = $row_nm['dob'];
										$student_id = $row_nm['student_id'];
										$passport_no = $row_nm['passport_no'];
										$email_address = $row_nm['email_address'];
										$prg_name1 = $row_nm['prg_name1'];
										$prg_intake = $row_nm['prg_intake'];
										$on_off_shore = $row_nm['on_off_shore'];
										$study_permit_yes2 = $row_nm['study_permit'];
										$study_insurance_form_mail_sent = $row_nm['study_insurance_form_mail_sent'];
										$v_g_r_status_datetime = $row_nm['v_g_r_status_datetime'];
										if (!empty($v_g_r_status_datetime)) {
											$vgDate = date('Y-m-d', strtotime("$v_g_r_status_datetime"));
										} else {
											$vgDate = 'N/A';
										}

										$queryGet2 = "SELECT sno, with_dism, refund_rp, datetime_at,dismissal_date, in_w_d, with_file, started_program, started_start_date, started_end_date FROM `start_college` WHERE with_dism!='' AND app_id='$snoid' ORDER BY sno DESC";
										$queryRslt2 = mysqli_query($con, $queryGet2);
										if (mysqli_num_rows($queryRslt2)) {
											$rowSC = mysqli_fetch_assoc($queryRslt2);
											$with_dism2 = $rowSC['with_dism'];
											$with_dism = $rowSC['with_dism'];
											$refund_rp = $rowSC['refund_rp'];
											$datetime_atS = substr($rowSC['datetime_at'], 0, 10);
											$datetime_atS1 = substr($rowSC['dismissal_date'], 0, 10);
											$in_w_d = $rowSC['in_w_d'];
											$with_file3 = $rowSC['with_file'];
											if (!empty($with_file3)) {
												$with_file_download = "<br><a href='../../Student_File/$with_file3' download>Download File</a>";
											} else {
												$with_file_download = '';
											}
											$started_program2 = $rowSC['started_program'];
											if (!empty($started_program2)) {
												$started_program = '<b>Program: </b>' . $started_program2 . '<br>';
												$started_start_date = '<b>Start Date: </b>' . $rowSC['started_start_date'] . '<br>';
												$started_end_date = '<b>End Date: </b>' . $rowSC['started_end_date'];
											} else {
												$started_program = '';
												$started_start_date = '';
												$started_end_date = '';
											}
										} else {
											$with_dism = '<span style="color:red;">No Action</span>';
											$with_dism2 = '';
											$refund_rp = '';
											$datetime_atS = '';
											$datetime_atS1 = '';
											$in_w_d = '';

											$started_program = '';
											$started_start_date = '';
											$started_end_date = '';
											$with_file_download = '';
										}
										$getquery22 = "SELECT username FROM `allusers` WHERE sno='$user_id'";
										$RefundsWeeklyRslt22 = mysqli_query($con, $getquery22);
										$row_nm22 = mysqli_fetch_assoc($RefundsWeeklyRslt22);
										$username = mysqli_real_escape_string($con, $row_nm22['username']);

										$queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
										$queryRslt4 = mysqli_query($con, $queryGet4);
										$rowSC4 = mysqli_fetch_assoc($queryRslt4);
										$start_date = $rowSC4['commenc_date'];
										$expected_date = $rowSC4['expected_date'];

										$slctQry_23 = "SELECT email_address FROM international_airport_student where app_id='$snoid'";
										$checkQuery_23 = mysqli_query($con, $slctQry_23);
										if (mysqli_num_rows($checkQuery_23)) {
											$rowStartValue_33 = mysqli_fetch_assoc($checkQuery_23);
											$email_address_33 = $rowStartValue_33['email_address'];
										} else {
											$email_address_33 = '';
										}

										$slctQry_24 = "SELECT id, app_id, send_date, signed_contract, contract_status FROM st_app_more where app_id='$snoid'";
										$checkQuery_24 = mysqli_query($con, $slctQry_24);
										$getZip = '4) Enrollment Contract - Pending';
										if (mysqli_num_rows($checkQuery_24)) {
											$rowStartValue_34 = mysqli_fetch_assoc($checkQuery_24);
											$send_date = $rowStartValue_34['send_date'];
											$signed_contract = $rowStartValue_34['signed_contract'];
											$contract_status = $rowStartValue_34['contract_status'];

											if (!empty($send_date)) {
												$statusDocs = '1) Sent Email to Student - <span class="text-success"><b>Done</b></span><br>';
											} else {
												$statusDocs = '1) Send Email to Student - <span class="text-danger">Pending</span><br>';
											}

											if (!empty($signed_contract)) {
												$statusDocs2 = '2) Signed By Student - <span class="text-success"><b>Done</b></span><br>';
												$getZip = '4) Enrollment Contract - <a href="localhost/accagents/backend/docsign/' . $signed_contract . '" download>Download</a>';
											} else {
												$statusDocs2 = '2) Signed By Student - <span class="text-danger">Pending</span><br>';
											}

											if (!empty($contract_status)) {
												$statusDocs3 = '3) Signed By College - <span class="text-success"><b>' . $contract_status . '</b></span><br>';
											} else {
												$statusDocs3 = '3) Signed By College - <span class="text-danger">Pending</span><br>';
											}

										} else {
											$statusDocs = '1) Send Email to Student - <span class="text-danger">Pending</span><br>';
											$statusDocs2 = '2) Signed By Student - <span class="text-danger">Pending</span><br>';
											$statusDocs3 = '3) Signed By College - <span class="text-danger">Pending</span><br>';
											$getZip = '4) Enrollment Contract - <span class="text-danger">Pending</span>';
										}
										?>
										<tr>
											<td class="name-id"><?php echo $fname . ' ' . $lname; ?></td>
											<td style="white-space: nowrap;"><?php echo $student_id; ?></td>
											<td><?php echo $on_off_shore; ?></td>
											<td><?php echo $username; ?></td>
											<td style="white-space: nowrap;"><?php echo $dob; ?></td>
											<td><?php echo $prg_name1; ?></td>
											<td style="white-space: nowrap;"><?php echo $start_date; ?></td>
											<td style="white-space: nowrap;">
												<?php
												echo $expected_date; //$started_program.''.$started_start_date.''.$started_end_date;
												?>
											</td>
											<td style="white-space: nowrap;"><?php echo $passport_no; ?></td>
											<td style="white-space: nowrap;"><?php echo $vgDate; ?></td>
											<td style="white-space: nowrap;">
												<form method="post" action="download_docs.php">
													<input type="hidden" name="stusno" value="<?php echo $snoid; ?>">
													<button type="submit" name="submit"
														class="btn btn-success btn-sm">Download</button>
												</form>
											<td style="white-space: nowrap;">
												<?php
												echo $statusDocs . ' ' . $statusDocs2 . ' ' . $statusDocs3 . ' ' . $getZip;
												if ($sessionid1 == '3716') {
													echo '<br><a href="../clg_docs/signedContractSend.php?stid=' . $snoid . '">Send Student to Enrollment Contract <i class="fas fa-arrow-right"></i></a>';
												}
												?>
											</td>
											</td>
											<td style="white-space: nowrap;">
												Contract - <?php echo $email_address; ?> <i class='far fa-edit editNameClass'
													data-toggle="modal" data-target="#editNameModel"
													data-id="<?php echo $snoid; ?>"
													st-no="<?php echo $fname . ' ' . $lname; ?>"></i><br>
												<?php
												if (!empty($email_address_33)) {
													echo 'Canvas - ' . $email_address_33;
												} else {
													echo 'Canvas - <span style="color:red;">Add Details</span>';
												}
												?> <i class='far fa-edit editNameNewClass' data-toggle="modal" data-target="#editNameNewModel"
													data-id="<?php echo $snoid; ?>"
													st-no="<?php echo $fname . ' ' . $lname; ?>"></i>
											</td>
										
											<!-- <?php if ($sessionid1 != '4792' && $sessionid1 != '4293' && $getStatus != 'Dismissed') { ?> -->
												<td>
													<?php
													if (!empty($study_permit_yes2) && $study_permit_yes2 == 'Yes') {
														$stprmt = 'success';
														$study_permit_No2 = '';
														$study_permit_FileCheck = '<br><a href="studyPermitInsunce.php?getsearch=' . $refid . '">Check Study Permit File</a>';
													} else {
														if (!empty($study_permit_yes2) && $study_permit_yes2 == 'No') {
															$stprmt = 'danger';
															$study_permit_No2 = ' - No';
															$study_permit_FileCheck = '';
														} else {
															$stprmt = 'warning';
															$study_permit_No2 = '';
															$study_permit_FileCheck = '';
														}
													}
													?>
													<span class="btn btn-sm btn-<?php echo $stprmt; ?> statusClassStuPmt my-1"
														data-toggle="modal" data-target="#statusModalStuPmt"
														data-id="<?php echo $snoid; ?>" data-name="<?php echo $fullname; ?>"
														data-refid="<?php echo $refid; ?>" data-stid="<?php echo $student_id; ?>"
														data-passp="<?php echo $passport_no; ?>">Add Status</span>
													<?php echo $study_permit_FileCheck; ?>
												</td>
											<!-- <?php } ?> -->
											<td style="white-space: nowrap;">
												<!-- <?php if ($sessionid1 == '4792' || $sessionid1 == '4293' || ($sessionid1 == '3738' && $getStatus == 'Dismissed')) { ?> -->
													<span class="btn btn-sm btn-success statusClass my-1" data-toggle="modal"
														data-target="#statusModal" data-id="<?php echo $snoid; ?>"
														data-name="<?php echo $fullname; ?>" data-refid="<?php echo $refid; ?>"
														data-stid="<?php echo $student_id; ?>"
														data-passp="<?php echo $passport_no; ?>"
														data-with-dism="<?php echo $with_dism2; ?>">Add Status</span>

													<span class="btn btn-sm btn-info allClass my-1" data-toggle="modal"
														data-target="#allModel" data-id="<?php echo $snoid; ?>"
														data-name="<?php echo $fullname; ?>">Logs</span>
													<?php
													?>
												<!-- <?php } else { ?> -->
													<?php if (!empty($study_permit_yes2) && $study_permit_yes2 == 'Yes') { ?>
														<span class="btn btn-sm btn-success statusClass my-1" data-toggle="modal"
															data-target="#statusModal" data-id="<?php echo $snoid; ?>"
															data-name="<?php echo $fullname; ?>" data-refid="<?php echo $refid; ?>"
															data-stid="<?php echo $student_id; ?>"
															data-passp="<?php echo $passport_no; ?>"
															data-with-dism="<?php echo $with_dism2; ?>">Add Status</span>

														<span class="btn btn-sm btn-info allClass my-1" data-toggle="modal"
															data-target="#allModel" data-id="<?php echo $snoid; ?>"
															data-name="<?php echo $fullname; ?>">Logs</span>
														<?php
													} else {
														echo '<span style="color:red;">Update Study Permit ' . $study_permit_No2 . '</span>';
													}
												}
												if ($with_dism == 'Dismissed') {
													echo '<br>' . $with_dism . '<br>' . $datetime_atS1;
												} else {
													echo '<br>' . $with_dism . '<br>' . $datetime_atS;
												}

												if ($with_dism == 'Started' || $with_dism == 'Re-enrolled') {
													echo '<br><a href="../clg_docs/signedContractSend.php?stid=' . $snoid . '" target="_blank">Go to Contract Re-Signed</a>';
												}
												?>
											</td>
											<?php
											if ($sessionid1 == '3738' || $sessionid1 == '3717' || $sessionid1 == '4226' || $sessionid1 == '3716') {
												if (!empty($study_insurance_form_mail_sent)) {
													$ddd = 'Resend Email';
													$dddBtn = 'success';
												} else {
													$ddd = 'Send Email';
													$dddBtn = 'warning';
												}
												?>
												<td style="white-space: nowrap;">
													<span
														class="text-right my-1 btn btn-<?php echo $dddBtn; ?> btn-sm mt-sm-0 sendbtnClick"
														data-id="<?php echo $snoid; ?>"><?php echo $ddd; ?></span>

													<span class="btn btn-sm my-1 btn-info allSIF" data-toggle="modal"
														data-target="#modelSIF" data-id="<?php echo $snoid; ?>"
														data-name="<?php echo $fullname; ?>">Logs</span>
												</td>
											<?php } ?>
										</tr>
									<?php }
								} else {
									echo '<tr><td colspan="15"><center>Not Found!!!</center></td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-md-8 mt-2 pl-3 text-center text-md-left">
					<strong>Total Records <?php echo $total_records; ?>, </strong>
					<strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
				</div>

				<div class="col-md-4 mt-2">
					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-end">
							<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>

							<li <?php if ($page_no <= 1) {
								echo "class='page-item disabled'";
							} ?>>
								<a <?php if ($page_no > 1) {
									echo "href='?page_no=$previous_page&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2'";
								} ?> class='page-link'><i class="fas fa-chevron-left"></i></a>
							</li>

							<?php
							if ($total_no_of_pages <= 10) {
								for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
									} else {
										echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>$counter</a></li>";
									}
								}
							} elseif ($total_no_of_pages > 10) {

								if ($page_no <= 4) {
									for ($counter = 1; $counter < 8; $counter++) {
										if ($counter == $page_no) {
											echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
										} else {
											echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>$counter</a></li>";
										}
									}
									echo "<li><a>...</a></li>";
									echo "<li><a href='?page_no=$second_last&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>$second_last</a></li>";
									echo "<li><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>$total_no_of_pages</a></li>";
								} elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
									echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>1</a></li>";
									echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>2</a></li>";
									echo "<li class='page-item'><a class='page-link'>...</a></li>";
									for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
										if ($counter == $page_no) {
											echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
										} else {
											echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>$counter</a></li>";
										}
									}
									echo "<li class='page-item'><a class='page-link'>...</a></li>";
									echo "<li class='page-item'><a href='?page_no=$second_last&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>$second_last</a></li>";
									echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>$total_no_of_pages</a></li>";
								} else {
									echo "<li class='page-item'><a href='?page_no=1&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>1</a></li>";
									echo "<li class='page-item'><a href='?page_no=2&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>2</a></li>";
									echo "<li class='page-item'><a class='page-link'>...</a></li>";

									for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
										if ($counter == $page_no) {
											echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
										} else {
											echo "<li class='page-item'><a href='?page_no=$counter&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'>$counter</a></li>";
										}
									}
								}
							}
							?>

							<li <?php if ($page_no >= $total_no_of_pages) {
								echo "class='page-item disabled'";
							} ?>>
								<a <?php if ($page_no < $total_no_of_pages) {
									echo "href='?page_no=$next_page&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2'";
								} ?> class='page-link'><i class="fas fa-angle-right"></i></a>
							</li>
							<?php if ($page_no < $total_no_of_pages) {
								echo "<li class='page-item'><a href='?page_no=$total_no_of_pages&getsearch=$search_url&getIntake=$getIntake2&getLocation=$getLocation2&getStatus=$getStatus&statusInput=$statusInput2&agentInput=$agentInput2' class='page-link'><i class='fas fa-angle-double-right'></i></a></li>";
							} ?>
						</ul>
					</nav>
				</div>
			</div>

		</div>
	</div>
	</div>
</section>

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

<div class="modal fade" id="modelSIF">
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
								<th>Name</th>
								<th>Email</th>
								<th>Program</th>
								<th>STUDY PERMIT</th>
								<th>INSURANCE</th>
							</tr>
						</thead>
						<tbody class="getSIFLogsDiv">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editNameModel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Details - <span class="stNameLogs"></span></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="editNameChange"></div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editNameNewModel">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Canada Details - <span class="stNameLogs"></span></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="editNameChangeNew"></div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<div class="modal" id="statusModalStuPmt">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Status - <span class="getNameId"></span></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body getStudyPermitLists"></div>
			<div class="modal-footer">
				<a href="" class="btn btn-danger closeBtnDiv">Submit</a>
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
		var getVal6 = $(this).attr('data-with-dism');
		var getStatus = '<?php echo $getStatus; ?>';
		$('.getNameId').html(getVal2);
		$.post("../responseStart.php?tag=getStartLists", { "idno": getVal, "name": getVal2, "passp": getVal3, "stid": getVal4, "refid": getVal5, "getStatus": getStatus, "statusD": getVal6 }, function (d) {
			$('.getStartLists').html("");
			$('' + d[0].getStartLists + '').appendTo(".getStartLists");

			$(document).on('change', '.wDisDiv', function () {
				var getwDisDiv = $('.wDisDiv').val();
				if (getwDisDiv == 'Withdrawal') {
					$('.withdrawal_dateDiv').show();
				} else {
					$('.withdrawal_dateDiv').hide();
					$('.newStartEndDate').hide();
				}
				if (getwDisDiv == 'Dismissed') {
					$('.dismissal_dateDiv').show();
				} else {
					$('.dismissal_dateDiv').hide();
					$('.newStartEndDate').hide();
				}
				if (getwDisDiv == 'Started' || getwDisDiv == 'Re-enrolled') {
					$('.startedYesNo').show();
				} else {
					$('.startedYesNo').hide();
				}
			});

			$('.yesnoStartAlert').on('change', function () {
				var gettval = $(this).val();
				if (gettval == 'Yes') {
					if (confirm("Are you sure you want to change Start & End Date?")) {
						$('.newStartEndDate').show();
						return true;
					} else {
						$('.newStartEndDate').hide();
						return false;
					}
				} else {
					$('.newStartEndDate').hide();
				}
			});

			$(function () {
				$(".datepickerDiv").datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth: false,
					changeYear: false,
				});
			});

			$("#firsttab_requried").submit(function () {
				var submit = true;
				$(".is_require:visible").each(function () {
					if ($(this).val() == '') {
						$(this).addClass('error_color');
						submit = false;
					} else {
						$(this).addClass('validError');
					}
				});
				if (submit == true) {
					return true;
				} else {
					$('.is_require').keyup(function () {
						$(this).removeClass('error_color');
					});
					return false;
				}
			});

		});
	});
</script>

<script>
	$(document).on('change', '.StuPmtDiv', function () {
		var getVal = $(this).val();
		if (getVal == 'Yes' || getVal == 'No') {
			$('.activeBtnDiv').show();
			$('.closeBtnDiv').hide();
		} else {
			$('.closeBtnDiv').show();
			$('.activeBtnDiv').hide();
		}
	});
</script>

<script type="text/javascript">
	$(document).on('click', '.allClass', function () {
		var idmodel = $(this).attr('data-id');
		var getHeadVal = $(this).attr('data-name');
		$('.stNameLogs').html(getHeadVal);
		$('.loading_icon').show();
		$.post("../responseStart.php?tag=getAllLogs", { "idno": idmodel }, function (il) {
			$('.getAllLogsDiv').html("");
			if (il == '') {
				$('.getAllLogsDiv').html("<tr><td colspan='11'><center>Not Found</center></td></tr>");
			} else {
				for (i in il) {
					$('<tr>' +
						'<td>' + il[i].idLogs + '</td>' +
						'<td>' + il[i].with_dismLogs + '</td>' +
						'<td style="white-space: nowrap;">' + il[i].inpStLogs + '</td>' +
						'<td>' + il[i].refund_rpLogs + '</td>' +
						'<td>' + il[i].rproccessLogs + '</td>' +
						'<td>' + il[i].yesp_amountLogs + '</td>' +
						'<td>' + il[i].followup_statusLogs + '</td>' +
						'<td>' + il[i].follow_dateLogs + '</td>' +
						'<td>' + il[i].remarksLogs + '</td>' +
						'<td>' + il[i].updateLogs + '</td>' +
						'<td>' + il[i].in_w_dLogs + '</td>' +
						'</tr>').appendTo(".getAllLogsDiv");
				}
			}
			$('.loading_icon').hide();
		});
	});

	$(document).on('click', '.allSIF', function () {
		var idmodel = $(this).attr('data-id');
		var getHeadVal = $(this).attr('data-name');
		$('.stNameLogs').html(getHeadVal);
		$('.loading_icon').show();
		$.post("../responseStart.php?tag=getSIFLogs", { "idno": idmodel }, function (il) {
			$('.getSIFLogsDiv').html("");
			if (il == '') {
				$('.getSIFLogsDiv').html("<tr><td colspan='6'><center>Not Found</center></td></tr>");
			} else {
				for (i in il) {
					$('<tr>' +
						'<td>' + il[i].idLogs + '</td>' +
						'<td>' + il[i].fullnameLogs + '</td>' +
						'<td style="white-space: nowrap;">' + il[i].email_addressLogs + '</td>' +
						'<td>' + il[i].programLogs + '</td>' +
						'<td>' + il[i].study_fileLogs + '</td>' +
						'<td>' + il[i].insuranceLogs + '</td>' +
						'</tr>').appendTo(".getSIFLogsDiv");
				}
			}
			$('.loading_icon').hide();
		});
	});	
</script>

<script type="text/javascript">
	$(document).on('change', '.ipDiv', function () {
		var getVal = $(this).val();
		if (getVal == 'Inprogress') {
			$('.InprgsDiv').show();
		} else {
			$('.InprgsDiv').hide();
		}
	});
	$(document).on('change', '.wDisDiv', function () {
		var getVal = $(this).val();
		if (getVal == 'Withdrawal' || getVal == 'Dismissed') {
			$('.contractSgndDiv').hide();
			$('.startedDiv').hide();
			$('.rfndRPDiv').show();
			$('.inpsDiv').hide();
			$('.flupDiv').hide();
			$('.flwpDateDiv').hide();
			$('.rfndPrDiv').hide();
			$('.yespDiv').hide();
			$('.withFileDiv').hide();
			// $('.sprDiv').hide();
		} else if (getVal == 'Graduate') {
			$('.contractSgndDiv').hide();
			$('.startedDiv').hide();
			$('.inpsDiv').show();
			$('.rfndRPDiv').hide();
			$('.flupDiv').hide();
			$('.flwpDateDiv').hide();
			$('.rfndPrDiv').hide();
			$('.yespDiv').hide();
			$('.withFileDiv').hide();
			// $('.sprDiv').hide();
		} else if (getVal == 'Contract Signed') {
			$('.contractSgndDiv').show();
			$('.startedDiv').hide();
			$('.inpsDiv').hide();
			$('.rfndRPDiv').hide();
			$('.flupDiv').hide();
			$('.flwpDateDiv').hide();
			$('.rfndPrDiv').hide();
			$('.yespDiv').hide();
			$('.withFileDiv').hide();
			// $('.sprDiv').hide();
		} else if (getVal == 'Started') {
			$('.contractSgndDiv').hide();
			$('.startedDiv').hide();
			$('.inpsDiv').hide();
			$('.rfndRPDiv').hide();
			$('.flupDiv').hide();
			$('.flwpDateDiv').hide();
			$('.rfndPrDiv').hide();
			$('.yespDiv').hide();
			$('.withFileDiv').hide();
			// $('.sprDiv').show();
		} else if (getVal == 'Not started' || getVal == 'Deferred') {
			$('.contractSgndDiv').hide();
			$('.startedDiv').hide();
			$('.inpsDiv').hide();
			$('.rfndRPDiv').hide();
			$('.flupDiv').hide();
			$('.flwpDateDiv').hide();
			$('.rfndPrDiv').hide();
			$('.yespDiv').hide();
			$('.withFileDiv').hide();
			// $('.sprDiv').hide();
		} else {
			$('.contractSgndDiv').hide();
			$('.startedDiv').hide();
			$('.rfndRPDiv').hide();
			$('.inpsDiv').hide();
			$('.flupDiv').hide();
			$('.flwpDateDiv').hide();
			$('.rfndPrDiv').hide();
			$('.yespDiv').hide();
			$('.withFileDiv').hide();
			// $('.sprDiv').hide();
		}
	});
	$(document).on('change', '.rfndRPList', function () {
		var getVal = $(this).val();
		if (getVal == 'Refund Request') {
			$('.flupDiv').show();
			$('.rfndPrDiv').hide();
			$('.yespDiv').hide();
			$('.withFileDiv').show();
		} else if (getVal == 'Refund Processed') {
			$('.flupDiv').hide();
			$('.flwpDateDiv').hide();
			$('.rfndPrDiv').show();
			$('.withFileDiv').show();
		} else {
			$('.flupDiv').hide();
			$('.flwpDateDiv').hide();
			$('.rfndPrDiv').hide();
			$('.yespDiv').hide();
			$('.withFileDiv').hide();
		}
	});
	$(document).on('change', '.fdDiv', function () {
		var getVal = $(this).val();
		if (getVal == 'Followup') {
			$('.flwpDateDiv').show();
		} else {
			$('.flwpDateDiv').hide();
		}
	});
	$(document).on('change', '.contractSgndDiv', function () {
		var getVal = $(this).val();
		if (getVal == 'Followup') {
			$('.flwpDateDiv').show();
		} else {
			$('.flwpDateDiv').hide();
		}
	});

	$(document).on('change', '.rproccessDiv', function () {
		var getVal = $(this).val();
		if (getVal == 'Yes') {
			$('.yespDiv').show();
		} else if (getVal == 'No') {
			$('.yespDiv').hide();
		} else {
			$('.yespDiv').hide();
		}
	});

	$(document).on('change', '.pcDiv', function () {
		var getVal = $(this).val();
		if (getVal == 'Yes') {
			$('.startedDiv').show();
		} else if (getVal == 'No') {
			$('.startedDiv').hide();
		} else {
			$('.startedDiv').hide();
		}
	});
</script>

<script type="text/javascript">
	$(document).on('click', '.editNameClass', function () {
		var getVal = $(this).attr('data-id');
		var getHeadVal = $(this).attr('st-no');
		$('.stNameLogs').html(getHeadVal);
		$.post("../responseStart.php?tag=changeNameSt", { "idno": getVal }, function (obj12) {
			$('.editNameChange').html("");
			$('' + obj12[0].editNameChange + '').appendTo(".editNameChange");
		});
	});

	$(document).on('click', '.editNameNewClass', function () {
		var getVal = $(this).attr('data-id');
		var getHeadVal = $(this).attr('st-no');
		$('.stNameLogs').html(getHeadVal);
		$.post("../responseStart.php?tag=changeNameStNew", { "idno": getVal }, function (obj12) {
			$('.editNameChangeNew').html("");
			$('' + obj12[0].editNameChangeNew + '').appendTo(".editNameChangeNew");
		});
	});
</script>

<script type="text/javascript">
	$(document).on('click', '.sendbtnClick', function () {
		var stusno = $(this).attr('data-id');
		var checkstr = confirm('Are you sure you want to Sent Email to Student?');
		if (checkstr == true) {
			$.post("sendStudentSign.php", { "stusno": stusno }, function (d) {
				if (d == '1') {
					alert('Sent Email to Student!!!');
					return false;
				}
				if (d == '2') {
					alert('Something went wrong. Please contact to Manager!!!');
					return false;
				}
				if (d == '3') {
					alert('Again Send Email to Student!!!');
					return false;
				}
			});
		} else {
			return false;
		}
	});
</script>

<script type="text/javascript">
	$(document).on('click', '.statusClassStuPmt', function () {
		var getVal = $(this).attr('data-id');
		var getVal2 = $(this).attr('data-name');
		var getVal3 = $(this).attr('data-passp');
		var getVal4 = $(this).attr('data-stid');
		var getVal5 = $(this).attr('data-refid');
		$('.getNameId').html(getVal2);
		$.post("../responseStart.php?tag=getStudyPermitLists", { "idno": getVal, "name": getVal2, "passp": getVal3, "stid": getVal4, "refid": getVal5 }, function (d) {
			$('.getStudyPermitLists').html("");
			$('' + d[0].getStudyPermitLists + '').appendTo(".getStudyPermitLists");

			$("#firsttab_requried").submit(function () {
				var submit = true;
				$(".is_require:visible").each(function () {
					if ($(this).val() == '') {
						$(this).addClass('error_color');
						submit = false;
					} else {
						$(this).addClass('validError');
					}
				});
				if (submit == true) {
					return true;
				} else {
					$('.is_require').keyup(function () {
						$(this).removeClass('error_color');
					});
					return false;
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).on('change', '.study_permit', function () {
		var getVal = $(this).val();
		if (getVal == 'Yes') {
			$('.studyPermitDiv').show();
		} else {
			$('.studyPermitDiv').hide();
		}
	});

	$(document).on('click', '.radioDivSI', function () {
		var getVal = $(this).val();
		var getVal2 = $(this).attr('data-id');
		var getVal3 = 'Study_Permit';
		$.post("../responseStart.php?tag=getSpifAppNot", { "status": getVal, "snoid": getVal2, "type": getVal3 }, function (d) {

		});
	});

	$(document).on('click', '.radioDivSI_2', function () {
		var getVal = $(this).val();
		var getVal2 = $(this).attr('data-id');
		var getVal3 = 'Inc_form';
		$.post("../responseStart.php?tag=getSpifAppNot", { "status": getVal, "snoid": getVal2, "type": getVal3 }, function (d) {

		});
	});

	// $(function(){
	// $(".datepickerDiv2").datepicker({
	// dateFormat: 'yy-mm-dd',
	// changeMonth: false,
	// changeYear: false,
	// });
	// });
</script>

<style type="text/css">
	.fixed-table-container th {
		width: 100px;
	}

	.fixed-table-container {
		overflow: scroll;
	}

	.fixed-table-container tr:first-child th {
		background: #333;
	}

	.name-id {
		text-transform: lowercase;
	}

	.name-id::first-letter {
		text-transform: capitalize;
	}

	/*.name-id::second-letter {text-transform: capitalize;}*/
	.table-bordered th,
	.table-bordered td {
		text-align: left !important
	}
</style>
<script>
	var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script>
<?php
include ("../../footer.php");
?>