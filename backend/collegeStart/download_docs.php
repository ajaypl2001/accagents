<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}

	$stusno = $_POST['stusno'];
	// $stusno = '12';
	$docs_query = "select fname, lname, student_id, idproof, englishpro, ielts_file, pte_file, certificate1, certificate2, certificate3, sign_student_declaration_agreement, sign_inter_stu_appli, offer_letter, loa_file from both_main_table where sno='$stusno'";
	$docs_res = mysqli_query($con, $docs_query);
	$docsdata = mysqli_fetch_assoc($docs_res);
	
	$fname = $docsdata['fname'];
	$lname = $docsdata['lname'];
	$refid = $docsdata['student_id'];
	$firstname = str_replace(' ', '', $fname);
	if($lname !== ''){
		$lastname = str_replace(' ', '', $lname);
		$ln = '_'.$lastname;
	}else{
		$ln = '';
	}
		
	$fileName = $refid .'_'. $firstname.$ln;	
	
	$file_folder = "../../uploads/"; 
	$file_folder2 = "../../uploads/offer_letter/"; 
	$file_folder1 = "../../uploads/loa/"; 
	$zip = new ZipArchive(); 
	$zip_name = $fileName.".zip";
	
	if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){
		$error .= "* Sorry ZIP creation failed at this time";
	}
	
	    $idproof = $docsdata['idproof'];
		$englishpro = $docsdata['englishpro'];			
		$certificate1 = $docsdata['certificate1'];		
		$certificate2 = $docsdata['certificate2'];
		$certificate3 = $docsdata['certificate3'];
		$sign_student_declaration_agreement = $docsdata['sign_student_declaration_agreement'];
		$sign_inter_stu_appli = $docsdata['sign_inter_stu_appli'];
		$offer_letter = $docsdata['offer_letter'];
		$loa_file = $docsdata['loa_file'];
		
		if($idproof !== ''){
			$zip->addFile($file_folder.$docsdata['idproof']);
		}
		if($englishpro == 'ielts'){
			$zip->addFile($file_folder.$docsdata['ielts_file']); 
		}
		if($englishpro == 'pte'){
			$zip->addFile($file_folder.$docsdata['pte_file']);
		}
		if($englishpro == 'duolingo'){
			$zip->addFile($file_folder.$docsdata['duolingo_file']);
		}		 
		
		if($certificate1 !== ''){
			$zip->addFile($file_folder.$docsdata['certificate1']);
		}
		if($certificate2 !== ''){
			$zip->addFile($file_folder.$docsdata['certificate2']);
		}
		if($certificate3 !== ''){
			$zip->addFile($file_folder.$docsdata['certificate3']);
		}
		if($sign_student_declaration_agreement !== ''){
			$zip->addFile($file_folder.$docsdata['sign_student_declaration_agreement']);
		} 
		if($sign_inter_stu_appli !== ''){
			$zip->addFile($file_folder.$docsdata['sign_inter_stu_appli']);
		} 
		if($offer_letter !== ''){
			$zip->addFile($file_folder2.$docsdata['offer_letter']);
		}
		if($loa_file !== ''){
			$zip->addFile($file_folder1.$docsdata['loa_file']);
		}
	
	$zip->close();
	if(file_exists($zip_name)){
		header('Content-type: application/zip');
		header('Content-Disposition: attachment; filename="'.$zip_name.'"');
		readfile($zip_name);
		unlink($zip_name);
	}
?>