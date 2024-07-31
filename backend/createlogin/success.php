<?php 
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}
?>
<style>
.msgss .alert.alert-success.alert-dismissible {
    margin-top: 36px;
    margin-bottom: -70px;
    width: 54%;
    margin-left: 22%;
}
body { background:url(../../images/book.jpg) no-repeat; background-size: cover;
   
  }
</style>
<?php
$sessionSno = $_SESSION['sno'];
$result1 = mysqli_query($con,"SELECT sno,role,create_login FROM allusers WHERE sno = '$sessionSno'");
 while ($row1 = mysqli_fetch_assoc($result1)) {
   $adminrole = mysqli_real_escape_string($con, $row1['role']);  
   $createLogin = mysqli_real_escape_string($con, $row1['create_login']);  
 }
?>
<body>
<section class="signin-page container-fluid">
<div class="container mt-5">
 <div class="row">
<?php

if($createLogin == '1'){
	
if(isset($_GET['lid']) && ($_GET['lid']!=='')){
$lids =  base64_decode($_GET['lid']);	
$result2 = mysqli_query($con,"SELECT username,email,original_pass,agent_email,mobile_no,alternate_mobile,contact_person, city,address,country FROM allusers WHERE sno = '$lids'");
$row2 = mysqli_fetch_assoc($result2);
$uname2 = mysqli_real_escape_string($con, $row2['username']);
$email2 = mysqli_real_escape_string($con, $row2['email']);
$pass2 = mysqli_real_escape_string($con, $row2['original_pass']);
$agent_email2 = mysqli_real_escape_string($con, $row2['agent_email']);
$mobile2 = mysqli_real_escape_string($con, $row2['mobile_no']);
$alternate_mobile2 = mysqli_real_escape_string($con, $row2['alternate_mobile']);
$contact_person2 = mysqli_real_escape_string($con, $row2['contact_person']);
$city2 = mysqli_real_escape_string($con, $row2['city']);
$address2 = mysqli_real_escape_string($con, $row2['address']);
$country = mysqli_real_escape_string($con, $row2['country']);
}

if(isset($_GET['rm']) && ($_GET['rm']!=='')){
	$msgg =  base64_decode($_GET['rm']);
	if($msgg == 'Register_Form_Agent'){
?>
<div class="col-sm-12 msgss">
	<div class="alert alert-success alert-dismissible" style="margin-top: 6% !important;margin-bottom: -10% !important;">
		<button type="button" class="close" data-dismiss="alert">×</button>
		Successfully Created Your Account.
	</div>
</div>
<?php } } ?>
		
	<div class="col-xs-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4 mt-5">
	<div class="panel panel-default mt-5">
	  <div class="panel-body main-bdy pb-2">
			<form method="post" autocomplete="off">
				<div class="account-wall col-sm-6 offset-sm-3 col-8 offset-2 mb-3 text-center">
					<img class="profile img-fluid" src="../images/hat.png" alt="">
				</div>			  
				<div id="mail-status" style="color:red;"></div>
				<h3 class="text-center mb-4">Login Details</h3>
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>
					<input type="text" id="uname" class="form-control" value="<?php echo $uname2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-user-cog"></i></span>
					<input type="text" id="email" class="form-control" value="<?php echo $email2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-lock"></i></span>
					<input type="text" id="pass" class="form-control" value="<?php echo $pass2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="far fa-envelope"></i></span>
					<input type="text" id="agent_email" class="form-control" value="<?php echo $agent_email2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-phone"></i></span>
					<input type="text" id="mobile" class="form-control" value="<?php echo $mobile2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-phone"></i></span>
					<input type="text" id="alternate_mobile2" class="form-control" value="<?php echo $alternate_mobile2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>
					<input type="text" id="contact_person" class="form-control" value="<?php echo $contact_person2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-map-marker-alt"></i></span>
					<input type="text" id="city" class="form-control" value="<?php echo $city2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-map-marker-alt"></i></span>
					<input type="text" id="address" class="form-control" value="<?php echo $address2; ?>" readonly>
				</div>
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-group">
					<span class="input-group-addon" id="icon"><i class="fas fa-map-marker-alt"></i></span>
					<input type="text" id="country" class="form-control" value="<?php echo $country; ?>" readonly>
				</div>
				</div>
				
				
				
			  </form>
			</div>
		</div>
		</div>	
<?php }else{ 
	header("Location: ../../logout.php");	
 }  
?>
</div>
	</div>
</section>
	
</body>