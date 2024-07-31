<?php 
/*
vm = verified message
*/

include("db.php");

$id = $_GET['verified'];
$origanal_id = base64_decode($id);
$update_verify = mysqli_query($con, "update `allusers` set `verifystatus`='Active' where `sno`='$origanal_id'");
$success = base64_decode('SUCCESS');
if($update_verify){
	header("Location: http://essglobal.online/aol/login?vm=success");
}

?>