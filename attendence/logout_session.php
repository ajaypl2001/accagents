<?php
ob_start();
if(!isset($_SESSION)){
	 session_start();
}
include("db.php");
if(!empty($_SESSION['sno']) || !empty($_SESSION['role']) || !empty($_SESSION['username']) || !empty($_SESSION['password'])){

$session_logs = $_SESSION['sno'];
$results_session = mysqli_query($conInt, "SELECT * FROM m_teacher WHERE sno='$session_logs'");
if(mysqli_num_rows($results_session)){
$rows_session = mysqli_fetch_assoc($results_session);
$s_snoid = mysqli_real_escape_string($conInt, $rows_session['sno']);
$s_role = mysqli_real_escape_string($conInt, $rows_session['role']);
$s_email = mysqli_real_escape_string($conInt, $rows_session['username']);
$s_password = mysqli_real_escape_string($conInt, $rows_session['password']);

if(($s_snoid != $_SESSION['sno']) || ($s_email != $_SESSION['username']) || ($s_role != $_SESSION['role']) || ($s_password != $_SESSION['password'])){
	header("Location: localhost/accagents/attendence/logout.php");		
}

}else{
	header("Location: localhost/accagents/attendence/logout.php");	
}
}else{
	header("Location: localhost/accagents/attendence/logout.php");	
}
?>