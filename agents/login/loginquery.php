<?php
session_start();
include("../db.php");
date_default_timezone_set("Asia/Kolkata");
$current_date3 = date('Y-m-d');
$current_time = date('H:i:s');
$ip_address = $_SERVER['REMOTE_ADDR'];

if(isset($_POST["emailForm"])){
		
	$emailForm = $_POST['emailForm'];
	$pwdform = $_POST['pwdform'];
	$login = mysqli_query($con,"SELECT * FROM allusers WHERE verifystatus='1' AND (email = '" . $emailForm . "') and (password = '" . md5(sha1($pwdform)) . "')");
    if (mysqli_num_rows($login) == 1) {
        while ($row = mysqli_fetch_array($login)) {            
            $_SESSION['sno'] = $row['sno'];
			$_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
			
			$role = $row['role'];
			$email = $row['email'];
			$username = $row['username'];
			$password2 = $row['original_pass'];
			$studentid = $row['sno'];
			$report_allow = $row['report_allow'];
			// $stun = mysqli_query($con, "SELECT * FROM st_application WHERE user_id='$studentid'");
			// $row1 = mysqli_fetch_assoc($stun); 
				$applForm = '';			
			}
		// if($role == 'Admin'){
			// echo "bkdb";
		// }
		
		mysqli_query($con, "UPDATE `allusers` SET `last_login_date_at` = '$current_date3', `last_login_time_at` = '$current_time' WHERE `sno` = '$studentid'");
		mysqli_query($con, "INSERT INTO `allusers_logs` (`uid`, `name`, `username`, `password`, `ip_address`, `created_date`, `created_time`) VALUES ('$studentid', '$username', '$email', '$password2', '$ip_address', '$current_date3', '$current_time')");
		
		if(($role == 'Admin') && ($report_allow == '1')){
			echo "bkdb";
		}
		if(($role == 'Admin') && ($report_allow == '')){
			echo "report";
		}
		if($role == 'college'){
			echo "clg";
		}
		if($role == 'Agent'){
			echo "urldashboard";		
		}
		if($role == 'Excu'){
			echo "bkdb";
		}	
		if($role == 'Excu1'){
			echo "bkdb";
		}		
		if($role == 'Student'){
			if($applForm == '1'){
				echo "studenturl";
			}else{
				echo "urldashboard";
			}
		}
    } else {
		// print "<p class='Error'>Your Email Address and Password is wrong.</p>";
		echo '403';
	}
} 
?>