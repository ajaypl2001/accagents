<?php
ob_start();
include("../db.php");
include("../header_navbar.php");

date_default_timezone_set("Asia/Kolkata");
$crnt_year = date('Y');

if(!isset($_SESSION['sno'])){
    header("Location: ../login");
    exit(); 
}
if(isset($_GET['pt']) && ($_GET['pt']!=='')){
	$name_redirect =  base64_decode($_GET['pt']);
if($name_redirect == "Academic-Details"){ 
?>
<script>
 $(document).ready(function(){
    $('#Personal-Details').hide();
    $('#Academic-Details').show();
	$('#Academic-Details-Docs').hide();
    $('#Course-Details').hide();
    $('#Application-Details').hide();
	$('.add_academic').addClass("academic_class");
	$('.academic_class').css("background-color", "#114663").css("color","#FFF");
	$('.personal_class').css("background-color", "#fff").css("color","#333");
	$('.course_class').css("background-color", "#fff").css("color","#333");
	$('.document_class').css("background-color", "#fff").css("color","#333");
	$('.academic_class_doc').css("background-color", "#fff").css("color","#333");
 });
</script>
<?php } if($name_redirect == "Academic-Details-Docs"){ ?>
<script> 
$(document).ready(function(){
	$('#Personal-Details').hide();
	$('#Academic-Details').hide();
	$('#Academic-Details-Docs').show();
	$('#Course-Details').hide();
	$('#Application-Details').hide();
	$('.add_academic_doc').addClass("academic_class_doc");
	$('.academic_class_doc').css("background-color", "#114663").css("color","#FFF");
	$('.personal_class').css("background-color", "#fff").css("color","#333");
	$('.course_class').css("background-color", "#fff").css("color","#333");
	$('.document_class').css("background-color", "#fff").css("color","#333");
	$('.academic_class').css("background-color", "#fff").css("color","#333"); });
</script>
<?php } 
if($name_redirect == "Course-Details"){ ?>
<script>
 $(document).ready(function(){
   $('#Personal-Details').hide();
    $('#Academic-Details').hide();
	$('#Academic-Details-Docs').hide();
    $('#Course-Details').show();
    $('#Application-Details').hide();
	$('.add_course').addClass("course_class");
	$('.course_class').css("background-color", "#114663").css("color","#FFF");
	$('.personal_class').css("background-color", "#fff").css("color","#333");
	$('.academic_class').css("background-color", "#fff").css("color","#333");
	$('.document_class').css("background-color", "#fff").css("color","#333");
	$('.academic_class_doc').css("background-color", "#fff").css("color","#333");
 });
</script>
<?php } if($name_redirect == "Application-Details"){ ?>
 <script>
 $(document).ready(function(){
   $('#Personal-Details').hide();
    $('#Academic-Details').hide();
	$('#Academic-Details-Docs').hide();
    $('#Course-Details').hide();
    $('#Application-Details').show();
	$('.add_document').addClass("document_class");
	$('.document_class').css("background-color", "#114663").css("color","#FFF");
	$('.personal_class').css("background-color", "#fff").css("color","#333");
	$('.academic_class').css("background-color", "#fff").css("color","#333");
	$('.course_class').css("background-color", "#fff").css("color","#333");
	$('.academic_class_doc').css("background-color", "#fff").css("color","#333");
 });
</script>
<?php } } else{ ?>
<script>
 $(document).ready(function(){
    $('#Personal-Details').show();
    $('#Academic-Details').hide();
	$('#Academic-Details-Docs').hide();
	$('#Course-Details').hide();
    $('#Application-Details').hide();
	$('.add').addClass("personal_class");
	$('.personal_class').css("background-color", "#114663").css("color","#FFF");
	$('.academic_class').css("background-color", "#fff").css("color","#333");
	$('.course_class').css("background-color", "#fff").css("color","#333");
	$('.document_class').css("background-color", "#fff").css("color","#333");
	$('.academic_class_doc').css("background-color", "#fff").css("color","#333");
 });
</script> 
<?php } ?>

<script>
$(document).ready(function(){
$('#show_personal_details').click(function(){
  $('#Personal-Details').show();	
  $('#Academic-Details').hide();
  $('#Academic-Details-Docs').hide();
  $('#Course-Details').hide();
  $('#Application-Details').hide();
  $('.add').addClass("personal_class");
  $('.personal_class').css("background-color", "#114663").css("color","#FFF");
  $('.academic_class').css("background-color", "#fff").css("color","#333");
  $('.course_class').css("background-color", "#fff").css("color","#333");
  $('.document_class').css("background-color", "#fff").css("color","#333");
  $('.academic_class_doc').css("background-color", "#fff").css("color","#333");
});
$('#show_acedmic_details').click(function(){
  $('#Personal-Details').hide();
  $('#Academic-Details').show();
  $('#Academic-Details-Docs').hide();
  $('#Course-Details').hide();
  $('#Application-Details').hide();
  $('.add_academic').addClass("academic_class");
  $('.academic_class').css("background-color", "#114663").css("color","#FFF");
  $('.personal_class').css("background-color", "#fff").css("color","#333");
  $('.course_class').css("background-color", "#fff").css("color","#333");
  $('.document_class').css("background-color", "#fff").css("color","#333");
  $('.academic_class_doc').css("background-color", "#fff").css("color","#333");
});

$('#show_acedmic_details_doc').click(function(){
	$('#Personal-Details').hide();
	$('#Academic-Details').hide();
	$('#Academic-Details-Docs').show();
	$('#Course-Details').hide();
	$('#Application-Details').hide();
	$('.add_academic_doc').addClass("academic_class_doc");
	$('.academic_class_doc').css("background-color", "#114663").css("color","#FFF");
	$('.personal_class').css("background-color", "#fff").css("color","#333");
	$('.course_class').css("background-color", "#fff").css("color","#333");
	$('.document_class').css("background-color", "#fff").css("color","#333");
	$('.academic_class').css("background-color", "#fff").css("color","#333");
});

$('#show_course_details').click(function(){
  $('#Personal-Details').hide();
  $('#Academic-Details').hide();
  $('#Academic-Details-Docs').hide();
  $('#Course-Details').show();
  $('#Application-Details').hide();
  $('.add_course').addClass("course_class");
  $('.course_class').css("background-color", "#114663").css("color","#FFF");
  $('.personal_class').css("background-color", "#fff").css("color","#333");
  $('.academic_class').css("background-color", "#fff").css("color","#333");
  $('.document_class').css("background-color", "#fff").css("color","#333");
  $('.academic_class_doc').css("background-color", "#fff").css("color","#333");
});

$('#show_docs_details').click(function(){
  $('#Personal-Details').hide();
  $('#Academic-Details').hide();
  $('#Academic-Details-Docs').hide();
  $('#Course-Details').hide();
  $('#Application-Details').show();
  $('.add_document').addClass("document_class");
  $('.document_class').css("background-color", "#114663").css("color","#FFF");
  $('.personal_class').css("background-color", "#fff").css("color","#333");
  $('.academic_class').css("background-color", "#fff").css("color","#333");
  $('.course_class').css("background-color", "#fff").css("color","#333");
  $('.academic_class_doc').css("background-color", "#fff").css("color","#333");
});
});

</script>
<?php
	$cntList11 = mysqli_query($con, "Select countries_name from countries");
	$cntList1 = mysqli_query($con, "Select countries_name from countries");
	$cntList2 = mysqli_query($con, "Select countries_name from countries");
	$cntList3 = mysqli_query($con, "Select countries_name from countries");
?>  
<style>.btn-download { padding:0px 10px; height:25px; line-height:22px;font-size:13px;}
.error_color{border:1px solid #de0e0e;}
.validError{border:1px solid #ccc;}

.modalStatus {
	display: none;
	position: fixed;
	z-index: 9;
	padding-top: 100px;
	left: 0;
	top: 0;
	width: 100%; 
	height: 100%; 
	overflow: auto; 
	background-color: rgb(0,0,0); 
	background-color: rgba(0,0,0,0.4); 
}
.modal-contentStatus {
	position: relative;
	background-color: #fefefe;
	margin: auto;
	padding: 0;
	border: 1px solid #888;
	width: 25% !important;
	box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
	-webkit-animation-name: animatetop;
	-webkit-animation-duration: 0.4s;
	animation-name: animatetop;
	animation-duration: 0.4s
}
@-webkit-keyframes animatetop {
	from {top:-300px; opacity:0} 
	to {top:0; opacity:1}
}

@keyframes animatetop {
	from {top:-300px; opacity:0}
	to {top:0; opacity:1}
}
.modal-headerStatus {
	padding: 2px 16px;
	background-color: #5cb85c;
	color: white;
}

.modal-bodyStatus {
	padding: 14px 25px;
	font-size: 16px;
	font-weight: bold;
}
.closeStatus {
	color: white;
	float: right;
	font-size: 30px;
	font-weight: bold;
	padding-top: 8px;
}

.closeStatus:hover,
.closeStatus:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
}
.closeacademicStatus {
	color: white;
	float: right;
	font-size: 30px;
	font-weight: bold;
	padding-top: 0px;
}

.closeacademicStatus:hover,
.closeacademicStatus:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
}
.close_uploadDoc_Status {
	color: white;
	float: right;
	font-size: 30px;
	font-weight: bold;
	padding-top: 0px; }
.close_uploadDoc_Status:hover,
.close_uploadDoc_Status:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
}
button.btn.btn-primary.btn-sm {
    float: right;
    margin-bottom: 91px;
	width: 33%;
}          
.alertdiv {
    margin-top: 10%;
    margin-bottom: -8%;
}
</style>
<?php $getsno = base64_decode($_GET['apid']); ?>   
<?php if(!empty($_GET['msgagree'])){
	$mssg =  base64_decode($_GET['msgagree']);
	if($mssg == 'ImageAgreementUpload'){ 
?>
	<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'File is not Supported (Please upload the PDF or ZIP File)'; ?>
		</div>
    </div>     
<?php }
if($mssg == 'ImageSizeAgreementUpload'){
	$getsize = $_GET['mb'];
?>	
<div class='alertdiv'>
		<div class='alert alert-danger' style="text-align:center;">
			<?php echo 'File too large. File must be less than '.$getsize.' megabytes.'; ?>
		</div>
    </div>
<?php } } ?>			
<script src="../document.js"></script>

<link rel="stylesheet" href="../calling_code/node_modules/intl-tel-input/build/css/intlTelInput.css">

<?php 
	$result = mysqli_query($con,"SELECT * FROM st_application WHERE sno = '$getsno'"); 
	$row = mysqli_fetch_assoc($result);
	 $insertid = mysqli_real_escape_string($con, $row['sno']);
	 
	 $app_show = mysqli_real_escape_string($con, $row['app_show']);
	 $user_id = mysqli_real_escape_string($con, $row['user_id']);
	 
	 $fname = mysqli_real_escape_string($con, $row['fname']);
	 $lname = mysqli_real_escape_string($con, $row['lname']);
	 $mobile = mysqli_real_escape_string($con, $row['mobile']);
	 
	 $calling_code = mysqli_real_escape_string($con, $row['calling_code']);
	$calling_cntry_code2 = mysqli_real_escape_string($con, $row['calling_cntry_code']);
	if(empty($calling_cntry_code2)){
	$calling_cntry_code = '';
	}else{
	$calling_cntry_code = $calling_cntry_code2;
	}
	 
	 $email_address = mysqli_real_escape_string($con, $row['email_address']);
	 $gender = mysqli_real_escape_string($con, $row['gender']);
	 $gtitle = mysqli_real_escape_string($con, $row['gtitle']);
	 $martial_status = mysqli_real_escape_string($con, $row['martial_status']);
	 $passport_no = mysqli_real_escape_string($con, $row['passport_no']);
	 $pp_issue_date = mysqli_real_escape_string($con, $row['pp_issue_date']);
	 $pp_expire_date = mysqli_real_escape_string($con, $row['pp_expire_date']);
	 $dob = mysqli_real_escape_string($con, $row['dob']);
	 $cntry_brth = mysqli_real_escape_string($con, $row['cntry_brth']);
	 $address1 = mysqli_real_escape_string($con, $row['address1']);
	 $address2 = mysqli_real_escape_string($con, $row['address2']);
	 $on_off_shore = mysqli_real_escape_string($con, $row['on_off_shore']);
	 $country = mysqli_real_escape_string($con, $row['country']);
	 $state = mysqli_real_escape_string($con, $row['state']);
	 $city = mysqli_real_escape_string($con, $row['city']);
	 $pincode = mysqli_real_escape_string($con, $row['pincode']);
	 $idproof = mysqli_real_escape_string($con, $row['idproof']);
	 
	 $personal_status = mysqli_real_escape_string($con, $row['personal_status']);
	 $academic_status = mysqli_real_escape_string($con, $row['academic_status']);
     $course_status = mysqli_real_escape_string($con, $row['course_status']);
     $application_form = mysqli_real_escape_string($con, $row['application_form']);
	 
	 $englishpro = mysqli_real_escape_string($con, $row['englishpro']);
	 if($englishpro == 'ielts'){
		$ieltsover = mysqli_real_escape_string($con, $row['ieltsover']);
		$ieltsnot = mysqli_real_escape_string($con, $row['ieltsnot']);
		$ielts_listening = mysqli_real_escape_string($con, $row['ielts_listening']);
		$ielts_reading = mysqli_real_escape_string($con, $row['ielts_reading']);
		$ielts_writing = mysqli_real_escape_string($con, $row['ielts_writing']);
		$ielts_speaking = mysqli_real_escape_string($con, $row['ielts_speaking']);
		$ielts_date = mysqli_real_escape_string($con, $row['ielts_date']);
		$ielts_file = mysqli_real_escape_string($con, $row['ielts_file']);
	}else{
		$ieltsover = '';
		$ieltsnot = '';
		$ielts_listening = '';
		$ielts_reading = '';
		$ielts_writing = '';
		$ielts_speaking = '';
		$ielts_date = '';
		$ielts_file = '';
	}
	 
	if($englishpro == 'Toefl'){
		$Toeflover = mysqli_real_escape_string($con, $row['ieltsover']);
		$Toeflnot = mysqli_real_escape_string($con, $row['ieltsnot']);
		$Toefl_listening = mysqli_real_escape_string($con, $row['ielts_listening']);
		$Toefl_reading = mysqli_real_escape_string($con, $row['ielts_reading']);
		$Toefl_writing = mysqli_real_escape_string($con, $row['ielts_writing']);
		$Toefl_speaking = mysqli_real_escape_string($con, $row['ielts_speaking']);
		$Toefl_date = mysqli_real_escape_string($con, $row['ielts_date']);
		$Toefl_file = mysqli_real_escape_string($con, $row['ielts_file']);
	}else{
		$Toeflover = '';
		$Toeflnot = '';
		$Toefl_listening = '';
		$Toefl_reading = '';
		$Toefl_writing = '';
		$Toefl_speaking = '';
		$Toefl_date = '';
		$Toefl_file = '';
	} 
	 
	 $pteover = mysqli_real_escape_string($con, $row['pteover']);
	 $ptenot = mysqli_real_escape_string($con, $row['ptenot']);
	 $pte_listening = mysqli_real_escape_string($con, $row['pte_listening']);
	 $pte_reading = mysqli_real_escape_string($con, $row['pte_reading']);
	 $pte_writing = mysqli_real_escape_string($con, $row['pte_writing']);
	 $pte_speaking = mysqli_real_escape_string($con, $row['pte_speaking']);
	 $pte_date = mysqli_real_escape_string($con, $row['pte_date']);
	 $pte_file = mysqli_real_escape_string($con, $row['pte_file']);
	 $pte_username = mysqli_real_escape_string($con, $row['pte_username']);
	 $pte_password = mysqli_real_escape_string($con, $row['pte_password']);
	 
	 $duolingo_score = mysqli_real_escape_string($con, $row['duolingo_score']);
	 $duolingo_date = mysqli_real_escape_string($con, $row['duolingo_date']);
	 $duolingo_file = mysqli_real_escape_string($con, $row['duolingo_file']);
	 
     $qualification1 = mysqli_real_escape_string($con, $row['qualification1']);
     $stream1 = mysqli_real_escape_string($con, $row['stream1']);
     $passing_year1 = mysqli_real_escape_string($con, $row['passing_year1']);
     $marks1 = mysqli_real_escape_string($con, $row['marks1']);
     $unicountry1 = mysqli_real_escape_string($con, $row['unicountry1']);
     $certificate1 = mysqli_real_escape_string($con, $row['certificate1']);
	 $qualification2 = mysqli_real_escape_string($con, $row['qualification2']);
     $stream2 = mysqli_real_escape_string($con, $row['stream2']);
     $passing_year2 = mysqli_real_escape_string($con, $row['passing_year2']);
     $marks2 = mysqli_real_escape_string($con, $row['marks2']);
     $unicountry2 = mysqli_real_escape_string($con, $row['unicountry2']);
     $certificate2 = mysqli_real_escape_string($con, $row['certificate2']);
	 
	 $qualification3 = mysqli_real_escape_string($con, $row['qualification3']);
     $stream3 = mysqli_real_escape_string($con, $row['stream3']);
     $passing_year3 = mysqli_real_escape_string($con, $row['passing_year3']);
     $marks3 = mysqli_real_escape_string($con, $row['marks3']);
     $unicountry3 = mysqli_real_escape_string($con, $row['unicountry3']);
     $certificate3 = mysqli_real_escape_string($con, $row['certificate3']);
	 
	$passing_year_gap = mysqli_real_escape_string($con, $row['passing_year_gap']);
	$passing_justify_gap = mysqli_real_escape_string($con, $row['passing_justify_gap']);
	$gap_duration = mysqli_real_escape_string($con, $row['gap_duration']);
	$gap_other = mysqli_real_escape_string($con, $row['gap_other']);
	 
     $campus = mysqli_real_escape_string($con, $row['campus']);
     $prg_name1 = mysqli_real_escape_string($con, $row['prg_name1']);
     $prg_intake = mysqli_real_escape_string($con, $row['prg_intake']);    
	 
     $uni_name1 = mysqli_real_escape_string($con, $row['uni_name1']);    
     $uni_name2 = mysqli_real_escape_string($con, $row['uni_name2']);    
     $uni_name3 = mysqli_real_escape_string($con, $row['uni_name3']);
		
	 $mother_father_select = mysqli_real_escape_string($con, $row['mother_father_select']);   
     $mother_father_name = mysqli_real_escape_string($con, $row['mother_father_name']);   
     $emergency_contact_no = mysqli_real_escape_string($con, $row['emergency_contact_no']);
	 
	 $emg_cc = mysqli_real_escape_string($con, $row['emg_cc']);
	$emg_cnty_c2 = mysqli_real_escape_string($con, $row['emg_cnty_c']);
	if(empty($emg_cnty_c2)){
		$emg_cnty_c = '';
	}else{
		$emg_cnty_c = $emg_cnty_c2;
	}
	$cgpa_prcntge1 = $row['cgpa_prcntge1'];
	$cgpa_prcntge2 = $row['cgpa_prcntge2'];
	$cgpa_prcntge3 = $row['cgpa_prcntge3'];
?>
				
<div class="main-div">           
<div class="container vertical_tab">  
  <div class="row">  
	<div class="col-md-12 col-lg-10 offset-lg-1"> 
	<ul class="nav nav-tabs nav-justified">		
		<li><span class="btn add" id="show_personal_details"><span class="fas fa-user"></span> <span class="mb-hide">Personal Details</span></span></li>
		<?php if(($personal_status == '1')){ ?>
			<li>
			<span class="btn add_academic" id="show_acedmic_details">
			<span class="fas fa-university"></span> <span class="mb-hide"> Academic Details</span></span>
			</li>
			<li>
			<span class="btn add_academic_doc" id="show_acedmic_details_doc">
			<i class="fas fa-upload"></i> <span class="mb-hide">Upload Docs</span>				</span>
			</li>
		<?php } else { ?>
           <li><span class="btn" id="profileStatus<?php echo $sessionid1;?>" style="color: #fff;background:#da5d5d;"><span class="mb-hide">Academic Details</span></span>
		   </li>
		   <li>
		   <span class="btn" style="color: #fff;background:#da5d5d;">
		   <i class="fas fa-upload"></i> <span class="mb-hide">Upload Docs</span></span>
		   </li>
        <?php } 
		if(($personal_status == '1') && ($idproof !== '') && ($academic_status ==1) && ($ielts_file !== '' || $Toefl_file !== '' || $pte_file !== '' || $duolingo_file !== '') && ($certificate1 !== '')){ ?>
			<li>
			<span class="btn add_course" id="show_course_details"><span class="fas fa-book"></span> <span class="mb-hide"> Choose Course</span></span>
			</li>
		   <?php } else { ?>
           <li><span class="btn" id="academicStatus<?php echo $sessionid1;?>" style="color: #fff;background:#da5d5d;"><span class="fas fa-book"></span> <span class="mb-hide"> Choose Course</span></span></li>
        <?php } 
		if(($personal_status == '1') && ($idproof !== '') && ($academic_status ==1) && ($certificate1 !== '') && ($ielts_file !== '' || $Toefl_file !== '' || $pte_file !== '' || $duolingo_file !== '') && ($course_status ==1)){ ?>
			<li>
			<span class="btn add_document" id="show_docs_details">
			<span class="fas fa-upload"></span><span class="mb-hide"> Submit Form</span></span>
			</li>
		<?php } else { ?>
           <li><span class="btn" id="uploadDocument_status<?php echo $sessionid1;?>" style="color: #fff;background:#da5d5d;"><span class="fas fa-upload"></span> <span class="mb-hide">Submit Form</span></span></li>
        <?php } ?>		
    </ul> 
          
<!---Personal Deatails Starting--->       
<div class="tab-content">
<div id="Personal-Details">
<form action="../mysqldb.php" method="post" autocomplete="off" enctype="multipart/form-data" id="firsttab_requried">
<div class="col-sm-12">
<h3 class="folded"><center><b>Enter Your Personal Details</b></center></h3>
</div>
<div class="col-sm-12">
	<div class="row">
	
	<div class="col-sm-4 form-group">
		<label>Student Status :<span style="color:red;">*</span></label>
		 <div class="input-group">
			<select name="on_off_shore" class="form-control is_require">
				<option value="">Select Option</option>
				<option value="Onshore" <?php if($on_off_shore == "Onshore") { echo 'selected="selected"'; } ?>>Onshore</option>
				<option value="Offshore" <?php if($on_off_shore == "Offshore") { echo 'selected="selected"'; } ?>>Offshore</option>
			</select>
		</div>
	</div>
	
	<?php
	$results = mysqli_query($con, "SELECT created_by_id FROM allusers WHERE sno='$sessionid1'");
	$rows = mysqli_fetch_assoc($results);
	$createdById = mysqli_real_escape_string($con, $rows['created_by_id']);
	
	$qrySelfAgent = "SELECT allusers.sno, allusers.created_by_id, admin_access.name FROM `allusers` INNER JOIN admin_access ON admin_access.admin_id=allusers.created_by_id where allusers.created_by_id='$createdById'";
	$resultSelfAgent = mysqli_query($con, $qrySelfAgent);
	if(mysqli_num_rows($resultSelfAgent)){
	?>
	<div class="col-sm-4 form-group">
		<label>Marketing Manager:</label>		 
	<?php
		$rowsSelfAgentName = mysqli_fetch_assoc($resultSelfAgent);
		$agentSelfName = $rowsSelfAgentName['name'];
	?>
	<input type="text" name="app_show" class="form-control" value="<?php echo $agentSelfName; ?>" disabled>	
	</div>
	<?php 
	}else{
	?>
	<input type="hidden" name="app_show" value="<?php echo $app_show; ?>">
	<?php } ?>
	
	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">	
	
		<div class="col-sm-4 form-group">
			<label>Title:<span style="color:red;">*</span></label>
 <div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fab fa-osi"></i></span>
			  <select name="gtitle" class="form-control is_require">
				<option value="">Title</option>
				<option value="Mr" <?php if($gtitle == "Mr") { echo 'selected="selected"'; } ?>>Mr</option>
				<option value="Miss" <?php if($gtitle == "Miss") { echo 'selected="selected"'; } ?>>Miss</option>
				<option value="Mrs" <?php if($gtitle == "Mrs") { echo 'selected="selected"'; } ?>>Mrs</option>
				<option value="Ms" <?php if($gtitle == "Ms") { echo 'selected="selected"'; } ?>>Ms</option>
			</select>
			</div>
		</div>
		<div class="col-sm-4 form-group">
			<label>First Name(as per passport):<span style="color:red;">*</span></label>
			 <div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>			  
			  <input type="text" name="fname" placeholder="First Name" class="form-control is_require" value="<?php echo $fname;?>">
			</div>
		</div>
		
		<div class="col-sm-4 form-group">
			<label>Last Name(as per passport):</label>
			 <div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>
			<input type="text" name="lname" placeholder="Last Name" class="form-control" value="<?php echo $lname;?>">
		</div>
		</div>
		
		<div class="col-sm-4 form-group">
			<label>Mobile No:<span style="color:red;">*</span></label>
			 <div class="input-group ccCode">
				<span class="input-group-addon" id="icon"><i class="fas fa-mobile"></i></span>
				<input id="dialCode" type="text" name="mobile" class="form-control is_require" value="<?php echo $mobile;?>" title="Please enter valid number" required>
				
				<input type="hidden" name="calling_code" class="calling_code" value="<?php echo $calling_code; ?>">
				<input type="hidden" name="calling_cntry_code" class="calling_cntry_code" value="<?php echo $calling_cntry_code; ?>">
		</div>
		</div>
	
	<div class="col-sm-4 form-group">
		<label>Student's Email ID:<span style="color:red;">*</span></label>
		 <div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-envelope"></i></span>
			<input type="text" name="email" placeholder="Email ID" class="form-control" value="<?php echo $email_address;?>">
		</div>	
	   </div>
		
		<div class="col-sm-4 form-group">
			<label>Martial Status:<span style="color:red;">*</span></label>
			<div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-handshake"></i></span>
			<select name="martial_status" class="form-control is_require">
				<option value="">Martial Status</option>
				<option value="Married" <?php if($martial_status == "Married") { echo 'selected="selected"'; } ?>>Married</option>
				<option value="Single" <?php if($martial_status == "Single") { echo 'selected="selected"'; } ?>>Single</option>
				<option value="Divorced" <?php if($martial_status == "Divorced") { echo 'selected="selected"'; } ?>>Divorced</option>
			</select>
			</div>
		</div>
		
		<div class="col-sm-4 form-group">
			<label>Gender:<span style="color:red;">*</span></label>
			<div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-venus-mars"></i></span>
			<select name="gender" class="form-control is_require">
				<option value="">Select Option</option>
				<option value="Male" <?php if($gender == "Male") { echo 'selected="selected"'; } ?>>Male</option>
				<option value="Female" <?php if($gender == "Female") { echo 'selected="selected"'; } ?>>Female</option>
			</select>
			</div>
		</div>
						
	 <div class="col-sm-4 form-group">
		<label>Date Of Birth:<span style="color:red;">*</span></label>
		 <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="text" name="dob" class="form-control datepicker123 is_require" placeholder="DD/MM/YYY" value="<?php echo $dob;?>">
		</div>
	</div>
	
	<div class="col-sm-4 form-group">
	<label>Mother/Father Name:<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-globe"></i></span>
		<select name="mother_father_select" class="form-control is_require mother_father_select">
		<option value="">Select Option</option>
		<option value="Mother" <?php if($mother_father_select == "Mother") { echo 'selected="selected"'; } ?>>Mother Name</option>
		<option value="Father" <?php if($mother_father_select == "Father") { echo 'selected="selected"'; } ?>>Father Name</option>		 
		</select>
	</div>
	</div>
	
	<?php if($mother_father_select == 'Mother'){
		$mother_nameDiv = 'display:block;';
		$father_nameDiv = 'display:none;';
	}
	if($mother_father_select == 'Father'){
		$mother_nameDiv = 'display:none;';
		$father_nameDiv = 'display:block;';
	}
	if($mother_father_select == ''){
		$mother_nameDiv = 'display:none;';
		$father_nameDiv = 'display:none;';
	} ?>
	
	<div class="col-sm-4 form-group mother_nameDiv" style="<?php echo $mother_nameDiv; ?>">
		<label>Mother Name:<span style="color:red;">*</span></label>
		 <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="number" name="mother_name" class="form-control mother_name is_require" value="<?php echo $mother_father_name;?>">
		</div>
	</div>
	
	<div class="col-sm-4 form-group father_nameDiv" style="<?php echo $father_nameDiv; ?>">
		<label>Father Name:<span style="color:red;">*</span></label>
		 <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="text" name="father_name" class="form-control father_name is_require" value="<?php echo $mother_father_name;?>">
		</div>
	</div>
	
	<div class="col-sm-4 form-group">	
	<label>Emergency Contact No:<span style="color:red;">*</span></label>
	<div class="input-group ccCode2">
		<span class="input-group-addon" id="icon"><i class="fas fa-mobile"></i></span>
		<input id="dialCode2" type="text" name="emergency_contact_no" class="form-control is_require" title="Please enter valid number" value="<?php echo $emergency_contact_no;?>" required>		
		<input type="hidden" name="emg_cc" class="emg_cc" value="<?php echo $emg_cc; ?>">
		<input type="hidden" name="emg_cnty_c" class="emg_cnty_c" value="<?php echo $emg_cnty_c; ?>">
	</div>
	</div>
		
	<div class="col-sm-4 form-group">
	<label>Country Of Birth:<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-globe"></i></span>
		<select class="form-control is_require" name="cntry_brth">
		<option value="">Select Option</option>
		<?php while ($rowcountry11 = mysqli_fetch_array($cntList11)){ 
			$countryname11 = $rowcountry11['countries_name'];
		?>
		<option value="<?php echo $countryname11; ?>" <?php if($cntry_brth == "$countryname11") { echo 'selected="selected"'; } ?>><?php echo $countryname11; ?></option> 
        <?php } ?>  
		</select>
	</div>
	</div>
		
		
	<div class="col-sm-4 form-group">	
	<label>Address-1:<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-map-marker"></i></span>
		<input type="text" name="address1" placeholder="Address-1" class="form-control is_require" value="<?php echo $address1;?>">
	</div>
	</div>
	
	<div class="col-sm-4 form-group">
	<label>Address-2(Optional):</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-map-marker"></i></span>		
		<input type="text" name="address2" placeholder="Address-2" class="form-control" value="<?php echo $address2;?>">
	</div>
	</div>
	
	<div class="col-sm-4 form-group">
	<label>Country:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-map-marker"></i></span>		
		<input type="text" name="country" placeholder="Country" class="form-control" value="<?php echo $country;?>">
	</div>
	</div>
				
	<div class="col-sm-4 form-group">
		<label>State:<span style="color:red;">*</span></label>
		 <div class="input-group">
		   <span class="input-group-addon" id="icon"><i class="fas fa-search"></i></span>
		   <input type="text" name="state" placeholder="State Name" class="form-control is_require" value="<?php echo $state;?>">
	</div>	
	</div>
	
	<div class="col-sm-4 form-group">
		<label>City:<span style="color:red;">*</span></label>
		 <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-home"></i></span>
			<input type="text" name="city" placeholder="City Name" class="form-control is_require" id="cityid" value="<?php echo $city;?>">
	</div>	
	</div>
			
	<div class="col-sm-4 form-group">
		<label>PIN Code:<span style="color:red;">*</span></label>
		 <div class="input-group">
		  <span class="input-group-addon" id="icon"><i class="fas fa-pencil-alt"></i></span>
		<input type="text" name="pincode" placeholder="Pin Code" class="form-control is_require" value="<?php echo $pincode;?>">
	</div> 
	</div>
		
	<div class="col-sm-4 form-group">
		<label>Passport Number:<span style="color:red;">*</span></label>
		 <div class="input-group">
		  <span class="input-group-addon" id="icon"><i class="fas fa-book-open"></i></span>
		<input type="text" name="passport_no" placeholder="Passport Number." class="form-control is_require" value="<?php echo $passport_no;?>">
	</div>
	</div>
	<div class="col-sm-4 form-group">
		<label>Passport Issue Date:<span style="color:red;">*</span></label>
		 <div class="input-group">
		 <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="text" name="pp_issue_date" placeholder="Passport Issue Date." class="form-control datepicker123 is_require" value="<?php echo $pp_issue_date;?>">
	</div>
	</div>
<div class="col-sm-4 form-group">
		<label>Passport Expiry Date:<span style="color:red;">*</span></label>
		 <div class="input-group">
		 <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="text" name="pp_expire_date" placeholder="Passport Issue Date." class="form-control is_require" id="gapyear" value="<?php echo $pp_expire_date;?>">		</div>
	</div>



	<input type="hidden" name="snid" value="<?php echo $insertid;?>">
	<input type="hidden" name="personal_status" value="1">
	<input type="hidden" name="edit" value="editfixed">
	<div class="col-sm-12">
		<button type="submit" name="personalbtn" class="btn btn-primary btn-sm">Next</button>
	</div>
	</form>

<script>
$(document).ready(function () {
	$('.mother_father_select').on("change",function(){
	var getval2 = $('.mother_father_select').val();
	if(getval2 == 'Mother'){
		$('.mother_nameDiv').show();
		$('.father_nameDiv').hide();
	}
	if(getval2 == 'Father'){
		$('.father_nameDiv').show();
		$('.mother_nameDiv').hide();
	}
	if(getval2 == ''){
		$('.mother_nameDiv').hide();
		$('.father_nameDiv').hide();
	}
});
});
</script>

<script>
$(document).ready(function () {
	$("#firsttab_requried").submit(function () {
		var submit = true;
		$(".is_require:visible").each(function(){
			if($(this).val() == '') {
					$(this).addClass('error_color');
					submit = false;
			} else {
					$(this).addClass('validError');
			}
		});
		if(submit == true) {
			return true;        
		} else {
			$('.is_require').keyup(function(){
				$(this).removeClass('error_color');
			});
			return false;        
		}
	});
});
</script>
	
</div>
</div>
</div>   
<!---Personal details ending-->                       
<!---Acedmic Deatails Starting--->                 
<div id="Academic-Details">
 <form action="../mysqldb.php" method="post" autocomplete="off" enctype="multipart/form-data" id="secondtab_requried">
 <div class="col-sm-12">
	<h3><b>Test Details(<span style="color:red;">*</span><small>Required</small>)</b></h3>	
	<div class="input-group mb-4">
	 <span class="input-group-addon" id="icon"><i class="far fa-copy"></i></span>
		<select name="englishpro" id="selectQ" class="form-control is_require1">
			<option value="">Choose Option</option>
			<option value="ielts" <?php if($englishpro == "ielts") { echo 'selected="selected"'; } ?>>IELTS</option>
			<option value="pte" <?php if($englishpro == "pte") { echo 'selected="selected"'; } ?>>PTE</option>
			<!--option value="duolingo" <?php //if($englishpro == "duolingo") { echo 'selected="selected"'; } ?>>Duolingo</option-->
			<option value="Toefl" <?php if($englishpro == "Toefl") { echo 'selected="selected"'; } ?>>Toefl</option>
		</select> 	
 </div>
 </div>

<?php if($englishpro == 'ielts'){ ?>
<script>
$(document).ready(function () {
	$('#eiltsdiv').show();
    $('#ptediv').hide();
	$('#duolingodiv').hide();
	$('#Toefldiv').hide();
});	
</script>
<?php } if($englishpro == 'pte'){ ?>
<script>
$(document).ready(function () {
	$('#eiltsdiv').hide();
    $('#ptediv').show();
	$('#duolingodiv').hide();
	$('#Toefldiv').hide();
});	
</script>
<?php } if($englishpro == 'duolingo'){ ?>
<script>
$(document).ready(function () {
	$('#eiltsdiv').hide();
    $('#ptediv').hide();
	$('#duolingodiv').show();
	$('#Toefldiv').hide();
});	
</script>
<?php } if($englishpro == 'Toefl'){ ?>
<script>
$(document).ready(function () {
	$('#eiltsdiv').hide();
	$('#Toefldiv').show();
    $('#ptediv').hide();
	$('#duolingodiv').hide();
});	
</script>
<?php } ?>


<script>	
	$(document).ready(function () {
		$('#selectQ').on("change",function(){
		var select = $('#selectQ').val();
		if(select == "ielts") {
		   $('#eiltsdiv').show();
		   $('#ptediv').hide();
		   $('#duolingodiv').hide();
		   $('#Toefldiv').hide();
		}
		if(select == "pte") {
		   $('#ptediv').show();
		   $('#eiltsdiv').hide();
		   $('#duolingodiv').hide();
		   $('#Toefldiv').hide();
		}
		if(select == "duolingo") {
		   $('#duolingodiv').show();
		   $('#ptediv').hide();
		   $('#eiltsdiv').hide();
		   $('#Toefldiv').hide();
		}
		if(select == "Toefl") {
		   $('#duolingodiv').hide();
		   $('#ptediv').hide();
		   $('#eiltsdiv').hide();
		   $('#Toefldiv').show();
		}
		if(select == "") {
		   $('#ptediv').hide();
		   $('#eiltsdiv').hide();
		   $('#duolingodiv').hide();
		   $('#Toefldiv').hide();
		}
	  });
	});
</script>

<div class="col-sm-12" id="eiltsdiv" style="display:none;">
	<div class="row">
	<div class="col-sm-4 form-group">
	<label>IELTS Overall Band<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-sync"></i></span>
		<select name="ieltsover" class="form-control is_require1 ieltsover">
		   <option value="" >Choose Option</option>
		   <!--option value="4" <?php //if ($ieltsover == "4") { echo 'selected="selected"'; } ?>>4</option>
		   <option value="4.5" <?php //if ($ieltsover == "4.5") { echo 'selected="selected"'; } ?>>4.5</option>
		   <option value="5" <?php //if ($ieltsover == "5") { echo 'selected="selected"'; } ?>>5</option>
		   <option value="5.5" <?php //if ($ieltsover == "5.5") { echo 'selected="selected"'; } ?>>5.5</option-->
		   <option value="5.5" <?php if ($ieltsover == "5.5") { echo 'selected="selected"'; } ?>>5.5</option>
		   <option value="6" <?php if ($ieltsover == "6") { echo 'selected="selected"'; } ?>>6</option>
		   <option value="6.5" <?php if ($ieltsover == "6.5") { echo 'selected="selected"'; } ?>>6.5</option>
		   <option value="7" <?php if ($ieltsover == "7") { echo 'selected="selected"'; } ?>>7</option>
		   <option value="7.5" <?php if ($ieltsover == "7.5") { echo 'selected="selected"'; } ?>>7.5</option>
		   <option value="8" <?php if ($ieltsover == "8") { echo 'selected="selected"'; } ?>>8</option>
		   <option value="8.5" <?php if ($ieltsover == "8.5") { echo 'selected="selected"'; } ?>>8.5</option>
		   <option value="9" <?php if ($ieltsover == "9") { echo 'selected="selected"'; } ?>>9</option>
		   <option value="9.5" <?php if ($ieltsover == "9.5") { echo 'selected="selected"'; } ?>>9.5</option>
		   <option value="10" <?php if ($ieltsover == "10") { echo 'selected="selected"'; } ?>>10</option>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>IELTS Band not Less than<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-less-than"></i></span>
		<select name="ieltsnot" class="form-control is_require1 ieltsnot">
		   <option value="" >Choose Option</option>
		   <!--option value="4" <?php //if ($ieltsover == "4") { echo 'selected="selected"'; } ?>>4</option>
		   <option value="4.5" <?php //if ($ieltsover == "4.5") { echo 'selected="selected"'; } ?>>4.5</option>
		   <option value="5" <?php //if ($ieltsover == "5") { echo 'selected="selected"'; } ?>>5</option>
		   <option value="5.5" <?php //if ($ieltsover == "5.5") { echo 'selected="selected"'; } ?>>5.5</option-->
		   <option value="5.5" <?php if ($ieltsnot == "5.5") { echo 'selected="selected"'; } ?>>5.5</option>
		   <option value="6" <?php if ($ieltsnot == "6") { echo 'selected="selected"'; } ?>>6</option>
		   <option value="6.5" <?php if ($ieltsnot == "6.5") { echo 'selected="selected"'; } ?>>6.5</option>
		   <option value="7" <?php if ($ieltsnot == "7") { echo 'selected="selected"'; } ?>>7</option>
		   <option value="7.5" <?php if ($ieltsnot == "7.5") { echo 'selected="selected"'; } ?>>7.5</option>
		   <option value="8" <?php if ($ieltsnot == "8") { echo 'selected="selected"'; } ?>>8</option>
		   <option value="8.5" <?php if ($ieltsnot == "8.5") { echo 'selected="selected"'; } ?>>8.5</option>
		   <option value="9" <?php if ($ieltsnot == "9") { echo 'selected="selected"'; } ?>>9</option>
		   <option value="9.5" <?php if ($ieltsnot == "9.5") { echo 'selected="selected"'; } ?>>9.5</option>
		   <option value="10" <?php if ($ieltsnot == "10") { echo 'selected="selected"'; } ?>>10</option>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Listening<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-headphones"></i></span>
		<select name="ielts_listening" class="form-control is_require1 ielts_listening">
		   <option value="" >Choose Option</option>
		   <!--option value="4" <?php //if ($ieltsover == "4") { echo 'selected="selected"'; } ?>>4</option>
		   <option value="4.5" <?php //if ($ieltsover == "4.5") { echo 'selected="selected"'; } ?>>4.5</option>
		   <option value="5" <?php //if ($ieltsover == "5") { echo 'selected="selected"'; } ?>>5</option>
		   <option value="5.5" <?php //if ($ieltsover == "5.5") { echo 'selected="selected"'; } ?>>5.5</option-->
		   <option value="5.5" <?php if ($ielts_listening == "5.5") { echo 'selected="selected"'; } ?>>5.5</option>
		   <option value="6" <?php if ($ielts_listening == "6") { echo 'selected="selected"'; } ?>>6</option>
		   <option value="6.5" <?php if ($ielts_listening == "6.5") { echo 'selected="selected"'; } ?>>6.5</option>
		   <option value="7" <?php if ($ielts_listening == "7") { echo 'selected="selected"'; } ?>>7</option>
		   <option value="7.5" <?php if ($ielts_listening == "7.5") { echo 'selected="selected"'; } ?>>7.5</option>
		   <option value="8" <?php if ($ielts_listening == "8") { echo 'selected="selected"'; } ?>>8</option>
		   <option value="8.5" <?php if ($ielts_listening == "8.5") { echo 'selected="selected"'; } ?>>8.5</option>
		   <option value="9" <?php if ($ielts_listening == "9") { echo 'selected="selected"'; } ?>>9</option>
		   <option value="9.5" <?php if ($ielts_listening == "9.5") { echo 'selected="selected"'; } ?>>9.5</option>
		   <option value="10" <?php if ($ielts_listening == "10") { echo 'selected="selected"'; } ?>>10</option>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Reading<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-book-open"></i></span>
		<select name="ielts_reading" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <!--option value="4" <?php //if ($ieltsover == "4") { echo 'selected="selected"'; } ?>>4</option>
		   <option value="4.5" <?php //if ($ieltsover == "4.5") { echo 'selected="selected"'; } ?>>4.5</option>
		   <option value="5" <?php //if ($ieltsover == "5") { echo 'selected="selected"'; } ?>>5</option>
		   <option value="5.5" <?php //if ($ieltsover == "5.5") { echo 'selected="selected"'; } ?>>5.5</option-->
		   <option value="5.5" <?php if ($ielts_reading == "5.5") { echo 'selected="selected"'; } ?>>5.5</option>
		   <option value="6" <?php if ($ielts_reading == "6") { echo 'selected="selected"'; } ?>>6</option>
		   <option value="6.5" <?php if ($ielts_reading == "6.5") { echo 'selected="selected"'; } ?>>6.5</option>
		   <option value="7" <?php if ($ielts_reading == "7") { echo 'selected="selected"'; } ?>>7</option>
		   <option value="7.5" <?php if ($ielts_reading == "7.5") { echo 'selected="selected"'; } ?>>7.5</option>
		   <option value="8" <?php if ($ielts_reading == "8") { echo 'selected="selected"'; } ?>>8</option>
		   <option value="8.5" <?php if ($ielts_reading == "8.5") { echo 'selected="selected"'; } ?>>8.5</option>
		   <option value="9" <?php if ($ielts_reading == "9") { echo 'selected="selected"'; } ?>>9</option>
		   <option value="9.5" <?php if ($ielts_reading == "9.5") { echo 'selected="selected"'; } ?>>9.5</option>
		   <option value="10" <?php if ($ielts_reading == "10") { echo 'selected="selected"'; } ?>>10</option>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Writing<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-edit"></i></span>
		<select name="ielts_writing" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <!--option value="4" <?php //if ($ieltsover == "4") { echo 'selected="selected"'; } ?>>4</option>
		   <option value="4.5" <?php //if ($ieltsover == "4.5") { echo 'selected="selected"'; } ?>>4.5</option>
		   <option value="5" <?php //if ($ieltsover == "5") { echo 'selected="selected"'; } ?>>5</option>
		   <option value="5.5" <?php //if ($ieltsover == "5.5") { echo 'selected="selected"'; } ?>>5.5</option-->
		   <option value="5.5" <?php if ($ielts_writing == "5.5") { echo 'selected="selected"'; } ?>>5.5</option>
		   <option value="6" <?php if ($ielts_writing == "6") { echo 'selected="selected"'; } ?>>6</option>
		   <option value="6.5" <?php if ($ielts_writing == "6.5") { echo 'selected="selected"'; } ?>>6.5</option>
		   <option value="7" <?php if ($ielts_writing == "7") { echo 'selected="selected"'; } ?>>7</option>
		   <option value="7.5" <?php if ($ielts_writing == "7.5") { echo 'selected="selected"'; } ?>>7.5</option>
		   <option value="8" <?php if ($ielts_writing == "8") { echo 'selected="selected"'; } ?>>8</option>
		   <option value="8.5" <?php if ($ielts_writing == "8.5") { echo 'selected="selected"'; } ?>>8.5</option>
		   <option value="9" <?php if ($ielts_writing == "9") { echo 'selected="selected"'; } ?>>9</option>
		   <option value="9.5" <?php if ($ielts_writing == "9.5") { echo 'selected="selected"'; } ?>>9.5</option>
		   <option value="10" <?php if ($ielts_writing == "10") { echo 'selected="selected"'; } ?>>10</option>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Speaking<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-volume-up"></i></span>
		<select name="ielts_speaking" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <!--option value="4" <?php //if ($ieltsover == "4") { echo 'selected="selected"'; } ?>>4</option>
		   <option value="4.5" <?php //if ($ieltsover == "4.5") { echo 'selected="selected"'; } ?>>4.5</option>
		   <option value="5" <?php //if ($ieltsover == "5") { echo 'selected="selected"'; } ?>>5</option>
		   <option value="5.5" <?php //if ($ieltsover == "5.5") { echo 'selected="selected"'; } ?>>5.5</option-->
		   <option value="5.5" <?php if ($ielts_speaking == "5.5") { echo 'selected="selected"'; } ?>>5.5</option>
		   <option value="6" <?php if ($ielts_speaking == "6") { echo 'selected="selected"'; } ?>>6</option>
		   <option value="6.5" <?php if ($ielts_speaking == "6.5") { echo 'selected="selected"'; } ?>>6.5</option>
		   <option value="7" <?php if ($ielts_speaking == "7") { echo 'selected="selected"'; } ?>>7</option>
		   <option value="7.5" <?php if ($ielts_speaking == "7.5") { echo 'selected="selected"'; } ?>>7.5</option>
		   <option value="8" <?php if ($ielts_speaking == "8") { echo 'selected="selected"'; } ?>>8</option>
		   <option value="8.5" <?php if ($ielts_speaking == "8.5") { echo 'selected="selected"'; } ?>>8.5</option>
		   <option value="9" <?php if ($ielts_speaking == "9") { echo 'selected="selected"'; } ?>>9</option>
		   <option value="9.5" <?php if ($ielts_speaking == "9.5") { echo 'selected="selected"'; } ?>>9.5</option>
		   <option value="10" <?php if ($ielts_speaking == "10") { echo 'selected="selected"'; } ?>>10</option>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>IELTS Date<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="text" name="ielts_date" class="form-control datepicker123 is_require1" value="<?php if(isset($ielts_date)){ echo $ielts_date; }?>">
	</div>
	</div>
	</div>
	</div>
	
<!---- Toefl ---->
<div class="col-sm-12" id="Toefldiv" style="display:none;">
<div class="row mt-3">	
	<div class="col-sm-4 form-group">
	<label>Toefl Overall Band<span style="color:red;">*</span></label>
	<div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-sync"></i></span>
		<select name="Toeflover" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $it=60; $it<=120; $it++ ){ ?>		   
		   <option value="<?php echo $it;?>" <?php if ($Toeflover == "$it") { echo 'selected="selected"'; } ?>><?php echo $it; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<input type="hidden" name="Toeflnot" value="N/A">
	<div class="col-sm-4 form-group">
	<label>Listening<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-headphones"></i></span>
		<select name="Toefl_listening" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $itl=12; $itl<=30; $itl++ ){ ?>		   
		   <option value="<?php echo $itl;?>" <?php if ($Toefl_listening == "$itl") { echo 'selected="selected"'; } ?>><?php echo $itl; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Reading<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-book-open"></i></span>
		<select name="Toefl_reading" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $itr=13; $itr<=30; $itr++ ){ ?>		   
		   <option value="<?php echo $itr;?>" <?php if ($Toefl_reading == "$itr") { echo 'selected="selected"'; } ?>><?php echo $itr; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Writing<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-edit"></i></span>
		<select name="Toefl_writing" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $itw=21; $itw<=30; $itw++ ){ ?>		   
		   <option value="<?php echo $itw;?>" <?php if ($Toefl_writing == "$itw") { echo 'selected="selected"'; } ?>><?php echo $itw; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Speaking<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-volume-up"></i></span>
		<select name="Toefl_speaking" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $its=18; $its<=30; $its++ ){ ?>		   
		   <option value="<?php echo $its;?>" <?php if ($Toefl_speaking == "$its") { echo 'selected="selected"'; } ?>><?php echo $its; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Toefl Date<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="text" name="Toefl_date" class="form-control datepicker123 is_require1" value="<?php if(isset($Toefl_date)){ echo $Toefl_date; }?>">
	</div>
	</div>
	
</div>
</div>	
	
<!--- PTE  -->	
	<div class="col-sm-12" id="ptediv" style="display:none;">
	<div class="row">
	<div class="col-sm-4 form-group">
	<label>PTE Overall Band<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-sync"></i></span>
		<select name="pteover" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $i=53; $i<=90; $i++ ){ ?>		   
		   <option value="<?php echo $i;?>" <?php if ($pteover == "$i") { echo 'selected="selected"'; } ?>><?php echo $i; ?></option>
		  <?php } ?>		   
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>PTE Band not Less than<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-less-than"></i></span>
		<select name="ptenot" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $i=50; $i<=90; $i++ ){ ?>		   
		   <option value="<?php echo $i;?>" <?php if ($ptenot == "$i") { echo 'selected="selected"'; } ?>><?php echo $i; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Listening<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-headphones"></i></span>
		<select name="pte_listening" class="form-control is_require1">
		   <option value="" >Choose Option</option>		   
		   <?php 
		   for( $i=50; $i<=90; $i++ ){ ?>		   
		   <option value="<?php echo $i;?>" <?php if ($pte_listening == "$i") { echo 'selected="selected"'; } ?>><?php echo $i; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Reading<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-book-open"></i></span>
		<select name="pte_reading" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $i=50; $i<=90; $i++ ){ ?>		   
		   <option value="<?php echo $i;?>" <?php if ($pte_reading == "$i") { echo 'selected="selected"'; } ?>><?php echo $i; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Writing<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-edit"></i></span>
		<select name="pte_writing" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $i=50; $i<=90; $i++ ){ ?>		   
		   <option value="<?php echo $i;?>" <?php if ($pte_writing == "$i") { echo 'selected="selected"'; } ?>><?php echo $i; ?></option>
		  <?php } ?>
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>Speaking<span style="color:red;">*</span></label>
	<div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-volume-up"></i></span>
		<select name="pte_speaking" class="form-control is_require1">
		   <option value="" >Choose Option</option>
		   <?php 
		   for( $i=50; $i<=90; $i++ ){ ?>		   
		   <option value="<?php echo $i;?>" <?php if ($pte_speaking == "$i") { echo 'selected="selected"'; } ?>><?php echo $i; ?></option>
		  <?php } ?>		   
	   </select>
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>PTE Date<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="text" name="pte_date" class="form-control datepicker123 is_require1" id="ielts_date_val" value="<?php if(isset($pte_date)){ echo $pte_date; }?>">
	</div>
	</div>	
	<div class="col-sm-4 form-group">
	<label>PTE Username<span style="color:red;">*</span></label>
	<div class="input-group">
		<input type="text" name="pte_username" class="form-control is_require1" value="<?php  echo $pte_username; ?>">
	</div>
	</div>
	<div class="col-sm-4 form-group">
	<label>PTE Password<span style="color:red;">*</span></label>
	<div class="input-group">
		<input type="text" name="pte_password" class="form-control is_require1" value="<?php  echo $pte_password; ?>">
	</div>
	</div>
	</div>
	</div>		
	<!--- Duolingo -->	
	<div class="col-sm-12" id="duolingodiv" style="display:none;">
	<div class="row">
	
	<div class="col-sm-4 form-group">
	<label>Overall Score<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-sync"></i></span>
		<select name="duolingo_score" class="form-control is_require1">
		   <option value="">Choose Option</option>		   		   
		   <option value="85" <?php if ($duolingo_score == "85") { echo 'selected="selected"'; } ?>>85</option>
		   <option value="90" <?php if ($duolingo_score == "90") { echo 'selected="selected"'; } ?>>90</option>
		   <option value="95" <?php if ($duolingo_score == "95") { echo 'selected="selected"'; } ?>>95</option>
		   <option value="100" <?php if ($duolingo_score == "100") { echo 'selected="selected"'; } ?>>100</option>
		   <option value="105" <?php if ($duolingo_score == "105") { echo 'selected="selected"'; } ?>>105</option>
		   <option value="110" <?php if ($duolingo_score == "110") { echo 'selected="selected"'; } ?>>110</option>
		   <option value="115" <?php if ($duolingo_score == "115") { echo 'selected="selected"'; } ?>>115</option>
		   <option value="120" <?php if ($duolingo_score == "120") { echo 'selected="selected"'; } ?>>120</option>
		   <option value="125" <?php if ($duolingo_score == "125") { echo 'selected="selected"'; } ?>>125</option>
		   <option value="130" <?php if ($duolingo_score == "130") { echo 'selected="selected"'; } ?>>130</option>
		   <option value="135" <?php if ($duolingo_score == "135") { echo 'selected="selected"'; } ?>>135</option>
		   <option value="140" <?php if ($duolingo_score == "140") { echo 'selected="selected"'; } ?>>140</option>
		   <option value="145" <?php if ($duolingo_score == "145") { echo 'selected="selected"'; } ?>>145</option>
		   <option value="150" <?php if ($duolingo_score == "150") { echo 'selected="selected"'; } ?>>150</option>
		   <option value="155" <?php if ($duolingo_score == "155") { echo 'selected="selected"'; } ?>>155</option>
		   <option value="160" <?php if ($duolingo_score == "160") { echo 'selected="selected"'; } ?>>160</option>
	   </select>
	</div>
	</div>
	
	<div class="col-sm-4 form-group">
	<label>Test Date<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<input type="text" name="duolingo_date" class="form-control datepicker123 is_require1" value="<?php if(isset($duolingo_date)){ echo $duolingo_date; }?>">
	</div>
	</div>	
	</div>
	</div>
	<div class="col-sm-12">
	<h3><b>Education Details(<span style="color:red;">*</span><small>Required</small>)</b></h3>
	</div>
	<div class="col-sm-12">
	<div class="row">
	<div class="col-sm-6 form-group">
	<label>Last Qualification<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-graduation-cap"></i></span>
		<select class="form-control is_require1" name="qualifications1">
		  <option value="">Select Qualification</option>
		  <option value="Secondary School" <?php if($qualification1 == "Secondary School") { echo 'selected="selected"'; } ?>>Secondary School</option>
		  <option value="Diploma" <?php if($qualification1 == "Diploma") { echo 'selected="selected"'; } ?>>Diploma</option>
		  <option value="Graduate" <?php if($qualification1 == "Graduate") { echo 'selected="selected"'; } ?>>Graduate</option>
		  <option value="Post-Graduate" <?php if($qualification1 == "Post-Graduate") { echo 'selected="selected"'; } ?>>Post-Graduate</option>
		</select>
	</div>
	</div>

	<div class="col-sm-6 form-group">
	<label>Education Type:<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-book-open"></i></span>	
	<input type="text" class="form-control is_require1" name="stream1" placeholder="Enter Education Type" value="<?php echo $stream1;?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">
	<label>CGPA/Percentage:<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<select class="form-control is_require1" id="cgpaPercentage1" name="cgpa_prcntge1">
			<option value="">Select Option</option>
			<option value="CGPA"<?php if($cgpa_prcntge1 == 'CGPA'){ echo 'selected="selected"'; }?>>CGPA</option>
			<option value="Percentage"<?php if($cgpa_prcntge1 == 'Percentage'){ echo 'selected="selected"'; }?>>Percentage</option>
		</select>
	</div>
</div>
<div class="col-sm-6 form-group" style="display: none;" id="cgpaPer1">
	<label>CGPA/Marks(%):<span style="color:red;">*</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-certificate"></i></span>
		<input type="text" class="form-control marksDiv is_require1" name="marks1" placeholder="Enter CGPA/Marks(Percentage %)" value="<?php echo $marks1; ?>">
	</div>
</div>
	<?php if($cgpa_prcntge1 != ''){ ?>
<script>
$(document).ready(function () {
	$('#cgpaPer1').show();
});	
</script>
<?php } ?>
<script>	
	$(document).ready(function () {
		$('#cgpaPercentage1').on("change",function(){
		var cgpa_per1 = $('#cgpaPercentage1').val();
		if(cgpa_per1 != "") {
		   $('#cgpaPer1').show();
		}else{
		   $('#cgpaPer1').hide();
		}
	  });
	});
</script>

	<div class="col-sm-6 form-group">
	<label>Passing Year:<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>	  
		<?php $cutoff1 = 2000;
            $now1 = date('Y'); ?>
          <select class="form-control is_require1" name="passing_year1">
              <option value="">Year</option>
            <?php for ($y=$now1; $y>=$cutoff1; $y--) { ?>
               <option value="<?php echo $y;?>" <?php if (($passing_year1) == "$y") { echo 'selected="selected"'; } ?>><?php echo $y;?></option>
            <?php } ?>
           </select>
	</div>
	</div>

	<div class="col-sm-6 form-group">
	<label>University Country<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-globe"></i></span>
		<select class="form-control is_require1" name="unicountry1">
		<option value="">Select Country</option>
		<?php while ($rowcountry1 = mysqli_fetch_array($cntList1)){ 
			$countryname1 = $rowcountry1['countries_name'];
		?>
		<option value="<?php echo $countryname1; ?>" <?php if($unicountry1 == "$countryname1") { echo 'selected="selected"'; } ?>><?php echo $countryname1; ?></option> 
        <?php } ?>  
		</select>
	</div>
	</div>
	
	<div class="col-sm-6 form-group">
	<label>Institute Name:<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-university"></i></span>
		<input type="text" class="form-control is_require1" name="uni_name1" placeholder="Enter Institute Name" value="<?php echo $uni_name1;?>">
	</div>
	</div>
	
	</div>
	</div>
	
	<div class="col-sm-12">	
	<h3><b>Education Details(<small>Optional</small>)</b></h3>
	<div class="row">
	<div class="col-sm-6 form-group">
	<label>Last Qualification</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-graduation-cap"></i></span>
		<select class="form-control" name="qualifications2">
		  <option value="">Select Qualification</option>
		  <option value="Secondary School" <?php if($qualification2 == "Secondary School") { echo 'selected="selected"'; } ?>>Secondary School</option>
		  <option value="Diploma" <?php if($qualification2 == "Diploma") { echo 'selected="selected"'; } ?>>Diploma</option>
		  <option value="Graduate" <?php if($qualification2 == "Graduate") { echo 'selected="selected"'; } ?>>Graduate</option>
		  <option value="Post-Graduate" <?php if($qualification2 == "Post-Graduate") { echo 'selected="selected"'; } ?>>Post-Graduate</option>
		</select>
	</div>
	</div>

	<div class="col-sm-6 form-group">
	<label>Education Type:</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-book-open"></i></span>
	<select class="form-control" name="stream2">
		<option value="">Select Stream</option>
		<option value="Arts" <?php if($stream2 == "Arts") { echo 'selected="selected"'; } ?>>Arts</option>
		<option value="Medical" <?php if($stream2 == "Medical") { echo 'selected="selected"'; } ?>>Medical</option>
		<option value="Non - Medical" <?php if($stream2 == "Non - Medical") { echo 'selected="selected"'; } ?>>Non - Medical</option>
		<option value="Commerce" <?php if($stream2 == "Commerce") { echo 'selected="selected"'; } ?>>Commerce</option>
		<option value="Vocational" <?php if($stream2 == "Vocational") { echo 'selected="selected"'; } ?>>Vocational</option>
	</select>
	</div>
	</div>
			
	<div class="col-sm-6 form-group">
	<label>CGPA/Percentage:</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>	  
		<select class="form-control" id="cgpaPercentage2" name="cgpa_prcntge2">
		  <option value="">Select Option</option>
		   <option value="CGPA"<?php if($cgpa_prcntge2 == 'CGPA'){ echo 'selected="selected"'; }?>>CGPA</option>
		   <option value="Percentage"<?php if($cgpa_prcntge2 == 'Percentage'){ echo 'selected="selected"'; }?>>Percentage</option>
		</select>    
	</div>
	</div>
	<div class="col-sm-6 form-group" style="display: none;" id="cgpaPer2">
		<label>CGPA/Marks(%):</label>
		<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-certificate"></i></span>
			<input type="text" class="form-control marksDiv" name="marks2" placeholder="Enter CGPA/Marks(Percentage %)" value="<?php echo $marks2;?>">
		</div>
		</div>
<?php if($cgpa_prcntge2 != ''){ ?>
<script>
  $('#cgpaPer2').show();	
</script>
<?php } ?>

<script>	
	$(document).ready(function () {
		$('#cgpaPercentage2').on("change",function(){
		var cgpa_per2 = $('#cgpaPercentage2').val();
		if(cgpa_per2 != "") {
		   $('#cgpaPer2').show();	
		}else{
		   $('#cgpaPer2').hide();
		}
	  });
	});
</script> 

	<div class="col-sm-6 form-group">
	<label>Passing Year:</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
	  <select class="form-control" name="passing_year2">
	  <option value="">Passing Year</option>
	  <option value="2018" <?php if($passing_year2 == "2018") { echo 'selected="selected"'; } ?>>2018</option>
	  <option value="2017" <?php if($passing_year2 == "2017") { echo 'selected="selected"'; } ?>>2017</option>
	  <option value="2016" <?php if($passing_year2 == "2016") { echo 'selected="selected"'; } ?>>2016</option>
	  <option value="2015" <?php if($passing_year2 == "2015") { echo 'selected="selected"'; } ?>>2015</option>
	  <option value="2014" <?php if($passing_year2 == "2014") { echo 'selected="selected"'; } ?>>2014</option>
	  <option value="2013" <?php if($passing_year2 == "2013") { echo 'selected="selected"'; } ?>>2013</option>
	  <option value="2012" <?php if($passing_year2 == "2012") { echo 'selected="selected"'; } ?>>2012</option>
		  </select>
	</div>
	</div>

	<div class="col-sm-6 form-group">
	<label>University Country</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-globe"></i></span>
		<select class="form-control" name="unicountry2">
		<option value="">Select Country</option>
		<?php while ($rowcountry2 = mysqli_fetch_array($cntList2)){ 
			$countryname2 = $rowcountry2['countries_name'];
		?>
		<option value="<?php echo $countryname2; ?>" <?php if($unicountry2 == "$countryname2") { echo 'selected="selected"'; } ?>><?php echo $countryname2; ?></option> 
        <?php } ?>  
		</select>
	</div>
	</div>	
	<div class="col-sm-6 form-group">
	<label>Institute Name:<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-university"></i></span>
		<input type="text" class="form-control" name="uni_name2" placeholder="Enter Institute Name" value="<?php echo $uni_name2;?>">
	</div>
	</div>
	
	</div>
	</div>
	
	<div class="col-sm-12">
	<h3><b>Education Details(<small>Optional</small>)</b></h3>
	<div class="row">
	<div class="col-sm-6 form-group">
	<label>Last Qualification</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-graduation-cap"></i></span>
		<select class="form-control" name="qualifications3">
		  <option value="">Select Qualification</option>
		  <option value="Secondary School" <?php if($qualification3 == "Secondary School") { echo 'selected="selected"'; } ?>>Secondary School</option>
		  <option value="Diploma" <?php if($qualification3 == "Diploma") { echo 'selected="selected"'; } ?>>Diploma</option>
		  <option value="Graduate" <?php if($qualification3 == "Under Graduate") { echo 'selected="selected"'; } ?>>Graduate</option>
		  <option value="Post-Graduate" <?php if($qualification3 == "Post-Graduate") { echo 'selected="selected"'; } ?>>Post-Graduate</option>
		</select>
	</div>
	</div>

	<div class="col-sm-6 form-group">
	<label>Education Type:</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-book-open"></i></span>
	<select class="form-control" name="stream3">
		<option value="">Select Stream</option>
		<option value="Arts" <?php if($stream3 == "Arts") { echo 'selected="selected"'; } ?>>Arts</option>
		<option value="Medical" <?php if($stream3 == "Medical") { echo 'selected="selected"'; } ?>>Medical</option>
		<option value="Non - Medical" <?php if($stream3 == "Non - Medical") { echo 'selected="selected"'; } ?>>Non - Medical</option>
		<option value="Commerce" <?php if($stream3 == "Commerce") { echo 'selected="selected"'; } ?>>Commerce</option>
		<option value="Vocational" <?php if($stream3 == "Vocational") { echo 'selected="selected"'; } ?>>Vocational</option>
	</select>
	</div>
	</div>
			
	<div class="col-sm-6 form-group">
	<label>CGPA/Percentage:</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>	  
		<select class="form-control" id="cgpaPercentage3" name="cgpa_prcntge3">
		  <option value="">Select Option</option>
		   <option value="CGPA"<?php if($cgpa_prcntge3 == 'CGPA'){ echo 'selected="selected"'; }?>>CGPA</option>
		   <option value="Percentage"<?php if($cgpa_prcntge3 == 'Percentage'){ echo 'selected="selected"'; }?>>Percentage</option>
		</select>    
	</div>
	</div>
	<div class="col-sm-6 form-group" style="display: none;" id="cgpaPer3">
		<label>CGPA/Marks(%):</label>
		<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-certificate"></i></span>
			<input type="text" class="form-control marksDiv" name="marks3" placeholder="Enter CGPA/Marks(Percentage %)" value="<?php echo $marks3;?>">
		</div>
		</div>
<?php if($cgpa_prcntge3 != ''){ ?>
<script>
  $('#cgpaPer3').show();	
</script>
<?php } ?>

<script>	
	$(document).ready(function () {
		$('#cgpaPercentage3').on("change",function(){
		var cgpa_per3 = $('#cgpaPercentage3').val();
		if(cgpa_per3 != "") {
		   $('#cgpaPer3').show();	
		}else{
		   $('#cgpaPer3').hide();
		}
	  });
	});
</script> 

	<div class="col-sm-6 form-group">
	<label>Passing Year:</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
	  <select class="form-control" name="passing_year3">
	  <option value="">Passing Year</option>
	  <option value="2018" <?php if($passing_year3 == "2018") { echo 'selected="selected"'; } ?>>2018</option>
	  <option value="2017" <?php if($passing_year3 == "2017") { echo 'selected="selected"'; } ?>>2017</option>
	  <option value="2016" <?php if($passing_year3 == "2016") { echo 'selected="selected"'; } ?>>2016</option>
	  <option value="2015" <?php if($passing_year3 == "2015") { echo 'selected="selected"'; } ?>>2015</option>
	  <option value="2014" <?php if($passing_year3 == "2014") { echo 'selected="selected"'; } ?>>2014</option>
	  <option value="2013" <?php if($passing_year3 == "2013") { echo 'selected="selected"'; } ?>>2013</option>
	  <option value="2012" <?php if($passing_year3 == "2012") { echo 'selected="selected"'; } ?>>2012</option>
		  </select>
	</div>
	</div>

	<div class="col-sm-6 form-group">
	<label>University Country</label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-globe"></i></span>
		<select class="form-control" name="unicountry3">
		<option value="">Select Country</option>
		<?php while ($rowcountry3 = mysqli_fetch_array($cntList3)){ 
			$countryname3 = $rowcountry3['countries_name'];
		?>
		<option value="<?php echo $countryname3; ?>" <?php if($unicountry3 == "$countryname3") { echo 'selected="selected"'; } ?>><?php echo $countryname3; ?></option> 
        <?php } ?>  
		</select>
	</div>
	</div>	
	<div class="col-sm-6 form-group">
	<label>Institute Name:<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-university"></i></span>
		<input type="text" class="form-control" name="uni_name3" placeholder="Enter Institute Name" value="<?php echo $uni_name3;?>">
	</div>
	</div>
	
	</div>
	</div>
	
	
	<div class="col-sm-12 form_bg pt-4">
		<h3><b>Justify Passing Details</b></h3>
	<div class="row">
	
	<div class="col-sm-6 form-group">
	<label>Passing Year<span style="color:red;">*</span></label>
	  	<?php $cutoff3 = 2000;
		$now3 = date('Y'); ?>
		<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-calendar"></i></span>
		<select class="form-control pass_year_div is_require1" name="passing_year_gap">
		  <option value="">Select Option</option>
		<?php for ($y=$now3; $y>=$cutoff3; $y--) { ?>
		   <option value="<?php echo $y;?>" <?php if (($passing_year_gap) == "$y") { echo 'selected="selected"'; } ?>><?php echo $y;?></option>
		<?php } ?>
		</select>
	</div>
	</div>
<?php 
if(!empty($passing_justify_gap)){ 
	$gapDiv = "block";
}else{
	$gapDiv = "none";
}
?>
	<div class="col-sm-6 form-group gapDiv" style="display:<?php echo $gapDiv; ?>;">
	<label>Do you have Justification for Gap ?<span style="color:red;">*</span></label>
	<div class="input-group">
	<span class="input-group-addon" id="icon"><i class="fab fa-searchengin"></i></span>
		<select class="form-control gapClass is_require1" name="passing_justify_gap">
			<option value="">Select Option</option>
			<option value="Yes" <?php if($passing_justify_gap == "Yes") { echo 'selected="selected"'; } ?>>Yes</option>
			<option value="No" <?php if($passing_justify_gap == "No") { echo 'selected="selected"'; } ?>>No</option>			
		</select>
	</div>
	</div>

<?php 
if(!empty($gap_duration)){ 
	$gapDurationDiv = "block";
}else{
	$gapDurationDiv = "none";
}
?>
	<div class="col-sm-6 form-group gapDurationDiv" style="display:<?php echo $gapDurationDiv; ?>;">
	<label>What you have done during gap?<span style="color:red;">*</span></label>
	<div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-people-carry"></i></span>
		<select class="form-control gapDurationClass is_require1" name="gap_duration">
			<option value="">Select Option</option>
			<option value="job" <?php if($gap_duration == "job") { echo 'selected="selected"'; } ?>>Job</option>
			<option value="business" <?php if($gap_duration == "business") { echo 'selected="selected"'; } ?>>Business</option>			
			<option value="exam_prepration" <?php if($gap_duration == "exam_prepration") { echo 'selected="selected"'; } ?>>Exam Prepration</option>			
			<option value="other" <?php if($gap_duration == "other") { echo 'selected="selected"'; } ?>>Other</option>			
		</select>
	</div>
	</div>

<?php 
if(!empty($gap_duration)){ 
	
	if($gap_duration == "job"){
		$jobDiv = "block";
		$businessDiv = "none";
		$exam_preprationDiv = "none";
		$otherDiv = "none";
	}
	if($gap_duration == "business"){
		$businessDiv = "block"; 
		$jobDiv = "none";
		$exam_preprationDiv = "none";
		$otherDiv = "none";
	}
	if($gap_duration == "exam_prepration"){
		$exam_preprationDiv = "block"; 
		$jobDiv = "none";
		$businessDiv = "none";
		$otherDiv = "none";
	}
	if($gap_duration == "other"){
		$otherDiv = "block";
		$jobDiv = "none";
		$businessDiv = "none";
		$exam_preprationDiv = "none";
	}
	
}else{
	$jobDiv = "none";
	$businessDiv = "none";
	$exam_preprationDiv = "none";
	$otherDiv = "none";
}
?>
	<div class="col-sm-6 form-group jobDiv" style="display:<?php echo $jobDiv; ?>;">
	<label>Documents Required For Gap Justification</label><div class="input-group">
	<span class="input-group-addon" id="icon"><i class="fas fa-question"></i></span>
		<p class="form-control">Salery Slip, Joining Letter, Bank Statement</p>
	</div>
	</div>
	
	<div class="col-sm-6 form-group businessDiv" style="display:<?php echo $businessDiv; ?>;">
	<label>Documents Required For Gap Justification</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-question"></i></span>
		<p class="form-control">ITR, TAN Number, Bank Statement</p>
	</div>
	</div>
	
	<div class="col-sm-6 form-group exam_preprationDiv" style="display:<?php echo $exam_preprationDiv; ?>;">
	<label>Documents Required For Gap Justification</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-question"></i></span>
		<p class="form-control">Admit Card</p>
	</div>
	</div>
	
	<div class="col-sm-6 form-group otherDiv" style="display:<?php echo $otherDiv; ?>;">
	<label>Please mention the other reason</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-question"></i></span>
		<input type="text" class="form-control is_require1" name="gap_other" placeholder="Enter Institute Name" value="<?php echo $gap_other; ?>">
	</div>
	</div>
	
	</div>
	</div>
	
	
	<input type="hidden" name="snid" value="<?php echo $insertid;?>">
	<input type="hidden" name="academic_status" value="1">
	<input type="hidden" name="edit" value="editfixed">
	<div class="col-sm-12">
		<button type="submit" name="academicbtn" class="btn btn-primary btn-sm">Next</button>
	</div>
	
	</form>
	<script>
	$(document).ready(function () {
	$("#secondtab_requried").submit(function () {
		var submit = true;
		$(".is_require1:visible").each(function(){
			if($(this).val() == '') {
					$(this).addClass('error_color');
					submit = false;
			} else {
					$(this).addClass('validError');
			}
		});
		if(submit == true) {
			return true;        
		} else {
			$('.is_require1').keyup(function(){
				$(this).removeClass('error_color');
			});
			return false;        
		}
	});
	});
	
	$(".marksDiv").keyup(function(){
		var $this = $(this);
		$this.val($this.val().replace(/[^\d.]/g, ''));        
	});
	</script>

<script>
$(document).on('change', '.pass_year_div', function(){
	var getYear = $(this).val();
	var crntYear = '<?php echo $crnt_year; ?>';
	if(getYear == crntYear){
		$('.gapDiv').hide();
		
		$('.gapDurationDiv').hide();
		$('.jobDiv').hide();
		$('.businessDiv').hide();
		$('.exam_preprationDiv').hide();
		$('.otherDiv').hide();
	}else{
		$('.gapDiv').show();
		
		$('.gapDurationDiv').hide();
		$('.jobDiv').hide();
		$('.businessDiv').hide();
		$('.exam_preprationDiv').hide();
		$('.otherDiv').hide();
	}
});

$(document).on('change', '.gapClass', function(){
	var getgap = $(this).val();
	if(getgap == 'Yes'){
		$('.gapDurationDiv').show();
		
		$('.jobDiv').hide();
		$('.businessDiv').hide();
		$('.exam_preprationDiv').hide();
		$('.otherDiv').hide();
	}else{
		$('.gapDurationDiv').hide();
		
		$('.jobDiv').hide();
		$('.businessDiv').hide();
		$('.exam_preprationDiv').hide();
		$('.otherDiv').hide();
	}
});

$(document).on('change', '.gapDurationClass', function(){
	var getgapReson = $(this).val();
	if(getgapReson == 'job'){
		$('.jobDiv').show();
		$('.businessDiv').hide();
		$('.exam_preprationDiv').hide();
		$('.otherDiv').hide();
	}
	else if (getgapReson == 'business') {
		$('.jobDiv').hide();
		$('.businessDiv').show();
		$('.exam_preprationDiv').hide();
		$('.otherDiv').hide();
	}
	else if (getgapReson == 'exam_prepration') {
		$('.jobDiv').hide();
		$('.businessDiv').hide();
		$('.exam_preprationDiv').show();
		$('.otherDiv').hide();
	}
	else if (getgapReson == 'other') {
		$('.jobDiv').hide();
		$('.businessDiv').hide();
		$('.exam_preprationDiv').hide();
		$('.otherDiv').show();
	}
	else{
		$('.jobDiv').hide();
		$('.businessDiv').hide();
		$('.exam_preprationDiv').hide();
		$('.otherDiv').hide();
	}
});
</script>
</div>

<div id="Academic-Details-Docs">

<div class="col-sm-12">
<h3 class="folded"><center><b>Upload Docs</b></center></h3>
</div>

    <table class="table table-bordered">
	<tr>
		<td>Upload Passport:<span style="color:red;">*</span></td>
		<td>
		<form action="../uploadpro.php" enctype="multipart/form-data" class="form-horizontal-docu1" method="post">
		<input type="file" name="idproof" class="form-control upload-image1" />
		<input type="hidden" name="stuid" value="<?php echo $insertid;?>">
		<div class="preview1">	
		<?php 
		if(!empty($idproof)){
			echo "<a href='../uploads/".$idproof."' class='btn btn-success btn-download' download>Download Passport</a>";
		} ?>
		</div>
		<div class="progress progressDiv1" style="display:none">
		<div class="progress-bar progress-bar-success progress-bar-striped pbClass1" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
		</div>
		<span style="color:red;float: left;">(upload front and back copy in JPG, PNG, ZIP or PDF File), Maximum Size: 4MB</span>
		</form>
		</td>
	</tr>
	<tr>
	<?php
	if($englishpro == 'ielts'){
		$englishpro_div = 'IELTS TRF';
		$input_name = 'ielts_file';
		if(!empty($ielts_file)){
			$download_english = "<a class='btn btn-success btn-download' href='../uploads/".$ielts_file."' download>Download IELTS TRF</a>";
		}else{
			$download_english = '';
		}
		$size_english = '(upload PDF or ZIP file), Maximum Size: 2MB';
	}
	if($englishpro == 'pte'){
		$englishpro_div = 'PTE TRF';
		$input_name = 'pte_file';
		if(!empty($pte_file)){
			$download_english = "<a class='btn btn-success btn-download' href='../uploads/".$pte_file."' download>Download PTE TRF</a>";
		}else{
			$download_english = '';
		}
		$size_english = '(upload PDF or ZIP file), Maximum Size: 2MB';
	}
	if($englishpro == 'Toefl'){
		$englishpro_div = 'Toefl TRF';
		$input_name = 'Toefl_file';
		if(!empty($Toefl_file)){
			$download_english = "<a class='btn btn-success btn-download' href='../uploads/".$Toefl_file."' download>Download Toefl TRF</a>";
		}else{
			$download_english = '';
		}
		$size_english = '(upload PDF or ZIP file), Maximum Size: 2MB';
	}
	if($englishpro == 'duolingo'){
		$englishpro_div = 'Duolingo File';
		$input_name = 'duolingo_file';
		if(!empty($duolingo_file)){
			$download_english = "<a class='btn btn-success btn-download' href='../uploads/".$duolingo_file."' download>Download Duolingo File</a>";
		}else{
			$download_english = '';
		}
		$size_english = '(upload JPG, PNG, PDF or ZIP file), Maximum Size: 2MB';
	}
	if(!empty($englishpro)){
	?>
	<td>
	<?php echo $englishpro_div; ?>:<span style="color:red;">*</span>
	</td>
	<td>
	<form action="../uploadpro.php" enctype="multipart/form-data" class="form-horizontal-docu2" method="post">
	<input type="file" name="<?php echo $input_name; ?>" class="form-control upload-image2" />
	<input type="hidden" name="stuid" value="<?php echo $insertid;?>">
	<div class="preview2">
	<?php echo $download_english; ?>
	</div>
	<div class="progress progressDiv2" style="display:none">
	<div class="progress-bar progress-bar-success progress-bar-striped pbClass2" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
	</div>
	<span style="color:red;float: left;"><?php echo $size_english; ?></span>
	</form>
	</td>
	<?php } ?>
	</tr>
	
	<?php if(!empty($qualification1)){ ?>
	<tr>
		<td>Certificate1:<span style="color:red;">*</span></td>
		<td>
		<form action="../uploadpro.php" enctype="multipart/form-data" class="form-horizontal-docu3" method="post">
		<input type="file" name="qualifications1" class="form-control upload-image3" />
		<input type="hidden" name="stuid" value="<?php echo $insertid;?>">
		<div class="preview3">
		<?php if(!empty($certificate1)){ 
			echo "<a class='btn btn-success btn-download' href='../uploads/".$certificate1."' download>Download Certificate</a>";
		}
		?>
		</div>
		<div class="progress progressDiv3" style="display:none">
		<div class="progress-bar progress-bar-success progress-bar-striped pbClass3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
		</div>
		<span style="color:red;float: left;">(upload PDF or all documents in one zip file), Maximum Size: 5MB</span>
		</form>
		</td>
	</tr>
	<?php } ?>
	</table>
	<div class="col-sm-12">
	<button type="submit" class="btn btn-primary btn-sm docsbtn" data-id="<?php echo $insertid;?>">Next</button>
	</div>
	
</div>
	
	<?php
	$msg333 = base64_encode('Course-Details');	$random = base64_encode(rand());
	$userid1 = base64_encode($insertid);
	$urlcrs = "../application/edit.php?pt=$msg333&apid=$userid1&$random";
	?>
	<script>
	$(document).on('click', '.docsbtn', function(){
		var stuid = $(this).attr('data-id');
		var uploaddoc = 'uploaddoc';
		$.post("../uploadpro.php", {"uploaddoc":uploaddoc, "stuid":stuid}, function(check_doc){
		if(check_doc == '1'){
			alert('Upload Passport Docs.');
			return false;
		}
		if(check_doc == '2'){
			alert('Upload Test Details Docs.');	
			return false;
		}
		if(check_doc == '3'){
			alert('Upload Education Certificate.');
			return false;
		}
		if(check_doc == '4'){
			window.location.href='<?php echo $urlcrs; ?>';
		}
		});
	});
	</script>
	
	<script>
	$(document).ready(function() {
	var progressbar = $('.pbClass1');
	$(".upload-image1").on('change',function(){
		var idproof_image = this.files[0].size;
		if(idproof_image <= '4194304'){
			$(".form-horizontal-docu1").ajaxForm({
				target: '.preview1',
				beforeSend: function() {
					$('.preview1').show();
					$(".progressDiv1").css("display","block");
					progressbar.width('0%');
					progressbar.text('0%');	
				},
			uploadProgress: function (event, position, total, percentComplete) {
			progressbar.width(percentComplete + '%');
			progressbar.text(percentComplete + '%');
			if(percentComplete == '100'){
				$('.progressDiv1').hide();
				$('.upload-image1').val('');
			}else{
				$('.progressDiv1').show();
			}
			},
		}).submit();
		}else{
			alert('File too large. File must be less than 4 MB.');
			return false;
		}
		});
		});
		</script>
		
<script>
$(document).ready(function() {
	var progressbar = $('.pbClass2');
	$(".upload-image2").on('change',function(){
		var idproof2_image = this.files[0].size;
		if(idproof2_image <= '2097152'){
		$(".form-horizontal-docu2").ajaxForm({
			target: '.preview2',
			beforeSend: function() {
			$('.preview2').show();
			$(".progressDiv2").css("display","block");
			progressbar.width('0%');
			progressbar.text('0%');
			},
			uploadProgress: function (event, position, total, percentComplete) {
			progressbar.width(percentComplete + '%');
			progressbar.text(percentComplete + '%');
			if(percentComplete == '100'){
			$('.progressDiv2').hide();
			$('.upload-image2').val('');
			}else{
				$('.progressDiv2').show();
			}
			},
		}).submit();
	}else{
		alert('File too large. File must be less than 2 MB.');
		return false;
	}
	});
});
</script>

<?php if(!empty($qualification1)){ ?>
<script>
$(document).ready(function() {
	var progressbar = $('.pbClass3');
	$(".upload-image3").on('change',function(){
		var idproof3_image = this.files[0].size;
		if(idproof3_image <= '5242880'){
			$(".form-horizontal-docu3").ajaxForm({
				target: '.preview3',
				beforeSend: function() {
					$('.preview3').show();
					$(".progressDiv3").css("display","block");
					progressbar.width('0%');
					progressbar.text('0%');
				},
				uploadProgress: function (event, position, total, percentComplete) {
				progressbar.width(percentComplete + '%');
				progressbar.text(percentComplete + '%');
				if(percentComplete == '100'){
					$('.progressDiv3').hide();
					$('.upload-image3').val('');
				}else{
					$('.progressDiv3').show();
				}
				},
			}).submit();
		}else{
		alert('File too large. File must be less than 5 MB.');
		return false;
		}
	});
});
</script>
<?php } ?>

<div id="Course-Details">
	<form action="../mysqldb.php" method="post" autocomplete="off" id="thirdtab_requried">
<!--- Course Program1 --->	
	<div class="col-sm-12">
	<h3><b>Choose Program<span style="color:red;">*</span></b></h3>
	</div>
	<div class="col-sm-12">
	<div class="row">
	
	<div class="col-sm-6 form-group">
	<label>Campus<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-graduation-cap"></i></span>
	<select name="campus" class="form-control is_require2 campusDiv ">
		<option value="">Select Campus</option>
		<?php 
		$campusFetch = mysqli_query($con, "Select campus from contract_courses group by campus");
		while ($rowCampus = mysqli_fetch_assoc($campusFetch)) {
			$campusVal = $rowCampus['campus'];
		?>
		<option value="<?php echo $campusVal; ?>" <?php if($campusVal == "$campus") { echo 'selected="selected"'; } ?>><?php echo $campusVal; ?></option>
		<?php } ?>
	</select>
	</div>
	</div>
		
	<div class="col-sm-6 form-group">
	<label>Choose Intake<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-graduation-cap"></i></span>
	<select name="intake" class="form-control intkeAppend is_require2" data-campus="<?php echo $campus; ?>">
		<option value="">Select Option</option>		
		<?php 
		$intakeFetch = mysqli_query($con, "Select intake from contract_courses where campus='$campus' AND show_oeg_status='1' group by intake");
		while ($rowIntake = mysqli_fetch_assoc($intakeFetch)) {
			$intakeVal = $rowIntake['intake'];
		?>
		<option value="<?php echo $intakeVal; ?>" <?php if($prg_intake == "$intakeVal") { echo 'selected="selected"'; } ?>><?php echo $intakeVal; ?></option>
		<?php } ?>		
	</select>
	</div>
	</div>
	
	<div class="col-sm-6 form-group defaultshow">
	<label>Program Name<span style="color:red;">*</span></label>
	<div class="input-group">
	  <span class="input-group-addon" id="icon"><i class="fas fa-book"></i></span>
		<select class="form-control prgmAppend is_require2" name="prg_name1">
			<option value="">Select Option</option>
		<?php 
		$pnQuery = "SELECT sno,program_name FROM contract_courses WHERE intake = '$prg_intake' AND campus = '$campus' AND visible_status!='2'";
		$pnFetch = mysqli_query($con, $pnQuery);
		while ($rowPn = mysqli_fetch_assoc($pnFetch)) {
			$program_nameVal = $rowPn['program_name'];
		?>	
			<option value="<?php echo $program_nameVal; ?>" <?php if($prg_name1 == "$program_nameVal") { echo 'selected="selected"'; } ?>><?php echo $program_nameVal; ?></option>
		<?php } ?>
		</select>
	</div>
	</div>
	
<!-- program1 script -->	

<script>
$(document).on('change', '.campusDiv', function(){
	$('.loading_icon').show();
	var vl = $(this).val();
	$(".prgmAppend").html("<option value=''>Select Option</option>");
	$('.intkeAppend').attr('data-campus', vl);
	$.post("../response.php?tag=campusadd",{"campus":vl},function(d){
		$(".intkeAppend").html(" ");
		$(".intkeAppend").html("<option value=''>Select Intake</option>");		
		for (i in d) {
			$('<option value="' + d[i].intake + '">'+ d[i].intake +'</option>').appendTo(".intkeAppend");
		}
	$('.loading_icon').hide();		
	});	
});
$(document).on('change', '.intkeAppend', function(){
	$('.loading_icon').show();
	var vl = $(this).val();
	var vl2 = $(this).attr('data-campus');
	$.post("../response.php?tag=corseadd",{"intake":vl, "campus":vl2},function(d){
		$(".prgmAppend").html(" ");
		$(".prgmAppend").html("<option value=''>Select Option</option>");		
		for (i in d) {
			$('<option value="' + d[i].program_name + '">'+ d[i].program_name +'</option>').appendTo(".prgmAppend");
		}
	$('.loading_icon').hide();		
	});	
});
</script>

<!-- thirdtab requried script -->
<script>
	$(document).ready(function () {
	$("#thirdtab_requried").submit(function () {
		var submit = true;
		$(".is_require2:visible").each(function(){
			if($(this).val() == '') {
					$(this).addClass('error_color');
					submit = false;
			} else {
					$(this).addClass('validError');
			}
		});
		if(submit == true) {
			return true;        
		} else {
			$('.is_require2').keyup(function(){
				$(this).removeClass('error_color');
			});
			return false;        
		}
	});
	});
	</script>	 
	
	<input type="hidden" name="snid" value="<?php echo $insertid;?>">
	<input type="hidden" name="course_status" value="1">
	<input type="hidden" name="edit" value="editfixed">
	<div class="col-sm-12">
		<button type="submit" name="coursebtn" class="btn btn-primary btn-sm">Next</button>	
	</div>
	</div>
	</div>
	</form>
</div>

      
<div id="Application-Details">
  <div class="col-sm-12">

	<form class="form-horizontal" action="../mysqldb.php" method="post">	
		<div class="row">
		<div class="col-sm-12 col-lg-6 col-md-6">
<!--- Personal Details --->	
	<h3><b>Personal Details</b></h3>
    <div class="form-group">
      <label class="control-label" for="email"><b>Full Name: </b></label>
		<span><?php echo $fname.' '.$lname;?></span>
      </div>
  
	<div class="form-group">
      <label class="control-label" for="email"><b>Email: </b></label>
		<span><?php echo $email_address;?></span>
      </div>

	<div class="form-group">
      <label class="control-label" for="email"><b>Moble Number:</b> </label>
		<span><?php echo $mobile;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Gender: </b></label>
		<span><?php echo $gender;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Date Of Birth: </b></label>
		<span><?php echo $dob;?></span>
    </div>	
	<div class="form-group">
      <label class="control-label" for="email"><b>Country Of Birth: </b></label>
		<span><?php echo $cntry_brth;?></span>
    </div>		
	<div class="form-group">
      <label class="control-label" for="email"><b>Address-1: </b></label>
		<span><?php echo $address1;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Address-2:</b> </label>
		<span><?php echo $address2;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Country: </b></label>
		<span><?php echo $country;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>State: </b></label>
		<span><?php echo $state;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>City: </b></label>
		<span><?php echo $city;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>PIN Code: </b></label>
		<span><?php echo $pincode;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Passport Number: </b></label>
		<span><?php echo $passport_no;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Passport Issue Date:</b> </label>
		<span><?php echo $pp_issue_date;?></span>
      </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Passport Expiry Date:</b> </label>
		<span><?php echo $pp_expire_date;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Passport: </label>
		<span>
		<a  class='btn btn-success btn-download' href="../uploads/<?php echo $idproof;?>" download>
			<?php echo 'Download';?>
		</a>		
		</span>
    </div>
    <h3><b>Courses</b></h3>    
	<div class="form-group">
      <label class="control-label" for="email"><b>Campus: </b></label>
		<span><?php echo $campus;?></span>
    </div>  
	<div class="form-group">
      <label class="control-label" for="email"><b>Program Name: </b></label>
		<span><?php echo $prg_name1;?></span>
    </div>	
	
	<div class="form-group">
      <label class="control-label" for="email"><b>Intake:</b> </label>
		<span><?php echo $prg_intake;?></span>
    </div>
	</div>
<!--- Academic Details --->	
<div class="col-sm-12 col-lg-6 col-md-6">
	<h3>Academic Details</h3>
	<h5><b>Test details</b></h5>
	<div class="form-group">
      <label class="control-label" for="email">Your test details: </label>
		<span><?php echo $englishpro;?></span>
    </div>
	<?php if($englishpro == 'ielts'){ ?>
	<div class="form-group">
      <label class="control-label" for="email">IELTS Overall Band: </label>
		<span><?php echo $ieltsover;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">IELTS Band not Less than: </label>
		<span><?php echo $ieltsnot;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Listening: </label>
		<span><?php echo $ielts_listening;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Reading: </label>
		<span><?php echo $ielts_reading;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Writing: </label>
		<span><?php echo $ielts_writing;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Speaking: </label>
		<span><?php echo $ielts_speaking;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">IELTS Date: </label>
		<span><?php echo $ielts_date;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">IELTS TRF: </label>
		<span>
		<a  class='btn btn-success btn-download' href="../uploads/<?php echo $ielts_file;?>" download>
			<?php echo 'Download';?>
		</a>
		</span>
    </div>
	<?php }
	
	if($englishpro == 'Toefl'){	?>
	<div class="form-group">
      <label class="control-label" for="email">Toefl Overall Band: </label>
		<span><?php echo $Toeflover;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Toefl Band not Less than: </label>
		<span><?php echo $Toeflnot;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Listening: </label>
		<span><?php echo $Toefl_listening;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Reading: </label>
		<span><?php echo $Toefl_reading;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Writing: </label>
		<span><?php echo $Toefl_writing;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Speaking: </label>
		<span><?php echo $Toefl_speaking;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Toefl Date: </label>
		<span><?php echo $Toefl_date;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Toefl TRF: </label>
		<span>
		<a href="../../uploads/<?php echo $Toefl_file;?>" download>
			<?php echo 'Download';?>
		</a>
		</span>
    </div>
	<?php } ?>
	
	<?php if($englishpro == 'pte'){ ?>
	<div class="form-group">
      <label class="control-label" for="email">PTE Overall Band: </label>
		<span><?php echo $pteover;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">PTE Band not Less than: </label>
		<span><?php echo $ptenot;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Listening: </label>
		<span><?php echo $pte_listening;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Reading: </label>
		<span><?php echo $pte_reading;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Writing: </label>
		<span><?php echo $pte_writing;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Speaking: </label>
		<span><?php echo $pte_speaking;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">PTE Date: </label>
		<span><?php echo $pte_date;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">PTE TRF: </label>
		<span>
		<a  class='btn btn-success btn-download' href="../uploads/<?php echo $pte_file;?>" download>
			<?php echo 'Download';?>
		</a>
		</span>
    </div>
	<?php } ?>	
	
	<?php if($englishpro == 'duolingo'){ ?>
	<div class="form-group">
      <label class="control-label" for="email">Overall Score: </label>
		<span><?php echo $duolingo_score;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email">Test Date: </label>
		<span><?php echo $duolingo_date;?></span>
    </div>	
	<div class="form-group">
      <label class="control-label" for="email">Duolingo File: </label>
		<span>
		<a href="../uploads/<?php echo $duolingo_file;?>" download>
			<?php echo 'Download';?>
		</a>
		</span>
    </div>
	<?php } ?>	
	
	<h5>Education Details1</h5>
    <div class="form-group">
      <label class="control-label" for="email"><b>Qualification:</b></label>
		<span><?php echo $qualification1;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Education Type: </b></label>
		<span><?php echo $stream1;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Marks(%):</b> </label>
		<span><?php echo $marks1;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Passing Year:</b> </label>
		<span><?php echo $passing_year1;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>University Country: </b></label>
		<span><?php echo $unicountry1;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Upload Certificate: </b></label>
		<span>
		<a href="../uploads/<?php echo $certificate1;?>" download>
			<?php echo 'Download';?>
		</a>
		</span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Institute Name: </b></label>
		<span><?php echo $uni_name1;?></span>
    </div>
	
	<?php if($qualification2 !== ''){ ?>
	<h5>Education Details2</h5>
    <div class="form-group">
      <label class="control-label" for="email"><b>Qualification:</b> </label>
		<span><?php echo $qualification2;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Education Type: </b></label>
		<span><?php echo $stream2;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Marks(%): </b></label>
		<span><?php echo $marks2;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Passing Year: </b></label>
		<span><?php echo $passing_year2;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>University Country:</b> </label>
		<span><?php echo $unicountry2;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Upload Certificate: </b></label>
		<span>
		<a href="../uploads/<?php echo $certificate2;?>" download>
			<?php echo 'Download';?>
		</a>
		</span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Institute Name:</b> </label>
		<span><?php echo $uni_name2;?></span>
    </div>
	<?php } 
	if($qualification3 !== ''){ ?>
	<h5>Education Details3</h5>
    <div class="form-group">
      <label class="control-label" for="email"><b>qualification:</b> </label>
		<span><?php echo $qualification3;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Education Type: </b></label>
		<span><?php echo $stream3;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Marks(%): </b></label>
		<span><?php echo $marks3;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Passing Year:</b> </label>
		<span><?php echo $passing_year3;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>University Country:</b> </label>
		<span><?php echo $unicountry3;?></span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Upload Certificate: </b></label>
		<span>
		<a href="../uploads/<?php echo $certificate3;?>" download>
			<?php echo 'Download';?>
		</a>
		</span>
    </div>
	<div class="form-group">
      <label class="control-label" for="email"><b>Institute Name: </b></label>
		<span><?php echo $uni_name3;?></span>
    </div></div>
	<?php } ?>
	</div>
<!--- Choose Course --->
	
	<input type="hidden" name="snid" value="<?php echo $insertid;?>">
	<input type="hidden" name="application_form" value="1">
	<input type="hidden" name="edit" value="editfixed">
	<div class="col-sm-12">
		<a href="../application/edit.php?apid=<?php echo base64_encode($insertid); ?>" class="btn go-back-btn"><i class="fas fa-chevron-circle-left"></i> Go back to edit</a>
		<button type="submit" name="smtapplctnbtn" class="btn submit-btn">Submit the Application</button>	
	</div>	
	</form>	
	</div>
	</div>	
		
  </div>
  </div>
   </div></div>
</div>

<div id="myModal_profileStatus<?php echo $sessionid1;?>" class="modalStatus">
  <div class="modal-contentStatus">
	<div class="modal-headerStatus">
	  <span class="closeStatus">&times;</span>
	  <h2 style="margin-top:7px;font-size: 23px;font-weight: bold;">Profile Status</h2>
	</div>
	<div class="modal-bodyStatus">
	  <p>Please Complete the Personal Details to activate this tab.</p>
	</div>
  </div>
</div>

<script>
$(document).ready(function(){
	var modal_opop = document.getElementById('myModal_profileStatus<?php echo $sessionid1;?>');
	var btn_opop = document.getElementById("profileStatus<?php echo $sessionid1;?>");
	var span_opop = document.getElementsByClassName("closeStatus")[0];
	btn_opop.onclick = function() {
		modal_opop.style.display = "block";
	}
	span_opop.onclick = function() {
		modal_opop.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == modal_opop) {
			modal_opop.style.display = "none";
		}
	}
});	
</script>


<div id="myModal_academicStatus<?php echo $sessionid1;?>" class="modalStatus">
  <div class="modal-contentStatus">
	<div class="modal-headerStatus">
	  <span class="closeacademicStatus">&times;</span>
	  <h2 style="margin-top:7px;font-size: 23px;font-weight: bold;">Academic Status</h2>
	</div>
	<div class="modal-bodyStatus">
	  <p>Please Complete the Academic Details to activate this tab.</p>
	</div>
  </div>
</div>
<script>
$(document).ready(function(){
	var modal1 = document.getElementById('myModal_academicStatus<?php echo $sessionid1;?>');
	var btn1 = document.getElementById("academicStatus<?php echo $sessionid1;?>");
	var spanas = document.getElementsByClassName("closeacademicStatus")[0];
	btn1.onclick = function() {
		modal1.style.display = "block";
	}
	spanas.onclick = function() {
		modal1.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == modal1) {
			modal1.style.display = "none";
		}
	}
});		
</script>


<div id="myModal_uploadDocument<?php echo $sessionid1;?>" class="modalStatus">
  <div class="modal-contentStatus">
	<div class="modal-headerStatus">
	  <span class="close_uploadDoc_Status">&times;</span>
	  <h2 style="margin-top:7px;font-size: 23px;font-weight: bold;">Upload Documents</h2>
	</div>
	<div class="modal-bodyStatus">
	  <p>Please Complete the Choose Coursees tab to activate this tab.</p>
	</div>
  </div>
</div>
<script>
$(document).ready(function(){
	
	var modal3 = document.getElementById('myModal_uploadDocument<?php echo $sessionid1;?>');
	var btn3 = document.getElementById("uploadDocument_status<?php echo $sessionid1;?>");
	var span3 = document.getElementsByClassName("close_uploadDoc_Status")[0];
	btn3.onclick = function() {
		modal3.style.display = "block";
	}
	span3.onclick = function() {
		modal3.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == modal3) {
			modal3.style.display = "none";
		}
	}	
});	
</script>

<script src="../calling_code/node_modules/intl-tel-input/build/js/intlTelInput.js"></script>

<script>
    var input = document.querySelector("#dialCode");
    window.intlTelInput(input, {
      preferredCountries: ['<?php echo $calling_cntry_code; ?>'],
      separateDialCode: true,
      utilsScript: "../calling_code/node_modules/intl-tel-input/build/js/utils.js",
    });
	
	var input2 = document.querySelector("#dialCode2");
    window.intlTelInput(input2, {
      preferredCountries: ['<?php echo $emg_cnty_c; ?>'],
      separateDialCode: true,
      utilsScript: "../calling_code/node_modules/intl-tel-input/build/js/utils.js",
    });
</script>
  
<script>
$(document).on('click', '.input-group.ccCode ul li.iti__country.iti__standard.iti__active', function(){
	var getCode = $(this).attr('data-dial-code');
	$('.calling_code').attr('value', getCode);
	
	var getCntryCode = $(this).attr('data-country-code');
	$('.calling_cntry_code').attr('value', getCntryCode);
});

$(document).on('click', '.input-group.ccCode2 ul li.iti__country.iti__standard.iti__active', function(){
	var getCode2 = $(this).attr('data-dial-code');
	$('.emg_cc').attr('value', getCode2);
	
	var getCntryCode2 = $(this).attr('data-country-code');
	$('.emg_cnty_c').attr('value', getCntryCode2);
});
</script>
<script>
  $( function() {
    $("#gapyear").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: true, 
		changeYear: true,
		yearRange: "-0:+15"
    });
  });
  </script>
<?php
include("../footer.php");
?>