<?php
ob_start();
include("../../db.php");
header("Content-Type: application/vnd.ms-excel");

$role2 = $_POST['tabName'];
$firstname = str_replace(' ', '', $role2);

if(!empty($_POST['intakeInput'])){
	$getIntake2 = $_POST['intakeInput'];
	$getIntake3 = "AND prg_intake='$getIntake2'";
	$getIntake4 = "AND st_application.prg_intake='$getIntake2'";
}else{
	$getIntake3 = '';
	$getIntake4 = '';
}

if($role2 == 'Student'){
	$slctQry_2 = "SELECT * FROM st_application where loa_file!='' AND loa_file_status='1' $getIntake3 order by sno desc";
	$checkQuery_2 = mysqli_query($con, $slctQry_2);
	echo 'Student ID Number'. "\t" .'PEN'. "\t" .'First Name'. "\t" .'Last Name'. "\t" .'Birth Date'. "\t" .'Gender'. "\t" .'Country Birth'. "\t" .'Citizenship Code'. "\t" .'Permanent Address Line 1'. "\t" .'Permanent Address Line 2'. "\t" .'City'. "\t" .'Province / State'. "\t" .'Country'. "\t" .'Postal Code'. "\t" .'Contact No'. "\t" .'Emergency Contact No'. "\t" .'Email address'."\n";

	if(mysqli_num_rows($checkQuery_2)){
	while ($row_1 = mysqli_fetch_assoc($checkQuery_2)) {
			$student_id = preg_replace('/\s+/', ' ',$row_1['student_id']);
			$pen = '';
			$fname = preg_replace('/\s+/', ' ',$row_1['fname']);			
			$lname = preg_replace('/\s+/', ' ',$row_1['lname']);
			$dob = $row_1['dob'];
			$gender = $row_1['gender'];
			$cntry_brth = preg_replace('/\s+/', ' ',$row_1['cntry_brth']);		
			$country = preg_replace('/\s+/', ' ',$row_1['country']);		
			$address1 = preg_replace('/\s+/', ' ',$row_1['address1']);
			$address2 = preg_replace('/\s+/', ' ',$row_1['address2']);
			$city = preg_replace('/\s+/', ' ',$row_1['city']);
			$state = preg_replace('/\s+/', ' ',$row_1['state']);
			$pincode = preg_replace('/\s+/', ' ',$row_1['pincode']);
			$mobile = preg_replace('/\s+/', ' ',$row_1['mobile']);
			$emergency_contact_no = preg_replace('/\s+/', ' ',$row_1['emergency_contact_no']);
			$email_address = preg_replace('/\s+/', ' ',$row_1['email_address']);
			
			$slctQry_3 = "SELECT countries_iso_code FROM `countries` where countries_name='$cntry_brth'";
			$checkQuery_3 = mysqli_query($con, $slctQry_3);
			if(mysqli_num_rows($checkQuery_3)){
				$row3 = mysqli_fetch_assoc($checkQuery_3);			
				$countries_iso_code = $row3['countries_iso_code'];
			}else{
				$countries_iso_code = '';				
			}
		 
		echo $student_id ."\t" . $pen. "\t" . $fname. "\t" . $lname. "\t" . $dob. "\t" . $gender. "\t" . $cntry_brth. "\t" . $countries_iso_code. "\t" . $address1. "\t" . $address2. "\t" . $city. "\t" . $state. "\t" . $country. "\t" . $pincode. "\t" . $mobile. "\t" . $emergency_contact_no. "\t" . $email_address. "\n";
		}
	}	
}

if($role2 == 'Enrollment'){	
	$slctQry_2 = "SELECT sno, fname, lname, student_id, prg_name1, prg_intake FROM st_application where loa_file!='' AND loa_file_status='1' $getIntake3 order by sno desc";
	$checkQuery_2 = mysqli_query($con, $slctQry_2);
	
	echo 'Program Location & Title'. "\t" .'Student ID Number'. "\t" .'Student Name'. "\t" .'Domestic_International'. "\t" .'Student Start Date'. "\t" .'Student End Date'. "\t" .'y6'."\n";

	if(mysqli_num_rows($checkQuery_2)){
	while ($row3 = mysqli_fetch_assoc($checkQuery_2)) {			
			$snoid = $row3['sno'];			
			$prg_name1 = preg_replace('/\s+/', ' ',$row3['prg_name1']);			
			$prgmLT = 'Granville College - Vancouver - 725-570 Dunsmuir Street[ID-00181L0001]::'.$prg_name1;			
			$student_id = preg_replace('/\s+/', ' ',$row3['student_id']);
			$fname = preg_replace('/\s+/', ' ',$row3['fname']);			
			$lname = preg_replace('/\s+/', ' ',$row3['lname']);
			$fullname = $fname.' '.$lname;
			$di = 'N/A';
			$prg_intake = preg_replace('/\s+/', ' ',$row3['prg_intake']);
			
			$slctQry_6 = "SELECT commenc_date, expected_date FROM `contract_courses` where intake='$prg_intake' AND program_name='$prg_name1'";
			$checkQuery_6 = mysqli_query($con, $slctQry_6);
			$row6 = mysqli_fetch_assoc($checkQuery_6);
			$commenc_date6 = $row6['commenc_date'];
			$expected_date6 = $row6['expected_date'];
			
			$slctQry_4 = "SELECT with_dism FROM `start_college` where with_dism!='' AND app_id='$snoid'";
			$checkQuery_4 = mysqli_query($con, $slctQry_4);
			if(mysqli_num_rows($checkQuery_4)){
				$row4 = mysqli_fetch_assoc($checkQuery_4);
				$with_dism = $row4['with_dism'];
			}else{
				$with_dism = 'N/A';
			}
		 
		echo $prgmLT ."\t" . $student_id. "\t" . $fullname. "\t" . $di. "\t" . $commenc_date6. "\t" . $expected_date6. "\t" . $with_dism. "\n";
		}
	}
	
}

header("Content-disposition: attachment; filename=".$firstname."_Lists.xls");
?>