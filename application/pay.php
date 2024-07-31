<?php
include("../db.php");
date_default_timezone_set("Asia/Kolkata");

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
	$stsmsg = base64_encode('Paymentmsg');
	header("Location: ../application?msg=$stsmsg");
}

if(isset($_POST['tfpaybtn'])){
	$tfname = $_POST['tfname'];
	$tftype = $_POST['tftype'];
	$total = $_POST['tfamnt'];
	$tfsid = $_POST['tfsid'];
	$fee_type = 'Tuition Fee';
	$exp_crsname = explode(",", $tfname);
	$exp_crstype = explode(",", $tftype);
	$created = date('Y-m-d H:i:s');
	$status = 'Pending';
	
	if(isset($exp_crsname[0])){
		mysqli_query($con, "INSERT INTO `payments` (`sid`, `course_name`, `course_type`, `fee_type`, `amount`, `status`, `created`) VALUES('$tfsid', '$exp_crsname[0]', '$exp_crstype[0]', '$fee_type', '$total', '$status', '$created')");
	}
	$stsmsg = base64_encode('Paymentmsg');
	header("Location: ../application?msg=$stsmsg");
}










?>


