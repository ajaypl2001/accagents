<?php
include("../../db.php");
header('Content-type: application/json');
date_default_timezone_set("Asia/Kolkata");

$created = date('Y-m-d H:i:s');
$timing_in = date('H:i:s');

$cnt_date = date("Y-m-d");	
$day_week = date("l");
$get_month = date('Y-m');

$getServerIp = $_SERVER['REMOTE_ADDR'];




if($_GET['tag'] == "empStatus"){
	$empid = $_POST['empid'];	
	$getst = $_POST['getst'];
	if($getst == '1'){
		$getst1 = '2';
	}
	if($getst == '2'){
		$getst1 = '1';
	}
	 $upquery = "update `allusers` set `verifystatus`='$getst1' where `sno`='$empid'";	
	mysqli_query($con, $upquery);
	
	echo '1';
}
if($_GET['tag'] == "checkpass") { 
	if(isset($_POST['crntpwd'])){
			$crntpwd=$_POST['crntpwd'];
			$user_id = $_POST['user_id'];
			$checkdata=" SELECT original_pass FROM allusers WHERE original_pass='$crntpwd' and sno='$user_id'";
			$query=mysqli_query($con, $checkdata);
			if(mysqli_num_rows($query)){
			  echo "1";
			  die;
			} else {
			  echo "0";
			  die;
			}
	}
}
if($_GET['tag'] == "changepass") { 
	
	if(isset($_POST['crntpwd'])){
		$crntpwd = $_POST['crntpwd'];
	} else {
		$crntpwd = '';
	}
	if(isset($_POST['newpwd'])){
		$newpwd = $_POST['newpwd'];
	} else {
		$newpwd = '';
	}
	if(isset($_POST['cnfmpwd'])){
		$cnfmpwd = $_POST['cnfmpwd'];
	} else {
		$cnfmpwd = '';
	}
	if(isset($_POST['sno'])){
		$sno = $_POST['sno'];
	} else {
		$sno = '';
	}
	if($crntpwd=='' || $newpwd =='' || $cnfmpwd==''){
		echo "5";
		die();
	}
	$checkdata=" SELECT original_pass FROM allusers WHERE original_pass='$crntpwd' and sno='$sno'";
	$query=mysqli_query($con, $checkdata);
	$macth_data = mysqli_num_rows($query);
	if($macth_data < 0) {
		echo "4";
		die();
	}
	$newpwd_count =  strlen($newpwd);
	if($newpwd_count < 6){
		echo "3";
		die();
	}
	if($newpwd != $cnfmpwd){
		echo "2";
		die();
	}
	$convert_pass = md5(sha1($newpwd));
	$update_pass = "update allusers SET original_pass='$newpwd', password='$convert_pass' where sno='$sno'";
	$update_data=mysqli_query($con, $update_pass);
	if($update_data=='TRUE'){
		echo "1";
		die();
	}
	
	
	
}
if($_GET['tag'] == "EditEmp"){
	
	
	$snoid = $_POST['snoid'];
	$username = $_POST['usernameInput'];
	$contact_person = $_POST['contact_personInput'];
	$agent_email = $_POST['agent_emailInput'];
	$mobile_no = $_POST['mobile_noInput'];
	$alternate_mobile = $_POST['alternate_mobileInput'];
	$city = $_POST['cityInput'];
	$address = $_POST['addressInput'];
	
	
	$created_datetime = date('Y-m-d H:i:s');
	$updated = "UPDATE `allusers` SET `contact_person`='$contact_person', `username`='$username', `agent_email`='$agent_email', `mobile_no`='$mobile_no', `alternate_mobile`='$alternate_mobile', `address`='$address', `city`='$city' WHERE `sno` = '$snoid'";
	mysqli_query($con, $updated);
	echo '1';
}

if($_GET['tag'] == "actchangepass") { 
	
	
	if(isset($_POST['newpwd'])){
		$newpwd = $_POST['newpwd'];
	} else {
		$newpwd = '';
	}
	if(isset($_POST['cnfmpwd'])){
		$cnfmpwd = $_POST['cnfmpwd'];
	} else {
		$cnfmpwd = '';
	}
	if(isset($_POST['sno'])){
		$sno = $_POST['sno'];
	} else {
		$sno = '';
	}
	if($newpwd =='' || $cnfmpwd==''){
		echo "5";
		die();
	}
	
	$newpwd_count =  strlen($newpwd);
	if($newpwd_count < 6){
		echo "3";
		die();
	}
	if($newpwd != $cnfmpwd){
		echo "2";
		die();
	}
	$convert_pass = md5(sha1($newpwd));
	$update_pass = "update allusers SET verifystatus='1',original_pass='$newpwd', password='$convert_pass' where sno='$sno'";
	$update_data=mysqli_query($con, $update_pass);
	if($update_data=='TRUE'){
		echo "1";
		die();
	}
	
	
	
}


?>