<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");
$datetime_at = date('Y-m-d H:i:s');

// if($roles1 == 'ClgCM' || $roles1 == 'APRStep'){
// 	if($roles1 == 'APRStep'){
// 		$InstructorLists = 'Employee';
// 	}else{
// 		$InstructorLists = 'Instructor';	
// 	}
// } else {
// 	header("Location: ../../login");
//     exit();
// }

if (isset($_POST['sbmtTeacher'])) {
    $snom = $_POST['snom'];
    $role33 = $_POST['role'];
    $loggedId =  $_POST['loggedId'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    if(isset($_POST['password'])){
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $org_pass = md5($password);
    }
    $designation = $_POST['designation'];
    $status = $_POST['status'];
    $department = $_POST['department'];
    $emp_code = $_POST['emp_code'];
    $payroll_type = $_POST['payroll_type'];
	if($sessionid1 == '4792'){
		$annual_salary = '0';
		$weekly = '0';
		$personal_leave = '';
		$sick_day_hrs = '';
		$sick_day_hrs_unpaid = '';
		$bereavement_leave = '';
		$jury_duty_leave = '';
	}else{
		if($payroll_type == 'Salaried'){
			$annual_salary = $_POST['annual_salary'];
			$personal_leave = $_POST['personal_leave'];
			$bereavement_leave = $_POST['bereavement_leave'];
			$jury_duty_leave = $_POST['jury_duty_leave'];
			$sick_day_hrs = $_POST['sick_day_hrs'];
			$sick_day_hrs_unpaid = $_POST['sick_day_hrs_unpaid'];		
			$weekly = $_POST['weekly']; //'26';
		}elseif($payroll_type == 'Hourly'){
			$annual_salary = $_POST['annual_salary_2'];
			$sick_day_hrs = $_POST['sick_day_hrs_2'];
			$sick_day_hrs_unpaid = $_POST['sick_day_hrs_unpaid_2'];
			$personal_leave = $_POST['personal_leave_2'];
			$bereavement_leave = $_POST['bereavement_leave_2'];
			$jury_duty_leave = $_POST['jury_duty_leave_2'];		
			$weekly = '0';	
		}else{
			$annual_salary = '0';
			$weekly = '0';
			$personal_leave = '';
			$sick_day_hrs = '';
			$sick_day_hrs_unpaid = '';
			$bereavement_leave = '';
			$jury_duty_leave = '';
		}
	}
    $date_of_joining = $_POST['date_of_joining'];
    $date_of_leaving = $_POST['date_of_leaving'];
    $street_address = mysqli_real_escape_string($con, $_POST['street_address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $province = mysqli_real_escape_string($con, $_POST['province']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
    $dob = $_POST['dob'];
    $effective_date = $_POST['effective_date'];
    $date_at = date('Y-m-d');
    $time_at = date('H:i:s');
    
    if (empty($snom)) {
        $qryInsert = "INSERT INTO `m_teacher` (`role`, `name`, `username`, `password`, `org_pass`, `status`, `designation`, `added_on`, `time_on`, `department`, `payroll_type`, `emp_code`, `annual_salary`, `weekly`, `date_of_joining`, `date_of_leaving`, `personal_leave`, `sick_day_hrs`, `sick_day_hrs_unpaid`, `street_address`, `city`, `province`, `country`, `postal_code`, `dob`, `effective_date`,  `bereavement_leave`, `jury_duty_leave`, `added_by`) VALUES ('$role33', '$name', '$username', '$org_pass', '$password', '$status', '$designation', '$date_at', '$time_at', '$department', '$payroll_type', '$emp_code', '$annual_salary', '$weekly', '$date_of_joining', '$date_of_leaving', '$personal_leave', '$sick_day_hrs', '$sick_day_hrs_unpaid', '$street_address', '$city', '$province', '$country', '$postal_code', '$dob', '$effective_date', '$bereavement_leave', '$jury_duty_leave', '$contact_person')";
        mysqli_query($con, $qryInsert);
    } else {
        $qryUpdate = "UPDATE `m_teacher` SET `name`='$name', `username`='$username', `status`='$status', `designation`='$designation', `department`='$department', `payroll_type`='$payroll_type', `emp_code`='$emp_code', `annual_salary`='$annual_salary', `weekly`='$weekly', `date_of_joining`='$date_of_joining', `date_of_leaving`='$date_of_leaving', `personal_leave`='$personal_leave', `sick_day_hrs`='$sick_day_hrs', `sick_day_hrs_unpaid`='$sick_day_hrs_unpaid', `street_address`='$street_address', `city`='$city', `province`='$province', `country`='$country', `postal_code`='$postal_code', `dob`='$dob', `effective_date`='$effective_date', `bereavement_leave`='$bereavement_leave', `jury_duty_leave`='$jury_duty_leave', `added_by`='$contact_person' WHERE `sno`='$snom'";
        mysqli_query($con, $qryUpdate);
    }

    $pmsg = base64_encode('TeacherAdded&Updated');
    header("Location: teacherLists.php?msg=Success&$pmsg");
}


if(!empty($_GET['sno'])){
	$prmsno = $_GET['sno'];
	$AddEditHead = 'View/Edit';
}else{
	$prmsno = '';
	$AddEditHead = 'Add New';
}

$resultsStr = "SELECT * FROM m_teacher WHERE sno='$prmsno'";
$get_query = mysqli_query($con, $resultsStr);
if(mysqli_num_rows($get_query)){
	$rowModule = mysqli_fetch_assoc($get_query);
	$snoM = $rowModule['sno'];
	$roleMM = $rowModule['role'];
	$nameM = $rowModule['name'];
	$username2 = $rowModule['username'];
	$status2 = $rowModule['status'];
	$password = $rowModule['password'];
	$added_on = $rowModule['added_on'];
	$designation = $rowModule['designation'];
	$department = $rowModule['department'];
	$emp_code = $rowModule['emp_code'];
	$payroll_type = $rowModule['payroll_type'];
	$date_of_joining = $rowModule['date_of_joining'];
	$date_of_leaving = $rowModule['date_of_leaving'];
	$street_address = $rowModule['street_address'];
	$city = $rowModule['city'];
	$province = $rowModule['province'];
	$country = $rowModule['country'];
	$postal_code = $rowModule['postal_code'];
	$dob = $rowModule['dob'];
	$effective_date = $rowModule['effective_date'];	
	if($payroll_type == 'Salaried'){
		$annual_salary = $rowModule['annual_salary'];
		$weekly = $rowModule['weekly'];
		$personal_leave = $rowModule['personal_leave'];
		$bereavement_leave = $rowModule['bereavement_leave'];
		$jury_duty_leave = $rowModule['jury_duty_leave'];
		$sick_day_hrs = $rowModule['sick_day_hrs'];
		$sick_day_hrs_unpaid = $rowModule['sick_day_hrs_unpaid'];
		
		$annual_salary_2 = '';
		$personal_leave_2 = '';
		$bereavement_leave_2 = '';
		$jury_duty_leave_2 = '';
		$sick_day_hrs_2 = '';
		$sick_day_hrs_unpaid_2 = '';
	}elseif($payroll_type == 'Hourly'){	
		$annual_salary = '';
		$weekly = '';
		$personal_leave = '';
		$bereavement_leave = '';
		$jury_duty_leave = '';
		$sick_day_hrs = '';
		$sick_day_hrs_unpaid = '';
		
		$annual_salary_2 = $rowModule['annual_salary'];
		$weekly_2 = $rowModule['weekly'];
		$personal_leave_2 = $rowModule['personal_leave'];
		$bereavement_leave_2 = $rowModule['bereavement_leave'];
		$jury_duty_leave_2 = $rowModule['jury_duty_leave'];
		$sick_day_hrs_2 = $rowModule['sick_day_hrs'];
		$sick_day_hrs_unpaid_2 = $rowModule['sick_day_hrs_unpaid'];
	}else{
		$annual_salary = '';
		$weekly = '';
		$personal_leave = '';
		$bereavement_leave = '';
		$jury_duty_leave = '';
		$sick_day_hrs = '';
		$sick_day_hrs_unpaid = '';
		
		$annual_salary_2 = '';
		$weekly_2 = '';
		$personal_leave_2 = '';
		$bereavement_leave_2 = '';
		$jury_duty_leave_2 = '';
		$sick_day_hrs_2 = '';
		$sick_day_hrs_unpaid_2 = '';
	}	
}else{
	$snoM = '';
	if($roles1 == 'APRStep'){
		$roleMM = '';
	}else{
		$roleMM = 'Teacher';
	}
	$nameM = '';
	$username2 = '';
	$status2 = '';
	$password = '';
	$added_on = '';
	$designation = '';
	$department = '';
	$emp_code = '';
	$payroll_type = '';
	$weekly = '';
	$date_of_joining = '';
	$date_of_leaving = '';
	$street_address = '';
	$city = '';
	$province = '';
	$country = '';
	$postal_code = '';
	$dob = '';
	$effective_date = '';
	
	$annual_salary = '';
	$weekly = '';
	$personal_leave = '';
	$bereavement_leave = '';
	$jury_duty_leave = '';
	$sick_day_hrs = '';
	$sick_day_hrs_unpaid = '';
	$vacation_leave = '';
	
	$annual_salary_2 = '';
	$weekly_2 = '';
	$personal_leave_2 = '';
	$bereavement_leave_2 = '';
	$jury_duty_leave_2 = '';
	$sick_day_hrs_2 = '';
	$sick_day_hrs_unpaid_2 = '';
}
?>
<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>
<section class="container-fluid">
<div class="main-div card">
	<div class="card-header">
	<h3 class="my-0 py-0" style="font-size: 22px; "><?php echo $AddEditHead;?> <?php echo $InstructorLists;?>
		<a href="teacherLists.php?MVNlY3VSaTR5OQ==" class="text-left btn btn-warning btn-sm ml-sm-2 mt-2 mt-sm-0" style="float:right;"><i class="fas fa-arrow-left"></i> Back to <?php echo $InstructorLists;?> Lists</a>
	</h3>
</div>
<div class="card-body">

<form method="POST" action="" class="forms-sample row" autocomplete="off">
<?php if($roles1 == 'APRStep'){ ?>
  <div class="form-group col-sm-6 col-md-4 col-lg-3">	
	<label>Role:<span style="color:red;">*</span></label>
	<select name="role" class="form-control form-control-sm" required>
		<option value="">Select Option*</option>
		<option value="Teacher" <?php if($roleMM == 'Teacher'){ echo 'selected="selected"'; } ?>>Instructor</option>
		<option value="Other" <?php if($roleMM == 'Other'){ echo 'selected="selected"'; } ?>>Other</option>
	</select>
  </div>
<!--input name="role" type="hidden" value="Teacher"-->
<?php }else{ ?>
<input name="role" type="hidden" value="<?php echo $roleMM; ?>">
<?php } ?>

  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="teachername"><?php echo $InstructorLists;?> Name:<span style="color:red;">*</span></label>
	<input name="name" type="text" class="form-control form-control-sm" id="teachername" placeholder="Enter <?php echo $InstructorLists;?> Name*" value="<?php echo $nameM;?>" required>
  </div>

<div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="username">Username:<span style="color:red;">*</span></label>
	<input type="text" name="username" class="form-control form-control-sm" id="username" placeholder="Enter Username*" value="<?php echo $username2;?>" required>
</div>

<?php if(empty($password)){ ?> 
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="password">Password:<span style="color:red;">*</span></label>
	<input type="password" name="password" class="form-control form-control-sm" id="password" placeholder="Enter Strong Password*" required>
  </div>
<?php } ?>
<div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="emp_code"><?php echo $InstructorLists;?> ID:<span style="color:red;">*</span></label>
	<input type="text" name="emp_code" class="form-control form-control-sm" id="emp_code" placeholder="Enter <?php echo $InstructorLists;?> ID*" value="<?php echo $emp_code;?>">
</div>

<?php if($roles1 == 'APRStep'){ ?>
  <div class="form-group col-sm-6 col-md-4 col-lg-3">	
	<label for="designation">Designation:</label>
	<input type="text" name="designation" class="form-control form-control-sm" id="designation" placeholder="Enter Designation" value="<?php echo $designation;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="department">Department:</label>
	<input type="text" name="department" class="form-control form-control-sm" id="department" placeholder="Enter Department" value="<?php echo $department;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="street_address">Street Address:<span style="color:red;">*</span></label>
	<input type="text" name="street_address" class="form-control form-control-sm"  placeholder="Enter Street Address" value="<?php echo $street_address;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="city">City:<span style="color:red;">*</span></label>
	<input type="text" name="city" class="form-control form-control-sm" id="city" placeholder="Enter City" value="<?php echo $city;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="province">Province:<span style="color:red;">*</span></label>
	<input type="text" name="province" class="form-control form-control-sm" id="province" placeholder="Enter Province" value="<?php echo $province;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="country">Country:<span style="color:red;">*</span></label>
	<input type="text" name="country" class="form-control form-control-sm" id="country" placeholder="Enter Country" value="<?php echo $country;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="postal_code">Postal Code:<span style="color:red;">*</span></label>
	<input type="text" name="postal_code" class="form-control form-control-sm" id="postal_code" placeholder="Enter Postal Code" value="<?php echo $postal_code;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="dob">DOB:<span style="color:red;">*</span></label>
	<input type="text" name="dob" class="form-control form-control-sm datepicker123" placeholder="Enter DOB" value="<?php echo $dob;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="effective_date">Effective Date:</label>
	<input type="text" name="effective_date" class="form-control form-control-sm datepicker123" placeholder="Enter Effective Date" value="<?php echo $effective_date;?>">
  </div> 
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="payroll_type">Payroll type:<span style="color:red;">*</span></label>
	<select name="payroll_type" class="form-control form-control-sm payroll_typeDiv" required>
		<option value="">Select Option*</option>
		<option value="Salaried" <?php if($payroll_type == 'Salaried') { echo 'selected="selected"'; } ?>>Salaried</option>
		<option value="Hourly" <?php if($payroll_type == 'Hourly') { echo 'selected="selected"'; } ?>>Hourly</option>
	</select>
  </div>
  
<?php
if($payroll_type == 'Salaried'){
	$Salariedshow = "display:block;";
}else{
	$Salariedshow = "display:none;";
}

if($payroll_type == 'Hourly'){
	$Hourlyshow = "display:block;";
}else{
	$Hourlyshow = "display:none;";
}
?>

  <div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php echo $Salariedshow; ?>">
	<label for="annual_salary">Annual Salary:($)<span style="color:red;">*</span></label>
	<input type="text" name="annual_salary" class="form-control form-control-sm" id="annual_salary" placeholder="Enter Annual Salary($)*" value="<?php echo $annual_salary;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php echo $Salariedshow; ?>">
	<label for="weekly">Bi Weekly Salary:<span style="color:red;">*</span></label>
	<input type="text" name="weekly" class="form-control form-control-sm weeklyDiv" placeholder="Enter Bi Weekly Salary($)*" value="<?php echo $weekly; ?>">
  </div>
  
  <!--div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php //echo $Salariedshow; ?>">
	<label for="vacation_leave">Annual Vacation:<span style="color:red;">*</span></label>
	<select name="vacation_leave" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php //for($i='0';$i<=20;$i++){ ?>
		<option value="<?php //echo $i;?>" <?php //if($i == $vacation_leave) { echo 'selected="selected"'; } ?>><?php //echo $i; ?></option>
		<?php //} ?>
	</select>
  </div-->
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php echo $Salariedshow; ?>">
	<label for="personal_leave">Personal Leave:<span style="color:red;">*</span>(UnPaid)</label>
	<select name="personal_leave" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i2='0';$i2<=5;$i2++){ ?>
		<option value="<?php echo $i2;?>" <?php if($i2 == $personal_leave) { echo 'selected="selected"'; } ?>><?php echo $i2;?></option>
		<?php } ?>
	</select>
  </div>
  
  <!--div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php echo $Salariedshow; ?>">
	<label for="maternity_leave">Maternity Leave:<span style="color:red;">*</span></label>
	<select name="maternity_leave" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php //for($i5='0';$i5<=20;$i5++){ ?>
		<option value="<?php //echo $i5;?>" <?php //if($i5 == $maternity_leave) { echo 'selected="selected"'; } ?>><?php //echo $i5; ?></option>
		<?php //} ?>
	</select>
  </div-->
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php echo $Salariedshow; ?>">
	<label for="bereavement_leave">Bereavement Leave:<span style="color:red;">*</span>(UnPaid)</label>
	<select name="bereavement_leave" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i6='0';$i6<=3;$i6++){ ?>
		<option value="<?php echo $i6;?>" <?php if($i6 == $bereavement_leave) { echo 'selected="selected"'; } ?>><?php echo $i6;?></option>
		<?php } ?>
	</select>
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php echo $Salariedshow; ?>">
	<label for="jury_duty_leave">Jury Duty Leave:<span style="color:red;">*</span>(Paid)</label>
	<select name="jury_duty_leave" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i7='0';$i7<=1;$i7++){ ?>
		<option value="<?php echo $i7;?>" <?php if($i7 == $jury_duty_leave) { echo 'selected="selected"'; } ?>><?php echo $i7;?></option>
		<?php } ?>
	</select>
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php echo $Salariedshow; ?>">
	<label for="sick_day_hrs">Sick Days:<span style="color:red;">*</span>(Paid)</label>
	<select name="sick_day_hrs" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i3='0';$i3<=5;$i3++){ ?>
		<option value="<?php echo $i3;?>" <?php if($i3 == $sick_day_hrs) { echo 'selected="selected"'; } ?>><?php echo $i3;?></option>
		<?php } ?>
	</select>
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 SalariedDiv" style="<?php echo $Salariedshow; ?>">
	<label for="sick_day_hrs_unpaid">Sick Days:<span style="color:red;">*</span>(UnPaid)</label>
	<select name="sick_day_hrs_unpaid" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i3='0';$i3<=3;$i3++){ ?>
		<option value="<?php echo $i3;?>" <?php if($i3 == $sick_day_hrs) { echo 'selected="selected"'; } ?>><?php echo $i3;?></option>
		<?php } ?>
	</select>
  </div>
 
<!--- Hourly --->
 
  <div class="form-group col-sm-6 col-md-4 col-lg-3 HourlyDiv" style="<?php echo $Hourlyshow; ?>">
	<label for="annual_salary_2">Per Hours:($)<span style="color:red;">*</span></label>
	<input type="text" name="annual_salary_2" class="form-control form-control-sm" id="annual_salary_2" placeholder="Enter Per Hours($)" value="<?php echo $annual_salary_2;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 HourlyDiv" style="<?php echo $Hourlyshow; ?>">
	<label for="sick_day_hrs_2">Sick Hours:<span style="color:red;">*</span>(Paid)</label>
	<select name="sick_day_hrs_2" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i4='0';$i4<=5;$i4++){ ?>
		<option value="<?php echo $i4;?>" <?php if($i4 == $sick_day_hrs_2) { echo 'selected="selected"'; } ?>><?php echo $i4;?></option>
		<?php } ?>
	</select>
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 HourlyDiv" style="<?php echo $Hourlyshow; ?>">
	<label for="sick_day_hrs_unpaid_2">Sick Hours:<span style="color:red;">*</span>(UnPaid)</label>
	<select name="sick_day_hrs_unpaid_2" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i4_2='0';$i4_2<=3;$i4_2++){ ?>
		<option value="<?php echo $i4_2;?>" <?php if($i4_2 == $sick_day_hrs_unpaid_2) { echo 'selected="selected"'; } ?>><?php echo $i4_2;?></option>
		<?php } ?>
	</select>
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 HourlyDiv" style="<?php echo $Hourlyshow; ?>">
	<label for="personal_leave_2">Personal Leave:<span style="color:red;">*</span>(UnPaid)</label>
	<select name="personal_leave_2" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i2_2='0';$i2_2<=5;$i2_2++){ ?>
		<option value="<?php echo $i2_2;?>" <?php if($i2_2 == $personal_leave_2) { echo 'selected="selected"'; } ?>><?php echo $i2_2;?></option>
		<?php } ?>
	</select>
  </div>
  
  <!--div class="form-group col-sm-6 col-md-4 col-lg-3 HourlyDiv" style="<?php //echo $Hourlyshow; ?>">
	<label for="maternity_leave_2">Maternity Leave:<span style="color:red;">*</span></label>
	<select name="maternity_leave_2" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php //for($i51='0';$i51<=20;$i51++){ ?>
		<option value="<?php //echo $i51;?>" <?php //if($i51 == $maternity_leave) { echo 'selected="selected"'; } ?>><?php //echo $i51;?></option>
		<?php //} ?>
	</select>
  </div-->
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 HourlyDiv" style="<?php echo $Hourlyshow; ?>">
	<label for="bereavement_leave_2">Bereavement Leave:<span style="color:red;">*</span>(UnPaid)</label>
	<select name="bereavement_leave_2" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i62='0';$i62<=3;$i62++){ ?>
		<option value="<?php echo $i62;?>" <?php if($i62 == $bereavement_leave_2) { echo 'selected="selected"'; } ?>><?php echo $i62;?></option>
		<?php } ?>
	</select>
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3 HourlyDiv" style="<?php echo $Hourlyshow; ?>">
	<label for="jury_duty_leave_2">Jury Duty Leave:<span style="color:red;">*</span>(Paid)</label>
	<select name="jury_duty_leave_2" class="form-control form-control-sm">
		<option value="">Select Option*</option>
		<?php for($i73='0';$i73<=1;$i73++){ ?>
		<option value="<?php echo $i73;?>" <?php if($i73 == $jury_duty_leave_2) { echo 'selected="selected"'; } ?>><?php echo $i73;?></option>
		<?php } ?>
	</select>
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="date_of_joining">Date of Joining:<span style="color:red;">*</span></label>
	<input type="text" name="date_of_joining" class="form-control form-control-sm datepicker123" id="date_of_joining" placeholder="Date of Joining*" value="<?php echo $date_of_joining;?>">
  </div>
  
  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label for="date_of_leaving">Date of Leaving:</label>
	<input type="text" name="date_of_leaving" class="form-control form-control-sm datepicker123" id="date_of_leaving" placeholder="Date of Leaving" value="<?php echo $date_of_leaving;?>">
  </div> 

<?php }else{ ?>
<div class="form-group col-sm-6 col-md-4 col-lg-3">
<label for="payroll_type">Payroll type:<span style="color:red;">*</span></label>
<select name="payroll_type" class="form-control form-control-sm" required>
	<option value="">Select Option*</option>
	<option value="Salaried" <?php if($payroll_type == 'Salaried') { echo 'selected="selected"'; } ?>>Salaried</option>
	<option value="Hourly" <?php if($payroll_type == 'Hourly') { echo 'selected="selected"'; } ?>>Hourly</option>
</select>
</div>
<input name="designation" type="hidden" value="<?php echo $designation; ?>">
<input name="department" type="hidden" value="<?php echo $department; ?>">
<input name="date_of_joining" type="hidden" value="<?php echo $date_of_joining; ?>">
<input name="date_of_leaving" type="hidden" value="<?php echo $date_of_leaving; ?>">
<input name="street_address" type="hidden" value="<?php echo $street_address; ?>">
<input name="city" type="hidden" value="<?php echo $city; ?>">
<input name="province" type="hidden" value="<?php echo $province; ?>">
<input name="country" type="hidden" value="<?php echo $country; ?>">
<input name="postal_code" type="hidden" value="<?php echo $postal_code; ?>">
<input name="dob" type="hidden" value="<?php echo $dob; ?>">
<input name="effective_date" type="hidden" value="<?php echo $effective_date; ?>">

<!--- <input name="vacation_leave" type="hidden" value="<?php //echo $vacation_leave;?>">
<input name="annual_salary" type="hidden" value="<?php //echo $annual_salary;?>">
<input name="personal_leave" type="hidden" value="<?php //echo $personal_leave;?>">
<input name="maternity_leave" type="hidden" value="<?php //echo $maternity_leave ;?>">
<input name="sick_day_hrs" type="hidden" value="<?php //echo $sick_day_hrs;?>">
<input name="maternity_leave" type="hidden" value="<?php //echo $maternity_leave;?>">
<input name="bereavement_leave" type="hidden" value="<?php //echo $bereavement_leave;?>">
<input name="jury_duty_leave" type="hidden" value="<?php //echo $jury_duty_leave;?>"> --->
<?php } ?>

  <div class="form-group col-sm-6 col-md-4 col-lg-3">
	<label>Status:<span style="color:red;">*</span></label>
	<select name="status" class="form-control form-control-sm" required>
	<?php if(empty($snoM)){ ?>
		<option value="1" selected="selected">Active</option>
		<option value="2">De-Active</option>
	<?php }else{ ?>
		<option value="">Select Option*</option>
		<option value="1" <?php if($status2 == '1') { echo 'selected="selected"'; } ?>>Active</option>
		<option value="2" <?php if($status2 == '2') { echo 'selected="selected"'; } ?>>De-Active</option>
	<?php } ?>
	</select>
  </div>
 <div class="form-group col-sm-12 col-md-4 col-lg-3 pt-md-2">
	<input type="hidden" name="loggedId" value="<?php echo $sessionid1; ?>">
	<input type="hidden" name="snom" value="<?php echo $snoM; ?>">
  <button name="sbmtTeacher" type="submit" class="btn btn-sm btn-success float-right float-md-left mt-md-4">Submit</button>
</div>
</form>
	  
</div>
</div>
</div>
</div>
</section>

<script>
$(document).on('change', '.payroll_typeDiv', function(){
	var getVal = $(this).val();
	if(getVal == 'Salaried'){
		$('.SalariedDiv').show();
		$('.HourlyDiv').hide();
		// $('.weeklyDiv').attr('value', '26');
	}
	
	if(getVal == 'Hourly'){
		$('.SalariedDiv').hide();
		$('.HourlyDiv').show();
	}
	
	if(getVal == ''){
		$('.SalariedDiv').hide();
		$('.HourlyDiv').hide();
	}
});
</script>

<script>
  $( function() {
    $(".datepicker123").datepicker({	  
		dateFormat: 'yy-mm-dd', 
		changeMonth: true, 
		changeYear: true,
		yearRange: "-80:+0"
    });
  });
</script>
