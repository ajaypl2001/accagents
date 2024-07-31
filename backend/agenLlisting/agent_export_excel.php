<?php 
ob_start();
include("../../db.php");
			
echo 'Agent'. "\t" .'Name'. "\t" .'Username'. "\t" . 'Password'. "\t" . 'Agent Email'. "\t" . 'Mobile No.'. "\t" . 'Alternate Mobile No.'. "\t" . 'Address.'. "\t" . 'City'. "\t" . 'Status'. "\n";

$stragent = "SELECT * FROM `allusers` where role='Agent'";
$resultagent = mysqli_query($con, $stragent);
while($rowNew = mysqli_fetch_assoc($resultagent)){
	$sno = preg_replace('/\s+/', ' ',$rowNew['sno']);
	$username = preg_replace('/\s+/', ' ',$rowNew['username']);
	$contact_person = preg_replace('/\s+/', ' ',$rowNew['contact_person']);
	$email = preg_replace('/\s+/', ' ',$rowNew['email']);
	$original_pass = preg_replace('/\s+/', ' ',$rowNew['original_pass']);
	$agent_email = preg_replace('/\s+/', ' ',$rowNew['agent_email']);
	$mobile_no = preg_replace('/\s+/', ' ',$rowNew['mobile_no']);
	$alternate_mobile = preg_replace('/\s+/', ' ',$rowNew['alternate_mobile']);
	$address = preg_replace('/\s+/', ' ',$rowNew['address']);
	$city = preg_replace('/\s+/', ' ',$rowNew['city']);
	$verifystatus = preg_replace('/\s+/', ' ',$rowNew['verifystatus']);
	if($verifystatus == '1'){
		$acnt_status = 'Active';
	}else{
		$acnt_status = 'Not-Active';
	}
	
	
	// $campus = preg_replace('/\s+/', ' ',$rowNew['campus']);
	// $certificate = preg_replace('/\s+/', ' ',$rowNew['certificate']);
	// if(!empty($certificate)){
		// $certificate2 = 'Generated';
	// }else{
		// $certificate2 = 'Pending';
	// }

echo $username. "\t" .$contact_person. "\t" .$email. "\t" .$original_pass. "\t" .$agent_email. "\t" .$mobile_no. "\t" .$alternate_mobile. "\t" .$address. "\t" .$city. "\t" .$acnt_status. "\n";
}


header("Content-disposition: attachment; filename=AOL_Agent_List.xls");
?>