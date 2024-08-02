<?php
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// die;

if(isset($_POST['paymentbtn'])){
	$crsname = $_POST['crsname'];
	$crstype = $_POST['crstype'];
	// $atc = $_POST['atc'];
	$total = $_POST['amount'];
	$stuid = $_POST['stuid'];
	$fee_type = 'Application Fee';
	$exp_crsname = explode(",", $crsname);
	$exp_crstype = explode(",", $crstype);
	$created = date('Y-m-d H:i:s');
	$status = 'Pending';
	
	if(isset($exp_crsname[0])){
		mysqli_query($con, "INSERT INTO `payments` (`sid`, `course_name`, `course_type`, `fee_type`, `amount`, `status`, `created`) VALUES('$stuid', '$exp_crsname[0]', '$exp_crstype[0]', '$fee_type', '$total', '$status', '$created')");
	}
	if(isset($exp_crsname[1])){
		mysqli_query($con, "INSERT INTO `payments` (`sid`, `course_name`, `course_type`, `fee_type`, `amount`, `status`, `created`) VALUES('$stuid', '$exp_crsname[1]', '$exp_crstype[1]', '$fee_type', '$total', '$status', '$created')");
	}
	if(isset($exp_crsname[2])){
		mysqli_query($con, "INSERT INTO `payments` (`sid`, `course_name`, `course_type`, `fee_type`, `amount`, `status`, `created`) VALUES('$stuid', '$exp_crsname[2]', '$exp_crstype[2]', '$fee_type', '$total', '$status', '$created')");
	}
	header("Location: ../../backend/application");
}











?>


