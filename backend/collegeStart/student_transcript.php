<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
$mail = new PHPMailer(true);

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	$official_unofficail2 = $_POST['official_unofficail'];
	header("Location: ../collegeStart/student_transcript.php?getsearch=$search&official_unofficail=$official_unofficail2");
}

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$official_unofficail = $_GET['official_unofficail'];
	$searchInput = "AND (student_id='$searchTerm')";
} else {
	$searchInput = '';
	$searchTerm = '';
	$official_unofficail = '';
}


$qryModule = "SELECT sno, fname, lname, prg_name1, prg_intake FROM st_application WHERE student_id!='' $searchInput";
$rsltModule = mysqli_query($con, $qryModule);
?>
<section class="container-fluid">
<div class="main-div">
<div class="admin-dashboard">
<div class="col-sm-12 col-lg-12">

<form action="" method="post" autocomplete="off" class="row mb-3 justify-content-center">
	<div class="col-sm-6 col-lg-4">
		<label>Type*</label>
		<div class="input-group input-group-sm">
		<select name="official_unofficail" class="form-control" required>
			<option value="">Select Type</option>
			<option value="OFFICIAL" <?php if($official_unofficail == 'OFFICIAL') { echo 'selected="selected"'; } ?>>OFFICIAL</option>
			<option value="UNOFFICIAL" <?php if($official_unofficail == 'UNOFFICIAL') { echo 'selected="selected"'; } ?>>UNOFFICIAL</option>
		</select>
		</div>
	</div>
	<div class="col-sm-6 col-lg-4">
		<label>Student ID*</label>
		<div class="input-group input-group-sm">
		<input type="text" name="inputval" class="form-control" placeholder="Enter Student ID*" value="<?php echo $searchTerm; ?>" required>
			<div class="input-group-append">
			<input type="submit" name="srchClickbtn" class="btn btn-sm btn-success" value="Search">
			</div>
		</div>
	</div>
</form>

</div>
<div class="row justify-content-center">	

<div class="col-12 col-xl-8 col-md-10 col-sm-12 mb-3">
	<div class="form-border p-md-5 p-2">
	<div class=" row ">
		<div class="col-12  mb-3">
			<div class="dashed-border p-md-3 p-1">
	<h2 class="my-0 text-center text-success">GRANVILLE COLLEGE</h2>
	<h4 class="my-0 text-center"><?php echo $official_unofficail; ?> STUDENT TRANSCRIPT</h4>
	
<?php
if(mysqli_num_rows($rsltModule) && !empty($searchTerm)){
$rowModule = mysqli_fetch_assoc($rsltModule);
$snoApp = $rowModule['sno'];
$fname = $rowModule['fname'];
$lname = $rowModule['lname'];
$fullname = $fname.' '.$lname;
$prg_name1 = $rowModule['prg_name1'];
$prg_intake = $rowModule['prg_intake'];

$qryModule_2 = "SELECT sno, commenc_date, expected_date FROM contract_courses WHERE program_name='$prg_name1' AND intake='$prg_intake'";
$rsltModule_2 = mysqli_query($con, $qryModule_2);
$rowModule_2 = mysqli_fetch_assoc($rsltModule_2);
$commenc_date = $rowModule_2['commenc_date'];
// $expected_date = $rowModule_2['expected_date'];

$qryModule_5 = "SELECT * FROM student_transcript WHERE app_id='$snoApp'";
$rsltModule_5 = mysqli_query($con, $qryModule_5);
if(mysqli_num_rows($rsltModule_5)){
	$rowModule_5 = mysqli_fetch_assoc($rsltModule_5);
	$classdiv = $rowModule_5['class'];
	$date_of_issue = $rowModule_5['date_of_issue'];
	if(empty($date_of_issue)){
		$date_of_issue2 = $date_of_issue;	
	}else{
		$date_of_issue2 = date('Y/m/d');
	}
	$status_ip = $rowModule_5['status_ip'];
	$expected_date = $rowModule_5['end_date'];
}else{
	$classdiv = '';
	$date_of_issue = '';
	$date_of_issue2 = date('Y/m/d');
	$status_ip = '';
	$expected_date = '';
}
?>

<form action="student_transcript_pdf.php" method="POST" class="forms-sample mt-sm-5 mt-4 row" autocomplete="off">
  <div class="form-group col-sm-6 mb-3">
	<input name="fullname" type="text" class="form-control1" placeholder="Enter Student Name*" value="<?php echo $fullname; ?>" id="fullname" disabled>
	<label for="fullname">Student Name:</label>
  </div>

<div class="form-group col-sm-6 mb-3 ">
	<input type="text" name="program" class="form-control1" placeholder="Enter Program*" value="<?php echo $prg_name1; ?>" id="program" disabled>
	<label for="program">Program:</label>
</div>

 
  <div class="form-group col-sm-6 mb-3 ">
	<input type="text" name="student_id" class="form-control1" placeholder="Student ID" value="GC<?php echo $searchTerm; ?>" id="student_id" disabled>
	<label for="student_id">Student ID:</label>
  </div>

  <div class="form-group col-sm-6 mb-3 ">
	<input type="text" name="start_date" class="form-control1" placeholder="Enter Start Date" value="<?php echo $commenc_date; ?>" id="start_date" disabled>
	<label for="start_date">Start Date:</label>
  </div>

  <div class="form-group col-sm-6 mb-3 ">	
	<input type="text" name="end_date" class="form-control1 datepicker123" placeholder="Enter End Date" value="<?php echo $expected_date; ?>" id="end_date">
	<label for="end_date">End Date:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3 ">
	<input type="text" name="class_crs" class="form-control1" placeholder="Enter Class" id="class_crs" value="<?php echo $classdiv; ?>" required>
	<label for="class_crs">Class:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3 ">
	<input type="text" name="date_issue" class="form-control1" placeholder="Date of Issue" value="<?php echo $date_of_issue2; ?>" id="date_issue" required>
	<label for="date_issue">Date of Issue:</label>
  </div>
  
<div class="line my-2"></div>

<?php
if($prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(1)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(2)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(3)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(4)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(5)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality'){
	$getPName3 = " program2='BA / GSCMS'";	
	
}elseif($prg_name1 == 'Business Administration / Human Resources Management Speciality(1)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(2)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(3)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(4)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(5)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality'){
	$getPName3 = " program2='BA / HRM'";
	
}elseif($prg_name1 == 'Business Administration Diploma(1)' || $prg_name1 == 'Business Administration Diploma(2)' || $prg_name1 == 'Business Administration Diploma(3)' || $prg_name1 == 'Business Administration Diploma(4)' || $prg_name1 == 'Business Administration Diploma(5)' || $prg_name1 == 'Business Administration Diploma'){
	$getPName3 = " program2='Business Administration'";	
	
}elseif($prg_name1 == 'Diploma in Hospitality Management(1)' || $prg_name1 == 'Diploma in Hospitality Management(2)' || $prg_name1 == 'Diploma in Hospitality Management(3)' || $prg_name1 == 'Diploma in Hospitality Management(4)' || $prg_name1 == 'Diploma in Hospitality Management(5)' || $prg_name1 == 'Diploma in Hospitality Management'){
	$getPName3 = " program2='Hospitality'";
	
}elseif($prg_name1 == 'Diploma in Hospitality Management with CO-OP(1)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP(2)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP(3)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP(4)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP(5)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP'){
	$getPName3 = " program2='Hospitality'";	
	
}elseif($prg_name1 == 'Global Supply Chain Management Diploma(1)' || $prg_name1 == 'Global Supply Chain Management Diploma(2)' || $prg_name1 == 'Global Supply Chain Management Diploma(3)' || $prg_name1 == 'Global Supply Chain Management Diploma(4)' || $prg_name1 == 'Global Supply Chain Management Diploma(5)' || $prg_name1 == 'Global Supply Chain Management Diploma'){
	$getPName3 = " program2='Global Supply Chain'";	
	
}elseif($prg_name1 == 'Healthcare Office Administration Diploma(1)' || $prg_name1 == 'Healthcare Office Administration Diploma(2)' || $prg_name1 == 'Healthcare Office Administration Diploma(3)' || $prg_name1 == 'Healthcare Office Administration Diploma(4)' || $prg_name1 == 'Healthcare Office Administration Diploma(5)' || $prg_name1 == 'Healthcare Office Administration Diploma'){
	$getPName3 = " program2='HCOA'";
	
}elseif($prg_name1 == 'Human Resources Management Speciality(1)' || $prg_name1 == 'Human Resources Management Speciality(2)' || $prg_name1 == 'Human Resources Management Speciality(3)' || $prg_name1 == 'Human Resources Management Speciality(4)' || $prg_name1 == 'Human Resources Management Speciality(5)' || $prg_name1 == 'Human Resources Management Speciality'){
	$getPName3 = " program2='Human Resources'";
	
}else{
	$getPName3 = " program2='$prg_name1'";	
}
?>

<div class="col-12 my-3">
	<div class="table-responsive">
		<table class="table borderless" border="0">
		<tr>
			<th>COURSE</th>
			<th>GRADE</th>
		</tr>
	<?php
	$qryModule_3 = "SELECT sno, module_name FROM m_program_lists WHERE module_name!='' AND $getPName3 order by sno desc";
	$rsltModule_3 = mysqli_query($con, $qryModule_3);
	if(mysqli_num_rows($rsltModule_3)){	
	$srnoCnt=1;
	while($rowModule_3 = mysqli_fetch_assoc($rsltModule_3)){
		$module_name_3 = $rowModule_3['module_name'];
		$getCnt = $srnoCnt++;
		$getCnt1 = $getCnt;	
		$getModuleData = mysqli_query($con,"SELECT * FROM student_transcript WHERE app_id='$snoApp'");
		$getModuleDataRow = mysqli_fetch_assoc($getModuleData);
		$dynamicMod = $module.$getCnt1 = $getModuleDataRow['module'.$getCnt1];		
	?>
	<tr>
		<td>
		<input type="hidden" name="module_name_hidden[]" value="<?php echo $module_name_3; ?>">
		<?php echo $module_name_3; ?>
		</td>
		<td>
			<select name="module[]" data-id="<?php echo $getCnt; ?>" class="form-control2 moduleDiv" required>
			<option value="">Select Option*</option>
			<option value="%"<?php if(!empty($dynamicMod) && ($dynamicMod != 'IP' && $dynamicMod != 'IC' && $dynamicMod != 'Complete')){ echo 'selected="selected"';} ?>>%</option>
			<option value="IP" <?php if($dynamicMod == 'IP'){ echo 'selected="selected"';} ?>>IP</option>
			<option value="IC" <?php if($dynamicMod == 'IC'){ echo 'selected="selected"';} ?>>IC</option>
			<option value="Complete" <?php if($dynamicMod == 'Complete'){ echo 'selected="selected"';} ?>>Complete</option>
			</select>
			<?php
			if(!empty($dynamicMod) && ($dynamicMod != 'IP' && $dynamicMod != 'IC' && $dynamicMod != 'Complete')){
				$getPI = 'block';
			}else{
				$getPI = 'none';
			}
			?>
			<input type="text" name="prcntg_input[]" class="prcntg_input<?php echo $getCnt; ?>" style="display:<?php echo $getPI; ?>;" value="<?php echo $dynamicMod; ?>">
		</td>
	</tr>
	<?php } ?>
	<?php } ?>
			
		</table>
	</div>
</div><br>
<div class="line mb-5 mt-2"></div>
  <div class="form-group col-sm-6 mb-3 col-lg-5">
	<select name="ipstatus" class="form-control1 ipstatusDiv" id="ipstatus" required>
		<option value="">Select Option*</option>
		<option value="Incomplete" <?php if($status_ip == 'Incomplete') { echo 'selected="selected"'; } ?>>Incomplete</option>
		<option value="Complete" <?php if($status_ip == 'Complete') { echo 'selected="selected"'; } ?>>Complete</option>
		<option value="Graduated" <?php if($status_ip == 'Graduated') { echo 'selected="selected"'; } ?>>Graduated</option>
		<option value="Inprocess" <?php if($status_ip == 'Inprocess') { echo 'selected="selected"'; } ?>>Inprocess</option>
	</select>
	<label for="ipstatus">Completion Status</label>
	<br><br>
	<p>
	<img src="img/JustynaMatracki.png" width="200">
	</p>

	<label for="sign" class="border-top">
		<b>Justyna Matracki</b>
		<br>SeniorEducation Administrator
	</label>
  </div>
    <div class="form-group col-sm-6 mb-3 col-lg-5">
<img src="https://granville-college.com/agents/images/logo.jpg" width="140" class="img-fluid ml-sm-5">
    </div>
 <div class="form-group col-sm-12 text-right pt-md-2">
	<input type="hidden" name="snoApp" value="<?php echo $snoApp; ?>">
	<input type="hidden" name="official_unofficail" value="<?php echo $official_unofficail; ?>">
  <button name="submit" type="submit" class="btn btn-success float-right mt-md-4">Download</button>
</div>
</form>
<?php }else{ ?>
	<p style="color: red; text-align: center; margin-top: 26px;"><b>Search Here!!!</b></p>
<?php } ?>

</div>
</div>

</div>
</div>
</div>
</div>
</div>
</section>

<script type="text/javascript">
$(document).on('change', '.moduleDiv', function () {
	var getVal = $(this).val();
	var getVal2 = $(this).attr('data-id');
	if(getVal == '%'){
		$('.prcntg_input'+getVal2).show();
	}else{
		$('.prcntg_input'+getVal2).hide();		
	}
});
</script>

<style type="text/css">
	.form-border { 
/*	 border:3px double #3a7f3e; */
box-shadow: 0 0 0 1px #3a7f3e, 0 0 0 2px #fff, 0 0 0 3px #3a7f3e, 0 0 0 4px #fff, 0 0 0 5px #3a7f3e;
	}
	.form-control1:focus, .form-control2:focus { border-bottom:1px solid #ccc; border-top:0px; border-left:0px; border-right:0px; outline:none; box-shadow:0px; }
	.form-control2 { border-bottom:1px solid #ccc; border-top:0px; border-left:0px; border-right:0px;  }
	.form-control1 { border-bottom:1px solid #ccc; border-top:0px; border-left:0px; border-right:0px; width:100%; }
.dashed-border { border:1px dashed #333; }
.line { height:1px; background:#333; width:100%; }
</style>
<?php 
include("../../footer.php");
?>