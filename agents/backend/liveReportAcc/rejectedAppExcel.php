<?php
ob_start();
session_start();
include("../../db.php");
header("Content-Type: application/vnd.ms-excel");

$uname = $_SESSION['sno'];
if($uname == '1697' || $uname == '1700'){

if(!empty($_GET['getsearch'])){
	$getsearch2 = $_GET['getsearch'];
	$inputSearch = "AND (CONCAT(fname,  ' ', lname) LIKE '%$getsearch2%' OR refid LIKE '%$getsearch2%' OR passport_no LIKE '%$getsearch2%')";
}else{
	$inputSearch = '';
}

echo 'Agent Name' .  "\t" . 'Student Name'. "\t" .'RefId'. "\t" .'DOB' . "\t" .'Passport No' . "\t" .'Intake' . "\t" .'Program' . "\t" .'Created On'. "\t" .'Status'. "\t" .'Remarks' ."\n";

$qry = "SELECT * FROM st_application where admin_status_crs!='' AND admin_status_crs!='Yes' AND flowdrp!='Drop' $inputSearch";
$rslt = mysqli_query($con, $qry);
while($row_nm = mysqli_fetch_assoc($rslt)){
	$user_id = mysqli_real_escape_string($con, $row_nm['user_id']);
	$getquery22 = "SELECT * FROM `allusers` WHERE sno='$user_id'";		
	$RefundsWeeklyRslt22 = mysqli_query($con, $getquery22);
	$row_nm22 = mysqli_fetch_assoc($RefundsWeeklyRslt22);
	$username = mysqli_real_escape_string($con, $row_nm22['username']); 
	$fname = mysqli_real_escape_string($con, $row_nm['fname']);
	$lname = mysqli_real_escape_string($con, $row_nm['lname']);	 
	$fullname = $fname.' '.$lname;
	$refid = mysqli_real_escape_string($con, $row_nm['refid']);
	$dob = mysqli_real_escape_string($con, $row_nm['dob']);
	$passport_no = mysqli_real_escape_string($con, $row_nm['passport_no']);
	$date_at = mysqli_real_escape_string($con, $row_nm['datetime']);
	$prg_intake = mysqli_real_escape_string($con, $row_nm['prg_intake']);
	$prg_name1 = mysqli_real_escape_string($con, $row_nm['prg_name1']);
	$admin_status_crs = mysqli_real_escape_string($con, $row_nm['admin_status_crs']);
	$admin_remark_crs = mysqli_real_escape_string($con, $row_nm['admin_remark_crs']);
	
		 
echo $username .  "\t" . $fullname.  "\t" . $refid. "\t" . $dob  . "\t" . $passport_no. "\t" . $prg_intake. "\t" . $prg_name1. "\t" . $date_at. "\t" . $admin_status_crs. "\t" . $admin_remark_crs . "\n";

}

header("Content-disposition: attachment; filename=Rejected_Application_Report.xls");

}else{
	header("Location: ../../login");
    exit();
}
?>