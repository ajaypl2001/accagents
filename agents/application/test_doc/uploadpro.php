<?php
ob_start();
include("../db.php");
date_default_timezone_set("Asia/Kolkata");

$stuid = $_POST['stuid'];
$rsltqry = "SELECT sno,fname,refid, certificate1, certificate2, certificate3,ielts_file,pte_file, duolingo_file FROM st_application WHERE sno = '$stuid'";
$result = mysqli_query($con, $rsltqry);
$row = mysqli_fetch_assoc($result);
// $fname = mysqli_real_escape_string($con, $row['fname']);
// $refid = mysqli_real_escape_string($con, $row['refid']);
// $duolingo_file = mysqli_real_escape_string($con, $row['duolingo_file']);
print_r($row);
die;

$firstname = str_replace(' ', '', $fname);

        
if(isset($_FILES['duolingo_file'])){
	$namepdf = $_FILES['duolingo_file']['name'];
	$tmppdf = $_FILES['duolingo_file']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='rar' || $extension=='png' || $extension=='PNG' || $extension=='JPG' || $extension=='JPG' || $extension=='JPEG' || $extension=='JPEG'){
	$pte_file_size = $_FILES['duolingo_file']['size'];
		if($pte_file_size <= '2097152'){
			if(!empty($duolingo_file)){
				unlink("../uploads/$duolingo_file");
			}
			$img_name_duolingo_file = 'Duolingo'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_duolingo_file);
			
			echo $updateqry = "update `st_application` set `duolingo_file`='$img_name_duolingo_file' where `sno`='$stuid'";
			// $update_query = mysqli_query($con, $updateqry);
			
		}else{
			echo "File too large. File must be less than 2 megabytes.";
			exit;
		}
	}else{
		echo 'File is not Supported (Please upload the PDF and ZIP Files)';
		exit;
	}	
} 
?>