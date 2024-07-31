<?php
// Agent 1606
ob_start();
include("../db.php");
include("../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../login");
    exit(); 
}
?>

<?php
$sessionid = $_SESSION['sno'];
$qa = "SELECT sno,role,password FROM allusers WHERE sno = '$sessionid'";
$result1sd = mysqli_query($con, $qa);
while($row1 = mysqli_fetch_array($result1sd)){
	$mainloggedid = mysqli_real_escape_string($con, $row1['sno']);
	$role_agent = mysqli_real_escape_string($con, $row1['role']);
	$pswd = mysqli_real_escape_string($con, $row1['password']);	
	
if($role_agent == 'Admin'){
	header("Location: ../backend/application/");
}else{	
?> 

<style>
.setting-form { padding:15px !important;}
.setting-form { padding:20px 50px; border-radius:4px; border-top:4px solid #2c97ea; border-bottom:4px solid #2c97ea;  border-left:1px solid #ccc; border-right:1px solid #ccc; float:left; width:100%;margin-left: 50% !important;}
.setting-form-pswd { font-size:13px; margin:4px 0px; text-align:left; font-weight:600; }
.setting-form-pswd1 input { width:100%; padding:6px 10px; border:1px solid #ddd; border-radius:4px;}
.btn-orange { padding:8px 25px; color:#FFFFFF; background:#ff9600; transition:0.5s; border:0px; margin-right:8px;}
.btn-orange:hover { background: #ff9600; color:#fff;}

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
    padding-left:22px;
    line-height:24px;
    color:#ec3f41;
}
.valid {
    padding-left:22px;
    line-height:24px;
    color:#3a7d34;
}
body {background:url(../images/book.jpg) no-repeat; background-size: cover;}
</style>
<?php 
if(isset($_POST['re_password'])){
	$old_pass=md5(sha1($_POST['old_pass']));
	$new_pass=md5(sha1($_POST['new_pass']));
	$re_pass=md5(sha1($_POST['re_pass']));
	$new_pass_org=$_POST['new_pass'];
	$data_pwd= $pswd;
	if($data_pwd==$old_pass){
	if($new_pass==$re_pass){
		$update_pwd=mysqli_query($con,"UPDATE `allusers` SET  `password` = '$new_pass', `original_pass`='$new_pass_org' WHERE `sno` =$mainloggedid");
		echo "<script>alert('Password Updated Sucessfully'); window.location='../changepassword'</script>";
	}else{
		echo "<script>alert('Your New and Confirm New Password do not match'); window.location='../changepassword'</script>";
	}
	}else{
	   echo "<script>alert('Old password is wrong'); window.location='../changepassword/'</script>";
	}                     
}
?>

 
<body>                        
<section class="container-fluid main-div">        
<div class="container vertical_tab">  
  <div class="row">  
	<div class="col-md-12 col-sm-12 col-lg-10 offset-lg-1">      
	<div class="tab-content">
	<h3><center>Change Password</center></h3>
	<div class="col-sm-12">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
	<div class="setting-form">
        <form method="post" id="chnageform_requried">
		<dl>
			<dt class="setting-form-pswd">
				Old Password
			</dt>
			<dd class="setting-form-pswd1">
				<input type="password" name="old_pass" class="is_require_once" id="opass" placeholder="Old Password..." value="" />
			</dd>
		</dl>
		<dl>
			<dt class="setting-form-pswd">
				New Password
			</dt>
			<dd class="setting-form-pswd1">
				<input type="password" name="new_pass" class="is_require_once" id="password" placeholder="New Password..." />
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
			</dd>
		</dl>
		<dl>
			<dt class="setting-form-pswd">
				Confirm Password
			</dt>
			<dd class="setting-form-pswd1">
				<input type="password" name="re_pass" class="is_require_once" id="cpassword" placeholder="Confirm New Password..." />
				<br><span class="error_cpassword"></span>
			</dd>
		</dl>
 
		<center>
			<input type="submit" class="btn btn-primary submitbtn" value="Change Password" name="re_password" />
		</center>
	</form></div>
	</div>
	<div class="col-sm-3"></div>
	</center>
<style>
.error11{ background-color: #FFAAAA; }
.validError1{ background-color: #fff;}
</style>
<script>   
  $(document).ready(function () {
	$("#chnageform_requried").submit(function () {
		var submit = true;
		$(".is_require_once:visible").each(function(){
			if($(this).val() == '') {
					$(this).addClass('error11');
					submit = false;
			} else {
					$(this).addClass('validError1');
			}
		});
		if(submit == true) {
			return true;        
		} else {
			$('.is_require_once').keyup(function(){
				$(this).removeClass('error11');
			});
			return false;        
		}
	});
	});
  
var passLower;	
var passUpper;	
var passInteger;	
var passSpecial;
var passEight;
$(document).ready(function () {	
	$('#password').keyup(passwordfun);
	$('#cpassword').keyup(cpasswordfun);
});
 
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
		$('.error_cpassword').html("Passwords do not match.").css({"color": "#fff", "right": "69px", "text-align": "center", "top": "4px", "background-color": "#ff8000", "font-size": "12px", "padding": "9px", "border-radius":"5px", "width":"39%","position": "relative", "left": "31%"});
	}else{
		$('.error_cpassword').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
	}
}


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
		$('.error_cpassword').html("Passwords do not match.").css({"color": "#fff", "right": "69px", "text-align": "center", "top": "4px", "background-color": "#ff8000", "font-size": "12px", "padding": "9px", "border-radius":"5px", "width":"39%","position": "relative", "left": "31%"});
		return false;
	}else{
		$('.error_cpassword').html(" ").css({"color": "#fff", "background-color": "#fff", "padding":"0"});
	}
}); 

$('.submitbtn').on('click', function(e){
	var opass = $('#opass').val();
	if(opass == "") {
		$("#opass").addClass('cpasswordad');
		$('.cpasswordad').css({"border":"1px solid red"});
		return false;
    }
}); 	
</script>

	</div>		
      </div>
    </div>
 </div>
 </section>	
<?php } } ?>
</body>