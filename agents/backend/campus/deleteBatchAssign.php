<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

// if($roles1 == 'ClgCM'){

// } else {
// 	header("Location: ../../login");
//     exit();
// }

if(isset($_POST['srchClickbtn'])){
	$search = $_POST['inputval'];
	header("Location: ../campus/deleteBatchAssign.php?getsearch=$search");
}

if(isset($_POST['sbmtRmveBatch'])){
	$student_id = $_POST['student_id'];
	$snoApp = $_POST['snoApp'];
	
	$qryMStdLists = "SELECT * FROM `m_student` WHERE app_id='$snoApp'";
	$rsltMStdLists = mysqli_query($con, $qryMStdLists);
	$rowLists = mysqli_fetch_assoc($rsltMStdLists);
	$teacher_id = $rowLists['teacher_id'];
	$betch_no = $rowLists['betch_no'];
	$updated_on = date('Y-m-d H:i:s');
	
	$qryMStdLists2 = "INSERT INTO `m_student_delete_from_batch` (`app_id`, `vnumber`, `teacher_id`, `betch_no`, `updated_on`, `updated_by`) VALUES ('$snoApp', '$student_id', '$teacher_id', '$betch_no', '$updated_on', '$contact_person')";
	mysqli_query($con, $qryMStdLists2);
	
	$qryDelete = "DELETE FROM `m_student` WHERE vnumber ='$student_id' AND app_id='$snoApp'";
	mysqli_query($con, $qryDelete);
	
	$getQry2 = "UPDATE `st_application` SET `tearcher_assign`='', `tearcher_assign_old`='' WHERE `sno` ='$snoApp'";
	mysqli_query($con, $getQry2);
	
	header("Location: ../campus/deleteBatchAssign.php?vno=$student_id&msg=successMsg");
}

if (isset($_GET['getsearch']) && $_GET['getsearch']!="") {
	$searchTerm = $_GET['getsearch'];
	$searchInput = "AND (student_id='$searchTerm')";
} else {
	$searchInput = '';
	$searchTerm = '';
}


$qryModule = "SELECT sno, fname, lname, prg_name1, prg_intake FROM st_application WHERE student_id!='' $searchInput";
$rsltModule = mysqli_query($con, $qryModule);
?>
<section class="container-fluid">
<div class="main-div">
<div class="admin-dashboard">
<div class="col-sm-12 col-lg-12">

<form action="" method="post" autocomplete="off" class="row justify-content-center mb-3">
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
	<h4 class="my-0 text-center text-success"><u>Student Delete from Batch</u></h4>
	
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
$expected_date = $rowModule_2['expected_date'];

if($prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(1)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(2)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(3)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(4)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(5)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality'){
	$getPName3 = " program_name='BA / GSCMS'";	
	
}elseif($prg_name1 == 'Business Administration / Human Resources Management Speciality(1)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(2)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(3)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(4)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(5)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality'){
	$getPName3 = " program_name='BA / HRM'";
	
}elseif($prg_name1 == 'Business Administration Diploma(1)' || $prg_name1 == 'Business Administration Diploma(2)' || $prg_name1 == 'Business Administration Diploma(3)' || $prg_name1 == 'Business Administration Diploma(4)' || $prg_name1 == 'Business Administration Diploma(5)' || $prg_name1 == 'Business Administration Diploma'){
	$getPName3 = " program_name='Business Administration'";	
	
}elseif($prg_name1 == 'Diploma in Hospitality Management(1)' || $prg_name1 == 'Diploma in Hospitality Management(2)' || $prg_name1 == 'Diploma in Hospitality Management(3)' || $prg_name1 == 'Diploma in Hospitality Management(4)' || $prg_name1 == 'Diploma in Hospitality Management(5)' || $prg_name1 == 'Diploma in Hospitality Management'){
	$getPName3 = " program_name='Hospitality'";	
	
}elseif($prg_name1 == 'Global Supply Chain Management Diploma(1)' || $prg_name1 == 'Global Supply Chain Management Diploma(2)' || $prg_name1 == 'Global Supply Chain Management Diploma(3)' || $prg_name1 == 'Global Supply Chain Management Diploma(4)' || $prg_name1 == 'Global Supply Chain Management Diploma(5)' || $prg_name1 == 'Global Supply Chain Management Diploma'){
	$getPName3 = " program_name='Global Supply Chain'";	
	
}elseif($prg_name1 == 'Healthcare Office Administration Diploma(1)' || $prg_name1 == 'Healthcare Office Administration Diploma(2)' || $prg_name1 == 'Healthcare Office Administration Diploma(3)' || $prg_name1 == 'Healthcare Office Administration Diploma(4)' || $prg_name1 == 'Healthcare Office Administration Diploma(5)' || $prg_name1 == 'Healthcare Office Administration Diploma'){
	$getPName3 = " program_name='HCOA'";
	
}elseif($prg_name1 == 'Human Resources Management Speciality(1)' || $prg_name1 == 'Human Resources Management Speciality(2)' || $prg_name1 == 'Human Resources Management Speciality(3)' || $prg_name1 == 'Human Resources Management Speciality(4)' || $prg_name1 == 'Human Resources Management Speciality(5)' || $prg_name1 == 'Human Resources Management Speciality'){
	$getPName3 = " program_name='Human Resources'";
	
}else{
	$getPName3 = " program_name='$prg_name1'";	
}

$rsltBatch6 = "SELECT * FROM `m_student` WHERE app_id='$snoApp'";
$queryBatch6 = mysqli_query($con, $rsltBatch6);
$rowBatch6 = mysqli_fetch_assoc($queryBatch6);
$batch_name61 = $rowBatch6['betch_no'];		
$program_name6 = $rowBatch6['program'];	
$shift_time6 = $rowBatch6['shift_time'];
$teacher_id6 = $rowBatch6['teacher_id'];	

$rsltBatch6_2 = "SELECT batch_name FROM m_batch where sno='$batch_name61'";
$queryBatch6_2 = mysqli_query($con, $rsltBatch6_2);
$rowBatch6_2 = mysqli_fetch_assoc($queryBatch6_2);
$batch_name6 = $rowBatch6_2['batch_name'];

$queryGet6 = "SELECT name FROM `m_teacher` WHERE sno='$teacher_id6'";
$queryRslt6 = mysqli_query($con, $queryGet6);
$rowSC6 = mysqli_fetch_assoc($queryRslt6);
$tchrName6 = $rowSC6['name'];
?>

<form action="" method="POST" class="forms-sample mt-sm-5 mt-4 row" autocomplete="off">
  <div class="form-group col-sm-6 mb-3">
	<input name="fullname" type="text" class="form-control1" placeholder="Enter Student Name*" value="<?php echo $fullname; ?>" id="fullname" disabled>
	<label for="fullname">Student Name:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3">
	<input name="vno" type="text" class="form-control1" value="<?php echo $searchTerm; ?>" id="vno" disabled>
	<label for="vno">Student ID:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3">
	<input name="vno" type="text" class="form-control1" value="<?php echo $prg_name1; ?>" id="vno" disabled>
	<label for="vno">Contract Program Name:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3">
	<input name="commenc_date" type="text" class="form-control1" value="<?php echo $commenc_date; ?>" id="commenc_date" disabled>
	<label for="commenc_date">Start Date:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3">
	<input name="expected_date" type="text" class="form-control1" value="<?php echo $expected_date; ?>" id="expected_date" disabled>
	<label for="expected_date">End Date:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3">
	<input name="batch_name" type="text" class="form-control1" value="B<?php echo $batch_name6; ?>" id="batch_name" disabled>
	<label for="batch_name">Batch Name:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3">
	<input name="program_name" type="text" class="form-control1" value="<?php echo $program_name6; ?>" id="program_name" disabled>
	<label for="program_name">Batch Program:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3">
	<input name="shift_time" type="text" class="form-control1" value="<?php echo $shift_time6; ?>" id="shift_time" disabled>
	<label for="shift_time">Shift Time:</label>
  </div>
  
  <div class="form-group col-sm-6 mb-3">
	<input name="tchrName" type="text" class="form-control1" value="<?php echo $tchrName6; ?>" id="tchrName" disabled>
	<label for="tchrName">Instructor Name:</label>
  </div>

 <div class="form-group col-sm-12 text-right pt-md-2">
	<input type="hidden" name="snoApp" value="<?php echo $snoApp; ?>">
	<input type="hidden" name="student_id" value="<?php echo $searchTerm; ?>">
	<button name="sbmtRmveBatch" type="submit" class="btn btn-success float-right mt-md-4">Click to Delete from Batch</button>
</div>
</form>
<?php }else{ ?>
<?php if(!empty($_GET['msg'] == 'successMsg')){ ?>
	<div class="alert alert-success mt-3">
		Student moved in main list.
	</div>
<?php }else{ ?>
	<p style="color: red; text-align: center; margin-top: 26px;"><b>Search Here!!!</b></p>
<?php } } ?>

</div>
</div>

</div>
</div>
</div>
</div>
</div>
</section>

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