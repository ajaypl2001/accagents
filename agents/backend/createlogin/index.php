<?php 
ob_start();
include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
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
    padding: 12px 15px 12px 45px;
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
.input-field-addon { position: absolute;padding-left: 15px;
}

</style>
<section class="signin-page mt-0 pb-5 container-fluid">
<div class="container">
 <div class="row justify-content-center">
<?php

if($createLogin == '1'){

if(isset($_POST['btnalogin'])){
	$username = mysqli_real_escape_string($con, $_POST['username']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$agent_email = mysqli_real_escape_string($con, $_POST['agent_email']);
	$mobile = $_POST['mobile'];
	$alternate_mobile = $_POST['alternate_mobile'];
	$contact_person = mysqli_real_escape_string($con, $_POST['contact_person']);
	$city = mysqli_real_escape_string($con, $_POST['city']);
	$address = mysqli_real_escape_string($con, $_POST['address']);
	$country = mysqli_real_escape_string($con, $_POST['country']);
	$rand = substr(str_shuffle("1234567890"), 0, 3);
	$rand1 = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1);
	$rand2 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 2);
	$rand3 = substr(str_shuffle("!@#$%&*"), 0, 2);
	$genreator = $rand.''.$rand1.''.$rand2.''.$rand3;
	$total_rand = str_shuffle($genreator);
	$original_pass = $total_rand;
	$password = md5(sha1($total_rand));
	$created = date('Y-m-d H:i:s');	
	 $querysql = "INSERT INTO `allusers` (`role`, `agent_type`, `username`, `email`, `agent_email`, `mobile_no`, `alternate_mobile`, `contact_person`, `address`, `city`,`country`, `password`, `original_pass`,`verifystatus`, `created`) VALUES('Agent', 'normal', '$username', '$email', '$agent_email', '$mobile', '$alternate_mobile', '$contact_person', '$address', '$city','$country', '$password', '$original_pass', '1', '$created')";
	$resldFund = mysqli_query($con, $querysql);
	$last_id = mysqli_insert_id($con);
	$dfdf = "UPDATE `allusers` SET `created_by_id` = '$sessionid1' WHERE `sno` = '$last_id'";
	mysqli_query($con, $dfdf);
	$pmsg = base64_encode('Register_Form_Agent');
	$lastId = base64_encode("$last_id");
	header("Location: ../createlogin/success.php?rm=$pmsg&lid=$lastId");
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
		
	<div class="col-12 col-sm-10 col-md-6 mt-5">
	<div class="card card-default mt-5">
	  <div class="card-body main-bdy pb-2">
			<form method="post" autocomplete="off" class="loginformbtn form-horizontal">
							  
				<div id="mail-status" style="color:red;"></div>
				<h3 class="text-center mb-5">Create Agent Login</h3>
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"><i class="fas fa-user-tie"></i></span>
					<input type="text" name="username" id="username" class="form-control username demoInputBox" placeholder="Enter Agent Name">
				<br><span class="error_username"></span>
				</div>	
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"><i class="fas fa-user-cog"></i></span>
					<input type="text" name="email" id="emailaddress" class="form-control emailaddress demoInputBox" placeholder="Enter Username">
				<br><span class="error_email_address"></span>
				</div>	
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"><i class="far fa-envelope"></i></span>
					<input type="text" name="agent_email" id="agent_email" class="form-control agent_email demoInputBox" placeholder="Enter Email Address">
				<br><span class="error_agent_email"></span>
				</div>	
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"><i class="fas fa-phone"></i></span>
					<input type="text" name="mobile" id="mobile" class="form-control mobile demoInputBox" placeholder="Enter Mobile No.">
				<br><span class="error_mobile"></span>
				</div>	
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"><i class="fas fa-phone"></i></span>
					<input type="text" name="alternate_mobile" id="alternate_mobile" class="form-control alternate_mobile demoInputBox" placeholder="Enter Alternate Mobile No.">
				<br><span class="error_mobile"></span>
				</div>	
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"><i class="fas fa-user"></i></span>
					<input type="text" name="contact_person" id="contact_person" class="form-control contact_person demoInputBox" placeholder="Enter Contact Person">
				<br><span class="error_mobile"></span>
				</div>	
				</div>
					
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"><i class="fas fa-building"></i></span>
					<input type="text" name="city" id="city" class="form-control city demoInputBox" placeholder="Enter City Name">
				<br><span class="error_city"></span>
				</div>	
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"><i class="fas fa-map-marker-alt"></i></span>
					<input type="text" name="address" id="address" class="form-control address demoInputBox" placeholder="Enter Address">
				<br><span class="error_address"></span>
				</div>	
				</div>
				
				<div class="form-group col-sm-12">
				<div class="input-field  d-flex align-items-center">
					<span class="input-field-addon"></span>
					<select name="country" id="country" class="form-control country demoInputBox" required>
					<option value="">Select Country</option>
					<?php $country_res = mysqli_query($con,"SELECT id,countries_name FROM countries ORDER BY countries_name ASC ");
							while($country_row = mysqli_fetch_assoc($country_res)){
								$country = $country_row['countries_name'];
								echo '<option value="'.$country.'">'.$country.'</option>';
							}
					?>
					</select
					
				<br><span class="error_country"></span>
				</div>	
				</div>
				
				<div class="col-sm-12  mt-4 mb-4">
					<input type="submit" name="btnalogin" class="btn btn-lg btn-primary btn-block btnalogin" value="Submit" style="margin-top: 41px;">
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
<script>
var exitEmailId;
var Agent_emailId;
var exitAgntEmailId;
var mobileValid;
var exit_mobile;
$(document).ready(function () {
	$('#emailaddress').keyup(emailfun);
	$('#username').keyup(unamefun);
	$('#agent_email').keyup(agent_emailfun);
	$('#mobile').keyup(mobilefun);
	$('#city').keyup(cityfun);
	$('#contact_person').keyup(contact_personfun);
});

function unamefun(){
	var usernameId = $('#username').val();
	if(usernameId == "") {
		$('.username').css({"border":"1px solid red"});
    } else {
		$('.username').css({"border":"1px solid #CCCCCC"});
	}
}
	
function emailfun(){	
    var varemail = $('#emailaddress').val(); 
    if(varemail == "") {
		$('.emailaddress').css({"border":"1px solid red"});
    } else {
		$('.emailaddress').css({"border":"1px solid #CCCCCC"});
	}	
	
	$.post("../../response.php", {"emailaddress": varemail}, function (d) {
		if (d == true) {
			exitEmailId = '0';
			$('.error_email_address').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
		}
		if (d == false) {
			exitEmailId = '1';
			$('.error_email_address').html("Username already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "text-align": "center", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%", "left": "84px", "top": "38px","float": "left","position":"absolute","z-index": "9"});
		}		
	});	
}


function agent_emailfun(){	
	var agent_email1 = $('#agent_email').val();
	var validformateEmail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;		
	if(agent_email1 == "") {
		$('.agent_email').css({"border":"1px solid red"});
	} else {
		$('.agent_email').css({"border":"1px solid #CCCCCC"});
	}
	if (validformateEmail.test(agent_email1) == false){
		Agent_emailId = '1';
		$('.agent_email').css({"border":"1px solid red"});
		
	}
	if (validformateEmail.test(agent_email1) == true){
		Agent_emailId = '0';
		$('.agent_email').css({"border":"1px solid #CCCCCC"});
	}
	
	$.post("../../response.php", {"agent_email_bk": agent_email1}, function (d) {
		if (d == true) {
			exitAgntEmailId = '0';
			$('.error_agent_email').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
		}
		if (d == false) {
			exitAgntEmailId = '1';
			$('.error_agent_email').html("Email Address already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "text-align": "center", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%", "left": "84px", "top": "38px","float": "left","position":"absolute","z-index": "9"});
		}		
	});
	
}

function mobilefun(){	
	var mobile1 = $('#mobile').val();	
	var validateMobNum = /^\d*(?:\.\d{1,2})?$/;				
	if(mobile1 == "") {
		$('.mobile').css({"border":"1px solid red"});
	} else {
		$('.mobile').css({"border":"1px solid #CCCCCC"});
	}
	if (validateMobNum.test(mobile1) == false){
		mobileValid = '1';
		$('.mobile').css({"border":"1px solid red"});
	}
	if (validateMobNum.test(mobile1) == true){
		mobileValid = '0';
		$('.mobile').css({"border":"1px solid #CCCCCC"});
	}
	
	$.post("../../response.php", {"mobile_bk": mobile1}, function (d) {
		if (d == true) {
			exit_mobile = 0;
			$('.error_mobile').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
		}
		if (d == false) {
			exit_mobile = 1;
			$('.error_mobile').html("Mobile Number already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "text-align": "center", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%", "left": "84px", "top": "38px","float": "left","position":"absolute","z-index": "9"});				
		}
	});	
	
}

function contact_personfun(){	
	var contact_person1 = $('#contact_person').val();
	if(contact_person1 == "") {
		$('.contact_person').css({"border":"1px solid red"});
	} else {
		$('.contact_person').css({"border":"1px solid #CCCCCC"});
	}
}

function cityfun(){	
	var city1 = $('#city').val();
	if(city1 == "") {
		$('.city').css({"border":"1px solid red"});
	} else {
		$('.city').css({"border":"1px solid #CCCCCC"});
	}
}

<!---------Click----------->

$('.btnalogin').on('click', function(e){	
	var username = $('#username').val();
	if(username == "") {
		$('.username').css({"border":"1px solid red"});		
		return false;
    }
});

$('.btnalogin').on('click', function(e){
	var emailId = $('#emailaddress').val();
	if(emailId == "") {
		$('.emailaddress').css({"border":"1px solid red"});
		return false;
    }	
	
	if(exitEmailId == '1'){
		$('.error_email_address').html("Email address already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "left": "87px", "top": "34px", "text-align": "center", "float": "left", "position": "absolute", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%"});
	   return false;
	}
});

$('.btnalogin').on('click', function(e){
	var agent_email2 = $('#agent_email').val();
	if(agent_email2 == "") {
		$('.agent_email').css({"border":"1px solid red"});
		return false;
    }	
	
	if(Agent_emailId == '1'){
		$('.agent_email').css({"border":"1px solid red"});
	   return false;
	}
	
	if(exitAgntEmailId == '1'){
		$('.error_agent_email').html("Email Address already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "text-align": "center", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%", "left": "84px", "top": "38px","float": "left","position":"absolute","z-index": "9"});
	   return false;
	}	
});

$('.btnalogin').on('click', function(e){
	var mobile2 = $('#mobile').val();
	if(mobile2 == "") {
		$('.mobile').css({"border":"1px solid red"});
		return false;
    }	
	
	if(mobileValid == '1'){
		$('.mobile').css({"border":"1px solid red"});
	   return false;
	}
	
	if(exit_mobile == '1'){
		$('.error_mobile').html("Mobile Number already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "text-align": "center", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%", "left": "84px", "top": "38px","float": "left","position":"absolute","z-index": "9"});	
	   return false;
	}	
});

$('.btnalogin').on('click', function(e){	
	var contact_person2 = $('#contact_person').val();
	if(contact_person2 == "") {
		$('.contact_person').css({"border":"1px solid red"});		
		return false;
    }
});

$('.btnalogin').on('click', function(e){	
	var city2 = $('#city').val();
	if(city2 == "") {
		$('.city').css({"border":"1px solid red"});		
		return false;
    }
});	

$('.btnalogin').on('click', function(e){	
	var country = $('#country').val();
	if(country == "") {
		$('.country').css({"border":"1px solid red"});		
		return false;
    }
});
</script>
	
</body>