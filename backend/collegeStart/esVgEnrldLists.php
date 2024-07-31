<?php
ob_start();
include("../../db.php");
header("Content-Type: application/vnd.ms-excel");

$role2 = $_POST['role'];

if(!empty($_POST['keywordLists'])){
	$getsearch2 = $_POST['keywordLists'];
	$keywordDiv = "AND (CONCAT(fname,  ' ', lname) LIKE '%".$getsearch2."%' OR refid LIKE '%".$getsearch2."%' OR passport_no LIKE '%".$getsearch2."%' OR student_id LIKE '%".$getsearch2."%')";
	
	$keywordDiv2 = "AND (CONCAT(st_application.fname,  ' ', st_application.lname) LIKE '%".$getsearch2."%' OR st_application.refid LIKE '%".$getsearch2."%' OR st_application.passport_no LIKE '%".$getsearch2."%' OR st_application.student_id LIKE '%".$getsearch2."%')";
}else{
	$keywordDiv = '';
	$keywordDiv2 = '';
}

if(!empty($_POST['intakeInput'])){
	$getIntake2 = $_POST['intakeInput'];
	$getIntake3 = "AND prg_intake='$getIntake2'";
	$getIntake4 = "AND st_application.prg_intake='$getIntake2'";
}else{
	$getIntake3 = '';
	$getIntake4 = '';
}

$slctQry_2 = "SELECT st_application.sno, st_application.user_id, st_application.fname, st_application.lname, st_application.refid, st_application.student_id, st_application.dob, st_application.passport_no, st_application.email_address, st_application.mobile, st_application.address1, st_application.prg_name1, st_application.prg_intake, st_application.country, start_college.with_dism, start_college.refund_rp, start_college.datetime_at, start_college.in_w_d, start_college.with_file, start_college.started_program, start_college.started_start_date, start_college.started_end_date, start_college.inp_program, start_college.inp_start_date, start_college.inp_end_date, start_college.followup_status, start_college.follow_date, start_college.rproccess, start_college.yesp_amount, start_college.remarks FROM `start_college` INNER JOIN st_application ON st_application.sno=start_college.app_id WHERE start_college.with_dism!='' AND (start_college.with_dism='Started' OR start_college.with_dism='Contract Signed') $keywordDiv2 $getIntake4 order by start_college.sno DESC";
	
$adHeading = "\t Inp.Program Name \t Inp.Actual Start Date \t Inp.Actual End Date";

$adHeading2 = "\t In/W/D \t Inprogress Status \t Refund Type \t Refund Processed \t Refund Amount \t Followup Status \t Followup Date \t Remarks \t Updated On \t Added By";


// echo $slctQry_2;
// die;
$checkQuery_2 = mysqli_query($con, $slctQry_2);

$firstname = str_replace(' ', '', $role2);
	
echo 'Agent Name' ."\t". 'Fullname' . "\t" .'Student Id'. "\t" .'Ref Id'. "\t" .'DOB' . "\t" .'Mobile Number'. "\t" .'Email Address'. "\t" .'Passport No.'. "\t" .'Country'. "\t" .'On/Off'. "\t" .'Program Name'. "\t" .'Program Start Date'. "\t" .'Program End Date'.$adHeading.''.$adHeading2."\n";

if(mysqli_num_rows($checkQuery_2)){

while ($row = mysqli_fetch_assoc($checkQuery_2)) {
		$snoid = mysqli_real_escape_string($con, $row['sno']);
		$user_id = mysqli_real_escape_string($con, $row['user_id']);	
		$fname = preg_replace('/\s+/', ' ',$row['fname']);			
		$lname = preg_replace('/\s+/', ' ',$row['lname']);	
		$fullname = $fname.' '.$lname;			
		$refid = preg_replace('/\s+/', ' ',$row['refid']);
		$student_id = preg_replace('/\s+/', ' ',$row['student_id']);
		$dob = mysqli_real_escape_string($con, $row['dob']);
		$mobile = mysqli_real_escape_string($con, $row['mobile']);
		$email_address = mysqli_real_escape_string($con, $row['email_address']);
		$passport_no = mysqli_real_escape_string($con, $row['passport_no']);
		$country = $row['country'];
		if($country == 'Canada'){
			$countryDiv = 'Onshore';
		}else{
			$countryDiv = 'Offshore';			
		}		
		
		$prg_name1 = preg_replace('/\s+/', ' ',$row['prg_name1']);
		$prg_intake = preg_replace('/\s+/', ' ',$row['prg_intake']);
		
		$queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
		$queryRslt4 = mysqli_query($con, $queryGet4);
		$rowSC4 = mysqli_fetch_assoc($queryRslt4);
		$start_date = $rowSC4['commenc_date'];
		$end_date = $rowSC4['expected_date'];
		
		$getquery22 = "SELECT username FROM `allusers` WHERE sno='$user_id'";		
		$RefundsWeeklyRslt22 = mysqli_query($con, $getquery22);
		$row_nm22 = mysqli_fetch_assoc($RefundsWeeklyRslt22);
		$username = mysqli_real_escape_string($con, $row_nm22['username']);
		
		if($role2 == 'Actual_Details'){
			$queryGet2 = "SELECT * FROM `start_college` WHERE act_pgname!='' AND app_id='$snoid'";
			$queryRslt2 = mysqli_query($con, $queryGet2);
			if(mysqli_num_rows($queryRslt2)){
				$rowSC = mysqli_fetch_assoc($queryRslt2);							
				$act_pgname2 = preg_replace('/\s+/', ' ',$rowSC['act_pgname2']);
				$act_start_date = $rowSC['act_start_date'];
				$act_end_date = $rowSC['act_end_date'];
				if(!empty($act_pgname2)){
					$act_pgname = $act_pgname2;
				}else{			
					$act_pgname = 'No Action';
				}		
				$datetime_at = $rowSC['act_datetime_at'];		
				$act_details_added_by = $rowSC['act_details_added_by'];
				$crsCompletion = "\t $act_pgname \t $act_start_date \t $act_end_date \t $datetime_at \t $act_details_added_by";
			}else{
				$crsCompletion = '';
			}
		}elseif($role2 == 'Dashboard_Std_Status'){
				$with_dism = $row['with_dism'];
				$in_w_d = $row['in_w_d'];					
				$remarks = preg_replace('/\s+/', ' ',$row['remarks']);
				$datetime_at = $row['datetime_at'];
				if(!empty($with_dism) && $with_dism == 'Started'){					
					$started_program = preg_replace('/\s+/', ' ',$row['started_program']);
					$started_start_date = $row['started_start_date'];
					$started_end_date = $row['started_end_date'];
					
					$refund_rp = '';
					$rproccess = '';
					$yesp_amount = '';
					$followup_status = '';
					$follow_date = '';
				}elseif(!empty($with_dism) && $with_dism == 'Graduate'){
					$started_program = preg_replace('/\s+/', ' ',$row['started_program']);
					$started_start_date = $row['inp_start_date'];	
					$started_end_date = $row['inp_end_date'];
					
					$refund_rp = '';
					$rproccess = '';
					$yesp_amount = '';
					$followup_status = '';
					$follow_date = '';
				}elseif(!empty($with_dism) && $with_dism == 'Dismissed'){
					$refund_rp = $row['refund_rp'];	
					$followup_status = $row['followup_status'];
					if($followup_status == 'Followup'){
						$follow_date = $row['follow_date'];			
					}else{
						$follow_date = '';			
					}			
					$rproccess = '';
					$yesp_amount = '';
					
					$started_program = '';
					$started_start_date = '';
					$started_end_date = '';
				}elseif(!empty($with_dism) && $with_dism == 'Withdrawal'){
					$refund_rp = $row['refund_rp'];	
					$rproccess = $row['rproccess'];
					if($rproccess == 'Yes'){
						$yesp_amount = $row['yesp_amount'];			
					}else{
						$yesp_amount = '';			
					}
					$followup_status = '';
					$follow_date = '';
					
					$started_program = '';
					$started_start_date = '';
					$started_end_date = '';
				}else{
					$started_program = '';
					$started_start_date = '';
					$started_end_date = '';
					
					$refund_rp = '';
					$rproccess = '';
					$yesp_amount = '';
					$followup_status = '';
					$follow_date = '';
				}
		
				$crsCompletion = "\t $with_dism \t $started_program \t $started_start_date \t $started_end_date \t $refund_rp \t $rproccess \t $yesp_amount \t $followup_status \t $follow_date \t $remarks \t $datetime_at \t $in_w_d";

		}elseif($role2 == 'Student_Status'){
			$queryGet2 = "SELECT * FROM `start_college` WHERE with_dism!='' AND app_id='$snoid'";
			$queryRslt2 = mysqli_query($con, $queryGet2);
			if(mysqli_num_rows($queryRslt2)){
				$row_nm = mysqli_fetch_assoc($queryRslt2);
				$with_dism = preg_replace('/\s+/', ' ',$row_nm['with_dism']);
				$in_w_d = $row_nm['in_w_d'];
				$remarks = preg_replace('/\s+/', ' ',$row_nm['remarks']);
				$datetime_at = $row_nm['datetime_at'];
				if(!empty($with_dism) && $with_dism == 'Started'){
					$started_program = preg_replace('/\s+/', ' ',$row_nm['started_program']);
					$started_start_date = $row_nm['started_start_date'];
					$started_end_date = $row_nm['started_end_date'];
					
					$refund_rp = '';
					$rproccess = '';
					$yesp_amount = '';
					$followup_status = '';
					$follow_date = '';
				}elseif(!empty($with_dism) && $with_dism == 'Graduate'){
					$started_program = preg_replace('/\s+/', ' ',$row_nm['started_program']);
					$started_start_date = $row_nm['inp_start_date'];	
					$started_end_date = $row_nm['inp_end_date'];
					
					$refund_rp = '';
					$rproccess = '';
					$yesp_amount = '';
					$followup_status = '';
					$follow_date = '';
				}elseif(!empty($with_dism) && $with_dism == 'Dismissed'){
					$refund_rp = $row_nm['refund_rp'];	
					$followup_status = $row_nm['followup_status'];
					if($followup_status == 'Followup'){
						$follow_date = $row_nm['follow_date'];			
					}else{
						$follow_date = '';			
					}			
					$rproccess = '';
					$yesp_amount = '';
					
					$started_program = '';
					$started_start_date = '';
					$started_end_date = '';
				}elseif(!empty($with_dism) && $with_dism == 'Withdrawal'){
					$refund_rp = $row_nm['refund_rp'];	
					$rproccess = $row_nm['rproccess'];
					if($rproccess == 'Yes'){
						$yesp_amount = $row_nm['yesp_amount'];			
					}else{
						$yesp_amount = '';			
					}
					$followup_status = '';
					$follow_date = '';
					
					$started_program = '';
					$started_start_date = '';
					$started_end_date = '';
				}else{
					$started_program = '';
					$started_start_date = '';
					$started_end_date = '';
					
					$refund_rp = '';
					$rproccess = '';
					$yesp_amount = '';
					$followup_status = '';
					$follow_date = '';
				}
			
		
				$crsCompletion = "\t $with_dism \t $started_program \t $started_start_date \t $started_end_date \t $refund_rp \t $rproccess \t $yesp_amount \t $followup_status \t $follow_date \t $remarks \t $datetime_at \t $in_w_d";
			}else{
				$crsCompletion = '';
			}
		}elseif($role2 == 'Start_Enrolled_Status'){
			$with_dism = $row['with_dism'];
			$in_w_d = $row['in_w_d'];					
			$remarks = preg_replace('/\s+/', ' ',$row['remarks']);
			$datetime_at = $row['datetime_at'];					
			$started_program = preg_replace('/\s+/', ' ',$row['started_program']);
			$started_start_date = $row['started_start_date'];
			$started_end_date = $row['started_end_date'];
			
			$refund_rp = '';
			$rproccess = '';
			$yesp_amount = '';
			$followup_status = '';
			$follow_date = '';
			
			$crsCompletion = "\t $started_program \t $started_start_date \t $started_end_date \t $remarks \t $datetime_at \t $in_w_d";
			
		}else{
			 $crsCompletion = '';
		}
	 
echo $username ."\t" . $fullname. "\t" . $student_id. "\t" . $refid. "\t" . $dob. "\t" . $mobile. "\t" . $email_address. "\t" . $passport_no. "\t" . $country. "\t" . $countryDiv. "\t" . $prg_name1. "\t" . $start_date. "\t" . $end_date .$crsCompletion. "\n";
}

}

header("Content-disposition: attachment; filename=".$firstname."_Lists.xls");
?>