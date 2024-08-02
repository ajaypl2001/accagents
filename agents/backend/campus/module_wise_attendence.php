<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");
date_default_timezone_set("America/Toronto");

// if($roles1 == 'ClgCM' || $roles1 == 'ClgAttd'){

// } else {
// 	header("Location: ../../login");
//     exit();
// }

if(isset($_POST['srchClassBtn'])){
	$inatke = $_POST['inatke'];
	$instructor_name = $_POST['instructor_name'];
	$shift_time = $_POST['shift_time'];
	$program_name = $_POST['program_name'];
	$module_name = $_POST['module_name'];
	$startDate2 = $_POST['msdate'];
	$first_date = $_POST['first_date'];
	$last_date = $_POST['last_date'];
	header("Location: ../campus/module_wise_attendence.php?intke=$inatke&instorName=$instructor_name&shiftTime=$shift_time&progName=$program_name&mdleName=$module_name&msdate=$startDate2&first_date=$first_date&last_date=$last_date");
}

if(!empty($_GET['intke'])){
	$intke2 = $_GET['intke'];
}else{
	$intke2 = '';
}

if(!empty($_GET['instorName'])){
	$instorName2 = $_GET['instorName'];
}else{
	$instorName2 = '';
}

if(!empty($_GET['shiftTime'])){
	$shiftTime2 = $_GET['shiftTime'];
}else{
	$shiftTime2 = '';
}

if(!empty($_GET['progName'])){
	$progName2 = $_GET['progName'];
}else{
	$progName2 = '';
}

if(!empty($_GET['mdleName'])){
	$mdleName2 = $_GET['mdleName'];
}else{
	$mdleName2 = '';
}

if(!empty($_GET['first_date'])){
	$first_date2 = $_GET['first_date'];
}else{
	$first_date2 = '';
}

if(!empty($_GET['last_date'])){
	$last_date2 = $_GET['last_date'];
}else{
	$last_date2 = '';
}

if(!empty($_GET['msdate'])){
	$msdate3 = $_GET['msdate'];	
}else{
	$msdate3 = '';
}

$getQry4="SELECT sno, module_start_date FROM `m_batch` WHERE m_intake='$intke2' AND teacher_id='$instorName2' AND shift_time='$shiftTime2' AND program_name='$progName2'";
$getRslt4=mysqli_query($con, $getQry4);
if(mysqli_num_rows($getRslt4)){
	$datacouns4=mysqli_fetch_array($getRslt4);
	$module_start_date = $datacouns4['module_start_date'];
}else{
	$module_start_date = '';
}
?> 
<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>

<link rel="stylesheet" type="text/css" href="../../css/fixed-table.css">
<script src="../../js/fixed-table.js"></script>

<section class="container-fluid">
<div class="main-div card">
<div class="card-header">
<h3 class="my-0 py-0" >Module Wise Attendence</h3>
</div>
<div class="card-body">

<form action="" class="bg-white row mb-2 p-2" method="POST">

	<div class="col-sm-6 col-md-4 col-lg-2 mb-3">
		<label>Filter by Intake</label>
	<select name="inatke" class="form-control form-control-sm inatke" required>
		<option value="May-2024" <?php if($intke2 == 'May-2024'){ echo 'selected="selected"'; } ?>>May-2024</option>
	</select>
	</div>
	<div class="col-sm-6 col-md-4 col-lg-2 mb-3">
		<label>Filter by Instructor</label>
		<select name="instructor_name" class="form-control form-control-sm InstructorName" required>
			<option value="">Select Instructor</option>	
			<?php		
			$counselor = "select sno, name from m_teacher where status='1' AND role='Teacher'";
			$counselorres = mysqli_query($con, $counselor);
			while($datacouns = mysqli_fetch_assoc($counselorres)){
				$sno33 = $datacouns['sno'];
				$name33 = $datacouns['name'];
			?>
			<option value="<?php echo $sno33; ?>"<?php if($sno33 == $instorName2){ echo 'selected="selected"'; } ?>><?php echo $name33; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="col-sm-6 col-md-4 col-lg-2 mb-3">
		<label>Filter by Time</label>
		<select name="shift_time" class="py-1 px-2 form-control form-control-sm shiftTimeDiv" data-Inst="<?php echo $instorName2; ?>" required>
			<option value="">Select Time</option>
		<?php
		$getQry="SELECT shift_time FROM `m_batch` WHERE m_intake!='' AND m_intake='$intke2' AND teacher_id!='' AND teacher_id='$instorName2' group by shift_time";
		$getRslt=mysqli_query($con, $getQry);
		if(mysqli_num_rows($getRslt)){
			while ($datacouns2=mysqli_fetch_array($getRslt)){
			$shift_time = $datacouns2['shift_time'];
			if($shift_time == $shiftTime2){
				$selectedDiv = 'selected="selected"';				
			}else{
				$selectedDiv = '';				
			}
			echo '<option value="'.$shift_time.'" '.$selectedDiv.'>'.$shift_time.'</option>';
			}
		}
		?>
		</select>
	</div>
	
	<div class="col-sm-6 col-md-4 col-lg-2 mb-3">
		<label>Filter by Program</label>
		<select name="program_name" class="py-1 px-2 form-control form-control-sm prgmDiv" data-Inst="<?php echo $instorName2; ?>" required>
			<option value="" data-sd="">Select Option</option>
			<?php
			$getQry2="SELECT sno, program_name, module_start_date FROM `m_batch` WHERE m_intake!='' AND m_intake='$intke2' AND teacher_id!='' AND teacher_id='$instorName2' AND shift_time='$shiftTime2' group by program_name";
			$getRslt2=mysqli_query($con, $getQry2);
			if(mysqli_num_rows($getRslt2)){
				while ($datacouns22=mysqli_fetch_array($getRslt2)){
					$program_name22 = $datacouns22['program_name'];
					$module_start_date22 = $datacouns22['module_start_date'];
					if($program_name22 == $progName2){
						$selectedDiv2 = 'selected="selected"';				
					}else{
						$selectedDiv2 = '';				
					}
					echo '<option value="'.$program_name22.'" data-sd="'.$module_start_date22.'" '.$selectedDiv2.'>'.$program_name22.'</option>';
				}
			}
			?>
		</select>
	</div>
	
	<div class="col-sm-6 col-md-4 col-lg-2 mb-3">
		<label>Filter by Module</label>
		<select name="module_name" class="py-1 px-2 form-control form-control-sm moduleDiv">
			<option value="">Select Option</option>
			<?php
			$getQry3="SELECT module_name FROM `m_program_lists` WHERE program2!='' AND program2='$progName2' group by module_name ORDER BY sno asc";
			$getRslt3=mysqli_query($con, $getQry3);
			if(mysqli_num_rows($getRslt3)){
				$srnoCnt=1;
				while ($datacouns3=mysqli_fetch_array($getRslt3)){
					$module_name3 = $datacouns3['module_name'];
					if($module_name3 == $mdleName2){
						$selectedDiv3 = 'selected="selected"';				
					}else{
						$selectedDiv3 = '';				
					}
					
					$dddf = $srnoCnt++;
					if($dddf == 1){
						$mdys = 28;
						$getaddDays = date('Y-m-d', strtotime($msdate3. ' + '.$mdys.' days'));
					}else{
						$mdys = 28+1;
						$getaddDays = date('Y-m-d', strtotime($getaddDays. ' + '.$mdys.' days'));
						$msdate3 = date('Y-m-d', strtotime($msdate3. ' + '.$mdys.' days'));
					}
					
					echo  '<option value="'.$module_name3.'" first_date="'.$msdate3.'" last_date="'.$getaddDays.'" '.$selectedDiv3.'>'.$module_name3.'</option>';
				}
			}
			?>
		</select>
	</div>
		
	<div class="col-sm-6 col-md-4 col-lg-2 mt-sm-4 pt-sm-1 mb-3">
		<input type="hidden" name="msdate" class="startDate" value="<?php echo $module_start_date; ?>">
		<input type="hidden" name="first_date" class="first_date" value="<?php echo $first_date2; ?>">
		<input type="hidden" name="last_date" class="last_date" value="<?php echo $last_date2; ?>">
		<button button="submit" name="srchClassBtn" Class="btn btn-success btn-sm float-sm-left float-right" value="submit">Submit</button>
	</div>
</form>

<div class="row">
<?php
if(!empty($mdleName2)){
?>
<div class="col-12">	
<div id="accordion">
	<div class="card">
    <div class="card-header">
    <a class="card-link" data-toggle="collapse" href="#first35">
	<?php echo $mdleName2; ?> &nbsp;&nbsp;&nbsp;&nbsp;
	COURSE DATES: <?php echo $first_date2; ?> to <?php echo $last_date2; ?> 
	</a>
	<form method="POST" action="excelSheet.php" autocomplete="off">
		<input type="hidden" name="role2" value="ClgCM">
		<input type="hidden" name="type2" value="Program_Wise">
		<input type="hidden" name="program_name2" value="Business Administration">
		<button type="submit" name="studentlist" class="btn btn-sm btn-success Download-btn float-sm-right">Download Excel</button>
	</form>
    </div>
    <div id="first35" class="collapse show in" data-parent="#accordion">
    <div class="card-body">
    <div id="fixed-table-container-1" class="fixed-table-container" style="overflow: auto; position: relative;">
	<table class="table table-sm table-bordered" width="100%">
    <thead style="top: 0px; z-index: 10;">	  
      <tr>
        <th rowspan="2">Start Date</th>
        <th rowspan="2">Student ID#</th>
        <th rowspan="2">Student Name</th>
        <th rowspan="2">Status</th>
		<?php		
		$startTime = strtotime("$first_date2");
		$endTime = strtotime("$last_date2");
		for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
		  $newDate = date('M', $i); 
		  $d = date('d', $i); 
		?>
			<th><?php echo $d.'-'.$newDate; ?></th>
		<?php } ?>
	        <th>Avg/5</th>
			<th>Count</th>      
      </tr> 
      <tr>
	  <?php
		for ( $i2 = $startTime; $i2 <= $endTime; $i2 = $i2 + 86400 ) {
		  $dateGet2 = date('Y-m-d', $i2);
		  $dateGet3[] = date('Y-m-d', $i2);
		  $newDays2 = date('D', strtotime($dateGet2));
		  $getFLD = substr($newDays2,0,1);
	  ?>
        <th style="background: #437f3a;"><?php echo $getFLD; ?></th>
	  <?php } ?>
		<th></th>
		<th></th>      
      </tr>
    </thead>
	
    <tbody>
<?php
$rsltQuery = "SELECT both_main_table.sno, both_main_table.fname, both_main_table.lname, both_main_table.email_address, both_main_table.student_id, both_main_table.prg_name1, both_main_table.prg_intake, m_student.app_id, m_student.teacher_id, m_student.betch_no
FROM m_student
INNER JOIN both_main_table ON m_student.app_id=both_main_table.sno
WHERE m_student.teacher_id!='' AND m_student.teacher_id='$instorName2' AND m_student.program='$progName2' AND m_student.shift_time='$shiftTime2' order by m_student.updated_on DESC";
$qurySql = mysqli_query($con, $rsltQuery);
if(mysqli_num_rows($qurySql)){
while ($row_nm = mysqli_fetch_assoc($qurySql)){
	$snoid_3 = $row_nm['sno'];				
	$fname = $row_nm['fname'];				
	$lname = $row_nm['lname'];
	$fullname = ucfirst($fname).' '.ucfirst($lname);
	$email_address = $row_nm['email_address'];
	$student_id = $row_nm['student_id'];
	$prg_name1 = $row_nm['prg_name1'];
	$prg_intake = $row_nm['prg_intake'];
	
	$queryGet2 = "SELECT app_id, with_dism FROM `start_college` WHERE with_dism!='' AND app_id='$snoid_3'";
	$queryRslt2 = mysqli_query($con, $queryGet2);
	if(mysqli_num_rows($queryRslt2)){
		$rowSC = mysqli_fetch_assoc($queryRslt2);	
		$with_dism = $rowSC['with_dism'];
	}else{
		$with_dism = '<span style="color:red;">No Action</span>';		
	}
	
	$queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
	$queryRslt4 = mysqli_query($con, $queryGet4);
	$rowSC4 = mysqli_fetch_assoc($queryRslt4);
	$start_date = $rowSC4['commenc_date'];
?>	
	<tr>
        <td><?php echo $start_date; ?></td>
        <td>
		<span class="btn-link statusClass" data-toggle="modal" data-target="#statusModal" data-id="<?php echo $snoid_3; ?>" fullstName="<?php echo $fullname; ?>"><?php echo $student_id; ?></span>
		</td>
        <td class="text-nowrap"><?php echo $fullname; ?></td>
        <td class="text-nowrap"><?php echo $with_dism; ?></td>
	<?php
	foreach($dateGet3 as $dateGet4){
	$rsltAttendance = "SELECT sno, date_at, status FROM m_attendance where date_at!='' AND date_at='$dateGet4' AND program='$progName2' AND shift_time='$shiftTime2' AND app_id='$snoid_3' AND teacher_id='$instorName2' AND module_name='$mdleName2'";
	$queryAttendance = mysqli_query($con, $rsltAttendance);
	$presentNo = mysqli_num_rows($queryAttendance);
	if($presentNo){
		$rowAttendance = mysqli_fetch_assoc($queryAttendance);
		$status = $rowAttendance['status'];
		if($status == '0'){
			$bkgrndDiv = "style='background:#fafaaa;'";
		}else{
			$bkgrndDiv = '';			
		}
	}else{
		$status = '';
		$bkgrndDiv = '';
	}
	?>
        <td <?php echo $bkgrndDiv; ?>><?php echo $status; ?></td>
	<?php } ?>
	<?php
	$rsltAttendance3 = "SELECT SUM(status) as totalh, sum(if(status='0',1,0)) as absent, sum(if(status!='0',1,0)) as present FROM m_attendance where date_at!='' AND (date_at BETWEEN '$first_date2' AND '$last_date2') AND program='$progName2' AND shift_time='$shiftTime2' AND app_id='$snoid_3' AND teacher_id='$instorName2' AND module_name='$mdleName2'";	
	$queryAttendance3 = mysqli_query($con, $rsltAttendance3);
	$totalid3 = mysqli_num_rows($queryAttendance3);
	if($totalid3){
		$rowAttDiv3 = mysqli_fetch_assoc($queryAttendance3);
		$totalh3 = $rowAttDiv3['totalh'];
		$absent = $rowAttDiv3['absent'];
		$present = $rowAttDiv3['present'];
		if($present == '0' || $present == NULL){
			$rngAvrge = '0';
		}else{
			$rngAvrge2 = ($totalh3/$present);
			$rngAvrge = round(($rngAvrge2/5)*100);
		}
		
		if($absent == '0' || $absent == NULL){
			$NoOfAbsent = '0';
		}else{			
			$NoOfAbsent = $absent;
		}
	}else{
		$rngAvrge = '0';
		$NoOfAbsent = '0';
	}
	if(($NoOfAbsent >= '1' && $NoOfAbsent <= '4') && $NoOfAbsent!='0'){		
		$bkgrndAbntDiv = "style='background:#fafaaa;'";
	}elseif(($NoOfAbsent >= '5' && $NoOfAbsent <= '9') && $NoOfAbsent!='0'){		
		$bkgrndAbntDiv = "style='background:orange;'";
	}elseif(($NoOfAbsent >= '10') && $NoOfAbsent!='0'){		
		$bkgrndAbntDiv = "style='background:#f27a7a;'";
	}else{
		$bkgrndAbntDiv = '';		
	}
	?>
		<td><?php echo $rngAvrge; ?>%</td>      
        <td <?php echo $bkgrndAbntDiv; ?>><?php echo $NoOfAbsent; ?></td>     
      </tr>
<?php }
} ?>	
    </tbody>	
	</table>  
	</div>
      </div>
    </div>
  </div>

</div>
</div>
	
<?php } ?>
</div>
</div>
</div>
</section>

<div class="modal" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span class="showFullName"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body getStDetails"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<script>
$(document).on('change', '.InstructorName', function(){
	var inatke = $('.inatke').val();
	var instName = $(this).val();
	$('.shiftTimeDiv').attr('data-inst', instName);
	$.post("response.php?tag=getInstructorName",{"inatke":inatke, "instName":instName},function(d){		
		$('.shiftTimeDiv').html("");
		$(''+ d[0].shiftTimeDiv + '').appendTo(".shiftTimeDiv");	
	});
});

$(document).on('change', '.shiftTimeDiv', function(){
	var inatke = $('.inatke').val();
	var shiftTime = $(this).val();
	var instName = $(this).attr('data-inst');
	$.post("response.php?tag=getPrgmName",{"inatke":inatke, "instName":instName, "shiftTime":shiftTime},function(d){		
		$('.prgmDiv').html("");
		$(''+ d[0].prgmDiv + '').appendTo(".prgmDiv");	
	});
});

$(document).on('change', '.prgmDiv', function(){
	var getPrgm = $(this).val();
	var getStDate = $('option:selected', this).attr('data-sd');
	$('.startDate').attr('value', getStDate);
	$.post("response.php?tag=getmoduleNamePW",{"getPrgm":getPrgm, "getStDate":getStDate},function(d){		
		$('.moduleDiv').html("");
		$(''+ d[0].moduleDiv + '').appendTo(".moduleDiv");	
	});
});

$(document).on('change', '.moduleDiv', function(){
	var first_date = $('option:selected', this).attr('first_date');
	var last_date = $('option:selected', this).attr('last_date');
	$('.first_date').attr('value', first_date);
	$('.last_date').attr('value', last_date);
});
</script>

<script type="text/javascript">
$(document).on('click', '.statusClass', function () {
	var getVal = $(this).attr('data-id');
	var getFullName = $(this).attr('fullstName');
	$('.showFullName').html(getFullName);
	$.post("response.php?tag=getStDetailsDiv",{"snoid":getVal},function(obj12){
		$('.getStDetails').html("");
		$('' + obj12[0].getStDetails +'').appendTo(".getStDetails");
	});
});
</script>

<script>
  var fixedTable1 = fixTable(document.getElementById('fixed-table-container-1'));
</script>

<style>
.fixed-table-container th, .fixed-table-container td { padding:2px 5px !important; font-size:13px; }
.fixed-table-container tr:first-child th { background:#437f3a;}
</style>