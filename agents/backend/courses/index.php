<?php
ob_start();
include("../../db.php");
include("../../header_navbar.php");

if(!isset($_SESSION['sno'])){
    header("Location: ../../login");
    exit(); 
}

if(!empty($_GET['idCrs_'])){
	$snoid_6 = base64_decode($_GET['idCrs_']);
	$qryCrs = "select * from contract_courses where sno='$snoid_6'";
	$rsltCrs = mysqli_query($con, $qryCrs); 	
	$rowCrs = mysqli_fetch_array($rsltCrs);
	$snoid = $rowCrs['sno'];
	$snoid_76 = $_GET['idCrs_'];
	$snoid_9 = "&idCrs_=$snoid_76";
	$campus = $rowCrs['campus'];
	$program_name = $rowCrs['program_name'];
	$intake = $rowCrs['intake'];
	$tuition_fee = $rowCrs['tuition_fee'];
	$commenc_date = $rowCrs['commenc_date'];
	$expected_date = $rowCrs['expected_date'];
	$app_fee = $rowCrs['app_fee'];
	$stu_ra_service_fee = $rowCrs['stu_ra_service_fee'];
	$textbook_cost = $rowCrs['textbook_cost'];
	$inter_stud_schlr = $rowCrs['inter_stud_schlr'];
	$total = $rowCrs['total'];
	$week = $rowCrs['week'];
	$practicum_start_date = $rowCrs['practicum_start_date'];
	$practicum_end_date = $rowCrs['practicum_end_date'];
}else{
	$snoid = '';
	$snoid_9 = '';
	$campus = '';
	$program_name = '';
	$intake = '';
	$tuition_fee = '';
	$commenc_date = '';
	$expected_date = '';
	$app_fee = '';
	$stu_ra_service_fee = '';
	$textbook_cost = '';
	$inter_stud_schlr = '';
	$total = '';
	$week = '';
	$practicum_start_date = '';
	$practicum_end_date = '';
}
?>		
<div class="loading_icon"></div>
<div class="main-div">           
<div class="container vertical_tab">  
  <div class="row">  
	<div class="col-md-12 col-lg-10 offset-lg-1"> 
             
<div class="tab-content">
<div id="Personal-Details">
<form action="../mysqldb.php" method="post" autocomplete="off" enctype="multipart/form-data">
<div class="col-sm-12">
<h3 class="folded"><center><b>Add New Course</b></center></h3>
</div>
<div class="col-sm-12">
	<div class="row">

	<div class="col-sm-6 form-group">
		<label>Campus Name:</label>
		 <div class="input-group">
		  <span class="input-group-addon" id="icon">
		<i class="fas fa-building"></i></span>
		  <select name="campus" class="form-control campusDiv" required>
			<option value="">Select Campus</option>
			<option value="Nanaimo"<?php if($campus == "Nanaimo") { echo 'selected="selected"'; } ?>>Nanaimo</option>
		  </select>
	</div>
	</div>
		
	<div class="col-sm-8 form-group">
		
		<?php if(!empty($_GET['oldcrs']) && $_GET['oldcrs'] == 'oldcrs'){ ?>
			
			<label class="w-100">Program Name:<span style="color:red;">*</span> 
				
			<a class="float-right" href="../courses?<?php echo base64_encode('20SecuRiTy19');?><?php echo $snoid_9;?>">Choose Program Name</a></label>
			 <div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-user"></i></span>		
			  <input type="text" name="program_name_input" placeholder="Enter Program Name" class="form-control">
			</div>
		<?php }else{ ?>			
			<label class="w-100">Program Name:<span style="color:red;">*</span> 
			<a class="float-right" href="../courses?oldcrs=oldcrs&<?php echo base64_encode('20SecuRiTy19');?><?php echo $snoid_9;?>">Add New Program Name</a></label>
			
			<div class="input-group"><span class="input-group-addon" id="icon"><i class="fas fa-graduation-cap"></i></span>	
			<select name="program_name_drop" class="form-control pnDiv" data-campusDiv="" data-VsDiv="">
				<option value="">Select Program Name</option>
				<?php
				$getresult = mysqli_query($con,"SELECT program_name FROM contract_courses where program_name !='' group by program_name");
				while ($rowCrses = mysqli_fetch_assoc($getresult)) {
				$pn_23 = $rowCrses['program_name'];
				?>
				<option value="<?php echo $pn_23;?>" <?php if($program_name == "$pn_23") { echo 'selected="selected"'; } ?>><?php echo $pn_23;?></option>
				<?php } ?>
			</select>			
			</div>
		<?php } ?>			
		</div>
		
		<div class="col-sm-4 form-group">
			<label>Intake:</label>
			 <div class="input-group">
			  <span class="input-group-addon" id="icon"><i class="fas fa-calendar-alt"></i></span>
			  <select name="intake" class="form-control">
				<option value="">Select Intake</option>
				<option value="Nov-2025"<?php if($intake == "Nov-2025") { echo 'selected="selected"'; } ?>>Nov-2025</option>
				<option value="SEP-2025"<?php if($intake == "SEP-2025") { echo 'selected="selected"'; } ?>>SEP-2025</option>
				<option value="May-2025"<?php if($intake == "May-2025") { echo 'selected="selected"'; } ?>>May-2025</option>
				<option value="March-2025"<?php if($intake == "March-2025") { echo 'selected="selected"'; } ?>>March-2025</option>
				<option value="JAN-2025"<?php if($intake == "JAN-2025") { echo 'selected="selected"'; } ?>>JAN-2025</option>
				
				<option value="Nov-2024"<?php if($intake == "Nov-2024") { echo 'selected="selected"'; } ?>>Nov-2024</option>
				<option value="SEP-2024"<?php if($intake == "SEP-2024") { echo 'selected="selected"'; } ?>>SEP-2024</option>
				<option value="May-2024"<?php if($intake == "May-2024") { echo 'selected="selected"'; } ?>>May-2024</option>
				<option value="JAN-2024"<?php if($intake == "JAN-2024") { echo 'selected="selected"'; } ?>>JAN-2024</option>
				<option value="March-2024"<?php if($intake == "March-2024") { echo 'selected="selected"'; } ?>>March-2024</option>
			  </select>
		</div>
		</div>
	
	<div class="col-sm-6 form-group">
	<label>Start Date:</label>
	 <div class="input-group">
		  <span class="input-group-addon" id="icon"><i class="fas fa-calendar-alt"></i></span>
		<input type="text" name="commenc_date" class="form-control commenc_date date_followup" value="<?php echo $commenc_date; ?>">
	</div>	
   </div>		
						
	<div class="col-sm-6 form-group">
		<label>End Date: </label>
		 <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-calendar-alt"></i></span>
		<input type="text" name="expected_date" class="form-control expected_date date_followup" value="<?php echo $expected_date; ?>">
		</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>Tuition Fee:<span style="font-size: 13px;"> (Eg: $0,000.00)</span></label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="fas fa-coins"></i></span>
		<input type="text" name="tuition_fee" id="tuition_fee" placeholder="Eg: $0,000.00" class="form-control tuition_fee" value="<?php echo $tuition_fee; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>Application Fee:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="far fa-clock"></i></span>
		<input type="text" name="app_fee" id="app_fee" class="form-control app_fee" value="<?php echo $app_fee; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>Student Records Archiving and Student services FEE:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="far fa-clock"></i></span>
		<input type="text" name="stu_ra_service_fee" id="stu_ra_service_fee" class="form-control stu_ra_service_fee" value="<?php echo $stu_ra_service_fee; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>Textbook, Costs:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="far fa-clock"></i></span>
		<input type="text" name="textbook_cost" id="textbook_cost" class="form-control textbook_cost" value="<?php echo $textbook_cost; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>International Scholarship:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="far fa-clock"></i></span>
		<input type="text" name="inter_stud_schlr" id="inter_stud_schlr" class="form-control inter_stud_schlr" value="<?php echo $inter_stud_schlr; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>Total Fee:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="far fa-clock"></i></span>
		<input type="text" name="total" id="total" class="form-control total" value="<?php echo $total; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">	
	<label>Week:</label>
	<div class="input-group">
		<span class="input-group-addon" id="icon"><i class="far fa-clock"></i></span>
		<input type="text" name="week" id="week" class="form-control week" value="<?php echo $week; ?>">
	</div>
	</div>
	
	<div class="col-sm-6 form-group">
	<label>Practicum Start Date:</label>
	 <div class="input-group">
		  <span class="input-group-addon" id="icon"><i class="fas fa-calendar-alt"></i></span>
		<input type="text" name="practicum_start_date" class="form-control  date_followup" value="<?php echo $practicum_start_date; ?>">
	</div>	
   </div>		
						
	<div class="col-sm-6 form-group">
		<label>Practicum End Date: </label>
		 <div class="input-group">
			<span class="input-group-addon" id="icon"><i class="fas fa-calendar-alt"></i></span>
		<input type="text" name="practicum_end_date" class="form-control date_followup" value="<?php echo $practicum_end_date; ?>">
		</div>
	</div>
	
	<input type="hidden" name="snoCheck" value="<?php echo $snoid;?>">
	
	<div class="col-sm-12">
	<?php if(!empty($_GET['idCrs_'])){ ?>
		<button type="submit" name="courseBtnNew" class="btn btn-primary btn-sm courseBtnNew float-right" onclick="return confirm('Are you sure you want to update this course?');">Submit</button>
	<?php }else{ ?>
		<button type="submit" name="courseBtnNew" class="btn btn-primary btn-sm courseBtnNew float-right" onclick="return confirm('Are you sure you want to add this course?');">Submit</button>
	<?php } ?>
	</div>
	</form>	
	</div>
	</div>
  </div>
   
<!---Personal details ending-->
		
  </div>
  </div>
   </div></div>

<script> 
$(document).on('change', '.campusDiv', function(){
	var getCampus = $(this).val();
	$('.pnDiv').attr('data-campusDiv', getCampus);
});
</script>

<script> 
$(document).on('change', '.VsDiv', function(){
	var getVs = $(this).val();
	$('.pnDiv').attr('data-VsDiv', getVs);
});
</script>

<script> 
// $(document).on('change', '.pnDiv', function(){
	// $('.loading_icon').show();
	// var getCampus = $(this).attr('data-campusDiv');
	// var getVs = $(this).attr('data-VsDiv');
	// var getPn = $(this).val();
	// $.post("../response.php?tag=getCampusCrsList",{"campus":getCampus, "vs":getVs, "pn":getPn},function(d){
		// $('.tuition_fee').val(d[0].tuition_fee);
		// $('.commenc_date').val(d[0].commenc_date);
		// $('.expected_date').val(d[0].expected_date);	
		// $('.school_break1').val(d[0].school_break1);	
		// $('.school_break2').val(d[0].school_break2);	
		// $('.school_break_3').val(d[0].school_break_3);	
		// $('.school_break_4').val(d[0].school_break_4);	
		// $('.hours').val(d[0].hours);	
		// $('.week').val(d[0].week);	
		// $('.int_fee').val(d[0].int_fee);	
		// $('.books_est').val(d[0].books_est);	
		// $('.other_fee').val(d[0].other_fee);	
		// $('.total_fee').val(d[0].total_fee);	
		// $('.otherandbook').val(d[0].otherandbook);	
		// $('.total_tuition').val(d[0].total_tuition);	
		// $('.loa_total_fee').val(d[0].loa_total_fee);	
		// $('.practicum').val(d[0].practicum);	
		// $('.practicum_wrk').val(d[0].practicum_wrk);	
		// $('.practicum_date').val(d[0].practicum_date);	
		// $('.program_start1').val(d[0].program_start1);	
		// $('.program_end1').val(d[0].program_end1);	
		// $('.program_start2').val(d[0].program_start2);	
		// $('.program_end2').val(d[0].program_end2);
		// $('.loading_icon').hide();
	// });	
// });
</script>

<script>
$(function(){
    $(".date_followup").datepicker({	  
		dateFormat: 'yy/mm/dd', 
		changeMonth: false, 
		changeYear: false,
    });
});
</script>
   