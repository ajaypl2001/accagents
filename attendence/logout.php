<?php
ob_start();
include("db.php");
date_default_timezone_set("America/Toronto");
$date_at = date('Y-m-d');
$time_at = date('H:i:s');
session_start();

$snoid2 = $_SESSION['sno'];
$qryAttendance = "SELECT * FROM m_emp_instructor where date_at='$date_at' AND m_instructor_id='$snoid2'";
$rsltAttendance = mysqli_query($conInt, $qryAttendance);
if (mysqli_num_rows($rsltAttendance)){
	$inrstSignOut = "UPDATE `m_emp_instructor` SET `signout`='$time_at' WHERE `date_at`='$date_at' AND m_instructor_id='$snoid2'";
	mysqli_query($conInt, $inrstSignOut);
}

unset($_SESSION['sno']);
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['role']);
session_destroy();
header("Location: /login");
exit;
?>