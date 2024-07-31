<?php
ob_start();
session_start();
include("../db.php");

if(isset($_SESSION['id'])){
    header("Location:../dashboard");
    exit(); 
}

include("../header.php");
?>
<style>
#pswd_info {
    position:relative;
    top: 9px;
    bottom: -115px\9; /* IE Specific */
    left: 39px;
    width: 89%;
    padding:15px;
    background:#fefefe;
    font-size:.875em;
    border-radius:5px;
    box-shadow:0 1px 3px #ccc;
    border:1px solid #ddd;
}
#pswd_info h4 {
    margin:0 0 10px 0;
    padding:0;
    font-weight:normal;
	font-size: 12px;
}
#pswd_info::before {
    content: "\25B2";
    position:absolute;
    top:-12px;
    left:45%;
    font-size:14px;
    line-height:14px;
    color:#ddd;
    text-shadow:none;
    display:block;
}
.invalid {
    background:url(../images/invalid.png) no-repeat 0 50%;
    padding-left:22px;
    line-height:24px;
    color:#ec3f41;
}
.valid {
    background:url(../images/valid.png) no-repeat 0 50%;
    padding-left:22px;
    line-height:24px;
    color:#3a7d34;
}body { background:url(../images/book.jpg) no-repeat; background-size: cover;  }
</style>

<body>   
<section class="signin-page container-fluid">
<div class="container main-div">
<div class="row centered-form">
<div class="col-xs-12 col-md-12 col-lg-8 offset-lg-2 column">
<?php
	if(isset($_GET['em']) && ($_GET['em']!=='')){
		$msgg =  base64_decode($_GET['em']);
		if($msgg == 'Register_Email'){
	?>
	<div class="col-sm-12 msgss" style="margin-top: 20px;">
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">×</button>
			Your Email Address Already Exists.Please go to login Page!!!
		</div>
	</div>
	<?php }
	if($msgg == 'Register_Passport'){
	?>	
	<div class="col-sm-12 msgss" style="margin-top: 20px;">
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">×</button>
			Your Passport Already Exists!!!
		</div>
	</div>
	<?php } } ?>	


<div class="col-sm-12 header mb-4">
<h3 class="well"><center><b>Enter Your Details</b></center></h3>
</div>
 <form action="../mysqldb.php" method="post" autocomplete="off">
 <div class="col-sm-12">
	<div class="row">
		<div class="col-sm-6 form-group">
			<label>First Name:<span style="color:red;">*</span></label>
			<div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>
			<input type="text" name="fname" id="fname" placeholder="First Name" class="form-control">
			</div>
		</div>
		
		<div class="col-sm-6 form-group">
		  <label>Last Name:<span style="color:red;">*</span></label>
			  <div class="input-group">
				   <span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>
			<input type="text" name="lname" id="lname" placeholder="Last Name" class="form-control">
		</div>
		</div>
		
		<div class="col-sm-6 form-group">
			 <label>Email ID:<span style="color:red;">*</span></label>
			  <div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-envelope"></i></span>
			  <input type="text" name="email" id="emailaddress" placeholder="Email ID" class="form-control">
			  <br><span class="error_email_address"></span>
		</div>	
		</div>
		
		  
		<div class="col-sm-6 form-group">
			<label>Mobile No:<span style="color:red;">*</span></label>
			  <div class="input-group">
		      <span class="input-group-addon" id="icon"><i class="fas fa-mobile"></i></span>
			  <input type="text" name="mobile" id="mobileno" placeholder="Mobile No." class="form-control">
			  <br><span class="error_mobile_no"></span>
		</div>
		</div>
		
		
		 <div class="col-sm-6 form-group">
			<label>Gender:<span style="color:red;">*</span></label>
			<div class="input-group">
			 <span class="input-group-addon" id="icon"><i class="fa fa-venus-mars"></i></span>
			<select name="gender" class="form-control" id="gender">
				<option value="">Select Option</option>
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			</select>
		   </div>
		</div>
		   
	    <div class="col-sm-6 form-group">
			<label>Passport No:<span style="color:red;">*</span></label>
			  <div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-book-open"></i></span>
			<input type="text" name="passport" id="passportno" placeholder="Passport No." class="form-control">
			<br><span class="error_passport"></span>
		</div>
	    </div>
	   
		<div class="col-sm-6 form-group">
			<label>Password:<span style="color:red;">*</span></label>
			<div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-key"></i></span>
			  <input type="password" name="password" id="password" placeholder="Password" class="form-control">
		    </div>
			<div id="pswd_info" style="display:none;">
				<h4>Password following requirements:</h4>
				<ul>
					<li id="letterlower" class="invalid">At least <strong>one letter</strong></li>
					<li id="letterupper" class="invalid">At least <strong>one capital letter</strong></li>
					<li id="numberinteger" class="invalid">At least <strong>one number</strong></li>
					<li id="specialchar" class="invalid">At least <strong>one special charactor</strong></li>
					<li id="lengthword" class="invalid">Be at least <strong>8 characters</strong></li>
				</ul>
			</div>
		</div>
		
		<div class="col-sm-6 form-group">
			<label>Confirm Password:<span style="color:red;">*</span></label>
			  <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-key"></i></span>
			<input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="form-control">
			<br><span class="error_cpassword"></span>
		</div>
		</div><br>
		
		<div class="col-sm-6 offset-sm-3 form-group mt-4">
			<input name="smtbtn" class="btn btn-lg btn-primary btn-block1 submitbtn" type="submit" value="Signup">					
		</div>
   </div>
	</div>
 </form>
</div>
</div>
</div></section>

<script type="text/javascript">
var exitEmailId;
var exitpass;
var mobilevalid;
var matchEmail;
var passLower;	
var passUpper;	
var passInteger;	
var passSpecial;
var passEight;
$(document).ready(function () {
	$('#fname').keyup(firstname);
	$('#lname').keyup(lastname);
	$('#emailaddress').keyup(emailfun);
	$('#mobileno').keyup(mobilefun);
	$('#gender').keyup(genderfun);
	$('#passportno').keyup(passportfun);
	$('#password').keyup(passwordfun);
	$('#cpassword').keyup(cpasswordfun);
});

function firstname(){	
    var fname = $('#fname').val();    
    if(fname == "") {
		$("#fname").addClass('fname');
		$('.fname').css({"border":"1px solid red"});
    } else {
		$('.fname').css({"border":"1px solid #CCCCCC"});
	}
}
function lastname(){	
    var lname = $('#lname').val();    
    if(lname == "") {
		$("#lname").addClass('lname');
		$('.lname').css({"border":"1px solid red"});
    } else {
		$('.lname').css({"border":"1px solid #CCCCCC"});
	}
}
function emailfun(){	
    var varemail = $('#emailaddress').val(); 
	var validformateEmail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(varemail == "") {
		$("#emailaddress").addClass('emailaddress');
		$('.emailaddress').css({"border":"1px solid red"});
    } else {
		$('.emailaddress').css({"border":"1px solid #CCCCCC"});
	}
	
	if (validformateEmail.test(varemail) == false){
		matchEmail = '1';
		$(".error_email_address").html("Not A valid email address!").css({"color": "#fff", "background-color": "#ff8000", "font-size": "12px", "padding": "10px 10px 10px 10px", "border-radius":"5px"});
	   return false;
	}
	
	if (validformateEmail.test(varemail) == true){
		matchEmail = '0';
		$(".error_email_address").html(" ").css({"color": "#fff", "background-color": "#fff",  "padding": "0"});
	}
	
	$.post("../response.php", {"emailaddress": varemail}, function (d) {
		if (d == true) {
			exitEmailId = '0';
			$('.error_email_address').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
		}
		if (d == false) {
			exitEmailId = '1';
			$('.error_email_address').html("Email address already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "left": "87px", "top": "34px", "text-align": "center", "float": "left", "position": "absolute", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%"});
		}		
	});	
}
function mobilefun(){	
    var varmobile = $('#mobileno').val(); 
	var validateMobNum = /^\d*(?:\.\d{1,2})?$/;
    if(varmobile == "") {
		$("#mobileno").addClass('mobileno');
		$('.mobileno').css({"border":"1px solid red"});
    } else {
		$('.mobileno').css({"border":"1px solid #CCCCCC"});
	}
	
	if (validateMobNum.test(varmobile) == false){
		mobilevalid = '1';
		$(".error_mobile_no").html("Not A valid Mobile Number!").css({"color": "#fff", "background-color": "#ff8000", "font-size": "12px", "padding": "10px 10px 10px 10px", "border-radius":"5px"});
	}
	if (validateMobNum.test(varmobile) == true){
		mobilevalid = '0';
		$(".error_mobile_no").html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
	}	
}
function genderfun(){
    var vargender = $('#gender').val();    
    if(vargender == "") {
		$("#gender").addClass('gender');
		$('.gender').css({"border":"1px solid red"});
    } else {
		$('.gender').css({"border":"1px solid #CCCCCC"});
	}
}
function passportfun(){
    var varpassport = $('#passportno').val();    
    if(varpassport == "") {
		$("#passportno").addClass('passportno');
		$('.passportno').css({"border":"1px solid red"});
    } else {
		$('.passportno').css({"border":"1px solid #CCCCCC"});
	}
	
	$.post("../response.php", {"passportno": varpassport}, function (d) {
		if (d == true) {
			exitpass = '0';
			$('.error_passport').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
		}
		if (d == false) {
			exitpass = '1';
			$('.error_passport').html("Passport no already Exists.").css({"color": "#fff", "background-color": "#ff8000", "z-index": "999", "text-align": "center", "left": "86px", "position": "absolute", "float": "left", "top": "34px",  "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%"});
		}
	});
}
		
function passwordfun(){
	var pswd = $('#password').val();
	if(pswd == "") {
		$("#password").addClass('passwordad');
		$('.passwordad').css({"border":"1px solid red"});
    } else {
		$('.passwordad').css({"border":"1px solid #CCCCCC"});
	}	
	
	var lngtcnt = pswd.length;
	$('#pswd_info').show();
	
	var lower_text = new RegExp('[a-z]');
	var upper_text = new RegExp('[A-Z]');
	var number_check = new RegExp('[0-9]');
	var special_char = new RegExp('[!/\'^£$%&*()}{@#~?><>,|=_+¬-\]');
	
	if(pswd.match(lower_text)){	
		passLower='true';
		$('#letterlower').removeClass('invalid').addClass('valid');		
	}else{
		passLower='false';
		$('#letterlower').removeClass('valid').addClass('invalid');
	}		
	
	if(pswd.match(upper_text)){	
		passUpper='true';	
		$('#letterupper').removeClass('invalid').addClass('valid');	
	}else{
		passUpper='false';
		$('#letterupper').removeClass('valid').addClass('invalid');
	}
	
	if(pswd.match(number_check)){	
		passInteger='true';	
		$('#numberinteger').removeClass('invalid').addClass('valid');	
	}else{
		passInteger='false';
		$('#numberinteger').removeClass('valid').addClass('invalid');
	}
	
	if(pswd.match(special_char)){	
		passSpecial='true';	
		$('#specialchar').removeClass('invalid').addClass('valid');	
	}else{
		passSpecial='false';
		$('#specialchar').removeClass('valid').addClass('invalid');
	}
	
	if (lngtcnt >= 8){
		passEight='true';	
		$('#lengthword').removeClass('invalid').addClass('valid');	
	}else{
		passEight='false';
		$('#lengthword').removeClass('valid').addClass('invalid');
	}
}

function cpasswordfun(){
	var matchpass = $('#password').val();
	var cpass = $('#cpassword').val();
	if(cpass == "") {
		$("#cpassword").addClass('cpasswordad');
		$('.cpasswordad').css({"border":"1px solid red"});
    } else {
		$('.cpasswordad').css({"border":"1px solid #CCCCCC"});
	}
	if (matchpass != cpass) {
		$('.error_cpassword').html("Passwords do not match.").css({"color": "#fff", "float": "left", "right": "69px", "text-align": "center", "position": "absolute", "top": "34px", "background-color": "#ff8000", "font-size": "12px", "padding": "10px", "border-radius":"5px", "width":"49%"});
	}else{
		$('.error_cpassword').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
	}
}


<!---- onclick start --->

$('.submitbtn').on('click', function(e){
	var fname = $('#fname').val();
	if(fname == "") {
		$("#fname").addClass('fname');
		$('.fname').css({"border":"1px solid red"});		
		return false;
    }
	
	if(exitpass==1){
		$('.error_passport').html("Passport no already Exists.").css({"color": "#fff", "background-color": "#ff8000", "z-index": "999", "text-align": "center", "left": "86px", "position": "absolute", "float": "left", "top": "34px",  "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%"});
		return false;
	}	
	
	if(exitEmailId==1){
		$('.error_email_address').html("Email address already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "left": "87px", "top": "34px", "text-align": "center", "float": "left", "position": "absolute", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%"});
		return false;
	}
});   
 
	
$('.submitbtn').on('click', function(e){	
	var lname = $('#lname').val();
	if(lname == "") {
		$("#lname").addClass('lname');
		$('.lname').css({"border":"1px solid red"});
		return false;
    }
});	

$('.submitbtn').on('click', function(e){
	var emailId = $('#emailaddress').val();
	if(emailId == "") {
		$("#emailaddress").addClass('emailaddress');
		$('.emailaddress').css({"border":"1px solid red"});
		return false;
    }	
	if(exitEmailId == '1'){
		$('.error_email_address').html("Email address already exist!!!").css({"color": "#fff", "background-color": "#ff8000", "left": "87px", "top": "34px", "text-align": "center", "float": "left", "position": "absolute", "font-size": "12px", "padding": "7px", "border-radius":"5px", "width":"58%"});
	   return false;
	}
	if(matchEmail == '1'){
		$(".error_email_address").html("Not A valid email address!").css({"color": "#fff", "background-color": "#ff8000", "font-size": "12px", "padding": "10px 10px 10px 10px", "border-radius":"5px"});
	   return false;
	}
});

$('.submitbtn').on('click', function(e){	
	var mobilenoId = $('#mobileno').val(); 
	if(mobilenoId == "") {
		$("#mobileno").addClass('mobileno');
		$('.mobileno').css({"border":"1px solid red"});
		return false;
    }
	if(mobilevalid == '1'){
		$(".error_mobile_no").html("Not A valid Mobile Number!").css({"color": "#fff", "background-color": "#ff8000", "font-size": "12px", "padding": "10px 10px 10px 10px", "border-radius":"5px"});
		   return false;
	}
});

$('.submitbtn').on('click', function(e){	
	var genderId = $('#gender').val();
	if(genderId == "") {
		$("#gender").addClass('gender');
		$('.gender').css({"border":"1px solid red"});
		return false;
    }else{
		$("#gender").addClass('gender');
		$('.gender').css({"border":"1px solid #CCCCCC"});
	}
});

$('.submitbtn').on('click', function(e){	
	var passportId = $('#passportno').val(); 
	if(passportId == "") {
		$("#passportno").addClass('passportno');
		$('.passportno').css({"border":"1px solid red"});
		return false;
    }
});		

$('.submitbtn').click(function () {
	var passwordid = $('#password').val(); 
	if(passwordid == "") {
		$("#password").addClass('passwordad');
		$('.passwordad').css({"border":"1px solid red"});
		return false;
    }
	
	if(passLower == 'false'){
		$('#letterlower').removeClass('valid').addClass('invalid');
		return false;
	}	
	if(passUpper == 'false'){
		$('#letterupper').removeClass('valid').addClass('invalid');
		return false;
	}
	if(passInteger == 'false'){
		$('#numberinteger').removeClass('valid').addClass('invalid');
		return false;
	}
	if(passSpecial == 'false'){
		$('#specialchar').removeClass('valid').addClass('invalid');
		return false;
	}
	if(passEight == 'false'){
		$('#lengthword').removeClass('valid').addClass('invalid');
		return false;
	}
});

$('.submitbtn').on('click', function(e){
	var matchpass = $('#password').val();
	var cpass = $('#cpassword').val();	
	if(cpass == "") {
		$("#cpassword").addClass('cpasswordad');
		$('.cpasswordad').css({"border":"1px solid red"});
		return false;
    }
	if (matchpass != cpass) {
		$('.error_cpassword').html("Passwords do not match.").css({"color": "#fff", "float": "left", "right": "69px", "text-align": "center", "position": "absolute", "top": "34px", "background-color": "#ff8000", "font-size": "12px", "padding": "10px", "border-radius":"5px", "width":"49%"});
		return false;
	}else{
		$('.error_cpassword').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
	}
});	

</script>

</body>


