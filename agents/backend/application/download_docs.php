<?php
ob_start();
include("../../db.php");

	$stusno = $_POST['stusno'];
	// $stusno = '12';
	$docs_query = "select sno, fname, refid, student_id, idproof, englishpro, certificate1, ielts_file, pte_file, duolingo_file, loa_file from st_application where sno='$stusno' AND course_status='1'";
	$docs_res = mysqli_query($con, $docs_query);
	$docsdata = mysqli_fetch_assoc($docs_res);
	
	$sno = $docsdata['sno'];
	$fname = $docsdata['fname'];
	$refid = $docsdata['refid'];
	$student_id = $docsdata['student_id'];
	$firstname = str_replace(' ', '', $fname);
	
	$getQry = "SELECT signed_contract FROM `st_app_more` WHERE app_id='$sno' AND signed_contract!=''";
	$getQryRslt = mysqli_query($con, $getQry);
	if(mysqli_num_rows($getQryRslt)){
		$rowS = mysqli_fetch_assoc($getQryRslt);
		$signed_contract2 = $rowS['signed_contract'];
	}else{		
		$signed_contract2 = '';
	}
		
	$fileName = $student_id.'_'.$firstname;	
	
	$file_folder = "../../uploads/";
	// $file_folder = "../../uploads/loa/";
	$file_folder2 = "../../../docsignD2/uploadsWS/";
	$zip = new ZipArchive(); 
	$zip_name = $fileName.".zip";
	
	if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){
		$error .= "* Sorry ZIP creation failed at this time";
	}	
	    $idproof = $docsdata['idproof'];
		$englishpro = $docsdata['englishpro'];			
		$certificate1 = $docsdata['certificate1'];
		$loa_file = $docsdata['loa_file'];
		
		if(!empty($idproof)){
			$zip->addFile($file_folder.$idproof);
		}
		if($englishpro == 'ielts'){
			$zip->addFile($file_folder.$docsdata['ielts_file']); 
		}
		if($englishpro == 'pte'){
			$zip->addFile($file_folder.$docsdata['pte_file']);
		}
		if($englishpro == 'Toefl'){
			$zip->addFile($file_folder.$docsdata['ielts_file']);
		}		 
		
		if(!empty($certificate1)){
			$zip->addFile($file_folder.$certificate1);
		}		 
		
		if(!empty($loa_file)){
			$zip->addFile($loa_file);
		}	 
		
		if(!empty($signed_contract2)){
			$zip->addFile($file_folder2.$signed_contract2);
		}	

	$zip->close();
	if(file_exists($zip_name)){
		header('Content-type: application/zip');
		header('Content-Disposition: attachment; filename="'.$zip_name.'"');
		readfile($zip_name);
		unlink($zip_name);
	}	
?>