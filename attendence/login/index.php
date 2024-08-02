<!doctype html>
<?php
ob_start();
session_start();
include("../db.php");

if(isset($_SESSION['sno'])){
    header("Location:../logout.php");
    exit();
}

$protocol3 = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>
<html lang="en">
  <head>
  	<title>Granville College Attendence - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/jquery.min.js"></script>
	
<style type="text/css">
.ftco-section .form-section {
    max-width: 550px;
    margin: 0 auto;
    padding: 70px 50px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 0 35px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 0;
}
	.ftco-section .form-section:before {
    content: "";
    width: 196px;
    height: 50px;
    position: absolute;
    bottom: 0;
    left: 0;
    background: url(../images/img-39.png) top left repeat;
    background-size: cover;
    z-index: -1;
}.ftco-section .form-section:after {
    content: "";
    width: 196px;
    height: 50px;
    position: absolute;
    top: 0;
    right: 0;
    background: url(../images/img-40.png) top left repeat;
    background-size: cover;
    z-index: -1;
}.form-control {
    font-size: 16px;
    outline: none;
    background: #efefef;
    padding: 12px 25px;
    color: #535353;
    height: 60px;
    border-radius: 3px;
    border: 1px solid #efefef;
}.form-section .btnlogin {
    width: 130px !important; 
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    border: none;
    color: #fff;
}

.form-section .btn-md {
    cursor: pointer;
    height: 50px;
    color: #fff;
    padding: 8px 20px 8px 20px;
    font-size: 17px;
    font-weight: 400;
    border-radius: 3px;
}	.ftco-section {  height:100vh !important}
	.form-login{position: relative;
    top: 50%; 
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
}
	@media only screen and (min-device-width:768px){


	.ftco-section { padding:40px 0px;  }}
</style>
</head>
<body style=" background-image: url(../images/aol-bg.png); background-size: cover; background-color:#ccc;" >
<section class="ftco-section">
<div class="container form-login">

<div class="row justify-content-center">
	<div class="col-md-8 col-lg-5">
	<!-- 	<div class="wrap d-md-flex">
		<div class="img" style="background-image: url(../images/bg-1.jpg);">
	  </div> -->
	<div class="bg-white form-section p-4 p-md-5">
		<div class="row justify-content-center">
<div class="col-md-12 text-center">
		<img src="../images/Granville-logo.webp" width="100" alt="Granville-logo">
	</div></div>
		<h3 class="my-4 text-center">SIGN INTO YOUR ACCOUNT</h3>
		<div id="mail-status" style="color:red;"></div>

	
<form action="" method="post" class="loginformbtn signin-form" autocomplete="off">
	<div class="form-group mb-3">
		<label class="label" for="username">Username</label><br>
		<input type="text" name="emailForm" class="form-control emailForm" id="emailForm" placeholder="Username">
		<span id="userEmail-info" class="info"></span>
	</div>
	<div class="form-group mb-3">
		<label class="label" for="password">Password</label><br>
		<input type="password" name="pwdform" class="form-control pwdform" placeholder="Password" id="pwdform">
		<span id="userPass-info" class="info"></span>
	</div>
	<div class="form-group text-end">
		<button type="submit" class="mb-3 btn btn-md btn-success rounded submit  btnlogin">Log In</button>
	</div>
		            
	</form>
	  
	</div>
  </div>
	</div>
</div>
</div>
</section>

<script type="text/javascript">
$(document).ready(function() {
$('.btnlogin').on('click',function (e) {
	 e.preventDefault();
	$('.loading_icon').show();
	var emailForm = $('.emailForm').val();
	var pwdform = $('.pwdform').val();
	
	if(emailForm == "" && pwdform == "") {
		$('.emailForm').css({"border":"1px solid red"});
		$('.pwdform').css({"border":"1px solid red"});
		$('.loading_icon').hide();
		return false;
    } else {
		$('.emailForm').css({"border":"1px solid #CCCCCC"});
		$('.pwdform').css({"border":"1px solid #CCCCCC"});
		$('.loading_icon').hide();
	}
		var $form = $(this).closest(".loginformbtn");
		var formData =  $form.serializeArray();
		var URL = "loginQuery.php";
		$.post(URL, formData).done(function(data) {
		$('.loading_icon').hide();
		if(data == 12341234){		
			// window.location.href = "<?php //echo $protocol3;?>granville-college.com/attendence/lists/module_wise_attendence.php?T3ZlckFsbEVBdHRlbmRhbmNl";
			window.location.href = "<?php echo $protocol3;?>granville-college.com/attendence/lists/module_wise_attendence_new.php?T3ZlckFsbEVBdHRlbmRhbmNl";
			return true;
		}
		else if(data == 12341235){	
			window.location.href = "<?php echo $protocol3;?>granville-college.com/attendence/empDiv/OTLists.php?T3SD3ZlkFsbE";
			return true;
		}
		else if(data == 40003){
			$("#mail-status").html('Your Username and Password is wrong').css({"text-align":"center","color": "white;"});
			return false;
		}
		
		});		
});
});
</script>
</body>
</html>

