<?php
ob_start();
include("../db.php");

	$stusno = $_GET['stusno'];
	// $stusno = '12';
	$docs_query = "select ppp_form_id, contract_signature, pp_sign, brsry_sign, emc_sign, shc_sign, osap_fund_sign, pai_sign from ppp_form_more where ppp_form_id='$stusno'";
	$docs_res = mysqli_query($con, $docs_query);
	$docsdata = mysqli_fetch_assoc($docs_res);
	$contract_signature = $docsdata['contract_signature'];
	$pp_sign = $docsdata['pp_sign'];			
	$emc_sign = $docsdata['emc_sign'];		
	$shc_sign = $docsdata['shc_sign'];
	$osap_fund_sign = $docsdata['osap_fund_sign'];
	$pai_sign = $docsdata['pai_sign'];
	$brsry_sign = $docsdata['brsry_sign'];
	
	$docs_query2 = "select sno, fname, student_no, bursary_award from ppp_form where sno='$stusno'";
	$docs_res2 = mysqli_query($con, $docs_query2);
	$docsdata2 = mysqli_fetch_assoc($docs_res2);
	
	$fname = $docsdata2['fname'];
	$firstname = str_replace(' ', '', $fname);
	
	$student_no2 = $docsdata2['student_no'];
	$student_no = str_replace(' ', '', $student_no2);
	
	$bursary_award = $docsdata2['bursary_award'];
		
	$fileName = $firstname .'_'. $student_no;	
	
	$file_folder = "../docsign/uploads/";
	$zip = new ZipArchive(); 
	$zip_name = $fileName.".zip";
	
	if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){
		$error .= "* Sorry ZIP creation failed at this time";
	}
		
		if($contract_signature !== ''){
			$zip->addFile($file_folder.$docsdata['contract_signature']);
		}		
		if($pp_sign !== ''){
			$zip->addFile($file_folder.$docsdata['pp_sign']);
		}
		if($emc_sign !== ''){
			$zip->addFile($file_folder.$docsdata['emc_sign']);
		}
		if($shc_sign !== ''){
			$zip->addFile($file_folder.$docsdata['shc_sign']);
		} 
		if($osap_fund_sign !== ''){
			$zip->addFile($file_folder.$docsdata['osap_fund_sign']);
		} 
		if($pai_sign !== ''){
			$zip->addFile($file_folder.$docsdata['pai_sign']);
		} 
		if($brsry_sign !== '' && $bursary_award !== 'No bursary'){
			$zip->addFile($file_folder.$docsdata['brsry_sign']);
		}	
	
	$zip->close();
	if(file_exists($zip_name)){
		header('Content-type: application/zip');
		header('Content-Disposition: attachment; filename="'.$zip_name.'"');
		readfile($zip_name);
		unlink($zip_name);
	}	
?>