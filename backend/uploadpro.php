<?php
ob_start();
include("../db.php");
date_default_timezone_set("Asia/Kolkata");

$stuid = $_POST['stuid'];
$rsltqry = "SELECT sno,fname,refid, idproof, certificate1, certificate2, certificate3,englishpro, ielts_file,pte_file, duolingo_file FROM st_application WHERE sno = '$stuid'";
$result = mysqli_query($con, $rsltqry);
$row = mysqli_fetch_assoc($result);
$fname = mysqli_real_escape_string($con, $row['fname']);
$refid = mysqli_real_escape_string($con, $row['refid']);
$idproof = mysqli_real_escape_string($con, $row['idproof']);
$englishpro = mysqli_real_escape_string($con, $row['englishpro']);
if($englishpro == 'ielts'){
	$ielts_file = mysqli_real_escape_string($con, $row['ielts_file']);
}else{
	$ielts_file = '';
}
if($englishpro == 'Toefl'){
	$Toefl_file = mysqli_real_escape_string($con, $row['ielts_file']);
}else{
	$Toefl_file = '';
}
$pte_file = mysqli_real_escape_string($con, $row['pte_file']);
$duolingo_file = mysqli_real_escape_string($con, $row['duolingo_file']);
$certificate1 = mysqli_real_escape_string($con, $row['certificate1']);
$certificate2 = mysqli_real_escape_string($con, $row['certificate2']);
$certificate3 = mysqli_real_escape_string($con, $row['certificate3']);

$firstname = str_replace(' ', '', $fname);

        
if(isset($_POST['uploaddoc'])){
	$stuid = $_POST['stuid'];
	$rsltqry = "SELECT sno, idproof, certificate1, englishpro, ielts_file, pte_file, duolingo_file FROM st_application WHERE sno = '$stuid'";
	$result = mysqli_query($con, $rsltqry);
	$row = mysqli_fetch_assoc($result);
	$idproof = mysqli_real_escape_string($con, $row['idproof']);
	$englishpro = mysqli_real_escape_string($con, $row['englishpro']);
	if($englishpro == 'ielts'){
		$ielts_file = mysqli_real_escape_string($con, $row['ielts_file']);
	}else{
		$ielts_file = '';
	}
	if($englishpro == 'Toefl'){
		$Toefl_file = mysqli_real_escape_string($con, $row['ielts_file']);
	}else{
		$Toefl_file = '';
	}
	$pte_file = mysqli_real_escape_string($con, $row['pte_file']);
	$duolingo_file = mysqli_real_escape_string($con, $row['duolingo_file']);
	$certificate1 = mysqli_real_escape_string($con, $row['certificate1']);
	if(empty($idproof)){
		echo '1';
		exit;
	}
	if($ielts_file == '' && $Toefl_file == '' && $pte_file == '' && $duolingo_file == ''){
		echo '2';
		exit;
	}
	if(empty($certificate1)){
		echo '3';
		exit;
	}
	if(!empty($idproof) && (!empty($ielts_file) || !empty($Toefl_file) || !empty($pte_file) || !empty($duolingo_file)) && !empty($certificate1)){
		echo '4';
		exit;
	}
	
}

	
if(isset($_FILES['idproof'])){
	$namepdf = $_FILES['idproof']['name'];
	$tmppdf = $_FILES['idproof']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	$pte_file_size = $_FILES['idproof']['size'];
	if($pte_file_size <= '4194304'){
		
		if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='ZIP' || $extension=='rar' || $extension=='RAR' || $extension=='png' || $extension=='PNG' || $extension=='JPG' || $extension=='JPG' || $extension=='JPEG' || $extension=='JPEG'){	
			if(!empty($idproof)){
				unlink("../uploads/$idproof");
			}
			$img_name_idproof = 'Passport'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_idproof);
			
			$updateqry = "update `st_application` set `idproof`='$img_name_idproof' where `sno`='$stuid'";
			$update_query = mysqli_query($con, $updateqry);
			echo "<a href='../../uploads/".$img_name_idproof."' class='preview1 btn btn-success btn-download' download>Download Passport</a>";
		}else{
			echo 'File is not Supported (Please upload the JPG, PNG, ZIP or PDF Files)';
			exit;
		}
	}else{
		echo "File too large. File must be less than 4 megabytes.";
		exit;
	}
}


if(isset($_FILES['ielts_file'])){
	$namepdf = $_FILES['ielts_file']['name'];
	$tmppdf = $_FILES['ielts_file']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	$pte_file_size = $_FILES['ielts_file']['size'];
	if($pte_file_size <= '2097152'){
		
		if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='rar' || $extension=='png' || $extension=='PNG' || $extension=='JPG' || $extension=='JPG' || $extension=='JPEG' || $extension=='JPEG'){	
			if(!empty($ielts_file)){
				unlink("../uploads/$ielts_file");
			}
			$img_name_ielts_file = 'Ielts'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_ielts_file);
			
			$updateqry = "update `st_application` set `ielts_file`='$img_name_ielts_file' where `sno`='$stuid'";
			$update_query = mysqli_query($con, $updateqry);		
			echo "<a href='../../uploads/".$img_name_ielts_file."' class='preview2 btn btn-success btn-download' download>Download IELTS TRF</a>";
		}else{
			echo 'File is not Supported (Please upload the PDF and ZIP Files)';
			exit;
		}
	}else{
		echo "File too large. File must be less than 2 megabytes.";
		exit;
	}
}

if(isset($_FILES['Toefl_file'])){
	$namepdf = $_FILES['Toefl_file']['name'];
	$tmppdf = $_FILES['Toefl_file']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	$pte_file_size = $_FILES['Toefl_file']['size'];
	if($pte_file_size <= '2097152'){
		
		if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='rar' || $extension=='png' || $extension=='PNG' || $extension=='JPG' || $extension=='JPG' || $extension=='JPEG' || $extension=='JPEG'){	
			if(!empty($Toefl_file)){
				unlink("../uploads/$Toefl_file");
			}
			$img_name_ielts_file = 'Toefl'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_ielts_file);
			
			$updateqry = "update `st_application` set `ielts_file`='$img_name_ielts_file' where `sno`='$stuid'";
			$update_query = mysqli_query($con, $updateqry);		
			echo "<a href='../../uploads/".$img_name_ielts_file."' class='preview2 btn btn-success btn-download mt-1' download>Download Toefl TRF</a>";
		}else{
			echo 'File is not Supported (Please upload the PDF and ZIP Files)';
			exit;
		}
	}else{
		echo "File too large. File must be less than 2 megabytes.";
		exit;
	}
}

if(isset($_FILES['pte_file'])){
	$namepdf = $_FILES['pte_file']['name'];
	$tmppdf = $_FILES['pte_file']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	$pte_file_size = $_FILES['pte_file']['size'];
	if($pte_file_size <= '2097152'){
		
		if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='rar' || $extension=='png' || $extension=='PNG' || $extension=='JPG' || $extension=='JPG' || $extension=='JPEG' || $extension=='JPEG'){	
			if(!empty($pte_file)){
				unlink("../uploads/$pte_file");
			}
			$img_name_pte_file = 'Pte'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_pte_file);
			
			$updateqry = "update `st_application` set `pte_file`='$img_name_pte_file' where `sno`='$stuid'";
			$update_query = mysqli_query($con, $updateqry);		
			echo "<a href='../../uploads/".$img_name_pte_file."' class='preview2 btn btn-success btn-download' download>Download PTE TRF</a>";
		}else{
			echo 'File is not Supported (Please upload the PDF and ZIP Files)';
			exit;
		}
	}else{
		echo "File too large. File must be less than 2 megabytes.";
		exit;
	}
} 

if(isset($_FILES['duolingo_file'])){
	$namepdf = $_FILES['duolingo_file']['name'];
	$tmppdf = $_FILES['duolingo_file']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	$pte_file_size = $_FILES['duolingo_file']['size'];
	if($pte_file_size <= '2097152'){
		
		if($extension=='pdf' || $extension=='PDF' || $extension=='zip' || $extension=='rar' || $extension=='png' || $extension=='PNG' || $extension=='JPG' || $extension=='JPG' || $extension=='JPEG' || $extension=='JPEG'){	
			if(!empty($duolingo_file)){
				unlink("../uploads/$duolingo_file");
			}
			$img_name_duolingo_file = 'Duolingo'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_duolingo_file);
			
			$updateqry = "update `st_application` set `duolingo_file`='$img_name_duolingo_file' where `sno`='$stuid'";
			$update_query = mysqli_query($con, $updateqry);		
			echo "<a href='../../uploads/".$img_name_duolingo_file."' class='preview2 btn btn-success btn-download' download>Download Duolingo File</a>";
		}else{
			echo 'File is not Supported (Please upload the PDF and ZIP Files)';
			exit;
		}
	}else{
		echo "File too large. File must be less than 2 megabytes.";
		exit;
	}
}

if(isset($_FILES['qualifications1'])){
	$namepdf = $_FILES['qualifications1']['name'];
	$tmppdf = $_FILES['qualifications1']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	$qualifications1_size = $_FILES['qualifications1']['size'];
	if($qualifications1_size <= '5242880'){
		
		if($extension=='pdf'  || $extension=='PDF'|| $extension=='jpg' || $extension=='JPG' || $extension=='PNG' || $extension=='png' || $extension=='zip' || $extension=='ZIP' || $extension=='rar' || $extension=='RAR'){	
			if(!empty($qualifications1)){
				unlink("../uploads/$qualifications1");
			}
			$img_name_qualifications1 = 'Crt1'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_qualifications1);
			
			$updateqry = "update `st_application` set `certificate1`='$img_name_qualifications1' where `sno`='$stuid'";
			$update_query = mysqli_query($con, $updateqry);		
			echo "<a href='../../uploads/".$img_name_qualifications1."' class='preview3 btn btn-success btn-download' download>Download Certificate</a>";
		}else{
			echo 'File is not Supported (Upload PDF or all documents in one zip file)';
			exit;
		}
	}else{
		echo "File too large. File must be less than 5 megabytes.";
		exit;
	}
}

if(isset($_FILES['qualifications2'])){
	$namepdf = $_FILES['qualifications2']['name'];
	$tmppdf = $_FILES['qualifications2']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	$qualifications2_size = $_FILES['qualifications2']['size'];
	if($qualifications2_size <= '5242880'){
		
		if($extension=='pdf'  || $extension=='PDF'|| $extension=='jpg' || $extension=='JPG' || $extension=='PNG' || $extension=='png' || $extension=='zip' || $extension=='ZIP' || $extension=='rar' || $extension=='RAR'){	
			if(!empty($qualifications2)){
				unlink("../uploads/$qualifications2");
			}
			$img_name_qualifications2 = 'Crt2'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_qualifications2);
			
			$updateqry = "update `st_application` set `certificate2`='$img_name_qualifications2' where `sno`='$stuid'";
			$update_query = mysqli_query($con, $updateqry);		
			echo "<a href='../../uploads/".$img_name_qualifications2."' class='preview4 btn btn-success btn-download' download>Download Certificate</a>";
		}else{
			echo 'File is not Supported (Upload PDF or all documents in one zip file)';
			exit;
		}
	}else{
		echo "File too large. File must be less than 5 megabytes.";
		exit;
	}
}

if(isset($_FILES['qualifications3'])){
	$namepdf = $_FILES['qualifications3']['name'];
	$tmppdf = $_FILES['qualifications3']['tmp_name'];
	$extension = pathinfo($namepdf, PATHINFO_EXTENSION);
	
	$qualifications3_size = $_FILES['qualifications3']['size'];
	if($qualifications3_size <= '5242880'){
		
		if($extension=='pdf'  || $extension=='PDF'|| $extension=='jpg' || $extension=='JPG' || $extension=='PNG' || $extension=='png' || $extension=='zip' || $extension=='ZIP' || $extension=='rar' || $extension=='RAR'){	
			if(!empty($qualifications3)){
				unlink("../uploads/$qualifications3");
			}
			$img_name_qualifications3 = 'Crt3'.'_'.$firstname.'_'.$refid.'_'.date('is').'.'.$extension;
			move_uploaded_file($tmppdf, '../uploads/'.$img_name_qualifications3);
			
			$updateqry = "update `st_application` set `certificate3`='$img_name_qualifications3' where `sno`='$stuid'";
			$update_query = mysqli_query($con, $updateqry);		
			echo "<a href='../../uploads/".$img_name_qualifications3."' class='preview5 btn btn-success btn-download' download>Download Certificate</a>";
		}else{
			echo 'File is not Supported (Upload PDF or all documents in one zip file)';
			exit;
		}
	}else{
		echo "File too large. File must be less than 5 megabytes.";
		exit;
	}
}

//////////
if (isset($_POST['doc_filled_name'])) {

    $doc_filled_name = $_POST['doc_filled_name'];
    $doc_content = $_POST['content_doc'];
    $preview_div = $_POST['preview_div'];

    $namepdf = $_FILES[$doc_filled_name]['name'];
    $tmppdf = $_FILES[$doc_filled_name]['tmp_name'];
    $extension = pathinfo($namepdf, PATHINFO_EXTENSION);
    $travel_documents_size = $_FILES[$doc_filled_name]['size'];

    if ($travel_documents_size <= '4194304') {

        if ($extension == 'pdf' || $extension == 'PDF') {
            $img_name = $doc_filled_name . '_' . $refid . '_' . date('is') . '.' . $extension;
            $datecrnt = date('Y-m-d H:i:s');
        } else {
            echo 'File is not Supported (Upload PDF file)';
            exit;
        }
    } else {
        echo "File too large. File must be less than 4 megabytes.";
        exit;
    }

    $resultRefA = mysqli_query($con, "SELECT * FROM `travel_docs` where st_id='$stuid' AND doc_name='$doc_content'");
    if (mysqli_num_rows($resultRefA)) {
        $rowGGT = mysqli_fetch_assoc($resultRefA);
        $content_doc = $rowGGT['travel_file_upload'];
        $doc_status = $rowGGT['doc_status'];
        $datetime_at = $rowGGT['datetime_at'];
        $remarks = $rowGGT['remarks'];
        $doc_name = $rowGGT['doc_name'];
        if ($doc_status != 1) {
            move_uploaded_file($tmppdf, '../travelDoc/' . $img_name);
            if (!empty($content_doc)) {
                unlink("../travelDoc/$content_doc");
            }
            $updateqry = "update `travel_docs` set `travel_file_upload`='$img_name', datetime_at='$datecrnt',doc_status='' where `st_id`='$stuid' AND doc_name='$doc_content'";
            mysqli_query($con, $updateqry);
            echo "<a href='../../travelDoc/" . $img_name . "' class='btn btn-sm btn-primary btn-download mt-1 preview" . $preview_div . "' download>Download</a><div class='col-sm-3'>
			<div class='preview'><b>Update On :</b> " . $datecrnt . "</div></div>";
            exit;
        } else {
            echo "<a href='../../travelDoc/" . $content_doc . "' class='btn btn-sm btn-primary btn-download mt-1 preview" . $preview_div . "' download>Download</a>&nbsp;<span style='color:red'>Already uploded</span><div class='col-sm-3'>
			<div class='preview'><b>Update On :</b> " . $datetime_at . "</div></div>";
            exit;
        }
    } else {
        move_uploaded_file($tmppdf, '../travelDoc/' . $img_name);
        $updateqry = "INSERT INTO `travel_docs` (`st_id`, `doc_name`, `travel_file_upload`, `datetime_at`) VALUES ('$stuid', '$doc_content', '$img_name', '$datecrnt')";
        mysqli_query($con, $updateqry);
        echo $a = "<a href='../../travelDoc/" . $img_name . "' class='btn btn-sm btn-primary btn-download mt-1 preview" . $preview_div . "' download>Download</a><div class='col-sm-3'>
				<div class='preview'><b>Update On :</b> " . $datecrnt . "</div></div>";
        exit;
    }
}

?>