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

if(isset($_FILES['qpf'])){	
	$asno = $_POST['asno'];
	$name1 = $_FILES['qpf']['name']; 	
	$tmp1 = $_FILES['qpf']['tmp_name'];	
	
	$delete_foldr=mysqli_query($con, "SELECT fname,refid, qpf FROM st_application where sno='$asno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);	
	$fname = $dltlist['fname'];	
	$qpf = $dltlist['qpf'];	
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);	
	
	
	if($name1 == ''){	
			$img_name1 = $qpf;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);			
		if($extension=='pdf' || $extension=='PDF' || $extension=='jpg' || $extension=='png' || $extension=='JPG' || $extension=='PNG' || $extension=='docx'){
			if($qpf !==''){
				unlink("Students_Travelling/$qpf");
			}
			$img_name1 = 'QPF'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			if(move_uploaded_file($tmp1, 'Students_Travelling/'.$img_name1)){
				mysqli_query($con,"UPDATE `st_application` SET  `qpf` = '$img_name1' WHERE `sno` =$asno"); 
				echo "<a href='../Students_Travelling/".$img_name1."' class='preview1_91' download>Download</a>";
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

if(isset($_FILES['loa_receipt'])){	
	$asno = $_POST['asno'];
	$name1 = $_FILES['loa_receipt']['name']; 	
	$tmp1 = $_FILES['loa_receipt']['tmp_name'];	
	
	$delete_foldr=mysqli_query($con, "SELECT fname,refid, loa_receipt FROM st_application where sno='$asno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);	
	$fname = $dltlist['fname'];	
	$loa_receipt = $dltlist['loa_receipt'];	
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);	
	
	if($name1 == ''){	
			$img_name1 = $loa_receipt;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);				
		if($extension=='pdf' || $extension=='PDF' || $extension=='jpg' || $extension=='png' || $extension=='JPG' || $extension=='PNG' || $extension=='docx'){
			if($loa_receipt !==''){
				unlink("Students_Travelling/$loa_receipt");
			}
			$img_name1 = 'LOAReceipt'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			if(move_uploaded_file($tmp1, 'Students_Travelling/'.$img_name1)){
				mysqli_query($con,"UPDATE `st_application` SET  `loa_receipt` = '$img_name1' WHERE `sno` =$asno"); 
				echo "<a href='../Students_Travelling/".$img_name1."' class='preview1_92' download>Download</a>";
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


if(isset($_FILES['air_ticket'])){	
	$asno = $_POST['asno'];
	$name1 = $_FILES['air_ticket']['name']; 	
	$tmp1 = $_FILES['air_ticket']['tmp_name'];	
	
	$delete_foldr=mysqli_query($con, "SELECT fname,refid,air_ticket FROM st_application where sno='$asno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);	
	$fname = $dltlist['fname'];	
	$air_ticket = $dltlist['air_ticket'];	
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);
		
	if($name1 == ''){	
			$img_name1 = $air_ticket;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);				
		if($extension=='pdf' || $extension=='PDF' || $extension=='jpg' || $extension=='png' || $extension=='JPG' || $extension=='PNG' || $extension=='docx'){
			if($air_ticket !==''){
				unlink("Students_Travelling/$air_ticket");
			}
			$img_name1 = 'Air_Ticket'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			if(move_uploaded_file($tmp1, 'Students_Travelling/'.$img_name1)){
				mysqli_query($con,"UPDATE `st_application` SET  `air_ticket` = '$img_name1' WHERE `sno` =$asno"); 
				echo "<a href='../uploads/".$img_name1."' class='preview1_93' download>Download</a>";
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

if(isset($_FILES['passport_file'])){	
	$asno = $_POST['asno'];
	$name1 = $_FILES['passport_file']['name']; 	
	$tmp1 = $_FILES['passport_file']['tmp_name'];	
	
	$delete_foldr=mysqli_query($con, "SELECT fname,refid,passport_file FROM st_application where sno='$asno'");
	$dltlist = mysqli_fetch_assoc($delete_foldr);	
	$fname = $dltlist['fname'];	
	$passport_file = $dltlist['passport_file'];	
	$refid = $dltlist['refid'];
	$firstname = str_replace(' ', '', $fname);
		
	if($name1 == ''){	
			$img_name1 = $passport_file;	
	}else{								
		$extension = pathinfo($name1, PATHINFO_EXTENSION);				
		if($extension=='pdf' || $extension=='PDF' || $extension=='jpg' || $extension=='png' || $extension=='JPG' || $extension=='PNG' || $extension=='docx'){
			if($passport_file !==''){
				unlink("Students_Travelling/$passport_file");
			}
			$img_name1 = 'PASSPORT'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			if(move_uploaded_file($tmp1, 'Students_Travelling/'.$img_name1)){
				mysqli_query($con,"UPDATE `st_application` SET `passport_file` = '$img_name1' WHERE `sno` =$asno"); 
				echo "<a href='../uploads/".$img_name1."' class='preview1_94' download>Download</a>";
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