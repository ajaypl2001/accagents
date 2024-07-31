<?php
session_start();
include '../db.php';

if (isset($_POST['submit'])) {
    $uid = $_SESSION['stsno'];
	$query="SELECT sno, fname, student_no, contract_student_signature from ppp_form WHERE sno='$uid'";
	$result=mysqli_query($con, $query);	
	$row2 = mysqli_fetch_assoc($result);
	$fname = $row2['fname'];
	$student_no = $row2['student_no'];
	$contract_student_signature = $row2['contract_student_signature'];
	if(!empty($contract_student_signature)){
		unlink("../Student_Sign/$contract_student_signature");
	}
	
	$fname2 = str_replace(' ', '', $fname);
	$fileNmae='Draw_'.$student_no.'_'.$fname2;
	
    $folderPath = "../Student_Sign/";
    $image_parts = explode(";base64,", $_POST['signed']);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . $fileNmae . '.' . $image_type;
    $file2 = $fileNmae . '.' . $image_type;
    file_put_contents($file, $image_base64);

	$query = "UPDATE ppp_form SET contract_student_signature='$file2' WHERE sno='$uid'";
	mysqli_query($con, $query);
	 header('Location: pdf.php?uid='.$uid.'');
}
?>