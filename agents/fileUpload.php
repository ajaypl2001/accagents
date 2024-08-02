<?php
ob_start();
include 'db.php';
if(!isset($_SESSION)){
	 session_start();
}
date_default_timezone_set("Asia/Kolkata");
if(isset($_SESSION['sno']) && !empty($_SESSION['sno'])){
$loggedid = $_SESSION['sno'];
$rsltLogged = mysqli_query($con,"SELECT sno,role,email FROM allusers WHERE sno = '$loggedid'");
$rowLogged = mysqli_fetch_assoc($rsltLogged);
$Loggedrole = mysqli_real_escape_string($con, $rowLogged['role']);
$Loggedemail = mysqli_real_escape_string($con, $rowLogged['email']);
}else{
   $Loggedrole = '';
   $Loggedemail = ''; 
}

if(isset($_FILES['file_upload_vgr'])){	
	$asno = $_POST['asno'];
	$name1 = $_FILES['file_upload_vgr']['name']; 	
	$tmp1 = $_FILES['file_upload_vgr']['tmp_name'];	
	
	$delete_foldr=mysqli_query($con, "SELECT fname,refid, file_upload_vgr,file_upload_vgr2,file_upload_vgr3 FROM st_application where sno='$asno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);	
	$fname = $dltlist['fname'];	
	$file_upload_vgr = $dltlist['file_upload_vgr'];	
	$file_upload_vgr2 = $dltlist['file_upload_vgr2'];	
	$file_upload_vgr3 = $dltlist['file_upload_vgr3'];	
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);	
	
	
	if($name1 == ''){	
			$img_name1 = $file_upload_vgr;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);			
		if($extension=='pdf' || $extension=='PDF' || $extension=='jpg' || $extension=='png' || $extension=='JPG' || $extension=='PNG' || $extension=='docx'){
			if($file_upload_vgr !==''){
				unlink("uploads/$file_upload_vgr");
			}
			$img_name1 = 'TT_Agent_Copy'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			if(move_uploaded_file($tmp1, 'uploads/'.$img_name1)){
				mysqli_query($con,"UPDATE `st_application` SET  `file_upload_vgr` = '$img_name1' WHERE `sno` =$asno"); 
				echo "<a href='../uploads/".$img_name1."' class='preview1' download>Download</a>";
			}else{
				echo "failed"; 
				exit;
			}
		}else{
			echo "notsupport";
			exit;
		}	
	}
	
}

if(isset($_FILES['file_upload_vgr2'])){	
	$asno = $_POST['asno'];
	$name1 = $_FILES['file_upload_vgr2']['name']; 	
	$tmp1 = $_FILES['file_upload_vgr2']['tmp_name'];	
	
	$delete_foldr=mysqli_query($con, "SELECT fname,refid, file_upload_vgr,file_upload_vgr2,file_upload_vgr3 FROM st_application where sno='$asno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);	
	$fname = $dltlist['fname'];	
	$file_upload_vgr = $dltlist['file_upload_vgr'];	
	$file_upload_vgr2 = $dltlist['file_upload_vgr2'];	
	$file_upload_vgr3 = $dltlist['file_upload_vgr3'];	
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);	
	
	if($name1 == ''){	
			$img_name1 = $file_upload_vgr2;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);				
		if($extension=='pdf' || $extension=='PDF' || $extension=='jpg' || $extension=='png' || $extension=='JPG' || $extension=='PNG' || $extension=='docx'){
			if($file_upload_vgr2 !==''){
				unlink("uploads/$file_upload_vgr2");
			}
			$img_name1 = 'Refund_Form'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			if(move_uploaded_file($tmp1, 'uploads/'.$img_name1)){
				mysqli_query($con,"UPDATE `st_application` SET  `file_upload_vgr2` = '$img_name1' WHERE `sno` =$asno"); 
				echo "<a href='../uploads/".$img_name1."' class='preview2' download>Download</a>";
			}else{
				echo "failed"; 
				exit;
			}
		}else{
			echo "notsupport";
			exit;
		}				
	}
	
}


if(isset($_FILES['file_upload_vgr3'])){	
	$asno = $_POST['asno'];
	$name1 = $_FILES['file_upload_vgr3']['name']; 	
	$tmp1 = $_FILES['file_upload_vgr3']['tmp_name'];	
	
	$delete_foldr=mysqli_query($con, "SELECT fname,refid,file_upload_vgr,file_upload_vgr2,file_upload_vgr3 FROM st_application where sno='$asno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);	
	$fname = $dltlist['fname'];	
	$file_upload_vgr = $dltlist['file_upload_vgr'];	
	$file_upload_vgr2 = $dltlist['file_upload_vgr2'];	
	$file_upload_vgr3 = $dltlist['file_upload_vgr3'];	
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);
		
	if($name1 == ''){	
			$img_name1 = $file_upload_vgr3;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);				
		if($extension=='pdf' || $extension=='PDF' || $extension=='jpg' || $extension=='png' || $extension=='JPG' || $extension=='PNG' || $extension=='docx'){
			if($file_upload_vgr3 !==''){
				unlink("uploads/$file_upload_vgr3");
			}
			$img_name1 = 'Refusal_Letter'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			if(move_uploaded_file($tmp1, 'uploads/'.$img_name1)){
				mysqli_query($con,"UPDATE `st_application` SET  `file_upload_vgr3` = '$img_name1' WHERE `sno` =$asno"); 
				echo "<a href='../uploads/".$img_name1."' class='preview3' download>Download</a>";
			}else{
				echo "failed"; 
				exit;
			}
		}else{
			echo "notsupport";
			exit;
		}				
	}
	
}


?>

