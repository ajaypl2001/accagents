<?php 
ob_start();
session_start();
include("../db.php");

if(isset($_SESSION['sno'])){
    header("Location:../logout.php");
    exit(); 
}
include("../header.php");

$protocol3 = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>

<style>
.msgss .alert.alert-success.alert-dismissible {
    margin-top: 36px;
    margin-bottom: -70px;
    width: 54%;
    margin-left: 22%;
}
/*body {background-image:url(holi.gif); background-size: 100% 100% ; background-position: fixed;     height: 100vh;

}*/
body {background: #ecf0f3;     height: 90vh;
}
   .account-wall img {

    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0px 0px 3px #5f5f5f, 0px 0px 0px 5px #ecf0f3, 8px 8px 15px #a7aaa7, -8px -8px 15px #fff;
}
.card  {  
    /*padding: 40px 30px 30px 30px;*/
    background-color: #ecf0f3;
    border-radius: 15px;
    box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
}
.signin-page .input-field input {
    width: 100%;
    display: block;
    border: none;
    outline: none;
    background: none;
    font-size: 14px;
    color: #666;border-radius: 20px;
    padding: 14px 15px 14px 35px;
    /* border: 1px solid red; */
}.signin-page .input-field {
    /*padding-left: 10px;*/
    margin-bottom: 20px;
    border-radius: 20px;
    box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
}
.form-control:focus {
    border: 0px !important;
    outline:  0px !important;
    box-shadow: 0px !important;
}
.input-field-addon { position: absolute;padding-left: 10px;
}
.signin-page
{top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    position: relative;
}
 
</style>
<body>
<div class="loading_icon" style="display:none;"></div> 
<section class="signin-page container-fluid">
<div class="container">
 <div class="row justify-content-center">
 
	<?php
	if(isset($_GET['rm']) && ($_GET['rm']!=='')){
		$msgg =  base64_decode($_GET['rm']);
		if($msgg == 'Register_Form'){
	?>
	<div class="col-sm-12 msgss">
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>Success!</strong> You have Successfully register!!!
		</div>
	</div>
	<?php } } ?>
	<?php 
	if(isset($_GET['vm']) && ($_GET['vm']!=='')){
		$msgg1 =  $_GET['vm'];
		if($msgg1 == 'success'){
	?>
	<div class="col-sm-12 msgss">
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">×</button>
			Your Email Address Successfully Activated.
		</div>
	</div>
	<?php } } ?>
	
	<div class="col-12 col-sm-10 col-md-6 col-xl-5">
	<div class="card card-default">
	  <div class="card-body main-bdy pb-2">
			<!--form name="login" class="login" action="" method="post" -->
			<form action="" method="post" class="loginformbtn form-horizontal" autocomplete="off">	
			<div class="account-wall  mb-3 text-center">
			   <img class="profile img-fluid" src="../images/logo-img.png" width="110" alt="">
			  </div>
			  
				<div id="mail-status" style="color:red;"></div>
			   <h3 class="text-center mb-4">Login to continue !</h3>
				<div class="form-group col-sm-12 mt-1">
					<div class="input-field  d-flex align-items-center">
					 <span class="input-field-addon"><i class="fas fa-user"></i></span>
					  <input type="text" name="emailForm" id="emailForm" class="form-control emailForm" placeholder="Email Address">
					</div>	
					<span id="userEmail-info" class="info"></span>
				</div>
				<div class="form-group col-sm-12">
					<div class="input-field  d-flex align-items-center">
					 <span class="input-field-addon"><i class="fas fa-lock"></i></span>
						<input type="password" name="pwdform" id="pwdform" class="form-control pwdform" placeholder="Password">		
					</div>
					<span id="userPass-info" class="info"></span>		
				</div>
				<div class="col-sm-12  mt-4 mb-4">
				<button class="btn btn-lg btn-primary btn-block btnlogin" type="submit">Login</button>
				</div>
			  </form>
			</div>
		</div>
		</div>
	</div>
	</div></section>


<script type="text/javascript">
$(document).ready(function() {
$('.btnlogin').on('click',function (e) {
	 e.preventDefault();
	$('.loading_icon').show();
	var emailForm = $('.emailForm').val();
	var pwdform = $('.pwdform').val();
	
	if(emailForm == "" && pwdform == "") {
		$('.emailForm').css({"border-bottom":"1px solid red"});
		$('.pwdform').css({"border-bottom":"1px solid red"});
		$('.loading_icon').hide();
		return false;
    } else {
		$('.emailForm').css({"border-bottom":"1px solid #CCCCCC"});
		$('.pwdform').css({"border-bottom":"1px solid #CCCCCC"});
		$('.loading_icon').hide();
	}
		var $form = $(this).closest(".loginformbtn");
		var formData =  $form.serializeArray();
		var URL = "loginquery.php";
		$.post(URL, formData).done(function(data) {
		$('.loading_icon').hide();
		if(data == "bkdb"){
			window.location.href = "<?php echo $protocol3;?>localhost/accagents/backend/application/";
		} 
		else if(data == "urldashboard"){
			window.location.href = "<?php echo $protocol3;?>localhost/accagents/application/";		
		}
		else if(data == "clg"){
			window.location.href = "<?php echo $protocol3;?>localhost/accagents/backend/collegeStart/index.php";		
		}  
		else if(data == "studenturl"){
			window.location.href = "<?php echo $protocol3;?>localhost/accagents/application/";
		}
		else if(data == "report"){
			window.location.href = "<?php echo $protocol3;?>localhost/accagents/backend/report/vgrapplication.php";
		}
		else if(data == "403"){
			// alert('Your Email Address and Password is wrong');
			$("#mail-status").html('Your Email Address and Password is wrong').css({"margin-left":"4%","font-weight": "bold"});
			return false;
		}
		
		});		
});
});
</script>	
	
	
	
</body>