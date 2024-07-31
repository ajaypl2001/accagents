<?php
include ("../db.php");
header('Content-type: application/json');
date_default_timezone_set("America/Toronto");
$datetime_at = date('Y-m-d H:i:s');

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['sno']) && !empty($_SESSION['sno'])) {
	$sessionSno = $_SESSION['sno'];
	$qryA = "SELECT role, email, contact_person FROM allusers WHERE sno='$sessionSno'";
	$resultA = mysqli_query($con, $qryA);
	$rowA = mysqli_fetch_assoc($resultA);
	$adminrole1 = $rowA['role'];
	$Loggedemail = $rowA['email'];
	$Loggedcontact_person = $rowA['contact_person'];
} else {
	$sessionSno = '';
	$adminrole1 = '';
	$Loggedemail = '';
	$Loggedcontact_person = '';
}

if ($_GET['tag'] == "getStartLists") {
	$idno = $_POST['idno'];
	$name = $_POST['name'];
	$passp = $_POST['passp'];
	$stid = $_POST['stid'];
	$refid = $_POST['refid'];
	$getStatus = $_POST['getStatus'];
	$statusD = $_POST['statusD'];

	if ($statusD == 'Dismissed' || $statusD == 'Withdrawal') {
		$getVal = '<option value="Re-enrolled">Re-enrolled</option>';
	} else {
		if ($sessionSno == '4792' || $sessionSno == '4293') {
			$getVal = '<option value="Dismissed">Dismissed</option>';
		} elseif ($sessionSno == '3738' && $getStatus == 'Dismissed') {
			$getVal = '<option value="Withdrawal">Withdrawal</option>';
		} else {
			$getVal = '<option value="Started">Started</option>
			<option value="Not started">Not started</option>
			<option value="Deferred">Deferred</option>
			<option value="Withdrawal">Withdrawal</option>
			<option value="Dismissed">Dismissed</option>';
		}
	}

	$getStartLists = '<form action="" method="post" autocomplete="off" id="firsttab_requried" enctype="multipart/form-data">
			<div class="form-group">
			<label>Student Status:</label>
			<select name="with_dism" class="form-control wDisDiv is_require">
				<option value="">Select Option</option>
				<!--option value="Contract Signed">Contract Signed</option-->
				' . $getVal . '
				<!--option value="Graduate">Graduate</option-->
			</select>
			</div>
			<div class="form-group startedYesNo" style="display:none;">
			<label>Select Option:*</label>
			<select name="started_yesno" class="form-control yesnoStartAlert is_require">
				<option value="">Select Option</option>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
			</div>
			<div class="form-group newStartEndDate" style="display:none;">
			<label>New Start Date:*</label>
			<input type="text" name="selected_start_date" class="form-control datepickerDiv is_require">
			</div>
			<div class="form-group newStartEndDate" style="display:none;">
			<label>New End Date:*</label>
			<input type="text" name="selected_end_date" class="form-control datepickerDiv is_require">
			</div>
			<div class="form-group inpsDiv" style="display:none;">
			<label>Program Name:</label>
			<input type="text" name="inp_program" class="form-control">
			</div>			
			<div class="form-group inpsDiv" style="display:none;">
			<label>Start Date:</label>
			<input type="text" name="inp_start_date" class="form-control datepickerDiv">
			</div>
			<div class="form-group inpsDiv" style="display:none;">
			<label>End Date:</label>
			<input type="text" name="inp_end_date" class="form-control datepickerDiv">
			</div>
			
			<div class="form-group contractSgndDiv" style="display:none;">
			<label>Program Change:</label>
			<select name="program_change" class="form-control pcDiv is_require">
				<option value="">Select Option</option>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
			</div>
			
			<div class="form-group startedDiv" style="display:none;">
			<label>Program Name:</label>';
	$getStartLists .= '<select name="started_program" class="form-control">
				<option value="">Select Option</option>';
	$slctQry_6 = "SELECT sno, program_name FROM contract_courses group by program_name";
	$checkQuery_6 = mysqli_query($con, $slctQry_6);
	while ($rowSt_6 = mysqli_fetch_assoc($checkQuery_6)) {
		$program_name = $rowSt_6['program_name'];
		$getStartLists .= '<option value="' . $program_name . '">' . $program_name . '</option>';
	}
	$getStartLists .= '</select>
			</div>		
			<div class="form-group startedDiv" style="display:none;">
			<label>Start Date:</label>
			<input type="text" name="started_start_date" class="form-control datepickerDiv">
			</div>
			<div class="form-group startedDiv" style="display:none;">
			<label>End Date:</label>
			<input type="text" name="started_end_date" class="form-control datepickerDiv">
			</div>
			
			<div class="form-group rfndRPDiv" style="display:none;">
			<label>Refund Status:</label>
			<select name="refund_rp" class="form-control rfndRPList is_require">
				<option value="">Select Option</option>
				<option value="Refund Request">Refund Request</option>
				<option value="Student Refund Not Eligible">Student Refund Not Eligible</option>
				<option value="Refund Processed">Refund Processed</option>
			</select>
			</div>	
			
			<div class="form-group flupDiv" style="display:none;">
			<label>Followup Status:</label>
			<select name="followup_status" class="form-control fdDiv is_require">
				<option value="">Select Option</option>
				<option value="Followup">Followup</option>
				<option value="Done">Done</option>
			</select>
			</div>
			<div class="form-group flwpDateDiv" style="display:none;">
			<label>Followup Date:</label>
			<input type="text" name="follow_date" class="form-control datepickerDiv is_require">
			</div>
			
			<div class="form-group rfndPrDiv" style="display:none;">
			<label>Refund Processed Amount:</label>
			<select name="rproccess" class="form-control rproccessDiv is_require">
				<option value="">Select Option</option>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
			</div>
			
			<div class="form-group yespDiv" style="display:none;">
			<label>Enter Amount:</label>
			<input type="text" name="yesp_amount" class="form-control is_require">
			</div>
			
			<div class="form-group withFileDiv" style="display:none;">
			<label>Upload File:</label><br>
			<input type="file" name="with_file" class="form-control">
			</div>
			
			<!--div class="form-group sprDiv" style="display:none;">
			<label>Study Permit Received:</label>
			<select name="spr" class="form-control is_require">
				<option value="">Select Option</option>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
			</div-->
			
			<div class="form-group withdrawal_dateDiv" style="display:none;">
				<label>Select Date:</label>
				<input type="text" name="withdrawal_date" class="form-control datepickerDiv is_require">
			</div>
			<div class="form-group dismissal_dateDiv" style="display:none;">
				<label>Select Date:</label>
				<input type="text" name="dismissal_date" class="form-control datepickerDiv is_require">
			</div>
			
			<div class="form-group">
			<label>Remarks:</label>
			<textarea class="form-control is_require" name="remarks" placeholder="Enter Remarks"></textarea>
			</div>
			
			<div class="form-group">
			<input type="hidden" name="app_id" value="' . $idno . '">
			<input type="hidden" name="student_name" value="' . $name . '">
			<input type="hidden" name="passp" value="' . $passp . '">
			<input type="hidden" name="stid" value="' . $stid . '">
			<input type="hidden" name="refid" value="' . $refid . '">
			<button type="submit" name="submitbtn" class="btn btn-sm btn-success mt-2 float-right">Submit</button>
			</div>
		</form>';

	$res1[] = array(
		'getStartLists' => $getStartLists
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getAllLogs") {
	$idno = $_POST['idno'];

	$strp1 = "SELECT * FROM start_college_logs WHERE with_dism!='' AND app_id='$idno' order by sno desc";
	$resultp1 = mysqli_query($con, $strp1);
	$cnt = 1;
	while ($row = mysqli_fetch_array($resultp1)) {
		$cnt = $cnt++;
		$with_dism = $row['with_dism'];
		$refund_rp = $row['refund_rp'];
		$rproccess = $row['rproccess'];
		$yesp_amount = $row['yesp_amount'];
		$followup_status = $row['followup_status'];
		$follow_date = $row['follow_date'];
		$remarks = $row['remarks'];
		$datetime_at = $row['datetime_at'];
		$in_w_d = $row['in_w_d'];
		$program_change = $row['program_change'];

		if ($with_dism == 'Contract Signed') {
			if ($program_change == 'Yes') {
				$inp_program2 = $row['inp_program'];
				if (!empty($inp_program2)) {
					$inp_program = $inp_program2;
				} else {
					$inp_program = 'N/A';
				}
				$inp_start_date = $row['inp_start_date'];
				$inp_end_date = $row['inp_end_date'];
			} else {
				$inp_program = 'N/A';
				$inp_start_date = '';
				$inp_end_date = '';
			}

		} elseif ($with_dism == 'Inprogress') {
			$inp_program2 = $row['inp_program'];
			if (!empty($inp_program2)) {
				$inp_program = $inp_program2;
			} else {
				$inp_program = 'N/A';
			}
			$inp_start_date = $row['inp_start_date'];
			$inp_end_date = $row['inp_end_date'];
		} else {
			$inp_program = 'N/A';
			$inp_start_date = '';
			$inp_end_date = '';
		}


		$inpSt = 'Program: ' . $inp_program . '<br>Start Date: ' . $inp_start_date . '<br>End Date: ' . $inp_end_date;

		$res1[] = array(
			'idLogs' => $cnt++,
			'inpStLogs' => $inpSt,
			'with_dismLogs' => $with_dism,
			'refund_rpLogs' => $refund_rp,
			'rproccessLogs' => $rproccess,
			'yesp_amountLogs' => $yesp_amount,
			'followup_statusLogs' => $followup_status,
			'follow_dateLogs' => $follow_date,
			'remarksLogs' => $remarks,
			'updateLogs' => $datetime_at,
			'in_w_dLogs' => $in_w_d
		);
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getActualLists") {
	$idno = $_POST['idno'];
	$name = $_POST['name'];
	$passp = $_POST['passp'];
	$stid = $_POST['stid'];
	$refid = $_POST['refid'];

	$getStartLists = '<form method="post" autocomplete="off" id="firsttab_requried">
			<div class="form-group">
			<label>Program Name:</label>
			<input type="text" name="act_pgname" class="form-control is_require">
			</div>
			<div class="form-group">
			<label>Actual Start Date:</label>
			<input type="text" name="act_start_date" class="form-control datepickerDiv is_require">
			</div>
			<div class="form-group">
			<label>Actual End Date:</label>
			<input type="text" name="act_end_date" class="form-control datepickerDiv is_require">
			</div>
			
			<div class="form-group">
			<label>Remarks:</label>
			<textarea class="form-control is_require" name="act_remarks" placeholder="Enter Remarks"></textarea>
			</div>
			<div class="form-group">
			<input type="hidden" name="app_id" value="' . $idno . '">
			<input type="hidden" name="student_name" value="' . $name . '">
			<input type="hidden" name="passp" value="' . $passp . '">
			<input type="hidden" name="stid" value="' . $stid . '">
			<input type="hidden" name="refid" value="' . $refid . '">
			<button type="submit" name="submitbtn" class="btn btn-sm btn-success mt-2 float-right">Submit</button>
			</div>
		</form>';

	$res1[] = array(
		'getStartLists' => $getStartLists
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getActualLogs") {
	$idno = $_POST['idno'];

	$strp1 = "SELECT * FROM start_college_logs WHERE act_start_date!='' AND app_id='$idno' order by sno desc";
	$resultp1 = mysqli_query($con, $strp1);
	$cnt = 1;
	while ($row = mysqli_fetch_array($resultp1)) {
		$cnt = $cnt++;
		$act_pgname = $row['act_pgname'];
		$act_start_date = $row['act_start_date'];
		$act_end_date = $row['act_end_date'];
		$act_remarks = $row['act_remarks'];
		$datetime_at = $row['act_datetime_at'];
		$act_details_added_by = $row['act_details_added_by'];

		$res1[] = array(
			'idLogs' => $cnt++,
			'act_pgname' => $act_pgname,
			'act_start_date' => $act_start_date,
			'act_end_date' => $act_end_date,
			'act_remarks' => $act_remarks,
			'datetime_at' => $datetime_at,
			'act_details_added_by' => $act_details_added_by
		);
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "changeNameSt") {
	$idno = $_POST['idno'];

	$slctQry_2 = "SELECT sno, mobile, email_address, address1 FROM both_main_table where sno='$idno'";
	$checkQuery_2 = mysqli_query($con, $slctQry_2);
	$rowStartValue = mysqli_fetch_assoc($checkQuery_2);
	$mobile = $rowStartValue['mobile'];
	$email_address = $rowStartValue['email_address'];
	$address1 = $rowStartValue['address1'];

	$editNameChange = '<form method="post" autocomplete="off" id="firsttab_requried">
		<div class="form-group">
		<label>Mobile No.:*</label>
		<input type="text" name="mobile" class="form-control" placeholder="Enter Mobile No." value="' . $mobile . '" required>
		</div>
		<div class="form-group">
		<label>Email Address:*</label>
		<input type="text" name="email_address" class="form-control" placeholder="Enter Email Address" value="' . $email_address . '" required>
		</div>
		<div class="form-group">
		<label>Address:*</label>
		<input type="text" name="address1" class="form-control" placeholder="Enter  Address" value="' . $address1 . '" required>
		</div>
		<div class="form-group">
		<input type="hidden" name="app_id" value="' . $idno . '">
		<input type="hidden" name="old_mobile" value="' . $mobile . '">
		<input type="hidden" name="old_email_address" value="' . $email_address . '">
		<input type="hidden" name="old_address1" value="' . $address1 . '">
		<input type="hidden" name="updated_by_name" value="' . $Loggedcontact_person . '">
		<button type="submit" name="stNameSbtBtn" class="btn btn-sm btn-success mt-2 float-right">Update</button>
		</div>
	</form>
	<div class="table-responsive">
	<table class="table table-bordered table-sm table-striped table-hover mt-3">
	<thead>
	<tr>
		<th>Sno.</th>
		<th>Old Mobile</th>
		<th>Old Email ID</th>
		<th>Old Address</th>
		<th>New Mobile</th>
		<th>New Email ID</th>
		<th>New Address</th>
		<th>Updated On</th>
		<th>Updated By</th>
	</tr>
	</thead>
	<tbody>';
	$strp1 = "SELECT * FROM student_details_update WHERE app_id='$idno' AND role='IN' order by sno desc";
	$resultp1 = mysqli_query($con, $strp1);
	$cnt = 1;
	if (mysqli_num_rows($resultp1)) {
		while ($row = mysqli_fetch_array($resultp1)) {
			$cnt = $cnt++;
			$old_mobile = $row['old_mobile'];
			$old_email_address = $row['old_email_address'];
			$old_address1 = $row['old_address1'];
			$mobile = $row['mobile'];
			$email_address = $row['email_address'];
			$address1 = $row['address1'];
			$updated_by_name = $row['updated_by_name'];
			$updated_datetime = $row['updated_datetime'];

			$editNameChange .= '<tr>
			<td>' . $cnt++ . '</td>
			<td>' . $old_mobile . '</td>
			<td>' . $old_email_address . '</td>
			<td>' . $old_address1 . '</td>
			<td>' . $mobile . '</td>
			<td>' . $email_address . '</td>
			<td>' . $address1 . '</td>
			<td>' . $updated_by_name . '</td>
			<td>' . $updated_datetime . '</td>
		</tr>';
		}
	} else {
		$editNameChange .= '<tr><td colspan="9"><center>Not Found!!!</center></td></tr>';
	}
	$editNameChange .= '</tbody>
	</table>
    </div></div></div>';

	$res1[] = array(
		'editNameChange' => $editNameChange
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getSIFLogs") {
	$idno = $_POST['idno'];

	$strp1 = "SELECT * FROM study_insurance_form WHERE app_id='$idno' order by sno desc";
	$resultp1 = mysqli_query($con, $strp1);
	$cnt = 1;
	while ($row = mysqli_fetch_array($resultp1)) {
		$cnt = $cnt++;
		$fullname = $row['fullname'];
		$email_address = $row['email_address'];
		$program = $row['program'];
		$study_file = $row['study_file'];
		if (!empty($study_file)) {
			$study_file2 = '<a href="localhost/studyInsuranceForm/uploads/' . $study_file . '" download>Download</a>';
		} else {
			$study_file2 = 'N/A';
		}
		$insurance = $row['insurance'];
		if (!empty($insurance)) {
			$insurance2 = '<a href="localhost/studyInsuranceForm/uploads/' . $insurance . '" download>Download</a>';
		} else {
			$insurance2 = 'N/A';
		}

		$res1[] = array(
			'idLogs' => $cnt++,
			'fullnameLogs' => $fullname,
			'email_addressLogs' => $email_address,
			'programLogs' => $program,
			'study_fileLogs' => $study_file2,
			'insuranceLogs' => $insurance2
		);
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getAttendLists") {
	$idno = $_POST['idno'];
	$name = $_POST['name'];

	$getAttendLists = '<form action="" method="post" autocomplete="off" id="firsttab_requried" enctype="multipart/form-data">
		<div class="form-group">
		<label>Student Status:</label>
		<select name="warning_letter" class="form-control is_require">
			<option value="">Select Option</option>
			<option value="1st_warning_letter">1st warning letter</option>
			<option value="2nd_warning_letter">2nd warning letter</option>
			<option value="Confirmation_of_Dismissal">Confirmation of Dismissal</option>
			<option value="Confirmation_of_Enrollment">Confirmation of Enrollment</option>
			<option value="Confirmation_of_Withdrawal">Confirmation of Withdrawal</option>
			<option value="Letter_of_Completion">Letter of Completion</option>			
			<option value="Student_Dismissal_Letter">Student Dismissal Letter</option>			
			<!--option value="3rd_warning_letter">3rd and FINAL warning letter</option>
			<option value="Notice_of_dismissal">Notice of dismissal</option>
			<option value="Cancelled_Letter">Cancelled Letter</option-->
		</select>
		</div>
		
		<div class="form-group">
		<label>Remarks:</label>
		<textarea class="form-control is_require" name="remarks" placeholder="Enter Remarks"></textarea>
		</div>
		<div class="form-group">
		<input type="hidden" name="app_id" value="' . $idno . '">
		<button type="submit" name="submitbtn" class="btn btn-sm btn-success mt-2 float-right">Submit</button>
		</div>
	</form>';

	$res1[] = array(
		'getAttendLists' => $getAttendLists
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getWLLogs") {
	$idno = $_POST['idno'];

	$strp1 = "SELECT * FROM start_college_attendance WHERE app_id='$idno' order by update_datetime desc";
	$resultp1 = mysqli_query($con, $strp1);
	$cnt = 1;
	while ($row = mysqli_fetch_array($resultp1)) {
		$cnt = $cnt++;
		$warning_letter = $row['warning_letter'];
		$remarks = $row['remarks'];
		$update_datetime = $row['update_datetime'];
		$updated_by_name = $row['updated_by_name'];

		if ($warning_letter == '1st_warning_letter' || $warning_letter == '2nd_warning_letter' || $warning_letter == '3rd_warning_letter') {
			$warning_letterFile = '<a href="localhost/agents/backend/clgAttendance/' . $warning_letter . '.php?snoid=' . $idno . '"><b>Download for ' . $warning_letter . '</b></a>';
		} elseif ($warning_letter == 'Notice_of_dismissal') {
			$warning_letterFile = '<a href="localhost/agents/backend/clgAttendance/Notice_of_dismissal.php?snoid=' . $idno . '"><b>Download for Notice of dismissal</b></a>';
		} elseif ($warning_letter == 'Confirmation_of_Dismissal') {
			$warning_letterFile = '<a href="localhost/agents/backend/clgAttendance/Confirmation_of_Dismissal.php?snoid=' . $idno . '"><b>Download for Confirmation of Dismissal</b></a>';
		} elseif ($warning_letter == 'Confirmation_of_Enrollment') {
			$warning_letterFile = '<a href="localhost/agents/backend/clgAttendance/Confirmation_of_Enrollment.php?snoid=' . $idno . '"><b>Download for Confirmation of Enrollment</b></a>';
		} elseif ($warning_letter == 'Confirmation_of_Withdrawal') {
			$warning_letterFile = '<a href="localhost/agents/backend/clgAttendance/Confirmation_of_Withdrawal.php?snoid=' . $idno . '"><b>Download for Confirmation of Withdrawal</b></a>';
		} elseif ($warning_letter == 'Letter_of_Completion') {
			$warning_letterFile = '<a href="localhost/agents/backend/clgAttendance/Letter_of_Completion.php?snoid=' . $idno . '"><b>Download for Letter of Completion</b></a>';
		} elseif ($warning_letter == 'Student_Dismissal_Letter') {
			$warning_letterFile = '<a href="localhost/agents/backend/clgAttendance/Student_Dismissal_Letter.php?snoid=' . $idno . '"><b>Download for Student Dismissal Letter</b></a>';
		} else {
			$warning_letterFile = '';
		}

		$res1[] = array(
			'idLogs' => $cnt++,
			'warning_letter' => $warning_letter,
			'warning_letterFile' => $warning_letterFile,
			'remarks' => $remarks,
			'update_datetime' => $update_datetime,
			'updated_by_name' => $updated_by_name
		);
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getStudyPermitLists") {
	$idno = $_POST['idno'];
	$name = $_POST['name'];
	$passp = $_POST['passp'];
	$stid = $_POST['stid'];
	$refid = $_POST['refid'];

	$rsltQuery = "SELECT * FROM `international_airport_student` WHERE app_id='$idno'";
	$qurySql = mysqli_query($con, $rsltQuery);
	if (mysqli_num_rows($qurySql)) {
		$row_nm = mysqli_fetch_assoc($qurySql);
		$study_file = $row_nm['study_permit'];
		$insurance = $row_nm['insurance'];
		$st_pmt_status = $row_nm['st_pmt_status'];
		$incform_status = $row_nm['incform_status'];

		if (!empty($study_file)) {
			$study_file2 = '<a href="localhost/accagents/international/uploads/' . $study_file . '" download>Download</a>';
		} else {
			$study_file2 = '';
		}
		if (!empty($insurance)) {
			$insurance2 = '<a href="localhost/accagents/international/uploads/' . $insurance . '" download>Download</a>';
		} else {
			$insurance2 = '';
		}
		if ($st_pmt_status == 'Approved') {
			$st_pmt_statusDiv = 'checked';
		} else {
			$st_pmt_statusDiv = '';
		}
		if ($st_pmt_status == 'Not-Approved') {
			$st_pmt_statusDiv2 = 'checked';
		} else {
			$st_pmt_statusDiv2 = '';
		}
		if ($incform_status == 'Approved') {
			$incform_statusDiv = 'checked';
		} else {
			$incform_statusDiv = '';
		}
		if ($incform_status == 'Not-Approved') {
			$incform_statusDiv2 = 'checked';
		} else {
			$incform_statusDiv2 = '';
		}
	} else {
		$study_file2 = '';
		$insurance2 = '';
		$st_pmt_statusDiv = '';
		$st_pmt_statusDiv2 = '';
		$incform_statusDiv = '';
		$incform_statusDiv2 = '';
	}

	$getStudyPermitLists = '<div class="table-responsive">
	<table class="table table-bordered table-sm table-striped table-hover mt-3">';
	if (!empty($study_file2)) {
		$getStudyPermitLists .= '<tr>
			<th>Study Permit</th>
			<td>' . $study_file2 . '</td>
			<td>
				<label class="radio-inline">
					<input type="radio" name="st_pmt_status" class="radioDivSI StuPmtDiv" value="Approved" data-id="' . $idno . '" ' . $st_pmt_statusDiv . '>Approved
				</label>
				<label class="radio-inline">
					<input type="radio" name="st_pmt_status" class="radioDivSI StuPmtDiv"  value="Not-Approved" data-id="' . $idno . '" ' . $st_pmt_statusDiv2 . '>Not-Approved
				</label>
			</td>
		</tr>';
	}
	if (!empty($insurance2)) {
		$getStudyPermitLists .= '<tr>
			<th>Insurance Form</th>
			<td>' . $insurance2 . '</td>
			<td>
				<label class="radio-inline">
					<input type="radio" name="incform_status" class="radioDivSI_2 StuPmtDiv" value="Approved" data-id="' . $idno . '" ' . $incform_statusDiv . '>Approved
				</label>
				<label class="radio-inline">
					<input type="radio" name="incform_status" class="radioDivSI_2 StuPmtDiv" value="Not-Approved" data-id="' . $idno . '" ' . $incform_statusDiv2 . '>Not-Approved
				</label>
			</td>
		</tr>';
	}
	$getStudyPermitLists .= '</table>
	</div>';

	$getStudyPermitLists .= '<form action="" method="post" autocomplete="off" id="firsttab_requried" enctype="multipart/form-data">
	<p><b style="text-decoration: underline;">If you want to upload Document-</b></p>
			<div class="form-group">
			<label>Do you have Study Permit?:</label>
			<select name="study_permit" class="form-control study_permit StuPmtDiv is_require">
				<option value="">Select Option</option>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
			</div>
			
			<div class="form-group studyPermitDiv" style="display:none;">
			<label>Upload Study Permit File:<span style="color:red;">*</span></label><br>
			<input type="file" name="study_permit_file" class="form-control is_require">
			</div>
			<div class="form-group studyPermitDiv" style="display:none;">
			<label>Upload Insurance Form File:<span style="color:red;">*</span></label><br>
			<input type="file" name="insurance" class="form-control is_require">
			</div>
			<div class="form-group">
			<input type="hidden" name="app_id" value="' . $idno . '">
			<input type="hidden" name="student_name" value="' . $name . '">
			<input type="hidden" name="passp" value="' . $passp . '">
			<input type="hidden" name="stid" value="' . $stid . '">
			<input type="hidden" name="refid" value="' . $refid . '">
			<button type="submit" name="submitbtnStuPmt" class="btn btn-sm btn-success mt-2 float-right activeBtnDiv" style="display:none;">Submit</button>
			</div>
		</form>';

	$res1[] = array(
		'getStudyPermitLists' => $getStudyPermitLists
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getSpifAppNot") {
	$type = $_POST['type'];
	$status = $_POST['status'];
	$snoid = $_POST['snoid'];
	if ($type == 'Study_Permit') {
		$getQry = "UPDATE `international_airport_student` SET `st_pmt_status`='$status' WHERE `app_id`='$snoid'";
		mysqli_query($con, $getQry);
		if ($status == 'Approved') {
			$mainTableQry = "UPDATE `both_main_table` SET `study_permit`='Yes' WHERE `sno`='$snoid'";
			mysqli_query($con, $mainTableQry);
		} else {
			$mainTableQry = "UPDATE `both_main_table` SET `study_permit`='No' WHERE `sno`='$snoid'";
			mysqli_query($con, $mainTableQry);
		}
	}
	if ($type == 'Inc_form') {
		$getQry = "UPDATE `international_airport_student` SET `incform_status`='$status' WHERE `app_id`='$snoid'";
		mysqli_query($con, $getQry);
	}
	echo '1';
	exit;
}

if ($_GET['tag'] == "changeNameStNew") {
	$idno = $_POST['idno'];

	$slctQry_2 = "SELECT * FROM international_airport_student where app_id='$idno'";
	$checkQuery_2 = mysqli_query($con, $slctQry_2);
	$rowStartValue = mysqli_fetch_assoc($checkQuery_2);
	$mobile = $rowStartValue['can_contact_no'];
	$email_address = $rowStartValue['email_address'];
	$address1 = $rowStartValue['can_address'];

	$editNameChangeNew = '<form method="post" autocomplete="off" id="firsttab_requried">
		<div class="form-group">
		<label>Canadian Contact No.:*</label>
		<input type="text" name="can_contact_no" class="form-control" placeholder="Enter Mobile No." value="' . $mobile . '" required>
		</div>
		<div class="form-group">
		<label>Email Address:*</label>
		<input type="text" name="email_address" class="form-control" placeholder="Enter Email Address" value="' . $email_address . '" required>
		</div>
		<div class="form-group">
		<label>Canadian Address:*</label>
		<input type="text" name="can_address" class="form-control" placeholder="Enter  Address" value="' . $address1 . '" required>
		</div>
		<div class="form-group">
		<input type="hidden" name="app_id" value="' . $idno . '">
		<button type="submit" name="stNameSbtBtn_44" class="btn btn-sm btn-success mt-2 float-right">Update</button>
		</div>
	</form>
	';

	$res1[] = array(
		'editNameChangeNew' => $editNameChangeNew
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getFinancialLists") {
	$idno = $_POST['idno'];
	$name = $_POST['name'];
	$start_date = $_POST['start_date'];

	$getFnclLists = '<form action="" method="post" autocomplete="off" id="firsttab_requried" enctype="multipart/form-data">
		<div class="form-group">
		<label>Student Status:<span style="color:red;">*</span></label>
		<select name="f_w_letter" class="form-control is_require f_w_letter">
			<option value="">Select Option</option>
			<option value="1st_warning_letter">1st warning letter</option>
			<option value="2nd_warning_letter">2nd warning letter</option>			
			<option value="Dismissal_Letter">Dismissal Letter</option>
		</select>
		</div>		
		<div class="form-group duesDate" style="display:none;">
		<label>Date:<span style="color:red;">*</span></label>
		<input type="text" name="dues_date" class="form-control datepickerDiv is_require" placeholder="Select Date">
		</div>		
		<div class="form-group">
		<label>Amount(CAD):<span style="color:red;">*</span></label>
		<input type="number" name="amount" class="form-control is_require" placeholder="Enter Amount">
		</div>		
		<div class="form-group">
		<label>Remarks:</label>
		<textarea class="form-control" name="remarks" placeholder="Enter Remarks"></textarea>
		</div>
		<div class="form-group">
		<input type="hidden" name="app_id" value="' . $idno . '">
		<input type="hidden" name="start_date" value="' . $start_date . '">
		<button type="submit" name="submitbtn" class="btn btn-sm btn-success mt-2 float-right">Submit</button>
		</div>
	</form>';

	$res1[] = array(
		'getFnclLists' => $getFnclLists
	);

	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}

if ($_GET['tag'] == "getFLLogs") {
	$idno = $_POST['idno'];

	$strp1 = "SELECT * FROM start_college_financial WHERE app_id='$idno' order by update_datetime desc";
	$resultp1 = mysqli_query($con, $strp1);
	$cnt = 1;
	while ($row = mysqli_fetch_array($resultp1)) {
		$cnt = $cnt++;
		$warning_letter = $row['f_w_letter'];
		$amount = $row['amount'];
		$remarks = $row['remarks'];
		$update_datetime = $row['update_datetime'];
		$updated_by_name = $row['updated_by_name'];
		$dues_date = $row['dues_date'];

		if ($warning_letter == '1st_warning_letter') {
			$warning_letterFile = '<a href="localhost/accagents/agents/backend/financialClg/1st_warning_letter.php?snoid=' . $idno . '"><b>Download for Financial 1st warning letter</b></a>';
		} elseif ($warning_letter == '2nd_warning_letter') {
			$warning_letterFile = '<a href="localhost/accagents/agents/backend/financialClg/2nd_warning_letter.php?snoid=' . $idno . '"><b>Download for Financial 2nd warning letter</b></a>';
		} elseif ($warning_letter == 'Dismissal_Letter') {
			$warning_letterFile = '<a href="localhost/accagents/agents/backend/financialClg/Dismissal_Letter.php?snoid=' . $idno . '"><b>Download for Financial Dismissal letter</b></a>';
		} else {
			$warning_letterFile = '';
		}

		$res1[] = array(
			'idLogs' => $cnt++,
			'warning_letter' => $warning_letter,
			'amount' => $amount,
			'warning_letterFile' => $warning_letterFile,
			'remarks' => $remarks,
			'dues_date' => $dues_date,
			'update_datetime' => $update_datetime,
			'updated_by_name' => $updated_by_name
		);
	}
	$list = isset($res1) ? $res1 : '';
	echo json_encode($list);
}
?>