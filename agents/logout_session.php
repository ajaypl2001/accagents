<?php
ob_start();
if(!isset($_SESSION)){
	 session_start();
}
include("db.php");
if(!empty($_SESSION['sno']) || !empty($_SESSION['email']) || !empty($_SESSION['password'])){

$session_logs = $_SESSION['sno'];
$results_session = mysqli_query($con,"SELECT sno, role, email, password FROM allusers WHERE verifystatus='1' AND sno = '$session_logs'");
$rows_session = mysqli_fetch_assoc($results_session);
$s_snoid = mysqli_real_escape_string($con, $rows_session['sno']);
$s_email = mysqli_real_escape_string($con, $rows_session['email']);
$s_password = mysqli_real_escape_string($con, $rows_session['password']);
$s_role = mysqli_real_escape_string($con, $rows_session['role']);

$get_title_url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if(($s_role == 'Admin' || $s_role == 'college') && ($get_title_url == "avaloncommunitycollege.com/portal/dashboard/index.php")){
	header("Location: ../logout.php");
	exit;
}

if(($s_snoid != $_SESSION['sno']) || ($s_email != $_SESSION['email']) || ($s_password != $_SESSION['password'])){
	header("Location: ../logout.php");
	exit;	
}

}else{
	header("Location: ../logout.php");
	exit;
}
?>