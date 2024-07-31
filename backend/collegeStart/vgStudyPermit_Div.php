<?php
ob_start();
include("../../db.php");

$getquery22 = "SELECT st_application.sno FROM st_application INNER JOIN international_airport_student ON international_airport_student.app_id=st_application.sno where international_airport_student.app_id!=''";
$qurySql = mysqli_query($con, $getquery22);
// $dd=1;
while ($row_nm = mysqli_fetch_assoc($qurySql)){
	$snoid = $row_nm['sno'];
	// echo '<br>';	
	// echo $dd++;
	$getquery2222 = "UPDATE `st_application` SET `study_permit` = 'Yes' WHERE `sno` ='$snoid'";
	// echo '<br>';
	mysqli_query($con, $getquery2222);
}
?>