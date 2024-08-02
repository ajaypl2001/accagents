<?php
ob_start();
include("../db.php");
include("../header.php");
date_default_timezone_set("America/Toronto");
$date_at = date('Y-m-d');
$getCrntDateFind = strtotime($date_at);

if($roles1 == 'Teacher'){
	// $getQry33="SELECT sno, module_name FROM `m_module_start_end_date` where teacher_id='$loggedId' AND status!='Complete' limit 1";
	// $getRslt33=mysqli_query($conInt, $getQry33);
	// if(mysqli_num_rows($getRslt33) == '0'){
		// header("Location: ../lists/module_wise_attendence_new.php?T3ZlckFsbEVBdHRlbmRhbmNl");
	// }
} else {
	header("Location: ../login");
    exit();
}

if(isset($_POST['srchClassBtn'])){
	$inatke = $_POST['inatke'];
	$instructor_name = $loggedId;
	$shift_time = $_POST['shift_time'];
	$program_name = $_POST['program_name'];
	$module_name = $_POST['module_name'];
	$startDate2 = $_POST['msdate'];
	$first_date = $_POST['first_date'];
	$last_date = $_POST['last_date'];
	header("Location: ../lists/module_wise_attendence_new.php?intke=$inatke&instorName=$instructor_name&shiftTime=$shift_time&progName=$program_name&mdleName=$module_name&msdate=$startDate2&first_date=$first_date&last_date=$last_date");
}

if(!empty($_GET['intke'])){
	$intke2 = $_GET['intke'];
}else{
	$intke2 = 'May-2024';
}

if(!empty($_GET['instorName'])){
	$instorName2 = $loggedId;
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
	$getLastDateFind = strtotime($last_date2);
}else{
	$last_date2 = '';
	$getLastDateFind = '';
}

if(!empty($_GET['msdate'])){
	$msdate3 = $_GET['msdate'];	
}else{
	$msdate3 = '';
}

$getQry4="SELECT sno, batch_name, module_start_date FROM `m_batch` WHERE m_intake='$intke2' AND teacher_id='$instorName2' AND shift_time='$shiftTime2' AND program_name='$progName2'";
$getRslt4=mysqli_query($conInt, $getQry4);
if(mysqli_num_rows($getRslt4)){
	$datacouns4=mysqli_fetch_array($getRslt4);
	$bid = $datacouns4['sno'];
	$module_start_date = $datacouns4['module_start_date'];
	$batch_name = $datacouns4['batch_name'];
}else{
	$bid = '';
	$module_start_date = '';
	$batch_name = '';
}
?> 
<style>
.error_color{border:2px solid #de0e0e;}
.validError{border:2px solid #ccc;}
</style>

<link rel="stylesheet" type="text/css" href="../css/fixed-table.css">
<script src="../js/fixed-table.js"></script>

<section class="container-fluid">
<div class="main-div card">
<div class="card-header">
<h3 class="my-0 py-0" >Student Wise Attendence</h3>
</div>
<div class="card-body">

<form action="" class="bg-white row mb-2 p-2" method="POST">

	<div class="col-sm-6 col-md-4 col-lg-2 mb-3">
		<label>Filter by Intake</label>
	<select name="inatke" class="form-control inatke" required>	
			<option value="">Select Intake</option>		
		<?php		
			$intakeQry = "select sno, m_intake from m_batch where status='1' AND teacher_id='$loggedId' group by m_intake";
			$intakeRslt = mysqli_query($conInt, $intakeQry);
			while($intakeRow = mysqli_fetch_assoc($intakeRslt)){
				$sno33 = $intakeRow['sno'];
				$m_intake33 = $intakeRow['m_intake'];
			?>
			<option value="<?php echo $m_intake33; ?>"<?php if($m_intake33 == $intke2){ echo 'selected="selected"'; } ?>><?php echo $m_intake33; ?></option>
			<?php } ?>
	</select>
	</div>
	<div class="col-sm-6 col-md-4 col-lg-2 mb-3">
		<label>Filter by Instructor</label>
		<select name="instructor_name" class="form-control InstructorName" required>
			<option value="">Select Instructor</option>	
			<?php		
			$counselor = "select sno, name from m_teacher where status='1' AND role='Teacher' AND sno='$loggedId'";
			$counselorres = mysqli_query($conInt, $counselor);
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
		<select name="shift_time" class="py-1 px-2 form-control shiftTimeDiv" data-Inst="<?php echo $instorName2; ?>" required>
			<option value="">Select Time</option>
		<?php
		$getQry="SELECT shift_time FROM `m_batch` WHERE m_intake!='' AND m_intake='$intke2' AND teacher_id!='' AND teacher_id='$instorName2' group by shift_time";
		$getRslt=mysqli_query($conInt, $getQry);
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
		<select name="program_name" class="py-1 px-2 form-control prgmDiv" data-Inst="<?php echo $instorName2; ?>" required>
			<option value="" data-sd="">Select Option</option>
			<?php
			$getQry2="SELECT sno, program_name, module_start_date FROM `m_batch` WHERE m_intake='$intke2' AND teacher_id='$instorName2' AND shift_time='$shiftTime2' group by program_name";
			$getRslt2=mysqli_query($conInt, $getQry2);
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
		<select name="module_name" class="py-1 px-2 form-control moduleDiv">
			<option value="">Select Option</option>
			<?php
			$getQry3="SELECT sno, module_name, start_date, end_date FROM `m_module_start_end_date` where intake='$intke2' AND teacher_id='$instorName2' AND shift_time='$shiftTime2' AND prog_name='$progName2' AND status!='Complete'";
			$getRslt3=mysqli_query($conInt, $getQry3);
			if(mysqli_num_rows($getRslt3)){
				$srnoCnt=1;
				while ($rowMSE=mysqli_fetch_array($getRslt3)){
					$module_name3 = $rowMSE['module_name'];
					if($module_name3 == $mdleName2){
						$selectedDiv3 = 'selected="selected"';				
					}else{
						$selectedDiv3 = '';				
					}
					$start_date = $rowMSE['start_date'];
					$end_date = $rowMSE['end_date'];
					
					echo  '<option value="'.$module_name3.'" first_date="'.$start_date.'" last_date="'.$end_date.'" '.$selectedDiv3.'>'.$module_name3.'</option>';
				}
			}
			?>
		</select>
	</div>
		
	<div class="col-sm-6 col-md-4 col-lg-2 mt-sm-4 pt-1 mb-3">
		<input type="hidden" name="msdate" class="startDate form-control" value="<?php echo $module_start_date; ?>">
		<input type="hidden" name="first_date" class="first_date form-control" value="<?php echo $first_date2; ?>">
		<input type="hidden" name="last_date" class="last_date form-control" value="<?php echo $last_date2; ?>">
		<button button="submit" name="srchClassBtn" Class="btn btn-success float-sm-start float-end" value="submit">Submit</button>
	</div>
</form>

<div class="row">
<?php
if(!empty($mdleName2)){

// $getBatchQry = "SELECT batch_name FROM `m_batch` WHERE program_name='$progName2' AND shift_time='$shiftTime2' AND teacher_id='$instorName2' AND m_intake='$intke2'";
// $rsltBatch = mysqli_query($conInt, $getBatchQry);
// $dataBatch = mysqli_fetch_assoc($rsltBatch);
// $batch_name = $dataBatch['batch_name'];
?>
<div class="col-12">	
<div >
	<div class="card">
    <div class="card-header"  href="#first35" aria-expanded="false">
 <h5 class="my-0">
    <a class="card-link" >
	<?php echo $mdleName2; ?> &nbsp;&nbsp;&nbsp;&nbsp;
	COURSE DATES: <?php echo $first_date2; ?> to <?php echo $last_date2; ?> 
	</a></h5>
	    <form method="POST"  style="float:right; margin-top: -35px;" action="excelSheet.php" autocomplete="off">
		<input type="hidden" name="role2" value="ClgCM">
		<input type="hidden" name="type2" value="Program_Wise">
		<input type="hidden" name="program_name2" value="Business Administration">
		<button type="submit" name="studentlist" class="btn btn-sm btn-link float-sm-right"><img src="../images/xlsx.png" width="30"></button>
	</form>
    </div>

    <div id="first35" class=" show in"  >
    <div class="card-body">
    <!-- <div id="fixed-table-container-1" class="fixed-table-container" style="overflow: auto; position: relative;"> -->
    	<div class="table-responsive secondaryContainer">
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
$rsltQuery = "SELECT st_application.sno, st_application.fname, st_application.lname, st_application.email_address, st_application.student_id, st_application.prg_name1, st_application.prg_intake, m_student.app_id, m_student.teacher_id, m_student.betch_no
FROM m_student
INNER JOIN st_application ON m_student.app_id=st_application.sno
WHERE m_student.teacher_id!='' AND m_student.teacher_id='$instorName2' AND m_student.program='$progName2' AND m_student.shift_time='$shiftTime2' AND m_student.betch_no='$bid' ORDER BY FIND_IN_SET(st_application.student_status, 'Graduate,Re-enrolled,Started,Dismissed,Withdrawal')";
$qurySql = mysqli_query($conInt, $rsltQuery);
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
	
	$queryGet2 = "SELECT app_id, with_dism FROM `start_college` WHERE with_dism!='' AND app_id='$snoid_3' ORDER BY sno DESC";
	$queryRslt2 = mysqli_query($conInt, $queryGet2);
	if(mysqli_num_rows($queryRslt2)){
		$rowSC = mysqli_fetch_assoc($queryRslt2);	
		$with_dism2 = $rowSC['with_dism'];
		if($with_dism2 == 'Dismissed' || $with_dism2 == 'Withdrawal'){
			$with_dism = '<span style="color:red;">'.$with_dism2.'</span>';
			$with_dismDisAbled = 'disabled';
		}else{
			$with_dism = $with_dism2;
			$with_dismDisAbled = '';
		}
	}else{
		$with_dism = '<span style="color:red;">No Action</span>';
		$with_dismDisAbled = '';	
	}
	
	$queryGet4 = "SELECT commenc_date, expected_date FROM `contract_courses` WHERE program_name='$prg_name1' AND intake='$prg_intake'";
	$queryRslt4 = mysqli_query($conInt, $queryGet4);
	$rowSC4 = mysqli_fetch_assoc($queryRslt4);
	$start_date = $rowSC4['commenc_date'];
?>	
	<tr>
        <td><?php echo $start_date; ?></td>
        <td>
		<span class="btn-link statusClass" data-bs-toggle="modal" data-bs-target="#statusModal" data-id="<?php echo $snoid_3; ?>" fullstName="<?php echo $fullname; ?>"><?php echo $student_id; ?></span>
		</td>
        <td class="text-nowrap"><?php echo $fullname; ?></td>
        <td class="text-nowrap"><?php echo $with_dism; ?></td>
	<?php
	foreach($dateGet3 as $dateGet4){
	$rsltAttendance = "SELECT sno, date_at, status FROM m_attendance where date_at!='' AND date_at='$dateGet4' AND program='$progName2' AND shift_time='$shiftTime2' AND app_id='$snoid_3' AND teacher_id='$instorName2' AND module_name='$mdleName2'";
	$queryAttendance = mysqli_query($conInt, $rsltAttendance);
	$presentNo = mysqli_num_rows($queryAttendance);
	if($presentNo){
		$rowAttendance = mysqli_fetch_assoc($queryAttendance);
		$status = $rowAttendance['status'];
	}else{
		$status = '';
	}
	$getSS = date('l', strtotime($dateGet4));
	if($getSS == 'Sunday' || $getSS == 'Saturday'){
		echo '<td>&nbsp;</td>';
	}else{
		if($getLastDateFind > $getCrntDateFind){			
			if($with_dism2 == 'Dismissed' || $with_dism2 == 'Withdrawal'){				
				$with_dismDisAbled = 'disabled';
			}else{
				$with_dismDisAbled = '';
			}
		}else{
			$with_dismDisAbled = 'disabled';
		}
	?>
        <td>
		<select name="mrng_evng<?php echo $snoid_3; ?>" class="mrngEvngDiv form-control p-1 from-control-sm" data-id="<?php echo $snoid_3; ?>" id="mrng_evng<?php echo $snoid_3; ?>" full-name="<?php echo $fullname; ?>" v-no="<?php echo $student_id; ?>" start-date="<?php echo $start_date; ?>" prg-name="<?php echo $progName2; ?>" batch-name="<?php echo $batch_name; ?>" module="<?php echo $mdleName2; ?>" shift-time="<?php echo $shiftTime2; ?>" in-take="<?php echo $intke2; ?>" first-date="<?php echo $first_date2; ?>" last-date="<?php echo $last_date2; ?>" attadance-date="<?php echo $dateGet4; ?>" <?php echo $with_dismDisAbled; ?>>
			<option value="">--</option>
			<option value="0"<?php if($status == '0'){ echo 'selected="selected"'; } ?>>0</option>
			<option value="1"<?php if($status == '1'){ echo 'selected="selected"'; } ?>>1</option>
			<option value="2"<?php if($status == '2'){ echo 'selected="selected"'; } ?>>2</option>
			<option value="3"<?php if($status == '3'){ echo 'selected="selected"'; } ?>>3</option>
			<option value="4"<?php if($status == '4'){ echo 'selected="selected"'; } ?>>4</option>
			<option value="5"<?php if($status == '5'){ echo 'selected="selected"'; } ?>>5</option>
		</select>		
		</td>
	<?php } } ?>
	<?php
	$rsltAttendance3 = "SELECT SUM(status) as totalh, COUNT(*) as totalcount, sum(if(status='0',1,0)) as absent, sum(if(status!='0',1,0)) as present FROM m_attendance where date_at!='' AND (date_at BETWEEN '$first_date2' AND '$last_date2') AND program='$progName2' AND shift_time='$shiftTime2' AND app_id='$snoid_3' AND teacher_id='$instorName2' AND module_name='$mdleName2'";	
	$queryAttendance3 = mysqli_query($conInt, $rsltAttendance3);
	$totalid3 = mysqli_num_rows($queryAttendance3);
	if($totalid3){
		$rowAttDiv3 = mysqli_fetch_assoc($queryAttendance3);
		$totalh3 = $rowAttDiv3['totalh'];
		$totalcount3 = $rowAttDiv3['totalcount'];
		$absent = $rowAttDiv3['absent'];
		$present = $rowAttDiv3['present'];
		if($present == '0' || $present == NULL){
			$rngAvrge = '0';
		}else{
			$rngAvrge2 = ($totalh3/$totalcount3);
			$rngAvrge3 = (($rngAvrge2/5)*100);
			$rngAvrge = number_format((float)$rngAvrge3, 2, '.', '');
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
        <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body getStDetails"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<script>
$(document).on('change', '.inatke', function(){
	$('.InstructorName').html("<option value=''>Select Instructor</option><option value='<?php echo $loggedId; ?>'><?php echo $name; ?></option>");
	$('.shiftTimeDiv').html("<option value=''>Select Time</option>");
	$('.prgmDiv').html("<option value=''>Select Program</option>");
	$('.moduleDiv').html("<option value=''>Select Module</option>");
});

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
	var inatke = $('.inatke').val();
	var instName = $('.InstructorName').val();
	var shiftTime = $('.shiftTimeDiv').val();
	$.post("response.php?tag=getmoduleNamePW_New",{"inatke":inatke, "instName":instName, "shiftTime":shiftTime, "getPrgm":getPrgm},function(d){		
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

<script>
$(document).ready(function(){
	$('.mrngEvngDiv').on('change', function() {		
		var getVal12 = $(this).attr('data-id');
		var getVal = $(this).val();
		var getVal2 = $(this).attr('full-name');
		var getVal3 = $(this).attr('v-no');
		var getVal4 = $(this).attr('start-date');
		var getVal5 = $(this).attr('prg-name');
		var getVal6 = $(this).attr('batch-name');
		var getVal7 = $(this).attr('module');
		var getVal8 = $(this).attr('shift-time');
		var getVal9 = $(this).attr('in-take');
		var getVal10 = $(this).attr('first-date');
		var getVal11 = $(this).attr('last-date');
		var getVal13 = $(this).attr('attadance-date');
		var teacher_id = '<?php echo $loggedId; ?>';
		$.post("response.php?tag=studentListsAtt",{"status":getVal, "stusno":getVal12, "fullname":getVal2, "v_no":getVal3, "start_date":getVal4, "prg_name":getVal5, "batch_name":getVal6, "module":getVal7, "shift_time":getVal8, "intake":getVal9, "first_date":getVal10, "last_date":getVal11, "teacher_id":teacher_id, "attadance_date":getVal13},function(d){
		if(d=='1'){
			// alert('Attendance Updated!!!');
			// $('.rowtdDiv'+getVal12).css({'color' : '#eb4c4c','background' : '#f1cbd7'});
			// $('.rowtrDiv'+getVal12).show();
			// $('.rowtrDiv'+getVal12).fadeToggle(4000);
			// $('#hrs'+getVal12).html(getVal);
			return false;
		}else{
			// alert('Again Attendance Updated!!!');
			// $('.rowtdDiv'+getVal12).css({'color' : '#eb4c4c','background' : '#f1cbd7'});
			// $('.rowtrDiv'+getVal12).show();
			// $('.rowtrDiv'+getVal12).fadeToggle(4000);
			// $('#hrs'+getVal12).html(getVal);
			return false;
		}
		});
	});	
});
</script>

<style type="text/css">




.table {
  overflow: scroll;
  border-collapse: collapse;
  background: white;
}
.secondaryContainer {
  overflow: scroll;
  border-collapse: collapse;
  height: 500px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 10px;
}
.table thead {
  white-space: nowrap;
  position: sticky;
  top: 0; z-index: 999
}


.secondaryContainer::-webkit-scrollbar-track
{ border: 3px solid #3a7f3e;
	-webkit-box-shadow: inset 0 0 6px #3a7f3e;
	background-color: #F5F5F5;
}

.secondaryContainer::-webkit-scrollbar
{
	width: 10px; height:10px;
	background-color: #F5F5F5;
}

.secondaryContainer::-webkit-scrollbar-thumb
{
	background-color: #000000;
	border: 2px solid #555555;
}
.table td .form-control { padding:2px 5px !important; height:24px; line-height: 18px; font-size:15px; text-align:center;width:35px; }

@media only screen and (min-width: 700px) {

  #first35 .table thead tr:first-child th:nth-of-type(1),
    #first35 .table thead tr:first-child th:nth-of-type(2),
     #first35 .table thead tr:first-child th:nth-of-type(3)  {z-index: 99;
}
    #first35 .table tbody td:nth-of-type(1),
  #first35 .table thead tr:first-child th:nth-of-type(1),
    #first35 .table tbody td:nth-of-type(2),
  #first35 .table thead tr:first-child th:nth-of-type(2),
    #first35 .table tbody td:nth-of-type(3),
  #first35 .table thead tr:first-child th:nth-of-type(3)  {
      position: sticky;  top:0; left: 0;
/*      background: lightgoldenrodyellow;*/
    
    }
    .table tr:hover {
    transform: scale(1);
}
     #first35 .table thead tr:first-child th:nth-of-type(1),
     #first35 .table tbody td:nth-of-type(1) {left:0; width: 80px}
     
     #first35 .table thead tr:first-child th:nth-of-type(2),
     #first35 .table tbody td:nth-of-type(2) {left:74px; width: 100px}
     
     #first35 .table thead tr:first-child th:nth-of-type(3),
      #first35 .table tbody td:nth-of-type(3) {left:157px; width: 130px}
     
      #first35 .table tbody td:nth-of-type(1),#first35 .table tbody td:nth-of-type(2),#first35 .table tbody td:nth-of-type(3)
         { background:#fff ;

         }
         }
</style>
